<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head();  ?>
</head>
<body <?php body_class(); ?> >

<div id="header" style="background-color: #eee;">
<div class="header-logo"><img src="<?php echo get_template_directory_uri().'/logo.png'; ?>">
 </div>
 
 <ul class="text-center">
 <?php
		wp_nav_menu( array(
            'theme_location' => 'main-menu',
            'menu_id' => 'main-menu',
		) );
        ?>
        </ul>
</div>
<i class="fas fa-user my-account icon"></i>
<div class="container">
