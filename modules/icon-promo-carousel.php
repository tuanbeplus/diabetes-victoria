<?php
/**
 * The template for displaying Icon Promo Carousel module
 *
 */

if( get_row_layout() != 'icon_promo_carousel' ) {
    return;
}

$section_id = rand(0, 999);
$heading = get_sub_field('heading');
$link_text = get_sub_field('link_text');
$link_url = get_sub_field('link_url');
$list_item = get_sub_field('list_item');

if (empty($heading) && empty($list_item)) {
    return;
}

$carousel_data = array();
$carousel_data['infinite'] = false;
$carousel_data['slidesToShow'] = 3;
$carousel_data['slidesToScroll'] = 3;
$carousel_data['accessibility'] = true;
$carousel_data['autoplay'] = false;
$carousel_data['autoplaySpeed'] = 2000;
$carousel_data['arrows'] = true;
$carousel_data['dots'] = true;
$carousel_data['dotsClass'] = 'slick-dots-custom';
$carousel_data['pauseOnFocus'] = true;
$carousel_data['pauseOnHover'] = true;
$carousel_data['responsive'] = array(
    array(
        'breakpoint' => 1023,
        'settings' => array(
            'slidesToShow' => 2,
            'slidesToScroll' => 2
        )
    ),
    array(
        'breakpoint' => 767,
        'settings' => array(
            'slidesToShow' => 1,
            'slidesToScroll' => 1
        )
    ),
);

$carousel_json = json_encode($carousel_data);

?>
<section id="ipro-carousel-section-<?php echo $section_id ?>" class="ipro-carousel-section">
    <div class="container">
        <div class="ipro-carousel-wrapper">
            <div class="ipro-heading-wrap">
                <?php if(!empty($heading)) { ?>
                    <h2 class="ipro-heading">
                        <?php echo '<span>' . $heading . '</span>'; ?>
                    </h2>
                <?php } ?>
                <?php if(!empty($link_url)) { ?>
                    <div class="ipro-link">
                        <a href="<?php echo esc_url($link_url); ?>" class="ipro-find-out-more">
                            <span><?php echo !empty($link_text) ? $link_text : __('Find out more', 'diabetes-victoria'); ?></span>
                        </a>
                    </div>
                <?php } ?>
            </div>

            <?php if(!empty($list_item)) { ?>
                <div class="carousel-wrapper js-carousel" data-carousel="<?php echo esc_attr($carousel_json); ?>">
                    <?php foreach ($list_item as $key => $item) {?>
                        <div class="carousel-item">
                            <div class="carousel-inner">
                                <div class="ipro-item">
                                    <?php if(!empty($item['icon'])) { ?>
                                        <div class="ipro-item--icon">
                                            <img src="<?php echo esc_url($item['icon']['url']); ?>" alt="<?php echo esc_attr($item['icon']['title']); ?>"/>
                                        </div>
                                        
                                    <?php } ?>

                                    <?php if(!empty($item['content'])) { ?>
                                        <div class="ipro-item--content">
                                            <?php echo $item['content']; ?>
                                        </div>
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
$bg_color = !empty($bg_color) ? $bg_color : '#F5FBFD';
$pd_top = get_sub_field('padding_top');
$pd_top = (isset($pd_top) && $pd_top !== '') ? $pd_top . 'px' : '60px';
$pd_bottom = get_sub_field('padding_bottom');
$pd_bottom = (isset($pd_bottom) && $pd_bottom !== '') ? $pd_bottom . 'px' : '60px';

echo '<style>
        #ipro-carousel-section-'. $section_id .' {
            --s-bg-color: ' . $bg_color . ';
            --s-pd-top: ' . $pd_top . ';
            --s-pd-bottom: ' . $pd_bottom . ';
        }
    </style>';
