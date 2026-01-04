<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;

defined( 'ABSPATH' ) || die();

class Site_Title extends Base {

	public function get_title() {
		return esc_html__( 'Site Title', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Site-title';
	}

	public function get_keywords() {
		return array( 'site title', 'site info', 'site', 'title', 'brand name', 'brand' );
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	// Widget Content controls
	protected function register_content_controls() {

		$this->start_controls_section(
			'section_site_title_content',
			array(
				'label' => esc_html__( 'Site Title Content', 'zyre-elementor-addons' ),
			)
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$this->add_control(
			'before',
			array(
				'label'   => esc_html__( 'Before Title Text', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$before_spacing_prop = is_rtl() ? 'margin-left' : 'margin-right';
		$this->add_control(
			'before_spacing',
			array(
				'label'     => esc_html__( 'Before Text Spacing', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 50,
					),
				),
				'condition' => array(
					'before[value]!' => '',
				),
				'default'   => array(
					'size' => 10,
				),
				'selectors' => array(
					'{{WRAPPER}} .zyre-site-title-prefix' => "{$before_spacing_prop}: {{SIZE}}{{UNIT}};",
				),
			)
		);

		$this->add_control(
			'after',
			array(
				'label'   => esc_html__( 'After Title Text', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$after_spacing_prop = is_rtl() ? 'margin-right' : 'margin-left';
		$this->add_control(
			'after_spacing',
			array(
				'label'     => esc_html__( 'After Text Spacing', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 50,
					),
				),
				'condition' => array(
					'after[value]!' => '',
				),
				'default'   => array(
					'size' => 10,
				),
				'selectors' => array(
					'{{WRAPPER}} .zyre-site-title-suffix' => "{$after_spacing_prop}: {{SIZE}}{{UNIT}};",
				),
			)
		);

		$this->add_control(
			'site_title_icon',
			array(
				'label'       => esc_html__( 'Icon', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => 'true',
			)
		);

		$this->add_control(
			'site_title_icon_position',
			array(
				'label'     => esc_html__( 'Icon Position', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'condition' => array(
					'site_title_icon[value]!' => '',
				),
				'options'   => array(
					'before' => esc_html__( 'Before', 'zyre-elementor-addons' ),
					'after'  => esc_html__( 'After', 'zyre-elementor-addons' ),
				),
				'default'   => 'before',
			)
		);

		$icon_indent_before = is_rtl() ? 'margin-left' : 'margin-right';
		$icon_indent_after  = is_rtl() ? 'margin-right' : 'margin-left';
		$this->add_control(
			'icon_indent',
			array(
				'label'     => esc_html__( 'Icon Spacing', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 50,
					),
				),
				'condition' => array(
					'site_title_icon[value]!' => '',
				),
				'default'   => array(
					'size' => 10,
				),
				'selectors' => array(
					'{{WRAPPER}} .zyre-site-title-icon--before' => "{$icon_indent_before}: {{SIZE}}{{UNIT}};",
					'{{WRAPPER}} .zyre-site-title-icon--after' => "{$icon_indent_after}: {{SIZE}}{{UNIT}};",
				),
			)
		);

		$this->add_control(
			'link',
			array(
				'label'   => esc_html__( 'Link', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'default' => esc_html__( 'Default', 'zyre-elementor-addons' ),
					'custom'  => esc_html__( 'Custom URL', 'zyre-elementor-addons' ),
				),
				'default' => 'default',
			)
		);

		$this->add_control(
			'custom_link',
			array(
				'label'       => esc_html__( 'Link', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'zyre-elementor-addons' ),
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => array(
					'url' => get_home_url(),
				),
				'condition'   => array(
					'link' => 'custom',
				),
			)
		);

		$this->add_control(
			'site_title_tag',
			array(
				'label'   => esc_html__( 'HTML Tag', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'h1' => array(
						'title' => esc_html__( 'H1', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-editor-h1',
					),
					'h2' => array(
						'title' => esc_html__( 'H2', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-editor-h2',
					),
					'h3' => array(
						'title' => esc_html__( 'H3', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-editor-h3',
					),
					'h4' => array(
						'title' => esc_html__( 'H4', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-editor-h4',
					),
					'h5' => array(
						'title' => esc_html__( 'H5', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-editor-h5',
					),
					'h6' => array(
						'title' => esc_html__( 'H6', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-editor-h6',
					),
				),
				'default' => 'h1',
				'toggle'  => false,
			)
		);

		$this->add_responsive_control(
			'alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'flex-start' => array(
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'fa fa-align-left',
					),
					'center'     => array(
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'fa fa-align-center',
					),
					'flex-end'   => array(
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .zyre-site-title-link' => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	// Widget Style controls
	protected function register_style_controls() {
		$this->__before_title_style_controls();
		$this->__title_style_controls();
		$this->__title_after_style_controls();
		$this->__icon_style_controls();
	}

	protected function __before_title_style_controls() {
		$this->start_controls_section(
			'section_site_title_before_style',
			array(
				'label'     => esc_html__( 'Before Title', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'before[value]!' => '',
				),
			)
		);

		$this->text_style_controls( 'title_before' );

		$this->end_controls_section();
	}

	protected function __title_style_controls() {
		$this->start_controls_section(
			'section_site_title_style',
			array(
				'label' => esc_html__( 'Title', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->text_style_controls( 'title' );

		$this->end_controls_section();
	}

	protected function __title_after_style_controls() {
		$this->start_controls_section(
			'section_site_title_after_style',
			array(
				'label'     => esc_html__( 'After Title', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'after[value]!' => '',
				),
			)
		);

		$this->text_style_controls( 'title_after' );

		$this->end_controls_section();
	}

	protected function __icon_style_controls() {
		$this->start_controls_section(
			'section_site_title_icon_style',
			array(
				'label'     => esc_html__( 'Icon', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'site_title_icon[value]!' => '',
				),
			)
		);

		$this->add_control(
			'icon_size',
			array(
				'label'     => esc_html__( 'Icon Size', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 50,
					),
				),
				'default'   => array(
					'size' => 16,
				),
				'selectors' => array(
					'{{WRAPPER}} .zyre-site-title-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		// Tabs
		$this->start_controls_tabs( 'site_title_icon_style_tabs' );

		// Tab: Normal
		$this->start_controls_tab(
			'site_title_icon_normal_tab',
			array(
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label'     => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .zyre-site-title-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-site-title-icon svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab(
			'site_title_icon_hover_tab',
			array(
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			)
		);

		$this->add_control(
			'icon_hover_color',
			array(
				'label'     => esc_html__( 'Hover Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .zyre-site-title-link:hover .zyre-site-title-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-site-title-link:hover .zyre-site-title-icon svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Text Style Controls for all sections.
	 *
	 * @param string $prefix The prefix of the controls.
	 */
	private function text_style_controls( string $prefix ) {
		$class_base = 'title-heading';
		if ( 'title_before' === $prefix ) {
			$class_base = 'title-prefix';
		} elseif ( 'title_after' === $prefix ) {
			$class_base = 'title-suffix';
		}

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => $prefix . '_typography',
				'selector' => '{{WRAPPER}} .zyre-site-' . $class_base,
			)
		);

		$this->add_control(
			$prefix . '_padding',
			array(
				'label'      => esc_html__( 'Padding', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'selectors'  => array(
					'{{WRAPPER}} .zyre-site-' . $class_base => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		// Tabs.
		$this->start_controls_tabs(
			$prefix . '_style_tabs'
		);

		// Tab: Normal.
		$this->start_controls_tab(
			$prefix . '_normal_tab',
			array(
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			)
		);

		$this->add_control(
			$prefix . '_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .zyre-site-' . $class_base => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			$prefix . '_color',
			array(
				'label'     => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .zyre-site-' . $class_base => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => $prefix . '_text_shadow',
				'selector' => '{{WRAPPER}} .zyre-site-' . $class_base,
			)
		);

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab(
			$prefix . '_hover_tab',
			array(
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			)
		);

		$this->add_control(
			$prefix . '_hover_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .zyre-site-' . $class_base => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			$prefix . '_hover_color',
			array(
				'label'     => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					"{{WRAPPER}} .zyre-site-title-link:hover .zyre-site-{$class_base}" => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => $prefix . '_hover_text_shadow',
				'selector' => "{{WRAPPER}} .zyre-site-title-link:hover .zyre-site-{$class_base}",
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
	}

	// Widget Display
	protected function render() {

		$settings      = $this->get_settings();
		$title         = get_bloginfo( 'name' );
		$icon_position = $settings['site_title_icon_position'];

		if ( 'custom' === $settings['link'] && ! empty( $settings['custom_link']['url'] ) ) {
			$this->add_link_attributes( 'url', $settings['custom_link'] );
		} else {
			$this->add_render_attribute( 'url', 'href', esc_url( get_home_url() ) );
		}

		$this->add_render_attribute( 'url', 'class', 'zyre-site-title-link zy-flex zy-color-black' );
		?>
		<a <?php $this->print_render_attribute_string( 'url' ); ?>>
			<<?php echo zyre_escape_tags( $settings['site_title_tag'], 'h1' ); ?> class="zyre-site-title-heading zy-inline-flex zy-align-center zy-m-0 zy-lh-1.5">
				<?php if ( 'before' === $icon_position ) : ?>
					<?php $this->render_icon( $settings, $icon_position ); ?>
				<?php endif; ?>	

				<?php if ( '' !== $settings['before'] ) : ?>
					<span class="zyre-site-title-prefix"><?php echo esc_html( $settings['before'] ); ?></span>
				<?php endif; ?>

				<span class="zyre-site-title"><?php echo esc_html( $title ); ?></span>

				<?php if ( '' !== $settings['after'] ) : ?>
					<span class="zyre-site-title-suffix"><?php echo esc_html( $settings['after'] ); ?></span>
					<?php
				endif;
				?>

				<?php if ( 'after' === $icon_position ) : ?>
					<?php $this->render_icon( $settings, $icon_position ); ?>
				<?php endif; ?>
			</<?php echo zyre_escape_tags( $settings['site_title_tag'], 'h1' ); ?>>
		</a>
		<?php
	}

	protected function render_icon( $settings, $icon_position ) {
		if ( empty( $settings['site_title_icon']['value'] ) ) {
			return;
		}
		?>
		<span class="zyre-site-title-icon zyre-site-title-icon--<?php echo esc_attr( $icon_position ); ?>">
			<?php zyre_render_icon( $settings, 'icon', 'site_title_icon' ); ?>
		</span>
		<?php
	}
}
