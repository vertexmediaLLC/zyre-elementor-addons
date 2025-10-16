<?php
namespace ZyreAddons\Elementor\Traits;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

trait Button_Trait {
	/**
	 *
	 * @param array $args {
	 *     An array of values for the button adjustments.
	 *
	 *     @type string $id_prefix  Set prefix of the controls id.
	 *     @type string $button_default_text  Text contained in button.
	 *     @type string $text_label  Button Text Control label.
	 *     @type string $link_label  Button Link Control label.
	 *     @type string $icon_label  Button Icon control Control label.
	 *     @type bool $show_button_id  Whether button id attribute field will show. Default true.
	 *     @type bool $show_button_class  Whether button custom class attribute field will show. Default true.
	 *     @type bool $show_button_event  Whether button onclick event attribute field will show. Default true.
	 *     @type array $condition  Whether controls will show or hide.
	 * }
	 */
	protected function register_button_content_controls( $args = [] ) {
		$default_args = [
			'id_prefix'           => '',
			'button_default_text' => esc_html__( 'Learn more', 'zyre-elementor-addons' ),
			'text_label'          => esc_html__( 'Text', 'zyre-elementor-addons' ),
			'link_label'          => esc_html__( 'Link', 'zyre-elementor-addons' ),
			'icon_label'          => esc_html__( 'Icon', 'zyre-elementor-addons' ),
			'show_button_id'      => true,
			'show_button_class'   => true,
			'show_button_event'   => true,
			'condition'           => [],
		];

		$args = wp_parse_args( $args, $default_args );

		$prefix = ! empty( $args['id_prefix'] ) ? $args['id_prefix'] . '_' : '';
		$class_base = ! empty( $args['id_prefix'] ) ? 'zyre-button-' . $args['id_prefix'] : 'zyre-button';

		$conditions = $args['condition'];

		$this->add_control(
			$prefix . 'button_text',
			[
				'label'       => $args['text_label'],
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => $args['button_default_text'],
				'dynamic'     => [
					'active' => true,
				],
				'ai'          => false,
				'condition'   => $conditions,
			]
		);

		$this->add_control(
			$prefix . 'button_link',
			[
				'label'       => $args['link_label'],
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://example.com',
				'dynamic'     => [
					'active' => true,
				],
				'default'     => [
					'url' => '#',
				],
				'condition'   => $conditions,
			]
		);

		$this->add_control(
			$prefix . 'button_icon',
			[
				'label'       => $args['icon_label'],
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'condition'   => $conditions,
			]
		);

		$this->add_control(
			$prefix . 'button_icon_position',
			[
				'label'     => esc_html__( 'Icon Position', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'right',
				'options'   => [
					'left'  => esc_html__( 'Before', 'zyre-elementor-addons' ),
					'right' => esc_html__( 'After', 'zyre-elementor-addons' ),
				],
				'condition' => [ $prefix . 'button_icon[value]!' => '' ] + $conditions,
			]
		);

		$this->add_responsive_control(
			$prefix . 'button_icon_space',
			[
				'label'     => esc_html__( 'Icon Spacing', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'unit' => 'px',
				],
				'range'     => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					"{{WRAPPER}} .{$class_base} .zyre-button-inner" => 'gap: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ $prefix . 'button_icon[value]!' => '' ] + $conditions,
			]
		);

		if ( $args['show_button_id'] ) {
			$this->add_control(
				$prefix . 'button_id_attr',
				[
					'label'       => esc_html__( 'Button ID', 'zyre-elementor-addons' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => '',
					'title'       => esc_html__( 'Add your custom id WITHOUT the Pound key. e.g: my-id', 'zyre-elementor-addons' ),
					'description' => esc_html__( 'Please make sure the ID is unique and not used elsewhere on the current page. This field allows <code>A-z 0-9</code> & underscore chars without spaces.', 'zyre-elementor-addons' ),
					'separator'   => 'before',
					'ai'          => false,
					'condition'   => $conditions,
				]
			);
		}

		if ( $args['show_button_class'] ) {
			$this->add_control(
				$prefix . 'button_class_attr',
				[
					'label'       => esc_html__( 'Custom Class', 'zyre-elementor-addons' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Class Name', 'zyre-elementor-addons' ),
					'ai'          => false,
					'condition'   => $conditions,
				]
			);
		}

		if ( $args['show_button_event'] ) {
			$this->add_control(
				$prefix . 'button_onclick_event',
				[
					'label'       => esc_html__( 'onClick Event', 'zyre-elementor-addons' ),
					'type'        => Controls_Manager::TEXT,
					'ai'          => false,
					'placeholder' => 'myFunction()',
					'condition'   => $conditions,
				]
			);
		}
	}

	/**
	 * @param array $args {
	 *     An array of values for the button styles adjustments.
	 *
	 *     @type string  $prefix  Set prefix of the controls id.
	 * }
	 */
	protected function register_button_style_controls( $args = [] ) {
		$default_args = [
			'id_prefix' => '',
		];

		$args = wp_parse_args( $args, $default_args );

		$prefix = ! empty( $args['id_prefix'] ) ? $args['id_prefix'] . '_' : '';
		$class_base = ! empty( $args['id_prefix'] ) ? 'zyre-button-' . $args['id_prefix'] : 'zyre-button';

		$this->add_responsive_control(
			$prefix . 'button_width',
			[
				'label'      => esc_html__( 'Width', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vw', '%' ],
				'range'      => [
					'%'  => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 800,
					],
				],
				'selectors'  => [
					"{{WRAPPER}} .{$class_base}" => 'width: {{SIZE}}{{UNIT}}; max-width:100%;',
				],
			]
		);

		$this->add_responsive_control(
			$prefix . 'button_height',
			[
				'label'      => esc_html__( 'Height', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vw', '%' ],
				'range'      => [
					'%'  => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 800,
					],
				],
				'selectors'  => [
					"{{WRAPPER}} .{$class_base}" => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			$prefix . 'button_justify_content',
			[
				'label'        => esc_html__( 'Justify Content', 'zyre-elementor-addons' ),
				'label_block'  => true,
				'type'         => Controls_Manager::CHOOSE,
				'default' => '',
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Start', 'zyre-elementor-addons' ),
						'icon' => 'eicon-flex eicon-justify-start-h',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon' => 'eicon-flex eicon-justify-center-h',
					],
					'flex-end' => [
						'title' => esc_html__( 'End', 'zyre-elementor-addons' ),
						'icon' => 'eicon-flex eicon-justify-end-h',
					],
					'space-between' => [
						'title' => esc_html__( 'Space Between', 'zyre-elementor-addons' ),
						'icon' => 'eicon-flex eicon-justify-space-between-h',
					],
					'space-around' => [
						'title' => esc_html__( 'Space Around', 'zyre-elementor-addons' ),
						'icon' => 'eicon-flex eicon-justify-space-around-h',
					],
					'space-evenly' => [
						'title' => esc_html__( 'Space Evenly', 'zyre-elementor-addons' ),
						'icon' => 'eicon-flex eicon-justify-space-evenly-h',
					],
				],
				'selectors' => [
					"{{WRAPPER}} .{$class_base} .zyre-button-inner" => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => $prefix . 'typography',
				'fields_options' => [
					'typography'  => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Inter' ],
					'font_size'   => [
						'default' => [
							'size' => '18',
							'unit' => 'px',
						],
					],
					'font_weight' => [ 'default' => '700' ],
					'line_height' => [
						'default' => [
							'unit' => 'em',
						],
					],
				],
				'selector'       => "{{WRAPPER}} .{$class_base} .zyre-button-text",
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => $prefix . 'button_text_shadow',
				'selector' => "{{WRAPPER}} .{$class_base} .zyre-button-text",
			]
		);

		// Tabs
		$this->start_controls_tabs( 'tabs_' . $prefix . 'button_style' );

		// Tab: Normal
		$this->start_controls_tab(
			$prefix . 'button_style_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			$prefix . 'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					"{{WRAPPER}} .{$class_base}"     => 'fill: {{VALUE}}; color: {{VALUE}};',
					"{{WRAPPER}} .{$class_base} svg" => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'           => $prefix . 'button_background',
				'label'          => esc_html__( 'Background', 'zyre-elementor-addons' ),
				'types'          => [ 'classic', 'gradient' ],
				'exclude'        => [ 'image' ],
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'selector'       => "{{WRAPPER}} .{$class_base}",
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => $prefix . 'button_box_shadow',
				'selector' => "{{WRAPPER}} .{$class_base}",
			]
		);

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab(
			$prefix . 'button_style_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			$prefix . 'button_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					"{{WRAPPER}} .{$class_base}:hover, {{WRAPPER}} .{$class_base}:focus"         => 'color: {{VALUE}};',
					"{{WRAPPER}} .{$class_base}:hover svg, {{WRAPPER}} .{$class_base}:focus svg" => 'color: {{VALUE}};fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'           => $prefix . 'button_hover_background',
				'label'          => esc_html__( 'Background', 'zyre-elementor-addons' ),
				'types'          => [ 'classic', 'gradient' ],
				'exclude'        => [ 'image' ],
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'selector'       => "{{WRAPPER}} .{$class_base}::before",
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => $prefix . 'button_hover_box_shadow',
				'selector' => "{{WRAPPER}} .{$class_base}:hover, {{WRAPPER}} .{$class_base}:focus",
			]
		);

		$this->add_control(
			$prefix . 'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					"{{WRAPPER}} .{$class_base}:hover, {{WRAPPER}} .{$class_base}:focus" => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => $prefix . 'button_border',
				'selector'  => "{{WRAPPER}} .{$class_base}",
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			$prefix . 'button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					"{{WRAPPER}} .{$class_base}" => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			$prefix . 'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					"{{WRAPPER}} .{$class_base}" => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			$prefix . 'button_margin',
			[
				'label'      => esc_html__( 'Margin', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					"{{WRAPPER}} .{$class_base}" => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			$prefix . 'button_align',
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
					'left'   => 'margin-right: auto;margin-left:0;',
					'center' => 'margin-right: auto;margin-left:auto;',
					'right'  => 'margin-right: 0;margin-left:auto;',
				],
				'selectors'            => [
					"{{WRAPPER}} .{$class_base}"     => '{{VALUE}}',
				],
			]
		);
	}

	/**
	 * @param array $args {
	 *     An array of values for the button icon styles adjustments.
	 *
	 *     @type string  $prefix  Set prefix of the controls id.
	 * }
	 */
	protected function register_button_icon_style_controls( $args = [] ) {
		$default_args = [
			'id_prefix' => '',
		];

		$args = wp_parse_args( $args, $default_args );

		$prefix = ! empty( $args['id_prefix'] ) ? $args['id_prefix'] . '_' : '';
		$class_base = ! empty( $args['id_prefix'] ) ? 'zyre-button-' . $args['id_prefix'] : 'zyre-button';

		$this->add_responsive_control(
			$prefix . 'button_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 5,
						'max' => 300,
					],
				],
				'default'    => [
					'unit' => 'px',
				],
				'selectors'  => [
					"{{WRAPPER}} .{$class_base} .zyre-button-icon"   => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			$prefix . 'button_icon_bg_width',
			[
				'label'      => esc_html__( 'Background Width', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 5,
						'max' => 500,
					],
				],
				'selectors'  => [
					"{{WRAPPER}} .{$class_base} .zyre-button-icon" => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			$prefix . 'button_icon_bg_height',
			[
				'label'      => esc_html__( 'Background Height', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 5,
						'max' => 500,
					],
				],
				'selectors'  => [
					"{{WRAPPER}} .{$class_base} .zyre-button-icon" => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( $prefix . 'button_icon_style' );

		$this->start_controls_tab(
			$prefix . 'button_icon_normal_style',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			$prefix . 'button_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					"{{WRAPPER}} .{$class_base} .zyre-button-icon > i"   => 'color: {{VALUE}};',
					"{{WRAPPER}} .{$class_base} .zyre-button-icon > svg" => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => $prefix . 'button_icon_background',
				'label'    => esc_html__( 'Background', 'zyre-elementor-addons' ),
				'types'    => [ 'classic', 'gradient' ],
				'exclude'  => [ 'image' ],
				'selector' => "{{WRAPPER}} .{$class_base} .zyre-button-icon",
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			$prefix . 'button_icon_hover_style',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			$prefix . 'button_icon_hover_color',
			[
				'label'     => esc_html__( 'Icon Hover Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					"{{WRAPPER}} .{$class_base}:hover .zyre-button-icon > i, {{WRAPPER}} .{$class_base}:focus .zyre-button-icon > i"     => 'color: {{VALUE}};',
					"{{WRAPPER}} .{$class_base}:hover .zyre-button-icon > svg, {{WRAPPER}} .{$class_base}:focus .zyre-button-icon > svg" => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => $prefix . 'button_icon_hover_background',
				'label'    => esc_html__( 'Background', 'zyre-elementor-addons' ),
				'types'    => [ 'classic', 'gradient' ],
				'exclude'  => [ 'image' ],
				'selector' => "{{WRAPPER}} .{$class_base}:hover .zyre-button-icon, {{WRAPPER}} .{$class_base}:focus .zyre-button-icon",
			]
		);

		$this->add_control(
			$prefix . 'button_icon_border_hover_color',
			[
				'label'     => esc_html__( 'Border Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					$prefix . 'button_icon_border!' => '',
				],
				'selectors' => [
					"{{WRAPPER}} .{$class_base}:hover .zyre-button-icon, {{WRAPPER}} .{$class_base}:focus .zyre-button-icon" => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => $prefix . 'button_icon_border',
				'selector'  => "{{WRAPPER}} .{$class_base} .zyre-button-icon",
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			$prefix . 'button_icon_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					"{{WRAPPER}} .{$class_base} .zyre-button-icon" => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
	}

	/**
	 * Render button widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @param \Elementor\Widget_Base|null $instance
	 *
	 * @access protected
	 */
	protected function render_button( ?Widget_Base $instance = null, $args = [] ) {
		if ( empty( $instance ) ) {
			$instance = $this;
		}

		$default_args = [
			'id_prefix' => '',
		];

		$args = wp_parse_args( $args, $default_args );
		$prefix = ! empty( $args['id_prefix'] ) ? $args['id_prefix'] . '_' : '';

		$settings = $this->get_settings_for_display();

		// Elements
		$button = "{$prefix}button";
		$button_link = "{$prefix}button_link";
		$button_text = "{$prefix}button_text";
		$icon = "{$prefix}icon";
		$button_icon = "{$prefix}button_icon";
		$button_icon_position = "{$prefix}button_icon_position";
		$button_id_attr = "{$prefix}button_id_attr";
		$button_class_attr = "{$prefix}button_class_attr";
		$button_onclick_event = "{$prefix}button_onclick_event";

		$instance->add_render_attribute( $button, 'class', ! empty( $args['id_prefix'] ) ? 'zyre-button zyre-button-' . $args['id_prefix'] : 'zyre-button' );

		$html_tag = 'span';
		if ( ! empty( $settings[ $button_link ]['url'] ) ) {
			$html_tag = 'a';
			$this->add_link_attributes( $button, $settings[ $button_link ] );
			$instance->add_render_attribute( $button, 'class', 'zyre-button-link' );
		}

		$instance->add_inline_editing_attributes( $button_text, 'none' );
		$instance->add_render_attribute( $button_text, 'class', 'zyre-button-text' );
		$instance->add_render_attribute( $icon, 'class', 'zyre-button-icon' );

		$icon_position = ! empty( $settings[ $button_icon_position ] ) ? $settings[ $button_icon_position ] : '';

		if ( ! empty( $settings[ $button_icon ]['value'] ) ) {
			$instance->add_render_attribute( $button, 'class', 'zyre-button-has-icon' );
		}

		$instance->add_render_attribute( $button, 'class', esc_attr( $icon_position ? 'zyre-align-icon-' . $icon_position : '' ) );
		$instance->add_render_attribute( $icon, 'class', esc_attr( $icon_position ? 'zyre-icon-' . $icon_position : '' ) );

		if ( ! empty( $settings[ $button_id_attr ] ) ) {
			$instance->add_render_attribute( $button, 'id', esc_attr( str_replace( ' ', '', $settings[ $button_id_attr ] ) ) );
		}

		if ( ! empty( $settings[ $button_class_attr ] ) ) {
			$instance->add_render_attribute( $button, 'class', esc_attr( $settings[ $button_class_attr ] ) );
		}

		if ( ! empty( $settings[ $button_onclick_event ] ) ) {
			$instance->add_render_attribute( $button, 'onclick', esc_attr( $settings[ $button_onclick_event ] ) );
		}

		if ( ! empty( $settings[ $button_icon ]['value'] ) || $settings[ $button_text ] ) : ?>
			<<?php echo esc_attr( $html_tag ); ?> <?php $instance->print_render_attribute_string( $button ); ?>>
				<span class="zyre-button-inner">
					<?php if ( $settings[ $button_icon ]['value'] ) : ?>
						<span <?php $instance->print_render_attribute_string( $icon ); ?>><?php Icons_Manager::render_icon( $settings[ $button_icon ], [ 'aria-hidden' => 'true' ] ); ?></span>
					<?php endif; ?>

					<?php if ( $settings[ $button_text ] ) : ?>
						<span <?php $instance->print_render_attribute_string( $button_text ); ?>><?php echo esc_html( $settings[ $button_text ] ); ?></span>
					<?php endif; ?>
				</span>
			</<?php echo esc_attr( $html_tag ); ?>>
		<?php endif;
	}
}
