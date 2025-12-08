<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use ZyreAddons\Elementor\Traits\Button_Trait;

defined( 'ABSPATH' ) || die();

/**
 * IconBox widget class
 *
 * @since 1.0.0
 * @package ZyreAddons
 */
class IconBox extends Base {

	use Button_Trait;

	/**
	 * Get widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Icon Box', 'zyre-elementor-addons' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'zy-fonticon zy-Iconbox';
	}

	/**
	 * Get widget search keywords.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_keywords() {
		return [ 'icon', 'box', 'iconbox', 'info', 'infobox', 'content' ];
	}

	/**
	 * Register widget content controls
	 */
	protected function register_content_controls() {
		$this->start_controls_section(
			'section_iconbox_content',
			[
				'label' => esc_html__( 'General Content', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$this->add_control(
			'iconbox_icon',
			[
				'label'       => esc_html__( 'Icon', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => [
					'value'   => 'fas fa-home',
					'library' => 'fa-solid',
				],
				'skin'        => 'inline',
				'label_block' => false,
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'zyre-elementor-addons' ),
				'default'     => esc_html__( 'Icon Box Title', 'zyre-elementor-addons' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Type Icon Box Title', 'zyre-elementor-addons' ),
				'dynamic'     => [
					'active' => true,
				],
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'   => esc_html__( 'Title HTML Tag', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'h1' => [
						'title' => esc_html__( 'H1', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-editor-h1',
					],
					'h2' => [
						'title' => esc_html__( 'H2', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-editor-h2',
					],
					'h3' => [
						'title' => esc_html__( 'H3', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-editor-h3',
					],
					'h4' => [
						'title' => esc_html__( 'H4', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-editor-h4',
					],
					'h5' => [
						'title' => esc_html__( 'H5', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-editor-h5',
					],
					'h6' => [
						'title' => esc_html__( 'H6', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-editor-h6',
					],
				],
				'default' => 'h2',
				'toggle'  => false,
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label'       => esc_html__( 'Subtitle', 'zyre-elementor-addons' ),
				'default'     => esc_html__( 'Icon Box Subtitle', 'zyre-elementor-addons' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Type Icon Box Subtitle', 'zyre-elementor-addons' ),
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'zyre-elementor-addons' ),
				'description' => zyre_get_allowed_html_desc(),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Type info box description', 'zyre-elementor-addons' ),
				'rows'        => 5,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->end_controls_section();

		// Button Content
		$this->start_controls_section(
			'section_button_content',
			[
				'label' => esc_html__( 'Button Content', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->register_button_content_controls(
			[
				'button_default_text' => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register widget style controls
	 */
	protected function register_style_controls() {
		$this->__box_style_controls();
		$this->__media_style_controls();
		$this->__content_style_controls();
		$this->__title_style_controls();
		$this->__subtitle_style_controls();
		$this->__description_style_controls();
		$this->__button_style_controls();
		$this->__button_icon_style_controls();
	}

	/**
	 * Box style controls
	 */
	protected function __box_style_controls() {
		$this->start_controls_section(
			'section_box_style',
			[
				'label' => esc_html__( 'Box', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Space Between Media & Content.
		$this->set_style_controls(
			'box',
			[
				'selector' => '{{WRAPPER}}.zyre-addon-iconbox .elementor-widget-container',
				'controls' => [
					'gap'       => [
						'label'       => __( 'Spacing', 'zyre-elementor-addons' ),
						'description' => __( 'Space between Media Icon & Content.', 'zyre-elementor-addons' ),
						'condition'   => [
							'iconbox_icon[value]!' => '',
						],
					],
					'height'    => [],
					'justify_y' => [
						'label_block' => true,
						'condition'   => [
							'iconbox_icon[value]!'  => '',
							'iconbox_icon_position' => 'top',
						],
					],
				],
			]
		);

		$this->start_controls_tabs( 'box_style' );

		$this->start_controls_tab(
			'box_normal_style',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'iconbox',
			[
				'selector' => '{{WRAPPER}} .elementor-widget-container',
				'controls' => [
					'bg'         => [
						'fields_options' => [
							'background' => [
								'default' => 'classic',
							],
						],
					],
					'border'     => [],
					'box_shadow' => [],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'box_hover_style',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'iconbox_hover',
			[
				'selector' => '{{WRAPPER}} .elementor-widget-container:hover',
				'controls' => [
					'bg'         => [
						'selector'       => '{{WRAPPER}} .elementor-widget-container::before',
						'fields_options' => [
							'background' => [
								'default' => 'classic',
							],
						],
					],
					'border'     => [],
					'box_shadow' => [],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->set_style_controls(
			'iconbox',
			[
				'selector' => '{{WRAPPER}} .elementor-widget-container',
				'controls' => [
					'border_radius' => [
						'selector' => '{{WRAPPER}} .elementor-widget-container, {{WRAPPER}} .elementor-widget-container::before',
					],
					'padding'       => [],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Icon and Image style controls
	 */
	protected function __media_style_controls() {
		$this->start_controls_section(
			'section_icon_style',
			[
				'label'     => esc_html__( 'Icon', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'iconbox_icon[value]!' => '',
				],
			]
		);

		$this->set_style_controls(
			'iconbox',
			[
				'selector' => '{{WRAPPER}} .zyre-iconbox-icon',
				'controls' => [
					'icon_size' => [
						'size_units' => [ 'px' ],
						'range'      => [
							'px' => [
								'min' => 6,
								'max' => 600,
							],
						],
					],
					'width'     => [
						'label' => esc_html__( 'Icon Width', 'zyre-elementor-addons' ),
					],
					'height'    => [
						'label' => esc_html__( 'Icon Height', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->add_responsive_control(
			'iconbox_icon_position',
			[
				'label'                => esc_html__( 'Icon Position', 'zyre-elementor-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'left'  => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'top'   => [
						'title' => esc_html__( 'Top', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-top',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'              => 'top',
				'toggle'               => false,
				'selectors_dictionary' => [
					'left'  => '-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;-ms-flex-direction:row;flex-direction:row;text-align:left;--flex-grow: 1;',
					'top'   => '-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;-ms-flex-direction:column;flex-direction:column;text-align:center;--flex-grow: 0;',
					'right' => '-webkit-box-orient:horizontal;-webkit-box-direction:reverse;-webkit-flex-direction:row-reverse;-ms-flex-direction:row-reverse;flex-direction:row-reverse;text-align:right;--flex-grow: 1;',
				],
				'selectors'            => [
					'{{WRAPPER}} .elementor-widget-container' => '{{VALUE}}',
				],
				'prefix_class'         => 'zyre-iconbox-media-dir%s-',
				'condition'            => [
					'iconbox_icon[value]!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'iconbox_media_y_position',
			[
				'label'                => esc_html__( 'Vertical Alignment', 'zyre-elementor-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'top'     => [
						'title' => esc_html__( 'Top', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-top',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom'  => [
						'title' => esc_html__( 'Bottom', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-bottom',
					],
					'stretch' => [
						'title' => esc_html__( 'Stretch', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-stretch',
					],
				],
				'default'              => 'top',
				'toggle'               => false,
				'condition'            => [
					'iconbox_icon_position' => [ 'left', 'right' ],
					'iconbox_icon[value]!'  => '',
				],
				'selectors_dictionary' => [
					'top'     => '-webkit-align-self: flex-start; -ms-flex-item-align: start; align-self: flex-start;',
					'center'  => '-webkit-align-self: center; -ms-flex-item-align: center; align-self: center;',
					'bottom'  => '-webkit-align-self: flex-end; -ms-flex-item-align: end; align-self: flex-end;',
					'stretch' => '-webkit-align-self: stretch; -ms-flex-item-align: stretch; align-self: stretch;',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-iconbox-icon' => '{{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'iconbox_media_align',
			[
				'label'                => esc_html__( 'Horizontal Alignment', 'zyre-elementor-addons' ),
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
				'toggle'               => true,
				'condition'            => [
					'iconbox_icon[value]!' => '',
				],
				'selectors_dictionary' => [
					'left'   => '-webkit-box-pack:start;-moz-box-pack:start;-ms-flex-pack:start;-webkit-justify-content:flex-start;justify-content:flex-start;',
					'center' => '-webkit-box-pack:center;-moz-box-pack:center;-ms-flex-pack:center;-webkit-justify-content:center;justify-content:center;',
					'right'  => '-webkit-box-pack:end;-moz-box-pack:end;-ms-flex-pack:end;-webkit-justify-content:flex-end;justify-content:flex-end;',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-iconbox-media' => '{{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'icon_style' );

		$this->start_controls_tab(
			'icon_normal_style',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'icon',
			[
				'selector' => '{{WRAPPER}} .zyre-iconbox-icon',
				'controls' => [
					'icon_color' => [],
					'bg' => [
						'fields_options' => [
							'background' => [
								'default' => 'classic',
							],
						],
					],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'icon_hover_style',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'icon_hover_style_switch',
			[
				'label'     => esc_html__( 'When hover over the Box.', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'ON', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'OFF', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'render_type'  => 'template', // Ensures live preview updates
				'prefix_class'   => 'zyre-addon-iconbox-hover-',
			]
		);

		$this->add_control(
			'icon_hover_color',
			[
				'label'     => esc_html__( 'Icon Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}:not(.zyre-addon-iconbox-hover-yes) .zyre-iconbox-icon:hover i'   => 'color: {{VALUE}}',
					'{{WRAPPER}}:not(.zyre-addon-iconbox-hover-yes) .zyre-iconbox-icon:hover svg' => 'fill: {{VALUE}}',
					'{{WRAPPER}}.zyre-addon-iconbox-hover-yes .elementor-widget-container:hover .zyre-iconbox-icon i'   => 'color: {{VALUE}}',
					'{{WRAPPER}}.zyre-addon-iconbox-hover-yes .elementor-widget-container:hover .zyre-iconbox-icon svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->set_style_controls(
			'icon_hover',
			[
				'selector' => '{{WRAPPER}} .zyre-iconbox-icon::before',
				'controls' => [
					'bg' => [
						'fields_options' => [
							'background' => [
								'default' => 'classic',
							],
						],
					],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'_heading_title_icon_border',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Icon Border', 'zyre-elementor-addons' ),
				'separator' => 'before',
			]
		);

		$this->set_style_controls(
			'icon',
			[
				'selector' => '{{WRAPPER}} .zyre-iconbox-icon',
				'controls' => [
					'border' => [],
					'border_radius' => [
						'selector' => '{{WRAPPER}} .zyre-iconbox-icon, {{WRAPPER}} .zyre-iconbox-icon::before',
					],
					'padding' => [
						'label'      => esc_html__( 'Icon Padding', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->add_control(
			'_heading_title_icon_wrapper',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Icon Wrapper', 'zyre-elementor-addons' ),
				'separator' => 'before',
			]
		);

		$this->set_style_controls(
			'media',
			[
				'selector' => '{{WRAPPER}} .zyre-iconbox-media',
				'controls' => [
					'bg_color'      => [],
					'border'        => [],
					'border_radius' => [],
					'padding'       => [],
					'box_shadow'    => [],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Content style controls
	 */
	protected function __content_style_controls() {
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'content',
			[
				'selector' => '{{WRAPPER}} .zyre-iconbox-content',
				'controls' => [
					'gap'       => [
						'label' => esc_html__( 'Content Spacing', 'zyre-elementor-addons' ),
					],
					'alignment' => [
						'label'        => esc_html__( 'Content Alignment', 'zyre-elementor-addons' ),
						'prefix_class' => 'zyre%s-iconbox-content-align-',
					],
				],
			]
		);

		$this->add_responsive_control(
			'content_alignment_y_position',
			[
				'label'                => esc_html__( 'Vertical Alignment', 'zyre-elementor-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'top'     => [
						'title' => esc_html__( 'Top', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-top',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom'  => [
						'title' => esc_html__( 'Bottom', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-bottom',
					],
					'stretch' => [
						'title' => esc_html__( 'Stretch', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-stretch',
					],
				],
				'default'              => 'top',
				'toggle'               => false,
				'condition'            => [
					'iconbox_icon_position' => [ 'left', 'right' ],
					'iconbox_icon[value]!'  => '',
				],
				'selectors_dictionary' => [
					'top'     => '-webkit-align-self: flex-start; -ms-flex-item-align: start; align-self: flex-start;',
					'center'  => '-webkit-align-self: center; -ms-flex-item-align: center; align-self: center;',
					'bottom'  => '-webkit-align-self: flex-end; -ms-flex-item-align: end; align-self: flex-end;',
					'stretch' => '-webkit-align-self: stretch; -ms-flex-item-align: stretch; align-self: stretch;',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-iconbox-content' => '{{VALUE}};',
				],
			]
		);

		$this->set_style_controls(
			'content',
			[
				'selector' => '{{WRAPPER}} .zyre-iconbox-content',
				'controls' => [
					'border'  => [],
					'padding' => [],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Title style controls.
	 */
	protected function __title_style_controls() {
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'title!' => '',
				],
			]
		);

		$this->text_style_controls( 'title' );

		$this->end_controls_section();
	}

	/**
	 * Subtitle style controls.
	 */
	protected function __subtitle_style_controls() {
		$this->start_controls_section(
			'section_subtitle_style',
			[
				'label' => esc_html__( 'Subtitle', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'subtitle!' => '',
				],
			]
		);

		$this->text_style_controls( 'subtitle' );

		$this->end_controls_section();
	}

	/**
	 * Description style controls.
	 */
	protected function __description_style_controls() {
		$this->start_controls_section(
			'section_description_style',
			[
				'label' => esc_html__( 'Description', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'description!' => '',
				],
			]
		);

		$this->text_style_controls( 'description' );

		$this->end_controls_section();
	}

	/**
	 * Text Style Controls for all sections.
	 *
	 * @param string $prefix The prefix of the controls.
	 */
	private function text_style_controls( string $prefix ) {
		$class_base = str_replace( '_', '-', $prefix );

		$this->set_style_controls(
			$prefix,
			[
				'selector' => '{{WRAPPER}} .zyre-iconbox-' . $class_base,
				'controls' => [
					'typography' => [
						'fields_options' => [
							'typography'  => [ 'default' => 'yes' ],
							'font_size'   => [
								'default' => [
									'unit' => 'px',
								],
							],
							'line_height' => [
								'default' => [
									'unit' => 'em',
								],
							],
						],
					],
					'margin'     => [],
				],
			]
		);

		$this->start_controls_tabs( $prefix . '_tabs' );

		$this->start_controls_tab(
			$prefix . '_tab_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			$prefix,
			[
				'selector' => '{{WRAPPER}} .zyre-iconbox-' . $class_base,
				'controls' => [
					'color' => [
						'default' => '#000000',
					],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			$prefix . '_tab_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			$prefix . '_hover',
			[
				'selector' => '{{WRAPPER}} .elementor-widget-container:hover .zyre-iconbox-' . $class_base,
				'controls' => [
					'color' => [],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
	}

	/**
	 * Button style controls
	 */
	protected function __button_style_controls() {
		$this->start_controls_section(
			'section_button_style',
			[
				'label'     => esc_html__( 'Button', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'button_text[value]!' => '',
				],
			]
		);

		$this->register_button_style_controls();

		$this->end_controls_section();
	}

	/**
	 * Button icon style controls
	 */
	protected function __button_icon_style_controls() {
		$this->start_controls_section(
			'section_button_icon_style',
			[
				'label'     => esc_html__( 'Button Icon', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'button_icon[value]!' => '',
				],
			]
		);

		$this->register_button_icon_style_controls();

		$this->end_controls_section();
	}

	/**
	 * Rendering HTML
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'iconbox_media', 'class', 'zyre-iconbox-media zy-index-1 zy-relative zy-inline-flex zy-justify-center' );
		$this->add_render_attribute( 'iconbox_icon', 'class', 'zyre-iconbox-icon zy-inline-block zy-relative zy-overflow-hidden zy-content-center zy-justify-items-center' );

		$this->add_inline_editing_attributes( 'title' );
		$this->add_render_attribute( 'title', 'class', 'zyre-iconbox-title zy-m-0' );

		$this->add_inline_editing_attributes( 'subtitle' );
		$this->add_render_attribute( 'subtitle', 'class', 'zyre-iconbox-subtitle zy-m-0' );

		$this->add_inline_editing_attributes( 'description' );
		$this->add_render_attribute( 'description', 'class', 'zyre-iconbox-description zy-m-0' );

		if ( $settings['iconbox_icon']['value'] ) {?>
			<div <?php $this->print_render_attribute_string( 'iconbox_media' ); ?>>
				<span <?php $this->print_render_attribute_string( 'iconbox_icon' ); ?>><?php Icons_Manager::render_icon( $settings['iconbox_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
			</div>
		<?php } ?>

		<?php if ( $settings['title'] || $settings['subtitle'] || $settings['description'] || $settings['button_text'] ) : ?>
		<div class="zyre-iconbox-content zy-index-1 zy-relative zy-inline-flex zy-direction-column">
			<?php if ( $settings['title'] || $settings['subtitle'] ) : ?>
				<div class="zyre-iconbox-titles zy-flex zy-direction-column">
					<?php
					if ( $settings['title'] ) :
						printf(
							'<%1$s %2$s>%3$s</%1$s>',
							zyre_escape_tags( $settings['title_tag'], 'h2' ),
							$this->get_render_attribute_string( 'title' ),
							wp_kses( $settings['title'], zyre_get_allowed_html( 'basic' ) )
						);
					endif;
					?>

					<?php if ( $settings['subtitle'] ) : ?>
						<p <?php $this->print_render_attribute_string( 'subtitle' ); ?>>
							<?php echo zyre_kses_basic( $settings['subtitle'] ); ?>
						</p>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( $settings['description'] ) : ?>
				<p <?php $this->print_render_attribute_string( 'description' ); ?>><?php echo zyre_kses_basic( $settings['description'] ); ?></p>
			<?php endif; ?>

			<?php $this->render_button(); ?>
		</div>
		<?php endif;
	}
}
