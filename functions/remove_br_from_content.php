<?php
function remove_br_from_content($content)
{
    $content = str_replace('<br>', '', $content);
    $content = str_replace('<br />', '', $content);
    return $content;
}
add_filter('the_content', 'remove_br_from_content');