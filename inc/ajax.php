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
        'posts_per_page' => 3,
        'orderby' => $search_orderby,
        'order' => $search_order,
    );
    $search_query = get_posts($args);

    foreach ($search_query as $post): ?>
        <article id="post-<?php echo $post->ID ?>" class="result-item">
            <h2 class="__title">
                <span><?php echo get_the_title($post->ID) ?></span>
            </h2>
            <a class="__link" href="<?php echo get_the_permalink($post->ID) ?>">
                <span><?php echo get_the_permalink($post->ID) ?></span>
            </a>
            <div class="__summary">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sem veniamue cil sint occaecat
                cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laboru
            </div>
        </article>
    <?php
    endforeach;

    // Reset Post Data
    wp_reset_postdata();
    die;
}
add_action('wp_ajax_dv_load_more_search_results', 'dv_load_more_search_results');
add_action('wp_ajax_nopriv_dv_load_more_search_results', 'dv_load_more_search_results');