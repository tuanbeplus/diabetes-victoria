<?php 
/**
 * Get icon SVG file content
 * 
 * @param $icon_file_name   File name
 * 
 * @return Content file svg
 * 
 */
function dv_get_icon_svg($icon_file_name) {
    if ($icon_file_name) {
        return file_get_contents(DV_IMG_DIR . $icon_file_name.'.svg');
    }
    else {
        return 'File not found!';
    }
}

/**
 * Get all publish posts, page, post type
 * 
 * @param $post_type      Post type
 * @param $number_posts   Number of post to show
 * @param $order_by       Ascending/Descending
 * 
 * @return Posts object
 * 
 */
function dv_get_latest_posts($post_type, $paged, $number_posts, $order_by) {
    $args = array(
		'post_type' => $post_type,
		'paged' => $paged,
		'posts_per_page' => $number_posts,
		'post_status' => 'publish',
		'orderby' => 'date',
		'order' => $order_by,
	);
	$posts = get_posts($args);

    return $posts;
}

/**
 * DV Breadcrumb Navigation Function
 * 
 */
function dv_breadcrumb() {
	global $post;
	$arrow_right = '<span class="arrow"> &gt; </span>';
	
	if (is_front_page() || is_404()) {
		return;
	}
	
	echo '<nav aria-label="Breadcrumbs" class="breadcrumb">';
	echo '  <ol class="breadcrumb-list">';
	echo '    <li><a href="' . esc_url(home_url()) . '">Home</a></li>' . $arrow_right;
	
	if (is_archive()) {
		$post_type = get_post_type_object(get_post_type());
		if ($post_type) {
			if ($post_type->name == 'post') {
				echo '<li><a href="' . home_url('/blogs') . '">' . esc_html($post_type->label) . '</a></li>' . $arrow_right;
			}
			else {
				echo '<li><a href="' . home_url('/' . $post_type->name . '/') . '">' . esc_html($post_type->label) . '</a></li>' . $arrow_right;
			}
		}
		the_archive_title('<li aria-current="page"><span>', '</span></li>');
	} 
	elseif (is_single()) {
		$post_type = get_post_type_object(get_post_type());
		if ($post_type) {
			if ($post_type->name == 'post') {
				echo '<li><a href="' . home_url('/blogs') . '">' . esc_html($post_type->label) . '</a></li>' . $arrow_right;
			}
			else {
				echo '<li><a href="' . home_url('/' . $post_type->name . '/') . '">' . esc_html($post_type->label) . '</a></li>' . $arrow_right;
			}
		}
		echo '<li aria-current="page"><span>' . esc_html(get_the_title()) . '</span></li>';
	} 
	elseif (is_page()) {
		if ($post->post_parent) {
			$ancestors = array_reverse(get_post_ancestors($post->ID));
			foreach ($ancestors as $ancestor) {
				echo '<li><a href="' . esc_url(get_permalink($ancestor)) . '">' . esc_html(get_the_title($ancestor)) . '</a></li>' . $arrow_right;
			}
		}
		echo '<li aria-current="page"><span>' . esc_html(get_the_title()) . '</span></li>';
	} 
	elseif (is_search()) {
		echo '<li aria-current="page"><span>Search results for: ' . esc_html(get_search_query()) . '</span></li>';
	}
	
	echo '  </ol>';
	echo '</nav>';
}


/**
 * Remove attributes from tags in HTML string
 * 
 * @param string $html_string    HTML string
 *
 * @return String Clean HTML string
 * 
 */
function dv_clean_html_content_editor($html_string) {
//     $clean_html = preg_replace_callback(
//         '/<(table|tbody|tr|th|td|p|ul|ol|span)([^>]*)>/',
//         function ($matches) {
//             return "<{$matches[1]}>";
//         },
//         $html_string
//     );
	
    return $html_string;
}

/**
 * Get the Summary from content of Post, Page, Custom post type
 * 
 * @param string/int $post_id    Post ID
 *
 * @return String the Summary
 * 
 */
function dv_get_post_summary($post_id) {
	// Get ACF page builder
	$page_builder = get_field('page_builder');
	$post_content = get_the_content($post_id);
	$summary = '';
	$summary .= $post_content;
	foreach ($page_builder as $module) {
		if ($module['acf_fc_layout'] == 'main_content') {
			$summary .= $module['content_editor'];
		}
	}
	$trim_summary = wp_trim_words( $summary , 35, ' (...)' );

	return $trim_summary;
}

/**
 * WCAG 2.0 Attributes for Dropdown Menus
 *
 * Adjustments to menu attributes tot support WCAG 2.0 recommendations
 * for flyout and dropdown menus.
 *
 * @ref https://www.w3.org/WAI/tutorials/menus/flyout/
 */
function dv_wcag_nav_menu_link_attributes( $atts, $item, $args, $depth ) {
    // Add [aria-haspopup] and [aria-expanded] to menu items that have children
    $item_has_children = in_array( 'menu-item-has-children', $item->classes );
    if ( $item_has_children ) {
        $atts['aria-haspopup'] = "true";
        $atts['aria-expanded'] = "false";
    }

    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'dv_wcag_nav_menu_link_attributes', 10, 4 );

/**
 * The thumbnail used for the post card doesn't have a thumbnail
 * 
 * @param string/int	Post ID
 * 
 * @return Html Thumbnail Image
 *
 */
function dv_the_post_thumbnail_default($post_id) {
	// Recipes
	if (get_post_type($post_id) == 'recipe') {
		echo '<img src="'.DV_IMG_DIR .'recipe-feature-img.png"
			alt="A man and woman sitting down to eat at a table set with a variety of dishes.">';
	}
	// Resources
	elseif (get_post_type($post_id) == 'resource') {
		$the_terms = get_the_terms($post_id, 'resource_categories');
		$terms_slug = array();
		if ($the_terms && ! is_wp_error( $the_terms )) {
			foreach ( $the_terms as $term ) {
				$terms_slug[] = $term->slug;
			}
		}
		// Podcasts
		if (in_array('podcasts', $terms_slug)) {
			echo '<img src="'.DV_IMG_DIR .'DVic-podcast.png" 
			alt="The official logo of the Diabetes Life Podcast">';
		}
		// Other Resources
		else {
			echo '<img src="'. DV_IMG_DIR .'card-img-placeholder.png" 
				alt="A group of people stand together, smiling, holding a large speech bubble sign that reads We are here to help you! with the Diabetes Victoria logo on it">';
		}
	}
	// Blogs
	else {
		echo '<img src="'.DV_IMG_DIR .'card-img-placeholder.png" 
			alt="A group of people stand together, smiling, holding a large speech bubble sign that reads We are here to help you! with the Diabetes Victoria logo on it">';
	}
}

/**
 * Get all publish child posts form their parent
 * 
 * @param string $post_type 	Post type (e.g., 'post', 'page', 'custom_post_type').
 * @param int|string $post_id 	Parent post ID.
 * 
 * @return Array Array of WP_Post objects representing the child posts.
 *
 */
function dv_get_direct_child_posts_from_parent($post_type ,$post_id) {
	$args = array(
		'post_type'      => $post_type,
		'posts_per_page' => -1,
		'post_status'	 => 'publish',
		'post_parent'    => $post_id, 
		'orderby'        => 'menu_order',
        'order'          => 'ASC',
	);
	
	$child_posts = get_posts($args);
	wp_reset_postdata(); 

	return $child_posts;
}
