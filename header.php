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
$right_text_align = get_field('enable_rtl', get_the_ID());
$is_right_text_align = $right_text_align ? $right_text_align : false;
$sf_community_url = get_field('salesforce_community_url', 'option');
// Member Sign up
$member_sign_up = get_field('member_sign_up', 'option');
$member_sign_up_link = !empty($member_sign_up['page_link']) ? $member_sign_up['page_link'] : '/sign-up-as-member';
// Member Login
$member_login = get_field('member_login', 'option');
$member_login_link = !empty($member_login['login_page']) ? $member_login['login_page'] : '/member-login';
// Member Logged in
$member_logged_in = get_field('member_logged_in', 'option');
$member_hub_link = !empty($member_logged_in['member_page']) ? $member_logged_in['member_page'] : '/members-hub';
// Member Content
$member_content = get_field('member_content', get_the_ID());
$is_member_content = $member_content ? $member_content : 0;
?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?php wp_head(); ?>
	<script id="member-login-js">
		jQuery(document).ready(function ($) {
			// Function to set a cookie
			function setCookie(name, value, days) {
				var expires = "";
				if (days) {
					var date = new Date();
					date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
					expires = "; expires=" + date.toUTCString();
				}
				document.cookie = name + "=" + (value || "") + expires + "; path=/";
			}

			// Function to get a cookie value by name
			function getCookie(name) {
				var nameEQ = name + "=";
				var cookies = document.cookie.split(';');
				for (var i = 0; i < cookies.length; i++) {
					var cookie = cookies[i];
					while (cookie.charAt(0) === ' ') {
						cookie = cookie.substring(1);
					}
					if (cookie.indexOf(nameEQ) === 0) {
						return cookie.substring(nameEQ.length, cookie.length);
					}
				}
				return null;
			}

			// Function to reset (delete) a cookie
			function resetCookie(name) {
				// Set the cookie with a past expiration date to delete it
				document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/;";
			}

			// Function to get a URL parameter by name
			function getUrlParameter(name) {
				var regex = new RegExp('[?&]' + encodeURIComponent(name) + '=([^&]*)');
				var results = regex.exec(window.location.search);
				return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
			}

			$(function() {
				// Get params on URL
				let responseCode = getUrlParameter("code")
				let communityUrl = getUrlParameter("sfdc_community_url")
				let overlay = $('.member-login-overlay')
				if (responseCode && communityUrl) {
					overlay.show()

					// Set member cookie
					setCookie('sf_auth_code', responseCode, 1);

					// Redirect to Members Hub page 
					window.location.href = "<?php echo $sf_community_url ?>/supporterportalauth/s/";
				}

				// Redirect to Sign In page if not member logged in
				let authCodeCookie = getCookie("sf_auth_code");
				let isMemberContent = <?php echo $is_member_content ?>;
				let siteBody = $('body');
				if (isMemberContent == true 
					|| siteBody.hasClass('single-resource')
					|| siteBody.hasClass('single-member_recipes')
					|| siteBody.hasClass('tax-resource_categories')
					|| siteBody.hasClass('tax-member_recipe_cat')
				) {
					// Not exist Cookie
					if (authCodeCookie === '' || authCodeCookie === null) {
						window.location.href = "<?php echo $member_sign_up_link ?>";
					}
					// Exist Cookie
					else {
						if (responseCode && communityUrl) {
							overlay.show()
						}
						else {
							overlay.hide()
						}
					}
				}
				else {
					overlay.hide()
				}
			});

			$('#btn-member-login').each(function() {
				let button = $(this)
				let authCode = getCookie("sf_auth_code");
				
				if (authCode === '' || authCode === null) {
					button.html('<span>Member Login<span>')
					button.attr('href', "<?php echo $member_login_link ?>")
				}
				else {
					button.html('<span>My Membership<span>')
					button.attr('href', "<?php echo $member_hub_link ?>")
				}
			});
			
			$('.btn-member-logout').each(function() {
				let button = $(this)
				let authCode = getCookie("sf_auth_code");
				
				if (authCode === '' || authCode === null) {
					button.hide()
				}
				else {
					button.show()
				}
			});

			$(document).on('click', '.btn-member-logout', function(e) {
				e.preventDefault()
				if (confirm('Are you sure you want to log out?')) {
					// Delete member cookie
					resetCookie("sf_auth_code");

					// Redirect to Members Hub page
					window.location.href = '/';
				}
			});
		});
	</script>
</head>

<?php if ($is_member_content == true || get_post_type() == 'resource' || get_post_type() == 'member_recipes'): ?>
	<div class="member-login-overlay">
		<div class="loading-wrapper">
			<div class="dv-spinner"></div>
		</div>
	</div>
<?php endif; ?>

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
						<div class="users-action">
							<a class="btn-member-logout" href="?action=member_logout">
								<span>
									<i class="fa-solid fa-arrow-right-from-bracket"></i>
								</span>
								<span>Logout</span>
							</a>
						</div>
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

	<?php get_template_part( 'template-parts/header/contact-phones-popup' ); ?>

	<?php get_template_part( 'template-parts/header/login-popup' ); ?>
	
	<?php get_template_part( 'template-parts/header/search-popup' ); ?>

	<?php get_template_part( 'template-parts/header/donate-popup' ); ?>

	<div id="content" class="site-content">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" <?php echo $is_right_text_align ? 'dir="rtl"' : ''; ?> >