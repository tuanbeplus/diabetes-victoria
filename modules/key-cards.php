<?php
/**
 * The template for displaying Key cards module
 *
 */

if( get_row_layout() == 'key_cards' ):
	$title = get_sub_field('title');
	$cards_per_row =  get_sub_field('cards_per_row');
    $hide_in_toc = get_sub_field('hide_in_table_of_contents');
    $cards_list = get_sub_field('cards_list');
    $section_id = rand(0, 999);
    $section_class = '';
    if ($hide_in_toc == true) {
        $section_class = 'hide_in_TOC';
    }

    if (!empty($cards_list)): ?>
        <!-- Key Cards section -->
        <section id="key-cards-section-<?php echo $section_id ?>" class="key-cards <?php echo $section_class ?>">
            <div class="container">
				<?php if (!empty($title)): ?>
					<h2 class="title"><?php echo $title; ?></h2>
				<?php endif; ?>
                <ul class="cards-list">
                <?php foreach ($cards_list as $index => $row): 
                    $card = $row['card'] ?? '';
                    $brand_color = ($card['brand_color'] !== '') ? $card['brand_color'] : 'var(--secondary-color)';
                    $cta_color = ($card['brand_color'] !== '') ? $card['brand_color'] : 'var(--tertiary-color)';
                    
                    // Get medium_large image size if available
                    $img_url = DV_IMG_DIR . 'DV-placeholder-img.png';
                    $img_alt = '';
                    if (!empty($card['image']) && !empty($card['image']['ID'])) {
                        $img_data = wp_get_attachment_image_src($card['image']['ID'], 'medium_large');
                        if ($img_data && isset($img_data[0])) {
                            $img_url = $img_data[0];
                        } elseif (!empty($card['image']['url'])) {
                            $img_url = $card['image']['url'];
                        }
                        $img_alt = $card['image']['alt'] ?? '';
                    } elseif (!empty($card['image']['url'])) {
                        $img_url = $card['image']['url'];
                        $img_alt = $card['image']['alt'] ?? '';
                    }

                    $landing_page_name = !empty($card['landing_page_name']) ? $card['landing_page_name'] : $card['landing_page_link'];
                    $landing_page_link = $card['landing_page_link'] ?? '';
                    $title = $card['title'] ?? '';
                    $description = $card['description'] ?? '';
                    $cta_text = !empty($card['cta_text']) ? $card['cta_text'] : 'Learn more';
                    $cta_link = $card['cta_link'] ?? '';
                    if (!empty($card)):
                        ?>
                        <li id="card-<?php echo $index; ?>" class="card" <?php if ($cards_per_row == 2) echo 'style="max-width:540px;"';?> >
                            <div class="card-body">
                                <div class="card-img">
                                    <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($img_alt); ?>" loading="lazy">
                                </div>
                                <div class="card-content">
                                    <?php if (!empty($landing_page_link)): ?>
                                        <h3 class="landing-page">
                                            <a href="<?php echo $landing_page_link; ?>"><?php echo $landing_page_name; ?></a>
                                        </h3>
                                    <?php endif; ?>

                                    <?php if (!empty($title)): ?>
                                        <h3 class="card-title"><?php echo $title; ?></h3>
                                    <?php endif; ?>

                                    <?php if (!empty($description)): ?>
                                        <div class="card-description"><?php echo $description; ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php if (!empty($cta_link)): ?>
                                <div class="card-cta">
                                    <a class="cta-btn" href="<?php echo $cta_link; ?>">
                                        <span><?php echo $cta_text; ?></span>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <style>
                                <?php 
                                    $duration_str = '0.'.$index;
                                    $duration = 0.4 + (float)$duration_str;
                                ?>
                                #key-cards-section-<?php echo $section_id; ?> #card-<?php echo $index; ?> {
                                    animation-duration: <?php echo $duration.'s'; ?>;
                                }
                                #key-cards-section-<?php echo $section_id; ?> #card-<?php echo $index; ?> .landing-page {
                                    color: <?php echo $brand_color ?>!important;
                                }
                                #key-cards-section-<?php echo $section_id; ?> #card-<?php echo $index; ?> .landing-page a {
                                    color: <?php echo $brand_color ?>!important;
                                }
                                #key-cards-section-<?php echo $section_id; ?> #card-<?php echo $index; ?> .card-content a {
                                    color: <?php echo $brand_color ?>!important;
                                }
                                #key-cards-section-<?php echo $section_id; ?> #card-<?php echo $index; ?> .card-cta a {
                                    border: 2px solid <?php echo $cta_color ?>!important;
                                    background-color: <?php echo $cta_color ?>!important;
                                }
                                #key-cards-section-<?php echo $section_id; ?> #card-<?php echo $index; ?> .card-cta a:hover {
                                    color: <?php echo $cta_color; ?>!important;
                                    box-shadow: inset 400px 0 0 0 #fff!important;
                                }
                            </style><!-- .Custom brand color -->
                        </li><!-- .Card -->
                    <?php endif; ?>
                <?php endforeach; ?>
                </ul><!-- .Card list -->
            </div>
        </section><!-- .Key Cards section -->
        <?php
        // Style
        $bg_color = get_sub_field('background_color');
        $bg_color = !empty($bg_color) ? $bg_color : '';
        $pd_top = get_sub_field('padding_top');
        $pd_top = (isset($pd_top) && $pd_top !== '') ? $pd_top . 'px' : '0';
        $pd_bottom = get_sub_field('padding_bottom');
        $pd_bottom = (isset($pd_bottom) && $pd_bottom !== '') ? $pd_bottom . 'px' : '70px';
        $title_font_size =  get_sub_field('title_font_size');
        $title_font_size = (isset($title_font_size) && $title_font_size !== '') ? $title_font_size . 'rem' : '1.688rem';
        $cards_per_row = (isset($cards_per_row) && $cards_per_row !== '') ? $cards_per_row : '3';
        
        echo '<style>
                #key-cards-section-'.$section_id.' {
                    --s-bg-color: ' . $bg_color . ';
                    --s-pd-top: ' . $pd_top . ';
                    --s-pd-bottom: ' . $pd_bottom . ';
                    --card-title-size: ' . $title_font_size . ';
                    --card-per-row: ' . $cards_per_row . ';
                }
            </style>';
    endif;
endif;