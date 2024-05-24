<?php
/**
 * The template for displaying Archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();

$description = get_the_archive_description();
?>
<section class="post-title">
    <div class="container">
        <?php the_archive_title( '<h1>', '</h1>' ); ?>
        <?php if ( !empty($description) ) : ?>
            <div class="archive-desc"><?php echo wp_kses_post( wpautop( $description ) ); ?></div>
        <?php endif; ?>
    </div>
</section><!-- .page-header -->
<section class="post-archive">
    <div class="container">
        <?php if ( have_posts() ) : ?>
            <ul class="posts-list">
            <?php while ( have_posts() ) : the_post(); ?>
                <?php get_template_part( 'template-parts/post/post-card' ); ?>
            <?php endwhile; ?>
            </ul>
        <?php else : ?>
            <?php get_template_part( 'template-parts/content/content-none' ); ?>
        <?php endif; ?>
        <?php 
            // Reset Post Data
            wp_reset_postdata();
         ?>
    </div>
</section>
<?php
get_footer();