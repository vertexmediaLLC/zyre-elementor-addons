<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;

defined( 'ABSPATH' ) || die();

class Advance_Heading extends Base {

	public function get_title() {
		return esc_html__( 'Advance Heading', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Advance-heading';
	}

	public function get_keywords() {
		return [ 'heading', 'headings', 'advance heading', 'title', 'content', 'text', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ];
	}

	protected function register_content_controls() {
		$this->start_controls_section(
			'section_heading',
			[
				'label' => esc_html__( 'Advance Heading Content', 'zyre-elementor-addons' ),
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
			'title_layout',
			[
				'label'          => esc_html__( 'Layout', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::CHOOSE,
				'default'        => '',
				'options'        => [
					'block'  => [
						'title' => esc_html__( 'Block', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-editor-list-ul',
					],
					'inline' => [
						'title' => esc_html__( 'Inline', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-ellipsis-h',
					],
				],
				'render_type'    => 'template',
				'style_transfer' => true,
				'prefix_class'   => 'zyre-advance-heading--layout-',
			]
		);

		$this->add_responsive_control(
			'title_gap',
			[
				'label'      => esc_html__( 'Gap', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', 'vw' ],
				'range'      => [
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-advance-heading-title' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'advance_heading_css_class',
			[
				'label'        => esc_html__( 'Class', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::TEXT,
				'placeholder'  => esc_html__( 'Class Name', 'zyre-elementor-addons' ),
				'prefix_class' => '',
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_controls() {
		$this->__title_prefix_style_controls();
		$this->__title_text_style_controls();
		$this->__title_suffix_style_controls();
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

		$this->text_style_controls( 'title_prefix' );

		// Separator Style Controls
		$this->separator_style_controls( 'title_prefix_separator', 'title-prefix' );

		$this->end_controls_section();
	}

	protected function __title_text_style_controls() {
		$this->start_controls_section(
			'section_title_text_style',
			[
				'label' => esc_html__( 'Title Text', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'title_text!' => '',
				],
			]
		);

		// Text Style Controls
		$this->text_style_controls( 'title_text' );

		// Separator Style Controls
		$this->separator_style_controls( 'title_text_separator', 'title-text' );

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

		$this->text_style_controls( 'title_suffix' );

		// Separator Style Controls
		$this->separator_style_controls( 'title_suffix_separator', 'title-suffix' );

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
				'selector' => '{{WRAPPER}} .zyre-advance-heading-' . $class_base,
				'controls' => [
					'typography' => [],
					'alignment'  => [],
					'align_x'    => [
						'options'   => [
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
						'condition' => [
							'title_layout' => 'block',
						],
					],
				],
			]
		);

		// Tabs: Title prefix colors
		$this->start_controls_tabs( $prefix . '_colors_tabs' );

		// Tab: Normal
		$this->start_controls_tab(
			$prefix . '_colors_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			$prefix,
			[
				'selector' => '{{WRAPPER}} .zyre-advance-heading-' . $class_base,
				'controls' => [
					'text_color'      => [],
					'background'      => [],
					'background_clip' => [],
					'shadow'          => [],
					'box_shadow'      => [],
					'border'          => [],
				],
			]
		);

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab(
			$prefix . '_colors_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			$prefix . '_hover',
			[
				'selector' => "{{WRAPPER}} .zyre-advance-heading-{$class_base}:hover",
				'controls' => [
					'color'           => [],
					'background'      => [],
					'background_clip' => [],
					'shadow' => [],
					'box_shadow' => [],
					'border' => [],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->set_style_controls(
			$prefix,
			[
				'selector' => '{{WRAPPER}} .zyre-advance-heading-' . $class_base,
				'controls' => [
					'border_radius' => [
						'separator' => 'before',
					],
					'padding'       => [],
					'margin'        => [],
					'offset_x'      => [],
					'offset_y'      => [],
					'zindex'        => [],
				],
			]
		);
	}

	/**
	 * Separator Style Controls for all sections.
	 *
	 * @param string $prefix The prefix of the controls.
	 * @param string $class_base This will help to select controls/elements.
	 */
	private function separator_style_controls( string $prefix, string $class_base ) {

		$this->add_control(
			'_heading_' . $prefix,
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Separators Style', 'zyre-elementor-addons' ),
				'separator' => 'before',
			]
		);

		$this->set_style_controls(
			$prefix,
			[
				'controls' => [
					'switch' => [],
				],
			]
		);
		
		$this->set_style_controls(
			$prefix,
			[
				'selector'  => '{{WRAPPER}} .zyre-advance-heading-' . $class_base,
				'controls'  => [
					'layout' => [
						'options'              => [
							'block'  => [
								'title' => esc_html__( 'Block', 'zyre-elementor-addons' ),
								'icon'  => 'eicon-editor-list-ul',
							],
							'inline' => [
								'title' => esc_html__( 'Inline', 'zyre-elementor-addons' ),
								'icon'  => 'eicon-ellipsis-h',
							],
						],
						'selectors_dictionary' => [
							'inline' => '-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;-ms-flex-direction:row;flex-direction:row;',
							'block'  => '-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;-ms-flex-direction:column;flex-direction:column;',
						],
					],
					'gap'    => [],
				],
				'condition' => [
					$prefix . '_switch' => 'yes',
				],
			]
		);

		// Tabs: Separator
		$this->start_controls_tabs( $prefix . '_separator_tabs' );

		// Tab: Left Separator
		$this->start_controls_tab(
			$prefix . '_left_tab',
			[
				'label' => esc_html__( 'Left Separator', 'zyre-elementor-addons' ),
				'condition' => [
					$prefix . '_switch' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			$prefix . '_left',
			[
				'controls'  => [
					'switch' => [
						'label' => esc_html__( 'Left Separator', 'zyre-elementor-addons' ),
					],
				],
				'condition' => [
					$prefix . '_switch' => 'yes',
				],
			]
		);

		$this->add_control(
			'_alert_left_' . $prefix,
			[
				'type'      => Controls_Manager::RAW_HTML,
				'raw'       => esc_html__( 'Set width, & border type, color for appearance.', 'zyre-elementor-addons' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'condition' => [
					$prefix . '_switch' => 'yes',
					$prefix . '_left_switch' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			$prefix . '_left',
			[
				'selector'  => '{{WRAPPER}} .zyre-advance-heading-' . $class_base . '::before',
				'controls'  => [
					'border'        => [],
					'position_x'    => [
						'condition' => [
							$prefix . '_switch'      => 'yes',
							$prefix . '_left_switch' => 'yes',
							$prefix . '_layout'      => ['block'],
						],
					],
					'position_y'    => [
						'condition' => [
							$prefix . '_switch'      => 'yes',
							$prefix . '_left_switch' => 'yes',
							$prefix . '_layout'      => ['inline', ''],
						],
					],
					'width'         => [],
					'margin'        => [],
					'border_radius' => [],
				],
				'condition' => [
					$prefix . '_switch'      => 'yes',
					$prefix . '_left_switch' => 'yes',
				],
			]
		);

		$this->end_controls_tab();

		// Tab: Right Separator
		$this->start_controls_tab(
			$prefix . '_right_tab',
			[
				'label' => esc_html__( 'Right Separator', 'zyre-elementor-addons' ),
				'condition' => [
					$prefix . '_switch' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			$prefix . '_right',
			[
				'controls'  => [
					'switch' => [
						'label' => esc_html__( 'Right Separator', 'zyre-elementor-addons' ),
					],
				],
				'condition' => [
					$prefix . '_switch' => 'yes',
				],
			]
		);

		$this->add_control(
			'_alert_right_' . $prefix,
			[
				'type'      => Controls_Manager::RAW_HTML,
				'raw'       => esc_html__( 'Set width, & border type, color for appearance.', 'zyre-elementor-addons' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'condition' => [
					$prefix . '_switch' => 'yes',
					$prefix . '_right_switch' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			$prefix . '_right',
			[
				'selector'  => '{{WRAPPER}} .zyre-advance-heading-' . $class_base . '::after',
				'controls'  => [
					'border'        => [],
					'position_x'    => [
						'condition' => [
							$prefix . '_switch'      => 'yes',
							$prefix . '_right_switch' => 'yes',
							$prefix . '_layout'      => ['block'],
						],
					],
					'position_y'    => [
						'condition' => [
							$prefix . '_switch'      => 'yes',
							$prefix . '_right_switch' => 'yes',
							$prefix . '_layout'      => ['inline', ''],
						],
					],
					'width'         => [],
					'margin'        => [],
					'border_radius' => [],
				],
				'condition' => [
					$prefix . '_switch'      => 'yes',
					$prefix . '_right_switch' => 'yes',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		// Add inline editing attributes
		$this->add_inline_editing_attributes( 'title_text' );
		$this->add_inline_editing_attributes( 'title_prefix' );
		$this->add_inline_editing_attributes( 'title_suffix', 'none' );

		// Add HTML class
		$this->add_render_attribute( 'title_text', 'class', 'zyre-advance-heading-title-text zy-relative zy-inline-flex zy-align-center zy-transition' );
		$this->add_render_attribute( 'title_prefix', 'class', 'zyre-advance-heading-title-prefix zy-relative zy-inline-flex zy-align-center zy-transition' );
		$this->add_render_attribute( 'title_suffix', 'class', 'zyre-advance-heading-title-suffix zy-relative zy-inline-flex zy-align-center zy-transition' );

		if ( ! empty( $settings['title_text_separator_switch'] ) && 'yes' === $settings['title_text_separator_switch'] ) {
			if ( ! empty( $settings['title_text_separator_left_switch'] ) && 'yes' === $settings['title_text_separator_left_switch'] ) {
				$this->add_render_attribute( 'title_text', 'class', 'has--separator-left' );
			}
			if ( ! empty( $settings['title_text_separator_right_switch'] ) && 'yes' === $settings['title_text_separator_right_switch'] ) {
				$this->add_render_attribute( 'title_text', 'class', 'has--separator-right' );
			}
		}

		if ( ! empty( $settings['title_prefix_separator_switch'] ) && 'yes' === $settings['title_prefix_separator_switch'] ) {
			if ( ! empty( $settings['title_prefix_separator_left_switch'] ) && 'yes' === $settings['title_prefix_separator_left_switch'] ) {
				$this->add_render_attribute( 'title_prefix', 'class', 'has--separator-left' );
			}
			if ( ! empty( $settings['title_prefix_separator_right_switch'] ) && 'yes' === $settings['title_prefix_separator_right_switch'] ) {
				$this->add_render_attribute( 'title_prefix', 'class', 'has--separator-right' );
			}
		}

		if ( ! empty( $settings['title_suffix_separator_switch'] ) && 'yes' === $settings['title_suffix_separator_switch'] ) {
			if ( ! empty( $settings['title_suffix_separator_left_switch'] ) && 'yes' === $settings['title_suffix_separator_left_switch'] ) {
				$this->add_render_attribute( 'title_suffix', 'class', 'has--separator-left' );
			}
			if ( ! empty( $settings['title_suffix_separator_right_switch'] ) && 'yes' === $settings['title_suffix_separator_right_switch'] ) {
				$this->add_render_attribute( 'title_suffix', 'class', 'has--separator-right' );
			}
		}
		?>
	
		<<?php echo zyre_escape_tags( $settings['title_tag'], 'h2' ); ?> class="zyre-advance-heading-title zy-text-center zy-relative zy-flex zy-align-center zy-justify-center zy-m-0">
			<?php if ( ! empty( $settings['title_prefix'] ) ) : ?>
				<span <?php echo $this->get_render_attribute_string( 'title_prefix' ); ?>>
					<?php echo zyre_kses_basic( $settings['title_prefix'] ); ?>
				</span>
			<?php endif; ?>
	
			<?php if ( ! empty( $settings['title_text'] ) ) : ?>
				<span <?php echo $this->get_render_attribute_string( 'title_text' ); ?>>
					<?php echo esc_html( $settings['title_text'] ); ?>
				</span>
			<?php endif; ?>
	
			<?php if ( ! empty( $settings['title_suffix'] ) ) : ?>
				<span <?php echo $this->get_render_attribute_string( 'title_suffix' ); ?>>
					<?php echo esc_html( $settings['title_suffix'] ); ?>
				</span>
			<?php endif; ?>
		</<?php echo zyre_escape_tags( $settings['title_tag'], 'h2' ); ?>>
		<?php
	}
}

