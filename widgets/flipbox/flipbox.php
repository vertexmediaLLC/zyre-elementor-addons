<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use ZyreAddons\Elementor\Traits\Button_Trait;

defined( 'ABSPATH' ) || die();

class FlipBox extends Base {

	use Button_Trait;

	public function get_name() {
		return 'zyre-flipbox';
	}

	public function get_title() {
		return esc_html__( 'Flip Box', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Flip-box';
	}

	public function get_keywords() {
		return [ 'flip', 'box', 'flip box', 'info', 'info box', 'content', 'flip content' ];
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	protected function is_dynamic_content(): bool {
		return false;
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
		$this->template_style_content_controls();
		$this->front_content_controls();
		$this->back_content_controls();
		$this->flip_settings_content_controls();
	}

	protected function template_style_content_controls() {
		$this->start_controls_section(
			'section_template_style_content',
			[
				'label' => esc_html__( 'Template Style', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->set_prestyle_controls();

		$this->end_controls_section();
	}

	protected function front_content_controls() {
		$this->start_controls_section(
			'section_front_content',
			[
				'label' => esc_html__( 'Front Side', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->flip_content_controls( 'front' );

		$this->end_controls_section();
	}

	protected function back_content_controls() {
		$this->start_controls_section(
			'section_back_content',
			[
				'label' => esc_html__( 'Back Side', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->flip_content_controls( 'back' );

		$this->add_control(
			'_separator_before_button',
			[
				'type'      => Controls_Manager::RAW_HTML,
				'raw'       => '<div style="border-block-start: var(--e-a-border);border-block-start-width: 1px;"></div>',
			]
		);

		$this->register_button_content_controls(
			[
				'id_prefix'           => 'back',
				'button_default_text' => esc_html__( 'Get now', 'zyre-elementor-addons' ),
				'text_label'          => esc_html__( 'Button Text', 'zyre-elementor-addons' ),
				'link_label'          => esc_html__( 'Button Link', 'zyre-elementor-addons' ),
				'icon_label'          => esc_html__( 'Button Icon', 'zyre-elementor-addons' ),
				'show_button_id'      => false,
				'show_button_class'   => false,
				'show_button_event'   => false,
				'condition'           => [
					'back_content_type' => 'custom_content',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function flip_settings_content_controls() {
		$this->start_controls_section(
			'section_flip_settings',
			[
				'label' => esc_html__( 'Settings', 'zyre-elementor-addons' ),
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label' => esc_html__( 'Height', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'vh', 'custom' ],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
					'em' => [
						'min' => 10,
						'max' => 100,
					],
					'rem' => [
						'min' => 10,
						'max' => 100,
					],
					'vh' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .zyre-flipbox' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'max' => 200,
					],
					'em' => [
						'max' => 20,
					],
					'rem' => [
						'max' => 20,
					],
				],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .zyre-flipbox-layer, {{WRAPPER}} .zyre-flipbox-layer-overlay' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'flip_effect',
			[
				'label' => esc_html__( 'Flip Effect', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'flip',
				'options' => [
					'flip' => 'Flip',
					'slide' => 'Slide',
					'push' => 'Push',
					'zoom-in' => 'Zoom In',
					'zoom-out' => 'Zoom Out',
					'fade' => 'Fade',
				],
				'prefix_class' => 'zyre-flipbox--effect-',
			]
		);

		$this->add_control(
			'flip_direction',
			[
				'label' => esc_html__( 'Flip Direction', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'up',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon' => 'eicon-h-align-right',
					],
					'up' => [
						'title' => esc_html__( 'Top', 'zyre-elementor-addons' ),
						'icon' => 'eicon-v-align-top',
					],
					'down' => [
						'title' => esc_html__( 'Bottom', 'zyre-elementor-addons' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'toggle' => false,
				'condition' => [
					'flip_effect!' => [
						'fade',
						'zoom-in',
						'zoom-out',
					],
				],
				'prefix_class' => 'zyre-flipbox--direction-',
			]
		);

		$this->add_control(
			'flip_3d',
			[
				'label' => esc_html__( '3D Depth', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Off', 'zyre-elementor-addons' ),
				'return_value' => 'zyre-flipbox--3d',
				'default' => '',
				'prefix_class' => '',
				'condition' => [
					'flip_effect' => 'flip',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_controls() {
		// General
		$this->general_style_controls();

		// Front
		$this->start_controls_section(
			'section_front_style',
			[
				'label' => esc_html__( 'Front Side', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->flip_style_controls( 'front' );

		$this->end_controls_section();

		// Back
		$this->start_controls_section(
			'section_back_style',
			[
				'label' => esc_html__( 'Back Side', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->flip_style_controls( 'back' );

		$this->end_controls_section();

		// Button
		$this->start_controls_section(
			'section_back_btn_style',
			[
				'label' => esc_html__( 'Back Button', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'back_content_type' => 'custom_content',
				],
			]
		);

		$this->register_button_style_controls( [ 'class_base' => 'zyre-button-back' ] );

		$this->end_controls_section();

		// Button Icon
		$this->start_controls_section(
			'section_back_btn_icon_style',
			[
				'label' => esc_html__( 'Back Button Icon', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'back_content_type' => 'custom_content',
					'back_button_icon[value]!' => '',
				],
			]
		);

		$this->register_button_icon_style_controls( [ 'class_base' => 'zyre-button-back' ] );

		$this->end_controls_section();
	}

	protected function general_style_controls() {
		$this->start_controls_section(
			'section_general_style',
			[
				'label' => esc_html__( 'General', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'flip_effect!' => 'flip',
				],
			]
		);

		$this->set_style_controls(
			'flipbox',
			[
				'selector' => '{{WRAPPER}} .zyre-flipbox',
				'controls' => [
					'border_radius' => [],
					'box_shadow'    => [],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Font & Back Side content controls.
	 *
	 * @param $prefix The prefix of the controls IDs.
	 */
	private function flip_content_controls( string $prefix ) {
		$this->add_control(
			$prefix . '_content_type',
			[
				'label'   => esc_html__( 'Content Type', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'custom_content' => esc_html__( 'Custom Content', 'zyre-elementor-addons' ),
					'saved_section' => esc_html__( 'Saved Section', 'zyre-elementor-addons' ),
					'saved_container' => esc_html__( 'Saved Container', 'zyre-elementor-addons' ),
				],
				'default' => 'custom_content',
			]
		);

		$saved_sections = [ '0' => esc_html__( '--- Select Section ---', 'zyre-elementor-addons' ) ];
		$saved_sections = $saved_sections + $this->select_elementor_page( 'section' );

		$this->add_control(
			$prefix . '_saved_section',
			[
				'label'     => esc_html__( 'Sections', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => $saved_sections,
				'default'   => '0',
				'condition' => [
					$prefix . '_content_type' => 'saved_section',
				],
			]
		);

		$saved_container = [ '0' => esc_html__( '--- Select Container ---', 'zyre-elementor-addons' ) ];
		$saved_container = $saved_container + $this->select_elementor_page( 'container' );

		$this->add_control(
			$prefix . '_saved_container',
			[
				'label'     => esc_html__( 'Container', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => $saved_container,
				'default'   => '0',
				'condition' => [
					$prefix . '_content_type' => 'saved_container',
				],
			]
		);

		$this->add_control(
			$prefix . '_media_type',
			[
				'label' => esc_html__( 'Media Type', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'none' => [
						'title' => esc_html__( 'None', 'zyre-elementor-addons' ),
						'icon' => 'eicon-ban',
					],
					'image' => [
						'title' => esc_html__( 'Image', 'zyre-elementor-addons' ),
						'icon' => 'eicon-image-bold',
					],
					'icon' => [
						'title' => esc_html__( 'Icon', 'zyre-elementor-addons' ),
						'icon' => 'eicon-star',
					],
				],
				'default' => 'icon',
				'condition'   => [
					$prefix . '_content_type' => 'custom_content',
				],
			]
		);

		$this->add_control(
			$prefix . '_image',
			[
				'label' => esc_html__( 'Choose Image', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					$prefix . '_media_type' => 'image',
					$prefix . '_content_type' => 'custom_content',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => $prefix . '_image', // Actually its `image_size`
				'default' => 'thumbnail',
				'condition' => [
					$prefix . '_media_type' => 'image',
					$prefix . '_content_type' => 'custom_content',
				],
			]
		);

		$this->add_control(
			$prefix . '_icon',
			[
				'label' => esc_html__( 'Icon', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'fa-solid',
				],
				'condition' => [
					$prefix . '_media_type' => 'icon',
					$prefix . '_content_type' => 'custom_content',
				],
			]
		);

		$this->add_control(
			$prefix . '_title',
			[
				'label' => esc_html__( 'Title', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'This is the heading', 'zyre-elementor-addons' ),
				'placeholder' => esc_html__( 'Enter your title', 'zyre-elementor-addons' ),
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'separator' => 'before',
				'condition'   => [
					$prefix . '_content_type' => 'custom_content',
				],
			]
		);

		$this->add_control(
			$prefix . '_description',
			[
				'label' => esc_html__( 'Description', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'zyre-elementor-addons' ),
				'placeholder' => esc_html__( 'Enter your description', 'zyre-elementor-addons' ),
				'description' => zyre_get_allowed_html_desc( 'basic' ),
				'dynamic' => [
					'active' => true,
				],
				'rows' => 8,
				'condition'   => [
					$prefix . '_content_type' => 'custom_content',
				],
			]
		);

		$this->add_control(
			$prefix . '_title_html_tag',
			[
				'label'   => esc_html__( 'Title HTML Tag', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h3',
				'options' => [
					'h1'   => esc_html__( 'H1', 'zyre-elementor-addons' ),
					'h2'   => esc_html__( 'H2', 'zyre-elementor-addons' ),
					'h3'   => esc_html__( 'H3', 'zyre-elementor-addons' ),
					'h4'   => esc_html__( 'H4', 'zyre-elementor-addons' ),
					'h5'   => esc_html__( 'H5', 'zyre-elementor-addons' ),
					'h6'   => esc_html__( 'H6', 'zyre-elementor-addons' ),
					'div'  => esc_html__( 'div', 'zyre-elementor-addons' ),
					'span' => esc_html__( 'span', 'zyre-elementor-addons' ),
					'p'    => esc_html__( 'p', 'zyre-elementor-addons' ),
				],
				'condition'   => [
					$prefix . '_content_type' => 'custom_content',
				],
			]
		);
	}

	/**
	 * Font & Back Side style controls.
	 *
	 * @param $prefix The prefix of the controls IDs.
	 */
	private function flip_style_controls( string $prefix ) {
		$class_base = str_replace( '_', '-', $prefix );

		// Tabs
		$this->start_controls_tabs( $prefix . '_bg_tabs' );

		// Tab: Normal
		$this->start_controls_tab(
			$prefix . '_bg_tab_normal',
			[
				'label'    => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			$prefix,
			[
				'selector' => '{{WRAPPER}} .zyre-flipbox-' . $class_base,
				'controls' => [
					'bg' => [
						'exclude' => [],
					],
				],
			],
		);

		$this->end_controls_tab();

		// Tab: Overlay
		$this->start_controls_tab(
			$prefix . '_bg_tab_overlay',
			[
				'label'    => esc_html__( 'Overlay', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			$prefix . '_overlay',
			[
				'selector' => "{{WRAPPER}} .zyre-flipbox-{$class_base} .zyre-flipbox-layer-overlay",
				'controls' => [
					'bg' => [],
				],
			],
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->set_style_controls(
			$prefix,
			[
				'selector' => "{{WRAPPER}} .zyre-flipbox-{$class_base} .zyre-flipbox-layer-overlay",
				'controls' => [
					'padding'   => [
						'separator' => 'before',
					],
					'alignment' => [
						'default'   => 'center',
						'condition' => [
							$prefix . '_content_type' => 'custom_content',
						],
					],
				],
			],
		);

		$this->add_control(
			$prefix . '_vertical_position',
			[
				'label' => esc_html__( 'Vertical Position', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => esc_html__( 'Top', 'zyre-elementor-addons' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => esc_html__( 'Middle', 'zyre-elementor-addons' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'zyre-elementor-addons' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'selectors_dictionary' => [
					'top' => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'selectors' => [
					"{{WRAPPER}} .zyre-flipbox-{$class_base} .zyre-flipbox-layer-overlay" => 'justify-content: {{VALUE}}',
				],
				'separator' => 'after',
			]
		);

		$this->set_style_controls(
			$prefix,
			[
				'selector' => "{{WRAPPER}} .zyre-flipbox-{$class_base}",
				'controls' => [
					'border'        => [
						'separator' => 'before',
					],
					'border_radius' => [],
					'box_shadow'    => [],
				],
			],
		);

		$this->add_control(
			$prefix . '_heading_image_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => esc_html__( 'Image', 'zyre-elementor-addons' ),
				'condition' => [
					$prefix . '_media_type' => 'image',
					$prefix . '_content_type' => 'custom_content',
				],
				'separator' => 'before',
			]
		);

		$this->set_style_controls(
			$prefix . '_image',
			[
				'selector' => "{{WRAPPER}} .zyre-flipbox-{$class_base} .zyre-flipbox-image",
				'controls' => [
					'spacing' => [],
					'width'   => [
						'selector' => "{{WRAPPER}} .zyre-flipbox-{$class_base} .zyre-flipbox-image img",
					],
					'height'   => [
						'selector' => "{{WRAPPER}} .zyre-flipbox-{$class_base} .zyre-flipbox-image img",
					],
					'opacity' => [],
					'border' => [
						'selector' => "{{WRAPPER}} .zyre-flipbox-{$class_base} .zyre-flipbox-image img",
						'separator' => 'before',
					],
					'border_radius' => [
						'selector' => "{{WRAPPER}} .zyre-flipbox-{$class_base} .zyre-flipbox-image img",
					],
					'padding' => [],
				],
				'condition' => [
					$prefix . '_media_type'   => 'image',
					$prefix . '_content_type' => 'custom_content',
				],
			],
		);

		$this->add_control(
			$prefix . '_heading_icon_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => esc_html__( 'Icon', 'zyre-elementor-addons' ),
				'condition' => [
					$prefix . '_media_type' => 'icon',
					$prefix . '_content_type' => 'custom_content',
				],
				'separator' => 'before',
			]
		);

		$this->set_style_controls(
			$prefix . '_icon',
			[
				'selector' => "{{WRAPPER}} .zyre-flipbox-{$class_base} .zyre-flipbox-icon-wrapper",
				'controls'  => [
					'spacing' => [
						'label' => esc_html__( 'Gap', 'zyre-elementor-addons' ),
					],
				],
				'condition' => [
					$prefix . '_media_type'   => 'icon',
					$prefix . '_content_type' => 'custom_content',
				],
			],
		);

		$this->set_style_controls(
			$prefix,
			[
				'selector' => "{{WRAPPER}} .zyre-flipbox-{$class_base} .zyre-flipbox-icon",
				'controls'  => [
					'icon_color' => [],
					'icon_size'  => [
						'range' => [
							'px'  => [
								'min' => 6,
								'max' => 300,
							],
							'em'  => [
								'min' => 0.6,
								'max' => 30,
							],
							'rem' => [
								'min' => 0.6,
								'max' => 30,
							],
						],
					],
				],
				'condition' => [
					$prefix . '_media_type'   => 'icon',
					$prefix . '_content_type' => 'custom_content',
				],
			],
		);

		$this->set_style_controls(
			$prefix . '_icon',
			[
				'selector' => "{{WRAPPER}} .zyre-flipbox-{$class_base} .zyre-flipbox-icon",
				'controls'  => [
					'width' => [
						'label' => esc_html__( 'Icon Width', 'zyre-elementor-addons' ),
					],
					'height' => [
						'label' => esc_html__( 'Icon Height', 'zyre-elementor-addons' ),
					],
				],
				'condition' => [
					$prefix . '_media_type'   => 'icon',
					$prefix . '_content_type' => 'custom_content',
				],
			],
		);

		$this->add_control(
			$prefix . '_icon_padding',
			[
				'label' => esc_html__( 'Icon Padding', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					"{{WRAPPER}} .zyre-flipbox-{$class_base} .zyre-flipbox-icon" => 'padding: {{SIZE}}{{UNIT}};',
				],
				'range' => [
					'em' => [
						'min' => 0,
						'max' => 5,
					],
				],
				'condition' => [
					$prefix . '_media_type' => 'icon',
					$prefix . '_content_type' => 'custom_content',
				],
			]
		);

		$this->add_control(
			$prefix . '_icon_rotate',
			[
				'label' => esc_html__( 'Icon Rotate', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'deg', 'grad', 'rad', 'turn' ],
				'default' => [
					'size' => 0,
					'unit' => 'deg',
				],
				'selectors' => [
					"{{WRAPPER}} .zyre-flipbox-{$class_base} .zyre-flipbox-icon i" => 'transform: rotate({{SIZE}}{{UNIT}});',
					"{{WRAPPER}} .zyre-flipbox-{$class_base} .zyre-flipbox-icon svg" => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
				'condition' => [
					$prefix . '_media_type' => 'icon',
					$prefix . '_content_type' => 'custom_content',
				],
			]
		);

		$this->set_style_controls(
			$prefix . '_icon',
			[
				'selector' => "{{WRAPPER}} .zyre-flipbox-{$class_base} .zyre-flipbox-icon",
				'controls'  => [
					'border'        => [],
					'border_radius' => [],
				],
				'condition' => [
					$prefix . '_media_type'   => 'icon',
					$prefix . '_content_type' => 'custom_content',
				],
			],
		);

		$this->set_style_controls(
			$prefix . '_content',
			[
				'selector' => "{{WRAPPER}} .zyre-flipbox-{$class_base} .zyre-flipbox-content",
				'controls' => [
					'heading'  => [
						'label'     => esc_html__( 'Content', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
					'bg_color' => [],
					'border'   => [],
					'padding'  => [],
					'align'    => [],
				],
			],
		);

		$this->add_control(
			$prefix . '_heading_title_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => esc_html__( 'Title', 'zyre-elementor-addons' ),
				'condition' => [
					$prefix . '_title!' => '',
					$prefix . '_content_type' => 'custom_content',
				],
			]
		);

		$this->set_style_controls(
			$prefix . '_title',
			[
				'selector' => "{{WRAPPER}} .zyre-flipbox-{$class_base} .zyre-flipbox-title",
				'controls' => [
					'spacing' => [
						'label'     => esc_html__( 'Gap', 'zyre-elementor-addons' ),
						'condition' => [
							$prefix . '_description!' => '',
							$prefix . '_title!'       => '',
							$prefix . '_content_type' => 'custom_content',
						],
					],
					'color'   => [
						'label'     => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
						'condition' => [
							$prefix . '_title!'       => '',
							$prefix . '_content_type' => 'custom_content',
						],
					],
					'typo'    => [
						'condition' => [
							$prefix . '_title!'       => '',
							$prefix . '_content_type' => 'custom_content',
						],
					],
					'stroke'  => [
						'condition' => [
							$prefix . '_title!'       => '',
							$prefix . '_content_type' => 'custom_content',
						],
					],
				],
			],
		);

		$this->add_control(
			$prefix . '_heading_description_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => esc_html__( 'Description', 'zyre-elementor-addons' ),
				'separator' => 'before',
				'condition' => [
					$prefix . '_description!' => '',
					$prefix . '_content_type' => 'custom_content',
				],
			]
		);

		$this->set_style_controls(
			$prefix . '_description',
			[
				'selector' => "{{WRAPPER}} .zyre-flipbox-{$class_base} .zyre-flipbox-description",
				'controls'  => [
					'color' => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
					'typo'  => [],
				],
				'condition' => [
					$prefix . '_description!' => '',
					$prefix . '_content_type' => 'custom_content',
				],
			],
		);
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<div class="zyre-flipbox zy-relative" tabindex="0">
			<div class="zyre-flipbox-layer zy-absolute zy-w-100 zy-h-100 zy-overflow-hidden zyre-flipbox-front zy-bg-white">
				<div class="zyre-flipbox-layer-overlay zy-align-stretch zy-color-black zy-flex zy-direction-column zy-justify-center zy-text-center zy-w-100 zy-h-100">
					<div class="zyre-flipbox-layer-inner">
						<?php $this->render_flip_content( 'front', $settings ); ?>
					</div>
				</div>
			</div>
			<div class="zyre-flipbox-layer zy-absolute zy-w-100 zy-h-100 zy-overflow-hidden zyre-flipbox-back zy-bg-white zy-block zy-index-1">
				<div class="zyre-flipbox-layer-overlay zy-align-stretch zy-color-black zy-flex zy-direction-column zy-justify-center zy-text-center zy-w-100 zy-h-100">
					<div class="zyre-flipbox-layer-inner">
						<?php $this->render_flip_content( 'back', $settings ); ?>
						<?php $this->render_button( $this, [ 'id_prefix' => 'back' ] ); ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	protected function render_flip_content( string $prefix, $settings ) {
		$content_type = $prefix . '_content_type';
		$saved_container = $prefix . '_saved_container';
		$saved_section = $prefix . '_saved_section';
		$media_type = $prefix . '_media_type';
		$image = $prefix . '_image';
		$icon = $prefix . '_icon';
		$title = $prefix . '_title';
		$title_tag = Utils::validate_html_tag( $settings[ $prefix . '_title_html_tag' ] );
		$description = $prefix . '_description';

		if ( 'custom_content' === $settings[ $content_type ] ) {
			if ( 'image' === $settings[ $media_type ] && ! empty( $settings[ $image ]['url'] ) ) : ?>
				<div class="zyre-flipbox-image zy-inline-block zy-w-100">
					<?php Group_Control_Image_Size::print_attachment_image_html( $settings, $image ); ?>
				</div>
			<?php elseif ( 'icon' === $settings[ $media_type ] && ! empty( $settings[ $icon ]['value'] ) ) : ?>
				<div class="zyre-flipbox-icon-wrapper">
					<span class="zyre-flipbox-icon zy-inline-flex zy-align-center zy-justify-center"><?php zyre_render_icon( $settings, null, $icon ); ?></span>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $settings[ $title ] ) && ! empty( $settings[ $description ] ) ) : ?>
				<div class="zyre-flipbox-content">
					<?php if ( ! empty( $settings[ $title ] ) ) : ?>
						<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="zyre-flipbox-title zy-m-0 zy-lh-1.2 zy-fw-bold">
							<?php $this->print_unescaped_setting( $title ); ?>
						</<?php Utils::print_validated_html_tag( $title_tag ); ?>>
					<?php endif; ?>

					<?php if ( ! empty( $settings[ $description ] ) ) : ?>
						<p class="zyre-flipbox-description zy-m-0 zy-lh-1.5"><?php $this->print_unescaped_setting( $description ); ?></p>
					<?php endif; ?>
				</div>
			<?php endif;
		} elseif ( 'saved_section' === $settings[ $content_type ] && 'publish' === get_post_status( $settings[ $saved_section ] ) ) {
			$settings[ $saved_section ] = apply_filters( 'wpml_object_id', $settings[ $saved_section ], 'elementor_library' ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
			echo zyre_elementor()->frontend->get_builder_content_for_display( $settings[ $saved_section ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} elseif ( 'saved_container' === $settings[ $content_type ] && 'publish' === get_post_status( $settings[ $saved_container ] ) ) {
			$settings[ $saved_container ] = apply_filters( 'wpml_object_id', $settings[ $saved_container ], 'elementor_library' ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
			echo zyre_elementor()->frontend->get_builder_content_for_display( $settings[ $saved_container ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
}
