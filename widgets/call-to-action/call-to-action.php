<?php
namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use Elementor\Control_Media;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;
use Elementor\Utils;
use ZyreAddons\Elementor\Traits\Button_Trait;

defined( 'ABSPATH' ) || die();

class Call_To_Action extends Base {
	use Button_Trait;

	public function get_title() {
		return esc_html__( 'Call to Action', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Call-to-action';
	}

	public function get_keywords() {
		return [ 'call to action', 'content', 'information', 'content box', 'info box', 'cta', 'buttons', 'card' ];
	}

	private function html_tags() {
		return [
			'h1' => 'H1',
			'h2' => 'H2',
			'h3' => 'H3',
			'h4' => 'H4',
			'h5' => 'H5',
			'h6' => 'H6',
			'p' => 'p',
			'div' => 'div',
			'span' => 'span',
		];
	}

	/**
	 * Register content controls
	 */
	protected function register_content_controls() {
		$this->__template_style_controls();
		$this->__image_content_controls();

		// Content section
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'zyre-elementor-addons' ),
			]
		);

		$this->__media_content_controls();
		$this->__subtitle_content_controls();
		$this->__title_content_controls();
		$this->__description_content_controls();

		$this->end_controls_section();

		// Button
		$this->__button_content_controls();
		// Ribbon
		$this->__ribbon_content_controls();
	}

	protected function __template_style_controls() {
		$this->start_controls_section(
			'section_template_style',
			[
				'label' => esc_html__( 'Template Style', 'zyre-elementor-addons' ),
			]
		);

		$this->set_prestyle_controls();

		$this->end_controls_section();
	}

	protected function __image_content_controls() {
		$this->start_controls_section(
			'section_main_image',
			[
				'label' => esc_html__( 'Main Image', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'skin',
			[
				'label' => esc_html__( 'Skin', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'classic' => esc_html__( 'Classic', 'zyre-elementor-addons' ),
					'cover' => esc_html__( 'Cover', 'zyre-elementor-addons' ),
				],
				'render_type' => 'template',
				'prefix_class' => 'zyre-cta--skin-',
				'default' => 'classic',
			]
		);

		$this->add_responsive_control(
			'layout',
			[
				'label' => esc_html__( 'Position', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon' => 'eicon-h-align-left',
					],
					'above' => [
						'title' => esc_html__( 'Above', 'zyre-elementor-addons' ),
						'icon' => 'eicon-v-align-top',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon' => 'eicon-h-align-right',
					],
					'below' => [
						'title' => esc_html__( 'Below', 'zyre-elementor-addons' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'selectors_dictionary' => [
					'left'   => 'flex-wrap: nowrap;flex-direction: row;--bg-wrapper-min-width:50%;--bg-wrapper-width:auto;',
					'above'  => 'flex-wrap: wrap;flex-direction: initial;--bg-wrapper-min-width:100%;--bg-wrapper-width:100%;',
					'right'  => 'flex-wrap: nowrap;flex-direction: row-reverse;--bg-wrapper-min-width:50%;--bg-wrapper-width:auto;',
					'below'  => 'flex-wrap: wrap;flex-direction: column-reverse;--bg-wrapper-min-width:100%;--bg-wrapper-width:100%;',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-cta' => '{{VALUE}};',
				],
				'prefix_class' => 'zyre-cta-%s-layout-image-',
				'condition' => [
					'skin!' => 'cover',
				],
			]
		);

		$this->add_control(
			'bg_image',
			[
				'label' => esc_html__( 'Choose Image', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'bg_image', // Actually its `image_size`
				'label' => esc_html__( 'Image Resolution', 'zyre-elementor-addons' ),
				'default' => 'large',
				'condition' => [
					'bg_image[url]!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'bg_image_background_size',
			[
				'label' => esc_html__( 'Background Size', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'Default', 'zyre-elementor-addons' ),
					'auto' => esc_html__( 'Auto', 'zyre-elementor-addons' ),
					'cover' => esc_html__( 'Cover', 'zyre-elementor-addons' ),
					'contain' => esc_html__( 'Contain', 'zyre-elementor-addons' ),
				],
				'render_type' => 'template',
				'selectors'  => [
					'{{WRAPPER}} .zyre-cta-bg'   => 'background-size: {{VALUE}};',
				],
				'condition' => [
					'bg_image[url]!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'bg_image_background_position',
			[
				'label'       => esc_html__( 'Background Position', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => [
					''              => esc_html__( 'Default', 'zyre-elementor-addons' ),
					'center center' => esc_html__( 'Center Center', 'zyre-elementor-addons' ),
					'center left'   => esc_html__( 'Center Left', 'zyre-elementor-addons' ),
					'center right'  => esc_html__( 'Center Right', 'zyre-elementor-addons' ),
					'top center'    => esc_html__( 'Top Center', 'zyre-elementor-addons' ),
					'top left'      => esc_html__( 'Top Left', 'zyre-elementor-addons' ),
					'top right'     => esc_html__( 'Top Right', 'zyre-elementor-addons' ),
					'bottom center' => esc_html__( 'Bottom Center', 'zyre-elementor-addons' ),
					'bottom left'   => esc_html__( 'Bottom Left', 'zyre-elementor-addons' ),
					'bottom right'  => esc_html__( 'Bottom Right', 'zyre-elementor-addons' ),
					'initial'       => esc_html__( 'Custom', 'zyre-elementor-addons' ),

				],
				'render_type' => 'template',
				'selectors'   => [
					'{{WRAPPER}} .zyre-cta-bg' => 'background-position: {{VALUE}};',
				],
				'condition'   => [
					'bg_image[url]!' => '',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __media_content_controls() {
		$this->add_control(
			'media_element',
			[
				'label' => esc_html__( 'Media Element', 'zyre-elementor-addons' ),
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
				'default' => 'none',
			]
		);

		$this->add_control(
			'media_image',
			[
				'label' => esc_html__( 'Choose Image', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'media_element' => 'image',
				],
				'show_label' => false,
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'media_image', // Actually its `image_size`
				'default' => 'medium_large',
				'condition' => [
					'media_element' => 'image',
					'media_image[id]!' => '',
				],
			]
		);

		$this->add_control(
			'selected_icon',
			[
				'label' => esc_html__( 'Icon', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'fa-solid',
				],
				'condition' => [
					'media_element' => 'icon',
				],
			]
		);

		$this->add_responsive_control(
			'media_layout',
			[
				'label' => esc_html__( 'Position', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon' => 'eicon-h-align-left',
					],
					'above' => [
						'title' => esc_html__( 'Above', 'zyre-elementor-addons' ),
						'icon' => 'eicon-v-align-top',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon' => 'eicon-h-align-right',
					],
					'below' => [
						'title' => esc_html__( 'Below', 'zyre-elementor-addons' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'selectors_dictionary' => [
					'left'   => 'flex-wrap: nowrap;flex-direction: row;',
					'above'  => 'flex-wrap: wrap;flex-direction: initial;',
					'right'  => 'flex-wrap: nowrap;flex-direction: row-reverse;',
					'below'  => 'flex-wrap: wrap;flex-direction: column-reverse;',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-cta-content-wrapper' => '{{VALUE}};',
				],
				'render_type' => 'template',
				'condition' => [
					'media_element!' => 'none',
				],
			]
		);
	}

	protected function __subtitle_content_controls() {
		$this->add_control(
			'subtitle',
			[
				'label' => esc_html__( 'Sub Title', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( 'This is sub title', 'zyre-elementor-addons' ),
				'placeholder' => esc_html__( 'Enter your sub title', 'zyre-elementor-addons' ),
				'label_block' => true,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'subtitle_tag',
			[
				'label' => esc_html__( 'Subtitle HTML Tag', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => $this->html_tags(),
				'default' => 'h3',
				'condition' => [
					'subtitle!' => '',
				],
			]
		);
	}

	protected function __title_content_controls() {
		$this->add_control(
			'title_prefix',
			[
				'label' => esc_html__( 'Title Prefix', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'separator' => 'before',
				'condition' => [
					'title!' => '',
				],
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( 'This is the main title', 'zyre-elementor-addons' ),
				'placeholder' => esc_html__( 'Enter your title', 'zyre-elementor-addons' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label' => esc_html__( 'Title HTML Tag', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => $this->html_tags(),
				'default' => 'h2',
				'condition' => [
					'title!' => '',
				],
			]
		);

		$this->add_control(
			'title_suffix',
			[
				'label' => esc_html__( 'Title Suffix', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'condition' => [
					'title!' => '',
				],
			]
		);
	}

	protected function __description_content_controls() {
		$this->add_control(
			'description',
			[
				'label' => esc_html__( 'Description', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( 'Lorem ipsum dolor sit amet consectetuer adipiscing elitsed diam nonummy lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.', 'zyre-elementor-addons' ),
				'placeholder' => esc_html__( 'Enter your description', 'zyre-elementor-addons' ),
				'separator' => 'before',
				'rows' => 5,
			]
		);

		$this->add_control(
			'description_tag',
			[
				'label' => esc_html__( 'Description HTML Tag', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => $this->html_tags(),
				'default' => 'p',
				'condition' => [
					'description!' => '',
				],
			]
		);
	}

	protected function __button_content_controls() {
		$this->start_controls_section(
			'section_button',
			[
				'label' => esc_html__( 'Button', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'button_show',
			[
				'label'       => esc_html__( 'Show:', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'button'      => esc_html__( 'Single Button', 'zyre-elementor-addons' ),
					'dual-button' => esc_html__( 'Dual Button', 'zyre-elementor-addons' ),
					'none'        => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				],
				'default'     => 'button',
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'button_content_notice',
			[
				'type'      => Controls_Manager::RAW_HTML,
				'raw'       => esc_html__( 'Click a Tab to view & change its content.', 'zyre-elementor-addons' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info zy-py-2',
				'condition' => [
					'button_show!' => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'button_layout',
			[
				'label' => esc_html__( 'Position', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon' => 'eicon-h-align-right',
					],
					'below' => [
						'title' => esc_html__( 'Below', 'zyre-elementor-addons' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'selectors_dictionary' => [
					'left'   => 'flex-wrap: nowrap;flex-direction: row-reverse;',
					'right'  => 'flex-wrap: nowrap;flex-direction: row;',
					'below'  => 'flex-wrap: wrap;flex-direction: initial;',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-cta-content' => '{{VALUE}};',
				],
				'render_type' => 'template',
				'condition' => [
					'button_show!' => 'none',
					'button_show' => [ 'button', 'dual-button' ],
				],
			]
		);

		$this->start_controls_tabs( 'tabs_dual_button' );

		$this->start_controls_tab(
			'tab_primary',
			[
				'label' => esc_html__( 'Primary', 'zyre-elementor-addons' ),
				'condition' => [
					'button_show!' => 'none',
					'button_show' => [ 'button', 'dual-button' ],
				],
			]
		);

		$this->register_button_content_controls(
			[
				'id_prefix' => 'primary',
				'button_default_text' => esc_html__( 'Get started', 'zyre-elementor-addons' ),
				'condition' => [
					'button_show!' => 'none',
					'button_show' => [ 'button', 'dual-button' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_connector',
			[
				'label' => esc_html__( 'Connector', 'zyre-elementor-addons' ),
				'condition' => [
					'button_show!' => 'none',
					'button_show' => [ 'dual-button' ],
				],
			]
		);

		$this->connector_content_controls();

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_secondary',
			[
				'label' => esc_html__( 'Secondary', 'zyre-elementor-addons' ),
				'condition' => [
					'button_show!' => 'none',
					'button_show' => [ 'dual-button' ],
				],
			]
		);

		$this->register_button_content_controls(
			[
				'id_prefix' => 'secondary',
				'condition' => [
					'button_show!' => 'none',
					'button_show' => [ 'dual-button' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function connector_content_controls() {
		$this->add_control(
			'show_button_connector',
			[
				'label'        => esc_html__( 'Show Connector', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off'    => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition' => [
					'button_show!' => 'none',
					'button_show' => [ 'dual-button' ],
				],
			]
		);

		$this->add_control(
			'button_connector_type',
			[
				'label'     => esc_html__( 'Connector Type', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'text' => esc_html__( 'Text', 'zyre-elementor-addons' ),
					'icon' => esc_html__( 'Icon', 'zyre-elementor-addons' ),
				],
				'default'   => 'text',
				'condition' => [
					'show_button_connector' => 'yes',
					'button_show!' => 'none',
					'button_show' => [ 'dual-button' ],
				],
			]
		);

		$this->add_control(
			'button_connector_text',
			[
				'label'       => esc_html__( 'Connector Text', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => esc_html__( 'OR', 'zyre-elementor-addons' ),
				'condition'   => [
					'show_button_connector'  => 'yes',
					'button_connector_type'  => 'text',
					'button_show!' => 'none',
					'button_show' => [ 'dual-button' ],
				],
				'ai' => false,
			]
		);

		$this->add_control(
			'button_connector_icon',
			[
				'label'     => esc_html__( 'Connector Icon', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'library' => 'fa-solid',
					'value'   => 'fa fa-angle-right',
				],
				'condition' => [
					'show_button_connector'  => 'yes',
					'button_connector_type'  => 'icon',
					'button_show!' => 'none',
					'button_show' => [ 'dual-button' ],
				],
			]
		);
	}

	protected function __ribbon_content_controls() {
		$this->start_controls_section(
			'section_ribbon',
			[
				'label' => esc_html__( 'Ribbon', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'ribbon_title',
			[
				'label' => esc_html__( 'Title', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'ribbon_position_x',
			[
				'label' => esc_html__( 'Position', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'condition' => [
					'ribbon_title!' => '',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register style controls
	 */
	protected function register_style_controls() {
		$this->__box_style_controls();
		$this->__image_style_controls();
		$this->__media_style_controls();
		$this->__content_style_controls();
		$this->__subtitle_style_controls();
		$this->__title_style_controls();
		$this->__title_prefix_style_controls();
		$this->__title_suffix_style_controls();
		$this->__description_style_controls();
		$this->__button_general_style_controls();
		$this->__button_style_controls();
		$this->__ribbon_style_controls();
	}

	protected function __box_style_controls() {
		$this->start_controls_section(
			'box_style',
			[
				'label' => esc_html__( 'Box', 'zyre-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'min_height',
			[
				'label' => esc_html__( 'Height', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'vh', 'custom' ],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 2000,
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
				'selectors' => [
					'{{WRAPPER}} .zyre-cta-content-wrapper' => 'min-height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'vertical_position',
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
				'prefix_class' => 'zyre-cta--valign-',
			]
		);

		$this->end_controls_section();
	}

	protected function __image_style_controls() {
		$this->start_controls_section(
			'image_style',
			[
				'label' => esc_html__( 'Main Image', 'zyre-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'bg_image[url]!' => '',
				],
			]
		);

		$this->set_style_controls(
			'image',
			[
				'selector' => '{{WRAPPER}} .zyre-cta-bg-wrapper',
				'controls' => [
					'min_width'     => [
						'label'        => esc_html__( 'Min Width', 'zyre-elementor-addons' ),
						'css_property' => 'min-width',
						'condition'    => [
							'skin'   => 'classic',
							'layout' => [ 'left', 'right' ],
						],
					],
					'min_height'    => [
						'label'        => esc_html__( 'Min Height', 'zyre-elementor-addons' ),
						'css_property' => 'min-height',
						'condition'    => [
							'skin' => 'classic',
						],
					],
					'border_radius' => [],
				],
			]
		);

		$this->add_control(
			'image_hover_scale',
			[
				'label' => esc_html__( 'Hover Scale', 'zyre-elementor-addons' ) . ' (ms)',
				'type' => Controls_Manager::SLIDER,
				'render_type' => 'template',
				'style_transfer' => true,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-cta:hover .zyre-cta-bg' => 'transform: scale({{SIZE}});',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'image_transition_duration',
			[
				'label' => esc_html__( 'Transition Duration', 'zyre-elementor-addons' ) . ' (ms)',
				'type' => Controls_Manager::SLIDER,
				'render_type' => 'template',
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 3000,
						'step' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-cta' => '--image-transition-duration: {{SIZE}}ms',
				],
			]
		);

		// Overlay
		$this->overlay_style_controls();

		$this->end_controls_section();
	}

	protected function overlay_style_controls() {

		// Tabs
		$this->start_controls_tabs( 'overlay_style_tabs' );

		// Tab: Normal
		$this->start_controls_tab( 'overlay_style_tab_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'overlay_color',
			[
				'label' => esc_html__( 'Overlay Color', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-cta .zyre-cta-bg-overlay' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'bg_filters',
				'selector' => '{{WRAPPER}} .zyre-cta-bg',
			]
		);

		$this->add_control(
			'overlay_blend_mode',
			[
				'label' => esc_html__( 'Blend Mode', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
					'multiply' => 'Multiply',
					'screen' => 'Screen',
					'overlay' => 'Overlay',
					'darken' => 'Darken',
					'lighten' => 'Lighten',
					'color-dodge' => 'Color Dodge',
					'color-burn' => 'Color Burn',
					'hue' => 'Hue',
					'saturation' => 'Saturation',
					'color' => 'Color',
					'exclusion' => 'Exclusion',
					'luminosity' => 'Luminosity',
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-cta-bg-overlay' => 'mix-blend-mode: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab( 'overlay_style_tab_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'overlay_color_hover',
			[
				'label' => esc_html__( 'Overlay Color', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-cta:hover .zyre-cta-bg-overlay' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'bg_filters_hover',
				'selector' => '{{WRAPPER}} .zyre-cta:hover .zyre-cta-bg',
			]
		);

		$this->add_control(
			'effect_duration',
			[
				'label' => esc_html__( 'Transition Duration', 'zyre-elementor-addons' ) . ' (ms)',
				'type' => Controls_Manager::SLIDER,
				'render_type' => 'template',
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 3000,
						'step' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-cta' => '--overlay-transition-duration: {{SIZE}}ms',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
	}

	protected function __media_style_controls() {
		$this->start_controls_section(
			'media_element_style',
			[
				'label'     => esc_html__( 'Media', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'media_element!' => [ 'none', '' ],
				],
			]
		);

		$this->set_style_controls(
			'media',
			[
				'selector' => '{{WRAPPER}} .zyre-cta-media',
				'controls' => [
					'width' => [
						'default'      => [
							'unit' => '%',
						],
						'css_value' => 'min-width: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
					],
				],
			]
		);

		$this->set_style_controls(
			'media_image',
			[
				'selector'  => '{{WRAPPER}} .zyre-cta-image img',
				'controls'  => [
					'width'  => [
						'label'   => esc_html__( 'Image Width', 'zyre-elementor-addons' ),
						'default' => [
							'unit' => '%',
						],
						'range'   => [
							'%' => [
								'min' => 5,
								'max' => 100,
							],
						],
					],
					'height' => [
						'label' => esc_html__( 'Image Height', 'zyre-elementor-addons' ),
					],
				],
				'condition' => [
					'media_element'     => 'image',
					'media_image[url]!' => '',
				],
			]
		);

		$this->set_style_controls(
			'media_icon',
			[
				'selector'  => '{{WRAPPER}} .zyre-cta-icon',
				'controls'  => [
					'width'  => [
						'label' => esc_html__( 'Icon Wrapper Width', 'zyre-elementor-addons' ),
					],
					'height' => [
						'label' => esc_html__( 'Icon Wrapper Height', 'zyre-elementor-addons' ),
					],
				],
				'condition' => [
					'media_element'         => 'icon',
					'selected_icon[value]!' => '',
				],
			]
		);

		$this->set_style_controls(
			'media',
			[
				'selector' => '{{WRAPPER}} .zyre-cta-icon',
				'controls' => [
					'icon_size'     => [
						'range'     => [
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
						'condition' => [
							'media_element'         => 'icon',
							'selected_icon[value]!' => '',
						],
					],
					'gap'           => [
						'label'    => esc_html__( 'Spacing', 'zyre-elementor-addons' ),
						'selector' => '{{WRAPPER}} .zyre-cta-content-wrapper',
					],
					'border'        => [
						'selector' => '{{WRAPPER}} .zyre-cta-image img, {{WRAPPER}} .zyre-cta-icon',
					],
					'border_radius' => [
						'selector' => '{{WRAPPER}} .zyre-cta-image img, {{WRAPPER}} .zyre-cta-icon',
					],
				],
			]
		);

		$this->set_style_controls(
			'media_icon',
			[
				'selector' => '{{WRAPPER}} .zyre-cta-image img, {{WRAPPER}} .zyre-cta-icon',
				'controls' => [
					'padding' => [],
				],
			]
		);

		$this->set_style_controls(
			'media',
			[
				'selector' => '{{WRAPPER}} .zyre-cta-media',
				'controls' => [
					'alignment'  => [
						'default' => 'center',
					],
					'position_y' => [],
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
				'tab' => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'subtitle',
							'operator' => '!==',
							'value' => '',
						],
						[
							'name' => 'title',
							'operator' => '!==',
							'value' => '',
						],
						[
							'name' => 'description',
							'operator' => '!==',
							'value' => '',
						],
					],
				],
			]
		);

		$this->set_style_controls(
			'content',
			[
				'selector' => '{{WRAPPER}} .zyre-cta-content-elements',
				'controls' => [
					'width' => [
						'default' => [
							'unit' => '%',
						],
						'range'   => [
							'%' => [
								'min' => 5,
							],
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'content_alignment',
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
				'default'              => is_rtl() ? 'right' : 'left',
				'selectors_dictionary' => [
					'left'   => 'margin-right: auto;margin-left:0;text-align:left;',
					'center' => 'margin-right: auto;margin-left:auto;text-align:center;',
					'right'  => 'margin-right: 0;margin-left:auto;text-align:right;',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-cta-content-elements'     => '{{VALUE}}',
					'{{WRAPPER}} .zyre-cta-content-elements > *' => '{{VALUE}}',
				],
			]
		);

		$this->set_style_controls(
			'content',
			[
				'selector' => '{{WRAPPER}} .zyre-cta-content',
				'controls' => [
					'position_y' => [],
					'padding'    => [
						'selector' => '{{WRAPPER}} .zyre-cta-content-wrapper',
					],
				],
			]
		);

		// Colors
		$this->content_colors_style_controls();

		$this->end_controls_section();
	}

	protected function content_colors_style_controls() {

		// Tabs
		$this->start_controls_tabs( 'content_colors_tabs' );

		// Tab: Normal
		$this->start_controls_tab( 'content_colors_tab_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'content_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-cta-content-wrapper' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'content_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-cta-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-cta-icon svg' => 'fill: {{VALUE}}',
				],
				'condition' => [
					'media_element[value]' => 'icon',
					'selected_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'media_el_border_color',
			[
				'label' => esc_html__( 'Media Border Color', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-cta-icon, {{WRAPPER}} .zyre-cta-image img' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'media_element!' => [
						'none',
						'',
					],
				],
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label' => esc_html__( 'Sub Title Color', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-cta-subtitle' => 'color: {{VALUE}};border-color: {{VALUE}};',
				],
				'condition' => [
					'subtitle!' => '',
				],
			]
		);

		$this->add_control(
			'title_prefix_color',
			[
				'label' => esc_html__( 'Title Prefix Color', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-cta-title-prefix' => 'color: {{VALUE}};border-color: {{VALUE}};',
				],
				'condition' => [
					'title_prefix!' => '',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title Color', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-cta-title' => 'color: {{VALUE}};border-color: {{VALUE}};',
				],
				'condition' => [
					'title!' => '',
				],
			]
		);

		$this->add_control(
			'title_suffix_color',
			[
				'label' => esc_html__( 'Title Suffix Color', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-cta-title-suffix' => 'color: {{VALUE}};border-color: {{VALUE}};',
				],
				'condition' => [
					'title_suffix!' => '',
				],
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => esc_html__( 'Description Color', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-cta-description' => 'color: {{VALUE}};border-color: {{VALUE}};',
				],
				'condition' => [
					'description!' => '',
				],
			]
		);

		$this->add_control(
			'button_color',
			[
				'label' => esc_html__( 'Button Color', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-button' => 'color: {{VALUE}}; border-color: {{VALUE}};border-color: {{VALUE}};',
					'{{WRAPPER}} .zyre-button svg' => 'fill: {{VALUE}};',
				],
				'condition' => [
					'button_show!' => 'none',
				],
			]
		);

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab( 'content_colors_tab_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'content_bg_color_hover',
			[
				'label' => esc_html__( 'Background Color', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-cta:hover .zyre-cta-content-wrapper' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'icon_color_hover',
			[
				'label' => esc_html__( 'Icon Color', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-cta:hover .zyre-cta-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-cta:hover .zyre-cta-icon svg' => 'fill: {{VALUE}}',
				],
				'condition' => [
					'media_element[value]' => 'icon',
					'selected_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'media_el_border_color_hover',
			[
				'label' => esc_html__( 'Media Border Color', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-cta:hover .zyre-cta-icon, {{WRAPPER}} .zyre-cta:hover .zyre-cta-image img' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'media_element!' => [
						'none',
						'',
					],
				],
			]
		);

		$this->add_control(
			'subtitle_color_hover',
			[
				'label' => esc_html__( 'Sub Title Color', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-cta:hover .zyre-cta-subtitle' => 'color: {{VALUE}};border-color: {{VALUE}};',
				],
				'condition' => [
					'subtitle!' => '',
				],
			]
		);

		$this->add_control(
			'title_prefix_color_hover',
			[
				'label' => esc_html__( 'Title Prefix Color', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-cta:hover .zyre-cta-title-prefix' => 'color: {{VALUE}};border-color: {{VALUE}};',
				],
				'condition' => [
					'title_prefix!' => '',
				],
			]
		);

		$this->add_control(
			'title_color_hover',
			[
				'label' => esc_html__( 'Title Color', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-cta:hover .zyre-cta-title' => 'color: {{VALUE}};border-color: {{VALUE}};',
				],
				'condition' => [
					'title!' => '',
				],
			]
		);

		$this->add_control(
			'title_suffix_color_hover',
			[
				'label' => esc_html__( 'Title Suffix Color', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-cta:hover .zyre-cta-title-suffix' => 'color: {{VALUE}};border-color: {{VALUE}};',
				],
				'condition' => [
					'title_suffix!' => '',
				],
			]
		);

		$this->add_control(
			'description_color_hover',
			[
				'label' => esc_html__( 'Description Color', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-cta:hover .zyre-cta-description' => 'color: {{VALUE}};border-color: {{VALUE}};',
				],
				'condition' => [
					'description!' => '',
				],
			]
		);

		$this->add_control(
			'button_color_hover',
			[
				'label' => esc_html__( 'Button Color', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-cta:hover .zyre-button' => 'color: {{VALUE}}; border-color: {{VALUE}};border-color: {{VALUE}};',
					'{{WRAPPER}} .zyre-cta:hover .zyre-button svg' => 'fill: {{VALUE}};',
				],
				'condition' => [
					'button_show!' => 'none',
				],
			]
		);

		$this->add_control(
			'content_duration_hover',
			[
				'label' => esc_html__( 'Transition Duration', 'zyre-elementor-addons' ) . ' (ms)',
				'type' => Controls_Manager::SLIDER,
				'render_type' => 'template',
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 3000,
						'step' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-cta' => '--content-transition-duration: {{SIZE}}ms',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
	}

	protected function __subtitle_style_controls() {
		$this->start_controls_section(
			'subtitle_style',
			[
				'label' => esc_html__( 'Sub Title', 'zyre-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'subtitle!' => '',
				],
			]
		);

		$this->text_style_controls( 'subtitle' );

		$this->end_controls_section();
	}

	protected function __title_style_controls() {
		$this->start_controls_section(
			'title_style',
			[
				'label' => esc_html__( 'Title', 'zyre-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'title!' => '',
				],
			]
		);

		$this->text_style_controls( 'title' );

		$this->end_controls_section();
	}

	protected function __title_prefix_style_controls() {
		$this->start_controls_section(
			'title_prefix_style',
			[
				'label' => esc_html__( 'Title Prefix', 'zyre-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'title_prefix!' => '',
				],
			]
		);

		$this->text_style_controls( 'title_prefix' );

		$this->end_controls_section();
	}

	protected function __title_suffix_style_controls() {
		$this->start_controls_section(
			'title_suffix_style',
			[
				'label' => esc_html__( 'Title Suffix', 'zyre-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'title_suffix!' => '',
				],
			]
		);

		$this->text_style_controls( 'title_suffix' );

		$this->end_controls_section();
	}

	protected function __description_style_controls() {
		$this->start_controls_section(
			'description_style',
			[
				'label' => esc_html__( 'Description', 'zyre-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'description!' => '',
				],
			]
		);

		$this->text_style_controls( 'description' );

		$this->end_controls_section();
	}

	protected function __button_general_style_controls() {
		$this->start_controls_section(
			'section_general_style',
			[
				'label'     => esc_html__( 'Button General', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'button_show!' => 'none',
				],
			]
		);

		$this->set_style_controls(
			'dual_button',
			[
				'selector' => '{{WRAPPER}} .zyre-cta-buttons',
				'controls' => [
					'layout'          => [
						'label'     => esc_html__( 'Layout', 'zyre-elementor-addons' ),
						'default'   => 'row',
						'condition' => [
							'button_show' => 'dual-button',
						],
					],
					'justify_content' => [
						'label'       => esc_html__( 'Justify Content', 'zyre-elementor-addons' ),
						'label_block' => true,
						'condition'   => [
							'dual_button_layout' => 'row',
							'button_layout'      => ['below', ''],
						],
					],
					'gap'             => [
						'label'     => esc_html__( 'Spacing', 'zyre-elementor-addons' ),
						'default'   => [
							'unit' => 'px',
						],
						'range'     => [
							'px' => [
								'max' => 500,
							],
						],
						'condition' => [
							'button_show' => 'dual-button',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'dual_button_position',
			[
				'label'                => esc_html__( 'Position', 'zyre-elementor-addons' ),
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
					'left'   => 'margin-right: auto;align-items:flex-start;',
					'center' => 'margin-left: auto;margin-right: auto;align-items:center;',
					'right'  => 'margin-left: auto;align-items:flex-end;',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-cta-buttons' => '{{VALUE}};',
				],
				'condition'            => [
					'dual_button_layout' => 'column',
					'button_show' => 'dual-button',
				],
			]
		);

		$this->set_style_controls(
			'dual_button',
			[
				'selector' => '{{WRAPPER}} .zyre-cta-buttons',
				'controls' => [
					'position_y' => [
						'label'     => esc_html__( 'Vertical Position', 'zyre-elementor-addons' ),
					],
					'padding'    => [],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __button_style_controls() {
		// Primary button style controls
		$this->start_controls_section(
			'section_primary_button_style',
			[
				'label' => esc_html__( 'Primary Button', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'button_show!' => 'none',
					'button_show' => [ 'button', 'dual-button' ],
				],
			]
		);

		$this->register_button_style_controls( [ 'id_prefix' => 'primary' ] );

		$this->end_controls_section();

		// Primary Button Icon style controls
		$this->start_controls_section(
			'section_primary_button_icon_style',
			[
				'label'      => esc_html__( 'Primary Button Icon', 'zyre-elementor-addons' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'button_show',
							'operator' => '!=',
							'value'    => 'none',
						],
						[
							'name'     => 'primary_button_icon[value]',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->register_button_icon_style_controls( [ 'id_prefix' => 'primary' ] );

		$this->end_controls_section();

		// Connector style controls
		$this->connector_style_controls();

		// Secondary button style controls
		$this->start_controls_section(
			'section_secondary_button_style',
			[
				'label' => esc_html__( 'Secondary Button', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'button_show!' => 'none',
					'button_show' => [ 'dual-button' ],
				],
			]
		);

		$this->register_button_style_controls( [ 'id_prefix' => 'secondary' ] );

		$this->end_controls_section();

		// Secondary Button Icon style controls
		$this->start_controls_section(
			'section_secondary_button_icon_style',
			[
				'label'      => esc_html__( 'Secondary Button Icon', 'zyre-elementor-addons' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'button_show',
							'operator' => '==',
							'value'    => 'dual-button',
						],
						[
							'name'     => 'secondary_button_icon[value]',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->register_button_icon_style_controls( [ 'id_prefix' => 'secondary' ] );

		$this->end_controls_section();
	}

	/**
	 * Connector style controls
	 */
	protected function connector_style_controls() {
		$this->start_controls_section(
			'section_button_connector_style',
			[
				'label'     => esc_html__( 'Button Connector', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'button_show!'          => 'none',
					'button_show'           => [ 'dual-button' ],
					'show_button_connector' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'button_connector',
			[
				'selector'  => '{{WRAPPER}} .zyre-button-connector-text',
				'controls'  => [
					'typography' => [],
				],
				'condition' => [
					'button_connector_type'  => 'text',
					'button_connector_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_connector_color',
			[
				'label'     => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .zyre-button-connector, {{WRAPPER}} .zyre-button-connector > i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-button-connector > svg'                                   => 'fill: {{VALUE}};',
				],
			]
		);

		$this->set_style_controls(
			'button_connector',
			[
				'selector' => '{{WRAPPER}} .zyre-button-connector',
				'controls' => [
					'background' => [],
					'icon_size'  => [
						'selector'  => '{{WRAPPER}} .zyre-button-connector-icon',
						'default'   => [
							'unit' => 'px',
						],
						'range'     => [
							'px' => [
								'min' => 5,
							],
						],
						'condition' => [
							'button_connector_type'         => 'icon',
							'button_connector_icon[value]!' => '',
						],
					],
					'width'      => [
						'range' => [
							'px' => [
								'min' => 5,
							],
						],
					],
					'height'     => [
						'range' => [
							'px' => [
								'min' => 5,
							],
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'button_connector_align',
			[
				'label'                => esc_html__( 'Align', 'zyre-elementor-addons' ),
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
					'left'   => 'margin-left: 0;margin-right: auto;',
					'center' => 'margin-left: auto;margin-right: auto;',
					'right'  => 'margin-left: auto;margin-right: 0;',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-button-connector' => '{{VALUE}}',
				],
			]
		);

		$this->set_style_controls(
			'button_connector_wrapper',
			[
				'selector' => '{{WRAPPER}} .zyre-button-connector-wrapper',
				'controls' => [
					'width' => [
						'label'     => esc_html__( 'Wrapper Width', 'zyre-elementor-addons' ),
						'condition' => [
							'button_show'        => 'dual-button',
							'dual_button_layout' => 'column',
						],
					],
				],
			]
		);

		$this->add_control(
			'button_connector_position',
			[
				'label'     => esc_html__( 'Position', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''         => esc_html__( 'Default', 'zyre-elementor-addons' ),
					'absolute' => esc_html__( 'Absolute', 'zyre-elementor-addons' ),
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-button-connector' => 'position: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'button_connector_offset_x',
			[
				'label'      => esc_html__( 'Horizontal Offset', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'%'  => [
						'min' => -100,
						'max' => 100,
					],
					'px' => [
						'min' => -1000,
						'max' => 1000,
					],
				],
				'default'    => [
					'unit' => '%',
					'size' => -50,
				],
				'size_units' => [ '%', 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .zyre-button-connector' => '--translate-x: {{SIZE}}{{UNIT}}',
				],
				'condition'  => [
					'button_connector_position!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'button_connector_offset_y',
			[
				'label'      => esc_html__( 'Vertical Offset', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'%'  => [
						'min' => -100,
						'max' => 100,
					],
					'px' => [
						'min' => -1000,
						'max' => 1000,
					],
				],
				'default'    => [
					'unit' => '%',
					'size' => -50,
				],
				'size_units' => [ '%', 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .zyre-button-connector' => '--translate-y: {{SIZE}}{{UNIT}}',
				],
				'condition'  => [
					'button_connector_position!' => '',
				],
			]
		);

		$this->set_style_controls(
			'button_connector',
			[
				'selector' => '{{WRAPPER}} .zyre-button-connector',
				'controls' => [
					'z_index'       => [
						'min' => 0,
					],
					'border'        => [
						'separator' => 'before',
					],
					'border_radius' => [],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __ribbon_style_controls() {
		$this->start_controls_section(
			'ribbon_style',
			[
				'label' => esc_html__( 'Ribbon', 'zyre-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'ribbon_title!' => '',
				],
			]
		);

		$this->set_style_controls(
			'ribbon',
			[
				'selector' => '{{WRAPPER}} .zyre-cta-ribbon-title',
				'controls' => [
					'background' => [
						'label' => esc_html__( 'Text Background', 'zyre-elementor-addons' ),
					],
					'color'      => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
					'typography' => [
						'fields_options' => [
							'typography'  => [ 'default' => 'yes' ],
							'font_family' => [ 'default' => 'Inter' ],
						],
					],
					'padding'    => [],
					'border'     => [],
					'box_shadow' => [],
				],
			]
		);

		$ribbon_distance_transform = is_rtl() ? 'translateY(-50%) translateX({{SIZE}}{{UNIT}}) rotate(-45deg)' : 'translateY(-50%) translateX(-50%) translateX({{SIZE}}{{UNIT}}) rotate(var(--rotate))';

		$this->add_responsive_control(
			'ribbon_distance',
			[
				'label' => esc_html__( 'Distance', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'max' => 50,
					],
					'em' => [
						'max' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-cta-ribbon .zyre-cta-ribbon-title' => 'margin-top: {{SIZE}}{{UNIT}}; transform: ' . $ribbon_distance_transform,
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'ribbon_rotate',
			[
				'label' => esc_html__( 'Rotate', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'deg', 'grad', 'rad', 'turn', 'custom' ],
				'default' => [
					'unit' => 'deg',
				],
				'range'      => [
					'deg'  => [
						'min' => -360,
						'max' => 360,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-cta-ribbon .zyre-cta-ribbon-title' => '--rotate: {{SIZE}}{{UNIT}};',
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
		$display_default = ( 'title_prefix' === $prefix || 'title_suffix' === $prefix ) ? 'inline' : 'block';

		$this->add_control(
			$prefix . '_display',
			[
				'label' => esc_html__( 'Display as', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => $display_default,
				'options' => [
					'block' => esc_html__( 'Block', 'zyre-elementor-addons' ),
					'inline-block' => esc_html__( 'Inline Block', 'zyre-elementor-addons' ),
					'inline'       => esc_html__( 'Inline', 'zyre-elementor-addons' ),
					'table' => esc_html__( 'Table', 'zyre-elementor-addons' ),
				],
				'render_type' => 'template',
				'selectors' => [
					'{{WRAPPER}} .zyre-cta-' . $class_base => 'display: {{VALUE}};',
				],
			]
		);

		$this->set_style_controls(
			$prefix,
			[
				'selector' => '{{WRAPPER}} .zyre-cta-' . $class_base,
				'controls' => [
					'typography' => [],
				],
			]
		);

		$selectors_values = [
			"{{WRAPPER}} .zyre-cta-{$class_base}.zyre-d-block" => 'margin-bottom: {{SIZE}}{{UNIT}};',
			"{{WRAPPER}} .zyre-cta-{$class_base}.zyre-d-table" => 'margin-bottom: {{SIZE}}{{UNIT}};',
			"{{WRAPPER}} .zyre-cta-{$class_base}:not(.zyre-d-block):not(.zyre-d-table)" => 'margin-right: {{SIZE}}{{UNIT}};',
		];
		if ( 'title_prefix' === $prefix ) {
			$selectors_values = [
				"{{WRAPPER}} .zyre-cta-{$class_base}.zyre-d-block" => 'margin-bottom: {{SIZE}}{{UNIT}};',
				"{{WRAPPER}} .zyre-cta-{$class_base}.zyre-d-table" => 'margin-bottom: {{SIZE}}{{UNIT}};',
				"{{WRAPPER}} .zyre-cta-{$class_base}:not(.zyre-d-block):not(.zyre-d-table)" => 'margin-right: {{SIZE}}{{UNIT}};',
			];
		}
		if ( 'title_suffix' === $prefix ) {
			$selectors_values = [
				"{{WRAPPER}} .zyre-cta-{$class_base}.zyre-d-block" => 'margin-top: {{SIZE}}{{UNIT}};',
				"{{WRAPPER}} .zyre-cta-{$class_base}.zyre-d-table" => 'margin-top: {{SIZE}}{{UNIT}};',
				"{{WRAPPER}} .zyre-cta-{$class_base}:not(.zyre-d-block):not(.zyre-d-table)" => 'margin-left: {{SIZE}}{{UNIT}};',
			];
		}

		$this->add_responsive_control(
			$prefix . '_space',
			[
				'label' => esc_html__( 'Spacing', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
					'em' => [
						'min' => -12,
						'max' => 12,
					],
					'rem' => [
						'min' => -12,
						'max' => 12,
					],
				],
				'selectors' => $selectors_values,
			]
		);

		$this->set_style_controls(
			$prefix,
			[
				'selector' => '{{WRAPPER}} .zyre-cta-' . $class_base,
				'controls' => [
					'text_color'    => [],
					'background'    => [],
					'border'        => [],
					'border_radius' => [],
					'box_shadow'    => [],
					'padding'       => [],
				],
			]
		);
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$title_tag = Utils::validate_html_tag( $settings['title_tag'] );
		$subtitle_tag = Utils::validate_html_tag( $settings['subtitle_tag'] );
		$description_tag = Utils::validate_html_tag( $settings['description_tag'] );
		$bg_image = '';
		$show_bg = true;
		$show_content = true;

		if ( ! empty( $settings['bg_image']['id'] ) ) {
			$bg_image = Group_Control_Image_Size::get_attachment_image_src( $settings['bg_image']['id'], 'bg_image', $settings );
		} elseif ( ! empty( $settings['bg_image']['url'] ) ) {
			$bg_image = $settings['bg_image']['url'];
		}

		if ( empty( $bg_image ) && 'classic' === $settings['skin'] ) {
			$show_bg = false;
		}

		if ( empty( $settings['title'] ) && empty( $settings['subtitle'] ) && empty( $settings['description'] ) ) {
			$show_content = false;
		}

		$this->add_render_attribute( 'wrapper', 'class', 'zyre-cta zy-flex zy-relative' );

		$this->add_render_attribute(
			'background_image',
			[
				'style' => 'background-image: url(' . esc_url( $bg_image ) . ');',
				'role' => 'img',
				'aria-label' => Control_Media::get_image_alt( $settings['bg_image'] ),
			]
		);

		$this->add_render_attribute( 'content_wrapper', 'class', 'zyre-cta-content-wrapper zy-flex zy-flex-wrap zy-overflow-hidden zy-w-100 zy-relative zy-index-1' );
		$this->add_render_attribute( 'content', 'class', 'zyre-cta-content zy-flex zy-flex-wrap zy-w-100' );
		$this->add_render_attribute( 'title_main', 'class', 'zyre-cta-title' );
		if ( ! empty( $settings['title_display'] ) ) {
			$this->add_render_attribute( 'title_main', 'class', esc_attr( 'zyre-d-' . $settings['title_display'] ) );
		}
		$this->add_render_attribute( 'title', 'class', 'zyre-cta-title-text' );
		$this->add_render_attribute( 'title_prefix', 'class', 'zyre-cta-title-prefix' );
		if ( ! empty( $settings['title_prefix_display'] ) ) {
			$this->add_render_attribute( 'title_prefix', 'class', esc_attr( 'zyre-d-' . $settings['title_prefix_display'] ) );
		}
		$this->add_render_attribute( 'title_suffix', 'class', 'zyre-cta-title-suffix' );
		if ( ! empty( $settings['title_suffix_display'] ) ) {
			$this->add_render_attribute( 'title_suffix', 'class', esc_attr( 'zyre-d-' . $settings['title_suffix_display'] ) );
	}
		$this->add_render_attribute( 'subtitle', 'class', 'zyre-cta-subtitle' );
		if ( ! empty( $settings['subtitle_display'] ) ) {
			$this->add_render_attribute( 'subtitle', 'class', esc_attr( 'zyre-d-' . $settings['subtitle_display'] ) );
		}
		$this->add_render_attribute( 'description', 'class', 'zyre-cta-description' );
		if ( ! empty( $settings['description_display'] ) ) {
			$this->add_render_attribute( 'description', 'class', esc_attr( 'zyre-d-' . $settings['description_display'] ) );
		}
		$this->add_render_attribute( 'media_element', 'class', 'zyre-cta-media' );

		if ( ! empty( $settings['media_layout'] ) ) {
			$this->add_render_attribute( 'content_wrapper', 'class', 'zyre-cta-content-media--' . $settings['media_layout'] );
		}

		if ( ! empty( $settings['button_layout'] ) ) {
			$this->add_render_attribute( 'content', 'class', 'zyre-cta-content-button--' . $settings['button_layout'] );
		}

		if ( 'icon' === $settings['media_element'] ) {
			$this->add_render_attribute( 'media_element', 'class', 'zyre-cta-icon-wrapper' );

			if ( ! isset( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
				// add old default
				$settings['icon'] = 'fa fa-star';
			}

			if ( ! empty( $settings['icon'] ) ) {
				$this->add_render_attribute( 'icon', 'class', $settings['icon'] );
			}
		} elseif ( 'image' === $settings['media_element'] && ! empty( $settings['media_image']['url'] ) ) {
			$this->add_render_attribute( 'media_element', 'class', 'zyre-cta-image zy-overflow-hidden' );
		}

		$this->add_inline_editing_attributes( 'subtitle' );
		$this->add_inline_editing_attributes( 'title' );
		$this->add_inline_editing_attributes( 'title_prefix' );
		$this->add_inline_editing_attributes( 'title_suffix' );
		$this->add_inline_editing_attributes( 'description' );

		$migrated = isset( $settings['__fa4_migrated']['selected_icon'] );
		$is_new = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<?php if ( $show_bg ) : ?>
				<div class="zyre-cta-bg-wrapper zy-overflow-hidden zy-index-1">
					<div class="zyre-cta-bg elementor-bg zy-left-0 zy-right-0 zy-top-0 zy-bottom-0 zy-absolute zy-index-1 zy-bg-50 zy-bg-cover zy-bg-no-repeat" <?php $this->print_render_attribute_string( 'background_image' ); ?>></div>
					<div class="zyre-cta-bg-overlay zy-left-0 zy-right-0 zy-top-0 zy-bottom-0 zy-absolute zy-index-2"></div>
				</div>
			<?php endif; ?>
			<?php if ( $show_content || 'none' !== $settings['media_element'] || 'none' !== $settings['button_show'] ) : ?>
				<div <?php $this->print_render_attribute_string( 'content_wrapper' ); ?>>
					<?php if ( 'image' === $settings['media_element'] && ! empty( $settings['media_image']['url'] ) ) : ?>
						<div <?php $this->print_render_attribute_string( 'media_element' ); ?>>
							<?php Group_Control_Image_Size::print_attachment_image_html( $settings, 'media_image' ); ?>
						</div>
					<?php elseif ( 'icon' === $settings['media_element'] && ( ! empty( $settings['icon'] ) || ! empty( $settings['selected_icon']['value'] ) ) ) : ?>
						<div <?php $this->print_render_attribute_string( 'media_element' ); ?>>
							<span class="zyre-cta-icon zy-inline-block zy-lh-1 zy-content-center">
								<?php if ( $is_new || $migrated ) :
									Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
								else : ?>
									<i <?php $this->print_render_attribute_string( 'icon' ); ?>></i>
								<?php endif; ?>
							</span>
						</div>
					<?php endif; ?>

					<div <?php $this->print_render_attribute_string( 'content' ); ?>>
						<?php if ( $show_content ) : ?>
							<div class="zyre-cta-content-elements">
								<?php if ( ! empty( $settings['subtitle'] ) ) : ?>
									<<?php Utils::print_validated_html_tag( $subtitle_tag ); ?> <?php $this->print_render_attribute_string( 'subtitle' ); ?>>
										<?php $this->print_unescaped_setting( 'subtitle' ); ?>
									</<?php Utils::print_validated_html_tag( $subtitle_tag ); ?>>
								<?php endif; ?>

								<?php if ( ! empty( $settings['title'] ) ) : ?>
									<<?php Utils::print_validated_html_tag( $title_tag ); ?> <?php $this->print_render_attribute_string( 'title_main' ); ?>>
										<?php if ( ! empty( $settings['title_prefix'] ) ) : ?>
											<span <?php $this->print_render_attribute_string( 'title_prefix' ); ?>><?php $this->print_unescaped_setting( 'title_prefix' ); ?></span>
										<?php endif; ?>
										<span <?php $this->print_render_attribute_string( 'title' ); ?>><?php $this->print_unescaped_setting( 'title' ); ?></span>
										<?php if ( ! empty( $settings['title_suffix'] ) ) : ?>
											<span <?php $this->print_render_attribute_string( 'title_suffix' ); ?>><?php $this->print_unescaped_setting( 'title_suffix' ); ?></span>
										<?php endif; ?>
									</<?php Utils::print_validated_html_tag( $title_tag ); ?>>
								<?php endif; ?>

								<?php if ( ! empty( $settings['description'] ) ) : ?>
									<<?php Utils::print_validated_html_tag( $description_tag ); ?> <?php $this->print_render_attribute_string( 'description' ); ?>>
										<?php echo zyre_kses_basic( $settings['description'] ); ?>
									</<?php Utils::print_validated_html_tag( $description_tag ); ?>>
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<?php if ( 'none' !== $settings['button_show'] ) : ?>
							<div class="zyre-cta-buttons zy-flex zy-align-center zy-justify-start">
								<?php $this->render_button( null, [ 'id_prefix' => 'primary' ] ); ?>

								<?php if ( 'yes' === $settings['show_button_connector'] ) { ?>
								<span class="zyre-button-connector-wrapper zy-relative">
									<?php if ( 'text' === $settings['button_connector_type'] ) { ?>
										<span class="zyre-button-connector zyre-button-connector-text zy-flex zy-align-center zy-justify-center zy-nowrap"><?php echo esc_html( $settings['button_connector_text'] ); ?></span>
									<?php } ?>
									<?php if ( 'icon' === $settings['button_connector_type'] ) { ?>
										<span class="zyre-button-connector zyre-button-connector-icon zy-flex zy-align-center zy-justify-center zy-nowrap"><?php Icons_Manager::render_icon( $settings['button_connector_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
									<?php } ?>
								</span>
								<?php } ?>

								<?php $this->render_button( null, [ 'id_prefix' => 'secondary' ] ); ?>
							</div>
						<?php endif; ?>
					</div> <!-- \END .zyre-cta-content -->
				</div>
			<?php endif; ?>

			<?php
			if ( ! empty( $settings['ribbon_title'] ) ) :
				$this->add_render_attribute( 'ribbon-wrapper', 'class', 'zyre-cta-ribbon zy-absolute zy-left-auto zy-right-0 zy-top-0 zy-index-1 zy-overflow-hidden' );

				if ( ! empty( $settings['ribbon_position_x'] ) ) {
					$this->add_render_attribute( 'ribbon-wrapper', 'class', 'zyre-cta-ribbon-' . $settings['ribbon_position_x'] );
				}
				?>
				<div <?php $this->print_render_attribute_string( 'ribbon-wrapper' ); ?>>
					<div class="zyre-cta-ribbon-title zy-bg-black zy-color-white zy-left-0 zy-lh-2 zy-text-center zy-uppercase"><?php $this->print_unescaped_setting( 'ribbon_title' ); ?></div>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}
}
