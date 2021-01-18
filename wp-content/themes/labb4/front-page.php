<?php get_header(); ?>

<div class="row puff">
  <div class="col-lg-3">
    <h2>Recent News</h2>
  </div>
  <div class="col-lg-9">
    <?php $the_query = new WP_Query('posts_per_page=1'); ?>
    <?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>
    <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
    <?php the_excerpt(__('(more…)')); ?>
    <?php
endwhile;
wp_reset_postdata();
?>
  </div>
</div>

<div class="row">

  <div class="col-lg-12">

    <h1 class="text-center">Best Sellers</h1>
    <p class="text-center">Brilliant design and unparalleled craftsmanship.</p>
    <?php
echo do_shortcode('[best_selling_products columns="4" per_page="8"]');
?>

    <h1 class="text-center">Shop by Category</h1>
    <p class="text-center">Brilliant design and unparalleled craftsmanship.</p>
    <?php
echo do_shortcode('[product_categories columns="6" number="6"]');
?>

  </div>
</div>
</div>

<div class="banner"
  style="background-image:url(<?php echo get_template_directory_uri(); ?>/banner.jpg);">
</div>

<?php get_footer();
