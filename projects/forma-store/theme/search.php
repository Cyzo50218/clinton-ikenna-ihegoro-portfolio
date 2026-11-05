<?php get_header(); ?>
<main id="main" class="container"><header class="shop-heading"><p class="eyebrow">FORMA / Search</p><h1>Search results</h1><p>Results for "<?php echo esc_html(get_search_query()); ?>"</p></header>
<form class="search-form" role="search" action="<?php echo esc_url(home_url('/')); ?>" method="get" style="margin-bottom:34px"><input type="search" name="s" value="<?php echo esc_attr(get_search_query()); ?>" placeholder="Search products"><input type="hidden" name="post_type" value="product"><button>Search ↗</button></form>
<?php if(have_posts()): ?><div class="product-grid" style="padding-bottom:100px"><?php while(have_posts()):the_post(); $p=wc_get_product(get_the_ID()); if($p)forma_product_card($p); endwhile; ?></div><?php the_posts_pagination(); ?>
<?php else: ?><p style="padding-bottom:100px">No matching products. <a href="<?php echo esc_url(home_url('/shop/')); ?>" class="small-link">Browse all items ↗</a></p><?php endif; ?>
</main><?php get_footer(); ?>
