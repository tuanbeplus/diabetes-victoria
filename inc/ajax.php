<?php 
/**
 * Ajax load more on Search page
 * 
 */
function dv_load_more_search_results() {
    $page = isset($_POST['page']) ? $_POST['page'] : '';
    $key_word = isset($_POST['key_word']) ? $_POST['key_word'] : '';
    $search_orderby = isset($_POST['search_orderby']) ? $_POST['search_orderby'] : '';
    $search_order = isset($_POST['search_order']) ? $_POST['search_order'] : '';

    // Custom query to fetch more search results based on the $query and $page.
    $args = array(
        'post_type' => 'any',
        's' => $key_word,
        'paged' => $page,
        'posts_per_page' => 6,
        'orderby' => $search_orderby,
        'order' => $search_order,
    );
    $search_query = get_posts($args);

    foreach ($search_query as $post): 
        // Get Post Summary
        $summary = dv_get_post_summary($post->ID);
        ?>
        <article id="post-<?php echo $post->ID ?>" class="result-item">
            <h2 class="__title">
                <span><?php echo get_the_title($post->ID) ?></span>
            </h2>
            <a class="__link" href="<?php echo get_the_permalink($post->ID) ?>">
                <span><?php echo get_the_permalink($post->ID) ?></span>
            </a>
            <div class="__summary"><?php echo $summary ?></div>
        </article>
    <?php
    endforeach;

    // Reset Post Data
    wp_reset_postdata();
    die;
}
add_action('wp_ajax_dv_load_more_search_results', 'dv_load_more_search_results');
add_action('wp_ajax_nopriv_dv_load_more_search_results', 'dv_load_more_search_results');


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
                    <?php echo get_the_post_thumbnail($post->ID, 'medium'); ?>
                <?php else: ?>
                    <img src="<?php echo DV_IMG_DIR .'card-img-placeholder.png'; ?>" 
                        alt="People holding a banner have the message that we are here to help you.">
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