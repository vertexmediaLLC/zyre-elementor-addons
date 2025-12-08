<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;

defined( 'ABSPATH' ) || die();

class Heading extends Base {

	public function get_title() {
		return esc_html__( 'Heading', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Text-t';
	}

	public function get_keywords() {
		return [ 'heading', 'advance heading', 'title', 'text', 'content', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ];
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	protected function register_content_controls() {
		$this->start_controls_section(
			'section_heading',
			[
				'label' => esc_html__( 'Heading Content', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$this->__title_content_controls();

		$this->__subtitle_content_controls();

		$this->__description_content_controls();

		$this->add_control(
			'heading_css_class',
			[
				'label'       => esc_html__( 'Class', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Class Name', 'zyre-elementor-addons' ),
				'prefix_class' => '',
			]
		);

		$this->end_controls_section();
	}

	protected function __title_content_controls() {
		$this->add_control(
			'heading_title',
			[
				'label'   => esc_html__( 'Title', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Title', 'zyre-elementor-addons' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'heading_suffix',
			[
				'label'       => esc_html__( 'Suffix', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'condition'   => [
					'heading_title!' => '',
				],
			]
		);

		$this->add_control(
			'heading_title_tag',
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
				'condition'   => [
					'heading_title!' => '',
				],
			]
		);
	}

	protected function __subtitle_content_controls() {
		$this->add_control(
			'subtitle',
			[
				'label'   => esc_html__( 'Subtitle', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Sub Title', 'zyre-elementor-addons' ),
				'dynamic' => ['active' => true],
			]
		);

		$this->add_control(
			'heading_subtitle_tag',
			[
				'label'   => esc_html__( 'Sub Title HTML Tag', 'zyre-elementor-addons' ),
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
				'default' => 'h3',
				'toggle'  => false,
				'condition'   => [
					'subtitle!' => '',
				],
			]
		);
	}

	protected function __description_content_controls() {
		$this->add_control(
			'heading_description',
			[
				'label'       => esc_html__( 'Description', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore' ),
				'description' => zyre_get_allowed_html_desc(),
			]
		);
	}

	protected function register_style_controls() {
		$this->__title_style_controls();
		$this->__subtitle_style_controls();
		$this->__description_style_controls();
	}

	protected function __title_style_controls() {
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'heading_title!' => '',
				],
			]
		);

		$this->set_style_controls(
			'title',
			[
				'selector' => '{{WRAPPER}} .zyre-heading-title',
				'controls' => [
					'typography' => [
						'fields_options' => [
							'typography'  => [ 'default' => 'yes' ],
							'font_family' => [ 'default' => 'Inter Tight' ],
						],
					],
					'color'      => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		// Main style controls
		$this->main_style_controls( 'title' );

		$this->set_style_controls(
			'title',
			[
				'selector' => '{{WRAPPER}} .zyre-heading-title',
				'controls' => [
					'alignment'      => [
						'label' => esc_html__( 'Text Alignment', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		// START Suffix Controls
		$this->add_control(
			'_heading_title_separator',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Suffix Style', 'zyre-elementor-addons' ),
				'separator' => 'before',
				'condition' => [
					'heading_suffix!' => '',
				],
			]
		);

		$this->set_style_controls(
			'title_suffix',
			[
				'selector'  => '{{WRAPPER}} .zyre-heading-title-suffix',
				'controls'  => [
					'typography'    => [
						'fields_options' => [
							'typography'  => [ 'default' => 'yes' ],
							'font_family' => [ 'default' => 'Lora' ],
						],
					],
					'color'         => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
					'background'    => [],
					'padding'       => [],
					'margin'        => [],
					'border'        => [],
					'border_radius' => [],
				],
				'condition' => [
					'heading_suffix!' => '',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __subtitle_style_controls() {
		$this->start_controls_section(
			'section_subtitle_style',
			[
				'label'     => esc_html__( 'Subtitle', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'subtitle!' => '',
				],
			]
		);

		// Main Style Controls
		$this->main_style_controls( 'subtitle' );

		// Text Style Controls
		$this->text_style_controls( 'subtitle_text', 'subtitle' );

		// Separator Style Controls
		$this->separator_style_controls( 'subtitle_separator', 'subtitle' );

		$this->end_controls_section();
	}

	protected function __description_style_controls() {
		$this->start_controls_section(
			'section_description_style',
			[
				'label' => esc_html__( 'Description', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'heading_description!' => '',
				],
			]
		);

		// Main Style Controls
		$this->main_style_controls( 'description' );

		// Text Style Controls
		$this->text_style_controls( 'description_text', 'description' );

		// Separator Style Controls
		$this->separator_style_controls( 'description_separator', 'description' );

		$this->end_controls_section();
	}

	/**
	 * Main Style Controls for all sections.
	 *
	 * @param string $id_base This will help to select controls/elements.
	 */
	private function main_style_controls( string $id_base ) {
		$this->set_style_controls(
			$id_base,
			[
				'selector' => '{{WRAPPER}} .zyre-heading-' . $id_base,
				'controls' => [
					'background'    => [],
					'padding'       => [],
					'margin'        => [],
					'border'        => [],
					'border_radius' => [],
				],
			]
		);

		$this->add_responsive_control(
			$id_base . '_position_x',
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
				'toggle'               => true,
				'selectors_dictionary' => [
					'left'   => '-webkit-box-pack:start;-moz-box-pack:start;-ms-flex-pack:start;-webkit-justify-content:flex-start;justify-content:flex-start;',
					'center' => '-webkit-box-pack:center;-moz-box-pack:center;-ms-flex-pack:center;-webkit-justify-content:center;justify-content:center;',
					'right'  => '-webkit-box-pack:end;-moz-box-pack:end;-ms-flex-pack:end;-webkit-justify-content:flex-end;justify-content:flex-end;',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-heading-' . $id_base => '{{VALUE}};',
				],
				'condition' => [
					$id_base . '_separator_position' => [ 'left', '' ],
					$id_base . '_separator_position!' => [ 'top', 'bottom', 'right' ],
				],
			]
		);

		$this->add_responsive_control(
			$id_base . '_position_x_r',
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
				'toggle'               => true,
				'selectors_dictionary' => [
					'left'  => '-webkit-box-pack:end;-moz-box-pack:end;-ms-flex-pack:end;-webkit-justify-content:flex-end;justify-content:flex-end;',
					'center' => '-webkit-box-pack:center;-moz-box-pack:center;-ms-flex-pack:center;-webkit-justify-content:center;justify-content:center;',
					'right'   => '-webkit-box-pack:start;-moz-box-pack:start;-ms-flex-pack:start;-webkit-justify-content:flex-start;justify-content:flex-start;',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-heading-' . $id_base => '{{VALUE}};',
				],
				'condition' => [
					$id_base . '_separator_position' => [ 'right' ],
					$id_base . '_separator_position!' => [ 'left', 'top', 'bottom' ],
				],
			]
		);

		$this->add_responsive_control(
			$id_base . '_order',
			[
				'label' => esc_html__( 'Order', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::NUMBER,
				'min' => -10,
				'max' => 10,
				'step' => 1,
				'selectors' => [
					'{{WRAPPER}} .zyre-heading-' . $id_base => 'order: {{VALUE}};',
				],
			]
		);
	}

	/**
	 * Text Style Controls for all sections.
	 *
	 * @param string $prefix The prefix of the controls.
	 * @param string $id_base This will help to select controls/elements.
	 */
	private function text_style_controls( string $prefix, string $id_base ) {
		$class_base = str_replace( '_', '-', $prefix );

		$this->add_control(
			'_heading_' . $prefix,
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Text Style', 'zyre-elementor-addons' ),
				'separator' => 'before',
			]
		);

		$this->set_style_controls(
			$prefix,
			[
				'selector' => '{{WRAPPER}} .zyre-heading-' . $class_base,
				'controls' => [
					'typography'    => [
						'fields_options' => [
							'typography'  => [ 'default' => 'yes' ],
							'font_family' => [ 'default' => 'Inter' ],
						],
					],
					'background'    => [
						'label' => esc_html__( 'Text Background', 'zyre-elementor-addons' ),
					],
					'color'         => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
					'padding'       => [
						'label' => esc_html__( 'Text Padding', 'zyre-elementor-addons' ),
					],
					'margin'        => [
						'label' => esc_html__( 'Text Margin', 'zyre-elementor-addons' ),
					],
					'border'        => [],
					'border_radius' => [],
					'alignment'     => [],
				],
			]
		);

		$this->add_responsive_control(
			$prefix . '_position_x',
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
					'stretch' => [
						'title' => esc_html__( 'Stretch', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'toggle'               => true,
				'selectors_dictionary' => [
					'left'   => '-webkit-align-self:flex-start;-ms-flex-item-align:start;align-self:flex-start;',
					'center' => '-webkit-align-self:center;-ms-flex-item-align:center;align-self:center;',
					'right'  => '-webkit-align-self:flex-end;-ms-flex-item-align:end;align-self:flex-end;',
					'stretch'  => '-webkit-align-self:stretch;-ms-flex-item-align:stretch;align-self:stretch;width: 100%;',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-heading-' . $class_base => '{{VALUE}};',
				],
				'condition' => [
					$id_base . '_separator_switch' => 'yes',
					$id_base . '_separator_position' => [ 'top', 'bottom' ],
				],
			]
		);

		$this->add_responsive_control(
			$prefix . '_position_y',
			[
				'label'                => esc_html__( 'Vertical Position', 'zyre-elementor-addons' ),
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
				'default'              => '',
				'toggle'               => false,
				'selectors_dictionary' => [
					'top'     => '-webkit-align-self: flex-start; -ms-flex-item-align: start; align-self: flex-start;',
					'center'  => '-webkit-align-self: center; -ms-flex-item-align: center; align-self: center;',
					'bottom'  => '-webkit-align-self: flex-end; -ms-flex-item-align: end; align-self: flex-end;',
					'stretch' => '-webkit-align-self: stretch; -ms-flex-item-align: stretch; align-self: stretch;',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-heading-' . $class_base => '{{VALUE}};',
				],
				'condition' => [
					$id_base . '_separator_switch' => 'yes',
					$id_base . '_separator_position' => [ 'left', 'right' ],
				],
			]
		);

		$this->set_style_controls(
			$prefix,
			[
				'selector' => '{{WRAPPER}} .zyre-heading-' . $class_base,
				'controls' => [
					'width' => [
						'label' => esc_html__( 'Text Width', 'zyre-elementor-addons' ),
						'range' => [
							'%'  => [
								'min' => 1,
							],
							'px' => [
								'min' => 50,
								'max' => 2000,
							],
						],
					],
				],
			]
		);
	}

	/**
	 * Separator Style Controls for all sections.
	 *
	 * @param string $prefix The prefix of the controls.
	 * @param string $id_base This will help to select controls/elements.
	 */
	private function separator_style_controls( string $prefix, string $id_base ) {

		$this->add_control(
			'_heading_' . $prefix,
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Separator Style', 'zyre-elementor-addons' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			$prefix . '_switch',
			[
				'label'     => esc_html__( 'Show Separator', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'SHOW', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'HIDE', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'_alert_' . $prefix,
			[
				'type'      => Controls_Manager::RAW_HTML,
				'raw'       => esc_html__( 'Set color, width & height for separator appearance.', 'zyre-elementor-addons' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'condition' => [
					$prefix . '_switch' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			$prefix . '_position',
			[
				'label'                => esc_html__( 'Position', 'zyre-elementor-addons' ),
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
					'bottom'   => [
						'title' => esc_html__( 'Bottom', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-bottom',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'toggle'               => false,
				'selectors_dictionary' => [
					'left'  => '-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;-ms-flex-direction:row;flex-direction:row;',
					'right' => '-webkit-box-orient:horizontal;-webkit-box-direction:reverse;-webkit-flex-direction:row-reverse;-ms-flex-direction:row-reverse;flex-direction:row-reverse;',
					'top'   => '-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;-ms-flex-direction:column;flex-direction:column;',
					'bottom'   => '-webkit-box-orient:vertical;-webkit-box-direction:reverse;-webkit-flex-direction:column-reverse;-ms-flex-direction:column-reverse;flex-direction:column-reverse;',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-heading-' . $id_base => '{{VALUE}}',
				],
				'prefix_class'  => 'zyre-addon-heading-' . $id_base . '-separator-position--',
				'condition' => [
					$prefix . '_switch' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			$prefix . '_position_x',
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
					'stretch' => [
						'title' => esc_html__( 'Stretch', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'toggle'               => true,
				'selectors_dictionary' => [
					'left'   => '-webkit-align-self:flex-start;-ms-flex-item-align:start;align-self:flex-start;',
					'center' => '-webkit-align-self:center;-ms-flex-item-align:center;align-self:center;',
					'right'  => '-webkit-align-self:flex-end;-ms-flex-item-align:end;align-self:flex-end;',
					'stretch'  => '-webkit-align-self:stretch;-ms-flex-item-align:stretch;align-self:stretch;width: 100%;max-width: 100%;',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-heading-' . $id_base . '::before' => '{{VALUE}};',
				],
				'condition' => [
					$prefix . '_switch' => 'yes',
					$prefix . '_position' => [ 'top', 'bottom' ],
				],
			]
		);

		$this->add_responsive_control(
			$prefix . '_position_y',
			[
				'label'                => esc_html__( 'Vertical Position', 'zyre-elementor-addons' ),
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
				'default'              => '',
				'toggle'               => false,
				'selectors_dictionary' => [
					'top'     => '-webkit-align-self: flex-start; -ms-flex-item-align: start; align-self: flex-start;',
					'center'  => '-webkit-align-self: center; -ms-flex-item-align: center; align-self: center;',
					'bottom'  => '-webkit-align-self: flex-end; -ms-flex-item-align: end; align-self: flex-end;',
					'stretch' => '-webkit-align-self: stretch; -ms-flex-item-align: stretch; align-self: stretch;',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-heading-' . $id_base . '::before' => '{{VALUE}};',
				],
				'condition' => [
					$prefix . '_switch' => 'yes',
					$prefix . '_position!' => [ 'top', 'bottom' ],
				],
			]
		);

		$this->set_style_controls(
			$prefix,
			[
				'selector'  => "{{WRAPPER}} .zyre-heading-{$id_base}::before",
				'controls'  => [
					'bg_color'      => [
						'label' => esc_html__( 'Color', 'zyre-elementor-addons' ),
					],
					'width'         => [
						'range' => [
							'%'  => [
								'min' => 1,
							],
							'px' => [
								'min' => 1,
								'max' => 1000,
							],
						],
					],
					'height'        => [
						'range' => [
							'%'  => [
								'min' => 1,
							],
							'px' => [
								'min' => 1,
								'max' => 1000,
							],
						],
					],
					'gap'           => [
						'label'    => esc_html__( 'Spacing', 'zyre-elementor-addons' ),
						'range'    => [
							'px' => [
								'max' => 500,
							],
						],
						'selector' => '{{WRAPPER}} .zyre-heading-' . $id_base,
					],
					'margin'        => [],
					'border'        => [],
					'border_radius' => [],
				],
				'condition' => [
					$prefix . '_switch' => 'yes',
				],
			]
		);
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		// Add inline editing attributes
		$this->add_inline_editing_attributes( 'heading_title' );
		$this->add_inline_editing_attributes( 'heading_suffix', 'none' );
		$this->add_inline_editing_attributes( 'subtitle' );
		$this->add_inline_editing_attributes( 'heading_description' );

		// Add HTML class
		$this->add_render_attribute( 'heading_description_wrap', 'class', 'zyre-heading-description zy-inline-flex zy-self-stretch zy-w-100 zy-relative zy-m-0' );
		$this->add_render_attribute( 'heading_description', 'class', 'zyre-heading-description-text zy-shrink-1' );
		if ( ! empty( $settings['description_separator_switch'] ) && 'yes' === $settings['description_separator_switch'] ) {
			$this->add_render_attribute( 'heading_description_wrap', 'class', 'has--separator' );
		}

		$this->add_render_attribute( 'heading_title', 'class', 'zyre-heading-title-text' );
		$this->add_render_attribute( 'heading_suffix', 'class', 'zyre-heading-title-suffix zy-inline-block' );
		$this->add_render_attribute( 'heading_subtitle', 'class', 'zyre-heading-subtitle zy-inline-flex zy-self-stretch zy-w-100 zy-relative zy-m-0' );
		$this->add_render_attribute( 'subtitle', 'class', 'zyre-heading-subtitle-text zy-shrink-1' );
		if ( ! empty( $settings['subtitle_separator_switch'] ) && 'yes' === $settings['subtitle_separator_switch'] ) {
			$this->add_render_attribute( 'heading_subtitle', 'class', 'has--separator' );
		}
		?>
		<div class="zyre-headings zy-flex zy-flex-wrap">
			<?php if ( ! empty( $settings['subtitle'] ) ) : ?>
				<<?php echo zyre_escape_tags( $settings['heading_subtitle_tag'], 'h3' ); ?> <?php echo $this->get_render_attribute_string( 'heading_subtitle' ); ?>><span <?php echo $this->get_render_attribute_string( 'subtitle' ); ?>><?php echo zyre_kses_basic( $settings['subtitle'] ); ?></span></<?php echo zyre_escape_tags( $settings['heading_subtitle_tag'], 'h3' ); ?>>
			<?php endif; ?>

			<?php if ( ! empty( $settings['heading_title'] ) ) : ?>
				<<?php echo zyre_escape_tags( $settings['heading_title_tag'], 'h2' ); ?> class="zyre-heading-title zy-m-0">
					<span <?php echo $this->get_render_attribute_string( 'heading_title' ); ?>><?php echo zyre_kses_basic( $settings['heading_title'] ); ?></span>
					<?php if ( $settings['heading_suffix'] ) : ?>
					<span <?php echo $this->get_render_attribute_string( 'heading_suffix' ); ?>><?php echo esc_html( $settings['heading_suffix'] ); ?></span>
					<?php endif; ?>
				</<?php echo zyre_escape_tags( $settings['heading_title_tag'], 'h2' ); ?>>
			<?php endif; ?>

			<?php if ( ! empty( $settings['heading_description'] ) ) : ?>
				<p <?php echo $this->get_render_attribute_string( 'heading_description_wrap' ); ?>><span <?php echo $this->get_render_attribute_string( 'heading_description' ); ?>><?php echo zyre_kses_basic( $settings['heading_description'] ); ?></span></p>
			<?php endif; ?>
		</div>
	
		<?php
	}
}

