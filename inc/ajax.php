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
    $post_type = isset($_POST['post_type']) ? $_POST['post_type'] : '';
    $paged = isset($_POST['paged']) ? $_POST['paged'] : '';
    $number_posts = isset($_POST['number_posts']) ? $_POST['number_posts'] : '';
    $order_by = isset($_POST['order_by']) ? $_POST['order_by'] : '';
    // Get posts
    $posts = dv_get_latest_posts($post_type, $paged, $number_posts, $order_by);
    foreach ($posts as $post):
        ?>
        <li class="post post-<?php echo $post->ID; ?>">
            <div class="__thumb">
                <?php if (!empty(get_the_post_thumbnail($post->ID))): ?>
                    <?php echo get_the_post_thumbnail($post->ID, 'full'); ?>
                <?php else: ?>
                    <?php if( get_post_type( $post->ID ) == 'recipe' ): ?>
                        <img src="<?php echo DV_IMG_DIR .'recipe-feature-img-default.jpeg'; ?>" 
                            alt="<?php echo $feature_img_alt_default ?>">
                    <?php elseif( get_post_type( $post->ID ) == 'resource' ): ?>
                        <?php 
                        $the_terms = get_the_terms( $post->ID, 'resource_categories' );
                        $terms_slug = array();
                        if( $the_terms && ! is_wp_error( $the_terms ) ){
                            foreach ( $the_terms as $term ) {
                                $terms_slug[] = $term->slug;
                            }
                        }
                        ?>
                        <?php if( in_array( 'podcasts', $terms_slug ) ): ?>
                            <img src="<?php echo DV_IMG_DIR .'resource-feature-img-default.png'; ?>" 
                            alt="<?php echo $feature_img_alt_default ?>">
                        <?php else: ?>
                            <img src="<?php echo DV_IMG_DIR .'card-img-placeholder.png'; ?>" 
                            alt="<?php echo $feature_img_alt_default ?>">
                        <?php endif; ?>
                    <?php else: ?>
                        <img src="<?php echo DV_IMG_DIR .'card-img-placeholder.png'; ?>" 
                            alt="<?php echo $feature_img_alt_default ?>">
                    <?php endif;?>
                <?php endif; ?>
            </div>
            <div class="post-meta">
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