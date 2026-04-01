<?php
namespace VertexMediaLLC\ZyreElementorAddons\Widget;

use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use VertexMediaLLC\ZyreElementorAddons\Controls\Select2;
use VertexMediaLLC\ZyreElementorAddons\Query_Manager;

defined( 'ABSPATH' ) || die();

class Search_Box extends Base {

	public function get_title() {
		return __( 'Search Box', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Search-box';
	}

	public function get_keywords() {
		return [ 'search box', 'search', 'advanced search', 'search filter', 'search form', 'search results' ];
	}

	/**
	 * Register widget content controls
	 */
	protected function register_content_controls() {
		$this->__general_content_controls();
		$this->__search_field_content_controls();
	}

	protected function __general_content_controls() {
		$this->start_controls_section(
			'section_general_content',
			[
				'label' => __( 'General', 'zyre-elementor-addons' ),
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$this->add_control(
			'post_type',
			[
				'label'       => __( 'Select Post Type', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'label_block' => true,
				'options'     => Query_Manager::get_post_types(),
			]
		);

		$this->add_control(
			'terms',
			[
				'label'          => __( 'Include Category', 'zyre-elementor-addons' ),
				'label_block'    => true,
				'type'           => Select2::TYPE,
				'multiple'       => true,
				'select2options' => [
					'minimumInputLength' => 2,
				],
				'dynamic_params' => [
					'object_type'        => 'term',
					'term_taxonomy'      => 'category',
					'select2_dependency' => 'post_type',
				],
			]
		);

		$this->add_control(
			'object_count',
			[
				'label'     => __( 'Show Post Count', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'terms_list_text',
			[
				'label'     => __( 'Category List Text', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'All categories', 'zyre-elementor-addons' ),
			]
		);

		$this->add_responsive_control(
			'layout',
			[
				'label'   => esc_html__( 'Layout', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => '',
				'options' => [
					'inline' => [
						'title' => esc_html__( 'Inline', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-ellipsis-h',
					],
					'block'  => [
						'title' => esc_html__( 'Block', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-editor-list-ul',
					],
				],
				'selectors_dictionary' => [
					'inline' => '-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;-ms-flex-direction:row;flex-direction:row;',
					'block'  => '-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;-ms-flex-direction:column;flex-direction:column;',
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-search-form-inner' => '{{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'terms_position',
			[
				'label'    => __( 'Category Position', 'zyre-elementor-addons' ),
				'type'     => Controls_Manager::CHOOSE,
				'default'  => is_rtl() ? 'after' : 'before',
				'skin'     => 'inline',
				'options'  => [
					'before'  => [
						'title' => __( 'Before', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-top',
					],
					'after' => [
						'title' => __( 'After', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'selectors_dictionary' => [
					'before'  => 'order: 0',
					'after' => 'order: 1',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-search-form-select-wrapper' => '{{VALUE}}',
				],
			]
		);

		$this->add_control(
			'enable_collapsible_search',
			[
				'label'        => esc_html__( 'Enable Collapsible Search', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'enable_floating',
			[
				'label'     => esc_html__( 'Enable Floating', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'enable_collapsible_search' => 'yes',
				],
			]
		);

		$this->add_control(
			'search_field_toggle_icon',
			[
				'label'            => __( 'Toggle Icon', 'zyre-elementor-addons' ),
				'type'             => Controls_Manager::ICONS,
				'default'          => [
					'value'   => 'fas fa-search',
					'library' => 'fa-solid',
				],
				'fa4compatibility' => 'toggle_icon_fa4',
				'label_block'      => false,
				'skin'             => 'inline',
				'condition'        => [
					'enable_collapsible_search' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'search_field_toggle_align',
			[
				'label'       => __( 'Toggle Alignment', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => true,
				'default'     => '',
				'options'     => [
					'flex-start'    => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-justify-start-h',
					],
					'center'        => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-justify-center-h',
					],
					'flex-end'      => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-justify-end-h',
					],
					'space-between' => [
						'title' => esc_html__( 'Space Between', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-justify-space-between-h',
					],
					'space-around'  => [
						'title' => esc_html__( 'Space Around', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-justify-space-around-h',
					],
					'space-evenly'  => [
						'title' => esc_html__( 'Space Evenly', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-justify-space-evenly-h',
					],
				],
				'selectors'   => [
					'{{WRAPPER}} .zyre-search-form-inner' => 'justify-content: {{VALUE}};',
				],
				'condition'   => [
					'enable_collapsible_search' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	public function __search_field_content_controls() {
		$this->start_controls_section(
			'section_search_field_content',
			[
				'label' => __( 'Search Field', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'search_field_placeholder',
			[
				'label'   => __( 'Placeholder Text', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Search..', 'zyre-elementor-addons' ),
				'ai' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'show_search_button',
			[
				'label'        => esc_html__( 'Show Search Button', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'zyre-elementor-addons' ),
				'label_off'    => __( 'Hide', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'search_field_button_text',
			[
				'label'     => __( 'Button Text', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Search', 'zyre-elementor-addons' ),
				'condition' => [
					'show_search_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'search_field_button_icon',
			[
				'label'            => __( 'Button Icon', 'zyre-elementor-addons' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'label_block'      => false,
				'skin'             => 'inline',
				'condition'        => [
					'show_search_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'search_field_button_icon_position',
			[
				'label'    => __( 'Icon Position', 'zyre-elementor-addons' ),
				'type'     => Controls_Manager::CHOOSE,
				'default'  => is_rtl() ? 'left' : 'right',
				'skin'     => 'inline',
				'options'  => [
					'left'  => [
						'title' => __( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => __( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'selectors_dictionary' => [
					'left'  => 'order: 0',
					'right' => 'order: 1',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-search-button-icon' => '{{VALUE}}',
				],
				'condition'            => [
					'show_search_button'               => 'yes',
					'search_field_button_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'search_field_button_position',
			[
				'label'                => __( 'Button Position', 'zyre-elementor-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'default'              => is_rtl() ? 'left' : 'right',
				'skin'                 => 'inline',
				'options'              => [
					'left'  => [
						'title' => __( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => __( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'selectors_dictionary' => [
					'left'  => 'order: -1',
					'right' => 'order: 0',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-search-button' => '{{VALUE}}',
				],
				'condition'            => [
					'show_search_button' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register styles related controls
	 */
	protected function register_style_controls() {
		$this->__search_general_style_controls();
		$this->__category_list_style_controls();
		$this->__search_box_style_controls();
		$this->__search_field_style_controls();
		$this->__search_button_style_controls();
		$this->__toggle_button_style_controls();
	}

	protected function __search_general_style_controls() {
		$this->start_controls_section(
			'section_search_general_style',
			[
				'label' => __( 'General Style', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'general',
			[
				'controls' => [
					'typo'           => [],
					'color'          => [],
					'border'         => [],
					'border_radius'  => [],
					'height'         => [
						'selector' => '{{WRAPPER}} .zyre-search-form-select-wrapper, {{WRAPPER}} .zyre-search-field, {{WRAPPER}} .zyre-search-button, {{WRAPPER}} .zyre-search-toggle',
					],
					'gap'            => [
						'description' => __( 'Space Between Category List & Search Box', 'zyre-elementor-addons' ),
						'selector'    => '{{WRAPPER}} .zyre-search-form-inner',
						'separator'   => 'after',
					],
					'html'           => [
						'raw' => __( 'Apply Box Shadow & Border Color to the Container when the Search Field is focused.', 'zyre-elementor-addons' ),
					],
					'box_shadow'     => [
						'selector' => '{{WRAPPER}}:has(.zyre-search-field:focus) .elementor-widget-container',
					],
					'border_color_2' => [
						'selector' => '{{WRAPPER}}:has(.zyre-search-field:focus) .elementor-widget-container',
					],
				],
				'selector' => '{{WRAPPER}} .zyre-search-form-select, {{WRAPPER}} .zyre-search-field, {{WRAPPER}} .zyre-search-button, {{WRAPPER}} .zyre-search-toggle',
			]
		);

		$this->add_control(
			'general_css_outline',
			[
				'label'     => __( 'Disable Default CSS Outline', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .zyre-search-field, {{WRAPPER}} .zyre-search-form-select, {{WRAPPER}} .zyre-search-button, {{WRAPPER}} .zyre-search-toggle' => 'outline: none;',
				],
			],
		);

		$this->end_controls_section();
	}

	protected function __category_list_style_controls() {
		$this->start_controls_section(
			'section_category_list_style',
			[
				'label'      => __( 'Category List', 'zyre-elementor-addons' ),
				'tab'        => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'category_list',
			[
				'controls' => [
					'typo'           => [],
					'color'          => [],
					'color_2'        => [
						'label'        => __( 'Arrow Color', 'zyre-elementor-addons' ),
						'css_property' => '--arrow-color',
						'selector'     => '{{WRAPPER}} .zyre-search-form-select-wrapper::after',
					],
					'arrow_size'     => [
						'label'        => __( 'Arrow Size', 'zyre-elementor-addons' ),
						'css_property' => '--arrow-size',
						'selector'     => '{{WRAPPER}} .zyre-search-form-select-wrapper::after',
					],
					'max_width'      => [
						'selector'     => '{{WRAPPER}} .zyre-search-form-select-wrapper',
						'css_property' => 'max-width',
					],
					'height'     => [
						'selector'     => '{{WRAPPER}} .zyre-search-form .zyre-search-form-select-wrapper',
					],
					'border'         => [],
					'border_color_2' => [
						'label'     => __( 'Focus Border Color', 'zyre-elementor-addons' ),
						'selector'  => '{{WRAPPER}} .zyre-search-form .zyre-search-form-select:focus',
						'condition' => [
							'category_list_border_border!' => 'none',
						],
					],
					'border_radius'  => [],
					'bg_color'       => [],
					'padding'        => [
						'css_values' => '--padding-top: {{TOP}}{{UNIT}}; --padding-right: {{RIGHT}}{{UNIT}}; --padding-bottom: {{BOTTOM}}{{UNIT}}; --padding-left: {{LEFT}}{{UNIT}};',
						'selector'   => '{{WRAPPER}} .zyre-search-form-select-wrapper',
					],
				],
				'selector' => '{{WRAPPER}} .zyre-search-form .zyre-search-form-select',
			]
		);

		$this->end_controls_section();
	}

	protected function __search_box_style_controls() {
		$this->start_controls_section(
			'section_search_box_style',
			[
				'label' => __( 'Search Box', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$offset_x_prop = is_rtl() ? 'left' : 'right';

		$this->set_style_controls(
			'search_field_search',
			[
				'controls' => [
					'bg_color'        => [],
					'border'          => [],
					'border_radius'   => [],
					'box_shadow'      => [],
					'padding'         => [],
					'gap'             => [
						'description' => __( 'Space Between Search Field & Button', 'zyre-elementor-addons' ),
						'condition' => [
							'show_search_button' => 'yes',
						],
					],
					'offset_y'        => [
						'css_property' => 'top',
						'separator'    => 'before',
						'condition'    => [
							'enable_collapsible_search' => 'yes',
							'enable_floating'           => 'yes',
						],
					],
					'offset_x'        => [
						'css_property' => $offset_x_prop,
						'condition'    => [
							'enable_collapsible_search' => 'yes',
							'enable_floating'           => 'yes',
						],
					],
				],
				'selector' => '{{WRAPPER}} .zyre-search-form-search',
			]
		);

		$this->end_controls_section();
	}

	protected function __search_field_style_controls() {
		$this->start_controls_section(
			'section_search_field_style',
			[
				'label' => __( 'Search Field', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'search_field',
			[
				'controls' => [
					'typo'           => [],
					'color'          => [],
					'color_2'        => [
						'label'    => __( 'Placeholder Color', 'zyre-elementor-addons' ),
						'selector' => '{{WRAPPER}} .zyre-search-field::placeholder, {{WRAPPER}} .zyre-search-field::-webkit-input-placeholder',
					],
					'bg_color'       => [],
					'height'         => [],
					'border'         => [],
					'border_color_2' => [
						'label'     => __( 'Focus Border Color', 'zyre-elementor-addons' ),
						'selector'  => '{{WRAPPER}} .zyre-search-form .zyre-search-field:focus',
						'condition' => [
							'search_field_border_border!' => 'none',
						],
					],
					'border_radius'  => [],
					'padding'        => [],
				],
				'selector' => '{{WRAPPER}} .zyre-search-form .zyre-search-field',
			]
		);

		$this->end_controls_section();
	}

	protected function __search_button_style_controls() {
		$this->start_controls_section(
			'section_search_button_style',
			[
				'label'     => __( 'Search Button', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_search_button' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'search_button',
			[
				'controls' => [
					'typo'          => [],
					'icon_size'     => [
						'selector'  => '{{WRAPPER}} .zyre-search-button-icon',
						'condition' => [
							'search_field_button_icon[value]!' => '',
						],
					],
					'gap'           => [
						'label'     => __( 'Space Between', 'zyre-elementor-addons' ),
						'condition' => [
							'search_field_button_icon[value]!' => '',
							'search_field_button_text!'        => '',
						],
					],
					'width'         => [],
					'height'        => [],
					'border'        => [],
					'border_radius' => [],
					'padding'       => [],
				],
				'selector' => '{{WRAPPER}} .zyre-search-form .zyre-search-button',
			]
		);

		// Start Tabs
		$this->start_controls_tabs( 'search_button_style_tabs' );

		// Tab: Normal
		$this->start_controls_tab(
			'search_button_normal_tab',
			[
				'label' => __( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'search_button',
			[
				'controls' => [
					'color'      => [],
					'icon_color' => [
						'selector' => '{{WRAPPER}} .zyre-search-form .zyre-search-button-icon',
						'condition' => [
							'search_field_button_icon[value]!' => '',
						],
					],
					'bg'         => [],
					'box_shadow' => [],
				],
				'selector' => '{{WRAPPER}} .zyre-search-form .zyre-search-button',
			]
		);

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab(
			'search_button_hover_tab',
			[
				'label' => __( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'search_button_hover',
			[
				'controls' => [
					'color'        => [],
					'icon_color'   => [
						'selectors' => [
							'{{WRAPPER}} .zyre-search-form .zyre-search-button:hover .zyre-search-button-icon i,
							{{WRAPPER}} .zyre-search-form .zyre-search-button:focus .zyre-search-button-icon i'   => 'color: {{VALUE}};',
							'{{WRAPPER}} .zyre-search-form .zyre-search-button:hover .zyre-search-button-icon svg,
							{{WRAPPER}} .zyre-search-form .zyre-search-button:focus .zyre-search-button-icon svg' => 'fill: {{VALUE}};',
						],
						'condition' => [
							'search_field_button_icon[value]!' => '',
						],
					],
					'border_color' => [],
					'bg'           => [],
					'box_shadow'   => [],
				],
				'selector' => '{{WRAPPER}} .zyre-search-form .zyre-search-button:hover, {{WRAPPER}} .zyre-search-form .zyre-search-button:focus',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function __toggle_button_style_controls() {
		$this->start_controls_section(
			'section_toggle_button_style',
			[
				'label'     => __( 'Toggle Button', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'enable_collapsible_search' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'toggle_button',
			[
				'controls' => [
					'icon_size'     => [
						'selector'  => '{{WRAPPER}} .zyre-search-toggle-icon',
						'condition' => [
							'search_field_toggle_icon[value]!' => '',
						],
					],
					'width'         => [],
					'height'        => [],
					'border'        => [],
					'border_radius' => [],
					'padding'       => [],
				],
				'selector' => '{{WRAPPER}} .zyre-search-form .zyre-search-toggle',
			]
		);

		// Start Tabs
		$this->start_controls_tabs( 'toggle_button_style_tabs' );

		// Tab: Normal
		$this->start_controls_tab(
			'toggle_button_normal_tab',
			[
				'label' => __( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'toggle_button',
			[
				'controls' => [
					'icon_color' => [
						'selector'  => '{{WRAPPER}} .zyre-search-toggle-icon',
						'condition' => [
							'search_field_toggle_icon[value]!' => '',
						],
					],
					'bg'         => [],
					'box_shadow' => [],
				],
				'selector' => '{{WRAPPER}} .zyre-search-form .zyre-search-toggle',
			]
		);

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab(
			'toggle_button_hover_tab',
			[
				'label' => __( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'toggle_button_hover',
			[
				'controls' => [
					'icon_color'   => [
						'selectors' => [
							'{{WRAPPER}} .zyre-search-form .zyre-search-toggle:hover .zyre-search-toggle-icon i,
							{{WRAPPER}} .zyre-search-form .zyre-search-toggle:focus .zyre-search-toggle-icon i'   => 'color: {{VALUE}};',
							'{{WRAPPER}} .zyre-search-form .zyre-search-toggle:hover .zyre-search-toggle-icon svg,
							{{WRAPPER}} .zyre-search-form .zyre-search-toggle:focus .zyre-search-toggle-icon svg' => 'fill: {{VALUE}};',
						],
						'condition' => [
							'search_field_toggle_icon[value]!' => '',
						],
					],
					'border_color' => [],
					'bg'           => [],
					'box_shadow'   => [],
				],
				'selector' => '{{WRAPPER}} .zyre-search-form .zyre-search-toggle:hover, {{WRAPPER}} .zyre-search-form .zyre-search-toggle:focus',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Register render display controls
	 */
	protected function render() {
		$settings 	= $this->get_settings_for_display();

		$this->add_render_attribute(
			'search_form',
			[
				'method' => 'get',
				'action' => esc_url( home_url( '/' ) ),
				'id'     => 'zyre-search-form-' . $this->get_id(),
				'class'  => 'zyre-search-form',
			]
		);

		$this->add_render_attribute(
			'search_field',
			[
				'type'        => 'search',
				'placeholder' => esc_attr( $settings['search_field_placeholder'] ),
				'class'       => 'zyre-search-field',
				'value'       => esc_attr( get_search_query() ),
				'name'        => 's',
			]
		);

		$this->add_render_attribute(
			'search_form_search',
			[
				'class' => 'zyre-search-form-search zy-inline-flex zy-grow-1 zy-w-100',
			]
		);

		if ( 'yes' === $settings['enable_collapsible_search'] ) {
			$this->add_render_attribute( 'search_form', 'class', 'collapsible' );
			$this->add_render_attribute( 'search_form_search', 'style', 'display: none;' );
		}

		if ( 'yes' === $settings['enable_floating'] ) {
			$position_class = is_rtl() ? ' zy-left-0' : ' zy-right-0';
			$this->add_render_attribute( 'search_form_search', 'class', 'zy-absolute zy-top-100 zy-index-2' . $position_class );
		}
		?>

		<div class="zyre-search-wrapper">
			<form <?php $this->print_render_attribute_string( 'search_form' ); ?>>
				<div class="zyre-search-form-inner zy-flex zy-relative">
					<?php $this->render_terms_list(); ?>
					<div <?php $this->print_render_attribute_string( 'search_form_search' ); ?>>
						<input <?php $this->print_render_attribute_string( 'search_field' ); ?>>
						<?php $this->render_button(); ?>
					</div>
					<?php $this->render_toggle(); ?>
				</div>
				<input type="hidden" id="post-types" value="">
			</form>
		</div>
		<?php
	}

	protected function render_button() {
		$settings 	= $this->get_settings_for_display();

		if ( 'yes' !== $settings['show_search_button'] ) {
			return;
		}

		if ( empty( $settings['search_field_button_text'] ) && empty( $settings['search_field_button_icon']['value'] ) ) {
			return;
		}

		$this->add_render_attribute(
			'search_button',
			[
				'type'  => 'submit',
				'class' => 'zyre-search-button zy-inline-flex zy-align-center zy-justify-center zy-gap-1',
			]
		);

		$migrated = isset( $settings['__fa4_migrated']['search_field_button_icon'] );
		$is_new = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

		?>
		<button <?php $this->print_render_attribute_string( 'search_button' ); ?>>
			<?php if ( ! empty( $settings['icon'] ) || ! empty( $settings['search_field_button_icon']['value'] ) ) : ?>
				<span class="zyre-search-button-icon">
					<?php if ( $is_new || $migrated ) :
						Icons_Manager::render_icon( $settings['search_field_button_icon'], [ 'aria-hidden' => 'true' ] );
					else : ?>
						<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
					<?php endif; ?>
				</span>
			<?php endif; ?>
			<?php if ( ! empty( $settings['search_field_button_text'] ) ) : ?>
				<span class="zyre-search-button-text"><?php echo esc_html( $settings[ 'search_field_button_text' ] ); ?></span>
			<?php endif; ?>
		</button>
		<?php
	}

	protected function render_toggle() {
		$settings 	= $this->get_settings_for_display();

		if ( 'yes' !== $settings['enable_collapsible_search'] ) {
			return;
		}

		$this->add_render_attribute(
			'search_toggle',
			[
				'type'  => 'button',
				'class' => 'zyre-search-toggle zy-inline-flex zy-align-center zy-justify-center zy-gap-1',
			]
		);

		$migrated = isset( $settings['__fa4_migrated']['search_field_toggle_icon'] );
		$is_new = empty( $settings['toggle_icon_fa4'] ) && Icons_Manager::is_migration_allowed();

		?>
		<button <?php $this->print_render_attribute_string( 'search_toggle' ); ?>>
			<?php if ( ! empty( $settings['toggle_icon_fa4'] ) || ! empty( $settings['search_field_toggle_icon']['value'] ) ) : ?>
				<span class="zyre-search-toggle-icon">
					<?php if ( $is_new || $migrated ) :
						Icons_Manager::render_icon( $settings['search_field_toggle_icon'], [ 'aria-hidden' => 'true' ] );
					else : ?>
						<i class="<?php echo esc_attr( $settings['toggle_icon_fa4'] ); ?>" aria-hidden="true"></i>
					<?php endif; ?>
				</span>
			<?php endif; ?>
		</button>
		<?php
	}

	protected function render_terms_list() {
		$settings 	= $this->get_settings_for_display();

		if ( empty( $settings['terms'] ) ) {
			return;
		}

		$show_object_count = $settings['object_count'] === 'yes';

		$this->add_render_attribute( 'search_form_select_wrapper', 'class', 'zyre-search-form-select-wrapper zy-grow-1 zy-w-100' );
		$this->add_render_attribute( 'search_form_select', 'class', 'zyre-search-form-select zy-w-100 zy-h-100' );

		$terms_list = zyreladdons_sanitize_array_recursively( wp_unslash( $settings['terms'] ) );
		?>

		<div <?php $this->print_render_attribute_string( 'search_form_select_wrapper' ); ?>>
			<select <?php $this->print_render_attribute_string( 'search_form_select' ); ?>>
				<?php if ( ! empty( $settings['terms_list_text'] ) ) : ?>
					<option value=""><?php echo esc_html( $settings['terms_list_text'] ); ?></option>
				<?php endif;
				foreach( $terms_list as $term_id ) {
					$term = get_term( $term_id );
					if ( ! is_wp_error( $term ) ) {
						$term_name = $term->name;
						if ( $show_object_count ) {
							$term_name .= " ($term->count)";
						}
						$taxonomy = get_taxonomy( $term->taxonomy );
						?>
						<option value="<?php echo esc_attr( $term->term_id ); ?>" data-post_type="<?php echo esc_attr( implode( ',', $taxonomy->object_type ) ); ?>"><?php echo esc_html( $term_name ); ?></option>
						<?php
					}
				}
				?>
			</select>
		</div>
		<?php
	}
}
