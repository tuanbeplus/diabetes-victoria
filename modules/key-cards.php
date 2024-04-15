<?php
/**
 * The template for displaying Key cards module
 *
 */

if( get_row_layout() == 'key_cards' ):
    $cards_list = get_sub_field('cards_list');
    if (!empty($cards_list)):
        ?>
        <section class="key-cards">
            <div class="container">
                <ul class="cards-list">
                <?php foreach ($cards_list as $index => $row): 
                    $card = $row['card'] ?? '';
                    $brand_color = $card['brand_color'] ?? '#019BC2';
                    $img_url = !empty($card['image']['url']) ? $card['image']['url'] : DV_IMG_DIR.'card-img-placeholder';
                    $img_alt = $card['image']['alt'] ?? '';
                    $landing_page_name = !empty($card['landing_page_name']) ? $card['landing_page_name'] : $card['landing_page_link'];
                    $landing_page_link = $card['landing_page_link'] ?? '';
                    $title = $card['title'] ?? '';
                    $description = $card['description'] ?? '';
                    $cta_text = !empty($card['cta_text']) ? $card['cta_text'] : 'Learn more';
                    $cta_link = $card['cta_link'] ?? '';
                    if (!empty($card)):
                        ?>
                        <li id="card-<?php echo $index; ?>" class="card">
                            <div class="card-body">
                                <div class="card-img">
                                    <img src="<?php echo $img_url; ?>" alt="<?php echo $img_alt; ?>" loading="lazy">
                                </div>
                                <div class="card-content">
                                    <?php if (!empty($landing_page_link)): ?>
                                        <div class="landing-page">
                                            <a href="<?php echo $landing_page_link; ?>">
                                                <span><?php echo $landing_page_name; ?></span>
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($title): ?>
                                        <h2 class="card-title"><?php echo $title; ?></h2>
                                    <?php endif; ?>

                                    <?php if ($description): ?>
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
                                #card-<?php echo $index; ?> .landing-page a::after {
                                    background-color: <?php echo $brand_color ?>!important;
                                }
                                #card-<?php echo $index; ?> .card-content a {
                                    color: <?php echo $brand_color ?>!important;
                                }
                                #card-<?php echo $index; ?> .card-cta a {
                                    border: 2px solid <?php echo $brand_color ?>!important;
                                    background-color: <?php echo $brand_color ?>!important;
                                }
                                #card-<?php echo $index; ?> .card-cta a:hover {
                                    color: <?php echo $brand_color; ?>!important;
                                    box-shadow: inset 200px 0 0 0 #fff!important;
                                }
                            </style><!-- .Custom brand color -->
                        </li><!-- .Card -->
                    <?php endif; ?>
                <?php endforeach; ?>
                </ul><!-- .Card list -->
            </div>
        </section>
        <?php
    endif;
endif;