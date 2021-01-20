<?php
/*
Plugin Name: Form Plugin
Author: Eliza Albert
Description: A Contact Form Plugin that saves the input data into a Custom Post Type. 
*/

// The code needed for the fields to show up are placed where the form is desired to be displayed, the code is therefore in the contact-us.php file. 

class ContactForm {

  // Method that inserts the data received through the contact form and its hook, to the wp_posts in the database and into the Custom Post Type "Messages". 
function insertpost() {
    $post_id = wp_insert_post(
      [
        'post_title' => $_REQUEST['name'],
        'post_content' => $_REQUEST['textarea'],
        'post_type' => 'meddelanden',
        'meta_key' => $_REQUEST['contact_reason'],
        'meta_value' => $_REQUEST['contact_reason'],
        'post_status' => 'publish',
        'meta_value' => $_REQUEST['file_uploads'],

      ]
    );

    // Sanitize Email
    $solid_email = sanitize_email($_REQUEST['email']);
    // Stores data sanitized received from the email input field in the wp_postmeta in the database.
    update_post_meta($post_id, 'email', $solid_email); 

    add_post_meta( $post_id, 'contact_reason', $_REQUEST['contact_reason'], true );
    add_post_meta( $post_id, 'file_uploads', $_REQUEST['file_uploads'], true );
    wp_redirect($_SERVER['HTTP_REFERER'] . '?sent=true'); // Changes URL address to a safe one. 
    die();
  }

  // Gets and displays Custom Post Data.
function get_CPT_data(){
        if(!is_admin()){
            $args = array( 
            'post_type'   => 'meddelanden',
            'meta_key'    => 'email',
            'meta_key'    => 'contact_reason',
            'meta_key'    => 'file_uploads'
          );
        $scheduled = new WP_Query( $args );

      while ( $scheduled->have_posts()) : $scheduled->the_post();

      $post_id = get_the_ID(); // Gets wp_postmeta IDs
      $emailFrom = get_post_meta($post_id, 'email', true); // Contains all values of the meta_key value "email" 
      $input_content = get_the_content();
      $input_name = get_the_title();
      $contact_reason = get_post_meta($post_id, 'contact_reason', true); // Contains all values of the meta_key value "contact_reason" 
      $files = get_post_meta($post_id, 'file_uploads', true); // Contains all values of the meta_key value "file_uploads" 

      // Displays the information that has been sent through the form if n
      // echo "Name: " . $input_name  . "<br>";
      // echo "Email: " . $emailFrom . "<br>";
      // echo "Message: " . $input_content  . "<br>";
      // echo "Reason of contact: " . $contact_reason . "<br>";
      // echo "File: <img src='" . $files . "'><br>";

      endwhile;
      }
      wp_reset_postdata();
      }

// Deactivates the plugin.
function deactivate(){
    wp_delete_post($this->post_id);
  }

// Creating CPT Messages.
function messages()
  {
    register_post_type('meddelanden', [
      'labels' => [
      'name' => 'Messages',
      'singular_name' => 'Message',
      ],
      'public' => true,
      'has_archive' => true
    ]);
    }

// CODE BELOW ADDS A SUB MENU TO CUSTOM POST TYPE MESSAGES AND IS A TEST!!!
//     function reclamation_register_ref_page() {
//       register_post_type( 'Reclamation',
//           array(
//                   'labels' => array(
//                           'name' => __( 'Reclamations' ),
//                           'singular_name' => __( 'Reclamation' )
//                   ),
//           'public' => true,
//           'has_archive' => true,
//           'show_in_menu' => 'edit.php?post_type=meddelanden'
//     )
// );
// }

// The following 4 functions add a New Column to the Custom Post Type "Messages", in this specific case it's "Contact Reason" 
function custom_columns_head($defaults) {
  $defaults['contact_reason'] = 'Contact Reason';
  return $defaults;
}
function custom_columns_content($column_name, $post_id) {
  if($column_name == 'contact_reason') {
    $column_name = get_post_meta($post_id, 'contact_reason', true);
    echo $column_name;
  }
}
// The following 2 functions add a New Column to the Custom Post Type "Messages", in this specific case it's "Email" 
function custom_columns_head_email($defaults_email) {
  $defaults_email['email'] = 'Email';
  return $defaults_email;
}
function custom_columns_content_email($column_name_email, $post_id) {
  if($column_name_email == 'email') {
    $column_name_email = get_post_meta($post_id, 'email', true);
    echo $column_name_email;
  }
}

// Enqueues scripts and styles. 
function enqueue(){ // Function that enqueues scripts and styles (gets activated by function registerEnqueue)
        wp_enqueue_style('style', plugin_dir_url(__FILE__) . "assets/style.css", array(), rand(111,9999), 'all');
    }

function __construct(){
    add_action('init', [$this, 'messages']);

    // CODE BELOW ADDS A SUB MENU TO CUSTOM POST TYPE MESSAGES AND IS A TEST!!!
    // add_action('init', [$this, 'reclamation_register_ref_page']);

    // Adds The New Column "Contact Reason" To Custom Post Type "Messages"
    add_filter('manage_posts_columns' , array($this,'custom_columns_head'));
    add_action('manage_posts_custom_column' , array($this,'custom_columns_content'), 10, 2 );
    // Adds The New Column "Email" To Custom Post Type "Messages"
    add_filter('manage_posts_columns' , array($this,'custom_columns_head_email'));
    add_action('manage_posts_custom_column' , array($this,'custom_columns_content_email'), 10, 2 );

    add_action('wp_enqueue_scripts', array($this, 'enqueue'));
    add_action('wp_ajax_my_contactform', [$this, 'insertpost']); // Hooks action with method. Basically information received from my_contactform input field is proccessed through insertpost() method. 
    //activation
    register_activation_hook( __FILE__, [$this, 'activate']);
    //deactivation
    register_deactivation_hook( __FILE__, array($this, 'deactivate'));
    add_action('init', [$this, 'get_CPT_data']);
    }
}
      $contact = new ContactForm();


