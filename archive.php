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
$current_term_obj = get_queried_object();
$taxonomy_name = !empty( $current_term_obj )? $current_term_obj->taxonomy : 'category';
$taxonomy_object = get_taxonomy($taxonomy_name);

// Get all terms data
$post_terms = get_terms( array(
    'taxonomy'   => $taxonomy_name,
    'hide_empty' => true,
));

if (get_post_type() == 'post') {
    $blogs_obj = get_term(96, 'category'); // Get Blog category object
    $impact_hub_obj = get_term(119, 'category'); // Get Impact Hub category object

    $tags_related_blogs = get_field('related_article_tags', $blogs_obj);
    $tags_related_impact_hub = get_field('related_article_tags', $impact_hub_obj);

    if (in_array($current_term_obj, $tags_related_blogs) && in_array($current_term_obj, $tags_related_impact_hub)) {
        $post_terms = array_unique(array_merge($tags_related_blogs, $tags_related_impact_hub));
    }
    elseif (in_array($current_term_obj, $tags_related_blogs)) {
        $post_terms = $tags_related_blogs;
    }
    elseif (in_array($current_term_obj, $tags_related_impact_hub)) {
        $post_terms = $tags_related_impact_hub;
    }
}

$description = get_the_archive_description();
$featured_image = get_field('featured_image', get_queried_object());
$cat_img_url = $featured_image['url'] ?? '';
$cat_img_alt = $featured_image['alt'] ?? '';

$post_type = get_post_type_object(get_post_type());
$post_type_label = $post_type->label ?? 'Article';

$args = array(
    'post_type' => get_post_type(),
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'tax_query' => array(
        array(
            'taxonomy' => $taxonomy_name,
            'field' => 'term_id',
            'terms' => $current_term_obj->term_id,
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
                <?php if (!empty($post_terms) && !is_wp_error($post_terms)): ?>
                    <div class="secondary-info">
                        <h2 class="__heading">
                            <?php echo 'More '. $taxonomy_object->label ?? ''; ?>
                        </h2>
                        <ul class="post-cats-list" role="list">
                        <?php foreach ($post_terms as $term): ?>
                            <li>
                                <a href="<?php echo get_term_link($term) ?>">
                                    <?php echo $term->name ?? ''; ?>
                                </a>
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
<?php if ( $posts_query->have_posts() ) : ?>
    <section class="latest-posts recipe" style="padding-top:0;">
        <div class="container">
            <div class="posts-wrapper">
                <div class="top">
                    <h2 class="heading">
                        <?php echo 'Latest '. $post_type_label; ?>
                    </h2>
                </div>
                <ul class="posts-list">
                <?php while ( $posts_query->have_posts() ) : $posts_query->the_post(); ?>
                    <?php get_template_part( 'template-parts/post/post-card' ); ?>
                <?php endwhile; ?>
                </ul>
            </div>
        </div>
    </section><!-- .Latest Posts -->
<?php endif; ?>
<?php 
    // Reset Post Data
    wp_reset_postdata();
?>
<?php
get_footer();