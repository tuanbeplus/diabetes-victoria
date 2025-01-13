<?php
/*
 * Recipe CPT
 */

function dv_recipe_register() {

	$cpt_slug = get_theme_mod('dv_recipe_slug');

	if(isset($cpt_slug) && $cpt_slug != ''){
		$cpt_slug = $cpt_slug;
	} else {
		$cpt_slug = 'recipes';
	}

	$labels = array(
		'name'               => esc_html__( 'Recipes', 'diabetes-victoria' ),
		'singular_name'      => esc_html__( 'Recipe', 'diabetes-victoria' ),
		'add_new'            => esc_html__( 'Add New', 'diabetes-victoria' ),
		'add_new_item'       => esc_html__( 'Add New Recipe', 'diabetes-victoria' ),
		'all_items'          => esc_html__( 'All Recipes', 'diabetes-victoria' ),
		'edit_item'          => esc_html__( 'Edit Recipe', 'diabetes-victoria' ),
		'new_item'           => esc_html__( 'Add New Recipe', 'diabetes-victoria' ),
		'view_item'          => esc_html__( 'View Item', 'diabetes-victoria' ),
		'search_items'       => esc_html__( 'Search Recipes', 'diabetes-victoria' ),
		'not_found'          => esc_html__( 'No recipe(s) found', 'diabetes-victoria' ),
		'not_found_in_trash' => esc_html__( 'No recipe(s) found in trash', 'diabetes-victoria' )
	);

  	$args = array(
		'labels'          => $labels,
		'public'          => true,
		'show_ui'         => true,
		'capability_type' => 'post',
		'hierarchical'    => false,
		'menu_icon'       => 'dashicons-book',
		'rewrite'         => array('slug' => $cpt_slug), // Permalinks format
		'supports'        => array('title', 'editor', 'thumbnail', 'author', 'custom-fields')
  	);

  register_post_type( 'recipe' , $args );
}
add_action('init', 'dv_recipe_register', 1);

/**
 * Register Recipe taxonomy
 * 
 */
function dv_recipe_taxonomy() {

	register_taxonomy(
		"recipe_categories",
		array("recipe"),
		array(
			"hierarchical"   => true,
			"label"          => "Categories",
			"singular_label" => "Category",
			"rewrite"        => true
		)
	);

}
add_action('init', 'dv_recipe_taxonomy', 1);

/**
 * Add custom columns to Recipe table
 * 
 */
function dv_custom_recipe_columns($columns)
{
	$columns['thumbnail'] = 'Thumbnail';
	$columns['recipe_categories'] = 'Categories';
	return $columns;
}
add_filter('manage_recipe_posts_columns', 'dv_custom_recipe_columns');

/**
 * Display value of custom colums at Recipe table
 * 
 */
function dv_recipe_column_display( $recipe_columns, $post_id ) {

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

		if ( $category_list = get_the_term_list( $post_id, 'recipe_categories', '', ', ', '' ) ) {
			echo $category_list; // No need to escape
		} else {
			echo esc_html__('None', 'diabetes-victoria');
		}
		break;
	}
}
add_action( 'manage_recipe_posts_custom_column', 'dv_recipe_column_display', 10, 2 );
