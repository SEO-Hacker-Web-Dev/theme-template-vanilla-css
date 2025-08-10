<?php get_header(); ?>

<main id="main" class="site-main">
    <header class="page-header">
        <h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'my_theme' ), get_search_query() ); ?></h1>
    </header>
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            get_template_part( 'template-parts/content', get_post_type() );
        endwhile;
        the_posts_navigation();
    else :
        get_template_part( 'template-parts/content', 'none' );
    endif;
    ?>
</main>

<?php get_footer(); ?>
