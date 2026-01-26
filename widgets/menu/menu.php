<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;

defined( 'ABSPATH' ) || die();

require ZYRE_ADDONS_DIR_PATH . 'classes/walker-nav-menu.php';

class Menu extends Base {

	public function get_title() {
		return esc_html__( 'Navigation Menu', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Menu';
	}

	public function get_keywords() {
		return [ 'menu', 'nav', 'header', 'navigation', 'nav menu', 'navigation menu', 'header menu', 'horizontal menu', 'horizontal navigation', 'vertical menu', 'vertical navigation', 'hamburger menu', 'mobile menu', 'responsive menu' ];
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	public function get_style_depends() {
		return [ 'zyre-elementor-addons-nav-menu' ];
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
				'label' => esc_html__( 'Navigation Menu', 'zyre-elementor-addons' ),
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

		foreach ( zyre_elementor()->breakpoints->get_active_breakpoints() as $breakpoint_key => $breakpoint_instance ) {
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
				'label'                  => esc_html__( 'Menu Icon', 'zyre-elementor-addons' ),
				'type'                   => Controls_Manager::ICONS,
				'default'                => [
					'value'   => 'fas fa-bars',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'hamburger_close_icon',
			[
				'label'                  => esc_html__( 'Close Icon', 'zyre-elementor-addons' ),
				'type'                   => Controls_Manager::ICONS,
				'default'                => [
					'value'   => 'far fa-window-close',
					'library' => 'fa-solid',
				],
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
				'selector' => '{{WRAPPER}} ul.menu li a',
				'controls' => [
					'typography'    => [],
				],
			]
		);

		$this->set_style_controls(
			'menu_desc',
			[
				'selector' => '{{WRAPPER}} ul.menu li a .menu-item-description',
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
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li > a',
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
					'{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li > .submenu-indicator' => 'margin-inline-start: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'menu_item_desc_space',
			[
				'label'     => esc_html__( 'Description Space', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li > a .menu-item-description' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->set_style_controls(
			'menu_item',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li',
				'controls' => [
					'border'       => [],
				],
			]
		);

		$this->add_control(
			'menu_item_rm_border',
			[
				'label'       => esc_html__( 'Exclude Border from', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					''  => esc_html__( 'None', 'zyre-elementor-addons' ),
					'last-child'  => esc_html__( 'Last Item', 'zyre-elementor-addons' ),
					'first-child' => esc_html__( 'First Item', 'zyre-elementor-addons' ),
				],
				'default'     => '',
				'condition'   => [
					'menu_item_border_border!' => [ '', 'none' ],
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
					'{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li > a',
				'controls' => [
					'color'        => [],
				],
			]
		);

		$this->set_style_controls(
			'menu_item',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li',
				'controls' => [
					'bg_color'       => [],
				],
			]
		);

		$this->set_style_controls(
			'menu_item_desc',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li > a .menu-item-description',
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
					'{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li > .submenu-indicator i' => 'color: {{VALUE}};',
					'{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li > .submenu-indicator svg' => 'fill: {{VALUE}};',
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
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li:hover > a',
				'controls' => [
					'color'      => [],
					'decoration' => [],
				],
			]
		);

		$this->set_style_controls(
			'menu_item_hover',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li:hover',
				'controls' => [
					'bg_color'     => [],
					'border_color' => [],
				],
			]
		);

		$this->set_style_controls(
			'menu_item_desc_hover',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li:hover > a .menu-item-description',
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
					'{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li:hover > .submenu-indicator i' => 'color: {{VALUE}};',
					'{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > li:hover > .submenu-indicator svg' => 'fill: {{VALUE}};',
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

		$this->set_style_controls(
			'submenu_link',
			[
				'selector' => '{{WRAPPER}} ul.sub-menu li a',
				'controls' => [
					'typography'    => [],
				],
			]
		);

		$this->set_style_controls(
			'submenu_desc',
			[
				'selector' => '{{WRAPPER}} ul.sub-menu li a .menu-item-description',
				'controls' => [
					'typography'    => [
						'label' => esc_html__( 'Description Typography', 'zyre-elementor-addons' ),
					],
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
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu',
				'controls' => [
					'bg_color'      => [],
					'padding'       => [],
					'border'        => [],
					'border_radius' => [],
					'box_shadow'    => [],
				],
			]
		);

		$this->set_style_controls(
			'submenu',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.menu > .menu-item > ul.sub-menu',
				'controls' => [
					'offset_x' => [
						'css_property' => is_rtl() ? 'right' : 'left',
						'size_units'   => ['%', 'px'],
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
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li > a',
				'controls' => [
					'padding'       => [],
				],
			]
		);

		$this->set_style_controls(
			'submenu_item',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li:not(:last-child)',
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
					'{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li > .submenu-indicator' => 'margin-inline-start: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'submenu_item_desc_space',
			[
				'label'     => esc_html__( 'Description Space', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li > a .menu-item-description' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->set_style_controls(
			'submenu_item',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li',
				'controls' => [
					'border'       => [],
				],
			]
		);

		$this->add_control(
			'submenu_item_rm_border',
			[
				'label'       => esc_html__( 'Exclude Border from', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					''  => esc_html__( 'None', 'zyre-elementor-addons' ),
					'last-child'  => esc_html__( 'Last Item', 'zyre-elementor-addons' ),
					'first-child' => esc_html__( 'First Item', 'zyre-elementor-addons' ),
				],
				'default'     => '',
				'condition'   => [
					'submenu_item_border_border!' => [ '', 'none' ],
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
					'{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li > a',
				'controls' => [
					'color'        => [],
				],
			]
		);

		$this->set_style_controls(
			'submenu_item',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li',
				'controls' => [
					'bg_color'       => [],
				],
			]
		);

		$this->set_style_controls(
			'submenu_item_desc',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li > a .menu-item-description',
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
					'{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li > .submenu-indicator i' => 'color: {{VALUE}};',
					'{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li > .submenu-indicator svg' => 'fill: {{VALUE}};',
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
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li:hover > a',
				'controls' => [
					'color'      => [],
					'decoration' => [],
				],
			]
		);

		$this->set_style_controls(
			'submenu_item_hover',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li:hover',
				'controls' => [
					'bg_color'     => [],
					'border_color' => [],
				],
			]
		);

		$this->set_style_controls(
			'submenu_item_desc_hover',
			[
				'selector' => '{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li:hover > a .menu-item-description',
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
					'{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li:hover > .submenu-indicator i' => 'color: {{VALUE}};',
					'{{WRAPPER}}:not(.zyre-menu__mobile) ul.sub-menu > li:hover > .submenu-indicator svg' => 'fill: {{VALUE}};',
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
				'selector' => '{{WRAPPER}}.zyre-menu__mobile ul.menu li a',
				'controls' => [
					'padding'       => [],
				],
			]
		);

		$this->set_style_controls(
			'mobile_menu_item',
			[
				'selector' => '{{WRAPPER}}.zyre-menu__mobile ul.menu > li:not(:last-child), {{WRAPPER}}.zyre-menu__mobile ul.sub-menu li',
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
				'selector' => '{{WRAPPER}}.zyre-menu__mobile ul.menu li',
				'controls' => [
					'border'        => [],
					'border_radius' => [],
				],
			]
		);

		$this->add_control(
			'mobile_menu_item_rm_border',
			[
				'label'       => esc_html__( 'Exclude Border from', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					''  => esc_html__( 'None', 'zyre-elementor-addons' ),
					'last-child'  => esc_html__( 'Last Item', 'zyre-elementor-addons' ),
					'first-child' => esc_html__( 'First Item', 'zyre-elementor-addons' ),
				],
				'default'     => '',
				'condition'   => [
					'mobile_menu_item_border_border!' => [ '', 'none' ],
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
				'selector' => '{{WRAPPER}}.zyre-menu__mobile ul.menu li a',
				'controls' => [
					'color'        => [],
				],
			]
		);

		$this->set_style_controls(
			'mobile_menu_item',
			[
				'selector' => '{{WRAPPER}}.zyre-menu__mobile ul.menu li',
				'controls' => [
					'bg_color'       => [],
				],
			]
		);

		$this->set_style_controls(
			'mobile_menu_item_desc',
			[
				'selector' => '{{WRAPPER}}.zyre-menu__mobile ul.menu li a .menu-item-description',
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
				'selector' => '{{WRAPPER}}.zyre-menu__mobile ul.menu li:hover a',
				'controls' => [
					'color' => [],
				],
			]
		);

		$this->set_style_controls(
			'mobile_menu_item_hover',
			[
				'selector' => '{{WRAPPER}}.zyre-menu__mobile ul.menu li:hover',
				'controls' => [
					'bg_color'     => [],
					'border_color' => [],
				],
			]
		);

		$this->set_style_controls(
			'mobile_menu_item_desc_hover',
			[
				'selector' => '{{WRAPPER}}.zyre-menu__mobile ul.menu li:hover a .menu-item-description',
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
				'selector' => '{{WRAPPER}}.zyre-menu__mobile ul.menu li .submenu-indicator',
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
					'{{WRAPPER}}.zyre-menu__mobile ul.menu li .submenu-indicator i' => 'color: {{VALUE}};',
					'{{WRAPPER}}.zyre-menu__mobile ul.menu li .submenu-indicator svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->set_style_controls(
			'mobile_menu_toggle',
			[
				'selector' => '{{WRAPPER}}.zyre-menu__mobile ul.menu li .submenu-indicator',
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
					'{{WRAPPER}}.zyre-menu__mobile ul.menu li .submenu-indicator.active i' => 'color: {{VALUE}};',
					'{{WRAPPER}}.zyre-menu__mobile ul.menu li .submenu-indicator.active svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->set_style_controls(
			'mobile_menu_toggle_active',
			[
				'selector' => '{{WRAPPER}}.zyre-menu__mobile ul.menu li .submenu-indicator.active',
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
		$widget_class = '.elementor-element-' . $this->get_id();

		$left_right = is_rtl() ? 'right' : 'left';

		$css_styles = "{$widget_class} .zyre-nav-menu:not(.initialized){display: none} {$widget_class} .zyre-hamburger-wrapper{display:none}{$widget_class} ul.menu{--flex-grow: 0;display:flex;flex-wrap:wrap;align-items:center;column-gap:20px;row-gap:20px}{$widget_class} ul.menu > li {justify-content: center;flex-grow:var(--flex-grow)}{$widget_class} ul.menu > li > a {padding: 20px 0;}{$widget_class} ul.menu li .submenu-indicator{display:inline-block;vertical-align:middle;margin:auto 0;margin-inline-start:5px;text-align:center;cursor:pointer}{$widget_class} ul.sub-menu{position:absolute;{$left_right}:0;transform:translateY(20px);transition:.3s;visibility:hidden;opacity:0;z-index:9999;background-color:#fff;min-width:260px;top:100%}body:not(.rtl) {$widget_class} ul.sub-menu{box-shadow:4px 6px 12px rgba(0,0,0,.1)}body.rtl {$widget_class} ul.sub-menu{box-shadow:-4px 6px 12px rgba(0,0,0,.1)}{$widget_class} ul.sub-menu li .submenu-indicator{padding-left:20px;padding-right:20px;transform:rotate(-90deg)}{$widget_class} ul.menu li.menu-item-has-children:hover>ul.sub-menu{transform:translateY(0);visibility:visible;opacity:1}{$widget_class} ul.sub-menu li a{padding:20px 25px}{$widget_class} ul.sub-menu ul.sub-menu{{$left_right}:100%}{$widget_class} ul.sub-menu li.menu-item-has-children:hover>ul.sub-menu{transform:translateY(0);visibility:visible;opacity:1;top:0;{$left_right}:100%}";

		// Remove border from First or Last Child Menu Item
		if ( ! empty( $settings['menu_item_rm_border'] ) ) {
			$css_styles .= "{$widget_class}:not(.zyre-menu__mobile) ul.menu>li:" . esc_attr( $settings['menu_item_rm_border'] ) . '{border: none}';
		}
		if ( ! empty( $settings['submenu_item_rm_border'] ) ) {
			$css_styles .= "{$widget_class}:not(.zyre-menu__mobile) ul.sub-menu>li:" . esc_attr( $settings['submenu_item_rm_border'] ) . '{border: none}';
		}

		$breakpoint_class = '';

		if ( ! empty( $settings['breakpoint'] ) ) {
			$breakpoint = $settings['breakpoint'];

			$breakpoint_values = [];
			foreach ( zyre_elementor()->breakpoints->get_active_breakpoints() as $breakpoint_key => $breakpoint_instance ) {
				$breakpoint_values[ $breakpoint_key ] = $breakpoint_instance->get_value();
			}

			$has_breakpoint = array_key_exists( $breakpoint, $breakpoint_values );

			$min_width = $has_breakpoint ? $breakpoint_values[ $breakpoint ] + 1 : '';
			$max_width = $has_breakpoint ? $breakpoint_values[ $breakpoint ] : '-1';

			if ( ! empty( $min_width ) ) {
				$css_styles = '@media (min-width: ' . $min_width . 'px) {' . $css_styles . '}';
			}

			if ( ! empty( $max_width ) ) {
				$css_responsive = "{$widget_class} .zyre-hamburger-wrapper{display:flex}{$widget_class} ul.menu,{$widget_class} ul.menu ul.sub-menu{display:none}{$widget_class} ul.menu ul.sub-menu{width:100%;z-index:10;margin-inline-start:15px}{$widget_class} ul.menu > li {justify-content: space-between}{$widget_class} ul.menu li{flex-wrap: wrap;}{$widget_class} ul.menu li:not(:last-child){border-bottom:1px solid var(--zy-hue2)}{$widget_class} ul.menu li a{padding: 15px 0}{$widget_class} ul.menu li .submenu-indicator{cursor:pointer;padding-left:20px;padding-right:20px;align-content:center;align-self: stretch}{$widget_class} ul.menu li .submenu-indicator svg{fill:#8C919B;transition:transform var(--zy-transition-duration),color var(--zy-transition-duration)}{$widget_class} ul.menu li .submenu-indicator.active svg{transform:rotate(-180deg)}{$widget_class} ul.menu li .submenu-indicator.active svg,{$widget_class} ul.menu li .submenu-indicator:hover svg{fill:#000}{$widget_class} ul.sub-menu li a{padding-left: 0;padding-right: 0}";

				if ( ! empty( $settings['mobile_menu_item_rm_border'] ) ) {
					$css_responsive .= "{$widget_class}.zyre-menu__mobile ul.menu li:" . esc_attr( $settings['mobile_menu_item_rm_border'] ) . '{border: none !important}';
				}

				if ( '-1' == $max_width ) {
					$css_styles = ' @media screen {' . $css_responsive . '}';
				} else {
					$css_styles .= ' @media (max-width: ' . $max_width . 'px) {' . $css_responsive . '}';
				}

				$breakpoint_class = ' breakpoint-' . $max_width;
			}
		}

		echo '<style id="zyre-menu-inline-css" type="text/css">' . $css_styles . '</style>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		// Hamburger Icon
		ob_start();
		?>
		<div class="zyre-hamburger-wrapper zy-justify-end">
			<span class="zyre-menu-open-icon zyre-menu-toggler zy-c-pointer zy-p-4" data-humberger="open">
				<?php
				if ( '' !== $settings['hamburger_icon']['value'] ) {
					zyre_render_icon( $settings, 'icon', 'hamburger_icon' );
				}
				?>
			</span>
			<span class="zyre-menu-close-icon zyre-menu-toggler zy-c-pointer zy-p-4 zy-icon-hide" data-humberger="close">
				<?php
				if ( '' !== $settings['hamburger_close_icon']['value'] ) {
					zyre_render_icon( $settings, 'icon', 'hamburger_close_icon' );
				}
				?>
			</span>
		</div>
		<?php
		$humberger_html = ob_get_clean();

		// Generate Menu
		$walker = ( class_exists( '\ZyreAddons\Elementor\Zyre_Walker_Nav_Menu' ) ? new \ZyreAddons\Elementor\Zyre_Walker_Nav_Menu() : '' );
		$args = [
			'items_wrap'      => $humberger_html . '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'menu'            => $settings['menu_list'],
			'fallback_cb'     => '__return_empty_string',
			'container'       => 'nav',
			'container_class' => 'zyre-nav-menu' . esc_attr( $breakpoint_class ),
			'walker'          => $walker,
		];

		$menu_html = wp_nav_menu( $args );
		if ( empty( $menu_html ) ) {
			return;
		} else {
			echo wp_kses_post( $menu_html );
		}
	}
}
