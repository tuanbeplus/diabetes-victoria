<?php 
/**
 * Add file SVG type to WP upload media
 * 
 */
function dv_custom_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
  }
add_filter('upload_mimes', 'dv_custom_mime_types');

/**
 * Custom WP query on search page
 * 
 */
function dv_custom_search_query($query) {
  // Check if this is the search page and the main query
  if (is_search() && $query->is_main_query()) {
    // Modify the query as per your requirements
    $query->set('posts_per_page', 3);
  }
}
add_action('pre_get_posts', 'dv_custom_search_query');