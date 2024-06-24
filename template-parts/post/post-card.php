<?php
/**
 * The template for Post Card
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 */
?>
<li class="post post-<?php the_ID() ?>">
    <div class="__thumb">
        <?php if (!empty(get_the_post_thumbnail(get_the_ID()))): ?>
            <?php echo get_the_post_thumbnail(get_the_ID(), 'full'); ?>
        <?php else: ?>
            <?php if( get_post_type() == 'recipe' ): ?>
                <img src="<?php echo DV_IMG_DIR .'recipe-feature-img-default.jpeg'; ?>" 
                    alt="<?php echo $feature_img_alt_default ?>">
            <?php elseif( get_post_type() == 'resource' ): ?>
                <?php 
                $the_terms = get_the_terms( get_the_ID(), 'resource_categories' );
                $terms_slug = array();
                if( $the_terms && ! is_wp_error( $the_terms ) ){
                    foreach ( $the_terms as $term ) {
                        $terms_slug[] = $term->slug;
                    }
                }
                ?>
                <?php if( in_array( 'podcasts', $terms_slug ) ): ?>
                    <img src="<?php echo DV_IMG_DIR .'resource-feature-img-default.png'; ?>" 
                    alt="<?php echo $feature_img_alt_default ?>">
                <?php else: ?>
                    <img src="<?php echo DV_IMG_DIR .'card-img-placeholder.png'; ?>" 
                    alt="<?php echo $feature_img_alt_default ?>">
                <?php endif; ?>
            <?php else: ?>
                <img src="<?php echo DV_IMG_DIR .'card-img-placeholder.png'; ?>" 
                    alt="<?php echo $feature_img_alt_default ?>">
            <?php endif;?>
        <?php endif; ?>
    </div>
    <div class="post-meta">
        <div class="__title">
            <a href="<?php echo get_the_permalink(); ?>">
                <span><?php echo get_the_title() ?></span>
            </a>
        </div>
    </div>
</li>
