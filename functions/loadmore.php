<?php
// AJAX handler: Load more posts
add_action('wp_ajax_my_loadmore', 'my_loadmore_ajax_handler');
add_action('wp_ajax_nopriv_my_loadmore', 'my_loadmore_ajax_handler');
function my_loadmore_ajax_handler() {
    check_ajax_referer('loadmore_nonce', 'nonce');
    $args = isset($_POST['args']) ? json_decode(stripslashes($_POST['args']), true) : [];
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
    $args['paged'] = $paged;

    function image_url_exists($url) {
        $wp_upload_dir = wp_upload_dir();
        $base_url = $wp_upload_dir['baseurl'];
        $base_dir = $wp_upload_dir['basedir'];
        if (strpos($url, $base_url) === 0) {
            $file = $base_dir . str_replace($base_url, '', $url);
            return file_exists($file);
        }
        return false;
    }

    $default_image = 'http://localhost:8882/wp-content/uploads/2025/08/Window-Works-5.jpg';
    $query = new WP_Query($args);

    ob_start();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
            $img = ($thumbnail_url && image_url_exists($thumbnail_url)) ? $thumbnail_url : $default_image;
            $blog_card_data = [
                'title'   => get_the_title(),
                'link'    => get_permalink(),
                'excerpt' => wpautop(get_the_excerpt()),
                'img'     => $img,
                'date'    => get_the_date(),
            ];
            get_template_part('templates/post_cards', null, $blog_card_data);
        }
    }
    $html = ob_get_clean();
    wp_send_json([
        'html' => $html,
        'has_more' => ($query->max_num_pages > $paged),
        'next_paged' => $paged + 1
    ]);
}


// Enqueue JS for load more
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('my-loadmore', get_template_directory_uri() . '/inc/js/loadmore.js', ['jquery'], null, true);
    wp_localize_script('my-loadmore', 'my_loadmore_params', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('loadmore_nonce')
    ]);
});