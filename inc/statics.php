<?php
/**
 * Define theme path
 */
define('DV_SCRIPT_SUFFIX', 'false' ); // 'true' or 'false' type string
define('DV_THEME_VER', '1.6');
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
	wp_enqueue_script('slick-carousel-script', get_template_directory_uri() . '/assets/slick/slick.min.js', array(), DV_THEME_VER, true);

    // Main style
    // wp_enqueue_style('custom-style', get_template_directory_uri() . '/assets/css/custom.css?r=' . DV_THEME_VER);
    wp_enqueue_style('main-style', get_template_directory_uri() . '/assets/css/main'.dv_suffix().'.css?r=' . DV_THEME_VER);

    // Main script
	wp_enqueue_script('main-script', get_template_directory_uri() . '/assets/js/main'.dv_suffix().'.js', array(), DV_THEME_VER, true);
	wp_enqueue_script('custom-script', get_template_directory_uri() . '/assets/js/custom.js', array(), DV_THEME_VER, true);
    
    // Localize admin ajax
    wp_localize_script(
        'main-script',
        'ajax_object',
        array( 
            'ajax_url' => admin_url('admin-ajax.php'),
        )
    );

    // Member login script
	wp_enqueue_script('member-login', get_template_directory_uri() . '/assets/js/member-login'.dv_suffix().'.js', array(), DV_THEME_VER, false);

    // Salesforce Community Url
    $sf_community_url = get_field('salesforce_community_url', 'option');
    // Member Sign up
    $member_sign_up = get_field('member_sign_up', 'option');
    $member_sign_up_link = !empty($member_sign_up['page_link']) ? $member_sign_up['page_link'] : '/sign-up-as-member';
    // Member Login
    $member_login = get_field('member_login', 'option');
    $member_login_link = !empty($member_login['login_page']) ? $member_login['login_page'] : '/member-login';
    // Member Logged in
    $member_logged_in = get_field('member_logged_in', 'option');
    $member_hub_link = !empty($member_logged_in['member_page']) ? $member_logged_in['member_page'] : '/members-hub';
    // Member Content
    $member_content = get_field('member_content', get_the_ID());
    $is_member_content = ($member_content == true) ? $member_content : 0;
    // Localize member login data
    wp_localize_script(
        'member-login',
        'member_login_data',
        array( 
            'isMemberContent'  => $is_member_content,
            'isSearchPage'     => is_search(),
            'memberHubLink'    => $member_hub_link,
            'memberLoginLink'  => $member_login_link,
            'memberSignUpLink' => $member_sign_up_link,
            'postTypeName'     => get_post_type(),
            'sfCommunityUrl'   => $sf_community_url,
            'siteHomeUrl'      => home_url(),
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