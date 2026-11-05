<?php
if (!defined('ABSPATH')) exit;
get_header();
$is_catalog = function_exists('is_shop') && (is_shop() || is_product_category() || is_product_tag());
?>
<?php if ($is_catalog):
 $archive_term = is_product_category() || is_product_tag() ? get_queried_object() : null;
 $archive_title = $archive_term && !is_wp_error($archive_term) ? single_term_title('',false) : 'The Collection';
 $archive_description = $archive_term && !empty($archive_term->description)
  ? wp_strip_all_tags(term_description($archive_term))
  : 'Thoughtful pieces for the way you dress, every day.';
 $catalog_url = wc_get_page_permalink('shop');
 $filter_url = $archive_term ? get_term_link($archive_term) : $catalog_url;
 if(is_wp_error($filter_url)) $filter_url = $catalog_url;
 $min_price = isset($_GET['min_price']) ? min(10000000,absint(wp_unslash($_GET['min_price']))) : 0;
 $max_price = isset($_GET['max_price']) ? min(10000000,absint(wp_unslash($_GET['max_price']))) : 0;
 $in_stock_only = !empty($_GET['stock_only']);
 $on_sale = !empty($_GET['on_sale']);
 $filters_active = $min_price > 0 || $max_price > 0 || $in_stock_only;
 $order_by = isset($_GET['orderby']) ? sanitize_key(wp_unslash($_GET['orderby'])) : '';
 $symbol = get_woocommerce_currency_symbol();
 $campaign_url = content_url('/uploads/forma-campaign/style-accessories.jpg');
?>
<main id="main" class="atelier-catalog">
 <section class="atelier-catalog-intro">
  <div class="atelier-catalog-intro__copy">
   <div class="atelier-catalog-intro__inner">
    <p class="atelier-catalog-kicker">FORMA <span>/</span> THE WARDROBE EDIT</p>
    <h1><?php echo esc_html($archive_title); ?></h1>
    <p class="atelier-catalog-intro__description"><?php echo esc_html($archive_description); ?></p>
    <div class="atelier-catalog-intro__bottom"><span>EST. FOR EVERYDAY</span><span>01 — 26</span></div>
   </div>
  </div>
  <div class="atelier-catalog-intro__visual">
   <img src="<?php echo esc_url($campaign_url); ?>" alt="Curated clothing photographed on a rail" decoding="async" fetchpriority="high">
   <span class="atelier-catalog-intro__caption">THE FORMA EDIT <span>/</span> 2026</span>
  </div>
 </section>

 <div class="container atelier-catalog__container">
  <nav class="atelier-catalog-categories" aria-label="Explore product categories">
   <a href="<?php echo esc_url($catalog_url); ?>" class="<?php echo is_shop() && !$on_sale ? 'is-current' : ''; ?>" <?php if(is_shop() && !$on_sale) echo 'aria-current="page"'; ?>>View all</a>
   <?php foreach (['apparel'=>'Apparel','layers'=>'Layers','accessories'=>'Accessories'] as $slug=>$label):
    $term=get_term_by('slug',$slug,'product_cat');
    if(!$term||is_wp_error($term))continue;
    $current=is_product_category($slug);
   ?>
   <a href="<?php echo esc_url(get_term_link($term)); ?>" class="<?php echo $current?'is-current':''; ?>" <?php if($current) echo 'aria-current="page"'; ?>><?php echo esc_html($label); ?></a>
   <?php endforeach; ?>
   <a href="<?php echo esc_url(add_query_arg('on_sale','1',$catalog_url)); ?>" class="<?php echo $on_sale?'is-current atelier-catalog-categories__sale':'atelier-catalog-categories__sale'; ?>" <?php if($on_sale) echo 'aria-current="page"'; ?>>The sale edit</a>
  </nav>

  <div class="atelier-catalog-controls">
   <div class="atelier-catalog-controls__label">
    <span class="atelier-catalog-controls__line"></span>
    <span>THE COMPLETE EDIT</span>
   </div>
   <details class="atelier-catalog-refine" <?php if($filters_active) echo 'open'; ?>>
    <summary>
     <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.35" aria-hidden="true">
      <path d="M3 6h18M6 12h12M9 18h6" />
     </svg>
     Refine<?php if($filters_active): ?><span class="atelier-catalog-refine__count" aria-label="Filters applied">●</span><?php endif; ?>
     <span class="atelier-catalog-refine__chevron" aria-hidden="true">⌄</span>
    </summary>
    <form class="atelier-catalog-filterform" method="get" action="<?php echo esc_url($filter_url); ?>">
     <label>Price from
      <span class="atelier-catalog-priceinput"><span><?php echo esc_html($symbol); ?></span>
       <input type="number" name="min_price" min="0" max="10000000" step="1" inputmode="numeric" placeholder="0" value="<?php echo $min_price ? esc_attr($min_price):''; ?>">
      </span>
     </label>
     <label>Price to
      <span class="atelier-catalog-priceinput"><span><?php echo esc_html($symbol); ?></span>
       <input type="number" name="max_price" min="0" max="10000000" step="1" inputmode="numeric" placeholder="Any" value="<?php echo $max_price ? esc_attr($max_price):''; ?>">
      </span>
     </label>
     <label class="atelier-catalog-filterform__stock">
      <input type="checkbox" name="stock_only" value="1" <?php checked($in_stock_only); ?>>
      Available pieces only
     </label>
     <?php if($on_sale): ?><input type="hidden" name="on_sale" value="1"><?php endif; ?>
     <?php if($order_by): ?><input type="hidden" name="orderby" value="<?php echo esc_attr($order_by); ?>"><?php endif; ?>
     <button type="submit">Apply filters</button>
     <a href="<?php echo esc_url($on_sale ? add_query_arg('on_sale','1',$filter_url) : $filter_url); ?>">Reset</a>
    </form>
   </details>
  </div>
  <div class="atelier-catalog-products shop-products">
   <?php woocommerce_content(); ?>
  </div>
  <div class="atelier-catalog-outro">
   <span>FORMA / THE EVERYDAY EDIT</span>
   <span>CURATED TO BE WORN, NOT JUST SEEN.</span>
  </div>
 </div>
</main>
<?php else: ?>
<main id="main" class="container">
 <div class="shop-products"><?php woocommerce_content(); ?></div>
</main>
<?php endif; ?>
<?php get_footer(); ?>
