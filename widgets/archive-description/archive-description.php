<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;

defined( 'ABSPATH' ) || die();

class Archive_Description extends Base {

	public function get_title() {
		return esc_html__( 'Archive Description', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Archive-Description';
	}

	public function get_keywords() {
		return [ 'archive description', 'description', 'archive', 'archive info', 'archive details', 'archive category', 'tag description', 'tag info', 'tag details' ];
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	/**
	 * Register widget content controls
	 */
	protected function register_content_controls() {
		$this->start_controls_section(
			'section_archive_desc_content',
			[
				'label' => esc_html__( 'Archive Description', 'zyre-elementor-addons' ),
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$this->add_control(
			'show_placeholder',
			[
				'label'        => esc_html__( 'Placeholder Text', 'zyre-elementor-addons' ),
				'description'  => esc_html__( 'Enabling this option will replace the real archive description with placeholder text.', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off'    => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'tag',
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

		$this->add_control(
			'align',
			[
				'label' => esc_html__( 'Alignment', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justify', 'zyre-elementor-addons' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => is_rtl() ? 'right' : 'left',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .zyre-archive-desc' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register styles related controls
	 */
	protected function register_style_controls() {
		$this->start_controls_section(
			'section_archive_desc_style',
			[
				'label' => esc_html__( 'Archive Description', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'text',
			[
				'selector' => '{{WRAPPER}} .zyre-archive-desc',
				'controls' => [
					'typography' => [],
					'color'      => [],
					'shadow'     => [],
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
		$archive_desc = get_the_archive_description();
		$archive_desc = preg_replace( '#^<p>(.*?)</p>$#is', '$1', trim( $archive_desc ) );
		if ( 'yes' === $settings['show_placeholder'] ) {
			$archive_desc = __( 'This is placeholder text. To display the real description for the archive pages, add or fill the archive\'s "Description" field in the WordPress admin.', 'zyre-elementor-addons' );
		}

		if ( ! empty( $archive_desc ) ) {
			echo '<' . zyre_escape_tags( $settings ['tag'], 'p' ) . ' class="zyre-archive-desc zy-m-0">' . esc_html( $archive_desc ) . '</' . zyre_escape_tags( $settings ['tag'], 'p' ) . '>';
		}
	}
}
