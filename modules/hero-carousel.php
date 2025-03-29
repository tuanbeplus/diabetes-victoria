<?php
/**
 * The template for displaying Carousel module
 *
 */

if( get_row_layout() == 'hero_carousel' ):
    $carousel_options = get_sub_field('carousel_options');
    $carousel_list = get_sub_field('carousel_list');
    $section_id = rand(0, 999);
    $dots       = ($carousel_options['dots']) ? 'true' : 'false';
    $autoplay   = ($carousel_options['autoplay']) ? 'true' : 'false';
    $autoplay_speed = $carousel_options['autoplay_speed'] ?? '2000';

    if(!empty($carousel_list)): ?>
        <!-- Carousel -->
        <section id="hero-carousel-<?php echo $section_id; ?>" class="hero-carousel carousel">
            <div class="carousel-wrapper carousel-wrapper-<?php echo $section_id; ?>">
                <?php foreach ($carousel_list as $id => $row): 
                    $item = $row['carousel_item'] ?? '';
                    if (!empty($item)): 
                        $title = $item['title'];
                        $image = $item['image'];
                        $text_color = !empty($item['text_color']) ? $item['text_color'] : 'var(--white-color)';
                        $background_color = !empty($item['background_color']) ? $item['background_color'] : 'var(--primary-color)';
                        $description = $item['description'];
                        $primary_cta = $item['primary_cta'];
                        $secondary_cta = $item['secondary_cta'];
                        ?>
                        <div class="carousel-item item-<?php echo $id; ?>" style="background-color:<?php echo $background_color; ?>">
                            <div class="item-inner container">
                                <div class="item-content">
                                    <!-- Main content -->
                                    <div class="main-content">
                                        <?php if ($title): ?>
                                            <h1 class="title"><?php echo $title; ?></h1>
                                        <?php endif; ?>

                                        <?php if ($item['description']): ?>
                                            <div class="description"><?php echo $item['description']; ?></div>
                                        <?php endif; ?>

                                        <?php if ($primary_cta['visibility'] == true || $secondary_cta['visibility'] == true): ?>
                                            <div class="group-cta">
                                                <?php if ($primary_cta['visibility'] == true): ?>
                                                    <a class="primary-cta" href="<?php echo $primary_cta['link']; ?>">
                                                        <span><?php echo $primary_cta['text']; ?></span>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if ($secondary_cta['visibility'] == true): ?>
                                                    <a class="secondary-cta" href="<?php echo $secondary_cta['link']; ?>">
                                                        <span><?php echo $secondary_cta['text']; ?></span>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div><!-- .Main content -->
                                </div>

                                <?php if ($image && $image['url']): ?>
                                    <!-- Carousel image -->
                                    <div class="item-img">
                                        <img class="main-img" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?? ''; ?>" loading="lazy">
                                    </div><!-- .Carousel image -->
                                <?php endif; ?>
                            </div>
                            <!-- Custom color options -->
                            <style>
                                #hero-carousel-<?php echo $section_id; ?> .carousel-item.item-<?php echo $id; ?> .carousel-content {
                                    color: <?php echo $text_color; ?>!important;
                                }
                                #hero-carousel-<?php echo $section_id; ?> .carousel-item.item-<?php echo $id; ?> .group-cta .primary-cta {
                                    color: <?php echo $background_color; ?>!important;
                                    background-color: <?php echo $text_color; ?>!important;
                                    border-color: <?php echo $text_color; ?>!important;
                                }
                                #hero-carousel-<?php echo $section_id; ?> .carousel-item.item-<?php echo $id; ?> .group-cta .primary-cta:hover {
                                    color: <?php echo $text_color; ?>!important;
                                    box-shadow: inset 400px 0 0 0 <?php echo $background_color; ?>!important;
                                }
                                #hero-carousel-<?php echo $section_id; ?> .carousel-item.item-<?php echo $id; ?> .group-cta .secondary-cta {
                                    color: <?php echo $text_color; ?>!important;
                                    border-color: <?php echo $text_color; ?>!important;
                                }
                                #hero-carousel-<?php echo $section_id; ?> .carousel-item.item-<?php echo $id; ?> .group-cta .secondary-cta::after {
                                    background-color: <?php echo $text_color; ?>!important;
                                }
                            </style><!-- .Custom color options -->
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </section><!-- .Carousel -->
        <script>
        jQuery(document).ready(function(){
            jQuery('.carousel-wrapper-<?php echo $section_id; ?>').slick({
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
        <?php
        // Style
        $bg_color = get_sub_field('background_color');
        $bg_color = !empty($bg_color) ? $bg_color : 'var(--primary-color)';
        $pd_top = get_sub_field('padding_top');
        $pd_top = (isset($pd_top) && $pd_top !== '') ? $pd_top . 'px' : '0';
        $pd_bottom = get_sub_field('padding_bottom');
        $pd_bottom = (isset($pd_bottom) && $pd_bottom !== '') ? $pd_bottom . 'px' : '0';
        
        echo '<style>
                #hero-carousel-'. $section_id .' {
                    --s-bg-color: ' . $bg_color . ';
                    --s-pd-top: ' . $pd_top . ';
                    --s-pd-bottom: ' . $pd_bottom . ';
                }
            </style>';
    endif;
endif;