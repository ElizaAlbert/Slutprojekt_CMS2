<?php
/**
* Plugin Name: Pickup in store
* Author: Emil Backlund
*/
if (! defined('ABSPATH')) {
    exit;
}


/**
 * Add the field to the checkout
 */
 add_action('woocommerce_after_order_notes', 'my_custom_checkout_field');

 function my_custom_checkout_field($checkout)
 {
     $post_type_query  = new WP_Query(
         array(
 'post_type'      => 'store',
 'posts_per_page' => -1
)
     );

     $posts_array = $post_type_query->posts;
     $store_locations = wp_list_pluck($posts_array, 'post_title', 'ID');
    
     //  $array = $store_locations;
     //  $test_var = array();
     //  foreach ($store_locations as $key => $value) {
     //      $test_var[] = $value;
     //  }
     

     echo '<span id="my_custom_checkout_field"><h2>' . __('Pickup in store') . '</h2>';

     woocommerce_form_field('my_field_name', array(
         'type'          => 'select',
         'class'         => array('my-field-class'),
         'options'       => $store_locations,
         'label'         => __('Select store for pickup'),
         'default'       => 'None',
         ), $checkout->get_value('my_field_name'));
 
     echo '</span>';
 }


/**
 * Update the order meta with field value
 */
 add_action('woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta');

 function my_custom_checkout_field_update_order_meta($order_id)
 {
     if (! empty($_POST['my_field_name'])) {
         update_post_meta($order_id, 'My Field', sanitize_text_field($_POST['my_field_name']));
     }
 }
 /**
 * Display field value on the order edit page
 */
add_action('woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1);

function my_custom_checkout_field_display_admin_order_meta($order)
{
    echo '<p><strong>'.__('Pickup in store').':</strong> ' . get_post_meta($order->id, 'Pickup in store', true) . '</p>';
}
