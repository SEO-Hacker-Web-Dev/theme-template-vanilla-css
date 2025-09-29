<?php

/**
 * Image Component Template with JS fallback
 */
$default_image = get_template_directory_uri() . '/assets/images/placeholder.png';

$src    = !empty($args['src']) ? $args['src'] : $default_image;
$alt    = isset($args['alt']) ? esc_attr($args['alt']) : '';
$class  = isset($args['class']) ? esc_attr($args['class']) : '';
$width  = isset($args['width']) ? intval($args['width']) : '';
$height = isset($args['height']) ? intval($args['height']) : '';
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