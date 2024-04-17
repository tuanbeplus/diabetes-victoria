<?php
/**
 * The template for displaying Bespoke Slider module
 *
 */

if( get_row_layout() != 'bespoke_slider' ) {
    return;
}

$heading = get_sub_field('heading');
$list_item = get_sub_field('list_item');

if (empty($heading) && empty($list_item)) {
    return;
}

$carousel_data = array();
$carousel_data['infinite'] = false;
$carousel_data['slidesToShow'] = 8;
$carousel_data['slidesToScroll'] = 8;
$carousel_data['accessibility'] = true;
$carousel_data['autoplay'] = false;
$carousel_data['autoplaySpeed'] = 2000;
$carousel_data['arrows'] = true;
$carousel_data['dots'] = true;
$carousel_data['dotsClass'] = 'slick-dots-custom';
$carousel_data['pauseOnFocus'] = true;
$carousel_data['pauseOnHover'] = true;

$carousel_json = json_encode($carousel_data);

?>
<section class="bespoke-slider-section">
    <div class="container">
        <div class="bespoke-slider-wrapper">
            <?php if(!empty($heading)) { ?>
                <div class="bespoke-slider-heading-wrap">
                    <h1 class="bespoke-slider-heading">
                        <?php echo $heading; ?>
                    </h1>
                </div>
            <?php } ?>

            <?php if(!empty($list_item)) { ?>
                <div class="carousel-wrapper js-carousel" data-carousel="<?php echo esc_attr($carousel_json); ?>">
                    <?php foreach ($list_item as $key => $item) { ?>
                        <div class="carousel-item">
                            <div class="carousel-inner">
                                <div class="bespoke-item <?php if(!empty($item['thumbnail'])) echo 'has-thumbnail'; ?>"> 
                                    <div class="bespoke-item--inner"> 
                                        <?php if(!empty($item['thumbnail'])) { ?>
                                            <div class="bespoke-item--thumbnail">
                                                <img src="<?php echo esc_url($item['thumbnail']['url']); ?>" alt="<?php echo esc_attr($item['thumbnail']['title']); ?>"/>
                                            </div>
                                            
                                        <?php } ?>

                                        <?php if(!empty($item['year'])) { ?>
                                            <div class="bespoke-item--year">
                                                <?php echo $item['year']; ?>
                                            </div>
                                        <?php } ?>

                                        <?php if(!empty($item['description'])) { ?>
                                            <div class="bespoke-item--desc">
                                                <?php echo $item['description']; ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
