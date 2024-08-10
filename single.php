<?php
/**
 * The template for displaying Single Post
 *
 */
get_header();
$post_id = get_the_ID();
$feature_img_url = get_the_post_thumbnail_url($post_id, 'full');
$feature_img_id = get_post_thumbnail_id();
$feature_img_alt = get_post_meta($feature_img_id, '_wp_attachment_image_alt', true);
$post_content = get_the_content();
$post_type = get_post_type_object(get_post_type());
$taxonomies = get_object_taxonomies(get_post_type(), 'names');
$post_terms = array();
$all_post_terms = array();

if (!empty($taxonomies)) {
    foreach ($taxonomies as $taxonomy) {
        if (isset($taxonomy) && !empty($taxonomy)) {
            $terms = wp_get_post_terms($post_id, $taxonomy);
            $all_tax_terms = get_terms( array(
                'taxonomy'   => $taxonomy,
                'hide_empty' => true,
            ));
            if (isset($terms) && !empty($terms)) {
                foreach ($terms as $term) {
                    $post_terms[] = $term;
                }
            }
            if (isset($all_tax_terms) && !empty($all_tax_terms)) {
                foreach ($all_tax_terms as $term) {
                    $all_post_terms[] = $term;
                }
            }
            // Only get first taxonomy
            break;
        }
    }
}

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
        <h1>
        <?php 
            if (isset($post_terms[0]) && !empty($post_terms[0])) {
                if ($post_terms[0]->term_id == '93' || $post_terms[0]->term_id == '99' || $post_terms[0]->term_id == '98') {
                    echo $post_terms[0]->name .' - '. get_the_date('j F Y');
                }    
                else {
                    echo get_the_title(); 
                }
            }
            else {
                echo get_the_title(); 
            }
        ?>
        </h1>
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
                <?php if (isset($all_post_terms) && !empty($all_post_terms)): ?>
                    <div class="secondary-info">
                        <h2 class="__heading" style="padding:0;">
                            <button id="btn-toggle-categories">
                                <?php
                                if ($post_terms[0]->term_id == '96' || $post_terms[0]->term_id == '119') {
                                   echo 'More '. $post_terms[0]->name ?? '';
                                }
                                else {
                                    echo 'More Categories';
                                } ?>
                                <span class="icon-chevron-down">
                                    <?php echo dv_get_icon_svg('icon-chevron-down-white') ?>
                                </span>
                            </button>
                        </h2>
                        <ul class="recipe-cats-list categories-list" role="list">
                        <?php if ($post_terms[0]->term_id == '96' || $post_terms[0]->term_id == '119'):
                            $related_article_tags =  get_field('related_article_tags', $post_terms[0]); ?>
                            <?php if (!empty($related_article_tags)): ?>
                                <?php foreach ($related_article_tags as $tag): ?>
                                    <li>
                                        <a href="<?php echo esc_url(get_term_link($tag)); ?>"><?php echo $tag->name ?? ''; ?></a>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php foreach ($all_post_terms as $term): 
                                if ($post_type->name == 'post'):
                                    $show_in_sidebar = get_field('show_in_the_public_article_sidebar', $term);
                                    if ($show_in_sidebar == true): ?>
                                        <li>
                                            <a href="<?php echo esc_url(get_term_link($term)); ?>"><?php echo $term->name ?? ''; ?></a>
                                        </li>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <li>
                                        <a href="<?php echo esc_url(get_term_link($term)); ?>"><?php echo $term->name ?? ''; ?></a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div><!-- .Sidebar -->

        <div class="content-wrapper">
            <?php if (!empty($feature_img_url)): ?>
                <img class="__banner" src="<?php echo $feature_img_url; ?>" alt="<?php echo $feature_img_alt; ?>">
            <?php else: ?>
                <?php dv_the_post_thumbnail_default($post_id) ?>
            <?php endif; ?>
            <?php
            // Post info
            $post_description = get_field('post_description');
            $organisation = get_field('organisation');
            $preparation = get_field('preparation');
            $cooking_time = get_field('cooking_time');
            $serves = get_field('serves');
            $type_of_recipe = get_field('type_of_recipe');

            if( !empty($post_description) 
                || !empty($organisation['org_name']) 
                || !empty($organisation['org_link']) 
                || !empty($preparation) 
                || !empty($cooking_time) 
                || !empty($serves) 
                || !empty($type_of_recipe) 
                || !empty(get_the_title())
            ): ?>
                <div class="__content">
                    <?php if (is_singular('recipe') || is_singular('member_recipes')): ?>
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
                    <?php else: ?>
                    <?php 
                        if (isset($post_terms[0]) && !empty($post_terms[0])) {
                            if ($post_terms[0]->term_id == '93' || $post_terms[0]->term_id == '99' || $post_terms[0]->term_id == '98') {
                                the_title('<h2 class="__title">', '</h2>'); 
                            }
                        }
                        echo $post_description;
                    ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section><!-- .Post Info -->

<?php if (!empty($post_content)): ?>
<!-- Post Content -->
<section class="main-content" style="padding-top:0;">
    <div class="main-content-inner">
        <div class="content-wrapper">
            <div class="__content">
                <?php if ($post_type->name == 'recipe' || $post_type->name == 'member_recipes'): ?>
                    <h2 class="__title">Recipe</h2>
                <?php endif; ?>
                <?php echo do_shortcode($post_content); ?>
            </div>
        </div>
    </div>
</section>
<!-- .Post Content -->
<?php endif; ?>

<!-- Author Profile -->
<?php 
$author_info = get_field('author_info');
$profile_picture = $author_info['infomations']['profile_picture'] ?? array();
$picture_url = $profile_picture['url'] ?? DV_IMG_DIR .'user-placeholder.jpeg';
$picture_alt = $profile_picture['alt'] ?? 'Author Picture Placeholder';
$author_name = $author_info['infomations']['name'] ?? '';
$author_qualifi = $author_info['infomations']['qualifications'] ?? '';
$author_bio = $author_info['biographical'] ?? '';
// echo "<pre>";
// print_r($author_info);
// echo "</pre>";
?>
<?php if (!empty($author_info) && !empty($author_info['infomations'])): ?>
    <section class="author-profile-section">
        <div class="container">
            <div class="author-profile-wrapper">
                <div class="profile-picture">
                    <img src="<?php echo $picture_url ?>" alt="<?php echo $picture_alt ?>">
                </div>
                <div class="info">
                    <?php if (!empty($author_name)): ?>
                        <h3 class="__name"><?php echo $author_name ?></h3>
                    <?php endif; ?>
                    <?php if (!empty($author_qualifi)): ?>
                        <p class="__qualifi"><?php echo $author_qualifi ?></p>
                    <?php endif; ?>
                    <?php if (!empty($author_bio)): ?>
                        <div class="__bio"><?php echo $author_bio ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section><!-- .Author Profile -->
<?php endif; ?>

<?php 
// Latest Posts
$post_type_name = isset($post_type->name) ? $post_type->name : 'post';
$paged = 1;
$number_posts = 6;
$order_by = 'DESC';
$categories = array($post_terms[0]->term_id);
// Get query posts
$query_args = array(
    'post_type'      => $post_type_name,
    'paged'          => $paged,
    'posts_per_page' => $number_posts,
    'order'          => $order_by,
    'categories'     => $categories,
);
$posts_list = dv_get_latest_posts($query_args);

// Get query posts
$query_all_args = array(
    'post_type'      => $post_type_name,
    'paged'          => $paged,
    'posts_per_page' => -1,
    'order'          => $order_by,
    'categories'     => $categories,
);
$max_posts = dv_get_latest_posts($query_all_args);
$max_posts = is_array($max_posts) ? count($max_posts) : '';
?>
<?php if (!empty($posts_list)): ?>
<!-- Latest Posts -->
<section class="latest-posts post" style="padding-top:0;">
    <input type="hidden" name="post_type" value="<?php echo $post_type_name ?>">
    <input type="hidden" name="number_posts" value="<?php echo $number_posts ?>">
    <input type="hidden" name="order_by" value="<?php echo $order_by ?>">
    <input type="hidden" name="max_posts" value="<?php echo $max_posts ?>">
    <input type="hidden" name="categories" value="<?php echo esc_attr(json_encode($categories)) ?>">
    <input type="hidden" name="tags" value="">

    <div class="container">
        <div class="posts-wrapper">
            <div class="top">
                <h2 class="heading">
                    <?php 
                    if (isset($post_terms[0]->name) && isset($post_type_name)) {
                        if ($post_type_name == 'recipe' || $post_type_name == 'member_recipes') {
                            echo 'Latest '. $post_terms[0]->name .' Recipes';
                        }
                        elseif ($post_type_name == 'post' || $post_type_name == 'resource') {
                            echo 'Latest '. $post_terms[0]->name .' Articles';
                        }
                        else {
                            echo 'Latest Posts';
                        }
                    }
                    else {
                        echo 'Latest Posts';
                    }
                    ?>
                </h2>
                <a class="top-cta-btn" href="<?php echo get_term_link($post_terms[0]) ?>">
                    <span>View all</span>
                </a>
            </div>
            <ul class="posts-list">
            <?php foreach ($posts_list as $post): ?>
                <li class="post post-<?php echo $post->ID; ?>">
                    <div class="__thumb">
                        <?php if (!empty(get_the_post_thumbnail($post->ID))): ?>
                            <?php echo get_the_post_thumbnail($post->ID, 'medium_large'); ?>
                        <?php else: ?>
                            <?php dv_the_post_thumbnail_default($post->ID) ?>
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