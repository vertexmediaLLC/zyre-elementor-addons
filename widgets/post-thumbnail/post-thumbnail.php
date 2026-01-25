<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

defined( 'ABSPATH' ) || die();

class Post_Thumbnail extends Base {

	public function get_title() {
		return esc_html__( 'Post Thumbnail', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Post-Thumbnail';
	}

	public function get_keywords() {
		return [ 'thumbnail', 'post thumbnail', 'post info', 'post', 'post data', 'post featured image', 'featured image', 'post image' ];
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	/**
	 * Register widget content controls
	 */
	protected function register_content_controls() {
		$this->start_controls_section(
			'section_post_thumbnail_content',
			[
				'label' => esc_html__( 'Post Thumbnail', 'zyre-elementor-addons' ),
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$this->add_control(
			'post_thumbnail_type',
			[
				'label'   => esc_html__( 'Thumbnail Type', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'default' => esc_html__( 'Default', 'zyre-elementor-addons' ),
					'custom'  => esc_html__( 'Custom', 'zyre-elementor-addons' ),
				],
				'default' => 'default',
			]
		);

		$this->add_control(
			'custom_img',
			[
				'label' => esc_html__( 'Choose Image', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'post_thumbnail_type' => 'custom',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'post_thumbnail_img',
				'default' => 'thumbnail',
			]
		);

		$this->add_control(
			'post_thumbnail_link',
			[
				'label'   => esc_html__( 'Thumbnail Link', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'zyre-elementor-addons' ),
					'default' => esc_html__( 'Default', 'zyre-elementor-addons' ),
					'custom'  => esc_html__( 'Custom', 'zyre-elementor-addons' ),
				],
				'default' => 'default',
			]
		);

		$this->add_control(
			'custom_link',
			[
				'label' => esc_html__( 'Custom Link', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'label_block' => true,
				'condition' => [
					'post_thumbnail_link' => 'custom',
				],
			]
		);

		$this->add_control(
			'post_thumbnail_caption',
			[
				'label'        => esc_html__( 'Thumbnail Caption', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => [
					'none'    => esc_html__( 'None', 'zyre-elementor-addons' ),
					'display' => esc_html__( 'Display', 'zyre-elementor-addons' ),
					'hover'   => esc_html__( 'Display on hover', 'zyre-elementor-addons' ),
				],
				'default'      => 'none',
			]
		);

		$this->add_responsive_control(
			'alignment',
			[
				'label'              => esc_html__( 'Alignment', 'zyre-elementor-addons' ),
				'type'               => Controls_Manager::CHOOSE,
				'options'            => [
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
				],
				'default'      => is_rtl() ? 'right' : 'left',
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register styles related controls
	 */
	protected function register_style_controls() {
		$this->__thumbnail_style_controls();
		$this->__thumbnail_caption_controls();
	}

	/**
	 * Post Thumbnail Styles
	 *
	 */
	protected function __thumbnail_style_controls() {
		$this->start_controls_section(
			'section_post_thumbnail_style',
			[
				'label' => esc_html__( 'Thumbnail Style', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'post_thumbnail',
			[
				'selector' => '{{WRAPPER}} .zyre-post-thumbnail img',
				'controls' => [
					'width'         => [
						'range'   => [
							'%'  => [
								'min' => 1,
								'max' => 100,
							],
							'px' => [
								'min' => 1,
								'max' => 1000,
							],
							'vw' => [
								'min' => 1,
								'max' => 100,
							],
						],
						'default' => [
							'unit' => '%',
						],
					],
					'max_width'     => [
						'label'        => esc_html__( 'Max Width', 'zyre-elementor-addons' ),
						'range'        => [
							'%'  => [
								'min' => 1,
								'max' => 100,
							],
							'px' => [
								'min' => 1,
								'max' => 1000,
							],
							'vw' => [
								'min' => 1,
								'max' => 100,
							],
						],
						'default'      => [
							'unit' => '%',
						],
						'css_property' => 'max-width',
					],
					'height'        => [
						'range' => [
							'px' => [
								'min' => 1,
								'max' => 500,
							],
							'vh' => [
								'min' => 1,
								'max' => 100,
							],
						],
					],
					'border'        => [],
					'border_radius' => [
						'selector' => '{{WRAPPER}} .zyre-post-thumbnail-inner.zyre-post-thumbnail-caption--hover, {{WRAPPER}} .zyre-post-thumbnail img',
					],
				],
			]
		);

		$this->post_thumbnail_style( 'post_thumbnail', ' .zyre-post-thumbnail img' );

		$this->end_controls_section();
	}

	/**
	 * Thumbnail Caption Styles
	 *
	 */
	protected function __thumbnail_caption_controls() {
		$this->start_controls_section(
			'section_thumbnail_caption_style',
			[
				'label' => esc_html__( 'Caption Style', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'post_thumbnail_caption!' => 'none',
				],
			]
		);

		$this->set_style_controls(
			'thumbnail_caption',
			[
				'selector' => '{{WRAPPER}} .zyre-thumbnail-caption',
				'controls' => [
					'typography' => [],
					'alignment'  => [
						'default' => is_rtl() ? 'right' : 'left',
					],
					'color'      => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->post_thumbnail_style( 'thumbnail_caption', ' .zyre-thumbnail-caption' );

		$this->end_controls_section();
	}

	/**
	 * Post Thumbnail controls.
	 *
	 * @param string $prefix control ID name.
	 * @param string $select selector 1st class name.
	 */
	private function post_thumbnail_style( $prefix, $select ) {
		$this->add_control(
			$prefix . '_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}' . $select => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			$prefix . '_padding',
			[
				'label' => esc_html__( 'Padding', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}' . $select => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			$prefix . '_margin',
			[
				'label' => esc_html__( 'Margin', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}' . $select => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
	}

	/**
	 * Register render display controls
	 */
	protected function render() {
		$post = get_post();
		// Exit early if there's no valid post object
		if ( ! $post ) {
			return;
		}

		if ( post_password_required( $post->ID ) ) {
			echo get_the_password_form( $post->ID );
			return;
		}

		$settings = $this->get_settings_for_display();

		$is_custom = ( 'custom' === $settings['post_thumbnail_type'] );

		if ( has_post_thumbnail() || $is_custom ) {
			$html_tag = 'div';
			if ( ! empty( $settings['post_thumbnail_link'] ) && 'none' !== $settings['post_thumbnail_link'] ) {
				$html_tag = 'a';
				$this->add_render_attribute( 'post_thumbnail', 'class', 'zyre-post-thumbnail zyre-post-thumbnail-link zy-inline-block zy-lh-1 zy-v-middle' );
				if ( ! empty( $settings['custom_link']['url'] ) ) {
					$this->add_link_attributes( 'post_thumbnail', $settings['custom_link'] );
				} else {
					$this->add_render_attribute( 'post_thumbnail', 'href', esc_url( get_the_permalink() ) );
				}
			} else {
				$this->add_render_attribute( 'post_thumbnail', 'class', 'zyre-post-thumbnail zy-inline-block zy-lh-1 zy-v-middle' );
			}

			$wp_caption = '';
			?>

			<<?php echo esc_attr( $html_tag ); ?> <?php $this->print_render_attribute_string( 'post_thumbnail' ); ?>>
				<figure class="zyre-post-thumbnail-inner zyre-post-thumbnail-caption--<?php echo esc_attr( $settings['post_thumbnail_caption'] ); ?> zy-relative zy-m-0 zy-overflow-hidden">
					<?php
					if ( 'default' === $settings['post_thumbnail_type'] ) {
						$wp_caption = get_the_post_thumbnail_caption();
						the_post_thumbnail( $settings['post_thumbnail_img_size'] );
					} elseif ( $is_custom ) {
						$wp_caption = wp_get_attachment_caption( $settings['custom_img']['id'] );
						Group_Control_Image_Size::print_attachment_image_html( $settings, 'post_thumbnail_img', 'custom_img' );
					}
					if ( 'display' === $settings['post_thumbnail_caption'] && ! empty( $wp_caption ) ) : ?>
						<figcaption class="zyre-thumbnail-caption">
							<?php echo wp_kses( $wp_caption, zyre_get_allowed_html() ); ?>
						</figcaption>
					<?php elseif ( 'hover' === $settings['post_thumbnail_caption'] && ! empty( $wp_caption ) ) : ?>
						<figcaption class="zyre-thumbnail-caption zyre-thumbnail-caption-hover zy-absolute zy-left-0 zy-bottom-0 zy-bg-black zy-color-white zy-w-100 zy-opacity-0 zy-px-1 zy-py-2">
							<?php echo wp_kses( $wp_caption, zyre_get_allowed_html() ); ?>
						</figcaption>
					<?php endif; ?>
				</figure>
			</<?php echo esc_attr( $html_tag ); ?>>
			<?php
		}
	}
}
