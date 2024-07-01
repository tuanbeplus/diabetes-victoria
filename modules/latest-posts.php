<?php
/**
 * The template for displaying Latest Posts module
 *
 */

if( get_row_layout() == 'latest_posts' ):

    $section_id = rand(0, 999);
    $heading = get_sub_field('heading');
    $post_type = get_sub_field('post_type');
    $paged = 1;
    $number_posts = get_sub_field('number_posts');
    $order_by = get_sub_field('order_by');
    $top_cta = get_sub_field('top_cta');
    $load_more_cta = get_sub_field('load_more_cta');

    // Get posts
    $posts_list = dv_get_latest_posts($post_type, $paged, $number_posts, $order_by);
    $max_posts = dv_get_latest_posts($post_type, $paged, '-1', $order_by);
    $max_posts = is_array($max_posts) ? count($max_posts) : '';

    if (!empty($posts_list)): ?>
        <!-- Latest Posts section -->
        <section id="latest-posts-section-<?php echo $section_id ?>" class="latest-posts">

            <input type="hidden" name="post_type" value="<?php echo $post_type ?>">
            <input type="hidden" name="number_posts" value="<?php echo $number_posts ?>">
            <input type="hidden" name="order_by" value="<?php echo $order_by ?>">
            <input type="hidden" name="max_posts" value="<?php echo $max_posts ?>">

            <div class="container">
                <div class="posts-wrapper">
                    <?php if (!empty($heading) || $top_cta['visibility'] == true): ?>
                        <div class="top">
                            <h2 class="heading"><?php echo $heading ?></h2>
                            <?php if ($top_cta['visibility'] == true): ?>
                                <a class="top-cta-btn" href="<?php echo $top_cta['cta_link']; ?>">
                                    <span><?php echo $top_cta['cta_text']; ?></span>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <ul class="posts-list">
                    <?php foreach ($posts_list as $post): ?>
                        <li class="post post-<?php echo $post->ID; ?>">
                            <div class="__thumb">
                                <?php if (!empty(get_the_post_thumbnail($post->ID))): ?>
                                    <?php echo get_the_post_thumbnail($post->ID, 'medium_large'); ?>
                                <?php else: ?>
                                    <?php dv_the_post_thumbnail_default($post->ID) ?>
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
                    <?php endforeach; ?>
                    </ul>
                    <?php if ($load_more_cta['visibility'] == true && $number_posts < $max_posts): ?>
                        <div class="bottom">
                            <button class="load-more-cta" role="button" data-next-page="2">
                                <span class="text"><?php echo $load_more_cta['cta_text']; ?></span>
                                <div class="loading-wrapper">
                                    <div class="dv-spinner"></div>
                                </div>
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section><!-- .Latest Posts section -->
    <?php
    // Reset Post Data
    wp_reset_postdata();
    // Style
    $bg_color = get_sub_field('background_color');
    $bg_color = !empty($bg_color) ? $bg_color : '';
    $pd_top = get_sub_field('padding_top');
    $pd_top = (isset($pd_top) && $pd_top !== '') ? $pd_top . 'px' : '0';
    $pd_bottom = get_sub_field('padding_bottom');
    $pd_bottom = (isset($pd_bottom) && $pd_bottom !== '') ? $pd_bottom . 'px' : '60px';
    
    echo '<style>
            #latest-posts-section-'. $section_id .' {
                --s-bg-color: ' . $bg_color . ';
                --s-pd-top: ' . $pd_top . ';
                --s-pd-bottom: ' . $pd_bottom . ';
            }
        </style>';
    endif;
endif;