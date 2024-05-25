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
$cat_img_url = DV_IMG_DIR .'recipe-feature-img-default.jpeg';
$recipe_cat = 'recipe_categories';
$recipe_cat_terms = get_terms( array(
    'taxonomy'   => $recipe_cat,
    'hide_empty' => true,
));
?>
<!-- Page Title -->
<section class="post-title">
    <div class="container">
        <?php the_archive_title( '<h1>', '</h1>' ); ?>
    </div>
</section><!-- .Page Title -->
<section class="main-content recipe-archive">
    <div class="main-content-inner has-sidebar">
        <!-- Sidebar -->
        <div id="main-content-sidebar" class="sidebar">
            <div class="sidebar-inner">
                <?php if (!empty($recipe_cat_terms) && !is_wp_error($recipe_cat_terms)): ?>
                    <div class="secondary-info">
                        <h2 class="__heading">More Recipes:</h2>
                        <ul class="recipe-cats-list" role="list">
                        <?php foreach ($recipe_cat_terms as $term): 
                            $term_link = get_term_link($term); ?>
                            <li>
                                <a href="<?php echo esc_url($term_link); ?>"><?php echo $term->name ?? ''; ?></a>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div><!-- .Sidebar -->
        <!-- Content -->
        <div class="content-wrapper">
            <img class="__banner" src="<?php echo $cat_img_url ?>" alt="Recipe Category Image">
            <?php if ( !empty($description) ): ?>
                <div class="__content archive-desc">
                    <?php echo wp_kses_post( wpautop( $description ) ); ?>
                </div>
            <?php endif; ?>
        </div><!-- .Content -->
    </div>
</section>
<!-- Latest Recipes -->
<section class="latest-posts recipe" style="padding-top:0;">
    <div class="container">
        <div class="posts-wrapper">
            <div class="top">
                <h2 class="heading">Latest Recipes</h2>
            </div>
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
    </div>
</section><!-- .Latest Recipes -->
<?php
get_footer();