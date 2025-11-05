<?php
/**
 * Enqueue scripts and styles
 *
 * @package Warp_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue theme styles and scripts
 */
function warp_enqueue_scripts() {
	// Enqueue Google Fonts - Inter (primary font)
	wp_enqueue_style(
		'warp-google-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap',
		array(),
		null
	);

	// Enqueue main stylesheet
	wp_enqueue_style(
		'warp-main-style',
		WARP_THEME_URI . '/assets/css/main.css',
		array(),
		WARP_THEME_VERSION
	);

	// Enqueue theme stylesheet (required by WordPress)
	wp_enqueue_style(
		'warp-style',
		get_stylesheet_uri(),
		array( 'warp-main-style' ),
		WARP_THEME_VERSION
	);

	// Enqueue navigation script
	wp_enqueue_script(
		'warp-navigation',
		WARP_THEME_URI . '/assets/js/navigation.js',
		array(),
		WARP_THEME_VERSION,
		true
	);

	// Enqueue animations script
	wp_enqueue_script(
		'warp-animations',
		WARP_THEME_URI . '/assets/js/animations.js',
		array(),
		WARP_THEME_VERSION,
		true
	);

	// Enqueue comment reply script
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Localize script with theme data
	wp_localize_script(
		'warp-navigation',
		'warpTheme',
		array(
			'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
			'themeUrl'  => WARP_THEME_URI,
			'siteUrl'   => home_url(),
			'nonce'     => wp_create_nonce( 'warp-theme-nonce' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'warp_enqueue_scripts' );

/**
 * Enqueue editor styles
 */
function warp_enqueue_editor_styles() {
	// Enqueue Google Fonts for editor
	wp_enqueue_style(
		'warp-editor-google-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap',
		array(),
		null
	);

	// Enqueue editor styles
	wp_enqueue_style(
		'warp-editor-style',
		WARP_THEME_URI . '/assets/css/editor-style.css',
		array(),
		WARP_THEME_VERSION
	);
}
add_action( 'enqueue_block_editor_assets', 'warp_enqueue_editor_styles' );

/**
 * Add async/defer attributes to scripts
 */
function warp_script_loader_tag( $tag, $handle, $src ) {
	// Array of script handles to defer
	$defer_scripts = array(
		'warp-animations',
	);

	// Array of script handles to async
	$async_scripts = array();

	if ( in_array( $handle, $defer_scripts, true ) ) {
		return str_replace( ' src', ' defer="defer" src', $tag );
	}

	if ( in_array( $handle, $async_scripts, true ) ) {
		return str_replace( ' src', ' async="async" src', $tag );
	}

	return $tag;
}
add_filter( 'script_loader_tag', 'warp_script_loader_tag', 10, 3 );

/**
 * Add preload for critical assets
 */
function warp_preload_assets() {
	// Preload main CSS
	echo '<link rel="preload" href="' . esc_url( WARP_THEME_URI . '/assets/css/main.css' ) . '" as="style">';

	// Preload main font
	echo '<link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" as="style">';
}
add_action( 'wp_head', 'warp_preload_assets', 1 );

/**
 * Remove unnecessary styles and scripts
 */
function warp_dequeue_unnecessary_scripts() {
	// Remove WordPress block library CSS if not using Gutenberg
	// Uncomment if you want to remove it:
	// wp_dequeue_style( 'wp-block-library' );
	// wp_dequeue_style( 'wp-block-library-theme' );

	// Remove classic theme styles
	wp_dequeue_style( 'classic-theme-styles' );

	// Remove global styles (if not needed)
	// wp_dequeue_style( 'global-styles' );
}
add_action( 'wp_enqueue_scripts', 'warp_dequeue_unnecessary_scripts', 100 );

/**
 * Add custom inline CSS for immediate critical styles
 */
function warp_critical_css() {
	$critical_css = '
		:root {
			--warp-primary-bg: #121212;
			--warp-primary-text: #ffffff;
			--warp-accent: #e3e2e0;
		}
		body {
			margin: 0;
			padding: 0;
			background-color: var(--warp-primary-bg);
			color: var(--warp-primary-text);
		}
	';
	wp_add_inline_style( 'warp-main-style', $critical_css );
}
add_action( 'wp_enqueue_scripts', 'warp_critical_css' );
