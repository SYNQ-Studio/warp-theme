<?php
/**
 * Elementor compatibility and custom widgets
 *
 * @package Warp_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Elementor theme support
 */
function warp_elementor_support() {
	// Add Elementor theme support
	add_theme_support( 'elementor' );

	// Add Elementor theme locations
	add_theme_support(
		'elementor',
		array(
			'settings' => array(
				'page_title_selector' => 'h1.entry-title',
				'disable_color_schemes' => 'yes',
				'disable_typography_schemes' => 'yes',
			),
		)
	);
}
add_action( 'after_setup_theme', 'warp_elementor_support' );

/**
 * Register Elementor locations
 */
function warp_register_elementor_locations( $elementor_theme_manager ) {
	$elementor_theme_manager->register_all_core_location();
}
add_action( 'elementor/theme/register_locations', 'warp_register_elementor_locations' );

/**
 * Load custom Elementor widgets
 */
function warp_register_elementor_widgets( $widgets_manager ) {
	// Check if Elementor is active
	if ( ! did_action( 'elementor/loaded' ) ) {
		return;
	}

	// Include widget files
	$widget_files = array(
		'warp-hero',
		'warp-feature',
		'warp-cta-button',
		'warp-terminal',
	);

	foreach ( $widget_files as $widget_file ) {
		$file_path = WARP_THEME_DIR . '/elementor/widgets/' . $widget_file . '.php';
		if ( file_exists( $file_path ) ) {
			require_once $file_path;
		}
	}

	// Register widgets
	if ( class_exists( 'Warp_Hero_Widget' ) ) {
		$widgets_manager->register( new Warp_Hero_Widget() );
	}

	if ( class_exists( 'Warp_Feature_Widget' ) ) {
		$widgets_manager->register( new Warp_Feature_Widget() );
	}

	if ( class_exists( 'Warp_CTA_Button_Widget' ) ) {
		$widgets_manager->register( new Warp_CTA_Button_Widget() );
	}

	if ( class_exists( 'Warp_Terminal_Widget' ) ) {
		$widgets_manager->register( new Warp_Terminal_Widget() );
	}
}
add_action( 'elementor/widgets/register', 'warp_register_elementor_widgets' );

/**
 * Register custom Elementor widget categories
 */
function warp_add_elementor_widget_categories( $elements_manager ) {
	$elements_manager->add_category(
		'warp-theme',
		array(
			'title' => esc_html__( 'Warp Theme', 'warp-theme' ),
			'icon'  => 'fa fa-plug',
		)
	);
}
add_action( 'elementor/elements/categories_registered', 'warp_add_elementor_widget_categories' );

/**
 * Enqueue Elementor widget styles
 */
function warp_elementor_widget_styles() {
	wp_enqueue_style(
		'warp-elementor-widgets',
		WARP_THEME_URI . '/assets/css/elementor-widgets.css',
		array(),
		WARP_THEME_VERSION
	);
}
add_action( 'elementor/frontend/after_enqueue_styles', 'warp_elementor_widget_styles' );

/**
 * Enqueue Elementor editor styles
 */
function warp_elementor_editor_styles() {
	wp_enqueue_style(
		'warp-elementor-editor',
		WARP_THEME_URI . '/assets/css/elementor-editor.css',
		array(),
		WARP_THEME_VERSION
	);
}
add_action( 'elementor/editor/after_enqueue_styles', 'warp_elementor_editor_styles' );

/**
 * Add custom CSS to Elementor
 */
function warp_elementor_custom_css() {
	if ( ! did_action( 'elementor/loaded' ) ) {
		return;
	}

	// Custom CSS for Elementor compatibility
	$custom_css = '
		.elementor-section {
			position: relative;
		}
		.elementor-widget-wrap {
			position: relative;
		}
	';

	wp_add_inline_style( 'elementor-frontend', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'warp_elementor_custom_css', 20 );

/**
 * Add body class when Elementor is active
 */
function warp_elementor_body_class( $classes ) {
	if ( did_action( 'elementor/loaded' ) ) {
		$classes[] = 'elementor-active';
	}

	// Check if current page is built with Elementor
	if ( class_exists( '\Elementor\Plugin' ) ) {
		$document = \Elementor\Plugin::$instance->documents->get( get_the_ID() );
		if ( $document && $document->is_built_with_elementor() ) {
			$classes[] = 'elementor-page';
		}
	}

	return $classes;
}
add_filter( 'body_class', 'warp_elementor_body_class' );

/**
 * Disable Elementor default fonts if needed
 */
function warp_elementor_disable_defaults() {
	// Update Elementor default options
	if ( did_action( 'elementor/loaded' ) ) {
		update_option( 'elementor_disable_color_schemes', 'yes' );
		update_option( 'elementor_disable_typography_schemes', 'yes' );
		update_option( 'elementor_container_width', '1200' );
		update_option( 'elementor_viewport_lg', '1024' );
		update_option( 'elementor_viewport_md', '768' );
	}
}
add_action( 'after_switch_theme', 'warp_elementor_disable_defaults' );

/**
 * Add theme colors to Elementor
 */
function warp_add_elementor_colors() {
	if ( ! did_action( 'elementor/loaded' ) ) {
		return;
	}

	// Custom colors for Elementor color picker
	$custom_colors = array(
		array(
			'_id'   => 'warp_primary_bg',
			'title' => esc_html__( 'Warp Primary BG', 'warp-theme' ),
			'color' => '#121212',
		),
		array(
			'_id'   => 'warp_primary_text',
			'title' => esc_html__( 'Warp Primary Text', 'warp-theme' ),
			'color' => '#ffffff',
		),
		array(
			'_id'   => 'warp_accent',
			'title' => esc_html__( 'Warp Accent', 'warp-theme' ),
			'color' => '#e3e2e0',
		),
		array(
			'_id'   => 'warp_gray',
			'title' => esc_html__( 'Warp Gray', 'warp-theme' ),
			'color' => '#afaeac',
		),
		array(
			'_id'   => 'warp_dark_gray',
			'title' => esc_html__( 'Warp Dark Gray', 'warp-theme' ),
			'color' => '#353534',
		),
	);

	update_option( 'elementor_custom_colors', $custom_colors );
}
add_action( 'after_switch_theme', 'warp_add_elementor_colors' );

/**
 * Add theme fonts to Elementor
 */
function warp_add_elementor_fonts( $fonts ) {
	$fonts['Inter'] = 'system';
	return $fonts;
}
add_filter( 'elementor/fonts/groups', 'warp_add_elementor_fonts' );

/**
 * Check if page is built with Elementor
 */
function warp_is_elementor_page() {
	if ( class_exists( '\Elementor\Plugin' ) ) {
		return \Elementor\Plugin::$instance->db->is_built_with_elementor( get_the_ID() );
	}
	return false;
}
