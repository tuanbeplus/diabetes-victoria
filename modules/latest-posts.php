<?php
/**
 * The template for displaying Latest Posts module
 *
 */

if( get_row_layout() == 'latest_posts' ):

    $heading = get_sub_field('heading');
    $post_type = get_sub_field('post_type');
    $number_posts = get_sub_field('number_posts');
    $order_by = get_sub_field('order_by');
    $top_cta = get_sub_field('top_cta');
    $bottom_cta = get_sub_field('bottom_cta');

    // Get posts
    $posts = dv_get_latest_posts($post_type, $number_posts, $order_by);

    if (!empty($posts)): ?>
        <!-- Latest Posts -->
        <section class="latest-posts">
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
                    <?php foreach ($posts as $post): ?>
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
                    <?php endforeach; ?>
                    </ul>
                    <?php if ($bottom_cta['visibility'] == true && !empty($bottom_cta['cta_link'])): ?>
                        <div class="bottom">
                            <a class="bottom-cta-btn" href="<?php echo $bottom_cta['cta_link']; ?>">
                                <span><?php echo $bottom_cta['cta_text']; ?></span>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section><!-- .Latest Posts -->
    <?php
    // Reset Post Data
    wp_reset_postdata();
    // Style
    $bg_color = get_sub_field('background_color');
    $bg_color = !empty($bg_color) ? $bg_color : '';
    $pd_top = get_sub_field('padding_top');
    $pd_top = (isset($pd_top) && $pd_top !== '') ? $pd_top . 'px' : '60px';
    $pd_bottom = get_sub_field('padding_bottom');
    $pd_bottom = (isset($pd_bottom) && $pd_bottom !== '') ? $pd_bottom . 'px' : '60px';
    
    echo '<style>
            section.latest-posts {
                --s-bg-color: ' . $bg_color . ';
                --s-pd-top: ' . $pd_top . ';
                --s-pd-bottom: ' . $pd_bottom . ';
            }
        </style>';
    endif;
endif;