<?php
/**
 * Warp Feature Widget for Elementor
 *
 * @package Warp_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Warp_Feature_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'warp-feature';
	}

	public function get_title() {
		return esc_html__( 'Warp Feature', 'warp-theme' );
	}

	public function get_icon() {
		return 'eicon-feature-list';
	}

	public function get_categories() {
		return array( 'warp-theme' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'warp-theme' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'icon',
			array(
				'label'   => esc_html__( 'Icon', 'warp-theme' ),
				'type'    => \Elementor\Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'fas fa-star',
					'library' => 'solid',
				),
			)
		);

		$this->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'warp-theme' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Feature Title', 'warp-theme' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'description',
			array(
				'label'   => esc_html__( 'Description', 'warp-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Feature description goes here.', 'warp-theme' ),
				'rows'    => 4,
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<div class="warp-feature">
			<div class="warp-feature__icon">
				<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], array( 'aria-hidden' => 'true' ) ); ?>
			</div>
			<h3 class="warp-feature__title"><?php echo esc_html( $settings['title'] ); ?></h3>
			<p class="warp-feature__description"><?php echo esc_html( $settings['description'] ); ?></p>
		</div>
		<?php
	}
}
