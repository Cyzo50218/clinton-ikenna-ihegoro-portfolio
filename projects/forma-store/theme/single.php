<?php get_header(); ?>
<main id="main" class="container"><div class="interior-heading"><?php while(have_posts()):the_post(); ?><p class="eyebrow">FORMA / Journal</p><h1><?php the_title(); ?></h1></div><article class="content-body"><?php the_content(); ?></article><?php endwhile; ?></main>
<?php get_footer(); ?>
