<?php get_header(); ?>

<main id="main" class="site-main">
    <section class="error-404 not-found">
        <header class="page-header">
            <h1 class="page-title"><?php _e( 'Oops! That page can\'t be found.', 'my_theme' ); ?></h1>
        </header>
        <div class="page-content">
            <p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'my_theme' ); ?></p>
            <?php get_search_form(); ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>
