<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body <?php body_class(); ?>>
    <header class="site-header">
        <div class="site-branding">
            <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
            <p class="site-description"><?php bloginfo('description'); ?></p>
        </div>
        <nav class="site-navigation">
            <?php
            wp_nav_menu(array(
                'menu' => 'Main Menu',
                'menu_class' => 'flex flex-col lg:flex-row lg:space-x-8 rtl:space-x-reverse',
                'container' => false,
                'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                'walker' => new class extends Walker_Nav_Menu {
                    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
                    {
                        $li_classes = empty($item->classes) ? array() : (array) $item->classes;
                        $li_classes[] = 'py-[10px] lg:py-[38px] relative';
                        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($li_classes), $item, $args, $depth));
                        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
                        $output .= '<li' . $class_names . '>';
                        $atts = array();
                        $atts['title']  = ! empty($item->attr_title) ? $item->attr_title : '';
                        $atts['target'] = ! empty($item->target)     ? $item->target     : '';
                        $atts['rel']    = ! empty($item->xfn)        ? $item->xfn        : '';
                        $atts['href']   = ! empty($item->url)        ? $item->url        : '';
                        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);
                        $attributes = '';
                        foreach ($atts as $attr => $value) {
                            if (! empty($value)) {
                                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                                $attributes .= ' ' . $attr . '="' . $value . '"';
                            }
                        }
                        $title = apply_filters('the_title', $item->title, $item->ID);
                        $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);
                        $item_output = $args->before;
                        $item_output .= '<a' . $attributes . '>';
                        $item_output .= $args->link_before . $title . $args->link_after;
                        $item_output .= '</a>';
                        $item_output .= $args->after;
                        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
                    }
                    function end_el(&$output, $item, $depth = 0, $args = null)
                    {
                        $output .= "</li>\n";
                    }
                }
            ));
            ?>
        </nav>
    </header>