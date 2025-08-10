
<?php get_header();
//Template Name: Blogs
$banner_data = [
    'banner_header' => get_field('banner_header'),
    'banner_content' => get_field('banner_content'),
    'banner_background_image' => get_field('banner_background_image'),
    'banner_class' => 'min-h-[600px] flex flex-col justify-center section_padding', // Default class for the terms and conditions banner
];
get_template_part('template/banner', null, $banner_data);
?>
<section class="section_padding" id="some_blogs">
    <div class="wrapper">
        <div class="grid_box gap-[24px] w-full">
            <?php
            $args = [
                'post_type' => 'post',
                'posts_per_page' => 4,
                'post_status' => 'publish',
            ];
            $query = new WP_Query($args);
            $excluded_post = [];
            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post();
                    $excluded_post[] = get_the_ID();
                    $blog_card_data = [
                        'title' => get_the_title(),
                        'link' => get_permalink(),
                        'excerpt' => wpautop(get_the_excerpt()),
                        'img' => get_the_post_thumbnail_url(get_the_ID(), 'medium') ?: get_template_directory_uri() . '/assets/images/placeholder.png',
                        'date' => get_the_date(),
                    ];
                    get_template_part('template/blog_cards', null, $blog_card_data);
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p>No blog posts found.</p>';
            endif;
            ?>
        </div>
    </div>
</section>

<section class="section_padding" id="other_blogs">
    <div class="wrapper">
        <div class="flex flex-wrap">
            <div class="header flex items-center justify-between flex-col lg:flex-row">
                <div class="left_content lg:max-w-[650px] max-w-full">
                    <h2>Other Blogs</h2>
                    <p>Lorem ipsum dolor sit amet consectetur. Mauris habitant ac consequat risus urna ut quisque rhoncus. Tristique diam vitae mattis diam nunc vitae tincidunt donec diam.</p>
                </div>
                <div class="search">
                    <form action="<?php echo esc_url(home_url('/')); ?>" method="get" class="flex items-center p-[15px] rounded-[2px] border border-[#878787] border-solid">
                        <input type="text" name="s" placeholder="Search" class="search_input" value="<?php echo get_search_query(); ?>">
                        <button type="submit" class="search_button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                                <path d="M8.755 11.7421C6.415 9.40207 6.415 5.60207 8.755 3.25207C11.095 0.91207 14.895 0.91207 17.245 3.25207C19.585 5.59207 19.585 9.39207 17.245 11.7421C14.905 14.0821 11.105 14.0821 8.755 11.7421Z" fill="#E5E5E5" stroke="#E5E5E5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M8.49512 12.002L0.995117 19.502L8.49512 12.002Z" fill="#E5E5E5" />
                                <path d="M8.49512 12.002L0.995117 19.502" stroke="#E5E5E5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
            <div class="grid_box gap-[24px] w-full">
                <?php
                $args = [
                    'post_type' => 'post',
                    'posts_per_page' => 9,
                    'post_status' => 'publish',
                    'post__not_in' => $excluded_post, // Exclude already displayed posts
                ];
                $query = new WP_Query($args);
                if ($query->have_posts()) :
                    while ($query->have_posts()) : $query->the_post();
                        $blog_card_data = [
                            'title' => get_the_title(),
                            'link' => get_permalink(),
                            'excerpt' => wpautop(get_the_excerpt()),
                            'img' => get_the_post_thumbnail_url(get_the_ID(), 'medium') ?: get_template_directory_uri() . '/assets/images/placeholder.png',
                            'date' => get_the_date(),
                            'author' => get_the_author(),
                        ];
                        get_template_part('template/blog_cards', null, $blog_card_data);
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p>No blog posts found.</p>';
                endif;
                ?>
            </div>
            <?php get_template_part('template/pagination'); ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>
