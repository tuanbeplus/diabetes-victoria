<?php
/**
 * Define theme path
 */
define('DV_THEME_VER', rand());
define('DV_IMG_DIR', get_template_directory_uri() . '/assets/imgs/');

/**
 * DV enqueue scripts and stylesheet
 */
add_action('wp_enqueue_scripts', 'dv_enqueue_scripts');
function dv_enqueue_scripts()
{   
    // jQuery
    wp_enqueue_script('jquery');

    // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css');

    // Slick Carousel
    wp_enqueue_style('slick-carousel-style', get_template_directory_uri() . '/assets/slick/slick.css?r=' . DV_THEME_VER);
	wp_enqueue_script('slick-carousel-script', get_template_directory_uri() . '/assets/slick/slick.min.js', array(), DV_THEME_VER, false);

    // Main style
    wp_enqueue_style('main-style', get_template_directory_uri() . '/assets/css/main.css?r=' . DV_THEME_VER);
    wp_enqueue_style('custom-style', get_template_directory_uri() . '/assets/css/custom.css?r=' . DV_THEME_VER);

    // Main script
	wp_enqueue_script('main-script', get_template_directory_uri() . '/assets/js/main.bundle.js', array(), DV_THEME_VER, true);
	wp_enqueue_script('custom-script', get_template_directory_uri() . '/assets/js/custom.js', array(), DV_THEME_VER, true);
    
    // Localize admin ajax
    wp_localize_script(
        'main-script',
        'ajax_object',
        array( 
            'ajax_url' => admin_url('admin-ajax.php'),
        )
    );
}

/**
 * Admin scripts and stylesheet
 */
function dv_admin_enqueue_scripts() {
    // Admin custom style
    wp_enqueue_style('main-style', get_template_directory_uri() . '/assets/css/custom-admin.css?r=' . DV_THEME_VER);
}
add_action('admin_enqueue_scripts', 'dv_admin_enqueue_scripts');