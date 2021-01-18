<?php get_header(); ?>
<!-- Testing resent posts -->
<h2>Recent Posts</h2>
<ul>
  <?php
    $args = array( 'numberposts' => '1' );
    $recent_posts = wp_get_recent_posts($args);
    foreach ($recent_posts as $recent) {
        printf(
            '<li><a href="%1$s">%2$s</a></li>',
            esc_url(get_permalink($recent['ID'])),
            apply_filters('the_title', $recent['post_title'], $recent['ID'])
        );
    }
?>
</ul>

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
