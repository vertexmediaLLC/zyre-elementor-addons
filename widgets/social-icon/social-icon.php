<?php

namespace VertexMediaLLC\ZyreElementorAddons\Widget;

use Elementor\Controls_Manager;
use VertexMediaLLC\ZyreElementorAddons\Traits\Social_Trait;

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

		// Extra Icon normal color is set on the icon itself. Inherit General hover when its own hover color is empty.
		$general_hover_color = $this->get_controls( 'all_social_color_hover' );

		if ( ! empty( $general_hover_color['selectors'] ) && is_array( $general_hover_color['selectors'] ) ) {
			$general_hover_color['selectors']['{{WRAPPER}} .zyre-social-icon-wrapper > .zyre-social-icon:hover .zyre-social-extra-icon'] = 'color: inherit;';

			$this->update_control(
				'all_social_color_hover',
				[
					'selectors' => $general_hover_color['selectors'],
				]
			);
		}

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

		// Extra Icon. Social Icons only — Team Member uses the Icon section above.
		$this->start_controls_section(
			'section_extra_icon_style',
			[
				'label'     => esc_html__( 'Extra Icon', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'social_extra_icon[value]!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'social_extra_icon_size',
			[
				'label'     => esc_html__( 'Icon Size', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 10,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-social-extra-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_social_extra_icon_colors' );

		$this->start_controls_tab(
			'tab_social_extra_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'social_extra_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-social-icon .zyre-social-extra-icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-social-icon .zyre-social-extra-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_social_extra_icon_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'social_extra_icon_color_hover',
			[
				'label'     => esc_html__( 'Icon Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-social-icon-wrapper > .zyre-social-icon:hover .zyre-social-extra-icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-social-icon-wrapper > .zyre-social-icon:hover .zyre-social-extra-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'social_extra_icon_rotate',
			[
				'label'      => esc_html__( 'Rotate', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'deg' ],
				'range'      => [
					'deg' => [
						'min' => -360,
						'max' => 360,
					],
				],
				'default'    => [
					'unit' => 'deg',
				],
				'separator'  => 'before',
				'selectors'  => [
					'{{WRAPPER}} .zyre-social-extra-icon' => 'transform: rotate({{SIZE}}deg);',
				],
			]
		);

		$this->add_responsive_control(
			'social_extra_icon_margin',
			[
				'label'      => esc_html__( 'Margin', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'range'      => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
					'%'  => [
						'min' => -100,
						'max' => 100,
					],
					'em' => [
						'min' => -10,
						'max' => 10,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-social-extra-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

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
