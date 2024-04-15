<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 */

$keysearch = $_GET['s'] ? trim($_GET['s']) : '';
$key_highligh = "<b>".$keysearch."</b>";

//Content
$page_builder = get_field('page_builder');
$content = '';
foreach ($page_builder as $key => $builder) {
	if($builder['acf_fc_layout'] == 'content_promo'){
		$content = $builder['content'];
	}
}

$content = wp_trim_words( $content , 35, '(...)' );
$content = str_replace($keysearch, $key_highligh , $content);
?>
<article id="post-<?php the_ID() ?>" class="result-item">

    <h2 class="__title">
        <span><?php echo get_the_title() ?></span>
    </h2>

    <a class="__link" href="<?php echo get_the_permalink() ?>">
        <span><?php echo get_the_permalink() ?></span>
    </a>

    <div class="__summary">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sem veniamue cil sint occaecat
        cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laboru
        <?php echo $content ?>
    </div>

</article>
