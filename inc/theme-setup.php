<?php
/**
 * Theme setup and configuration
 *
 * @package Warp_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sets up theme defaults and registers support for various WordPress features
 */
function warp_theme_setup() {
	// Make theme available for translation
	load_theme_textdomain( 'warp-theme', WARP_THEME_DIR . '/languages' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1568, 9999 );

	// Register navigation menus
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'warp-theme' ),
			'footer'  => esc_html__( 'Footer Menu', 'warp-theme' ),
			'mobile'  => esc_html__( 'Mobile Menu', 'warp-theme' ),
		)
	);

	// Switch default core markup to output valid HTML5
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Add theme support for selective refresh for widgets
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add support for custom logo
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	// Add support for custom background
	add_theme_support(
		'custom-background',
		array(
			'default-color' => '121212',
			'default-image' => '',
		)
	);

	// Add support for editor styles
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor-style.css' );

	// Add support for responsive embedded content
	add_theme_support( 'responsive-embeds' );

	// Add support for wide and full aligned blocks
	add_theme_support( 'align-wide' );

	// Add support for block editor features
	add_theme_support( 'wp-block-styles' );

	// Add support for custom line heights
	add_theme_support( 'custom-line-height' );

	// Add support for custom spacing
	add_theme_support( 'custom-spacing' );

	// Add support for custom units
	add_theme_support( 'custom-units' );

	// Add support for link color
	add_theme_support( 'link-color' );

	// Add support for appearance tools
	add_theme_support( 'appearance-tools' );

	// Add support for border
	add_theme_support( 'border' );

	// Define content width
	if ( ! isset( $content_width ) ) {
		$content_width = 1200;
	}
}
add_action( 'after_setup_theme', 'warp_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet
 */
function warp_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'warp_content_width', 1200 );
}
add_action( 'after_setup_theme', 'warp_content_width', 0 );

/**
 * Register widget areas
 */
function warp_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'warp-theme' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'warp-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Widget Area 1', 'warp-theme' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'warp-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Widget Area 2', 'warp-theme' ),
			'id'            => 'footer-2',
			'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'warp-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Widget Area 3', 'warp-theme' ),
			'id'            => 'footer-3',
			'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'warp-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Widget Area 4', 'warp-theme' ),
			'id'            => 'footer-4',
			'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'warp-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'warp_widgets_init' );

/**
 * Add body classes for customization
 */
function warp_body_classes( $classes ) {
	// Adds a class if the site has a custom logo
	if ( has_custom_logo() ) {
		$classes[] = 'has-custom-logo';
	}

	// Adds a class if sidebar is active
	if ( is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'has-sidebar';
	}

	// Add class for dark mode (default)
	$classes[] = 'warp-theme';
	$classes[] = 'dark-mode';

	return $classes;
}
add_filter( 'body_class', 'warp_body_classes' );

/**
 * Add preconnect for Google Fonts
 */
function warp_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.googleapis.com',
			'crossorigin',
		);
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'warp_resource_hints', 10, 2 );
