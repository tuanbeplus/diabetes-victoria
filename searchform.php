<?php
/**
 * The searchform.php template.
 *
 * Used any time that get_search_form() is called.
 *
 * @link https://developer.wordpress.org/reference/functions/get_search_form/
 *
 * @package WordPress
 */

$suggestions = get_field('suggestions', 'option');
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="form-wrapper">
        <label>
            <input type="search" class="search-field-input" 
                    placeholder="<?php echo esc_attr_x( 'Enter a search term', 'placeholder' ); ?>" 
                    name="s" 
                    value="<?php echo esc_attr( get_search_query() ); ?>" 
                    title="<?php _ex( 'Search for:', 'label' ); ?>">
        </label>
        <button type="submit" class="search-submit-btn" aria-label="Search">
            <span class="search-icon"><?php echo dv_get_icon_svg('icon-search'); ?></span>
        </button>
    </div>
    <?php if (!empty($suggestions)): ?>
        <div class="form-suggest">
            Suggestions: 
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