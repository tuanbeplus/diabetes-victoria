<?php
/**
 * The template for displaying Contact Us module
 *
 */

if( get_row_layout() != 'contact_us' ) {
    return;
}

$heading = get_sub_field('heading');
$content = get_sub_field('content');
$social_title = get_sub_field('social_title');
$social_items = get_sub_field('social_items');
$button_text = get_sub_field('button_text');
$button_link = get_sub_field('button_link');

?>
<section class="contact-us-section">
    <div class="container">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="574px" height="631px" viewBox="0 0 574 631" version="1.1">
            <path d="M286.688536,0 L286.577902,0 C128.301435,0 0,121.530741 0,271.455998 L0,271.511321 C0,391.472273 82.1668526,493.176643 196.092718,529.081253 C209.81831,534.620466 221.158345,543.126373 216.138305,564.978947 L200.960636,631 L253.518933,586.292122 C271.780539,570.953828 305.973511,547.904894 336.978826,538.721281 C471.275268,516.197916 573.321755,405.171624 573.321755,271.511321 L573.321755,271.455998 C573.321755,121.530741 444.971918,0 286.688536,0" id="path-1"/>
        </svg>
        
        <div class="ctu-wrapper">
            <?php if(!empty($heading)) { ?>
                <h2 class="ctu-heading">
                    <?php echo '<span>' . $heading . '</span>'; ?>
                </h2>
            <?php } ?>
            <div class="ctu-content-wrap">
                <div class="ctu-content-col">
                    <?php if(!empty($content)) { ?>
                        <div class="ctu-content">
                            <?php echo $content; ?>
                        </div>
                    <?php } ?>
                    
                    <?php if(!empty($button_text)) { ?>
                        <a class="ctu-button" href="<?php echo esc_url($button_link); ?>">
                            <?php echo '<span>' . $button_text . '</span>'; ?>
                        </a> 
                    <?php } ?>
                </div>

                <div class="ctu-social-col">
                    <?php if(!empty($social_title)) { ?>
                        <h3 class="ctu-social-title">
                            <?php echo '<span>' . $social_title . '</span>'; ?>
                        </h3>
                    <?php } ?>
                    
                    <?php if(!empty($social_items)) { ?>
                        <ul class="ctu-social-list">
                            <?php foreach($social_items as $item) { ?>
                                <li>
                                    <a href="<?php echo esc_url($item['link']); ?>" target="_blank">
                                        <?php echo '<span>' . $item['title'] . '</span>'; ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
