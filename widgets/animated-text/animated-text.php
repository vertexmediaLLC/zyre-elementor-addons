<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Animated_Text extends Base {

	public function get_title() {
		return esc_html__( 'Animated Text', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Animated-text';
	}

	public function get_keywords() {
		return [ 'animated text', 'text animation', 'animated headings', 'headings animate', 'fancy text', 'animate', 'fancy', 'text', 'headings', 'typing', 'headline' ];
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	protected function is_dynamic_content(): bool {
		return false;
	}

	public function is_reload_preview_required() {
		return true;
	}

	public function has_widget_inner_wrapper(): bool {
		return ! \Elementor\Plugin::$instance->experiments->is_feature_active( 'e_optimized_markup' );
	}

	protected function register_content_controls() {
		$this->__general_content_controls();
		$this->__switch_settings_controls();
		$this->__single_settings_controls();
	}

	protected function __general_content_controls() {
		$this->start_controls_section(
			'section_general_content',
			[
				'label' => esc_html__( 'General', 'zyre-elementor-addons' ),
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$this->add_control(
			'type',
			[
				'label'        => esc_html__( 'Text Type', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SELECT,
				'prefix_class' => 'zyre-animated-text-type_',
				'options'      => [
					'single' => esc_html__( 'Single', 'zyre-elementor-addons' ),
					'switch' => esc_html__( 'Switched', 'zyre-elementor-addons' ),
				],
				'default'      => 'switch',
				'render_type'  => 'template',
			]
		);

		$this->add_control(
			'prefix_text',
			[
				'label'       => esc_html__( 'Before Text', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'anim_text',
			[
				'label'       => esc_html__( 'Animated Text', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'separator'   => 'before',
				'default'     => esc_html__( 'Awesome', 'zyre-elementor-addons' ),
				'label_block' => true,
				'condition'   => [
					'type' => 'single',
				],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'switch_text',
			[
				'label'       => esc_html__( 'Fancy String', 'zyre-elementor-addons' ),
				'dynamic'     => [ 'active' => true ],
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'switch_text_color',
			[
				'label'          => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::COLOR,
				'style_transfer' => true,
				'selectors'      => [
					'{{WRAPPER}} .zyre-animated-text {{CURRENT_ITEM}}' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'switch_text_items',
			[
				'label'       => esc_html__( 'Animated Text', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::REPEATER,
				'default'     => [
					[
						'switch_text' => esc_html__( 'Awesome', 'zyre-elementor-addons' ),
					],
					[
						'switch_text' => esc_html__( 'Brilliant', 'zyre-elementor-addons' ),
					],
					[
						'switch_text' => esc_html__( 'Graphics', 'zyre-elementor-addons' ),
					],
				],
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ switch_text }}}',
				'condition'   => [
					'type' => 'switch',
				],
			]
		);

		$this->add_control(
			'suffix_text',
			[
				'label'       => esc_html__( 'After Text', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'Design', 'zyre-elementor-addons' ),
				'label_block' => true,
			]
		);

		$this->add_responsive_control(
			'display',
			[
				'label'          => esc_html__( 'Display', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::SELECT,
				'options'        => [
					'inline' => esc_html__( 'Inline', 'zyre-elementor-addons' ),
					'block'  => esc_html__( 'Block', 'zyre-elementor-addons' ),
				],
				'default'        => 'inline',
				'tablet_default' => 'inline',
				'mobile_default' => 'inline',
				'selectors'      => [
					'{{WRAPPER}} .zyre-animated-text-prefix, {{WRAPPER}} .zyre-animated-text-suffix' => 'display: {{VALUE}}',
				],
				'label_block'    => true,
			]
		);

		$this->add_responsive_control(
			'text_align',
			[
				'label'     => esc_html__( 'Alignment', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'   => 'center',
				'toggle'    => false,
				'selectors' => [
					'{{WRAPPER}} .zyre-animated-text-heading' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_tag',
			[
				'label'       => esc_html__( 'HTML Tag', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'h2',
				'options'     => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				],
				'label_block' => true,
			]
		);

		$this->end_controls_section();
	}

	protected function __switch_settings_controls() {
		$this->start_controls_section(
			'section_switch_animation_settings',
			[
				'label'     => esc_html__( 'Switched Settings', 'zyre-elementor-addons' ),
				'condition' => [
					'type' => 'switch',
				],
			]
		);

		$this->add_control(
			'trigger',
			[
				'label'   => esc_html__( 'Trigger On', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'page_load' => esc_html__( 'Page Load', 'zyre-elementor-addons' ),
					'viewport'  => esc_html__( 'Visible on Viewport', 'zyre-elementor-addons' ),
				],
				'default' => 'page_load',
			]
		);

		$this->add_control(
			'switch_effect_type',
			[
				'label'       => esc_html__( 'Effect', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'typing'  => esc_html__( 'Typing', 'zyre-elementor-addons' ),
					'clip'    => esc_html__( 'Clip', 'zyre-elementor-addons' ),
					'slide'   => esc_html__( 'Slide', 'zyre-elementor-addons' ),
					'zoomout' => esc_html__( 'Zoom Out', 'zyre-elementor-addons' ),
					'rotate'  => esc_html__( 'Rotate', 'zyre-elementor-addons' ),
					'custom'  => esc_html__( 'Custom', 'zyre-elementor-addons' ),
				],
				'default'     => 'typing',
				'render_type' => 'template',
				'label_block' => true,
			]
		);

		$this->add_control(
			'custom_animation',
			[
				'label'       => esc_html__( 'Animations', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::ANIMATION,
				'render_type' => 'template',
				'default'     => 'fadeIn',
				'condition'   => [
					'switch_effect_type' => 'custom',
				],
			]
		);

		$this->add_control(
			'type_speed',
			[
				'label'       => esc_html__( 'Type Speed', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 150,
				'description' => esc_html__( 'Set typing effect speed in milliseconds.', 'zyre-elementor-addons' ),
				'condition'   => [
					'switch_effect_type' => 'typing',
				],
			]
		);

		$this->add_control(
			'zoom_speed',
			[
				'label'       => esc_html__( 'Animation Speed', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::NUMBER,
				'render_type' => 'template',
				'description' => esc_html__( 'Set animation speed in milliseconds. Default value is 1000', 'zyre-elementor-addons' ),
				'condition'   => [
					'switch_effect_type!' => [ 'typing', 'slide' ],
				],
				'selectors'   => [
					'{{WRAPPER}} .zyre-animated-text-wrapper:not(.zyre-animated-text__typing):not(.zyre-animated-text__slide) .zyre-animated-text-item' => 'animation-duration: {{VALUE}}ms',
				],
			]
		);

		$this->add_control(
			'zoom_delay',
			[
				'label'       => esc_html__( 'Animation Delay', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Set animation delay in milliseconds. Default value is 2500', 'zyre-elementor-addons' ),
				'condition'   => [
					'switch_effect_type!' => [ 'typing', 'slide' ],
				],
			]
		);

		$this->add_control(
			'loop_count',
			[
				'label'     => esc_html__( 'Loop Count', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'condition' => [
					'switch_effect_type!' => [ 'typing', 'slide' ],
				],
			]
		);

		$this->add_control(
			'back_speed',
			[
				'label'       => esc_html__( 'Back Speed', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 60,
				'description' => esc_html__( 'Set a speed for backspace effect in milliseconds.', 'zyre-elementor-addons' ),
				'condition'   => [
					'switch_effect_type' => 'typing',
				],
			]
		);

		$this->add_control(
			'start_delay',
			[
				'label'       => esc_html__( 'Start Delay', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 60,
				'description' => esc_html__( 'If you set it on 5000 milliseconds, the first word/string will appear after 5 seconds.', 'zyre-elementor-addons' ),
				'condition'   => [
					'switch_effect_type' => 'typing',
				],
			]
		);

		$this->add_control(
			'back_delay',
			[
				'label'       => esc_html__( 'Back Delay', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 1000,
				'description' => esc_html__( 'If you set it on 5000 milliseconds, the word/string will remain visible for 5 seconds before backspace effect.', 'zyre-elementor-addons' ),
				'condition'   => [
					'switch_effect_type' => 'typing',
				],
			]
		);

		$this->add_control(
			'type_loop',
			[
				'label'     => esc_html__( 'Loop', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'switch_effect_type' => 'typing',
				],
			]
		);

		$this->add_control(
			'show_cursor',
			[
				'label'     => esc_html__( 'Show Cursor', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'switch_effect_type' => 'typing',
				],
			]
		);

		$this->add_control(
			'slide_up_speed',
			[
				'label'       => esc_html__( 'Animation Speed', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 200,
				'description' => esc_html__( 'Set a duration value in milliseconds for slide up effect.', 'zyre-elementor-addons' ),
				'condition'   => [
					'switch_effect_type' => 'slide',
				],
			]
		);

		$this->add_control(
			'slide_up_pause_time',
			[
				'label'       => esc_html__( 'Pause Time', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 3000,
				'description' => esc_html__( 'How long should the word/string stay visible? Set a value in milliseconds.', 'zyre-elementor-addons' ),
				'condition'   => [
					'switch_effect_type' => 'slide',
				],
			]
		);

		$this->add_control(
			'slide_up_shown_items',
			[
				'label'       => esc_html__( 'Show Items', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 1,
				'description' => esc_html__( 'How many items should be visible at a time?', 'zyre-elementor-addons' ),
				'condition'   => [
					'switch_effect_type' => 'slide',
				],
			]
		);

		$this->add_control(
			'slide_up_hover_pause',
			[
				'label'        => esc_html__( 'Pause on Hover', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'zyre-animated-text__paused-',
				'render_type'  => 'template',
				'condition'    => [
					'switch_effect_type' => 'slide',
				],
			]
		);

		$this->add_responsive_control(
			'slide_align',
			[
				'label'     => esc_html__( 'Slide Text Align', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'   => 'center',
				'toggle'    => false,
				'selectors' => [
					'{{WRAPPER}} .zyre-animated-text-item' => 'text-align: {{VALUE}}',
				],
				'condition' => [
					'switch_effect_type' => 'slide',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __single_settings_controls() {
		$this->start_controls_section(
			'section_single_settings',
			[
				'label'     => esc_html__( 'Single Settings', 'zyre-elementor-addons' ),
				'condition' => [
					'type' => 'single',
				],
			]
		);

		$this->add_control(
			'single_eff_type',
			[
				'label'       => esc_html__( 'Effect', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'shadow'    => esc_html__( 'Shadow Bounce', 'zyre-elementor-addons' ),
					'glow'      => esc_html__( 'Glow', 'zyre-elementor-addons' ),
					'fill'      => esc_html__( 'Fill', 'zyre-elementor-addons' ),
					'tilt'      => esc_html__( 'Tilt', 'zyre-elementor-addons' ),
					'flip'      => esc_html__( 'Flip', 'zyre-elementor-addons' ),
					'wave'      => esc_html__( 'Wave', 'zyre-elementor-addons' ),
					'pop'       => esc_html__( 'Pop', 'zyre-elementor-addons' ),
					'reveal'    => esc_html__( 'Reveal', 'zyre-elementor-addons' ),
					'lines'     => esc_html__( 'Moving Lines', 'zyre-elementor-addons' ),
					'shape'     => esc_html__( 'Draw Shape', 'zyre-elementor-addons' ),
				],
				'default'     => 'glow',
				'label_block' => true,
			]
		);

		$this->add_control(
			'show_fill_line',
			[
				'label'          => esc_html__( 'Show Fill Line', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::SWITCHER,
				'return_value'   => 'on',
				'condition'      => [
					'type'            => 'single',
					'single_eff_type' => 'fill',
				],
			]
		);

		$this->add_control(
			'shape',
			[
				'label'       => esc_html__( 'Shape', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'circle'    => esc_html__( 'Circle', 'zyre-elementor-addons' ),
					'wavy'      => esc_html__( 'Wavy Zigzag', 'zyre-elementor-addons' ),
					'underline' => esc_html__( 'Underline', 'zyre-elementor-addons' ),
					'double'    => esc_html__( 'Double Underline', 'zyre-elementor-addons' ),
					'zigzag'    => esc_html__( 'Underline Zigzag', 'zyre-elementor-addons' ),
					'strike'    => esc_html__( 'Strikethrough', 'zyre-elementor-addons' ),
					'cross'     => esc_html__( 'Cross X', 'zyre-elementor-addons' ),
				],
				'default'     => 'circle',
				'label_block' => true,
				'condition'   => [
					'type'            => 'single',
					'single_eff_type' => 'shape',
				],
			]
		);

		$this->add_control(
			'reveal_notice',
			[
				'raw'             => esc_html__( 'Set a background color in the Style tab to see the effect.', 'zyre-elementor-addons' ),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
				'condition'       => [
					'type'            => 'single',
					'single_eff_type' => 'reveal',
				],
			]
		);

		$this->add_control(
			'lines_notice',
			[
				'raw'             => esc_html__( 'This effect requires colors set in the Style tab.', 'zyre-elementor-addons' ),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
				'condition'       => [
					'type'            => 'single',
					'single_eff_type' => 'lines',
				],
			]
		);

		$this->add_responsive_control(
			'anim_text_width',
			[
				'label'      => esc_html__( 'Width', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%', 'custom' ],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 1200,
					],
					'em' => [
						'min' => 1,
						'max' => 30,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-animated-text' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'type'            => 'single',
					'single_eff_type' => 'lines',
				],
			]
		);

		$this->add_responsive_control(
			'lines_svg_height',
			[
				'label'      => esc_html__( 'Height', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'custom' ],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 200,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-animated-text__lines .zyre-animated-text' => 'height: {{SIZE}}{{UNIT}}',
				],
				'condition'  => [
					'type'            => 'single',
					'single_eff_type' => [ 'lines' ],
				],
			]
		);

		$this->add_control(
			'hover_pause',
			[
				'label'        => esc_html__( 'Pause on Hover', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'zyre-animated-text__paused-',
				'render_type'  => 'template',
				'condition'    => [
					'single_eff_type!' => [ 'shape' ],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_controls() {
		$this->__animated_text_style_controls();
		$this->__prefix_style_controls();
		$this->__suffix_style_controls();
		$this->__shape_style_controls();
		$this->__cursor_style_controls();
		$this->__line_style_controls();
	}

	protected function __animated_text_style_controls() {
		$this->start_controls_section(
			'animated_text_style_section',
			[
				'label' => esc_html__( 'Animated Text', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'anim_text_typo',
				'label'    => esc_html__( 'Headline Typography', 'zyre-elementor-addons' ),
				'selector' => '{{WRAPPER}} .zyre-animated-text-heading, {{WRAPPER}} .zyre-animated-text svg g > text',
			]
		);

		$this->add_control(
			'anim_text_color',
			[
				'label'      => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .zyre-animated-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .text'               => 'fill: {{VALUE}};',
				],
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'  => 'type',
							'value' => 'switch',
						],
						[
							'terms' => [
								[
									'name'  => 'type',
									'value' => 'single',
								],
								[
									'name'     => 'single_eff_type',
									'operator' => '!==',
									'value'    => 'fill',
								],
								[
									'name'     => 'single_eff_type',
									'operator' => '!==',
									'value'    => 'reveal',
								],
							],
						],
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'fill_background',
				'types'     => [ 'classic', 'gradient' ],
				'fields_options' => [
					'background' => [
						'default' => 'gradient',
					],
					'color' => [
						'default' => '#8A32EB',
					],
					'color_stop' => [
						'default' => [
							'unit' => '%',
							'size' => 50,
						],
					],
					'color_b' => [
						'default' => '#FFA0FF',
					],
					'color_b_stop' => [
						'default' => [
							'unit' => '%',
							'size' => 50,
						],
					],
					'gradient_angle' => [
						'default' => [
							'unit' => 'deg',
							'size' => 135,
						],
					],
				],
				'condition' => [
					'type'        => 'single',
					'single_eff_type' => 'fill',
				],
				'selector'  => '{{WRAPPER}} .zyre-animated-text',
			]
		);

		$this->add_control(
			'bg_size_w',
			[
				'label'      => esc_html__( 'Background Width (%)', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'default'    => [
					'unit' => '%',
				],
				'range'      => [
					'%' => [
						'min' => 10,
						'max' => 1000,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-animated-text' => '--background-size-w: {{SIZE}}%',
				],
				'condition'  => [
					'type'                       => 'single',
					'single_eff_type'            => 'fill',
					'fill_background_background' => 'gradient',
				],
			]
		);

		$this->add_control(
			'bg_size_h',
			[
				'label'      => esc_html__( 'Background Height (%)', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'default'    => [
					'unit' => '%',
				],
				'range'      => [
					'%' => [
						'min' => 10,
						'max' => 1000,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-animated-text' => '--background-size-h: {{SIZE}}%',
				],
				'condition'  => [
					'type'                       => 'single',
					'single_eff_type'            => 'fill',
					'fill_background_background' => 'gradient',
				],
				'separator'  => 'after',
			]
		);

		$this->add_control(
			'color_a',
			[
				'label'     => esc_html__( 'First Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#197dff',
				'selectors' => [
					'{{WRAPPER}} .zyre-animated-text' => '--color-a: {{VALUE}}',
				],
				'condition' => [
					'type'        => 'single',
					'single_eff_type' => [ 'shadow', 'glow', 'lines' ],
				],
			]
		);

		$this->add_control(
			'color_b',
			[
				'label'     => esc_html__( 'Second Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8A32EB',
				'selectors' => [
					'{{WRAPPER}} .zyre-animated-text' => '--color-b: {{VALUE}}',
				],
				'condition' => [
					'type'        => 'single',
					'single_eff_type' => [ 'shadow', 'lines' ],
				],
			]
		);

		$this->add_control(
			'color_c',
			[
				'label'     => esc_html__( 'Third Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFA0FF',
				'selectors' => [
					'{{WRAPPER}} .zyre-animated-text' => '--color-c: {{VALUE}}',
				],
				'condition' => [
					'type'        => 'single',
					'single_eff_type' => [ 'shadow', 'lines' ],
				],
			]
		);

		$this->add_control(
			'color_d',
			[
				'label'     => esc_html__( 'Fourth Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FA4119',
				'selectors' => [
					'{{WRAPPER}} .zyre-animated-text' => '--color-d: {{VALUE}}',
				],
				'condition' => [
					'type'        => 'single',
					'single_eff_type' => [ 'shadow', 'lines' ],
				],
			]
		);

		$this->add_control(
			'color_e',
			[
				'label'     => esc_html__( 'Fifth Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => [
					'{{WRAPPER}} .zyre-animated-text' => '--color-e: {{VALUE}}',
				],
				'condition' => [
					'type'        => 'single',
					'single_eff_type' => [ 'lines' ],
				],
			]
		);

		$this->add_control(
			'text_bg_color',
			[
				'label'      => esc_html__( 'Background Color', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .zyre-animated-text' => 'background-color: {{VALUE}}',
				],
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'  => 'type',
							'value' => 'switch',
						],
						[
							'terms' => [
								[
									'name'  => 'type',
									'value' => 'single',
								],
								[
									'name'     => 'single_eff_type',
									'operator' => '!==',
									'value'    => 'fill',
								],
							],
						],
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'       => 'text_shadow',
				'selector'   => '{{WRAPPER}} .zyre-animated-text',
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'  => 'type',
							'value' => 'switch',
						],
						[
							'terms' => [
								[
									'name'  => 'type',
									'value' => 'single',
								],
								[
									'name'     => 'single_eff_type',
									'operator' => '!==',
									'value'    => 'shadow',
								],
								[
									'name'     => 'single_eff_type',
									'operator' => '!==',
									'value'    => 'lines',
								],
							],
						],
					],
				],
			]
		);

		$this->add_control(
			'stroke_width',
			[
				'label'     => esc_html__( 'Stroke Width', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .zyre-animated-text' => '-webkit-text-stroke-width: {{SIZE}}px',
					'{{WRAPPER}} .text'               => 'stroke-width: {{SIZE}}',
				],
			]
		);

		$this->add_control(
			'stroke_color',
			[
				'label'      => esc_html__( 'Stroke Color', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::COLOR,
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'  => 'type',
							'value' => 'switch',
						],
						[
							'terms' => [
								[
									'name'  => 'type',
									'value' => 'single',
								],
								[
									'name'     => 'single_eff_type',
									'operator' => '!==',
									'value'    => 'lines',
								],
							],
						],
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-animated-text' => '-webkit-text-stroke-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'animation_speed',
			[
				'label'     => esc_html__( 'Animation Speed (sec)', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-animated-text, {{WRAPPER}} .zyre-animated-text::after,
										{{WRAPPER}} .zyre-animated-text__letter, {{WRAPPER}} .text' => 'animation-duration: {{SIZE}}s',
					'{{WRAPPER}} .zyre-animated-text__shape svg path'                   => '--zy-shape-anim-duration: {{SIZE}}s',
					'{{WRAPPER}}'                                                       => '--zy-shape-anim-duration: {{SIZE}}',
				],
				'condition' => [
					'type' => 'single',
				],
			]
		);

		$this->add_control(
			'animation_delay',
			[
				'label'     => esc_html__( 'Animation Delay (sec)', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					's' => [
						'min'  => 0,
						'max'  => 20,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => '--zy-shape-anim-delay: {{SIZE}}',
				],
				'condition' => [
					'type'            => 'single',
					'single_eff_type' => 'shape',
				],
			]
		);

		$this->add_responsive_control(
			'text_margin',
			[
				'label'      => esc_html__( 'Margin', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .zyre-animated-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __prefix_style_controls() {
		$this->start_controls_section(
			'section_prefix_style',
			[
				'label' => esc_html__( 'Before Text', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'prefix_text!' => '',
				],
			]
		);

		$this->text_style_controls( 'prefix', '{{WRAPPER}} .zyre-animated-text-prefix' );

		$this->float_style_controls( 'prefix', '{{WRAPPER}} .zyre-animated-text-prefix' );

		$this->end_controls_section();
	}

	protected function __suffix_style_controls() {
		$this->start_controls_section(
			'section_suffix_style',
			[
				'label' => esc_html__( 'After Text', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'suffix_text!' => '',
				],
			]
		);

		$this->text_style_controls( 'suffix', '{{WRAPPER}} .zyre-animated-text-suffix' );

		$this->float_style_controls( 'suffix', '{{WRAPPER}} .zyre-animated-text-suffix' );

		$this->end_controls_section();
	}

	protected function __shape_style_controls() {
		$this->start_controls_section(
			'section_shape_style',
			[
				'label'     => esc_html__( 'Shape', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'type'            => 'single',
					'single_eff_type' => 'shape',
				],
			]
		);

		$this->add_control(
			'shape_color',
			[
				'label'     => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-animated-text__shape path' => 'stroke: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'shape_stroke_width',
			[
				'label'      => esc_html__( 'Width', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'range'      => [
					'px'  => [
						'min' => 1,
						'max' => 20,
					],
					'em'  => [
						'max' => 2,
					],
					'rem' => [
						'max' => 2,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-animated-text__shape path' => 'stroke-width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'rounded_edges',
			[
				'label'     => esc_html__( 'Rounded Edges', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} .zyre-animated-text__shape path' => 'stroke-linecap: round; stroke-linejoin: round',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __cursor_style_controls() {
		$this->start_controls_section(
			'section_cursor_style',
			[
				'label'     => esc_html__( 'Cursor', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'type'               => 'switch',
					'switch_effect_type' => 'typing',
				],
			]
		);

		$this->add_control(
			'cursor_color',
			[
				'label'     => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .typed-cursor' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cursor_width',
			[
				'label'     => esc_html__( 'Width', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'     => [ 'px', '%', 'em', 'rem' ],
				'default'   => [
					'unit' => 'px',
				],
				'range'     => [
					'px' => [
						'min' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .typed-cursor' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __line_style_controls() {
		$this->start_controls_section(
			'section_line_style',
			[
				'label'     => esc_html__( 'Fill Line', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'type'            => 'single',
					'single_eff_type' => 'fill',
					'show_fill_line'  => 'on',
				],
			]
		);

		$this->add_control(
			'line_color',
			[
				'label'     => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-animated-text' => '--background-line-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'line_width',
			[
				'label'      => esc_html__( 'Width', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'default'    => [
					'unit' => 'px',
				],
				'range'      => [
					'px' => [
						'min'  => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-animated-text' => '--background-line-w: calc({{SIZE}}{{UNIT}} / 2);',
				],
			]
		);

		$this->add_control(
			'line_angle',
			[
				'label'      => esc_html__( 'Angle', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'deg' ],
				'default'    => [
					'unit' => 'deg',
					'size' => 135,
				],
				'range'      => [
					'deg' => [
						'min' => -360,
						'max' => 360,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-animated-text' => '--background-line-angle: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Text Style Controls.
	 *
	 * @param string $prefix The prefix of the controls.
	 * @param string $selector The HTML selectors.
	 */
	private function text_style_controls( string $prefix, string $selector ) {
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => $prefix . '_typo',
				'selector' => $selector,
			]
		);

		$this->add_control(
			$prefix . '_color',
			[
				'label'     => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					$selector => 'color: {{VALUE}};',
				],
			]
		);
	}

	/**
	 * Float Style Controls.
	 *
	 * @param string $prefix The prefix of the controls.
	 * @param string $selector The HTML selectors.
	 */
	private function float_style_controls( string $prefix, string $selector ) {
		$this->add_control(
			$prefix . '_float',
			[
				'label'     => esc_html__( 'Enable Floating', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'return_value' => 'on',
				'selectors' => [
					$selector => 'position: absolute;z-index: 1;',
				],
			]
		);

		$this->add_responsive_control(
			$prefix . '_align_x',
			[
				'label'     => esc_html__( 'Horizontal Align', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => is_rtl() ? 'right' : 'left',
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-arrow-left',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-arrow-right',
					],
				],
				'toggle'    => false,
				'selectors_dictionary' => [
					'left' => 'left: 0;',
					'right' => 'right: 0;',
				],
				'selectors' => [
					$selector => '{{VALUE}}',
				],
				'condition' => [
					$prefix . '_float' => 'on',
				],
			]
		);

		$this->add_responsive_control(
			$prefix . '_align_y',
			[
				'label'     => esc_html__( 'Vertical Align', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'top',
				'options'   => [
					'top'   => [
						'title' => esc_html__( 'Top', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-arrow-up',
					],
					'bottom'  => [
						'title' => esc_html__( 'Bottom', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-arrow-down',
					],
				],
				'toggle'    => false,
				'selectors_dictionary' => [
					'top' => 'top: 0;',
					'bottom' => 'bottom: 0;',
				],
				'selectors' => [
					$selector => '{{VALUE}}',
				],
				'condition' => [
					$prefix . '_float' => 'on',
				],
			]
		);

		$this->add_responsive_control(
			$prefix . '_left',
			[
				'label'      => esc_html__( 'Left Position', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', 'em', 'rem' ],
				'default'    => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors'  => [
					$selector => 'left: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					$prefix . '_float' => 'on',
					$prefix . '_align_x' => 'left',
				],
			]
		);

		$this->add_responsive_control(
			$prefix . '_right',
			[
				'label'      => esc_html__( 'Right Position', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', 'em', 'rem' ],
				'default'    => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors'  => [
					$selector => 'right: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					$prefix . '_float' => 'on',
					$prefix . '_align_x' => 'right',
				],
			]
		);

		$this->add_responsive_control(
			$prefix . '_top',
			[
				'label'      => esc_html__( 'Top Position', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', 'em', 'rem' ],
				'default'    => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors'  => [
					$selector => 'top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					$prefix . '_float' => 'on',
					$prefix . '_align_y' => 'top',
				],
			]
		);

		$this->add_responsive_control(
			$prefix . '_bottom',
			[
				'label'      => esc_html__( 'Bottom Position', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', 'em', 'rem' ],
				'default'    => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors'  => [
					$selector => 'bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					$prefix . '_float' => 'on',
					$prefix . '_align_y' => 'bottom',
				],
			]
		);

		$this->add_responsive_control(
			$prefix . '_offset_x',
			[
				'label'      => esc_html__( 'Horizontal Offset', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', 'em', 'rem' ],
				'default'    => [
					'unit' => '%',
					'size' => -50,
				],
				'range'    => [
					'%' => [
						'min' => -100,
					],
				],
				'selectors'  => [
					$selector => '--offset-x: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					$prefix . '_float' => 'on',
				],
			]
		);

		$this->add_responsive_control(
			$prefix . '_offset_y',
			[
				'label'      => esc_html__( 'Vertical Offset', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', 'em', 'rem' ],
				'default'    => [
					'unit' => '%',
					'size' => -50,
				],
				'range'    => [
					'%' => [
						'min' => -100,
					],
				],
				'selectors'  => [
					$selector => '--offset-y: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					$prefix . '_float' => 'on',
				],
			]
		);
	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		$effect = $settings['switch_effect_type'];
		$title_tag = Utils::validate_html_tag( $settings['text_tag'] );

		$this->add_render_attribute( 'wrapper', 'class', 'zyre-animated-text-wrapper zy-relative' );

		if ( 'switch' === $settings['type'] ) {
			$this->add_render_attribute( 'wrapper', 'data-start-effect', $settings['trigger'] );

			$pause = '';

			if ( 'typing' === $effect ) {
				$show_cursor = ( ! empty( $settings['show_cursor'] ) ) ? true : false;
				$loop = ! empty( $settings['type_loop'] ) ? true : false;

				$strings = [];

				foreach ( $settings['switch_text_items'] as $item ) {
					if ( ! empty( $item['switch_text'] ) ) {
						array_push( $strings, str_replace( '\'', '&#39;', $item['switch_text'] ) );
					}
				}

				$data_settings = [
					'effect'     => $effect,
					'strings'    => $strings,
					'typeSpeed'  => $settings['type_speed'],
					'backSpeed'  => $settings['back_speed'],
					'startDelay' => $settings['start_delay'],
					'backDelay'  => $settings['back_delay'],
					'showCursor' => $show_cursor,
					'loop'       => $loop,
				];
			} elseif ( 'slide' === $effect ) {

				$this->add_render_attribute( 'prefix', 'class', 'zyre-animated-text__align-span' );
				$this->add_render_attribute( 'suffix', 'class', 'zyre-animated-text__align-span' );

				$mouse_pause = 'yes' === $settings['slide_up_hover_pause'] ? true : false;
				$pause = $mouse_pause ? 'pause' : '';
				$data_settings = [
					'effect'     => $effect,
					'speed'      => $settings['slide_up_speed'],
					'showItems'  => $settings['slide_up_shown_items'],
					'pause'      => $settings['slide_up_pause_time'],
					'mousePause' => $mouse_pause,
				];
			} else {

				$data_settings = [
					'effect' => $effect,
					'delay'  => $settings['zoom_delay'],
					'count'  => $settings['loop_count'],
				];

				if ( 'custom' === $effect ) {
					$data_settings['animation'] = $settings['custom_animation'];
				} elseif ( 'clip' === $effect ) {
					$data_settings['speed'] = $settings['zoom_speed'];
				}
			}

			$data_settings['type'] = $settings['type'];

			$this->add_render_attribute(
				'wrapper',
				[
					'class'         => [
						'zyre-animated-text__' . $effect,
						$pause,
					],
					'data-settings' => wp_json_encode( $data_settings ),
				]
			);
		} else {

			$effect = $settings['single_eff_type'];

			$data_settings = [
				'effect' => $effect,
				'type'   => $settings['type'],
			];

			$this->add_render_attribute(
				'wrapper',
				[
					'class'         => [
						'zyre-animated-text__' . $effect,
					],
					'data-settings' => wp_json_encode( $data_settings ),
				]
			);

		}
		?>

		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="zyre-animated-text-heading">
				<?php if ( ! empty( $settings['prefix_text'] ) ) : ?>
					<span class="zyre-animated-text-prefix">
						<span <?php $this->print_render_attribute_string( 'prefix' ); ?>><?php echo wp_kses( $settings['prefix_text'], zyre_get_allowed_html() ); ?></span>
					</span>
				<?php endif; ?>

				<?php
				if ( 'single' === $settings['type'] ) :
					$this->render_single_text();
				else :
					$this->render_switch_text();
				endif;
				?>

				<?php if ( ! empty( $settings['suffix_text'] ) ) : ?>
					<span class="zyre-animated-text-suffix">
						<span <?php $this->print_render_attribute_string( 'suffix' ); ?>><?php echo wp_kses( $settings['suffix_text'], zyre_get_allowed_html() ); ?></span>
					</span>
				<?php endif; ?>
			</<?php Utils::print_validated_html_tag( $title_tag ); ?>>
		</div>

		<?php
	}

	/**
	 * Render Single Text
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render_single_text() {

		$settings = $this->get_settings_for_display();

		$this->add_render_attribute(
			'anim_text',
			[
				'class'     => 'zyre-animated-text',
				'data-text' => $settings['anim_text'],
			]
		);

		if ( 'reveal' === $settings['single_eff_type'] ) {
			$image_url = ZYRE_ADDONS_ASSETS . 'css/widgets/animated-text/reveal_background.jpg';
			$this->add_render_attribute( 'anim_text', 'style', "background-image: url('$image_url')" );
		}

		if ( 'fill' === $settings['single_eff_type'] && 'on' === $settings['show_fill_line'] ) {
			$this->add_render_attribute( 'anim_text', 'class', 'zyre-animated-text__has-line' );
		}
		?>

		<?php if ( 'lines' !== $settings['single_eff_type'] ) : ?>
			<span <?php $this->print_render_attribute_string( 'anim_text' ); ?>>
				<?php echo wp_kses( $settings['anim_text'], zyre_get_allowed_html() ); ?>
				<?php if ( 'shape' === $settings['single_eff_type'] ) : ?>
					<?php $this->render_draw_shape(); ?>
				<?php endif; ?>
			</span>

		<?php else : ?>
			<svg class="zyre-animated-text">
				<!-- Symbol -->
				<symbol id="s-text">
					<text text-anchor="middle" x="50%" y="50%" dy=".35em">
						<?php echo wp_kses( $settings['anim_text'], zyre_get_allowed_html() ); ?>
					</text>
				</symbol>

				<!-- Duplicate symbols -->
				<use xlink:href="#s-text" class="text"></use>
				<use xlink:href="#s-text" class="text"></use>
				<use xlink:href="#s-text" class="text"></use>
				<use xlink:href="#s-text" class="text"></use>
				<use xlink:href="#s-text" class="text"></use>
			</svg>
		<?php endif; ?>

		<?php
	}

	/**
	 * Render Switch Text
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render_switch_text() {

		$settings = $this->get_settings_for_display();

		$effect = $settings['switch_effect_type'];
		$this->add_render_attribute( 'text', 'class', 'zyre-animated-text' );

		if ( 'typing' === $effect ) : ?>
			<span <?php $this->print_render_attribute_string( 'text' ); ?>></span>
		<?php else : ?>
			<div <?php $this->print_render_attribute_string( 'text' ); ?> style='display: inline-block; text-align: center'>
				<ul class="zyre-animated-text-items">
					<?php
					foreach ( $settings['switch_text_items'] as $index => $item ) :
						if ( ! empty( $item['switch_text'] ) ) :
							$this->add_render_attribute( 'text_' . $item['_id'], 'class', 'zyre-animated-text-item elementor-repeater-item-' . $item['_id'] );

							if ( ( 'typing' !== $effect && 'slide' !== $effect ) && 0 !== $index ) {
								$this->add_render_attribute( 'text_' . $item['_id'], 'class', 'zyre-animated-text-item-hidden' );
							} else {
								$this->add_render_attribute( 'text_' . $item['_id'], 'class', 'zyre-animated-text-item-visible' );
							}
							?>
								<li <?php $this->print_render_attribute_string( 'text_' . $item['_id'] ); ?>>
									<?php echo wp_kses( $item['switch_text'], zyre_get_allowed_html() ); ?>
								</li>
							<?php
						endif;
					endforeach;
					?>
				</ul>
			</div>
			<?php
		endif;
	}

	/**
	 * Render Draw shape
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render_draw_shape() {

		$settings = $this->get_settings_for_display();
		$shape = $settings['shape'];

		$shapes_array = [
			'circle'    => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M325,18C228.7-8.3,118.5,8.3,78,21C22.4,38.4,4.6,54.6,5.6,77.6c1.4,32.4,52.2,54,142.6,63.7 c66.2,7.1,212.2,7.5,273.5-8.3c64.4-16.6,104.3-57.6,33.8-98.2C386.7-4.9,179.4-1.4,126.3,20.7"></path></svg>',

			'wavy'      => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M3,146.1c17.1-8.8,33.5-17.8,51.4-17.8c15.6,0,17.1,18.1,30.2,18.1c22.9,0,36-18.6,53.9-18.6 c17.1,0,21.3,18.5,37.5,18.5c21.3,0,31.8-18.6,49-18.6c22.1,0,18.8,18.8,36.8,18.8c18.8,0,37.5-18.6,49-18.6c20.4,0,17.1,19,36.8,19 c22.9,0,36.8-20.6,54.7-18.6c17.7,1.4,7.1,19.5,33.5,18.8c17.1,0,47.2-6.5,61.1-15.6"></path></svg>',

			'underline' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M7.7,145.6C109,125,299.9,116.2,401,121.3c42.1,2.2,87.6,11.8,87.3,25.7"></path></svg>',

			'double'    => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M5,125.4c30.5-3.8,137.9-7.6,177.3-7.6c117.2,0,252.2,4.7,312.7,7.6"></path><path d="M26.9,143.8c55.1-6.1,126-6.3,162.2-6.1c46.5,0.2,203.9,3.2,268.9,6.4"></path></svg>',

			'zigzag'    => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M9.3,127.3c49.3-3,150.7-7.6,199.7-7.4c121.9,0.4,189.9,0.4,282.3,7.2C380.1,129.6,181.2,130.6,70,139 c82.6-2.9,254.2-1,335.9,1.3c-56,1.4-137.2-0.3-197.1,9"></path></svg>',

			'strike'    => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M3,75h493.5"></path></svg>',

			'cross'     => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M497.4,23.9C301.6,40,155.9,80.6,4,144.4"></path><path d="M14.1,27.6c204.5,20.3,393.8,74,467.3,111.7"></path></svg>',
		];

		echo $shapes_array[ $shape ]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
