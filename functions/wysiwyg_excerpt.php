<?php
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