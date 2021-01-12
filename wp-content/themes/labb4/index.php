<?php get_header(); ?>
<div class="main">
<div class="row">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
<h1><?php the_title(); ?></h1>
</div>
<?php endwhile; ?>
<?php endif; ?>
</div>
</div>
</div>
<?php get_footer(); ?>