<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WordPress
 */

get_header(); 

$page_template_404 = get_field('404_page_template', 'option');
if (!empty($page_template_404)) {
	// Redirect to 404 page template
	// wp_redirect( $page_template_404 );
	// exit;
}
?>

<section class="error-404 not-found">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?' ); ?></p>

		<?php get_search_form(); ?>

	</div><!-- .page-content -->
</section><!-- .error-404 -->

<?php
get_footer();
