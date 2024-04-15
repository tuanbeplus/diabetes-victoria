
<?php
/**
 * Displays the Global search popup
 *
 */

$site_logo = get_field('site_logo', 'option');
$logo_full_color = $site_logo['logo_full_color'];
?>
<!-- Global search -->
<div id="global-search-wrapper" class="global-search-wrapper">
    <div class="container">
        <?php echo get_search_form(); ?>
        <div class="search-header">
            <a href="<?php echo home_url(); ?>">
                <img class="site-logo" 
                    src="<?php echo $logo_full_color['url'] ?? ''; ?>" 
                    alt="<?php echo $logo_full_color['alt'] ?? ''; ?>">
            </a>
            <button id="btn-close-search" title="Close Search Popup" aria-label="Close Search Popup">
                <span class="text">Close</span>
                <span class="close-icon btn-small"><i class="fa-solid fa-xmark"></i></span>
            </button>
        </div>
    </div>
</div><!-- .Global search -->
