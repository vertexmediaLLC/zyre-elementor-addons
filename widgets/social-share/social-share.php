<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Social_Share extends Base {

	public function get_title() {
		return esc_html__( 'Social Share', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Social-button';
	}

	public function get_keywords() {
		return [ 'social', 'share', 'social share', 'icons', 'social icons', 'social links', 'links', 'facebook', 'fb', 'twitter', 'linkedin', 'pinterest', 'telegram', 'whatsapp' ];
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	private static function get_network_icon_data( $network_name ) {
		$networks_class_dictionary = [
			'pocket' => [
				'value' => 'fa fa-get-pocket',
			],
			'email' => [
				'value' => 'fa fa-envelope',
			],
		];

		$networks_icon_mapping = [
			'pocket' => [
				'value' => 'fab fa-get-pocket',
				'library' => 'fa-brands',
			],
			'email' => [
				'value' => 'fas fa-envelope',
				'library' => 'fa-solid',
			],
			'print' => [
				'value' => 'fas fa-print',
				'library' => 'fa-solid',
			],
		];

		$prefix = 'fa ';
		$library = '';

		if ( Icons_Manager::is_migration_allowed() ) {
			if ( isset( $networks_icon_mapping[ $network_name ] ) ) {
				return $networks_icon_mapping[ $network_name ];
			}
			$prefix = 'fab ';
			$library = 'fa-brands';
		}

		if ( isset( $networks_class_dictionary[ $network_name ] ) ) {
			return $networks_class_dictionary[ $network_name ];
		}

		return [
			'value' => $prefix . 'fa-' . $network_name,
			'library' => $library,
		];
	}

	public static function get_networks( $network_name = null ) {
		$networks = [
			'facebook-f' => [
				'title' => 'Facebook',
				'has_counter' => true,
			],
			'x-twitter' => [
				'title' => 'X (Twitter)',
			],
			'linkedin-in' => [
				'title' => 'LinkedIn',
				'has_counter' => true,
			],
			'pinterest-p' => [
				'title' => 'Pinterest',
				'has_counter' => true,
			],
			'reddit' => [
				'title' => 'Reddit',
				'has_counter' => true,
			],
			'vk' => [
				'title' => 'VK',
				'has_counter' => true,
			],
			'odnoklassniki' => [
				'title' => 'OK',
				'has_counter' => true,
			],
			'tumblr' => [
				'title' => 'Tumblr',
			],
			'digg' => [
				'title' => 'Digg',
			],
			'skype' => [
				'title' => 'Skype',
			],
			'stumbleupon' => [
				'title' => 'StumbleUpon',
				'has_counter' => true,
			],
			'mix' => [
				'title' => 'Mix',
			],
			'telegram' => [
				'title' => 'Telegram',
			],
			'pocket' => [
				'title' => 'Pocket',
				'has_counter' => true,
			],
			'xing' => [
				'title' => 'XING',
				'has_counter' => true,
			],
			'whatsapp' => [
				'title' => 'WhatsApp',
			],
			'email' => [
				'title' => 'Email',
			],
			'print' => [
				'title' => 'Print',
			],
			'twitter' => [
				'title' => 'Twitter',
			],
			'threads' => [
				'title' => 'Threads',
			],
		];

		if ( $network_name ) {
			return $networks[ $network_name ] ?? null;
		}

		return $networks;
	}

	protected function register_content_controls() {
		$this->start_controls_section(
			'section_share_content',
			[
				'label' => esc_html__( 'Social Share Content', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$repeater = new Repeater();

		$networks = self::get_networks();
		$networks_names = array_keys( $networks );

		$repeater->add_control(
			'share_network',
			[
				'label' => esc_html__( 'Network', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'facebook-f',
				'options' => array_reduce( $networks_names, function ( $options, $network_name ) use ( $networks ) {
					$options[ $network_name ] = $networks[ $network_name ]['title'];

					return $options;
				}, [] ),
			]
		);

		$repeater->add_control(
			'share_label',
			[
				'label'     => esc_html__( 'Custom Label', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'hashtags',
			[
				'label'       => esc_html__( 'Hashtags', 'zyre-elementor-addons' ),
				'description' => esc_html__( 'Write hashtags without # sign and with comma separated value', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'      => 2,
				'dynamic'     => [
					'active' => true,
				],
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'share_network',
							'operator' => '!==',
							'value' => 'facebook-f',
						],
						[
							'name' => 'share_network',
							'operator' => '!==',
							'value' => 'linkedin-in',
						],
						[
							'name' => 'share_network',
							'operator' => '!==',
							'value' => 'whatsapp',
						],
						[
							'name' => 'share_network',
							'operator' => '!==',
							'value' => 'reddit',
						],
						[
							'name' => 'share_network',
							'operator' => '!==',
							'value' => 'skype',
						],
						[
							'name' => 'share_network',
							'operator' => '!==',
							'value' => 'pinterest-p',
						],
						[
							'name' => 'share_network',
							'operator' => '!==',
							'value' => 'email',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'share_title',
			[
				'label'     => esc_html__( 'Custom Title', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXTAREA,
				'rows'      => 2,
				'dynamic'   => [
					'active' => true,
				],
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'share_network',
							'operator' => '!==',
							'value' => 'facebook-f',
						],
						[
							'name' => 'share_network',
							'operator' => '!==',
							'value' => 'linkedin-in',
						],
						[
							'name' => 'share_network',
							'operator' => '!==',
							'value' => 'reddit',
						],
						[
							'name' => 'share_network',
							'operator' => '!==',
							'value' => 'skype',
						],
						[
							'name' => 'share_network',
							'operator' => '!==',
							'value' => 'pinterest-p',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'email_to',
			[
				'label'     => esc_html__( 'To', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'label_block' => true,
				'condition' => [
					'share_network' => 'email',
				],
			]
		);

		$repeater->add_control(
			'email_subject',
			[
				'label'     => esc_html__( 'Subject', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'label_block' => true,
				'condition' => [
					'share_network' => 'email',
				],
			]
		);

		$repeater->add_control(
			'twitter_handle',
			[
				'label'     => esc_html__( 'Twitter Handle', 'zyre-elementor-addons' ),
				'description' => esc_html__( 'Write without @ sign.', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => [
					'share_network' => [ 'x-twitter', 'twitter' ],
				],
			]
		);

		$repeater->add_control(
			'share_image',
			[
				'type' => Controls_Manager::MEDIA,
				'label' => esc_html__( 'Custom Image', 'zyre-elementor-addons' ),
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'share_network' => 'pinterest-p',
				],
			]
		);

		$repeater->add_control(
			'customize',
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
			'tabs_share_colors',
			[
				'condition' => [ 'customize' => 'yes' ],
			]
		);

		// Normal Tab
		$repeater->start_controls_tab(
			'tab_share_color_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$repeater->add_control(
			'share_color',
			[
				'label' => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'  => Controls_Manager::COLOR,

				'selectors'      => [
					'{{WRAPPER}} .zyre-share-wrapper > {{CURRENT_ITEM}}.zyre-share-item' => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-share-wrapper > {{CURRENT_ITEM}}.zyre-share-item svg' => 'fill: {{VALUE}};',
				],
				'condition'      => [ 'customize' => 'yes' ],
				'style_transfer' => true,
			]
		);

		$repeater->add_control(
			'share_bg_color',
			[
				'label'          => esc_html__( 'Background Color', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::COLOR,
				'selectors'      => [
					'{{WRAPPER}} .zyre-share-wrapper > {{CURRENT_ITEM}}.zyre-share-item' => 'background-color: {{VALUE}};',
				],
				'condition'      => [ 'customize' => 'yes' ],
				'style_transfer' => true,
			]
		);

		$repeater->add_control(
			'share_border_color',
			[
				'label'          => esc_html__( 'Border Color', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::COLOR,
				'condition'      => [ 'customize' => 'yes' ],
				'style_transfer' => true,
				'selectors'      => [
					'{{WRAPPER}} .zyre-share-wrapper > {{CURRENT_ITEM}}.zyre-share-item' => 'border-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'share_separator_color',
			[
				'label'          => esc_html__( 'Separator Color', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::COLOR,
				'condition'      => [
					'customize' => 'yes',
				],
				'style_transfer' => true,
				'selectors'      => [
					'{{WRAPPER}} .zyre-share-wrapper > {{CURRENT_ITEM}}.zyre-share-item .zyre-share-item-label' => 'border-color: {{VALUE}};',
				],
			]
		);

		$repeater->end_controls_tab();

		// Hover Tab
		$repeater->start_controls_tab(
			'tab_share_color_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$repeater->add_control(
			'share_icon_color_hover',
			[
				'label' => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'  => Controls_Manager::COLOR,

				'selectors'      => [
					'{{WRAPPER}} .zyre-share-wrapper > {{CURRENT_ITEM}}.zyre-share-item:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-share-wrapper > {{CURRENT_ITEM}}.zyre-share-item:hover svg' => 'fill: {{VALUE}};',
				],
				'condition'      => [ 'customize' => 'yes' ],
				'style_transfer' => true,
			]
		);

		$repeater->add_control(
			'share_bg_color_hover',
			[
				'label'          => esc_html__( 'Background Color', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::COLOR,
				'selectors'      => [
					'{{WRAPPER}} .zyre-share-wrapper > {{CURRENT_ITEM}}.zyre-share-item:hover' => 'background-color: {{VALUE}};',
				],
				'condition'      => [ 'customize' => 'yes' ],
				'style_transfer' => true,
			]
		);

		$repeater->add_control(
			'share_border_color_hover',
			[
				'label'          => esc_html__( 'Border Color', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::COLOR,
				'condition'      => [ 'customize' => 'yes' ],
				'style_transfer' => true,
				'selectors'      => [
					'{{WRAPPER}} .zyre-share-wrapper > {{CURRENT_ITEM}}.zyre-share-item:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'share_separator_color_hover',
			[
				'label'          => esc_html__( 'Separator Color', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::COLOR,
				'condition'      => [ 'customize' => 'yes' ],
				'style_transfer' => true,
				'selectors'      => [
					'{{WRAPPER}} .zyre-share-wrapper > {{CURRENT_ITEM}}.zyre-share-item:hover .zyre-share-item-label' => 'border-color: {{VALUE}};',
				],
			]
		);

		$repeater->end_controls_tab();
		$repeater->end_controls_tabs();

		$repeater->add_responsive_control(
			'share_icon_size',
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
					'{{WRAPPER}} .zyre-share-wrapper > {{CURRENT_ITEM}}.zyre-share-item'   => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'share_items',
			[
				'label'       => esc_html__( 'Share Items', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default' => [
					[
						'share_network' => 'facebook-f',
					],
					[
						'share_network' => 'x-twitter',
					],
					[
						'share_network' => 'linkedin-in',
					],
					[
						'share_network' => 'pinterest-p',
					],
				],
				'title_field' => '{{ share_network }}',
			]
		);

		$this->add_control(
			'share_url_type',
			[
				'label' => esc_html__( 'Target URL', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'current_page' => esc_html__( 'Current Page', 'zyre-elementor-addons' ),
					'custom' => esc_html__( 'Custom', 'zyre-elementor-addons' ),
				],
				'default' => 'current_page',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'share_url',
			[
				'label' => esc_html__( 'URL', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'options' => false,
				'condition' => [
					'share_url_type' => 'custom',
				],
				'show_label' => false,
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'share_view',
			[
				'label'        => esc_html__( 'View', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => [
					'icon-text' => esc_html__( 'Icon and Text', 'zyre-elementor-addons' ),
					'icon'      => esc_html__( 'Icon', 'zyre-elementor-addons' ),
					'text'      => esc_html__( 'Text', 'zyre-elementor-addons' ),
				],
				'default'      => 'icon',
				'separator'    => 'before',
				'prefix_class' => 'zyre-social-share--view-',
				'render_type'  => 'template',
			]
		);

		$this->add_responsive_control(
			'share_columns',
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
			'share_align',
			[
				'label'        => esc_html__( 'Alignment', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::CHOOSE,
				'default'      => 'center',
				'options'      => [
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
				'prefix_class' => 'zyre-social-share%s--align-',
				'selectors_dictionary' => [
					'left'   => 'text-align: left; justify-items: flex-start;',
					'center' => 'text-align: center; justify-items: center;',
					'right'  => 'text-align: right; justify-items: flex-end;',
				],
				'selectors'    => [
					'{{WRAPPER}} .zyre-share-wrapper' => '{{VALUE}}',
				],
				'render_type'  => 'ui',
			]
		);

		$left_right = is_rtl() ? 'right' : 'left';
		$this->add_control(
			'share_separator',
			[
				'label'          => esc_html__( 'Show Separator', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::SWITCHER,
				'return_value'   => 'yes',
				'style_transfer' => true,
				'selectors'      => [
					'{{WRAPPER}} .zyre-share-item-label' => "border-{$left_right}-width: 1px;border-{$left_right}-style: solid;border-{$left_right}-color: initial;",
				],
				'condition'      => [
					'share_view' => 'icon-text',
				],
			]
		);

		$this->add_control(
			'social_share_css_class',
			[
				'label'       => esc_html__( 'Class', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Class Name', 'zyre-elementor-addons' ),
				'prefix_class' => '',
				'separator'   => 'before',
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_controls() {
		$this->__general_style_controls();
		$this->__icon_style_controls();
		$this->__share_label_style_controls();
	}

	protected function __general_style_controls() {
		$this->start_controls_section(
			'section_general_style',
			[
				'label' => esc_html__( 'General', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Tabs
		$this->start_controls_tabs(
			'tabs_all_share_colors'
		);

		// Normal Tab
		$this->start_controls_tab(
			'tab_all_share_color_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'all_share_color',
			[
				'label' => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'  => Controls_Manager::COLOR,

				'selectors'      => [
					'{{WRAPPER}} .zyre-share-wrapper > .zyre-share-item' => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-share-wrapper > .zyre-share-item svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->set_style_controls(
			'all_share',
			[
				'selector' => '{{WRAPPER}} .zyre-share-wrapper > .zyre-share-item',
				'controls' => [
					'bg_color'     => [],
					'border_color' => [],
					'box_shadow'   => [],
				],
			]
		);

		$this->add_control(
			'all_share_separator_color',
			[
				'label'          => esc_html__( 'Separator Color', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::COLOR,
				'condition'      => [
					'share_separator' => 'yes',
					'share_view' => 'icon-text',
				],
				'selectors'      => [
					'{{WRAPPER}} .zyre-share-wrapper > .zyre-share-item .zyre-share-item-label' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'tab_all_share_color_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'all_share_color_hover',
			[
				'label' => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'  => Controls_Manager::COLOR,

				'selectors'      => [
					'{{WRAPPER}} .zyre-share-wrapper > .zyre-share-item:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-share-wrapper > .zyre-share-item:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->set_style_controls(
			'all_share_hover',
			[
				'selector' => '{{WRAPPER}} .zyre-share-wrapper > .zyre-share-item:hover',
				'controls' => [
					'bg_color'     => [],
					'border_color' => [],
					'box_shadow'   => [],
				],
			]
		);

		$this->add_control(
			'all_share_separator_color_hover',
			[
				'label'          => esc_html__( 'Separator Color', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::COLOR,
				'condition'      => [
					'share_separator' => 'yes',
					'share_view' => 'icon-text',
				],
				'selectors'      => [
					'{{WRAPPER}} .zyre-share-wrapper > .zyre-share-item:hover .zyre-share-item-label' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'share_gap',
			[
				'label'      => esc_html__( 'Spacing', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'separator'  => 'before',
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
			'share_row_gap',
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
			'all_share_width',
			[
				'label' => esc_html__( 'Item Width', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
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
					'{{WRAPPER}} .zyre-share-wrapper > .zyre-share-item' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'all_share_height',
			[
				'label'      => esc_html__( 'Item Height', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', '%', 'em', 'rem', 'vh', 'custom'],
				'range'      => [
					'px'  => [
						'max' => 500,
					],
					'%'   => [
						'max' => 100,
					],
					'em'  => [
						'max' => 20,
					],
					'rem' => [
						'max' => 20,
					],
				],
				'default'    => [
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-share-wrapper > .zyre-share-item' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$left_right = is_rtl() ? 'right' : 'left';
		$this->add_control(
			'share_separator_width',
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
				'condition'      => [
					'share_separator' => 'yes',
					'share_view' => 'icon-text',
				],
				'selectors'      => [
					'{{WRAPPER}} .zyre-share-wrapper > .zyre-share-item .zyre-share-item-label' => "border-{$left_right}-width: {{SIZE}}{{UNIT}};",
				],
			]
		);

		$this->set_style_controls(
			'share',
			[
				'selector' => '{{WRAPPER}} .zyre-share-wrapper > .zyre-share-item',
				'controls' => [
					'border'        => [],
					'border_radius' => [],
					'padding'       => [],
				],
			]
		);

		$this->add_responsive_control(
			'share_items_align',
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
					'{{WRAPPER}} .zyre-share-wrapper > .zyre-share-item' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __icon_style_controls() {
		$this->start_controls_section(
			'section_icon_style',
			[
				'label'     => esc_html__( 'Icon', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'share_view' => [ 'icon-text', 'icon' ],
				],
			]
		);

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
					'{{WRAPPER}} .zyre-share-wrapper > .zyre-share-item'   => 'font-size: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .zyre-share-icon-holder' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __share_label_style_controls() {
		$this->start_controls_section(
			'section_share_label_style',
			[
				'label' => esc_html__( 'Label', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'share_view' => [ 'icon-text', 'text' ],
				],
			]
		);

		$this->set_style_controls(
			'share_label',
			[
				'selector' => '{{WRAPPER}} .zyre-share-item-label',
				'controls' => [
					'typography' => [],
					'color'      => [],
					'padding'    => [],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['share_items'] ) ) {
			return;
		}

		$class_animation = '';

		if ( ! empty( $settings['icon_hover_animation'] ) ) {
			$class_animation = 'elementor-animation-' . $settings['icon_hover_animation'];
		}
		?>
		<div class="zyre-share-wrapper elementor-grid zy-align-center">
			<?php
			$networks_data = self::get_networks();

			$url = get_the_permalink();
			$share_url_type = $settings['share_url_type'];
			$custom_share_url = $settings['share_url'];
			$share_url = ( ! empty( $share_url_type ) && 'custom' === $share_url_type ) ? $custom_share_url : $url;

			foreach ( $settings['share_items'] as $index => $item ) {
				$network_name = $item['share_network'];

				// A deprecated network.
				if ( ! isset( $networks_data[ $network_name ] ) ) {
					continue;
				}

				$hashtags = $item['hashtags'];
				$custom_share_title = esc_html( $item['share_title'] );
				$twitter_handle = $item['twitter_handle'];
				$image = isset( $item['share_image']['url'] ) ? $item['share_image']['url'] : '';
				$email_to = $item['email_to'];
				$email_subject = $item['email_subject'];

				$link_attr = 'link_' . $index;

				$this->set_render_attribute( $link_attr, 'class', [
					'zyre-share-item zy-inline-flex zy-align-stretch zy-gap-1 zy-c-pointer',
					'zyre-share-item_' . $network_name,
					$class_animation,
					'elementor-repeater-item-' . $item['_id'],
				] );

				$this->set_render_attribute( $link_attr, 'data-sharer', esc_attr( $network_name ) );
				$this->set_render_attribute( $link_attr, 'data-url', $share_url );
				$this->set_render_attribute( $link_attr, 'data-hashtags', $hashtags ? esc_html( $hashtags ) : '' );
				$this->set_render_attribute( $link_attr, 'data-title', $custom_share_title );
				$this->set_render_attribute( $link_attr, 'data-image', esc_url( $image ) );
				$this->set_render_attribute( $link_attr, 'data-to', esc_attr( $email_to ) );
				$this->set_render_attribute( $link_attr, 'data-subject', esc_attr( $email_subject ) );
				?>
				<a <?php $this->print_render_attribute_string( $link_attr ); ?>>
					<?php if ( 'icon' === $settings['share_view'] || 'icon-text' === $settings['share_view'] ) : ?>
						<span class="zyre-share-icon-holder zy-inline-flex zy-align-center"><?php self::render_share_icon( $network_name ); ?></span>
					<?php endif; ?>

					<?php if ( 'text' === $settings['share_view'] || 'icon-text' === $settings['share_view'] ) : ?>
						<span class="zyre-share-item-label zy-inline-flex zy-align-center zy-w-100 zy-lh-1">
							<?php echo zyre_kses_basic( ! empty( $item['share_label'] ) ? $item['share_label'] : $networks_data[ $network_name ]['title'] ); ?>
						</span>
					<?php endif; ?>
				</a>
				<?php
			}
			?>
		</div>
		<?php
	}

	private static function render_share_icon( $network_name ) {
		$network_icon_data = self::get_network_icon_data( $network_name );

		if ( Icons_Manager::is_migration_allowed() ) {
			$icon = Icons_Manager::render_font_icon( $network_icon_data );
		} else {
			$icon = sprintf( '<i class="%s" aria-hidden="true"></i>', esc_attr( $network_icon_data['value'] ) );
		}

		Utils::print_unescaped_internal_string( $icon );
	}
}
