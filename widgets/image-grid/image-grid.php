<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Image_Grid extends Base {

	/**
	 * The default filter acts as the global filter
	 * and can be overridden in the settings.
	 *
	 * @var string
	 */
	protected $_default_filter = '*';

	public function get_title() {
		return esc_html__( 'Image Grid', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Image-grid';
	}

	public function get_keywords() {
		return [ 'image list', 'images lists', 'image grid', 'media grid', 'media filter', 'gallery', 'image gallery', 'media gallery', 'portfolio' ];
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	protected function register_content_controls() {
		$this->start_controls_section(
			'section_content_general',
			[
				'label' => esc_html__( 'General', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();
	
		$repeater = new Repeater();

		$repeater->add_control(
			'image',
			[
				'label'   => esc_html__( 'Upload Image', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'category',
			[
				'label'       => esc_html__( 'Category', 'zyre-elementor-addons' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Separate multiple categories with commas \',\'', 'zyre-elementor-addons' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'link',
			[
				'label'       => esc_html__( 'Link', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://example.com/',
				'label_block' => true,
			]
		);

		$repeater->add_responsive_control(
			'width',
			[
				'label'          => esc_html__( 'Span Width', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::NUMBER,
				'min'            => 1,
				'max'            => 12,
				'default'        => 1,
				'tablet_default' => 1,
        		'mobile_default' => 1,
				'selectors'      => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.zyre-image-grid-item' => 'width: calc((100% / var(--image-grid-column)) * {{VALUE}});',
				],
				'render_type'    => 'template',
				'style_transfer' => true,
			]
		);

		$repeater->add_responsive_control(
			'height',
			[
				'label'          => esc_html__( 'Span Height', 'zyre-elementor-addons' ),
				'description'	 => esc_html__( 'Works if “Content Display” is set to “Overlay”', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::NUMBER,
				'min'            => 1,
				'max'            => 12,
				'default'        => 1,
				'tablet_default' => 1,
        		'mobile_default' => 1,
				'selectors'      => [
					'{{WRAPPER}}.zyre-image-grid-content-display--overlay {{CURRENT_ITEM}}.zyre-image-grid-item' => '--item-span-height: {{VALUE}};',
				],
				'render_type'    => 'template',
				'style_transfer' => true,
			]
		);

		$this->add_control(
			'all_items',
			[
				'label'              => esc_html__( 'All Items', 'zyre-elementor-addons' ),
				'type'               => Controls_Manager::REPEATER,
				'default'            => [
					[
						'title'    => 'Image #1',
						'category' => 'Category 1',
					],
					[
						'title'    => 'Image #2',
						'category' => 'Category 2',
					],
					[
						'title'    => 'Image #3',
						'category' => 'Category 3',
					],
					[
						'title'    => 'Image #4',
						'category' => 'Category 1',
					],
					[
						'title'    => 'Image #5',
						'category' => 'Category 2',
					],
					[
						'title'    => 'Image #6',
						'category' => 'Category 3',
					],
				],
				'frontend_available' => true,
				'fields'             => $repeater->get_controls(),
				'title_field'        => '{{{ "" !== title ? title : "Image" }}} - {{{ "" !== category ? category : "No Categories" }}}',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'default'   => 'medium_large',
				'separator' => 'before',
				'exclude'   => [
					'custom',
				],
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'              => esc_html__( 'Columns', 'zyre-elementor-addons' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => [
					'1' => esc_html__( 'Column - 1', 'zyre-elementor-addons' ),
					'2' => esc_html__( 'Columns - 2', 'zyre-elementor-addons' ),
					'3' => esc_html__( 'Columns - 3', 'zyre-elementor-addons' ),
					'4' => esc_html__( 'Columns - 4', 'zyre-elementor-addons' ),
					'5' => esc_html__( 'Columns - 5', 'zyre-elementor-addons' ),
					'6' => esc_html__( 'Columns - 6', 'zyre-elementor-addons' ),
				],
				'default'            => '4',
				'tablet_default'     => '3',
				'mobile_default'     => '2',
				'selectors'          => [
					'{{WRAPPER}} .zyre-image-grid-item' => '--image-grid-column: {{VALUE}};',
				],
				'frontend_available' => true,
				'style_transfer'     => true,
			]
		);

		$this->add_control(
			'link_switch',
			[
				'label'       => esc_html__( 'Set Link to', 'zyre-elementor-addons' ),
				'description' => esc_html__( 'Ensure items have links and the lightbox is disabled for "Image Only" / "Both Title & Image".', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'image',
				'options'     => [
					'image'       => esc_html__( 'Image Only', 'zyre-elementor-addons' ),
					'title'       => esc_html__( 'Title Only', 'zyre-elementor-addons' ),
					'content'     => esc_html__( 'Content', 'zyre-elementor-addons' ),
					'image_title' => esc_html__( 'Both Title & Image', 'zyre-elementor-addons' ),
					'button'      => esc_html__( 'Button', 'zyre-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'view_button_text',
			[
				'label'     => esc_html__( 'View Button Text', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'View', 'zyre-elementor-addons' ),
				'condition' => [
					'link_switch' => 'button',
				],
			]
		);

		$this->add_control(
			'category_display',
			[
				'label'     => esc_html__( 'Display Category', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'On', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Off', 'zyre-elementor-addons' ),
			]
		);

		$this->add_responsive_control(
			'category_order',
			[
				'label'     => esc_html__( 'Category Order', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => -1,
				'max'       => 5,
				'selectors' => [
					'{{WRAPPER}} .zyre-image-grid-item-category' => 'order: {{VALUE}};',
				],
				'condition' => [
					'category_display' => 'yes',
				],
			]
		);

		$this->add_control(
			'content_display',
			[
				'label'        => esc_html__( 'Content Display', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => '',
				'options'      => [
					''        => esc_html__( 'Default', 'zyre-elementor-addons' ),
					'overlay' => esc_html__( 'Overlay', 'zyre-elementor-addons' ),
				],
				'prefix_class' => 'zyre-image-grid-content-display--',
				'render_type'  => 'template',
			]
		);

		$this->add_control(
			'filter_tabs_show',
			[
				'label'     => esc_html__( 'Filter Tabs', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'On', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Off', 'zyre-elementor-addons' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'filter_tabs_all',
			[
				'label'       => esc_html__( 'Filter All Label', 'zyre-elementor-addons' ),
				'default'     => esc_html__( 'All', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'condition'   => [
					'filter_tabs_show' => 'yes',
				],
			]
		);

		$this->add_control(
			'filter_tab_active',
			[
				'label'     => esc_html__( 'Active Tab', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 0,
				'max'       => 50,
				'condition' => [
					'filter_tabs_show' => 'yes',
				],
			]
		);

		$this->add_control(
			'filter_tabs_separator',
			[
				'label'     => esc_html__( 'Tabs Separator', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'On', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Off', 'zyre-elementor-addons' ),
				'condition' => [
					'filter_tabs_show' => 'yes',
				],
			]
		);

		$this->add_control(
			'tabs_separator_position',
			[
				'label'     => esc_html__( 'Separator Position', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::CHOOSE,
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
					'filter_tabs_show'      => 'yes',
					'filter_tabs_separator' => 'yes',
				],
			]
		);

		$this->add_control(
			'enable_lightbox',
			[
				'label'              => esc_html__( 'Enable Lightbox', 'zyre-elementor-addons' ),
				'type'               => Controls_Manager::SWITCHER,
				'separator'          => 'before',
				'return_value'       => 'yes',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'open_lightbox_on',
			[
				'label'       => esc_html__( 'Open Lightbox on', 'zyre-elementor-addons' ),
				'description' => esc_html__( 'Image click won’t work with Content \'Overlay\' display.', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'icon_click',
				'options'     => [
					'icon_click'   => esc_html__( 'Icon Click', 'zyre-elementor-addons' ),
					'image_click'  => esc_html__( 'Image Click', 'zyre-elementor-addons' ),
					'button_click' => esc_html__( 'Button Click', 'zyre-elementor-addons' ),
				],
				'condition'   => [
					'enable_lightbox' => 'yes',
				],
			]
		);

		$this->add_control(
			'lightbox_button_text',
			[
				'label'     => esc_html__( 'Button Text', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Zoom', 'zyre-elementor-addons' ),
				'condition' => [
					'enable_lightbox'  => 'yes',
					'open_lightbox_on' => 'button_click',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_controls() {
		$this->__items_style_controls();
		$this->__item_style_controls();
		$this->__image_style_controls();
		$this->__item_content_style_controls();
		$this->__tabs_wrap_style_controls();
		$this->__tabs_style_controls();
		$this->__tabs_separator_style_controls();
		$this->__buttons_style_controls();
		$this->__lightbox_btn_style_controls();
	}

	protected function __tabs_wrap_style_controls() {
		$this->start_controls_section(
			'section_style_tabs_wrap',
			[
				'label'     => esc_html__( 'Tabs Wrapper', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'filter_tabs_show' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'tabs_wrap',
			[
				'selector' => '{{WRAPPER}} .zyre-image-grid-filter-tabs',
				'controls' => [
					'border'        => [],
					'border_radius' => [],
					'bg_color'      => [],
					'padding'       => [],
					'margin_bottom' => [
						'label' => esc_html__( 'Margin Bottom', 'zyre-elementor-addons' ),
					],
					'gap'           => [
						'condition' => [
							'filter_tabs_separator' => 'yes',
						],
					],
					'align_x'       => [
						'label_block' => true,
					],
					'align_y'       => [],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __tabs_separator_style_controls() {
		$this->start_controls_section(
			'section_style_tabs_separator',
			[
				'label'     => esc_html__( 'Tabs Separator', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'filter_tabs_show'      => 'yes',
					'filter_tabs_separator' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'tabs_separator',
			[
				'selector' => '{{WRAPPER}} .zyre-image-grid-filter-separator',
				'controls' => [
					'height'        => [],
					'bg_color'      => [],
					'border'        => [],
					'border_radius' => [],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __tabs_style_controls() {
		$this->start_controls_section(
			'section_style_filter_tabs',
			[
				'label'     => esc_html__( 'Filter Tabs', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'filter_tabs_show' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'tabs',
			[
				'selector' => '{{WRAPPER}} .zyre-image-grid-filter-tab',
				'controls' => [
					'row_gap'       => [
						'selector' => '{{WRAPPER}} .zyre-image-grid-filter-tabs > ul',
					],
					'column_gap'    => [
						'selector' => '{{WRAPPER}} .zyre-image-grid-filter-tabs > ul',
					],
					'typo'          => [],
					'border'        => [],
					'border_radius' => [],
					'padding'       => [],
				],
			]
		);

		// Tabs
		$this->start_controls_tabs( '_tabs_tabs' );

		// Tab: Normal
		$this->start_controls_tab(
			'_tabs_tabs_normal',
			[
				'label'     => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'tabs',
			[
				'selector' => '{{WRAPPER}} .zyre-image-grid-filter-tab',
				'controls' => [
					'color'      => [],
					'bg_color'   => [],
					'box_shadow' => [],
				],
			]
		);

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab(
			'_tabs_tabs_hover',
			[
				'label'     => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'tabs_hover',
			[
				'selector' => '{{WRAPPER}} .zyre-image-grid-filter-tab:hover',
				'controls' => [
					'color'        => [],
					'bg_color'     => [],
					'border_color' => [],
					'font_weight'  => [],
					'box_shadow'   => [],
				],
			]
		);

		$this->end_controls_tab();

		// Tab: Active
		$this->start_controls_tab(
			'_tabs_tabs_active',
			[
				'label'     => esc_html__( 'Active', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'tabs_active',
			[
				'selector' => '{{WRAPPER}} .zyre-image-grid-filter-tab.zyre-filter-tab--active',
				'controls' => [
					'color'        => [],
					'bg_color'     => [],
					'border_color' => [],
					'font_weight'  => [],
					'box_shadow'   => [],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function __items_style_controls() {
		$this->start_controls_section(
			'section_items_wrap_style',
			[
				'label' => esc_html__( 'Grid Wrap', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,

			]
		);

		$this->set_style_controls(
			'items_wrap',
			[
				'selector' => '{{WRAPPER}} .zyre-image-grid-items-wrap',
				'controls' => [
					'bg_color'      => [],
					'border'        => [],
					'border_radius' => [],
					'padding'       => [],
					'margin'        => [],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __item_style_controls() {
		$this->start_controls_section(
			'section_style_item',
			[
				'label' => esc_html__( 'Grid Item', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'item',
			[
				'selector' => '{{WRAPPER}} .zyre-image-grid-item-inner',
				'controls' => [
					'height'        => [
						'condition' => [
							'content_display' => 'overlay',
						],
					],
					'bg'            => [],
					'border'        => [],
					'border_radius' => [
						'selector' => '{{WRAPPER}} .zyre-image-grid-item-inner, {{WRAPPER}}.zyre-image-grid-content-display--overlay .zyre-image-grid-item-img',
					],
					'box_shadow'    => [],
					'padding'       => [
						'selector' => '{{WRAPPER}} .zyre-image-grid-item',
					],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __image_style_controls() {
		$this->start_controls_section(
			'section_style_image',
			[
				'label'     => esc_html__( 'Image', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'image',
			[
				'selector'  => '{{WRAPPER}} .zyre-image-grid-item-img',
				'controls'  => [
					'height'        => [],
					'object_fit'    => [
						'label'     => esc_html__( 'Image Fit', 'zyre-elementor-addons' ),
						'default'   => 'cover',
						'condition' => [
							'content_display' => [ '', 'overlay' ],
						],
					],
					'border'        => [],
					'border_radius' => [
						'condition' => [
							'content_display' => [ '', 'overlay' ],
						],
					],
					'box_shadow'    => [],
					'bg_color'      => [],
					'padding'       => [],
				],
				'condition' => [
					'content_display' => '',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __item_content_style_controls() {
		$this->start_controls_section(
			'section_style_item_content',
			[
				'label' => esc_html__( 'Content', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'item_content',
			[
				'selector' => '{{WRAPPER}} .zyre-image-grid-item-content',
				'controls' => [
					'border'        => [],
					'border_radius' => [],
					'padding'       => [],
					'margin'        => [],
					'align_y'       => [
						'css_property' => 'align-content',
						'condition'    => [
							'content_display' => 'overlay',
						],
					],
					'align'         => [],
				],
			]
		);

		// Tabs
		$this->start_controls_tabs( 'tabs_item_content' );

		// Tab: Normal
		$this->start_controls_tab(
			'tab_item_content_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'item_content',
			[
				'selector' => '{{WRAPPER}} .zyre-image-grid-item-content',
				'controls' => [
					'bg'         => [
						'selector' => '{{WRAPPER}} .zyre-image-grid-item-content',
					],
					'color_1'    => [
						'label'    => esc_html__( 'Title Color', 'zyre-elementor-addons' ),
						'selector' => '{{WRAPPER}} .zyre-image-grid-item-title, {{WRAPPER}} .zyre-image-grid-item-title > a',
					],
					'color_2'    => [
						'label'    => esc_html__( 'Category Color', 'zyre-elementor-addons' ),
						'selector' => '{{WRAPPER}} .zyre-image-grid-item-category',
					],
					'color_3'    => [
						'label'    => esc_html__( 'Description Color', 'zyre-elementor-addons' ),
						'selector' => '{{WRAPPER}} .zyre-image-grid-item-description',
					],
					'box_shadow' => [],
					'opacity'    => [
						'selector'  => '{{WRAPPER}}.zyre-image-grid-content-display--overlay .zyre-image-grid-item-content',
						'condition' => [
							'content_display' => 'overlay',
						],
					],
				],
			]
		);

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab(
			'tab_item_content_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'item_content_hover',
			[
				'selector' => '{{WRAPPER}} .zyre-image-grid-item-content:hover',
				'controls' => [
					'bg'             => [
						'selector' => '{{WRAPPER}}:not(.zyre-image-grid-content-display--overlay) .zyre-image-grid-item-content:hover::before,
									{{WRAPPER}}.zyre-image-grid-content-display--overlay .zyre-image-grid-item:hover .zyre-image-grid-item-content::before',
					],
					'border_color'   => [],
					'color_1'        => [
						'label'    => esc_html__( 'Title Color', 'zyre-elementor-addons' ),
						'selector' => '{{WRAPPER}} .zyre-image-grid-item-content:hover .zyre-image-grid-item-title, {{WRAPPER}} .zyre-image-grid-item-title > a:hover',
					],
					'border_color_1' => [
						'label'    => esc_html__( 'Title Border Color', 'zyre-elementor-addons' ),
						'selector' => '{{WRAPPER}} .zyre-image-grid-item-content:hover .zyre-image-grid-item-title',
					],
					'color_2'        => [
						'label'    => esc_html__( 'Category Color', 'zyre-elementor-addons' ),
						'selector' => '{{WRAPPER}} .zyre-image-grid-item-content:hover .zyre-image-grid-item-category',
					],
					'border_color_2' => [
						'label'    => esc_html__( 'Category Border Color', 'zyre-elementor-addons' ),
						'selector' => '{{WRAPPER}} .zyre-image-grid-item-content:hover .zyre-image-grid-item-category',
					],
					'color_3'        => [
						'label'    => esc_html__( 'Description Color', 'zyre-elementor-addons' ),
						'selector' => '{{WRAPPER}} .zyre-image-grid-item-content:hover .zyre-image-grid-item-description',
					],
					'border_color_3' => [
						'label'    => esc_html__( 'Description Border Color', 'zyre-elementor-addons' ),
						'selector' => '{{WRAPPER}} .zyre-image-grid-item-content:hover .zyre-image-grid-item-description',
					],
					'box_shadow'     => [],
					'opacity'        => [
						'selector'  => '{{WRAPPER}}.zyre-image-grid-content-display--overlay .zyre-image-grid-item:hover .zyre-image-grid-item-content',
						'condition' => [
							'content_display' => 'overlay',
						],
					],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->set_style_controls(
			'item_title',
			[
				'selector' => '{{WRAPPER}} .zyre-image-grid-item-title',
				'controls' => [
					'heading' => [
						'label'     => esc_html__( 'Title', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
					'typo'    => [
						'selector' => '{{WRAPPER}} .zyre-image-grid-item-title, {{WRAPPER}} .zyre-image-grid-item-title > a',
					],
					'border'  => [],
					'padding' => [],
					'margin'  => [],
				],
			]
		);

		$this->set_style_controls(
			'item_category',
			[
				'selector'  => '{{WRAPPER}} .zyre-image-grid-item-category',
				'controls'  => [
					'heading' => [
						'label'     => esc_html__( 'Category', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
					'typo'    => [],
					'border'  => [],
					'padding' => [],
					'margin'  => [],
				],
				'condition' => [
					'category_display' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'item_description',
			[
				'selector' => '{{WRAPPER}} .zyre-image-grid-item-description',
				'controls' => [
					'heading' => [
						'label'     => esc_html__( 'Description', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
					'typo'    => [],
					'border'  => [],
					'padding' => [],
					'margin'  => [],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __buttons_style_controls() {
		$this->start_controls_section(
			'section_style_buttons',
			[
				'label'      => esc_html__( 'Buttons', 'zyre-elementor-addons' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'link_switch',
							'operator' => '==',
							'value'    => 'button',
						],
						[
							'relation' => 'and',
							'terms'    => [
								[
									'name'     => 'enable_lightbox',
									'operator' => '==',
									'value'    => 'yes',
								],
								[
									'name'     => 'open_lightbox_on',
									'operator' => '==',
									'value'    => 'button_click',
								],
							],
						],
					],
				],
			]
		);

		$this->set_style_controls(
			'buttons',
			[
				'selector' => '{{WRAPPER}} .zyre-image-grid-buttons > a',
				'controls' => [
					'typo'          => [],
					'padding'       => [
						'label' => esc_html__( 'Buttons Padding', 'zyre-elementor-addons' ),
					],
					'border_radius' => [
						'label' => esc_html__( 'Buttons Radius', 'zyre-elementor-addons' ),
					],
					'margin'        => [
						'selector' => '{{WRAPPER}} .zyre-image-grid-buttons',
					],
					'gap'           => [
						'selector' => '{{WRAPPER}} .zyre-image-grid-buttons',
					],
				],
			]
		);

		$this->add_control(
			'heading_view_button',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'View Button', 'zyre-elementor-addons' ),
				'separator' => 'before',
				'condition' => [
					'link_switch' => 'button',
				],
			]
		);

		// Tabs
		$this->start_controls_tabs(
			'tabs_view_button',
			[
				'condition' => [
					'link_switch' => 'button',
				],
			]
		);

		// Tab: Normal
		$this->start_controls_tab(
			'tab_view_button_normal',
			[
				'label'     => esc_html__( 'Normal', 'zyre-elementor-addons' ),
				'condition' => [
					'link_switch' => 'button',
				],
			]
		);

		$this->set_style_controls(
			'view_button',
			[
				'selector'  => '{{WRAPPER}} .zyre-image-grid-view-button',
				'controls'  => [
					'color'    => [],
					'bg_color' => [],
				],
				'condition' => [
					'link_switch' => 'button',
				],
			]
		);

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab(
			'tab_view_button_hover',
			[
				'label'     => esc_html__( 'Hover', 'zyre-elementor-addons' ),
				'condition' => [
					'link_switch' => 'button',
				],
			]
		);

		$this->set_style_controls(
			'view_button_hover',
			[
				'selector'  => '{{WRAPPER}} .zyre-image-grid-view-button:hover',
				'controls'  => [
					'color'        => [],
					'bg_color'     => [],
				],
				'condition' => [
					'link_switch' => 'button',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function __lightbox_btn_style_controls() {
		$this->start_controls_section(
			'section_style_lightbox_btn',
			[
				'label'     => esc_html__( 'Lightbox Button', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'enable_lightbox'  => 'yes',
					'open_lightbox_on' => [ 'button_click', 'icon_click' ],
				],
			]
		);

		$this->set_style_controls(
			'lightbox_btn',
			[
				'selector'  => '{{WRAPPER}} .zyre-image-grid-open-lightbox-btn',
				'controls'  => [
					'width'      => [],
					'height'     => [],
					'bg_color'   => [],
					'icon_size'  => [],
					'icon_color' => [],
				],
				'condition' => [
					'open_lightbox_on' => 'icon_click',
				],
			]
		);

		// Tabs
		$this->start_controls_tabs(
			'tabs_lightbox_zoom_btn',
			[
				'condition' => [
					'open_lightbox_on' => 'button_click',
				],
			]
		);

		// Tab: Normal
		$this->start_controls_tab(
			'tab_lightbox_zoom_btn_normal',
			[
				'label'     => esc_html__( 'Normal', 'zyre-elementor-addons' ),
				'condition' => [
					'open_lightbox_on' => 'button_click',
				],
			]
		);

		$this->set_style_controls(
			'lightbox_zoom_btn',
			[
				'selector'  => '{{WRAPPER}} .zyre-image-grid-zoom-button',
				'controls'  => [
					'color'    => [],
					'bg_color' => [],
				],
				'condition' => [
					'open_lightbox_on' => 'button_click',
				],
			]
		);

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab(
			'tab_lightbox_zoom_btn_hover',
			[
				'label'     => esc_html__( 'Hover', 'zyre-elementor-addons' ),
				'condition' => [
					'open_lightbox_on' => 'button_click',
				],
			]
		);

		$this->set_style_controls(
			'lightbox_zoom_btn_hover',
			[
				'selector'  => '{{WRAPPER}} .zyre-image-grid-zoom-button:hover',
				'controls'  => [
					'color'        => [],
					'bg_color'     => [],
				],
				'condition' => [
					'open_lightbox_on' => 'button_click',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Format Category
	 *
	 * Format Category to be inserted in class attribute.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param string $category category slug.
	 *
	 * @return string The filtered $category_slug.
	 */
	public function format_category( $category ) {

		$category_slug = trim( $category );

		$category_slug = extension_loaded( 'mbstring' ) ? mb_strtolower( $category_slug ) : strtolower( $category_slug );

		if ( strpos( $category_slug, 'class' ) || strpos( $category_slug, 'src' ) ) {
			$category_slug = substr( $category_slug, strpos( $category_slug, '"' ) + 1 );
			$category_slug = strtok( $category_slug, '"' );
			$category_slug = preg_replace( '/[http:.]/', '', $category_slug );
			$category_slug = str_replace( '/', '', $category_slug );
		}

		$category_slug = str_replace( ', ', ',', $category_slug );
		$category_slug = preg_replace( '/[\s_`\'&@!#%]/', '-', $category_slug );
		$category_slug = str_replace( ',', ' ', $category_slug );

		return $category_slug;
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$show_filter_tabs = $settings['filter_tabs_show'];
		$spr_position = $settings['tabs_separator_position'];
		$is_enable_lightbox = ( 'yes' === $settings['enable_lightbox'] );
		$open_lightbox_on = $settings['open_lightbox_on'];

		$link_switch = ! empty( $settings['link_switch'] ) ? $settings['link_switch'] : 'image';
		$view_text = ! empty( $settings['view_button_text'] ) ? $settings['view_button_text'] : '';
		$lb_button_text = ! empty( $settings['lightbox_button_text'] ) ? $settings['lightbox_button_text'] : '';
		$display_category = ( 'yes' === $settings['category_display'] );

		$this->add_render_attribute( 'items_wrap', 'class', 'zyre-image-grid-items zyre-isotope' );

		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			$this->add_render_attribute( 'items_wrap', 'class', 'zyre-isotope-' . $this->get_id() );
		}

		$content_display = $settings['content_display'] ?? '';

		$content_class = 'zyre-image-grid-item-content zy-flex zy-flex-wrap zy-relative';
		if ( 'overlay' === $content_display ) {
			$content_class .= ' zy-absolute zy-w-100 zy-h-100 zy-top-0 zy-left-0 zy-content-end zy-p-3 zy-index-1';
		}

		if ( 'yes' === $show_filter_tabs ) {
			$filter_tabs = [];
			foreach ( $settings['all_items'] as $index => $item ) {
				if ( ! empty( $item['category'] ) ) {
					$formatted_category = $this->format_category( $item['category'] );
					$filter_tabs[$formatted_category] = [
						'item_cat' => $item['category'],
						'item_id'  => $item['_id'],
					];
				}
			}

			if ( ! empty( $filter_tabs ) ) :

				$category_slugs = array_keys( $filter_tabs );
				if ( ! empty( $settings['filter_tab_active'] ) ) {
					$active_tab = absint( $settings['filter_tab_active'] ) - 1;
					if ( isset( $category_slugs[ $active_tab ] ) ) {
						$this->_default_filter = '.' . $category_slugs[ $active_tab ];
					}
				}

				?>
				<div class="zyre-image-grid-filter-tabs zy-flex zy-align-center zy-gap-3">
					<?php if ( ( 'yes' === $settings['filter_tabs_separator'] ) && ( '' === $spr_position || 'left' === $spr_position ) ) : ?>
						<span class="zyre-image-grid-filter-separator zy-grow-1 zy-h-1 zy-bg-black"></span>
					<?php endif; ?>
					<ul class="zy-flex zy-flex-wrap zy-m-0 zy-list-none zy-gap-2 zyre-js-filter-tabs" data-default-filter="<?php echo $this->_default_filter; ?>">
						<?php if ( ! empty( $settings['filter_tabs_all'] ) ) : ?>
							<li>
								<a href="javascript:;" class="zyre-image-grid-filter-tab" data-filter="*"><?php echo esc_html( $settings['filter_tabs_all'] ); ?></a>
							</li>
						<?php endif; ?>
						<?php
						foreach ( $filter_tabs as $key => $tab ) {
							$this->add_render_attribute(
								$key,
								'class',
								[
									'zyre-image-grid-filter-tab',
									'elementor-repeater-item-' . $tab['item_id'],
								]
							);

							$slug = sprintf( '.%s', $key );
							$this->add_render_attribute( $key, 'data-filter', $slug );
							?>
							<li>
								<a href="javascript:;" <?php echo wp_kses_post( $this->get_render_attribute_string( $key ) ); ?>><?php echo esc_html( $tab['item_cat'] ); ?></a>
							</li>
							<?php
						}
						?>
					</ul>
					<?php if ( ( 'yes' === $settings['filter_tabs_separator'] ) && ( 'right' === $spr_position ) ) : ?>
						<span class="zyre-image-grid-filter-separator zy-grow-1 zy-h-1 zy-bg-black"></span>
					<?php endif; ?>
				</div>
				<?php
			endif;
		}
		?>
		
		<div class="zyre-image-grid-items-wrap">
			<div <?php $this->print_render_attribute_string( 'items_wrap' ); ?>>
				<?php
				$items_total = count( $settings['all_items'] );

				foreach ( $settings['all_items'] as $index => $item ) :
					
					$key = 'item_' . $index;
					$key_inner = 'item_inner_' . $index;

					$this->add_render_attribute(
						$key,
						[
							'class' => [
								'zyre-image-grid-item zy-overflow-hidden',
								'elementor-repeater-item-' . $item['_id'],
								$this->format_category( $item['category'] ),
							],
						]
					);

					$this->add_render_attribute(
						$key_inner,
						[
							'class' => [
								'zyre-image-grid-item-inner zy-relative',
								'elementor-repeater-item-' . $item['_id'],
								$this->format_category( $item['category'] ),
							],
						]
					);

					$image_wrapper_tag = 'div';
					$image = $item['image'] ?? [];
					$link_key = 'link_' . $index;
					$image_link_key = 'image_' . $link_key;
					$lb_button_key = 'button_' . $link_key;
					$content_link_key = 'content_' . $link_key;
	
					$this->add_link_attributes( $link_key, $item['link'] );

					$img_src = $image['url'] ? $image['url'] : Utils::get_placeholder_image_src();
					$img_html = sprintf( '<img src="%s" class="zyre-image-grid-item-img" alt="%s">',
						esc_url( $img_src ),
						esc_attr( $item['title'] )
					);

					if ( isset( $image['source'] ) && $image['id'] && isset( $settings['image_size'] ) ) :
						$img_src = wp_get_attachment_image_url( $image['id'], 'full' );
						$img_html = wp_get_attachment_image(
							$image['id'],
							$settings['image_size'],
							false,
							[ 'class' => 'zyre-image-grid-item-img' ],
						);
					endif;

					if ( ( 'image' === $link_switch || 'image_title' === $link_switch ) && ! empty( $item['link']['url'] ) && ! $is_enable_lightbox ) {
						$image_wrapper_tag = 'a';
						$this->add_render_attribute(
							$image_link_key,
							$this->get_render_attributes( $link_key )
						);
					}

					if ( $is_enable_lightbox && 'image_click' === $open_lightbox_on ) {
						$image_wrapper_tag = 'a';
						$this->add_render_attribute(
							$image_link_key,
							[
								'href'                              => esc_url( $img_src ),
								'data-elementor-open-lightbox'      => 'yes',
								'data-elementor-lightbox-slideshow' => $items_total > 1 ? $this->get_id() : false,
								'data-elementor-lightbox-title'     => esc_attr( $item['title'] ),
							]
						);
					}
					?>

					<div <?php echo wp_kses_post( $this->get_render_attribute_string( $key ) ); ?>>
						<div <?php echo wp_kses_post( $this->get_render_attribute_string( $key_inner ) ); ?>>
							<<?php Utils::print_validated_html_tag( $image_wrapper_tag ); ?> <?php echo wp_kses_post( $this->get_render_attribute_string( $image_link_key ) ); ?> class="zyre-image-grid-item-img-wrapper zy-relative">
								<?php

								echo $img_html;

								if ( $is_enable_lightbox ) {
									$lightbox_key = 'lightbox_' . $index;
									$this->add_render_attribute(
										$lightbox_key,
										[
											'href'                              => esc_url( $img_src ),
											'class'                             => 'zyre-image-grid-open-lightbox-btn zyre-js-lightbox',
											'data-elementor-open-lightbox'      => 'yes',
											'data-elementor-lightbox-slideshow' => $items_total > 1 ? $this->get_id() : false,
											'data-elementor-lightbox-title'     => esc_attr( $item['title'] ),
										]
									);

									if ( 'icon_click' === $open_lightbox_on ) :
										$icon_settings = [
											'library' => 'eicons',
											'value' => 'eicon-search-bold',
										];
										?>
										<a <?php echo wp_kses_post( $this->get_render_attribute_string( $lightbox_key ) ); ?>>
											<?php Icons_Manager::render_icon( $icon_settings, [ 'aria-hidden' => 'true' ] ); ?>
										</a>
										<?php
									endif;
								}
								?>
							</<?php Utils::print_validated_html_tag( $image_wrapper_tag ); ?>>

							<?php 
							$title       = $item['title']       ?? '';
							$category    = $item['category']    ?? '';
							$description = $item['description'] ?? '';

							$content_tag = 'div';
			
							if ( 'content' === $link_switch && ! empty( $item['link']['url'] ) ) {
								$content_tag = 'a';
								$this->add_render_attribute(
									$content_link_key,
									$this->get_render_attributes( $link_key )
								);
							}

							if ( $title || ( $display_category && $category ) || $description || ( $is_enable_lightbox && $open_lightbox_on ) || ( 'button' === $link_switch && ! empty( $item['link']['url'] ) ) ) : ?>
								<<?php Utils::print_validated_html_tag( $content_tag ); ?> <?php echo wp_kses_post( $this->get_render_attribute_string( $content_link_key ) ); ?> class="<?php echo esc_attr( $content_class ); ?>">
									<?php if ( $title ) : ?>
										<h3 class="zyre-image-grid-item-title zy-m-0 zy-w-100">
											<?php
											if ( ( 'title' === $link_switch || 'image_title' === $link_switch ) && ! empty( $item['link']['url'] ) ) {
												printf( '<a href="%s" %s>%s</a>',
													esc_url( $item['link']['url'] ),
													( $item['link']['is_external'] ?? '' ) ? 'target="_blank"' : '',
													esc_html( $item['title'] )
												);
											} else {
												echo esc_html( $item['title'] );
											}
											?>
										</h3>
									<?php endif; ?>

									<?php if ( $display_category && $category ) : ?>
										<p class="zyre-image-grid-item-category zy-m-0 zy-w-100"><?php echo esc_html( $item['category'] ); ?></p>
									<?php endif; ?>

									<?php if ( $description ) : ?>
										<p class="zyre-image-grid-item-description zy-m-0 zy-w-100"><?php echo esc_html( $item['description'] ); ?></p>
									<?php endif; ?>

									<?php if ( 'button_click' === $open_lightbox_on || ( 'button' === $link_switch && ! empty( $item['link']['url'] ) ) ) : ?>
										<div class="zyre-image-grid-buttons zy-inline-flex zy-gap-2">
											<?php if ( 'button_click' === $open_lightbox_on ) :
												$this->add_render_attribute(
													$lb_button_key,
													[
														'href'                              => esc_url( $img_src ),
														'data-elementor-open-lightbox'      => 'yes',
														'data-elementor-lightbox-slideshow' => $items_total > 1 ? $this->get_id() : false,
														'data-elementor-lightbox-title'     => esc_attr( $item['title'] ),
													]
												);
												?>
												<a class="zyre-image-grid-zoom-button zy-transition" <?php echo wp_kses_post( $this->get_render_attribute_string( $lb_button_key ) ); ?>><?php echo esc_html( $lb_button_text ); ?></a>
											<?php endif;
											
											if ( 'button' === $link_switch && ! empty( $item['link']['url'] ) ) : ?>
												<a class="zyre-image-grid-view-button zy-transition" <?php echo wp_kses_post( $this->get_render_attribute_string( $link_key ) ); ?>><?php echo esc_html( $view_text ); ?></a>
											<?php endif; ?>
										</div>
									<?php endif; ?>
								</<?php Utils::print_validated_html_tag( $content_tag ); ?>>
							<?php endif; ?>
						</div>
					</div>
					<?php
				endforeach;
				?>
			</div>
		</div>
		
		<?php
		/**
		 * Zyre Isotope adjustment.
		 *
		 * This code may look unnecessary,
		 * but it resolves a critical issue.
		 */
		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
			printf( '<script>jQuery(".zyre-isotope-%s").isotope();</script>', $this->get_id() );
		endif;
	}
}
