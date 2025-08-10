<?php
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