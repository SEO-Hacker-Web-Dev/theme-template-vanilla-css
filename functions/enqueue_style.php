<?php
function theme_enqueue_all_assets()
{
    $theme_dir = get_template_directory_uri();
    $css_path = $theme_dir . '/inc/css';

    // ✅ Only enqueue final Tailwind build (minified output.css)
    // wp_enqueue_style(
    //     'main-css',
    //     $theme_dir . '/src/output.css',
    //     array(),
    //     file_exists(get_template_directory() . '/src/output.css') ? filemtime(get_template_directory() . '/src/output.css') : null
    // );

    // Local stylesheets
    wp_enqueue_style('header-css', $css_path . '/header.css', array(), null);
    wp_enqueue_style('footer-css', $css_path . '/footer.css', array(), null);
    wp_enqueue_style('global-css', $css_path . '/global.css', array(), null);
    // Preload global.css for faster styling (hooked into wp_head manually)
    add_action('wp_head', function () use ($css_path, $theme_dir) {
        echo '<link rel="preload" as="style" href="' . $css_path . '/global.css" />';
    }, 1);
    // wp_enqueue_style('mark-font-css', $theme_dir . '/assets/fonts/Mark/stylesheet.css', array(), null);

    // jQuery (from local)
    wp_enqueue_script('jquery-cdn', $theme_dir . '/inc/js/jquery.min.js', array(), null, true);

    // Flowbite JS from CDN
    // wp_enqueue_script(
    //     'flowbite-js',
    //     $theme_dir . '/inc/js/flowbite.js',
    //     array(),
    //     null,
    //     true
    // );

    // Front Page Specific
    if (is_front_page()) {
        wp_enqueue_style('index-css', $css_path . '/index.css', array(), null);
        wp_enqueue_style('owl-carousel-css', $css_path . '/owl.carousel.min.css', array(), null);
        wp_enqueue_style('owl-theme-css', $css_path . '/owl.theme.default.css', array(), null);
    }
}
// Set priority to 1 to load before all other enqueued assets
add_action('wp_enqueue_scripts', 'theme_enqueue_all_assets', 1);