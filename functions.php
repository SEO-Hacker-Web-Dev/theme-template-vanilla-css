<?php

/**
 * Theme setup and customization functions.
 *
 * - Adds theme support for post thumbnails, post formats, WooCommerce, and product gallery features.
 * - Registers primary and secondary navigation menus.
 * - Removes <br> tags from Contact Form 7 forms and disables automatic <p> tag wrapping.
 * - Replaces the default excerpt meta box with a TinyMCE (WYSIWYG) editor for excerpts.
 * - Saves a list of active plugins (including network-activated plugins in multisite) to a file named 'plugin.txt' in the theme directory.
 *
 * Hooks and Filters:
 * - after_setup_theme: Initializes theme features and menus.
 * - wpcf7_form_elements: Filters Contact Form 7 form HTML to remove <br> tags.
 * - wpcf7_autop_or_not: Disables automatic <p> tag wrapping in Contact Form 7 forms.
 * - add_meta_boxes: Replaces the excerpt meta box with a WYSIWYG editor.
 * - admin_init: Saves the list of active plugins to a file.
 */

if (! function_exists('theme_setup')) :
    function theme_setup_setup()
    {
        add_theme_support('post-thumbnails');
        add_theme_support('post-formats', array('aside', 'gallery', 'quote', 'image', 'video'));
        add_theme_support('woocommerce');
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');

        register_nav_menus(array(
            'primary' => __('Primary Menu', 'theme_setup'),
            'quick-links' => __('Quick Links', 'theme_setup'),
            'core-programs' => __('Core Programs', 'theme_setup'),
        ));
    }
    add_action('after_setup_theme', 'theme_setup_setup');
endif;

function remove_br_from_cf7_form($form)
{

    $form = str_replace('<br>', '', $form);
    $form = str_replace('<br />', '', $form);
    return $form;
}
add_filter('wpcf7_form_elements', 'remove_br_from_cf7_form');

// Remove <br> tags from the_content output
function remove_br_from_content($content)
{
    $content = str_replace('<br>', '', $content);
    $content = str_replace('<br />', '', $content);
    return $content;
}
add_filter('the_content', 'remove_br_from_content');

// disable wrapper of cf7 p tag
add_filter('wpcf7_autop_or_not', '__return_false');

// Enable TinyMCE (WYSIWYG) editor for excerpts
function wysiwyg_excerpt_meta_box()
{
    remove_meta_box('postexcerpt', null, 'normal');
    add_meta_box(
        'postexcerpt',
        __('Excerpt'),
        'wysiwyg_excerpt_meta_box_callback',
        null,
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'wysiwyg_excerpt_meta_box');

function wysiwyg_excerpt_meta_box_callback($post)
{
    $excerpt = get_the_excerpt($post);
    wp_editor(
        $excerpt,
        'excerpt',
        array(
            'textarea_rows' => 10,
            'media_buttons' => false,
            'teeny'         => true,
        )
    );
}


function save_active_plugins_list()
{
    $active_plugins = get_option('active_plugins');
    if (is_multisite()) {
        $network_plugins = get_site_option('active_sitewide_plugins');
        if ($network_plugins && is_array($network_plugins)) {
            $active_plugins = array_merge($active_plugins, array_keys($network_plugins));
        }
    }
    $plugin_names = array();
    foreach ($active_plugins as $plugin_file) {
        $plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/' . $plugin_file, false, false);
        $plugin_names[] = $plugin_data['Name'] ?? $plugin_file;
    }
    $output = implode(PHP_EOL, $plugin_names);
    $file = get_template_directory() . '/plugin.txt';
    file_put_contents($file, $output);
}
add_action('admin_init', 'save_active_plugins_list');


function dequeue_wp_block_library_css()
{
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wc-block-style'); // If WooCommerce blocks are used
}
add_action('wp_enqueue_scripts', 'dequeue_wp_block_library_css', 100);

function minify_html_output($buffer)
{
    if (preg_match('/<html[^>]*>(.*?)<\/body>/is', $buffer, $matches)) {
        $body_content = $matches[1];

        // Minify the body content
        $minified = preg_replace([
            '/\>[^\S ]+/s',    // strip whitespaces after tags, except space
            '/[^\S ]+\</s',    // strip whitespaces before tags, except space
            '/(\s)+/s'         // shorten multiple whitespace sequences
        ], ['>', '<', '\\1'], $body_content);

        // Replace original with minified content
        $buffer = str_replace($matches[1], $minified, $buffer);
    }

    return $buffer;
}

function start_html_minify()
{
    ob_start('minify_html_output');
}
add_action('template_redirect', 'start_html_minify');


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