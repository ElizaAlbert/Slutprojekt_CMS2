<?php 
/*
Template Name: Contact Page 
*/

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <?php wp_head();  ?>
</head>
<body <?php body_class(); ?>>
<div id="header" style="background-color: #eee;">
<div class="header-logo"><img src="<?php echo get_template_directory_uri().'/logo.png'; ?>">
 <ul class="text-center">
     
<?php
    wp_nav_menu( array(
        'theme_location' => 'main-menu',
        'menu_id' => 'main-menu',
    ) );
?>

<!-- Contact Us Form -->
      <div class="container">
          <h4 class="titleContactForm">Fill in the following form to contact us!</h4>
      <!-- admin-ajax.php is located in wp-admin and is the point where data is received through forms -->
        <form action="<?php echo admin_url('admin-ajax.php'); ?>"> 
              <input type="text" name="name" id="field" placeholder="Name" required> <br>
              <input type="text" name="email" id="field" placeholder="Email" required> <br>
              <input type="textarea" name="textarea" id="field" placeholder="Message" required> <br>
              <label for="message">Reason of contact:</label><br>
              <input type="radio" name="contact_reason" value="Contact" required> Contact 
              <input type="radio" name="contact_reason" value="Reclamation" required> Reclamation
              <input type="radio" name="contact_reason" value="Billing" required> Billing <br>
              <label id="message" for="message">Select upload file:</label>
              <input type="file" name="file_uploads"><br>
              <input type="submit" value="Submit" class="btn btn-success">
              <!-- When data is sent to admin-ajax, it looks for this WordPress special Get Parameter "action", takes the value and create a hook -->
              <input type="hidden" name="action" value="my_contactform"> 
        </form>

        <!-- Map to headoffice  -->
    <div class="cf_map">
        <h2>Find us:</h2>
        <?php
        while ( have_posts() ) : the_post(); 
        // cf_map is Contact Form Map.
        $cf_map = get_post_meta($post->ID, 'cf_map', true);
        echo $cf_map;
    endwhile; // end of the loop. ?>
    </div>
        </div>
            </div>
        </div>
<div>

<!-- This shortcode is placed on this page only for view -->
<?php echo do_shortcode("[on-sale-products]"); ?>

</div>
</body>
<?php wp_footer(); ?>
</html>

<style>
.container {
    background-color: white;
    padding: 5em;
    text-align: left;
}
#message {
    margin-top: 1em;
}
#field {
    width: 15em;
    margin-bottom: 1em;
}
.btn {
    margin-top: 1em;
}
.cf_map {
  margin: auto;
    text-align: center;
}
</style>