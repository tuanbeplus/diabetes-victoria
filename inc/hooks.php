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
 * Google Analytics
 */
function dv_google_analytics() {
    $ga4 = get_field('google_analytics_4', 'option');

    if(!empty($ga4)) {
        echo $ga4;
    }
    
}
add_action('wp_head', 'dv_google_analytics', 1);

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
        // Labels
        $args['labels']['name']               = 'Articles';
        $args['labels']['singular_name']      = 'Article';
        $args['labels']['add_new']            = 'Add New';
        $args['labels']['add_new_item']       = 'Add New Article';
        $args['labels']['edit_item']          = 'Edit Article';
        $args['labels']['new_item']           = 'New Article';
        $args['labels']['view_item']          = 'View Article';
        $args['labels']['search_items']       = 'Search Articles';
        $args['labels']['not_found']          = 'No articles found';
        $args['labels']['not_found_in_trash'] = 'No articles found in Trash';
        $args['labels']['all_items']          = 'All Articles';
        $args['labels']['archives']           = 'Article Archives';
        $args['labels']['insert_into_item']   = 'Insert into article';
        $args['labels']['uploaded_to_this_item'] = 'Uploaded to this article';
        $args['labels']['filter_items_list']  = 'Filter articles list';
        $args['labels']['items_list_navigation'] = 'Articles list navigation';
        $args['labels']['items_list']         = 'Articles list';

        // Rewrite
        $args['rewrite']['slug'] = 'articles';
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
//add_action('save_post', 'dv_strip_html_attributes_on_save');

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


function dv_add_member_role() {
    add_role(
        'dv_member',
        __('Diabetes Victoria Member'),
    );
}
add_action('init', 'dv_add_member_role');

function dv_hide_admin_bar_for_member_role($show) {
    if (current_user_can('dv_member')) {
        return false;
    }
    return $show;
}
add_filter('show_admin_bar', 'dv_hide_admin_bar_for_member_role');

/**
 * Customize WP admin login logo
 */
function dv_custom_wp_login_logo() { 
    ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url("<?php echo DV_IMG_DIR ?>dv-logo-full-color.png");
            width:190px;
            background-size: 190px;
            background-repeat: no-repeat;
        }
    </style>
    <?php 
}
add_action('login_enqueue_scripts', 'dv_custom_wp_login_logo');

/**
 * Change WP admin login logo URL
 */
function dv_custom_wp_login_logo_url() {
    return home_url();
}
add_filter('login_headerurl', 'dv_custom_wp_login_logo_url');
