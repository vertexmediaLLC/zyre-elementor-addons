<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use ZyreAddons\Elementor\Traits\Social_Trait;

defined( 'ABSPATH' ) || die();

class Social_Icon extends Base {

	use Social_Trait;

	public function get_title() {
		return esc_html__( 'Social Icons', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Social-media';
	}

	public function get_keywords() {
		return [ 'social', 'icon', 'social icon', 'link', 'links', 'social links', 'icons', 'media', 'facebook', 'fb', 'twitter', 'linkedin' ];
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	protected function register_content_controls() {
		$this->start_controls_section(
			'section_social_content',
			[
				'label' => esc_html__( 'Social Icons', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$this->register_social_content_controls( [ 'default_items' => 5 ] );

		$this->register_social_settings_controls();

		$this->add_control(
			'social_icon_css_class',
			[
				'label'       => esc_html__( 'Class', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Class Name', 'zyre-elementor-addons' ),
				'prefix_class' => '',
				'separator'   => 'before',
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_controls() {
		// General
		$this->start_controls_section(
			'section_general_style',
			[
				'label' => esc_html__( 'General', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_social_general_style_controls();

		$this->end_controls_section();

		// Icon
		$this->start_controls_section(
			'section_icon_style',
			[
				'label' => esc_html__( 'Icon', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_social_icon_style_controls();

		$this->end_controls_section();

		// Social Name
		$this->start_controls_section(
			'section_social_name_style',
			[
				'label' => esc_html__( 'Social Name', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_social_name_style_controls();

		$this->end_controls_section();
	}

	protected function render() {
		$this->render_social_items();
	}
}
