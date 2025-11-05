<?php
/**
 * Warp Terminal Widget for Elementor
 *
 * @package Warp_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Warp_Terminal_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'warp-terminal';
	}

	public function get_title() {
		return esc_html__( 'Warp Terminal', 'warp-theme' );
	}

	public function get_icon() {
		return 'eicon-code';
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
			'code',
			array(
				'label'   => esc_html__( 'Terminal Code', 'warp-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => '$ npm install warp-theme',
				'rows'    => 10,
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<div class="warp-terminal">
			<div class="warp-terminal__header">
				<span class="warp-terminal__button warp-terminal__button--close"></span>
				<span class="warp-terminal__button warp-terminal__button--minimize"></span>
				<span class="warp-terminal__button warp-terminal__button--maximize"></span>
			</div>
			<div class="warp-terminal__content">
				<pre><code><?php echo esc_html( $settings['code'] ); ?></code></pre>
			</div>
		</div>
		<?php
	}
}
