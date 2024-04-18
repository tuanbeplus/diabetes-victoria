<?php
/**
 * The template for displaying Main Content module
 *
 */

if( get_row_layout() == 'main_content' ):
    // Content
    $banner_image = get_sub_field('banner_image');
    $content_title = get_sub_field('content_title');
    $content_editor = get_sub_field('content_editor');
    $sidebar = get_sub_field('sidebar');
    $show_sidebar = $sidebar['show_sidebar'];
    $on_this_page = $sidebar['on_this_page'];
    $on_this_page_options = $on_this_page['options'];
    $custom_links = $on_this_page['custom_links'];
    $secondary_info = $sidebar['secondary_info'];
    $sc_info_visibility = $secondary_info['visibility'];
    $sc_info_list = $secondary_info['info_list'];
    $additional_info_boxes = $sidebar['additional_info_boxes'];
    $aib_visibility = $additional_info_boxes['visibility'];
    $aib_list = $additional_info_boxes['info_boxes'];

    // Style
    $padding = get_sub_field('padding');
    $background_color = get_sub_field('background_color');

    if (!empty($banner_image) || !empty($content_editor)):
        ?>
        <section class="main-content">
            <div class="main-content-inner">
                <!-- Content -->
                <div class="content-wrapper">
                    <?php if (!empty($banner_image['url'])): ?>
                        <img class="__banner" src="<?php echo $banner_image['url']; ?>" alt="<?php echo $banner_image['alt']; ?>">
                    <?php endif; ?>
                    <?php if (!empty($content_editor)): ?>
                        <div class="__content">
                            <?php if(!empty($content_title)) echo '<h2 class="__title">'.$content_title.'</h2>'; ?>
                            <?php echo dv_clean_html_content_editor($content_editor); ?>
                        </div>
                    <?php endif; ?>
                </div><!-- .Content -->
                <?php if ($show_sidebar == true): ?>
                    <!-- Sidebar -->
                    <div id="main-content-sidebar" class="sidebar">
                        <div class="sidebar-inner">
                            <div class="on-this-page">
                                <h3 class="__heading"><?php echo $on_this_page['heading']; ?></h3>
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
                            <?php if ($sc_info_visibility == true && !empty($sc_info_list)): ?>
                                <div class="secondary-info">
                                    <h3 class="__heading"><?php echo $secondary_info['heading'] ?? ''; ?></h3>
                                    <ul class="sc-info-list" role="list">
                                    <?php foreach ($sc_info_list as $item): ?>
                                        <li>
                                            <img class="__icon" src="<?php echo $item['icon']['url'] ?>" alt="<?php echo $item['icon']['alt'] ?>">
                                            <div class="__info"><?php echo $item['info'] ?></div>
                                        </li>
                                    <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <?php if ($aib_visibility == true && !empty($aib_list)): ?>
                                <div class="additional-info-boxes">
                                <?php foreach ($aib_list as $box): ?>
                                    <div class="aib-box">
                                        <h3 class="__heading"><?php echo $box['heading'] ?? ''; ?></h3>
                                        <div class="__content"><?php echo $box['content'] ?? ''; ?></div>
                                    </div>
                                <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div><!-- .Sidebar -->
                <?php endif; ?>
            </div>
            <style>
                section.main-content {
                    --padding-top: <?php echo $padding['top'].'px' ?? '' ?>;
                    --padding-bottom: <?php echo $padding['bottom'].'px' ?? '' ?>;
                    --background-color: <?php echo $background_color ?? '' ?>;
                }
            </style>
        </section>
        <?php
    endif;
endif;