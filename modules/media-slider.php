<?php
/**
 * The template for displaying Media Slider module
 *
 */

if( get_row_layout() != 'media_slider' ) {
    return;
}

$section_id = rand(0, 999);
$heading = get_sub_field('heading');
$list_item = get_sub_field('list_item');

if (empty($heading) && empty($list_item)) {
    return;
}

$carousel_data = array();
$carousel_data['infinite'] = false;
$carousel_data['slidesToShow'] = 1;
$carousel_data['slidesToScroll'] = 1;
$carousel_data['accessibility'] = false;
$carousel_data['autoplay'] = false;
$carousel_data['autoplaySpeed'] = 2000;
$carousel_data['arrows'] = true;
$carousel_data['dots'] = true;
$carousel_data['dotsClass'] = 'slick-dots-custom';
$carousel_data['pauseOnFocus'] = true;
$carousel_data['pauseOnHover'] = true;

$carousel_json = json_encode($carousel_data);

?>
<section id="media-slider-section-<?php echo $section_id ?>" class="media-slider-section">
    <div class="container">
        <div class="media-slider-wrapper">
            <?php if(!empty($heading)) { ?>
                <h2 class="media-slider-heading">
                    <?php echo '<span>' . $heading . '</span>'; ?>
                </h2>
            <?php } ?>

            <?php if(!empty($list_item)) { ?>
                <div class="carousel-wrapper js-carousel" data-carousel="<?php echo esc_attr($carousel_json); ?>">
                    <?php foreach ($list_item as $key => $item) { ?>
                        <div class="carousel-item">
                            <div class="carousel-inner">
                                <div class="media-item">
                                    <?php if($item['type'] == 'image') { ?>
                                        <?php if(!empty($item['image'])) { ?>
                                            <div class="media-item--inner type-image">
                                                <img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php echo esc_attr($item['image']['title']); ?>"/>
                                            </div>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <?php if(!empty($item['video'])) { ?>
                                            <div class="media-item--inner type-video">
                                                <?php echo $item['video']; ?>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<?php 
// Style
$bg_color = get_sub_field('background_color');
$bg_color = !empty($bg_color) ? $bg_color : '#fff';
$pd_top = get_sub_field('padding_top');
$pd_top = (isset($pd_top) && $pd_top !== '') ? $pd_top . 'px' : '60px';
$pd_bottom = get_sub_field('padding_bottom');
$pd_bottom = (isset($pd_bottom) && $pd_bottom !== '') ? $pd_bottom . 'px' : '60px';

echo '<style>
        #media-slider-section-'. $section_id .' {
            --s-bg-color: ' . $bg_color . ';
            --s-pd-top: ' . $pd_top . ';
            --s-pd-bottom: ' . $pd_bottom . ';
        }
    </style>';