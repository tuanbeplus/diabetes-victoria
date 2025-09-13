<?php
/**
 * The template for displaying Carousel module
 *
 */

if( get_row_layout() !== 'promo_slider' ) {
    return;
}
$template = get_sub_field('templates');
$settings = get_sub_field('settings');
$slides = get_sub_field('slides');
$section_id = rand(0, 999);

// Fix: Only show dots if more than 1 slide
$slide_count = is_array($slides) ? count($slides) : 0;
$dots = ($settings['dots'] && $slide_count > 1) ? 'true' : 'false';

$autoplay = ($settings['autoplay']) ? 'true' : 'false';
$autoplay_speed = $settings['autoplay_speed'] ?? '3000';

if(!empty($slides)):
    ?>
    <!-- Content Promo section -->
    <section id="promo-slider-<?php echo $section_id; ?>" class="promo-slider">
        <div class="slide-wrapper promo-slider-<?php echo $section_id; ?> <?php echo $template; ?>">
            <?php foreach ($slides as $id => $slide): 
                $item = $slide['slide_item'];
                if (!empty($item)): 
                    $title = $item['title'];
                    $sub_title = $item['sub_title'];
                    $image = $item['image'];
                    $description = $item['description'];
                    $button = $item['button'];
                    $text_color = !empty($item['text_color']) ? $item['text_color'] : '#FFF';
                    $button_text_color = !empty($item['button_text_color']) ? $item['button_text_color'] : '#FFF';
                    if ($template === 'template_1') {
                        $slide_bg_color = !empty($item['background_color']) ? $item['background_color'] : 'var(--primary-color)';
                        $button_bg_color = !empty($item['button_background_color']) ? $item['button_background_color'] : 'var(--accent-color)';
                    }
                    else {
                        $slide_bg_color = !empty($item['background_color']) ? $item['background_color'] : 'var(--secondary-color)';
                        $button_bg_color = !empty($item['button_background_color']) ? $item['button_background_color'] : '#ff5a5c';
                    }
                    ?>
                    <div class="slide-item item-<?php echo $id; ?>">
                        <div class="item-inner container">
                            <?php if ($image && isset($image['ID'])): ?>
                                <?php
                                    // Get medium_large image size if available
                                    $img_url = '';
                                    if ($image && isset($image['ID'])) {
                                        $img_data = wp_get_attachment_image_src($image['ID'], 'medium_large');
                                        if ($img_data && isset($img_data[0])) {
                                            $img_url = $img_data[0];
                                        }
                                    }
                                    if (!$img_url && $image && isset($image['url'])) {
                                        $img_url = $image['url'];
                                    }
                                ?>
                                <?php if ($img_url): ?>
                                    <div class="item-img">
                                        <img class="" src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($image['alt'] ?? ''); ?>">
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                            <div class="item-content">
                                <?php if ($sub_title): ?>
                                    <p class="__sub-title"><?php echo $sub_title; ?></p>
                                <?php endif; ?>
                                <?php if ($title): ?>
                                    <h2 class="__title"><span><?php echo $title; ?></span></h2>
                                <?php endif; ?>
                                <?php if ($description): ?>
                                    <div class="__desc"><?php echo $description; ?></div>
                                <?php endif; ?>
                                <?php if ($button['showhide'] == true): ?>
                                    <a class="__btn" href="<?php echo $button['link']; ?>" role="button">
                                        <span><?php echo $button['text']; ?></span>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="item-shape">
                                <img src="<?php echo DV_IMG_DIR . 'new-dv-shape-white.png'; ?>" alt="">
                            </div>
                        </div>
                        <!-- Custom color options -->
                        <style>
                            #promo-slider-<?php echo $section_id; ?> .slide-item.item-<?php echo $id; ?> {
                                --slide-text-color: <?php echo $text_color; ?>;
                                --slide-bg-color: <?php echo $slide_bg_color; ?>;
                                --slide-button-color: <?php echo $button_text_color; ?>;
                                --slide-button-bg-color: <?php echo $button_bg_color; ?>;
                            }
                        </style><!-- .Custom color options -->
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </section><!-- .Content Promo section -->
    <script>
    jQuery(document).ready(function(){
        jQuery('.promo-slider-<?php echo $section_id; ?>').slick({
            infinite: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            accessibility: false,
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
    if ($template == 'template_1') {
        $bg_color = !empty($bg_color) ? $bg_color : 'var(--primary-color)';
    }
    else {
        $bg_color = !empty($bg_color) ? $bg_color : 'var(--secondary-color)';
    }
    $pd_top = get_sub_field('padding_top');
    $pd_top = (isset($pd_top) && $pd_top !== '') ? $pd_top . 'px' : '60px';
    $pd_bottom = get_sub_field('padding_bottom');
    $pd_bottom = (isset($pd_bottom) && $pd_bottom !== '') ? $pd_bottom . 'px' : '60px';
    
    echo '<style>
            #promo-slider-'. $section_id .' {
                --s-bg-color: ' . $bg_color . ';
                --s-pd-top: ' . $pd_top . ';
                --s-pd-bottom: ' . $pd_bottom . ';
            }
        </style>';
endif;
