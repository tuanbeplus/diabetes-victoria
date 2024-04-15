<?php
/**
 * The template for displaying all pages
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

get_header(); 
    // check if the flexible content field has rows of data
    if( have_rows('page_builder') ):
        // loop through the rows of data
        while ( have_rows('page_builder') ) : the_row();

            get_template_part('modules/hero-carousel');
            get_template_part('modules/key-cards');
            get_template_part('modules/content-promo');
            get_template_part('modules/latest-posts');
            get_template_part('modules/partner-logos');

        endwhile;

    else:
        // no layouts found
    endif;

get_footer();