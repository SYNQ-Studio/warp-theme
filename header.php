<?php
/**
 * The header template
 *
 * @package Warp_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Check if Elementor header is set
$elementor_header = '';
if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'header' ) ) {
	return;
}

$header_class = get_theme_mod( 'warp_header_style', 'solid' );
$sticky_class = get_theme_mod( 'warp_sticky_header', true ) ? 'sticky-header' : '';
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'warp-theme' ); ?></a>

	<header id="masthead" class="site-header header-<?php echo esc_attr( $header_class ); ?> <?php echo esc_attr( $sticky_class ); ?>">
		<div class="header-container">
			<div class="header-inner">
				<div class="site-branding">
					<?php
					if ( has_custom_logo() ) {
						the_custom_logo();
					} else {
						?>
						<div class="site-identity">
							<?php if ( is_front_page() && is_home() ) : ?>
								<h1 class="site-title">
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
										<?php bloginfo( 'name' ); ?>
									</a>
								</h1>
							<?php else : ?>
								<p class="site-title">
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
										<?php bloginfo( 'name' ); ?>
									</a>
								</p>
							<?php endif; ?>

							<?php
							$description = get_bloginfo( 'description', 'display' );
							if ( $description || is_customize_preview() ) :
								?>
								<p class="site-description"><?php echo $description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
							<?php endif; ?>
						</div>
						<?php
					}
					?>
				</div><!-- .site-branding -->

				<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'warp-theme' ); ?>">
					<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
						<span class="hamburger-icon">
							<span class="line"></span>
							<span class="line"></span>
							<span class="line"></span>
						</span>
						<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'warp-theme' ); ?></span>
					</button>

					<?php
					if ( has_nav_menu( 'primary' ) ) {
						wp_nav_menu(
							array(
								'theme_location' => 'primary',
								'menu_id'        => 'primary-menu',
								'menu_class'     => 'primary-menu',
								'container'      => 'div',
								'container_class' => 'primary-menu-container',
							)
						);
					}
					?>
				</nav><!-- #site-navigation -->

				<div class="header-actions">
					<?php if ( get_theme_mod( 'warp_header_search', true ) ) : ?>
						<button class="search-toggle" aria-label="<?php esc_attr_e( 'Search', 'warp-theme' ); ?>" aria-controls="search-modal">
							<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M19 19L13 13M15 8C15 11.866 11.866 15 8 15C4.13401 15 1 11.866 1 8C1 4.13401 4.13401 1 8 1C11.866 1 15 4.13401 15 8Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</button>
					<?php endif; ?>
				</div><!-- .header-actions -->
			</div><!-- .header-inner -->
		</div><!-- .header-container -->

		<!-- Mobile Menu -->
		<div class="mobile-menu-overlay" id="mobile-menu-overlay">
			<div class="mobile-menu-container">
				<button class="mobile-menu-close" aria-label="<?php esc_attr_e( 'Close Menu', 'warp-theme' ); ?>">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php
				if ( has_nav_menu( 'mobile' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'mobile',
							'menu_id'        => 'mobile-menu',
							'menu_class'     => 'mobile-menu',
							'container'      => 'nav',
							'container_class' => 'mobile-navigation',
						)
					);
				} elseif ( has_nav_menu( 'primary' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_id'        => 'mobile-menu',
							'menu_class'     => 'mobile-menu',
							'container'      => 'nav',
							'container_class' => 'mobile-navigation',
						)
					);
				}
				?>
			</div>
		</div>

		<!-- Search Modal -->
		<?php if ( get_theme_mod( 'warp_header_search', true ) ) : ?>
			<div class="search-modal" id="search-modal">
				<div class="search-modal-container">
					<button class="search-modal-close" aria-label="<?php esc_attr_e( 'Close Search', 'warp-theme' ); ?>">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="search-form-container">
						<?php get_search_form(); ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
