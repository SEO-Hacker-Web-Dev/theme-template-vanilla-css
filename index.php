<?php get_header(); ?>

<main id="main" class="site-main">
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

<?php
get_template_part('templates/link_btn', null, [
    'url' => 'https://example.com',
    'text' => 'Visit Example',
    'target' => '_blank',
    'rel' => 'noopener',
    'class' => 'btn btn-primary',
]);
?>

<?php get_footer(); ?>
