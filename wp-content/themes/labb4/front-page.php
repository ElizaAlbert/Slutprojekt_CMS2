<?php get_header(); ?>
<div class="row">

<div class="col-lg-12">
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

<?php get_footer(); ?>