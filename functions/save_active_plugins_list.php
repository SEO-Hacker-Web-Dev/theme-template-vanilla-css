<?php

function save_active_plugins_list()
{
    $active_plugins = get_option('active_plugins');
    if (is_multisite()) {
        $network_plugins = get_site_option('active_sitewide_plugins');
        if ($network_plugins && is_array($network_plugins)) {
            $active_plugins = array_merge($active_plugins, array_keys($network_plugins));
        }
    }
    $plugin_names = array();
    foreach ($active_plugins as $plugin_file) {
        $plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/' . $plugin_file, false, false);
        $plugin_names[] = $plugin_data['Name'] ?? $plugin_file;
    }
    $output = implode(PHP_EOL, $plugin_names);
    $file = get_template_directory() . '/plugin.txt';
    file_put_contents($file, $output);
}
add_action('admin_init', 'save_active_plugins_list');