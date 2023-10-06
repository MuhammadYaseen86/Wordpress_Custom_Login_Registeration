<?php
/**
 * The template for displaying header.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! hello_get_header_display() ) {
	return;
}

$is_editor = isset( $_GET['elementor-preview'] );
$site_name = get_bloginfo( 'name' );
$tagline   = get_bloginfo( 'description', 'display' );
$header_left_nav_menu = wp_nav_menu( [
	'theme_location' => 'left-menu',
	'fallback_cb' => false,
	// 'menu_class' => 'left-menu',  
	'echo' => false,
] );
$header_right_nav_menu = wp_nav_menu( [
	'theme_location' => 'right-menu',
	'fallback_cb' => false,
	'echo' => false,
] );
$header_mobile_nav_menu = wp_nav_menu( [
	'theme_location' => 'mobile-menu',
	'fallback_cb' => false,
	'echo' => false,
] );
?>
<header id="site-header" class="site-header dynamic-header <?php echo esc_attr( hello_get_header_layout_class() ); ?>" role="banner">
	<div class="header-inner">
		<?php if ( $header_left_nav_menu ) : ?>
			<nav class="site-navigation left-menu <?php echo esc_attr( hello_show_or_hide( 'hello_header_menu_display' ) ); ?>" role="navigation">
				<?php
				// PHPCS - escaped by WordPress with "wp_nav_menu"
				echo $header_left_nav_menu; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>
			</nav>
		<?php endif; ?>
		
		<div class="site-branding hidden-mobile show-<?php echo esc_attr( hello_elementor_get_setting( 'hello_header_logo_type' ) ); ?>">
			<?php if ( has_custom_logo() && ( 'title' !== hello_elementor_get_setting( 'hello_header_logo_type' ) || $is_editor ) ) : ?>
				<div class="site-logo <?php echo esc_attr( hello_show_or_hide( 'hello_header_logo_display' ) ); ?>">
					<?php the_custom_logo(); ?>
				</div>
			<?php endif;

			if ( $site_name && ( 'logo' !== hello_elementor_get_setting( 'hello_header_logo_type' ) || $is_editor ) ) : ?>
				<h1 class="site-title <?php echo esc_attr( hello_show_or_hide( 'hello_header_logo_display' ) ); ?>">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr_e( 'Home', 'hello-elementor' ); ?>" rel="home">
						<?php echo esc_html( $site_name ); ?>
					</a>
				</h1>
			<?php endif;

			if ( $tagline && ( hello_elementor_get_setting( 'hello_header_tagline_display' ) || $is_editor ) ) : ?>
				<p class="site-description <?php echo esc_attr( hello_show_or_hide( 'hello_header_tagline_display' ) ); ?>">
					<?php echo esc_html( $tagline ); ?>
				</p>
			<?php endif; ?>
		</div>

		<div class="for-mobile mobile-call-icon" style="flex: 0 0 10%;">
			<?php $mobile_icon = get_stylesheet_directory_uri() . '/assets/img/icon_call.svg'; ?>
			<a style="color: #192549; text-decoration: none;" href="tel:+44 (0)7852 882 933"><img src="<?php echo $mobile_icon; ?>" class="call-icon"></a>
		</div>
		<div class="for-mobile">
			<?php if ( has_custom_logo() && ( 'title' !== hello_elementor_get_setting( 'hello_header_logo_type' ) || $is_editor ) ) : ?>
				<div class="site-logo <?php echo esc_attr( hello_show_or_hide( 'hello_header_logo_display' ) ); ?>">
					<?php the_custom_logo(); ?>
				</div>
			<?php endif;

			if ( $site_name && ( 'logo' !== hello_elementor_get_setting( 'hello_header_logo_type' ) || $is_editor ) ) : ?>
				<h1 class="site-title <?php echo esc_attr( hello_show_or_hide( 'hello_header_logo_display' ) ); ?>">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr_e( 'Home', 'hello-elementor' ); ?>" rel="home">
						<?php echo esc_html( $site_name ); ?>
					</a>
				</h1>
			<?php endif;

			if ( $tagline && ( hello_elementor_get_setting( 'hello_header_tagline_display' ) || $is_editor ) ) : ?>
				<p class="site-description <?php echo esc_attr( hello_show_or_hide( 'hello_header_tagline_display' ) ); ?>">
					<?php echo esc_html( $tagline ); ?>
				</p>
			<?php endif; ?>
		</div>
		
		<?php if ( $header_right_nav_menu ) : ?>
			<nav class="site-navigation <?php echo esc_attr( hello_show_or_hide( 'hello_header_menu_display' ) ); ?>" role="navigation">
				<?php
				// PHPCS - escaped by WordPress with "wp_nav_menu"
				echo $header_right_nav_menu; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>
			</nav>
		<?php endif; ?>
		<div class="site-navigation-toggle-holder <?php echo esc_attr( hello_show_or_hide( 'hello_header_menu_display' ) ); ?>">
			<div class="site-navigation-toggle">
				<i class="eicon-menu-bar"></i>
				<span class="elementor-screen-only">Menu</span>
			</div>
		</div>
		<nav class="site-navigation-dropdown <?php echo esc_attr( hello_show_or_hide( 'hello_header_menu_display' ) ); ?>" role="navigation">
			<?php 
				// $mobile_logo = get_stylesheet_directory_uri() . '/assets/img/Mobile-Logo.png';
				$mobile_logo = get_stylesheet_directory_uri() . '/assets/img/ekr-mobile-logo.svg'; ?>
				<img src="<?php echo $mobile_logo; ?>" class="mobile-logo">
			<?php
				// PHPCS - escaped by WordPress with "wp_nav_menu"
				echo $header_mobile_nav_menu; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?>
		</nav>
	</div>
</header>