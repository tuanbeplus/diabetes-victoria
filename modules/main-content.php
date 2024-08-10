<?php
/**
 * The template for displaying Main Content module
 *
 */

if( get_row_layout() == 'main_content' ):
    // Content
    $section_id = rand(0, 999);
    $media_options = get_sub_field('media_options');
    $video_url = get_sub_field('video_url');
    $banner_image = get_sub_field('banner_image');
    $content_title = get_sub_field('content_title');
    $content_editor = get_sub_field('content_editor');
    $bottom_cta = get_sub_field('bottom_cta');
    $sidebar = get_sub_field('sidebar');
    $show_sidebar = $sidebar['show_sidebar'];
    $in_this_section = $sidebar['in_this_section'];
    $custom_parent_page_id = $sidebar['custom_parent_page'];
    $on_this_page = $sidebar['on_this_page'];
    $on_this_page_options = $on_this_page['options'];
    $custom_links = $on_this_page['custom_links'];
    $secondary_info = $sidebar['secondary_info'];
    $sc_info_visibility = $secondary_info['visibility'];
    $sc_info_type = $secondary_info['info_type'];
    $sc_info_list = $secondary_info['info_list'];
    $sc_post_type = $secondary_info['post_type'];
    $additional_info_boxes = $sidebar['additional_info_boxes'];
    $aib_visibility = $additional_info_boxes['visibility'];
    $aib_list = $additional_info_boxes['info_boxes'];
    $parent_page_id = get_the_ID();
    if (isset($custom_parent_page_id) && !empty($custom_parent_page_id)) {
        $parent_page_id = $custom_parent_page_id;
    }
    $child_pages = dv_get_direct_child_posts_from_parent($parent_page_id);

    if (!empty($banner_image) || !empty($content_editor)):
        ?>
        <!-- Main content with sidebar section -->
        <section id="main-content-<?php echo $section_id; ?>" class="main-content">
            <div class="main-content-inner <?php if ($show_sidebar == true) echo 'has-sidebar'; ?>">
                <?php if ($show_sidebar == true): ?>
                    <!-- Sidebar -->
                    <div id="main-content-sidebar" class="sidebar">
                        <div class="sidebar-inner">
                            <?php if ( $in_this_section == true && !empty($child_pages) ): ?>
                                <!-- In This Section -->
                                <div class="in-this-section">
                                    <h2 class="__heading">In This Section</h2>
                                    <ul class="child-pages-list" role="list">
                                        <li>
                                            <?php if ($parent_page_id == get_the_ID()): ?>
                                                <?php echo get_the_title($parent_page_id) ?>
                                            <?php else: ?>
                                                <a href="<?php echo get_the_permalink($parent_page_id) ?>">
                                                    <?php echo get_the_title($parent_page_id) ?>
                                                </a>
                                            <?php endif; ?>
                                        </li>
                                    <?php foreach ($child_pages as $page): ?>
                                        <li>
                                        <?php if ($page->ID == get_the_ID()): ?>
                                            <?php echo $page->post_title ?>
                                        <?php else: ?>
                                            <a href="<?php echo get_the_permalink($page->ID) ?>">
                                                <?php echo $page->post_title ?>
                                            </a>
                                        <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                    </ul>
                                </div>
                                <!-- /In This Section -->
                            <?php endif; ?>
                            <div class="on-this-page">
                                <h2 class="__heading"><?php echo $on_this_page['heading']; ?></h2>
                                <?php if ($on_this_page_options == 'auto_tocs'): ?>
                                    <ul id="tocs" class="links-list" role="list"></ul>
                                <?php endif; ?>
                                <?php if ($on_this_page_options == 'custom_links' && !empty($custom_links)): ?>
                                    <ul id="custom-links" class="links-list" role="list">
                                    <?php foreach ($custom_links as $item): ?>
                                        <li>
                                            <a href="<?php echo $item['link'] ?>"><?php echo $item['text'] ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                            <?php if ($sc_info_visibility == true && $sc_info_type == 'custom_info' && !empty($sc_info_list)): ?>
                                <div class="secondary-info">
                                    <h2 class="__heading"><?php echo $secondary_info['heading'] ?? ''; ?></h2>
                                    <ul class="sc-info-list" role="list">
                                    <?php foreach ($sc_info_list as $item): 
                                        $icon_url = !empty($item['icon']['url']) ? $item['icon']['url'] : DV_IMG_DIR .'arrow-up-right-from-square-solid.svg';
                                        ?>
                                        <li>
                                            <img class="__icon" src="<?php echo $icon_url; ?>" alt="<?php echo $item['icon']['alt'] ?>">
                                            <div class="__info"><?php echo $item['info'] ?></div>
                                        </li>
                                    <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <?php if ($sc_info_visibility == true && $sc_info_type == 'categories' && !empty($sc_post_type)): ?>
                                <div class="secondary-info archive-categories">
                                    <?php
                                        $all_taxonomies = get_object_taxonomies($sc_post_type, 'objects');
                                        foreach ($all_taxonomies as $taxonomy): ?>
                                        <?php if (isset($taxonomy->name) && $taxonomy->name != 'post_tag'): 
                                            $all_tax_terms = get_terms( array(
                                                'taxonomy'   => $taxonomy->name,
                                                'hide_empty' => true,
                                            ));
                                            if (!empty($all_tax_terms)):
                                            ?>
                                                <h2 class="__heading"><?php echo 'More '. $taxonomy->label ?? ''; ?></h2>
                                                <ul role="list">
                                                <?php foreach ($all_tax_terms as $term): ?>
                                                    <li>
                                                        <a href="<?php echo esc_url(get_term_link($term)) ?? '' ?>">
                                                            <?php echo $term->name ?? '' ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                                </ul>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($aib_visibility == true && !empty($aib_list)): ?>
                                <div class="additional-info-boxes">
                                <?php foreach ($aib_list as $box): ?>
                                    <div class="aib-box">
                                        <h2 class="__heading"><?php echo $box['heading'] ?? ''; ?></h2>
                                        <div class="__content"><?php echo $box['content'] ?? ''; ?></div>
                                    </div>
                                <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div><!-- .Sidebar -->
                <?php endif; ?>
                
                <!-- Content -->
                <div class="content-wrapper">
                    <?php if ($media_options == 'image' && !empty($banner_image['url'])): ?>
                        <img class="__banner" src="<?php echo $banner_image['url']; ?>" alt="<?php echo $banner_image['alt']; ?>">
                    <?php endif; ?>

                    <?php if($media_options == 'video' && !empty($video_url)) 
                        echo do_shortcode( '[video src="'. $video_url .'"/]' ); ?>

                    <?php if (!empty($content_editor)): ?>
                        <div class="__content">
                            <?php if(!empty($content_title)) echo '<h2 class="__title">'.$content_title.'</h2>'; ?>

                            <?php echo $content_editor; ?>

                            <?php if ($bottom_cta['visibility'] == true && !empty($bottom_cta['link'])): ?>
                                <a class="__cta" href="<?php echo $bottom_cta['link']; ?>" role="button">
                                    <span><?php echo $bottom_cta['text']; ?></span>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div><!-- .Content -->
            </div>
        </section><!--. Main content with sidebar section -->
        <?php
        // Style
        $bg_color = get_sub_field('background_color');
        $bg_color = !empty($bg_color) ? $bg_color : '';
        $pd_top = get_sub_field('padding_top');
        $pd_top = (isset($pd_top) && $pd_top !== '') ? $pd_top . 'px' : '0';
        $pd_bottom = get_sub_field('padding_bottom');
        $pd_bottom = (isset($pd_bottom) && $pd_bottom !== '') ? $pd_bottom . 'px' : '60px';
        
        echo '<style>
                #main-content-'. $section_id .' {
                    --s-bg-color: ' . $bg_color . ';
                    --s-pd-top: ' . $pd_top . ';
                    --s-pd-bottom: ' . $pd_bottom . ';
                }
            </style>';
    endif;
endif;