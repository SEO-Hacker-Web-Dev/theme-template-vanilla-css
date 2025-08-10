<?php
// Helper: check if image URL exists on disk to avoid 404s
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

// Use $args passed from get_template_part, or set defaults
$args = $args ?? [
    'post_type'      => 'post',
    'posts_per_page' => 4,
    'post_status'    => 'publish',
    'paged'          => 1,
];

if (!isset($args['post_status'])) $args['post_status'] = 'publish';
if (!isset($args['paged'])) $args['paged'] = 1;

$query = new WP_Query($args);
$default_image = 'http://localhost:8882/wp-content/uploads/2025/08/Window-Works-5.jpg';

if ($query->have_posts()) : ?>
    <div id="loadmore-list" class="row">
        <?php
        while ($query->have_posts()) : $query->the_post();
            $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
            // Avoid 404: Only use if file exists
            $img = ($thumbnail_url && image_url_exists($thumbnail_url)) ? $thumbnail_url : $default_image;

            $blog_card_data = [
                'title'   => get_the_title(),
                'link'    => get_permalink(),
                'excerpt' => wpautop(get_the_excerpt()),
                'img'     => $img,
                'date'    => get_the_date(),
            ];
            get_template_part('templates/post_cards', null, $blog_card_data);
        endwhile;
        ?>
    </div>
    <?php wp_reset_postdata(); ?>
    <?php if ($query->max_num_pages > $args['paged']) : ?>
        <div id="loadmore-container" class="text-center mt-4">
            <button
                id="loadmore-btn"
                data-paged="<?php echo esc_attr($args['paged']); ?>"
                data-maxpage="<?php echo esc_attr($query->max_num_pages); ?>"
                data-args='<?php echo esc_attr(json_encode($args)); ?>'
                data-nonce="<?php echo esc_attr(wp_create_nonce('loadmore_nonce')); ?>">
                Load More
            </button>
        </div>
    <?php endif; ?>
<?php else : ?>
    <p>No blog posts found.</p>
<?php endif; ?>