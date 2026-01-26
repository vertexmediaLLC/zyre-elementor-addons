<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use ZyreAddons\Elementor\Controls\Select2;

defined( 'ABSPATH' ) || die();

class Post_Excerpt extends Base {

	public function get_title() {
		return esc_html__( 'Post Excerpt', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Post-Excerpt';
	}

	public function get_keywords() {
		return [ 'excerpt', 'post excerpt', 'post info', 'post', 'post content', 'post data', 'read more' ];
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	// Widget Content controls
	protected function register_content_controls() {
		$this->start_controls_section(
			'section_post_excerpt_content',
			[
				'label' => esc_html__( 'Post Excerpt Content', 'zyre-elementor-addons' ),
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		// Content Source
		$this->add_control(
			'source_type',
			[
				'label'     => esc_html__( 'Content Source', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'current_post' => esc_html__( 'Current Post', 'zyre-elementor-addons' ),
					'custom'       => esc_html__( 'Custom', 'zyre-elementor-addons' ),
				],
				'default'   => 'current_post',
			]
		);

		$this->add_control(
			'source_custom',
			[
				'label'          => esc_html__( 'Search & Select', 'zyre-elementor-addons' ),
				'type'           => Select2::TYPE,
				'multiple'       => false,
				'placeholder'    => esc_html__( 'Search Post', 'zyre-elementor-addons' ),
				'dynamic_params' => [
					'object_type' => 'post',
					'post_type'   => 'any',
				],
				'select2options' => [
					'minimumInputLength' => 2,
				],
				'label_block'    => true,
				'condition'      => [
					'source_type' => 'custom',
				],
			]
		);

		$this->add_control(
			'excerpt_length',
			[
				'type'        => Controls_Manager::NUMBER,
				'label'       => esc_html__( 'Excerpt Length', 'zyre-elementor-addons' ),
				'min'         => 0,
				'default'     => 22,
			]
		);

		$this->add_responsive_control(
			'alignment',
			[
				'label'     => esc_html__( 'Alignment', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'    => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'fa fa-align-left',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'   => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'fa fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justify', 'zyre-elementor-addons' ),
						'icon'  => 'fa fa-align-justify',
					],
				],
				'default'   => is_rtl() ? 'right' : 'left',
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'read_more',
			[
				'label' => esc_html__( 'Read More', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'read_more_text',
			[
				'label' => esc_html__( 'Text', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Read More', 'zyre-elementor-addons' ),
				'condition'   => [
					'read_more' => 'yes',
				],
			]
		);

		$this->add_control(
			'read_more_icon',
			[
				'label'       => esc_html__( 'Icon', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => 'true',
				'condition'   => [
					'read_more' => 'yes',
				],
			]
		);

		$this->add_control(
			'icon_position',
			[
				'label'   => esc_html__( 'Icon Position', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'before' => esc_html__( 'Before', 'zyre-elementor-addons' ),
					'after'  => esc_html__( 'After', 'zyre-elementor-addons' ),
				],
				'default' => 'after',
				'condition'   => [
					'read_more' => 'yes',
					'read_more_icon[value]!' => '',
				],
			]
		);

		$margin_right = is_rtl() ? 'margin-left' : 'margin-right';
		$margin_left = is_rtl() ? 'margin-right' : 'margin-left';

		$this->add_control(
			'icon_spacing',
			[
				'label'     => esc_html__( 'Icon Spacing', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'read_more' => 'yes',
					'read_more_icon[value]!' => '',
				],
				'default' => [
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-post-read-more-icon--before' => "{$margin_right}: {{SIZE}}{{UNIT}};",
					'{{WRAPPER}} .zyre-post-read-more-icon--after' => "{$margin_left}: {{SIZE}}{{UNIT}};",
				],
			]
		);

		$this->add_control(
			'link',
			[
				'label'   => esc_html__( 'Link', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'default' => esc_html__( 'Default', 'zyre-elementor-addons' ),
					'custom'  => esc_html__( 'Custom URL', 'zyre-elementor-addons' ),
				],
				'default' => 'default',
				'condition'   => [
					'read_more' => 'yes',
					'read_more_text[value]!' => '',
				],
			]
		);

		$this->add_control(
			'custom_link',
			[
				'label'       => esc_html__( 'Custom Link', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'zyre-elementor-addons' ),
				'dynamic'     => [
					'active' => true,
				],
				'default'     => [
					'url' => get_home_url(),
				],
				'condition'   => [
					'read_more' => 'yes',
					'link' => 'custom',
					'read_more_text[value]!' => '',
				],
			]
		);

		$this->end_controls_section();
	}

	// Widget Style controls
	protected function register_style_controls() {
		$this->start_controls_section(
			'section_post_excerpt_style',
			[
				'label' => esc_html__( 'Excerpt', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'excerpt',
			[
				'selector' => '{{WRAPPER}} .zyre-post-excerpt',
				'controls' => [
					'typography' => [],
					'color'      => [],
					'space'      => [
						'label' => esc_html__( 'Space Bottom', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->end_controls_section();

		// Section: Read More Style
		$this->start_controls_section(
			'section_post_read_more_style',
			[
				'label'     => esc_html__( 'Read More', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'read_more'              => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'read_more',
			[
				'selector' => '{{WRAPPER}} .zyre-post-read-more-link',
				'controls' => [
					'typography'    => [],
					'width'         => [
						'default' => [
							'unit' => 'px',
						],
					],
					'height'        => [],
					'margin'        => [
						'selector' => '{{WRAPPER}} .zyre-post-read-more',
					],
					'padding'       => [],
					'border'        => [],
					'border_radius' => [],
					'icon_size'     => [
						'selector'  => '{{WRAPPER}} .zyre-post-read-more-icon',
						'condition' => [
							'read_more_icon[value]!' => '',
						],
					],
				],
			]
		);

		$this->start_controls_tabs( 'read_more_style_tabs' );

		$this->start_controls_tab(
			'read_more_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'read_more',
			[
				'selector' => '{{WRAPPER}} .zyre-post-read-more-link',
				'controls' => [
					'text_color' => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
					'icon_color' => [
						'selector'  => '{{WRAPPER}} .zyre-post-read-more-icon',
						'condition' => [
							'read_more_icon[value]!' => '',
						],
					],
					'bg_color'   => [],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'read_more_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'read_more_hover',
			[
				'selector' => '{{WRAPPER}} .zyre-post-read-more-link:hover',
				'controls' => [
					'text_color'   => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
					'icon_color'   => [
						'selector'  => '{{WRAPPER}} .zyre-post-read-more-link:hover .zyre-post-read-more-icon',
						'condition' => [
							'read_more_icon[value]!' => '',
						],
					],
					'bg_color'     => [],
					'border_color' => [],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	// Widget Display
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( 'custom' === $settings['source_type'] ) {
			$post_id = is_array( $settings['source_custom'] ) ? (int) $settings['source_custom'][0] : (int) $settings['source_custom'];
			zyre_elementor()->db->switch_to_post( $post_id );
		}

		$post = get_post();
		// Exit early if there's no valid post object
		if ( ! $post ) {
			return;
		}

		if ( post_password_required( $post->ID ) ) {
			echo wp_kses_post( get_the_password_form( $post->ID ) );
			return;
		}

		$settings = $this->get_settings_for_display();
		$length = ! empty( $settings['excerpt_length'] ) ? (int) $settings['excerpt_length'] : 55;
		$wp_excerpt = apply_filters( 'get_the_excerpt', zyre_trim_words( get_the_excerpt(), $length ) );

		$this->add_render_attribute( 'read_more', 'class', 'zyre-post-read-more-link zy-inline-flex zy-align-center zy-justify-center' );
		if ( 'custom' === $settings['link'] && ! empty( $settings['custom_link']['url'] ) ) {
			$this->add_link_attributes( 'read_more', $settings['custom_link'] );
		} else {
			$this->add_render_attribute( 'read_more', 'href', esc_url( get_the_permalink() ) );
		}

		if ( '' !== $wp_excerpt ) { ?>
			<p class="zyre-post-excerpt">
				<?php echo wp_kses_post( $wp_excerpt, 'zyre-elementor-addons' ); ?>
			</p>			
			<?php
			if ( 'yes' === $settings['read_more'] ) {
				?>
				<span class="zyre-post-read-more zy-inline-block">
					<a <?php $this->print_render_attribute_string( 'read_more' ); ?>>
						<?php if ( 'before' === $settings['icon_position'] ) : ?>
							<span class="zyre-post-read-more-icon zyre-post-read-more-icon--before">
								<?php zyre_render_icon( $settings, 'icon', 'read_more_icon' ); ?>
							</span>
						<?php endif; ?>

						<?php if ( ! empty( $settings['read_more_text'] ) ) : ?>
							<span class="zyre-post-read-more-text"><?php echo esc_html( $settings['read_more_text'] ); ?></span>
						<?php endif; ?>

						<?php if ( 'after' === $settings['icon_position'] ) : ?>
							<span class="zyre-post-read-more-icon zyre-post-read-more-icon--after">
								<?php zyre_render_icon( $settings, 'icon', 'read_more_icon' ); ?>
							</span>
						<?php endif; ?>	
					</a>							
				</span>
			<?php }
		}

		if ( 'custom' === $settings['source_type'] ) {
			zyre_elementor()->db->restore_current_post();
		}
	}
}
