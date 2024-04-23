<?php 
/**
 * Get icon SVG file content
 * 
 * @param $icon_file_name   File name
 * 
 * @return content file svg
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
function dv_get_latest_posts($post_type, $number_posts, $order_by) {
    $args = array(
		'post_type' => $post_type,
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
    $arrow_right = '<span class="arrow"> > </span>';
	if ( ! is_front_page() ) {
		if (is_404()) return;
        echo '<nav aria-label="Breadcrumbs" class="breadcrumb">';
        echo '	<ol class="breadcrumb-list">';
		echo '		<li><a href="' . site_url() . '">Home</a></li> '.$arrow_right;
		if ( is_category() || is_single() ) {
			the_category( $arrow_right );
			if ( is_single() ) {
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				echo '<li><a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a></li>';
				echo $arrow_right;
                echo '<li aria-current="page"><span> ' . get_the_title() . '</span></li>';
			}
		} 
		elseif ( is_page() ) {
			if ( $post->post_parent ) {
				$anc   = get_post_ancestors( $post->ID );
				foreach ( $anc as $ancestor ) {
					$output = '<li><a href="' . get_permalink( $ancestor ) . '" title="' . get_the_title( $ancestor ) . '">' . get_the_title( $ancestor ) . '</a></li> '.$arrow_right;
				}
				echo $output;
				echo '<li aria-current="page"><span> ' . get_the_title() . '</span></li>';
			} else {
				echo '<li aria-current="page"><span> ' . get_the_title() . '</span></li>';
			}
		}
		elseif ( is_search() ) {
			echo '<li aria-current="page"><span>Search result for: ' . esc_html(get_search_query()) . '</span></li>';
		}
		
        echo '	</ol>';
        echo '</nav>';
	}
}


/**
 * Remove attributes from tags in HTML string
 * 
 * @param string $html_string    HTML string
 *
 * @return string Clean HTML string
 * 
 */
function dv_clean_html_content_editor($html_string) {
    $clean_html = preg_replace_callback(
        '/<(table|tbody|tr|th|td|p|ul|ol|script)([^>]*)>/',
        function ($matches) {
            // For <script> tags, return an empty string to remove them completely
            if ($matches[1] === 'script') {
                return '';
            } else {
                return "<{$matches[1]}>";
            }
        },
        $html_string
    );
    return $clean_html;
}