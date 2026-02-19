<?php
namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use ZyreAddons\Elementor\Traits\Button_Trait;
use ZyreAddons\Elementor\Traits\Social_Trait;

defined( 'ABSPATH' ) || die();

class Team_Member extends Base {

	use Social_Trait, Button_Trait;

	public function get_title() {
		return esc_html__( 'Team Member', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Team-member';
	}

	public function get_keywords() {
		return [ 'team', 'member', 'team member', 'crew', 'staff', 'person', 'card', 'info' ];
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	/**
	 * Register content controls
	 */
	protected function register_content_controls() {
		$this->__template_style_controls();
		$this->__info_content_controls();
		$this->__social_content_controls();
		$this->__details_content_controls();
		$this->__lightbox_content_controls();
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

	protected function __info_content_controls() {

		$this->start_controls_section(
			'section_info',
			[
				'label' => esc_html__( 'Information', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'photo',
			[
				'label'      => esc_html__( 'Photo', 'zyre-elementor-addons' ),
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
				'name'      => 'photo_thumb',
				'default'   => 'large',
				'separator' => 'none',
			]
		);

		$this->add_responsive_control(
			'photo_position',
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
				'prefix_class'         => 'zyre-team-member--photo-',
				'render_type'          => 'template',
				'condition'            => [
					'photo[url]!' => '',
				],
			]
		);

		$this->add_control(
			'name',
			[
				'label'       => esc_html__( 'Name', 'zyre-elementor-addons' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Member Name', 'zyre-elementor-addons' ),
				'placeholder' => esc_html__( 'Type Member Name', 'zyre-elementor-addons' ),
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'job_title',
			[
				'label'       => esc_html__( 'Job Title', 'zyre-elementor-addons' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Member Job Title', 'zyre-elementor-addons' ),
				'placeholder' => esc_html__( 'Type Member Job Title', 'zyre-elementor-addons' ),
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'bio',
			[
				'label'       => esc_html__( 'Short Bio', 'zyre-elementor-addons' ),
				'description' => zyre_get_allowed_html_desc( 'advanced' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Write something amazing about the team member', 'zyre-elementor-addons' ),
				'rows'        => 5,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'name_tag',
			[
				'label'     => esc_html__( 'Name HTML Tag', 'zyre-elementor-addons' ),
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

	protected function __social_content_controls() {

		$this->start_controls_section(
			'section_social',
			[
				'label' => esc_html__( 'Social Links', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->register_social_content_controls(
			[
				'default_items' => 5,
				'prevent_empty' => false,
			]
		);

		$this->add_control(
			'show_social',
			[
				'label'          => esc_html__( 'Show Socials', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::SWITCHER,
				'label_on'       => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off'      => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'return_value'   => 'yes',
				'default'        => 'yes',
				'separator'      => 'before',
				'style_transfer' => true,
			]
		);

		$this->end_controls_section();
	}

	protected function __details_content_controls() {

		$this->start_controls_section(
			'section_button',
			[
				'label' => esc_html__( 'Details Button', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_details_button',
			[
				'label'          => esc_html__( 'Show Button', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::SWITCHER,
				'label_on'       => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off'      => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'return_value'   => 'yes',
				'default'        => '',
				'style_transfer' => true,
			]
		);

		$this->add_control(
			'show_lightbox',
			[
				'label'          => esc_html__( 'Show Lightbox', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::SWITCHER,
				'description'    => esc_html__( 'Set Lightbox Content from "Lightbox" Section below.', 'zyre-elementor-addons' ),
				'label_on'       => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off'      => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'return_value'   => 'yes',
				'default'        => '',
				'style_transfer' => true,
				'condition'      => [
					'show_details_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'button_position',
			[
				'label'          => esc_html__( 'Position', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'after',
				'style_transfer' => true,
				'options'        => [
					'before' => esc_html__( 'Before Social Icons', 'zyre-elementor-addons' ),
					'after'  => esc_html__( 'After Social Icons', 'zyre-elementor-addons' ),
				],
				'condition'      => [
					'show_details_button' => 'yes',
				],
			]
		);

		$this->register_button_content_controls(
			[
				'button_default_text' => esc_html__( 'Show Details', 'zyre-elementor-addons' ),
				'condition' => [
					'show_details_button' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __lightbox_content_controls() {

		$this->start_controls_section(
			'section_lightbox',
			[
				'label'     => esc_html__( 'Lightbox', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'show_details_button' => 'yes',
					'show_lightbox'       => 'yes',
				],
			]
		);

		$this->add_control(
			'saved_template_list',
			[
				'label'       => esc_html__( 'Content Source', 'zyre-elementor-addons' ),
				'description' => esc_html__( 'Select a saved section to show in popup window.', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => $this->get_saved_content( [ 'page', 'section' ] ),
				'default'     => '0',
			]
		);

		$this->add_control(
			'show_lightbox_preview',
			[
				'label'        => esc_html__( 'Show Lightbox Preview', 'zyre-elementor-addons' ),
				'description'  => esc_html__( 'This option only works on edit mode.', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off'    => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default'      => '',
				'prefix_class' => 'zyre-member-lightbox-preview--',

			]
		);

		$this->add_control(
			'lightbox_close_position',
			[
				'label'                => esc_html__( 'Close Icon Position', 'zyre-elementor-addons' ),
				'type'                 => Controls_Manager::SELECT,
				'options'              => [
					'top-left'  => esc_html__( 'Top Left', 'zyre-elementor-addons' ),
					'top-right' => esc_html__( 'Top Right', 'zyre-elementor-addons' ),
				],
				'default'              => 'top-right',
				'selectors_dictionary' => [
					'top-left'  => 'top:0; left:0;',
					'top-right' => 'top:0; right:0;',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-member-lightbox.zyre-member-lightbox-show .zyre-member-lightbox-close,
					{{WRAPPER}}.zyre-member-lightbox-preview--yes .zyre-member-lightbox .zyre-member-lightbox-close' => '{{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register style controls
	 */
	protected function register_style_controls() {
		$this->__photo_wrapper_style_controls();
		$this->__photo_style_controls();
		$this->__content_style_controls();
		$this->__content_elements_style_controls();
		$this->__social_style_controls();
		$this->__button_style_controls();
		$this->__lightbox_style_controls();
	}

	protected function __photo_wrapper_style_controls() {

		$this->start_controls_section(
			'section_photo_wrapper_style',
			[
				'label' => esc_html__( 'Photo Holder', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'photo[url]!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'photo_wrapper_width',
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
					'{{WRAPPER}} .zyre-member-figure' => 'min-width: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'photo_spacing',
			[
				'label'      => esc_html__( 'Spacing', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .zyre-member-figure' => '--photo-space: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->common_style_controls( 'figure' );

		$this->add_control(
			'photo_wrapper_overflow',
			[
				'label' => esc_html__( 'Overflow', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'Default', 'zyre-elementor-addons' ),
					'hidden' => esc_html__( 'Hidden', 'zyre-elementor-addons' ),
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .zyre-member-figure' => 'overflow: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __photo_style_controls() {

		$this->start_controls_section(
			'section_photo_style',
			[
				'label' => esc_html__( 'Photo', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'photo[url]!' => '',
				],
			]
		);

		$this->set_style_controls(
			'photo',
			[
				'selector' => '{{WRAPPER}} .zyre-member-figure img',
				'controls' => [
					'width'      => [],
					'height'     => [],
					'object_fit' => [],
				],
			]
		);

		$this->common_style_controls( 'photo_img' );

		$this->add_responsive_control(
			'photo_align',
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
					'{{WRAPPER}} .zyre-member-figure' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'photo_position_y',
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
					'{{WRAPPER}} .zyre-member-figure' => 'align-content: {{VALUE}};align-items: {{VALUE}};',
				],
				'condition' => [
					'photo_position' => [ 'left', 'right' ],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __content_style_controls() {

		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content Body', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'content',
			[
				'selector' => '{{WRAPPER}} .zyre-member-body',
				'controls' => [
					'spacing' => [
						'label'        => esc_html__( 'Top Spacing', 'zyre-elementor-addons' ),
						'css_property' => 'margin-top',
					],
					'width'   => [
						'condition' => [
							'photo[url]!'    => '',
							'photo_position' => [ 'left', 'right' ],
						],
					],
				],
			]
		);

		$this->common_style_controls( 'content' );

		$this->add_responsive_control(
			'content_position_y',
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
					'{{WRAPPER}} .zyre-member-body' => 'align-self: {{VALUE}}',
				],
				'condition' => [
					'photo[url]!' => '',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __content_elements_style_controls() {
		// Name
		$this->start_controls_section(
			'section_name_style',
			[
				'label' => esc_html__( 'Name', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'name!' => '',
				],
			]
		);

		$this->text_style_controls( 'member_name' );

		$this->end_controls_section();

		// Job Title
		$this->start_controls_section(
			'section_job_title_style',
			[
				'label' => esc_html__( 'Job Title', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'job_title!' => '',
				],
			]
		);

		$this->text_style_controls( 'member_job_title' );

		$this->end_controls_section();

		// Bio
		$this->start_controls_section(
			'section_bio_style',
			[
				'label' => esc_html__( 'Bio', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'bio!' => '',
				],
			]
		);

		$this->text_style_controls( 'member_bio' );

		$this->end_controls_section();
	}

	protected function __social_style_controls() {
		// General
		$this->start_controls_section(
			'section_social_general_style',
			[
				'label' => esc_html__( 'Social', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_social' => 'yes',
				],
			]
		);

		$this->common_style_controls( 'social_wrapper' );

		$this->add_control(
			'_heading_social_items',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Style Social Items:', 'zyre-elementor-addons' ),
				'separator' => 'before',
			]
		);

		$this->register_social_general_style_controls();

		$this->end_controls_section();

		// Icon
		$this->start_controls_section(
			'section_social_icon_style',
			[
				'label' => esc_html__( 'Social Icon', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_social' => 'yes',
				],
			]
		);

		$this->register_social_icon_style_controls();

		$this->end_controls_section();

		// Social Name
		$this->start_controls_section(
			'section_social_name_style',
			[
				'label' => esc_html__( 'Social Name', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_social' => 'yes',
				],
			]
		);

		$this->register_social_name_style_controls();

		$this->end_controls_section();
	}

	protected function __button_style_controls() {

		// Button style controls
		$this->start_controls_section(
			'section_button_style',
			[
				'label' => esc_html__( 'Details Button', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_details_button' => 'yes',
				],
			]
		);

		$this->register_button_style_controls();

		$this->end_controls_section();

		// Icon style controls
		$this->start_controls_section(
			'section_button_icon_style',
			[
				'label'      => esc_html__( 'Button Icon', 'zyre-elementor-addons' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_details_button' => 'yes',
					'button_icon[value]!' => '',
				],
			]
		);

		$this->register_button_icon_style_controls();

		$this->end_controls_section();
	}

	protected function __lightbox_style_controls() {

		$this->start_controls_section(
			'section_style_lightbox',
			[
				'label'     => esc_html__( 'LightBox', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_details_button' => 'yes',
					'show_lightbox'       => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'lightbox',
			[
				'selector' => '{{WRAPPER}} .zyre-member-lightbox.zyre-member-lightbox-show,
				{{WRAPPER}}.zyre-member-lightbox-preview--yes .zyre-member-lightbox',
				'controls'  => [
					'padding'    => [],
					'background' => [
						'exclude' => [],
					],
				],
			]
		);

		// Close button
		$this->add_control(
			'close_button_heading',
			[
				'label'     => esc_html__( 'Close Button', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'close_icon_size',
			[
				'label'      => esc_html__( 'Size', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 2,
						'max' => 200,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-member-lightbox.zyre-member-lightbox-show .zyre-member-lightbox-close,
					{{WRAPPER}}.zyre-member-lightbox-preview--yes .zyre-member-lightbox .zyre-member-lightbox-close' => '--font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->set_style_controls(
			'close_button',
			[
				'selector' => '{{WRAPPER}} .zyre-member-lightbox-close',
				'controls'  => [
					'border'        => [],
					'border_radius' => [],
					'box_shadow'    => [],
				],
			]
		);

		// Tabs
		$this->start_controls_tabs( '_tabs_close_button' );

		$this->start_controls_tab(
			'_tab_close_button_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'close_button',
			[
				'selector' => '{{WRAPPER}} .zyre-member-lightbox-close',
				'controls'  => [
					'color'    => [],
					'bg_color' => [],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'_tab_close_button_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'close_button_hover',
			[
				'selector' => '{{WRAPPER}} .zyre-member-lightbox-close:hover',
				'controls'  => [
					'color'        => [],
					'bg_color'     => [],
					'border_color' => [
						'condition' => [
							'close_button_border_border!' => '',
						],
					],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'close_button_offset_x',
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
						'min' => -500,
						'max' => 500,
					],
					'vw'  => [
						'min' => -100,
						'max' => 100,
					],
				],
				'separator'  => 'before',
				'selectors'  => [
					'{{WRAPPER}} .zyre-member-lightbox-close' => '--horizontal-offset: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'close_button_offset_y',
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
						'min' => -500,
						'max' => 500,
					],
					'vw'  => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-member-lightbox-close' => '--vertical-offset: {{SIZE}}{{UNIT}};',
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
		$class_base = ( 'content' === $prefix ) ? 'body' : str_replace( '_', '-', $prefix );
		$selector = ( 'photo_img' === $prefix ) ? '{{WRAPPER}} .zyre-member-figure img' : '{{WRAPPER}} .zyre-member-' . $class_base;
		if ( 'social_wrapper' === $prefix ) {
			$selector = '{{WRAPPER}} .zyre-social-icon-wrapper';
		}

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

		$this->set_style_controls(
			$prefix,
			[
				'selector' => '{{WRAPPER}} .zyre-' . $class_base,
				'controls' => [
					'typography'  => [],
					'color'       => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
					'text_shadow' => [],
					'spacing'     => [
						'label' => esc_html__( 'Bottom Spacing', 'zyre-elementor-addons' ),
					],
				],
			]
		);
	}

	protected function get_post_template( $term = 'page' ) {
		$posts = get_posts(
			[
				'post_type'      => 'elementor_library',
				'orderby'        => 'title',
				'order'          => 'ASC',
				'posts_per_page' => '-1',
				'tax_query'      => [
					[
						'taxonomy' => 'elementor_library_type',
						'field'    => 'slug',
						'terms'    => $term,
					],
				],
			]
		);

		$templates = [];
		foreach ( $posts as $post ) {
			$templates[] = [
				'id'   => $post->ID,
				'name' => $post->post_title,
			];
		}

		return $templates;
	}

	protected function get_saved_content( $term = 'section' ) {
		$saved_contents = $this->get_post_template( $term );

		if ( count( $saved_contents ) > 0 ) {
			$options['0'] = esc_html__( 'None', 'zyre-elementor-addons' );
			foreach ( $saved_contents as $saved_content ) {
				$content_id             = $saved_content['id'];
				$options[ $content_id ] = $saved_content['name'];
			}
		} else {
			$options['no_template'] = esc_html__( 'Nothing Found', 'zyre-elementor-addons' );
		}

		return $options;
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$button_position = ! empty( $settings['button_position'] ) ? $settings['button_position'] : 'after';

		$show_button = false;
		if ( ! empty( $settings['show_details_button'] ) && 'yes' === $settings['show_details_button'] ) {
			$show_button = true;
		}

		$this->add_inline_editing_attributes( 'name', 'basic' );
		$this->add_render_attribute( 'name', 'class', 'zyre-member-name zy-m-0' );

		$this->add_inline_editing_attributes( 'job_title', 'basic' );
		$this->add_render_attribute( 'job_title', 'class', 'zyre-member-job-title' );

		$this->add_inline_editing_attributes( 'bio', 'basic' );
		$this->add_render_attribute( 'bio', 'class', 'zyre-member-bio zy-m-0' );
		?>

		<?php if ( $settings['photo']['url'] || $settings['photo']['id'] ) : ?>
			<figure class="zyre-member-figure">
				<?php echo wp_kses_post( Group_Control_Image_Size::get_attachment_image_html( $settings, 'photo_thumb', 'photo' ) ); ?>
			</figure>
		<?php endif; ?>

		<div class="zyre-member-body">
			<?php if ( ! empty( $settings['name'] ) ) :
				$name_html = sprintf( '<%1$s %2$s>%3$s</%1$s>',
					Utils::validate_html_tag( $settings['name_tag'] ),
					$this->get_render_attribute_string( 'name' ),
					$settings['name'],
				);
				echo wp_kses_post( $name_html );
			endif; ?>

			<?php if ( ! empty( $settings['job_title'] ) ) : ?>
				<div <?php $this->print_render_attribute_string( 'job_title' ); ?>><?php echo wp_kses( $settings['job_title'], zyre_get_allowed_html() ); ?></div>
			<?php endif; ?>

			<?php if ( ! empty( $settings['bio'] ) ) : ?>
				<p <?php $this->print_render_attribute_string( 'bio' ); ?>><?php echo wp_kses( $settings['bio'], zyre_get_allowed_html('advanced') ); ?></p>
			<?php endif; ?>

			<?php if ( $show_button && 'before' === $button_position ) :
				$this->render_button();
			endif; ?>

			<?php if ( $settings['show_social'] && is_array( $settings['social_icons'] ) ) :
				$this->render_social_items();
			endif; ?>

			<?php if ( $show_button && 'after' === $button_position ) :
				$this->render_button();
			endif; ?>
		</div>

		<?php
		// render lightbox
		$this->render_lightbox();
	}

	protected function render_lightbox() {
		$settings = $this->get_settings_for_display();
		$template = false;
		if ( ! empty( $settings['saved_template_list'] ) && '0' !== $settings['saved_template_list'] && 'no_template' !== $settings['saved_template_list'] ) {
			$template = true;
		}
		if ( $settings['show_lightbox'] && 'yes' === $settings['show_lightbox'] && $template ) :
			$this->add_render_attribute( 'lightbox', 'class', 'zyre-member-lightbox zy-fixed zy-top-0 zy-left-0 zy-d-none zy-v-hidden zy-w-0 zy-h-0' );
			?>
			<div <?php $this->print_render_attribute_string( 'lightbox' ); ?>>
				<div class="zyre-member-lightbox-inner">
					<div class="zyre-member-lightbox-close">&times;</div>
					<?php
					$saved_template_list = apply_filters( 'wpml_object_id', $settings['saved_template_list'], 'elementor_library' ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
					echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $saved_template_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>
				</div>
			</div>
			<?php
		endif;
	}
}
