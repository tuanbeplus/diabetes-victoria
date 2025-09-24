<?php
/**
 * Define theme path
 */
define('DV_THEME_VER', '2.1.0');
define('DV_IMG_DIR', get_template_directory_uri() . '/assets/imgs/');

/**
 * DV enqueue scripts and stylesheet
 */
add_action('wp_enqueue_scripts', 'dv_enqueue_scripts');
function dv_enqueue_scripts() {   
    // jQuery
    wp_enqueue_script('jquery');
    // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css');
    // Slick Carousel
    wp_enqueue_style('slick-style', get_template_directory_uri() . '/assets/slick/slick.css?r=' . DV_THEME_VER);
	wp_enqueue_script('slick-script', get_template_directory_uri() . '/assets/slick/slick.min.js', array(), DV_THEME_VER, true);
    // Main style
    wp_enqueue_style('main-style', get_template_directory_uri() . '/assets/css/main.bundle.css?r=' . DV_THEME_VER);
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
    // Member login script
	wp_enqueue_script('member-login', get_template_directory_uri() . '/assets/js/member-login.bundle.js', array(), DV_THEME_VER, false);

    // Salesforce Community Url
    $sf_community_url = get_field('salesforce_community_url', 'option');
    
    // New ACF fields for member login flow
    $members_login = get_field('members_login', 'option');
    $members_sign_up = get_field('members_sign_up', 'option');
    $members_hub = get_field('members_hub', 'option');
    $members_hub_free = get_field('members_hub_free', 'option');
    $renew_membership = get_field('renew_membership', 'option');
    $join_membership = get_field('join_membership', 'option');
    
    // Fallback values
    $member_login_link = !empty($members_login['url']) ? $members_login['url'] : '/member-login/';
    $member_hub_link = !empty($members_hub['url']) ? $members_hub['url'] : '/members-hub/';
    $member_hub_free_link = !empty($members_hub_free['url']) ? $members_hub_free['url'] : '/members-hub-free-test/';
    $renew_membership_link = !empty($renew_membership['url']) ? $renew_membership['url'] : '/renew-membership/';
    $join_membership_link = !empty($join_membership['url']) ? $join_membership['url'] : '/join-membership/';
    
    // Member Content
    $member_content = get_field('member_content', get_the_ID());
    $is_member_content = ($member_content == true) ? true : false;
    // Content access rule (ACF option): 'full_member_only' | 'full_and_free_member'
    $content_for_member_type = get_field('content_for_member_type', get_the_ID());
    $content_for_member_type = $content_for_member_type ? $content_for_member_type : 'full_and_free_member';
    // Localize member login data
    wp_localize_script(
        'member-login',
        'member_login_data',
        array( 
            'isMemberContent'  => $is_member_content,
            'isSearchPage'     => is_search(),
            'postTypeName'     => get_post_type(),
            'sfCommunityUrl'   => $sf_community_url,
            'siteHomeUrl'      => home_url(),
            'contentForMemberType' => $content_for_member_type,
            // New ACF field data
            'membersLogin'     => $members_login,
            'membersSignUp'    => $members_sign_up,
            'membersHub'       => $members_hub,
            'membersHubFree'   => $members_hub_free,
            'renewMembership'  => $renew_membership,
            'joinMembership'   => $join_membership,
            // Fallback URLs for backward compatibility
            'memberHubLink'    => $member_hub_link,
            'memberLoginLink'  => $member_login_link,
            'memberHubFreeLink' => $member_hub_free_link,
            'renewMembershipLink' => $renew_membership_link,
            'joinMembershipLink' => $join_membership_link,
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