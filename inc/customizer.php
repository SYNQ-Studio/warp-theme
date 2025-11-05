<?php
/**
 * Theme Customizer
 *
 * @package Warp_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add postMessage support for site title and description
 */
function warp_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	// Remove default background color control (we'll add our own)
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'warp_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'warp_customize_partial_blogdescription',
			)
		);
	}

	/**
	 * Theme Options Section
	 */
	$wp_customize->add_section(
		'warp_theme_options',
		array(
			'title'    => esc_html__( 'Warp Theme Options', 'warp-theme' ),
			'priority' => 30,
		)
	);

	// Dark Mode Toggle
	$wp_customize->add_setting(
		'warp_dark_mode',
		array(
			'default'           => true,
			'sanitize_callback' => 'warp_sanitize_checkbox',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'warp_dark_mode',
		array(
			'label'       => esc_html__( 'Enable Dark Mode by Default', 'warp-theme' ),
			'description' => esc_html__( 'Enable dark mode as the default color scheme', 'warp-theme' ),
			'section'     => 'warp_theme_options',
			'type'        => 'checkbox',
		)
	);

	// Sticky Header
	$wp_customize->add_setting(
		'warp_sticky_header',
		array(
			'default'           => true,
			'sanitize_callback' => 'warp_sanitize_checkbox',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'warp_sticky_header',
		array(
			'label'       => esc_html__( 'Enable Sticky Header', 'warp-theme' ),
			'description' => esc_html__( 'Make the header stick to the top on scroll', 'warp-theme' ),
			'section'     => 'warp_theme_options',
			'type'        => 'checkbox',
		)
	);

	// Smooth Scrolling
	$wp_customize->add_setting(
		'warp_smooth_scroll',
		array(
			'default'           => true,
			'sanitize_callback' => 'warp_sanitize_checkbox',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'warp_smooth_scroll',
		array(
			'label'       => esc_html__( 'Enable Smooth Scrolling', 'warp-theme' ),
			'description' => esc_html__( 'Enable smooth scroll animations', 'warp-theme' ),
			'section'     => 'warp_theme_options',
			'type'        => 'checkbox',
		)
	);

	/**
	 * Header Options Section
	 */
	$wp_customize->add_section(
		'warp_header_options',
		array(
			'title'    => esc_html__( 'Header Options', 'warp-theme' ),
			'priority' => 31,
		)
	);

	// Header Style
	$wp_customize->add_setting(
		'warp_header_style',
		array(
			'default'           => 'solid',
			'sanitize_callback' => 'warp_sanitize_select',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'warp_header_style',
		array(
			'label'   => esc_html__( 'Header Style', 'warp-theme' ),
			'section' => 'warp_header_options',
			'type'    => 'select',
			'choices' => array(
				'solid'       => esc_html__( 'Solid', 'warp-theme' ),
				'transparent' => esc_html__( 'Transparent', 'warp-theme' ),
			),
		)
	);

	// Show Search in Header
	$wp_customize->add_setting(
		'warp_header_search',
		array(
			'default'           => true,
			'sanitize_callback' => 'warp_sanitize_checkbox',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'warp_header_search',
		array(
			'label'       => esc_html__( 'Show Search in Header', 'warp-theme' ),
			'description' => esc_html__( 'Display search icon in header', 'warp-theme' ),
			'section'     => 'warp_header_options',
			'type'        => 'checkbox',
		)
	);

	/**
	 * Footer Options Section
	 */
	$wp_customize->add_section(
		'warp_footer_options',
		array(
			'title'    => esc_html__( 'Footer Options', 'warp-theme' ),
			'priority' => 32,
		)
	);

	// Copyright Text
	$wp_customize->add_setting(
		'warp_copyright_text',
		array(
			'default'           => '',
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'warp_copyright_text',
		array(
			'label'       => esc_html__( 'Copyright Text', 'warp-theme' ),
			'description' => esc_html__( 'Enter custom copyright text for footer', 'warp-theme' ),
			'section'     => 'warp_footer_options',
			'type'        => 'textarea',
		)
	);

	/**
	 * Social Links Section
	 */
	$wp_customize->add_section(
		'warp_social_links',
		array(
			'title'    => esc_html__( 'Social Links', 'warp-theme' ),
			'priority' => 33,
		)
	);

	$social_links = array(
		'twitter'  => 'Twitter',
		'facebook' => 'Facebook',
		'linkedin' => 'LinkedIn',
		'github'   => 'GitHub',
		'youtube'  => 'YouTube',
	);

	foreach ( $social_links as $key => $label ) {
		$wp_customize->add_setting(
			'warp_social_' . $key,
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
				'transport'         => 'refresh',
			)
		);

		$wp_customize->add_control(
			'warp_social_' . $key,
			array(
				'label'   => $label . ' ' . esc_html__( 'URL', 'warp-theme' ),
				'section' => 'warp_social_links',
				'type'    => 'url',
			)
		);
	}

	/**
	 * Typography Section
	 */
	$wp_customize->add_section(
		'warp_typography',
		array(
			'title'    => esc_html__( 'Typography', 'warp-theme' ),
			'priority' => 34,
		)
	);

	// Body Font Size
	$wp_customize->add_setting(
		'warp_body_font_size',
		array(
			'default'           => '16',
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'warp_body_font_size',
		array(
			'label'       => esc_html__( 'Body Font Size (px)', 'warp-theme' ),
			'section'     => 'warp_typography',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 12,
				'max'  => 24,
				'step' => 1,
			),
		)
	);

	/**
	 * Layout Section
	 */
	$wp_customize->add_section(
		'warp_layout',
		array(
			'title'    => esc_html__( 'Layout', 'warp-theme' ),
			'priority' => 35,
		)
	);

	// Container Width
	$wp_customize->add_setting(
		'warp_container_width',
		array(
			'default'           => '1200',
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'warp_container_width',
		array(
			'label'       => esc_html__( 'Container Width (px)', 'warp-theme' ),
			'section'     => 'warp_layout',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 960,
				'max'  => 1920,
				'step' => 10,
			),
		)
	);
}
add_action( 'customize_register', 'warp_customize_register' );

/**
 * Render the site title for the selective refresh partial
 */
function warp_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial
 */
function warp_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Sanitize checkbox
 */
function warp_sanitize_checkbox( $checked ) {
	return ( ( isset( $checked ) && true === $checked ) ? true : false );
}

/**
 * Sanitize select
 */
function warp_sanitize_select( $input, $setting ) {
	$input   = sanitize_key( $input );
	$choices = $setting->manager->get_control( $setting->id )->choices;
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously
 */
function warp_customize_preview_js() {
	wp_enqueue_script(
		'warp-customizer',
		WARP_THEME_URI . '/assets/js/customizer.js',
		array( 'customize-preview' ),
		WARP_THEME_VERSION,
		true
	);
}
add_action( 'customize_preview_init', 'warp_customize_preview_js' );
