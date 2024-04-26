<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 */

$post_id = get_the_ID();
$summary = dv_get_post_summary($post_id);
?>
<article id="post-<?php echo $post_id ?>" class="result-item">
    <h2 class="__title">
        <span><?php echo get_the_title() ?></span>
    </h2>
    <a class="__link" href="<?php echo get_the_permalink() ?>">
        <span><?php echo get_the_permalink() ?></span>
    </a>
    <div class="__summary"><?php echo $summary ?></div>
</article>
