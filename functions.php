<?php
/**
 * WP Diabetes Victoria Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 */

if ( ! function_exists( 'diabetes_victoria_styles' ) ) {
	/**
	 * Enqueue styles.
	 *
	 * @since Diabetes Victoria Theme 1.0
	 *
	 * @return void
	 */
	function diabetes_victoria_styles() {
		// Enqueue theme stylesheet.
		wp_enqueue_style( 'diabetes-victoria-style', get_template_directory_uri() . '/style.css?r=', DV_THEME_VER);
	}
    add_action( 'wp_enqueue_scripts', 'diabetes_victoria_styles' );
}

if ( ! function_exists( 'diabetes_victoria_theme_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @return void
	 */
	function diabetes_victoria_theme_setup() {

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * This theme does not use a hard-coded <title> tag in the document head,
		 * WordPress will provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Site Primary menu
		 */
		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary menu', ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
				'navigation-widgets',
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Add support for Widgets.
		add_theme_support( 'widgets' );

	}
	add_action( 'after_setup_theme', 'diabetes_victoria_theme_setup' );
}

function dv_theme_widgets_init() {
    // Register sidebar widget area
    register_sidebar( array(
        'name'          => __( 'In Your Language' ),
        'id'            => 'languages-widget',
        'description'   => 'Add widgets here to appear in Language module.',
        // 'before_widget' => '<div id="%1$s" class="widget %2$s">',
        // 'after_widget'  => '</div>',
        // 'before_title'  => '<h2 class="widget-title">',
        // 'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'dv_theme_widgets_init' );

/**
 * Custom static functions
 */
require get_template_directory() . '/inc/statics.php';

/**
 * Custom hook functions
 */
require get_template_directory() . '/inc/hooks.php';

/**
 * Custom helper functions
 */
require get_template_directory() . '/inc/helpers.php';

/**
 * Ajax functions
 */
require get_template_directory() . '/inc/ajax.php';

/**
 * DV functions
 */
require get_template_directory() . '/inc/dv-functions.php';

/**
 * CPT Public Recipes
 */
require get_template_directory() . '/inc/custom-post-types/recipes.php';

/**
 * CPT Member Recipes
 */
require get_template_directory() . '/inc/custom-post-types/member-recipes.php';

/**
 * CPT Member Articles
 */
require get_template_directory() . '/inc/custom-post-types/member-articles.php';
