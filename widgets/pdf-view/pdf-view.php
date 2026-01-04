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
			array(
				'label' => esc_html__( 'PDF View', 'zyre-elementor-addons' ),
			)
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$this->add_control(
			'file_type',
			array(
				'label'   => esc_html__( 'File Source', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'url'         => esc_html__( 'URL', 'zyre-elementor-addons' ),
					'upload_file' => esc_html__( 'Upload File', 'zyre-elementor-addons' ),
				),
				'default' => 'url',
			)
		);

		$this->add_control(
			'pdf_url',
			array(
				'label'         => esc_html__( 'PDF URL', 'zyre-elementor-addons' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => esc_html__( 'http://www.example.com/sample.pdf', 'zyre-elementor-addons' ),
				'show_external' => false,
				'condition'     => array(
					'file_type' => 'url',
				),
				'default'       => array(
					'url' => ZYRE_ADDONS_ASSETS . 'pdf/sample.pdf',
				),
				'ai'            => false,
			)
		);

		$this->add_control(
			'pdf_file',
			array(
				'label'      => esc_html__( 'Choose PDF', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::MEDIA,
				'media_type' => 'application/pdf',
				'condition'  => array(
					'file_type' => 'upload_file',
				),
				'ai'         => false,
			)
		);

		$this->add_control(
			'pdf_header_direction',
			array(
				'label'   => esc_html__( 'Header Direction', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'column',
				'options' => array(
					'column' => array(
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-left',
					),
					'row'    => array(
						'title' => esc_html__( 'Bottom', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
				'toggle'  => false,
			)
		);

		$this->add_control(
			'pdf_title',
			array(
				'label'       => esc_html__( 'PDF Title', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'PDF Title', 'zyre-elementor-addons' ),
				'placeholder' => esc_html__( 'Type PDF title', 'zyre-elementor-addons' ),
				'ai'          => false,
			)
		);

		$this->add_control(
			'pdf_author',
			array(
				'label'       => esc_html__( 'PDF Author', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'PDF Author', 'zyre-elementor-addons' ),
				'placeholder' => esc_html__( 'Type Author Name', 'zyre-elementor-addons' ),
				'ai'          => false,
			)
		);

		/**
		 * PDF Icon
		 */
		$this->add_control(
			'enable_icon',
			array(
				'label'        => esc_html__( 'Show Icon', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
				'separator'    => 'before',
			)
		);

		$this->add_responsive_control(
			'pdf_icon_media',
			array(
				'label'       => esc_html__( 'Set Icon/Image', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => true,
				'options'     => array(
					'icon'  => array(
						'title' => esc_html__( 'Icon', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-star',
					),
					'image' => array(
						'title' => esc_html__( 'Image', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-image',
					),
				),
				'default'     => 'icon',
			)
		);

		$this->add_control(
			'pdf_icon',
			array(
				'label'       => esc_html__( 'Icon', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => true,
				'default'     => array(
					'value'   => 'far fa-file-pdf',
					'library' => 'regular',
				),
				'condition'   => array(
					'pdf_icon_media[value]' => 'icon',
				),
			)
		);

		$this->add_control(
			'pdf_icon_image',
			array(
				'label'     => esc_html__( 'Image', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => array(
					'url' => Utils::get_placeholder_image_src(),
				),
				'ai'        => array(
					'active' => false,
				),
				'dynamic'   => array(
					'active' => true,
				),
				'condition' => array(
					'pdf_icon_media[value]' => 'image',
				),
			),
		);

		$this->add_control(
			'pdf_icon_text',
			array(
				'label'       => esc_html__( 'PDF Icon Text', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'PDF', 'zyre-elementor-addons' ),
				'placeholder' => esc_html__( 'PDF Icon Text', 'zyre-elementor-addons' ),
				'ai'          => false,
				'condition'   => array(
					'enable_icon' => 'yes',
				),
			)
		);

		$this->add_control(
			'enable_download',
			array(
				'label'        => esc_html__( 'Show Download', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
				'separator'    => 'before',
			)
		);

		$this->add_control(
			'download_icon',
			array(
				'label'     => esc_html__( 'Download Icon', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => array(
					'value'   => 'far fa-file-pdf',
					'library' => 'regular',
				),
				'condition' => array(
					'enable_download' => 'yes',
				),
			)
		);

		$this->add_control(
			'download_button_text',
			array(
				'label'       => esc_html__( 'Download Button Text', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Download PDF', 'zyre-elementor-addons' ),
				'placeholder' => esc_html__( 'Download Button', 'zyre-elementor-addons' ),
				'ai'          => false,
				'condition'   => array(
					'enable_download' => 'yes',
				),
			)
		);

		$this->add_control(
			'page_number',
			array(
				'label'       => esc_html__( 'Page Number', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 1,
				'description' => esc_html__( 'Set the initial page number to display.', 'zyre-elementor-addons' ),
			)
		);

		$this->add_control(
			'show_toolbar',
			array(
				'label'        => esc_html__( 'Show Toolbar', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_responsive_control(
			'pdf_width',
			array(
				'label'      => esc_html__( 'Width', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%', 'px' ),
				'range'      => array(
					'%'  => array(
						'min' => 5,
						'max' => 100,
					),
					'px' => array(
						'min'  => 100,
						'max'  => 2000,
						'step' => 1,
					),
				),
				'default'    => array(
					'size' => 100,
					'unit' => '%',
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			'pdf_height',
			array(
				'label'      => esc_html__( 'Height', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'vh', 'em' ),
				'range'      => array(
					'px' => array(
						'min'  => 200,
						'max'  => 2000,
						'step' => 1,
					),
					'em' => array(
						'min' => 5,
						'max' => 100,
					),
					'vh' => array(
						'min' => 2,
						'max' => 100,
					),
				),
				'default'    => array(
					'size' => 600,
					'unit' => 'px',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register styles related controls
	 */
	protected function register_style_controls() {
		$this->__titlebar_style();
		$this->__icon_style();
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
			array(
				'label'      => esc_html__( 'Title Bar', 'zyre-elementor-addons' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'name'     => 'pdf_title',
							'operator' => '!==',
							'value'    => '',
						),
						array(
							'name'  => 'enable_download',
							'value' => 'yes',
						),
						array(
							'name'  => 'enable_icon',
							'value' => 'yes',
						),
					),
				),
			)
		);

		$this->set_style_controls(
			'titlebar',
			array(
				'selector' => '{{WRAPPER}} .zyre-pdf-view-header',
				'controls' => array(
					'bottom_spacing' => array(
						'label' => esc_html__( 'Bottom Spacing', 'zyre-elementor-addons' ),
					),
					'bg_color'       => array(),
					'padding'        => array(),
					'border'         => array(),
					'border_radius'  => array(),
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Icon / Image
	 */
	protected function __icon_style() {
		$this->start_controls_section(
			'icon_style',
			array(
				'label'     => esc_html__( 'Icon / Image', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'enable_icon' => 'yes',
				),
			)
		);

		$this->set_style_controls(
			'icon_wrap',
			array(
				'selector' => '{{WRAPPER}} .zyre-pdf-view-icon-wrap',
				'controls' => array(
					'margin'        => array(),
					'bg_color'      => array(),
					'width'         => array(),
					'height'        => array(),
					'padding'       => array(),
					'border_radius' => array(),
				),
			)
		);

		$this->add_control(
			'icon_heading',
			array(
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Icon Styles', 'zyre-elementor-addons' ),
				'separator' => 'before',
				'condition' => array(
					'pdf_icon_media[value]' => 'icon',
				),
			)
		);

		$this->set_style_controls(
			'icon',
			array(
				'selector' => '{{WRAPPER}} .zyre-pdf-view-icon',
				'controls' => array(
					'icon_size'     => array(
						'default' => array(
							'size' => 30,
						),
					),
					'icon_color'    => array(),
					'bg_color'      => array(),
					'width'         => array(),
					'height'        => array(),
					'padding'       => array(),
					'border_radius' => array(),
					'condition'     => array(
						'pdf_icon_media[value]' => 'icon',
					),
				),
			)
		);

		$this->add_control(
			'image_heading',
			array(
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Image Styles', 'zyre-elementor-addons' ),
				'separator' => 'before',
				'condition' => array(
					'pdf_icon_media[value]' => 'image',
				),
			)
		);

		$this->set_style_controls(
			'image',
			array(
				'selector' => '{{WRAPPER}} .zyre-pdf-view-image',
				'controls' => array(
					'bg_color'      => array(),
					'width'         => array(),
					'height'        => array(),
					'padding'       => array(),
					'border_radius' => array(),
					'condition'     => array(
						'pdf_icon_media[value]' => 'image',
					),
				),
			)
		);

		$this->add_control(
			'icon_text_heading',
			array(
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Icon Text Styles', 'zyre-elementor-addons' ),
				'separator' => 'before',
				'condition' => array(
					'pdf_icon_text!' => '',
				),
			)
		);

		$this->set_style_controls(
			'icon_text',
			array(
				'selector' => '{{WRAPPER}} .zyre-pdf-view-icon-text',
				'controls' => array(
					'spacing'    => array(
						'label'        => esc_html__( 'Icon Text Spacing', 'zyre-elementor-addons' ),
						'css_property' => is_rtl() ? 'margin-right' : 'margin-left',
						'default'      => array(
							'size' => 10,
						),
					),
					'typography' => array(),
					'color'      => array(),
					'condition'  => array(
						'pdf_icon_text!' => '',
					),
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Title
	 */
	protected function __title_style() {
		$this->start_controls_section(
			'title_style',
			array(
				'label'     => esc_html__( 'Title', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'pdf_title!' => '',
				),
			)
		);

		$this->set_style_controls(
			'title',
			array(
				'selector' => '{{WRAPPER}} .zyre-pdf-view-title',
				'controls' => array(
					'typography' => array(),
					'color'      => array(
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					),
					'margin'     => array(),
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Author
	 */
	protected function __author_style() {
		$this->start_controls_section(
			'author_style',
			array(
				'label'     => esc_html__( 'Author', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'pdf_author!' => '',
				),
			)
		);

		$this->set_style_controls(
			'author',
			array(
				'selector' => '{{WRAPPER}} .zyre-pdf-view-author',
				'controls' => array(
					'typography' => array(),
					'color'      => array(
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					),
					'margin'     => array(),
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Download Button
	 */
	protected function __btn_style() {
		$this->start_controls_section(
			'download_btn_style',
			array(
				'label'     => esc_html__( 'Download Button', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'enable_download' => 'yes',
				),
			)
		);

		$this->set_style_controls(
			'download_btn_wrap',
			array(
				'selector' => '{{WRAPPER}} .zyre-pdf-view-btn',
				'controls' => array(
					'typography'    => array(),
					'border'        => array(),
					'border_radius' => array(),
					'padding'       => array(),
				),
			),
		);

		$this->set_style_controls(
			'download_btn_icon',
			array(
				'selector' => '{{WRAPPER}} .zyre-pdf-download-icon',
				'controls' => array(
					'icon_size' => array(
						'default' => array(
							'size' => 30,
						),
					),
					'spacing'   => array(
						'label'        => esc_html__( 'Icon Spacing', 'zyre-elementor-addons' ),
						'css_property' => is_rtl() ? 'margin-left' : 'margin-right',
						'default'      => array(
							'size' => 10,
						),
					),
				),
			),
		);

		$this->start_controls_tabs(
			'download_btn_style_tabs',
		);

		$this->start_controls_tab(
			'download_btn_normal_tab',
			array(
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			)
		);

		$this->set_style_controls(
			'download_btn_wrap_normal',
			array(
				'selector' => '{{WRAPPER}} .zyre-pdf-view-btn',
				'controls' => array(
					'bg_color' => array(),
				),
			)
		);

		$this->set_style_controls(
			'download_btn_icon_normal',
			array(
				'selector' => '{{WRAPPER}} .zyre-pdf-download-icon',
				'controls' => array(
					'icon_color' => array(
						'label' => esc_html__( 'Icon Color', 'zyre-elementor-addons' ),
					),
				),
			)
		);

		$this->set_style_controls(
			'download_btn_text_normal',
			array(
				'selector' => '{{WRAPPER}} .zyre-pdf-download-icon-text',
				'controls' => array(
					'text_color' => array(
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					),
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'download_btn_hover_tab',
			array(
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			)
		);

		$this->set_style_controls(
			'download_btn_wrap_hover',
			array(
				'selector' => '{{WRAPPER}} .zyre-pdf-view-btn:hover',
				'controls' => array(
					'bg_color' => array(),
				),
			)
		);

		$this->set_style_controls(
			'download_btn_icon_hover',
			array(
				'selector' => '{{WRAPPER}} .zyre-pdf-view-btn:hover .zyre-pdf-download-icon',
				'controls' => array(
					'icon_color' => array(
						'label' => esc_html__( 'Icon Color', 'zyre-elementor-addons' ),
					),
				),
			)
		);

		$this->set_style_controls(
			'download_btn_text_hover',
			array(
				'selector' => '{{WRAPPER}} .zyre-pdf-view-btn:hover .zyre-pdf-download-icon-text',
				'controls' => array(
					'text_color' => array(
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					),
				),
			)
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

		$json_settings = array(
			'unique_id'   => esc_attr( $unique_id ),
			'pdf_url'     => esc_url( $pdf_url_i ),
			'file_type'   => esc_attr( $file_type ),
			'page_number' => ! empty( $settings['page_number'] ) ? intval( $settings['page_number'] ) : 1,
			'toolbar'     => ( 'yes' !== $settings['show_toolbar'] ) ? 0 : 1,
			'width'       => esc_attr( $width ),
			'height'      => esc_attr( $height ),
		);

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
					<div class="zyre-pdf-view-header zy-flex zy-align-center">
						<div class="zyre-pdf-view-header-left zy-flex zy-align-center zy-grow-1">
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
											<span class="zyre-pdf-view-icon zy-inline-flex zy-align-center zy-justify-center">
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
											<?php zyre_render_icon( $settings, 'icon', 'download_icon' ); ?>
										</span>									
									<?php endif; ?>
									<?php if ( ! empty( $settings['download_button_text'] ) ) : ?>
										<span class="zyre-pdf-download-icon-text zy-inline-block">
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
