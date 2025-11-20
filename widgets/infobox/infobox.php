<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;
use Elementor\Utils;
use ZyreAddons\Elementor\Traits\Button_Trait;
use ZyreAddons\Elementor\Traits\List_Item_Trait;

defined( 'ABSPATH' ) || die();

/**
 * InfoBox widget class
 *
 * @since 1.0.0
 * @package ZyreAddons
 */
class InfoBox extends Base {

	use Button_Trait;
	use List_Item_Trait;

	/**
	 * Get widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Info box', 'zyre-elementor-addons' );
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
		return 'zy-fonticon zy-Infobox';
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
		return [ 'info', 'box', 'infobox', 'card', 'blurb', 'text', 'content' ];
	}

	/**
	 * Register widget content controls
	 */
	protected function register_content_controls() {
		$this->template_style_content_controls();
		$this->media_content_controls();
		$this->title_desc_content_controls();
		$this->icon_list_content_controls();
		$this->button_content_controls();
	}

	/**
	 * Template Styles content controls
	 */
	protected function template_style_content_controls() {
		$this->start_controls_section(
			'section_template',
			[
				'label' => esc_html__( 'Template Styles', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->set_prestyle_controls();

		$this->end_controls_section();
	}

	/**
	 * Media content Controls
	 */
	protected function media_content_controls() {
		$this->start_controls_section(
			'section_media',
			[
				'label' => esc_html__( 'Icon / Image', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'infobox_media',
			[
				'label'       => esc_html__( 'Set Icon/Image', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => true,
				'options'     => [
					'none' => [
						'title' => esc_html__( 'None', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-ban',
					],
					'icon' => [
						'title' => esc_html__( 'Icon', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-star',
					],
					'image' => [
						'title' => esc_html__( 'Image', 'zyre-elementor-addons' ),
						'icon' => 'eicon-image',
					],
				],
				'default'     => 'icon',
			]
		);

		$this->add_control(
			'infobox_media_icon',
			[
				'label'       => esc_html__( 'Icon', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => true,
				'default' => [
					'value' => 'far fa-building',
					'library' => 'fa-regular',
				],
				'condition'   => [
					'infobox_media[value]' => 'icon',
				],
			]
		);

		$this->add_control(
			'infobox_media_image',
			[
				'label'     => esc_html__( 'Image', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'ai'        => [
					'active' => false,
				],
				'dynamic'   => [
					'active' => true,
				],
				'condition' => [
					'infobox_media[value]' => 'image',
				],
			],
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'thumbnail',
				'default'   => 'full',
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
					'infobox_media[value]' => 'image',
				],
			]
		);

		$this->add_responsive_control(
			'infobox_media_position',
			[
				'label'          => esc_html__( 'Media position', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::CHOOSE,
				'options'        => [
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
				'default'        => 'top',
				'toggle'         => false,
				'style_transfer' => true,
				'prefix_class'   => 'zyre-infobox-media-dir%s-',
				'condition'      => [
					'infobox_media[value]!'   => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'infobox_media_y_position',
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
					'infobox_media_position' => [ 'left', 'right' ],
					'infobox_media[value]!'  => 'none',
				],
				'style_transfer'       => true,
				'selectors_dictionary' => [
					'top'     => '-webkit-align-self: flex-start; -ms-flex-item-align: flex-start; align-self: flex-start;',
					'center'  => '-webkit-align-self: center; -ms-flex-item-align: center; align-self: center;',
					'bottom'  => '-webkit-align-self: flex-end; -ms-flex-item-align: end; align-self: flex-end;',
					'stretch' => '-webkit-align-self: stretch; -ms-flex-item-align: stretch; align-self: stretch;',
				],
				'selectors'            => [
					'{{WRAPPER}}.zyre-addon-infobox.zyre-infobox-media-dir-left .zyre-infobox-media'  => '{{VALUE}};',
					'{{WRAPPER}}.zyre-addon-infobox.zyre-infobox-media-dir-right .zyre-infobox-media' => '{{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Title and Description Content Controls
	 */
	protected function title_desc_content_controls() {

		$this->start_controls_section(
			'section_title_desc',
			[
				'label' => esc_html__( 'Title, Description', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'infobox_title',
			[
				'label'       => esc_html__( 'Title', 'zyre-elementor-addons' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Real company', 'zyre-elementor-addons' ),
				'placeholder' => esc_html__( 'Type Info Box Title', 'zyre-elementor-addons' ),
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'infobox_title_tag',
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
					'infobox_title!' => '',
				],
			]
		);

		$this->add_control(
			'infobox_description',
			[
				'label'       => esc_html__( 'Description', 'zyre-elementor-addons' ),
				'description' => zyre_get_allowed_html_desc( 'advanced' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt.', 'zyre-elementor-addons' ),
				'placeholder' => esc_html__( 'Type info box description', 'zyre-elementor-addons' ),
				'rows'        => 5,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Icon and List Content Controls
	 */
	protected function icon_list_content_controls() {
		$this->start_controls_section(
			'section_infobox_list',
			[
				'label' => esc_html__( 'Icon List', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->register_list_item_content_controls(
			[
				'id_prefix'     => 'infobox_list',
				'prevent_empty' => false,
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Button Content Controls
	 */
	protected function button_content_controls() {

		$this->start_controls_section(
			'section_button',
			[
				'label' => esc_html__( 'Button', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->register_button_content_controls();

		$this->end_controls_section();
	}

	/**
	 * Register widget style controls
	 */
	protected function register_style_controls() {
		$this->__general_style_controls();
		$this->__media_style_controls();
		$this->__content_style_controls();
		$this->__title_style_controls();
		$this->__description_style_controls();
		$this->__icon_list_style_controls();
		$this->__button_style_controls();
		$this->__button_icon_style_controls();
	}

	/**
	 * General style controls
	 */
	protected function __general_style_controls() {
		$this->start_controls_section(
			'section_general_style',
			[
				'label' => esc_html__( 'General', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_general_style' );

		// Normal Tab
		$this->start_controls_tab(
			'infobox_style_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'infobox',
			[
				'selector' => '{{WRAPPER}} .elementor-widget-container',
				'controls' => [
					'background' => [
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

		// Hover Tab
		$this->start_controls_tab(
			'infobox_style_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'infobox_hover',
			[
				'selector' => '{{WRAPPER}} .elementor-widget-container:hover',
				'controls' => [
					'background' => [
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
			'infobox',
			[
				'selector' => '{{WRAPPER}} .elementor-widget-container',
				'controls' => [
					'border_radius' => [
						'separator' => 'before',
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
			'section_media_style',
			[
				'label' => esc_html__( 'Icon / Image', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'infobox_media[value]!' => 'none',
				],
			]
		);

		$this->set_style_controls(
			'icon',
			[
				'selector'  => '{{WRAPPER}} .zyre-infobox-icon',
				'controls'  => [
					'icon_size' => [
						'label' => esc_html__( 'Icon Size', 'zyre-elementor-addons' ),
						'range' => [
							'px' => [
								'min' => 6,
								'max' => 600,
							],
						],
					],
				],
				'condition' => [
					'infobox_media' => 'icon',
				],
			]
		);

		$this->set_style_controls(
			'image',
			[
				'selector' => '{{WRAPPER}} .zyre-infobox-image > img',
				'controls' => [
					'width' => [
						'label'      => esc_html__( 'Image Width', 'zyre-elementor-addons' ),
					],
					'height' => [
						'label'      => esc_html__( 'Image Height', 'zyre-elementor-addons' ),
					],
				],
				'condition'  => [
					'infobox_media[value]' => 'image',
				],
			]
		);

		$this->add_responsive_control(
			'media_spacing',
			[
				'label'      => esc_html__( 'Spacing', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}}:not(.zyre-infobox-media-dir-left):not(.zyre-infobox-media-dir-right) .zyre-infobox-media'                                     => 'margin-bottom: {{SIZE}}{{UNIT}} !important;',
					'{{WRAPPER}}.zyre-infobox-media-dir-left .elementor-widget-container,{{WRAPPER}}.zyre-infobox-media-dir-right .elementor-widget-container' => '-webkit-gap: {{SIZE}}{{UNIT}};-moz-gap: {{SIZE}}{{UNIT}};gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->set_style_controls(
			'icon',
			[
				'selector'  => '{{WRAPPER}} .zyre-infobox-icon',
				'controls'  => [
					'icon_color' => [],
					'bg_color'   => [],
					'width'     => [
						'label' => esc_html__( 'Icon Width', 'zyre-elementor-addons' ),
					],
					'height'    => [
						'label' => esc_html__( 'Icon Height', 'zyre-elementor-addons' ),
					],
				],
				'condition' => [
					'infobox_media' => 'icon',
				],
			]
		);

		$this->add_responsive_control(
			'icon_position',
			[
				'label'                => esc_html__( 'Icon Position', 'zyre-elementor-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
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
				'selectors_dictionary' => [
					'left'   => 'margin-right: auto;margin-left: 0;',
					'center' => 'margin-left: auto;margin-right: auto;',
					'right'  => 'margin-right: 0;margin-left: auto;',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-infobox-icon' => '{{VALUE}}',
				],
				'condition'            => [
					'infobox_media_position' => 'top',
					'infobox_media[value]!'  => 'none',
					'icon_width[size]!'      => '',
				],
			]
		);

		$this->add_responsive_control(
			'infobox_media_align',
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
				'toggle'               => true,
				'condition'            => [
					'infobox_media[value]!' => 'none',
				],
				'default'              => 'center',
				'style_transfer'       => true,
				'selectors_dictionary' => [
					'left'   => 'margin-right: auto;margin-left: 0;',
					'center' => 'margin-left: auto;margin-right: auto;',
					'right'  => 'margin-right: 0;margin-left: auto;',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-infobox-media svg' => '{{VALUE}}',
					'{{WRAPPER}} .zyre-infobox-media i'   => '{{VALUE}}',
					'{{WRAPPER}} .zyre-infobox-media img' => '{{VALUE}}',
				],
			]
		);

		$this->add_control(
			'icon_rotate',
			[
				'label'      => esc_html__( 'Rotate', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'deg' ],
				'default'    => [
					'unit' => 'deg',
				],
				'range'      => [
					'deg' => [
						'min' => 0,
						'max' => 360,
					],
				],
				'selectors'  => [
					'{{WRAPPER}}' => '--zyre-infobox-media-rotate: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'infobox_media' => 'icon',
				],
			]
		);

		$this->set_style_controls(
			'media',
			[
				'selector' => '{{WRAPPER}} .zyre-infobox-image img, {{WRAPPER}} .zyre-infobox-icon',
				'controls' => [
					'border'        => [],
					'border_radius' => [],
					'box_shadow'    => [
						'exclude' => [
							'box_shadow_position',
						],
					],
					'padding'       => [],
					'margin'        => [
						'selector' => '{{WRAPPER}} .zyre-infobox-media',
					],
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
				'selector' => '{{WRAPPER}} .zyre-infobox-content',
				'controls' => [
					'padding'    => [],
					'align'      => [],
					'position_y' => [
						'condition'   => [
							'infobox_media[value]!'  => 'none',
							'infobox_media_position' => [ 'left', 'right' ],
						],
					],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Title style controls
	 */
	protected function __title_style_controls() {
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'infobox_title!' => '',
				],
			]
		);

		$this->text_style_controls( 'title' );

		$this->end_controls_section();
	}

	/**
	 * Description style controls
	 */
	protected function __description_style_controls() {
		$this->start_controls_section(
			'section_description_style',
			[
				'label' => esc_html__( 'Description', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'infobox_description!' => '',
				],
			]
		);

		$this->text_style_controls( 'description' );

		$this->end_controls_section();
	}

	/**
	 * Icon & List style controls
	 */
	protected function __icon_list_style_controls() {
		$this->start_controls_section(
			'section_icon_list__style',
			[
				'label'     => esc_html__( 'Icon List', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_list_item_style_controls( [ 'id_prefix' => 'infobox_list' ] );

		$this->set_style_controls(
			'infobox_list',
			[
				'selector' => '{{WRAPPER}} .zyre-list-items',
				'controls' => [
					'margin' => [
						'separator' => 'before',
					],
				],
			]
		);

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
				'selector' => '{{WRAPPER}} .zyre-infobox-' . $class_base,
				'controls' => [
					'typography' => [],
					'color'      => [
						'default' => '#000000',
					],
					'margin'     => [],
					'alignment'  => [
						'selector' => '{{WRAPPER}} .zyre-infobox-content .zyre-infobox-' . $class_base,
					],
					'max_width'  => [
						'css_property' => 'max-width',
					],
				],
			]
		);
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
					'button_text!' => '',
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
					'button_icon[value]!'  => '',
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

		$this->add_render_attribute( 'title', 'class', 'zyre-infobox-title zy-m-0' );
		$this->add_render_attribute( 'description', 'class', 'zyre-infobox-description' );
		$this->add_render_attribute( 'infobox_icon', 'class', 'zyre-infobox-media zyre-infobox-icon zy-block zy-content-center' );
		$this->add_render_attribute( 'infobox_image', 'class', 'zyre-infobox-media zyre-infobox-image zy-block' );
		?>

		<?php if ( 'image' === $settings['infobox_media'] && ( $settings['infobox_media_image']['url'] || $settings['infobox_media_image']['id'] ) ) : ?>
			<div <?php $this->print_render_attribute_string( 'infobox_image' ); ?>>
				<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'infobox_media_image' ); ?>
			</div>

			<?php elseif ( 'icon' === $settings['infobox_media'] && ! empty( $settings['infobox_media_icon'] ) ) : ?>

			<div <?php $this->print_render_attribute_string( 'infobox_icon' ); ?>>
				<?php Icons_Manager::render_icon( $settings['infobox_media_icon'], [ 'aria-hidden' => 'true' ] ); ?>
			</div>
		<?php endif; ?>

		<div class="zyre-infobox-content">
			<?php
			if ( $settings['infobox_title'] ) :
				printf(
					'<%1$s %2$s>%3$s</%1$s>',
					zyre_escape_tags( $settings['infobox_title_tag'], 'h2' ),
					$this->get_render_attribute_string( 'title' ),
					wp_kses( $settings['infobox_title'], zyre_get_allowed_html( 'basic' ) )
				);
			endif;
			?>

			<?php if ( $settings['infobox_description'] ) :
				?>
				<div <?php $this->print_render_attribute_string( 'description' ); ?>>
					<p class="zy-m-0"><?php echo zyre_kses_advanced( $settings['infobox_description'] ); ?></p>
				</div>
				<?php
			endif; ?>

			<?php $this->render_list_items( null, [ 'id_prefix' => 'infobox_list' ] ); ?>

			<?php $this->render_button(); ?>
		</div>

		<?php
	}
}
