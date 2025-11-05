<?php
/**
 * Elementor Pro V4 Alpha Support
 *
 * Enhanced support for Elementor Pro V4 Alpha features including:
 * - Variables system
 * - Filters
 * - Atomic Elements
 * - Size Variables
 * - Granular Transitions
 * - Cloud Templates
 *
 * @package Warp_Theme
 * @since 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check if Elementor Pro is active and V4 is enabled
 */
function warp_is_elementor_v4_active() {
	if ( ! class_exists( '\ElementorPro\Plugin' ) ) {
		return false;
	}

	// Check if V4 is enabled
	$v4_enabled = get_option( 'elementor_editor_v4', 'no' );
	return 'yes' === $v4_enabled;
}

/**
 * Register theme variables for Elementor V4
 */
function warp_register_elementor_v4_variables() {
	if ( ! warp_is_elementor_v4_active() ) {
		return;
	}

	// Register color variables
	$color_variables = array(
		'warp-primary-bg'     => array(
			'label' => __( 'Warp Primary Background', 'warp-theme' ),
			'value' => '#121212',
			'type'  => 'color',
		),
		'warp-secondary-bg'   => array(
			'label' => __( 'Warp Secondary Background', 'warp-theme' ),
			'value' => '#1a1a1a',
			'type'  => 'color',
		),
		'warp-primary-text'   => array(
			'label' => __( 'Warp Primary Text', 'warp-theme' ),
			'value' => '#ffffff',
			'type'  => 'color',
		),
		'warp-secondary-text' => array(
			'label' => __( 'Warp Secondary Text', 'warp-theme' ),
			'value' => '#e3e2e0',
			'type'  => 'color',
		),
		'warp-accent'         => array(
			'label' => __( 'Warp Accent', 'warp-theme' ),
			'value' => '#e3e2e0',
			'type'  => 'color',
		),
		'warp-border'         => array(
			'label' => __( 'Warp Border', 'warp-theme' ),
			'value' => '#333333',
			'type'  => 'color',
		),
	);

	// Register size variables
	$size_variables = array(
		'warp-spacing-xs'    => array(
			'label' => __( 'Warp Spacing XS', 'warp-theme' ),
			'value' => '4px',
			'type'  => 'size',
		),
		'warp-spacing-sm'    => array(
			'label' => __( 'Warp Spacing SM', 'warp-theme' ),
			'value' => '8px',
			'type'  => 'size',
		),
		'warp-spacing-md'    => array(
			'label' => __( 'Warp Spacing MD', 'warp-theme' ),
			'value' => '16px',
			'type'  => 'size',
		),
		'warp-spacing-lg'    => array(
			'label' => __( 'Warp Spacing LG', 'warp-theme' ),
			'value' => '24px',
			'type'  => 'size',
		),
		'warp-spacing-xl'    => array(
			'label' => __( 'Warp Spacing XL', 'warp-theme' ),
			'value' => '32px',
			'type'  => 'size',
		),
		'warp-radius-sm'     => array(
			'label' => __( 'Warp Radius Small', 'warp-theme' ),
			'value' => '4px',
			'type'  => 'size',
		),
		'warp-radius-md'     => array(
			'label' => __( 'Warp Radius Medium', 'warp-theme' ),
			'value' => '8px',
			'type'  => 'size',
		),
		'warp-radius-lg'     => array(
			'label' => __( 'Warp Radius Large', 'warp-theme' ),
			'value' => '12px',
			'type'  => 'size',
		),
		'warp-container-width' => array(
			'label' => __( 'Warp Container Width', 'warp-theme' ),
			'value' => '1200px',
			'type'  => 'size',
		),
	);

	// Apply filters to allow customization
	$color_variables = apply_filters( 'warp_elementor_v4_color_variables', $color_variables );
	$size_variables  = apply_filters( 'warp_elementor_v4_size_variables', $size_variables );

	// Store variables
	update_option( 'warp_elementor_v4_color_variables', $color_variables );
	update_option( 'warp_elementor_v4_size_variables', $size_variables );
}
add_action( 'after_setup_theme', 'warp_register_elementor_v4_variables' );

/**
 * Add V4 variables CSS output
 */
function warp_output_elementor_v4_variables() {
	if ( ! warp_is_elementor_v4_active() ) {
		return;
	}

	$color_variables = get_option( 'warp_elementor_v4_color_variables', array() );
	$size_variables  = get_option( 'warp_elementor_v4_size_variables', array() );

	$css = ':root {';

	foreach ( $color_variables as $key => $data ) {
		$css .= sprintf( '--%s: %s;', esc_attr( $key ), esc_attr( $data['value'] ) );
	}

	foreach ( $size_variables as $key => $data ) {
		$css .= sprintf( '--%s: %s;', esc_attr( $key ), esc_attr( $data['value'] ) );
	}

	$css .= '}';

	wp_add_inline_style( 'warp-main-style', $css );
}
add_action( 'wp_enqueue_scripts', 'warp_output_elementor_v4_variables', 20 );

/**
 * Add V4 Atomic Elements support
 */
function warp_add_elementor_v4_atomic_support() {
	if ( ! warp_is_elementor_v4_active() ) {
		return;
	}

	// Enable atomic elements
	update_option( 'elementor_enable_atomic_widgets', 'yes' );

	// Add custom CSS for atomic elements optimization
	$atomic_css = '
		/* Elementor V4 Atomic Elements Optimization */
		.e-atomic {
			position: relative;
		}

		.e-atomic-text {
			line-height: inherit;
		}

		.e-atomic-heading {
			margin: 0;
			padding: 0;
		}

		/* Single DIV wrapper optimization */
		.e-con.e-parent {
			display: flex;
		}

		.e-con.e-flex {
			display: flex;
			flex-wrap: wrap;
		}

		.e-con.e-grid {
			display: grid;
		}
	';

	wp_add_inline_style( 'elementor-frontend', $atomic_css );
}
add_action( 'wp_enqueue_scripts', 'warp_add_elementor_v4_atomic_support', 30 );

/**
 * Register custom transitions for V4
 */
function warp_register_elementor_v4_transitions() {
	if ( ! warp_is_elementor_v4_active() ) {
		return;
	}

	$transitions = array(
		'warp-fast'   => array(
			'label'    => __( 'Warp Fast', 'warp-theme' ),
			'duration' => '150ms',
			'timing'   => 'ease-in-out',
		),
		'warp-base'   => array(
			'label'    => __( 'Warp Base', 'warp-theme' ),
			'duration' => '250ms',
			'timing'   => 'ease-in-out',
		),
		'warp-slow'   => array(
			'label'    => __( 'Warp Slow', 'warp-theme' ),
			'duration' => '350ms',
			'timing'   => 'ease-in-out',
		),
		'warp-smooth' => array(
			'label'    => __( 'Warp Smooth', 'warp-theme' ),
			'duration' => '500ms',
			'timing'   => 'cubic-bezier(0.4, 0, 0.2, 1)',
		),
	);

	$transitions = apply_filters( 'warp_elementor_v4_transitions', $transitions );
	update_option( 'warp_elementor_v4_transitions', $transitions );
}
add_action( 'after_setup_theme', 'warp_register_elementor_v4_transitions' );

/**
 * Add filters support for V4
 */
function warp_add_elementor_v4_filters() {
	if ( ! warp_is_elementor_v4_active() ) {
		return;
	}

	$filters_css = '
		/* Elementor V4 Filters Support */
		.warp-filter-blur {
			filter: blur(8px);
		}

		.warp-filter-brightness {
			filter: brightness(1.2);
		}

		.warp-filter-contrast {
			filter: contrast(1.1);
		}

		.warp-filter-grayscale {
			filter: grayscale(100%);
		}

		.warp-filter-hue {
			filter: hue-rotate(45deg);
		}

		.warp-filter-invert {
			filter: invert(100%);
		}

		.warp-filter-saturate {
			filter: saturate(1.5);
		}

		.warp-filter-sepia {
			filter: sepia(100%);
		}

		/* Hover state filters */
		.warp-hover-filter:hover {
			transition: filter var(--warp-transition-base, 250ms ease-in-out);
		}
	';

	wp_add_inline_style( 'elementor-frontend', $filters_css );
}
add_action( 'wp_enqueue_scripts', 'warp_add_elementor_v4_filters', 30 );

/**
 * Cloud Templates integration
 */
function warp_setup_elementor_cloud_templates() {
	if ( ! class_exists( '\ElementorPro\Plugin' ) ) {
		return;
	}

	// Enable cloud templates
	update_option( 'elementor_enable_cloud_templates', 'yes' );
}
add_action( 'after_switch_theme', 'warp_setup_elementor_cloud_templates' );

/**
 * Add V4 status to admin notice
 */
function warp_elementor_v4_admin_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( ! class_exists( '\Elementor\Plugin' ) ) {
		?>
		<div class="notice notice-warning">
			<p><?php esc_html_e( 'Warp Theme: Elementor is not installed. Install Elementor to unlock full theme features.', 'warp-theme' ); ?></p>
		</div>
		<?php
		return;
	}

	if ( ! warp_is_elementor_v4_active() ) {
		?>
		<div class="notice notice-info">
			<p>
				<?php
				printf(
					/* translators: %s: link to Elementor settings */
					esc_html__( 'Warp Theme: Enable Elementor V4 Alpha in %s to unlock advanced features like Variables, Filters, and Atomic Elements.', 'warp-theme' ),
					'<a href="' . esc_url( admin_url( 'admin.php?page=elementor#tab-editor' ) ) . '">' . esc_html__( 'Elementor Settings', 'warp-theme' ) . '</a>'
				);
				?>
			</p>
		</div>
		<?php
	}
}
add_action( 'admin_notices', 'warp_elementor_v4_admin_notice' );

/**
 * Register V4 optimized widget styles
 */
function warp_elementor_v4_widget_styles() {
	if ( ! warp_is_elementor_v4_active() ) {
		return;
	}

	$v4_styles = '
		/* Elementor V4 Optimized Widget Styles */

		/* Single DIV wrapper - no nested divs needed */
		.e-atomic-widget {
			position: relative;
			display: block;
		}

		/* Variables usage in widgets */
		.warp-widget {
			background: var(--warp-secondary-bg);
			color: var(--warp-primary-text);
			padding: var(--warp-spacing-lg);
			border-radius: var(--warp-radius-md);
			border: 1px solid var(--warp-border);
			transition: all var(--warp-transition-base);
		}

		.warp-widget:hover {
			transform: translateY(-4px);
			box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
		}

		/* V4 Flexbox containers */
		.e-con.warp-flex-container {
			gap: var(--warp-spacing-md);
		}

		/* V4 Grid containers */
		.e-con.warp-grid-container {
			grid-gap: var(--warp-spacing-md);
		}

		/* Granular transitions */
		.warp-transition-transform {
			transition-property: transform;
			transition-duration: var(--warp-transition-base);
			transition-timing-function: ease-in-out;
		}

		.warp-transition-opacity {
			transition-property: opacity;
			transition-duration: var(--warp-transition-base);
			transition-timing-function: ease-in-out;
		}

		.warp-transition-color {
			transition-property: color, background-color, border-color;
			transition-duration: var(--warp-transition-base);
			transition-timing-function: ease-in-out;
		}
	';

	wp_add_inline_style( 'elementor-frontend', $v4_styles );
}
add_action( 'wp_enqueue_scripts', 'warp_elementor_v4_widget_styles', 30 );

/**
 * Add custom attributes support for V4
 */
function warp_elementor_v4_custom_attributes( $element ) {
	if ( ! warp_is_elementor_v4_active() ) {
		return;
	}

	// Add custom attributes control
	$element->add_control(
		'warp_custom_attributes',
		array(
			'label'       => __( 'Warp Custom Attributes', 'warp-theme' ),
			'type'        => \Elementor\Controls_Manager::TEXTAREA,
			'dynamic'     => array(
				'active' => true,
			),
			'placeholder' => 'data-attribute="value"',
			'description' => __( 'Add custom HTML attributes (one per line)', 'warp-theme' ),
		)
	);
}
add_action( 'elementor/element/common/_section_style/after_section_end', 'warp_elementor_v4_custom_attributes' );

/**
 * Get V4 feature status
 */
function warp_get_elementor_v4_features() {
	return array(
		'v4_enabled'       => warp_is_elementor_v4_active(),
		'variables'        => warp_is_elementor_v4_active(),
		'filters'          => warp_is_elementor_v4_active(),
		'atomic_elements'  => warp_is_elementor_v4_active(),
		'size_variables'   => warp_is_elementor_v4_active(),
		'transitions'      => warp_is_elementor_v4_active(),
		'cloud_templates'  => class_exists( '\ElementorPro\Plugin' ),
		'pro_active'       => class_exists( '\ElementorPro\Plugin' ),
		'elementor_version' => defined( 'ELEMENTOR_VERSION' ) ? ELEMENTOR_VERSION : '',
	);
}
