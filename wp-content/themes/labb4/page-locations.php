<!-- template page for store locations only -->
<?php get_header();
/**
*  ACF field g_maps
*/
 ?>
<div class="container">
  <div class="row">
    <div class="col-md-12 text-center">
      <h1 class="h2Main"><?php the_title();?>
      </h1>
      <p><?php the_content();?>
      </p>
    </div>
  </div>
</div>

<!-- store content custom post type-->
<div class="container">
  <?php
          $args = array( 'post_type' => 'store', 'posts_per_page' => 20, );
          $the_query = new WP_Query($args);
          if ($the_query->have_posts()) {
              while ($the_query->have_posts()) {
                  $the_query->the_post(); ?>

  <div class="row shadow mb-3">
    <div class="col-md-5">
      <h2><?php the_title(); ?>
      </h2>
      <div><?php the_content(); ?>
      </div>
    </div>
    <div class="col-md-7 pt-3 pb-3 maps">
      <?php the_field('g_maps') ?>
    </div>
    <?php wp_reset_postdata(); ?>
  </div>


  <?php
              } ?>
  <?php
          } ?>
</div>
<?php get_footer();
