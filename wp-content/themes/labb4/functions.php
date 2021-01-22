<?php
function slutprojekt_styles()
{
    wp_enqueue_style('style.css', get_stylesheet_uri());
    wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css', array(), '5.10.2');
    wp_enqueue_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css', array(), '4.5.2');
    wp_enqueue_script('jquery');
    wp_enqueue_script('bootstrapjs', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'), '4.5.2', true);
    //   wp_enqueue_script('checkoutfix', get_template_directory_uri() .'/checkoutfix.js', array('jquery'), '1', true);
    wp_enqueue_style('unslider', get_template_directory_uri() . '/includes/css/unslider.css');
}
add_action('wp_enqueue_scripts', 'slutprojekt_styles');

function include_jquery()
{
    wp_deregister_script('jquery');
    wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.5.1.min.js', array(), null, false);
    //Carusel slider deps
    wp_enqueue_script('script', get_template_directory_uri() . '/includes/js/script.js');
    wp_enqueue_script('unslider', get_template_directory_uri() . '/includes/js/unslider.js');
}
add_action('wp_enqueue_scripts', 'include_jquery');

function slutprojekt_setup()
{
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
}
add_action('after_setup_theme', 'slutprojekt_setup');


function slutprojekt_menus()
{
    register_nav_menus(array(
        'main-menu' => 'Main Menu',
    ));
}
add_action('init', 'slutprojekt_menus');

function slutprojekt_add_woocommerce_support()
{
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'slutprojekt_add_woocommerce_support');
