<?php

namespace VertexMediaLLC\ZyreElementorAddons\Widget;

use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use VertexMediaLLC\ZyreElementorAddons\Query_Manager;

defined( 'ABSPATH' ) || die();

class Off_Canvas extends Base {

	public function get_title() {
		return __( 'Off Canvas', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Header';
	}

	public function get_keywords() {
		return [ 'off canvas', 'offcanvas', 'canvas', 'popup', 'floating elements', 'mobile menu' ];
	}

	/**
	 * Register widget content controls
	 */
	protected function register_content_controls() {
		$this->__general_content_controls();
		$this->__toggle_content_controls();
		$this->__closebar_content_controls();
		$this->__settings_content_controls();
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
			'content_type',
			[
				'label'    => __( 'Content Type', 'zyre-elementor-addons' ),
				'type'     => Controls_Manager::SELECT2,
				'multiple' => false,
				'options'  => [
					'sidebar'  => __( 'Sidebar', 'zyre-elementor-addons' ),
					'custom'   => __( 'Custom Content', 'zyre-elementor-addons' ),
					'section'  => __( 'Saved Section', 'zyre-elementor-addons' ),
					'widget'   => __( 'Saved Widget', 'zyre-elementor-addons' ),
					'template' => __( 'Saved Page Template', 'zyre-elementor-addons' ),
				],
				'default'  => 'custom',
			]
		);

		$this->add_control(
			'sidebar',
			[
				'label'       => __( 'Choose Sidebar', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => false,
				'options'     => Query_Manager::get_registered_sidebars(),
				'condition'   => [
					'content_type' => 'sidebar',
				],
			]
		);

		$this->add_control(
			'saved_widget',
			[
				'label'       => __( 'Choose Widget', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => false,
				'options'     => Query_Manager::get_page_template_options( 'widget' ),
				'condition'   => [
					'content_type' => 'widget',
				],
			]
		);

		$this->add_control(
			'saved_section',
			[
				'label'       => __( 'Choose Section', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => false,
				'options'     => Query_Manager::get_page_template_options( 'section' ),
				'condition'   => [
					'content_type' => 'section',
				],
			]
		);

		$this->add_control(
			'templates',
			[
				'label'       => __( 'Choose Template', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => false,
				'options'     => Query_Manager::get_page_template_options( 'page' ),
				'condition'   => [
					'content_type' => 'template',
				],
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => __( 'Title', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => __( 'Title', 'zyre-elementor-addons' ),
				'dynamic'     => [
					'active' => true,
				],
				'condition'   => [
					'content_type' => 'custom',
				],
			]
		);

		$this->add_control(
			'description',
			[
				'label'       => __( 'Description', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => __( 'Text box description goes here', 'zyre-elementor-addons' ),
				'dynamic'     => [
					'active' => true,
				],
				'condition'   => [
					'content_type' => 'custom',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __toggle_content_controls() {
		$this->start_controls_section(
			'section_toggle_content',
			[
				'label' => __( 'Toggle', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'toggle_source',
			[
				'label'              => __( 'Toggle Source', 'zyre-elementor-addons' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'button',
				'options'            => [
					'button'        => __( 'Button', 'zyre-elementor-addons' ),
					'element-class' => __( 'Element Class', 'zyre-elementor-addons' ),
					'element-id'    => __( 'Element ID', 'zyre-elementor-addons' ),
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'toggle_position',
			[
				'label'     => __( 'Position', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'inline',
				'options'   => [
					'inline'   => __( 'Inline', 'zyre-elementor-addons' ),
					'floating' => __( 'Floating', 'zyre-elementor-addons' ),
				],
				'condition' => [
					'toggle_source' => ['button'],
				],
			]
		);

		$this->add_control(
			'floating_toggle_placement',
			[
				'label'        => __( 'Placement', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'middle-right',
				'options'      => [
					'top-left'      => __( 'Top Left', 'zyre-elementor-addons' ),
					'top-center'    => __( 'Top Center', 'zyre-elementor-addons' ),
					'top-right'     => __( 'Top Right', 'zyre-elementor-addons' ),
					'middle-left'   => __( 'Middle Left', 'zyre-elementor-addons' ),
					'middle-right'  => __( 'Middle Right', 'zyre-elementor-addons' ),
					'bottom-right'  => __( 'Bottom Right', 'zyre-elementor-addons' ),
					'bottom-center' => __( 'Bottom Center', 'zyre-elementor-addons' ),
					'bottom-left'   => __( 'Bottom Left', 'zyre-elementor-addons' ),
				],
				'selectors_dictionary' => [
					'top-left'      => 'top: 0; left: 0;',
					'top-center'    => 'top: 0; left: 50%; --translateX: -50%;',
					'top-right'     => 'top: 0; right: 0;',
					'middle-left'   => 'top: 50%; left: 0; --translateY: -50%;',
					'middle-right'  => 'top: 50%; right: 0; --translateY: -50%;',
					'bottom-right'  => 'bottom: 0; right: 0;',
					'bottom-center' => 'bottom: 0; left: 50%; --translateX: -50%;',
					'bottom-left'   => 'bottom: 0; left: 0;',
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-floating-element' => '{{VALUE}}',
				],
				'condition'    => [
					'toggle_source'   => ['button'],
					'toggle_position' => 'floating',
				],
			]
		);

		$this->add_control(
			'toggle_class',
			[
				'label'              => __( 'Toggle CSS Class', 'zyre-elementor-addons' ),
				'type'               => Controls_Manager::TEXT,
				'dynamic'            => [
					'active' => true,
				],
				'default'            => '',
				'frontend_available' => true,
				'condition'          => [
					'toggle_source' => 'element-class',
				],
			]
		);

		$this->add_control(
			'toggle_id',
			[
				'label'              => __( 'Toggle CSS ID', 'zyre-elementor-addons' ),
				'type'               => Controls_Manager::TEXT,
				'dynamic'            => [
					'active' => true,
				],
				'default'            => '',
				'frontend_available' => true,
				'condition'          => [
					'toggle_source' => 'element-id',
				],
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'     => __( 'Button Text', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'dynamic'   => [
					'active' => true,
				],
				'default'   => __( 'Menu', 'zyre-elementor-addons' ),
				'separator' => 'before',
				'condition' => [
					'toggle_source' => 'button',
				],
			]
		);

		$this->add_control(
			'button_icon',
			[
				'label'            => __( 'Button Icon', 'zyre-elementor-addons' ),
				'type'             => Controls_Manager::ICONS,
				'label_block'      => false,
				'skin'             => 'inline',
				'fa4compatibility' => 'button_icon_fa4',
				'default'          => [
					'value'   => 'fas fa-bars',
					'library' => 'fa-solid',
				],
				'condition'        => [
					'toggle_source' => 'button',
				],
			]
		);

		$this->add_control(
			'button_icon_close',
			[
				'label'            => __( 'Button Close Icon', 'zyre-elementor-addons' ),
				'type'             => Controls_Manager::ICONS,
				'label_block'      => false,
				'skin'             => 'inline',
				'fa4compatibility' => 'button_icon_close_fa4',
				'default'          => [
					'value'   => 'fas fa-times',
					'library' => 'fa-solid',
				],
				'condition'        => [
					'toggle_source'       => 'button',
					'button_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'button_icon_position',
			[
				'label'     => __( 'Icon Position', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'before',
				'options'   => [
					'before' => __( 'Before', 'zyre-elementor-addons' ),
					'after'  => __( 'After', 'zyre-elementor-addons' ),
				],
				'selectors_dictionary' => [
					'before' => '-webkit-box-ordinal-group: 1;-webkit-order: 0;-ms-flex-order: 0;order: 0;',
					'after'  => '-webkit-box-ordinal-group: 3;-webkit-order: 2;-ms-flex-order: 2;order: 2;',
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-offcanvas-toggle-icon' => '{{VALUE}}',
				],
				'condition' => [
					'toggle_source'       => 'button',
					'button_icon[value]!' => '',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __closebar_content_controls() {
		$this->start_controls_section(
			'section_closebar_content',
			[
				'label' => __( 'Close Bar', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'close_bar_absolute',
			[
				'label'        => __( 'Overlapping Close Button', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'zyre-elementor-addons' ),
				'label_off'    => __( 'No', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'close_bar_icon',
			[
				'label'            => __( 'Close Icon', 'zyre-elementor-addons' ),
				'type'             => Controls_Manager::ICONS,
				'label_block'      => false,
				'fa4compatibility' => 'close_bar_icon_fa4',
				'default'          => [
					'value'   => 'fas fa-times',
					'library' => 'fa-solid',
				],
				'recommended'      => [
					'fa-regular' => [
						'times-circle',
					],
					'fa-solid'   => [
						'times',
						'times-circle',
					],
				],
				'skin'             => 'inline',
			]
		);

		$this->add_control(
			'close_bar_button_title',
			[
				'label'              => __( 'Close Icon Title', 'zyre-elementor-addons' ),
				'type'               => Controls_Manager::TEXT,
				'default'            => '',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'close_bar_icon_position',
			[
				'label'                => __( 'Close Icon Position', 'zyre-elementor-addons' ),
				'type'                 => Controls_Manager::SELECT,
				'default'              => 'after',
				'options'              => [
					'before' => __( 'Before', 'zyre-elementor-addons' ),
					'after'  => __( 'After', 'zyre-elementor-addons' ),
				],
				'selectors_dictionary' => [
					'before' => '-webkit-box-ordinal-group: 1;-webkit-order: 0;-ms-flex-order: 0;order: 0;',
					'after'  => '-webkit-box-ordinal-group: 3;-webkit-order: 2;-ms-flex-order: 2;order: 2;',
				],
				'selectors'            => [
					'.zyre-offcanvas-close.zyre-offcanvas-close-{{ID}} .zyre-offcanvas-close-bar-icon' => '{{VALUE}}',
				],
				'condition'            => [
					'close_bar_icon[value]!'  => '',
					'close_bar_button_title!' => '',
				],
			]
		);

		$this->add_control(
			'close_button_align',
			[
				'label'     => __( 'Close Button Alignment', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'   => '',
				'selectors' => [
					'.zyre-offcanvas-content.zyre-offcanvas-content-{{ID}} .zyre-offcanvas-header' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __settings_content_controls() {
		$this->start_controls_section(
			'section_settings_content',
			[
				'label' => __( 'Settings', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'direction',
			[
				'label'              => __( 'Direction', 'zyre-elementor-addons' ),
				'type'               => Controls_Manager::CHOOSE,
				'label_block'        => false,
				'toggle'             => false,
				'default'            => is_rtl() ? 'left' : 'right',
				'options'            => [
					'left'   => [
						'title' => __( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right'  => [
						'title' => __( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
					'top'    => [
						'title' => __( 'Top', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-top',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'content_transition',
			[
				'label'              => __( 'Content Transition', 'zyre-elementor-addons' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'slide',
				'options'            => [
					'slide'       => __( 'Slide', 'zyre-elementor-addons' ),
					'reveal'      => __( 'Reveal', 'zyre-elementor-addons' ),
					'push'        => __( 'Push', 'zyre-elementor-addons' ),
					'slide-along' => __( 'Slide Along', 'zyre-elementor-addons' ),
				],
				'frontend_available' => true,
				'separator'          => 'after',
			]
		);

		$this->add_control(
			'esc_close',
			[
				'label'        => __( 'Esc to Close', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => __( 'Yes', 'zyre-elementor-addons' ),
				'label_off'    => __( 'No', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'body_click_close',
			[
				'label'        => __( 'Click anywhere to Close', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => __( 'Yes', 'zyre-elementor-addons' ),
				'label_off'    => __( 'No', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register styles related controls
	 */
	protected function register_style_controls() {
		$this->__general_style_controls();
		$this->__content_style_controls();
		$this->__toggle_style_controls();
		$this->__close_bar_style_controls();
	}

	protected function __general_style_controls() {
		$this->start_controls_section(
			'section_general_style',
			[
				'label' => __( 'General', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'content',
			[
				'controls' => [
					'width'         => [
						'priority' => true,
					],
					'height'        => [
						'priority' => true,
					],
					'height_2'      => [
						'label'    => __( 'Body Height', 'zyre-elementor-addons' ),
						'selector' => '.zyre-offcanvas-content.zyre-offcanvas-content-{{ID}} .zyre-offcanvas-body',
					],
					'position'      => [
						'separator' => 'after',
					],
					'border'        => [],
					'border_radius' => [],
					'box_shadow'    => [],
					'bg'            => [],
					'padding'       => [],
				],
				'selector' => '.zyre-offcanvas-content.zyre-offcanvas-content-{{ID}}',
			]
		);

		$this->set_style_controls(
			'overlay',
			[
				'controls' => [
					'heading'  => [
						'label'     => __( 'Overlay', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
					'bg_color' => [],
					'opacity'  => [
						'selector' => '.zyre-offcanvas-content-open .zyre-offcanvas-container:after',
					],
				],
				'selector' => '.zyre-offcanvas-container:after',
			]
		);

		$this->end_controls_section();
	}

	protected function __content_style_controls() {
		$this->start_controls_section(
			'section_content_style',
			[
				'label'     => __( 'Content', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'content_type' => 'custom',
				],
			]
		);

		$this->set_style_controls(
			'body',
			[
				'controls' => [
					'alignment'     => [],
					'bg_color'      => [],
					'padding'       => [
						'separator' => 'after',
					],
					'border'        => [],
					'border_radius' => [],
				],
				'selector' => '.zyre-offcanvas-content.zyre-offcanvas-content-{{ID}} .zyre-offcanvas-body',
			]
		);

		$this->set_style_controls(
			'title',
			[
				'controls'  => [
					'heading' => [
						'label'     => __( 'Title', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
					'typo'    => [],
					'color'   => [],
					'margin'  => [],
				],
				'selector'  => '.zyre-offcanvas-content.zyre-offcanvas-content-{{ID}} .zyre-offcanvas-content-title',
				'condition' => [
					'title!' => '',
				],
			]
		);

		$this->set_style_controls(
			'description',
			[
				'controls'  => [
					'heading' => [
						'label'     => __( 'Description', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
					'typo'    => [],
					'color'   => [],
				],
				'selector'  => '.zyre-offcanvas-content.zyre-offcanvas-content-{{ID}} .zyre-offcanvas-content-description *',
				'condition' => [
					'description!' => '',
				],
			]
		);

		$this->set_style_controls(
			'links',
			[
				'controls'  => [
					'heading' => [
						'label'     => __( 'Links', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
					'typo'    => [],
				],
				'selector'  => '.zyre-offcanvas-content.zyre-offcanvas-content-{{ID}} .zyre-offcanvas-content-description a',
				'condition' => [
					'description!' => '',
				],
			]
		);

		// Tabs: links tab
		$this->start_controls_tabs(
			'content_links_style_tabs',
			[
				'condition' => [
					'description!' => '',
				],
			]
		);

		// Tab: Normal
		$this->start_controls_tab(
			'content_links_style_tab_normal',
			[
				'label' => __( 'Normal', 'zyre-elementor-addons' ),
				'condition' => [
					'description!' => '',
				],
			]
		);

		$this->add_control(
			'links_color',
			[
				'label'     => __( 'Link Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.zyre-offcanvas-content.zyre-offcanvas-content-{{ID}} .zyre-offcanvas-content-description a' => 'color: {{VALUE}};',
				],
				'condition' => [
					'description!' => '',
				],
			]
		);

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab(
			'content_links_style_tab_hover',
			[
				'label' => __( 'Hover', 'zyre-elementor-addons' ),
				'condition' => [
					'description!' => '',
				],
			]
		);

		$this->add_control(
			'links_hover_color',
			[
				'label'     => __( 'Link Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.zyre-offcanvas-content.zyre-offcanvas-content-{{ID}} .zyre-offcanvas-content-description a:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
					'description!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function __toggle_style_controls() {
		$this->start_controls_section(
			'section_toggle_style',
			[
				'label'     => __( 'Toggle', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'toggle_source' => 'button',
				],
			]
		);

		$this->set_style_controls(
			'toggle_button',
			[
				'controls' => [
					'alignment'     => [
						'selector'  => '{{WRAPPER}} .zyre-offcanvas-toggle-wrap',
						'options' => [
							'left'   => [
								'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
								'icon'  => 'eicon-h-align-left',
							],
							'center' => [
								'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
								'icon'  => 'eicon-h-align-center',
							],
							'right'  => [
								'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
								'icon'  => 'eicon-h-align-right',
							],
						],
						'default' => is_rtl() ? 'right' : 'left',
					],
					'icon_size'     => [
						'selector'  => '{{WRAPPER}} .zyre-offcanvas-toggle-icon',
						'condition' => [
							'button_icon[value]!' => '',
						],
					],
					'border'        => [],
					'border_radius' => [],
					'box_shadow'    => [],
					'gap'           => [
						'label' => __( 'Space Between', 'zyre-elementor-addons' ),
					],
					'padding'       => [],
					'typo'          => [
						'selector'  => '{{WRAPPER}} .zyre-offcanvas-toggle-text',
						'condition' => [
							'button_text!' => '',
						],
					],
				],
				'selector' => '{{WRAPPER}} .zyre-offcanvas-toggle',
			]
		);

		// Tabs: links tab
		$this->start_controls_tabs( 'toggle_button_style_tabs' );

		// Tab: Normal
		$this->start_controls_tab(
			'toggle_button_style_tab_normal',
			[
				'label'     => __( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'toggle_button',
			[
				'controls' => [
					'bg'         => [],
					'icon_color' => [
						'selector'  => '{{WRAPPER}} .zyre-offcanvas-toggle-icon',
						'condition' => [
							'button_icon[value]!' => '',
						],
						'separator' => 'before',
					],
					'color'      => [
						'label'     => __( 'Text Color', 'zyre-elementor-addons' ),
						'selector'  => '{{WRAPPER}} .zyre-offcanvas-toggle-text',
						'condition' => [
							'button_text!' => '',
						],
					],
				],
				'selector' => '{{WRAPPER}} .zyre-offcanvas-toggle',
			]
		);

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab(
			'toggle_button_style_tab_hover',
			[
				'label'     => __( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'toggle_button_hover',
			[
				'controls' => [
					'bg'           => [],
					'border_color' => [
						'separator' => 'before',
					],
					'icon_color'   => [
						'selector'  => '{{WRAPPER}} .zyre-offcanvas-toggle:hover .zyre-offcanvas-toggle-icon',
						'condition' => [
							'button_icon[value]!' => '',
						],
					],
					'color'        => [
						'label'     => __( 'Text Color', 'zyre-elementor-addons' ),
						'selector'  => '{{WRAPPER}} .zyre-offcanvas-toggle:hover .zyre-offcanvas-toggle-text',
						'condition' => [
							'button_text!' => '',
						],
					],
				],
				'selector' => '{{WRAPPER}} .zyre-offcanvas-toggle:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->set_style_controls(
			'toggle_floating',
			[
				'controls'  => [
					'heading'  => [
						'label'     => __( 'Floating Styles', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
					'zindex'   => [],
					'offset_x' => [],
					'offset_y' => [],
				],
				'selector'  => '{{WRAPPER}} .zyre-floating-element',
				'condition' => [
					'toggle_position' => 'floating',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __close_bar_style_controls() {
		$this->start_controls_section(
			'section_close_bar_style',
			[
				'label'     => __( 'Close Bar', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'close_bar_icon[value]',
							'operator' => '!=',
							'value'    => '',
						],
						[
							'name'     => 'close_bar_button_title',
							'operator' => '!=',
							'value'    => '',
						],
					]
				],
			]
		);

		$this->set_style_controls(
			'close_bar_button',
			[
				'controls' => [
					'icon_size'     => [
						'selector'  => '.zyre-offcanvas-content.zyre-offcanvas-content-{{ID}} .zyre-offcanvas-close-bar-icon',
						'condition' => [
							'close_bar_icon[value]!' => '',
						],
					],
					'border'        => [],
					'border_radius' => [],
					'box_shadow'    => [],
					'gap'           => [
						'label' => __( 'Space Between', 'zyre-elementor-addons' ),
					],
					'padding'       => [],
					'typo'          => [
						'selector'  => '.zyre-offcanvas-content.zyre-offcanvas-content-{{ID}} .zyre-offcanvas-close-bar-title',
						'condition' => [
							'close_bar_button_title!' => '',
						],
					],
				],
				'selector' => '.zyre-offcanvas-content.zyre-offcanvas-content-{{ID}} .zyre-offcanvas-close',
			]
		);

		// Tabs: links tab
		$this->start_controls_tabs( 'close_bar_style_tabs' );

		// Tab: Normal
		$this->start_controls_tab(
			'close_bar_style_tab_normal',
			[
				'label'     => __( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'close_bar_button',
			[
				'controls' => [
					'bg'         => [],
					'icon_color' => [
						'selector'  => '.zyre-offcanvas-content.zyre-offcanvas-content-{{ID}} .zyre-offcanvas-close-bar-icon',
						'condition' => [
							'close_bar_icon[value]!' => '',
						],
						'separator' => 'before',
					],
					'color'      => [
						'label'     => __( 'Text Color', 'zyre-elementor-addons' ),
						'selector'  => '.zyre-offcanvas-content.zyre-offcanvas-content-{{ID}} .zyre-offcanvas-close-bar-title',
						'condition' => [
							'close_bar_button_title!' => '',
						],
					],
				],
				'selector' => '.zyre-offcanvas-content.zyre-offcanvas-content-{{ID}} .zyre-offcanvas-close',
			]
		);

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab(
			'close_bar_style_tab_hover',
			[
				'label'     => __( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'close_bar_button_hover',
			[
				'controls' => [
					'bg'           => [],
					'border_color' => [
						'separator' => 'before',
					],
					'icon_color'   => [
						'selector'  => '.zyre-offcanvas-content.zyre-offcanvas-content-{{ID}} .zyre-offcanvas-close:hover .zyre-offcanvas-close-bar-icon',
						'condition' => [
							'close_bar_icon[value]!' => '',
						],
					],
					'color'        => [
						'label'     => __( 'Text Color', 'zyre-elementor-addons' ),
						'selector'  => '.zyre-offcanvas-content.zyre-offcanvas-content-{{ID}} .zyre-offcanvas-close:hover .zyre-offcanvas-close-bar-title',
						'condition' => [
							'close_bar_button_title!' => '',
						],
					],
				],
				'selector' => '.zyre-offcanvas-content.zyre-offcanvas-content-{{ID}} .zyre-offcanvas-close:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->set_style_controls(
			'close_bar_wrapper',
			[
				'controls' => [
					'heading'  => [
						'label'     => __( 'Button Wrapper', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
					'padding'  => [],
					'position' => [
						'options'   => [
							'left'  => [
								'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
								'icon'  => 'eicon-h-align-left',
							],
							'right' => [
								'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
								'icon'  => 'eicon-h-align-right',
							],
						],
						'condition' => [
							'close_bar_absolute' => 'yes',
						],
					],
					'offset_x' => [
						'condition' => [
							'close_bar_absolute' => 'yes',
						],
					],
					'offset_y' => [
						'condition' => [
							'close_bar_absolute' => 'yes',
						],
					],
				],
				'selector' => '.zyre-offcanvas-content.zyre-offcanvas-content-{{ID}} .zyre-offcanvas-header',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register render display controls
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$settings_atts = [
			'toggle_source'     => esc_attr( $settings['toggle_source'] ),
			'toggle_id'         => esc_attr( $settings['toggle_id'] ),
			'toggle_class'      => esc_attr( $settings['toggle_class'] ),
			'content_id'        => esc_attr( $this->get_id() ),
			'transition'        => esc_attr( $settings['content_transition'] ),
			'direction'         => esc_attr( $settings['direction'] ),
			'esc_close'         => esc_attr( $settings['esc_close'] ),
			'body_click_close'  => esc_attr( $settings['body_click_close'] ),
		];

		$this->add_render_attribute( 'content-wrap', 'class', 'zyre-offcanvas-content-wrap' );

		$this->add_render_attribute( 'content-wrap', 'data-settings', htmlspecialchars( json_encode( $settings_atts ) ) );

		$this->add_render_attribute( 'content', 'class', [
			'zyre-offcanvas-content',
			'zyre-offcanvas-content-' . esc_attr( $this->get_id() ),
			'zyre-offcanvas-' . esc_attr( $settings['content_transition'] ),
			'elementor-element-' . esc_attr( $this->get_id() ),
		] );

		$this->add_render_attribute( 'content', 'class', 'zyre-offcanvas-content-' . esc_attr( $settings['direction'] ) );

		$this->add_render_attribute( 'toggle-button', 'class', [
			'zyre-offcanvas-toggle',
			'zyre-offcanvas-toggle-' . esc_attr( $this->get_id() ),
			'zy-flex zy-align-center zy-c-pointer zy-gap-1',
		] );

		$this->add_render_attribute( 'hamburger', 'class', [
			'zyre-offcanvas-toggle',
			'zyre-offcanvas-toggle-' . esc_attr( $this->get_id() ),
			'elementor-button',
			'zyre-hamburger',
		] );
		?>

		<div <?php $this->print_render_attribute_string( 'content-wrap' ); ?>>
			<?php $this->render_toggle(); ?>

			<!-- Placeholder for editor. Will not be rendered on the frontend. -->
			<?php 
			if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) :
				$has_placeholder = false;
				$placeholder = '';

				if ( 'button' !== $settings['toggle_source'] ) {
					$has_placeholder = true;
					$placeholder = __( 'You have chosen to open the off canvas using a different element.', 'zyre-elementor-addons' );
				}

				if ( 'button' === $settings['toggle_source'] && 'floating' === $settings['toggle_position'] ) {
					$has_placeholder = true;
					$placeholder = __( 'You’ve set the offcanvas toggle to float, keeping it fixed on the screen.', 'zyre-elementor-addons' );
				}
				
				$args = [];
				$defaults = [
					'title' => $this->get_title(),
					'body'  => $placeholder,
				];
				$args = wp_parse_args( $args, $defaults );

				$this->add_render_attribute([
					'placeholder' => [
						'class' => 'zyre-offcanvas-placeholder zy-text-center zy-p-4',
					],
					'placeholder-title' => [
						'class' => 'zyre-offcanvas-placeholder-title zy-m-0 zy-mb-1 zy-fs-1.2 zy-fw-bold',
					],
					'placeholder-content' => [
						'class' => 'zyre-offcanvas-placeholder-content zy-m-0',
					],
				]);

				if ( $has_placeholder ) {
					?>
					<div <?php $this->print_render_attribute_string( 'placeholder' ); ?>>
						<h3 <?php $this->print_render_attribute_string( 'placeholder-title' ); ?>><?php echo esc_html( $args['title'] ); ?></h3>
						<p <?php $this->print_render_attribute_string( 'placeholder-content' ); ?>><?php echo esc_html( $args['body'] ); ?></p>
					</div>
					<?php
				}
			endif;
			?>

			<div <?php $this->print_render_attribute_string( 'content' ); ?>>
				<?php $this->render_close_bar_button(); ?>

				<div class="zyre-offcanvas-body">
					<?php
					if ( 'sidebar' === $settings['content_type'] ) {
						$this->render_sidebar();
					} elseif ( 'custom' === $settings['content_type'] ) {
						$this->render_custom_content();
					} elseif ( 'section' === $settings['content_type'] && ! empty( $settings['saved_section'] ) ) {
						$saved_section = apply_filters('wpml_object_id', $settings['saved_section'], 'elementor_library');

						echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $saved_section ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

					} elseif ( 'template' === $settings['content_type'] && ! empty( $settings['templates'] ) ) {
						$templates = apply_filters('wpml_object_id', $settings['templates'], 'elementor_library');

						echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $templates ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

					} elseif ( 'widget' === $settings['content_type'] && ! empty( $settings['saved_widget'] ) ) {
						$saved_widget = apply_filters('wpml_object_id', $settings['saved_widget'], 'elementor_library');

						echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $saved_widget ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					}
					?>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render toggle output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render_toggle() {
		$settings = $this->get_settings_for_display();

		if ( 'button' !== $settings['toggle_source'] ) {
			return;
		}

		$this->add_render_attribute( 'toggle-wrap', 'class', 'zyre-offcanvas-toggle-wrap' );

		if ( 'floating' === $settings['toggle_position'] ) {
			$this->add_render_attribute( 'toggle-wrap', 'class', 'zyre-floating-element' );
		}

		// Button Icon
		if ( ! isset( $settings['button_icon_fa4'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['button_icon_fa4'] = '';
		}

		$has_icon = ! empty( $settings['button_icon_fa4'] );

		if ( $has_icon ) {
			$this->add_render_attribute( 'i', 'class', $settings['button_icon_fa4'] );
			$this->add_render_attribute( 'i', 'aria-hidden', 'true' );
		}

		if ( ! $has_icon && ! empty( $settings['button_icon']['value'] ) ) {
			$has_icon = true;
		}
		$migrated = isset( $settings['__fa4_migrated']['button_icon'] );
		$is_new = ! isset( $settings['button_icon_fa4'] ) && Icons_Manager::is_migration_allowed();

		// Button Close Icon
		if ( ! isset( $settings['button_icon_close_fa4'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['button_icon_close_fa4'] = '';
		}

		$has_close_icon = ! empty( $settings['button_icon_close_fa4'] );

		if ( $has_close_icon ) {
			$this->add_render_attribute( 'i', 'class', $settings['button_icon_close_fa4'] );
			$this->add_render_attribute( 'i', 'aria-hidden', 'true' );
		}

		if ( ! $has_close_icon && ! empty( $settings['button_icon_close']['value'] ) ) {
			$has_close_icon = true;
		}
		$migrated_close_icon = isset( $settings['__fa4_migrated']['button_icon_close'] );
		$is_new_close_icon = ! isset( $settings['button_icon_close_fa4'] ) && Icons_Manager::is_migration_allowed();
		?>

		<div <?php $this->print_render_attribute_string( 'toggle-wrap' ); ?>>
			<div <?php $this->print_render_attribute_string( 'toggle-button' ); ?>>
				<?php if ( $has_icon ) : ?>
					<span class="zyre-offcanvas-toggle-icon zyre-offcanvas-toggle-icon-open">
						<?php
						if ( $is_new || $migrated ) {
							Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] );
						} elseif ( ! empty( $settings['button_icon_fa4'] ) ) {
							?><i <?php echo wp_kses_post( $this->get_render_attribute_string( 'i' ) ); ?>></i><?php
						}
						?>
					</span>
				<?php endif; ?>

				<?php if ( $has_close_icon ) : ?>
					<span class="zyre-offcanvas-toggle-icon zyre-offcanvas-toggle-icon-close">
						<?php
						if ( $is_new_close_icon || $migrated_close_icon ) {
							Icons_Manager::render_icon( $settings['button_icon_close'], [ 'aria-hidden' => 'true' ] );
						} elseif ( ! empty( $settings['button_icon_close_fa4'] ) ) {
							?><i <?php echo wp_kses_post( $this->get_render_attribute_string( 'i' ) ); ?>></i><?php
						}
						?>
					</span>
				<?php endif; ?>

				<?php if ( ! empty( $settings['button_text'] ) ) : ?>
					<span class="zyre-offcanvas-toggle-text">
						<?php echo esc_html( $settings['button_text'] ); ?>
					</span>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Render sidebar content output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render_close_bar_button() {
		$settings = $this->get_settings_for_display();

		if ( ! isset( $settings['close_bar_icon_fa4'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['close_bar_icon_fa4'] = '';
		}

		$has_icon = ! empty( $settings['close_bar_icon_fa4'] );

		if ( $has_icon ) {
			$this->add_render_attribute( 'i', 'class', $settings['close_bar_icon_fa4'] );
			$this->add_render_attribute( 'i', 'aria-hidden', 'true' );
		}

		if ( ! $has_icon && ! empty( $settings['close_bar_icon']['value'] ) ) {
			$has_icon = true;
		}
		$migrated = isset( $settings['__fa4_migrated']['close_bar_icon'] );
		$is_new = ! isset( $settings['close_bar_icon_fa4'] ) && Icons_Manager::is_migration_allowed();

		$this->add_render_attribute( 'close-button', 'class',
			[
				'zyre-offcanvas-close',
				'zyre-offcanvas-close-' . $this->get_id(),
			]
		);

		$this->add_render_attribute( 'close-button', 'role', 'button' );

		$wrap_class = '';

		if ( 'yes' === $settings['close_bar_absolute'] ) {
			$wrap_class .= ' zy-absolute zy-w-100';
		}
		?>

		<?php if ( $settings['close_bar_button_title'] || $has_icon ) : ?>		
			<div class="zyre-offcanvas-header<?php echo esc_attr( $wrap_class ); ?>">
				<div <?php $this->print_render_attribute_string( 'close-button' ); ?>>
					<?php if ( $has_icon ) : ?>
						<span class="zyre-offcanvas-close-bar-icon">
							<?php
							if ( $is_new || $migrated ) {
								Icons_Manager::render_icon( $settings['close_bar_icon'], [ 'aria-hidden' => 'true' ] );
							} elseif ( ! empty( $settings['close_bar_icon_fa4'] ) ) {
								?><i <?php echo wp_kses_post( $this->get_render_attribute_string( 'i' ) ); ?>></i><?php
							}
							?>
						</span>
					<?php endif; ?>
					<?php if ( $settings['close_bar_button_title'] ) : ?>
						<span class="zyre-offcanvas-close-bar-title zyre-offcanvas-close-bar-title-after"><?php echo esc_html( $settings['close_bar_button_title'] ); ?></span>
					<?php endif; ?>
				</div>
			</div>
		<?php endif;
	}

	/**
	 * Render sidebar content output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render_sidebar() {
		$settings = $this->get_settings_for_display();

		$sidebar = $settings['sidebar'];

		if ( empty( $sidebar ) ) {
			return;
		}

		dynamic_sidebar( $sidebar );
	}

	/**
	 * Render saved template output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render_custom_content() {
		$settings = $this->get_settings_for_display();

		if ( $settings['title'] || $settings['description'] ) :
			?>
			<div class="zyre-offcanvas-custom-content">
				<?php if ( $settings['title']) : ?>
					<h3 class="zyre-offcanvas-content-title">
						<?php echo esc_html( $settings['title'] ); ?>
					</h3>
				<?php endif; ?>
				<?php if ( $settings['description'] ) : ?>
					<div class="zyre-offcanvas-content-description">
						<?php echo wp_kses_post( $settings['description'] ); ?>
					</div>
				<?php endif; ?>
			</div>
			<?php
		endif;
	}
}
