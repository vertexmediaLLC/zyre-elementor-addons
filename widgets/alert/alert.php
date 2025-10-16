<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Alert extends Base {

	public function get_title() {
		return esc_html__( 'Alert', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Alert';
	}

	public function get_keywords() {
		return [ 'alert', 'notice', 'message', 'warning', 'info', 'danger', 'success' ];
	}

	protected function register_content_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Alert Content', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$this->add_control(
			'alert_type',
			[
				'label'        => esc_html__( 'Type', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'info',
				'options'      => [
					'info'    => esc_html__( 'Info', 'zyre-elementor-addons' ),
					'success' => esc_html__( 'Success', 'zyre-elementor-addons' ),
					'warning' => esc_html__( 'Warning', 'zyre-elementor-addons' ),
					'danger'  => esc_html__( 'Danger', 'zyre-elementor-addons' ),
				],
				'prefix_class' => 'zyre-alert-',
			]
		);

		$this->add_control(
			'alert_icon',
			[
				'label'       => esc_html__( 'Icon', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default'     => [
					'value'   => 'far fa-bell',
					'library' => 'fa-regular',
				],
			]
		);

		$this->add_control(
			'alert_title',
			[
				'label'       => esc_html__( 'Title', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your title', 'zyre-elementor-addons' ),
				'default'     => esc_html__( 'Notice!', 'zyre-elementor-addons' ),
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'alert_description',
			[
				'label'       => esc_html__( 'Description', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter your description', 'zyre-elementor-addons' ),
				'default'     => esc_html__( 'I am a description. Click the edit button to change this text.', 'zyre-elementor-addons' ),
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'alert_layout',
			[
				'label'          => esc_html__( 'Title & Description View', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::CHOOSE,
				'default'        => 'inline',
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
				'prefix_class' => 'zyre-alert-layout-',
				'selectors' => [
					'{{WRAPPER}} .zyre-alert-title, {{WRAPPER}} .zyre-alert-description' => 'display: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'show_dismiss',
			[
				'label'        => esc_html__( 'Dismiss Content', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off'    => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'return_value' => 'show',
				'default'      => 'show',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'dismiss_icon',
			[
				'label'            => esc_html__( 'Dismiss Icon', 'zyre-elementor-addons' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'skin'             => 'inline',
				'label_block'      => false,
				'render_type'      => 'template',
				'skin_settings'    => [
					'inline' => [
						'none' => [
							'label' => 'Default',
							'icon'  => 'eicon-t-letter-bold',
						],
						'icon' => [
							'icon' => 'eicon-star',
						],
					],
				],
				'recommended'      => [
					'fa-regular' => [
						'times-circle',
					],
					'fa-solid'   => [
						'times',
						'times-circle',
					],
				],
				'condition'        => [
					'show_dismiss' => 'show',
				],
			]
		);

		$this->add_control(
			'dismiss_text',
			[
				'label'     => esc_html__( 'Dismiss Text', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'OK', 'zyre-elementor-addons' ),
				'ai'        => false,
				'condition' => [
					'show_dismiss'        => 'show',
					'dismiss_icon[value]' => '',
				],
			]
		);

		$this->add_control(
			'dismiss_onclick_event',
			[
				'label'       => esc_html__( 'Dismiss onClick Event', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => 'myFunction()',
				'ai'          => false,
				'condition'   => [
					'show_dismiss' => 'show',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_controls() {
		$this->__icon_style_controls();
		$this->__title_style_controls();
		$this->__description_style_controls();
		$this->__dismiss_style_controls();
	}

	protected function __icon_style_controls() {
		$this->start_controls_section(
			'section_icon',
			[
				'label' => esc_html__( 'Icon', 'zyre-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'alert_icon[value]!' => '',
				],
			]
		);

		$this->set_style_controls(
			'alert',
			[
				'selector' => '{{WRAPPER}} .zyre-alert-icon',
				'controls' => [
					'icon_size' => [
						'label' => esc_html__( 'Size', 'zyre-elementor-addons' ),
					],
					'gap' => [
						'label' => esc_html__( 'Spacing', 'zyre-elementor-addons' ),
						'selector' => '{{WRAPPER}} .zyre-alert-main',
					],
				],
			]
		);

		$this->icon_common_style_controls( 'icon' );
		$this->icon_extra_style_controls( 'icon' );

		$this->end_controls_section();
	}

	protected function __title_style_controls() {
		$this->start_controls_section(
			'section_title',
			[
				'label'     => esc_html__( 'Title', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'alert_title!' => '',
				],
			]
		);

		$this->text_style_controls( 'title' );

		$this->end_controls_section();
	}

	protected function __description_style_controls() {
		$this->start_controls_section(
			'section_description',
			[
				'label' => esc_html__( 'Description', 'zyre-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'alert_description!' => '',
				],
			]
		);

		$this->text_style_controls( 'description' );

		$this->end_controls_section();
	}

	protected function __dismiss_style_controls() {
		$this->start_controls_section(
			'section_dismiss',
			[
				'label' => esc_html__( 'Dismiss', 'zyre-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_dismiss' => 'show',
				],
			]
		);

		$this->set_style_controls(
			'dismiss',
			[
				'selector' => '{{WRAPPER}} .zyre-alert-dismiss',
				'controls' => [
					'typography' => [
						'condition' => [
							'dismiss_icon[value]' => '',
							'dismiss_text!'       => '',
						],
					],
					'icon_size'  => [
						'condition' => [
							'dismiss_icon[value]!' => '',
						],
					],
				],
			]
		);

		$this->start_controls_tabs( 'dismiss_icon_colors' );

		$this->start_controls_tab( 'dismiss_icon_normal_colors', [
			'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
		] );

		$this->set_style_controls(
			'dismiss',
			[
				'selector' => '{{WRAPPER}} .zyre-alert-dismiss',
				'controls' => [
					'color'  => [
						'condition' => [
							'dismiss_icon[value]' => '',
						],
					],
				],
			]
		);

		$this->icon_common_style_controls( 'dismiss' );

		$this->end_controls_tab();

		$this->start_controls_tab( 'dismiss_icon_hover_colors', [
			'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
		] );

		$this->set_style_controls(
			'dismiss_hover',
			[
				'selector' => '{{WRAPPER}} .zyre-alert-dismiss:hover',
				'controls' => [
					'color'  => [
						'condition' => [
							'dismiss_icon[value]' => '',
						],
					],
				],
			]
		);

		$this->icon_common_style_controls( 'dismiss', true );

		$this->set_style_controls(
			'dismiss_icon_hover',
			[
				'selector' => '{{WRAPPER}} .zyre-alert-dismiss',
				'controls' => [
					'transition_duration' => [
						'css_property' => '--transition-duration',
					],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->icon_extra_style_controls( 'dismiss' );

		$this->end_controls_section();
	}

	/**
	 * Icon Common Style Controls.
	 *
	 * @param string $prefix The prefix of the controls.
	 * @param bool $is_hover Whether the controls go in hover tab.
	 */
	private function icon_common_style_controls( string $prefix, bool $is_hover = false ) {
		$class_base = str_replace( '_', '-', $prefix );
		$class_base = $is_hover ? "$class_base:hover" : $class_base;
		$cond_prefix = 'icon' === $prefix ? 'alert' : $prefix;
		$prefix = $is_hover ? $prefix . '_hover' : $prefix;

		$this->set_style_controls(
			$prefix,
			[
				'selector' => '{{WRAPPER}} .zyre-alert-' . $class_base,
				'controls' => [
					'icon_color' => [
						'condition' => [
							$cond_prefix . '_icon[value]!' => '',
						],
					],
					'background' => [],
				],
			]
		);
	}

	/**
	 * Icon Extra Style Controls.
	 *
	 * @param string $prefix The prefix of the controls.
	 */
	private function icon_extra_style_controls( string $prefix ) {
		$class_base = str_replace( '_', '-', $prefix );

		$this->set_style_controls(
			$prefix,
			[
				'selector' => '{{WRAPPER}} .zyre-alert-' . $class_base,
				'controls' => [
					'border'        => [
						'separator' => 'before',
					],
					'box_shadow'    => [],
					'border_radius' => [],
					'padding'       => [],
					'align_self_y'  => [
						'default' => 'center',
						'toggle'  => false,
					],
					'offset_x'      => [
						'css_property' => '--translateX',
						'range'        => [
							'px' => [
								'min' => -100,
								'max' => 100,
							],
						],
					],
					'offset_y'      => [
						'css_property' => '--translateY',
						'range'        => [
							'px' => [
								'min' => -100,
								'max' => 100,
							],
						],
					],
				],
			]
		);
	}

	/**
	 * Text Style Controls.
	 *
	 * @param string $prefix The prefix of the controls.
	 */
	private function text_style_controls( string $prefix ) {
		$class_base = str_replace( '_', '-', $prefix );

		$this->set_style_controls(
			$prefix,
			[
				'selector' => '{{WRAPPER}} .zyre-alert-' . $class_base,
				'controls' => [
					'typography' => [],
					'color'      => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
					'margin'     => [],
					'align'      => [
						'condition' => [
							'alert_layout' => 'block',
						],
					],
				],
			]
		);
	}

	/**
	 * Render alert widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( Utils::is_empty( $settings['alert_title'] ) && Utils::is_empty( $settings['alert_description'] ) ) {
			return;
		}

		$this->add_render_attribute( 'alert_wrapper', 'class', 'zyre-alert zy-flex zy-align-center zy-justify-between zy-w-100 zy-gap-6' );
		$this->add_render_attribute( 'alert_wrapper', 'role', 'alert' );
		$this->add_render_attribute( 'alert_title', 'class', 'zyre-alert-title' );
		$this->add_render_attribute( 'alert_description', 'class', 'zyre-alert-description' );
		$this->add_render_attribute( 'dismiss_button', 'class', 'zyre-alert-dismiss zy-p-0 zy-radius-0 zy-border-none zy-outline-0 zy-lh-1 zy-shadow-none zy-c-pointer zy-shrink-0 zy-align-center zy-bg-transparent' );
		$this->add_render_attribute( 'dismiss_button', 'type', 'button' );
		$this->add_render_attribute( 'dismiss_button', 'aria-label', esc_attr__( 'Dismiss this alert.', 'zyre-elementor-addons' ) );
		if ( ! empty( $settings['dismiss_onclick_event'] ) ) {
			$this->add_render_attribute( 'dismiss_button', 'onclick', esc_attr( $settings['dismiss_onclick_event'] ) );
		}

		$this->add_inline_editing_attributes( 'alert_title', 'none' );
		$this->add_inline_editing_attributes( 'alert_description' );
		?>
		<div <?php $this->print_render_attribute_string( 'alert_wrapper' ); ?>>

			<div class="zyre-alert-main zy-inline-flex zy-align-center zy-gap-3 zy-grow-1">
				<?php if ( ! empty( $settings['alert_icon']['value'] ) ) : ?>
					<span class="zyre-alert-icon zy-self-center zy-lh-1"><?php Icons_Manager::render_icon( $settings['alert_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
				<?php endif; ?>

				<div class="zyre-alert-content">
					<?php if ( ! Utils::is_empty( $settings['alert_title'] ) ) : ?>
					<span <?php $this->print_render_attribute_string( 'alert_title' ); ?>><?php $this->print_unescaped_setting( 'alert_title' ); ?></span>
					<?php endif; ?>

					<?php if ( ! Utils::is_empty( $settings['alert_description'] ) ) : ?>
					<span <?php $this->print_render_attribute_string( 'alert_description' ); ?>><?php $this->print_unescaped_setting( 'alert_description' ); ?></span>
					<?php endif; ?>
				</div>
			</div>

			<?php if ( 'show' === $settings['show_dismiss'] ) : ?>
			<button <?php $this->print_render_attribute_string( 'dismiss_button' ); ?>>
				<?php
				if ( ! empty( $settings['dismiss_icon']['value'] ) ) {
					Icons_Manager::render_icon( $settings['dismiss_icon'], [ 'aria-hidden' => 'true' ] );
				} elseif ( ! empty( $settings['dismiss_text'] ) ) {
					echo esc_html( $settings['dismiss_text'] );
				}
				?>
			</button>
			<?php endif; ?>

		</div>
		<?php
	}
}
