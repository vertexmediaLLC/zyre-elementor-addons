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
		return array( 'archive description', 'description', 'archive', 'archive info', 'archive details', 'archive category', 'tag description', 'tag info', 'tag details' );
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
			array(
				'label' => esc_html__( 'Archive Description', 'zyre-elementor-addons' ),
			)
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$this->add_control(
			'show_separator',
			array(
				'label'        => esc_html__( 'Show Separator', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off'    => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'show_separator_position',
			array(
				'label'                => esc_html__( 'Separator Position', 'zyre-elementor-addons' ),
				'type'                 => Controls_Manager::SELECT,
				'options'              => array(
					'left'  => esc_html__( 'Left', 'zyre-elementor-addons' ),
					'right' => esc_html__( 'Right', 'zyre-elementor-addons' ),
				),
				'default'              => 'left',
				'selectors_dictionary' => array(
					'left'  => 'flex-direction: row;',
					'right' => 'flex-direction: row-reverse;',
				),
				'selectors'            => array(
					'{{WRAPPER}} .zyre-archive-desc-wrap' => '{{VALUE}};',
				),
				'condition'            => array(
					'show_separator' => 'yes',
				),
			)
		);

		$this->add_control(
			'show_placeholder',
			array(
				'label'        => esc_html__( 'Placeholder Text', 'zyre-elementor-addons' ),
				'description'  => esc_html__( 'Enabling this option will replace the real archive description with placeholder text.', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off'    => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'tag',
			array(
				'label'   => esc_html__( 'HTML Tag', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'h1'   => array(
						'title' => esc_html__( 'H1', 'zyre-elementor-addons' ),
					),
					'h2'   => array(
						'title' => esc_html__( 'H2', 'zyre-elementor-addons' ),
					),
					'h3'   => array(
						'title' => esc_html__( 'H3', 'zyre-elementor-addons' ),
					),
					'h4'   => array(
						'title' => esc_html__( 'H4', 'zyre-elementor-addons' ),
					),
					'h5'   => array(
						'title' => esc_html__( 'H5', 'zyre-elementor-addons' ),
					),
					'h6'   => array(
						'title' => esc_html__( 'H6', 'zyre-elementor-addons' ),
					),
					'p'    => array(
						'title' => esc_html__( 'P', 'zyre-elementor-addons' ),
					),
					'span' => array(
						'title' => esc_html__( 'Span', 'zyre-elementor-addons' ),
					),
					'div'  => array(
						'title' => esc_html__( 'Div', 'zyre-elementor-addons' ),
					),
				),
				'default' => 'p',
			)
		);

		$this->add_control(
			'align',
			array(
				'label'     => esc_html__( 'Alignment', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'  => array(
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'   => array(
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-right',
					),
					'justify' => array(
						'title' => esc_html__( 'Justify', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-justify',
					),
				),
				'default'   => is_rtl() ? 'right' : 'left',
				'toggle'    => true,
				'selectors' => array(
					'{{WRAPPER}} .zyre-archive-desc' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register styles related controls
	 */
	protected function register_style_controls() {
		$this->start_controls_section(
			'section_archive_desc_style',
			array(
				'label' => esc_html__( 'Archive Description', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->set_style_controls(
			'text',
			array(
				'selector' => '{{WRAPPER}} .zyre-archive-desc',
				'controls' => array(
					'typography' => array(),
					'color'      => array(),
					'shadow'     => array(),
					'margin'     => array(),
				),
			),
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_archive_separator_style',
			array(
				'label'     => esc_html__( 'Archive Separator', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'show_separator' => 'yes',
				),
			)
		);

		$this->set_style_controls(
			'separator',
			array(
				'selector' => '{{WRAPPER}} .zyre-archive-desc-separator',
				'controls' => array(
					'width'    => array(),
					'height'   => array(),
					'bg_color' => array(),
				),
			),
		);

		$this->end_controls_section();
	}

	/**
	 * Register render display controls
	 */
	protected function render() {
		$settings               = $this->get_settings_for_display();
		$archive_desc           = get_the_archive_description();
		$archive_desc_separator = '';
		$archive_desc           = preg_replace( '#^<p>(.*?)</p>$#is', '$1', trim( $archive_desc ) );
		if ( 'yes' === $settings['show_separator'] ) {
			$archive_desc_separator = '<span class="zyre-archive-desc-separator"></span>';
		}
		if ( 'yes' === $settings['show_placeholder'] ) {
			$archive_desc = __( 'This is placeholder text. To display the real description for the archive pages, add or fill the archive\'s "Description" field in the WordPress admin.', 'zyre-elementor-addons' );
		}

		if ( ! empty( $archive_desc ) ) {
			echo '<div class="zyre-archive-desc-wrap zy-flex zy-align-center zy-justify-between">';
			echo '<' . zyre_escape_tags( $settings ['tag'], 'p' ) . ' class="zyre-archive-desc zy-m-0">' . esc_html( $archive_desc ) . '</' . zyre_escape_tags( $settings ['tag'], 'p' ) . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $archive_desc_separator; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo '</div>';
		}
	}
}
