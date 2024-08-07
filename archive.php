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

// Get current taxonomy
$queried_object = get_queried_object();
$taxonomy = !empty( $queried_object )? $queried_object->taxonomy : 'category';

$post_terms = get_terms( array(
    'taxonomy'   => $taxonomy,
    'hide_empty' => true,
));
$post_cat_terms = array();
$child_terms = array();
if( !empty($post_terms) && !is_wp_error($post_terms) ){
    foreach ($post_terms as $term) {
        if ($term->parent == 0) {
            $post_cat_terms[] = $term;
        }
        else {
            $child_terms[$term->parent][] = $term;
        }
    }
}

$description = get_the_archive_description();
$featured_image = get_field('featured_image', get_queried_object());
$cat_img_url = $featured_image['url'] ?? '';
$cat_img_alt = $featured_image['alt'] ?? '';

$post_type = get_post_type_object(get_post_type());
$post_type_label = $post_type->label ?? 'Posts';

$args = array(
    'post_type' => get_post_type(),
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'tax_query' => array(
        array(
            'taxonomy' => $taxonomy,
            'field' => 'term_id',
            'terms' => $queried_object->term_id,
        ),
    )
);
$posts_query = new WP_Query($args);

?>
<!-- Page Title -->
<section class="post-title">
    <div class="container">
        <?php the_archive_title( '<h1>', '</h1>' ); ?>
    </div>
</section><!-- .Page Title -->
<section class="main-content post-archive">
    <div class="main-content-inner has-sidebar">
        <!-- Sidebar -->
        <div id="main-content-sidebar" class="sidebar">
            <div class="sidebar-inner">
                <?php if (!empty($post_cat_terms) && !is_wp_error($post_cat_terms)): ?>
                    <div class="secondary-info">
                        <h2 class="__heading">
                            <?php echo 'More '. $post_type_label; ?>
                        </h2>
                        <ul class="post-cats-list" role="list">
                        <?php foreach ($post_cat_terms as $term): 
                            $term_link = get_term_link($term); ?>
                            <li>
                                <a href="<?php echo esc_url($term_link); ?>"><?php echo $term->name ?? ''; ?></a>
                                <?php if (isset($child_terms[$term->term_id]) && !empty($child_terms[$term->term_id])): ?>
                                    <ul class="child-terms">
                                    <?php foreach ($child_terms[$term->term_id] as $child_term): ?>
                                        <li>
                                            <a href="<?php echo esc_url(get_term_link($child_term)); ?>">
                                                <?php echo $child_term->name ?? ''; ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div><!-- .Sidebar -->
        <!-- Content -->
        <div class="content-wrapper">
            <?php if (!empty($cat_img_url)): ?>
                <img class="__banner" src="<?php echo $cat_img_url ?>" alt="<?php echo $cat_img_alt ?>">
            <?php else: ?>
                <?php dv_the_post_thumbnail_default($post->ID) ?>
            <?php endif; ?>
            <?php if ( !empty($description) ): ?>
                <div class="__content archive-desc">
                    <?php echo wp_kses_post( wpautop( $description ) ); ?>
                </div>
            <?php endif; ?>
        </div><!-- .Content -->
    </div>
</section>
<!-- Latest Post -->
<section class="latest-posts recipe" style="padding-top:0;">
    <div class="container">
        <div class="posts-wrapper">
            <div class="top">
                <h2 class="heading">
                    <?php echo 'Latest '. $post_type_label; ?>
                </h2>
            </div>
            <?php if ( $posts_query->have_posts() ) : ?>
                <ul class="posts-list">
                <?php while ( $posts_query->have_posts() ) : $posts_query->the_post(); ?>
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
</section><!-- .Latest Posts -->
<?php
get_footer();