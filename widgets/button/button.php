<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use ZyreAddons\Elementor\Traits\Button_Trait;

defined( 'ABSPATH' ) || die();

/**
 * The Button widget class
 *
 * @since 1.0.0
 * @package ZyreAddons
 */
class Button extends Base {

	use Button_Trait;

	public function get_title() {
		return esc_html__( 'Button', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Button';
	}

	public function get_keywords() {
		return [ 'button', 'btn', 'advance button', 'link' ];
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	/**
	 * Register widget content controls
	 */
	protected function register_content_controls() {
		$this->start_controls_section(
			'section_button',
			[
				'label' => esc_html__( 'Button Content', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$this->add_responsive_control(
			'button_align_x',
			[
				'label'        => esc_html__( 'Button Alignment', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'left'    => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'   => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default'      => '',
			]
		);

		$this->register_button_content_controls();

		$this->end_controls_section();
	}

	/**
	 * Register widget style controls
	 */
	protected function register_style_controls() {

		// Button style controls
		$this->start_controls_section(
			'section_button_style',
			[
				'label' => esc_html__( 'Button style', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_button_style_controls();

		$this->end_controls_section();

		// Icon style controls
		$this->start_controls_section(
			'section_icon_style',
			[
				'label'      => esc_html__( 'Icon style', 'zyre-elementor-addons' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'button_icon[value]',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->register_button_icon_style_controls();

		$this->end_controls_section();
	}

	/**
	 * Rendering HTML
	 */
	protected function render() {
		$this->render_button();
	}
}
