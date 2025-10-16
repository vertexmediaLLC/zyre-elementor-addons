<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

defined( 'ABSPATH' ) || die();

class Post_Navigation extends Base {
	public function get_title() {
		return esc_html__( 'Post Navigation', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Post-Navigation';
	}

	public function get_keywords() {
		return [ 'posts', 'post navigation', 'post links', 'next post', 'previous post', 'after post', 'before post' ];
	}

	/**
	 * Register widget content controls
	 */
	protected function register_content_controls() {
		$this->start_controls_section(
			'section_post_navigation_content',
			[
				'label' => esc_html__( 'Post Navigation', 'zyre-elementor-addons' ),
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$this->add_control(
			'show_label',
			[
				'label'     => esc_html__( 'Show Labels', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'default'   => 'yes',
			]
		);

		$this->add_control(
			'prev_label',
			[
				'label'     => esc_html__( 'Previous Label', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Previous', 'zyre-elementor-addons' ),
				'condition' => [
					'show_label' => 'yes',
				],
				'ai' => false,
			]
		);
		$this->add_control(
			'next_label',
			[
				'label'     => esc_html__( 'Next Label', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Next', 'zyre-elementor-addons' ),
				'condition' => [
					'show_label' => 'yes',
				],
				'ai' => false,
			]
		);

		$this->add_control(
			'show_arrow',
			[
				'label'     => esc_html__( 'Show Arrows', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'default'   => 'yes',
			]
		);

		$this->add_control(
			'prev_arrow_icon',
			[
				'label'       => esc_html__( 'Previous Icon', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => 'true',
				'default'     => [
					'value'   => 'fas fa-chevron-left',
					'library' => 'fa-solid',
				],
				'condition'   => [
					'show_arrow' => 'yes',
				],
			]
		);

		$this->add_control(
			'next_arrow_icon',
			[
				'label'       => esc_html__( 'Next Icon', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => 'true',
				'default'     => [
					'value'   => 'fas fa-chevron-right',
					'library' => 'fa-solid',
				],
				'condition'   => [
					'show_arrow' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_post_title',
			[
				'label'     => esc_html__( 'Show Post Title', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default'   => 'no',
			]
		);

		$this->add_control(
			'show_divider',
			[
				'label'     => esc_html__( 'Show Divider', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'default'   => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register styles related controls
	 */
	protected function register_style_controls() {
		$this->__general_style();
		$this->__label_style();
		$this->__arrow_style();
		$this->__divider_style();
		$this->__title_style();
	}

	/**
	 * Post Navigation - General
	 */
	protected function __general_style() {
		$this->start_controls_section(
			'general_style',
			[
				'label'     => esc_html__( 'General', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'general',
			[
				'selector' => '{{WRAPPER}} .zyre-post-navigation-wrapper',
				'controls' => [
					'margin'   => [],
					'padding'  => [],
					'border'   => [],
					'bg_color' => [],
				],
			]
		);

		$this->set_style_controls(
			'nav',
			[
				'selector' => '{{WRAPPER}} .zyre-post-navigation-wrapper',
				'controls' => [
					'gap'       => [
						'separator' => 'before',
					],
					'direction' => [
						'label'                => esc_html__( 'Navigation Direction', 'zyre-elementor-addons' ),
						'selectors_dictionary' => [
							'row'    => 'flex-direction: row;--divider-b-style: none none none var(--divider-b-style-val);--divider-b-width: 0 0 0 var(--divider-b-width-val);--divider-b-color: transparent transparent transparent var(--divider-b-color-val);--divider-length: 100%;',
							'column' => 'flex-direction: column;--divider-b-style: none none var(--divider-b-style-val) none;--divider-b-width: 0 0 var(--divider-b-width-val) 0;--divider-b-color: transparent transparent var(--divider-b-color-val) transparent;--divider-length: 100%;',
						],
						'default'              => 'row',
						'tablet_default'       => 'row',
						'mobile_default'       => 'column',
					],
					'justify_content'       => [
						'label'       => esc_html__( 'Justify Content', 'zyre-elementor-addons' ),
						'label_block' => true,
						'condition'   => [
							'nav_direction' => 'row',
						],
					],
					'align_xy'       => [
						'label'       => esc_html__( 'Align Items', 'zyre-elementor-addons' ),
						'condition'   => [
							'nav_direction' => 'column',
						],
					],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Post Navigation - Label Styles
	 */
	protected function __label_style() {
		$this->start_controls_section(
			'label_style',
			[
				'label'     => esc_html__( 'Labels', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_label' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'post_label_typography',
				'selector' => '{{WRAPPER}} .zyre-post-navigation__prev--label, {{WRAPPER}} .zyre-post-navigation__next--label',
			]
		);

		$this->post_navigation_tab( 'post_label', 'label' );

		$this->end_controls_section();
	}

	/**
	 * Post Navigation - Arrow Styles
	 */
	protected function __arrow_style() {
		$this->start_controls_section(
			'arrow_style',
			[
				'label'     => esc_html__( 'Arrows', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_arrow' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'arrow_size',
			[
				'label'     => esc_html__( 'Size', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-post-navigation__prev--arrow, {{WRAPPER}} .zyre-post-navigation__next--arrow' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrow_gap',
			[
				'label'     => esc_html__( 'Gap', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'body:not(.rtl) {{WRAPPER}} .zyre-post-navigation__prev--arrow' => 'margin-right: {{SIZE}}{{UNIT}};',
					'body:not(.rtl) {{WRAPPER}} .zyre-post-navigation__next--arrow' => 'margin-left: {{SIZE}}{{UNIT}};',
					'body.rtl {{WRAPPER}} .zyre-post-navigation__prev--arrow'       => 'margin-left: {{SIZE}}{{UNIT}};',
					'body.rtl {{WRAPPER}} .zyre-post-navigation__next--arrow'       => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
			]
		);

		$this->set_style_controls(
			'arrow',
			[
				'selector' => '{{WRAPPER}} .zyre-post-navigation__prev--arrow, {{WRAPPER}} .zyre-post-navigation__next--arrow',
				'controls' => [
					'padding'       => [],
					'border'        => [],
					'border_radius' => [],
				],
			]
		);

		// Tabs
		$this->start_controls_tabs( 'arrow_color_tabs' );

		// Tab: Normal
		$this->start_controls_tab(
			'arrow_color_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'post_arrow_color',
			[
				'label'     => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-post-navigation__prev--arrow'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-post-navigation__next--arrow'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-post-navigation__prev--arrow svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}} .zyre-post-navigation__next--arrow svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->set_style_controls(
			'post_arrow',
			[
				'selector' => '{{WRAPPER}} .zyre-post-navigation__prev--arrow, {{WRAPPER}} .zyre-post-navigation__next--arrow',
				'controls' => [
					'bg_color' => [],
				],
			]
		);

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab(
			'arrow_color_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'post_arrow_hover_color',
			[
				'label'     => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-post-navigation-item a:hover .zyre-post-navigation__prev--arrow'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-post-navigation-item a:hover .zyre-post-navigation__next--arrow'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-post-navigation-item a:hover .zyre-post-navigation__prev--arrow svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}} .zyre-post-navigation-item a:hover .zyre-post-navigation__next--arrow svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->set_style_controls(
			'post_arrow_hover',
			[
				'selector' => '{{WRAPPER}} .zyre-post-navigation-item a:hover .zyre-post-navigation__prev--arrow,
						{{WRAPPER}} .zyre-post-navigation-item a:hover .zyre-post-navigation__next--arrow',
				'controls' => [
					'bg_color'     => [],
					'border_color' => [],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->set_style_controls(
			'arrow_prev',
			[
				'selector'  => '{{WRAPPER}} .zyre-post-navigation__prev--wrapper > a',
				'controls'  => [
					'justify_content' => [
						'label'   => esc_html__( 'Prev Post Align', 'zyre-elementor-addons' ),
						'options' => [
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
					],
				],
				'separator' => 'before',
			]
		);

		$this->set_style_controls(
			'arrow_next',
			[
				'selector' => '{{WRAPPER}} .zyre-post-navigation__next--wrapper > a',
				'controls' => [
					'justify_content' => [
						'label'   => esc_html__( 'Next Post Align', 'zyre-elementor-addons' ),
						'options' => [
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
						'default' => 'flex-end',
					],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Post Navigation - Divider Styles
	 */
	protected function __divider_style() {
		$this->start_controls_section(
			'divider_style',
			[
				'label'     => esc_html__( 'Divider', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_divider' => 'yes',
				],
			]
		);

		$this->add_control(
			'divider_color',
			[
				'label'     => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-post-navigation-wrapper' => '--divider-b-color-val: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'divider_border_style',
			[
				'label' => esc_html__( 'Style', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'solid' => esc_html__( 'Solid', 'zyre-elementor-addons' ),
					'double' => esc_html__( 'Double', 'zyre-elementor-addons' ),
					'dotted' => esc_html__( 'Dotted', 'zyre-elementor-addons' ),
					'dashed' => esc_html__( 'Dashed', 'zyre-elementor-addons' ),
				],
				'default' => 'solid',
				'selectors' => [
					'{{WRAPPER}} .zyre-post-navigation-wrapper' => '--divider-b-style-val: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'divider_weight',
			[
				'label'      => esc_html__( 'Weight', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'default'    => [
					'size' => 2,
					'unit' => 'px',
				],
				'range'      => [
					'px' => [
						'min' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-post-navigation-wrapper' => '--divider-b-width-val: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'divider_width',
			[
				'label'      => esc_html__( 'Width', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
				],
				'default'    => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-post-navigation-wrapper'  => '--divider-length: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .zyre-post-navigation__divider' => 'width: var(--divider-length);height:0;',
				],
				'condition'  => [
					'nav_direction' => 'column',
				],
			]
		);

		$this->add_responsive_control(
			'divider_height',
			[
				'label'      => esc_html__( 'Height', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 46,
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-post-navigation-wrapper'  => '--divider-length: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .zyre-post-navigation__divider' => 'height: var(--divider-length);width:0;',
				],
				'condition'  => [
					'nav_direction' => 'row',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Post Navigation - Post Title Styles
	 */
	protected function __title_style() {
		$this->start_controls_section(
			'post_title_style',
			[
				'label'     => esc_html__( 'Post Titles', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_post_title' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'post_title_typography',
				'selector' => '{{WRAPPER}} .zyre-post-navigation__prev--title, {{WRAPPER}} .zyre-post-navigation__next--title',
			]
		);

		$this->post_navigation_tab( 'post_title', 'title' );

		$this->end_controls_section();
	}

	/**
	 * Tab Style
	 *
	 * @param string $prefix control ID name.
	 * @param string $select selector 1st class name.
	 */
	private function post_navigation_tab( $prefix, $select ) {

		$this->start_controls_tabs( $prefix . '_tabs' );

		$this->start_controls_tab(
			$prefix . '_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			$prefix . '_color',
			[
				'label'     => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-post-navigation__prev--' . $select => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-post-navigation__next--' . $select => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			$prefix . '_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			$prefix . '_hover_color',
			[
				'label'     => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-post-navigation-item a:hover .zyre-post-navigation__prev--' . $select => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-post-navigation-item a:hover .zyre-post-navigation__next--' . $select => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
	}

	/**
	 * Register render display controls
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$prev_label = '';
		$next_label = '';
		if ( 'yes' === $settings['show_label'] ) {
			if ( '' !== $settings['prev_label'] ) {
				$prev_label = '<span class="zyre-post-navigation__prev--label">' . $settings['prev_label'] . '</span>';
			}
			if ( '' !== $settings['next_label'] ) {
				$next_label = '<span class="zyre-post-navigation__next--label">' . $settings['next_label'] . '</span>';
			}
		}

		$prev_arrow = '';
		$next_arrow = '';
		if ( 'yes' === $settings['show_arrow'] ) {
			if ( '' !== $settings['prev_arrow_icon']['value'] ) {
				$prev_arrow = '<span class="zyre-post-navigation__prev--arrow">' . zyre_get_icon_html( $settings, 'icon', 'prev_arrow_icon' ) . '</span>';
			}
			if ( '' !== $settings['next_arrow_icon']['value'] ) {
				$next_arrow = '<span class="zyre-post-navigation__next--arrow">' . zyre_get_icon_html( $settings, 'icon', 'next_arrow_icon' ) . '</span>';
			}
		}

		$prev_title = '';
		$next_title = '';
		if ( 'yes' === $settings['show_post_title'] ) {
			$prev_title = '<span class="zyre-post-navigation__prev--title">%title</span>';
			$next_title = '<span class="zyre-post-navigation__next--title">%title</span>';
		}

		$prev_html = $prev_arrow . '<div class="zyre-post-navigation-text-wrapper">' . $prev_label . $prev_title . '</div>';
		$next_html = '<div class="zyre-post-navigation-text-wrapper">' . $next_label . $next_title . '</div>' . $next_arrow;
		?>

		<div class="zyre-post-navigation-wrapper zy-flex zy-justify-between zy-align-center">
			<div class="zyre-post-navigation-item zy-basis-0 zy-grow-1 zyre-post-navigation__prev--wrapper">
				<?php previous_post_link( '%link', $prev_html ); ?>
			</div>

			<?php if ( 'yes' === $settings['show_divider'] ) : ?>
				<span class="zyre-post-navigation__divider"></span>
			<?php endif; ?>

			<div class="zyre-post-navigation-item zy-basis-0 zy-grow-1 zyre-post-navigation__next--wrapper">
				<?php next_post_link( '%link', $next_html ); ?>
			</div>
		</div>
		<?php
	}
}
