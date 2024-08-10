<?php 
/**
 * Ajax load more on Search page
 * 
 */
function dv_query_search_results() {
    $page = isset($_POST['page']) ? $_POST['page'] : '';
    $key_word = isset($_POST['key_word']) ? $_POST['key_word'] : '';
    $search_orderby = isset($_POST['search_orderby']) ? $_POST['search_orderby'] : '';
    $search_order = isset($_POST['search_order']) ? $_POST['search_order'] : '';

    // Custom query to fetch more search results based on the $query and $page.
    $args = array(
        's' => $key_word,
        'post_type' => 'any',
        'post_status' => 'publish',
        'paged' => $page,
        'posts_per_page' => 6,
        'orderby' => $search_orderby,
        'order' => $search_order,
    );
    $search_query = new WP_Query($args);
    $search_result = '';

    if ($search_query->have_posts()) {
        while ($search_query->have_posts()) {
            $search_query->the_post();
            // Get Post Summary
            $summary = dv_get_post_summary(get_the_ID());
            $search_result .= 
            '<article id="post-'.get_the_ID().'" class="result-item">
                <h2 class="__title">
                    <span>'.get_the_title().'</span>
                </h2>
                <a class="__link" href="'.get_the_permalink().'">
                    <span>'.get_the_permalink().'</span>
                </a>
                <div class="__summary">'.$summary.'</div>
            </article>';
        }
    }

    $second_args = array(
        's' => $key_word,
        'post_type' => 'any',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => $search_orderby,
        'order' => $search_order,
    );
    $all_posts_query = new WP_Query($second_args);
    // Get total number of search results
    $total_posts = $all_posts_query->found_posts;
    // Reset Post Data
    wp_reset_postdata();

    // Send response
    wp_send_json(array(
        'search_result' => $search_result,
        'found_posts'   => $total_posts,
        'args'          => $args, 
        'paged'         => $page,
    ));
    die;
}
add_action('wp_ajax_dv_query_search_results', 'dv_query_search_results');
add_action('wp_ajax_nopriv_dv_query_search_results', 'dv_query_search_results');


/**
 * Ajax load more on Latest Posts module
 * 
 */
function dv_load_more_latest_posts() {
    $post_type      = isset($_POST['post_type']) ? $_POST['post_type'] : '';
    $paged          = isset($_POST['paged']) ? $_POST['paged'] : '';
    $number_posts   = isset($_POST['number_posts']) ? $_POST['number_posts'] : '';
    $order_by       = isset($_POST['order_by']) ? $_POST['order_by'] : '';
    $categories     = !empty($_POST['categories']) ? $_POST['categories'] : array();
    $tags           = !empty($_POST['tags']) ? $_POST['tags'] : array();
    $has_post_meta  = isset($_POST['has_post_meta']) ? $_POST['has_post_meta'] : '';

    // Get query posts
    $query_args = array(
        'post_type'      => $post_type,
        'paged'          => $paged,
        'posts_per_page' => $number_posts,
        'order'          => $order_by,
        'categories'     => $categories,
		'tags'           => $tags,
    );
    // Get posts
    $posts = dv_get_latest_posts($query_args);
    foreach ($posts as $post):
        ?>
        <li class="post post-<?php echo $post->ID; ?>">
            <div class="__thumb">
                <?php if (!empty(get_the_post_thumbnail($post->ID))): ?>
                    <?php echo get_the_post_thumbnail($post->ID, 'medium_large', array('loading' => 'eager')); ?>
                <?php else: ?>
                    <?php dv_the_post_thumbnail_default($post->ID) ?>
                <?php endif; ?>
            </div>
            <div class="post-meta">
                <?php if ($has_post_meta == true): 
                    // Get all taxonomies for the post type of the given post ID
                    $taxonomies = get_object_taxonomies($post_type, 'names');
                    foreach ($taxonomies as $taxonomy) {
                        if (isset($taxonomy) && !empty($taxonomy)) {
                            $terms = wp_get_post_terms($post->ID, $taxonomy);
                            if (isset($terms) && !empty($terms)) {
                                break;
                            }
                        }
                    } ?>
                    <div class="__meta">
                        <span class="date"><?php echo get_the_date('j F Y', $post->ID) ?? '' ?></span>
                        <span class="term"><?php echo $terms[0]->name ?? '' ?></span>
                    </div>
                <?php endif; ?>
                <div class="__title">
                    <a href="<?php echo get_the_permalink($post->ID); ?>">
                        <span><?php echo $post->post_title; ?></span>
                    </a>
                </div>
            </div>
        </li>
    <?php
    endforeach;
    // Reset Post Data
    wp_reset_postdata();
    die;
}
add_action('wp_ajax_dv_load_more_latest_posts', 'dv_load_more_latest_posts');
add_action('wp_ajax_nopriv_dv_load_more_latest_posts', 'dv_load_more_latest_posts');


/**
 * Ajax user profile update
 * 
 */
function dv_user_profile_update() {
    $user_id = get_current_user_id();

    $fname = isset($_POST['user_fname']) ? $_POST['user_fname'] : '';
    $lname = isset($_POST['user_lname']) ? $_POST['user_lname'] : '';
    $email = isset($_POST['user_email']) ? $_POST['user_email'] : '';
    $url = isset($_POST['user_url']) ? $_POST['user_url'] : '';
    $desc = isset($_POST['user_desc']) ? $_POST['user_desc'] : '';

    update_user_meta( $user_id, 'first_name', $fname );
    update_user_meta( $user_id, 'last_name', $lname );
    update_user_meta( $user_id, 'description', $desc );

    wp_update_user( array( 
        'ID' => $user_id, 
        'user_email' => $email,
        'user_url' => $url 
    ) );

    wp_send_json_success('succes');
    
    die;
}
add_action('wp_ajax_dv_user_profile_update', 'dv_user_profile_update');
add_action('wp_ajax_nopriv_dv_user_profile_update', 'dv_user_profile_update');

/**
 * Ajax WP Members Login
 * 
 */
function dv_member_login_ajax() {
    // First check the nonce, if it fails the function will break
    check_ajax_referer('ajax-login-nonce', 'security');
    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = $_POST['log'];
    $info['user_password'] = $_POST['pwd'];
    $info['remember'] = true;

    $user_signon = wp_signon($info, false);
    
    if (is_wp_error($user_signon)) {
        return wp_send_json(
            array(
                'status' => 'failed',
                'message' => 'Invalid username or password.'
            )
        );
    } else {
        return wp_send_json(
            array(
                'status' => 'success', 
                'message' => 'Login successful, redirecting...'
            )
        );
    }
    die();
}
add_action('wp_ajax_nopriv_dv_member_login_ajax', 'dv_member_login_ajax');
add_action('wp_ajax_dv_member_login_ajaxn', 'dv_member_login_ajax');