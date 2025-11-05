<?php
/**
 * Warp Hero Widget for Elementor
 *
 * @package Warp_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Warp_Hero_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name
	 */
	public function get_name() {
		return 'warp-hero';
	}

	/**
	 * Get widget title
	 */
	public function get_title() {
		return esc_html__( 'Warp Hero', 'warp-theme' );
	}

	/**
	 * Get widget icon
	 */
	public function get_icon() {
		return 'eicon-slider-full-screen';
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
		return array( 'hero', 'banner', 'header', 'warp' );
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

		$this->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'warp-theme' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Welcome to Warp', 'warp-theme' ),
				'placeholder' => esc_html__( 'Enter your title', 'warp-theme' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'subtitle',
			array(
				'label'       => esc_html__( 'Subtitle', 'warp-theme' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'The next generation development environment', 'warp-theme' ),
				'placeholder' => esc_html__( 'Enter your subtitle', 'warp-theme' ),
				'rows'        => 3,
			)
		);

		$this->add_control(
			'primary_button_text',
			array(
				'label'       => esc_html__( 'Primary Button Text', 'warp-theme' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Get Started', 'warp-theme' ),
				'placeholder' => esc_html__( 'Enter button text', 'warp-theme' ),
			)
		);

		$this->add_control(
			'primary_button_link',
			array(
				'label'       => esc_html__( 'Primary Button Link', 'warp-theme' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'warp-theme' ),
				'default'     => array(
					'url' => '#',
				),
			)
		);

		$this->add_control(
			'secondary_button_text',
			array(
				'label'       => esc_html__( 'Secondary Button Text', 'warp-theme' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Learn More', 'warp-theme' ),
				'placeholder' => esc_html__( 'Enter button text', 'warp-theme' ),
			)
		);

		$this->add_control(
			'secondary_button_link',
			array(
				'label'       => esc_html__( 'Secondary Button Link', 'warp-theme' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'warp-theme' ),
				'default'     => array(
					'url' => '#',
				),
			)
		);

		$this->end_controls_section();

		// Style Section
		$this->start_controls_section(
			'style_section',
			array(
				'label' => esc_html__( 'Style', 'warp-theme' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Title Color', 'warp-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .warp-hero__title' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Title Typography', 'warp-theme' ),
				'selector' => '{{WRAPPER}} .warp-hero__title',
			)
		);

		$this->add_control(
			'subtitle_color',
			array(
				'label'     => esc_html__( 'Subtitle Color', 'warp-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .warp-hero__subtitle' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'subtitle_typography',
				'label'    => esc_html__( 'Subtitle Typography', 'warp-theme' ),
				'selector' => '{{WRAPPER}} .warp-hero__subtitle',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'warp-hero' );

		$primary_target   = $settings['primary_button_link']['is_external'] ? ' target="_blank"' : '';
		$primary_nofollow = $settings['primary_button_link']['nofollow'] ? ' rel="nofollow"' : '';

		$secondary_target   = $settings['secondary_button_link']['is_external'] ? ' target="_blank"' : '';
		$secondary_nofollow = $settings['secondary_button_link']['nofollow'] ? ' rel="nofollow"' : '';

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<div class="warp-hero__content">
				<?php if ( ! empty( $settings['title'] ) ) : ?>
					<h1 class="warp-hero__title"><?php echo esc_html( $settings['title'] ); ?></h1>
				<?php endif; ?>

				<?php if ( ! empty( $settings['subtitle'] ) ) : ?>
					<p class="warp-hero__subtitle"><?php echo esc_html( $settings['subtitle'] ); ?></p>
				<?php endif; ?>

				<div class="warp-hero__actions">
					<?php if ( ! empty( $settings['primary_button_text'] ) ) : ?>
						<a href="<?php echo esc_url( $settings['primary_button_link']['url'] ); ?>" class="warp-cta-button"<?php echo $primary_target . $primary_nofollow; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
							<?php echo esc_html( $settings['primary_button_text'] ); ?>
						</a>
					<?php endif; ?>

					<?php if ( ! empty( $settings['secondary_button_text'] ) ) : ?>
						<a href="<?php echo esc_url( $settings['secondary_button_link']['url'] ); ?>" class="warp-cta-button warp-cta-button--secondary"<?php echo $secondary_target . $secondary_nofollow; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
							<?php echo esc_html( $settings['secondary_button_text'] ); ?>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render widget output in the editor
	 */
	protected function content_template() {
		?>
		<#
		view.addRenderAttribute( 'wrapper', 'class', 'warp-hero' );

		var primaryTarget = settings.primary_button_link.is_external ? ' target="_blank"' : '';
		var primaryNofollow = settings.primary_button_link.nofollow ? ' rel="nofollow"' : '';

		var secondaryTarget = settings.secondary_button_link.is_external ? ' target="_blank"' : '';
		var secondaryNofollow = settings.secondary_button_link.nofollow ? ' rel="nofollow"' : '';
		#>
		<div {{{ view.getRenderAttributeString( 'wrapper' ) }}}>
			<div class="warp-hero__content">
				<# if ( settings.title ) { #>
					<h1 class="warp-hero__title">{{{ settings.title }}}</h1>
				<# } #>

				<# if ( settings.subtitle ) { #>
					<p class="warp-hero__subtitle">{{{ settings.subtitle }}}</p>
				<# } #>

				<div class="warp-hero__actions">
					<# if ( settings.primary_button_text ) { #>
						<a href="{{ settings.primary_button_link.url }}" class="warp-cta-button"{{{ primaryTarget }}}{{{ primaryNofollow }}}>
							{{{ settings.primary_button_text }}}
						</a>
					<# } #>

					<# if ( settings.secondary_button_text ) { #>
						<a href="{{ settings.secondary_button_link.url }}" class="warp-cta-button warp-cta-button--secondary"{{{ secondaryTarget }}}{{{ secondaryNofollow }}}>
							{{{ settings.secondary_button_text }}}
						</a>
					<# } #>
				</div>
			</div>
		</div>
		<?php
	}
}
