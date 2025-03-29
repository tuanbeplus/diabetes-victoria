<?php
/**
 * The template for displaying all Pages, Post
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 */

$brand_color = get_field('brand_color');
$brand_color = !empty($brand_color) ? $brand_color : '';
$sub_brand_color = !empty($brand_color) ? '#fff' : '';
$bg_color = get_field('background_color');
$bg_color = !empty($bg_color) ? $bg_color : '';

get_header(); 
    // Post brand css variable
    echo '<style> html {';
        if (!empty($brand_color)) echo '--post-brand-color: '. $brand_color .';';
        if (!empty($sub_brand_color)) echo '--post-sub-brand-color: '. $sub_brand_color .';';
        if (!empty($bg_color)) echo '--post-bg-color: '. $bg_color .';';
    echo '} </style>';
    // Post Title
    if (is_singular() && !is_front_page()) {
        echo '<section class="post-title">
                <div class="container">
                    <h1>'. get_the_title() .'</h1>
                </div>
            </section>';
    }
    // check if the flexible content field has rows of data
    if( have_rows('page_builder') ):
        // loop through the rows of data
        while ( have_rows('page_builder') ) : the_row();

            get_template_part('modules/hero-carousel');
            get_template_part('modules/key-cards');
            get_template_part('modules/content-promo');
            get_template_part('modules/latest-posts');
            get_template_part('modules/partner-logos');
            get_template_part('modules/faqs');
            get_template_part('modules/icon-promo-carousel');
            get_template_part('modules/media-slider');
            get_template_part('modules/bespoke-slider');
            get_template_part('modules/main-content');
            get_template_part('modules/contact-us');
            get_template_part('modules/search-form');
            get_template_part('modules/members-list');
            get_template_part('modules/single-column-content');
            get_template_part('modules/jotform-embed');
            get_template_part('modules/user-profile');
            get_template_part('modules/promo-slider');

        endwhile;

    else:
        // no layouts found
        echo '<div class="no-layouts"></div>';
    endif;

get_footer();