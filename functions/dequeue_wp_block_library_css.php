<?php

function dequeue_wp_block_library_css()
{
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wc-block-style'); // If WooCommerce blocks are used
}
add_action('wp_enqueue_scripts', 'dequeue_wp_block_library_css', 100);