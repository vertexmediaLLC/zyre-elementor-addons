<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;

defined( 'ABSPATH' ) || die();

class CF7 extends Base {

	public function get_title() {
		return esc_html__( 'Contact Form 7', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Contact-form';
	}

	public function get_keywords() {
		return [ 'contact form 7', 'contact form', 'contact', 'form', 'cf7', 'contact us', 'message form', 'message' ];
	}

	/**
	 * Register widget content controls
	 */
	protected function register_content_controls() {
		$this->start_controls_section(
			'section_cf7_content',
			[
				'label' => zyre_is_cf7_activated() ? esc_html__( 'Contact Form 7', 'zyre-elementor-addons' ) : esc_html__( 'Warning!', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		if ( ! zyre_is_cf7_activated() ) {
			$cf7_missing_info = zyre_get_plugin_missing_info(
				[
					'plugin_name' => 'contact-form-7',
					'plugin_file' => 'contact-form-7/wp-contact-form-7.php',
				]
			);

			$cf7_missing_url = ! empty( $cf7_missing_info['url'] ) ? $cf7_missing_info['url'] : '#';
			$cf7_missing_title = ! empty( $cf7_missing_info['title'] ) ? $cf7_missing_info['title'] : '';

			$this->add_control(
				'_cf7_missing_notice',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf(
						/* translators: 1: plugin name, 2: status, 3: action */
						__( 'It seems that %1$s plugin is not %2$s on your site. Please click the link below to %3$s it. Once done, be sure to refresh this page to continue.', 'zyre-elementor-addons' ),
						sprintf(
							'<a href="%s" target="_blank" rel="noopener">%s</a>',
							esc_url( $cf7_missing_url ),
							esc_html( 'Contact Form 7' )
						),
						$cf7_missing_info['installed'] ? esc_html( 'activated' ) : esc_html( 'installed' ),
						esc_html( strtolower( $cf7_missing_title ) )
					),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-danger',
				]
			);

			$this->add_control(
				'_cf7_install',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw' => sprintf(
						'<a href="%s" target="_blank" rel="noopener">%s Contact Form 7 Plugin</a>',
						esc_url( $cf7_missing_url ),
						esc_html( $cf7_missing_title )
					),
				]
			);
		} else {
			
			// Pre-styles
			$this->set_prestyle_controls();

			$this->add_control(
				'form_id',
				[
					'label' => esc_html__( 'Select Your Form', 'zyre-elementor-addons' ),
					'type' => Controls_Manager::SELECT,
					'label_block' => true,
					'options' => zyre_get_cf7_forms(),
				]
			);
		}

		$this->end_controls_section();
	}

	/**
	 * Register styles related controls
	 */
	protected function register_style_controls() {
		$this->__general_style();
		$this->__input_textarea_style();
		$this->__submit_btn_style();
		$this->__error_style();
		$this->__after_submit_style();
	}

	/**
	 * Style - General
	 */
	protected function __general_style() {
		$this->start_controls_section(
			'section_general_style',
			[
				'label' => esc_html__( 'General', 'zyre-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'wpcf7_form',
			[
				'selector' => '{{WRAPPER}} .wpcf7-form',
				'controls' => [
					'typography' => [],
					'color'      => [],
					'align'      => [
						'default' => is_rtl() ? 'right' : 'left',
					],
				],
			],
		);

		$this->end_controls_section();
	}

	/**
	 * Style - Input & Textarea
	 */
	protected function __input_textarea_style() {
		$this->start_controls_section(
			'input_textarea_style',
			[
				'label' => esc_html__( 'Input & Textarea', 'zyre-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'input_textarea',
			[
				'selector' => '{{WRAPPER}} .wpcf7-text, {{WRAPPER}} .wpcf7-email, {{WRAPPER}} .wpcf7-url, {{WRAPPER}} .wpcf7-number, {{WRAPPER}} .wpcf7-quiz, {{WRAPPER}} .wpcf7-date, {{WRAPPER}} .wpcf7-select, {{WRAPPER}} .wpcf7-textarea',
				'controls' => [
					'bg_color'      => [],
					'box_shadow'    => [],
					'border'        => [],
					'border_radius' => [],
					'margin'        => [],
					'padding'       => [],
					'align'         => [
						'default' => is_rtl() ? 'right' : 'left',
					],
				],
			],
		);

		// Tabs
		$this->start_controls_tabs( 'input_textarea_tabs' );

		// Tab: Normal
		$this->start_controls_tab(
			'input_textarea_tab_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'input_textarea',
			[
				'selector' => '{{WRAPPER}} .wpcf7-text, {{WRAPPER}} .wpcf7-email, {{WRAPPER}} .wpcf7-url, {{WRAPPER}} .wpcf7-number, {{WRAPPER}} .wpcf7-quiz, {{WRAPPER}} .wpcf7-date, {{WRAPPER}} .wpcf7-textarea',
				'controls' => [
					'color' => [],
				],
			],
		);

		$this->end_controls_tab();

		// Tab: Active
		$this->start_controls_tab(
			'input_textarea_tab_active',
			[
				'label' => esc_html__( 'Active', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'input_textarea_hover',
			[
				'selector' => '{{WRAPPER}} .wpcf7-text:focus, {{WRAPPER}} .wpcf7-email:focus, {{WRAPPER}} .wpcf7-url:focus, {{WRAPPER}} .wpcf7-number:focus, {{WRAPPER}} .wpcf7-quiz:focus, {{WRAPPER}} .wpcf7-date:focus, {{WRAPPER}} .wpcf7-textarea:focus',
				'controls' => [
					'color' => [],
					'border_color' => [],
				],
			],
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->set_style_controls(
			'input',
			[
				'selector' => '{{WRAPPER}} .wpcf7-text, {{WRAPPER}} .wpcf7-email, {{WRAPPER}} .wpcf7-url, {{WRAPPER}} .wpcf7-number, {{WRAPPER}} .wpcf7-quiz, {{WRAPPER}} .wpcf7-date',
				'controls' => [
					'height' => [
						'label' => esc_html__( 'Input Height', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
				],
			],
		);

		$this->set_style_controls(
			'textarea',
			[
				'selector' => '{{WRAPPER}} .wpcf7-textarea',
				'controls' => [
					'height' => [
						'label' => esc_html__( 'Textarea Height', 'zyre-elementor-addons' ),
					],
				],
			],
		);

		$this->set_style_controls(
			'placeholder',
			[
				'selector' => '{{WRAPPER}} .wpcf7-form-control::placeholder, {{WRAPPER}} .wpcf7-form-control::-webkit-input-placeholder',
				'controls' => [
					'color' => [
						'label'     => esc_html__( 'Placeholder Color', 'zyre-elementor-addons' ),
					],
				],
			],
		);

		$this->end_controls_section();
	}

	/**
	 * Style - Submit Button
	 */
	protected function __submit_btn_style() {
		$this->start_controls_section(
			'submit_btn_style',
			[
				'label' => esc_html__( 'Submit Button', 'zyre-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'submit_btn',
			[
				'selector' => '{{WRAPPER}} .wpcf7-submit',
				'controls' => [
					'typography'    => [],
					'margin'        => [],
					'padding'       => [],
					'width'         => [],
					'height'        => [],
					'border'        => [],
					'border_radius' => [],
					'box_shadow'    => [],
					'align'         => [
						'default' => 'center',
					],
				],
			],
		);

		// Tabs
		$this->start_controls_tabs( 'submit_btn_tabs' );

		// Tab: Normal
		$this->start_controls_tab(
			'submit_btn_tab_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'submit_btn',
			[
				'selector' => '{{WRAPPER}} .wpcf7-submit',
				'controls' => [
					'color' => [],
					'bg_color' => [],
				],
			],
		);

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab(
			'submit_btn_tab_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'submit_btn_hover',
			[
				'selector' => '{{WRAPPER}} .wpcf7-submit:hover',
				'controls' => [
					'color' => [],
					'bg_color' => [],
					'border_color' => [],
				],
			],
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Style - Error Massage
	 */
	protected function __error_style() {
		$this->start_controls_section(
			'error_style',
			[
				'label' => esc_html__( 'Error Massage', 'zyre-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'error',
			[
				'selector' => '{{WRAPPER}} .wpcf7-not-valid-tip',
				'controls' => [
					'typography' => [],
					'color'      => [],
					'margin_top' => [
						'label'        => esc_html__( 'Margin Top', 'zyre-elementor-addons' ),
						'css_property' => 'margin-top',
					],
					'align'      => [
						'default' => is_rtl() ? 'right' : 'left',
					],
				],
			],
		);

		$this->end_controls_section();
	}

	/**
	 * Style - After Submit Massage
	 */
	protected function __after_submit_style() {
		$this->start_controls_section(
			'after_submit_style',
			[
				'label' => esc_html__( 'After Submit Massage', 'zyre-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'after_submit',
			[
				'selector' => '{{WRAPPER}} .wpcf7-response-output',
				'controls' => [
					'typography'    => [],
					'color'         => [],
					'bg_color'      => [],
					'margin'        => [],
					'padding'       => [],
					'border'        => [],
					'border_radius' => [],
					'align'         => [
						'default' => is_rtl() ? 'right' : 'left',
					],
				],
			],
		);

		$this->end_controls_section();
	}

	/**
	 * Register render display controls
	 */
	protected function render() {
		if ( ! zyre_is_cf7_activated() ) {
			zyre_show_plugin_missing_alert( 'Contact Forms 7' );
			return;
		}

		$settings = $this->get_settings_for_display();

		// Remove Contact Form 7 Extra <p> tag
		add_filter( 'wpcf7_autop_or_not', '__return_false' );

		if ( ! empty( $settings['form_id'] ) ) {
			echo do_shortcode( '[contact-form-7 id="' . esc_attr( $settings['form_id'] ) . '" ]' );
		}
	}
}
