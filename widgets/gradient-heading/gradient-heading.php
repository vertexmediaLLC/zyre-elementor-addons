<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;

defined( 'ABSPATH' ) || die();

class Gradient_Heading extends Base {

	public function get_title() {
		return esc_html__( 'Gradient Heading', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Gradient-heading';
	}

	public function get_keywords() {
		return [ 'heading', 'gradient heading', 'title', 'text', 'content', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ];
	}

	protected function register_content_controls() {
		$this->start_controls_section(
			'section_heading',
			[
				'label' => esc_html__( 'Gradient Heading Content', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$this->add_control(
			'title_prefix',
			[
				'label'       => esc_html__( 'Title Prefix', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'title_text',
			[
				'label'       => esc_html__( 'Title Text', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'title_suffix',
			[
				'label'       => esc_html__( 'Title Suffix', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'text_subtitle',
			[
				'label'       => esc_html__( 'Subtitle', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'   => esc_html__( 'Title HTML Tag', 'zyre-elementor-addons' ),
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

		$this->add_control(
			'title_subtitle_order',
			[
				'label'   => esc_html__( 'Title & Subtitle Order', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'title_first',
				'options' => [
					'title_first'   => esc_html__( 'Title / Subtitle', 'zyre-elementor-addons' ),
					'subtitle_first' => esc_html__( 'Subtitle / Title', 'zyre-elementor-addons' ),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'           => 'title_gradient',
				'types'          => [ 'gradient' ],
				'exclude'        => [ 'image' ],
				'fields_options' => [
					'background' => [
						'default' => 'gradient',
						'label'          => esc_html__( 'Set Gradient for Title ', 'zyre-elementor-addons' ),
					],
				],

				'selector' => '{{WRAPPER}} .zyre-gradient-heading-title',
			]
		);

		$this->add_control(
			'gradient_heading_css_class',
			[
				'label'       => esc_html__( 'Class', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'Class Name', 'zyre-elementor-addons' ),
				'prefix_class' => '',
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_controls() {
		$this->__title_prefix_style_controls();
		$this->__title_text_style_controls();
		$this->__title_suffix_style_controls();
		$this->__text_subtitle_style_controls();
	}

	protected function __title_text_style_controls() {
		$this->start_controls_section(
			'section_title_text_style',
			[
				'label' => esc_html__( 'Title', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'title_text!' => '',
				],
			]
		);

		// Text Style Controls
		$this->text_style_controls( 'title_text' );

		$this->add_responsive_control(
			'title_alignment',
			[
				'label'        => esc_html__( 'Title Alignment', 'zyre-elementor-addons' ),
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
					'justify' => [
						'title' => esc_html__( 'Justified', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'default'      => 'center',
				'selectors'    => [
					'{{WRAPPER}} .zyre-gradient-heading-title' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->set_style_controls(
			'title',
			[
				'selector' => '{{WRAPPER}} .zyre-gradient-heading-title',
				'controls' => [
					'zindex' => [],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __title_prefix_style_controls() {
		$this->start_controls_section(
			'section_title_prefix_style',
			[
				'label' => esc_html__( 'Title Prefix', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'title_prefix!' => '',
				],
			]
		);

		// Text Style Controls
		$this->text_style_controls( 'title_prefix' );

		$this->end_controls_section();
	}

	protected function __title_suffix_style_controls() {
		$this->start_controls_section(
			'section_suffix_title_style',
			[
				'label' => esc_html__( 'Title Suffix', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'title_suffix!' => '',
				],
			]
		);

		// Text Style Controls
		$this->text_style_controls( 'title_suffix' );

		$this->end_controls_section();
	}

	protected function __text_subtitle_style_controls() {
		$this->start_controls_section(
			'section_text_subtitle_style',
			[
				'label' => esc_html__( 'Subtitle', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'text_subtitle!' => '',
				],
			]
		);

		$this->set_style_controls(
			'subtitle',
			[
				'selector' => '{{WRAPPER}} .zyre-gradient-heading-subtitle',
				'controls' => [
					'bg'        => [
						'label'          => esc_html__( 'Set Gradient for Subtitle ', 'zyre-elementor-addons' ),
						'types'          => [ 'gradient' ],
						'fields_options' => [
							'background' => [
								'default' => 'gradient',
								'label'   => esc_html__( 'Set Gradient for Subtitle ', 'zyre-elementor-addons' ),
							],
						],
					],
					'alignment' => [
						'label'   => esc_html__( 'Subtitle Alignment', 'zyre-elementor-addons' ),
						'default' => '',
					],
				],
			]
		);

		// Text Style Controls
		$this->text_style_controls( 'subtitle' );

		$this->set_style_controls(
			'subtitle',
			[
				'selector' => '{{WRAPPER}} .zyre-gradient-heading-subtitle',
				'controls' => [
					'zindex' => [],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Text Style Controls for all sections.
	 *
	 * @param string $prefix The prefix of the controls.
	 */
	private function text_style_controls( string $prefix ) {
		$class_base = str_replace( '_', '-', $prefix );

		$this->set_style_controls(
			$prefix,
			[
				'selector' => '{{WRAPPER}} .zyre-gradient-heading-' . $class_base,
				'controls' => [
					'typography' => [],
				],
			]
		);

		// Normal Styles
		$this->start_controls_tabs( '_tab_' . $prefix );

		$this->start_controls_tab(
			$prefix . '_style_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			$prefix,
			[
				'selector' => '{{WRAPPER}} .zyre-gradient-heading-' . $class_base,
				'controls' => [
					'text_color' => [
						'label'   => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
						'default' => '',
					],
					'shadow'     => [],
					'box_shadow' => [],
					'border'     => [],
				],
			]
		);

		$this->end_controls_tab();

		// Hover Styles
		$this->start_controls_tab(
			'_tab_hover_' . $prefix,
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			$prefix . '_hover',
			[
				'selector' => "{{WRAPPER}} .zyre-gradient-heading-{$class_base}:hover",
				'controls' => [
					'color' => [
						'label'   => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
						'default' => '',
					],
					'shadow'     => [],
					'box_shadow' => [],
					'border'     => [],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->set_style_controls(
			$prefix,
			[
				'selector' => '{{WRAPPER}} .zyre-gradient-heading-' . $class_base,
				'controls' => [
					'border_radius' => [],
					'padding'       => [],
					'margin'        => [],
				],
			]
		);
	}


	protected function render() {
		$settings = $this->get_settings_for_display();
		// Add inline editing attributes
		$this->add_inline_editing_attributes( 'text_subtitle' );
		$this->add_inline_editing_attributes( 'title_suffix', 'none' );
		$this->add_inline_editing_attributes( 'title_text' );
		$this->add_inline_editing_attributes( 'title_prefix' );

		$this->add_render_attribute( 'text_subtitle', 'class', 'zyre-gradient-heading-subtitle zy-relative zy-color-transparent zy-m-0' );
		$this->add_render_attribute( 'title_text', 'class', 'zyre-gradient-heading-title-text zy-inline-block zy-lh-1' );
		$this->add_render_attribute( 'title_suffix', 'class', 'zyre-gradient-heading-title-suffix zy-inline-block zy-lh-1' );
		$this->add_render_attribute( 'title_prefix', 'class', 'zyre-gradient-heading-title-prefix zy-inline-block zy-lh-1' );

		$title_tag = ! empty( $settings['title_tag'] ) ? zyre_escape_tags( $settings['title_tag'], 'h2' ) : 'h2';

		$title_html = '<' . esc_attr( $title_tag ) . ' class="zyre-gradient-heading-title zy-relative zy-color-transparent zy-break-all zy-m-0">';

		if ( ! empty( $settings['title_prefix'] ) ) {
			$title_html .= '<span ' . $this->get_render_attribute_string( 'title_prefix' ) . '>' . esc_html( $settings['title_prefix'] ) . '</span>';
		}

		if ( ! empty( $settings['title_text'] ) ) {
			$title_html .= '<span ' . $this->get_render_attribute_string( 'title_text' ) . '>' . zyre_kses_basic( $settings['title_text'] ) . '</span>';
		}

		if ( ! empty( $settings['title_suffix'] ) ) {
			$title_html .= '<span ' . $this->get_render_attribute_string( 'title_suffix' ) . '>' . esc_html( $settings['title_suffix'] ) . '</span>';
		}

		$title_html .= '</' . esc_attr( $title_tag ) . '>';

		$subtitle_html = '';
		if ( ! empty( $settings['text_subtitle'] ) ) {
			$subtitle_html = '<p ' . $this->get_render_attribute_string( 'text_subtitle' ) . '>' . zyre_kses_basic( $settings['text_subtitle'] ) . '</p>';
		}

		// Get the order from settings
		if ( 'title_first' === $settings['title_subtitle_order'] ) {
			echo $title_html . $subtitle_html;
		} else {
			echo $subtitle_html . $title_html;
		}
	}
}
