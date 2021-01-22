<?php get_header(); ?>

<!-- start slider image-->
<div class="mySlider">
  <?php $images = get_field('gallery', 'options'); ?>
  <?php if ($images) { ?>
    <ul>
      <?php foreach ($images as $image) { ?>
        <li><img src="<?php echo $image['sizes']['medium'] ?>"></li>
      <?php } ?>
    </ul>
  <?php } ?>
</div>
<!-- end slider image-->

</div> <!-- end container from header -->

<div class="puff mt-5 mb-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-3">
        <h2>Recent News</h2>
      </div>
      <div class="col-lg-9">
        <?php $the_query = new WP_Query('posts_per_page=1'); ?>
        <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
          <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
          <?php the_excerpt(__('(more…)')); ?>
        <?php
        endwhile;
        wp_reset_postdata();
        ?>
      </div>
    </div>
  </div>
</div>
<div class="container">
  <!-- start container from header -->
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

<div class="banner" style="background-image:url(<?php echo get_template_directory_uri(); ?>/banner.jpg);">
</div>

<?php get_footer();
