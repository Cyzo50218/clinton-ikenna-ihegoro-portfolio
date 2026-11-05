<?php get_header(); ?>
<main id="main" class="container">
 <?php while(have_posts()):the_post(); ?>
 <header class="interior-heading"><p class="eyebrow">FORMA / Information</p><h1><?php the_title(); ?></h1></header>
 <article class="<?php echo (in_array(get_post_field('post_name'),['cart','checkout','my-account'],true))?'commerce-body':'content-body'; ?>"><?php the_content();wp_link_pages(); ?></article>
 <?php endwhile; ?>
</main>
<?php get_footer(); ?>
