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
    endif;
endif;