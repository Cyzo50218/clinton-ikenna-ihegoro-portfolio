<?php
/**
 * FORMA demo-store retail features.
 * Browser-only wishlist and opt-in test-address newsletter registration.
 */
if (!defined('ABSPATH')) exit;

/** Render a working browser-local wishlist control, never a dummy button. */
function forma_wishlist_button($product, $single=false) {
 if (!$product instanceof WC_Product) return '';
 $id=(int)$product->get_id();
 $label=$single?'Save this product':'Save to wishlist';
 return '<button type="button" class="forma-save-item'.($single?' forma-single-wishlist':'').'" data-product-id="'.esc_attr($id).'" aria-pressed="false" aria-label="'.esc_attr($label).'"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path d="M20.3 5.8a4.9 4.9 0 0 0-6.9 0L12 7.2l-1.4-1.4a4.9 4.9 0 0 0-6.9 6.9L12 21l8.3-8.3a4.9 4.9 0 0 0 0-6.9Z"/></svg>'.($single?'<span>Save for later</span>':'').'</button>';
}
add_action('woocommerce_after_shop_loop_item',function(){
 global $product;
 if($product instanceof WC_Product) echo forma_wishlist_button($product);
},16);
add_action('woocommerce_single_product_summary',function(){
 global $product;
 if($product instanceof WC_Product) echo forma_wishlist_button($product,true);
},35);
add_shortcode('forma_wishlist',function(){
 return '<p class="demo-note">Saved products are stored in this browser only, and do not synchronize across devices. No account is required.</p><div class="forma-wishlist-grid" id="forma-wishlist-grid" aria-live="polite"></div><div class="forma-wishlist-empty" id="forma-wishlist-empty" hidden>No saved items yet. <a class="small-link" href="'.esc_url(home_url('/shop/')).'">Shop the collection &rarr;</a></div>';
});
function forma_localized_catalog(){
 if(!function_exists('wc_get_products'))return [];
 $products=wc_get_products(['status'=>'publish','limit'=>80,'orderby'=>'date','order'=>'DESC']);
 $catalog=[];
 foreach($products as $p){
  if(!$p->is_visible())continue;
  $catalog[(string)$p->get_id()]=[
    'id'=>(int)$p->get_id(),
    'name'=>$p->get_name(),
    'url'=>get_permalink($p->get_id()),
    'image'=>$p->get_image_id()?(wp_get_attachment_image_url($p->get_image_id(),'woocommerce_thumbnail')?:''): '',
    'price'=>wp_strip_all_tags($p->get_price_html()),
    'inStock'=>$p->is_in_stock(),
    'variable'=>$p->is_type('variable'),
    'addUrl'=>$p->is_type('simple')&&$p->is_in_stock()?$p->add_to_cart_url():get_permalink($p->get_id()),
  ];
 }
 return $catalog;
}
add_action('wp_enqueue_scripts',function(){
 wp_localize_script('forma-ui','formaRetailData',[
   'catalog'=>forma_localized_catalog(),
   'wishlistUrl'=>home_url('/wishlist/'),
   'cartUrl'=>function_exists('wc_get_cart_url')?wc_get_cart_url():home_url('/cart/'),
 ]);
},20);

/** Sale tab: preserve the user's min/max price, stock, category and sort constraints. */
add_action('woocommerce_product_query',function($query){
 if(!empty($_GET['on_sale'])){
  $on_sale=wc_get_product_ids_on_sale();
  $query->set('post__in', $on_sale?:[0]);
 }
},30);

/**
 * Newsletter learning flow: only accepts reserved .invalid test domains,
 * stores local demo records, sends no emails and makes no external requests.
 */
add_action('init',function(){
 register_post_type('forma_demo_signup',[
  'labels'=>[
   'name'=>'Demo newsletter signups',
   'singular_name'=>'Demo newsletter signup',
   'menu_name'=>'Demo newsletter signups'
  ],
  'public'=>false,'exclude_from_search'=>true,'show_ui'=>true,'show_in_menu'=>true,
  'show_in_rest'=>false,'supports'=>['title'],
  'capability_type'=>'post','menu_icon'=>'dashicons-email-alt2',
 ]);
});
function forma_demo_newsletter_handler(){
 $return=home_url('/#newsletter');
 if(!isset($_POST['forma_signup_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['forma_signup_nonce'])),'forma_demo_newsletter')){
  wp_safe_redirect(home_url('/?newsletter=invalid#newsletter'));exit;
 }
 if(!empty($_POST['site_company'])){
  wp_safe_redirect($return);exit;
 }
 $email=isset($_POST['demo_email'])?sanitize_email(wp_unslash($_POST['demo_email'])):'';
 if(!$email || strlen($email)>140 || !is_email($email) || !preg_match('/@[^@\s]+\.invalid$/i',$email)){
  wp_safe_redirect(home_url('/?newsletter=invalid#newsletter'));exit;
 }
 $hash=hash('sha256',strtolower($email));
 $existing=get_posts(['post_type'=>'forma_demo_signup','post_status'=>'private','fields'=>'ids','posts_per_page'=>1,'meta_key'=>'_forma_demo_email_hash','meta_value'=>$hash]);
 if(!$existing){
  $post_id=wp_insert_post(['post_type'=>'forma_demo_signup','post_status'=>'private','post_title'=>$email,'comment_status'=>'closed'],true);
  if(!is_wp_error($post_id)){
    update_post_meta($post_id,'_forma_demo_email_hash',$hash);
  }
 }
 wp_safe_redirect(home_url('/?newsletter=success#newsletter'));exit;
}
add_action('admin_post_nopriv_forma_demo_newsletter','forma_demo_newsletter_handler');
add_action('admin_post_forma_demo_newsletter','forma_demo_newsletter_handler');
