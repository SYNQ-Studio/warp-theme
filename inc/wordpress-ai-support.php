<?php
/**
 * WordPress AI Plugin Integration
 *
 * Integration with the WordPress AI plugin for:
 * - AI-powered content generation
 * - Alt text generation for images
 * - Title and excerpt suggestions
 * - Content summarization
 * - AI abilities registration
 *
 * @package Warp_Theme
 * @since 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check if WordPress AI plugin is active
 */
function warp_is_ai_plugin_active() {
	// Check for various possible AI plugin signatures
	$ai_active = function_exists( 'ai_services' ) ||
				class_exists( 'WP_AI\Plugin' ) ||
				defined( 'WP_AI_PLUGIN_VERSION' ) ||
				function_exists( 'wp_ai_abilities' );

	return apply_filters( 'warp_is_ai_plugin_active', $ai_active );
}

/**
 * Add AI features support to theme
 */
function warp_add_ai_theme_support() {
	if ( ! warp_is_ai_plugin_active() ) {
		return;
	}

	// Add theme support for AI features
	add_theme_support( 'wp-ai-features' );
	add_theme_support( 'ai-content-assistant' );
	add_theme_support( 'ai-alt-text-generation' );
	add_theme_support( 'ai-title-generation' );
}
add_action( 'after_setup_theme', 'warp_add_ai_theme_support' );

/**
 * Register custom AI abilities for Warp Theme
 */
function warp_register_ai_abilities() {
	if ( ! warp_is_ai_plugin_active() ) {
		return;
	}

	// Check if abilities registration function exists
	if ( ! function_exists( 'wp_ai_register_ability' ) ) {
		return;
	}

	// Register Warp-specific AI abilities
	$abilities = array(
		'warp_hero_content'  => array(
			'label'       => __( 'Generate Hero Section Content', 'warp-theme' ),
			'description' => __( 'Generate compelling hero section titles and subtitles', 'warp-theme' ),
			'prompt'      => 'Generate a compelling hero section title and subtitle for a modern developer-focused website. The tone should be professional yet exciting.',
		),
		'warp_feature_text'  => array(
			'label'       => __( 'Generate Feature Description', 'warp-theme' ),
			'description' => __( 'Generate feature box descriptions', 'warp-theme' ),
			'prompt'      => 'Generate a concise, compelling description for a feature in 2-3 sentences. Focus on benefits and use professional language.',
		),
		'warp_cta_text'      => array(
			'label'       => __( 'Generate CTA Button Text', 'warp-theme' ),
			'description' => __( 'Generate call-to-action button text', 'warp-theme' ),
			'prompt'      => 'Generate short, action-oriented call-to-action button text (2-4 words maximum). Make it compelling and clear.',
		),
		'warp_meta_description' => array(
			'label'       => __( 'Generate Meta Description', 'warp-theme' ),
			'description' => __( 'Generate SEO-friendly meta descriptions', 'warp-theme' ),
			'prompt'      => 'Generate an SEO-friendly meta description (150-160 characters) that is compelling and includes relevant keywords.',
		),
	);

	foreach ( $abilities as $slug => $ability ) {
		wp_ai_register_ability( $slug, $ability );
	}

	do_action( 'warp_ai_abilities_registered', $abilities );
}
add_action( 'init', 'warp_register_ai_abilities' );

/**
 * Add AI generation button to Elementor widgets
 */
function warp_add_ai_to_elementor_widgets() {
	if ( ! warp_is_ai_plugin_active() ) {
		return;
	}

	// Add AI button CSS
	$ai_css = '
		.warp-ai-generate {
			display: inline-flex;
			align-items: center;
			gap: 4px;
			padding: 4px 12px;
			margin: 8px 0;
			font-size: 12px;
			color: #fff;
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			border: none;
			border-radius: 4px;
			cursor: pointer;
			transition: opacity 0.2s ease;
		}

		.warp-ai-generate:hover {
			opacity: 0.9;
		}

		.warp-ai-generate:disabled {
			opacity: 0.5;
			cursor: not-allowed;
		}

		.warp-ai-generate svg {
			width: 14px;
			height: 14px;
		}

		.warp-ai-loading {
			animation: warp-spin 1s linear infinite;
		}

		@keyframes warp-spin {
			from { transform: rotate(0deg); }
			to { transform: rotate(360deg); }
		}
	';

	wp_add_inline_style( 'elementor-editor', $ai_css );
}
add_action( 'elementor/editor/after_enqueue_styles', 'warp_add_ai_to_elementor_widgets' );

/**
 * AI content generation AJAX handler
 */
function warp_ai_generate_content() {
	check_ajax_referer( 'warp-ai-nonce', 'nonce' );

	if ( ! current_user_can( 'edit_posts' ) ) {
		wp_send_json_error( array( 'message' => __( 'Unauthorized', 'warp-theme' ) ) );
	}

	$ability = isset( $_POST['ability'] ) ? sanitize_text_field( wp_unslash( $_POST['ability'] ) ) : '';
	$context = isset( $_POST['context'] ) ? sanitize_textarea_field( wp_unslash( $_POST['context'] ) ) : '';

	if ( empty( $ability ) ) {
		wp_send_json_error( array( 'message' => __( 'Ability parameter is required', 'warp-theme' ) ) );
	}

	// Generate content using AI
	if ( function_exists( 'wp_ai_generate' ) ) {
		$result = wp_ai_generate( $ability, $context );

		if ( is_wp_error( $result ) ) {
			wp_send_json_error( array( 'message' => $result->get_error_message() ) );
		}

		wp_send_json_success( array( 'content' => $result ) );
	}

	// Fallback if AI function doesn't exist
	wp_send_json_error( array( 'message' => __( 'AI generation is not available', 'warp-theme' ) ) );
}
add_action( 'wp_ajax_warp_ai_generate', 'warp_ai_generate_content' );

/**
 * Add AI generation JavaScript for editor
 */
function warp_ai_editor_scripts() {
	if ( ! warp_is_ai_plugin_active() ) {
		return;
	}

	$script = "
	(function($) {
		'use strict';

		window.WarpAI = {
			generate: function(ability, context, callback) {
				$.ajax({
					url: ajaxurl,
					type: 'POST',
					data: {
						action: 'warp_ai_generate',
						ability: ability,
						context: context,
						nonce: warpAI.nonce
					},
					beforeSend: function() {
						$('.warp-ai-generate').prop('disabled', true)
							.find('svg').addClass('warp-ai-loading');
					},
					success: function(response) {
						if (response.success) {
							callback(null, response.data.content);
						} else {
							callback(response.data.message);
						}
					},
					error: function(xhr, status, error) {
						callback(error);
					},
					complete: function() {
						$('.warp-ai-generate').prop('disabled', false)
							.find('svg').removeClass('warp-ai-loading');
					}
				});
			}
		};
	})(jQuery);
	";

	wp_add_inline_script( 'jquery', $script );

	wp_localize_script(
		'jquery',
		'warpAI',
		array(
			'nonce'  => wp_create_nonce( 'warp-ai-nonce' ),
			'labels' => array(
				'generate'   => __( 'Generate with AI', 'warp-theme' ),
				'generating' => __( 'Generating...', 'warp-theme' ),
				'error'      => __( 'AI generation failed', 'warp-theme' ),
			),
		)
	);
}
add_action( 'elementor/editor/after_enqueue_scripts', 'warp_ai_editor_scripts' );

/**
 * Auto-generate alt text for images
 */
function warp_auto_generate_alt_text( $attachment_id ) {
	if ( ! warp_is_ai_plugin_active() ) {
		return;
	}

	// Check if image already has alt text
	$alt_text = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
	if ( ! empty( $alt_text ) ) {
		return;
	}

	// Check if auto-generation is enabled
	$auto_generate = get_theme_mod( 'warp_ai_auto_alt_text', false );
	if ( ! $auto_generate ) {
		return;
	}

	// Generate alt text using AI
	if ( function_exists( 'wp_ai_generate_alt_text' ) ) {
		$generated_alt = wp_ai_generate_alt_text( $attachment_id );

		if ( ! is_wp_error( $generated_alt ) && ! empty( $generated_alt ) ) {
			update_post_meta( $attachment_id, '_wp_attachment_image_alt', $generated_alt );
		}
	}
}
add_action( 'add_attachment', 'warp_auto_generate_alt_text' );

/**
 * Add AI settings to customizer
 */
function warp_ai_customizer_settings( $wp_customize ) {
	if ( ! warp_is_ai_plugin_active() ) {
		return;
	}

	// Add AI section
	$wp_customize->add_section(
		'warp_ai_settings',
		array(
			'title'    => __( 'AI Features', 'warp-theme' ),
			'priority' => 36,
		)
	);

	// Auto-generate alt text
	$wp_customize->add_setting(
		'warp_ai_auto_alt_text',
		array(
			'default'           => false,
			'sanitize_callback' => 'warp_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'warp_ai_auto_alt_text',
		array(
			'label'       => __( 'Auto-generate Alt Text', 'warp-theme' ),
			'description' => __( 'Automatically generate alt text for uploaded images using AI', 'warp-theme' ),
			'section'     => 'warp_ai_settings',
			'type'        => 'checkbox',
		)
	);

	// AI content suggestions
	$wp_customize->add_setting(
		'warp_ai_content_suggestions',
		array(
			'default'           => true,
			'sanitize_callback' => 'warp_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'warp_ai_content_suggestions',
		array(
			'label'       => __( 'Enable AI Content Suggestions', 'warp-theme' ),
			'description' => __( 'Show AI-powered content suggestions in the editor', 'warp-theme' ),
			'section'     => 'warp_ai_settings',
			'type'        => 'checkbox',
		)
	);
}
add_action( 'customize_register', 'warp_ai_customizer_settings' );

/**
 * Add AI admin notice
 */
function warp_ai_admin_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( ! warp_is_ai_plugin_active() ) {
		?>
		<div class="notice notice-info is-dismissible">
			<p>
				<?php
				printf(
					/* translators: %s: link to WordPress AI plugin */
					esc_html__( 'Warp Theme: Install the %s to unlock AI-powered content generation features.', 'warp-theme' ),
					'<a href="https://github.com/WordPress/ai" target="_blank">' . esc_html__( 'WordPress AI Plugin', 'warp-theme' ) . '</a>'
				);
				?>
			</p>
		</div>
		<?php
	}
}
add_action( 'admin_notices', 'warp_ai_admin_notice' );

/**
 * Filter AI abilities for theme context
 */
function warp_filter_ai_abilities( $abilities ) {
	// Add theme-specific context to abilities
	foreach ( $abilities as $key => $ability ) {
		if ( isset( $ability['prompt'] ) ) {
			$abilities[ $key ]['prompt'] .= ' The content should match the modern, developer-focused aesthetic of the Warp theme.';
		}
	}

	return $abilities;
}
add_filter( 'wp_ai_abilities', 'warp_filter_ai_abilities' );

/**
 * Get AI feature status
 */
function warp_get_ai_features() {
	return array(
		'ai_active'             => warp_is_ai_plugin_active(),
		'abilities_registered'  => warp_is_ai_plugin_active(),
		'auto_alt_text'         => get_theme_mod( 'warp_ai_auto_alt_text', false ),
		'content_suggestions'   => get_theme_mod( 'warp_ai_content_suggestions', true ),
		'elementor_integration' => warp_is_ai_plugin_active() && class_exists( '\Elementor\Plugin' ),
	);
}

/**
 * Add AI-powered excerpt generation
 */
function warp_ai_generate_excerpt( $post_id ) {
	if ( ! warp_is_ai_plugin_active() ) {
		return;
	}

	$post = get_post( $post_id );

	// Only generate if excerpt is empty
	if ( ! empty( $post->post_excerpt ) ) {
		return;
	}

	// Check if auto-generation is enabled
	$auto_generate = get_theme_mod( 'warp_ai_auto_excerpt', false );
	if ( ! $auto_generate ) {
		return;
	}

	if ( function_exists( 'wp_ai_generate_excerpt' ) ) {
		$excerpt = wp_ai_generate_excerpt( $post->post_content );

		if ( ! is_wp_error( $excerpt ) && ! empty( $excerpt ) ) {
			wp_update_post(
				array(
					'ID'           => $post_id,
					'post_excerpt' => $excerpt,
				)
			);
		}
	}
}
add_action( 'save_post', 'warp_ai_generate_excerpt', 20 );
