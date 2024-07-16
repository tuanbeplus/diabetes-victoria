<?php
/**
 * The template for displaying FAQs module
 *
 */

if( get_row_layout() != 'faqs' ) {
    return;
}

$section_id = rand(0, 999);
$heading = get_sub_field('heading');
$description = get_sub_field('description');
$faqs = get_sub_field('faqs');

if (empty($heading) && empty($faqs)) {
    return;
}
?>
<!-- FAQs section -->
<section id="faqs-section-<?php echo $section_id ?>" class="faqs-section">
    <div class="container">
        <div class="faqs-wrapper">
            <?php if(!empty($heading)) { ?>
                <h2 class="faqs-heading">
                    <?php echo '<span>' . $heading . '</span>'; ?>
                </h2>
            <?php } ?>

            <?php if (!empty($description)): ?>
                <div class="faqs-desc dv-editor-content">
                    <?php echo $description; ?>
                </div>
            <?php endif; ?>

            <?php if(!empty($faqs)) { ?>
                <div class="accordion js-accordion" role="tablist" aria-live="polite" data-behavior="accordion">
                    <?php foreach($faqs as $key => $item) { ?>
                        <div class="accordion__item js-show-item-default" data-binding="expand-accordion-item">
                            <div id="<?php echo 'tab' . $key; ?>" class="accordion__title" tabindex="0" aria-controls="<?php echo 'panel' . $key; ?>" role="tab" aria-selected="false" aria-expanded="false" data-binding="expand-accordion-trigger">
                                <h3 class="heading"><?php echo $item['heading']; ?></h3>
                                <span class="chevron-down-icon">
                                    <?php echo dv_get_icon_svg('chevron-down-blu-thin-icon'); ?>
                                </span>
                            </div>

                            <div id="<?php echo 'panel' . $key; ?>" class="accordion__content" role="tabpanel" aria-hidden="true" aria-labelledby="tab5" data-binding="expand-accordion-container">
                                <div class="accordion__content-inner">
                                    <?php echo $item['content']; ?>
                                </div>
                            </div> 
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</section><!-- .FAQs section -->

<?php 
// Style
$bg_color = get_sub_field('background_color');
$bg_color = !empty($bg_color) ? $bg_color : 'var(--post-bg-color, #F5FBFD)';
$pd_top = get_sub_field('padding_top');
$pd_top = (isset($pd_top) && $pd_top !== '') ? $pd_top . 'px' : '0';
$pd_bottom = get_sub_field('padding_bottom');
$pd_bottom = (isset($pd_bottom) && $pd_bottom !== '') ? $pd_bottom . 'px' : '60px';

echo '<style>
        #faqs-section-'. $section_id .' {
            --s-bg-color: ' . $bg_color . ';
            --s-pd-top: ' . $pd_top . ';
            --s-pd-bottom: ' . $pd_bottom . ';
        }
    </style>';