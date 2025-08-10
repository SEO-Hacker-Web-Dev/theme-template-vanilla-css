<?php
/**
 * Template for an SEO-friendly link button.
 *
 * Usage:
 * get_template_part('templates/link_btn', null, [
 *     'url' => 'https://example.com',
 *     'text' => 'Visit Example',
 *     'target' => '_blank', // optional
 *     'rel' => 'noopener',  // optional
 *     'class' => 'btn btn-primary', // optional
 * ]);
 */

$args = wp_parse_args($args ?? [], [
    'url'    => '#',
    'text'   => 'Learn More',
    'target' => '',
    'rel'    => '',
    'class'  => 'link-btn',
]);

// Add rel="noopener noreferrer" for external links with target _blank
if ($args['target'] === '_blank' && empty($args['rel'])) {
    $args['rel'] = 'noopener noreferrer';
}
?>
<a
    href="<?php echo esc_url($args['url']); ?>"
    <?php if (!empty($args['target'])) : ?>target="<?php echo esc_attr($args['target']); ?>"<?php endif; ?>
    <?php if (!empty($args['rel'])) : ?>rel="<?php echo esc_attr($args['rel']); ?>"<?php endif; ?>
    class="<?php echo esc_attr($args['class']); ?>"
>
    <?php echo esc_html($args['text']); ?>
</a>