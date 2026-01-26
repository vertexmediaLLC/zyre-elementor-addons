<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Css_Filter;

defined( 'ABSPATH' ) || die();

class Lottie_Animation extends Base {

	public function get_title() {
		return esc_html__( 'Lottie Animation', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Lottie-Animations';
	}

	public function get_keywords() {
		return [ 'lottie', 'animation', 'animations', 'svg animation', 'json animation' ];
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	/**
	 * Register widget content controls
	 */
	protected function register_content_controls() {
		$this->start_controls_section(
			'section_lottie_animation_content',
			[
				'label' => esc_html__( 'Lottie Animation', 'zyre-elementor-addons' ),
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$this->add_control(
			'source',
			[
				'label'   => esc_html__( 'File Source', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'url'  => esc_html__( 'External URL', 'zyre-elementor-addons' ),
					'file' => esc_html__( 'Media File', 'zyre-elementor-addons' ),
				],
				'default' => 'url',
			]
		);

		$this->add_control(
			'json_url',
			[
				'label'       => esc_html__( 'Animation JSON URL', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'condition'   => [
					'source' => 'url',
				],
				'ai'          => false,
				'default'     => esc_url( 'https://lottie.host/2dc3d071-7d39-44a0-99b5-44adc2d1e236/hXMgJ0VuGf.json' ),
			]
		);

		$this->add_control(
			'json_file',
			[
				'label'              => esc_html__( 'Upload JSON File', 'zyre-elementor-addons' ),
				'type'               => Controls_Manager::MEDIA,
				'media_type'         => 'application/json',
				'frontend_available' => true,
				'condition'          => [
					'source' => 'file',
				],
				'ai'                 => false,
			]
		);

		$this->add_responsive_control(
			'animation_align',
			[
				'label'     => esc_html__( 'Alignment', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-center',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'   => 'center',
				'toggle'    => false,
				'selectors' => [
					'{{WRAPPER}} .zyre-lottie-animation-wrapper' => ' justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'link_to',
			[
				'label'              => esc_html__( 'Link', 'zyre-elementor-addons' ),
				'type'               => Controls_Manager::SELECT,
				'render_type'        => 'none',
				'default'            => 'none',
				'options'            => [
					'none'   => esc_html__( 'None', 'zyre-elementor-addons' ),
					'custom' => esc_html__( 'Custom URL', 'zyre-elementor-addons' ),
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'custom_link',
			[
				'label'              => esc_html__( 'Link', 'zyre-elementor-addons' ),
				'type'               => Controls_Manager::URL,
				'render_type'        => 'template',
				'placeholder'        => esc_html__( 'Enter your URL', 'zyre-elementor-addons' ),
				'condition'          => [
					'link_to' => 'custom',
				],
				'show_label'         => false,
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'        => esc_html__( 'Autoplay', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'loop',
			[
				'label'        => esc_html__( 'Loop', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'reverse',
			[
				'label'        => esc_html__( 'Reverse', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'condition'    => [
					'trigger!' => 'scroll',
				],
			]
		);

		$this->add_control(
			'speed',
			[
				'label'   => esc_html__( 'Play Speed (x)', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1,
				'min'     => 0.1,
				'max'     => 10,
				'step'    => 0.1,
			]
		);

		$this->add_control(
			'trigger',
			[
				'label'              => esc_html__( 'Trigger', 'zyre-elementor-addons' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'none',
				'options'            => [
					'none'     => esc_html__( 'None', 'zyre-elementor-addons' ),
					'viewport' => esc_html__( 'Viewport', 'zyre-elementor-addons' ),
					'hover'    => esc_html__( 'Hover', 'zyre-elementor-addons' ),
					'scroll'   => esc_html__( 'Scroll', 'zyre-elementor-addons' ),
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'animate_view',
			[
				'label'     => esc_html__( 'Viewport', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'sizes' => [
						'start' => 0,
						'end'   => 100,
					],
					'unit'  => '%',
				],
				'labels'    => [
					esc_html__( 'Bottom', 'zyre-elementor-addons' ),
					esc_html__( 'Top', 'zyre-elementor-addons' ),
				],
				'scales'    => 1,
				'handles'   => 'range',
				'condition' => [
					'trigger' => [ 'scroll', 'viewport' ],
				],
			]
		);

		$this->add_responsive_control(
			'rotate',
			[
				'label'       => esc_html__( 'Rotate (degrees)', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::SLIDER,
				'description' => esc_html__( 'Set rotation value in degrees', 'zyre-elementor-addons' ),
				'range'       => [
					'px' => [
						'min' => -180,
						'max' => 180,
					],
				],
				'default'     => [
					'size' => 0,
				],
				'selectors'   => [
					'{{WRAPPER}} .zyre-lottie-animation' => 'transform: rotate({{SIZE}}deg)',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register styles related controls
	 */
	protected function register_style_controls() {
		$this->start_controls_section(
			'lottie_styles',
			[
				'label' => esc_html__( 'Animation', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'width',
			[
				'label'          => esc_html__( 'Width', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'default'        => [
					'unit' => 'px',
					'size' => 300,
				],
				'tablet_default' => [
					'unit' => 'px',
					'size' => 300,
				],
				'mobile_default' => [
					'unit' => 'px',
					'size' => 300,
				],
				'range'          => [
					'%'  => [
						'min' => 2,
					],
					'px' => [
						'min' => 20,
						'max' => 2000,
					],
					'em' => [
						'min' => 2,
						'max' => 100,
					],
					'rem' => [
						'min' => 2,
						'max' => 100,
					],
					'vw' => [
						'min' => 1,
					],
				],
				'selectors'      => [
					'{{WRAPPER}} .zyre-lottie-animation' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'space',
			[
				'label'          => esc_html__( 'Max Width', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'default'        => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'range'          => [
					'%'  => [
						'min' => 2,
					],
					'px' => [
						'min' => 20,
						'max' => 2000,
					],
					'em' => [
						'min' => 2,
						'max' => 100,
					],
					'rem' => [
						'min' => 2,
						'max' => 100,
					],
					'vw' => [
						'min' => 1,
					],
				],
				'selectors'      => [
					'{{WRAPPER}} .zyre-lottie-animation' => 'max-width: {{SIZE}}{{UNIT}};',
				],
				'separator'      => 'after',
			]
		);

		$this->start_controls_tabs( 'tabs_lottie' );

		$this->start_controls_tab(
			'tab_lottie_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'opacity',
			[
				'label'     => esc_html__( 'Opacity', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-lottie-animation' => 'opacity: {{SIZE}}',
				],
			]
		);

		$this->add_control(
			'transition',
			[
				'label'     => esc_html__( 'Transition Duration', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0.3,
				'min'       => 0,
				'max'       => 5,
				'step'      => 0.1,
				'selectors' => [
					'{{WRAPPER}} .zyre-lottie-animation' => 'transition: all {{VALUE}}s ease-in-out;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'css_filters',
				'selector' => '{{WRAPPER}} .zyre-lottie-animation',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_lottie_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'hover_opacity',
			[
				'label'     => esc_html__( 'Opacity', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}}  .zyre-lottie-animation:hover' => 'opacity: {{SIZE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'hover_css_filters',
				'selector' => '{{WRAPPER}}  .zyre-lottie-animation:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	public function lottie_attributes( $settings ) {
		$attributes = [
			'loop' => $settings['loop'],
			'autoplay' => $settings['autoplay'],
			'speed' => $settings['speed'],
			'trigger' => $settings['trigger'],
			'reverse' => $settings['reverse'],
			'scroll_start'  => isset( $settings['animate_view']['sizes']['start'] ) ? $settings['animate_view']['sizes']['start'] : '0',
			'scroll_end'    => isset( $settings['animate_view']['sizes']['end'] ) ? $settings['animate_view']['sizes']['end'] : '100',
		];

		return wp_json_encode( $attributes );
	}

	/**
	 * Register render display controls
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$lottie_json = '';
		if ( 'url' === $settings['source'] && '' !== $settings['json_url'] ) {
			$lottie_json = $settings['json_url'];
		} elseif ( 'file' === $settings['source'] && '' !== $settings['json_file']['url'] ) {
			$lottie_json = $settings['json_file']['url'];
		}

		$lottie_link = '';
		if ( 'custom' === $settings['link_to'] && '' !== $settings['custom_link']['url'] ) {
			$lottie_link = $settings['custom_link']['url'];
			$lottie_animation = '<a href="' . esc_url( $lottie_link ) . '" class="zyre-lottie-animation zy-inline-block" data-settings="' . esc_attr( $this->lottie_attributes( $settings ) ) . '" data-json-url="' . esc_url( $lottie_json ) . '"></a>';
		} else {
			$lottie_animation = '<div class="zyre-lottie-animation" data-settings="' . esc_attr( $this->lottie_attributes( $settings ) ) . '" data-json-url="' . esc_url( $lottie_json ) . '"></div>';
		}

		echo '<div class="zyre-lottie-animation-wrapper zy-flex zy-align-center">' . wp_kses_post( $lottie_animation ) . '</div>';
	}
}
