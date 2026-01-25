<?php
namespace ZyreAddons\Elementor\Traits;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

trait List_Item_Advanced_Trait {

	/**
	 * Register content controls.
	 *
	 * @param array $args {
	 *     Optional. An array of arguments for adjusting the controls.
	 *
	 *     @type string $id_prefix     Prefix for the control IDs.
	 *     @type bool   $prevent_empty Whether to prevent empty items. Default true.
	 * }
	 */
	protected function register_list_item_advanced_content_controls( $args = [] ) {
		$default_args = [
			'id_prefix' => '',
			'prevent_empty' => true,
		];

		$args = wp_parse_args( $args, $default_args );
		$prefix = ! empty( $args['id_prefix'] ) ? $args['id_prefix'] . '_' : '';
		$class_base = ! empty( $args['id_prefix'] ) ? $args['id_prefix'] . '-' : '';

		$options = [];
		$default_type = '';
		$default_icon = [];

		if ( ! empty( $args['id_prefix'] ) && 'image' === $args['id_prefix'] ) {
			$options = [
				'image' => esc_html__( 'Image', 'zyre-elementor-addons' ),
				'icon'   => esc_html__( 'Icon', 'zyre-elementor-addons' ),
			];
			$default_type = 'image';
			$default_icon = [
				'value'   => 'fas fa-check',
				'library' => 'fa-solid',
			];
		}

		if ( ! empty( $args['id_prefix'] ) && 'numeric' === $args['id_prefix'] ) {
			$options = [
				'number' => esc_html__( 'Number', 'zyre-elementor-addons' ),
				'icon'   => esc_html__( 'Icon', 'zyre-elementor-addons' ),
			];
			$default_type = 'number';
			$default_icon = [
				'value'   => 'fas fa-check',
				'library' => 'fa-solid',
			];
		}

		if ( ! empty( $args['id_prefix'] ) && 'feature' === $args['id_prefix'] ) {
			$options = [
				'icon'   => esc_html__( 'Icon', 'zyre-elementor-addons' ),
				'image' => esc_html__( 'Image', 'zyre-elementor-addons' ),
			];
			$default_type = 'icon';
			$default_icon = [
				'value'   => 'fas fa-pizza-slice',
				'library' => 'fa-solid',
			];
		}

		if ( ! empty( $args['id_prefix'] ) && 'group' === $args['id_prefix'] ) {
			$options = [
				'number' => esc_html__( 'Number', 'zyre-elementor-addons' ),
				'icon'   => esc_html__( 'Icon', 'zyre-elementor-addons' ),
				'image'  => esc_html__( 'Image', 'zyre-elementor-addons' ),
			];
			$default_type = 'icon';
			$default_icon = [
				'value'   => 'fas fa-star',
				'library' => 'fa-solid',
			];
		}

		$repeater = new Repeater();

		$repeater->add_control(
			'item_type',
			[
				'label'       => esc_html__( 'Type', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::SELECT,
				'render_type' => 'template',
				'options'     => $options,
				'default'     => $default_type,
			]
		);

		$repeater->add_control(
			'item_image',
			[
				'label'     => esc_html__( 'Image', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [ 'item_type' => 'image' ],
			]
		);

		if ( ! empty( $args['id_prefix'] ) && ( 'image' === $args['id_prefix'] || 'feature' === $args['id_prefix'] ) ) {
			$repeater->add_control(
				'media_caption',
				[
					'label'     => esc_html__( 'Caption', 'zyre-elementor-addons' ),
					'type'      => Controls_Manager::TEXT,
					'condition' => [ 'item_type' => 'image' ],
				]
			);
		}

		$repeater->add_control(
			'item_number',
			[
				'label'     => esc_html__( 'Number', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '1',
				'condition' => [ 'item_type' => 'number' ],
			]
		);

		$repeater->add_control(
			'selected_icon',
			[
				'label'     => esc_html__( 'Icon', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => $default_icon,
				'condition' => [ 'item_type' => 'icon' ],
			]
		);

		$repeater->add_control(
			'item_title',
			[
				'label'   => esc_html__( 'Title', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Item Title', 'zyre-elementor-addons' ),
			]
		);

		$repeater->add_control(
			'title_html_tag',
			[
				'label'     => esc_html__( 'Title HTML Tag', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'h3',
				'options'   => [
					'span' => 'span',
					'div'  => 'div',
					'h2'   => 'h2',
					'h3'   => 'h3',
					'h4'   => 'h4',
					'h5'   => 'h5',
					'h6'   => 'h6',
					'p'    => 'p',
				],
				'condition' => [
					'item_title!' => '',
				],
			]
		);

		$repeater->add_control(
			'item_description',
			[
				'label'   => esc_html__( 'Description', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows' => 3,
				'default' => esc_html__( 'Item description goes here', 'zyre-elementor-addons' ),
			]
		);

		$repeater->add_control(
			'item_link',
			[
				'label' => esc_html__( 'Link', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'default' => 'group' === $args['id_prefix'] ? [ 'url' => '#' ] : [],
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$default_items = [];
		$list_label = esc_html__( 'List Items', 'zyre-elementor-addons' );

		if ( ! empty( $args['id_prefix'] ) && 'image' === $args['id_prefix'] ) {
			$default_items = [
				[
					'item_image'       => Utils::get_placeholder_image_src(),
					'item_title'       => esc_html__( 'Item Title #1', 'zyre-elementor-addons' ),
				],
				[
					'item_image'       => Utils::get_placeholder_image_src(),
					'item_title'       => esc_html__( 'Item Title #2', 'zyre-elementor-addons' ),
				],
				[
					'item_image'       => Utils::get_placeholder_image_src(),
					'item_title'       => esc_html__( 'Item Title #3', 'zyre-elementor-addons' ),
				],
				[
					'item_image'       => Utils::get_placeholder_image_src(),
					'item_title'       => esc_html__( 'Item Title #4', 'zyre-elementor-addons' ),
				],
			];

			$list_label = esc_html__( 'Image List', 'zyre-elementor-addons' );
			$title_field = '{{{ item_type === "icon" ? elementor.helpers.renderIcon( this, selected_icon, {}, "i", "panel" ) || \'<i class="{{ icon }}" aria-hidden="true"></i>\' : "" }}} {{{ item_title }}}';
		}

		if ( ! empty( $args['id_prefix'] ) && 'numeric' === $args['id_prefix'] ) {
			$default_items = [
				[
					'item_number'      => '1',
					'item_title'       => esc_html__( 'Item Title #1', 'zyre-elementor-addons' ),
				],
				[
					'item_number'      => '2',
					'item_title'       => esc_html__( 'Item Title #2', 'zyre-elementor-addons' ),
				],
				[
					'item_number'      => '3',
					'item_title'       => esc_html__( 'Item Title #3', 'zyre-elementor-addons' ),
				],
				[
					'item_number'      => '4',
					'item_title'       => esc_html__( 'Item Title #4', 'zyre-elementor-addons' ),
				],
			];

			$list_label = esc_html__( 'Numeric List', 'zyre-elementor-addons' );
			$title_field = '{{{ item_type === "icon" ? elementor.helpers.renderIcon( this, selected_icon, {}, "i", "panel" ) || \'<i class="{{ icon }}" aria-hidden="true"></i>\' : item_number + " -" }}} {{{ item_title }}}';
		}

		if ( ! empty( $args['id_prefix'] ) && 'feature' === $args['id_prefix'] ) {
			$default_items = [
				[
					'item_title'       => esc_html__( 'Item Title #1', 'zyre-elementor-addons' ),
				],
				[
					'item_title'       => esc_html__( 'Item Title #2', 'zyre-elementor-addons' ),
				],
				[
					'item_title'       => esc_html__( 'Item Title #3', 'zyre-elementor-addons' ),
				],
				[
					'item_title'       => esc_html__( 'Item Title #4', 'zyre-elementor-addons' ),
				],
			];

			$list_label = esc_html__( 'Feature List', 'zyre-elementor-addons' );
			$title_field = '{{{ item_type === "icon" ? elementor.helpers.renderIcon( this, selected_icon, {}, "i", "panel" ) || \'<i class="{{ icon }}" aria-hidden="true"></i>\' : "" }}} {{{ item_title }}}';
		}

		if ( ! empty( $args['id_prefix'] ) && 'group' === $args['id_prefix'] ) {
			$default_items = [
				[
					'item_title'       => esc_html__( 'Item Title #1', 'zyre-elementor-addons' ),
					'selected_icon' => [
						'value' => 'fas fa-chalkboard',
						'library' => 'fa-solid',
					],
				],
				[
					'item_title'       => esc_html__( 'Item Title #2', 'zyre-elementor-addons' ),
					'selected_icon' => [
						'value' => 'fas fa-cloud',
						'library' => 'fa-solid',
					],
				],
				[
					'item_title'       => esc_html__( 'Item Title #3', 'zyre-elementor-addons' ),
					'selected_icon' => [
						'value' => 'fas fa-palette',
						'library' => 'fa-solid',
					],
				],
				[
					'item_title'       => esc_html__( 'Item Title #4', 'zyre-elementor-addons' ),
					'selected_icon' => [
						'value' => 'fas fa-shopping-cart',
						'library' => 'fa-solid',
					],
				],
			];

			$list_label = esc_html__( 'Group List', 'zyre-elementor-addons' );
			$title_field = '{{{ item_type === "icon" ? elementor.helpers.renderIcon( this, selected_icon, {}, "i", "panel" ) || \'<i class="{{ icon }}" aria-hidden="true"></i>\' : "" }}} {{{ item_title }}}';
		}

		$this->add_control(
			$prefix . 'list',
			[
				'label'       => $list_label,
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => $default_items,
				'title_field' => $title_field,
			]
		);

		if ( ! empty( $args['id_prefix'] ) && 'image' === $args['id_prefix'] ) {
			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'      => 'thumbnail',
					'default'   => 'medium',
					'separator' => 'before',
					'exclude'   => [
						'custom',
					],
				]
			);
		}

		if ( ! empty( $args['id_prefix'] ) && ( 'image' === $args['id_prefix'] || 'feature' === $args['id_prefix'] ) ) {
			$this->add_control(
				$prefix . 'caption_display',
				[
					'label'        => esc_html__( 'Caption Display', 'zyre-elementor-addons' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => 'overlay',
					'options'      => [
						'normal'  => esc_html__( 'Normal', 'zyre-elementor-addons' ),
						'overlay' => esc_html__( 'Overlay', 'zyre-elementor-addons' ),
					],
					'prefix_class' => "zyre-{$class_base}list-caption-display--",
					'render_type' => 'template',
				]
			);
		}

		if ( ! empty( $args['id_prefix'] ) && 'group' === $args['id_prefix'] ) {
			$this->add_control(
				$prefix . 'items_icon',
				[
					'label'   => esc_html__( 'Items Icon', 'zyre-elementor-addons' ),
					'type'    => Controls_Manager::ICONS,
					'default' => [
						'value'   => is_rtl() ? 'zy-fonticon-b zy-Arrow-left' : 'zy-fonticon-b zy-Arrow-right',
						'library' => 'zyre-icons-bold',
					],
				]
			);
		}

		$this->add_responsive_control(
			'items_columns',
			[
				'label'           => esc_html__( 'Columns', 'zyre-elementor-addons' ),
				'type'            => Controls_Manager::SELECT,
				'options'         => [
					1 => esc_html__( '1 Column', 'zyre-elementor-addons' ),
					2 => esc_html__( '2 Columns', 'zyre-elementor-addons' ),
					3 => esc_html__( '3 Columns', 'zyre-elementor-addons' ),
					4 => esc_html__( '4 Columns', 'zyre-elementor-addons' ),
					5 => esc_html__( '5 Columns', 'zyre-elementor-addons' ),
					6 => esc_html__( '6 Columns', 'zyre-elementor-addons' ),
				],
				'desktop_default' => 4,
				'tablet_default'  => 2,
				'mobile_default'  => 1,
				'prefix_class'    => "zyre-{$class_base}list--col-%s",
				'style_transfer'  => true,
				'selectors'       => [
					"{{WRAPPER}} .zyre-{$class_base}list-items" => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
				],
			]
		);

		$this->add_responsive_control(
			'content_alignment',
			[
				'label'        => esc_html__( 'Alignment', 'zyre-elementor-addons' ),
				'description'  => esc_html__( 'Works when List Item > Width is set in the Style tab.', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'flex-start'    => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-center',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'      => 'center',
				'selectors'    => [
					"{{WRAPPER}} .zyre-{$class_base}list-items" => 'justify-items: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			$prefix . 'list_css_class',
			[
				'label'       => esc_html__( 'Class', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Class Name', 'zyre-elementor-addons' ),
				'prefix_class' => '',
			]
		);
	}

	/**
	 * Register general style controls.
	 *
	 * @param array $args {
	 *     Optional. An array of arguments for adjusting the controls.
	 *
	 *     @type string $id_prefix     Prefix for the control IDs.
	 * }
	 */
	protected function register_general_style_controls( $args = [] ) {
		$default_args = [
			'id_prefix' => '',
		];

		$args = wp_parse_args( $args, $default_args );
		$class_base = ! empty( $args['id_prefix'] ) ? $args['id_prefix'] . '-' : '';

		$this->add_responsive_control(
			'items_space_between',
			[
				'label' => esc_html__( 'Horizontal Space', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					"{{WRAPPER}} .zyre-{$class_base}list-items" => 'column-gap: {{SIZE}}{{UNIT}}',
					"{{WRAPPER}} .zyre-{$class_base}list-item" => '--right: calc(-{{SIZE}}{{UNIT}} / 2)',
				],
			]
		);

		$this->add_responsive_control(
			'items_space_between_y',
			[
				'label' => esc_html__( 'Vertical Space', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					"{{WRAPPER}} .zyre-{$class_base}list-items" => 'row-gap: {{SIZE}}{{UNIT}}',
					"{{WRAPPER}} .zyre-{$class_base}list-item" => '--bottom: calc(-{{SIZE}}{{UNIT}} / 2)',
				],
			]
		);

		// Divider controls
		$this->add_control(
			'divider_style_section',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Divider Style', 'zyre-elementor-addons' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'divider',
			[
				'label' => esc_html__( 'Divider', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Off', 'zyre-elementor-addons' ),
				'label_on' => esc_html__( 'On', 'zyre-elementor-addons' ),
				'separator' => 'before',
				'prefix_class' => "zyre-{$class_base}list-divider--",
				'style_transfer' => true,
			]
		);

		if ( ! empty( $args['id_prefix'] ) && 'image' === $args['id_prefix'] ) {
			$this->add_control(
				'divider_apply_to',
				[
					'label'        => esc_html__( 'Apply To', 'zyre-elementor-addons' ),
					'type'         => Controls_Manager::SELECT,
					'options'      => [
						'item'    => esc_html__( 'Item', 'zyre-elementor-addons' ),
						'content' => esc_html__( 'Content', 'zyre-elementor-addons' ),
					],
					'default'      => 'item',
					'prefix_class' => "zyre-{$class_base}list-divider-to--",
					'condition' => [
						'divider'     => 'yes',
						'item_layout' => 'bottom',
					],
				]
			);
		}

		$this->add_control(
			'divider_style',
			[
				'label' => esc_html__( 'Style', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'solid' => esc_html__( 'Solid', 'zyre-elementor-addons' ),
					'double' => esc_html__( 'Double', 'zyre-elementor-addons' ),
					'dotted' => esc_html__( 'Dotted', 'zyre-elementor-addons' ),
					'dashed' => esc_html__( 'Dashed', 'zyre-elementor-addons' ),
				],
				'default' => 'solid',
				'condition' => [
					'divider' => 'yes',
				],
				'selectors' => [
					"{{WRAPPER}}:not(.zyre-image-list-divider-to--content) .zyre-{$class_base}list-items .zyre-{$class_base}list-item:not(:last-child)::after" => '--divider-style: {{VALUE}}',
					"{{WRAPPER}}.zyre-image-list-divider-to--content .zyre-{$class_base}list-items .zyre-{$class_base}list-item:not(:last-child) .zyre-image-list-item-content::after" => '--divider-style: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'divider_weight',
			[
				'label' => esc_html__( 'Weight', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'condition' => [
					'divider' => 'yes',
				],
				'selectors' => [
					"{{WRAPPER}}:not(.zyre-image-list-divider-to--content) .zyre-{$class_base}list-items .zyre-{$class_base}list-item:not(:last-child)::after" => '--divider-weight: {{SIZE}}{{UNIT}}',
					"{{WRAPPER}}.zyre-image-list-divider-to--content .zyre-{$class_base}list-items .zyre-{$class_base}list-item:not(:last-child) .zyre-image-list-item-content::after" => '--divider-weight: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'divider_width',
			[
				'label' => esc_html__( 'Width', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'default' => [
					'unit' => '%',
				],
				'condition' => [
					'divider' => 'yes',
					'view!' => 'inline',
				],
				'selectors' => [
					"{{WRAPPER}}:not(.zyre-image-list-divider-to--content) .zyre-{$class_base}list-item:not(:last-child)::after" => 'width: {{SIZE}}{{UNIT}}',
					"{{WRAPPER}}.zyre-image-list-divider-to--content .zyre-{$class_base}list-item:not(:last-child) .zyre-image-list-item-content::after" => 'width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'divider_height',
			[
				'label' => esc_html__( 'Height', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'custom' ],
				'default' => [
					'unit' => '%',
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'condition' => [
					'divider' => 'yes',
					'view' => 'inline',
				],
				'selectors' => [
					"{{WRAPPER}}:not(.zyre-image-list-divider-to--content) .zyre-{$class_base}list-item:not(:last-child)::after" => 'height: {{SIZE}}{{UNIT}}',
					"{{WRAPPER}}.zyre-image-list-divider-to--content .zyre-{$class_base}list-item:not(:last-child) .zyre-image-list-item-content::after" => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'divider_color',
			[
				'label' => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#e6ebf2',
				'condition' => [
					'divider' => 'yes',
				],
				'selectors' => [
					"{{WRAPPER}}:not(.zyre-image-list-divider-to--content) .zyre-{$class_base}list-item:not(:last-child)::after" => 'border-color: {{VALUE}}',
					"{{WRAPPER}}.zyre-image-list-divider-to--content .zyre-{$class_base}list-item:not(:last-child) .zyre-image-list-item-content::after" => 'border-color: {{VALUE}}',
				],
			]
		);
	}

	/**
	 * Register item style controls.
	 *
	 * @param array $args {
	 *     Optional. An array of arguments for adjusting the controls.
	 *
	 *     @type string $id_prefix     Prefix for the control IDs.
	 * }
	 */
	protected function register_item_style_controls( $args = [] ) {
		$default_args = [
			'id_prefix' => '',
		];

		$args = wp_parse_args( $args, $default_args );
		$class_base = ! empty( $args['id_prefix'] ) ? $args['id_prefix'] . '-' : '';

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_typography',
				'fields_options' => [
					'typography'  => [ 'default' => 'custom' ],
					'font_family' => [ 'default' => 'Inter' ],
				],
				'selector' => "{{WRAPPER}} .zyre-{$class_base}list-item",
			]
		);

		// Tabs
		$this->start_controls_tabs( 'item_tabs' );

		// Normal Tab
		$this->start_controls_tab(
			'item_style_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'           => 'item_background',
				'label'          => esc_html__( 'Background', 'zyre-elementor-addons' ),
				'types'          => [ 'classic', 'gradient' ],
				'exclude'        => [ 'image' ],
				'selector'       => "{{WRAPPER}} .zyre-{$class_base}list-item",
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'item_border',
				'selector'  => "{{WRAPPER}} .zyre-{$class_base}list-item",
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'item_box_shadow',
				'selector' => "{{WRAPPER}} .zyre-{$class_base}list-item",
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'item_style_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'           => 'item_background_hover',
				'label'          => esc_html__( 'Background', 'zyre-elementor-addons' ),
				'types'          => [ 'classic', 'gradient' ],
				'exclude'        => [ 'image' ],
				'selector'       => "{{WRAPPER}} .zyre-{$class_base}list-item:hover",
			]
		);

		$this->add_control(
			'title_color_hover',
			[
				'label'     => esc_html__( 'Title Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					"{{WRAPPER}} .zyre-{$class_base}list-item:hover .zyre-{$class_base}list-item-title" => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'description_color_hover',
			[
				'label'     => esc_html__( 'Description Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					"{{WRAPPER}} .zyre-{$class_base}list-item:hover .zyre-{$class_base}list-item-text"    => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'item_border_hover',
				'selector'  => "{{WRAPPER}} .zyre-{$class_base}list-item:hover",
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'item_box_shadow_hover',
				'selector' => "{{WRAPPER}} .zyre-{$class_base}list-item:hover",
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'item_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'separator'  => 'before',
				'selectors'  => [
					"{{WRAPPER}} .zyre-{$class_base}list-item" => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'item_layout',
			[
				'label'   => esc_html__( 'Layout', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'right' => [
						'title' => esc_html__( 'Content Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
					'left'  => [
						'title' => esc_html__( 'Content Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'bottom'   => [
						'title' => esc_html__( 'Content Bottom', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'default'              => 'group' === $args['id_prefix'] ? 'right' : 'bottom',
				'render_type'          => 'template',
				'selectors_dictionary' => [
					'right'  => 'flex-direction: row;justify-content: flex-start;',
					'left' => 'flex-direction: row-reverse;justify-content: flex-end;',
					'bottom'   => 'flex-direction: column;align-items: flex-start;',
				],
				'selectors'            => [
					"{{WRAPPER}} .zyre-{$class_base}list-item, {{WRAPPER}} .zyre-{$class_base}list-item-link" => '{{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_padding',
			[
				'label'      => esc_html__( 'Padding', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					"{{WRAPPER}} .zyre-{$class_base}list-items .zyre-{$class_base}list-item" => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'item_alignment',
			[
				'label'        => esc_html__( 'Alignment', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::CHOOSE,
				'default'      => 'flex-start',
				'options'      => [
					'flex-start'    => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-center',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'selectors'    => [
					"{{WRAPPER}} .zyre-{$class_base}list-items .zyre-{$class_base}list-item:not(.zyre-{$class_base}list-item--content-right)" => 'align-items: {{VALUE}};',
					"{{WRAPPER}} .zyre-{$class_base}list-items .zyre-{$class_base}list-item.zyre-{$class_base}list-item--content-right" => 'justify-content: {{VALUE}};',
				],
				'condition' => [
					'item_layout'  => [ 'right' ],
				],
			]
		);

		$this->add_responsive_control(
			'item_alignment_r',
			[
				'label'        => esc_html__( 'Alignment', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::CHOOSE,
				'default'      => 'flex-end',
				'options'      => [
					'flex-end'    => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-center',
					],
					'flex-start'   => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'selectors'    => [
					"{{WRAPPER}} .zyre-{$class_base}list-items .zyre-{$class_base}list-item" => 'justify-content: {{VALUE}};',
				],
				'condition' => [
					'item_layout'  => [ 'left' ],
				],
			]
		);

		$this->add_responsive_control(
			'item_alignment_b',
			[
				'label'        => esc_html__( 'Alignment', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::CHOOSE,
				'default'      => 'center',
				'options'      => [
					'flex-start'    => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-center',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'selectors'    => [
					"{{WRAPPER}} .zyre-{$class_base}list-items .zyre-{$class_base}list-item.zyre-{$class_base}list-item--content-bottom,
					{{WRAPPER}} .zyre-{$class_base}list-items .zyre-{$class_base}list-item.zyre-{$class_base}list-item--content-bottom .zyre-{$class_base}list-item-link" => 'align-items: {{VALUE}};',
				],
				'condition' => [
					'item_layout'  => [ 'bottom' ],
				],
			]
		);

		$this->add_responsive_control(
			'item_width',
			[
				'label'      => esc_html__( 'Width', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', 'vw' ],
				'default' => [
					'unit' => '%',
				],
				'range'      => [
					'%'  => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 50,
						'max' => 1000,
					],
				],
				'selectors'  => [
					"{{WRAPPER}} .zyre-{$class_base}list-item"  => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_height',
			[
				'label'      => esc_html__( 'Height', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', 'vw' ],
				'default' => [
					'unit' => 'px',
				],
				'range'      => [
					'%'  => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 50,
						'max' => 1000,
					],
				],
				'selectors'  => [
					"{{WRAPPER}} .zyre-{$class_base}list-item"  => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
	}

	/**
	 * Register content style controls.
	 *
	 * @param array $args {
	 *     Optional. An array of arguments for adjusting the controls.
	 *
	 *     @type string $id_prefix     Prefix for the control IDs.
	 * }
	 */
	protected function register_content_style_controls( $args = [] ) {
		$default_args = [
			'id_prefix' => '',
		];

		$args = wp_parse_args( $args, $default_args );
		$class_base = ! empty( $args['id_prefix'] ) ? $args['id_prefix'] . '-' : '';

		$this->add_responsive_control(
			'item_content_margin',
			[
				'label'      => esc_html__( 'Margin', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					"{{WRAPPER}} .zyre-{$class_base}list-item-content" => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'item_content_padding',
			[
				'label'      => esc_html__( 'Padding', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					"{{WRAPPER}} .zyre-{$class_base}list-item-content" => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_content_alignment',
			[
				'label'        => esc_html__( 'Alignment', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'left'    => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'   => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-right',
					],
					'justify'   => [
						'title' => esc_html__( 'Justify', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'selectors'    => [
					"{{WRAPPER}} .zyre-{$class_base}list-items .zyre-{$class_base}list-item-content" => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_content_align_y',
			[
				'label'        => esc_html__( 'Vertical Alignment', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'flex-start'    => [
						'title' => esc_html__( 'Top', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-align-start-v',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-align-center-v',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Bottom', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-align-end-v',
					],
				],
				'selectors'    => [
					"{{WRAPPER}} .zyre-{$class_base}list-item:not(.zyre-{$class_base}list-item--content-bottom) .zyre-{$class_base}list-item-content" => 'align-content: {{VALUE}};',
				],
			]
		);

		// Tabs
		$this->start_controls_tabs( 'item_content_tabs' );

		// Normal Tab
		$this->start_controls_tab(
			'item_content_tab_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'           => 'item_content_bg',
				'label'          => esc_html__( 'Background', 'zyre-elementor-addons' ),
				'types'          => [ 'classic', 'gradient' ],
				'exclude'        => [ 'image' ],
				'selector'       => "{{WRAPPER}} .zyre-{$class_base}list-item-content",
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'item_content_border',
				'selector'  => "{{WRAPPER}} .zyre-{$class_base}list-item-content",
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'item_content_box_shadow',
				'selector' => "{{WRAPPER}} .zyre-{$class_base}list-item-content",
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'item_content_tab_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'item_content_hover_style_switch',
			[
				'label'        => esc_html__( 'When hover over the Item.', 'zyre-elementor-addons' ),
				'description'  => esc_html__( 'Activate the styles when hover over the item.', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'ON', 'zyre-elementor-addons' ),
				'label_off'    => esc_html__( 'OFF', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'render_type'  => 'template', // Ensures live preview updates
				'prefix_class' => "zyre-{$class_base}list-item-content-hover--",
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'           => 'item_content_bg_hover',
				'label'          => esc_html__( 'Background', 'zyre-elementor-addons' ),
				'types'          => [ 'classic', 'gradient' ],
				'exclude'        => [ 'image' ],
				'selector'       => "{{WRAPPER}}:not(.zyre-{$class_base}list-item-content-hover--yes) .zyre-{$class_base}list-item-content:hover,
				{{WRAPPER}}.zyre-{$class_base}list-item-content-hover--yes .zyre-{$class_base}list-item:hover .zyre-{$class_base}list-item-content",
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'item_content_border_hover',
				'selector'  => "{{WRAPPER}}:not(.zyre-{$class_base}list-item-content-hover--yes) .zyre-{$class_base}list-item-content:hover,
				{{WRAPPER}}.zyre-{$class_base}list-item-content-hover--yes .zyre-{$class_base}list-item:hover .zyre-{$class_base}list-item-content",
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'item_content_box_shadow_hover',
				'selector' => "{{WRAPPER}}:not(.zyre-{$class_base}list-item-content-hover--yes) .zyre-{$class_base}list-item-content:hover,
				{{WRAPPER}}.zyre-{$class_base}list-item-content-hover--yes .zyre-{$class_base}list-item:hover .zyre-{$class_base}list-item-content",
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'item_content_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'separator'  => 'before',
				'selectors'  => [
					"{{WRAPPER}} .zyre-{$class_base}list-item-content" => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_content_zindex',
			[
				'label'     => esc_html__( 'Z-Index', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => -5,
				'max'       => 5,
				'step'      => 1,
				'selectors' => [
					"{{WRAPPER}} .zyre-{$class_base}list-item-content" => 'z-index: {{VALUE}};',
				],
			]
		);
	}

	/**
	 * Register text style controls.
	 *
	 * @param array $args {
	 *     Optional. An array of arguments for adjusting the controls.
	 *
	 *     @type string $id_prefix     Prefix for the control IDs.
	 *     @type string $widget_base   Base ID of the widget.
	 * }
	 */
	protected function register_text_style_controls( $args = [] ) {
		$default_args = [
			'id_prefix' => '',
			'widget_base' => '',
		];

		$args = wp_parse_args( $args, $default_args );
		$prefix = ! empty( $args['id_prefix'] ) ? $args['id_prefix'] . '_' : '';
		$class_base = ! empty( $args['id_prefix'] ) ? str_replace( '_', '-', $args['id_prefix'] ) : '';
		$widget_base_class = ! empty( $args['widget_base'] ) ? $args['widget_base'] . '-' : '';
		$font_size = 'item_text' === $args['id_prefix'] ? 14 : 18;
		$color = 'item_text' === $args['id_prefix'] ? '#8C919B' : '#000000';

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => $prefix . 'typography',
				'fields_options' => [
					'typography' => [
						'default' => 'yes',
					],
					'font_size'  => [
						'default' => [
							'unit' => 'px',
							'size' => $font_size,
						],
					],
				],
				'selector'       => "{{WRAPPER}} .zyre-{$widget_base_class}list-item .zyre-{$widget_base_class}list-{$class_base}",
			]
		);

		$this->add_control(
			$prefix . 'color',
			[
				'label'     => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => $color,
				'selectors' => [
					"{{WRAPPER}} .zyre-{$widget_base_class}list-item .zyre-{$widget_base_class}list-{$class_base}"     => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			$prefix . 'margin',
			[
				'label'     => esc_html__( 'Margin', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					"{{WRAPPER}} .zyre-{$widget_base_class}list-item .zyre-{$widget_base_class}list-{$class_base}"     => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
	}

	/**
	 * Register content style controls.
	 *
	 * @param array $args {
	 *     Optional. An array of arguments for adjusting the controls.
	 *
	 *     @type string $id_prefix     Prefix for the control IDs.
	 * }
	 */
	protected function register_item_type_element_style_controls( $args = [] ) {
		$default_args = [
			'id_prefix' => '',
		];

		$args = wp_parse_args( $args, $default_args );
		$class_base = ! empty( $args['id_prefix'] ) ? $args['id_prefix'] . '-' : '';

		if ( ! empty( $args['id_prefix'] ) && 'numeric' === $args['id_prefix'] ) {
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'list_number_typography',
					'label'    => esc_html__( 'Number Typography', 'zyre-elementor-addons' ),
					'fields_options' => [
						'typography'  => [ 'default' => 'yes' ],
						'font_size'  => [
							'default' => [
								'unit' => 'px',
								'size' => 21,
							],
						],
					],
					'selector' => "{{WRAPPER}} .zyre-{$class_base}list-item .zyre-{$class_base}list-item-num",
				]
			);
		}

		$this->add_responsive_control(
			'item_type_icon_size',
			[
				'label'     => esc_html__( 'Icon Size', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors' => [
					"{{WRAPPER}} .zyre-{$class_base}list-item-type-wrapper"   => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_type_wrapper_width',
			[
				'label'      => esc_html__( 'Width', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 1000,
					],
					'%'  => [
						'min' => 1,
						'max' => 100,
					],
					'vw'  => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors'  => [
					"{{WRAPPER}} .zyre-{$class_base}list-item-type-wrapper:not(.zyre-image-list-item-image),
					{{WRAPPER}} .zyre-{$class_base}list-item-type-wrapper.zyre-image-list-item-image img"  => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_type_wrapper_height',
			[
				'label'      => esc_html__( 'Height', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 1000,
					],
					'%'  => [
						'min' => 1,
						'max' => 100,
					],
					'vw'  => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors'  => [
					"{{WRAPPER}} .zyre-{$class_base}list-item-type-wrapper:not(.zyre-image-list-item-image),
					{{WRAPPER}} .zyre-{$class_base}list-item-type-wrapper.zyre-image-list-item-image img"  => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Start Tabs
		$this->start_controls_tabs( 'item_type_tabs' );

		// Start Normal Tab
		$this->start_controls_tab(
			'item_type_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'           => 'item_type_background',
				'label'          => esc_html__( 'Background', 'zyre-elementor-addons' ),
				'types'          => [ 'classic', 'gradient' ],
				'exclude'        => [ 'image' ],
				'selector'       => "{{WRAPPER}} .zyre-{$class_base}list-item-type-wrapper:not(.zyre-image-list-item-image),
									{{WRAPPER}} .zyre-{$class_base}list-item-type-wrapper.zyre-image-list-item-image img",
			]
		);

		if ( ! empty( $args['id_prefix'] ) && 'numeric' === $args['id_prefix'] ) {
			$this->add_control(
				'item_type_color',
				[
					'label'     => esc_html__( 'Number Color', 'zyre-elementor-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#197DFF',
					'selectors' => [
						"{{WRAPPER}} .zyre-{$class_base}list-item-num" => 'color: {{VALUE}};',
					],
				]
			);
		}

		$this->add_control(
			'item_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#197DFF',
				'selectors' => [
					"{{WRAPPER}} .zyre-{$class_base}list-item-type-wrapper i" => 'color: {{VALUE}};',
					"{{WRAPPER}} .zyre-{$class_base}list-item-type-wrapper svg" => 'fill: {{VALUE}};',
				],
			]
		);

		if ( ! empty( $args['id_prefix'] ) && 'image' === $args['id_prefix'] ) {
			$this->add_group_control(
				Group_Control_Css_Filter::get_type(),
				[
					'name' => 'item_type_image_filters',
					'selector' => "{{WRAPPER}} .zyre-{$class_base}list-item-image img",
				]
			);

			$this->add_control(
				'item_type_image_opacity',
				[
					'label' => esc_html__( 'Opacity', 'zyre-elementor-addons' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 1,
							'min' => 0.10,
							'step' => 0.01,
						],
					],
					'selectors' => [
						"{{WRAPPER}} .zyre-{$class_base}list-item-image img" => 'opacity: {{SIZE}};',
					],
				]
			);

			$this->add_control(
				'item_type_image_scale',
				[
					'label' => esc_html__( 'Scale', 'zyre-elementor-addons' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 1,
							'min' => 0,
							'step' => 0.01,
						],
					],
					'selectors' => [
						"{{WRAPPER}} .zyre-{$class_base}list-item-image img" => 'transform: scale({{SIZE}});',
					],
				]
			);
		}

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'item_type_border',
				'selector'  => "{{WRAPPER}} .zyre-{$class_base}list-item-type-wrapper:not(.zyre-image-list-item-image),
								{{WRAPPER}} .zyre-{$class_base}list-item-type-wrapper.zyre-image-list-item-image img",
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'item_type_box_shadow',
				'selector' => "{{WRAPPER}} .zyre-{$class_base}list-item-type-wrapper",
			]
		);

		$this->end_controls_tab();

		// Start Hover Tab
		$this->start_controls_tab(
			'item_type_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'item_hover_style_switch',
			[
				'label'        => esc_html__( 'When hover over the Item.', 'zyre-elementor-addons' ),
				'description'  => esc_html__( 'Activate the styles when hover over the item.', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'ON', 'zyre-elementor-addons' ),
				'label_off'    => esc_html__( 'OFF', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'render_type'  => 'template', // Ensures live preview updates
				'prefix_class' => "zyre-addon-{$class_base}list-item-hover-",
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'           => 'item_type_background_hover',
				'label'          => esc_html__( 'Background', 'zyre-elementor-addons' ),
				'types'          => [ 'classic', 'gradient' ],
				'exclude'        => [ 'image' ],
				'selector'       => "{{WRAPPER}}:not(.zyre-addon-{$class_base}list-item-hover-yes) .zyre-{$class_base}list-item-type-wrapper:not(.zyre-image-list-item-image):hover,
									{{WRAPPER}}:not(.zyre-addon-{$class_base}list-item-hover-yes) .zyre-{$class_base}list-item-type-wrapper.zyre-image-list-item-image:hover img,
									{{WRAPPER}}.zyre-addon-{$class_base}list-item-hover-yes .zyre-{$class_base}list-item:hover .zyre-{$class_base}list-item-type-wrapper:not(.zyre-image-list-item-image),
									{{WRAPPER}}.zyre-addon-{$class_base}list-item-hover-yes .zyre-{$class_base}list-item:hover .zyre-{$class_base}list-item-type-wrapper.zyre-image-list-item-image:hover img",
			]
		);

		if ( ! empty( $args['id_prefix'] ) && 'numeric' === $args['id_prefix'] ) {
			$this->add_control(
				'item_type_color_hover',
				[
					'label'     => esc_html__( 'Number Color', 'zyre-elementor-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						"{{WRAPPER}}:not(.zyre-addon-{$class_base}list-item-hover-yes) .zyre-{$class_base}list-item-num:hover"                   => 'color: {{VALUE}};',
						"{{WRAPPER}}.zyre-addon-{$class_base}list-item-hover-yes .zyre-{$class_base}list-item:hover .zyre-{$class_base}list-item-num" => 'color: {{VALUE}};',
					],
				]
			);
		}

		$this->add_control(
			'item_icon_color_hover',
			[
				'label'     => esc_html__( 'Icon Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					"{{WRAPPER}}:not(.zyre-addon-{$class_base}list-item-hover-yes) .zyre-{$class_base}list-item-type-wrapper:hover i"                   => 'color: {{VALUE}};',
					"{{WRAPPER}}:not(.zyre-addon-{$class_base}list-item-hover-yes) .zyre-{$class_base}list-item-type-wrapper:hover svg"                 => 'fill: {{VALUE}};',
					"{{WRAPPER}}.zyre-addon-{$class_base}list-item-hover-yes .zyre-{$class_base}list-item:hover .zyre-{$class_base}list-item-type-wrapper i"   => 'color: {{VALUE}};',
					"{{WRAPPER}}.zyre-addon-{$class_base}list-item-hover-yes .zyre-{$class_base}list-item:hover .zyre-{$class_base}list-item-type-wrapper svg" => 'fill: {{VALUE}};',
				],
			]
		);

		if ( ! empty( $args['id_prefix'] ) && 'image' === $args['id_prefix'] ) {
			$this->add_group_control(
				Group_Control_Css_Filter::get_type(),
				[
					'name' => 'item_type_image_filters_hover',
					'selector' => "{{WRAPPER}}:not(.zyre-addon-{$class_base}list-item-hover-yes) .zyre-{$class_base}list-item-image:hover img,
					{{WRAPPER}}.zyre-addon-{$class_base}list-item-hover-yes .zyre-{$class_base}list-item:hover .zyre-{$class_base}list-item-image img",
				]
			);

			$this->add_control(
				'item_type_image_opacity_hover',
				[
					'label' => esc_html__( 'Opacity', 'zyre-elementor-addons' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 1,
							'min' => 0.10,
							'step' => 0.01,
						],
					],
					'selectors' => [
						"{{WRAPPER}}:not(.zyre-addon-{$class_base}list-item-hover-yes) .zyre-{$class_base}list-item-image:hover img" => 'opacity: {{SIZE}};',
						"{{WRAPPER}}.zyre-addon-{$class_base}list-item-hover-yes .zyre-{$class_base}list-item:hover .zyre-{$class_base}list-item-image img" => 'opacity: {{SIZE}};',
					],
				]
			);

			$this->add_control(
				'item_type_image_scale_hover',
				[
					'label' => esc_html__( 'Scale', 'zyre-elementor-addons' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 1,
							'min' => 0,
							'step' => 0.01,
						],
					],
					'selectors' => [
						"{{WRAPPER}}:not(.zyre-addon-{$class_base}list-item-hover-yes) .zyre-{$class_base}list-item-image:hover img" => 'transform: scale({{SIZE}});',
						"{{WRAPPER}}.zyre-addon-{$class_base}list-item-hover-yes .zyre-{$class_base}list-item:hover .zyre-{$class_base}list-item-image img" => 'transform: scale({{SIZE}});',
					],
				]
			);

			$this->add_control(
				'item_type_transition_hover',
				[
					'label' => esc_html__( 'Transition Duration (s)', 'zyre-elementor-addons' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 3,
							'step' => 0.1,
						],
					],
					'selectors' => [
						"{{WRAPPER}} .zyre-{$class_base}list-item-image img" => 'transition-duration: {{SIZE}}s',
					],
				]
			);
		}

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'item_type_border_hover',
				'selector'  => "{{WRAPPER}}:not(.zyre-addon-{$class_base}list-item-hover-yes) .zyre-{$class_base}list-item-type-wrapper:not(.zyre-image-list-item-image):hover,
								{{WRAPPER}}:not(.zyre-addon-{$class_base}list-item-hover-yes) .zyre-{$class_base}list-item-type-wrapper.zyre-image-list-item-image:hover img,
								{{WRAPPER}}.zyre-addon-{$class_base}list-item-hover-yes .zyre-{$class_base}list-item:hover .zyre-{$class_base}list-item-type-wrapper:not(.zyre-image-list-item-image),
								{{WRAPPER}}.zyre-addon-{$class_base}list-item-hover-yes .zyre-{$class_base}list-item:hover .zyre-{$class_base}list-item-type-wrapper.zyre-image-list-item-image:hover img",
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'item_type_box_shadow_hover',
				'selector' => "{{WRAPPER}}:not(.zyre-addon-{$class_base}list-item-hover-yes) .zyre-{$class_base}list-item-type-wrapper:hover,
				{{WRAPPER}}.zyre-addon-{$class_base}list-item-hover-yes .zyre-{$class_base}list-item:hover .zyre-{$class_base}list-item-type-wrapper",
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'item_type_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					"{{WRAPPER}} .zyre-{$class_base}list-item-type-wrapper:not(.zyre-image-list-item-image),
					{{WRAPPER}} .zyre-{$class_base}list-item-type-wrapper.zyre-image-list-item-image img" => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'item_type_padding',
			[
				'label'      => esc_html__( 'Padding', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors'  => [
					"{{WRAPPER}} .zyre-{$class_base}list-item-type-wrapper:not(.zyre-image-list-item-image),
					{{WRAPPER}} .zyre-{$class_base}list-item-type-wrapper.zyre-image-list-item-image img" => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_type_alignment_h',
			[
				'label'        => esc_html__( 'Horizontal Alignment', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'flex-start'    => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-center',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'selectors'    => [
					"{{WRAPPER}} .zyre-{$class_base}list-items .zyre-{$class_base}list-item-type-wrapper" => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_type_alignment_v',
			[
				'label'        => esc_html__( 'Vertical Alignment', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'flex-start'    => [
						'title' => esc_html__( 'Top', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-align-start-v',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-align-center-v',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Bottom', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-align-end-v',
					],
				],
				'selectors'    => [
					"{{WRAPPER}} .zyre-{$class_base}list-item .zyre-{$class_base}list-item-type-wrapper" => 'align-items: {{VALUE}};',
					"{{WRAPPER}} .zyre-{$class_base}list-item:not(.zyre-{$class_base}list-item--content-bottom) .zyre-{$class_base}list-item-type-wrapper" => 'align-self: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_type_zindex',
			[
				'label'     => esc_html__( 'Z-Index', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => -5,
				'max'       => 5,
				'step'      => 1,
				'selectors' => [
					"{{WRAPPER}} .zyre-{$class_base}list-items .zyre-{$class_base}list-item-type-wrapper" => 'z-index: {{VALUE}};',
				],
			]
		);
	}

	/**
	 * Register media wrapper style controls.
	 *
	 * @param array $args {
	 *     Optional. An array of arguments for adjusting the controls.
	 *
	 *     @type string $id_prefix     Prefix for the control IDs.
	 * }
	 */
	protected function register_media_wrapper_style_controls( $args = [] ) {
		$default_args = [
			'id_prefix' => '',
		];

		$args = wp_parse_args( $args, $default_args );
		$class_base = ! empty( $args['id_prefix'] ) ? $args['id_prefix'] . '-' : '';

		// Tabs
		$this->start_controls_tabs( 'media_wrapper_tabs' );

		// Normal Tab
		$this->start_controls_tab(
			'media_wrapper_tab_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'media_wrapper_bg_color',
			[
				'label'    => esc_html__( 'Background Color', 'zyre-elementor-addons' ),
				'type'     => Controls_Manager::COLOR,
				'selectors' => [
					"{{WRAPPER}} .zyre-{$class_base}list-item-type-wrapper" => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'media_wrapper_border',
				'selector'  => "{{WRAPPER}} .zyre-{$class_base}list-item-type-wrapper",
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'media_wrapper_tab_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'media_wrapper_bg_color_hover',
			[
				'label'    => esc_html__( 'Background Color', 'zyre-elementor-addons' ),
				'type'     => Controls_Manager::COLOR,
				'selectors' => [
					"{{WRAPPER}} .zyre-{$class_base}list-item-type-wrapper:hover" => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'media_wrapper_border_hover',
				'selector'  => "{{WRAPPER}} .zyre-{$class_base}list-item-type-wrapper:hover",
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'media_wrapper_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'separator'  => 'before',
				'selectors'  => [
					"{{WRAPPER}} .zyre-{$class_base}list-item-type-wrapper" => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'media_wrapper_padding',
			[
				'label'      => esc_html__( 'Padding', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					"{{WRAPPER}} .zyre-{$class_base}list-item-type-wrapper" => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
	}

	/**
	 * Register media caption style controls.
	 *
	 * @param array $args {
	 *     Optional. An array of arguments for adjusting the controls.
	 *
	 *     @type string $id_prefix     Prefix for the control IDs.
	 * }
	 */
	protected function register_media_caption_style_controls( $args = [] ) {
		$default_args = [
			'id_prefix' => '',
		];

		$args = wp_parse_args( $args, $default_args );
		$class_base = ! empty( $args['id_prefix'] ) ? $args['id_prefix'] . '-' : '';

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'caption_typo',
				'fields_options' => [
					'typography'  => [ 'default' => 'custom' ],
					'font_family' => [ 'default' => 'Inter' ],
				],
				'selector' => "{{WRAPPER}} .zyre-{$class_base}list-item-caption",
			]
		);

		// Tabs
		$this->start_controls_tabs( 'caption_tabs' );

		// Normal Tab
		$this->start_controls_tab(
			'caption_tab_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'caption_color',
			[
				'label'    => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'     => Controls_Manager::COLOR,
				'selectors' => [
					"{{WRAPPER}} .zyre-{$class_base}list-item-caption" => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'caption_bg_color',
			[
				'label'    => esc_html__( 'Background Color', 'zyre-elementor-addons' ),
				'type'     => Controls_Manager::COLOR,
				'selectors' => [
					"{{WRAPPER}} .zyre-{$class_base}list-item-caption-wrap" => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'caption_opacity',
			[
				'label' => esc_html__( 'Opacity', 'zyre-elementor-addons' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					"{{WRAPPER}} .zyre-{$class_base}list-item-caption-wrap" => 'opacity: {{SIZE}};',
				],
				'condition' => [
					"{$args['id_prefix']}_caption_display" => 'overlay',
				],
			]
		);

		$this->add_control(
			'caption_scale',
			[
				'label' => esc_html__( 'Scale', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0,
						'step' => 0.01,
					],
				],
				'selectors' => [
					"{{WRAPPER}} .zyre-{$class_base}list-item-caption-wrap" => 'transform: scale({{SIZE}});',
				],
				'condition' => [
					"{$args['id_prefix']}_caption_display" => 'overlay',
				],
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'caption_tab_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'caption_color_hover',
			[
				'label'    => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'     => Controls_Manager::COLOR,
				'selectors' => [
					"{{WRAPPER}} .zyre-{$class_base}list-item-caption-wrap:hover .zyre-{$class_base}list-item-caption" => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'caption_bg_color_hover',
			[
				'label'    => esc_html__( 'Background Color', 'zyre-elementor-addons' ),
				'type'     => Controls_Manager::COLOR,
				'selectors' => [
					"{{WRAPPER}} .zyre-{$class_base}list-item-caption-wrap:hover" => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'caption_opacity_hover',
			[
				'label' => esc_html__( 'Opacity', 'zyre-elementor-addons' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					"{{WRAPPER}} .zyre-{$class_base}list-item-image:hover .zyre-{$class_base}list-item-caption-wrap" => 'opacity: {{SIZE}};',
				],
				'condition' => [
					"{$args['id_prefix']}_caption_display" => 'overlay',
				],
			]
		);

		$this->add_control(
			'caption_scale_hover',
			[
				'label' => esc_html__( 'Scale', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0,
						'step' => 0.01,
					],
				],
				'selectors' => [
					"{{WRAPPER}} .zyre-{$class_base}list-item-image:hover .zyre-{$class_base}list-item-caption-wrap" => 'transform: scale({{SIZE}});',
				],
				'condition' => [
					"{$args['id_prefix']}_caption_display" => 'overlay',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'caption_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'separator'  => 'before',
				'selectors'  => [
					"{{WRAPPER}} .zyre-{$class_base}list-item-caption-wrap" => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'caption_width',
			[
				'label'                                                 => esc_html__( 'Width', 'zyre-elementor-addons' ),
				'type'                                                  => Controls_Manager::SLIDER,
				'size_units'                                            => ['px', '%', 'custom'],
				'selectors'                                             => [
					"{{WRAPPER}} .zyre-{$class_base}list-item-caption-wrap" => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition'                            => [
					"{$args['id_prefix']}_caption_display" => 'overlay',
				],
			]
		);

		$this->add_responsive_control(
			'caption_height',
			[
				'label'                                                 => esc_html__( 'Height', 'zyre-elementor-addons' ),
				'type'                                                  => Controls_Manager::SLIDER,
				'size_units'                                            => ['px', '%', 'custom'],
				'selectors'                                             => [
					"{{WRAPPER}} .zyre-{$class_base}list-item-caption-wrap" => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition'                            => [
					"{$args['id_prefix']}_caption_display" => 'overlay',
				],
			]
		);
		
		$this->add_responsive_control(
			'caption_padding',
			[
				'label'      => esc_html__( 'Padding', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					"{{WRAPPER}} .zyre-{$class_base}list-item-caption-wrap" => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'caption_margin',
			[
				'label'      => esc_html__( 'Margin', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					"{{WRAPPER}} .zyre-{$class_base}list-item-caption-wrap" => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'condition' => [
					"{$args['id_prefix']}_caption_display" => 'normal',
				],
			]
		);

		$this->add_responsive_control(
			'caption_position',
			[
				'label'      => esc_html__( 'Overlay Position', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					"{{WRAPPER}} .zyre-{$class_base}list-item-caption-wrap" => 'top: {{TOP}}{{UNIT}};right: {{RIGHT}}{{UNIT}};bottom: {{BOTTOM}}{{UNIT}};left: {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					"{$args['id_prefix']}_caption_display" => 'overlay',
				],
			]
		);

		$this->add_responsive_control(
			'caption_alignment',
			[
				'label'        => esc_html__( 'Alignment', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'left'    => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'   => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-right',
					],
					'justify'   => [
						'title' => esc_html__( 'Justify', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'selectors'    => [
					"{{WRAPPER}} .zyre-{$class_base}list-items .zyre-{$class_base}list-item-caption-wrap" => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'caption_align_y',
			[
				'label'     => esc_html__( 'Vertical Alignment', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Top', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-align-start-v',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-align-center-v',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Bottom', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-align-end-v',
					],
				],
				'selectors' => [
					"{{WRAPPER}}.zyre-{$class_base}list-caption-display--overlay .zyre-{$class_base}list-item-caption-wrap" => 'align-content: {{VALUE}};',
				],
				'condition' => [
					"{$args['id_prefix']}_caption_display" => 'overlay',
				],
			]
		);
	}

	/**
	 * Register items icon style controls.
	 *
	 * @param array $args {
	 *     Optional. An array of arguments for adjusting the controls.
	 *
	 *     @type string $id_prefix     Prefix for the control IDs.
	 * }
	 */
	protected function register_items_icon_style_controls( $args = [] ) {
		$default_args = [
			'id_prefix' => '',
		];

		$args = wp_parse_args( $args, $default_args );
		$class_base = ! empty( $args['id_prefix'] ) ? $args['id_prefix'] . '-' : '';

		$this->add_responsive_control(
			'items_icon_size',
			[
				'label'     => esc_html__( 'Icon Size', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors' => [
					"{{WRAPPER}} .zyre-{$class_base}list-items-icon-wrapper .zyre-{$class_base}list-items-icon"   => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'items_icon_width',
			[
				'label'      => esc_html__( 'Width', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 1000,
					],
					'%'  => [
						'min' => 1,
						'max' => 100,
					],
					'vw'  => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors'  => [
					"{{WRAPPER}} .zyre-{$class_base}list-items-icon"  => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'items_icon_height',
			[
				'label'      => esc_html__( 'Height', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 1000,
					],
					'%'  => [
						'min' => 1,
						'max' => 100,
					],
					'vw'  => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors'  => [
					"{{WRAPPER}} .zyre-{$class_base}list-items-icon"  => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'items_icon_wrapper_width',
			[
				'label'      => esc_html__( 'Wrapper Width', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 1000,
					],
					'%'  => [
						'min' => 1,
						'max' => 100,
					],
					'vw'  => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors'  => [
					"{{WRAPPER}} .zyre-{$class_base}list-items-icon-wrapper"  => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'items_icon_wrapper_height',
			[
				'label'      => esc_html__( 'Wrapper Height', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 1000,
					],
					'%'  => [
						'min' => 1,
						'max' => 100,
					],
					'vw'  => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors'  => [
					"{{WRAPPER}} .zyre-{$class_base}list-items-icon-wrapper"  => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'items_icon_wrapper_margin',
			[
				'label'      => esc_html__( 'Margin', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					"{{WRAPPER}} .zyre-{$class_base}list-items-icon-wrapper" => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Start Tabs
		$this->start_controls_tabs( 'items_icon_tabs' );

		// Start Normal Tab
		$this->start_controls_tab(
			'items_icon_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'           => 'items_icon_wrapper_bg',
				'label'          => esc_html__( 'Background', 'zyre-elementor-addons' ),
				'types'          => [ 'classic', 'gradient' ],
				'exclude'        => [ 'image' ],
				'selector'       => "{{WRAPPER}} .zyre-{$class_base}list-items-icon-wrapper",
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'items_icon_wrapper_border',
				'selector'  => "{{WRAPPER}} .zyre-{$class_base}list-items-icon-wrapper",
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'items_icon_wrapper_box_shadow',
				'selector' => "{{WRAPPER}} .zyre-{$class_base}list-items-icon-wrapper",
			]
		);

		// Icon only
		$this->add_control(
			'_heading_items_icon_normal',
			[
				'label' => esc_html__( 'Icon:', 'zyre-elementor-addons' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'items_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#197DFF',
				'selectors' => [
					"{{WRAPPER}} .zyre-{$class_base}list-items-icon-wrapper i" => 'color: {{VALUE}};',
					"{{WRAPPER}} .zyre-{$class_base}list-items-icon-wrapper svg" => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'           => 'items_icon_bg',
				'label'          => esc_html__( 'Icon Background', 'zyre-elementor-addons' ),
				'types'          => [ 'classic', 'gradient' ],
				'exclude'        => [ 'image' ],
				'selector'       => "{{WRAPPER}} .zyre-{$class_base}list-items-icon",
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'items_icon_border',
				'label'     => esc_html__( 'Icon Border', 'zyre-elementor-addons' ),
				'selector'  => "{{WRAPPER}} .zyre-{$class_base}list-items-icon",
			]
		);

		$this->end_controls_tab();

		// Start Hover Tab
		$this->start_controls_tab(
			'items_icon_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'items_icon_hover_style_switch',
			[
				'label'        => esc_html__( 'When hover over the Item.', 'zyre-elementor-addons' ),
				'description'  => esc_html__( 'Activate the styles when hover over the item.', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'ON', 'zyre-elementor-addons' ),
				'label_off'    => esc_html__( 'OFF', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'render_type'  => 'template', // Ensures live preview updates
				'prefix_class' => "zyre-{$class_base}list-items-icon-hover--",
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'           => 'items_icon_wrapper_bg_hover',
				'label'          => esc_html__( 'Background', 'zyre-elementor-addons' ),
				'types'          => [ 'classic', 'gradient' ],
				'exclude'        => [ 'image' ],
				'selector'       => "{{WRAPPER}}:not(.zyre-{$class_base}list-items-icon-hover--yes) .zyre-{$class_base}list-items-icon-wrapper:hover,
				{{WRAPPER}}.zyre-{$class_base}list-items-icon-hover--yes .zyre-{$class_base}list-item:hover .zyre-{$class_base}list-items-icon-wrapper",
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'items_icon_wrapper_border_hover',
				'selector'  => "{{WRAPPER}}:not(.zyre-{$class_base}list-items-icon-hover--yes) .zyre-{$class_base}list-items-icon-wrapper:hover,
				{{WRAPPER}}.zyre-{$class_base}list-items-icon-hover--yes .zyre-{$class_base}list-item:hover .zyre-{$class_base}list-items-icon-wrapper",
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'items_icon_wrapper_box_shadow_hover',
				'selector' => "{{WRAPPER}}:not(.zyre-{$class_base}list-items-icon-hover--yes) .zyre-{$class_base}list-items-icon-wrapper:hover,
				{{WRAPPER}}.zyre-{$class_base}list-items-icon-hover--yes .zyre-{$class_base}list-item:hover .zyre-{$class_base}list-items-icon-wrapper",
			]
		);

		// Icon only
		$this->add_control(
			'_heading_items_icon_hover',
			[
				'label' => esc_html__( 'Icon:', 'zyre-elementor-addons' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'items_icon_color_hover',
			[
				'label'     => esc_html__( 'Icon Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					"{{WRAPPER}}:not(.zyre-{$class_base}list-items-icon-hover--yes) .zyre-{$class_base}list-items-icon:hover i"                   => 'color: {{VALUE}};',
					"{{WRAPPER}}:not(.zyre-{$class_base}list-items-icon-hover--yes) .zyre-{$class_base}list-items-icon:hover svg"                 => 'fill: {{VALUE}};',
					"{{WRAPPER}}.zyre-{$class_base}list-items-icon-hover--yes .zyre-{$class_base}list-item:hover .zyre-{$class_base}list-items-icon i"   => 'color: {{VALUE}};',
					"{{WRAPPER}}.zyre-{$class_base}list-items-icon-hover--yes .zyre-{$class_base}list-item:hover .zyre-{$class_base}list-items-icon svg" => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'           => 'items_icon_bg_hover',
				'label'          => esc_html__( 'Icon Background', 'zyre-elementor-addons' ),
				'types'          => [ 'classic', 'gradient' ],
				'exclude'        => [ 'image' ],
				'selector'       => "{{WRAPPER}}:not(.zyre-{$class_base}list-items-icon-hover--yes) .zyre-{$class_base}list-items-icon:hover,
				{{WRAPPER}}.zyre-{$class_base}list-items-icon-hover--yes .zyre-{$class_base}list-item:hover .zyre-{$class_base}list-items-icon",
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'items_icon_border_hover',
				'label'     => esc_html__( 'Icon Border', 'zyre-elementor-addons' ),
				'selector'  => "{{WRAPPER}}:not(.zyre-{$class_base}list-items-icon-hover--yes) .zyre-{$class_base}list-items-icon:hover,
				{{WRAPPER}}.zyre-{$class_base}list-items-icon-hover--yes .zyre-{$class_base}list-item:hover .zyre-{$class_base}list-items-icon",
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'items_icon_wrapper_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					"{{WRAPPER}} .zyre-{$class_base}list-items-icon-wrapper" => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'items_icon_border_radius',
			[
				'label'      => esc_html__( 'Icon Border Radius', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					"{{WRAPPER}} .zyre-{$class_base}list-items-icon" => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'items_icon_align_x',
			[
				'label'        => esc_html__( 'Horizontal Alignment', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'flex-start'    => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-center',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'selectors'    => [
					"{{WRAPPER}} .zyre-{$class_base}list-items .zyre-{$class_base}list-items-icon-wrapper" => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'items_icon_align_y',
			[
				'label'        => esc_html__( 'Vertical Alignment', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'flex-start'    => [
						'title' => esc_html__( 'Top', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-align-start-v',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-align-center-v',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Bottom', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-align-end-v',
					],
				],
				'selectors'    => [
					"{{WRAPPER}} .zyre-{$class_base}list-item .zyre-{$class_base}list-items-icon-wrapper" => 'align-items: {{VALUE}};',
					"{{WRAPPER}} .zyre-{$class_base}list-item:not(.zyre-{$class_base}list-item--content-bottom) .zyre-{$class_base}list-items-icon-wrapper" => 'align-self: {{VALUE}};',
				],
			]
		);
	}

	/**
	 * Register grid style controls.
	 *
	 * @param array $args {
	 *     Optional. An array of arguments for adjusting the controls.
	 *
	 *     @type string $id_prefix     Prefix for the control IDs.
	 * }
	 */
	protected function register_grid_style_controls( $args = [] ) {
		$default_args = [
			'id_prefix' => '',
		];

		$args = wp_parse_args( $args, $default_args );
		$id_base = ! empty( $args['id_prefix'] ) ? $args['id_prefix'] : '';
		$class_base = ! empty( $id_base ) ? $id_base . '-' : '';
		$control_base = ! empty( $args['selector_suffix'] ) ? $args['selector_suffix'] : '';

		$this->add_control(
			$control_base . '_grid_settings',
			[
				'label' => esc_html__( 'Grid Settings', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition'              => [
					"{$id_base}_item_layout" => 'grid',
					'divider'                => 'yes',
				],
			]
		);

		$this->add_control(
			$control_base . '_row_start',
			[
				'label'                  => esc_html__( 'Row Start', 'zyre-elementor-addons' ),
				'type'                   => Controls_Manager::NUMBER,
				'min'                    => -12,
				'max'                    => 12,
				'step'                   => 1,
				'condition'              => [
					"{$id_base}_item_layout" => 'grid',
					'divider'                => 'yes',
				],
			]
		);

		$this->add_control(
			$control_base . '_row_end',
			[
				'label' => esc_html__( 'Row End', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::NUMBER,
				'min' => -12,
				'max' => 12,
				'step' => 1,
				'condition'              => [
					"{$id_base}_item_layout" => 'grid',
					'divider'                => 'yes',
				],
			]
		);

		$this->add_control(
			$control_base . '_column_start',
			[
				'label' => esc_html__( 'Column Start', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::NUMBER,
				'min' => -12,
				'max' => 12,
				'step' => 1,
				'condition'              => [
					"{$id_base}_item_layout" => 'grid',
					'divider'                => 'yes',
				],
			]
		);

		$this->add_control(
			$control_base . '_column_end',
			[
				'label' => esc_html__( 'Column End', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::NUMBER,
				'min' => -12,
				'max' => 12,
				'step' => 1,
				'condition'              => [
					"{$id_base}_item_layout" => 'grid',
					'divider'                => 'yes',
				],
			]
		);
	}

	/**
	 * Render items output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @param \Elementor\Widget_Base|null $instance
	 *
	 * @param array $args {
	 *     Optional. An array of arguments for adjusting the controls.
	 *
	 *     @type string $id_prefix     Prefix for the control IDs.
	 * }
	 *
	 * @access protected
	 */
	protected function render_items( ?Widget_Base $instance = null, $args = [] ) {
		if ( empty( $instance ) ) {
			$instance = $this;
		}

		$default_args = [
			'id_prefix' => '',
		];

		$args = wp_parse_args( $args, $default_args );
		$id_base = ! empty( $args['id_prefix'] ) ? $args['id_prefix'] : '';
		$prefix = ! empty( $id_base ) ? $id_base . '_' : '';
		$class_base = ! empty( $args['id_prefix'] ) ? str_replace( '_', '-', $args['id_prefix'] ) . '-' : '';

		$settings = $this->get_settings_for_display();
		$fallback_defaults = [
			'fa fa-check',
			'fa fa-times',
			'fa fa-dot-circle-o',
		];

		$caption_display = ! empty( $settings[ $prefix . 'caption_display' ] ) ? sanitize_key( $settings[ $prefix . 'caption_display' ] ) : '';

		// Add HTML class
		$instance->add_render_attribute( 'items', 'class', "zyre-{$class_base}list-items" );
		$instance->add_render_attribute( 'item', 'class', "zyre-{$class_base}list-item" );
		$instance->add_render_attribute( 'item_link', 'class', "zyre-{$class_base}list-item-link" );
		$instance->add_render_attribute( 'item', 'class', ! empty( $settings['item_layout'] ) ? "zyre-{$class_base}list-item--content-" . esc_attr( $settings['item_layout'] ) : '' );

		$instance->add_render_attribute( 'icon', 'class', "zyre-{$class_base}list-item-type-wrapper zyre-{$class_base}list-item-icon zy-overflow-hidden" );
		$instance->add_render_attribute( 'image', 'class', "zyre-{$class_base}list-item-type-wrapper zyre-{$class_base}list-item-image zy-overflow-hidden zy-relative" );
		$instance->add_render_attribute( 'number', 'class', "zyre-{$class_base}list-item-type-wrapper zyre-{$class_base}list-item-num zy-overflow-hidden" );
		$instance->add_render_attribute( 'item_content', 'class', "zyre-{$class_base}list-item-content zy-relative" );
		?>

		<ul <?php $instance->print_render_attribute_string( 'items' ); ?>>
			<?php foreach ( $settings[ $prefix . 'list' ] as $index => $item ) :
				$repeater_caption_wrap_key = $instance->get_repeater_setting_key( 'caption_wrap', $prefix . 'list', $index );
				$repeater_caption_key = $instance->get_repeater_setting_key( 'caption', $prefix . 'list', $index );
				$repeater_title_setting_key = $instance->get_repeater_setting_key( 'item_title', $prefix . 'list', $index );
				$repeater_desc_setting_key = $instance->get_repeater_setting_key( 'item_description', $prefix . 'list', $index );
				$image = $item['item_image'] ?? [];

				$instance->add_render_attribute( $repeater_caption_wrap_key, 'class', "zyre-{$class_base}list-item-caption-wrap" );
				if ( 'overlay' === $caption_display ) {
					$instance->add_render_attribute( $repeater_caption_wrap_key, 'class', 'zy-absolute zy-left-0 zy-top-0 zy-w-100 zy-h-100 zy-content-center' );
				}

				$instance->add_render_attribute( $repeater_caption_key, 'class', "zyre-{$class_base}list-item-caption" );
				$instance->add_render_attribute( $repeater_title_setting_key, 'class', "zyre-{$class_base}list-item-title" );
				$instance->add_render_attribute( $repeater_desc_setting_key, 'class', "zyre-{$class_base}list-item-text" );

				$instance->add_inline_editing_attributes( $repeater_title_setting_key );
				$instance->add_inline_editing_attributes( $repeater_desc_setting_key );
				$migration_allowed = Icons_Manager::is_migration_allowed();

				?>
				<li <?php $instance->print_render_attribute_string( 'item' ); ?>>
					<?php
					if ( ! empty( $item['item_link']['url'] ) ) {
						$link_key = 'item_link_' . $index;

						$this->add_link_attributes( $link_key, $item['item_link'] );
						?>
						<a <?php $instance->print_render_attribute_string( 'item_link' ); ?> <?php $this->print_render_attribute_string( $link_key ); ?>>
						<?php
					}

					// add old default
					if ( ! isset( $item['icon'] ) && ! $migration_allowed ) {
						$item['icon'] = isset( $fallback_defaults[ $index ] ) ? $fallback_defaults[ $index ] : 'fa fa-check';
					}

					$migrated = isset( $item['__fa4_migrated']['selected_icon'] );
					$is_new = ! isset( $item['icon'] ) && $migration_allowed;
					if ( ! empty( $item['icon'] ) || ( 'icon' === $item['item_type'] && ! empty( $item['selected_icon']['value'] ) && $is_new ) ) :
						?>
						<span <?php $instance->print_render_attribute_string( 'icon' ); ?>>
							<?php
							if ( $is_new || $migrated ) {
								Icons_Manager::render_icon( $item['selected_icon'], [ 'aria-hidden' => 'true' ] );
							} else { ?>
								<i class="<?php echo esc_attr( $item['icon'] ); ?>" aria-hidden="true"></i>
							<?php } ?>
						</span>
					<?php endif; ?>

					<?php if ( 'image' === $item['item_type'] ) : ?>
						<div <?php $instance->print_render_attribute_string( 'image' ); ?>>
							<?php
							if ( isset( $image['source'] ) && $image['id'] && isset( $settings['thumbnail_size'] ) ) :
								echo wp_get_attachment_image(
									$image['id'],
									$settings['thumbnail_size'],
									false,
								);
							else :
								$url = $image['url'] ? $image['url'] : Utils::get_placeholder_image_src();
								printf( '<img src="%s" alt="%s">',
									esc_url( $url ),
									esc_attr( $item['item_title'] )
								);
							endif;

							?>

							<?php if ( ( 'image' === $id_base || 'feature' === $id_base ) && ! empty( $item['media_caption'] ) ) : ?>
								<div <?php $instance->print_render_attribute_string( $repeater_caption_wrap_key ); ?>><span <?php $instance->print_render_attribute_string( $repeater_caption_key ); ?>><?php echo wp_kses( $item['media_caption'], zyre_get_allowed_html() ); ?></span></div>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<?php if ( 'number' === $item['item_type'] && ! empty( $item['item_number'] ) ) : ?>
						<span <?php $instance->print_render_attribute_string( 'number' ); ?>><?php echo esc_html( $item['item_number'] ); ?></span>
					<?php endif; ?>

					<div <?php $instance->print_render_attribute_string( 'item_content' ); ?>>
						<?php if ( ! empty( $item['item_title'] ) ) : ?>
							<<?php Utils::print_validated_html_tag( $item['title_html_tag'] ); ?> <?php $instance->print_render_attribute_string( $repeater_title_setting_key ); ?>>
								<?php echo esc_html( $item['item_title'] ); ?>
							</<?php Utils::print_validated_html_tag( $item['title_html_tag'] ); ?>>
						<?php endif; ?>

						<?php if ( ! empty( $item['item_description'] ) ) : ?>
							<p <?php $instance->print_render_attribute_string( $repeater_desc_setting_key ); ?>>
								<?php echo esc_html( $item['item_description'] ); ?>
							</p>
						<?php endif; ?>
					</div>

					<?php if ( ! empty( $args['id_prefix'] ) && 'group' === $args['id_prefix'] ) :
						$items_icon_key = $args['id_prefix'] . '_items_icon';

						if ( ! empty( $settings['icon'] ) || ! empty( $settings[ $items_icon_key ]['value'] ) ) :
							$icon_migrated = isset( $settings['__fa4_migrated'][ $items_icon_key ] );
							$is_icon_new = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
							$instance->add_render_attribute( 'items', 'class', "zyre-{$class_base}list-items" );
							?>
							<div class="zyre-group-list-items-icon-wrapper">
								<?php
								if ( $is_icon_new || $icon_migrated ) { ?>
									<span class="zyre-group-list-items-icon"><?php Icons_Manager::render_icon( $settings[ $items_icon_key ], [ 'aria-hidden' => 'true' ] ); ?></span>
								<?php } else { ?>
									<span class="zyre-group-list-items-icon"><i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i></span>
								<?php } ?>
							</div>
						<?php endif; ?>
					<?php endif; ?>
					<?php if ( ! empty( $item['item_link']['url'] ) ) : ?>
						</a>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php
	}
}
