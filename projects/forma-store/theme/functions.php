<?php
if(!defined('ABSPATH'))exit;
require_once get_template_directory().'/inc/retail-features.php';
require_once get_template_directory().'/inc/atelier-shop.php';
function forma_setup(){
 add_theme_support('title-tag');
 add_theme_support('post-thumbnails');
 add_theme_support('automatic-feed-links');
 add_theme_support('responsive-embeds');
 add_theme_support('align-wide');
 add_theme_support('wp-block-styles');
 add_theme_support('woocommerce', ['thumbnail_image_width'=>480,'single_image_width'=>700,'product_grid'=>['default_rows'=>3,'min_rows'=>2,'max_rows'=>8,'default_columns'=>4,'min_columns'=>2,'max_columns'=>4]]);
 add_theme_support('wc-product-gallery-zoom');
 add_theme_support('wc-product-gallery-lightbox');
 add_theme_support('wc-product-gallery-slider');
 add_theme_support('html5',['search-form','comment-form','comment-list','gallery','caption','style','script']);
 register_nav_menus(['primary'=>'Store navigation']);
}
add_action('after_setup_theme','forma_setup');
function forma_assets(){
 wp_enqueue_style('forma-main',get_stylesheet_uri(),[],wp_get_theme()->get('Version'));
 wp_enqueue_style('forma-filters',get_template_directory_uri().'/assets/filters.css',['forma-main'],'1.1.0');
 wp_enqueue_style('forma-retail-v2',get_template_directory_uri().'/assets/storefront-v2.css',['forma-filters'],'1.2.0');
 wp_enqueue_style('forma-atelier-v3',get_template_directory_uri().'/assets/atelier-v3.css',['forma-retail-v2'],'1.3.0');
 wp_enqueue_style('forma-atelier-tuning',get_template_directory_uri().'/assets/atelier-v3-tuning.css',['forma-atelier-v3'],'1.3.1');
 if(is_front_page()) {
  wp_enqueue_style('forma-header-transition',get_template_directory_uri().'/assets/atelier-header-transition.css',['forma-atelier-tuning'],'1.3.2');
  wp_enqueue_script('forma-atelier-motion',get_template_directory_uri().'/assets/atelier-motion.js',[], '1.3.5',true);
  wp_enqueue_script('forma-header-transition',get_template_directory_uri().'/assets/atelier-header-transition.js',['forma-ui'],'1.3.4',true);
 }
 wp_enqueue_style('forma-hero-promo-v134',get_template_directory_uri().'/assets/atelier-hero-promo-v134.css',is_front_page()?['forma-header-transition']:['forma-atelier-tuning'],'1.3.4');
 wp_enqueue_style('forma-promo-dots-v135',get_template_directory_uri().'/assets/atelier-promo-dots-v135.css',['forma-hero-promo-v134'],'1.3.9');
 wp_enqueue_style('forma-fashion-v136',get_template_directory_uri().'/assets/atelier-fashion-v136.css',['forma-promo-dots-v135'],'1.3.6');
 wp_enqueue_style('forma-headline-v137',get_template_directory_uri().'/assets/atelier-headline-v137.css',['forma-fashion-v136'],'1.3.8');
 if(is_front_page()) wp_enqueue_style('forma-bodoni-v1311',get_template_directory_uri().'/assets/atelier-bodoni-v1311.css',['forma-headline-v137'],'1.3.12');
 if(function_exists('forma_is_catalog_archive') && forma_is_catalog_archive()) wp_enqueue_style('forma-atelier-shop-v140',get_template_directory_uri().'/assets/atelier-shop-v140.css',['forma-headline-v137'],'1.4.0');
 wp_enqueue_script('forma-ui',get_template_directory_uri().'/assets/store.js',[],wp_get_theme()->get('Version'),true);
 if(function_exists('is_woocommerce') && (is_front_page()||is_woocommerce()))wp_enqueue_script('wc-add-to-cart');
 if(function_exists('WC')&&WC()->cart)wp_enqueue_script('wc-cart-fragments');
}
add_action('wp_enqueue_scripts','forma_assets');
function forma_cart_number(){return function_exists('WC') && WC()->cart?(int)WC()->cart->get_cart_contents_count():0;}
function forma_cart_link(){
 $url=function_exists('wc_get_cart_url')?wc_get_cart_url():home_url('/cart/');
 return '<a class="header-cart" href="'.esc_url($url).'" aria-label="'.esc_attr('Shopping bag, '.forma_cart_number().' items').'"><svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M4 8h16l-1 12H5L4 8Z"/><path d="M9 9V6a3 3 0 0 1 6 0v3"/></svg><span class="bag-count">'.forma_cart_number().'</span></a>';
}
add_filter('woocommerce_add_to_cart_fragments',function($fragments){$fragments['a.header-cart']=forma_cart_link();return $fragments;});
add_filter('loop_shop_columns',fn()=>4);
add_filter('woocommerce_show_page_title','__return_false');
/* Training gateway: never imply a practice checkout has been paid for. */
add_filter('woocommerce_cod_process_payment_order_status',function($status,$order){return 'on-hold';},10,2);
add_filter('loop_shop_per_page',fn()=>12,20);
function forma_product_card($product){
 if(!$product||!$product->is_visible())return;
 $permalink=get_permalink($product->get_id());
 $cats=wc_get_product_category_list($product->get_id(),', ');
 $label=$product->is_on_sale()?'Sale':'';
 echo '<article class="product-card">';
 echo '<a class="product-card-media" href="'.esc_url($permalink).'">';
 if($label)echo '<span class="product-pill">'.esc_html($label).'</span>';
 echo $product->get_image('woocommerce_thumbnail',['loading'=>'lazy','alt'=>$product->get_name()]);
 echo '</a><div class="product-card-bottom"><p class="product-card-sub">'.wp_strip_all_tags($cats).'</p><h3 class="product-card-title"><a href="'.esc_url($permalink).'">'.esc_html($product->get_name()).'</a></h3>';
 echo '<div class="product-card-price">'.wp_kses_post($product->get_price_html()).'</div>';
 if($product->is_type('simple')&&$product->is_in_stock()) {
  echo '<a class="card-add add_to_cart_button ajax_add_to_cart" data-product_id="'.esc_attr($product->get_id()).'" data-product_sku="'.esc_attr($product->get_sku()).'" aria-label="'.esc_attr('Add '.$product->get_name().' to your cart').'" href="'.esc_url($product->add_to_cart_url()).'">Add to bag <span aria-hidden="true">↗</span></a>';
 }else{
  echo '<a class="card-add" href="'.esc_url($permalink).'">'.($product->is_type('variable')?'Choose options':'View product').' <span aria-hidden="true">↗</span></a>';
 }
 echo '</div>';
 if(function_exists('forma_wishlist_button')) echo forma_wishlist_button($product);
 echo '</article>';
}
function forma_home_products($limit=4,$type='popular'){
 if(!class_exists('WooCommerce'))return;
 $args=['status'=>'publish','limit'=>$limit,'orderby'=>$type==='new'?'date':'popularity','order'=>'DESC'];
 if($type==='popular'){$args['featured']=true;$args['orderby']='date';}
 $products=wc_get_products($args);
 echo '<div class="product-grid">';
 foreach($products as $product)forma_product_card($product);
 echo '</div>';
}
function forma_category_link($slug){
 $term=get_term_by('slug',$slug,'product_cat');
 return $term&&!is_wp_error($term)?get_term_link($term):home_url('/shop/');
}
function forma_asset($name){
 $post=get_posts(['post_type'=>'attachment','post_status'=>'inherit','posts_per_page'=>1,'meta_key'=>'_forma_demo_asset','meta_value'=>$name]);
 return $post?wp_get_attachment_image_url($post[0]->ID,'large'):wc_placeholder_img_src();
}
function forma_body_class($classes){$classes[]='forma-shop-body';return $classes;}
add_filter('body_class','forma_body_class');
/**
 * Minimal catalog filters for the practice store. Preserve WC's existing
 * query clauses, and treat all visitor-supplied prices as bounded numbers.
 */
add_action('woocommerce_product_query',function($query){
 $meta=(array)$query->get('meta_query');
 $request_min=isset($_GET['min_price'])?max(0,(float)sanitize_text_field(wp_unslash($_GET['min_price']))):0;
 $request_max=isset($_GET['max_price'])?max(0,(float)sanitize_text_field(wp_unslash($_GET['max_price']))):0;
 $min=min(10000000,$request_min);
 $max=min(10000000,$request_max);
 if($min>0 || $max>0){
   $meta[]=['key'=>'_price','value'=>[$min,$max>0?max($min,$max):10000000],'compare'=>'BETWEEN','type'=>'DECIMAL'];
 }
 if(!empty($_GET['stock_only'])){
   $meta[]=['key'=>'_stock_status','value'=>'instock','compare'=>'='];
 }
 $query->set('meta_query',$meta);
});
