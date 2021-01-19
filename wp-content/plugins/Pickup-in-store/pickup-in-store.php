<?php
/**
* Plugin Name: Pickup in store
* Author: Emil Backlund
*/

function get_store_titles()
{
    $post_type_query  = new WP_Query(
        array(
  'post_type'      => 'store',
  'posts_per_page' => -1
)
    );

    $posts_array = $post_type_query->posts;
    $store_locations = wp_list_pluck($posts_array, 'post_title', 'ID');
    echo '<label for="storeLocations">Pickup in store </label>';
    echo '<select name="storeLocations" id="storeLocations">';
    foreach ($store_locations as $value) {
        echo '<option value="'.$value.'">'.$value.'</option>';
    }
    echo '</select>';
}

add_action('woocommerce_checkout_after_customer_details', 'get_store_titles');
class Pickup
{
    public $content= '';

    public function set_store_locations($content)
    {
        $this->content = $content;
    }
    public function get_store_locations()
    {
        return $this->content;
    }
}
