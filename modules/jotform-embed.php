<?php
/**
 * The template for displaying FAQs module
 *
 */

if( get_row_layout() != 'jotform_embed' ) {
    return;
}

$section_id = rand(0, 999);
$form_embed_snipet = get_sub_field('form_embed_snipet');

if (empty($form_embed_snipet)) {
    return;
}
?>
<!-- Form Embed Section -->
<section id="form-embed-section-<?php echo $section_id ?>" class="form-embed-section">
    <div class="container">
        <div class="form-wrapper">
            <?php echo $form_embed_snipet ?>
        </div>
    </div>
</section><!-- .Form Embed Section -->

<?php 
// Style
$bg_color = get_sub_field('background_color');
$bg_color = !empty($bg_color) ? $bg_color : '#F5FBFD';
$pd_top = get_sub_field('padding_top');
$pd_top = (isset($pd_top) && $pd_top !== '') ? $pd_top . 'px' : '0';
$pd_bottom = get_sub_field('padding_bottom');
$pd_bottom = (isset($pd_bottom) && $pd_bottom !== '') ? $pd_bottom . 'px' : '60px';

echo '<style>
        #form-embed-section-'. $section_id .' {
            --s-bg-color: ' . $bg_color . ';
            --s-pd-top: ' . $pd_top . ';
            --s-pd-bottom: ' . $pd_bottom . ';
        }
        body section.post-title {
            padding-bottom: 0;
        }
    </style>';