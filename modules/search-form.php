<?php
/**
 * The template for displaying Search Form module
 *
 */

if( get_row_layout() == 'search_form' ):
    $heading = get_sub_field('heading');
    $input_plh = get_sub_field('input_placeholder');
    $suggestions = get_sub_field('suggestions');
    $section_id = rand(0, 999);
    ?>
    <section id="search-section-<?php echo $section_id; ?>" class="search-section">
        <div class="container">
            <h2 class="heading"><span><?php echo $heading; ?></span></h2>
            <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <div class="form-wrapper">
                    <label>
                        <input type="search" class="search-field-input" 
                                placeholder="<?php echo esc_attr_x( $input_plh, 'placeholder' ); ?>" 
                                name="s" 
                                value="<?php echo esc_attr( get_search_query() ); ?>" 
                                title="<?php _ex( 'Search for:', 'label' ); ?>">
                    </label>
                    <button type="submit" class="search-submit-btn" aria-label="Search">
                        <span>Show reults</span>
                    </button>
                </div>
                <?php if (!empty($suggestions)): ?>
                    <div class="form-suggest">
                        <span>Suggestions: </span>
                        <ul class="suggest-list">
                        <?php $count = count($suggestions); ?> 
                        <?php foreach($suggestions as $index => $suggest): ?>
                            <li class="suggest">
                                <a href="/?s=<?php echo $suggest['suggest_text']; ?>">
                                    <span><?php echo $suggest['suggest_text']; ?></span>
                                </a>
                                <?php if ($index < $count - 1) echo ', '; ?>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </section>
    <?php
    // Style
    $bg_color = get_sub_field('background_color');
    $bg_color = !empty($bg_color) ? $bg_color : '#fff';
    $pd_top = get_sub_field('padding_top');
    $pd_top = (isset($pd_top) && $pd_top !== '') ? $pd_top . 'px' : '60px';
    $pd_bottom = get_sub_field('padding_bottom');
    $pd_bottom = (isset($pd_bottom) && $pd_bottom !== '') ? $pd_bottom . 'px' : '100px';
    
    echo '<style>
            #search-section-'.$section_id.' {
                --s-bg-color: ' . $bg_color . ';
                --s-pd-top: ' . $pd_top . ';
                --s-pd-bottom: ' . $pd_bottom . ';
            }
        </style>';
endif;