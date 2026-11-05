<?php if(!defined('ABSPATH')) exit; ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main">Skip to content</a>
<div class="atelier-announcement">
 <div class="container atelier-announcement__row">
  <span class="atelier-announcement__note">DEMO SHOP / PRACTICE ONLY</span>
  <strong class="atelier-announcement__promo">10% OFF PRACTICE ORDERS <span>USE CODE PRACTICE10</span></strong>
  <a href="<?php echo esc_url(home_url('/shop/?on_sale=1')); ?>">SHOP THE EDIT <span aria-hidden="true">&rarr;</span></a>
 </div>
</div>
<header class="site-header atelier-header">
 <div class="container atelier-header__inner">
  <div class="atelier-header__left">
   <button class="nav-toggle atelier-menu-toggle" id="nav-toggle" type="button" aria-expanded="false" aria-controls="primary-navigation" aria-label="Open navigation">
     <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path d="M3 7h18M3 12h18M3 17h18" stroke-width="1.6"/></svg>
   </button>
   <nav id="primary-navigation" class="atelier-navigation" aria-label="Primary navigation">
    <a href="<?php echo esc_url(home_url('/shop/')); ?>">Shop</a>
    <a href="<?php echo esc_url(home_url('/#atelier-best-sellers')); ?>">Best sellers</a>
    <a href="<?php echo esc_url(forma_category_link('apparel')); ?>">Apparel</a>
    <a href="<?php echo esc_url(forma_category_link('accessories')); ?>">Accessories</a>
    <a href="<?php echo esc_url(home_url('/about/')); ?>">About</a>
   </nav>
  </div>
  <a class="atelier-header__logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="FORMA, homepage">FORMA<span>.</span></a>
  <div class="atelier-header__right">
   <button type="button" class="forma-search-open atelier-icon-button" aria-label="Search products" aria-expanded="false" aria-controls="forma-mobile-search" title="Search">
    <svg viewBox="0 0 24 24" stroke="currentColor" fill="none" aria-hidden="true"><circle cx="10.7" cy="10.7" r="6.3"/><path d="m15.4 15.4 5.1 5.1"/></svg>
   </button>
   <a class="atelier-icon-button atelier-account-link" href="<?php echo esc_url(home_url('/my-account/')); ?>" aria-label="My account" title="My account">
    <svg viewBox="0 0 24 24" stroke="currentColor" fill="none" aria-hidden="true"><circle cx="12" cy="8" r="3.5"/><path d="M4.4 21c0-4.4 3.3-7 7.6-7 4.3 0 7.6 2.6 7.6 7"/></svg>
   </a>
   <a class="atelier-icon-button forma-wishlist-link" href="<?php echo esc_url(home_url('/wishlist/')); ?>" aria-label="Saved items" title="Saved items">
    <svg viewBox="0 0 24 24" stroke="currentColor" fill="none" aria-hidden="true"><path d="M20.3 5.8a4.9 4.9 0 0 0-6.9 0L12 7.2l-1.4-1.4a4.9 4.9 0 0 0-6.9 6.9L12 21l8.3-8.3a4.9 4.9 0 0 0 0-6.9Z"/></svg>
    <span class="forma-wishlist-count" hidden>0</span>
   </a>
   <?php echo forma_cart_link(); ?>
  </div>
 </div>
 <div id="forma-mobile-search" class="atelier-search-drawer" hidden>
   <form role="search" class="atelier-search-form container" method="get" action="<?php echo esc_url(home_url('/')); ?>">
    <label class="sr-only" for="forma-mobile-product-query">Search products</label>
    <svg viewBox="0 0 24 24" stroke="currentColor" fill="none" aria-hidden="true"><circle cx="10.7" cy="10.7" r="6.3"/><path d="m15.4 15.4 5.1 5.1"/></svg>
    <input type="search" id="forma-mobile-product-query" name="s" value="<?php echo esc_attr(get_search_query()); ?>" placeholder="Search clothing, hoodies, accessories..." autocomplete="off" required>
    <input type="hidden" name="post_type" value="product">
    <button type="submit">Search <span aria-hidden="true">&rarr;</span></button>
    <button type="button" class="atelier-search-close" aria-label="Close search">&times;</button>
   </form>
 </div>
</header>
