<?php
/**
 * The template for displaying Partner logos module
 *
 */

if( get_row_layout() == 'partner_logos' ):

    $logos_list = get_sub_field('logos_list');
    
    if (!empty($logos_list)): ?>
        <section class="partner-logos">
            <div class="container">
                <div class="logos">
                <?php foreach ($logos_list as $row): 
                    $logo = $row['logo_image'];
                    ?>
                    <?php if (!empty($logo['url'])): ?>
                        <div class="logo">
                            <img src="<?php echo $logo['url']; ?>" alt="<?php echo $logo['alt']; ?>">
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php  
    // Style
    $bg_color = get_sub_field('background_color');
    $bg_color = !empty($bg_color) ? $bg_color : '#fff';
    $pd_top = get_sub_field('padding_top');
    $pd_top = (isset($pd_top) && $pd_top !== '') ? $pd_top . 'px' : '90px';
    $pd_bottom = get_sub_field('padding_bottom');
    $pd_bottom = (isset($pd_bottom) && $pd_bottom !== '') ? $pd_bottom . 'px' : '90px';
    
    echo '<style>
            section.partner-logos {
                --s-bg-color: ' . $bg_color . ';
                --s-pd-top: ' . $pd_top . ';
                --s-pd-bottom: ' . $pd_bottom . ';
            }
        </style>';
    endif;
endif;