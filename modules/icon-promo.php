<?php
/**
 * The template for displaying Icon Promo Carousel module
 *
 */

if( get_row_layout() != 'icon-promo' ) {
    return;
}

$heading = get_sub_field('heading');
$ipro_list = get_sub_field('icon_promo_list');

if (empty($heading) && empty($ipro_list)) {
    return;
}

$wrapper_id = rand(0, 999);
$navigation = ($carousel_options['navigation']) ? 'true' : 'false';
$dots       = ($carousel_options['dots']) ? 'true' : 'false';
$autoplay   = ($carousel_options['autoplay']) ? 'true' : 'false';
$autoplay_speed = $carousel_options['autoplay_speed'] ?? '2000';

?>
<section class="icon-promo-carousel-section">
    <div class="container">
        <div class="icon-promo-wrapper">
            <?php if(!empty($heading)) { ?>
                <h1 class="icon-promo-heading">
                    <?php echo $heading; ?>
                </h1>
            <?php } ?>

            <?php if(!empty($ipro_list)) { ?>
                <div id="carousel-wrapper-<?php echo $wrapper_id; ?>" class="carousel-wrapper carousel-wrapper-<?php echo $wrapper_id; ?>">
                    <?php foreach ($carousel_list as $id => $row) {?>
                        <div class="carousel-item item-<?php echo $id; ?>">
                            <div class="carousel-inner container">
                                <div class="carousel-content">
                                    item
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<?php if(!empty($ipro_list)) { ?>
    <script>
        jQuery(document).ready(function($){
            jQuery('.carousel-wrapper-<?php echo $wrapper_id; ?>').slick({
                infinite: false,
                slidesToShow: 1,
                slidesToScroll: 1,
                accessibility: true,
                autoplay: false,
                autoplaySpeed: 2000,
                arrows: false,
                dots: true,
                dotsClass: 'slick-dots container',
                pauseOnFocus: true,
                pauseOnHover: true,
            });
        });
    </script>
<?php } ?>
