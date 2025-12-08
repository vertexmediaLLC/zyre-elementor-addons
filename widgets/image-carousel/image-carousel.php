<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use ZyreAddons\Elementor\Traits\Swiper_Trait;

defined( 'ABSPATH' ) || die();

/**
 * Image Carousel Widget
 *
 * @since 1.0.0
 */
class Image_Carousel extends Base {

	use Swiper_Trait;

	public function get_title() {
		return esc_html__( 'Image Carousel', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Image-carousel';
	}

	public function get_keywords() {
		return [ 'image carousel', 'image slider', 'image', 'slider', 'media carousel', 'media slider', 'media', 'logos', 'logo carousel', 'logo slider', 'content carousel', 'content slider' ];
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	protected function is_dynamic_content(): bool {
		return false;
	}

	public function get_style_depends(): array {
		return [ 'e-swiper' ];
	}

	protected function register_content_controls() {
		$this->start_controls_section(
			'section_carousel_content',
			[
				'label' => esc_html__( 'Carousel Content', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Pre style controls
		$this->set_prestyle_controls();

		$this->register_carousel_content_controls();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_carousel_settings',
			[
				'label' => esc_html__( 'Carousel Settings', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->register_carousel_settings_controls();

		$this->end_controls_section();
	}

	protected function register_style_controls() {
		$this->start_controls_section(
			'section_carousel_wrapper_style',
			[
				'label' => esc_html__( 'Wrapper', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'wrapper',
			[
				'selector' => '{{WRAPPER}} .zyre-carousel-wrapper',
				'controls' => [
					'height'            => [
						'condition' => [
							'content_overlay' => 'yes',
						],
					],
					'space'             => [
						'css_property' => 'padding-bottom',
						'condition'    => [
							'navigation' => [ 'both', 'dots' ],
						],
					],
				],
			]
		);

		$this->add_control(
			'swiper_transition',
			[
				'label' => esc_html__( 'Transition Effect', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'ease',
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

		// Section: Navigation
		$this->start_controls_section(
			'section_navigation_style',
			[
				'label' => esc_html__( 'Navigation', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->set_style_controls(
			'arrows',
			[
				'selector'  => '{{WRAPPER}} .zyre-swiper-button',
				'controls'  => [
					'options'       => [
						'label'        => esc_html__( 'Position', 'zyre-elementor-addons' ),
						'default'      => 'inside',
						'options'      => [
							'inside'  => esc_html__( 'Inside', 'zyre-elementor-addons' ),
							'outside' => esc_html__( 'Outside', 'zyre-elementor-addons' ),
						],
						'prefix_class' => 'zyre-image-carousel-arrows-position-',
					],
					'font_size'     => [
						'label'        => esc_html__( 'Size', 'zyre-elementor-addons' ),
						'selector'     => '{{WRAPPER}}  .zyre-carousel-wrapper',
						'css_property' => '--icon-size',
					],
					'padding'       => [],
					'border'        => [],
					'border_radius' => [],
				],
			]
		);

		// Tabs
		$this->start_controls_tabs( 'tabs_arrows_colors' );

		// Tab: Normal
		$this->start_controls_tab(
			'tab_arrows_color_normal',
			[
				'label'     => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'arrows',
			[
				'selector'  => '{{WRAPPER}} .zyre-swiper-button',
				'controls'  => [
					'bg_color'   => [],
					'icon_color' => [],
					'box_shadow' => [],
				],
			]
		);

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab(
			'tab_arrows_color_hover',
			[
				'label'     => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'arrows_hover',
			[
				'selector'  => '{{WRAPPER}} .zyre-swiper-button:hover',
				'controls'  => [
					'bg_color'     => [],
					'icon_color'   => [],
					'border_color' => [],
					'box_shadow'   => [],
				],
			]
		);

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab(
			'tab_arrows_color_disabled',
			[
				'label'     => esc_html__( 'Disabled', 'zyre-elementor-addons' ),
				'condition' => [
					'loop!'      => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'arrows_disabled',
			[
				'selector'  => '{{WRAPPER}} .zyre-swiper-button.swiper-button-disabled',
				'controls'  => [
					'bg_color'     => [],
					'icon_color'   => [],
					'border_color' => [],
				],
				'condition' => [
					'loop!'      => 'yes',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->set_style_controls(
			'arrows_prev',
			[
				'selector' => '{{WRAPPER}} .zyre-swiper-button-prev',
				'controls' => [
					'margin' => [
						'label'     => esc_html__( 'Prev Arrow Margin', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
				],
			]
		);

		$this->set_style_controls(
			'arrows_next',
			[
				'selector' => '{{WRAPPER}} .zyre-swiper-button-next',
				'controls' => [
					'margin' => [
						'label' => esc_html__( 'Next Arrow Margin', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->end_controls_section();

		// Section: Pagination
		$this->start_controls_section(
			'section_pagination_style',
			[
				'label'     => esc_html__( 'Pagination', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'navigation'  => [ 'dots', 'both' ],
					'pagination!' => '',
				],
			]
		);

		$this->set_style_controls(
			'dots',
			[
				'selector'  => '{{WRAPPER}} .swiper-pagination-bullet',
				'controls'  => [
					'width_height' => [
						'range' => [
							'px' => [
								'max' => 100,
							],
						],
					],
					'bg_color'     => [
						'label' => esc_html__( 'Active Color', 'zyre-elementor-addons' ),
					],
					'margin'       => [],
				],
				'condition' => [
					'pagination' => 'bullets',
				],
			]
		);

		$this->set_style_controls(
			'dots_active',
			[
				'selector' => '{{WRAPPER}} .swiper-pagination-bullet:not(.swiper-pagination-bullet-active)',
				'controls' => [
					'bg_color' => [
						'label' => esc_html__( 'Color', 'zyre-elementor-addons' ),
					],
					'opacity'  => [],
				],
				'condition' => [
					'pagination' => 'bullets',
				],
			]
		);

		$this->set_style_controls(
			'dots_hover',
			[
				'selector' => '{{WRAPPER}} .swiper-pagination-bullet:not(.swiper-pagination-bullet-active):hover',
				'controls' => [
					'bg_color' => [
						'label' => esc_html__( 'Hover Color', 'zyre-elementor-addons' ),
					],
				],
				'condition' => [
					'pagination' => 'bullets',
				],
			]
		);

		// Fraction
		$this->set_style_controls(
			'fraction',
			[
				'selector'  => '{{WRAPPER}} .swiper-pagination-fraction',
				'controls'  => [
					'typography' => [
						'label' => esc_html__( 'Typography', 'zyre-elementor-addons' ),
					],
					'color'      => [
						'label' => esc_html__( 'Fraction Color', 'zyre-elementor-addons' ),
					],
				],
				'condition' => [
					'pagination' => 'fraction',
				],
			]
		);

		$this->set_style_controls(
			'fraction_current',
			[
				'selector'  => '{{WRAPPER}} .swiper-pagination-current',
				'controls'  => [
					'color' => [
						'label' => esc_html__( 'Current Color', 'zyre-elementor-addons' ),
					],
				],
				'condition' => [
					'pagination' => 'fraction',
				],
			]
		);

		$this->set_style_controls(
			'fraction_total',
			[
				'selector'  => '{{WRAPPER}} .swiper-pagination-total',
				'controls'  => [
					'color' => [
						'label' => esc_html__( 'Total Color', 'zyre-elementor-addons' ),
					],
				],
				'condition' => [
					'pagination' => 'fraction',
				],
			]
		);

		// Progress Bar
		$this->set_style_controls(
			'progressbar',
			[
				'selector'  => '{{WRAPPER}} .swiper-pagination-progressbar',
				'controls'  => [
					'bg_color' => [
						'label' => esc_html__( 'Progress Bar Color', 'zyre-elementor-addons' ),
					],
				],
				'condition' => [
					'pagination' => 'progressbar',
				],
			]
		);

		$this->set_style_controls(
			'progressbar_fill',
			[
				'selector'  => '{{WRAPPER}} .swiper-pagination-progressbar-fill',
				'controls'  => [
					'bg_color' => [
						'label' => esc_html__( 'Progress Fill Color', 'zyre-elementor-addons' ),
					],
				],
				'condition' => [
					'pagination' => 'progressbar',
				],
			]
		);

		$this->end_controls_section();

		// Section: Content
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
				'selector' => '{{WRAPPER}} .zyre-carousel-content',
				'controls' => [
					'background' => [],
					'padding'    => [],
					'height'     => [
						'size_units' => [ '%', 'px' ],
						'default' => [
							'unit' => '%',
						],
						'condition' => [
							'content_overlay' => 'yes',
						],
					],
					'align_y'    => [
						'css_property' => 'align-content',
						'condition'    => [
							'content_overlay' => 'yes',
						],
					],
					'align' => [],
				],
			]
		);

		$this->set_style_controls(
			'content_title',
			[
				'selector' => '{{WRAPPER}} .zyre-carousel-title',
				'controls' => [
					'heading' => [
						'label' => esc_html__( 'Title', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
					'typography' => [],
					'color'  => [],
					'space'  => [],
				],
			]
		);

		$this->set_style_controls(
			'content_subtitle',
			[
				'selector' => '{{WRAPPER}} .zyre-carousel-subtitle',
				'controls' => [
					'heading' => [
						'label' => esc_html__( 'Sub Title', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
					'typography' => [],
					'color'  => [],
					'space'  => [],
				],
			]
		);

		// Image
		$this->set_style_controls(
			'content_image',
			[
				'selector' => '{{WRAPPER}} .zyre-carousel-image',
				'controls' => [
					'heading'       => [
						'label'     => esc_html__( 'Image', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
					'object_fit'    => [
						'default' => 'cover',
						'label'   => esc_html__( 'Fit Image as', 'zyre-elementor-addons' ),
					],
					'border'        => [],
					'border_radius' => [],
					'padding'       => [],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$this->render_html();
	}
}
