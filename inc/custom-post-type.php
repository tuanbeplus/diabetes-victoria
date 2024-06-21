<?php
/*
 * Resources CPT
 */

function dv_resources_register() {

	$cpt_slug = get_theme_mod('dv_resource_slug');

	if(isset($cpt_slug) && $cpt_slug != ''){
		$cpt_slug = $cpt_slug;
	} else {
		$cpt_slug = 'resource';
	}

	$labels = array(
		'name'               => esc_html__( 'Resources', 'diabetes-victoria' ),
		'singular_name'      => esc_html__( 'Resource', 'diabetes-victoria' ),
		'add_new'            => esc_html__( 'Add New', 'diabetes-victoria' ),
		'add_new_item'       => esc_html__( 'Add New Resource', 'diabetes-victoria' ),
		'all_items'          => esc_html__( 'All Resource', 'diabetes-victoria' ),
		'edit_item'          => esc_html__( 'Edit Resource', 'diabetes-victoria' ),
		'new_item'           => esc_html__( 'Add New Resource', 'diabetes-victoria' ),
		'view_item'          => esc_html__( 'View Item', 'diabetes-victoria' ),
		'search_items'       => esc_html__( 'Search Resource', 'diabetes-victoria' ),
		'not_found'          => esc_html__( 'No Resource(s) found', 'diabetes-victoria' ),
		'not_found_in_trash' => esc_html__( 'No Resource(s) found in trash', 'diabetes-victoria' )
	);

  	$args = array(
		'labels'          => $labels,
		'public'          => true,
		'show_ui'         => true,
		'capability_type' => 'post',
		'hierarchical'    => false,
		'menu_icon'       => 'dashicons-book',
		'rewrite'         => array('slug' => $cpt_slug), // Permalinks format
		'supports'        => array('title', 'editor', 'thumbnail', 'author', 'comments', 'custom-fields')
  	);

  add_filter( 'enter_title_here',  'dv_recipe_change_default_title');

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
			"hierarchical"   => true,
			"label"          => __( 'Categories', 'diabetes-victoria' ),
			'singular_name' => __( 'Category', 'diabetes-victoria' ),
			"rewrite"        => true,
            'query_var'     => true
		)
	);

}
add_action('init', 'dv_resources_taxonomy', 0);