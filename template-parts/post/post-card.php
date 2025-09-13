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
            <?php echo get_the_post_thumbnail(get_the_ID(), 'medium'); ?>
        <?php else: ?>
            <?php dv_the_post_thumbnail_default(get_the_ID()) ?>
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
