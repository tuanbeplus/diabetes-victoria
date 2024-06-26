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
}, 99);

/**
 * Customize the Post
 */
add_filter('register_post_type_args', function ($args, $post_type) {
    if ($post_type === 'post') {
        $args['labels']['name'] = 'Blogs';
    }
    return $args;
}, 10, 2);

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

/**
 * Add custom columns to Blogs table
 */
function dv_custom_blog_columns($columns)
{
	$columns['thumbnail'] = 'Thumbnail';
	return $columns;
}
add_filter('manage_post_posts_columns', 'dv_custom_blog_columns');

/**
 * Display value of custom colums at Blogs table
 */
function dv_blog_columns_display( $blog_columns, $post_id ) {

	switch ( $blog_columns ) {
		// Display the thumbnail in the column view
		case "thumbnail":
			$width = (int) 64;
			$height = (int) 64;
			$thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );

			// Display the featured image in the column view if possible
			if ( $thumbnail_id ) {
				$thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
			}
			if ( isset( $thumb ) ) {
				echo $thumb; // No need to escape
			} else {
				echo esc_html__('None', 'diabetes-victoria');
			}
		break;
	}
}
add_action( 'manage_post_posts_custom_column', 'dv_blog_columns_display', 10, 2 );

