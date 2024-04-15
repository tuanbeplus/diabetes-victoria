<?php
/**
 * The template for displaying Carousel module
 *
 */

if( get_row_layout() == 'hero_carousel' ):
    $carousel_options = get_sub_field('carousel_options');
    $carousel_list = get_sub_field('carousel_list');
    $wrapper_id = rand(0, 999);
    $navigation = ($carousel_options['navigation']) ? 'true' : 'false';
    $dots       = ($carousel_options['dots']) ? 'true' : 'false';
    $autoplay   = ($carousel_options['autoplay']) ? 'true' : 'false';
    $autoplay_speed = $carousel_options['autoplay_speed'] ?? '2000';

    if(!empty($carousel_list)):
        ?>
        <!-- Carousel -->
        <section class="hero-carousel carousel">
            <div id="carousel-wrapper-<?php echo $wrapper_id; ?>" class="carousel-wrapper owl-carousel">
                <?php foreach ($carousel_list as $id => $row): 
                    $item = $row['carousel_item'] ?? '';
                    if (!empty($item)): 
                        $label = $item['label'];
                        $title = $item['title'];
                        $image = $item['image'];
                        $text_color = !empty($item['text_color']) ? $item['text_color'] : '#fff';
                        $background_color = !empty($item['background_color']) ? $item['background_color'] : '#019BC2';
                        $description = $item['description'];
                        $primary_cta = $item['primary_cta'];
                        $secondary_cta = $item['secondary_cta'];
                        $additional_links = $item['additional_links'];
                        ?>
                        <div class="carousel-item item-<?php echo $id; ?>" style="background-color:<?php echo $background_color; ?>">
                            <div class="carousel-inner container">
                                <div class="carousel-content">
                                    <!-- Main content -->
                                    <div class="main-content">
                                        <?php if ($title): ?>
                                            <h1 class="title"><?php echo $title; ?></h1>
                                        <?php endif; ?>

                                        <?php if ($item['description']): ?>
                                            <p class="description"><?php echo $item['description']; ?></p>
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
                                    <div class="carousel-img">
                                        <img class="main-img" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?? ''; ?>" loading="lazy">
                                        <img class="quote-shape" src="<?php echo DV_IMG_DIR.'quote-shape-blu-2.png'; ?>" alt="Quote Shape" loading="lazy">
                                    </div><!-- .Carousel image -->
                                <?php endif; ?>
                            </div>
                            <!-- Custom color options -->
                            <style>
                                .carousel-item.item-<?php echo $id; ?> .carousel-content {
                                    color: <?php echo $text_color; ?>!important;
                                }
                                .carousel-item.item-<?php echo $id; ?> .group-cta .primary-cta {
                                    color: <?php echo $background_color; ?>!important;
                                    background-color: <?php echo $text_color; ?>!important;
                                    border-color: <?php echo $text_color; ?>!important;
                                }
                                .carousel-item.item-<?php echo $id; ?> .group-cta .primary-cta:hover {
                                    color: <?php echo $text_color; ?>!important;
                                    box-shadow: inset 300px 0 0 0 <?php echo $background_color; ?>!important;
                                }
                                .carousel-item.item-<?php echo $id; ?> .group-cta .secondary-cta {
                                    color: <?php echo $text_color; ?>!important;
                                    border-color: <?php echo $text_color; ?>!important;
                                }
                                .carousel-item.item-<?php echo $id; ?> .group-cta .secondary-cta::after {
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
            let carousel_<?php echo $wrapper_id; ?> = jQuery("#carousel-wrapper-<?php echo $wrapper_id; ?>").owlCarousel({
                loop: false,
                margin: 0,
                items: 1,
                nav: false,
                dots: <?php echo $dots; ?>,
                autoplay: <?php echo $autoplay; ?>,
                autoplaySpeed: <?php echo $autoplay_speed; ?>,
                autoplayTimeout: 3000,
                autoplayHoverPause: true,
                navText: [
                    '<span aria-label="Previous Slide"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"/></svg></span>',
			        '<span aria-label="Next Slide"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/></svg></span>',
                ],
            });
            jQuery("#carousel-wrapper-<?php echo $wrapper_id; ?> .owl-dots").addClass('container');
        });
        </script>
        <?php
    endif;
endif;