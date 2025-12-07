<?php
namespace ZyreAddons\Elementor\Traits;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

trait Social_Trait {

	/**
	 * Register content controls.
	 *
	 * @param array $args {
	 *     Optional. An array of arguments for adjusting the controls.
	 *
	 *     @type integer $default_items     How many default items will show. Default 5.
	 *     @type bool   $prevent_empty Whether to prevent empty items. Default true.
	 * }
	 */
	protected function register_social_content_controls( $args = [] ) {
		$default_args = [
			'default_items' => 5,
			'prevent_empty' => true,
		];

		$args = wp_parse_args( $args, $default_args );

		$repeater = new Repeater();

		$repeater->add_control(
			'social_icon',
			[
				'label'       => esc_html__( 'Icon', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::ICONS,
				'fa4compatibility' => 'social',
				'label_block' => false,
				'default'     => [
					'value'   => 'fab fa-wordpress',
					'library' => 'fa-brands',
				],
				'skin' => 'inline',
				'exclude_inline_options' => [ 'svg' ],
				'recommended' => [
					'fa-brands' => [
						'android',
						'apple',
						'behance',
						'bitbucket',
						'codepen',
						'delicious',
						'deviantart',
						'digg',
						'dribbble',
						'zyre-elementor-addons',
						'facebook',
						'flickr',
						'foursquare',
						'free-code-camp',
						'github',
						'gitlab',
						'globe',
						'google-plus',
						'houzz',
						'instagram',
						'jsfiddle',
						'linkedin',
						'medium',
						'meetup',
						'mixcloud',
						'odnoklassniki',
						'pinterest',
						'product-hunt',
						'reddit',
						'shopping-cart',
						'skype',
						'slideshare',
						'snapchat',
						'soundcloud',
						'spotify',
						'stack-overflow',
						'steam',
						'stumbleupon',
						'telegram',
						'thumb-tack',
						'tripadvisor',
						'tumblr',
						'twitch',
						'twitter',
						'viber',
						'vimeo',
						'vk',
						'weibo',
						'weixin',
						'whatsapp',
						'wordpress',
						'xing',
						'yelp',
						'youtube',
						'500px',
					],
				],
			]
		);

		$repeater->add_control(
			'social_link',
			[
				'label'       => esc_html__( 'Link', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::URL,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'default' => [
					'url' => '#',
					'is_external' => 'true',
				],
				'placeholder' => esc_html__( 'https://your-social-link.com', 'zyre-elementor-addons' ),
			]
		);

		$repeater->add_control(
			'enable_text',
			[
				'label'          => esc_html__( 'Enable Name', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::SWITCHER,
				'label_on'       => esc_html__( 'Yes', 'zyre-elementor-addons' ),
				'label_off'      => esc_html__( 'No', 'zyre-elementor-addons' ),
				'return_value'   => 'yes',
				'style_transfer' => true,
				'separator'      => 'before',
			]
		);

		$repeater->add_control(
			'social_name',
			[
				'label'     => esc_html__( 'Social Name', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'condition' => [
					'enable_text' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'social_customize',
			[
				'label'          => esc_html__( 'Want To Customize?', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::SWITCHER,
				'label_on'       => esc_html__( 'Yes', 'zyre-elementor-addons' ),
				'label_off'      => esc_html__( 'No', 'zyre-elementor-addons' ),
				'return_value'   => 'yes',
				'style_transfer' => true,
				'separator'      => 'before',
			]
		);

		// Tabs
		$repeater->start_controls_tabs(
			'tabs_social_icon_colors',
			[
				'condition' => [ 'social_customize' => 'yes' ],
			]
		);

		// Normal Tab
		$repeater->start_controls_tab(
			'tab_social_icon_color_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$repeater->add_control(
			'social_icon_color',
			[
				'label' => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'  => Controls_Manager::COLOR,

				'selectors'      => [
					'{{WRAPPER}} .zyre-social-icon-wrapper > {{CURRENT_ITEM}}.zyre-social-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-social-icon-wrapper > {{CURRENT_ITEM}}.zyre-social-icon svg' => 'fill: {{VALUE}};',
				],
				'condition'      => [ 'social_customize' => 'yes' ],
				'style_transfer' => true,
			]
		);

		$repeater->add_control(
			'social_icon_bg_color',
			[
				'label'          => esc_html__( 'Background Color', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::COLOR,
				'selectors'      => [
					'{{WRAPPER}} .zyre-social-icon-wrapper > {{CURRENT_ITEM}}.zyre-social-icon' => 'background-color: {{VALUE}};',
				],
				'condition'      => [ 'social_customize' => 'yes' ],
				'style_transfer' => true,
			]
		);

		$repeater->add_control(
			'social_icon_border_color',
			[
				'label'          => esc_html__( 'Border Color', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::COLOR,
				'condition'      => [ 'social_customize' => 'yes' ],
				'style_transfer' => true,
				'selectors'      => [
					'{{WRAPPER}} .zyre-social-icon-wrapper > {{CURRENT_ITEM}}.zyre-social-icon' => 'border-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'social_icon_separator_color',
			[
				'label'          => esc_html__( 'Separator Color', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::COLOR,
				'condition'      => [ 'social_customize' => 'yes' ],
				'style_transfer' => true,
				'selectors'      => [
					'{{WRAPPER}} .zyre-social-icon-wrapper > {{CURRENT_ITEM}}.zyre-social-icon .zyre-social-icon-label' => 'border-color: {{VALUE}};',
				],
			]
		);

		$repeater->end_controls_tab();

		// Hover Tab
		$repeater->start_controls_tab(
			'tab_social_icon_color_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$repeater->add_control(
			'social_icon_color_hover',
			[
				'label' => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'  => Controls_Manager::COLOR,

				'selectors'      => [
					'{{WRAPPER}} .zyre-social-icon-wrapper > {{CURRENT_ITEM}}.zyre-social-icon:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-social-icon-wrapper > {{CURRENT_ITEM}}.zyre-social-icon:hover svg' => 'fill: {{VALUE}};',
				],
				'condition'      => [ 'social_customize' => 'yes' ],
				'style_transfer' => true,
			]
		);

		$repeater->add_control(
			'social_icon_bg_color_hover',
			[
				'label'          => esc_html__( 'Background Color', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::COLOR,
				'selectors'      => [
					'{{WRAPPER}} .zyre-social-icon-wrapper > {{CURRENT_ITEM}}.zyre-social-icon:hover' => 'background-color: {{VALUE}};',
				],
				'condition'      => [ 'social_customize' => 'yes' ],
				'style_transfer' => true,
			]
		);

		$repeater->add_control(
			'social_icon_border_color_hover',
			[
				'label'          => esc_html__( 'Border Color', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::COLOR,
				'condition'      => [ 'social_customize' => 'yes' ],
				'style_transfer' => true,
				'selectors'      => [
					'{{WRAPPER}} .zyre-social-icon-wrapper > {{CURRENT_ITEM}}.zyre-social-icon:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'social_icon_separator_color_hover',
			[
				'label'          => esc_html__( 'Separator Color', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::COLOR,
				'condition'      => [ 'social_customize' => 'yes' ],
				'style_transfer' => true,
				'selectors'      => [
					'{{WRAPPER}} .zyre-social-icon-wrapper > {{CURRENT_ITEM}}.zyre-social-icon:hover .zyre-social-icon-label' => 'border-color: {{VALUE}};',
				],
			]
		);

		$repeater->end_controls_tab();
		$repeater->end_controls_tabs();

		$repeater->add_responsive_control(
			'social_icon_size',
			[
				'label'     => esc_html__( 'Icon Size', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 10,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-social-icon-wrapper > {{CURRENT_ITEM}}.zyre-social-icon'   => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'separator'   => 'before',
			]
		);

		$default_items = [
			[
				'social_icon' => [
					'value'   => 'fab fa-facebook-f',
					'library' => 'fa-brands',
				],
				'social_link' => [
					'url' => '#',
				],
			],
			[
				'social_icon' => [
					'value'   => 'fab fa-x-twitter',
					'library' => 'fa-brands',
				],
				'social_link' => [
					'url' => '#',
				],
			],
			[
				'social_icon' => [
					'value'   => 'fab fa-instagram',
					'library' => 'fa-brands',
				],
				'social_link' => [
					'url' => '#',
				],
			],
			[
				'social_icon' => [
					'value'   => 'fab fa-tiktok',
					'library' => 'fa-brands',
				],
				'social_link' => [
					'url' => '#',
				],
			],
			[
				'social_icon' => [
					'value'   => 'fab fa-youtube',
					'library' => 'fa-brands',
				],
				'social_link' => [
					'url' => '#',
				],
			],
		];

		$this->add_control(
			'social_icons',
			[
				'label'         => esc_html__( 'Social Icons', 'zyre-elementor-addons' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'prevent_empty' => $args['prevent_empty'],
				'default'       => array_slice( $default_items, 0, $args['default_items'] ),
				'title_field'   => '<# var migrated = "undefined" !== typeof __fa4_migrated, social = ( "undefined" === typeof social ) ? false : social; #>{{{ elementor.helpers.getSocialNetworkNameFromIcon( social_icon, social, true, migrated, true ) }}}',
			]
		);
	}

	/**
	 * Register social settings controls.
	 *
	 * @param array $args {
	 *     Optional. An array of arguments for adjusting the controls.
	 * }
	 */
	protected function register_social_settings_controls( $args = [] ) {
		$default_args = [];

		$args = wp_parse_args( $args, $default_args );

		$this->add_responsive_control(
			'social_icon_columns',
			[
				'label' => esc_html__( 'Columns', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '0',
				'options' => [
					'0' => esc_html__( 'Auto', 'zyre-elementor-addons' ),
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'prefix_class' => 'elementor-grid%s-',
				'selectors' => [
					'{{WRAPPER}}' => '--grid-template-columns: repeat({{VALUE}}, auto);',
				],
			]
		);

		$this->add_responsive_control(
			'social_icon_align',
			[
				'label'       => esc_html__( 'Alignment', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
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
				'selectors_dictionary' => [
					'left'   => 'text-align: left; justify-items: flex-start;',
					'center' => 'text-align: center; justify-items: center;',
					'right'  => 'text-align: right; justify-items: flex-end;',
				],
				'selectors'   => [
					'{{WRAPPER}} .zyre-social-icon-wrapper' => '{{VALUE}}',
				],
				'separator'   => 'before',
				'render_type' => 'ui',
			]
		);

		$left_right = is_rtl() ? 'right' : 'left';
		$this->add_control(
			'social_icon_separator',
			[
				'label'          => esc_html__( 'Enable Separator', 'zyre-elementor-addons' ),
				'description'    => esc_html__( 'Separator Between Icon & Social Name', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::SWITCHER,
				'return_value'   => 'yes',
				'style_transfer' => true,
				'selectors'      => [
					'{{WRAPPER}} .zyre-social-icon-label' => "border-{$left_right}-width: 1px;border-{$left_right}-style: solid;border-{$left_right}-color: initial;",
				],
			]
		);
	}

	/**
	 * Register social general style controls.
	 *
	 * @param array $args {
	 *     Optional. An array of arguments for adjusting the controls.
	 * }
	 */
	protected function register_social_general_style_controls( $args = [] ) {
		$default_args = [];

		$args = wp_parse_args( $args, $default_args );

		// Tabs
		$this->start_controls_tabs(
			'tabs_all_social_colors'
		);

		// Normal Tab
		$this->start_controls_tab(
			'tab_all_social_color_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'all_social_color',
			[
				'label' => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'  => Controls_Manager::COLOR,

				'selectors'      => [
					'{{WRAPPER}} .zyre-social-icon-wrapper > .zyre-social-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-social-icon-wrapper > .zyre-social-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'all_social_bg_color',
			[
				'label'          => esc_html__( 'Background Color', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::COLOR,
				'selectors'      => [
					'{{WRAPPER}} .zyre-social-icon-wrapper > .zyre-social-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'all_social_border_color',
			[
				'label'          => esc_html__( 'Border Color', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::COLOR,
				'selectors'      => [
					'{{WRAPPER}} .zyre-social-icon-wrapper > .zyre-social-icon' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'all_social_icon_separator_color',
			[
				'label'          => esc_html__( 'Separator Color', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::COLOR,
				'condition'      => [ 'social_icon_separator' => 'yes' ],
				'selectors'      => [
					'{{WRAPPER}} .zyre-social-icon-wrapper > .zyre-social-icon .zyre-social-icon-label' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'tab_all_social_color_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'all_social_color_hover',
			[
				'label' => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'  => Controls_Manager::COLOR,

				'selectors'      => [
					'{{WRAPPER}} .zyre-social-icon-wrapper > .zyre-social-icon:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-social-icon-wrapper > .zyre-social-icon:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'all_social_bg_color_hover',
			[
				'label'          => esc_html__( 'Background Color', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::COLOR,
				'selectors'      => [
					'{{WRAPPER}} .zyre-social-icon-wrapper > .zyre-social-icon:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'all_social_border_color_hover',
			[
				'label'          => esc_html__( 'Border Color', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::COLOR,
				'selectors'      => [
					'{{WRAPPER}} .zyre-social-icon-wrapper > .zyre-social-icon:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'all_social_icon_separator_color_hover',
			[
				'label'          => esc_html__( 'Separator Color', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::COLOR,
				'condition'      => [ 'social_icon_separator' => 'yes' ],
				'selectors'      => [
					'{{WRAPPER}} .zyre-social-icon-wrapper > .zyre-social-icon:hover .zyre-social-icon-label' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'social_gap',
			[
				'label'      => esc_html__( 'Space Between', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'range'      => [
					'px'  => [
						'max' => 100,
					],
					'em'  => [
						'min' => 0,
						'max' => 10,
					],
					'rem' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'selectors'  => [
					'{{WRAPPER}}' => '--grid-column-gap: {{SIZE}}{{UNIT}}',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'social_row_gap',
			[
				'label' => esc_html__( 'Rows Gap', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}}' => '--grid-row-gap: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'all_social_width',
			[
				'label' => esc_html__( 'Item Width', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'custom' ],
				'range' => [
					'px' => [
						'max' => 500,
					],
					'%' => [
						'max' => 100,
					],
					'em' => [
						'max' => 20,
					],
					'rem' => [
						'max' => 20,
					],
				],
				'default' => [
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-social-icon-wrapper > .zyre-social-icon' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'all_social_height',
			[
				'label' => esc_html__( 'Item Height', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'custom' ],
				'range' => [
					'px' => [
						'max' => 500,
					],
					'%' => [
						'max' => 100,
					],
					'em' => [
						'max' => 20,
					],
					'rem' => [
						'max' => 20,
					],
				],
				'default' => [
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-social-icon-wrapper > .zyre-social-icon' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$left_right = is_rtl() ? 'right' : 'left';
		$this->add_control(
			'social_icon_separator_width',
			[
				'label'          => esc_html__( 'Separator Width', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'condition'      => [ 'social_icon_separator' => 'yes' ],
				'selectors'      => [
					'{{WRAPPER}} .zyre-social-icon-wrapper > .zyre-social-icon .zyre-social-icon-label' => "border-{$left_right}-width: {{SIZE}}{{UNIT}};",
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'social_border',
				'selector'  => '{{WRAPPER}} .zyre-social-icon-wrapper > .zyre-social-icon',
			]
		);

		$this->add_responsive_control(
			'social_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .zyre-social-icon-wrapper > .zyre-social-icon'  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'social_box_shadow',
				'selector' => '{{WRAPPER}} .zyre-social-icon-wrapper > .zyre-social-icon',
			]
		);

		$this->add_responsive_control(
			'social_padding',
			[
				'label'      => esc_html__( 'Padding', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .zyre-social-icon-wrapper > .zyre-social-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'social_items_align',
			[
				'label'     => esc_html__( 'Items Alignment', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Start', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-center',
					],
					'flex-end'   => [
						'title' => esc_html__( 'End', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-social-icon-wrapper > .zyre-social-icon' => 'justify-content: {{VALUE}};',
				],
			]
		);
	}

	/**
	 * Register social icon style controls.
	 *
	 * @param array $args {
	 *     Optional. An array of arguments for adjusting the controls.
	 * }
	 */
	protected function register_social_icon_style_controls( $args = [] ) {
		$default_args = [];

		$args = wp_parse_args( $args, $default_args );

		$this->add_responsive_control(
			'all_icon_size',
			[
				'label'     => esc_html__( 'Size', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 10,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-social-icon-wrapper > .zyre-social-icon'   => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_hover_animation',
			[
				'label' => esc_html__( 'Hover Animation', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->add_responsive_control(
			'icon_padding',
			[
				'label'      => esc_html__( 'Padding', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .zyre-social-icon-holder' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
	}

	/**
	 * Register social name style controls.
	 *
	 * @param array $args {
	 *     Optional. An array of arguments for adjusting the controls.
	 * }
	 */
	protected function register_social_name_style_controls( $args = [] ) {
		$default_args = [];

		$args = wp_parse_args( $args, $default_args );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'name_typography',
				'selector' => '{{WRAPPER}} .zyre-social-icon-label',
			]
		);

		$this->add_responsive_control(
			'social_name_padding',
			[
				'label'      => esc_html__( 'Padding', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .zyre-social-icon-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
	 * }
	 *
	 * @access protected
	 */
	protected function render_social_items( ?Widget_Base $instance = null, $args = [] ) {
		if ( empty( $instance ) ) {
			$instance = $this;
		}

		$default_args = [];

		$args = wp_parse_args( $args, $default_args );

		$settings = $this->get_settings_for_display();
		$fallback_defaults = [
			'fa fa-facebook',
			'fa fa-twitter',
			'fa fa-google-plus',
		];

		$class_animation = '';

		if ( ! empty( $settings['icon_hover_animation'] ) ) {
			$class_animation = ' elementor-animation-' . $settings['icon_hover_animation'];
		}

		$migration_allowed = Icons_Manager::is_migration_allowed();

		?>
		<div class="zyre-social-icon-wrapper elementor-grid zy-align-center">
			<?php
			foreach ( $settings['social_icons'] as $index => $item ) {
				$migrated = isset( $item['__fa4_migrated']['social_icon'] );
				$is_new = empty( $item['social'] ) && $migration_allowed;
				$social = '';

				// add old default
				if ( empty( $item['social'] ) && ! $migration_allowed ) {
					$item['social'] = isset( $fallback_defaults[ $index ] ) ? $fallback_defaults[ $index ] : 'fa fa-wordpress';
				}

				if ( ! empty( $item['social'] ) ) {
					$social = str_replace( [ 'fa fa-', 'zy-' ], '', $item['social'] );
				}

				if ( ( $is_new || $migrated ) && 'svg' !== $item['social_icon']['library'] ) {
					$social = explode( ' ', $item['social_icon']['value'], 2 );
					if ( empty( $social[1] ) ) {
						$social = '';
					} else {
						$social = str_replace( [ 'fa-', 'zy-' ], '', $social[1] );
					}
				}

				if ( 'svg' === $item['social_icon']['library'] ) {
					$social = get_post_meta( $item['social_icon']['value']['id'], '_wp_attachment_image_alt', true );
				}

				$link_key = 'link_' . $index;

				$instance->add_render_attribute( $link_key, 'class', [
					'zyre-social-icon zy-inline-flex zy-align-stretch zy-gap-1 zy-c-pointer',
					'zyre-social-icon-' . $social . $class_animation,
					'elementor-repeater-item-' . $item['_id'],
				] );

				$instance->add_link_attributes( $link_key, $item['social_link'] );

				$social_name = esc_html( $item['social_name'] );
				?>
				<a <?php $instance->print_render_attribute_string( $link_key ); ?>>
					<span class="elementor-screen-only"><?php echo esc_html( ucwords( $social ) ); ?></span>
					<?php
					if ( $is_new || $migrated ) { ?>
						<span class="zyre-social-icon-holder zy-inline-flex zy-align-center"><?php Icons_Manager::render_icon( $item['social_icon'] ); ?></span>
					<?php } else { ?>
						<span class="zyre-social-icon-holder zy-inline-flex zy-align-center"><i class="<?php echo esc_attr( $item['social'] ); ?>"></i></span>
					<?php } ?>

					<?php if ( ! empty( $social_name ) && '' !== $social_name ) {
						echo '<span class="zyre-social-icon-label zy-inline-flex zy-align-center zy-w-100 zy-lh-1">' . $social_name . '</span>';
					} ?>
				</a>
				<?php
			}
			?>
		</div>
		<?php
	}
}
