<?php
/**
 * The template for displaying Single Post
 *
 */
get_header();
$post_id = get_the_ID();
$feature_img_url = get_the_post_thumbnail_url($post_id, 'full');
$feature_img_url = !empty($feature_img_url) ? $feature_img_url : DV_IMG_DIR .'recipe-feature-img-default.jpeg';
$feature_img_id = get_post_thumbnail_id();
$feature_img_alt_default = 'Fresh herbs and spices arranged on a black background, adding vibrant colors and flavors to culinary creations.';
$feature_img_alt = get_post_meta($feature_img_id, '_wp_attachment_image_alt', true);
$feature_img_alt = !empty($feature_img_id) ? $feature_img_alt : $feature_img_alt_default;
$post_content = get_the_content();



$post_cat = is_singular('recipe') ? 'recipe_categories' : 'category';
$post_cat_terms = get_terms( array(
    'taxonomy'   => $post_cat,
    'hide_empty' => true,
));

// Post brand css variable
$brand_color = get_field('brand_color');
$brand_color = !empty($brand_color) ? $brand_color : '';
$sub_brand_color = !empty($brand_color) ? '#fff' : '';
$bg_color = get_field('background_color');
$bg_color = !empty($bg_color) ? $bg_color : '';

echo '<style> html {';
    if (!empty($brand_color)) echo '--post-brand-color: '. $brand_color .';';
    if (!empty($sub_brand_color)) echo '--post-sub-brand-color: '. $sub_brand_color .';';
    if (!empty($bg_color)) echo '--post-bg-color: '. $bg_color .';';
echo '} </style>';
?>
<!-- Post Title -->
<section class="post-title">
    <div class="container">
        <h1><?php echo get_the_title(); ?></h1>
    </div>
</section><!-- .Post Title -->

<!-- Post Info -->
<section class="main-content post-info">
    <div class="main-content-inner has-sidebar">
        <!-- Sidebar -->
        <div id="main-content-sidebar" class="sidebar">
            <div class="sidebar-inner">
                <div class="on-this-page">
                    <h2 class="__heading">On This Page</h2>
                    <ul id="tocs" class="links-list" role="list"></ul>
                </div>
                <?php if (!empty($post_cat_terms) && !is_wp_error($post_cat_terms)): ?>
                    <div class="secondary-info">
                        <h2 class="__heading">
                            <?php echo is_singular('recipe') ? 'More Posts' : 'More Blog'; ?>
                        </h2>
                        <ul class="recipe-cats-list" role="list">
                        <?php foreach ($post_cat_terms as $term): 
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

        <div class="content-wrapper">
            <img class="__banner" src="<?php echo $feature_img_url; ?>" alt="<?php echo $feature_img_alt; ?>">
            
            <div class="__content">
                <?php
                    if(is_singular('recipe')) {
                        // Post info
                        $organisation = get_field('organisation');
                        $preparation = get_field('preparation');
                        $cooking_time = get_field('cooking_time');
                        $serves = get_field('serves');
                        $type_of_recipe = get_field('type_of_recipe');

                        ?>
                        <?php if (!empty($organisation['org_name'])): ?>
                            <p>
                                <b>Organisation</b>: 
                                <a href="<?php echo $organisation['org_link'] ?? ''; ?>"><b><?php echo $organisation['org_name']; ?></b></a>
                            </p>
                        <?php endif; ?>
                        <?php if (!empty($preparation)): ?>
                            <p><b>Preparation</b>: <?php echo $preparation; ?></p>
                        <?php endif; ?>
                        <?php if (!empty($cooking_time)): ?>
                            <p><b>Cooking time</b>: <?php echo $cooking_time; ?></p>
                        <?php endif; ?>
                        <?php if (!empty($serves)): ?>
                            <p><b>Serves</b>: <?php echo $serves; ?></p>
                        <?php endif; ?>
                        <?php if (!empty($type_of_recipe)): ?>
                            <p><b>Type of recipe</b>: <?php echo $type_of_recipe; ?></p>
                        <?php endif; ?>
                        <?php
                    } else {
                        $post_description = get_field('post_description');
                        echo $post_description;
                    }
                ?>
                
            </div>
        </div>
    </div>
</section><!-- .Post Info -->

<?php if (!empty($post_content)): ?>
<!-- Post Content -->
<section class="main-content" style="padding-top:0;">
    <div class="main-content-inner">
        <div class="content-wrapper">
            <div class="__content">
                <h2 class="__title">
                    <?php echo is_singular('recipe') ? 'Post' : 'Blog'; ?>
                </h2>
                <?php echo dv_clean_html_content_editor($post_content); ?>
            </div>
        </div>
    </div>
</section><!-- .Post Content -->
<?php endif; ?>

<?php 
// Latest Post
$post_type = is_singular('recipe') ? 'recipe' : 'post';
$paged = 1;
$number_posts = 6;
$order_by = 'DESC';
$posts_list = dv_get_latest_posts($post_type, $paged, $number_posts, $order_by);
$max_posts = dv_get_latest_posts($post_type, $paged, '-1', $order_by);
$max_posts = is_array($max_posts) ? count($max_posts) : '';
?>
<?php if (!empty($posts_list)): ?>
<!-- Latest Post -->
<section class="latest-posts post" style="padding-top:0;">
    <input type="hidden" name="post_type" value="<?php echo $post_type ?>">
    <input type="hidden" name="number_posts" value="<?php echo $number_posts ?>">
    <input type="hidden" name="order_by" value="<?php echo $order_by ?>">
    <input type="hidden" name="max_posts" value="<?php echo $max_posts ?>">
    <div class="container">
        <div class="posts-wrapper">
            <div class="top">
                <h2 class="heading">
                    <?php echo is_singular('recipe') ? 'Latest Posts' : 'Latest Blog'; ?>
                </h2>
                <a class="top-cta-btn" href="<?php echo is_singular('recipe') ? '/recipe' : '/news-research'; ?>">
                    <span>View all</span>
                </a>
            </div>
            <ul class="posts-list">
            <?php foreach ($posts_list as $post): ?>
                <li class="post post-<?php echo $post->ID; ?>">
                    <div class="__thumb">
                        <?php if (!empty(get_the_post_thumbnail($post->ID))): ?>
                            <?php echo get_the_post_thumbnail($post->ID, 'medium'); ?>
                        <?php else: ?>
                            <img src="<?php echo DV_IMG_DIR .'recipe-feature-img-default.jpeg'; ?>" 
                                 alt="<?php echo $feature_img_alt_default ?>">
                        <?php endif; ?>
                    </div>
                    <div class="post-meta">
                        <div class="__title">
                            <a href="<?php echo get_the_permalink($post->ID); ?>">
                                <span><?php echo $post->post_title; ?></span>
                            </a>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
            </ul>
            <?php if ($number_posts < $max_posts): ?>
                <div class="bottom">
                    <button class="load-more-cta" role="button" data-next-page="2">
                        <span class="text">View more</span>
                        <div class="loading-wrapper">
                            <div class="dv-spinner"></div>
                        </div>
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section><!-- .Latest Post -->
<?php endif; ?>

<?php get_footer(); 