<?php
function remove_br_from_cf7_form($form)
{

    $form = str_replace('<br>', '', $form);
    $form = str_replace('<br />', '', $form);
    return $form;
}
add_filter('wpcf7_form_elements', 'remove_br_from_cf7_form');

add_filter('wpcf7_autop_or_not', '__return_false');