<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;

defined( 'ABSPATH' ) || die();

class Dual_Color_Heading extends Base {

	public function get_title() {
		return esc_html__( 'Dual Color Heading', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Dual-color-heading';
	}

	public function get_keywords() {
		return [ 'dual heading', 'dual color heading', 'title', 'text', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ];
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	protected function register_content_controls() {
		$this->start_controls_section(
			'section_heading',
			[
				'label' => esc_html__( 'Dual Color Content', 'zyre-elementor-addons' ),
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
				'default'     => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'title_prefix',
			[
				'label'       => esc_html__( 'Title Prefix', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Dual', 'zyre-elementor-addons' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'title_suffix',
			[
				'label'       => esc_html__( 'Title Suffix', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Heading', 'zyre-elementor-addons' ),
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

		$this->add_responsive_control(
			'title_alignment',
			[
				'label'        => esc_html__( 'Text Alignment', 'zyre-elementor-addons' ),
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
					'{{WRAPPER}} .zyre-dual-color-heading-title' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'advance_heading_css_class',
			[
				'label'       => esc_html__( 'Class', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Class Name', 'zyre-elementor-addons' ),
				'prefix_class' => '',
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_controls() {
		$this->__general_style_controls();
		$this->__title_text_style_controls();
		$this->__title_prefix_style_controls();
		$this->__title_suffix_style_controls();
	}

	protected function __general_style_controls() {
		$this->start_controls_section(
			'section_general_style',
			[
				'label' => esc_html__( 'General', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'title',
			[
				'selector' => '{{WRAPPER}} .zyre-dual-color-heading-title',
				'controls' => [
					'typography' => [],
				],
			]
		);

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

		$this->text_style_controls( 'title_text' );

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

		$this->text_style_controls( 'title_suffix' );

		$this->end_controls_section();
	}

	/**
	 * Text Style Controls for all sections.
	 *
	 * @param string $prefix The prefix of the controls.
	 */
	private function text_style_controls( string $prefix ) {
		$class_base = str_replace( '_', '-', $prefix );

		$this->add_control(
			$prefix . '_display',
			[
				'label'     => esc_html__( 'Display as', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'block'        => esc_html__( 'Block', 'zyre-elementor-addons' ),
					'inline-block' => esc_html__( 'Inline Block', 'zyre-elementor-addons' ),
					'inline'       => esc_html__( 'Inline', 'zyre-elementor-addons' ),
					'table'        => esc_html__( 'Table', 'zyre-elementor-addons' ),
				],
				'default'   => 'inline-block',
				'selectors' => [
					'{{WRAPPER}} .zyre-dual-color-heading-' . $class_base => 'display: {{VALUE}};',
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
				'selector' => '{{WRAPPER}} .zyre-dual-color-heading-' . $class_base,
				'controls' => [
					'text_color' => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
					'background' => [
						'exclude' => [],
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
				'selector' => "{{WRAPPER}} .zyre-dual-color-heading-{$class_base}:hover",
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
				'selector' => '{{WRAPPER}} .zyre-dual-color-heading-' . $class_base,
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

		// Add inline editing attributes
		$this->add_inline_editing_attributes( 'title_text' );
		$this->add_inline_editing_attributes( 'title_prefix' );
		$this->add_inline_editing_attributes( 'title_suffix', 'none' );

		// Add HTML class
		$this->add_render_attribute( 'title_text', 'class', 'zyre-dual-color-heading-title-text zy-lh-1.2 zy-inline-block zy-relative' );
		$this->add_render_attribute( 'title_prefix', 'class', 'zyre-dual-color-heading-title-prefix zy-inline-block zy-relative' );
		$this->add_render_attribute( 'title_suffix', 'class', 'zyre-dual-color-heading-title-suffix zy-inline-block zy-relative' );
		?>
	
		<<?php echo zyre_escape_tags( $settings['title_tag'], 'h2' ); ?> class="zyre-dual-color-heading-title zy-m-0">
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
