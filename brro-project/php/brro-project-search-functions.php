<?php
//
// ******************************************************************************************************************************************************************** Search
// Index of Functions
//
// 1. brro_modify_search_query
//      - Modifies the main search query to include only post titles and excerpts.
//
// Search TITLE AND SUMMARY
//add_filter('posts_search', 'brro_modify_search_query', 10, 2);*****************************disabled
function brro_modify_search_query($search, $wp_query) {
    global $wpdb;
    // Only modify the main search query
    if (!is_search() || !is_main_query()) {
        return $search;
    }
    // Get the search term
    $search_term = $wp_query->query_vars['s'];
    if (empty($search_term)) {
        return $search;
    }
    // Escape the search term for use in SQL LIKE clause
    $esc_search_term = esc_sql($wpdb->esc_like($search_term));
    // Construct the search query to include only post titles and excerpts
    $search = " AND (";
    $search .= "{$wpdb->posts}.post_title LIKE '%{$esc_search_term}%'";
    $search .= " OR {$wpdb->posts}.post_excerpt LIKE '%{$esc_search_term}%'";
    $search .= ")";
    return $search;
}