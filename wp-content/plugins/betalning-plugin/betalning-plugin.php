<?php
/*
 * Plugin Name: Invoice Payment -E
 * Description: Take credit card payments on your store.
 * Author: Eliza Albert
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Denies access to the file when attempted to be accessed through URL

/*
 * This action hook registers our PHP class as a WooCommerce payment gateway
 */
add_filter( 'woocommerce_payment_gateways', 'eliza_add_gateway_class' );
function eliza_add_gateway_class( $gateways ) {
	$gateways[] = 'WC_Eliza_Gateway'; // class name 
	return $gateways;
}
 
/*
 * The class itself which is inside plugins_loaded action hook
 */
add_action( 'plugins_loaded', 'eliza_init_gateway_class' );
function eliza_init_gateway_class() {
 
	class WC_Eliza_Gateway extends WC_Payment_Gateway {
 	public function __construct() {
        // Setting standard values:
            $this->id = 'eliza'; // payment gateway plugin ID
            $this->has_fields = true; // in case you need a custom credit card form
            $this->method_title = 'Invoice'; // title in WooCommerce "Payment" settings
            $this->method_description = 'Sends an invoice if personal number is correct'; // will be displayed on the options page
            $this->supports = array(
                'products'
            );
        
            // Method with all the options fields
            $this->init_form_fields();
            // Load the settings.
            $this->init_settings();
            $this->enabled = $this->get_option( 'enabled' );
            $this->title = $this->get_option( 'title' );
            $this->description = $this->get_option( 'description' );
            $this->testmode = 'yes' === $this->get_option( 'testmode' );
        
            // This action hook saves the settings
            add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
        }

 	public function init_form_fields(){
        $this->form_fields = array(
		'enabled' => array(
			'title'       => 'Enable/Disable',
			'label'       => 'Activate Invoicing by Personal Number',
			'type'        => 'checkbox',
			'description' => '',
			'default'     => 'no'
		),
		'title' => array(
			'title'       => 'Title',
			'type'        => 'text',
			'description' => 'This controls the title which the user sees during checkout.',
			'default'     => 'Invoice',
			'desc_tip'    => true,
		),
		'description' => array(
			'title'       => 'Description',
			'type'        => 'textarea',
			'description' => 'This controls the description which the user sees during checkout.',
			'default'     => 'Enter your personal number in order to receive the invoice.',
		),
		'testmode' => array(
			'title'       => 'Test mode',
			'label'       => 'Enable Test Mode',
			'type'        => 'checkbox',
			'description' => 'Place the payment gateway in test mode using test API keys.',
			'default'     => 'yes',
			'desc_tip'    => true,
		)
	);
	 	}
 
// Form shown in Checkout
	public function payment_fields() {
         echo $this->description . '
            <div style="margin-top: 1em;">
               <p>Social Security Number (yymmdd-nnnn) * </p>
               <input id="eliza_ssn" name="eliza_ssn" type="text">
            </div>';
		}
 
// Proccesses the actual order
    public function process_payment($order_id) {
         // Get the order
         global $woocommerce;
         $order = new WC_Order($order_id);
         // Gets put on "on-hold"
         $order->update_status('on-hold', __(''));
         // Clear Cart
         $woocommerce->cart->empty_cart();
         // Send to "Thank You"-page
         return array(
             'result' => 'success',
             'redirect' => $this->get_return_url($order)
         );
     }

     // Validation of fields
	public function validate_fields() {
         if(!empty($_POST['eliza_ssn']) && (Validate_Social_Security_Nr::validateString($_POST['eliza_ssn']) == true)) {
            return true;}
         else {
            wc_add_notice('You must enter a valid social security number!', 'error');
            return false;
        }
     }
    }

   // Class that validates the social security numbers by the Luhn-algorithm
   class Validate_Social_Security_Nr
   {
      private
         $day = 0, $month = 0, $year = 0, $bn = 0;

      function __construct($year, $month, $day, $bn)
      {
         $this->year  = $year;
         $this->month = $month;
         $this->day   = $day;
         $this->bn    = $bn;
      }
      
      function validateString(string $social_security_nr)
      {
         return self::createFromString($social_security_nr) !== null;
      }
      
      function createFromString(string $social_security_nr) : ? Validate_Social_Security_Nr
      {
         if(preg_match("/^
               (\d{2}) # 3: Day
               (\d{2}) # 2: Month
               (\d{2}) # 1: Year
               ([+-])  # 4: Divider
               (\d{3}) # 5: Birthnr
               (\d{1}) # 6: Controlnr
         $/x", $social_security_nr, $m))
         {
               $day   = (int)$m[3];
               $month = (int)$m[2];
               $year  = (int)$m[1];
               $sep   = $m[4];
               $check = (int)$m[6];
               $bn    = (int)$m[5];
               
               // Normalize birthyear 
               $year = self::normalizeYear($year, $sep === "+");
               // Checks for valid date 
               if(checkdate($month, $day > 60 ? $day - 60 : $day, $year))
               {
                  // Verify control number
                  if($check === self::checkDigit($year, $month, $day, $bn))
                  {
                     return new self($year, $month, $day, $bn);
                  }
               }
         }
         return null;
      }
      
      function normalizeYear($birthYear, $hundredOrOlder = false)
      {
         $currentYear    = (int)date("Y");
         $currentCentury = (int)floor($currentYear / 100) * 100;
         $currentYear    = $currentYear % 100;
         
         if($hundredOrOlder)
         {
            if($birthYear > $currentYear){
               return $birthYear + $currentCentury - 200;}
            else{
               return $birthYear + $currentCentury - 100;}
         }
         else{
            if($birthYear > $currentYear){
               return $birthYear + $currentCentury - 100;}
            else{
               return $birthYear + $currentCentury;}
         }
      }
      
      function checkDigit($year, $month, $day, $bn)
      {
         $digits = sprintf(
               '%02d%02d%02d%03d',
               substr((string)$year, 2, 2),
               $day,
               $month,
               $bn
         );
               $sum = 0;
         
         //Luhn-algorithm
         for($i = 0, $c1 = strlen($digits); $i < $c1; ++$i)
         {
               // Every character gets multiplied by the numbers 1 and 2
               $t = (string)((int)$digits[$i] * ($i % 2 === 0 ? 2 : 1));
               
               for($n = 0, $c2 = strlen($t); $n < $c2; ++$n)
               {
                  $sum += (int)$t[$n];
               }
         }
         $check = 10 - $sum % 10;
         return $check === 10 ? 0 : $check;
      }

      function getCheckDigit()
      {
         return self::checkDigit(
         $this->day,
         $this->month,
         $this->year,
         $this->bn);
      }
      
      function toString()
      {
         return sprintf(
               '%s%02d%02d%s%03d%d',
               substr((string)$this->year, 2, 2),
               ((int)date("Y") - $this->year < 100 ? "-" : "+"),
               $this->getCheckDigit(),
               $this->day,
               $this->month,
               $this->bn
         );
      }
      
      function returnToString()
      {
         return $this->toString();
      }
   }

}