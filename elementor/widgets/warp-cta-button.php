<?php
/**
 * Warp CTA Button Widget for Elementor
 *
 * @package Warp_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Warp_CTA_Button_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'warp-cta-button';
	}

	public function get_title() {
		return esc_html__( 'Warp CTA Button', 'warp-theme' );
	}

	public function get_icon() {
		return 'eicon-button';
	}

	public function get_categories() {
		return array( 'warp-theme' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'warp-theme' ),
			)
		);

		$this->add_control(
			'text',
			array(
				'label'   => esc_html__( 'Button Text', 'warp-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Click Here', 'warp-theme' ),
			)
		);

		$this->add_control(
			'link',
			array(
				'label'   => esc_html__( 'Link', 'warp-theme' ),
				'type'    => \Elementor\Controls_Manager::URL,
				'default' => array( 'url' => '#' ),
			)
		);

		$this->add_control(
			'style',
			array(
				'label'   => esc_html__( 'Style', 'warp-theme' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'primary',
				'options' => array(
					'primary'   => esc_html__( 'Primary', 'warp-theme' ),
					'secondary' => esc_html__( 'Secondary', 'warp-theme' ),
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$target   = $settings['link']['is_external'] ? ' target="_blank"' : '';
		$nofollow = $settings['link']['nofollow'] ? ' rel="nofollow"' : '';
		$class    = 'secondary' === $settings['style'] ? 'warp-cta-button warp-cta-button--secondary' : 'warp-cta-button';
		?>
		<a href="<?php echo esc_url( $settings['link']['url'] ); ?>" class="<?php echo esc_attr( $class ); ?>"<?php echo $target . $nofollow; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<?php echo esc_html( $settings['text'] ); ?>
		</a>
		<?php
	}
}
