<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;

defined( 'ABSPATH' ) || die();

class Post_Title extends Base {

	public function get_title() {
		return esc_html__( 'Post Title', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Post-Title';
	}

	public function get_keywords() {
		return [ 'title', 'post title', 'post heading', 'heading', 'post name', 'post info' ];
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	// Widget Content controls
	protected function register_content_controls() {
		$this->start_controls_section(
			'section_post_title_content',
			[
				'label' => esc_html__( 'Post Title Content', 'zyre-elementor-addons' ),
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$this->__before_title_content_controls();
		$this->__title_after_content_controls();

		$this->add_control(
			'link',
			[
				'label'   => esc_html__( 'Link', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'None', 'zyre-elementor-addons' ),
					'default' => esc_html__( 'Default', 'zyre-elementor-addons' ),
					'custom'  => esc_html__( 'Custom URL', 'zyre-elementor-addons' ),
				],
				'default' => '',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'custom_link',
			[
				'label'       => esc_html__( 'Link', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'zyre-elementor-addons' ),
				'dynamic'     => [
					'active' => true,
				],
				'default'     => [
					'url' => get_home_url(),
				],
				'condition'   => [
					'link' => 'custom',
				],
			]
		);

		$this->add_control(
			'post_title_tag',
			[
				'label'   => esc_html__( 'HTML Tag', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'h1' => [
						'title' => esc_html__( 'H1', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-editor-h1',
					],
					'h2' => [
						'title' => esc_html__( 'H2', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-editor-h2',
					],
					'h3' => [
						'title' => esc_html__( 'H3', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-editor-h3',
					],
					'h4' => [
						'title' => esc_html__( 'H4', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-editor-h4',
					],
					'h5' => [
						'title' => esc_html__( 'H5', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-editor-h5',
					],
					'h6' => [
						'title' => esc_html__( 'H6', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-editor-h6',
					],
				],
				'default' => 'h2',
				'toggle'  => false,
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
				],
				'default'      => 'left',
				'selectors_dictionary' => [
					'left'   => 'justify-content: flex-start; text-align: left;',
					'center' => 'justify-content: center; text-align: center;',
					'right'  => 'justify-content: flex-end; text-align: right;',
				],
				'selectors'          => [
					'{{WRAPPER}} .zyre-post-title-heading' => '{{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __before_title_content_controls() {
		$this->title_before_after_content_controls( 'before' );
	}

	protected function __title_after_content_controls() {
		$this->title_before_after_content_controls( 'after' );
	}

	/**
	 * Title before & after content controls.
	 *
	 * @param string $prefix The prefix of the controls.
	 */
	private function title_before_after_content_controls( string $prefix ) {
		$types = [
			'none' => esc_html__( 'None', 'zyre-elementor-addons' ),
			'text' => esc_html__( 'Text', 'zyre-elementor-addons' ),
			'separator' => esc_html__( 'Separator', 'zyre-elementor-addons' ),
			'icon' => esc_html__( 'Icon', 'zyre-elementor-addons' ),
		];

		$margin_property = 'before' === $prefix ? ( is_rtl() ? 'margin-left' : 'margin-right' ) : ( is_rtl() ? 'margin-right' : 'margin-left' );
		$label_prefix = 'before' === $prefix ? esc_html__( 'Before ', 'zyre-elementor-addons' ) : esc_html__( 'After ', 'zyre-elementor-addons' );

		$this->add_control(
			$prefix . '_types',
			[
				'label'   => $label_prefix . esc_html__( 'Title Text', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $types,
				'default' => 'none',
				'separator' => 'before',
			]
		);

		$this->add_control(
			$prefix . '_text',
			[
				'label'   => esc_html__( 'Text', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					$prefix . '_types' => 'text',
				],
			]
		);

		$this->add_control(
			$prefix . '_icon',
			[
				'label'       => esc_html__( 'Icon', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => 'true',
				'condition' => [
					$prefix . '_types' => 'icon',
				],
			]
		);

		$this->add_control(
			$prefix . '_spacing',
			[
				'label'     => $label_prefix . esc_html__( 'Spacing', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					$prefix . '_types!' => 'none',
				],
				'default' => [
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-post-title-' . $prefix  => "{$margin_property}: {{SIZE}}{{UNIT}};",
				],
			]
		);
	}

	// Widget Style controls
	protected function register_style_controls() {
		$this->__before_text_style_controls();
		$this->__before_icon_style_controls();
		$this->__before_separator_style_controls();
		$this->__title_style_controls();
		$this->__after_text_style_controls();
		$this->__after_icon_style_controls();
		$this->__after_separator_style_controls();
	}

	protected function __before_text_style_controls() {
		$this->start_controls_section(
			'section_post_text_before_style',
			[
				'label' => esc_html__( 'Before Text', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'before_types' => 'text',
				],
			]
		);

		$this->set_style_controls(
			'before_text',
			[
				'selector' => '{{WRAPPER}} .zyre-post-title-text-prefix',
				'controls' => [
					'typography'  => [],
					'text_color'  => [],
					'text_shadow' => [],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __before_icon_style_controls() {
		$this->start_controls_section(
			'section_post_icon_before_style',
			[
				'label' => esc_html__( 'Before Icon', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'before_types' => 'icon',
				],
			]
		);

		$this->set_style_controls(
			'before_icon',
			[
				'selector' => '{{WRAPPER}} .zyre-post-title-icon-prefix',
				'controls' => [
					'icon_size'  => [
						'default' => [
							'size' => 16,
						],
					],
					'icon_color' => [],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __before_separator_style_controls() {
		$this->start_controls_section(
			'section_post_separator_before_style',
			[
				'label' => esc_html__( 'Before Separator', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'before_types' => 'separator',
				],
			]
		);

		$this->set_style_controls(
			'before_separator',
			[
				'selector' => '{{WRAPPER}} .zyre-post-title-separator-prefix',
				'controls' => [
					'width'  => [
						'css_property' => 'max-width',
						'default'      => [
							'unit' => 'px',
						],
					],
					'border' => [
						'fields_options' => [
							'border' => [
								'default' => 'solid',
							],
							'width' => [
								'default' => [
									'top' => '1',
									'right' => '1',
									'bottom' => '1',
									'left' => '1',
									'isLinked' => true,
								],
							],
							'color' => [
								'default' => '#DDDDDD',
							],
						],
					],
					'border_radius' => [],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __title_style_controls() {
		$this->start_controls_section(
			'section_post_title_style',
			[
				'label' => esc_html__( 'Title', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'title',
			[
				'selector' => '{{WRAPPER}} .zyre-post-title',
				'controls' => [
					'typography' => [],
					'alignment'  => [
						'default' => is_rtl() ? 'right' : 'left',
					],
				],
			]
		);

		$this->start_controls_tabs( 'title_colors_style_tabs' );

		$this->start_controls_tab(
			'title_colors_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'title',
			[
				'selector' => '{{WRAPPER}} .zyre-post-title',
				'controls' => [
					'text_color'  => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
					'text_shadow' => [],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'title_colors_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'title_hover',
			[
				'selector' => '{{WRAPPER}} .zyre-post-title:hover',
				'controls' => [
					'text_color'  => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
					'text_shadow' => [],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function __after_text_style_controls() {
		$this->start_controls_section(
			'section_post_text_after_style',
			[
				'label' => esc_html__( 'After Text', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'after_types' => 'text',
				],
			]
		);

		$this->set_style_controls(
			'after_text',
			[
				'selector' => '{{WRAPPER}} .zyre-post-title-text-suffix',
				'controls' => [
					'typography'  => [],
					'text_color'  => [],
					'text_shadow' => [],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __after_icon_style_controls() {
		$this->start_controls_section(
			'section_post_icon_after_style',
			[
				'label' => esc_html__( 'After Icon', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'after_types' => 'icon',
				],
			]
		);

		$this->set_style_controls(
			'after_icon',
			[
				'selector' => '{{WRAPPER}} .zyre-post-title-icon-suffix',
				'controls' => [
					'icon_size'  => [
						'default' => [
							'size' => 16,
						],
					],
					'icon_color' => [],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __after_separator_style_controls() {
		$this->start_controls_section(
			'section_post_separator_after_style',
			[
				'label' => esc_html__( 'After Separator', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'after_types' => 'separator',
				],
			]
		);

		$this->set_style_controls(
			'after_separator',
			[
				'selector' => '{{WRAPPER}} .zyre-post-title-separator-suffix',
				'controls' => [
					'width'  => [
						'css_property' => 'max-width',
						'default'      => [
							'unit' => 'px',
						],
					],
					'border' => [
						'fields_options' => [
							'border' => [
								'default' => 'solid',
							],
							'width' => [
								'default' => [
									'top' => '1',
									'right' => '1',
									'bottom' => '1',
									'left' => '1',
									'isLinked' => true,
								],
							],
							'color' => [
								'default' => '#DDDDDD',
							],
						],
					],
					'border_radius' => [],
				],
			]
		);

		$this->end_controls_section();
	}

	// Widget Display
	protected function render() {
		$settings = $this->get_settings_for_display(); ?>
		<<?php echo zyre_escape_tags( $settings['post_title_tag'], 'h2' ); ?> class="zyre-post-title-heading zy-flex zy-align-center zy-m-0 zy-lh-1.5">        
			<?php
				$this->__render_title_before_after( 'before', 'prefix' );
				$this->__render_title();
				$this->__render_title_before_after( 'after', 'suffix' );
			?> 
		</<?php echo zyre_escape_tags( $settings['post_title_tag'], 'h2' ); ?>>
		<?php
	}

	protected function __render_title() {
		$settings = $this->get_settings_for_display();

		$html_tag = 'span';
		if ( 'custom' === $settings['link'] || 'default' === $settings['link'] ) {
			$html_tag = 'a';
			$this->add_render_attribute( 'title', 'class', 'zyre-post-title zyre-post-title-link' );
			if ( ! empty( $settings['custom_link']['url'] ) ) {
				$this->add_link_attributes( 'title', $settings['custom_link'] );
			} else {
				$this->add_render_attribute( 'title', 'href', esc_url( get_the_permalink() ) );
			}
		} else {
			$this->add_render_attribute( 'title', 'class', 'zyre-post-title' );
		}
		?>
		<<?php echo esc_attr( $html_tag ); ?> <?php $this->print_render_attribute_string( 'title' ); ?>>
			<?php echo zyre_kses_basic( get_the_title() ); ?>
		</<?php echo esc_attr( $html_tag ); ?>>
	<?php }

	/**
	 * Render Title before & after HTML.
	 *
	 * @param string $prefix The prefix of the elements.
	 * @param string $class_base This will help to select HTML elements.
	 */
	protected function __render_title_before_after( $prefix, $class_base ) {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings[ $prefix . '_types' ] ) || 'none' === $settings[ $prefix . '_types' ] ) {
			return;
		}

		if ( 'text' === $settings[ $prefix . '_types' ] && '' !== $settings[ $prefix . '_text' ] ) : ?>
			<span class="zyre-post-title-<?php echo esc_attr( $prefix ); ?> zyre-post-title-text-<?php echo esc_attr( $class_base ); ?>">
				<?php echo esc_html( $settings[ $prefix . '_text' ] ); ?>
			</span>
		<?php endif; ?>
		<?php if ( 'separator' === $settings[ $prefix . '_types' ] ) : ?>
			<span class="zyre-post-title-<?php echo esc_attr( $prefix ); ?> zyre-post-title-separator-<?php echo esc_attr( $class_base ); ?> zy-grow-1 zy-mw-2 zy-h-0"></span>
		<?php endif; ?>
		<?php if ( 'icon' === $settings[ $prefix . '_types' ] ) : ?>
			<span class="zyre-post-title-<?php echo esc_attr( $prefix ); ?> zyre-post-title-icon-<?php echo esc_attr( $class_base ); ?>">
				<?php zyre_render_icon( $settings, 'icon', $prefix . '_icon' ); ?>
			</span>
		<?php endif;
	}
}
