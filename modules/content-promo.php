<?php
/**
 * The template for displaying Carousel module
 *
 */

if( get_row_layout() == 'content_promo' ):
    $promo_data = array();
    $promo_class = '';
    $promo_options = get_sub_field('promo_options'); //carousel_layout
    $static_content = get_sub_field('static_content');
    $arr_static_content = array($static_content);
    $carousel_options = get_sub_field('carousel_options');
    $carousel_list = get_sub_field('carousel_list');
    $section_id = rand(0, 999);
    $dots       = ($carousel_options['dots']) ? 'true' : 'false';
    $autoplay   = ($carousel_options['autoplay']) ? 'true' : 'false';
    $autoplay_speed = $carousel_options['autoplay_speed'] ?? '2000';

    if ($promo_options == 'carousel_layout') {
        $promo_data = $carousel_list;
        $promo_class = 'carousel';
    }
    else {
        $promo_data = $arr_static_content;
        $promo_class = 'static';
    }    

    if(!empty($promo_data)):
        ?>
        <!-- Content Promo section -->
        <section id="content-promo-<?php echo $section_id; ?>" class="content-promo <?php echo $promo_class; ?>">
            <div class="carousel-wrapper promo-carousel-<?php echo $section_id; ?>">
                <?php foreach ($promo_data as $id => $row): 
                    if ($promo_options == 'carousel_layout') {
                        $item = $row['carousel_item'];
                    }
                    else {
                        $item = $row;
                    }
                    if (!empty($item)): 
                        $landing_page = $item['landing_page'];
                        $title = $item['title'];
                        $image = $item['image'];
                        $text_color = !empty($item['text_color']) ? $item['text_color'] : '#FFF';
                        $background_color = !empty($item['background_color']) ? $item['background_color'] : 'var(--primary-color)';
                        $cta_background_color = !empty($item['cta_background_color']) ? $item['cta_background_color'] : '#FFF';
                        $description = $item['description'];
                        $primary_cta = $item['primary_cta'];
                        $secondary_cta = $item['secondary_cta'];
                        $additional_links = $item['additional_links'];
                        $links_list = $item['additional_links']['links_list'];
                        ?>
                        <div class="carousel-item item-<?php echo $id; ?>" style="background-color:<?php echo $background_color; ?>">
                            <div class="item-inner container">
                                <!-- Carousel content -->
                                <div class="item-content">
                                    <?php if ($landing_page['page_name'] && $landing_page['page_link']): ?>
                                        <div class="landing-page">
                                            <a class="cta-btn" href="<?php echo $landing_page['page_link']; ?>" role="button">
                                                <span><?php echo $landing_page['page_name']; ?></span>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    <!-- Main content -->
                                    <div class="main-content"> 
                                        <div class="col-left">
                                            <?php if ($title): ?>
                                                <h2 class="title"><span><?php echo $title; ?></span></h2>
                                            <?php endif; ?>

                                            <?php if ($item['description']): ?>
                                                <div class="description"><?php echo $item['description']; ?></div>
                                            <?php endif; ?>

                                            <?php if ($primary_cta['visibility'] == true || $secondary_cta['visibility'] == true): ?>
                                                <div class="group-cta">
                                                    <?php if ($primary_cta['visibility'] == true): ?>
                                                        <a class="primary-cta" href="<?php echo $primary_cta['link']; ?>" role="button">
                                                            <span><?php echo !empty($primary_cta['text']) ? $primary_cta['text'] : 'Learn more'; ?></span>
                                                        </a>
                                                    <?php endif; ?>
                                                    <?php if ($secondary_cta['visibility'] == true): ?>
                                                        <a class="secondary-cta" href="<?php echo $secondary_cta['link']; ?>">
                                                            <span><?php echo $secondary_cta['text']; ?></span>
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <?php if (!empty($additional_links) && !empty($links_list)): ?>
                                            <div class="col-right">
                                                <!-- Additional content -->
                                                <div class="additional-content">
                                                    <?php if ($additional_links['heading']): ?>
                                                        <h3><?php echo $additional_links['heading']; ?></h3>
                                                    <?php endif; ?>
                                                    <?php if ($links_list): ?>
                                                        <ul class="links-list">
                                                        <?php foreach ($links_list as $link): ?>
                                                            <li>
                                                                <a href="<?php echo $link['link']; ?>"><?php echo $link['text']; ?></a>
                                                            </li>
                                                        <?php endforeach; ?>
                                                        </ul>
                                                    <?php endif; ?>
                                                </div><!-- .Additional content -->
                                            </div>
                                        <?php endif; ?>
                                    </div><!-- .Main content -->
                                </div><!-- .Carousel content -->

                                <?php if ($image && $image['url']): ?>
                                    <!-- Carousel image -->
                                    <div class="item-img">
                                        <img class="main-img" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?? ''; ?>">
                                    </div><!-- .Carousel image -->
                                <?php endif; ?>
                            </div>
                            <!-- Custom color options -->
                            <style>
                                #content-promo-<?php echo $section_id; ?> .item-<?php echo $id; ?> .landing-page .cta-btn {
                                    color: <?php echo $background_color; ?>!important;
                                    background-color: <?php echo $cta_background_color; ?>!important;
                                    border-color: <?php echo $cta_background_color; ?>!important;
                                }
                                #content-promo-<?php echo $section_id; ?> .item-<?php echo $id; ?> .landing-page .cta-btn:hover {
                                    color: <?php echo $cta_background_color; ?>!important;
                                    box-shadow: inset 400px 0 0 0 <?php echo $background_color; ?>!important;
                                }
                                #content-promo-<?php echo $section_id; ?> .item-<?php echo $id; ?> .carousel-content {
                                    color: <?php echo $text_color; ?>!important;
                                }
                                #content-promo-<?php echo $section_id; ?> .item-<?php echo $id; ?> .group-cta .primary-cta {
                                    color: <?php echo $background_color; ?>!important;
                                    background-color: <?php echo $cta_background_color; ?>!important;
                                    border-color: <?php echo $cta_background_color; ?>!important;
                                }
                                #content-promo-<?php echo $section_id; ?> .item-<?php echo $id; ?> .group-cta .primary-cta:hover {
                                    color: <?php echo $cta_background_color; ?>!important;
                                    box-shadow: inset 400px 0 0 0 <?php echo $background_color; ?>!important;
                                }
                                #content-promo-<?php echo $section_id; ?> .item-<?php echo $id; ?> .group-cta .secondary-cta {
                                    color: <?php echo $text_color; ?>!important;
                                    border-color: <?php echo $text_color; ?>!important;
                                }
                                #content-promo-<?php echo $section_id; ?> .item-<?php echo $id; ?> .group-cta .secondary-cta::after {
                                    background-color: <?php echo $text_color; ?>!important;
                                }
                            </style><!-- .Custom color options -->
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </section><!-- .Content Promo section -->
        <?php if ($promo_options == 'carousel_layout'): ?>
            <script>
            jQuery(document).ready(function(){
                jQuery('.promo-carousel-<?php echo $section_id; ?>').slick({
                    // Slick Slider options
                    infinite: false,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    accessibility: true,
                    speed: 800,
                    autoplay: <?php echo $autoplay; ?>,
                    autoplaySpeed: <?php echo $autoplay_speed.'000'; ?>,
                    arrows: false,
                    dots: <?php echo $dots; ?>,
                    dotsClass: 'slick-dots container',
                    pauseOnFocus: true,
                    pauseOnHover: true,
                });
            });
            </script>
        <?php endif;
        // Style
        $bg_color = get_sub_field('background_color');
        $bg_color = !empty($bg_color) ? $bg_color : 'transparent';
        $pd_top = get_sub_field('padding_top');
        $pd_top = (isset($pd_top) && $pd_top !== '') ? $pd_top . 'px' : '0';
        $pd_bottom = get_sub_field('padding_bottom');
        $pd_bottom = (isset($pd_bottom) && $pd_bottom !== '') ? $pd_bottom . 'px' : '60px';
        $image_width = get_sub_field('image_width');
        $image_width = (isset($image_width) && $image_width !== '') ? $image_width . 'px' : '740px';
        
        echo '<style>
                #content-promo-'. $section_id .' {
                    --s-bg-color: ' . $bg_color . ';
                    --s-pd-top: ' . $pd_top . ';
                    --s-pd-bottom: ' . $pd_bottom . ';
                    --s-img-width: '. $image_width .';
                }
            </style>';
    endif;
endif;