<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 */

$post_id = get_the_ID();
$footer_banner = get_field('custom_footer_banner', $post_id);
$footer_title = get_field('footer_title', 'option') ?? 'Diabetes Victoria';
$footer_description = get_field('footer_description', 'option');
$certified_image = get_field('certified_image', 'option');
$quick_links = get_field('quick_links', 'option');
$footer_logo = get_field('footer_logo', 'option');
$copyright = get_field('copyright', 'option');
$acknoledgement = get_field('acknoledgement', 'option');
?>
			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<div class="footer-banner">
			<?php if (isset($footer_banner['url']) && !empty($footer_banner['url'])): ?>
				<img src="<?php echo $footer_banner['url']; ?>" alt="<?php echo $footer_banner['alt'] ?? 'DV Footer Banner'; ?>" loading="lazy">
			<?php else: ?>
				<img src="<?php echo DV_IMG_DIR .'footer-banner-default.jpeg'; ?>" alt="DV Footer Banner" loading="lazy">
			<?php endif; ?>
		</div><!-- #banner -->
		<div class="container">
			<?php if ($footer_logo['url']): ?>
				<div class="footer-logo tablet">
					<a href="<?php echo home_url(); ?>">
						<img src="<?php echo $footer_logo['url']; ?>" alt="<?php echo $footer_logo['atl'] ?? 'Diabetes Victoria Logo'; ?>">
					</a>
				</div><!-- #logo tablet, mobile -->
			<?php endif; ?>
			<div class="footer-wrapper">
				<div class="info">
					<h3><?php echo $footer_title; ?></h3>
					<?php if ($footer_description) echo $footer_description; ?>
					<?php if (isset($certified_image['url']) && !empty($certified_image['url'])): ?>
						<img class="certified-img" src="<?php echo $certified_image['url']; ?>" alt="<?php echo $certified_image['alt'] ?? 'DV Certified'; ?>">
					<?php endif; ?>
				</div><!-- #info -->
				<?php if ($quick_links): ?>
					<div class="quick-links">
						<?php foreach ($quick_links as $row): ?>
							<div class="links-list">
								<?php if ($row['heading']): ?>
									<h3><?php echo $row['heading']; ?></h3>
								<?php endif; ?>
								<?php if ($row['links_list']): ?>
									<ul>
									<?php foreach ($row['links_list'] as $item): ?>
										<?php if ($item['text'] && $item['link']): ?>
											<li><a href="<?php echo $item['link']; ?>"><?php echo $item['text']; ?></a></li>
										<?php endif; ?>
									<?php endforeach; ?>
									</ul><!-- #links list -->
								<?php endif; ?>
								<?php if ($row['talk_to_us']): ?>
									<ul class="contacts-list">
									<?php foreach ($row['talk_to_us'] as $item): ?>
										<?php if ($item['label'] && $item['phone_number']): ?>
											<li>
												<?php echo $item['label'].' '; ?>
												<a href="tel:<?php echo $item['phone_number']; ?>"><?php echo $item['phone_number']; ?></a>
											</li>
										<?php endif; ?>
									<?php endforeach; ?>
									</ul><!-- #contacts list -->
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div><!-- #quick links -->
				<?php endif; ?>
				<?php if ($footer_logo['url']): ?>
					<div class="footer-logo">
						<a href="<?php echo home_url(); ?>">
							<img src="<?php echo $footer_logo['url']; ?>" alt="<?php echo $footer_logo['atl'] ?? 'Diabetes Victoria Logo'; ?>">
						</a>
					</div><!-- #logo -->
				<?php endif; ?>
			</div>
			<?php if ($copyright): ?>
				<p class="copyright"><?php echo $copyright; ?></p><!-- #copyright -->
			<?php endif; ?>
		</div>
		<?php if ($acknoledgement): ?>
			<div class="acknoledgement">
				<div class="container">
					<div class="ack-wrapper">
						<?php if ($acknoledgement['content']['heading']): ?>
							<h3><?php echo $acknoledgement['content']['heading']; ?></h3>
						<?php endif; ?>
						<?php if ($acknoledgement['content']['description']): ?>
							<?php echo $acknoledgement['content']['description']; ?>
						<?php endif; ?>
						<?php if ($acknoledgement['flags']): ?>
							<?php foreach ($acknoledgement['flags'] as $flag): ?>
								<?php if ($flag['flag_image']['url']): ?>
									<img class="flag" src="<?php echo $flag['flag_image']['url']; ?>" alt="<?php echo $flag['flag_image']['alt'] ?? ''; ?>">
								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>
			</div><!-- #acknoledgement -->
		<?php endif; ?>
	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>