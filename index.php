<?php get_header(); ?>
<section class="blogs">
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <?php get_template_part(
                    'templates/loop-loadmore',
                    null,
                    [
                        'post_type' => 'post',
                        'posts_per_page' => 6,
                        'orderby' => 'title',
                        'order' => 'ASC'
                    ],
                ); ?>
            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>