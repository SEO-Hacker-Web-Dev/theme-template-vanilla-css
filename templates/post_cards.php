<?php
$title = isset($args['title']) ? $args['title'] : '';
$link = isset($args['link']) ? $args['link'] : '';
$excerpt = isset($args['excerpt']) ? $args['excerpt'] : '';
$img = isset($args['img']) ? $args['img'] : '';
$date = isset($args['date']) ? $args['date'] : get_the_date();
?>
<div class="col-lg-4 col-md-6">
    <div class="blog_content" onclick="window.location.href='<?= $link ?>'">
        <div class="image relative">
            <?php
            get_template_part('templates/image', null, [
                'src' => $img,
                'alt' => $title,
                'class' => 'w-100',
            ]);
            ?>
        </div>
        <div class="main_content">
            <p class="date"><?= $date; ?></p>
            <h3 class="title"><?= $title ?></h3>
            <?= $excerpt ?>
            <?php
            get_template_part('templates/link_btn', null, [
                'url' => $link,
                'text' => 'Read More',
                'target' => '_blank',
                'rel' => 'noopener noreferrer',
                'class' => '',
            ]);
            ?>
        </div>
    </div>
</div>