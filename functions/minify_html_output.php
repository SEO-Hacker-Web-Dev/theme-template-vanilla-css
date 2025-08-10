<?php
function minify_html_output($buffer)
{
    if (preg_match('/<html[^>]*>(.*?)<\/body>/is', $buffer, $matches)) {
        $body_content = $matches[1];

        // Minify the body content
        $minified = preg_replace([
            '/\>[^\S ]+/s',    // strip whitespaces after tags, except space
            '/[^\S ]+\</s',    // strip whitespaces before tags, except space
            '/(\s)+/s'         // shorten multiple whitespace sequences
        ], ['>', '<', '\\1'], $body_content);

        // Replace original with minified content
        $buffer = str_replace($matches[1], $minified, $buffer);
    }

    return $buffer;
}

function start_html_minify()
{
    ob_start('minify_html_output');
}
add_action('template_redirect', 'start_html_minify');
