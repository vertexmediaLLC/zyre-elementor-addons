<?php
namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Testimonial extends Base {

	public function get_title() {
		return esc_html__( 'Testimonial', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Testimonial-rating';
	}

	public function get_keywords() {
		return [ 'testimonial', 'reviews', 'feedback', 'quote', 'blockquote', 'appreciate', 'ratings', 'stars', 'recommendation' ];
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	/**
	 * Register content controls
	 */
	protected function register_content_controls() {
		$this->__template_style_controls();
		$this->__testimonial_content_controls();
	}

	protected function __template_style_controls() {
		$this->start_controls_section(
			'section_template_style',
			[
				'label' => esc_html__( 'Template Style', 'zyre-elementor-addons' ),
			]
		);

		$this->set_prestyle_controls();

		$this->end_controls_section();
	}

	protected function __testimonial_content_controls() {

		$this->start_controls_section(
			'section_info',
			[
				'label' => esc_html__( 'Testimonial Content', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'image',
			[
				'label'      => esc_html__( 'Image', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::MEDIA,
				'default'    => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'dynamic'    => [
					'active' => true,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image_thumb',
				'default'   => 'medium',
				'separator' => 'none',
			]
		);

		$this->add_responsive_control(
			'image_position',
			[
				'label'                => esc_html__( 'Position', 'zyre-elementor-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'left'  => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'above' => [
						'title' => esc_html__( 'Above', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-top',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
					'below' => [
						'title' => esc_html__( 'Below', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'selectors_dictionary' => [
					'left'  => 'flex-wrap: nowrap;flex-direction: row;',
					'above' => 'flex-wrap: wrap;flex-direction: initial;',
					'right' => 'flex-wrap: nowrap;flex-direction: row-reverse;',
					'below' => 'flex-wrap: wrap;flex-direction: column-reverse;',
				],
				'selectors'            => [
					'{{WRAPPER}} .elementor-widget-container' => '{{VALUE}};',
				],
				'prefix_class'         => 'zyre-testimonial--image-',
				'render_type'          => 'template',
				'condition'            => [
					'image[url]!' => '',
				],
			]
		);

		$this->add_control(
			'quote_icon',
			[
				'label'     => esc_html__( 'Quote Icon', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-quote-right',
					'library' => 'fa-solid',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'quote_icon_position',
			[
				'label'                => esc_html__( 'Icon Position', 'zyre-elementor-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'above' => [
						'title' => esc_html__( 'Above', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-top',
					],
					'below' => [
						'title' => esc_html__( 'Below', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'render_type'          => 'template',
				'condition'            => [
					'quote_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'ratting',
			[
				'label'      => esc_html__( 'Rating', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => 5,
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 5,
						'step' => 0.1,
					],
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'ratting_type',
			[
				'label'          => esc_html__( 'Ratting Type', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::SELECT,
				'options'        => [
					'none'   => esc_html__( 'None', 'zyre-elementor-addons' ),
					'star'   => esc_html__( 'Star', 'zyre-elementor-addons' ),
					'number' => esc_html__( 'Number', 'zyre-elementor-addons' ),
				],
				'default'        => 'none',
				'style_transfer' => true,
			]
		);

		$this->add_control(
			'content',
			[
				'label'       => esc_html__( 'Content', 'zyre-elementor-addons' ),
				'description' => zyre_get_allowed_html_desc( 'advanced' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam lorem ipsum dolor sit amet.', 'zyre-elementor-addons' ),
				'placeholder' => esc_html__( 'Write something amazing about the zyre addons', 'zyre-elementor-addons' ),
				'rows'        => 5,
				'dynamic'     => [
					'active' => true,
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'content_position',
			[
				'label'     => esc_html__( 'Content Position', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'above' => [
						'title' => esc_html__( 'Above', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-top',
					],
					'below' => [
						'title' => esc_html__( 'Below', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'condition' => [
					'content!' => '',
				],
			]
		);

		$this->add_control(
			'author',
			[
				'label'       => esc_html__( 'Author Name', 'zyre-elementor-addons' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html( 'Zyre' ),
				'placeholder' => esc_html__( 'Type Name here', 'zyre-elementor-addons' ),
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'designation',
			[
				'label'       => esc_html__( 'Designation', 'zyre-elementor-addons' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'CEO, ZyreAddons', 'zyre-elementor-addons' ),
				'placeholder' => esc_html__( 'Type Designation here', 'zyre-elementor-addons' ),
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'logo',
			[
				'label'      => esc_html__( 'Logo', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::MEDIA,
				'dynamic'    => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'author_tag',
			[
				'label'     => esc_html__( 'Author HTML Tag', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'h1' => [
						'title' => esc_html__( 'H1', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-editor-h1',
					],
					'h2' => [
						'title' => esc_html__( 'H2', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-editor-h2',
					],
					'h3' => [
						'title' => esc_html__( 'H3', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-editor-h3',
					],
					'h4' => [
						'title' => esc_html__( 'H4', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-editor-h4',
					],
					'h5' => [
						'title' => esc_html__( 'H5', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-editor-h5',
					],
					'h6' => [
						'title' => esc_html__( 'H6', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-editor-h6',
					],
				],
				'default'   => 'h3',
				'toggle'    => false,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'     => esc_html__( 'Alignment', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'    => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'   => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justify', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'toggle'    => true,
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register style controls
	 */
	protected function register_style_controls() {
		$this->__container_style_controls();
		$this->__image_wrapper_style_controls();
		$this->__image_style_controls();
		$this->__quote_icon_style_controls();
		$this->__ratting_style_controls();
		$this->__content_body_style_controls();
		$this->__content_elements_style_controls();
		$this->__logo_style_controls();
	}

	protected function __container_style_controls() {

		$this->start_controls_section(
			'section_container_style',
			[
				'label' => esc_html__( 'Container', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'image[url]!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'container_gap',
			[
				'label'      => esc_html__( 'Gap Between', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
					'%'  => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .elementor-widget-container' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __image_wrapper_style_controls() {

		$this->start_controls_section(
			'section_image_wrapper_style',
			[
				'label' => esc_html__( 'Image Holder', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'image[url]!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'image_wrapper_width',
			[
				'label'      => esc_html__( 'Width', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'%'  => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 10,
						'max' => 2000,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-testimonial-image' => 'min-width: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_wrapper_spacing',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .zyre-testimonial-image' => 'margin-bottom: {{SIZE}}{{UNIT}} !important',
				],
			]
		);

		$this->common_style_controls( 'image' );

		$this->add_control(
			'image_wrapper_overflow',
			[
				'label' => esc_html__( 'Overflow', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'Default', 'zyre-elementor-addons' ),
					'hidden' => esc_html__( 'Hidden', 'zyre-elementor-addons' ),
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .zyre-testimonial-image' => 'overflow: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __image_style_controls() {

		$this->start_controls_section(
			'section_image_style',
			[
				'label' => esc_html__( 'Image', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'image[url]!' => '',
				],
			]
		);

		$this->set_style_controls(
			'image',
			[
				'selector' => '{{WRAPPER}} .zyre-testimonial-image img',
				'controls' => [
					'width'      => [],
					'height'     => [],
					'object_fit' => [],
				],
			]
		);

		$this->common_style_controls( 'image_img' );

		$this->add_responsive_control(
			'image_align',
			[
				'label'     => esc_html__( 'Horizontal Alignment', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'    => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'   => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'toggle'    => true,
				'selectors' => [
					'{{WRAPPER}} .zyre-testimonial-image' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_position_y',
			[
				'label' => esc_html__( 'Vertical Position', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Top', 'zyre-elementor-addons' ),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__( 'Middle', 'zyre-elementor-addons' ),
						'icon' => 'eicon-v-align-middle',
					],
					'flex-end' => [
						'title' => esc_html__( 'Bottom', 'zyre-elementor-addons' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-testimonial-image' => 'align-content: {{VALUE}};align-items: {{VALUE}};',
				],
				'condition' => [
					'image_position' => [ 'left', 'right' ],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __quote_icon_style_controls() {

		$this->start_controls_section(
			'section_quote_icon_style',
			[
				'label' => esc_html__( 'Quote Icon', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'quote_icon[value]!' => '',
				],
			]
		);

		$this->set_style_controls(
			'quote',
			[
				'selector' => '{{WRAPPER}} .zyre-testimonial-quote-icon',
				'controls' => [
					'icon_color' => [],
					'icon_size'  => [
						'default' => [
							'unit' => 'px',
						],
					],
					'width'      => [],
					'height'     => [],
					'rotate'     => [
						'label' => esc_html__( 'Icon Rotate', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->common_style_controls( 'quote_icon' );

		$this->add_responsive_control(
			'quote_margin',
			[
				'label'      => esc_html__( 'Margin', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .zyre-testimonial-quote' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'quote_overflow',
			[
				'label'          => esc_html__( 'Overflow?', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::SWITCHER,
				'label_on'       => esc_html__( 'Yes', 'zyre-elementor-addons' ),
				'label_off'      => esc_html__( 'No', 'zyre-elementor-addons' ),
				'return_value'   => 'yes',
				'selectors'      => [
					'{{WRAPPER}} .zyre-testimonial-quote' => 'position: absolute;z-index: 2;',
				],
				'separator'      => 'before',
			]
		);

		$this->add_responsive_control(
			'quote_offset_x',
			[
				'label'      => esc_html__( 'Horizontal Offset', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', 'vw' ],
				'range'      => [
					'%'  => [
						'min' => -100,
						'max' => 100,
					],
					'px' => [
						'min' => -1000,
						'max' => 1000,
					],
					'vw'  => [
						'min' => -100,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-testimonial-quote-left' => 'left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .zyre-testimonial-quote-right' => 'right: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'quote_overflow' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'quote_offset_y',
			[
				'label'      => esc_html__( 'Vertical Offset', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', 'vw' ],
				'range'      => [
					'%'  => [
						'min' => -100,
						'max' => 100,
					],
					'px' => [
						'min' => -1000,
						'max' => 1000,
					],
					'vw'  => [
						'min' => -100,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-testimonial-quote-above' => 'top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .zyre-testimonial-quote-below' => 'bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'quote_overflow' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'quote_of_align',
			[
				'label'       => esc_html__( 'Alignment', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'left'  => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'     => is_rtl() ? 'right' : 'left',
				'render_type' => 'template',
				'condition'   => [
					'quote_overflow' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'quote_align',
			[
				'label'     => esc_html__( 'Alignment', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'    => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'   => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'toggle'    => true,
				'selectors' => [
					'{{WRAPPER}} .zyre-testimonial-quote' => 'text-align: {{VALUE}};',
				],
				'condition' => [
					'quote_overflow!' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __ratting_style_controls() {

		$this->start_controls_section(
			'section_ratting_style',
			[
				'label' => esc_html__( 'Ratting', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'ratting_type!' => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'ratting_size',
			[
				'label'      => esc_html__( 'Star Size', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 2,
						'max' => 1000,
					],
					'%' => [
						'min' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-testimonial-rating,
					{{WRAPPER}} .zyre-testimonial-rated,
					{{WRAPPER}} .zyre-testimonial-rating-num,
					{{WRAPPER}} .zyre-testimonial-rating-icon'   => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'ratting_color',
			[
				'label'     => esc_html__( 'Unrated Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-testimonial-rating' => 'color: {{VALUE}}',
				],
				'condition' => [
					'ratting_type' => 'star',
				],
			]
		);

		$this->add_control(
			'ratting_num_color',
			[
				'label'     => esc_html__( 'Number Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-testimonial-rating-num' => 'color: {{VALUE}}',
				],
				'condition' => [
					'ratting_type' => 'number',
				],
			]
		);

		$this->add_control(
			'rated_color',
			[
				'label'     => esc_html__( 'Rated/Icon Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-testimonial-rated, {{WRAPPER}} .zyre-testimonial-rating-icon i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .zyre-testimonial-rating-icon svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->set_style_controls(
			'ratting',
			[
				'selector' => '{{WRAPPER}} .zyre-testimonial-rating-stars',
				'controls' => [
					'bg_color'      => [],
					'spacing'       => [
						'label'    => esc_html__( 'Bottom Spacing', 'zyre-elementor-addons' ),
						'selector' => '{{WRAPPER}} .zyre-testimonial-rating-wrapper',
						'priority' => true,
					],
					'border'        => [],
					'border_radius' => [],
					'padding'       => [],
					'align'         => [
						'selector' => '{{WRAPPER}} .zyre-testimonial-rating-wrapper',
					],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __content_body_style_controls() {

		$this->start_controls_section(
			'section_content_body_style',
			[
				'label' => esc_html__( 'Content Body', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_body_width',
			[
				'label'      => esc_html__( 'Width', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'%'  => [
						'min' => 10,
						'max' => 100,
					],
					'px' => [
						'min' => 100,
						'max' => 2000,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-testimonial-body' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'image[url]!' => '',
					'image_position' => [ 'left', 'right' ],
				],
			]
		);

		$this->common_style_controls( 'content_body' );

		$this->add_responsive_control(
			'content_body_position_y',
			[
				'label' => esc_html__( 'Vertical Position', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Top', 'zyre-elementor-addons' ),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__( 'Middle', 'zyre-elementor-addons' ),
						'icon' => 'eicon-v-align-middle',
					],
					'flex-end' => [
						'title' => esc_html__( 'Bottom', 'zyre-elementor-addons' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-testimonial-content-body' => 'align-self: {{VALUE}}',
				],
				'condition' => [
					'image[url]!' => '',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __content_elements_style_controls() {
		// Content
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content Text', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'content!' => '',
				],
			]
		);

		$this->text_style_controls( 'content' );

		$this->end_controls_section();

		// Author
		$this->start_controls_section(
			'section_author_style',
			[
				'label' => esc_html__( 'Author', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'author!' => '',
				],
			]
		);

		$this->text_style_controls( 'author' );

		$this->end_controls_section();

		// Designation
		$this->start_controls_section(
			'section_designation_style',
			[
				'label' => esc_html__( 'Designation', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'designation!' => '',
				],
			]
		);

		$this->text_style_controls( 'designation' );

		$this->end_controls_section();
	}

	protected function __logo_style_controls() {
		$this->start_controls_section(
			'section_logo_style',
			[
				'label' => esc_html__( 'Logo', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'logo[url]!' => '',
				],
			]
		);

		$this->set_style_controls(
			'logo',
			[
				'selector' => '{{WRAPPER}} .zyre-testimonial-logo img',
				'controls' => [
					'width'   => [],
					'height'  => [],
					'spacing' => [
						'selector'     => '{{WRAPPER}} .zyre-testimonial-logo',
						'label'        => esc_html__( 'Top Spacing', 'zyre-elementor-addons' ),
						'css_property' => 'margin-top',
						'range'        => [
							'px' => [
								'min' => -200,
								'max' => 200,
							],
						],
						'priority'     => true,
					],
					'align'   => [
						'selector' => '{{WRAPPER}} .zyre-testimonial-logo',
						'default'  => is_rtl() ? 'left' : 'right',
					],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Common Style Controls.
	 *
	 * @param string $prefix The prefix of the controls.
	 */
	private function common_style_controls( string $prefix ) {
		$class_base = str_replace( '_', '-', $prefix );
		$selector = ( 'image_img' === $prefix ) ? '{{WRAPPER}} .zyre-testimonial-image img' : '{{WRAPPER}} .zyre-testimonial-' . $class_base;

		$this->set_style_controls(
			$prefix,
			[
				'selector' => $selector,
				'controls' => [
					'bg'            => [],
					'border'        => [],
					'border_radius' => [],
					'box_shadow'    => [],
					'padding'       => [],
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

		$this->add_control(
			$prefix . '_display',
			[
				'label' => esc_html__( 'Display as', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'block' => esc_html__( 'Block', 'zyre-elementor-addons' ),
					'inline-block' => esc_html__( 'Inline Block', 'zyre-elementor-addons' ),
					'inline'       => esc_html__( 'Inline', 'zyre-elementor-addons' ),
					'table' => esc_html__( 'Table', 'zyre-elementor-addons' ),
				],
				'default' => 'block',
				'selectors' => [
					'{{WRAPPER}} .zyre-testimonial-' . $class_base => 'display: {{VALUE}};',
				],
			]
		);

		$this->set_style_controls(
			$prefix,
			[
				'selector' => '{{WRAPPER}} .zyre-testimonial-' . $class_base,
				'controls' => [
					'typo'        => [],
					'color'       => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
					'text_shadow' => [],
					'border'      => [],
					'spacing'     => [
						'label' => esc_html__( 'Bottom Spacing', 'zyre-elementor-addons' ),
					],
					'padding'     => [],
				],
			]
		);
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$content_position = ! empty( $settings['content_position'] ) ? $settings['content_position'] : 'above';
		$show_icon = ! empty( $settings['quote_icon']['value'] ) ? true : false;
		$icon_position = ! empty( $settings['quote_icon_position'] ) ? $settings['quote_icon_position'] : 'above';
		$icon_align = ! empty( $settings['quote_of_align'] ) ? $settings['quote_of_align'] : 'left';

		$this->add_render_attribute( 'quote', 'class', 'zyre-testimonial-quote' );
		$this->add_render_attribute( 'quote', 'class', 'zyre-testimonial-quote-' . esc_attr( $icon_position ) );
		$this->add_render_attribute( 'quote', 'class', 'zyre-testimonial-quote-' . esc_attr( $icon_align ) );

		$this->add_inline_editing_attributes( 'content', 'basic' );
		$this->add_render_attribute( 'content', 'class', 'zyre-testimonial-content zy-m-0' );

		$this->add_inline_editing_attributes( 'author', 'basic' );
		$this->add_render_attribute( 'author', 'class', 'zyre-testimonial-author zy-m-0' );

		$this->add_inline_editing_attributes( 'designation', 'basic' );
		$this->add_render_attribute( 'designation', 'class', 'zyre-testimonial-designation' );
		?>

		<?php if ( $settings['image']['url'] || $settings['image']['id'] ) : ?>
			<figure class="zyre-testimonial-image">
				<?php echo wp_kses_post( Group_Control_Image_Size::get_attachment_image_html( $settings, 'image_thumb', 'image' ) ); ?>
			</figure>
		<?php endif; ?>

		<div class="zyre-testimonial-content-body zy-relative">
			<?php if ( $show_icon && 'above' === $icon_position ) : ?>
				<div <?php $this->print_render_attribute_string( 'quote' ); ?>>
					<span class="zyre-testimonial-quote-icon zy-inline-flex zy-align-center zy-justify-center zy-lh-1"><?php Icons_Manager::render_icon( $settings['quote_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
				</div>
			<?php endif; ?>

			<?php if ( 'none' !== $settings['ratting_type'] ) :
				$rating_count = $settings['ratting']['size'];
				$this->add_render_attribute( 'rating_wrapper', 'class', 'zyre-testimonial-rating-wrapper' );
				$this->add_render_attribute( 'rating_wrapper', 'class', 'zyre-testimonial-rating-type-' . esc_attr( $settings['ratting_type'] ) );
				$ratings = sprintf(
					/* translators: %s is the rating count */
					esc_attr__( 'Rated %s out of 5','zyre-elementor-addons' ),
					$rating_count
				);
				?>
				<div <?php $this->print_render_attribute_string( 'rating_wrapper' ); ?>>
					<div class="zyre-testimonial-rating-stars zy-relative zy-inline-flex zy-align-center zy-overflow-hidden zy-lh-1" role="img" aria-label="<?php echo esc_attr( $ratings ); ?>">
						<?php if ( 'number' === $settings['ratting_type'] ) : ?>
							<span class="zyre-testimonial-rating-num"><?php echo esc_html( $rating_count ); ?></span>
							<span class="zyre-testimonial-rating-icon"><i class="fas fa-star" aria-hidden="true"></i></span>
						<?php else : ?>
							<span class="zyre-testimonial-rating"><?php echo esc_html( '★★★★★' ); ?></span>
							<span class="zyre-testimonial-rated zy-absolute zy-left-0 zy-top-0 zy-bottom-0 zy-index-1 zy-overflow-hidden" style="width:<?php echo esc_attr( ( $rating_count / 5 ) * 100 ); ?>%"><?php echo esc_html( '★★★★★' ); ?></span>
						<?php endif; ?>
					</div>
				</div>
				<?php
			endif; ?>
			
			<?php if ( ! empty( $settings['content'] ) && 'above' === $content_position ) : ?>
				<p <?php $this->print_render_attribute_string( 'content' ); ?>><?php echo wp_kses( $settings['content'], zyre_get_allowed_html( 'advanced' ) ); ?></p>
			<?php endif; ?>

			<?php if ( ! empty( $settings['author'] ) || ! empty( $settings['designation'] ) ) : ?>
			<div class="zyre-testimonial-bio">
				<?php if ( ! empty( $settings['author'] ) ) :
					$author_html = sprintf( '<%1$s %2$s>%3$s</%1$s>',
						Utils::validate_html_tag( $settings['author_tag'] ),
						$this->get_render_attribute_string( 'author' ),
						$settings['author'],
					);
					echo wp_kses_post( $author_html );
				endif; ?>

				<?php if ( ! empty( $settings['designation'] ) ) : ?>
					<div <?php $this->print_render_attribute_string( 'designation' ); ?>><?php echo wp_kses( $settings['designation'], zyre_get_allowed_html() ); ?></div>
				<?php endif; ?>
			</div>
			<?php endif; ?>

			<?php if ( ! empty( $settings['content'] ) && 'below' === $content_position ) : ?>
				<p <?php $this->print_render_attribute_string( 'content' ); ?>><?php echo wp_kses( $settings['content'], zyre_get_allowed_html( 'advanced' ) ); ?></p>
			<?php endif; ?>

			<?php if ( $settings['logo']['url'] || $settings['logo']['id'] ) : ?>
				<figure class="zyre-testimonial-logo">
					<img src="<?php echo esc_url( $settings['logo']['url'] ); ?>" alt="">
				</figure>
			<?php endif; ?>

			<?php if ( $show_icon && 'below' === $icon_position ) : ?>
				<div <?php $this->print_render_attribute_string( 'quote' ); ?>>
					<span class="zyre-testimonial-quote-icon zy-inline-flex zy-align-center zy-justify-center zy-lh-1"><?php Icons_Manager::render_icon( $settings['quote_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
				</div>
			<?php endif; ?>
		</div>

		<?php
	}
}
