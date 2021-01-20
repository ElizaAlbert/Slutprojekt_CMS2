<?php get_header(); ?>

<div class="container">
  <h1 class="text-center" style="margin-bottom: 25px;">News Blog</h1>
  <div class="row justify-content-around">
    <?php if ( have_posts() ) : while ( have_posts() ) :  the_post(); ?>
    <?php $featured_img_url=get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>
    <div class="col-lg-4">
      <div class="card mb-2">
        <img class="card-img-top" src="<?php echo $featured_img_url ?>">
        <div class="card-body">
          <h4 class="card-title"><?php the_title(); ?></h4>
          <p class="card-text"><?php the_excerpt(); ?></p>
          <a href="<?php the_permalink(); ?>" class="solid-btn">Read more</a>
        </div>
      </div>
    </div>
    <?php endwhile; ?>
    <?php endif; ?>
  </div>
</div>

</div>

<?php get_footer(); ?>