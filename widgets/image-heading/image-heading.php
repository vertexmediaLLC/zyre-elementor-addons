<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;

defined( 'ABSPATH' ) || die();

class Image_Heading extends Base {

	public function get_title() {
		return esc_html__( 'Image Heading', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Image-heading';
	}

	public function get_keywords() {
		return [ 'heading', 'image heading', 'title', 'text', 'content', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ];
	}

	protected function register_content_controls() {
		$this->start_controls_section(
			'section_heading',
			[
				'label' => esc_html__( 'Image Heading Content', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$this->add_control(
			'title_text',
			[
				'label'       => esc_html__( 'Title Text', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'description' => zyre_get_allowed_html_desc(),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'           => 'bg_image_for_title',
				'types'          => [ 'classic' ],
				'exclude'        => [ 'color' ],
				'fields_options' => [
					'background' => [
						'default' => 'classic',
						'label'          => esc_html__( 'Set Image for Title Text ', 'zyre-elementor-addons' ),
					],
					'image' => [
						'default' => [
							'url' => \Elementor\Utils::get_placeholder_image_src(),
						],
					],
				],
				'selector' => '{{WRAPPER}} .zyre-image-heading-title-text',
				'condition' => [
					'title_text!' => '',
				],
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
				'condition' => [
					'title_text!' => '',
				],
			]
		);

		$this->add_control(
			'title_suffix',
			[
				'label'       => esc_html__( 'Title Suffix', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'description' => zyre_get_allowed_html_desc(),
			]
		);

		$this->add_control(
			'text_subtitle',
			[
				'label'       => esc_html__( 'Subtitle', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'separator'   => 'before',
			]
		);

		// Add this control right after or before your 'text_subtitle' control
		$this->add_control(
			'subtitle_position',
			[
				'label' => esc_html__( 'Subtitle Position', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'bottom',
				'options' => [
					'top'  => esc_html__( 'Top (Above Title)', 'zyre-elementor-addons' ),
					'bottom' => esc_html__( 'Bottom (Below Title)', 'zyre-elementor-addons' ),
				],
				'condition' => [
					'text_subtitle!' => '',
				],
			]
		);

		$this->add_control(
			'subtitle_tag',
			[
				'label'   => esc_html__( 'Subtitle HTML Tag', 'zyre-elementor-addons' ),
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
				'default' => 'h3',
				'toggle'  => false,
				'condition' => [
					'text_subtitle!' => '',
				],
			]
		);

		$this->add_control(
			'enable_overlay',
			[
				'label'        => esc_html__( 'Enable Overlay Image', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'zyre-elementor-addons' ),
				'label_off'    => esc_html__( 'No', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default'      => '',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'overlay_image',
			[
				'label'     => esc_html__( 'Overlay Image', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => ZYRE_ADDONS_ASSETS . 'css/widgets/image-heading/overlay.png',
				],
				'condition' => [
					'enable_overlay' => 'yes',
				],
			]
		);

		$this->add_control(
			'advance_heading_css_class',
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
		$this->__title_text_style_controls();
		$this->__title_suffix_style_controls();
		$this->__text_subtitle_style_controls();
		$this->__overlay_image_style_controls();
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

		// Text Style Controls
		$this->text_style_controls( 'subtitle' );

		$this->end_controls_section();
	}

	protected function __overlay_image_style_controls() {
		$this->start_controls_section(
			'section_overlay_image_style',
			[
				'label' => esc_html__( 'Overlay Image', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'enable_overlay' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'overlay_image',
			[
				'selector' => '{{WRAPPER}} .zyre-image-heading-overlay img',
				'controls' => [
					'width'  => [
						'range' => [
							'px' => [
								'min' => 50,
								'max' => 1000,
							],
							'%'  => [
								'min' => 10,
							],
							'vw' => [
								'min' => 10,
							],
						],
					],
					'height' => [
						'range' => [
							'px' => [
								'min' => 50,
								'max' => 1000,
							],
							'vh' => [
								'min' => 10,
							],
							'%'  => [
								'min' => 10,
							],
						],
					],
				],
			]
		);

		$this->add_control(
			'overlay_image_position',
			[
				'label' => esc_html__( 'Position', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'absolute',
				'options' => [
					'' => esc_html__( 'Default', 'zyre-elementor-addons' ),
					'absolute' => esc_html__( 'Absolute', 'zyre-elementor-addons' ),
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-image-heading-overlay' => 'position: {{VALUE}};',
				],
			]
		);

		$left = esc_html__( 'Left', 'zyre-elementor-addons' );
		$right = esc_html__( 'Right', 'zyre-elementor-addons' );

		$start = is_rtl() ? $right : $left;
		$end = ! is_rtl() ? $right : $left;

		// Horizontal
		$this->add_control(
			'overlay_image_offset_orientation_h',
			[
				'label' => esc_html__( 'Horizontal Orientation', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'toggle' => false,
				'default' => 'end',
				'options' => [
					'start' => [
						'title' => $start,
						'icon' => 'eicon-h-align-left',
					],
					'end' => [
						'title' => $end,
						'icon' => 'eicon-h-align-right',
					],
				],
				'condition' => [
					'overlay_image_position!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'overlay_image_offset_x',
			[
				'label' => esc_html__( 'Offset', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -1000,
						'max' => 1000,
					],
					'%' => [
						'min' => -200,
						'max' => 200,
					],
					'vw' => [
						'min' => -200,
						'max' => 200,
					],
					'vh' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'default' => [
					'size' => 0,
				],
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'vh', 'custom' ],
				'selectors' => [
					'body:not(.rtl) {{WRAPPER}}  .zyre-image-heading-overlay' => 'left: {{SIZE}}{{UNIT}}',
					'body.rtl {{WRAPPER}}  .zyre-image-heading-overlay' => 'right: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'overlay_image_offset_orientation_h!' => 'end',
					'overlay_image_position!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'overlay_image_offset_x_end',
			[
				'label' => esc_html__( 'Offset', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -1000,
						'max' => 1000,
					],
					'%' => [
						'min' => -200,
						'max' => 200,
					],
					'vw' => [
						'min' => -200,
						'max' => 200,
					],
					'vh' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'default' => [
					'size' => 0,
				],
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'vh', 'custom' ],
				'selectors' => [
					'body:not(.rtl) {{WRAPPER}} .zyre-image-heading-overlay' => 'right: {{SIZE}}{{UNIT}}',
					'body.rtl {{WRAPPER}} .zyre-image-heading-overlay' => 'left: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'overlay_image_offset_orientation_h' => 'end',
					'overlay_image_position!' => '',
				],
			]
		);

		// Vertical
		$this->add_control(
			'overlay_image_offset_orientation_v',
			[
				'label' => esc_html__( 'Vertical Orientation', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'toggle' => false,
				'default' => 'end',
				'options' => [
					'start' => [
						'title' => esc_html__( 'Top', 'zyre-elementor-addons' ),
						'icon' => 'eicon-v-align-top',
					],
					'end' => [
						'title' => esc_html__( 'Bottom', 'zyre-elementor-addons' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'condition' => [
					'overlay_image_position!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'overlay_image_offset_y',
			[
				'label' => esc_html__( 'Offset', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -1000,
						'max' => 1000,
					],
					'%' => [
						'min' => -200,
						'max' => 200,
					],
					'vh' => [
						'min' => -200,
						'max' => 200,
					],
					'vw' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'vw', 'custom' ],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-image-heading-overlay' => 'top: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'overlay_image_offset_orientation_v!' => 'end',
					'overlay_image_position!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'overlay_image_offset_y_end',
			[
				'label' => esc_html__( 'Offset', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -1000,
						'max' => 1000,
					],
					'%' => [
						'min' => -200,
						'max' => 200,
					],
					'vh' => [
						'min' => -200,
						'max' => 200,
					],
					'vw' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'vw', 'custom' ],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-image-heading-overlay' => 'bottom: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'overlay_image_offset_orientation_v' => 'end',
					'overlay_image_position!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'overlay_image_z_index',
			[
				'label'     => esc_html__( 'Z-Index', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 0,
				'default'   => 1,
				'selectors' => [
					'{{WRAPPER}} .zyre-image-heading-overlay' => 'z-index: {{VALUE}};',
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
				'selector' => '{{WRAPPER}} .zyre-image-heading-' . $class_base,
				'controls' => [
					'typography' => [],
					'alignment'  => [
						'label' => esc_html__( 'Text Alignment', 'zyre-elementor-addons' ),
					],
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
				'selector' => '{{WRAPPER}} .zyre-image-heading-' . $class_base,
				'controls' => [
					'text_color' => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
					'background' => [],
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
				'selector' => "{{WRAPPER}} .zyre-image-heading-{$class_base}:hover",
				'controls' => [
					'color' => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
					'background' => [],
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
				'selector' => '{{WRAPPER}} .zyre-image-heading-' . $class_base,
				'controls' => [
					'border_radius' => [],
					'padding'       => [],
					'margin'        => [],
					'zindex'        => [],
				],
			]
		);
	}


	protected function render() {
		$settings = $this->get_settings_for_display();

		// --- Get Settings ---
		$title_text = $settings['title_text'];
		$title_suffix = $settings['title_suffix'];
		$subtitle_text = $settings['text_subtitle'];
		$subtitle_position = $settings['subtitle_position']; // Get the new setting value

		$title_tag = ! empty( $settings['title_tag'] ) ? zyre_escape_tags( $settings['title_tag'], 'h2' ) : 'h2';
		$subtitle_tag = ! empty( $settings['subtitle_tag'] ) ? zyre_escape_tags( $settings['subtitle_tag'], 'h3' ) : 'h3';
		$overlay_image = ( ! empty( $settings['overlay_image']['url'] ) && 'yes' === $settings['enable_overlay'] ) ? $settings['overlay_image']['url'] : '';

		// --- Add Inline Editing & Render Attributes ---
		$this->add_inline_editing_attributes( 'text_subtitle' );
		$this->add_inline_editing_attributes( 'title_suffix', 'none' );
		$this->add_inline_editing_attributes( 'title_text' );

		$this->add_render_attribute( 'text_subtitle', 'class', 'zyre-image-heading-subtitle zy-relative zy-lh-normal zy-m-0' );
		$this->add_render_attribute( 'title_text', 'class', 'zyre-image-heading-title-text zy-relative zy-inline-block zy-color-transparent zy-bg-size-100 zy-bg-center zy-bg-clip-text' );
		$this->add_render_attribute( 'title_suffix', 'class', 'zyre-image-heading-title-suffix zy-relative zy-inline-block zy-v-text-top' );

		// --- Prepare Title HTML ---
		// We create functions/variables for title and subtitle blocks to avoid repetition
		$title_html = '';
		if ( ! empty( $title_text ) || ! empty( $title_suffix ) ) { // Check if there's anything to wrap in the title tag
			$title_html .= sprintf( '<%s class="zyre-image-heading-title zy-m-0 zy-lh-normal">', esc_attr( $title_tag ) );
			if ( ! empty( $title_text ) ) {
				$title_html .= sprintf( '<span %1$s>%2$s</span>', $this->get_render_attribute_string( 'title_text' ), zyre_kses_basic( $title_text ) );
			}
			if ( ! empty( $title_suffix ) ) {
				$title_html .= sprintf( ' <span %1$s>%2$s</span>', $this->get_render_attribute_string( 'title_suffix' ), zyre_kses_basic( $title_suffix ) ); // Added space before suffix span
			}
			$title_html .= sprintf( '</%s>', esc_attr( $title_tag ) );
		}

		// --- Prepare Subtitle HTML ---
		$subtitle_html = '';
		if ( ! empty( $subtitle_text ) ) {
			$subtitle_html = sprintf(
				'<%1$s %2$s>%3$s</%1$s>',
				esc_attr( $subtitle_tag ),
				$this->get_render_attribute_string( 'text_subtitle' ),
				zyre_kses_basic( $subtitle_text )
			);
		}

		// --- Render Output ---
		?>
		<div class="zyre-image-heading-wrapper zy-relative zy-text-center">
			<?php
			// Conditionally render subtitle based on position
			if ( 'top' === $subtitle_position && ! empty( $subtitle_html ) ) {
				echo $subtitle_html; // Subtitle first
			}

			// Render Title
			echo $title_html;

			// Conditionally render subtitle based on position (default case)
			if ( 'bottom' === $subtitle_position && ! empty( $subtitle_html ) ) {
				echo $subtitle_html; // Subtitle second
			}
			?>
	
			<?php if ( $overlay_image ) : ?>
				<div class="zyre-image-heading-overlay zy-inline-block">
					<img src="<?php echo esc_url( $overlay_image ); ?>" alt="<?php echo esc_attr__( 'Overlay Image', 'zyre-elementor-addons' ); ?>">
				</div>
			<?php endif; ?>
		</div>
		<?php
	}
}

