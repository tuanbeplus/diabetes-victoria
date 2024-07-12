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
		<?php if ( is_user_logged_in() ): 
			$current_user = wp_get_current_user();
			$display_name = esc_html($current_user->data->display_name);
			?>
			<div class="user-action-mobile">
				<span><?php echo $display_name; ?></span>
				<a href="/user-profile">My Profile</a>
				<a class="members-logout-link" href="<?php echo esc_url( wp_logout_url(home_url()) ); ?>">Logout</a>
			</div>
		<?php endif; ?>
	</nav><!-- #site-navigation -->
	<?php
endif;