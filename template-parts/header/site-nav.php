<?php
/**
 * Displays the site navigation.
 *
 * @package WordPress
 */
?>

<?php if ( has_nav_menu( 'primary' ) ) : ?>
	<nav id="site-navigation" class="primary-navigation" aria-label="<?php esc_attr_e( 'Primary menu' ); ?>">
		<?php
		wp_nav_menu(
			array(
				'theme_location'  => 'primary',
				'menu_class'      => 'menu-wrapper',
				'container_class' => 'primary-menu-container',
				'items_wrap'      => '<ul id="primary-menu-list" class="%2$s">%3$s</ul>',
				'fallback_cb'     => false,
			)
		);
		?>
		<div class="top-menu-mobile">
			<?php get_template_part( 'template-parts/header/top-menu' ); ?>
		</div>
	</nav><!-- #site-navigation -->
	<?php
endif;