<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;

defined( 'ABSPATH' ) || die();

class Site_Tagline extends Base {

	public function get_title() {
		return esc_html__( 'Site Tagline', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Site-tagline';
	}

	public function get_keywords() {
		return [ 'site tagline', 'tagline', 'site', 'site info', 'site description', 'description', 'site brand', 'brand description' ];
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	// Widget Content controls
	protected function register_content_controls() {

		$this->start_controls_section(
			'section_site_tagline_content',
			[
				'label' => esc_html__( 'Site Tagline Content', 'zyre-elementor-addons' ),
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$this->add_control(
			'before',
			[
				'label'   => esc_html__( 'Before Tagline Text', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$before_spacing_prop = is_rtl() ? 'margin-left' : 'margin-right';
		$this->add_control(
			'before_spacing',
			[
				'label'     => esc_html__( 'Before Text Spacing', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'before[value]!' => '',
				],
				'default' => [
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-site-tagline-prefix' => "{$before_spacing_prop}: {{SIZE}}{{UNIT}};",
				],
			]
		);

		$this->add_control(
			'after',
			[
				'label'   => esc_html__( 'After Tagline Text', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$after_spacing_prop = is_rtl() ? 'margin-right' : 'margin-left';
		$this->add_control(
			'after_spacing',
			[
				'label'     => esc_html__( 'After Text Spacing', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'after[value]!' => '',
				],
				'default' => [
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-site-tagline-suffix' => "{$after_spacing_prop}: {{SIZE}}{{UNIT}};",
				],
			]
		);

		$this->add_control(
			'site_tagline_icon',
			[
				'label'       => esc_html__( 'Icon', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => 'true',
			]
		);

		$this->add_control(
			'site_tagline_icon_position',
			[
				'label'   => esc_html__( 'Icon Position', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'condition' => [
					'site_tagline_icon[value]!' => '',
				],
				'options' => [
					'before' => esc_html__( 'Before', 'zyre-elementor-addons' ),
					'after'  => esc_html__( 'After', 'zyre-elementor-addons' ),
				],
				'default' => 'before',
			]
		);

		$icon_indent_before = is_rtl() ? 'margin-left' : 'margin-right';
		$icon_indent_after  = is_rtl() ? 'margin-right' : 'margin-left';
		$this->add_control(
			'icon_indent',
			[
				'label'     => esc_html__( 'Icon Spacing', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'site_tagline_icon[value]!' => '',
				],
				'default' => [
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-site-tagline-icon--before' => "{$icon_indent_before}: {{SIZE}}{{UNIT}};",
					'{{WRAPPER}} .zyre-site-tagline-icon--after' => "{$icon_indent_after}: {{SIZE}}{{UNIT}};",
				],
			]
		);

		$this->add_control(
			'site_tagline_tag',
			[
				'label'   => esc_html__( 'HTML Tag', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'h1' => [
						'title' => esc_html__( 'H1', 'zyre-elementor-addons' ),
					],
					'h2' => [
						'title' => esc_html__( 'H2', 'zyre-elementor-addons' ),
					],
					'h3' => [
						'title' => esc_html__( 'H3', 'zyre-elementor-addons' ),
					],
					'h4' => [
						'title' => esc_html__( 'H4', 'zyre-elementor-addons' ),
					],
					'h5' => [
						'title' => esc_html__( 'H5', 'zyre-elementor-addons' ),
					],
					'h6' => [
						'title' => esc_html__( 'H6', 'zyre-elementor-addons' ),
					],
					'p' => [
						'title' => esc_html__( 'P', 'zyre-elementor-addons' ),
					],
					'span' => [
						'title' => esc_html__( 'Span', 'zyre-elementor-addons' ),
					],
					'div' => [
						'title' => esc_html__( 'Div', 'zyre-elementor-addons' ),
					],
				],
				'default' => 'p',
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
				'default'      => is_rtl() ? 'right' : 'left',
				'selectors'          => [
					'{{WRAPPER}} .zyre-site-tagline' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	// Widget Style controls
	protected function register_style_controls() {
		$this->__before_tagline_style_controls();
		$this->__tagline_style_controls();
		$this->__tagline_after_style_controls();
		$this->__icon_style_controls();
	}

	protected function __before_tagline_style_controls() {
		$this->start_controls_section(
			'section_site_tagline_before_style',
			[
				'label' => esc_html__( 'Before Tagline', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'before[value]!' => '',
				],
			]
		);

		$this->text_style_controls( 'tagline_before' );

		$this->end_controls_section();
	}

	protected function __tagline_style_controls() {
		$this->start_controls_section(
			'section_site_tagline_style',
			[
				'label' => esc_html__( 'Tagline', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->text_style_controls( 'tagline' );

		$this->end_controls_section();
	}

	protected function __tagline_after_style_controls() {
		$this->start_controls_section(
			'section_site_tagline_after_style',
			[
				'label' => esc_html__( 'After Tagline', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'after[value]!' => '',
				],
			]
		);

		$this->text_style_controls( 'tagline_after' );

		$this->end_controls_section();
	}

	protected function __icon_style_controls() {
		$this->start_controls_section(
			'section_site_tagline_icon_style',
			[
				'label' => esc_html__( 'Icon', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'site_tagline_icon[value]!' => '',
				],
			]
		);

		$this->set_style_controls(
			'tagline',
			[
				'selector' => '{{WRAPPER}} .zyre-site-tagline-icon',
				'controls' => [
					'icon_size'  => [
						'default' => [
							'size' => 16,
						],
					],
					'icon_color' => [
						'label' => esc_html__( 'Color', 'zyre-elementor-addons' ),
					],
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

		$class_base = 'tagline';
		if ( 'tagline_before' === $prefix ) {
			$class_base = 'tagline-prefix';
		} elseif ( 'tagline_after' === $prefix ) {
			$class_base = 'tagline-suffix';
		}

		$this->set_style_controls(
			$prefix,
			[
				'selector' => '{{WRAPPER}} .zyre-site-' . $class_base,
				'controls' => [
					'typography'  => [],
					'color'       => [],
					'text_shadow' => [],
				],
			]
		);
	}

	// Widget Display
	protected function render() {

		$settings = $this->get_settings();
		$tagline    = get_bloginfo( 'description' );
		$icon_position = $settings['site_tagline_icon_position'];

		if ( $tagline ) {
			?>
			<<?php echo zyre_escape_tags( $settings['site_tagline_tag'], 'p' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> class="zyre-site-tagline zy-flex zy-align-center zy-m-0">
				<?php if ( 'before' === $icon_position ) : ?>
					<span class="zyre-site-tagline-icon zyre-site-tagline-icon--<?php echo esc_attr( $icon_position ); ?>">
						<?php zyre_render_icon( $settings, 'icon', 'site_tagline_icon' ); ?>
					</span>
				<?php endif; ?>	

				<?php if ( '' !== $settings['before'] ) : ?>
					<span class="zyre-site-tagline-prefix"><?php echo esc_html( $settings['before'] ); ?></span>
				<?php endif; ?>

				<span class="zyre-site-tagline-text"><?php echo esc_html( $tagline ); ?></span>

				<?php if ( '' !== $settings['after'] ) : ?>
					<span class="zyre-site-tagline-suffix"><?php echo esc_html( $settings['after'] ); ?></span>
				<?php endif;
				?>

				<?php if ( 'after' === $icon_position ) : ?>
					<span class="zyre-site-tagline-icon zyre-site-tagline-icon--<?php echo esc_attr( $icon_position ); ?>">
						<?php zyre_render_icon( $settings, 'icon', 'site_tagline_icon' ); ?>					
					</span>
				<?php endif; ?>
			</<?php echo zyre_escape_tags( $settings['site_tagline_tag'], 'p' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<?php
		}
	}
}
