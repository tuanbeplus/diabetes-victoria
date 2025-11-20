<?php
/*
 * Member Recipes CPT
 */

function dv_register_member_recipe_cpt() {

	$labels = array(
		'name'               => esc_html__( 'Member Recipes', 'diabetes-victoria' ),
		'singular_name'      => esc_html__( 'Member Recipe', 'diabetes-victoria' ),
		'add_new'            => esc_html__( 'Add New Member Recipe', 'diabetes-victoria' ),
		'add_new_item'       => esc_html__( 'Add New Member Recipe', 'diabetes-victoria' ),
		'all_items'          => esc_html__( 'All Member Recipes', 'diabetes-victoria' ),
		'edit_item'          => esc_html__( 'Edit Member Recipe', 'diabetes-victoria' ),
		'new_item'           => esc_html__( 'Add New Member Recipe', 'diabetes-victoria' ),
		'view_item'          => esc_html__( 'View Item', 'diabetes-victoria' ),
		'search_items'       => esc_html__( 'Search Member Recipes', 'diabetes-victoria' ),
		'not_found'          => esc_html__( 'No Member Recipe(s) found', 'diabetes-victoria' ),
		'not_found_in_trash' => esc_html__( 'No Member Recipe(s) found in trash', 'diabetes-victoria' )
	);

  	$args = array(
		'labels'          => $labels,
		'public'          => true,
		'show_ui'         => true,
		'capability_type' => 'post',
		'hierarchical'    => false,
		'menu_icon'       => 'dashicons-book-alt',
		'rewrite'         => array('slug' => 'member-recipes'), // Permalinks format
		'supports'        => array('title', 'editor', 'thumbnail', 'author', 'custom-fields')
  	);

    register_post_type( 'member_recipes' , $args );
}
add_action('init', 'dv_register_member_recipe_cpt');

/**
 * Register Member Recipes taxonomy
 * 
 */
function dv_register_member_recipes_taxonomy() {

	register_taxonomy(
		"member_recipe_cat",
		array("member_recipes"),
		array(
			"hierarchical"   => true,
			"label"          => "Member Recipes Categories",
			"singular_label" => "Member Recipes Category",
			"rewrite"        => true,
		)
	);

}
add_action('init', 'dv_register_member_recipes_taxonomy');

/**
 * Add custom columns to Member Recipes table
 * 
 */
function dv_custom_member_recipes_columns($columns)
{
	$columns['thumbnail'] = 'Thumbnail';
	$columns['recipe_categories'] = 'Categories';
	return $columns;
}
add_filter('manage_member_recipes_posts_columns', 'dv_custom_member_recipes_columns', 1);

/**
 * Display value of custom colums at Member Recipes table
 * 
 */
function dv_member_recipes_column_display( $recipe_columns, $post_id ) {

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
		case "recipe_categories":

		if ( $category_list = get_the_term_list( $post_id, 'member_recipe_cat', '', ', ', '' ) ) {
			echo $category_list; // No need to escape
		} else {
			echo esc_html__('None', 'diabetes-victoria');
		}
		break;
	}
}
add_action( 'manage_member_recipes_posts_custom_column', 'dv_member_recipes_column_display', 10, 2 );
