<?php
if(!defined('ABSPATH')) exit;
get_header();
$campaign=esc_url(content_url('/uploads/forma-campaign/'));
$shop=esc_url(home_url('/shop/'));
$sale=esc_url(home_url('/shop/?on_sale=1'));
$hoodie=wc_get_product_id_by_sku('FORMA-HOODIE-004');
$hoodie_url=$hoodie?get_permalink($hoodie):forma_category_link('layers');
?>
<main id="main" class="atelier-home">
 <section class="atelier-hero" aria-label="FORMA new collection campaign">
  <div class="atelier-image-carousel atelier-hero-gallery" data-interval="5600" aria-label="Fashion campaign image carousel">
    <img class="atelier-hero__image atelier-image-slide is-active" src="<?php echo $campaign; ?>fashion-campaign.jpg" alt="Seasonal fashion campaign with sunglasses and shopping bags" fetchpriority="high">
    <img class="atelier-hero__image atelier-image-slide" src="<?php echo $campaign; ?>neutral-fashion.jpg" alt="Contemporary fashion outfit inspiration" loading="lazy">
    <img class="atelier-hero__image atelier-image-slide" src="<?php echo $campaign; ?>style-accessories.jpg" alt="Carefully styled everyday clothing on a rack" loading="lazy">
  </div>
  <div class="atelier-hero__shade"></div>
  <div class="container atelier-hero__layout">
   <div class="atelier-hero__copy">
    <h1>Your fashion speaks for you.</h1>
    <a href="<?php echo $shop; ?>" class="atelier-hero__button">SHOP NOW</a>
   </div>
  </div>
  <div class="atelier-hero__pagination" role="group" aria-label="Choose a fashion campaign image">
   <button type="button" class="atelier-hero__dot is-active" data-slide-to="0" aria-label="Show campaign image 1" aria-pressed="true"></button>
   <button type="button" class="atelier-hero__dot" data-slide-to="1" aria-label="Show campaign image 2" aria-pressed="false"></button>
   <button type="button" class="atelier-hero__dot" data-slide-to="2" aria-label="Show campaign image 3" aria-pressed="false"></button>
  </div>
 </section>

 <section class="atelier-section atelier-best" id="atelier-best-sellers">
  <div class="container">
   <div class="atelier-section-head atelier-section-head--center">
    <p class="atelier-kicker">THE PIECES ON REPEAT</p>
    <h2>Shop Best Sellers</h2>
    <p>Explore the featured essentials in our practice catalog.</p>
   </div>
   <div class="atelier-carousel-shell">
    <div class="atelier-carousel-track" id="atelier-best-track" tabindex="0" aria-label="Featured products">
      <?php forma_home_products(8,'popular'); ?>
    </div>
   </div>
   <div class="atelier-carousel-controls">
     <span class="atelier-carousel-progress" aria-hidden="true"><span></span></span>
     <span class="atelier-carousel-index" aria-hidden="true">01 / 08</span>
     <span class="atelier-carousel-nav">
       <button type="button" class="atelier-carousel-button" data-target="atelier-best-track" data-direction="-1" aria-label="Previous products">&larr;</button>
       <button type="button" class="atelier-carousel-button atelier-carousel-button--dark" data-target="atelier-best-track" data-direction="1" aria-label="Next products">&rarr;</button>
     </span>
   </div>
  </div>
 </section>

 <section class="atelier-editorial">
  <div class="container atelier-editorial__grid">
   <div class="atelier-editorial__photo">
     <div class="atelier-image-carousel atelier-editorial-gallery-slider" data-interval="4700" aria-label="Editorial styling photographs">
       <img class="atelier-image-slide is-active" src="<?php echo $campaign; ?>style-accessories.jpg" alt="Neutrally styled everyday clothing hanging on a rack" loading="lazy">
       <img class="atelier-image-slide" src="<?php echo $campaign; ?>fashion-look.jpg" alt="Casual streetwear fashion styling" loading="lazy">
       <img class="atelier-image-slide" src="<?php echo $campaign; ?>boutique-interior.jpg" alt="Inside an apparel and accessories shop" loading="lazy">
     </div>
     <span class="atelier-photo-label">THE ART OF EVERYDAY / FORMA</span>
     <div class="atelier-image-controls">
       <button type="button" class="atelier-image-control" data-slide="prev" aria-label="Previous editorial photo">&larr;</button>
       <span class="atelier-image-count" aria-live="off">01 / 03</span>
       <button type="button" class="atelier-image-control" data-slide="next" aria-label="Next editorial photo">&rarr;</button>
     </div>
   </div>
   <div class="atelier-editorial__text">
     <p class="atelier-kicker">THE FORMA PERSPECTIVE</p>
     <h2>More than<br><em>just a look.</em></h2>
     <p>The best kind of style feels personal. Explore a simple mix of clothing and everyday accessories, with space to make every piece your own.</p>
     <a href="<?php echo esc_url(home_url('/about/')); ?>" class="atelier-text-button">Explore our story <span aria-hidden="true">&rarr;</span></a>
     <div class="atelier-editorial__stamp">F.<span>THE EVERYDAY EDIT</span></div>
   </div>
  </div>
 </section>

 <section class="atelier-section atelier-regular">
  <div class="container">
   <div class="atelier-section-head atelier-section-head--split">
    <div><p class="atelier-kicker">THE NEW ROTATION</p><h2>Shop Regular Sellers</h2><p>Versatile finds, easy favorites and accessories worth a closer look.</p></div>
    <a href="<?php echo $shop; ?>" class="atelier-small-link">View all products <span aria-hidden="true">&rarr;</span></a>
   </div>
   <?php forma_home_products(4,'new'); ?>
  </div>
 </section>

 <section class="atelier-campaign" aria-label="New wardrobe edit">
  <div class="container atelier-campaign__grid">
   <div class="atelier-campaign__content">
     <p class="atelier-kicker">A NEW PERSPECTIVE</p>
     <h2>Build the<br><em>everyday edit.</em></h2>
     <p>Go-to layers and pieces that fit the pace of your day. Discover the current collection.</p>
     <a class="atelier-campaign__button" href="<?php echo esc_url(forma_category_link('layers')); ?>">Explore layers <span aria-hidden="true">&rarr;</span></a>
   </div>
   <div class="atelier-campaign__photo">
     <img src="<?php echo $campaign; ?>neutral-fashion.jpg" alt="Editorial outfit and accessory inspiration" loading="lazy">
     <span>FORM + FUNCTION <strong>THE EDIT / 26</strong></span>
   </div>
  </div>
 </section>

 <section class="atelier-section atelier-categories">
  <div class="container">
    <div class="atelier-section-head atelier-section-head--center"><p class="atelier-kicker">FIND YOUR STYLE</p><h2>Explore the collection</h2><p>Browse the real WooCommerce categories.</p></div>
    <div class="atelier-category-grid">
      <a href="<?php echo esc_url(forma_category_link('apparel')); ?>" class="atelier-category-card">
        <span class="atelier-category-art"><img src="<?php echo esc_url(forma_asset('tee')); ?>" alt="Demo crew tee illustration" loading="lazy"></span>
        <span class="atelier-category-name">01 / APPAREL <strong>Everyday pieces &nearr;</strong></span>
      </a>
      <a href="<?php echo esc_url(forma_category_link('layers')); ?>" class="atelier-category-card">
        <span class="atelier-category-art"><img src="<?php echo esc_url(forma_asset('hoodie-blue')); ?>" alt="Demo hoodie illustration" loading="lazy"></span>
        <span class="atelier-category-name">02 / LAYERS <strong>Wear it your way &nearr;</strong></span>
      </a>
      <a href="<?php echo esc_url(forma_category_link('accessories')); ?>" class="atelier-category-card">
        <span class="atelier-category-art"><img src="<?php echo esc_url(forma_asset('sunglasses')); ?>" alt="Demo sunglasses illustration" loading="lazy"></span>
        <span class="atelier-category-name">03 / ACCESSORIES <strong>The finishing details &nearr;</strong></span>
      </a>
    </div>
  </div>
 </section>

 <div class="atelier-demo-benefits">
  <div class="container atelier-demo-benefits__row">
    <div><span aria-hidden="true">◇</span><strong>Curated practice catalog</strong><small>Browse styles & variations</small></div>
    <div><span aria-hidden="true">↻</span><strong>Try the full checkout</strong><small>Fictional orders only</small></div>
    <div><span aria-hidden="true">♧</span><strong>Save favorite pieces</strong><small>In this browser</small></div>
    <div><span aria-hidden="true">□</span><strong>Explore your account</strong><small>Orders & sample addresses</small></div>
  </div>
 </div>

 <section class="atelier-editorial-gallery">
  <div class="atelier-section-head atelier-section-head--center">
    <p class="atelier-kicker">THE FORM OF EVERYDAY</p><h2>Inspiration from the edit</h2>
    <p>A little creative inspiration beyond the product shelf.</p>
  </div>
  <div class="atelier-gallery-grid">
    <img src="<?php echo $campaign; ?>fashion-campaign.jpg" alt="Fashion streetwear campaign styling" loading="lazy">
    <img src="<?php echo $campaign; ?>neutral-fashion.jpg" alt="Contemporary outfit styling" loading="lazy">
    <img src="<?php echo $campaign; ?>style-accessories.jpg" alt="Minimalist clothing and rack" loading="lazy">
    <img src="<?php echo $campaign; ?>accessory-style.jpg" alt="Colorful modern styling" loading="lazy">
  </div>
 </section>

 <section id="newsletter" class="atelier-newsletter">
  <div class="container atelier-newsletter__inner">
    <div><p class="atelier-kicker">STAY IN THE LOOP</p><h2>Join the FORMA list.</h2><p>Explore the demo signup experience. No emails are sent and only fictional test addresses are accepted.</p></div>
    <div class="atelier-newsletter__right">
    <?php if(isset($_GET['newsletter'])&&$_GET['newsletter']==='success'): ?><p class="atelier-form-status" role="status">Your example signup was saved locally.</p><?php elseif(isset($_GET['newsletter'])&&$_GET['newsletter']==='invalid'): ?><p class="atelier-form-status" role="alert">Use a fictional address ending in .invalid (example: hello@example.invalid).</p><?php endif; ?>
    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="atelier-newsletter-form">
      <input type="hidden" name="action" value="forma_demo_newsletter">
      <?php wp_nonce_field('forma_demo_newsletter','forma_signup_nonce'); ?>
      <label class="sr-only" for="atelier-newsletter-email">Your demo email</label>
      <input type="email" id="atelier-newsletter-email" name="demo_email" required maxlength="140" placeholder="Your example email address">
      <label class="r-newsletter-hidden" aria-hidden="true">Do not fill <input type="text" name="site_company" tabindex="-1" autocomplete="off"></label>
      <button type="submit" aria-label="Submit demo signup">&rarr;</button>
    </form>
    <small>Demo signup · No real mailing list or messages</small>
    </div>
  </div>
 </section>
</main>
<?php get_footer(); ?>
