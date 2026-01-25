<?php
namespace ZyreAddons\Elementor\Traits;

use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

trait Swiper_Trait {

	private $slide_prints_count = 0;

	/**
	 * Register content controls.
	 *
	 * @param array $args {
	 *     Optional. An array of arguments for adjusting the controls.
	 *
	 *     @type string id_prefix     Prefix for the control IDs.
	 *     @type string slides_label     Label of the slides items. Default 'Slide Items'.
	 *     @type bool   prevent_empty Whether to prevent empty items. Default false.
	 *     @type array   default_icon The default icon. Default 'fa-heart'.
	 *     @type array   default_slides The default slides items. Default 8 placeholder images.
	 * }
	 */
	protected function register_carousel_content_controls( $args = [] ) {
		$placeholder_img = [
			'image' => [
				'url' => Utils::get_placeholder_image_src(),
			],
		];

		$default_args = [
			'controls'          => [ 'thumbnail', 'title_tag', 'content_overlay' ],
			'repeater_controls' => [ 'image', 'title', 'subtitle', 'link' ],
			'slides_label'      => __( 'Slide Items', 'zyre-elementor-addons' ),
			'prevent_empty'     => false,
			'default_icon'      => [
				'value'   => 'far fa-heart',
				'library' => 'fa-regular',
			],
			'default_slides'    => array_fill( 0, 7, $placeholder_img ),
		];

		$args = wp_parse_args( $args, $default_args );

		// Repeater Controls
		if ( ! empty( $args['repeater_controls'] ) && is_array( $args['repeater_controls'] ) ) :
			$repeater = new Repeater();

			foreach ( $args['repeater_controls'] as $rp_control_id ) :
				switch ( $rp_control_id ) {
					case 'image':
						$repeater->add_control(
							'image',
							[
								'label'     => esc_html__( 'Image', 'zyre-elementor-addons' ),
								'type'      => Controls_Manager::MEDIA,
								'dynamic'   => [
									'active' => true,
								],
								'default'   => [
									'url' => Utils::get_placeholder_image_src(),
								],
							]
						);
						break;

					case 'title':
						$repeater->add_control(
							'title',
							[
								'label'       => esc_html__( 'Title', 'zyre-elementor-addons' ),
								'label_block' => true,
								'type'        => Controls_Manager::TEXT,
								'placeholder' => esc_attr__( 'Type Title Text', 'zyre-elementor-addons' ),
							]
						);
						break;

					case 'subtitle':
						$repeater->add_control(
							'subtitle',
							[
								'label'       => esc_html__( 'Sub Title', 'zyre-elementor-addons' ),
								'label_block' => true,
								'type'        => Controls_Manager::TEXTAREA,
								'rows'        => 2,
								'placeholder' => esc_attr__( 'Type Sub Title Text', 'zyre-elementor-addons' ),
								'dynamic'     => [
									'active' => true,
								],
							]
						);
						break;

					case 'link':
						$repeater->add_control(
							'link',
							[
								'label'       => esc_html__( 'Link', 'zyre-elementor-addons' ),
								'type'        => Controls_Manager::URL,
								'label_block' => true,
								'placeholder' => 'https://example.com',
								'dynamic'     => [
									'active' => true,
								],
							]
						);
						break;
				}
			endforeach;

			$this->add_control(
				'slides',
				[
					'label'       => esc_html( $args['slides_label'] ),
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'default'     => $args['default_slides'],
					'title_field' => ! empty( $repeater->get_controls()['title'] ) ? '<# print(title || "Slide Item"); #>' : '<# print("Slide Item"); #>',
				]
			);
		endif;

		// Controls
		if ( ! empty( $args['controls'] ) && is_array( $args['controls'] ) ) :
			foreach ( $args['controls'] as $control_id ) :
				switch ( $control_id ) {
					case 'thumbnail':
						if ( in_array( 'image', $args['repeater_controls'], true ) ) {
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
						break;

					case 'title_tag':
						$this->add_control(
							'title_tag',
							[
								'label'   => esc_html__( 'Title HTML Tag', 'zyre-elementor-addons' ),
								'type'    => Controls_Manager::SELECT,
								'options' => [
									'h1'   => 'H1',
									'h2'   => 'H2',
									'h3'   => 'H3',
									'h4'   => 'H4',
									'h5'   => 'H5',
									'h6'   => 'H6',
									'div'  => 'div',
									'span' => 'span',
									'p'    => 'p',
								],
								'default' => 'h3',
							]
						);
						break;

					case 'content_overlay':
						$this->add_control(
							'content_overlay',
							[
								'label' => esc_html__( 'Overlay Content on Image', 'zyre-elementor-addons' ),
								'type' => Controls_Manager::SWITCHER,
								'default' => 'yes',
								'prefix_class' => 'zyre-carousel-content-overlay-',
							]
						);
						break;
				}
			endforeach;
		endif;
	}

	/**
	 * Register settings content controls.
	 *
	 * @param array $args {
	 *      Optional. An array of arguments for adjusting the controls.
	 *
	 *      @type array The controls to be excluded.
	* }
	*/
	protected function register_carousel_settings_controls( $args = [] ) {

		$default_args = [
			'excludes' => [],
		];

		$args = wp_parse_args( $args, $default_args );
		$default_values = isset( $args['default_values'] ) && is_array( $args['default_values'] ) ? $args['default_values'] : [];

		$navigation_options = [
			'both'   => esc_html__( 'Arrows & Pagination', 'zyre-elementor-addons' ),
			'arrows' => esc_html__( 'Arrows', 'zyre-elementor-addons' ),
			'dots'   => esc_html__( 'Pagination', 'zyre-elementor-addons' ),
			'none'   => esc_html__( 'None', 'zyre-elementor-addons' ),
		];

		$is_navigation = isset( $args['controls'], $args['controls']['navigation'] );
		if ( $is_navigation && ! empty( $args['controls']['navigation']['options'] ) && is_array( $args['controls']['navigation']['options'] ) ) {
			$navigation_options = $args['controls']['navigation']['options'];
		}

		$this->add_control(
			'navigation',
			[
				'label'              => esc_html__( 'Navigation', 'zyre-elementor-addons' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => $is_navigation && ! empty( $args['controls']['navigation']['default'] ) ? $args['controls']['navigation']['default'] : 'arrows',
				'options'            => $navigation_options,
				'frontend_available' => true,
			]
		);

		if ( ! in_array( 'pagination', $args['excludes'], true ) ) {
			$this->add_control(
				'pagination',
				[
					'label' => esc_html__( 'Pagination', 'zyre-elementor-addons' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'bullets',
					'options' => [
						'' => esc_html__( 'None', 'zyre-elementor-addons' ),
						'bullets' => esc_html__( 'Bullets', 'zyre-elementor-addons' ),
						'fraction' => esc_html__( 'Fraction', 'zyre-elementor-addons' ),
						'progressbar' => esc_html__( 'Progress', 'zyre-elementor-addons' ),
					],
					'prefix_class' => 'zyre-carousel-pagination-type-',
					'render_type' => 'template',
					'condition' => [
						'navigation' => [ 'both', 'dots' ],
					],
					'frontend_available' => true,
				]
			);
		}

		$this->add_control(
			'speed',
			[
				'label' => esc_html__( 'Transition Duration', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::NUMBER,
				'default' => ! empty( $default_values['speed'] ) ? absint( $default_values['speed'] ) : 500,
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$slides_per_view = range( 1, 10 );
		$slides_per_view = array_combine( $slides_per_view, $slides_per_view );
		$slides_per_view_d = ! empty( $default_values['slides_per_view'] ) ? absint( $default_values['slides_per_view'] ) : 3;
		$slides_per_view_t = $slides_per_view_d > 4 ? $slides_per_view_d - 2 : 2;
		$slides_per_view_m = $slides_per_view_t > 2 ? $slides_per_view_t - 1 : 1;

		$this->add_responsive_control(
			'slides_per_view',
			[
				'type'                 => Controls_Manager::SELECT,
				'label'                => esc_html__( 'Slides Per View', 'zyre-elementor-addons' ),
				'default'              => esc_attr( $slides_per_view_d ),
				'tablet_default'       => esc_attr( $slides_per_view_t ),
				'mobile_default'       => esc_attr( $slides_per_view_m ),
				'options'              => [ '' => esc_html__( 'Default', 'zyre-elementor-addons' ) ] + $slides_per_view,
				'inherit_placeholders' => false,
				'frontend_available'   => true,
			]
		);

		$this->add_responsive_control(
			'slides_to_scroll',
			[
				'type'                 => Controls_Manager::SELECT,
				'label'                => esc_html__( 'Slides to Scroll', 'zyre-elementor-addons' ),
				'description'          => esc_html__( 'Set how many slides are scrolled per swipe.', 'zyre-elementor-addons' ),
				'default'              => '1',
				'tablet_default'       => '1',
				'mobile_default'       => '1',
				'options'              => [ '' => esc_html__( 'Default', 'zyre-elementor-addons' ) ] + $slides_per_view,
				'inherit_placeholders' => false,
				'frontend_available'   => true,
			]
		);

		if ( ! in_array( 'effect', $args['excludes'], true ) ) {
			$effect_options = [
				'slide'     => esc_html__( 'Slide', 'zyre-elementor-addons' ),
				'fade'      => esc_html__( 'Fade', 'zyre-elementor-addons' ),
				'cube'      => esc_html__( 'Cube', 'zyre-elementor-addons' ),
				'coverflow' => esc_html__( 'Coverflow', 'zyre-elementor-addons' ),
				'flip'      => esc_html__( 'Flip', 'zyre-elementor-addons' ),
				'creative'  => esc_html__( 'Creative', 'zyre-elementor-addons' ),
				'cards'     => esc_html__( 'Cards', 'zyre-elementor-addons' ),
			];
			$is_effect = isset( $args['controls'], $args['controls']['effect'] );
			if ( $is_effect && ! empty( $args['controls']['effect']['options'] ) && is_array( $args['controls']['effect']['options'] ) ) {
				$effect_options = $args['controls']['effect']['options'];
			}
			$this->add_control(
				'effect',
				[
					'label'              => esc_html__( 'Effect', 'zyre-elementor-addons' ),
					'type'               => Controls_Manager::SELECT,
					'default'            => 'slide',
					'options'            => $effect_options,
					'frontend_available' => true,
					'condition'          => [
						'slides_per_view' => '1',
					],
				]
			);
			if ( ! empty( $args['controls']['effect']['alert'] ) ) {
				$this->add_control(
					'_alert_fade_effect',
					[
						'type'      => Controls_Manager::RAW_HTML,
						'raw'       => esc_html( $args['controls']['effect']['alert'] ),
						'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
						'condition' => [
							'effect' => 'fade',
						],
					]
				);
			}
		}

		$this->add_control(
			'image_spacing_custom',
			[
				'label'              => esc_html__( 'Space Between', 'zyre-elementor-addons' ),
				'type'               => Controls_Manager::SLIDER,
				'size_units'         => [ 'px' ],
				'range'              => [
					'px' => [
						'max' => 100,
					],
				],
				'render_type'        => 'none',
				'frontend_available' => true,
				'condition'          => [
					'slides_per_view!' => '1',
				],
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => esc_html__( 'Autoplay', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'separator' => 'before',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label' => esc_html__( 'Autoplay Speed', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::NUMBER,
				'default' => array_key_exists( 'autoplay_speed', $default_values ) ? absint( $default_values['autoplay_speed'] ) : 4000,
				'condition' => [
					'autoplay' => 'yes',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'loop',
			[
				'label' => esc_html__( 'Infinite Loop', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label'              => esc_html__( 'Pause on Hover', 'zyre-elementor-addons' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_on'           => esc_html__( 'Yes', 'zyre-elementor-addons' ),
				'label_off'          => esc_html__( 'No', 'zyre-elementor-addons' ),
				'return_value'       => 'yes',
				'default'            => '',
				'condition'          => [
					'autoplay' => 'yes',
				],
				'render_type'        => 'none',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'pause_on_interaction',
			[
				'label' => esc_html__( 'Pause on Interaction', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'autoplay' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		if ( ! in_array( 'lazyload', $args['excludes'], true ) ) {
			$this->add_control(
				'lazyload',
				[
					'label' => esc_html__( 'Lazy Load', 'zyre-elementor-addons' ),
					'type' => Controls_Manager::SWITCHER,
					'separator' => 'before',
					'frontend_available' => true,
				]
			);
		}

		$this->add_control(
			'direction',
			[
				'label'   => esc_html__( 'Direction', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => is_rtl() ? 'rtl' : 'ltr',
				'options' => [
					'ltr' => esc_html__( 'Left', 'zyre-elementor-addons' ),
					'rtl' => esc_html__( 'Right', 'zyre-elementor-addons' ),
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
	protected function render_html( ?Widget_Base $instance = null, $args = [] ) {
		if ( empty( $instance ) ) {
			$instance = $this;
		}

		$default_args = [];
		$args = wp_parse_args( $args, $default_args );

		$settings = $this->get_settings_for_display();

		$this->add_render_attribute(
			[
				'wrapper' => [
					'class'                => 'zyre-carousel-wrapper swiper zy-static',
					'role'                 => 'region',
					'aria-roledescription' => 'carousel',
					'aria-label'           => esc_attr__( 'Carousel', 'zyre-elementor-addons' ),
					'dir'                  => $settings['direction'],
				],
			]
		);

		$show_pagination = ( in_array( $settings['navigation'], [ 'dots', 'both' ] ) ) && ! empty( $settings['pagination'] );
		$show_arrows = ( in_array( $settings['navigation'], [ 'arrows', 'both' ] ) );

		$slides_count = count( $settings['slides'] );
		?>

		<div class="zyre-carousel">
			<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
				<div class="swiper-wrapper">
					<?php
					foreach ( $settings['slides'] as $index => $slide ) :
						$this->slide_prints_count++;
						?>
						<div class="swiper-slide" role="group" aria-roledescription="slide">
							<?php $this->print_slide( $slide, $settings, 'slide-' . $index . '-' . $this->slide_prints_count ); ?>
						</div>
					<?php endforeach; ?>
				</div>
				<?php if ( 1 < $slides_count ) : ?>
					<?php if ( $show_arrows ) : ?>
						<div class="zyre-swiper-button zyre-swiper-button-prev zy-absolute zy-<?php echo is_rtl() ? 'right' : 'left'; ?>-0 zy-inline-flex zy-index-1 zy-top-50 zy-translateY--50" role="button" tabindex="0" aria-label="<?php echo esc_attr__( 'Previous', 'zyre-elementor-addons' ); ?>">
							<?php $this->render_swiper_button( 'previous' ); ?>
						</div>
						<div class="zyre-swiper-button zyre-swiper-button-next zy-absolute zy-<?php echo is_rtl() ? 'left' : 'right'; ?>-0 zy-inline-flex zy-index-1 zy-top-50 zy-translateY--50" role="button" tabindex="0" aria-label="<?php echo esc_attr__( 'Next', 'zyre-elementor-addons' ); ?>">
							<?php $this->render_swiper_button( 'next' ); ?>
						</div>
					<?php endif; ?>
					<?php if ( $show_pagination ) : ?>
						<div class="swiper-pagination"></div>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>

		<?php
	}

	protected function print_slide( array $slide, array $settings, $element_key ) {

		$img_attribute = [
			'class' => 'zyre-carousel-image zy-w-100 zy-fit-cover',
			'role' => 'img',
			'aria-label' => Control_Media::get_image_alt( $slide['image'] ),
		];

		$this->add_render_attribute( $element_key . '-image', $img_attribute );

		$image_url = ! empty( $slide['image']['id'] ) ? Group_Control_Image_Size::get_attachment_image_src( $slide['image']['id'], 'thumbnail', $settings ) : '';

		if ( ! $image_url ) {
			$image_url = $slide['image']['url'];
		}

		if ( 'yes' === $settings['lazyload'] ) {
			$img_attribute['class'] = 'swiper-lazy';
			$img_attribute['loading'] = 'lazy';
		}

		$this->add_render_attribute( $element_key . '-image', $img_attribute );

		$item_key = $element_key . '_item';
		$item_tag = 'div';
		$this->add_render_attribute( $item_key, 'class', 'zyre-carousel-item zy-relative zy-h-100' );

		if ( isset( $slide['link'] ) && ! empty( $slide['link']['url'] ) ) {
			$item_tag = 'a';
			$this->add_link_attributes( $item_key, $slide['link'] );
			$this->add_render_attribute( $item_key, 'class', 'zy-block' );
		}

		$img_alt = ! empty( $slide['title'] ) ? $slide['title'] : '';
		?>

		<<?php Utils::print_validated_html_tag( $item_tag ); ?> <?php $this->print_render_attribute_string( $item_key ); ?>>
			<img <?php $this->print_render_attribute_string( $element_key . '-image' ); ?> src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>">
			<?php if ( 'yes' === $settings['lazyload'] ) : ?>
				<div class="swiper-lazy-preloader"></div>
			<?php endif; ?>

			<?php if ( ! empty( $slide['title'] ) || ! empty( $slide['subtitle'] ) ) : ?>
				<div class="zyre-carousel-content">
					<?php
					if ( ! empty( $slide['title'] ) ) {
						printf( '<%1$s class="zyre-carousel-title zy-m-0 zy-fs-1.5">%2$s</%1$s>',
							zyre_escape_tags( $settings['title_tag'], 'h3' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							wp_kses( $slide['title'], zyre_get_allowed_html() )
						);
					}
					?>
					<?php if ( ! empty( $slide['subtitle'] ) ) : ?>
						<p class="zyre-carousel-subtitle zy-m-0"><?php echo wp_kses( $slide['subtitle'], zyre_get_allowed_html() ); ?></p>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</<?php Utils::print_validated_html_tag( $item_tag ); ?>>
		<?php
	}

	private function render_swiper_button( $type ) {
		$direction = 'next' === $type ? 'right' : 'left';

		if ( is_rtl() ) {
			$direction = 'right' === $direction ? 'left' : 'right';
		}

		$icon_value = 'eicon-chevron-' . $direction;

		Icons_Manager::render_icon( [
			'library' => 'eicons',
			'value' => $icon_value,
		], [ 'aria-hidden' => 'true' ] );
	}
}
