<?php
function add_bootstrap_cdn()
{
  wp_enqueue_style('bootstrap4', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css');
  wp_enqueue_script('boot1', 'https://code.jquery.com/jquery-3.3.1.slim.min.js', array('jquery'), '', true);
  wp_enqueue_script('boot2', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array('jquery'), '', true);
  wp_enqueue_script('boot3', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js', array('jquery'), '', true);
}
//To add css and scripts create a function add style with wp_enqueue_style and scripts with wp_enquque_scripts(<alias>, <url>);
//Always add theme scripts last, otherwise it will be overwritten
function add_theme_scripts()
{
  wp_enqueue_style('style', get_stylesheet_uri());
  wp_enqueue_script('script', get_template_directory_uri() . '/js/script.js');
}


//Invoke "add_theme_scripts" function when 
add_action('wp_enqueue_scripts', 'add_bootstrap_cdn');
add_action('wp_enqueue_scripts', 'add_theme_scripts');

//Acf custom options page
if (function_exists('acf_add_options_page')) {

  acf_add_options_page();
}
