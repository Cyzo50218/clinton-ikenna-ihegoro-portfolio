<?php
/**
 * FORMA luxury collection loop enhancements.
 * Do not modify the WooCommerce loop structure, cart, prices or catalog queries.
 */
if(!defined('ABSPATH')) exit;

function forma_is_catalog_archive() {
 return function_exists('is_shop') && (is_shop() || is_product_category() || is_product_tag());
}

/* A discreet true product category above the item name; exclude root grouping. */
add_action('woocommerce_shop_loop_item_title',function(){
 if(!forma_is_catalog_archive()) return;
 $product=wc_get_product(get_the_ID());
 if(!$product) return;
 $terms=get_the_terms($product->get_id(),'product_cat');
 if(!$terms || is_wp_error($terms))return;
 $selected=null;
 foreach($terms as $term){
  if($term->slug==='the-collection'||$term->slug==='uncategorized')continue;
  if(!$selected || $term->parent)$selected=$term;
 }
 if($selected){
  echo '<p class="atelier-product-category">'.esc_html($selected->name).'</p>';
 }
},8);

/* Keep a meaningful stock label on genuinely unavailable merchandise. */
add_action('woocommerce_after_shop_loop_item_title',function(){
 if(!forma_is_catalog_archive())return;
 $product=wc_get_product(get_the_ID());
 if($product&&!$product->is_in_stock())echo '<span class="atelier-product-soldout">Currently unavailable</span>';
},12);
