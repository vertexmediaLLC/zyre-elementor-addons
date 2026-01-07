<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class PDF_View extends Base {

	public function get_title() {
		return esc_html__( 'PDF View', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-PDF-view';
	}

	public function get_keywords() {
		return array( 'pdf', 'document', 'docs', 'pdf view', 'pdf iframe', 'pdf download', 'pdf reader' );
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	/**
	 * Register widget content controls
	 */
	protected function register_content_controls() {
		$this->start_controls_section(
			'section_pdf_view_content',
			[
				'label' => esc_html__( 'PDF View', 'zyre-elementor-addons' ),
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$this->add_control(
			'file_type',
			[
				'label'   => esc_html__( 'File Source', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'url'         => esc_html__( 'URL', 'zyre-elementor-addons' ),
					'upload_file' => esc_html__( 'Upload File', 'zyre-elementor-addons' ),
				],
				'default' => 'url',
			]
		);

		$this->add_control(
			'pdf_url',
			[
				'label'         => esc_html__( 'PDF URL', 'zyre-elementor-addons' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => esc_html__( 'http://www.example.com/sample.pdf', 'zyre-elementor-addons' ),
				'show_external' => false,
				'condition'     => [
					'file_type' => 'url',
				],
				'default'       => [
					'url' => ZYRE_ADDONS_ASSETS . 'pdf/sample.pdf',
				],
				'ai'            => false,
			]
		);

		$this->add_control(
			'pdf_file',
			[
				'label'      => esc_html__( 'Choose PDF', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::MEDIA,
				'media_type' => 'application/pdf',
				'condition'  => [
					'file_type' => 'upload_file',
				],
				'ai'         => false,
			]
		);

		$this->add_control(
			'pdf_title',
			[
				'label'       => esc_html__( 'PDF Title', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'PDF Title', 'zyre-elementor-addons' ),
				'placeholder' => esc_html__( 'Type title', 'zyre-elementor-addons' ),
				'ai'          => false,
			]
		);

		$this->add_control(
			'pdf_author',
			[
				'label'       => esc_html__( 'PDF Sub Title', 'zyre-elementor-addons' ),
				'placeholder' => esc_html__( 'Type Sub title', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'ai'          => false,
			]
		);

		$this->add_control(
			'pdf_header_direction',
			[
				'label'   => esc_html__( 'Direction', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'column',
				'options' => [
					'column' => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'row'    => [
						'title' => esc_html__( 'Bottom', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'toggle'  => false,
			]
		);

		/**
		 * PDF Icon
		 */
		$this->add_control(
			'enable_icon',
			[
				'label'        => esc_html__( 'Show Icon', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_responsive_control(
			'pdf_icon_media',
			[
				'label'       => esc_html__( 'Set Icon/Image', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => true,
				'options'     => [
					'icon'  => [
						'title' => esc_html__( 'Icon', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-star',
					],
					'image' => [
						'title' => esc_html__( 'Image', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-image',
					],
				],
				'default'     => 'icon',
			]
		);

		$this->add_control(
			'pdf_icon',
			[
				'label'       => esc_html__( 'Icon', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => true,
				'default'     => [
					'value'   => 'far fa-file-pdf',
					'library' => 'regular',
				],
				'condition'   => [
					'pdf_icon_media[value]' => 'icon',
				],
			]
		);

		$this->add_control(
			'pdf_icon_image',
			[
				'label'     => esc_html__( 'Image', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'ai'        => [
					'active' => false,
				],
				'dynamic'   => [
					'active' => true,
				],
				'condition' => [
					'pdf_icon_media[value]' => 'image',
				],
			],
		);

		$this->add_control(
			'pdf_icon_text',
			[
				'label'       => esc_html__( 'PDF Icon Text', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'PDF', 'zyre-elementor-addons' ),
				'placeholder' => esc_html__( 'PDF Icon Text', 'zyre-elementor-addons' ),
				'ai'          => false,
				'condition'   => [
					'enable_icon' => 'yes',
				],
			]
		);

		$this->add_control(
			'enable_download',
			[
				'label'        => esc_html__( 'Show Download', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'download_icon',
			[
				'label'     => esc_html__( 'Download Icon', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'far fa-file-pdf',
					'library' => 'regular',
				],
				'condition' => [
					'enable_download' => 'yes',
				],
			]
		);

		$this->add_control(
			'download_button_text',
			[
				'label'       => esc_html__( 'Download Button Text', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Download PDF', 'zyre-elementor-addons' ),
				'placeholder' => esc_html__( 'Download Button', 'zyre-elementor-addons' ),
				'ai'          => false,
				'condition'   => [
					'enable_download' => 'yes',
				],
			]
		);

		$this->add_control(
			'page_number',
			[
				'label'       => esc_html__( 'Page Number', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 1,
				'description' => esc_html__( 'Set the initial page number to display.', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'show_toolbar',
			[
				'label'        => esc_html__( 'Show Toolbar', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			]
		);

		$this->add_responsive_control(
			'pdf_width',
			[
				'label'      => esc_html__( 'Width', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['%', 'px'],
				'range'      => [
					'%'  => [
						'min' => 5,
						'max' => 100,
					],
					'px' => [
						'min'  => 100,
						'max'  => 2000,
						'step' => 1,
					],
				],
				'default'    => [
					'size' => 100,
					'unit' => '%',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'pdf_height',
			[
				'label'      => esc_html__( 'Height', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'vh', 'em'],
				'range'      => [
					'px' => [
						'min'  => 200,
						'max'  => 2000,
						'step' => 1,
					],
					'em' => [
						'min' => 5,
						'max' => 100,
					],
					'vh' => [
						'min' => 2,
						'max' => 100,
					],
				],
				'default'    => [
					'size' => 984,
					'unit' => 'px',
				],
			]
		);

		$this->add_responsive_control(
			'pdf_border_radius',
			[
				'label'     => esc_html__( 'Border Radius', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'default'   => [
					'unit'   => 'px',
					'top'    => 5,
					'right'  => 5,
					'bottom' => 5,
					'left'   => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .pdfobject-container > iframe' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register styles related controls
	 */
	protected function register_style_controls() {
		$this->__titlebar_style();
		$this->__icon_image_style();
		$this->__title_style();
		$this->__author_style();
		$this->__btn_style();
	}

	/**
	 * Title Bar
	 */
	protected function __titlebar_style() {
		$this->start_controls_section(
			'titlebar_style',
			[
				'label'      => esc_html__( 'Title Bar', 'zyre-elementor-addons' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'pdf_title',
							'operator' => '!==',
							'value'    => '',
						],
						[
							'name'  => 'enable_download',
							'value' => 'yes',
						],
						[
							'name'  => 'enable_icon',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->set_style_controls(
			'titlebar',
			[
				'selector' => '{{WRAPPER}} .zyre-pdf-view-header',
				'controls' => [
					'bottom_spacing' => [
						'label' => esc_html__( 'Bottom Spacing', 'zyre-elementor-addons' ),
					],
					'bg_color'       => [],
					'padding'        => [],
					'border'         => [],
					'border_radius'  => [],
					'direction'      => [],
					'align_x'        => [
						'label_block' => true,
						'default'     => 'space-between',
						'condition'   => [
							'titlebar_direction' => ['row', ''],
						],
					],
					'align_xy'       => [
						'default'        => 'flex-start',
						'tablet_default' => 'flex-start',
						'mobile_default' => 'flex-start',
						'condition'      => [
							'titlebar_direction' => ['column'],
						],
					],
					'gap'            => [],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Icon / Image
	 */
	protected function __icon_image_style() {
		$this->start_controls_section(
			'icon_style',
			[
				'label'     => esc_html__( 'Icon / Image', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'enable_icon' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'icon_wrap',
			[
				'selector' => '{{WRAPPER}} .zyre-pdf-view-icon-wrap',
				'controls' => [
					'margin'        => [],
					'bg_color'      => [],
					'width'         => [],
					'height'        => [],
					'padding'       => [],
					'border_radius' => [],
					'align_x'       => [
						'options' => [
							'space-between' => [
								'title' => esc_html__( 'Space Between', 'zyre-elementor-addons' ),
								'icon'  => 'eicon-justify-space-between-h',
							],
							'space-around'  => [
								'title' => esc_html__( 'Space Around', 'zyre-elementor-addons' ),
								'icon'  => 'eicon-justify-space-around-h',
							],
							'space-evenly'  => [
								'title' => esc_html__( 'Space Evenly', 'zyre-elementor-addons' ),
								'icon'  => 'eicon-justify-space-evenly-h',
							],
						],
					],
					'align_y'       => [],
				],
			]
		);

		$this->add_control(
			'icon_heading',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Icon Styles', 'zyre-elementor-addons' ),
				'separator' => 'before',
				'condition' => [
					'pdf_icon_media[value]' => 'icon',
				],
			]
		);

		$this->set_style_controls(
			'icon',
			[
				'selector'  => '{{WRAPPER}} .zyre-pdf-view-icon',
				'controls'  => [
					'icon_size'     => [
						'default' => [
							'size' => 30,
						],
					],
					'icon_color'    => [],
					'bg_color'      => [],
					'width'         => [],
					'height'        => [],
					'padding'       => [],
					'border_radius' => [],
				],
				'condition' => [
					'pdf_icon_media[value]' => 'icon',
				],
			]
		);

		$this->add_control(
			'image_heading',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Image Styles', 'zyre-elementor-addons' ),
				'separator' => 'before',
				'condition' => [
					'pdf_icon_media[value]' => 'image',
				],
			]
		);

		$this->set_style_controls(
			'image',
			[
				'selector'  => '{{WRAPPER}} .zyre-pdf-view-image',
				'controls'  => [
					'bg_color'      => [],
					'width'         => [],
					'height'        => [],
					'padding'       => [],
					'border_radius' => [],
				],
				'condition' => [
					'pdf_icon_media[value]' => 'image',
				],
			]
		);

		$this->add_control(
			'icon_text_heading',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Icon Text Styles', 'zyre-elementor-addons' ),
				'separator' => 'before',
				'condition' => [
					'pdf_icon_text!' => '',
				],
			]
		);

		$this->set_style_controls(
			'icon_text',
			[
				'selector'  => '{{WRAPPER}} .zyre-pdf-view-icon-text',
				'controls'  => [
					'spacing'    => [
						'label'        => esc_html__( 'Icon Text Spacing', 'zyre-elementor-addons' ),
						'css_property' => is_rtl() ? 'margin-right' : 'margin-left',
						'default'      => [
							'size' => 10,
						],
					],
					'typography' => [],
					'color'      => [],
				],
				'condition' => [
					'pdf_icon_text!' => '',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Title
	 */
	protected function __title_style() {
		$this->start_controls_section(
			'title_style',
			[
				'label'     => esc_html__( 'Title', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'pdf_title!' => '',
				],
			]
		);

		$this->set_style_controls(
			'title',
			[
				'selector' => '{{WRAPPER}} .zyre-pdf-view-title',
				'controls' => [
					'typography' => [],
					'color'      => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
					'margin'     => [],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Author
	 */
	protected function __author_style() {
		$this->start_controls_section(
			'author_style',
			[
				'label'     => esc_html__( 'Author', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'pdf_author!' => '',
				],
			]
		);

		$this->set_style_controls(
			'author',
			[
				'selector' => '{{WRAPPER}} .zyre-pdf-view-author',
				'controls' => [
					'typography' => [],
					'color'      => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
					'margin'     => [],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Download Button
	 */
	protected function __btn_style() {
		$this->start_controls_section(
			'download_btn_style',
			[
				'label'     => esc_html__( 'Download Button', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'enable_download' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'download_btn_wrap',
			[
				'selector' => '{{WRAPPER}} .zyre-pdf-view-btn',
				'controls' => [
					'typography'    => [],
					'border'        => [],
					'border_radius' => [],
					'padding'       => [],
					'margin'        => [],
				],
			],
		);

		$this->set_style_controls(
			'download_btn_icon',
			[
				'selector' => '{{WRAPPER}} .zyre-pdf-download-icon',
				'controls' => [
					'icon_size' => [
						'default' => [
							'size' => 30,
						],
					],
					'spacing'   => [
						'label'        => esc_html__( 'Icon Spacing', 'zyre-elementor-addons' ),
						'css_property' => is_rtl() ? 'margin-left' : 'margin-right',
						'default'      => [
							'size' => 10,
						],
					],
				],
			],
		);

		$this->start_controls_tabs(
			'download_btn_style_tabs',
		);

		$this->start_controls_tab(
			'download_btn_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'download_btn_wrap_normal',
			[
				'selector' => '{{WRAPPER}} .zyre-pdf-view-btn',
				'controls' => [
					'bg_color' => [],
				],
			]
		);

		$this->set_style_controls(
			'download_btn_icon_normal',
			[
				'selector' => '{{WRAPPER}} .zyre-pdf-download-icon',
				'controls' => [
					'icon_color' => [
						'label' => esc_html__( 'Icon Color', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->set_style_controls(
			'download_btn_text_normal',
			[
				'selector' => '{{WRAPPER}} .zyre-pdf-download-icon-text',
				'controls' => [
					'text_color' => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'download_btn_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'download_btn_wrap_hover',
			[
				'selector' => '{{WRAPPER}} .zyre-pdf-view-btn:hover',
				'controls' => [
					'bg_color' => [],
				],
			]
		);

		$this->set_style_controls(
			'download_btn_icon_hover',
			[
				'selector' => '{{WRAPPER}} .zyre-pdf-view-btn:hover .zyre-pdf-download-icon',
				'controls' => [
					'icon_color' => [
						'label' => esc_html__( 'Icon Color', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->set_style_controls(
			'download_btn_text_hover',
			[
				'selector' => '{{WRAPPER}} .zyre-pdf-view-btn:hover .zyre-pdf-download-icon-text',
				'controls' => [
					'text_color' => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Register render display controls
	 */
	protected function render() {
		$settings  = $this->get_settings_for_display();
		$unique_id = 'viewer-' . $this->get_id();
		$file_type = $settings['file_type'];

		$pdf_url_i = '';

		if ( 'url' === $file_type ) {
			$pdf_url_i = $settings['pdf_url']['url'];
		} else {
			$pdf_url_i = $settings['pdf_file']['url'];
		}

		if ( isset( $settings['pdf_width'] ) ) {
			$width = $settings['pdf_width']['size'] . $settings['pdf_width']['unit'];
		}
		if ( isset( $settings['pdf_height'] ) ) {
			$height = $settings['pdf_height']['size'] . $settings['pdf_height']['unit'];
		}

		if ( empty( $pdf_url_i ) ) {
			$pdf_url_i = ZYRE_ADDONS_ASSETS . 'pdf/sample.pdf';
		}

		$json_settings = [
			'unique_id'   => esc_attr( $unique_id ),
			'pdf_url'     => esc_url( $pdf_url_i ),
			'file_type'   => esc_attr( $file_type ),
			'page_number' => ! empty( $settings['page_number'] ) ? intval( $settings['page_number'] ) : 1,
			'toolbar'     => ( 'yes' !== $settings['show_toolbar'] ) ? 0 : 1,
			'width'       => esc_attr( $width ),
			'height'      => esc_attr( $height ),
		];

		$this->add_render_attribute( 'pdf_settings', 'class', 'pdf_viewer_options ' . esc_attr( $unique_id ) );
		$this->add_render_attribute( 'pdf_settings', 'data-pdf-settings', wp_json_encode( $json_settings ) );

		$show_header = ( 'yes' === $settings['enable_icon'] || ! empty( $settings['pdf_title'] ) || 'yes' === $settings['enable_download'] );

		$header_direction = 'zy-direction-row zy-align-center';
		if ( 'row' === $settings['pdf_header_direction'] ) {
			$header_direction = 'zy-direction-column zy-justify-center';
		}
		?>
		<div class="zyre-pdf-view-container">
			<div <?php $this->print_render_attribute_string( 'pdf_settings' ); ?>>
				<?php if ( $show_header ) : ?>
					<div class="zyre-pdf-view-header zy-flex zy-align-center zy-gap-3">
						<div class="zyre-pdf-view-header-left zy-flex zy-align-center">
							<div class="zyre-pdf-view-header-left-content zy-flex <?php echo esc_attr( $header_direction ); ?>">
								<?php
								if ( 'yes' === $settings['enable_icon'] ) :
									?>
									<div class="zyre-pdf-view-icon-wrap zy-m-0 zy-inline-flex">
										<?php if ( 'image' === $settings['pdf_icon_media'] && ( $settings['pdf_icon_image']['url'] || $settings['pdf_icon_image']['id'] ) ) : ?>
											<span class="zyre-pdf-view-image zy-inline-flex zy-align-center zy-justify-center">
												<img src="<?php echo esc_url( $settings['pdf_icon_image']['url'] ); ?>">
											</span>
										<?php elseif ( 'icon' === $settings['pdf_icon_media'] && ( ! empty( $settings['pdf_icon']['value'] ) ) ) : ?>
											<span class="zyre-pdf-view-icon zy-inline-flex zy-align-center zy-justify-center zy-shrink-0">
												<?php zyre_render_icon( $settings, 'icon', 'pdf_icon' ); ?>
											</span>										
										<?php endif; ?>

										<?php if ( $settings['pdf_icon_text'] ) : ?>
											<span class="zyre-pdf-view-icon-text zy-inline-flex zy-align-center zy-justify-center">
												<?php echo esc_html( $settings['pdf_icon_text'] ); ?>
											</span>										
										<?php endif; ?>
									</div>
									<?php
								endif;
								if ( $settings['pdf_title'] ) {
									printf(
										'<h2 class="zyre-pdf-view-title zy-m-0 zy-inline-flex">%s</h2>',
										esc_html( $settings['pdf_title'] )
									);
								}
								if ( $settings['pdf_author'] ) {
									printf(
										'<p class="zyre-pdf-view-author zy-m-0 zy-inline-flex">%s</p>',
										esc_html( $settings['pdf_author'] )
									);
								}
								?>
							</div>
						</div>
						<div class="zyre-pdf-view-header-right">
							<?php if ( 'yes' === $settings['enable_download'] ) : ?>
								<a href="<?php echo esc_url( $pdf_url_i ); ?>" class="zyre-pdf-view-btn zy-transition zy-flex zy-align-center" download title="<?php echo esc_attr( $settings['pdf_title'] ); ?>">
									<?php if ( ! empty( $settings['download_icon']['value'] ) ) : ?>
										<span class="zyre-pdf-download-icon zy-inline-block">
											<?php zyre_render_icon( $settings, 'icon', 'download_icon', [ 'class' => 'zy-transition' ] ); ?>
										</span>									
									<?php endif; ?>
									<?php if ( ! empty( $settings['download_button_text'] ) ) : ?>
										<span class="zyre-pdf-download-icon-text zy-inline-block zy-transition">
											<?php echo esc_html( $settings['download_button_text'] ); ?>
										</span>									
									<?php endif; ?>
								</a>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>

				<div>
					<div id="<?php echo esc_attr( $unique_id ); ?>"></div>
				</div>
			</div>
		<?php
	}
}
