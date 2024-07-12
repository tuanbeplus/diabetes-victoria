<?php
/**
 * The header.
 *
 * This is the template that displays all of the <head> section and everything up until main.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 */

$wrapper_classes  = 'site-header';
$wrapper_classes .= has_custom_logo() ? ' has-logo' : '';
$wrapper_classes .= ( true === get_theme_mod( 'display_title_and_tagline', true ) ) ? ' has-title-and-tagline' : '';
$wrapper_classes .= has_nav_menu( 'primary' ) ? ' has-menu' : '';
$site_logo = get_field('site_logo', 'option') ?? '';
$logo_white_color = $site_logo['logo_white_color'] ?? '';
$logo_full_color = $site_logo['logo_full_color'] ?? '';
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content">
		<?php
		/* translators: Hidden accessibility text. */
		esc_html_e( 'Skip to content' );
		?>
	</a>

	<header id="masthead" class="<?php echo esc_attr( $wrapper_classes ); ?>">
		<?php get_template_part( 'template-parts/header/top-menu' ); ?>
		<div class="container">
			<div class="header-wrapper">
				<?php if (!empty($logo_white_color) && !empty($logo_full_color) ): ?>
					<div class="header-inner">
						<div id="header-logo">
							<a href="<?php echo home_url(); ?>">
								<img class="logo-white-color" src="<?php echo $logo_white_color['url'] ?? ''; ?>" alt="<?php echo $logo_white_color['alt'] ?? ''; ?>">
								<img class="logo-full-color" src="<?php echo $logo_full_color['url'] ?? ''; ?>" alt="<?php echo $logo_full_color['alt'] ?? ''; ?>">
							</a>
						</div>
						<?php if ( is_user_logged_in() ): 
							$current_user = wp_get_current_user();
							$display_name = esc_html($current_user->data->display_name);
							?>
							<div class="users-action">
								<span><?php echo $display_name; ?></span>
								<a href="/user-profile">My Profile</a>
								<a class="members-logout-link" href="<?php echo esc_url( wp_logout_url(home_url()) ); ?>">Logout</a>
							</div>
						<?php endif; ?>
						<button id="btn-nav-bar">
							<span class="icon-bar"><i class="fa-solid fa-bars"></i></span>
							<span class="icon-close"><i class="fa-solid fa-xmark"></i></span>
						</button>
					</div>
				<?php endif; ?>
				<?php get_template_part( 'template-parts/header/site-nav' ); ?>
			</div>
		</div>
		<!-- Breadcrumb -->
		<?php dv_breadcrumb(); ?>
		<!-- .Breadcrumb -->
	</header><!-- #masthead -->

	<div class="site-tools">
		<button id="btn-scroll-top" title="Go to top">
			<?php echo dv_get_icon_svg('icon-chevron-down-blu'); ?>
		</button><!-- #button scroll to top -->
	</div>
	
	<?php get_template_part( 'template-parts/header/search-popup' ); ?>

	<?php get_template_part( 'template-parts/header/donate-popup' ); ?>

	<?php get_template_part( 'template-parts/header/login-popup' ); ?>
			
	<div id="content" class="site-content">
		<div id="primary" class="content-area">
			<main id="main" class="site-main">