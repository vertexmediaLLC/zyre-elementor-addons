<?php

namespace VertexMediaLLC\ZyreElementorAddons\Widget;

use Elementor\Controls_Manager;

defined( 'ABSPATH' ) || die();

class Mega_Menu extends Base {

	public function get_title() {
		return esc_html__( 'Mega Menu', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Mega-menu';
	}

	public function get_keywords() {
		return [ 'menu', 'mega menu', 'nav', 'header', 'navigation', 'nav menu', 'navigation menu', 'header menu', 'horizontal menu', 'horizontal navigation', 'vertical menu', 'vertical navigation', 'hamburger menu', 'mobile menu', 'responsive menu' ];
	}

	public function get_style_depends() {
		return [ 'zyreladdons-mega-menu' ];
	}

	/**
	 * Get a list of all Navigation Menu
	 *
	 * @return array
	 */
	public function get_menus() {
		$menus = wp_get_nav_menus();

		$list  = [];
		foreach ( $menus as $menu ) {
			$list[ $menu->slug ] = $menu->name;
		}

		return $list;
	}

	/**
	 * Register widget content controls
	 */
	protected function register_content_controls() {
		$this->start_controls_section(
			'section_menu_content',
			[
				'label' => esc_html__( 'Mega Menu Settings', 'zyre-elementor-addons' ),
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$this->add_control(
			'menu_list',
			[
				'label'   => esc_html__( 'Select menu', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $this->get_menus(),
			]
		);

		$this->add_control(
			'menu_layout',
			[
				'label'   => esc_html__( 'Layout', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'hr',
				'options' => [
					'hr' => esc_html__( 'Horizontal', 'zyre-elementor-addons' ),
					'vr' => esc_html__( 'Vertical', 'zyre-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'submenu_position',
			[
				'label'     => esc_html__( 'Submenu Position', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'pos_rel',
				'options'   => [
					'pos_rel' => esc_html__( 'Relative', 'zyre-elementor-addons' ),
					'pos_top' => esc_html__( 'Very Top', 'zyre-elementor-addons' ),
				],
				'condition' => [
					'menu_layout' => 'vr',
				],
			]
		);

		$this->add_control(
			'submenu_y_h',
			[
				'label'     => esc_html__( 'Submenu Height', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'h_full',
				'options'   => [
					'h_full' => esc_html__( 'Full', 'zyre-elementor-addons' ),
					'h_rel'  => esc_html__( 'Relative', 'zyre-elementor-addons' ),
				],
				'condition' => [
					'menu_layout'      => 'vr',
					'submenu_position' => 'pos_top',
				],
			]
		);

		$this->add_control(
			'heading_responsive_menu',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Responsive', 'zyre-elementor-addons' ),
			]
		);

		// Dynamically get breakpoints
		$dropdown_options = [
			'' => esc_html__( 'None', 'zyre-elementor-addons' ),
			'-1' => esc_html__( 'All Devices', 'zyre-elementor-addons' ),
		];

		$excluded_breakpoints = [
			'widescreen',
		];

		foreach ( zyreladdons_elementor()->breakpoints->get_active_breakpoints() as $breakpoint_key => $breakpoint_instance ) {
			// Do not include laptop and widscreen in the options since this feature is for mobile devices.
			if ( in_array( $breakpoint_key, $excluded_breakpoints, true ) ) {
				continue;
			}

			$dropdown_options[ $breakpoint_key ] = sprintf(
				/* translators: 1: Breakpoint label, 2: `>` character, 3: Breakpoint value. */
				esc_html__( '%1$s (%2$s %3$dpx)', 'zyre-elementor-addons' ),
				$breakpoint_instance->get_label(),
				'>',
				$breakpoint_instance->get_value()
			);
		}

		$this->add_control(
			'breakpoint',
			[
				'label'        => __( 'Breakpoint', 'zyre-elementor-addons' ),
				'label_block'  => true,
				'type'         => Controls_Manager::SELECT,
				'options'      => $dropdown_options,
				'default'      => 'tablet',
				'prefix_class' => 'zyre-menu__breakpoint-',
				'render_type'  => 'template',
			]
		);

		$this->add_control(
			'hamburger_icon',
			[
				'label'       => esc_html__( 'Menu Icon', 'zyre-elementor-addons' ),
				'label_block' => false,
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'default'     => [
					'value'   => 'fas fa-bars',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'hamburger_close_icon',
			[
				'label'       => esc_html__( 'Close Icon', 'zyre-elementor-addons' ),
				'label_block' => false,
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'default'     => [
					'value'   => 'far fa-window-close',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'submenu_indicator',
			[
				'label'                  => esc_html__( 'Submenu Indicator', 'zyre-elementor-addons' ),
				'label_block'            => false,
				'type'                   => Controls_Manager::ICONS,
				'skin'                   => 'inline',
				'default'                => [
					'value'   => 'zy-fonticon-b zy-Arrow-down',
					'library' => 'zyre-icons-bold',
				],
				'exclude_inline_options' => [ 'none' ],
				'separator'              => 'before',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register styles related controls
	 */
	protected function register_style_controls() {
		$this->__main_menu_style();
		$this->__main_menu_item_style();
		$this->__submenu_indicator_style();
		$this->__sub_menu_style();
		$this->__sub_menu_item_style();
		$this->__hamburger_style();
		$this->__mobile_menu_style();
	}

	/**
	 * Style - Main Menu
	 */
	protected function __main_menu_style() {
		$this->start_controls_section(
			'main_menu_style',
			[
				'label' => esc_html__( 'Menu', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'menu_link',
			[
				'selector' => '{{WRAPPER}} ul.menu li.menu-item a',
				'controls' => [
					'typography'    => [],
				],
			]
		);

		$this->set_style_controls(
			'menu_desc',
			[
				'selector' => '{{WRAPPER}} ul.menu li.menu-item a .menu-item-description',
				'controls' => [
					'typography'    => [
						'label' => esc_html__( 'Description Typography', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->set_style_controls(
			'menu',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu',
				'controls' => [
					'column_gap'    => [
						'label' => esc_html__( 'Space Between (Horizontal)', 'zyre-elementor-addons' ),
					],
					'row_gap'       => [
						'label' => esc_html__( 'Space Between (Vertical)', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->add_control(
			'menu_align',
			[
				'label'        => __( 'Alignment', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'left'    => [
						'title' => __( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center'  => [
						'title' => __( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'   => [
						'title' => __( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
					'justify' => [
						'title' => __( 'Justify', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-stretch',
					],
				],
				'default'      => 'left',
				'selectors_dictionary' => [
					'left'    => 'justify-content: flex-start',
					'center'  => 'justify-content: center',
					'right'   => 'justify-content: flex-end',
					'justify' => '--flex-grow: 1',
				],
				'selectors' => [
					'{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu' => '{{VALUE}};',
				],
			]
		);

		$this->set_style_controls(
			'menu',
			[
				'selector'  => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu',
				'controls'  => [
					'heading'          => [
						'label'     => esc_html__( 'Vertical Layout only', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
					'width'            => [],
					'height'           => [],
					'align_y'          => [
						'default'      => 'flex-start',
						'css_property' => 'align-content',
					],
					'background_color' => [],
					'border'           => [],
					'box_shadow'       => [],
					'padding'          => [
						'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) .zyre-mega-menu--vr',
					],
				],
				'condition' => [
					'menu_layout' => 'vr',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style - Main Menu Item
	 */
	protected function __main_menu_item_style() {
		$this->start_controls_section(
			'main_menu_item_style',
			[
				'label' => esc_html__( 'Menu Item', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'menu_item_link',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li.menu-item > a',
				'controls' => [
					'padding'       => [],
				],
			]
		);

		$this->add_responsive_control(
			'menu_item_arrow_space',
			[
				'label'     => esc_html__( 'Arrow Space', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li.menu-item > .submenu-indicator' => 'margin-inline-start: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'menu_item_desc_space',
			[
				'label'     => esc_html__( 'Description Space', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li.menu-item > a .menu-item-description' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->set_style_controls(
			'menu_item',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li.menu-item',
				'controls' => [
					'border'       => [],
				],
			]
		);

		$this->add_control(
			'menu_item_rm_border',
			[
				'label'              => esc_html__( 'Exclude Border from', 'zyre-elementor-addons' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => [
					''            => esc_html__( 'None', 'zyre-elementor-addons' ),
					'last-child'  => esc_html__( 'Last Item', 'zyre-elementor-addons' ),
					'first-child' => esc_html__( 'First Item', 'zyre-elementor-addons' ),
				],
				'default'            => '',
				'frontend_available' => true,
				'condition'          => [
					'menu_item_border_border!' => ['', 'none'],
				],
			]
		);

		$this->add_responsive_control(
			'menu_item_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li.menu-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Tabs
		$this->start_controls_tabs( 'tabs_menu_item_link_colors' );

		$this->start_controls_tab(
			'tab_menu_item_link_color',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'menu_item_link',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li.menu-item > a',
				'controls' => [
					'color'        => [],
				],
			]
		);

		$this->set_style_controls(
			'menu_item',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li.menu-item',
				'controls' => [
					'bg_color'       => [],
				],
			]
		);

		$this->set_style_controls(
			'menu_item_desc',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li.menu-item > a .menu-item-description',
				'controls' => [
					'color'        => [
						'label' => esc_html__( 'Description Color', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->add_control(
			'menu_item_arrow',
			[
				'label'     => esc_html__( 'Arrow Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li.menu-item > .submenu-indicator i' => 'color: {{VALUE}};',
					'{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li.menu-item > .submenu-indicator svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab(
			'tab_menu_item_link_color_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'menu_item_link_hover',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li.menu-item:hover > a',
				'controls' => [
					'color'      => [],
					'decoration' => [],
				],
			]
		);

		$this->set_style_controls(
			'menu_item_hover',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li.menu-item:hover',
				'controls' => [
					'bg_color'     => [],
					'border_color' => [],
				],
			]
		);

		$this->set_style_controls(
			'menu_item_desc_hover',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li.menu-item:hover > a .menu-item-description',
				'controls' => [
					'color'        => [
						'label' => esc_html__( 'Description Color', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->add_control(
			'menu_item_arrow_hover',
			[
				'label'     => esc_html__( 'Arrow Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li.menu-item:hover > .submenu-indicator i' => 'color: {{VALUE}};',
					'{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li.menu-item:hover > .submenu-indicator svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Tab: Active
		$this->start_controls_tab(
			'tab_menu_item_link_color_active',
			[
				'label' => esc_html__( 'Active', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'menu_item_link_active',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li.current-menu-item > a, {{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li.current-menu-ancestor > a',
				'controls' => [
					'color'      => [],
					'decoration' => [],
				],
			]
		);

		$this->set_style_controls(
			'menu_item_active',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li.current-menu-item, {{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li.current-menu-ancestor',
				'controls' => [
					'bg_color'        => [],
					'border_color'        => [],
				],
			]
		);

		$this->set_style_controls(
			'menu_item_desc_active',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li.current-menu-item > a .menu-item-description, {{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li.current-menu-ancestor > a .menu-item-description',
				'controls' => [
					'color'        => [
						'label' => esc_html__( 'Description Color', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->add_control(
			'menu_item_arrow_active',
			[
				'label'     => esc_html__( 'Arrow Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li.current-menu-item > .submenu-indicator i,
					{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li.current-menu-ancestor > .submenu-indicator i' => 'color: {{VALUE}};',
					'{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li.current-menu-item > .submenu-indicator svg,
					{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li.current-menu-ancestor > .submenu-indicator svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Style - Submenu Indicator
	 */
	protected function __submenu_indicator_style() {
		$this->start_controls_section(
			'submenu_indicator_style',
			[
				'label'     => esc_html__( 'Submenu Indicator', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'submenu_indicator[value]!' => '',
				],
			]
		);

		$this->set_style_controls(
			'submenu_indicator',
			[
				'selector' => '{{WRAPPER}} ul.menu .submenu-indicator',
				'controls' => [
					'width'      => [
						'selector' => '{{WRAPPER}} ul.menu > li.menu-item > .submenu-indicator',
						'range'    => [
							'px' => [
								'min' => 1,
								'max' => 100,
							],
						],
					],
					'width_ex'   => [
						'label'    => __( 'Width (child indicators)', 'zyre-elementor-addons' ),
						'selector' => '{{WRAPPER}} ul.sub-menu li.menu-item > .submenu-indicator',
						'range'    => [
							'px' => [
								'min' => 1,
								'max' => 100,
							],
						],
					],
					'icon_size'  => [],
					'icon_color' => [],
					'padding'    => [],
					'rotate'     => [
						'selector' => '{{WRAPPER}} ul.menu .submenu-indicator svg, {{WRAPPER}} ul.menu .submenu-indicator i',
						'priority' => true,
					],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style - Sub Menu
	 */
	protected function __sub_menu_style() {
		$this->start_controls_section(
			'sub_menu_style',
			[
				'label' => esc_html__( 'Sub Menu', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'_alert_sub_menu_style',
			[
				'type'      => Controls_Manager::RAW_HTML,
				'raw'       => esc_html__( 'Note: The following styles will not apply to the Mega Menu Builder content.', 'zyre-elementor-addons' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);

		$this->set_style_controls(
			'submenu_link',
			[
				'selector' => '{{WRAPPER}} ul.sub-menu:not(.zy-megamenu-panel) li.menu-item a',
				'controls' => [
					'typography'    => [],
				],
			]
		);

		$this->set_style_controls(
			'submenu_desc',
			[
				'selector' => '{{WRAPPER}} ul.sub-menu:not(.zy-megamenu-panel) li.menu-item a .menu-item-description',
				'controls' => [
					'typography'    => [
						'label' => esc_html__( 'Description Typography', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->set_style_controls(
			'submenu',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu:not(.zy-megamenu-panel)',
				'controls' => [
					'bg_color'      => [],
					'padding'       => [],
					'margin'        => [
						'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li.menu-item > ul.sub-menu',
					],
					'border'        => [],
					'border_radius' => [],
					'box_shadow'    => [],
				],
			]
		);

		$this->add_responsive_control(
			'submenu_min_width',
			[
				'label'     => esc_html__( 'Min Width', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 260,
				],
				'selectors' => [
					'{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu' => 'min-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->set_style_controls(
			'submenu',
			[
				'selector'  => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li.menu-item > ul.sub-menu:not(.zy-megamenu-panel)',
				'controls'  => [
					'height' => [],
				],
				'condition' => [
					'menu_layout'      => 'vr',
					'submenu_position' => 'pos_top',
				],
			]
		);

		$this->set_style_controls(
			'submenu',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li.menu-item > ul.sub-menu:not(.zy-megamenu-panel)',
				'controls' => [
					'offset_x' => [
						'css_property' => is_rtl() ? 'right' : 'left',
						'size_units'   => ['%', 'px', 'custom'],
						'range'        => [
							'%'  => [
								'min' => -500,
								'max' => 500,
							],
							'px' => [
								'min' => -500,
								'max' => 500,
							],
						],
					],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style - Sub Menu Item
	 */
	protected function __sub_menu_item_style() {
		$this->start_controls_section(
			'sub_menu_item_style',
			[
				'label' => esc_html__( 'Sub Menu Item', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'submenu_item_link',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li.menu-item > a',
				'controls' => [
					'padding'       => [],
				],
			]
		);

		$this->set_style_controls(
			'submenu_item',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li.menu-item:not(:last-child)',
				'controls' => [
					'space' => [
						'label' => esc_html__( 'Bottom Space', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->add_responsive_control(
			'submenu_item_arrow_space',
			[
				'label'     => esc_html__( 'Arrow Space', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li.menu-item > .submenu-indicator' => 'margin-inline-start: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'submenu_item_desc_space',
			[
				'label'     => esc_html__( 'Description Space', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li.menu-item > a .menu-item-description' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->set_style_controls(
			'submenu_item',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li.menu-item',
				'controls' => [
					'border'       => [],
				],
			]
		);

		$this->add_control(
			'submenu_item_rm_border',
			[
				'label'              => esc_html__( 'Exclude Border from', 'zyre-elementor-addons' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => [
					''            => esc_html__( 'None', 'zyre-elementor-addons' ),
					'last-child'  => esc_html__( 'Last Item', 'zyre-elementor-addons' ),
					'first-child' => esc_html__( 'First Item', 'zyre-elementor-addons' ),
				],
				'default'            => '',
				'frontend_available' => true,
				'condition'          => [
					'submenu_item_border_border!' => ['', 'none'],
				],
			]
		);

		$this->add_responsive_control(
			'submenu_item_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li.menu-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Tabs
		$this->start_controls_tabs( 'tabs_submenu_item_link_colors' );

		$this->start_controls_tab(
			'tab_submenu_item_link_color',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'submenu_item_link',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li.menu-item > a',
				'controls' => [
					'color'        => [],
				],
			]
		);

		$this->set_style_controls(
			'submenu_item',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li.menu-item',
				'controls' => [
					'bg_color'       => [],
				],
			]
		);

		$this->set_style_controls(
			'submenu_item_desc',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li.menu-item > a .menu-item-description',
				'controls' => [
					'color'        => [
						'label' => esc_html__( 'Description Color', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->add_control(
			'submenu_item_arrow',
			[
				'label'     => esc_html__( 'Arrow Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li.menu-item > .submenu-indicator i' => 'color: {{VALUE}};',
					'{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li.menu-item > .submenu-indicator svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab(
			'tab_submenu_item_link_color_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'submenu_item_link_hover',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li.menu-item:hover > a',
				'controls' => [
					'color'      => [],
					'decoration' => [],
				],
			]
		);

		$this->set_style_controls(
			'submenu_item_hover',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li.menu-item:hover',
				'controls' => [
					'bg_color'     => [],
					'border_color' => [],
				],
			]
		);

		$this->set_style_controls(
			'submenu_item_desc_hover',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li.menu-item:hover > a .menu-item-description',
				'controls' => [
					'color'        => [
						'label' => esc_html__( 'Description Color', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->add_control(
			'submenu_item_arrow_hover',
			[
				'label'     => esc_html__( 'Arrow Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li.menu-item:hover > .submenu-indicator i' => 'color: {{VALUE}};',
					'{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li.menu-item:hover > .submenu-indicator svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Tab: Active
		$this->start_controls_tab(
			'tab_submenu_item_link_color_active',
			[
				'label' => esc_html__( 'Active', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'submenu_item_link_active',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li.current-menu-item > a, {{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li.current-menu-ancestor > a',
				'controls' => [
					'color'      => [],
					'decoration' => [],
				],
			]
		);

		$this->set_style_controls(
			'submenu_item_active',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li.current-menu-item, {{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li.current-menu-ancestor',
				'controls' => [
					'bg_color'        => [],
					'border_color'        => [],
				],
			]
		);

		$this->set_style_controls(
			'submenu_item_desc_active',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li.current-menu-item > a .menu-item-description, {{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li.current-menu-ancestor > a .menu-item-description',
				'controls' => [
					'color'        => [
						'label' => esc_html__( 'Description Color', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->add_control(
			'submenu_item_arrow_active',
			[
				'label'     => esc_html__( 'Arrow Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li.current-menu-item > .submenu-indicator i, {{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li.current-menu-ancestor > .submenu-indicator i' => 'color: {{VALUE}};',
					'{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li.current-menu-item > .submenu-indicator svg, {{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li.current-menu-ancestor > .submenu-indicator svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function __hamburger_style() {
		$this->start_controls_section(
			'hamburger_style',
			[
				'label' => esc_html__( 'Menu Toggle', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'hamburger',
			[
				'selector' => '{{WRAPPER}}.zyre-menu__mobile .zyre-hamburger-wrapper',
				'controls' => [
					'bg_color'      => [],
					'padding'       => [],
					'border'        => [],
					'border_radius' => [],
				],
			]
		);

		$this->add_responsive_control(
			'hamburger_alignment',
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
				'default'   => is_rtl() ? 'left' : 'right',
				'selectors' => [
					'{{WRAPPER}}.zyre-menu__mobile .zyre-hamburger-wrapper' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hamburger_toggle_heading',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Toggle Button', 'zyre-elementor-addons' ),
				'separator' => 'before',
			]
		);

		$this->set_style_controls(
			'hamburger_toggle',
			[
				'selector' => '{{WRAPPER}}.zyre-menu__mobile .zyre-menu-toggler',
				'controls' => [
					'icon_size'     => [],
					'icon_color'    => [],
				],
			]
		);

		$this->set_style_controls(
			'hamburger_toggle_close',
			[
				'selector' => '{{WRAPPER}}.zyre-menu__mobile .zyre-menu-close-icon',
				'controls' => [
					'icon_color' => [
						'label' => esc_html__( 'Close Icon Color', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->set_style_controls(
			'hamburger_toggle',
			[
				'selector' => '{{WRAPPER}}.zyre-menu__mobile .zyre-menu-toggler',
				'controls' => [
					'bg_color'      => [],
					'padding'       => [],
					'border'        => [],
					'border_radius' => [],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style - Responsive Menu
	 */
	protected function __mobile_menu_style() {
		$this->start_controls_section(
			'mobile_menu_style',
			[
				'label' => esc_html__( 'Responsive Menu', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'mobile_menu',
			[
				'selector' => '{{WRAPPER}}.zyre-menu__mobile ul.menu',
				'controls' => [
					'bg_color'      => [],
					'space'         => [
						'label'        => esc_html__( 'Space Top', 'zyre-elementor-addons' ),
						'css_property' => 'margin-top',
					],
					'padding'       => [],
					'box_shadow'    => [],
					'border'        => [],
					'border_radius' => [],
				],
			]
		);

		// Dropdown Menu
		$this->add_control(
			'mobile_menu_dropdown_heading',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Dropdown Menu', 'zyre-elementor-addons' ),
				'separator' => 'before',
			]
		);

		$this->set_style_controls(
			'mobile_menu_dropdown',
			[
				'selector' => '{{WRAPPER}}.zyre-menu__mobile ul.sub-menu',
				'controls' => [
					'padding' => [],
				],
			]
		);

		// Menu Item
		$this->add_control(
			'mobile_menu_item_heading',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Menu Item', 'zyre-elementor-addons' ),
				'separator' => 'before',
			]
		);

		$this->set_style_controls(
			'mobile_menu_item',
			[
				'selector' => '{{WRAPPER}}.zyre-menu__mobile ul.menu li.menu-item a',
				'controls' => [
					'padding'       => [],
				],
			]
		);

		$this->set_style_controls(
			'mobile_menu_item',
			[
				'selector' => '{{WRAPPER}}.zyre-menu__mobile ul.menu > li.menu-item:not(:last-child), {{WRAPPER}}.zyre-menu__mobile ul.sub-menu li.menu-item',
				'controls' => [
					'space' => [
						'label' => esc_html__( 'Bottom Space', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->set_style_controls(
			'mobile_menu_item',
			[
				'selector' => '{{WRAPPER}}.zyre-menu__mobile ul.menu li.menu-item',
				'controls' => [
					'border'        => [],
					'border_radius' => [],
				],
			]
		);

		$this->add_control(
			'mobile_menu_item_rm_border',
			[
				'label'              => esc_html__( 'Exclude Border from', 'zyre-elementor-addons' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => [
					''            => esc_html__( 'None', 'zyre-elementor-addons' ),
					'last-child'  => esc_html__( 'Last Item', 'zyre-elementor-addons' ),
					'first-child' => esc_html__( 'First Item', 'zyre-elementor-addons' ),
				],
				'default'            => '',
				'frontend_available' => true,
				'condition'          => [
					'mobile_menu_item_border_border!' => ['', 'none'],
				],
			]
		);

		// Tabs
		$this->start_controls_tabs( 'tabs_mobile_menu_item_link_colors' );

		$this->start_controls_tab(
			'tab_mobile_menu_item_link_color',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'mobile_menu_item_link',
			[
				'selector' => '{{WRAPPER}}.zyre-menu__mobile ul.menu li.menu-item a',
				'controls' => [
					'color'        => [],
				],
			]
		);

		$this->set_style_controls(
			'mobile_menu_item',
			[
				'selector' => '{{WRAPPER}}.zyre-menu__mobile ul.menu li.menu-item',
				'controls' => [
					'bg_color'       => [],
				],
			]
		);

		$this->set_style_controls(
			'mobile_menu_item_desc',
			[
				'selector' => '{{WRAPPER}}.zyre-menu__mobile ul.menu li.menu-item a .menu-item-description',
				'controls' => [
					'color'        => [
						'label' => esc_html__( 'Description Color', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab(
			'tab_mobile_menu_item_link_color_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'mobile_menu_item_link_hover',
			[
				'selector' => '{{WRAPPER}}.zyre-menu__mobile ul.menu li.menu-item:hover a',
				'controls' => [
					'color' => [],
				],
			]
		);

		$this->set_style_controls(
			'mobile_menu_item_hover',
			[
				'selector' => '{{WRAPPER}}.zyre-menu__mobile ul.menu li.menu-item:hover',
				'controls' => [
					'bg_color'     => [],
					'border_color' => [],
				],
			]
		);

		$this->set_style_controls(
			'mobile_menu_item_desc_hover',
			[
				'selector' => '{{WRAPPER}}.zyre-menu__mobile ul.menu li.menu-item:hover a .menu-item-description',
				'controls' => [
					'color'        => [
						'label' => esc_html__( 'Description Color', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->end_controls_tab();

		// Tab: Active
		$this->start_controls_tab(
			'tab_mobile_menu_item_link_color_active',
			[
				'label' => esc_html__( 'Active', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'mobile_menu_item_link_active',
			[
				'selector' => '{{WRAPPER}}.zyre-menu__mobile ul.menu li.current-menu-item a,
				{{WRAPPER}}.zyre-menu__mobile ul.menu li.current-menu-ancestor a',
				'controls' => [
					'color' => [],
				],
			]
		);

		$this->set_style_controls(
			'mobile_menu_item_active',
			[
				'selector' => '{{WRAPPER}}.zyre-menu__mobile ul.menu li.current-menu-item,
				{{WRAPPER}}.zyre-menu__mobile ul.menu li.current-menu-ancestor',
				'controls' => [
					'bg_color'        => [],
					'border_color'        => [],
				],
			]
		);

		$this->set_style_controls(
			'mobile_menu_item_desc_active',
			[
				'selector' => '{{WRAPPER}}.zyre-menu__mobile ul.menu li.current-menu-item a .menu-item-description,
				{{WRAPPER}}.zyre-menu__mobile ul.menu li.current-menu-ancestor a .menu-item-description',
				'controls' => [
					'color'        => [
						'label' => esc_html__( 'Description Color', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// Submenu Toggle
		$this->add_control(
			'mobile_menu_toggle_heading',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Submenu Toggle', 'zyre-elementor-addons' ),
				'separator' => 'before',
			]
		);

		$this->set_style_controls(
			'mobile_menu_toggle',
			[
				'selector' => '{{WRAPPER}}.zyre-menu__mobile ul.menu li.menu-item .submenu-indicator',
				'controls' => [
					'padding'       => [],
					'border'        => [],
					'border_radius' => [],
				],
			]
		);

		// Tabs
		$this->start_controls_tabs( 'tabs_mobile_menu_toggle_colors' );

		$this->start_controls_tab(
			'tab_mobile_menu_toggle_color',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'mobile_menu_toggle_icon',
			[
				'label'     => esc_html__( 'Icon Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.zyre-menu__mobile ul.menu li.menu-item .submenu-indicator i' => 'color: {{VALUE}};',
					'{{WRAPPER}}.zyre-menu__mobile ul.menu li.menu-item .submenu-indicator svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->set_style_controls(
			'mobile_menu_toggle',
			[
				'selector' => '{{WRAPPER}}.zyre-menu__mobile ul.menu li.menu-item .submenu-indicator',
				'controls' => [
					'bg_color'        => [],
				],
			]
		);

		$this->end_controls_tab();

		// Tab: Active
		$this->start_controls_tab(
			'tab_mobile_menu_toggle_active',
			[
				'label' => esc_html__( 'Active', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'mobile_menu_toggle_icon_active',
			[
				'label'     => esc_html__( 'Icon Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.zyre-menu__mobile ul.menu li.menu-item .submenu-indicator.active i' => 'color: {{VALUE}};',
					'{{WRAPPER}}.zyre-menu__mobile ul.menu li.menu-item .submenu-indicator.active svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->set_style_controls(
			'mobile_menu_toggle_active',
			[
				'selector' => '{{WRAPPER}}.zyre-menu__mobile ul.menu li.menu-item .submenu-indicator.active',
				'controls' => [
					'bg_color'        => [],
				],
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
		$menus = $this->get_menus();

		if ( empty( $menus ) ) {
			return false;
		}

		$settings = $this->get_settings_for_display();

		$nav_menu_classes = [
			'zyre-mega-menu',
		];

		if ( ! empty( $settings['menu_layout'] ) ) {
			$nav_menu_classes[] = 'zyre-mega-menu--' . $settings['menu_layout'];
		}
		if ( ! empty( $settings['submenu_position'] ) ) {
			$nav_menu_classes[] = 'submenu--' . $settings['submenu_position'];
		}
		if ( ! empty( $settings['submenu_y_h'] ) ) {
			$nav_menu_classes[] = 'submenu--' . $settings['submenu_y_h'];
		}

		if ( ! empty( $settings['breakpoint'] ) ) {
			$breakpoint = $settings['breakpoint'];

			$breakpoint_values = [];
			foreach ( zyreladdons_elementor()->breakpoints->get_active_breakpoints() as $breakpoint_key => $breakpoint_instance ) {
				$breakpoint_values[ $breakpoint_key ] = $breakpoint_instance->get_value();
			}

			$has_breakpoint = array_key_exists( $breakpoint, $breakpoint_values );

			$max_width = $has_breakpoint ? $breakpoint_values[ $breakpoint ] : '-1';

			if ( ! empty( $max_width ) ) {
				$nav_menu_classes[] = 'breakpoint-' . $max_width;
			}
		}

		// Hamburger Icon
		ob_start();
		?>
		<div class="zyre-hamburger-wrapper zy-justify-end">
			<span class="zyre-menu-open-icon zyre-menu-toggler zy-c-pointer zy-p-4" data-humberger="open">
				<?php
				if ( '' !== $settings['hamburger_icon']['value'] ) {
					zyreladdons_render_icon( $settings, 'icon', 'hamburger_icon' );
				}
				?>
			</span>
			<span class="zyre-menu-close-icon zyre-menu-toggler zy-c-pointer zy-p-4 zy-icon-hide" data-humberger="close">
				<?php
				if ( '' !== $settings['hamburger_close_icon']['value'] ) {
					zyreladdons_render_icon( $settings, 'icon', 'hamburger_close_icon' );
				}
				?>
			</span>
		</div>
		<?php
		$humberger_html = ob_get_clean();

		// Generate Menu
		$walker = ( class_exists( '\VertexMediaLLC\ZyreElementorAddons\Modules\Mega_Menu\Zyre_Walker_Nav' ) ? new \VertexMediaLLC\ZyreElementorAddons\Modules\Mega_Menu\Zyre_Walker_Nav() : '' );
		$args = [
			'items_wrap'      => $humberger_html . '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'menu'            => $settings['menu_list'],
			'container'       => 'nav',
			'container_class' => implode( ' ', $nav_menu_classes ),
			'fallback_cb'     => 'wp_page_menu',
			'walker'          => $walker,
			'sub_indicator'   => ! empty( $settings['submenu_indicator']['value'] ) ? zyreladdons_get_icon( $settings, 'icon', 'submenu_indicator' ) : '',
		];

		wp_nav_menu( $args );
	}
}
