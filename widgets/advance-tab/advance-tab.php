<?php

namespace VertexMediaLLC\ZyreElementorAddons\Widget;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use VertexMediaLLC\ZyreElementorAddons\Query_Manager;

defined( 'ABSPATH' ) || die();

class Advance_Tab extends Base {

	public function get_title() {
		return esc_html__( 'Advance Tab', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Advance-tab';
	}

	public function get_keywords() {
		return [ 'advance tabs', 'tabs', 'toggle', 'toggle content', 'content switcher', 'toggle button' ];
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	protected function register_content_controls() {
		$this->start_controls_section(
			'section_general_content',
			[
				'label' => esc_html__( 'General', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$repeater = new Repeater();

		$repeater->add_control(
			'title',
			[
				'label'   => esc_html__( 'Title', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Tab', 'zyre-elementor-addons' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'subtitle',
			[
				'label'   => esc_html__( 'Sub Title', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::TEXT,
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
				'description' => zyreladdons_get_allowed_html_desc( 'intermediate' ),
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
		$saved_sections = $saved_sections + Query_Manager::get_page_template_options( 'section' );

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
		$saved_container = $saved_container + Query_Manager::get_page_template_options( 'container' );

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
		$saved_page = $saved_page + Query_Manager::get_page_template_options( 'page' );

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
				'label'       => esc_html__( 'Icon', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => false,
				'skin'        => 'inline',
			]
		);

		$repeater->add_control(
			'icon_align',
			[
				'label'                => esc_html__( 'Icon Position', 'zyre-elementor-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'default'              => is_rtl() ? 'right' : 'left',
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
					'{{WRAPPER}} .zyre-tabs {{CURRENT_ITEM}}' => '{{VALUE}}',
				],
			]
		);

		$repeater->add_control(
			'image',
			[
				'label'       => esc_html__( 'Add Image', 'zyre-elementor-addons' ),
				'description' => esc_html__( 'Shows only for Toggle Type → Button', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::MEDIA,
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
			'tabs',
			[
				'label'         => esc_html__( 'Tabs', 'zyre-elementor-addons' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [
					[
						'title'         => esc_html__( 'Tab #1', 'zyre-elementor-addons' ),
						'content_type'  => 'plain_content',
						'plain_content' => esc_html__( 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Incidunt, natus! Facere suscipit doloremque, ea animi debitis quas nihil beatae nobis autem cupiditate sequi doloribus voluptate magnam ipsum provident magni officiis exercitationem aliquam. Iure, minima id consectetur recusandae laudantium nam aperiam delectus. Temporibus optio doloremque nesciunt rerum atque fugit cumque aspernatur excepturi odio minus earum sunt deleniti iste magnam eum nam voluptates porro dolores autem fuga, ad, nobis in minima quod.', 'zyre-elementor-addons' ),
						'active'        => 'yes',
					],
					[
						'title'         => esc_html__( 'Tab #2', 'zyre-elementor-addons' ),
						'content_type'  => 'plain_content',
						'plain_content' => esc_html__( 'Non possimus cumque consequuntur sunt est alias quae nisi voluptas dolorum nesciunt iste maiores deserunt dignissimos placeat pariatur, vitae molestias numquam, porro natus, magnam officiis nostrum sint? Amet, et porro minus corporis, asperiores labore, molestiae culpa pariatur alias expedita ea voluptatem hic? Mollitia culpa odio sequi dolore nesciunt recusandae accusantium rerum harum praesentium eos est explicabo debitis rem, iusto, iure pariatur quaerat enim? Fugiat rem, exercitationem ipsa deleniti eius libero, itaque quia, porro eaque minima quibusdam? Hic quaerat blanditiis similique aliquam corrupti eos nemo molestiae dicta tempora.', 'zyre-elementor-addons' ),
					],
					[
						'title'         => esc_html__( 'Tab #3', 'zyre-elementor-addons' ),
						'content_type'  => 'plain_content',
						'plain_content' => esc_html__( 'Phasellus dignissim quam libero, a laoreet leo malesuada sit amet. Vestibulum eget augue orci. Praesent vitae est feugiat, tristique nunc et, facilisis nibh. Curabitur faucibus ultricies dui, non tempor nibh blandit eu. Praesent congue, sapien ut porttitor egestas, elit justo rutrum lorem, nec blandit arcu purus sit amet est. Ut laoreet ac nunc luctus faucibus. Pellentesque eget viverra lectus, a varius libero. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In et dapibus odio, ac pharetra ipsum. Aliquam vel arcu a ex lacinia accumsan. Vestibulum tortor urna, iaculis non accumsan quis, tempus quis sapien. Ut ac nisi nec orci semper ultricies.', 'zyre-elementor-addons' ),
					],
				],
				'title_field'   => '{{{ title }}}',
			]
		);

		$this->add_control(
			'content_display_on_hover',
			[
				'label'        => esc_html__( 'Content Display on Hover', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'YES', 'zyre-elementor-addons' ),
				'label_off'    => esc_html__( 'NO', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'separator'    => 'before',
				'prefix_class' => 'zyre-tab-content-display-hover--',
				'render_type'  => 'template',
			]
		);

		$this->add_responsive_control(
			'layout',
			[
				'label'     => esc_html__( 'Layout', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'block',
				'options'   => [
					'block' => [
						'title' => esc_html__( 'Block', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-editor-list-ul',
					],
					'flex'  => [
						'title' => esc_html__( 'Inline', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-ellipsis-h',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-tabs' => 'display: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'tabs_nav_pos',
			[
				'label'     => esc_html__( 'Tabs Nav Position', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'row',
				'options'   => [
					'row'         => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'row-reverse' => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-tabs' => 'flex-direction: {{VALUE}};',
				],
				'condition' => [
					'layout' => 'flex',
				],
			]
		);

		$this->add_responsive_control(
			'gap',
			[
				'label'      => esc_html__( 'Space Between', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					],
					'em' => [
						'min'  => 0,
						'max'  => 30,
						'step' => 0.1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-tabs' => 'gap: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'layout' => 'flex',
				],
			]
		);

		$this->add_control(
			'indicator',
			[
				'label'       => esc_html__( 'Tab Indicator', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => false,
				'recommended' => [
					'fa-solid' => [
						'arrow-left',
						'arrow-right',
						'arrow-up',
						'arrow-down',
						'long-arrow-alt-left',
						'long-arrow-alt-right',
					],
					'zyre-icons-bold' => [
						'Arrow-down',
						'Arrow-up',
						'Arrow-left',
						'Arrow-right',
					],
				],
				'skin'        => 'inline',
				'separator'    => 'before',
			]
		);

		$arrow_offset_prop_x = is_rtl() ? 'left' : 'right';

		$this->add_control(
			'tab_item_arrow',
			[
				'label'        => esc_html__( 'Enable Custom Indicator', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'YES', 'zyre-elementor-addons' ),
				'label_off'    => esc_html__( 'NO', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'selectors'    => [
					'{{WRAPPER}} .zyre-tabs-nav-item' => '--arrow-width: 8px;--arrow-height: 12px;--arrow-color: #197dff;--arrow-bottom: 0px;--arrow-flip: 1;--arrow-rotate: 0deg;--arrow-offset-x: 50%;',
					'{{WRAPPER}} .zyre-tabs-nav-item::after' => 'content: "";width: 0;height: 0;border-style: solid;border-width: 0px var(--arrow-width) var(--arrow-height) var(--arrow-width);border-color: transparent transparent var(--arrow-color) transparent;position: absolute;bottom: var(--arrow-bottom);' . $arrow_offset_prop_x . ': var(--arrow-offset-x);transform: translateX(-50%) scaleY(var(--arrow-flip)) rotate(var(--arrow-rotate));',
				],
				'condition'    => [
					'indicator[value]' => '',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_controls() {
		$this->__tabs_nav_style_controls();
		$this->__tabs_nav_inner_style_controls();
		$this->__tab_item_style_controls();
		$this->__tab_item_image_style_controls();
		$this->__tab_item_icon_style_controls();
		$this->__tab_item_indicator_style_controls();
		$this->__tab_content_item_style_controls();
	}

	protected function __tabs_nav_style_controls() {

		$this->start_controls_section(
			'_section_tabs_nav_style',
			[
				'label' => esc_html__( 'Tabs Nav', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'tabs_nav',
			[
				'selector' => '{{WRAPPER}} .zyre-tabs-nav',
				'controls' => [
					'align_x' => [
						'label'   => esc_html__( 'Tabs Alignment', 'zyre-elementor-addons' ),
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
						'description'  => __( 'Set Space between tabs nav and content', 'zyre-elementor-addons' ),
						'css_property' => 'margin-bottom',
					],
				],
				'condition' => [
					'layout' => 'block',
				],
			]
		);

		$this->common_style_controls( 'tabs_nav', '.zyre-tabs-nav' );

		$this->set_style_controls(
			'tabs_nav',
			[
				'selector' => '{{WRAPPER}} .zyre-tabs-nav',
				'controls' => [
					'border_radius' => [],
					'padding'       => [],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __tabs_nav_inner_style_controls() {

		$this->start_controls_section(
			'_section_tabs_nav_inner_style',
			[
				'label' => esc_html__( 'Tabs Nav Inner', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'tabs_nav',
			[
				'selector' => '{{WRAPPER}} .zyre-tabs-nav-inner',
				'controls' => [
					'width' => [],
					'direction' => [
						'label'   => esc_html__( 'Tabs Direction', 'zyre-elementor-addons' ),
						'default' => 'row',
					],
					'justify_content'   => [
						'label_block' => true,
						'condition' => [
							'tabs_nav_direction' => 'row',
							'layout'             => 'block',
						],
					],
					'align_y'   => [
						'css_property' => 'justify-content',
						'condition' => [
							'tabs_nav_direction' => 'column',
							'layout'             => 'flex',
						],
					],
					'gap'       => [
						'label' => esc_html__( 'Space Between Tabs', 'zyre-elementor-addons' ),
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 500,
							],
						],
					],
				],
			]
		);

		$this->common_style_controls( 'tabs_nav_inner', '.zyre-tabs-nav-inner' );

		$this->set_style_controls(
			'tabs_nav_inner',
			[
				'selector' => '{{WRAPPER}} .zyre-tabs-nav-inner',
				'controls' => [
					'border_radius' => [],
					'padding'       => [],
					'margin'        => [],
				],
			]
		);

		$this->end_controls_section();
	}
	
	protected function __tab_item_style_controls() {
		$this->start_controls_section(
			'_section_tab_item_style',
			[
				'label' => esc_html__( 'Tab Item', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'tab_item',
			[
				'selector' => '{{WRAPPER}} .zyre-tabs-nav-item',
				'controls' => [
					'typo'      => [],
					'typo_2'    => [
						'label'    => esc_html__( 'Sub Title Typography', 'zyre-elementor-addons' ),
						'selector' => '{{WRAPPER}} .zyre-tabs-nav-item .zyre-tabs-nav-item-subtitle',
					],
				],
			]
		);

		$this->set_style_controls(
			'tab_item',
			[
				'selector' => '{{WRAPPER}} .zyre-tabs-nav-item',
				'controls' => [
					'width'         => [],
					'height'        => [],
					'padding'       => [],
					'border'        => [],
					'border_radius' => [],
					'direction'     => [
						'label'     => esc_html__( 'Direction the Elements', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
					'gap'           => [
						'label' => esc_html__( 'Space Between', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->set_style_controls(
			'tab_item_titles',
			[
				'selector' => '{{WRAPPER}} .zyre-tabs-nav-item-titles',
				'controls' => [
					'direction' => [
						'label' => esc_html__( 'Direction Titles', 'zyre-elementor-addons' ),
					],
					'align_self_x' => [
						'label' => esc_html__( 'Align Titles', 'zyre-elementor-addons' ),
						'selector' => '{{WRAPPER}} .zyre-tabs-nav-item-titles > *',
						'condition' => [
							'tab_item_titles_direction' => 'column',
						],
					],
					'gap' => [
						'label' => esc_html__( 'Space Between', 'zyre-elementor-addons' ),
					],
					'align_x' => [
						'label' => esc_html__( 'Text Align', 'zyre-elementor-addons' ),
						'options' => [
							'flex-start'    => [
								'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
								'icon'  => 'eicon-text-align-left',
							],
							'center'        => [
								'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
								'icon'  => 'eicon-text-align-center',
							],
							'flex-end'      => [
								'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
								'icon'  => 'eicon-text-align-right',
							],
						],
						'selector' => '{{WRAPPER}} .zyre-tabs-nav-item-titles',
					],
				],
			]
		);

		$this->add_responsive_control(
			'tab_item_title_order',
			[
				'label'     => esc_html__( 'Title Order', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => -5,
				'max'       => 5,
				'selectors' => [
					'{{WRAPPER}} .zyre-tabs-nav-item-title' => 'order: {{VALUE}};',
				],
			]
		);

		// Tabs
		$this->start_controls_tabs( 'tabs_tab_item' );

		// Tab: Normal
		$this->start_controls_tab(
			'tab_tab_item_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'tab_item_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-tabs-nav-item'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-tabs-nav-item svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tab_item_subtitle_color',
			[
				'label'     => esc_html__( 'Sub Title Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-tabs-nav-item .zyre-tabs-nav-item-subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->common_style_controls( 'tab_item', '.zyre-tabs-nav-item', [ 'border' ] );

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab(
			'tab_tab_item_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'tab_item_text_color_hover',
			[
				'label'     => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-tabs-nav-item:hover'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-tabs-nav-item:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tab_item_subtitle_color_hover',
			[
				'label'     => esc_html__( 'Sub Title Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-tabs-nav-item:hover .zyre-tabs-nav-item-subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->common_style_controls( 'tab_item_hover', '.zyre-tabs-nav-item:not(.active):hover', [], [ 'font_weight' => [ 'default' => '' ] ] );

		$this->add_responsive_control(
			'nav_item_subtitle_fw_hover',
			[
				'label'     => esc_html__( 'Subtitle Font Weight', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					'100'    => esc_html__( '100 (Thin)', 'zyre-elementor-addons' ),
					'200'    => esc_html__( '200 (Extra Light)', 'zyre-elementor-addons' ),
					'300'    => esc_html__( '300 (Light)', 'zyre-elementor-addons' ),
					'400'    => esc_html__( '400 (Normal)', 'zyre-elementor-addons' ),
					'500'    => esc_html__( '500 (Medium)', 'zyre-elementor-addons' ),
					'600'    => esc_html__( '600 (Semi Bold)', 'zyre-elementor-addons' ),
					'700'    => esc_html__( '700 (Bold)', 'zyre-elementor-addons' ),
					'800'    => esc_html__( '800 (Extra Bold)', 'zyre-elementor-addons' ),
					'900'    => esc_html__( '900 (Black)', 'zyre-elementor-addons' ),
					''       => esc_html__( 'Default', 'zyre-elementor-addons' ),
					'normal' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
					'bold'   => esc_html__( 'Bold', 'zyre-elementor-addons' ),
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-tabs-nav-item:not(.active):hover .zyre-tabs-nav-item-subtitle' => 'font-weight: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Tab: Active
		$this->start_controls_tab(
			'tab_tab_item_active',
			[
				'label' => esc_html__( 'Active', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'tab_item_text_color_active',
			[
				'label'     => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-tabs-nav-item.active'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-tabs-nav-item.active svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tab_item_subtitle_color_active',
			[
				'label'     => esc_html__( 'Sub Title Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-tabs-nav-item.active .zyre-tabs-nav-item-subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->common_style_controls( 'tab_item_active', '.zyre-tabs-nav-item.active', [], [ 'font_weight' => [ 'default' => '' ] ] );

		$this->add_responsive_control(
			'nav_item_subtitle_fw_active',
			[
				'label'     => esc_html__( 'Subtitle Font Weight', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					'100'    => esc_html__( '100 (Thin)', 'zyre-elementor-addons' ),
					'200'    => esc_html__( '200 (Extra Light)', 'zyre-elementor-addons' ),
					'300'    => esc_html__( '300 (Light)', 'zyre-elementor-addons' ),
					'400'    => esc_html__( '400 (Normal)', 'zyre-elementor-addons' ),
					'500'    => esc_html__( '500 (Medium)', 'zyre-elementor-addons' ),
					'600'    => esc_html__( '600 (Semi Bold)', 'zyre-elementor-addons' ),
					'700'    => esc_html__( '700 (Bold)', 'zyre-elementor-addons' ),
					'800'    => esc_html__( '800 (Extra Bold)', 'zyre-elementor-addons' ),
					'900'    => esc_html__( '900 (Black)', 'zyre-elementor-addons' ),
					''       => esc_html__( 'Default', 'zyre-elementor-addons' ),
					'normal' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
					'bold'   => esc_html__( 'Bold', 'zyre-elementor-addons' ),
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-tabs-nav-item.active .zyre-tabs-nav-item-subtitle' => 'font-weight: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function __tab_item_image_style_controls() {

		$this->start_controls_section(
			'_section_image_style',
			[
				'label'     => esc_html__( 'Tab Item Image', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'image',
			[
				'selector' => '{{WRAPPER}} .zyre-tabs-nav-item .zyre-tabs-nav-item-image img',
				'controls' => [
					'width'         => [
						'selector' => '{{WRAPPER}} .zyre-tabs-nav-item .zyre-tabs-nav-item-image, {{WRAPPER}} .zyre-tabs-nav-item .zyre-tabs-nav-item-image img',
					],
					'height'        => [
						'selector' => '{{WRAPPER}} .zyre-tabs-nav-item .zyre-tabs-nav-item-image, {{WRAPPER}} .zyre-tabs-nav-item .zyre-tabs-nav-item-image img',
					],
					'object_fit'    => [],
					'border_radius' => [],
					'padding'       => [],
				],
			]
		);

		$this->start_controls_tabs( 'tabs_image_style' );

		// Tab: Normal
		$this->start_controls_tab(
			'tab_image_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);
		
		$this->add_control(
			'image_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-tabs-nav-item .zyre-tabs-nav-item-image img' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'image_box_shadow',
				'selector'  => '{{WRAPPER}} .zyre-tabs-nav-item .zyre-tabs-nav-item-image img',
			]
		);

		$this->add_control(
			'image_opacity',
			[
				'label'      => esc_html__( 'Opacity', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-tabs-nav-item .zyre-tabs-nav-item-image img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab(
			'tab_image_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'image_bg_color_hover',
			[
				'label'     => esc_html__( 'Background Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-tabs-nav-item:hover .zyre-tabs-nav-item-image img' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'image_box_shadow_hover',
				'selector'  => '{{WRAPPER}} .zyre-tabs-nav-item:hover .zyre-tabs-nav-item-image img',
			]
		);

		$this->add_control(
			'image_opacity_hover',
			[
				'label'      => esc_html__( 'Opacity', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-tabs-nav-item:hover .zyre-tabs-nav-item-image img' => 'opacity: {{SIZE}};',
				],
			]
		);
	
		$this->end_controls_tab();

		// Tab: Active
		$this->start_controls_tab(
			'tab_image_active',
			[
				'label' => esc_html__( 'Active', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'image_bg_color_active',
			[
				'label'     => esc_html__( 'Background Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-tabs-nav-item.active .zyre-tabs-nav-item-image img' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'image_box_shadow_active',
				'selector'  => '{{WRAPPER}} .zyre-tabs-nav-item.active .zyre-tabs-nav-item-image img',
			]
		);

		$this->add_control(
			'image_opacity_active',
			[
				'label'      => esc_html__( 'Opacity', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-tabs-nav-item.active .zyre-tabs-nav-item-image img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function __tab_item_icon_style_controls() {
		$this->start_controls_section(
			'_section_tab_item_icon_style',
			[
				'label' => esc_html__( 'Tab Item Icon', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'tab_item_icon',
			[
				'selector' => '{{WRAPPER}} .zyre-tabs-nav-item .zyre-tabs-nav-item-icon-wrapper',
				'controls' => [
					'font_size'     => [],
					'width'         => [],
					'height'        => [],
					'border_radius' => [],
				],
			]
		);

		// Tabs
		$this->start_controls_tabs( 'tabs_tab_item_icon' );

		// Tab: Normal
		$this->start_controls_tab(
			'tab_tab_item_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'tab_item_icon_color',
			[
				'label'     => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-tabs-nav-item .zyre-tabs-nav-item-icon-wrapper i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-tabs-nav-item .zyre-tabs-nav-item-icon-wrapper svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tab_item_icon_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-tabs-nav-item .zyre-tabs-nav-item-icon-wrapper' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab(
			'tab_tab_item_icon_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'tab_item_icon_color_hover',
			[
				'label'     => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-tabs-nav-item:hover .zyre-tabs-nav-item-icon-wrapper i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-tabs-nav-item:hover .zyre-tabs-nav-item-icon-wrapper svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tab_item_icon_bg_color_hover',
			[
				'label'     => esc_html__( 'Background Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-tabs-nav-item:hover .zyre-tabs-nav-item-icon-wrapper' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Tab: Active
		$this->start_controls_tab(
			'tab_tab_item_icon_active',
			[
				'label' => esc_html__( 'Active', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'tab_item_icon_color_active',
			[
				'label'     => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-tabs-nav-item.active .zyre-tabs-nav-item-icon-wrapper i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-tabs-nav-item.active .zyre-tabs-nav-item-icon-wrapper svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tab_item_icon_bg_color_active',
			[
				'label'     => esc_html__( 'Background Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-tabs-nav-item.active .zyre-tabs-nav-item-icon-wrapper' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function __tab_item_indicator_style_controls() {
		$this->start_controls_section(
			'_section_tab_item_indicator_style',
			[
				'label' => esc_html__( 'Tab Item Indicator', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'indicator[value]',
							'operator' => '!==',
							'value'    => '',
						],
						[
							'name'     => 'tab_item_arrow',
							'operator' => '===',
							'value'    => 'yes',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'tab_item_arrow_width',
			[
				'label'      => esc_html__( 'Width', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .zyre-tabs-nav-item' => '--arrow-width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'indicator[value]' => '',
				],
			]
		);

		$this->add_responsive_control(
			'tab_item_arrow_height',
			[
				'label'      => esc_html__( 'Height', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .zyre-tabs-nav-item' => '--arrow-height: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'indicator[value]' => '',
				],
			]
		);

		$this->add_responsive_control(
			'tab_item_indicator_size',
			[
				'label'      => esc_html__( 'Size', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .zyre-tabs-nav-item-indicator' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'indicator[value]!' => '',
					'tab_item_arrow!' => '',
				],
			]
		);

		$offset_x_prop = is_rtl() ? 'left' : 'right';

		$this->add_responsive_control(
			'tab_item_arrow_x_offset',
			[
				'label'      => esc_html__( 'Horizontal Offset', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', 'custom' ],
				'default'    => [
					'unit' => '%',
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-tabs-nav-item' => '--arrow-offset-x: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .zyre-tabs-nav-item-indicator' => $offset_x_prop . ': var(--arrow-offset-x);'
				],
			]
		);

		$this->add_responsive_control(
			'tab_item_arrow_y_offset',
			[
				'label'      => esc_html__( 'Vertical Offset', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', 'custom' ],
				'default'    => [
					'unit' => '%',
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-tabs-nav-item' => '--arrow-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .zyre-tabs-nav-item-indicator' => 'bottom: var(--arrow-bottom);'
				],
			]
		);

		$this->add_control(
			'tab_item_arrow_flip',
			[
				'label'     => esc_html__( 'Flip', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'1'  => [
						'title' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-arrow-down',
					],
					'-1' => [
						'title' => esc_html__( 'Flipped', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-arrow-up',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-tabs-nav-item' => '--arrow-flip: {{VALUE}};',
				],
				'condition' => [
					'indicator[value]'    => '',
				],
			]
		);

		$this->add_responsive_control(
			'tab_item_arrow_rotate',
			[
				'label'          => esc_html__( 'Rotate', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => [ 'deg', 'grad', 'rad', 'turn', 'custom' ],
				'default'        => [
					'unit' => 'deg',
				],
				'range'          => [
					'deg' => [
						'min' => -360,
						'max' => 360,
					],
				],
				'selectors'      => [
					'{{WRAPPER}} .zyre-tabs-nav-item' => '--arrow-rotate: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .zyre-tabs-nav-item-indicator' => 'transform: rotate(var(--arrow-rotate));',
				],
			]
		);

		// Tabs
		$this->start_controls_tabs( 'tabs_tab_item_indicator' );

		// Tab: Normal
		$this->start_controls_tab(
			'tab_tab_item_indicator_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'tab_item_arrow_color',
			[
				'label'     => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-tabs-nav-item' => '--arrow-color: {{VALUE}};',
					'{{WRAPPER}} .zyre-tabs-nav-item-indicator i' => 'color: var(--arrow-color);',
					'{{WRAPPER}} .zyre-tabs-nav-item-indicator svg' => 'fill: var(--arrow-color);',
				],
			]
		);

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab(
			'tab_tab_item_indicator_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'tab_item_arrow_color_hover',
			[
				'label'     => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-tabs-nav-item:hover' => '--arrow-color: {{VALUE}};',
					'{{WRAPPER}} .zyre-tabs-nav-item:hover .zyre-tabs-nav-item-indicator i' => 'color: var(--arrow-color);',
					'{{WRAPPER}} .zyre-tabs-nav-item:hover .zyre-tabs-nav-item-indicator svg' => 'fill: var(--arrow-color);',
				],
			]
		);

		$this->end_controls_tab();

		// Tab: Active
		$this->start_controls_tab(
			'tab_tab_item_indicator_active',
			[
				'label' => esc_html__( 'Active', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'tab_item_arrow_color_active',
			[
				'label'      => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .zyre-tabs-nav-item.active'  => '--arrow-color: {{VALUE}};',
					'{{WRAPPER}} .zyre-tabs-nav-item.active .zyre-tabs-nav-item-indicator i'   => 'color: var(--arrow-color);',
					'{{WRAPPER}} .zyre-tabs-nav-item.active .zyre-tabs-nav-item-indicator svg' => 'fill: var(--arrow-color);',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function __tab_content_item_style_controls() {

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
				'selector' => '{{WRAPPER}} .zyre-tabs-content .zyre-tabs-content-inner .zyre-tabs-content-item',
				'controls' => [
					'typo'  => [],
					'color' => [
						'label' => __( 'Text Color', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->common_style_controls( 'content_inner', '.zyre-tabs-content-inner' );

		$this->set_style_controls(
			'content',
			[
				'selector' => '{{WRAPPER}} .zyre-tabs-content-inner',
				'controls' => [
					'border_radius' => [],
					'padding'       => [],
					'align'         => [],
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
	 * @param array $exclude The controls to be excluded.
	 * @param array $include The controls to be included.
	 */
	private function common_style_controls( string $prefix, $selector, $exclude = [], $include = [] ) {
		$controls = [
			'background' => [],
			'border'     => [],
			'box_shadow' => [],
		];

		// Remove excluded controls
		if ( ! empty( $exclude ) ) {
			$controls = array_diff_key(
				$controls,
				array_flip( $exclude )
			);
		}

		// Merge additional controls
		$controls = wp_parse_args( $include, $controls );

		$this->set_style_controls(
			$prefix,
			[
				'selector' => '{{WRAPPER}} ' . $selector,
				'controls' => $controls,
			]
		);
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		?>

		<div class="zyre-tabs">
			<div class="zyre-tabs-nav zy-flex">
				<div class="zyre-tabs-nav-inner zy-inline-flex zy-align-center zy-justify-center zy-gap-4">
					<?php if ( ! empty( $settings['tabs'] ) ): ?>
						<?php foreach ( $settings['tabs'] as $i => $item ): ?>
							<button class="zyre-tabs-nav-item zy-relative zy-flex zy-align-center zy-justify-center zy-nowrap zy-gap-1 zy-outline-none zy-shadow-none zy-bg-white zy-lh-normal <?php echo esc_attr( ( 'yes' === $item['active'] ) ? 'active' : '' ); ?> zyre-tabs-nav-item-icon-<?php echo esc_attr( $item['icon_align'] ?? '' ); ?> elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>" data-content-id="<?php echo esc_attr( $item['_id'] ); ?>">
								<?php if ( ! empty( $item['image']['id'] ) ) : ?>
									<div class="zyre-tabs-nav-item-image zy-shrink-0 zy-content-center zy-justify-items-center">
										<?php echo wp_get_attachment_image( $item['image']['id'], 'medium_large' ); ?>
									</div>
								<?php endif; ?>
								<?php if ( ! empty( $item['icon']['value'] ) ) : ?>
									<div class="zyre-tabs-nav-item-icon-wrapper zy-shrink-0 zy-content-center zy-justify-items-center"><?php zyreladdons_render_icon( $item, null, 'icon' ); ?></div>
								<?php endif; ?>
								<?php if ( $item['title'] || $item['subtitle'] ) : ?>
									<div class="zyre-tabs-nav-item-titles zy-inline-flex zy-w-100">
								<?php endif; ?>
								<?php if ( ! empty( $item['title'] ) ) : ?>
									<span class="zyre-tabs-nav-item-title zy-white-space-normal"><?php echo esc_html( $item['title'] ); ?></span>
								<?php endif; ?>
								<?php if ( ! empty( $item['subtitle'] ) ) : ?>
									<span class="zyre-tabs-nav-item-subtitle zy-white-space-normal"><?php echo esc_html( $item['subtitle'] ); ?></span>
								<?php endif; ?>
								<?php if ( $item['title'] || $item['subtitle'] ) : ?>
									</div>
								<?php endif; ?>
								<?php if ( ! empty( $settings['indicator']['value'] ) && ( empty( $settings['tab_item_arrow'] ) || 'yes' !== $settings['tab_item_arrow'] ) ): ?>
									<div class="zyre-tabs-nav-item-indicator zy-relative zy-shrink-0">
										<?php zyreladdons_render_icon( $settings, 'icon', 'indicator' ); ?>
									</div>
								<?php endif; ?>
							</button>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>

			<div class="zyre-tabs-content">
				<div class="zyre-tabs-content-inner">
					<?php if ( ! empty( $settings['tabs'] ) ): ?>
						<?php foreach ( $settings['tabs'] as $i => $item ): ?>
							<div id="<?php echo esc_attr( $item['_id'] ); ?>" class="zyre-tabs-content-item <?php echo esc_attr( ( 'yes' === $item['active'] ) ? 'active' : '' ); ?>">
								<?php
								if ( 'plain_content' === $item['content_type'] ) {
									echo wp_kses( $item['plain_content'], zyreladdons_get_allowed_html('advanced') );
								} elseif ( 'saved_section' === $item['content_type'] && 'publish' === get_post_status( $item['saved_section'] ) ) {
									$item['saved_section'] = apply_filters( 'wpml_object_id', $item['saved_section'], 'elementor_library' );
									echo zyreladdons_elementor()->frontend->get_builder_content_for_display( $item['saved_section'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								} elseif ( 'saved_container' === $item['content_type'] && 'publish' === get_post_status( $item['saved_container'] ) ) {
									$item['saved_container'] = apply_filters( 'wpml_object_id', $item['saved_container'], 'elementor_library' ); 
									echo zyreladdons_elementor()->frontend->get_builder_content_for_display( $item['saved_container'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								} elseif ( 'saved_page' === $item['content_type'] && 'publish' === get_post_status( $item['saved_pages'] ) ) {
									$item['saved_pages'] = apply_filters( 'wpml_object_id', $item['saved_pages'], 'elementor_library' );
									echo zyreladdons_elementor()->frontend->get_builder_content_for_display( $item['saved_pages'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								}
								?>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
	}
}
