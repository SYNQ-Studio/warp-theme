<?php
/**
 * Warp Smart Content Widget for Elementor V4 + AI
 *
 * Advanced widget leveraging:
 * - Elementor V4 Variables
 * - AI-powered content generation
 * - Filters and transitions
 * - Atomic Elements structure
 *
 * @package Warp_Theme
 * @since 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Warp_Smart_Content_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name
	 */
	public function get_name() {
		return 'warp-smart-content';
	}

	/**
	 * Get widget title
	 */
	public function get_title() {
		return esc_html__( 'Warp Smart Content (AI + V4)', 'warp-theme' );
	}

	/**
	 * Get widget icon
	 */
	public function get_icon() {
		return 'eicon-ai';
	}

	/**
	 * Get widget categories
	 */
	public function get_categories() {
		return array( 'warp-theme' );
	}

	/**
	 * Get widget keywords
	 */
	public function get_keywords() {
		return array( 'smart', 'ai', 'content', 'warp', 'v4', 'variables' );
	}

	/**
	 * Register widget controls
	 */
	protected function register_controls() {
		// Content Section
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'warp-theme' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		// AI Generation Toggle
		if ( function_exists( 'warp_is_ai_plugin_active' ) && warp_is_ai_plugin_active() ) {
			$this->add_control(
				'enable_ai_generation',
				array(
					'label'        => esc_html__( 'AI Content Generation', 'warp-theme' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'warp-theme' ),
					'label_off'    => esc_html__( 'Off', 'warp-theme' ),
					'return_value' => 'yes',
					'default'      => 'no',
					'separator'    => 'after',
				)
			);

			$this->add_control(
				'ai_generate_button',
				array(
					'type'            => \Elementor\Controls_Manager::RAW_HTML,
					'raw'             => '<button type="button" class="warp-ai-generate" data-ability="warp_hero_content">
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="currentColor"/>
						</svg>
						' . esc_html__( 'Generate with AI', 'warp-theme' ) . '
					</button>',
					'content_classes' => 'elementor-descriptor',
					'condition'       => array(
						'enable_ai_generation' => 'yes',
					),
				)
			);
		}

		$this->add_control(
			'heading',
			array(
				'label'       => esc_html__( 'Heading', 'warp-theme' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Smart Content Block', 'warp-theme' ),
				'placeholder' => esc_html__( 'Enter heading', 'warp-theme' ),
				'label_block' => true,
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'content',
			array(
				'label'       => esc_html__( 'Content', 'warp-theme' ),
				'type'        => \Elementor\Controls_Manager::WYSIWYG,
				'default'     => esc_html__( 'Add your content here. Use AI generation for smart suggestions!', 'warp-theme' ),
				'placeholder' => esc_html__( 'Enter content', 'warp-theme' ),
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'layout',
			array(
				'label'   => esc_html__( 'Layout', 'warp-theme' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array(
					'default' => esc_html__( 'Default', 'warp-theme' ),
					'card'    => esc_html__( 'Card', 'warp-theme' ),
					'minimal' => esc_html__( 'Minimal', 'warp-theme' ),
				),
			)
		);

		$this->end_controls_section();

		// V4 Variables Section
		if ( function_exists( 'warp_is_elementor_v4_active' ) && warp_is_elementor_v4_active() ) {
			$this->start_controls_section(
				'v4_variables_section',
				array(
					'label' => esc_html__( 'V4 Variables', 'warp-theme' ),
					'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
				)
			);

			$this->add_control(
				'use_v4_variables',
				array(
					'label'        => esc_html__( 'Use Theme Variables', 'warp-theme' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'warp-theme' ),
					'label_off'    => esc_html__( 'No', 'warp-theme' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'description'  => esc_html__( 'Use Warp theme V4 variables for consistent styling', 'warp-theme' ),
				)
			);

			$this->add_control(
				'v4_info',
				array(
					'type'            => \Elementor\Controls_Manager::RAW_HTML,
					'raw'             => '<div style="padding:10px;background:#667eea;color:#fff;border-radius:4px;">
						<strong>' . esc_html__( 'Elementor V4 Active!', 'warp-theme' ) . '</strong><br>
						' . esc_html__( 'This widget uses Variables, Filters, and Atomic Elements.', 'warp-theme' ) . '
					</div>',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				)
			);

			$this->end_controls_section();
		}

		// Style Section
		$this->start_controls_section(
			'style_section',
			array(
				'label' => esc_html__( 'Style', 'warp-theme' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'heading_color',
			array(
				'label'     => esc_html__( 'Heading Color', 'warp-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .warp-smart-content__heading' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .warp-smart-content__heading',
			)
		);

		$this->add_control(
			'content_color',
			array(
				'label'     => esc_html__( 'Content Color', 'warp-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .warp-smart-content__text' => 'color: {{VALUE}}',
				),
			)
		);

		// V4 Filters
		if ( function_exists( 'warp_is_elementor_v4_active' ) && warp_is_elementor_v4_active() ) {
			$this->add_control(
				'hover_filter',
				array(
					'label'   => esc_html__( 'Hover Filter (V4)', 'warp-theme' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'default' => 'none',
					'options' => array(
						'none'       => esc_html__( 'None', 'warp-theme' ),
						'brightness' => esc_html__( 'Brightness', 'warp-theme' ),
						'blur'       => esc_html__( 'Blur', 'warp-theme' ),
						'contrast'   => esc_html__( 'Contrast', 'warp-theme' ),
					),
				)
			);
		}

		$this->end_controls_section();

		// Advanced Section with V4 Transitions
		$this->start_controls_section(
			'advanced_section',
			array(
				'label' => esc_html__( 'Advanced', 'warp-theme' ),
				'tab'   => \Elementor\Controls_Manager::TAB_ADVANCED,
			)
		);

		if ( function_exists( 'warp_is_elementor_v4_active' ) && warp_is_elementor_v4_active() ) {
			$this->add_control(
				'transition_type',
				array(
					'label'   => esc_html__( 'Transition Type (V4)', 'warp-theme' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'default' => 'warp-base',
					'options' => array(
						'warp-fast'   => esc_html__( 'Fast (150ms)', 'warp-theme' ),
						'warp-base'   => esc_html__( 'Base (250ms)', 'warp-theme' ),
						'warp-slow'   => esc_html__( 'Slow (350ms)', 'warp-theme' ),
						'warp-smooth' => esc_html__( 'Smooth (500ms)', 'warp-theme' ),
					),
				)
			);
		}

		$this->add_control(
			'custom_attributes',
			array(
				'label'       => esc_html__( 'Custom Attributes', 'warp-theme' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => 'data-aos="fade-up"',
				'description' => esc_html__( 'Add custom HTML attributes (one per line)', 'warp-theme' ),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'warp-smart-content' );
		$this->add_render_attribute( 'wrapper', 'class', 'warp-layout-' . $settings['layout'] );

		// Add V4 classes
		if ( function_exists( 'warp_is_elementor_v4_active' ) && warp_is_elementor_v4_active() ) {
			$this->add_render_attribute( 'wrapper', 'class', 'e-atomic-widget' );

			if ( isset( $settings['use_v4_variables'] ) && 'yes' === $settings['use_v4_variables'] ) {
				$this->add_render_attribute( 'wrapper', 'class', 'warp-use-variables' );
			}

			if ( isset( $settings['hover_filter'] ) && 'none' !== $settings['hover_filter'] ) {
				$this->add_render_attribute( 'wrapper', 'class', 'warp-filter-' . $settings['hover_filter'] );
				$this->add_render_attribute( 'wrapper', 'class', 'warp-hover-filter' );
			}

			if ( isset( $settings['transition_type'] ) ) {
				$this->add_render_attribute( 'wrapper', 'data-transition', $settings['transition_type'] );
			}
		}

		// Add custom attributes
		if ( ! empty( $settings['custom_attributes'] ) ) {
			$attributes = explode( "\n", $settings['custom_attributes'] );
			foreach ( $attributes as $attribute ) {
				if ( strpos( $attribute, '=' ) !== false ) {
					list( $key, $value ) = explode( '=', $attribute, 2 );
					$key   = trim( $key );
					$value = trim( $value, ' "' );
					$this->add_render_attribute( 'wrapper', $key, $value );
				}
			}
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<?php if ( ! empty( $settings['heading'] ) ) : ?>
				<h3 class="warp-smart-content__heading">
					<?php echo esc_html( $settings['heading'] ); ?>
				</h3>
			<?php endif; ?>

			<?php if ( ! empty( $settings['content'] ) ) : ?>
				<div class="warp-smart-content__text">
					<?php echo wp_kses_post( $settings['content'] ); ?>
				</div>
			<?php endif; ?>

			<?php if ( function_exists( 'warp_is_ai_plugin_active' ) && warp_is_ai_plugin_active() && isset( $settings['enable_ai_generation'] ) && 'yes' === $settings['enable_ai_generation'] ) : ?>
				<div class="warp-smart-content__ai-badge">
					<svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
						<path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
					</svg>
					<?php esc_html_e( 'AI Enhanced', 'warp-theme' ); ?>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Render widget output in the editor
	 */
	protected function content_template() {
		?>
		<#
		view.addRenderAttribute( 'wrapper', 'class', 'warp-smart-content' );
		view.addRenderAttribute( 'wrapper', 'class', 'warp-layout-' + settings.layout );

		if ( typeof warp_is_elementor_v4_active !== 'undefined' && warp_is_elementor_v4_active ) {
			view.addRenderAttribute( 'wrapper', 'class', 'e-atomic-widget' );

			if ( settings.use_v4_variables === 'yes' ) {
				view.addRenderAttribute( 'wrapper', 'class', 'warp-use-variables' );
			}

			if ( settings.hover_filter && settings.hover_filter !== 'none' ) {
				view.addRenderAttribute( 'wrapper', 'class', 'warp-filter-' + settings.hover_filter );
				view.addRenderAttribute( 'wrapper', 'class', 'warp-hover-filter' );
			}
		}
		#>
		<div {{{ view.getRenderAttributeString( 'wrapper' ) }}}>
			<# if ( settings.heading ) { #>
				<h3 class="warp-smart-content__heading">{{{ settings.heading }}}</h3>
			<# } #>

			<# if ( settings.content ) { #>
				<div class="warp-smart-content__text">{{{ settings.content }}}</div>
			<# } #>

			<# if ( settings.enable_ai_generation === 'yes' ) { #>
				<div class="warp-smart-content__ai-badge">
					<svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
						<path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
					</svg>
					<?php esc_html_e( 'AI Enhanced', 'warp-theme' ); ?>
				</div>
			<# } #>
		</div>
		<?php
	}
}
