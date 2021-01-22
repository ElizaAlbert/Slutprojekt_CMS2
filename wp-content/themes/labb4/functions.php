<?php
  function slutprojekt_styles()
  {
      wp_enqueue_style('style.css', get_stylesheet_uri());
      wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css', array(), '5.10.2');
      wp_enqueue_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css', array(), '4.5.2');
      wp_enqueue_style('poppins-font', 'https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap', array(), '1.0.0');
      wp_enqueue_script('bootstrapjs', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'), '4.5.2', true);
      //   wp_enqueue_script('checkoutfix', get_template_directory_uri() .'/checkoutfix.js', array('jquery'), '1', true);
  }
  add_action('wp_enqueue_scripts', 'slutprojekt_styles');

  function include_jquery()
  {
      wp_deregister_script('jquery');
      wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.5.1.min.js', array(), null, false);
  }
add_action('wp_enqueue_scripts', 'jquery');

function slutprojekt_setup()
{
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
}
add_action('after_setup_theme', 'slutprojekt_setup');


function slutprojekt_menus()
{
    register_nav_menus(array(
        'main-menu' => 'Main Menu',
    ));
}
add_action('init', 'slutprojekt_menus');

function slutprojekt_custom_excerpt($excerpt)
{
    if (has_excerpt()) {
        $excerpt = wp_trim_words(get_the_excerpt(), apply_filters("excerpt_length", 30));
    }

    return $excerpt;
}

add_filter("the_excerpt", "slutprojekt_custom_excerpt", 999);

function slutprojekt_add_woocommerce_support()
{
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'slutprojekt_add_woocommerce_support');




function onSaleProductsShortcode() {?>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="text-center">Products on Sale</h1>
            <p class="text-center">Brilliant design and unparalleled craftsmanship.</p>
            <div class="on-sale">
                <?php
    $args = array(
    'post_type' => 'product',
    'posts_per_page' => 4,
    'meta_key' => '_sale_price',
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
    $onSale = new WP_Query($args);
    while ($onSale->have_posts()) : $onSale->the_post(); global $product; ?>

                <a style="color: black;" id="id-<?php the_id(); ?>"
                    href="<?php the_permalink(); ?>"
                    title="<?php the_title(); ?>">
                    <h3><?php the_title(); ?>
                    </h3>
                    <?php echo get_the_post_thumbnail($onSale->post->ID, 'shop_catalog'); ?>
                    <p style="color: red"><?php echo $product->get_price_html(); ?>
                    </p>
                </a>

                <?php endwhile; ?>
            </div>
            <?php wp_reset_query(); }?>


        </div>
        <?php add_shortcode('on-sale-products', 'onSaleProductsShortcode');
