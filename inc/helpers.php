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
 * @param array $query_args   The arguments for the query.
 * 
 * @return array Posts object
 * 
 */
function dv_get_latest_posts($query_args = array()) {
    // Set default values
    $post_type     = $query_args['post_type'] ?? 'post';
    $paged         = $query_args['paged'] ?? 1;
    $number_posts  = $query_args['posts_per_page'] ?? -1;
    $order         = $query_args['order'] ?? 'DESC';
    $categories    = $query_args['categories'] ?? array();
    $tags          = $query_args['tags'] ?? array();

    // Base query arguments
    $args = array(
        'post_type'      => $post_type,
        'paged'          => $paged,
        'posts_per_page' => $number_posts,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => $order,
        'tax_query'      => array(),
    );

    // // Taxonomy query based on post type
    if ($post_type == 'post') {
        if (!empty($categories)) {
            $args['tax_query'][] = array(
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => $categories,
                'operator' => 'IN',
                'include_children' => false,
            );
        }
        if (!empty($tags)) {
            $args['tax_query'][] = array(
                'taxonomy' => 'post_tag',
                'field'    => 'term_id',
                'terms'    => $tags,
                'operator' => 'IN',
                'include_children' => false,
            );
        }
    }
    else {
        $taxonomy_map = array(
            'resource'        => 'resource_categories',
            'recipe'          => 'recipe_categories',
            'member_recipes'  => 'member_recipe_cat'
        );
        $taxonomy_name = $taxonomy_map[$post_type] ?? '';

        if (!empty($categories) && !empty($taxonomy_name)) {
            $args['tax_query'][] = array(
                'taxonomy' => $taxonomy_name,
                'field'    => 'id',
                'terms'    => $categories,
                'operator' => 'IN',
                'include_children' => false,
            );
        }
    }

    // Execute the query and return results
    $posts = get_posts($args);

    // Always reset post data after using get_posts in case anything global was setup
    wp_reset_postdata();

    // Error handling (optional)
    if (is_wp_error($posts)) {
        return array(); // Return an empty array on error
    }

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
			echo '<li><a href="' . home_url('/' . $post_type->rewrite['slug'] . '/') . '">' . esc_html($post_type->label) . '</a></li>' . $arrow_right;
		}
		the_archive_title('<li aria-current="page"><span>', '</span></li>');
	}
	elseif (is_single()) {
		$post_type = get_post_type_object(get_post_type());
		if ($post_type) {
			echo '<li><a href="' . home_url('/' . $post_type->rewrite['slug'] . '/') . '">' . esc_html($post_type->label) . '</a></li>' . $arrow_right;
			// Get all taxonomies for the post type of the given post ID
			$taxonomies = get_object_taxonomies($post_type->name, 'names');
			$category_link_printed = false;
			foreach ($taxonomies as $taxonomy) {
				if (isset($taxonomy) && !empty($taxonomy)) {
					$terms = wp_get_post_terms($post->ID, $taxonomy);
					if (isset($terms) && !empty($terms)) {
						$term = $terms[0];
						// Custom handling for recipe and member_recipes post types
						if ($post_type->name === 'recipe' && $taxonomy === 'recipe_categories') {
							$cat_link = get_term_link($term, $taxonomy);
							if (!is_wp_error($cat_link)) {
								echo '<li><a href="' . esc_url($cat_link) . '">' . esc_html($term->name) . '</a></li>' . $arrow_right;
								$category_link_printed = true;
								break;
							}
						} elseif ($post_type->name === 'member_recipes' && $taxonomy === 'member_articles_cat') {
							$cat_link = get_term_link($term, $taxonomy);
							if (!is_wp_error($cat_link)) {
								echo '<li><a href="' . esc_url($cat_link) . '">' . esc_html($term->name) . '</a></li>' . $arrow_right;
								$category_link_printed = true;
								break;
							}
						} elseif (!$category_link_printed) {
							// Default for posts: use category or tag
							$cat_link = get_term_link($term, $taxonomy);
							if (!is_wp_error($cat_link)) {
								echo '<li><a href="' . esc_url($cat_link) . '">' . esc_html($term->name) . '</a></li>' . $arrow_right;
								$category_link_printed = true;
								break;
							}
						}
					}
				}
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
	if (!empty($page_builder) && is_array($page_builder)) {
		foreach ($page_builder as $module) {
			if ($module['acf_fc_layout'] == 'main_content') {
				$summary .= $module['content_editor'];
			}
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
	$post_type = get_post_type($post_id);
	// Recipes & Member Recipes
	if ($post_type == 'recipe' || $post_type == 'member_recipes') {
		echo '<img src="'.DV_IMG_DIR .'recipe-feature-img.png"
			alt="A man and woman sitting down to eat at a table set with a variety of dishes.">';
	}
	// Articles
	elseif ($post_type == 'post') {
		$the_terms = get_the_terms($post_id, 'category');
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
function dv_get_direct_child_posts_from_parent($post_id) {
	$post_type = get_post_type($post_id);
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


/**
 * Get the appropriate footer banner image for a given post.
 *
 * Determines which footer banner to display, prioritizing (in order):
 * 1. Custom footer banner (if set for the current post)
 * 2. Banner by post type (page, post, resource, recipe, or member_recipes)
 * 3. Default fallback banner image (if none set)
 *
 * @param int $post_id The ID of the post to retrieve the footer banner for.
 *
 * @return array Associative array with 'url' and 'alt' keys for the footer banner image.
 */
function dv_get_footer_banner_image($post_id) {
	// Default banner values
	$default_banner = [
		'url' => DV_IMG_DIR . 'default-footer-banner.png',
		'alt' => 'Diabetes Victoria Footer Banner Image',
	];

	// Always use default banner on search page or if $post_id is empty/invalid
	if ( is_search() || empty($post_id) || !get_post($post_id) ) {
		return $default_banner;
	}

	// Map post types to their corresponding option field names
	$type_banner_fields = [
		'page'           => 'footer_banner_for_pages',
		'post'           => 'footer_banner_for_articles',
		'resource'       => 'footer_banner_for_members_articles',
		'recipe'         => 'footer_banner_for_recipes',
		'member_recipes' => 'footer_banner_for_members_recipes',
	];

	$post_type = get_post_type($post_id);

	// If this is not one of the five allowed post types, use default banner
	if ( !isset($type_banner_fields[$post_type]) ) {
		return $default_banner;
	}

	// Try fetching a custom footer banner (per post)
	$custom_footer_banner = get_field('custom_footer_banner', $post_id);

	// Start with type-based banner
	$footer_banner = $default_banner;
	$type_banner = get_field( $type_banner_fields[$post_type], 'option' );
	if ( !empty($type_banner) && !empty($type_banner['url']) ) {
		$footer_banner = $type_banner;
	}

	// Override with custom banner if available
	if ( !empty($custom_footer_banner) && !empty($custom_footer_banner['url']) ) {
		$footer_banner = $custom_footer_banner;
	}

	// Ensure fallback to default if url is missing
	if ( empty($footer_banner['url']) ) {
		$footer_banner = $default_banner;
	}
	// Set a default alt attribute if not present
	if ( empty($footer_banner['alt']) ) {
		$footer_banner['alt'] = $default_banner['alt'];
	}

	return $footer_banner;
}