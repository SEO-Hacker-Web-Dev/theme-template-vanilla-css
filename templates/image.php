<?php

/**
 * Image Component Template with JS fallback
 */

$src    = isset($args['src']) ? $args['src'] : '';
$alt    = isset($args['alt']) ? esc_attr($args['alt']) : '';
$class  = isset($args['class']) ? esc_attr($args['class']) : '';
$width  = isset($args['width']) ? intval($args['width']) : '';
$height = isset($args['height']) ? intval($args['height']) : '';

$default_image = get_stylesheet_directory_uri() . '/assets/img/global/header_logo.png';
?>

<img
    loading="lazy"
    src="<?php echo esc_url($src); ?>"
    alt="<?php echo $alt; ?>"
    title="<?php echo $alt; ?>"
    onerror="this.onerror=null;this.src='<?php echo esc_url($default_image); ?>';"
    <?php if ($class) : ?>class="<?php echo $class; ?>" <?php endif; ?>
    <?php if ($width) : ?>width="<?php echo $width; ?>" <?php endif; ?>
    <?php if ($height) : ?>height="<?php echo $height; ?>" <?php endif; ?> />