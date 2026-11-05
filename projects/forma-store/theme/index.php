<?php get_header(); ?>
<main id="main" class="container"><header class="interior-heading"><p class="eyebrow">FORMA / Journal</p><h1><?php echo esc_html(is_archive()?get_the_archive_title():'Journal'); ?></h1></header>
<div class="product-grid" style="padding-bottom:100px"><?php while(have_posts()):the_post(); ?>
<article><a href="<?php the_permalink(); ?>"><?php if(has_post_thumbnail())the_post_thumbnail('medium_large');?><h2><?php the_title(); ?></h2></a><p><?php echo esc_html(wp_trim_words(get_the_excerpt(),25)); ?></p></article>
<?php endwhile; ?></div><?php the_posts_pagination(); ?></main>
<?php get_footer(); ?>
