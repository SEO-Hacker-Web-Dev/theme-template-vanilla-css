<?php
/**
 * Universal Pagination Component
 * Usage: Place this file in your theme and include it in your loop templates.
 * Example: get_template_part('templates/pagination');
 */

if ( ! isset( $wp_query ) ) {
    global $wp_query;
}

$total_pages = $wp_query->max_num_pages;
$current_page = max( 1, get_query_var( 'paged' ) );

if ( $total_pages > 1 ) : ?>
    <nav class="pagination" role="navigation" aria-label="Pagination">
        <?php
        echo paginate_links( array(
            'base'      => get_pagenum_link( 1 ) . '%_%',
            'format'    => ( get_option('permalink_structure') ? 'page/%#%/' : '&paged=%#%' ),
            'current'   => $current_page,
            'total'     => $total_pages,
            'prev_text' => __('« Prev'),
            'next_text' => __('Next »'),
            'type'      => 'list',
        ) );
        ?>
    </nav>
<?php endif; ?>