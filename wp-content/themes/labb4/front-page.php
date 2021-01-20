<?php get_header(); ?>
</div> <!-- end container from header -->

<div class="puff mt-5 mb-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-3">
        <h2>Recent News</h2>
      </div>
      <div class="col-lg-9">
        <?php $the_query = new WP_Query('posts_per_page=1'); ?>
        <?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>
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
  <div class="best-seller">
  <?php
    $args = array(
    'post_type' => 'product',
    'posts_per_page' => 4,
    'meta_key' => 'total_sales',
    'orderby' => 'meta_value_num',
    'tax_query' => array( 
        array(
          'taxonomy' => 'product_cat',
          'field' => 'slug',
          'terms' => array( 'catalogues' ),
          'operator' => 'NOT IN'
        )
    ),
    );
    $bestSelling = new WP_Query( $args );
    while ( $bestSelling->have_posts() ) : $bestSelling->the_post(); global $product; ?>
    <a id="id-<?php the_id(); ?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
    <?php if (has_post_thumbnail( $bestSelling->post->ID )) echo get_the_post_thumbnail($bestSelling->post->ID, 'shop_catalog'); 
    else echo '<p>No image found</p>'; ?>
    <h3><?php the_title(); ?></h3>
  <p><?php echo $product->get_price_html(); ?></p>
    </a>
    
    <?php endwhile; ?>
    </div>
        <?php wp_reset_query(); ?>

      <h1 class="text-center">Shop by Category</h1>
      <p class="text-center">Brilliant design and unparalleled craftsmanship.</p>

<div class="categories">
 <?php
 $args = array(
          'taxonomy' => 'product_cat',
          'hide_empty' => false,
          'parent'   => 0
      );
  $product_cat = get_terms( $args );

  foreach ($product_cat as $parent_product_cat) {

  echo '
        <h3><a href="'.get_term_link($parent_product_cat->term_id).'">'.$parent_product_cat->name.'</a></h3><br>
        <ul>
       ';
  $child_args = array(
              'taxonomy' => 'product_cat',
              'hide_empty' => false,
              'parent'   => $parent_product_cat->term_id
          );
  $child_product_cats = get_terms( $child_args );
  foreach ($child_product_cats as $child_product_cat)
  {
    echo '<li><a href="'.get_term_link($child_product_cat->term_id).'">'.$child_product_cat->name.'</a></li>';
  }

  echo '
    </ul>';
  }?>
</div>


    </div>
  </div>
</div>

<div class="banner"
  style="background-image:url(<?php echo get_template_directory_uri(); ?>/banner.jpg);">
</div>

<?php get_footer();
