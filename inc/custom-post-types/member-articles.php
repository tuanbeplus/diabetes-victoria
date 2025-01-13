<?php
/*
 * Resources CPT
 */

function dv_resources_register() {

	$cpt_slug = get_theme_mod('dv_resource_slug');

	if(isset($cpt_slug) && $cpt_slug != ''){
		$cpt_slug = $cpt_slug;
	} else {
		$cpt_slug = 'member-articles';
	}

	$labels = array(
		'name'               => esc_html__( 'Member Articles', 'diabetes-victoria' ),
		'singular_name'      => esc_html__( 'Member Article', 'diabetes-victoria' ),
		'add_new'            => esc_html__( 'Add New', 'diabetes-victoria' ),
		'add_new_item'       => esc_html__( 'Add New Article', 'diabetes-victoria' ),
		'all_items'          => esc_html__( 'All Member Articles', 'diabetes-victoria' ),
		'edit_item'          => esc_html__( 'Edit Article', 'diabetes-victoria' ),
		'new_item'           => esc_html__( 'Add New Article', 'diabetes-victoria' ),
		'view_item'          => esc_html__( 'View Item', 'diabetes-victoria' ),
		'search_items'       => esc_html__( 'Search Articles', 'diabetes-victoria' ),
		'not_found'          => esc_html__( 'No Resource(s) found', 'diabetes-victoria' ),
		'not_found_in_trash' => esc_html__( 'No Resource(s) found in trash', 'diabetes-victoria' )
	);

  	$args = array(
		'labels'          => $labels,
		'public'          => true,
		'show_ui'         => true,
		'capability_type' => 'post',
		'hierarchical'    => false,
		'menu_icon'       => 'dashicons-admin-post',
		'rewrite'         => array('slug' => $cpt_slug), // Permalinks format
		'supports'        => array('title', 'editor', 'thumbnail', 'author', 'custom-fields')
  	);

  register_post_type( 'resource' , $args );
}
add_action('init', 'dv_resources_register', 0);

/**
 * Register Resources taxonomy
 * 
 */
function dv_resources_taxonomy() {

	register_taxonomy(
		"resource_categories",
		array("resource"),
		array(
			'hierarchical'  => true,
			'label'         => __( 'Categories', 'diabetes-victoria' ),
			'singular_name' => __( 'Category', 'diabetes-victoria' ),
			'rewrite' 		=> array('slug' => 'member_articles_cat'),
            'query_var'     => true
		)
	);

}
add_action('init', 'dv_resources_taxonomy');

/**
 * Add custom columns to post type resource table
 * 
 */
function dv_custom_post_typed_resource_columns($columns)
{
	unset($columns['comments']);
	unset($columns['date']);
	$columns['thumbnail'] = __( 'Thumbnail', 'diabetes-victoria' );
	$columns['resource_categories'] = __( 'Categories', 'diabetes-victoria' );
	$columns['date'] = 'Date';

	return $columns;
}
add_filter('manage_resource_posts_columns', 'dv_custom_post_typed_resource_columns');

/**
 * Display value of custom colums at post type table
 * 
 */
function dv_post_type_resource_column_display( $recipe_columns, $post_id ) {

	switch ( $recipe_columns ) {
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

		// Display the recipe tags in the column view
		case "resource_categories":

		if ( $category_list = get_the_term_list( $post_id, 'resource_categories', '', ', ', '' ) ) {
			echo $category_list; // No need to escape
		} else {
			echo esc_html__('None', 'diabetes-victoria');
		}
		break;
	}
}
add_action( 'manage_resource_posts_custom_column', 'dv_post_type_resource_column_display', 10, 2 );