<?php
/**
 * The template for displaying FAQs module
 *
 */

if( get_row_layout() != 'faqs' ) {
    return;
}

$heading = get_sub_field('heading');
$faqs = get_sub_field('faqs');

if (empty($heading) && empty($faqs)) {
    return;
}

?>
<section class="faqs-section">
    <div class="container">
        <div class="faqs-wrapper">
            <?php if(!empty($heading)) { ?>
                <h1 class="faqs-heading">
                    <?php echo $heading; ?>
                </h1>
            <?php } ?>

            <?php if(!empty($faqs)) { ?>
                <div class="accordion js-accordion" role="tablist" aria-live="polite" data-behavior="accordion">
                    <?php foreach($faqs as $key => $item) { ?>
                        <div class="accordion__item js-show-item-default" data-binding="expand-accordion-item">
                            <div id="<?php echo 'tab' . $key; ?>" tabindex="0" class="accordion__title" aria-controls="panel5" role="tab" aria-selected="false" aria-expanded="false" data-binding="expand-accordion-trigger">
                                <h5><?php echo $item['heading']; ?></h5>
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
</section>
