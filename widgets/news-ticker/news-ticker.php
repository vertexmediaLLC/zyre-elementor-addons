<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use ZyreAddons\Elementor\Traits\Swiper_Trait;

defined( 'ABSPATH' ) || die();

class News_Ticker extends Base {

	use Swiper_Trait;

	/**
	 * Widget Name
	 */
	public function get_title() {
		return esc_html__( 'News Ticker', 'zyre-elementor-addons' );
	}

	/**
	 * Widget Icon
	 */
	public function get_icon() {
		return 'zy-fonticon zy-News-ticker';
	}

	/**
	 * Widget search keywords
	 */
	public function get_keywords() {
		return [ 'news ticker', 'news slider', 'news carousel', 'carousel', 'slider', 'content ticker', 'news', 'ticker', 'news scroll', 'trending news', 'hot news', 'content slider', 'content carousel' ];
	}

	protected function is_dynamic_content(): bool {
		return false;
	}

	public function get_style_depends(): array {
		return [ 'e-swiper' ];
	}

	public function get_script_depends(): array {
		return [ 'swiper' ];
	}

	/**
	 * Register widget content controls
	 */
	protected function register_content_controls() {
		$this->__news_ticker_general();
		$this->__news_ticker_settings();
	}

	/**
	 * Content - News Ticker General
	 */
	protected function __news_ticker_general() {
		$this->start_controls_section(
			'section_news_ticker_content',
			[
				'label' => esc_html__( 'News Ticker', 'zyre-elementor-addons' ),
			]
		);

		// Pre style
		$this->set_prestyle_controls();

		$this->add_control(
			'sticky_text',
			[
				'label' => esc_html__( 'Label', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Breaking', 'zyre-elementor-addons' ),
				'ai' => false,
			]
		);

		$this->add_control(
			'after_icon',
			[
				'label'        => esc_html__( 'Show Label Arrow', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'yes',
				'condition'    => [
					'sticky_text!' => '',
				],
			]
		);

		$post_types = [
			'post' => esc_html__( 'Posts', 'zyre-elementor-addons' ),
			'page' => esc_html__( 'Pages', 'zyre-elementor-addons' ),
		];

		$this->add_control(
			'query_source',
			[
				'label' => esc_html__( 'Post Type', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'post',
				'options' => $post_types,
			]
		);

		$this->add_control(
			'query_selection',
			[
				'label' => esc_html__( 'Selection Type', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'auto',
				'options' => [
					'auto' => esc_html__( 'Auto', 'zyre-elementor-addons' ),
					'manual' => esc_html__( 'Manual', 'zyre-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'choose_posts',
			[
				'label' => esc_html__( 'Post Selection', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'placeholder' => esc_html__( 'Search Post', 'zyre-elementor-addons' ),
				'options' => zyre_get_all_posts(),
				'condition' => [
					'query_source' => 'post',
					'query_selection' => 'manual',
				],
			]
		);

		$this->add_control(
			'choose_pages',
			[
				'label' => esc_html__( 'Page Selection', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'placeholder' => esc_html__( 'Search Page', 'zyre-elementor-addons' ),
				'options' => zyre_get_all_pages(),
				'condition' => [
					'query_source' => 'page',
					'query_selection' => 'manual',
				],
			]
		);

		$this->add_control(
			'query_posts',
			[
				'label' => esc_html__( 'Number of Post', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 10,
				'min' => 1,
				'condition' => [
					'query_selection' => 'auto',
				],
			]
		);

		$this->add_control(
			'query_offset',
			[
				'label' => esc_html__( 'Offset', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0,
				'min' => 0,
				'max' => 10,
				'condition' => [
					'query_selection' => 'auto',
				],
			]
		);

		$this->add_control(
			'post_order',
			[
				'label' => esc_html__( 'Order', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'ASC' => esc_html__( 'Ascending', 'zyre-elementor-addons' ),
					'DESC' => esc_html__( 'Descending', 'zyre-elementor-addons' ),
				],
				'condition' => [
					'query_selection' => 'auto',
				],
			]
		);

		$this->add_control(
			'post_orderby',
			[
				'label' => esc_html__( 'Order By', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date' => esc_html__( 'Date', 'zyre-elementor-addons' ),
					'modified' => esc_html__( 'Last Modified', 'zyre-elementor-addons' ),
					'rand' => esc_html__( 'Rand', 'zyre-elementor-addons' ),
					'title' => esc_html__( 'Title', 'zyre-elementor-addons' ),
					'ID' => esc_html__( 'Post ID', 'zyre-elementor-addons' ),
					'author' => esc_html__( 'Post Author', 'zyre-elementor-addons' ),
					'comment_count' => esc_html__( 'Comment Count', 'zyre-elementor-addons' ),
				],
				'condition' => [
					'query_selection' => 'auto',
				],
			]
		);

		$this->add_control(
			'ignore_sticky',
			[
				'label' => esc_html__( 'Ignore Sticky Post', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'No', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'query_selection' => 'auto',
				],
			]
		);

		$this->add_control(
			'show_thumbnail',
			[
				'label' => esc_html__( 'Show Thumbnail', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'show_meta',
			[
				'label' => esc_html__( 'Show Date', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Content - News Ticker Settings
	 */
	protected function __news_ticker_settings() {
		$this->start_controls_section(
			'section_animation_content',
			[
				'label' => esc_html__( 'Ticker Settings', 'zyre-elementor-addons' ),
			]
		);

		// Carousel Settings Controls
		$this->register_carousel_settings_controls(
			[
				'excludes'       => [ 'pagination', 'lazyload' ],
				'controls'       => [
					'navigation' => [
						'options' => [
							'arrows' => esc_html__( 'Arrows', 'zyre-elementor-addons' ),
							'none'   => esc_html__( 'None', 'zyre-elementor-addons' ),
						],
						'default' => 'none',
					],
					'effect'     => [
						'options' => [
							'slide' => esc_html__( 'Slide', 'zyre-elementor-addons' ),
							'fade'  => esc_html__( 'Fade', 'zyre-elementor-addons' ),
						],
						'alert'   => __( 'Set Default value from Style > Slide Item > Width', 'zyre-elementor-addons' ),
					],
				],
				'default_values' => [
					'speed'           => 5000,
					'slides_per_view' => '4',
					'autoplay_speed'  => 0,
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register styles related controls
	 */
	protected function register_style_controls() {
		$this->__wrapper_style();
		$this->__item_style();
		$this->__label_style();
		$this->__divider_style();
		$this->__post_thumbnail_style();
		$this->__post_title_style();
		$this->__post_meta_style();
		$this->__slide_navigation_style();
	}

	/**
	 * Style - Wrapper
	 */
	protected function __wrapper_style() {
		$this->start_controls_section(
			'section_wrap_style',
			[
				'label' => esc_html__( 'Wrapper', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'wrap',
			[
				'selector' => '{{WRAPPER}} .zyre-carousel-wrapper',
				'controls' => [
					'height'  => [
						'label'        => esc_html__( 'Min Height', 'zyre-elementor-addons' ),
						'selector'     => '{{WRAPPER}} .zyre-news-ticker',
						'css_property' => 'min-height',
					],
					'padding' => [],
					'margin'  => [],
				],
			]
		);

		$this->add_control(
			'swiper_transition',
			[
				'label' => esc_html__( 'Transition Effect', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'linear',
				'options' => [
					'ease'        => esc_html__( 'ease', 'zyre-elementor-addons' ),
					'linear'      => esc_html__( 'linear', 'zyre-elementor-addons' ),
					'ease-in'     => esc_html__( 'ease-in', 'zyre-elementor-addons' ),
					'ease-out'    => esc_html__( 'ease-out', 'zyre-elementor-addons' ),
					'ease-in-out' => esc_html__( 'ease-in-out', 'zyre-elementor-addons' ),
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-wrapper' => 'transition-timing-function: {{VALUE}};',
				],
				'render_type' => 'template',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style - Item
	 */
	protected function __item_style() {
		$this->start_controls_section(
			'section_item_style',
			[
				'label' => esc_html__( 'Slide Item', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'item_width',
			[
				'label'       => esc_html__( 'Width', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'auto',
				'options'     => [
					''     => esc_html__( 'Default', 'zyre-elementor-addons' ),
					'auto' => esc_html__( 'Auto', 'zyre-elementor-addons' ),
				],
				'render_type' => 'template',
				'selectors'   => [
					'{{WRAPPER}} .zyre-news-ticker-item' => 'width: {{VALUE}} !important;',
				],
			]
		);

		$this->set_style_controls(
			'item',
			[
				'selector' => '{{WRAPPER}} .zyre-news-ticker-item',
				'controls' => [
					'justify_content' => [
						'options' => [
							'flex-start' => [
								'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
								'icon'  => 'eicon-justify-start-h',
							],
							'center'     => [
								'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
								'icon'  => 'eicon-justify-center-h',
							],
							'flex-end'   => [
								'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
								'icon'  => 'eicon-justify-end-h',
							],
						],
						'default' => is_rtl() ? 'flex-end' : 'flex-start',
					],
					'alignment'       => [
						'default' => is_rtl() ? 'right' : 'left',
					],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style - Label
	 */
	protected function __label_style() {
		$this->start_controls_section(
			'sticky_title_style',
			[
				'label' => esc_html__( 'Label', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'sticky_text!' => '',
				],
			]
		);

		$this->set_style_controls(
			'sticky_title',
			[
				'selector' => '{{WRAPPER}} .zyre-news-ticker-label',
				'controls' => [
					'width'         => [
						'label'        => esc_html__( 'Min Width', 'zyre-elementor-addons' ),
						'css_property' => 'min-width',
					],
					'typography'    => [],
					'color'         => [],
					'bg_color'      => [],
					'padding'       => [],
					'spacing'       => [],
					'border'        => [],
					'border_radius' => [],
					'direction'     => [
						'selector' => '{{WRAPPER}} .zyre-news-ticker',
						'default'  => 'row',
					],
					'align_x'       => [
						'label'   => esc_html__( 'Alignment', 'zyre-elementor-addons' ),
						'options' => [
							'flex-start' => [
								'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
								'icon'  => 'eicon-justify-start-h',
							],
							'center'     => [
								'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
								'icon'  => 'eicon-justify-center-h',
							],
							'flex-end'   => [
								'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
								'icon'  => 'eicon-justify-end-h',
							],
						],
					],
				],
			]
		);

		$this->set_style_controls(
			'sticky_title_after',
			[
				'selector'  => '{{WRAPPER}} .zyre-news-ticker-label-arrow',
				'controls'  => [
					'heading'      => [
						'label'     => esc_html__( 'Label Arrow', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
					'width'        => [
						'label'        => esc_html__( 'Arrow Size', 'zyre-elementor-addons' ),
						'css_property' => '--border-width',
						'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
						'range' => [
							'px' => [
								'max'  => 100,
							],
							'em' => [
								'min'  => 0.1,
								'max'  => 3,
							],
							'rem' => [
								'min'  => 0.1,
								'max'  => 3,
							],
						],
					],
					'border_color' => [
						'label'        => esc_html__( 'Arrow Color', 'zyre-elementor-addons' ),
						'css_property' => is_rtl() ? 'border-right-color' : 'border-left-color',
					],
				],
				'condition' => [
					'after_icon' => 'yes',
				],
			],
		);

		$this->end_controls_section();
	}

	/**
	 * Style - Divider
	 */
	protected function __divider_style() {
		$this->start_controls_section(
			'section_post_divider_style',
			[
				'label' => esc_html__( 'Divider', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'slides_per_view!' => '1',
				],
			]
		);

		$this->set_style_controls(
			'post_item',
			[
				'selector' => '{{WRAPPER}} .zyre-news-ticker-item:not(:last-child) .zyre-news-ticker-item-container:after',
				'controls' => [
					'divider'      => [
						'default' => 'yes',
					],
					'border_width' => [
						'label'     => esc_html__( 'Weight', 'zyre-elementor-addons' ),
						'condition' => [
							'post_item_divider' => 'yes',
						],
					],
					'border_color' => [
						'label'        => esc_html__( 'Divider Color', 'zyre-elementor-addons' ),
						'css_property' => 'border-left-color',
						'condition'    => [
							'post_item_divider' => 'yes',
						],
					],
					'margin'       => [
						'condition' => [
							'post_item_divider' => 'yes',
						],
					],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style - Post Thumbnail
	 */
	protected function __post_thumbnail_style() {
		$this->start_controls_section(
			'section_post_thumbnail_style',
			[
				'label' => esc_html__( 'Thumbnail', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_thumbnail' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'post_thumbnail',
			[
				'selector' => '{{WRAPPER}} .zyre-news-ticker-item-img-wrap',
				'controls' => [
					'space' => [
						'css_property' => 'margin-inline-end',
					],
				],
			]
		);

		$this->set_style_controls(
			'post_thumbnail',
			[
				'selector' => '{{WRAPPER}} .zyre-news-ticker-item-img-wrap img',
				'controls' => [
					'width'         => [],
					'height'        => [],
					'bg_color'      => [],
					'padding'       => [],
					'border'        => [],
					'border_radius' => [],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style - Post Title
	 */
	protected function __post_title_style() {
		$this->start_controls_section(
			'section_post_title_style',
			[
				'label' => esc_html__( 'Post Title', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'post_title',
			[
				'selector' => '{{WRAPPER}} .zyre-news-ticker-item-title',
				'controls' => [
					'typography' => [],
				],
			]
		);

		// Tabs
		$this->start_controls_tabs( 'post_title_tabs' );

		$this->start_controls_tab(
			'post_title_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'post_title',
			[
				'selector' => '{{WRAPPER}} .zyre-news-ticker-item-link',
				'controls' => [
					'color'      => [],
				],
			]
		);

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab(
			'post_title_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'post_title_hover',
			[
				'selector' => '{{WRAPPER}} .zyre-news-ticker-item-link:hover',
				'controls' => [
					'color'         => [],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Style - Post Meta
	 */
	protected function __post_meta_style() {
		$this->start_controls_section(
			'section_post_meta_style',
			[
				'label' => esc_html__( 'Post Meta', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_meta' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'post_meta',
			[
				'selector' => '{{WRAPPER}} .zyre-news-ticker-item-meta',
				'controls' => [
					'typography' => [],
					'color'      => [],
					'space'      => [
						'label'        => esc_html__( 'Margin Bottom', 'zyre-elementor-addons' ),
						'css_property' => 'margin-bottom',
					],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style - Slide Navigation
	 */
	protected function __slide_navigation_style() {
		$this->start_controls_section(
			'section_slide_navigation_style',
			[
				'label' => esc_html__( 'Slider Navigation', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'navigation' => 'arrows',
				],
			]
		);

		$this->set_style_controls(
			'slide_navigation',
			[
				'selector' => '{{WRAPPER}} .zyre-swiper-button',
				'controls' => [
					'width'         => [
						'css_property' => '--width',
					],
					'space'         => [
						'label'        => esc_html__( 'Space Between', 'zyre-elementor-addons' ),
						'selector'     => '{{WRAPPER}} .zyre-swiper-button-prev',
						'css_property' => is_rtl() ? 'margin-inline-start' : 'margin-inline-end',
					],
					'border'        => [],
					'border_radius' => [],
					'font_size'     => [
						'label' => esc_html__( 'Arrow Size', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		// Tabs
		$this->start_controls_tabs( 'slide_navigation_tabs' );

		$this->start_controls_tab(
			'slide_navigation_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'slide_navigation',
			[
				'selector' => '{{WRAPPER}} .zyre-swiper-button',
				'controls' => [
					'icon_color' => [],
					'bg_color'   => [],
				],
			]
		);

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab(
			'slide_navigation_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'slide_navigation_hover',
			[
				'selector' => '{{WRAPPER}} .zyre-swiper-button:hover',
				'controls' => [
					'icon_color'   => [],
					'bg_color'     => [],
					'border_color' => [],
				],
			]
		);

		$this->end_controls_tab();

		// Tab: Disabled
		$this->start_controls_tab(
			'tab_slide_navigation_disabled',
			[
				'label'     => esc_html__( 'Disabled', 'zyre-elementor-addons' ),
				'condition' => [
					'loop!'      => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'slide_navigation_disabled',
			[
				'selector'  => '{{WRAPPER}} .zyre-swiper-button.swiper-button-disabled',
				'controls'  => [
					'icon_color'   => [],
					'bg_color'     => [],
					'border_color' => [],
				],
				'condition' => [
					'loop!'      => 'yes',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Register render display controls
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$ignore_sticky = false;
		if ( 'yes' === $settings['ignore_sticky'] || 'manual' === $settings['query_selection'] ) {
			$ignore_sticky = true;
		}

		$post_ids = [];
		if ( 'post' === $settings['query_source'] && ! empty( $settings['choose_posts'] ) ) {
			$post_ids = array_map( 'intval', (array) $settings['choose_posts'] );
		}

		if ( 'page' === $settings['query_source'] && ! empty( $settings['choose_pages'] ) ) {
			$post_ids = array_map( 'intval', (array) $settings['choose_pages'] );
		}
		$query_args = [
			'post_type'           => $settings['query_source'],
			'post_status'         => 'publish',
			'ignore_sticky_posts' => $ignore_sticky,
			'post__in'            => $post_ids,
			'offset'              => $settings['query_offset'],
			'orderby'             => $settings['post_orderby'],
			'order'               => $settings['post_order'],
		];

		if ( ! empty( $settings['query_posts'] ) && 'auto' === $settings['query_selection'] ) {
			$query_args['posts_per_page'] = (int) $settings['query_posts'];
		}

		$the_query = new \WP_Query( $query_args );

		$this->add_render_attribute(
			[
				'wrapper' => [
					'class'                => 'swiper zyre-carousel-wrapper zy-flex zy-ml-1 zy-mr-1',
					'role'                 => 'region',
					'aria-roledescription' => 'carousel',
					'aria-label'           => esc_attr__( 'Carousel', 'zyre-elementor-addons' ),
					'dir'                  => $settings['direction'],
				],
			]
		);
		?>
		<div class="zyre-news-ticker zy-flex">
		
			<?php if ( '' !== $settings['sticky_text'] ) : ?>
				<div class="zyre-news-ticker-label zy-relative zy-inline-flex zy-align-center zy-index-2">
					<?php echo esc_html( $settings['sticky_text'] ); ?>
					<?php if ( 'yes' === $settings['after_icon'] ) : ?>
					<span class="zyre-news-ticker-label-arrow zy-absolute zy-top-50 zy-<?php echo is_rtl() ? 'left' : 'right'; ?>-0"></span>
					<?php endif; ?>
				</div>				
			<?php endif; ?>

			<!-- Start Loop -->
			<?php
			if ( $the_query->have_posts() ) : ?>
			<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
				<ul class="zyre-news-ticker-list swiper-wrapper zy-list-none zy-w-auto">
					<?php while ( $the_query->have_posts() ) {
						$the_query->the_post();
						?>
						<li class="zyre-news-ticker-item swiper-slide zy-flex zy-align-center zy-gap-2">	
							<div class="zyre-news-ticker-item-container zy-inline-flex zy-align-center">
								<?php if ( has_post_thumbnail() && 'yes' === $settings['show_thumbnail'] ) : ?>
									<div class="zyre-news-ticker-item-img-wrap">
										<?php the_post_thumbnail(); ?>
									</div>
								<?php endif; ?>
								<div class="zyre-news-ticker-item-content-wrap">
									<?php if ( 'yes' === $settings['show_meta'] ) : ?>
									<p class="zyre-news-ticker-item-meta zy-m-0 zy-transition">
										<?php echo get_the_date( 'F d, l' ); ?>
									</p>
									<?php endif; ?>
									<h4 class="zyre-news-ticker-item-title zy-nowrap zy-m-0">
										<a href="<?php the_permalink(); ?>" class="zyre-news-ticker-item-link zy-transition"><?php the_title(); ?></a>
									</h4>
								</div>
							</div>
						</li>
					<?php } wp_reset_postdata(); ?>
				</ul>

				<!-- arrows -->
				<?php if ( 'arrows' === $settings['navigation'] ) : ?>
					<div class="zyre-swiper-button zyre-swiper-button-prev zy-h-100 zy-c-pointer zy-inline-flex zy-align-center zy-justify-center zy-transition zy-fs-1 zy-index-1 zy-absolute zy-top-0">
						<?php $this->render_swiper_button( 'previous' ); ?>
					</div>
					<div class="zyre-swiper-button zyre-swiper-button-next zy-h-100 zy-c-pointer zy-inline-flex zy-align-center zy-justify-center zy-transition zy-fs-1 zy-index-1 zy-absolute zy-top-0">
						<?php $this->render_swiper_button( 'next' ); ?>
					</div>
				<?php endif; ?>
			</div>
			<?php endif; ?>
			<!-- End Loop -->
		</div>
		<?php
	}

	private function render_swiper_button( $type ) {
		$direction = 'next' === $type ? 'right' : 'left';

		if ( is_rtl() ) {
			$direction = 'right' === $direction ? 'left' : 'right';
		}

		$icon_value = 'fas fa-chevron-' . $direction;

		Icons_Manager::render_icon( [
			'library' => 'fa-solid',
			'value' => $icon_value,
		], [ 'aria-hidden' => 'true' ] );
	}
}
