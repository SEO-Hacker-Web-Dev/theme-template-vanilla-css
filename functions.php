<?php
/**
 * functions.php
 *
 * Contains theme or plugin custom functions, hooks, and filters for WordPress.
 * Use this file to add custom PHP code to extend or modify WordPress functionality.
 *
 * @package YourThemeOrPluginName
 */
require_once get_template_directory() . '/functions/theme_setup.php';
require_once get_template_directory() . '/functions/loadmore.php';
require_once get_template_directory() . '/functions/prevent_duplicate_media_upload.php';
require_once get_template_directory() . '/functions/remove_br_cf7.php';
require_once get_template_directory() . '/functions/enqueue_style.php';
require_once get_template_directory() . '/functions/remove_br_from_content.php';
require_once get_template_directory() . '/functions/wysiwyg_excerpt.php';
require_once get_template_directory() . '/functions/save_active_plugins_list.php';
require_once get_template_directory() . '/functions/dequeue_wp_block_library_css.php';
require_once get_template_directory() . '/functions/minify_html_output.php';