<?php
/**
 * The template for displaying Single Column Content module
 *
 */

if( get_row_layout() == 'single_column_content' ):
    // Content
    $section_id = rand(0, 999);
    $title = get_sub_field('title');
    $content_editor = get_sub_field('content_editor');

    if (!empty($content_editor)): ?>
        <!-- Single Column Content section -->
        <section id="main-content-<?php echo $section_id; ?>" class="main-content">
            <div class="main-content-inner">
                <!-- Content -->
                <div class="content-wrapper">
                    <div class="__content">
                        <?php if(!empty($title)) echo '<h2 class="__title">'.$title.'</h2>'; ?>
                        <?php echo dv_clean_html_content_editor($content_editor); ?>
                    </div>
                </div><!-- .Content -->
            </div>
        </section><!-- .Single Column Content section -->
        <?php
        // Style
        $bg_color = get_sub_field('background_color');
        $bg_color = !empty($bg_color) ? $bg_color : '';
        $pd_top = get_sub_field('padding_top');
        $pd_top = (isset($pd_top) && $pd_top !== '') ? $pd_top . 'px' : '0';
        $pd_bottom = get_sub_field('padding_bottom');
        $pd_bottom = (isset($pd_bottom) && $pd_bottom !== '') ? $pd_bottom . 'px' : '60px';
        
        echo '<style>
                #main-content-'. $section_id .' {
                    --s-bg-color: ' . $bg_color . ';
                    --s-pd-top: ' . $pd_top . ';
                    --s-pd-bottom: ' . $pd_bottom . ';
                }
            </style>';
    endif;
endif;