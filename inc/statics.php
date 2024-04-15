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

    // Owl Carousel
	wp_enqueue_style('owl-carousel-style', get_template_directory_uri() . '/assets/owl-carousel/owl.carousel.css?r=' . DV_THEME_VER);
	wp_enqueue_script('owl-carousel-script', get_template_directory_uri() . '/assets/owl-carousel/owl.carousel.min.js', array(), DV_THEME_VER, true);

    // Main style
    wp_enqueue_style('main-style', get_template_directory_uri() . '/assets/css/main.css?r=' . DV_THEME_VER);

    // Main script
	wp_enqueue_script('main-script', get_template_directory_uri() . '/assets/js/main.bundle.js', array(), DV_THEME_VER, true);
    
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