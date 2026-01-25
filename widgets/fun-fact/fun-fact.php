<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Fun_Fact extends Base {

	public function get_title() {
		return esc_html__( 'Fun Fact', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Fun-fact';
	}

	public function get_keywords() {
		return [ 'fun', 'fun fact', 'fun factor', 'animation', 'info', 'icon', 'box', 'number', 'animated' ];
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	protected function is_dynamic_content(): bool {
		return false;
	}

	protected function register_content_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Fun Fact Content', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$this->add_control(
			'media_type',
			[
				'label'          => esc_html__( 'Media Type', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::CHOOSE,
				'label_block'    => false,
				'options'        => [
					'none' => [
						'title' => esc_html__( 'None', 'zyre-elementor-addons' ),
						'icon' => 'eicon-ban',
					],
					'icon'  => [
						'title' => esc_html__( 'Icon', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-star',
					],
					'image' => [
						'title' => esc_html__( 'Image', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-image',
					],
				],
				'default'        => 'icon',
				'toggle'         => false,
				'style_transfer' => true,
			]
		);

		$this->add_control(
			'image',
			[
				'label'     => esc_html__( 'Image', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'media_type' => 'image',
				],
				'dynamic'   => [
					'active' => true,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'thumbnail',
				'default'   => 'thumbnail',
				'separator' => 'none',
				'exclude'   => [
					'full',
					'custom',
					'large',
					'shop_catalog',
					'shop_single',
					'shop_thumbnail',
				],
				'condition' => [
					'media_type' => 'image',
				],
			]
		);

		$this->add_control(
			'selected_icon',
			[
				'label'      => esc_html__( 'Icon', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::ICONS,
				'show_label' => true,
				'default'    => [
					'value'   => 'far fa-thumbs-up',
					'library' => 'solid',
				],
				'condition'  => [
					'media_type' => 'icon',
				],
			]
		);

		$this->add_control(
			'image_icon_position',
			[
				'label'                => esc_html__( 'Position', 'zyre-elementor-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
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
				'prefix_class'         => 'zyre-ff-media--',
				'style_transfer'       => true,
				'selectors_dictionary' => [
					'left'  => '-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;-ms-flex-direction:row;flex-direction:row;',
					'top'   => '-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;-ms-flex-direction:column;flex-direction:column;',
					'right' => '-webkit-box-orient:horizontal;-webkit-box-direction:reverse;-webkit-flex-direction:row-reverse;-ms-flex-direction:row-reverse;flex-direction:row-reverse;',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-fun-fact-wrapper' => '{{VALUE}}',
				],
				'condition'            => [
					'media_type!' => 'none',
				],
			]
		);

		$this->set_style_controls(
			'container',
			[
				'selector'  => '{{WRAPPER}} .zyre-fun-fact-wrapper',
				'controls'  => [
					'gap'     => [
						'label' => esc_html__( 'Spacing', 'zyre-elementor-addons' ),
					],
					'align_y' => [
						'condition' => [
							'media_type!'         => 'none',
							'image_icon_position' => [ 'left', 'right' ],
						],
					],
				],
				'condition' => [
					'media_type!' => 'none',
				],
			]
		);

		$this->add_control(
			'container_position_x',
			[
				'label'                => esc_html__( 'Horizontal Align', 'zyre-elementor-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
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
					'stretch' => [
						'title' => esc_html__( 'Stretch', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-align-stretch-h',
					],
				],
				'default'              => 'center',
				'toggle'               => false,
				'style_transfer'       => true,
				'selectors'            => [
					'{{WRAPPER}} .zyre-fun-fact-wrapper' => 'justify-self: {{VALUE}};',
				],
			]
		);

		// Number
		$this->add_control(
			'ff_number',
			[
				'label'       => esc_html__( 'Number', 'zyre-elementor-addons' ),
				'placeholder' => esc_html__( 'Numbers Only (e.g. 12345)', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '10360',
				'dynamic'     => [
					'active' => true,
				],
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'decimal',
			[
				'label'        => esc_html__( 'Number of Decimal', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::NUMBER,
				'default'      => '0',
				'condition' => [
					'ff_number!' => '',
				],
			]
		);

		$this->add_control(
			'decimal_place',
			[
				'label'        => esc_html__( 'Place Decimal', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::NUMBER,
				'default'      => '0',
				'condition' => [
					'ff_number!' => '',
				],
			]
		);

		$this->add_control(
			'delimiter',
			[
				'label'        => esc_html__( 'Show Delimiter', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'zyre-elementor-addons' ),
				'label_off'    => esc_html__( 'Off', 'zyre-elementor-addons' ),
				'return_value' => 'on',
				'default'      => '',
				'condition' => [
					'ff_number!' => '',
				],
			]
		);

		$this->add_control(
			'ff_number_prefix',
			[
				'label'       => esc_html__( 'Number Prefix', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( '1', 'zyre-elementor-addons' ),
				'dynamic'     => [
					'active' => true,
				],
				'condition' => [
					'ff_number!' => '',
				],
			]
		);

		$this->add_control(
			'ff_number_suffix',
			[
				'label'       => esc_html__( 'Number Suffix', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( '+', 'zyre-elementor-addons' ),
				'default'     => esc_html__( '+', 'zyre-elementor-addons' ),
				'dynamic'     => [
					'active' => true,
				],
				'condition'   => [
					'ff_number!' => '',
				],
			]
		);

		$this->add_control(
			'ff_title',
			[
				'label'   => esc_html__( 'Title', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( 'Zyre customers', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'ff_title_tag',
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
				'default' => 'h3',
				'toggle'  => false,
				'condition'   => [
					'ff_title!' => '',
				],
			]
		);

		$this->add_control(
			'ff_title_icon',
			[
				'label'       => esc_html__( 'Title Icon', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'condition'   => [
					'ff_title!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'text_align',
			[
				'label'                => esc_html__( 'Text Alignment', 'zyre-elementor-addons' ),
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
				'toggle'               => false,
				'selectors'            => [
					'{{WRAPPER}} .zyre-fun-fact-wrapper' => 'text-align:{{value}};',
				],
				'default'              => 'center',
			]
		);

		// Settings
		$this->add_control(
			'show_divider',
			[
				'label'        => esc_html__( 'Show Divider', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off'    => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default'      => '',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'animate_number',
			[
				'label'        => esc_html__( 'Animate', 'zyre-elementor-addons' ),
				'description'  => esc_html__( 'Only number is animatable', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'zyre-elementor-addons' ),
				'label_off'    => esc_html__( 'No', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition' => [
					'ff_number!' => '',
				],
			]
		);

		$this->add_control(
			'animate_duration',
			[
				'label'     => esc_html__( 'Duration', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 100,
				'max'       => 10000,
				'step'      => 10,
				'default'   => 500,
				'condition' => [
					'ff_number!' => '',
					'animate_number!' => '',
				],
				'dynamic'   => [
					'active' => true,
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_controls() {
		$this->__icon_image_style_controls();
		$this->__content_style_controls();
		$this->__number_style_controls();
		$this->__title_style_controls();
		$this->__divider_style_controls();
	}

	protected function __icon_image_style_controls() {
		$this->start_controls_section(
			'section_style_icon_image',
			[
				'label' => esc_html__( 'Icon / Image', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'  => [
					'media_type!' => 'none',
				],
			]
		);

		$this->set_style_controls(
			'image',
			[
				'selector'  => '{{WRAPPER}} .zyre-fun-fact-image img',
				'controls'  => [
					'width'  => [
						'default' => [
							'unit' => 'px',
						],
					],
					'height' => [
						'default' => [
							'unit' => 'px',
						],
					],
				],
				'condition' => [
					'media_type' => 'image',
				],
			]
		);

		$this->set_style_controls(
			'icon',
			[
				'selector'  => '{{WRAPPER}} .zyre-fun-fact-icon',
				'controls'  => [
					'icon_size'  => [],
					'icon_color' => [],
					'width'      => [],
					'height'     => [],
				],
				'condition' => [
					'media_type' => 'icon',
				],
			]
		);

		$this->common_style_controls( 'media', '{{WRAPPER}} .zyre-fun-fact-icon, {{WRAPPER}} .zyre-fun-fact-image img' );

		$this->set_style_controls(
			'media',
			[
				'selector' => '{{WRAPPER}} .zyre-fun-fact-icon, {{WRAPPER}} .zyre-fun-fact-image img',
				'controls' => [
					'box_shadow' => [],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __content_style_controls() {
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->common_style_controls( 'content', '{{WRAPPER}} .zyre-fun-fact-content' );

		$this->end_controls_section();
	}

	protected function __number_style_controls() {
		$this->start_controls_section(
			'section_number_style',
			[
				'label' => esc_html__( 'Number', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'ff_number!' => '',
				],
			]
		);

		$this->text_style_controls( 'ff_number', '{{WRAPPER}} .zyre-fun-fact-number-wrap' );

		$this->add_control(
			'ff_number_bottom_spacing',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .zyre-fun-fact-number-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'ff_number_prefix_spacing',
			[
				'label'      => esc_html__( 'Prefix Spacing', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'condition'  => [
					'ff_number_prefix!' => '',
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-fun-fact-number-prefix' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'ff_suffix_spacing',
			[
				'label'      => esc_html__( 'Suffix Spacing', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'condition'  => [
					'ff_number_suffix!' => '',
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-fun-fact-number-suffix' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'ff_number_gradient_set',
			[
				'label'        => esc_html__( 'Set Gradient Background', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'zyre-elementor-addons' ),
				'label_off'    => esc_html__( 'Off', 'zyre-elementor-addons' ),
				'return_value' => 'on',
				'default'      => '',
				'render_type'  => 'template',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'           => 'ff_number_gradient',
				'types'          => [ 'gradient' ],
				'exclude'        => [ 'image' ],
				'fields_options' => [
					'background' => [
						'default' => 'gradient',
					],
				],
				'selector' => '{{WRAPPER}} .zyre-fun-fact-number-wrap',
				'condition'  => [
					'ff_number_gradient_set' => 'on',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __title_style_controls() {
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'ff_title!' => '',
				],
			]
		);

		$this->text_style_controls( 'ff_title', '{{WRAPPER}} .zyre-fun-fact-title' );

		$this->add_control(
			'heading_title_icon_style',
			[
				'label'     => esc_html__( 'Icon', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition'       => [
					'ff_title_icon[value]!' => '',
				],
			]
		);

		$this->set_style_controls(
			'title',
			[
				'selector'  => '{{WRAPPER}} .zyre-fun-fact-title-icon',
				'controls'  => [
					'icon_size'  => [
						'range' => [
							'px' => [
								'min' => 6,
								'max' => 300,
							],
						],
					],
					'icon_color' => [],
				],
				'condition' => [
					'ff_title_icon[value]!' => '',
				],
			]
		);

		$this->set_style_controls(
			'title_icon',
			[
				'selector'  => '{{WRAPPER}} .zyre-fun-fact-title-inner',
				'controls'  => [
					'gap' => [
						'px' => [
							'max' => 500,
						],
					],
				],
				'condition' => [
					'ff_title_icon[value]!' => '',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __divider_style_controls() {
		$this->start_controls_section(
			'section_divider_style',
			[
				'label' => esc_html__( 'Divider', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_divider' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'divider',
			[
				'selector' => '{{WRAPPER}} .zyre-fun-fact-divider',
				'controls' => [
					'width'          => [
						'range' => [
							'%'  => [
								'min' => 1,
							],
							'px' => [
								'min' => 2,
								'max' => 2000,
							],
						],
					],
					'height'         => [],
					'border_radius'  => [],
					'bg_color'       => [
						'label' => esc_html__( 'Color', 'zyre-elementor-addons' ),
					],
					'bottom_spacing' => [
						'size_units' => [ 'px' ],
						'label'      => esc_html__( 'Bottom Spacing', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->add_responsive_control(
			'divider_align',
			[
				'label'                => esc_html__( 'Alignment', 'zyre-elementor-addons' ),
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
				'toggle'               => false,
				'selectors_dictionary' => [
					'left' => 'margin-left: 0; margin-right: auto;',
					'center' => 'margin-left: auto; margin-right: auto;',
					'right' => 'margin-left: auto; margin-right: 0;',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-fun-fact-divider' => '{{value}}',
				],
				'default'              => 'center',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Text Style Controls for all sections.
	 *
	 * @param string $prefix The prefix of the controls.
	 * @param string $selector The HTML selectors.
	 */
	private function text_style_controls( string $prefix, string $selector ) {
		$this->set_style_controls(
			$prefix,
			[
				'selector' => $selector,
				'controls' => [
					'typo'        => [],
					'color'       => [],
					'text_shadow' => [],
				],
			],
		);
	}

	/**
	 * Common Style Controls for all sections.
	 *
	 * @param string $prefix The prefix of the controls.
	 * @param string $selector The HTML selectors.
	 */
	private function common_style_controls( string $prefix, string $selector ) {
		$this->set_style_controls(
			$prefix,
			[
				'selector' => $selector,
				'controls' => [
					'bg_color'      => [],
					'border'        => [
						'separator' => 'before',
					],
					'border_radius' => [],
					'padding'       => [],
				],
			]
		);
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( ! empty( $settings['ff_number'] ) ) {
			$this->add_render_attribute( 'ff_number', 'class', 'zyre-fun-fact-number' );
			$number = $settings['ff_number'];

			if ( $settings['animate_number'] ) {
				$data = [
					'toValue'  => intval( preg_replace( '/[^\d]/', '', $settings['ff_number'] ) ),
					'duration' => intval( $settings['animate_duration'] ),
					'delimiter' => 'on' === $settings['delimiter'] ? esc_html__( ',', 'zyre-elementor-addons' ) : '',
					'rounding' => ! empty( $settings['decimal'] ) ? intval( $settings['decimal'] ) : 0,
					'placeDecimal' => ! empty( $settings['decimal_place'] ) ? intval( $settings['decimal_place'] ) : 0,
				];
				$this->add_render_attribute( 'ff_number', 'data-animation', wp_json_encode( $data ) );
				$number = 0;
			} elseif ( empty( $settings['animate_number'] ) && 'on' === $settings['delimiter'] ) {
				$number = number_format_i18n( $settings['ff_number'] );
			}

			$number_prefix = $settings['ff_number_prefix'] ?? '';
			$number_suffix = $settings['ff_number_suffix'] ?? '';

			$this->add_render_attribute( 'ff_number_wrap', 'class', 'zyre-fun-fact-number-wrap zy-inline-flex zy-align-center' );
			if ( 'on' === $settings['ff_number_gradient_set'] ) {
				$this->add_render_attribute( 'ff_number_wrap', 'class', 'zyre-fun-fact-number-wrap-gradient' );
			}
		}

		$text_align = $settings['text_align'] ?? '';

		$this->add_render_attribute( 'ff_title', 'class', 'zyre-fun-fact-title zy-m-0' );
		$this->add_inline_editing_attributes( 'ff_title' );
		?>
		
		<div class="zyre-fun-fact-wrapper zy-flex zy-gap-3 zy-break-word zy-overflow-break-word zy-text-center">
			<?php if ( ! empty( $settings['selected_icon']['value'] ) ) : ?>
				<div class="zyre-fun-fact-media zyre-fun-fact-icon zy-content-center zy-justify-items-center zy-inline-block">
					<?php zyre_render_icon( $settings ); ?>
				</div>
			<?php elseif ( isset( $settings['image'] ) && isset( $settings['image']['url'] ) && isset( $settings['image']['id'] ) ) : ?>
				<div class="zyre-fun-fact-media zyre-fun-fact-image zy-inline-block">
					<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'image' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
			<?php endif; ?>

			<div class="zyre-fun-fact-content">
				<?php if ( ! empty( $settings['ff_number'] ) ) : ?>
					<div <?php $this->print_render_attribute_string( 'ff_number_wrap' ); ?>>
						<?php if ( $settings['ff_number_prefix'] ) : ?>
							<span class="zyre-fun-fact-number-prefix"><?php echo esc_html( $number_prefix ); ?></span>
						<?php endif; ?>
						<span <?php $this->print_render_attribute_string( 'ff_number' ); ?>><?php echo esc_html( $number ); ?></span>
						<?php if ( $settings['ff_number_suffix'] ) : ?>
							<span class="zyre-fun-fact-number-suffix"><?php echo esc_html( $number_suffix ); ?></span>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php if ( 'yes' === $settings['show_divider'] ) : ?>
					<div class="zyre-fun-fact-divider zy-mb-3 zyre-fun-fact-divider-align-<?php echo esc_attr( $text_align ); ?>"></div>
				<?php endif; ?>

				<?php if ( ! empty( $settings['ff_title'] ) ) : ?>
					<div class="zyre-fun-fact-title-wrap">
						<div class="zyre-fun-fact-title-inner zy-inline-flex zy-align-center zy-gap-1">
							<?php if ( ! empty( $settings['ff_title_icon']['value'] ) ) : ?>
								<span class="zyre-fun-fact-title-icon"><?php zyre_render_icon( $settings, 'icon', 'ff_title_icon' ); ?></span>
							<?php endif; ?>
							<<?php echo zyre_escape_tags( $settings['ff_title_tag'], 'h3' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
								<?php $this->print_render_attribute_string( 'ff_title' ); ?>><?php echo wp_kses( $settings['ff_title'], zyre_get_allowed_html() ); ?>
							</<?php echo zyre_escape_tags( $settings['ff_title_tag'], 'h3' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}
