<?php
/**
 * The template for displaying Icon Promo Carousel module
 *
 */

if( get_row_layout() != 'icon_promo_carousel' ) {
    return;
}

$heading = get_sub_field('heading');
$list_item = get_sub_field('list_item');

if (empty($heading) && empty($list_item)) {
    return;
}

$carousel_data = array();
$carousel_data['infinite'] = false;
$carousel_data['slidesToShow'] = 3;
$carousel_data['slidesToScroll'] = 1;
$carousel_data['accessibility'] = true;
$carousel_data['autoplay'] = false;
$carousel_data['autoplaySpeed'] = 2000;
$carousel_data['arrows'] = true;
$carousel_data['dots'] = true;
$carousel_data['pauseOnFocus'] = true;
$carousel_data['pauseOnHover'] = true;
$carousel_data['responsive'] = array(
    array(
        'breakpoint' => 1023,
        'settings' => array(
            'slidesToShow' => 2
        )
    ),
    array(
        'breakpoint' => 767,
        'settings' => array(
            'slidesToShow' => 1
        )
    ),
);

$carousel_json = json_encode($carousel_data);

?>
<section class="ipro-carousel-section">
    <div class="container">
        <div class="ipro-carousel-wrapper">
            <?php if(!empty($heading)) { ?>
                <h1 class="ipro-heading">
                    <?php echo $heading; ?>
                </h1>
            <?php } ?>

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
