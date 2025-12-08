<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

defined( 'ABSPATH' ) || die();

class Site_Logo extends Base {

	public function get_title() {
		return esc_html__( 'Site Logo', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Site-logo';
	}

	public function get_keywords() {
		return [ 'site logo', 'logo', 'site', 'site info', 'site branding', 'branding', 'company logo', 'company branding' ];
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	// Widget Content controls
	protected function register_content_controls() {

		$this->start_controls_section(
			'section_site_logo_content',
			[
				'label' => esc_html__( 'Site Logo Content', 'zyre-elementor-addons' ),
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$this->add_control(
			'logo_type',
			[
				'label'   => esc_html__( 'Logo Type', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'default' => esc_html__( 'Default', 'zyre-elementor-addons' ),
					'custom'  => esc_html__( 'Custom', 'zyre-elementor-addons' ),
				],
				'default' => 'default',
			]
		);

		$this->add_control(
			'custom_site_logo',
			[
				'label'   => esc_html__( 'Custom Site Logo', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::MEDIA,
				'condition' => [
					'logo_type' => 'custom',
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'site_logo_size',
				'default' => 'thumbnail',
				'condition' => [
					'logo_type' => 'custom',
				],
			]
		);

		$this->add_control(
			'logo_link_switcher',
			[
				'label' => esc_html__( 'Logo URL', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Off', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'no',
				'condition' => [
					'logo_type' => 'custom',
				],
			]
		);

		$this->add_responsive_control(
			'site_logo_align',
			[
				'label'     => esc_html__( 'Alignment', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
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
				'default'      => is_rtl() ? 'right' : 'left',
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	// Widget Content Style
	protected function register_style_controls() {
		$this->start_controls_section(
			'_section_site_logo',
			[
				'label' => esc_html__( 'Logo style', 'zyre-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'logo',
			[
				'selector' => '{{WRAPPER}} .zyre-site-logo img, {{WRAPPER}} .zyre-site-logo-link img, {{WRAPPER}} .custom-logo',
				'controls' => [
					'width'         => [],
					'max_width'     => [
						'label'        => esc_html__( 'Max Width', 'zyre-elementor-addons' ),
						'css_property' => 'max-width',
					],
					'height'        => [],
					'object_fit'    => [
						'label' => esc_html__( 'Logo Fit', 'zyre-elementor-addons' ),
					],
					'border'        => [],
					'border_radius' => [],
					'padding'       => [
						'separator' => 'before',
					],
					'margin'        => [],
					'box_shadow'    => [],
				],
			]
		);

		$this->end_controls_section();
	}

	// Widget Display
	protected function render() {
		$settings         = $this->get_settings_for_display();

		if ( 'default' === $settings['logo_type'] ) {
			if ( has_custom_logo() ) {
				the_custom_logo();
			}
		} elseif ( 'custom' === $settings['logo_type'] ) {
			$custom_logo_html = Group_Control_Image_Size::get_attachment_image_html( $settings, 'site_logo_size', 'custom_site_logo' );

			if ( 'yes' === $settings['logo_link_switcher'] ) {
				echo '<a class="zyre-site-logo-link zyre-site-logo-link-custom" href="' . esc_url( home_url( '/' ) ) . '">' . $custom_logo_html . '</a>';
			} else {
				echo '<div class="zyre-site-logo zyre-site-logo-custom zy-inline-block">' . $custom_logo_html . '</div>';
			}
		}
	}
}
