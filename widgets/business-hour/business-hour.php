<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;

defined( 'ABSPATH' ) || die();

class Business_Hour extends Base {

	public function get_title() {
		return esc_html__( 'Business Hour', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Business-hour';
	}

	public function get_keywords() {
		return [ 'business', 'hours', 'business hours', 'business schedule', 'days', 'dates', 'business days', 'business times', 'times' ];
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	protected function register_content_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Business Hour Content', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		// Header
		$this->add_control(
			'show_header',
			[
				'label'        => esc_html__( 'Show Header', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off'    => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => esc_html__( 'Working hours', 'zyre-elementor-addons' ),
				'dynamic'     => [
					'active' => true,
				],
				'condition'   => [
					'show_header' => 'yes',
				],
			]
		);

		$this->add_control(
			'sub_title',
			[
				'label'       => esc_html__( 'Sub Title', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'condition'   => [
					'show_header' => 'yes',
				],
			]
		);

		$this->add_control(
			'header_icon',
			[
				'label'        => esc_html__( 'Icon', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'condition'   => [
					'show_header' => 'yes',
				],
			]
		);

		$this->add_control(
			'header_icon_position',
			[
				'label'       => esc_html__( 'Icon Position', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'left'  => esc_html__( 'Left', 'zyre-elementor-addons' ),
					'right' => esc_html__( 'Right', 'zyre-elementor-addons' ),
				],
				'default'     => 'left',
				'skin'        => 'inline',
				'label_block' => false,
				'style_transfer' => true,
				'selectors_dictionary' => [
					'left' => 'flex-direction: row;',
					'right' => 'flex-direction: row-reverse;',
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-business-hour-header' => '{{VALUE}}',
				],
				'condition' => [
					'show_header' => 'yes',
					'header_icon[value]!' => '',
				],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'day',
			[
				'label'       => esc_html__( 'Day', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => esc_html__( 'Monday', 'zyre-elementor-addons' ),
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		// Icon
		$repeater->add_control(
			'day_icon',
			[
				'label'       => esc_html__( 'Icon', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
			]
		);

		$repeater->add_control(
			'day_icon_position',
			[
				'label'          => esc_html__( 'Icon Position', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::SELECT,
				'options'        => [
					'left'  => esc_html__( 'Left', 'zyre-elementor-addons' ),
					'right' => esc_html__( 'Right', 'zyre-elementor-addons' ),
				],
				'default'        => 'left',
				'skin'           => 'inline',
				'label_block'    => false,
				'style_transfer' => true,
				'condition'      => [
					'day_icon[value]!' => '',
				],
			]
		);

		$repeater->add_responsive_control(
			'day_icon_size',
			[
				'label'          => esc_html__( 'Icon Size', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => [ 'px' ],
				'range'          => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors'      => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .zyre-business-hour-day-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'style_transfer' => true,
				'condition'      => [
					'day_icon[value]!' => '',
				],
			]
		);

		$repeater->add_control(
			'day_icon_space',
			[
				'label'          => esc_html__( 'Icon Space', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::SLIDER,
				'selectors'      => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .zyre-business-hour-day' => 'gap: {{SIZE}}{{UNIT}};',
				],
				'style_transfer' => true,
				'condition'      => [
					'day_icon[value]!' => '',
				],
			]
		);

		$repeater->add_control(
			'day_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .zyre-business-hour-day-icon i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} .zyre-business-hour-day-icon svg' => 'fill: {{VALUE}};',
				],
				'separator' => 'after',
				'condition' => [
					'day_icon[value]!' => '',
				],
			]
		);

		// Day off
		$repeater->add_control(
			'day_off',
			[
				'label'        => esc_html__( 'Day off?', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'zyre-elementor-addons' ),
				'label_off'    => esc_html__( 'No', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
			]
		);

		$repeater->add_control(
			'day_off_text',
			[
				'label'     => esc_html__( 'Day off text', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Day off', 'zyre-elementor-addons' ),
				'condition' => [
					'day_off' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'day_item_bg',
			[
				'label'          => esc_html__( 'Item Background', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::COLOR,
				'selectors'      => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.zyre-business-hour-item-offday' => 'background-color: {{VALUE}};',
				],
				'style_transfer' => true,
				'separator'      => 'after',
				'condition'      => [
					'day_off' => 'yes',
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'day_typo',
				'label'    => esc_html__( 'Day Typography', 'zyre-elementor-addons' ),
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .zyre-business-hour-day-text',
				'style_transfer' => true,
				'condition' => [
					'day_off' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'day_color',
			[
				'label'          => esc_html__( 'Day Color', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::COLOR,
				'default'        => '#8C919B',
				'selectors'      => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .zyre-business-hour-day-text' => 'color: {{VALUE}};',
				],
				'style_transfer' => true,
				'separator'      => 'after',
				'condition'      => [
					'day_off' => 'yes',
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'day_off_typo',
				'label'          => esc_html__( 'Off Text Typography', 'zyre-elementor-addons' ),
				'selector'       => '{{WRAPPER}} {{CURRENT_ITEM}} .zyre-business-hour-times .zyre-business-hour-dayoff-text',
				'style_transfer' => true,
				'condition'      => [
					'day_off' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'day_off_color',
			[
				'label'     => esc_html__( 'Off Text Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FA4119',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .zyre-business-hour-times .zyre-business-hour-dayoff-text' => 'color: {{VALUE}};',
				],
				'style_transfer' => true,
				'condition' => [
					'day_off' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'day_off_times_bg',
			[
				'label'     => esc_html__( 'Off Text Background', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .zyre-business-hour-times' => 'background-color: {{VALUE}};',
				],
				'style_transfer' => true,
				'condition' => [
					'day_off' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'day_task',
			[
				'label'     => esc_html__( 'Task Name', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => [
					'day_off!' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'time_start',
			[
				'label'     => esc_html__( 'Start Time', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( '10:00AM', 'zyre-elementor-addons' ),
				'dynamic'   => [
					'active' => true,
				],
				'separator' => 'before',
				'condition' => [
					'day_off!' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'time_end',
			[
				'label'     => esc_html__( 'End Time', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( '07:00PM', 'zyre-elementor-addons' ),
				'dynamic'   => [
					'active' => true,
				],
				'condition' => [
					'day_off!' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'label_time_start',
			[
				'label'     => esc_html__( 'Start Time Label', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'dynamic'   => [
					'active' => true,
				],
				'separator' => 'before',
				'condition' => [
					'day_off!' => 'yes',
					'time_start!' => '',
				],
			]
		);

		$repeater->add_control(
			'label_time_end',
			[
				'label'     => esc_html__( 'End Time Label', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'dynamic'   => [
					'active' => true,
				],
				'condition' => [
					'day_off!' => 'yes',
					'time_end!' => '',
				],
			]
		);

		$this->add_control(
			'items',
			[
				'type'        => Controls_Manager::REPEATER,
				'title_field' => '{{{ day }}}',
				'fields'      => $repeater->get_controls(),
				'separator'   => 'before',
				'default'     => [
					[
						'day'     => esc_html__( 'Monday - Friday', 'zyre-elementor-addons' ),
						'time_start'  => esc_html__( '09:00AM - 06:00PM', 'zyre-elementor-addons' ),
						'time_end' => '',
					],
					[
						'day'     => esc_html__( 'Saturday', 'zyre-elementor-addons' ),
						'time_start'  => esc_html__( '09:00AM - 02:00PM', 'zyre-elementor-addons' ),
						'time_end' => '',
					],
					[
						'day'     => esc_html__( 'Sunday', 'zyre-elementor-addons' ),
						'day_off' => 'yes',
						'day_off_text' => esc_html__( 'Day off', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_controls() {
		$this->__header_style_controls();
		$this->__header_title_style_controls();
		$this->__header_subtitle_style_controls();
		$this->__header_icon_style_controls();
		$this->__items_style_controls();
		$this->__item_style_controls();
		$this->__day_style_controls();
		$this->__times_style_controls();
		$this->__time_style_controls();
		$this->__times_label_style_controls();
		$this->__task_style_controls();
	}

	protected function __header_style_controls() {
		$this->start_controls_section(
			'section_header_style',
			[
				'label' => esc_html__( 'Header', 'zyre-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_header' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'header',
			[
				'selector' => '{{WRAPPER}} .zyre-business-hour-header',
				'controls' => [
					'gap'           => [
						'default'   => [
							'unit' => 'px',
						],
						'condition' => [
							'header_icon[value]!' => '',
						],
					],
					'bg_color'      => [],
					'border'        => [],
					'border_radius' => [],
					'padding'       => [],
					'margin_bottom' => [
						'label' => esc_html__( 'Space Bottom', 'zyre-elementor-addons' ),
					],
					'align'         => [],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __header_title_style_controls() {
		$this->start_controls_section(
			'section_header_title_style',
			[
				'label'     => esc_html__( 'Header Title', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_header' => 'yes',
					'title!'      => '',
				],
			]
		);

		$this->set_style_controls(
			'title',
			[
				'selector' => '{{WRAPPER}} .zyre-business-hour-title',
				'controls' => [
					'typo'          => [],
					'color'         => [],
					'text_shadow'   => [],
					'margin_bottom' => [
						'label'     => esc_html__( 'Space Bottom', 'zyre-elementor-addons' ),
						'condition' => [
							'sub_title!' => '',
						],
					],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __header_subtitle_style_controls() {
		$this->start_controls_section(
			'section_header_subtitle_style',
			[
				'label' => esc_html__( 'Header Sub Title', 'zyre-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_header' => 'yes',
					'sub_title!' => '',
				],
			]
		);

		$this->set_style_controls(
			'sub_title',
			[
				'selector' => '{{WRAPPER}} .zyre-business-hour-sub-title',
				'controls' => [
					'typo'          => [],
					'color'         => [],
					'text_shadow'   => [],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __header_icon_style_controls() {
		$this->start_controls_section(
			'section_header_icon_style',
			[
				'label' => esc_html__( 'Header Icon', 'zyre-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_header' => 'yes',
					'header_icon[value]!' => '',
				],
			]
		);

		$this->set_style_controls(
			'icon',
			[
				'selector' => '{{WRAPPER}} .zyre-business-hour-header-icon',
				'controls' => [
					'width'         => [
						'range'   => [
							'px'  => [
								'max' => 200,
							],
							'em'  => [
								'min' => 0.1,
							],
							'rem' => [
								'min' => 0.1,
							],
						],
						'default' => [
							'unit' => 'px',
						],
					],
					'icon_size'     => [],
					'icon_color'    => [],
					'bg_color'      => [],
					'border'        => [],
					'border_radius' => [],
					'padding'       => [],
					'align_y'       => [
						'css_property' => 'align-content',
					],
				],
			]
		);

		$this->add_responsive_control(
			'icon_align_x',
			[
				'label'                => esc_html__( 'Horizontal Position', 'zyre-elementor-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
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
				'selectors_dictionary' => [
					'left'   => 'margin-left: 0; margin-right: auto; text-align: left;',
					'center' => 'margin-left: auto; margin-right: auto; text-align: center;',
					'right'  => 'margin-left: auto; margin-right: 0; text-align: right;',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-business-hour-header-icon i, {{WRAPPER}} .zyre-business-hour-header-icon svg' => '{{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __items_style_controls() {
		$this->start_controls_section(
			'section_items_style',
			[
				'label' => esc_html__( 'Items', 'zyre-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'items_columns',
			[
				'label'           => esc_html__( 'Columns', 'zyre-elementor-addons' ),
				'type'            => Controls_Manager::SELECT,
				'options'         => [
					1 => esc_html__( '1 Column', 'zyre-elementor-addons' ),
					2 => esc_html__( '2 Columns', 'zyre-elementor-addons' ),
					3 => esc_html__( '3 Columns', 'zyre-elementor-addons' ),
					4 => esc_html__( '4 Columns', 'zyre-elementor-addons' ),
					5 => esc_html__( '5 Columns', 'zyre-elementor-addons' ),
					6 => esc_html__( '6 Columns', 'zyre-elementor-addons' ),
				],
				'desktop_default' => 1,
				'tablet_default'  => 1,
				'mobile_default'  => 1,
				'selectors'       => [
					'{{WRAPPER}} .zyre-business-hour-items' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
				],
			]
		);

		$this->set_style_controls(
			'items',
			[
				'selector' => '{{WRAPPER}} .zyre-business-hour-items',
				'controls' => [
					'gap'           => [
						'label'   => esc_html__( 'Space Between', 'zyre-elementor-addons' ),
						'default' => [
							'unit' => 'px',
						],
					],
					'bg_color'      => [],
					'border'        => [],
					'border_radius' => [],
					'padding'       => [],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __item_style_controls() {
		$this->start_controls_section(
			'section_item_style',
			[
				'label' => esc_html__( 'Item', 'zyre-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'item',
			[
				'selector' => '{{WRAPPER}} .zyre-business-hour-item',
				'controls' => [
					'min_height'    => [
						'label'        => esc_html__( 'Min Height', 'zyre-elementor-addons' ),
						'range'        => [
							'px' => [
								'min' => 25,
								'max' => 500,
							],
							'%'  => [
								'min' => 5,
							],
							'em' => [
								'min' => 1.5,
							],
						],
						'default'      => [
							'unit' => 'px',
						],
						'css_property' => 'min-height',
					],
					'gap'           => [
						'label'   => esc_html__( 'Space Between', 'zyre-elementor-addons' ),
						'default' => [
							'unit' => 'px',
						],
					],
					'bg_color'      => [],
					'border'        => [
						'selector' => '{{WRAPPER}} .zyre-business-hour-item:not(.zyre-business-hour-item-no-border)',
					],
					'options'       => [
						'label'     => esc_html__( 'Exclude Border', 'zyre-elementor-addons' ),
						'default'   => 'none',
						'options'   => [
							'none'  => esc_html__( 'None', 'zyre-elementor-addons' ),
							'last'  => esc_html__( 'Last Item', 'zyre-elementor-addons' ),
							'first' => esc_html__( 'First Item', 'zyre-elementor-addons' ),
						],
						'condition' => [
							'item_border_border!' => [ '', 'none' ],
						],
					],
					'border_radius' => [],
					'padding'       => [],
					'box_shadow'    => [],
				],
			]
		);

		$this->add_responsive_control(
			'item_direction',
			[
				'label'        => esc_html__( 'Direction', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::CHOOSE,
				'default'      => 'row',
				'options'      => [
					'row'    => [
						'title' => esc_html__( 'Row - horizontal', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-arrow-right',
					],
					'column' => [
						'title' => esc_html__( 'Column - vertical', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-arrow-down',
					],
				],
				'prefix_class' => 'zyre-business-hour-item-dir%s-',
				'selectors'    => [
					'{{WRAPPER}} .zyre-business-hour-item' => 'flex-direction: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __day_style_controls() {
		$this->start_controls_section(
			'section_day_style',
			[
				'label' => esc_html__( 'Days', 'zyre-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'day_text',
			[
				'selector' => '{{WRAPPER}} .zyre-business-hour-day-text',
				'controls' => [
					'typo'        => [],
					'color'       => [],
					'text_shadow' => [],
				],
			]
		);

		$this->set_style_controls(
			'day',
			[
				'selector' => '{{WRAPPER}} .zyre-business-hour-day',
				'controls' => [
					'bg_color'      => [
						'separator' => 'after',
					],
					'border'        => [],
					'border_radius' => [],
					'padding'       => [],
				],
			]
		);

		$this->add_responsive_control(
			'day_align_v',
			[
				'label'       => esc_html__( 'Align Items', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'flex-start'    => [
						'title' => esc_html__( 'Start', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-align-start-v',
					],
					'center'        => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-align-center-v',
					],
					'flex-end'      => [
						'title' => esc_html__( 'End', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-align-end-v',
					],
					'stretch'      => [
						'title' => esc_html__( 'Stretch', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-align-stretch-v',
					],
				],
				'selectors'   => [
					'{{WRAPPER}}:not(.zyre-business-hour-item-dir-column) .zyre-business-hour-day' => 'align-items: {{VALUE}};',
				],
				'condition'   => [
					'item_direction!' => 'column',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __times_style_controls() {
		$this->start_controls_section(
			'section_times_style',
			[
				'label' => esc_html__( 'Times', 'zyre-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'times',
			[
				'selector' => '{{WRAPPER}} .zyre-business-hour-times',
				'controls' => [
					'gap'           => [
						'label'   => esc_html__( 'Space Between', 'zyre-elementor-addons' ),
						'default' => [
							'unit' => 'px',
						],
					],
					'width'         => [
						'default' => [
							'unit' => 'px',
						],
					],
					'bg_color'      => [
						'separator' => 'after',
					],
					'border'        => [],
					'border_radius' => [],
					'padding'       => [],
					'direction'     => [
						'label'        => esc_html__( 'Content Direction', 'zyre-elementor-addons' ),
						'default'      => 'row',
						'prefix_class' => 'zyre-business-hour-times-dir-',
					],
				],
			]
		);

		$this->add_responsive_control(
			'times_justify',
			[
				'label'       => esc_html__( 'Justify Content', 'zyre-elementor-addons' ),
				'label_block' => true,
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'flex-start'    => [
						'title' => esc_html__( 'Start', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-justify-start-h',
					],
					'center'        => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-justify-center-h',
					],
					'flex-end'      => [
						'title' => esc_html__( 'End', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-justify-end-h',
					],
					'space-between' => [
						'title' => esc_html__( 'Space Between', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-justify-space-between-h',
					],
					'space-around'  => [
						'title' => esc_html__( 'Space Around', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-justify-space-around-h',
					],
					'space-evenly'  => [
						'title' => esc_html__( 'Space Evenly', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-justify-space-evenly-h',
					],
				],
				'selectors'   => [
					'{{WRAPPER}} .zyre-business-hour-times' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'times_align_items',
			[
				'label'       => esc_html__( 'Align Items', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'flex-start'    => [
						'title' => esc_html__( 'Start', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-align-start-v',
					],
					'center'        => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-align-center-v',
					],
					'flex-end'      => [
						'title' => esc_html__( 'End', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-align-end-v',
					],
				],
				'selectors'   => [
					'{{WRAPPER}} .zyre-business-hour-times' => 'align-items: {{VALUE}};',
				],
				'condition'   => [
					'times_direction!' => 'column',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __time_style_controls() {
		$this->start_controls_section(
			'section_time_style',
			[
				'label' => esc_html__( 'Time', 'zyre-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'time',
			[
				'selector' => '{{WRAPPER}} .zyre-business-hour-time-text',
				'controls' => [
					'typo'        => [],
					'color'       => [],
					'text_shadow' => [],
				],
			]
		);

		$this->set_style_controls(
			'time',
			[
				'selector' => '{{WRAPPER}} .zyre-business-hour-time',
				'controls' => [
					'heading'   => [
						'label'     => esc_html__( 'Labels & Times', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
					'gap'       => [
						'label'   => esc_html__( 'Space Between', 'zyre-elementor-addons' ),
						'default' => [
							'unit' => 'px',
						],
					],
					'direction' => [
						'default'      => 'row',
						'prefix_class' => 'zyre-business-hour-time-dir-',
					],
				],
			]
		);

		$this->add_responsive_control(
			'time_text_align',
			[
				'label'                => esc_html__( 'Text Alignment', 'zyre-elementor-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'default'              => is_rtl() ? 'right' : 'left',
				'options'              => [
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
				'selectors_dictionary' => [
					'left'   => 'text-align: left; align-items: flex-start;',
					'center' => 'text-align: center; align-items: center;',
					'right'  => 'text-align: right; align-items: flex-end;',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-business-hour-time, {{WRAPPER}} .zyre-business-hour-time-label' => '{{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __times_label_style_controls() {
		$this->start_controls_section(
			'section_times_label_style',
			[
				'label' => esc_html__( 'Times Label', 'zyre-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'times_label',
			[
				'selector' => '{{WRAPPER}} .zyre-business-hour-times .zyre-business-hour-time-label',
				'controls' => [
					'typo'        => [],
					'color'       => [],
					'text_shadow' => [],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __task_style_controls() {
		$this->start_controls_section(
			'section_task_style',
			[
				'label' => esc_html__( 'Task', 'zyre-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'task_text',
			[
				'selector' => '{{WRAPPER}} .zyre-business-hour-day-task-text',
				'controls' => [
					'typo'          => [],
					'color'         => [],
					'text_shadow'   => [],
					'bg_color'      => [],
					'border'        => [],
					'border_radius' => [],
					'padding'       => [],
				],
			]
		);

		$this->set_style_controls(
			'task_wrap',
			[
				'selector' => '{{WRAPPER}} .zyre-business-hour-day-task-wrap',
				'controls' => [
					'heading'       => [
						'label'     => esc_html__( 'Task Wrapper', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
					'bg_color'      => [],
					'border'        => [],
					'border_radius' => [],
					'padding'       => [],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$no_border_item = '';
		if ( isset( $settings['item_opt'] ) && 'none' !== $settings['item_opt'] ) {
			$no_border_item = $settings['item_opt'];
		}

		$items = $settings['items'];
		$first_index = array_key_first( $items );
		$last_index  = array_key_last( $items );

		$this->add_render_attribute( 'title', 'class', 'zyre-business-hour-title zy-fs-1.5' );
		$this->add_render_attribute( 'sub_title', 'class', 'zyre-business-hour-sub-title' );
		$this->add_inline_editing_attributes( 'title' );
		$this->add_inline_editing_attributes( 'sub_title' );
		?>

		<div class="zyre-business-hour-wrapper">
			<?php if ( 'yes' === $settings['show_header'] ) : ?>
				<div class="zyre-business-hour-header zy-flex zy-align-center">
					<?php if ( ! empty( $settings['header_icon']['value'] ) ) : ?>
						<span class="zyre-business-hour-header-icon zy-fs-2"><?php zyre_render_icon( $settings, 'icon', 'header_icon' ); ?></span>
					<?php endif; ?>

					<?php if ( ! empty( $settings['title'] ) || ! empty( $settings['sub_title'] ) ) : ?>
						<div class="zyre-business-hour-header-inner zy-grow-1">
							<?php if ( $settings['title'] ) : ?>
								<div <?php $this->print_render_attribute_string( 'title' ); ?>><?php echo esc_html( $settings['title'] ); ?></div>
							<?php endif; ?>
							<?php if ( $settings['sub_title'] ) : ?>
								<div <?php $this->print_render_attribute_string( 'sub_title' ); ?>><?php echo esc_html( $settings['sub_title'] ); ?></div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<ul class="zyre-business-hour-items zy-list-none zy-m-0 zy-p-0 zy-grid zy-gap-2">
				<?php foreach ( $items as $i => $item ) :
					$item_key = 'item_' . $i;
					$this->add_render_attribute( $item_key, 'class', 'zyre-business-hour-item zy-flex zy-align-center zy-justify-between zy-mh-10 zy-w-100 zy-overflow-hidden' );
					$this->add_render_attribute( $item_key, 'class', 'elementor-repeater-item-' . $item['_id'] );
					if ( ( $i === $first_index && 'first' === $no_border_item ) || ( $i === $last_index && 'last' === $no_border_item ) ) {
						$this->add_render_attribute( $item_key, 'class', 'zyre-business-hour-item-no-border' );
					}
					if ( 'yes' === $item['day_off'] && ! empty( $item['day_off_text'] ) ) {
						$this->add_render_attribute( $item_key, 'class', 'zyre-business-hour-item-offday' );
					}
					?>
					<li <?php $this->print_render_attribute_string( $item_key ); ?>>
						<?php if ( $item['day'] ) : ?>
							<div class="zyre-business-hour-day zy-inline-flex zy-align-center">
								<?php if ( ! empty( $item['day_icon']['value'] ) && 'left' === $item['day_icon_position'] ) : ?>
									<span class="zyre-business-hour-day-icon"><?php zyre_render_icon( $item, 'icon', 'day_icon' ); ?></span>
								<?php endif; ?>
								<span class="zyre-business-hour-day-text"><?php echo zyre_kses_basic( $item['day'] ); ?></span>
								<?php if ( ! empty( $item['day_icon']['value'] ) && 'right' === $item['day_icon_position'] ) : ?>
									<span class="zyre-business-hour-day-icon"><?php zyre_render_icon( $item, 'icon', 'day_icon' ); ?></span>
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $item['day_task'] ) ) : ?>
							<div class="zyre-business-hour-day-task">
								<div class="zyre-business-hour-day-task-wrap">
									<span class="zyre-business-hour-day-task-text"><?php echo zyre_kses_basic( $item['day_task'] ); ?></span>
								</div>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $item['time_start'] ) || ! empty( $item['time_end'] ) ) : ?>
							<div class="zyre-business-hour-times zy-inline-flex zy-align-center">
								<?php if ( $item['time_start'] ) : ?>
									<div class="zyre-business-hour-time zyre-business-hour-start-time zy-flex zy-align-center">
										<?php if ( ! empty( $item['label_time_start'] ) ) : ?>
											<span class="zyre-business-hour-time-label zyre-business-hour-start-time-label"><?php echo zyre_kses_basic( $item['label_time_start'] ); ?></span>
										<?php endif; ?>
										<span class="zyre-business-hour-time-text zyre-business-hour-start-time-text"><?php echo zyre_kses_basic( $item['time_start'] ); ?></span>
									</div>
								<?php endif; ?>

								<?php if ( $item['time_end'] ) : ?>
									<div class="zyre-business-hour-time zyre-business-hour-end-time zy-flex zy-align-center">
										<?php if ( $item['label_time_end'] ) : ?>
											<span class="zyre-business-hour-time-label zyre-business-hour-end-time-label"><?php echo zyre_kses_basic( $item['label_time_end'] ); ?></span>
										<?php endif; ?>
										<span class="zyre-business-hour-time-text zyre-business-hour-end-time-text"><?php echo zyre_kses_basic( $item['time_end'] ); ?></span>
									</div>
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<?php if ( 'yes' === $item['day_off'] && ! empty( $item['day_off_text'] ) ) : ?>
							<div class="zyre-business-hour-times">
								<div class="zyre-business-hour-time zyre-business-hour-dayoff">
									<span class="zyre-business-hour-time-text zyre-business-hour-dayoff-text"><?php echo zyre_kses_basic( $item['day_off_text'] ); ?></span>
								</div>
							</div>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>

		<?php
	}
}
