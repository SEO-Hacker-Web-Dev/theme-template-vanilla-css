<?php
// Use $args passed from get_template_part, or set defaults
$args = $args ?? [
    'post_type' => 'post',
    'posts_per_page' => 4,
    'post_status' => 'publish',
];

// Always ensure post_status is set
if (!isset($args['post_status'])) {
    $args['post_status'] = 'publish';
}

$query = new WP_Query($args);
$excluded_post = [];
if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post();
        $excluded_post[] = get_the_ID();
        $default_image = 'http://localhost:8882/wp-content/uploads/2025/08/Window-Works-5.jpg';
        $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
        if (!$thumbnail_url) {
            $thumbnail_url = $default_image;
        }

        $blog_card_data = [
            'title'   => get_the_title(),
            'link'    => get_permalink(),
            'excerpt' => wpautop(get_the_excerpt()),
            'img'     => $thumbnail_url,
            'date'    => get_the_date(),
        ];
        get_template_part('templates/post_cards', null, $blog_card_data);
    endwhile;
    wp_reset_postdata();

    // Show pagination if posts_per_page is not -1
    if (isset($args['posts_per_page']) && $args['posts_per_page'] != -1) : ?>
        <div id="pagination-container">
            <?php get_template_part('templates/pagination'); ?>
        </div>
<?php endif;

else :
    echo '<p>No blog posts found.</p>';
endif;
?>