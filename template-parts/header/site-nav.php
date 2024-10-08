<?php
/**
 * Displays the site navigation.
 *
 * @package WordPress
 */
?>

<?php if ( has_nav_menu( 'primary' ) ) : ?>
	<nav id="site-navigation" class="primary-navigation" role="navigation" aria-label="Main Navigation">
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
		<div class="user-action-mobile">
			<a class="btn-member-logout" href="?action=member_logout">
				<span>
					<i class="fa-solid fa-arrow-right-from-bracket"></i>
				</span>
				<span>Logout</span>
			</a>
		</div>
	</nav><!-- #site-navigation -->
	<?php
endif;