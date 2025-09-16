<?php
/**
 * The template for displaying Partner logos module
 *
 */

if( get_row_layout() == 'members_list' ):

    $section_id = rand(0, 999);
    $title = get_sub_field('title');
    $members_list = get_sub_field('list');
    
    if (!empty($members_list)): ?>
        <!-- Members List section -->
        <section id="members-list-<?php echo $section_id; ?>" class="members-list-section">
            <div class="container">
                <div class="members-list-wrapper">
                    <?php if (!empty($title)): ?>
                        <h2 class="title"><?php echo $title ?></h2>
                    <?php endif; ?>
                    <ul class="members-list">
                    <?php foreach ($members_list as $member): 
                        // Get image ID if available, else fallback to URL or placeholder
                        $image_field = $member['member_info']['image'] ?? '';
                        $img_url = DV_IMG_DIR . 'user-placeholder.jpeg';
                        if (!empty($image_field)) {
                            // If it's an array with ID (ACF image field), get medium size
                            if (is_array($image_field) && !empty($image_field['ID'])) {
                                $img_array = wp_get_attachment_image_src($image_field['ID'], 'medium');
                                if ($img_array && !empty($img_array[0])) {
                                    $img_url = $img_array[0];
                                }
                            } elseif (is_numeric($image_field)) {
                                // If it's just an ID
                                $img_array = wp_get_attachment_image_src($image_field, 'medium');
                                if ($img_array && !empty($img_array[0])) {
                                    $img_url = $img_array[0];
                                }
                            } elseif (is_string($image_field)) {
                                // If it's a URL string, use as is (no resizing possible)
                                $img_url = $image_field;
                            }
                        }
                        $name = $member['member_info']['name'] ?? '';
                        $qualifications = $member['member_info']['qualifications'] ?? '';
                        $description = $member['member_description'] ?? '';
                        ?>
                        <li class="member">
                            <div class="__img">
                                <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($name) ?>">
                            </div>
                            <div class="__info">
                                <?php if (!empty($name)): ?>
                                    <h3 class="name"><?php echo $name ?></h3>
                                <?php endif; ?>
                                <?php if (!empty($qualifications)): ?>
                                    <p class="qualifi"><?php echo $qualifications ?></p>
                                <?php endif; ?>
                                <?php if (!empty($description)): ?>
                                    <div class="desc"><?php echo $description ?></div>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </section><!-- .Members List section -->
    <?php  
    // Style
    $bg_color = get_sub_field('background_color');
    $bg_color = !empty($bg_color) ? $bg_color : '#fff';
    $pd_top = get_sub_field('padding_top');
    $pd_top = (isset($pd_top) && $pd_top !== '') ? $pd_top . 'px' : '0';
    $pd_bottom = get_sub_field('padding_bottom');
    $pd_bottom = (isset($pd_bottom) && $pd_bottom !== '') ? $pd_bottom . 'px' : '60px';
    
    echo '<style>
            #members-list-'. $section_id .' {
                --s-bg-color: ' . $bg_color . ';
                --s-pd-top: ' . $pd_top . ';
                --s-pd-bottom: ' . $pd_bottom . ';
            }
        </style>';
    endif;
endif;