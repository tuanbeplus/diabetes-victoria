<?php 
/**
 * Add file SVG type to WP upload media
 */
function dv_custom_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'dv_custom_mime_types');

/**
 * Custom WP query on search page
 */
function dv_custom_search_posts_per_page($query) {
    // Check if this is the search page and the main query
    if (is_search() && $query->is_main_query()) {
        // Modify the query as per your requirements
        $query->set('posts_per_page', 6);
    }
}
add_action('pre_get_posts', 'dv_custom_search_posts_per_page');

/**
 * Remove the editor from page
 */
add_action( 'init', function() {
    remove_post_type_support( 'page', 'editor' );
    // remove_post_type_support( 'post', 'editor' );
}, 99);

/**
 * Strip HTML tag attr on save post
 */
function dv_strip_html_attributes_on_save($post_id) {
    // Check if this is an autosave, if so, return.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    // Get the post content
    if (isset($_POST['post_content']) && !empty($_POST['post_content'])) {
        // Clean html
        $clean_content = preg_replace_callback(
            '/<(thead|tbody|tr|th|td|p|ul|ol|script|span)([^>]*)>/',
            function ($matches) {
                // For <script> tags, return an empty string to remove them completely
                if ($matches[1] === 'script') {
                    return '';
                } else {
                    return "<{$matches[1]}>";
                }
            },
            $_POST['post_content']
        );

        // Update the post content
        remove_action('save_post', 'dv_strip_html_attributes_on_save'); // Unhook to avoid infinite loop
        wp_update_post(array(
            'ID'           => $post_id,
            'post_content' => $clean_content,
        ));
        add_action('save_post', 'dv_strip_html_attributes_on_save'); // Re-hook the function
    }
}
add_action('save_post', 'dv_strip_html_attributes_on_save');

