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
    // $arrow_right = '<span class="chevron-right-icon"><i class="fa-solid fa-chevron-right"></i></span>';
    $arrow_right = '<span class="arrow-right"> > </span>';
	if ( ! is_home() ) {
        echo '<nav aria-label="Breadcrumbs" class="breadcrumb">';
        echo '  <div class="container">';
        echo '      <ol class="breadcrumb-list">';
		echo '          <li><a href="' . site_url() . '">Home</a></li> '.$arrow_right;
		if ( is_category() || is_single() ) {
			the_category( $arrow_right );
			if ( is_single() ) {
				echo $arrow_right;
                echo '<li aria-current="page"><strong> ' . get_the_title() . '</strong></li>';
			}
		} elseif ( is_page() ) {
			if ( $post->post_parent ) {
				$anc   = get_post_ancestors( $post->ID );
				foreach ( $anc as $ancestor ) {
					$output = '<li><a href="' . get_permalink( $ancestor ) . '" title="' . get_the_title( $ancestor ) . '">' . get_the_title( $ancestor ) . '</a></li> '.$arrow_right;
				}
				echo $output;
				echo '<li aria-current="page"><strong> ' . get_the_title() . '</strong></li>';
			} else {
				echo '<li aria-current="page"><strong> ' . get_the_title() . '</strong></li>';
			}
		}
        echo '      </ol>';
        echo '  </div>';
        echo '</nav>';
	}
}
