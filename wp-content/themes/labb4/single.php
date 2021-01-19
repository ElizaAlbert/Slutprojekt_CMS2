<?php get_header(); ?>

 <div class="row">
    <?php if ( have_posts() ) : while ( have_posts() ) :  the_post(); ?>
    <?php $featured_img_url=get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>
    <div class="col-lg-12">
        <img class="img-top-single" src="<?php echo $featured_img_url ?>">
        <div class="single-content">
          <h1><?php the_title(); ?></h1>
          <p><?php the_content(); ?></p>
          </div>
    </div>
    <?php endwhile; ?>
    <?php endif; ?>
  </div>
</div>

<?php get_footer(); ?>