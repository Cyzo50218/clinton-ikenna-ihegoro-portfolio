<?php if(!defined('ABSPATH'))exit; ?>
<footer class="site-footer"><div class="container">
 <div class="footer-grid">
  <div><a class="footer-brand" href="<?php echo esc_url(home_url('/')); ?>">FORMA.</a><p class="footer-about">A fictional everyday essentials store built for hands-on WordPress and WooCommerce practice.</p><p class="footer-social-note">Demo products. No real sales. No shipments.</p></div>
  <div><p class="footer-heading">Explore</p><ul class="footer-list"><li><a href="<?php echo esc_url(home_url('/shop/')); ?>">Shop all</a></li><li><a href="<?php echo esc_url(forma_category_link('apparel')); ?>">Apparel</a></li><li><a href="<?php echo esc_url(forma_category_link('layers')); ?>">Layers</a></li><li><a href="<?php echo esc_url(forma_category_link('accessories')); ?>">Accessories</a></li></ul></div>
  <div><p class="footer-heading">Help</p><ul class="footer-list"><li><a href="<?php echo esc_url(home_url('/my-account/')); ?>">My account</a></li><li><a href="<?php echo esc_url(home_url('/cart/')); ?>">Shopping bag</a></li><li><a href="<?php echo esc_url(home_url('/shipping-returns/')); ?>">Shipping & returns</a></li><li><a href="<?php echo esc_url(home_url('/faq/')); ?>">FAQ</a></li></ul></div>
  <div><p class="footer-heading">Information</p><ul class="footer-list"><li><a href="<?php echo esc_url(home_url('/about/')); ?>">Our story</a></li><li><a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact</a></li><li><a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Privacy</a></li><li><a href="<?php echo esc_url(home_url('/terms-and-conditions/')); ?>">Terms & conditions</a></li></ul></div>
 </div>
 <div class="footer-bottom"><span>© <?php echo esc_html(wp_date('Y')); ?> FORMA. Practice storefront powered by WordPress + WooCommerce.</span><strong>DEMONSTRATION ONLY · NOT A LIVE BUSINESS</strong></div>
</div></footer>
<?php wp_footer(); ?>
</body></html>
