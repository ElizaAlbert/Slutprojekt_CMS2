<?php get_header(); ?>

<div class="main">
	<div class="container">
    <div class="row">
    <div class="col-12">

  <?php if ( have_posts() ) : while ( have_posts() ) :  the_post(); ?>
    <h2><?php the_title(); ?></h2>
    <p><?php the_content(); ?></p>
  <?php endwhile; ?>
  <?php endif; ?>

</div>
</div>
</div>
</div>
<?php get_footer(); ?>
