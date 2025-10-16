<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Author_Box extends Base {
	/**
	 * Widget Name
	 */
	public function get_title() {
		return esc_html__( 'Author Box', 'zyre-elementor-addons' );
	}

	/**
	 * Widget Icon
	 */
	public function get_icon() {
		return 'zy-fonticon zy-Author-Box';
	}

	/**
	 * Widget search keywords
	 */
	public function get_keywords() {
		return [ 'author box', 'author meta', 'author', 'author description', 'author details', 'author name', 'author info', 'author link', 'author bio', 'bio' ];
	}

	/**
	 * Register widget content controls
	 */
	protected function register_content_controls() {
		$this->start_controls_section(
			'section_author_box_content',
			[
				'label' => esc_html__( 'Author Box', 'zyre-elementor-addons' ),
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$this->add_control(
			'show_avatar',
			[
				'label'        => esc_html__( 'Show Avatar', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'avatar_size',
			[
				'label' => esc_html__( 'Avatar Size', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 500,
				'step' => 1,
				'default' => 96,
				'condition' => [
					'show_avatar' => 'yes',
				],
			]
		);

		$this->add_control(
			'avatar_link',
			[
				'label'        => esc_html__( 'Enable Avatar Link', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
				'condition' => [
					'show_avatar' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'avatar_direction',
			[
				'label'                => esc_html__( 'Avatar Direction', 'zyre-elementor-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'left'   => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
					'top'    => [
						'title' => esc_html__( 'Top', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-top',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'default'              => 'left',
				'tablet_default'       => 'left',
				'mobile_default'       => 'left',
				'prefix_class'         => 'zyre-author-box-avatar%s-dir-',
				'selectors_dictionary' => [
					'left'   => 'flex-wrap: nowrap;flex-direction: row;--info-width: auto;',
					'right'  => 'flex-wrap: nowrap;flex-direction: row-reverse;--info-width: auto;',
					'top'    => 'flex-wrap: wrap;flex-direction: column;--info-width: 100%;',
					'bottom' => 'flex-wrap: wrap;flex-direction: column-reverse;--info-width: 100%;',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-author-box' => '{{VALUE}};',
				],
				'style_transfer'       => true,
				'condition'            => [
					'show_avatar' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'avatar_position',
			[
				'label'                => esc_html__( 'Avatar Position', 'zyre-elementor-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'top'    => [
						'title' => esc_html__( 'Top', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'default'              => 'center',
				'tablet_default'       => 'center',
				'mobile_default'       => 'center',
				'selectors_dictionary' => [
					'top'    => 'align-self: flex-start;',
					'center' => 'align-self: center;',
					'bottom' => 'align-self: flex-end;',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-author-img' => '{{VALUE}}',
				],
				'condition'            => [
					'show_avatar' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_author',
			[
				'label'        => esc_html__( 'Show Author Name', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'author_link',
			[
				'label'        => esc_html__( 'Enable Author Link', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
				'condition' => [
					'show_author' => 'yes',
				],
			]
		);

		$this->add_control(
			'author_meta_tag',
			[
				'label' => esc_html__( 'Author Name Tag', 'zyre-elementor-addons' ),
				'label_block' => true,
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'h1'  => [
						'title' => esc_html__( 'H1', 'zyre-elementor-addons' ),
						'icon' => 'eicon-editor-h1',
					],
					'h2'  => [
						'title' => esc_html__( 'H2', 'zyre-elementor-addons' ),
						'icon' => 'eicon-editor-h2',
					],
					'h3'  => [
						'title' => esc_html__( 'H3', 'zyre-elementor-addons' ),
						'icon' => 'eicon-editor-h3',
					],
					'h4'  => [
						'title' => esc_html__( 'H4', 'zyre-elementor-addons' ),
						'icon' => 'eicon-editor-h4',
					],
					'h5'  => [
						'title' => esc_html__( 'H5', 'zyre-elementor-addons' ),
						'icon' => 'eicon-editor-h5',
					],
					'h6'  => [
						'title' => esc_html__( 'H6', 'zyre-elementor-addons' ),
						'icon' => 'eicon-editor-h6',
					],
				],
				'default' => 'h4',
				'toggle' => false,
				'condition' => [
					'show_author' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_bio',
			[
				'label'        => esc_html__( 'Show Short Bio', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'show_posts',
			[
				'label'        => esc_html__( 'Show Author Post Link', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'btn_text',
			[
				'label'   => esc_html__( 'Link Text', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::TEXT,
				'condition' => [
					'show_posts' => 'yes',
				],
				'ai' => false,
				'default' => esc_html__( 'All Posts', 'zyre-elementor-addons' ),
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => esc_html__( 'Alignment', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justify', 'zyre-elementor-addons' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => is_rtl() ? 'right' : 'left',
				'toggle' => true,
				'style_transfer' => true,
				'selectors' => [
					'{{WRAPPER}} .zyre-author-info' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register styles related controls
	 */
	protected function register_style_controls() {
		$this->__author_box_avatar();
		$this->__author_box_name();
		$this->__author_box_info();
		$this->__author_box_link();
	}

	/**
	 * Author Image
	 */
	protected function __author_box_avatar() {
		$this->start_controls_section(
			'section_author_img_style',
			[
				'label' => esc_html__( 'Avatar', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_avatar' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'author_img',
			[
				'selector' => '{{WRAPPER}} .zyre-author-img img',
				'controls' => [
					'width'         => [],
					'bg_color'      => [],
					'padding'       => [],
					'border'        => [],
					'border_radius' => [],
					'gap'           => [
						'selector' => '{{WRAPPER}} .zyre-author-box',
						'default'  => [
							'size' => 20,
						],
					],
				],
			],
		);

		$this->end_controls_section();
	}

	/**
	 * Author Name
	 */
	protected function __author_box_name() {
		$this->start_controls_section(
			'section_author_name_style',
			[
				'label' => esc_html__( 'Author Name', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_author' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'author_name',
			[
				'selector' => '{{WRAPPER}} .zyre-author-name',
				'controls' => [
					'typography'    => [],
					'text_color'    => [],
					'margin_bottom' => [
						'label' => esc_html__( 'Margin Bottom', 'zyre-elementor-addons' ),
					],
				],
			],
		);

		$this->set_style_controls(
			'author_name_hover',
			[
				'selector'  => '{{WRAPPER}} .zyre-author-name:hover',
				'controls'  => [
					'text_color' => [
						'label' => esc_html__( 'Hover Color', 'zyre-elementor-addons' ),
					],
				],
				'condition' => [
					'author_link' => 'yes',
				],
			],
		);

		$this->end_controls_section();
	}

	/**
	 * Author Description
	 */
	protected function __author_box_info() {
		$this->start_controls_section(
			'section_author_info_style',
			[
				'label' => esc_html__( 'Author Bio', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_bio' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'author_info',
			[
				'selector' => '{{WRAPPER}} .zyre-author-desc',
				'controls' => [
					'typography'    => [],
					'text_color'    => [],
					'margin_bottom' => [
						'label' => esc_html__( 'Margin Bottom', 'zyre-elementor-addons' ),
					],
				],
			],
		);

		$this->end_controls_section();
	}

	/**
	 * Author Link
	 */
	protected function __author_box_link() {
		$this->start_controls_section(
			'section_btn_link_style',
			[
				'label'     => esc_html__( 'Author Posts Link', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'btn_text!' => '',
				],
			]
		);

		$this->set_style_controls(
			'author_post',
			[
				'selector' => '{{WRAPPER}} .zyre-author-post-link',
				'controls' => [
					'typography'    => [],
					'padding'       => [],
					'border'        => [],
					'border_radius' => [],
				],
			],
		);

		$this->start_controls_tabs(
			'tabs_author_post_link_colors',
		);

		$this->start_controls_tab(
			'tab_normal_author_post_link_colors',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'author_post',
			[
				'selector' => '{{WRAPPER}} .zyre-author-post-link',
				'controls' => [
					'text_color' => [],
					'bg_color'   => [],
				],
			],
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_hover_author_post_link_colors',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'author_post_hover',
			[
				'selector' => '{{WRAPPER}} .zyre-author-post-link:hover',
				'controls' => [
					'text_color'   => [],
					'bg_color'     => [],
					'border_color' => [],
				],
			],
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
		$user_id = get_post_field( 'post_author', get_the_ID() );
		$avatar = get_avatar( $user_id, $settings['avatar_size'] );
		$display_name = get_the_author_meta( 'display_name', $user_id );
		$bio = get_the_author_meta( 'description', $user_id );
		$post_url = get_author_posts_url( $user_id );

		$this->add_render_attribute( 'author_img', 'class', 'zyre-author-img zy-flex zy-shrink-0 zy-self-start' );
		$this->add_render_attribute( 'author_name', 'class', 'zyre-author-name zy-inline-block' );

		$author_img_tag = 'div';
		if ( 'yes' === $settings['avatar_link'] ) {
			$author_img_tag = Utils::validate_html_tag( 'a' );
			$this->add_render_attribute( 'author_img', 'class', 'zyre-author-img-link' );
			$this->add_render_attribute( 'author_img', 'href', esc_url( $post_url ) );
		}

		$author_name_tag = 'span';
		if ( 'yes' === $settings['author_link'] ) {
			$author_name_tag = Utils::validate_html_tag( 'a' );
			$this->add_render_attribute( 'author_name', 'class', 'zyre-author-name-link zy-inline-block' );
			$this->add_render_attribute( 'author_name', 'href', esc_url( $post_url ) );
		}
		?>
		<div class="zyre-author-box zy-flex zy-align-center">
			<?php if ( 'yes' === $settings['show_avatar'] ) : ?>
			<<?php Utils::print_validated_html_tag( $author_img_tag ); ?> <?php $this->print_render_attribute_string( 'author_img' ); ?>>
				<?php echo $avatar; ?>
			</<?php Utils::print_validated_html_tag( $author_img_tag ); ?>>
			<?php endif; ?>

			<div class="zyre-author-info zy-grow-1">
				<?php if ( 'yes' === $settings['show_author'] ) : ?>
				<<?php echo zyre_escape_tags( $settings ['author_meta_tag'], 'h4' ); ?> class="zyre-author-name-heading zy-m-0">
					<<?php Utils::print_validated_html_tag( $author_name_tag ); ?> <?php $this->print_render_attribute_string( 'author_name' ); ?>>
						<?php echo esc_html( $display_name ); ?>
					</<?php Utils::print_validated_html_tag( $author_name_tag ); ?>>
				</<?php echo zyre_escape_tags( $settings ['author_meta_tag'], 'h4' ); ?>>
				<?php endif; ?>

				<?php if ( 'yes' === $settings['show_bio'] ) : ?>
				<p class="zyre-author-desc">
					<?php echo esc_html( $bio ); ?>
				</p>
				<?php endif; ?>

				<?php if ( 'yes' === $settings['show_posts'] && '' !== $settings['btn_text'] ) : ?>
					<a href="<?php echo esc_url( $post_url ); ?>" class="zyre-author-post-link">
						<?php echo esc_html( $settings['btn_text'] ); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}
