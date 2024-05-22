<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WordPress
 */

get_header();
?>

<section class="search-results-wrapper">
	<h1>Search results</h1>
	<form role="search" method="post" class="search-results-form" onsubmit="return false">
		<div class="search-inner">
			<label>
				<input type="search" class="search-field-input" 
						placeholder="<?php echo esc_attr_x( 'Enter a search term', 'placeholder' ); ?>" 
						name="s" 
						value="<?php echo esc_attr( get_search_query() ); ?>" 
						title="<?php _ex( 'Search for:', 'label' ); ?>">
			</label>
			<button id="btn-show-search-results" type="submit">
				<span>Show results</span>
			</button>
		</div>
		<div class="search-result-info">
			<div class="results-count">
				<span>
					Showing 
					<span id="number-results-count"><?php echo (int) $wp_query->post_count; ?></span>
					of 
					<span id="number-all-results"><?php echo (int) $wp_query->found_posts; ?> </span>
					results
				</span>
			</div>
			<div class="results-sort">
				<button id="btn-open-sort" type="button">
					<span>Sort by</span>
					<span class="chevron-icon">
						<?php echo dv_get_icon_svg('chevron-down-blu-thin-icon'); ?>
					</span>
				</button>
				<div class="sort-options">
					<div class="sort-by">
						<p>Sort by</p>
						<div class="gr-radio">
							<label for="sort-date">
								<input id="sort-date" type="radio" 
									name="orderby" value="date" 
									<?php if ($_GET['orderby'] == 'date' || !isset($_GET['orderby']) || $_GET['orderby'] == '') echo 'checked="checked"'; ?>>
								Date
							</label>
							<label for="sort-title">
								<input id="sort-title" type="radio" 
									name="orderby" value="title"
									<?php if ($_GET['orderby'] == 'title') echo 'checked="checked"'; ?>>
								Title
							</label>
						</div>
					</div>
					<div class="sort-direction">
						<p>Sort direction</p>
						<div class="gr-radio">
							<label for="sort-asc">
								<input id="sort-asc" type="radio" 
									name="order" value="ASC"
									<?php if ($_GET['order'] == 'ASC') echo 'checked="checked"'; ?>>
								Ascending
							</label>
							<label for="sort-desc">
								<input id="sort-desc" type="radio" 
									name="order" value="DESC" 
									<?php if ($_GET['order'] == 'DESC' || !isset($_GET['order']) || $_GET['order'] == '') echo 'checked="checked"'; ?>>
								Descending
							</label>
						</div>
					</div>
					<button id="btn-apply-sort" type="submit">Apply Sort</button>
					<button id="btn-close-sort-opts" type="button" title="Close sort options" aria-label="Close sort options">
						<span><i class="fa-solid fa-xmark"></i></span>
					</button>
				</div>
			</div>
		</div>
	</form>

	<div id="search-results">
		<div class="loading-wrapper">
			<div class="dv-spinner"></div>
		</div>
	<?php 
		if ( have_posts() ) {
			// Start the Loop.
			while ( have_posts() ): 
				the_post(); 
				get_template_part( 'template-parts/content/content-search' );
			endwhile; // End the loop. 
			// Reset Post Data
			wp_reset_postdata();
		} else {
			echo '<h3 style="text-align:center;">Results not found.</h3>';
		}
	?>
	</div>
	<?php if ($wp_query->found_posts > $wp_query->query_vars['posts_per_page']): ?>
		<div class="bottom-cta">
			<button id="btn-load-more-results" data-next-page="2">
				<span class="text">View more</span>
				<div class="loading-wrapper">
					<div class="dv-spinner"></div>
				</div>
			</button>
		</div>
	<?php endif; ?>
</section>
<?php
get_footer();