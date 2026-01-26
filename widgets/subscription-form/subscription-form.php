<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use ZyreAddons\Elementor\Controls\Select2;

defined( 'ABSPATH' ) || die();

class Subscription_Form extends Base {

	private $settings;

	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );

		$this->settings = zyre_get_credentials( 'mailchimp' );
	}

	public function get_title() {
		return esc_html__( 'Subscription Form', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Subscription';
	}

	public function get_keywords() {
		return [ 'subscription form', 'email', 'mailchimp', 'mail', 'email list', 'subscription', 'subscribe', 'form', 'email template' ];
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	/**
	 * Register widget content controls
	 */
	protected function register_content_controls() {
		$this->start_controls_section(
			'section_subscription_form_content',
			[
				'label' => esc_html__( 'Subscription Form', 'zyre-elementor-addons' ),
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$this->add_control(
			'mailchimp_api_check',
			[
				'raw'             => sprintf(
					'<strong>%s</strong> %s <a style="border-bottom-color: inherit;" href="%s" target="_blank">%s</a> %s %s',
					esc_html__( 'Please note!', 'zyre-elementor-addons' ),
					esc_html__( 'You must set MailChimp API Key in Zyre Addons Dashboard → ', 'zyre-elementor-addons' ),
					esc_url( admin_url( 'admin.php?page=zyre-addons&t=integrations#integrations' ) ),
					esc_html__( 'Integrations', 'zyre-elementor-addons' ),
					sprintf(
						' %s <a style="border-bottom-color: inherit;" href="%s" target="_blank">%s</a>',
						esc_html__( 'and', 'zyre-elementor-addons' ),
						esc_url( 'https://mailchimp.com/help/create-audience/' ),
						esc_html__( 'Create Audience.', 'zyre-elementor-addons' )
					),
					esc_html__( ' Ignore if you have already done.', 'zyre-elementor-addons' ),
				),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
				'render_type'     => 'ui',
			]
		);

		$this->add_control(
			'mailchimp_lists',
			[
				'label'          => esc_html__( 'Audience', 'zyre-elementor-addons' ),
				'label_block'    => true,
				'type'           => Select2::TYPE,
				'multiple'       => false,
				'placeholder'    => 'Choose your created audience ',
				'dynamic_params' => [
					'object_type'        => 'mailchimp_list',
					'global_api'         => isset( $this->settings['api'] ) ? $this->settings['api'] : '',
				],
				'select2options' => [
					'minimumInputLength' => 0,
				],
				'description'    => esc_html__( 'Create a audience/list in mailchimp account ', 'zyre-elementor-addons' ) . '<a href="https://mailchimp.com/help/create-audience/" target="_blank"> ' . esc_html__( 'Create Audience', 'zyre-elementor-addons' ) . '</a>',
			]
		);

		$this->add_control(
			'mailchimp_list_tags',
			[
				'label'       => esc_html__( 'Tags', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'Tag-1, Tag-2', 'zyre-elementor-addons' ),
				'description' => esc_html__( 'Enter tag here to separate your subscribers. Use comma separator to use multiple tags. Example: Tag-1, Tag-2, Tag-3', 'zyre-elementor-addons' ),
				'condition'   => [
					'mailchimp_lists!' => '',
				],
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'enable_double_opt_in',
			[
				'label'        => esc_html__( 'Enable Double Opt In?', 'zyre-elementor-addons' ),
				'description'  => esc_html__( 'Send contacts an opt-in confirmation email when they subscribe to your audience.', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'zyre-elementor-addons' ),
				'label_off'    => esc_html__( 'No', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'email_placeholder',
			[
				'label'       => esc_html__( 'Email Placeholder', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Type your email', 'zyre-elementor-addons' ),
				'ai'          => false,
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'fname_enable',
			[
				'label'        => esc_html__( 'Enable First Name?', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'yes',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'fname_placeholder',
			[
				'label'       => esc_html__( 'Placeholder', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'First name', 'zyre-elementor-addons' ),
				'ai'          => false,
				'condition' => [
					'fname_enable' => 'yes',
				],
			]
		);

		$this->add_control(
			'lname_enable',
			[
				'label'        => esc_html__( 'Enable Last Name?', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'yes',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'lname_placeholder',
			[
				'label'       => esc_html__( 'Placeholder', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Last name', 'zyre-elementor-addons' ),
				'ai'          => false,
				'condition' => [
					'lname_enable' => 'yes',
				],
			]
		);

		$this->add_control(
			'enable_phone',
			[
				'label'        => esc_html__( 'Enable Phone?', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'zyre-elementor-addons' ),
				'label_off'    => esc_html__( 'No', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'phone_placeholder',
			[
				'label'       => esc_html__( 'Placeholder', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Phone', 'zyre-elementor-addons' ),
				'placeholder' => esc_html__( 'Phone input placeholder', 'zyre-elementor-addons' ),
				'condition'   => [
					'enable_phone' => 'yes',
				],
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'submit_text',
			[
				'label'       => esc_html__( 'Submit Button', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Subscribe now', 'zyre-elementor-addons' ),
				'ai'          => false,
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'mailchimp_success_message',
			[
				'label'       => esc_html__( 'Success Message', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => esc_html__( 'Your data has been inserted on Mailchimp.', 'zyre-elementor-addons' ),
				'placeholder' => esc_html__( 'Type your success message here', 'zyre-elementor-addons' ),
				'dynamic'     => [ 'active' => true ],
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'mailchimp_show_dummy_success_msg',
			[
				'label'        => __( 'Show Dummy Success Message?', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'zyre-elementor-addons' ),
				'label_off'    => __( 'No', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'mailchimp_show_dummy_error_msg',
			[
				'label'        => __( 'Show Dummy Error Message?', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'zyre-elementor-addons' ),
				'label_off'    => __( 'No', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register styles related controls
	 */
	protected function register_style_controls() {
		$this->start_controls_section(
			'general_section_style',
			[
				'label' => esc_html__( 'General', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'general',
			[
				'selector' => '{{WRAPPER}} .zyre-subscription-form',
				'controls' => [
					'bg_color'      => [],
					'box_shadow'    => [],
					'padding'       => [],
					'border'        => [],
					'border_radius' => [],
				],
			],
		);

		$this->set_style_controls(
			'general',
			[
				'selector' => '{{WRAPPER}} .zyre-subscription-form-wrap',
				'controls' => [
					'direction'      => [],
					'vertical_align' => [
						'condition' => [
							'general_direction' => 'row',
						],
					],
				],
			],
		);

		$this->end_controls_section();

		// Section: Input Fields
		$this->start_controls_section(
			'input_field_section_style',
			[
				'label' => esc_html__( 'Input Fields', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'input_field',
			[
				'selector' => '{{WRAPPER}} .zyre-subscription-field input',
				'controls' => [
					'typography'    => [],
					'width'         => [],
					'height'        => [],
					'border'        => [],
					'border_radius' => [],
					'box_shadow'    => [],
					'align'         => [
						'default' => is_rtl() ? 'right' : 'left',
					],
					'color'         => [
						'label' => esc_html__( 'Input Color', 'zyre-elementor-addons' ),
					],
					'bg_color'      => [],
					'padding'       => [],
					'margin'        => [
						'selector' => '{{WRAPPER}} .zyre-subscription-fields > .zyre-subscription-field:not(:last-child) > input',
						'default' => [
							'top'      => 0,
							'right'    => 0,
							'bottom'   => 10,
							'left'     => 0,
							'unit'     => 'px',
							'isLinked' => false,
						],
					],
				],
			],
		);

		$this->set_style_controls(
			'placeholder',
			[
				'selector' => '{{WRAPPER}} .zyre-subscription-form-input::placeholder, {{WRAPPER}} .zyre-subscription-form-input::-webkit-input-placeholder',
				'controls' => [
					'color' => [
						'label'     => esc_html__( 'Placeholder Color', 'zyre-elementor-addons' ),
					],
				],
			],
		);

		$this->end_controls_section();

		// Section: Submit Button
		$this->start_controls_section(
			'submit_btn_section_style',
			[
				'label' => esc_html__( 'Submit Button', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'submit_btn',
			[
				'selector' => '{{WRAPPER}} .zyre-subscription-form-button',
				'controls' => [
					'typography'    => [
						'fields_options' => [
							'letter_spacing' => [
								'default' => [
									'unit' => 'px',
									'size' => '0',
								],
							],
						],
					],
					'margin'        => [],
					'padding'       => [
						'default' => [
							'unit'     => 'px',
							'left'     => '15',
							'right'    => '15',
							'top'      => '10',
							'bottom'   => '10',
							'isLinked' => false,
						],
					],
					'width'         => [
						'selector' => '{{WRAPPER}} .zyre-subscription-btn-wrap, {{WRAPPER}} .zyre-subscription-form-button',
					],
					'height'        => [],
					'border'        => [],
					'border_radius' => [],
					'box_shadow'    => [],
				],
			],
		);

		$this->add_responsive_control(
			'submit_btn_align',
			[
				'label'    => esc_html__( 'Horizontal Position', 'zyre-elementor-addons' ),
				'type'     => Controls_Manager::CHOOSE,
				'options'  => [
					'left'   => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'selectors_dictionary' => [
					'left'   => 'margin-left: 0;margin-right: auto;',
					'center' => 'margin-left: auto;margin-right: auto;',
					'right'  => 'margin-left: auto;margin-right: 0;',
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-subscription-btn-wrap' => '{{VALUE}}',
				],
				'condition' => [
					'general_direction' => 'column',
				],
			]
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
				'selector' => '{{WRAPPER}} .zyre-subscription-form-button',
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
				'selector' => '{{WRAPPER}} .zyre-subscription-form-button:hover',
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

		// Section: Messages
		$this->start_controls_section(
			'section_messages_style',
			[
				'label' => esc_html__( 'Response Messages', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'mc_success',
			[
				'selector' => '{{WRAPPER}} .zyre-mc-response-message',
				'controls' => [
					'typography' => [],
				],
			],
		);

		$this->set_style_controls(
			'mc_success_msg',
			[
				'selector' => '{{WRAPPER}} .zyre-mc-response-message.mc-success',
				'controls' => [
					'color' => [
						'label' => esc_html__( 'Success Message Color', 'zyre-elementor-addons' ),
						'default' => '#19CD55',
					],
				],
			],
		);

		$this->set_style_controls(
			'mc_error_msg',
			[
				'selector' => '{{WRAPPER}} .zyre-mc-response-message.mc-error',
				'controls' => [
					'color' => [
						'label' => esc_html__( 'Error Message Color', 'zyre-elementor-addons' ),
						'default' => '#FA4119',
					],
				],
			],
		);

		$this->set_style_controls(
			'mc_success',
			[
				'selector' => '{{WRAPPER}} .zyre-mc-response-message',
				'controls' => [
					'space' => [],
					'align' => [],
				],
			],
		);

		$this->end_controls_section();
	}

	/**
	 * Register render display controls
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		// Email Field
		$email_field = sprintf(
			'<div class="zyre-subscription-field"><input type="text" id="email" name="email" class="zyre-subscription-form-input zy-w-100 zy-outline-0" placeholder="%1$s"></div>',
			! empty( $settings['email_placeholder'] ) ? esc_attr( $settings['email_placeholder'] ) : ''
		);

		// First Name Field
		$fname_field = sprintf(
			'<div class="zyre-subscription-field"><input type="text" id="fname" name="fname" class="zyre-subscription-form-input zy-w-100 zy-outline-0" placeholder="%1$s"></div>',
			! empty( $settings['fname_placeholder'] ) ? esc_attr( $settings['fname_placeholder'] ) : ''
		);

		// Last Name Field
		$lname_field = sprintf(
			'<div class="zyre-subscription-field"><input type="text" id="lname" name="lname" class="zyre-subscription-form-input zy-w-100 zy-outline-0" placeholder="%1$s"></div>',
			! empty( $settings['lname_placeholder'] ) ? esc_attr( $settings['lname_placeholder'] ) : ''
		);

		// Phone field
		$phone_field = sprintf(
			'<div class="zyre-subscription-field"><input type="text" id="phone" name="phone" class="zyre-subscription-form-input zy-w-100 zy-outline-0" placeholder="%1$s"></div>',
			! empty( $settings['phone_placeholder'] ) ? esc_attr( $settings['phone_placeholder'] ) : ''
		);

		// Submit Button Text
		$submit_btn_text = ! empty( $settings['submit_text'] ) ? $settings['submit_text'] : __( 'Subscribe now', 'zyre-elementor-addons' );

		$list_id     = ( ( is_array( $settings['mailchimp_lists'] ) ) ? ( isset( $settings['mailchimp_lists'][0] ) ? ltrim( $settings['mailchimp_lists'][0] ) : '' ) : ( ltrim( $settings['mailchimp_lists'] ) ) );
		?>

		<?php if ( \Elementor\Plugin::$instance->editor->is_edit_mode() && 'yes' === $settings['mailchimp_show_dummy_success_msg'] ) : ?>
			<div class="zyre-mc-response-message mc-success zy-text-left"><?php esc_html_e( 'This is a dummy success message and will not appear in the live preview.', 'zyre-elementor-addons' ); ?></div>
		<?php endif; ?>
		<?php if ( \Elementor\Plugin::$instance->editor->is_edit_mode() && 'yes' === $settings['mailchimp_show_dummy_error_msg'] ) : ?>
			<div class="zyre-mc-response-message mc-error zy-text-left"><?php esc_html_e( 'This is a dummy error message and will not appear in the live preview.', 'zyre-elementor-addons' ); ?></div>
		<?php endif; ?>
		<div class="zyre-mc-response-message zy-text-left"></div>

		<form class="zyre-subscription-form zy-flex" data-list-id="<?php echo esc_attr( $list_id ); ?>" data-success-message="<?php echo esc_attr( $settings['mailchimp_success_message'] ); ?>" data-post-id="<?php echo esc_attr( get_the_ID() ); ?>" data-widget-id="<?php echo esc_attr( $this->get_id() ); ?>">
			<div class="zyre-subscription-form-wrap zy-flex zy-grow-1 zy-gap-2 zy-justify-between">
				<?php
					printf(
						'<div class="zyre-subscription-fields zy-grow-1 zy-w-100">%1$s %2$s %3$s %4$s</div><div class="zyre-subscription-btn-wrap">%5$s</div>',
						wp_kses_post( $email_field ),
						( 'yes' === $settings['fname_enable'] ) ? wp_kses_post( $fname_field ) : '',
						( 'yes' === $settings['lname_enable'] ) ? wp_kses_post( $lname_field ) : '',
						( 'yes' === $settings['enable_phone'] ) ? wp_kses_post( $phone_field ) : '',
						sprintf(
							'<button class="zyre-subscription-form-button zy-outline-0 zy-border-none zy-c-pointer zy-transition" type="submit">%1$s</button>',
							esc_html( $submit_btn_text )
						)
					);
				?>				
			</div>
		</form>

		<?php
	}
}
