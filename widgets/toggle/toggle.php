<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use Elementor\Repeater;

defined( 'ABSPATH' ) || die();

class Toggle extends Base {

	public function get_title() {
		return esc_html__( 'Toggle', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Toggle';
	}

	public function get_keywords() {
		return [ 'toggle', 'toggle content', 'switch', 'switcher', 'content switcher', 'toggle button' ];
	}

	public function select_elementor_page( $type ) {
		$args  = [
			'tax_query'      => [
				[
					'taxonomy' => 'elementor_library_type',
					'field'    => 'slug',
					'terms'    => $type,
				],
			],
			'post_type'      => 'elementor_library',
			'posts_per_page' => -1,
		];
		$query = new \WP_Query( $args );

		$posts = $query->posts;
		foreach ( $posts as $post ) {
			$items[ $post->ID ] = $post->post_title;
		}

		if ( empty( $items ) ) {
			$items = [];
		}

		return $items;
	}

	protected function register_content_controls() {
		$this->start_controls_section(
			'section_toggle_content',
			[
				'label' => esc_html__( 'Toggle Content', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$this->add_control(
			'toggle_type',
			[
				'label'   => esc_html__( 'Toggle Type', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'switch'    => esc_html__( 'Switch', 'zyre-elementor-addons' ),
					'button'   => esc_html__( 'Button', 'zyre-elementor-addons' ),
				],
				'default' => 'switch',
			]
		);

		$this->add_control(
			'toggle_warning_message',
			[
				'raw'             => '<strong>' . esc_html__( 'Please note!', 'zyre-elementor-addons' ) . '</strong> ' . esc_html__( 'only the first two items are applicable to this toggle type.', 'zyre-elementor-addons' ),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
				'render_type'     => 'ui',
				'condition'       => [
					'toggle_type!' => 'button',
				],
			]
		);

		$this->add_control(
			'__heading_controls_text',
			[
				'label'     => esc_html__( 'Controls Text', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::HEADING,
				'condition'       => [
					'toggle_type!' => 'button',
				],
			]
		);

		$this->add_control(
			'active_text',
			[
				'label'   => esc_html__( 'Active Text', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::TEXT,
				'condition'       => [
					'toggle_type!' => 'button',
				],
				'ai' => false,
			]
		);

		$this->add_control(
			'inactive_text',
			[
				'label'   => esc_html__( 'Inactive Text', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::TEXT,
				'condition'       => [
					'toggle_type!' => 'button',
				],
				'ai' => false,
			]
		);

		$this->add_control(
			'above_switcher_btn',
			[
				'label'        => esc_html__( 'Show text above the switcher', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'YES', 'zyre-elementor-addons' ),
				'label_off'    => esc_html__( 'NO', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'separator'    => 'after',
				'render_type'  => 'template',
				'condition'    => [
					'toggle_type!' => 'button',
				],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'title',
			[
				'label'   => esc_html__( 'Title', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Title', 'zyre-elementor-addons' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'content_type',
			[
				'label'   => esc_html__( 'Type', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'plain_content' => esc_html__( 'Plain/ HTML Text', 'zyre-elementor-addons' ),
					'saved_section' => esc_html__( 'Saved Section', 'zyre-elementor-addons' ),
					'saved_container' => esc_html__( 'Saved Container', 'zyre-elementor-addons' ),
					'saved_page'    => esc_html__( 'Saved Page', 'zyre-elementor-addons' ),
				],
				'default' => 'plain_content',
			]
		);

		$repeater->add_control(
			'plain_content',
			[
				'label'       => esc_html__( 'Plain/ HTML Text', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXTAREA,
				'description' => zyre_get_allowed_html_desc( 'intermediate' ),
				'rows'        => 16,
				'condition'   => [
					'content_type' => 'plain_content',
				],
				'dynamic'     => [
					'active' => true,
				],
				'default'     => esc_html__( 'Add some content here.', 'zyre-elementor-addons' ),
			]
		);

		$saved_sections = [ '0' => esc_html__( '--- Select Section ---', 'zyre-elementor-addons' ) ];
		$saved_sections = $saved_sections + $this->select_elementor_page( 'section' );

		$repeater->add_control(
			'saved_section',
			[
				'label'     => esc_html__( 'Sections', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => $saved_sections,
				'default'   => '0',
				'condition' => [
					'content_type' => 'saved_section',
				],
			]
		);

		$saved_container = [ '0' => esc_html__( '--- Select Container ---', 'zyre-elementor-addons' ) ];
		$saved_container = $saved_container + $this->select_elementor_page( 'container' );

		$repeater->add_control(
			'saved_container',
			[
				'label'     => esc_html__( 'Container', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => $saved_container,
				'default'   => '0',
				'condition' => [
					'content_type' => 'saved_container',
				],
			]
		);

		$saved_page = [ '0' => esc_html__( '--- Select Page ---', 'zyre-elementor-addons' ) ];
		$saved_page = $saved_page + $this->select_elementor_page( 'page' );

		$repeater->add_control(
			'saved_pages',
			[
				'label'     => esc_html__( 'Pages', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => $saved_page,
				'default'   => '0',
				'condition' => [
					'content_type' => 'saved_page',
				],
			]
		);

		$repeater->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'zyre-elementor-addons' ),
				'type'  => Controls_Manager::ICONS,
			]
		);

		$repeater->add_control(
			'icon_align',
			[
				'label'                => esc_html__( 'Icon Position', 'zyre-elementor-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'left'  => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'selectors_dictionary' => [
					'left'  => '-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;-ms-flex-direction:row;flex-direction:row;',
					'right' => '-webkit-box-orient:horizontal;-webkit-box-direction:reverse;-webkit-flex-direction:row-reverse;-ms-flex-direction:row-reverse;flex-direction:row-reverse;',
				],
				'selectors'            => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '{{VALUE}}',
				],
			]
		);

		$repeater->add_control(
			'active',
			[
				'label'        => esc_html__( 'Active', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Active on Load', 'zyre-elementor-addons' ),
				'label_on'     => esc_html__( 'Yes', 'zyre-elementor-addons' ),
				'label_off'    => esc_html__( 'No', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'content_list',
			[
				'label'         => esc_html__( 'Contents', 'zyre-elementor-addons' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [
					[
						'title'         => '',
						'content_type'  => 'plain_content',
						'plain_content' => esc_html__( 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Incidunt, natus! Facere suscipit doloremque, ea animi debitis quas nihil beatae nobis autem cupiditate sequi doloribus voluptate magnam ipsum provident magni officiis exercitationem aliquam. Iure, minima id consectetur recusandae laudantium nam aperiam delectus. Temporibus optio doloremque nesciunt rerum atque fugit cumque aspernatur excepturi odio minus earum sunt deleniti iste magnam eum nam voluptates porro dolores autem fuga, ad, nobis in minima quod.', 'zyre-elementor-addons' ),
						'active'        => 'yes',
					],
					[
						'title'         => '',
						'content_type'  => 'plain_content',
						'plain_content' => esc_html__( 'Non possimus cumque consequuntur sunt est alias quae nisi voluptas dolorum nesciunt iste maiores deserunt dignissimos placeat pariatur, vitae molestias numquam, porro natus, magnam officiis nostrum sint? Amet, et porro minus corporis, asperiores labore, molestiae culpa pariatur alias expedita ea voluptatem hic? Mollitia culpa odio sequi dolore nesciunt recusandae accusantium rerum harum praesentium eos est explicabo debitis rem, iusto, iure pariatur quaerat enim? Fugiat rem, exercitationem ipsa deleniti eius libero, itaque quia, porro eaque minima quibusdam? Hic quaerat blanditiis similique aliquam corrupti eos nemo molestiae dicta tempora.', 'zyre-elementor-addons' ),
					],
				],
				'title_field'   => '{{{ title }}}',
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_controls() {
		$this->__togglebar_style_controls();
		$this->__togglebar_inner_style_controls();
		$this->__toggle_text_style_controls();
		$this->__toggle_button_style_controls();
		$this->__switch_style_controls();
		$this->__switch_handle_style_controls();
		$this->__switch_handle_text_style_controls();
		$this->__toggle_content_style_controls();
	}

	protected function __togglebar_style_controls() {

		$this->start_controls_section(
			'_section_togglebar_style',
			[
				'label' => esc_html__( 'Toggle Bar', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'toggle',
			[
				'selector' => '{{WRAPPER}} .zyre-toggle-switch-container',
				'controls' => [
					'align_x' => [
						'label'   => esc_html__( 'Toggle Alignment', 'zyre-elementor-addons' ),
						'options' => [
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
					],
					'space'   => [
						'label'        => esc_html__( 'Space Between', 'zyre-elementor-addons' ),
						'description'  => __( 'Set Space between toggle bar and content section', 'zyre-elementor-addons' ),
						'css_property' => 'margin-bottom',
					],
				],
			]
		);

		$this->common_style_controls( 'switch_container', '.zyre-toggle-switch-container' );

		$this->set_style_controls(
			'switch_container',
			[
				'selector' => '{{WRAPPER}} .zyre-toggle-switch-container',
				'controls' => [
					'border_radius' => [],
					'padding'       => [],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __togglebar_inner_style_controls() {

		$this->start_controls_section(
			'_section_togglebar_inner_style',
			[
				'label' => esc_html__( 'Toggle Bar Inner', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'toggle',
			[
				'selector' => '{{WRAPPER}} .zyre-toggle-switch-wrapper',
				'controls' => [
					'direction' => [
						'label' => esc_html__( 'Switch Direction', 'zyre-elementor-addons' ),
					],
					'gap'       => [
						'label'       => esc_html__( 'Space Between', 'zyre-elementor-addons' ),
						'description' => esc_html__( 'Set Space between toggles', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->common_style_controls( 'switch_wrapper', '.zyre-toggle-switch-wrapper' );

		$this->set_style_controls(
			'switch_wrapper',
			[
				'selector' => '{{WRAPPER}} .zyre-toggle-switch-wrapper',
				'controls' => [
					'border_radius' => [],
					'padding'       => [],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __toggle_text_style_controls() {
		$this->start_controls_section(
			'_section_switch_text_style',
			[
				'label' => esc_html__( 'Toggle Text', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'       => [
					'toggle_type!' => 'button',
				],
			]
		);

		$this->set_style_controls(
			'switch_text',
			[
				'selector' => '{{WRAPPER}} .zyre-toggle-switch-text',
				'controls' => [
					'typo' => [],
				],
			]
		);

		$this->add_control(
			'switch_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-toggle-switch-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-toggle-switch-text svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'switch_text_active_color',
			[
				'label'     => esc_html__( 'Active Text Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-toggle-switch-text.active' => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-toggle-switch-text.active svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'switch_icon_size',
			[
				'label'       => esc_html__( 'Icon Size', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px', 'em' ],
				'range'       => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
					],
					'em'  => [
						'min' => 0.2,
						'step' => 0.1,
						'max' => 5,
					],
				],
				'selectors'   => [
					'{{WRAPPER}} .zyre-toggle-switch-text .zyre-toggle-icon-wrapper' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'switch_text_gap',
			[
				'label'       => esc_html__( 'Space Between', 'zyre-elementor-addons' ),
				'description' => esc_html__( 'Set Space between icon & text', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px', '%' ],
				'range'       => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'   => [
					'{{WRAPPER}} .zyre-toggle-switch-text' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __toggle_button_style_controls() {
		$this->start_controls_section(
			'_section_toggle_button_style',
			[
				'label' => esc_html__( 'Toggle Button', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'       => [
					'toggle_type' => 'button',
				],
			]
		);

		$this->set_style_controls(
			'toggle_button',
			[
				'selector' => '{{WRAPPER}} .zyre-toggle-switch-button',
				'controls' => [
					'typo'      => [],
					'icon_size' => [
						'selector' => '{{WRAPPER}} .zyre-toggle-switch-button .zyre-toggle-switch-icon-wrapper',
					],
				],
			]
		);

		// Tabs
		$this->start_controls_tabs( 'tabs_toggle_button' );

		// Tab: Normal
		$this->start_controls_tab(
			'tab_toggle_button_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'toggle_button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-toggle-switch-button'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-toggle-switch-button svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->common_style_controls( 'toggle_button', '.zyre-toggle-switch-button' );

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab(
			'tab_toggle_button_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'toggle_button_text_color_hover',
			[
				'label'     => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-toggle-switch-button:hover'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-toggle-switch-button:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->common_style_controls( 'toggle_button_hover', '.zyre-toggle-switch-button:not(.active):hover' );

		$this->end_controls_tab();

		// Tab: Active
		$this->start_controls_tab(
			'tab_toggle_button_active',
			[
				'label' => esc_html__( 'Active', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'toggle_button_text_color_active',
			[
				'label'     => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-toggle-switch-button.active'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-toggle-switch-button.active svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->common_style_controls( 'toggle_button_active', '.zyre-toggle-switch-button.active' );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->set_style_controls(
			'toggle_button',
			[
				'selector' => '{{WRAPPER}} .zyre-toggle-switch-button',
				'controls' => [
					'border_radius' => [
						'separator' => 'before',
					],
					'width'         => [],
					'height'        => [],
					'padding'       => [],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __switch_style_controls() {
		$this->start_controls_section(
			'_section_control_style',
			[
				'label' => esc_html__( 'Switch', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'       => [
					'toggle_type!' => 'button',
				],
			]
		);

		$this->set_style_controls(
			'control',
			[
				'selector' => '{{WRAPPER}} .zyre-toggle-input-label',
				'controls' => [
					'width'  => [],
					'height' => [],
				],
			]
		);

		// Tabs
		$this->start_controls_tabs( 'tabs_switch_control' );

		// Tab: Normal
		$this->start_controls_tab(
			'tab_switch_control_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->common_style_controls( 'switch_control', '.zyre-toggle-switch-control' );

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab(
			'tab_switch_control_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->common_style_controls( 'switch_control_hover', '.zyre-toggle-switch-control:hover' );

		$this->end_controls_tab();

		// Tab: Active
		$this->start_controls_tab(
			'tab_switch_control_active',
			[
				'label' => esc_html__( 'Active', 'zyre-elementor-addons' ),
			]
		);

		$this->common_style_controls( 'switch_control_active', '.zyre-toggle-switch-input:checked + .zyre-toggle-switch-control' );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'switch_control_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .zyre-toggle-switch-control' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->end_controls_section();
	}

	protected function __switch_handle_style_controls() {
		$this->start_controls_section(
			'_section_control_button_style',
			[
				'label' => esc_html__( 'Switch Handle', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'       => [
					'toggle_type!' => 'button',
				],
			]
		);

		$this->set_style_controls(
			'control_btn',
			[
				'selector' => '{{WRAPPER}} .zyre-toggle-switch-control::before',
				'controls' => [
					'width'  => [],
					'height' => [],
				],
			]
		);

		$this->add_control(
			'control_btn_position_x',
			[
				'label'      => esc_html__( 'Horizontal Position', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-toggle-switch-control::before' => '--horizontal-position: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'control_btn_position_y',
			[
				'label'      => esc_html__( 'Vertical Position', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-toggle-switch-control::before' => '--vertical-position: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Tabs
		$this->start_controls_tabs( 'tabs_switch_control_btn' );

		// Tab: Normal
		$this->start_controls_tab(
			'tab_switch_control_btn_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->common_style_controls( 'switch_control_btn', '.zyre-toggle-switch-control::before' );

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab(
			'tab_switch_control_btn_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->common_style_controls( 'switch_control_btn_hover', '.zyre-toggle-switch-control:hover::before' );

		$this->end_controls_tab();

		// Tab: Active
		$this->start_controls_tab(
			'tab_switch_control_btn_active',
			[
				'label' => esc_html__( 'Active', 'zyre-elementor-addons' ),
			]
		);

		$this->common_style_controls( 'switch_control_btn_active', '.zyre-toggle-switch-input:checked + .zyre-toggle-switch-control::before' );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'switch_control_btn_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .zyre-toggle-switch-control::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'switch_control_btn_trans_duration',
			[
				'label'       => esc_html__( 'Transition Duration', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Set Transition Duration in Millisecond', 'zyre-elementor-addons' ),
				'min'         => 0,
				'max'         => 3000,
				'step'        => 50,
				'selectors'   => [
					'{{WRAPPER}} .zyre-toggle-switch-control::before' => '--transition-duration: {{VALUE}}ms',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __switch_handle_text_style_controls() {
		$this->start_controls_section(
			'_section_switcher_text_style',
			[
				'label' => esc_html__( 'Switch Handle Text', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'       => [
					'toggle_type!' => 'button',
				],
			]
		);

		$this->set_style_controls(
			'switcher_text',
			[
				'selector' => '{{WRAPPER}} .zyre-toggle-switch-control::after',
				'controls' => [
					'typo'  => [],
					'color' => [
						'label'    => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
						'selector' => '{{WRAPPER}} .zyre-toggle-switch-input:not(:checked) + .zyre-toggle-switch-control::after,
								{{WRAPPER}} .zyre-toggle-switch-input:not(:checked) + .zyre-toggle-switch-control::before',
					],
				],
			]
		);

		$this->add_control(
			'switcher_text_hover_color',
			[
				'label'     => esc_html__( 'Hover Text Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-toggle-switch-input:not(:checked) + .zyre-toggle-switch-control:hover::after, {{WRAPPER}} .zyre-toggle-switch-input:not(:checked) + .zyre-toggle-switch-control:hover::before' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'switcher_text_active_color',
			[
				'label'     => esc_html__( 'Active Text Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-toggle-switch-input:checked + .zyre-toggle-switch-control::after, {{WRAPPER}} .zyre-toggle-switch-input:checked + .zyre-toggle-switch-control::before' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __toggle_content_style_controls() {

		$this->start_controls_section(
			'_section_content_style',
			[
				'label' => esc_html__( 'Content', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'content',
			[
				'selector' => '{{WRAPPER}} .zyre-toggle-content-container .zyre-toggle-content-wrapper .zyre-toggle-content-section',
				'controls' => [
					'typo'  => [],
					'color' => [
						'label' => __( 'Text Color', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->common_style_controls( 'toggle_content', '.zyre-toggle-content-wrapper' );

		$this->set_style_controls(
			'content',
			[
				'selector' => '{{WRAPPER}} .zyre-toggle-content-wrapper',
				'controls' => [
					'border_radius' => [],
					'padding'       => [],
					'align'         => [
						'label' => esc_html__( 'Toggle Alignment', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Common Style Controls.
	 *
	 * @param string $prefix The prefix of the controls.
	 * @param string $selector HTML selector of the elements.
	 */
	private function common_style_controls( string $prefix, $selector ) {
		$this->set_style_controls(
			$prefix,
			[
				'selector' => '{{WRAPPER}} ' . $selector,
				'controls' => [
					'background' => [],
					'border'     => [],
					'box_shadow' => [],
				],
			]
		);
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$primary   = ( isset( $settings['content_list'][0] ) ? $settings['content_list'][0] : '' );
		$secondary = ( isset( $settings['content_list'][1] ) ? $settings['content_list'][1] : '' );

		$above_switcher_class = ( ! empty( $settings['above_switcher_btn'] ) && 'yes' === $settings['above_switcher_btn'] ) ? 'text-above-switcher-button' : '';

		?>
		<div class="zyre-toggle-wrapper zyre-toggle-switch-type-<?php echo esc_attr( $settings['toggle_type'] ); ?>" data-toggle-type="<?php echo esc_attr( $settings['toggle_type'] ); ?>">
			<div class="zyre-toggle-switch-container zy-flex">
				<div class="zyre-toggle-switch-wrapper zy-inline-flex zy-align-center zy-justify-center zy-gap-4">
					<?php if ( 'button' === $settings['toggle_type'] ) : ?>
						<?php foreach ( $settings['content_list'] as $i => $item ) : ?>
							<button class="zyre-toggle-switch-button zy-flex zy-align-center zy-justify-center zy-nowrap zy-gap-1 zy-outline-none zy-shadow-none zy-bg-white zy-lh-normal <?php echo esc_attr( ( 'yes' === $item['active'] ) ? 'active' : '' ); ?> zyre-toggle-switch-icon-<?php echo esc_attr( $item['icon_align'] ); ?> elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>" data-content-id="<?php echo esc_attr( $item['_id'] ); ?>">
								<?php if ( ! empty( $item['icon']['value'] ) ) : ?>
									<div class="zyre-toggle-switch-icon-wrapper"><?php zyre_render_icon( $item, null, 'icon' ); ?></div>
								<?php endif; ?>
								<span><?php echo esc_html( $item['title'] ); ?></span>
							</button>
						<?php endforeach; ?>
						<?php
					else :
						?>
						<div class="zyre-toggle-switch-text zyre-toggle-switch-text-primary zy-flex zy-align-center zy-justify-center zy-nowrap zy-gap-1 <?php echo esc_attr( ( 'yes' === $primary['active'] ) ? 'active' : '' ); ?> elementor-repeater-item-<?php echo esc_attr( $primary['_id'] ); ?>" data-content-id="<?php echo esc_attr( $primary['_id'] ); ?>">
							<?php if ( ! empty( $primary['icon']['value'] ) ) : ?>
								<div class="zyre-toggle-icon-wrapper"><?php zyre_render_icon( $primary, null, 'icon' ); ?></div>
							<?php endif; ?>
							<span><?php echo esc_html( $primary['title'] ); ?></span>
						</div>

						<label class="zyre-toggle-input-label zy-relative">
							<input class="zyre-toggle-switch-input zy-w-0 zy-h-0 zy-opacity-0" type="checkbox" <?php echo esc_attr( ( 'yes' === $secondary['active'] ) ? 'checked' : '' ); ?>>
							<span class="zyre-toggle-switch-control zy-absolute zy-c-pointer zy-top-0 zy-left-0 zy-right-0 zy-bottom-0 zy-flex zy-align-center zy-justify-center <?php echo esc_attr( $above_switcher_class ); ?>" data-active_text="<?php echo ! empty( $settings['active_text'] ) ? esc_attr( $settings['active_text'] ) : ''; ?>" data-inactive_text="<?php echo ! empty( $settings['inactive_text'] ) ? esc_attr( $settings['inactive_text'] ) : ''; ?>"></span>
						</label>

						<div class="zyre-toggle-switch-text zyre-toggle-switch-text-secondary zy-flex zy-align-center zy-justify-center zy-nowrap zy-gap-1 <?php echo esc_attr( ( 'yes' === $secondary['active'] ) ? 'active' : '' ); ?> elementor-repeater-item-<?php echo esc_attr( $secondary['_id'] ); ?>" data-content-id="<?php echo esc_attr( $secondary['_id'] ); ?>">
							<?php if ( ! empty( $secondary['icon']['value'] ) ) : ?>
								<div class="zyre-toggle-icon-wrapper"><?php zyre_render_icon( $secondary, null, 'icon' ); ?></div>
							<?php endif; ?>
							<span><?php echo esc_html( $secondary['title'] ); ?></span>
						</div>
					<?php endif; ?>
				</div>
			</div>

			<div class="zyre-toggle-content-container">
				<div class="zyre-toggle-content-wrapper">
					<?php if ( 'button' === $settings['toggle_type'] ) : ?>
						<?php foreach ( $settings['content_list'] as $i => $item ) : ?>
							<div id="<?php echo esc_attr( $item['_id'] ); ?>" class="zyre-toggle-content-section <?php echo esc_attr( ( 'yes' === $item['active'] ) ? 'active' : '' ); ?>">
								<?php
								if ( 'plain_content' === $item['content_type'] ) {
									echo zyre_kses_advanced( $item['plain_content'] );
								} elseif ( 'saved_section' === $item['content_type'] && 'publish' === get_post_status( $item['saved_section'] ) ) {
									$item['saved_section'] = apply_filters( 'wpml_object_id', $item['saved_section'], 'elementor_library' );
									echo zyre_elementor()->frontend->get_builder_content_for_display( $item['saved_section'] );
								} elseif ( 'saved_container' === $item['content_type'] && 'publish' === get_post_status( $item['saved_container'] ) ) {
									$item['saved_container'] = apply_filters( 'wpml_object_id', $item['saved_container'], 'elementor_library' );
									echo zyre_elementor()->frontend->get_builder_content_for_display( $item['saved_container'] );
								} elseif ( 'saved_page' === $item['content_type'] && 'publish' === get_post_status( $item['saved_pages'] ) ) {
									$item['saved_pages'] = apply_filters( 'wpml_object_id', $item['saved_pages'], 'elementor_library' );
									echo zyre_elementor()->frontend->get_builder_content_for_display( $item['saved_pages'] );
								}
								?>
							</div>
						<?php endforeach; ?>
						<?php
					else :
						?>
						<div id="<?php echo esc_attr( $primary['_id'] ); ?>" class="zyre-toggle-content-section zyre-toggle-content-primary <?php echo esc_attr( ( 'yes' === $primary['active'] ) ? 'active' : '' ); ?>">
							<?php
							if ( 'plain_content' === $primary['content_type'] ) {
								echo zyre_kses_advanced( $primary['plain_content'] );
							} elseif ( 'saved_section' === $primary['content_type'] && 'publish' === get_post_status( $primary['saved_section'] ) ) {
								$primary['saved_section'] = apply_filters( 'wpml_object_id', $primary['saved_section'], 'elementor_library' );
								echo zyre_elementor()->frontend->get_builder_content_for_display( $primary['saved_section'] );
							} elseif ( 'saved_container' === $primary['content_type'] && 'publish' === get_post_status( $primary['saved_container'] ) ) {
								$primary['saved_container'] = apply_filters( 'wpml_object_id', $primary['saved_container'], 'elementor_library' );
								echo zyre_elementor()->frontend->get_builder_content_for_display( $primary['saved_container'] );
							} elseif ( 'saved_page' === $primary['content_type'] && 'publish' === get_post_status( $primary['saved_pages'] ) ) {
								$primary['saved_pages'] = apply_filters( 'wpml_object_id', $primary['saved_pages'], 'elementor_library' );
								echo zyre_elementor()->frontend->get_builder_content_for_display( $primary['saved_pages'] );
							}
							?>
						</div>

						<div id="<?php echo esc_attr( $secondary['_id'] ); ?>" class="zyre-toggle-content-section zyre-toggle-content-secondary <?php echo esc_attr( ( 'yes' === $secondary['active'] ) ? 'active' : '' ); ?>">
							<?php
							if ( 'plain_content' === $secondary['content_type'] ) {
								echo zyre_kses_advanced( $secondary['plain_content'] );
							} elseif ( 'saved_section' === $secondary['content_type'] && 'publish' === get_post_status( $secondary['saved_section'] ) ) {
								$secondary['saved_section'] = apply_filters( 'wpml_object_id', $secondary['saved_section'], 'elementor_library' );
								echo zyre_elementor()->frontend->get_builder_content_for_display( $secondary['saved_section'] );
							} elseif ( 'saved_container' === $secondary['content_type'] && 'publish' === get_post_status( $secondary['saved_container'] ) ) {
								$secondary['saved_container'] = apply_filters( 'wpml_object_id', $secondary['saved_container'], 'elementor_library' );
								echo zyre_elementor()->frontend->get_builder_content_for_display( $secondary['saved_container'] );
							} elseif ( 'saved_page' === $secondary['content_type'] && 'publish' === get_post_status( $secondary['saved_pages'] ) ) {
								$secondary['saved_pages'] = apply_filters( 'wpml_object_id', $secondary['saved_pages'], 'elementor_library' );
								echo zyre_elementor()->frontend->get_builder_content_for_display( $secondary['saved_pages'] );
							}
							?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
	}
}
