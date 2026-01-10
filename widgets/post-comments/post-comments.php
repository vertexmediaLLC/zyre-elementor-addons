<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use ZyreAddons\Elementor\Controls\Select2;

defined( 'ABSPATH' ) || die();

class Post_Comments extends Base {

	public function get_title() {
		return esc_html__( 'Post Comments', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Post-Comment';
	}

	public function get_keywords() {
		return [ 'comments', 'post comments', 'post info', 'comments form', 'comments list', 'reply', 'replies', 'post reply', 'reponse', 'respond', 'post response' ];
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	/**
	 * Register widget content controls
	 */
	protected function register_content_controls() {
		$this->__template_style_controls();
		$this->__comments_list_settings();
		$this->__comment_form_settings();
	}

	/**
	 * Template Style
	 */
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

	/**
	 * Comments List
	 */
	protected function __comments_list_settings() {
		$this->start_controls_section(
			'section_comments_list_settings',
			[
				'label' => esc_html__( 'Comments List', 'zyre-elementor-addons' ),
			]
		);

		// Comment Source
		$this->add_control(
			'source_type',
			[
				'label'     => esc_html__( 'Comment Source', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'current_post' => esc_html__( 'Current Post', 'zyre-elementor-addons' ),
					'custom'       => esc_html__( 'Custom', 'zyre-elementor-addons' ),
				],
				'default'   => 'current_post',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'source_custom',
			[
				'label'          => esc_html__( 'Search & Select', 'zyre-elementor-addons' ),
				'type'           => Select2::TYPE,
				'multiple'       => false,
				'placeholder'    => esc_html__( 'Search Post', 'zyre-elementor-addons' ),
				'dynamic_params' => [
					'object_type' => 'post',
					'post_type'   => 'any',
				],
				'select2options' => [
					'minimumInputLength' => 2,
				],
				'label_block'    => true,
				'condition'      => [
					'source_type' => 'custom',
				],
			]
		);

		$this->add_control(
			'show_comments_title',
			[
				'label' => esc_html__( 'Show Comments Title', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'comments_one',
			[
				'label'     => esc_html__( 'One Comment', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => [
					'show_comments_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'comments_singular',
			[
				'label'     => esc_html__( 'Singular Comment', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => [
					'show_comments_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'comments_plural',
			[
				'label'     => esc_html__( 'Plural Comment', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => [
					'show_comments_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'avatar_size',
			[
				'label'     => esc_html__( 'Avatar Size (px)', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 20,
						'max' => 200,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 60,
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'disable_author_link',
			[
				'label' => esc_html__( 'Disable Author Link', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'No', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'comment_says_text',
			[
				'label'     => esc_html__( 'Says Text', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'show_date_time',
			[
				'label' => esc_html__( 'Show Date & Time', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'No', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'comment_date_format',
			[
				'label'       => esc_html__( 'Date Format', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html( 'e.g. F j, Y' ),
				'condition'   => [
					'show_date_time' => 'yes',
				],
			]
		);

		$this->add_control(
			'comment_time_format',
			[
				'label'       => esc_html__( 'Time Format', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html( 'e.g. g:i a' ),
				'condition'   => [
					'show_date_time' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_comment_edit',
			[
				'label' => esc_html__( 'Show Edit', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'No', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'pagination_display',
			[
				'label'     => esc_html__( 'Pagination Display', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'top_bottom' => esc_html__( 'Top & Bottom', 'zyre-elementor-addons' ),
					'top'        => esc_html__( 'Top', 'zyre-elementor-addons' ),
					'bottom'     => esc_html__( 'Bottom', 'zyre-elementor-addons' ),
				],
				'default'   => 'bottom',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'pagination_prev_text',
			[
				'label'       => esc_html__( 'Pagination Prev Text', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html( '&laquo;' ),
			]
		);

		$this->add_control(
			'pagination_next_text',
			[
				'label'       => esc_html__( 'Pagination Next Text', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html( '&raquo;' ),
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Comment Form Settings
	 */
	protected function __comment_form_settings() {
		$this->start_controls_section(
			'section_form_settings',
			[
				'label' => esc_html__( 'Comment Form', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'form_position',
			[
				'label'   => esc_html__( 'Form Position', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'before' => esc_html__( 'Before Comments', 'zyre-elementor-addons' ),
					'after'  => esc_html__( 'After Comments', 'zyre-elementor-addons' ),
				],
				'default' => 'after',
			]
		);

		$this->add_control(
			'title_reply',
			[
				'label'     => esc_html__( 'Reply Title', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'title_reply_tag',
			[
				'label'   => esc_html__( 'HTML Tag', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
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
				'default' => 'h2',
				'toggle'  => false,
			]
		);

		$this->add_control(
			'title_reply_to',
			[
				'label'     => esc_html__( 'Reply to Title', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'cancel_reply_text',
			[
				'label'     => esc_html__( 'Cancel Reply Text', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
			]
		);

		// Comment Note
		$this->add_control(
			'show_comment_note',
			[
				'label' => esc_html__( 'Show Comment Note', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'comment_note',
			[
				'label'     => esc_html__( 'Comment Note', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXTAREA,
				'rows' => 2,
				'condition' => [
					'show_comment_note' => 'yes',
				],
			]
		);

		// Indicator
		$this->add_control(
			'show_indicator',
			[
				'label' => esc_html__( 'Show Required Indicator', 'zyre-elementor-addons' ),
				'description' => esc_html__( 'To display indicators, enable the "Comment author must fill out name and email" option in the Discussion Settings.', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_req_msg',
			[
				'label' => esc_html__( 'Show Required Message', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'show_indicator' => 'yes',
				],
			]
		);

		$this->add_control(
			'required_fields_msg',
			[
				'label'     => esc_html__( 'Required Message', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXTAREA,
				'rows' => 2,
				'condition' => [
					'show_indicator' => 'yes',
					'show_req_msg' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_logged_in_as',
			[
				'label' => esc_html__( 'Show Logged in As', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		if ( get_option( 'show_comments_cookies_opt_in' ) ) {
			$this->add_control(
				'cookies_note',
				[
					'label'     => esc_html__( 'Cookies Note', 'zyre-elementor-addons' ),
					'type'      => Controls_Manager::TEXTAREA,
					'rows' => 2,
				]
			);
		}

		// Name Field
		$this->add_control(
			'heading_name_field',
			[
				'label' => esc_html__( 'Name Field', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'name_field_label',
			[
				'label'     => esc_html__( 'Label Text', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Name', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'name_field_placeholder',
			[
				'label'     => esc_html__( 'Placeholder Text', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
			]
		);

		// Email Field
		$this->add_control(
			'heading_email_field',
			[
				'label' => esc_html__( 'Email Field', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'email_field_label',
			[
				'label'     => esc_html__( 'Label Text', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Email', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'email_field_placeholder',
			[
				'label'     => esc_html__( 'Placeholder Text', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
			]
		);

		// Website Field
		$this->add_control(
			'heading_website_field',
			[
				'label' => esc_html__( 'Website Field', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'url_field_switcher',
			[
				'label' => esc_html__( 'Show Field', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'url_field_label',
			[
				'label'     => esc_html__( 'Label Text', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Website', 'zyre-elementor-addons' ),
				'condition' => [
					'url_field_switcher' => 'yes',
				],
			]
		);

		$this->add_control(
			'url_field_placeholder',
			[
				'label'     => esc_html__( 'Placeholder Text', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => [
					'url_field_switcher' => 'yes',
				],
			]
		);

		// Comment Field
		$this->add_control(
			'heading_comment_field',
			[
				'label' => esc_html__( 'Comment Field', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'comment_field_label',
			[
				'label'     => esc_html__( 'Label Text', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Post Comment', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'comment_field_placeholder',
			[
				'label'     => esc_html__( 'Placeholder Text', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
			]
		);

		// Submit Button
		$this->add_control(
			'heading_submit_button',
			[
				'label' => esc_html__( 'Submit Button', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'label_submit_show',
			[
				'label'        => esc_html__( 'Show Label', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => esc_html__( 'Yes', 'zyre-elementor-addons' ),
				'label_off'    => esc_html__( 'Off', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'label_submit',
			[
				'label'     => esc_html__( 'Button Text', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => [
					'label_submit_show' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register styles related controls
	 */
	protected function register_style_controls() {
		$this->__comments_title();
		$this->__comments_list();
		$this->__comment_author_image();
		$this->__comment_meta();
		$this->__comment_body();
		$this->__comment_reply();
		$this->__comments_pagination();
		$this->__comment_form();
		$this->__comment_form_field_wrap();
		$this->__comment_form_fields();
		$this->__comment_form_submit();
	}

	/**
	 * Comments Title Style Controls
	 */
	protected function __comments_title() {
		$this->start_controls_section(
			'section_comments_title_style',
			[
				'label'     => esc_html__( 'Comments Title', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_comments_title' => 'yes',
				],
			]
		);

		$this->text_style_controls( 'comments_title', '{{WRAPPER}} .zyre-comments-title' );

		$this->add_responsive_control(
			'comments_title_space',
			[
				'label'     => esc_html__( 'Spacing', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .zyre-comments-title' => 'margin-block-end: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->common_style_controls( 'comments_title', '{{WRAPPER}} .zyre-comments-title' );

		$this->add_responsive_control(
			'comments_title_align',
			[
				'label'       => esc_html__( 'Alignment', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'left'    => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'        => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'      => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default' => is_rtl() ? 'right' : 'left',
				'selectors'   => [
					'{{WRAPPER}} .zyre-comments-title' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Comments List Style Controls
	 */
	protected function __comments_list() {
		$this->start_controls_section(
			'section_comments_list_style',
			[
				'label'     => esc_html__( 'Comments List', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'comments_list_space',
			[
				'label'     => esc_html__( 'Spacing', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .zyre-comments-list' => 'margin-block-end: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->common_style_controls( 'comments_list', '{{WRAPPER}} .zyre-comments-list' );

		$this->add_responsive_control(
			'child_comments_list_space',
			[
				'label'     => esc_html__( 'Children Comments Space', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} #comments .children' => 'padding-inline-start: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Comment Author Image Style Controls
	 */
	protected function __comment_author_image() {
		$this->start_controls_section(
			'section_comment_author_img_style',
			[
				'label'     => esc_html__( 'Author Image', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'avatar_position',
			[
				'label'   => esc_html__( 'Position', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'static'   => esc_html__( 'Default', 'zyre-elementor-addons' ),
					'absolute' => esc_html__( 'Absolute', 'zyre-elementor-addons' ),
				],
				'default' => 'absolute',
				'tablet_default' => 'absolute',
				'mobile_default' => 'absolute',
				'selectors' => [
					'{{WRAPPER}} #comments .comment .avatar, {{WRAPPER}} #comments .pingback .avatar' => 'position: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'avatar_space',
			[
				'label'     => esc_html__( 'Spacing', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} #comments .comment .avatar, {{WRAPPER}} #comments .pingback .avatar' => 'margin-inline-end: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'avatar_position' => 'static',
				],
			]
		);

		$this->add_responsive_control(
			'avatar_position_x',
			[
				'label'      => esc_html__( 'Horizontal Position', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} #comments .comment .avatar, {{WRAPPER}} #comments .pingback .avatar' => 'left: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'avatar_position' => 'absolute',
				],
			]
		);

		$this->add_responsive_control(
			'vertical_position_y',
			[
				'label'      => esc_html__( 'Vertical Position', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} #comments .comment .avatar, {{WRAPPER}} #comments .pingback .avatar' => 'top: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'avatar_position' => 'absolute',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Comment Meta Style Controls
	 */
	protected function __comment_meta() {
		$this->start_controls_section(
			'section_comment_meta_style',
			[
				'label'     => esc_html__( 'Comment Meta', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'comment_meta_space',
			[
				'label'     => esc_html__( 'Spacing', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} #comments .comment .comment-meta' => 'margin-block-end: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->common_style_controls( 'comment_meta', '{{WRAPPER}} #comments .comment .comment-meta' );

		$this->add_responsive_control(
			'comment_meta_direction',
			[
				'label'                => esc_html__( 'Direction', 'zyre-elementor-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'default'              => 'row',
				'options'              => [
					'row'    => [
						'title' => esc_html__( 'Row - horizontal', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-arrow-right',
					],
					'column' => [
						'title' => esc_html__( 'Column - vertical', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-arrow-down',
					],
				],
				'prefix_class'         => 'zyre-addon-post-comments-meta-dir-',
				'selectors_dictionary' => [
					'row'    => 'display: flex;justify-content: space-between;align-items: center;',
					'column' => 'display: block;',
				],
				'selectors'            => [
					'{{WRAPPER}} #comments .comment-meta' => '{{VALUE}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'comment_meta_justify',
			[
				'label'       => esc_html__( 'Justify Content', 'zyre-elementor-addons' ),
				'label_block' => true,
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'flex-start'    => [
						'title' => esc_html__( 'Start', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-justify-start-h',
					],
					'center'        => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-justify-center-h',
					],
					'flex-end'      => [
						'title' => esc_html__( 'End', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-justify-end-h',
					],
					'space-between' => [
						'title' => esc_html__( 'Space Between', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-justify-space-between-h',
					],
					'space-around'  => [
						'title' => esc_html__( 'Space Around', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-justify-space-around-h',
					],
					'space-evenly'  => [
						'title' => esc_html__( 'Space Evenly', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-justify-space-evenly-h',
					],
				],
				'default' => 'space-between',
				'selectors'   => [
					'{{WRAPPER}} #comments .comment-meta' => 'justify-content: {{VALUE}};',
				],
				'condition'   => [
					'comment_meta_direction' => 'row',
				],
			]
		);

		$this->add_responsive_control(
			'comment_meta_gap',
			[
				'label'      => esc_html__( 'Space Between', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'default'    => [
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} #comments .comment-meta' => 'gap: {{SIZE}}{{UNIT}};',
				],
				'condition'   => [
					'comment_meta_direction' => 'row',
				],
			]
		);

		$this->add_responsive_control(
			'comment_meta_spacing',
			[
				'label'      => esc_html__( 'Space Between', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'default'    => [
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} #comments .comment-meta .comment-author' => 'margin-block-end: {{SIZE}}{{UNIT}};',
				],
				'condition'   => [
					'comment_meta_direction' => 'column',
				],
			]
		);

		$this->add_responsive_control(
			'comment_meta_align',
			[
				'label'       => esc_html__( 'Alignment', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'left'    => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'        => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'      => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'selectors'   => [
					'{{WRAPPER}} #comments .comment-meta' => 'text-align: {{VALUE}};',
				],
				'condition'   => [
					'comment_meta_direction' => 'column',
				],
			]
		);

		$this->add_control(
			'_separator_before_comment_meta_typo',
			[
				'type'      => Controls_Manager::RAW_HTML,
				'raw'       => '<div style="border-block-start: var(--e-a-border);border-block-start-width: 1px;"></div>',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'comment_author_typo',
				'label'     => esc_html__( 'Author Typography', 'zyre-elementor-addons' ),
				'selector' => '{{WRAPPER}} .zyre-comments-area .comment .fn',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'author_says_typo',
				'label'     => esc_html__( 'Says Typography', 'zyre-elementor-addons' ),
				'selector' => '{{WRAPPER}} .zyre-comments-area .comment .says',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'comment_time',
				'label'     => esc_html__( 'Time Typography', 'zyre-elementor-addons' ),
				'selector' => '{{WRAPPER}} .zyre-comments-area .comment time',
				'condition' => [
					'show_date_time' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'comment_edit',
				'label'     => esc_html__( 'Edit Typography', 'zyre-elementor-addons' ),
				'selector' => '{{WRAPPER}} .zyre-comments-area .comment .edit-link',
				'condition' => [
					'show_comment_edit' => 'yes',
				],
			]
		);

		// Tabs
		$this->start_controls_tabs( 'tabs_comment_meta' );

		// Tab: Normal
		$this->start_controls_tab(
			'tab_comment_meta_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'comment_author_color',
			[
				'label'     => esc_html__( 'Author Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-comments-area .comment .fn' => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-comments-area .comment .fn .url' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'comment_time_color',
			[
				'label'     => esc_html__( 'Time Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-comments-area .comment time' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_date_time' => 'yes',
				],
			]
		);

		$this->add_control(
			'comment_edit_color',
			[
				'label'     => esc_html__( 'Edit Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-comments-area .comment .comment-edit-link' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_comment_edit' => 'yes',
				],
			]
		);

		$this->end_controls_tab(); // End Normal Tab

		// Tab: Hover
		$this->start_controls_tab(
			'tab_comment_meta_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'comment_author_color_hover',
			[
				'label'     => esc_html__( 'Author Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-comments-area .comment .url:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
					'disable_author_link!' => 'yes',
				],
			]
		);

		$this->add_control(
			'comment_time_color_hover',
			[
				'label'     => esc_html__( 'Time Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-comments-area .comment a:hover time' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_date_time' => 'yes',
				],
			]
		);

		$this->add_control(
			'comment_edit_color_hover',
			[
				'label'     => esc_html__( 'Edit Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-comments-area .comment .comment-edit-link:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_comment_edit' => 'yes',
				],
			]
		);

		$this->end_controls_tab(); // End Hover Tab

		$this->end_controls_tabs(); // End Tabs

		$this->add_control(
			'author_says_color',
			[
				'label'     => esc_html__( 'Says Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-comments-area .comment .says' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Comment Body Style Controls
	 */
	protected function __comment_body() {
		$this->start_controls_section(
			'section_comment_body_style',
			[
				'label'     => esc_html__( 'Comment Body', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->text_style_controls( 'comment_body', '{{WRAPPER}} #comments .comment .comment-content-box, {{WRAPPER}} #comments .pingback .comment-content-box' );

		$this->add_control(
			'comment_body_link_color',
			[
				'label'     => esc_html__( 'Link Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .comment .comment-content-box a, {{WRAPPER}} .pingback .comment-content-box a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'comment_body_link_hover_color',
			[
				'label'     => esc_html__( 'Link Hover Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .comment .comment-content-box a:hover, {{WRAPPER}} .pingback .comment-content-box a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'comment_body_space',
			[
				'label'     => esc_html__( 'Spacing', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} #comments .comment:not(:last-child) .comment-content-box,
					{{WRAPPER}} #comments .pingback:not(:last-child) .comment-content-box' => 'margin-block-end: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->common_style_controls( 'comment_body', '{{WRAPPER}} #comments .comment .comment-content-box, {{WRAPPER}} #comments .pingback .comment-content-box' );

		$this->end_controls_section();
	}

	/**
	 * Comment Reply Style Controls
	 */
	protected function __comment_reply() {
		$this->start_controls_section(
			'section_comment_reply_style',
			[
				'label'     => esc_html__( 'Comment Reply', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'comment_reply_typo',
				'selector' => '{{WRAPPER}} .comment .comment-content-box .comment-reply-link',
			]
		);

		$this->add_responsive_control(
			'comment_reply_padding',
			[
				'label' => __( 'Padding', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .comment .comment-content-box .comment-reply-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'comment_reply_border',
				'selector'  => '{{WRAPPER}} .comment .comment-content-box .comment-reply-link',
			]
		);

		$this->add_responsive_control(
			'comment_reply_space',
			[
				'label'     => esc_html__( 'Spacing', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .comment .comment-content-box .reply' => 'margin-block-start: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'comment_reply_align',
			[
				'label'       => esc_html__( 'Alignment', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'left'    => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'        => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'      => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default' => is_rtl() ? 'right' : 'left',
				'selectors'   => [
					'{{WRAPPER}} .comment .comment-content-box .reply' => 'text-align: {{VALUE}};',
				],
			]
		);

		// Tabs
		$this->start_controls_tabs( 'tabs_comment_reply_style' );

		// Tab: Normal
		$this->start_controls_tab(
			'tab_comment_reply_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'comment_reply_normal_bg',
			[
				'label'     => esc_html__( 'Background Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .comment .comment-content-box .comment-reply-link' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'comment_reply_normal_color',
			[
				'label'     => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .comment .comment-content-box .comment-reply-link' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab(); // End Normal Tab.

		// Tab: Hover.
		$this->start_controls_tab(
			'tab_comment_reply_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'comment_reply_hover_bg',
			[
				'label'     => esc_html__( 'Background Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .comment .comment-content-box .comment-reply-link:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'comment_reply_hover_color',
			[
				'label'     => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .comment .comment-content-box .comment-reply-link:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'comment_reply_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .comment .comment-content-box .comment-reply-link:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab(); // End Hover Tab

		$this->end_controls_tabs(); // End Tabs

		$this->end_controls_section();
	}

	/**
	 * Comments Pagination Style Controls
	 */
	protected function __comments_pagination() {
		$this->start_controls_section(
			'section_comments_pagination_style',
			[
				'label'     => esc_html__( 'Comments Pagination', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->text_style_controls( 'comments_pagination', '{{WRAPPER}} .zyre-comments-area .zyre-comments-navigation .page-numbers' );

		$this->add_responsive_control(
			'comments_pagination_space',
			[
				'label'     => esc_html__( 'Spacing', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .zyre-comments-area .zyre-comments-navigation' => 'margin-block-end: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->common_style_controls( 'comments_pagination', '{{WRAPPER}} .zyre-comments-area .zyre-comments-navigation' );

		$this->add_responsive_control(
			'comments_pagination_gap',
			[
				'label'     => esc_html__( 'Space Between', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .zyre-comments-area .zyre-comments-navigation' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'comments_pagination_justify',
			[
				'label'       => esc_html__( 'Justify Content', 'zyre-elementor-addons' ),
				'label_block' => true,
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'flex-start'    => [
						'title' => esc_html__( 'Start', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-justify-start-h',
					],
					'center'        => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-justify-center-h',
					],
					'flex-end'      => [
						'title' => esc_html__( 'End', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-justify-end-h',
					],
					'space-between' => [
						'title' => esc_html__( 'Space Between', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-justify-space-between-h',
					],
					'space-around'  => [
						'title' => esc_html__( 'Space Around', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-justify-space-around-h',
					],
					'space-evenly'  => [
						'title' => esc_html__( 'Space Evenly', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-justify-space-evenly-h',
					],
				],
				'selectors'   => [
					'{{WRAPPER}} .zyre-comments-area .zyre-comments-navigation' => 'justify-content: {{VALUE}};',
				],
			]
		);

		// Page Numbers
		$this->add_control(
			'heading_page_numbers',
			[
				'label' => esc_html__( 'Page Numbers', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'page_numbers_width',
			[
				'label'      => esc_html__( 'Numbers Width', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range'      => [
					'px' => [
						'min' => 20,
						'max' => 200,
					],
				],
				'default'    => [
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-comments-area .zyre-comments-navigation .page-numbers:not(.dots):not(.prev):not(.next)' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Tabs
		$this->start_controls_tabs( 'tabs_pagination_page_numbers' );

		// Tab: Normal
		$this->start_controls_tab(
			'tab_pagination_page_numbers_normal',
			[
				'label'     => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			],
		);

		$this->add_control(
			'page_numbers_color',
			[
				'label'     => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-comments-area .zyre-comments-navigation .page-numbers:not(.dots)' => 'color: {{VALUE}};',
				],
			]
		);

		$this->common_style_controls( 'page_numbers', '{{WRAPPER}} .zyre-comments-area .zyre-comments-navigation .page-numbers:not(.dots)' );

		$this->end_controls_tab(); // End Normal Tab

		// Tab: Hover
		$this->start_controls_tab(
			'tab_pagination_page_numbers_hover',
			[
				'label'     => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			],
		);

		$this->common_hover_style_controls( 'page_numbers_hover', '{{WRAPPER}} .zyre-comments-area .zyre-comments-navigation .page-numbers:not(.dots):not(.current):hover' );

		$this->end_controls_tab(); // End Hover Tab

		$this->end_controls_tabs(); // End Tabs

		// Page Numbers: Current
		$this->add_control(
			'heading_current_page_numbers',
			[
				'label' => esc_html__( 'Page Numbers: Current', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'current_page_numbers_style_switcher',
			[
				'label' => esc_html__( 'Want to Customize ?', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'No', 'zyre-elementor-addons' ),
				'default' => '',
			]
		);

		$this->add_control(
			'current_page_numbers_color',
			[
				'label'     => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-comments-area .zyre-comments-navigation .page-numbers.current' => 'color: {{VALUE}};',
				],
				'condition' => [
					'current_page_numbers_style_switcher' => 'yes',
				],
			]
		);

		$this->add_control(
			'current_page_numbers_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-comments-area .zyre-comments-navigation .page-numbers.current' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'current_page_numbers_style_switcher' => 'yes',
				],
			]
		);

		$this->add_control(
			'current_page_numbers_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-comments-area .zyre-comments-navigation .page-numbers.current' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'current_page_numbers_style_switcher' => 'yes',
				],
			]
		);

		// Prev & Next Buttons.
		$this->add_control(
			'heading_prev_next_button',
			[
				'label' => esc_html__( 'Previous & Next Buttons', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'prev_next_style_switcher',
			[
				'label' => esc_html__( 'Want to Customize ?', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'No', 'zyre-elementor-addons' ),
				'default' => '',
			]
		);

		// Tabs
		$this->start_controls_tabs( 'tabs_prev_next_buttons' );

		// Tab: Normal
		$this->start_controls_tab(
			'tab_prev_next_button_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
				'condition' => [
					'prev_next_style_switcher' => 'yes',
				],
			]
		);

		$this->add_control(
			'prev_next_color',
			[
				'label'     => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-comments-area .zyre-comments-navigation .page-numbers.prev,
					{{WRAPPER}} .zyre-comments-area .zyre-comments-navigation .page-numbers.next' => 'color: {{VALUE}};',
				],
				'condition' => [
					'prev_next_style_switcher' => 'yes',
				],
			]
		);

		$this->common_style_controls( 'prev_next', '{{WRAPPER}} .zyre-comments-area .zyre-comments-navigation .page-numbers.prev, {{WRAPPER}} .zyre-comments-area .zyre-comments-navigation .page-numbers.next', [ 'prev_next_style_switcher' => 'yes' ] );

		$this->end_controls_tab(); // End Normal Tab

		// Tab: Hover
		$this->start_controls_tab(
			'tab_prev_next_button_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
				'condition' => [
					'prev_next_style_switcher' => 'yes',
				],
			]
		);

		$this->add_control(
			'prev_next_color_hover',
			[
				'label'     => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-comments-area .zyre-comments-navigation .page-numbers.prev:hover,
					{{WRAPPER}} .zyre-comments-area .zyre-comments-navigation .page-numbers.next:hover' => 'color: {{VALUE}} !important;',
				],
				'condition' => [
					'prev_next_style_switcher' => 'yes',
				],
			]
		);

		$this->add_control(
			'prev_next_bg_color_hover',
			[
				'label'     => esc_html__( 'Background Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-comments-area .zyre-comments-navigation .page-numbers.prev:hover,
					{{WRAPPER}} .zyre-comments-area .zyre-comments-navigation .page-numbers.next:hover' => 'background-color: {{VALUE}} !important;',
				],
				'condition' => [
					'prev_next_style_switcher' => 'yes',
				],
			]
		);

		$this->add_control(
			'prev_next_border_color_hover',
			[
				'label'     => esc_html__( 'Border Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-comments-area .zyre-comments-navigation .page-numbers.prev:hover,
					{{WRAPPER}} .zyre-comments-area .zyre-comments-navigation .page-numbers.next:hover' => 'border-color: {{VALUE}} !important;',
				],
				'condition' => [
					'prev_next_style_switcher' => 'yes',
				],
			]
		);

		$this->end_controls_tab(); // End Hover Tab

		$this->end_controls_tabs(); // End Tabs

		$this->end_controls_section();
	}

	/**
	 * Comment Form Style Controls
	 */
	protected function __comment_form() {
		$this->start_controls_section(
			'section_comment_respond_style',
			[
				'label'     => esc_html__( 'Comment Form', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		// Reply Title
		$typo_label = __( 'Title Typography', 'zyre-elementor-addons' );
		$color_label = __( 'Title Color', 'zyre-elementor-addons' );
		$this->text_style_controls( 'reply_title', '{{WRAPPER}} .zyre-comment-form-reply-title', $typo_label, $color_label );

		$this->add_responsive_control(
			'reply_title_space',
			[
				'label'     => esc_html__( 'Spacing', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .zyre-comment-form-reply-title' => 'margin-block-end: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'form_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-comment-form' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'form_msg_space',
			[
				'label'     => esc_html__( 'Message Spacing', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .zyre-comment-form-notes' => 'margin-block-end: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .logged-in-as' => 'margin-block-end: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Others Typography
		$this->add_control(
			'heading_form_typo_styles',
			[
				'type'     => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Typography Styles', 'zyre-elementor-addons' ),
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'form_note_typo',
				'label'     => esc_html__( 'Form Note', 'zyre-elementor-addons' ),
				'selector' => '{{WRAPPER}} .zyre-comment-form-notes',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'logged_in_as_typo',
				'label'     => esc_html__( 'Logged in as', 'zyre-elementor-addons' ),
				'selector' => '{{WRAPPER}} .logged-in-as',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'must_log_in_typo',
				'label'     => esc_html__( 'Must Log in', 'zyre-elementor-addons' ),
				'selector' => '{{WRAPPER}} .must-log-in',
			]
		);

		$this->add_control(
			'required_msg_color',
			[
				'label'     => esc_html__( 'Required Message Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .required-field-message' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_req_msg' => 'yes',
				],
				'separator' => 'before',
			]
		);

		// Tabs
		$this->start_controls_tabs( 'tabs_form_link_colors' );

		// Tab: Normal
		$this->start_controls_tab(
			'tab_form_link_color_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'form_link_color',
			[
				'label'     => esc_html__( 'Link Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-comment-respond .must-log-in a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-comment-respond .logged-in-as a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab(); // End Normal Tab

		// Tab: Hover
		$this->start_controls_tab(
			'tab_form_link_color_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'form_link_color_hover',
			[
				'label'     => esc_html__( 'Link Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-comment-respond .must-log-in a:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-comment-respond .logged-in-as a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab(); // End Hover Tab

		$this->end_controls_tabs(); // End Tabs

		$this->common_style_controls( 'comment_respond', '{{WRAPPER}} .zyre-comment-respond' );

		$this->add_responsive_control(
			'comment_respond_align',
			[
				'label'       => esc_html__( 'Alignment', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'left'    => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'        => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'      => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default' => is_rtl() ? 'right' : 'left',
				'selectors'   => [
					'{{WRAPPER}} .zyre-comment-respond' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Comment Form - Field Wrapper Style Controls
	 */
	protected function __comment_form_field_wrap() {
		$this->start_controls_section(
			'section_form_field_wrapper_style',
			[
				'label'     => esc_html__( 'Comment Form - Field Wrap', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$label_typo_label = __( 'Label Typography', 'zyre-elementor-addons' );
		$label_color_label = __( 'Label Color', 'zyre-elementor-addons' );
		$this->text_style_controls( 'form_field_label', '{{WRAPPER}} .zyre-comment-form-field-wrap > label', $label_typo_label, $label_color_label );

		$this->add_responsive_control(
			'form_field_label_space',
			[
				'label'     => esc_html__( 'Label Space', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .zyre-comment-form-field-wrap > label' => 'margin-block-end: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'form_field_req_ind_color',
			[
				'label'     => esc_html__( 'Required Indicator Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-comment-respond .required' => 'color: {{VALUE}};',
				],
				'separator' => 'after',
			]
		);

		$this->common_style_controls( 'form_field_wrap', '{{WRAPPER}} .zyre-comment-form-field-wrap' );

		$this->add_responsive_control(
			'form_field_wrap_width_c',
			[
				'label'      => esc_html__( 'Comment Width', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
				'selectors'  => [
					'{{WRAPPER}} .zyre-comment-form-comment' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'form_field_wrap_width_a',
			[
				'label'      => esc_html__( 'Author Width', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors'  => [
					'{{WRAPPER}} .zyre-comment-form-author' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'form_field_wrap_width_e',
			[
				'label'      => esc_html__( 'Email Width', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors'  => [
					'{{WRAPPER}} .zyre-comment-form-email' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'form_field_wrap_width_u',
			[
				'label'      => esc_html__( 'Url Width', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors'  => [
					'{{WRAPPER}} .zyre-comment-form-url' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'form_field_wrap_space',
			[
				'label'     => esc_html__( 'Space Between', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .zyre-comment-form-field-wrap:not(:last-child)' => 'margin-block-end: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);

		$cookies_typo_label = __( 'Cookies Typography', 'zyre-elementor-addons' );
		$cookies_color_label = __( 'Cookies Color', 'zyre-elementor-addons' );
		$this->text_style_controls( 'form_field_cookies_label', '{{WRAPPER}} .zyre-comment-form-cookies > label', $cookies_typo_label, $cookies_color_label );

		$this->end_controls_section();
	}

	/**
	 * Comment Form - Fields Style Controls
	 */
	protected function __comment_form_fields() {
		$this->start_controls_section(
			'section_form_fields_style',
			[
				'label'     => esc_html__( 'Comment Form - Fields', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->text_style_controls(
			'comment_form_fields',
			'{{WRAPPER}} .zyre-comment-form input[type=email],
			{{WRAPPER}} .zyre-comment-form input[type=text],
			{{WRAPPER}} .zyre-comment-form input[type=url],
			{{WRAPPER}} .zyre-comment-form textarea'
		);

		$this->add_control(
			'fields_placeholder_color',
			[
				'label'     => esc_html__( 'Placeholder Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-comment-form ::placeholder, {{WRAPPER}} .zyre-comment-form ::-webkit-input-placeholder' => 'color: {{VALUE}};',
				],
			]
		);

		$this->common_style_controls(
			'comment_form_fields',
			'{{WRAPPER}} .zyre-comment-form input[type=email],
			{{WRAPPER}} .zyre-comment-form input[type=text],
			{{WRAPPER}} .zyre-comment-form input[type=url],
			{{WRAPPER}} .zyre-comment-form textarea'
		);

		$this->add_control(
			'form_fields_focus_border_color',
			[
				'label'     => esc_html__( 'Focus Border Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-comment-form input[type=email]:focus,
					{{WRAPPER}} .zyre-comment-form input[type=email]:focus-visible,
					{{WRAPPER}} .zyre-comment-form input[type=text]:focus,
					{{WRAPPER}} .zyre-comment-form input[type=text]:focus-visible,
					{{WRAPPER}} .zyre-comment-form input[type=url]:focus,
					{{WRAPPER}} .zyre-comment-form input[type=url]:focus-visible,
					{{WRAPPER}} .zyre-comment-form textarea:focus,
					{{WRAPPER}} .zyre-comment-form textarea:focus-visible' => 'border-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'form_fields_input_height',
			[
				'label'     => esc_html__( 'Input Height', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 20,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-comment-form input[type=email],
					{{WRAPPER}} .zyre-comment-form input[type=text],
					{{WRAPPER}} .zyre-comment-form input[type=url]' => 'Height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'form_fields_textarea_height',
			[
				'label'     => esc_html__( 'Textarea Height', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 20,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-comment-form textarea' => 'Height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Comment Form - Submit Style Controls
	 */
	protected function __comment_form_submit() {
		$this->start_controls_section(
			'section_form_submit_style',
			[
				'label'     => esc_html__( 'Comment Form - Submit', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->text_style_controls( 'form_submit', '{{WRAPPER}} .zyre-comment-form-submit-btn' );

		// Tabs
		$this->start_controls_tabs( 'tabs_form_submit_style' );

		// Tab: Normal
		$this->start_controls_tab(
			'tab_form_submit_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->common_style_controls( 'form_submit', '{{WRAPPER}} .zyre-comment-form-submit-btn' );

		$this->end_controls_tab(); // End Normal Tab

		// Tab: Hover
		$this->start_controls_tab(
			'tab_form_submit_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->common_hover_style_controls( 'form_submit_hover', '{{WRAPPER}} .zyre-comment-form-submit-btn:hover' );

		$this->end_controls_tab(); // End Hover Tab

		$this->end_controls_tabs(); // End Tabs

		$this->add_responsive_control(
			'form_submit_width',
			[
				'label'      => esc_html__( 'Width', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', 'vw' ],
				'range'      => [
					'%'  => [
						'min' => 5,
					],
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
					'vw' => [
						'min' => 2,
					],
				],
				'default'    => [
					'unit' => '%',
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-comment-form-submit-btn' => 'width: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'form_submit_align',
			[
				'label'       => esc_html__( 'Button Align', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'left'    => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center'        => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'      => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default' => is_rtl() ? 'right' : 'left',
				'selectors'   => [
					'{{WRAPPER}} .zyre-comment-form-submit' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Common style controls.
	 *
	 * @param string $prefix control ID.
	 * @param string $selector CSS selector.
	 */
	private function common_style_controls( $prefix, $selector, $conditions = [] ) {

		if ( 'form_submit' === $prefix ) {
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => $prefix . '_bg',
					'selector'  => $selector,
					'condition' => $conditions,
				]
			);
		} else {
			$this->add_control(
				$prefix . '_bg_color',
				[
					'label'     => esc_html__( 'Background Color', 'zyre-elementor-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						$selector => 'background-color: {{VALUE}};',
					],
					'condition' => $conditions,
				]
			);
		}

		$this->add_responsive_control(
			$prefix . '_padding',
			[
				'label' => __( 'Padding', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					$selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => $conditions,
			]
		);

		if ( 'comment_respond' === $prefix ) {
			$this->add_responsive_control(
				$prefix . '_margin',
				[
					'label' => __( 'Margin', 'zyre-elementor-addons' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						$selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => $conditions,
				]
			);
		}

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => $prefix . '_border',
				'selector'  => $selector,
				'condition' => $conditions,
			]
		);

		$this->add_responsive_control(
			$prefix . '_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					$selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => $conditions,
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => $prefix . '_box_shadow',
				'selector' => $selector,
				'condition' => $conditions,
			]
		);
	}

	/**
	 * Common style controls for Hover only.
	 *
	 * @param string $prefix control ID.
	 * @param string $selector CSS selector.
	 */
	private function common_hover_style_controls( $prefix, $selector ) {
		$this->add_control(
			$prefix . '_color',
			[
				'label'     => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					$selector => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			$prefix . '_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					$selector => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			$prefix . '_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					$selector => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => $prefix . '_box_shadow',
				'selector' => $selector,
			]
		);
	}

	/**
	 * Text style controls.
	 *
	 * @param string $prefix control ID.
	 * @param string $selector CSS selector.
	 * @param string $typo_label Custom Typography Label.
	 * @param string $color_label Custom Color Label.
	 */
	private function text_style_controls( $prefix, $selector, $typo_label = '', $color_label = '' ) {
		$typo_label = ! empty( $typo_label ) ? $typo_label : __( 'Typography', 'zyre-elementor-addons' );
		$color_label = ! empty( $color_label ) ? $color_label : __( 'Color', 'zyre-elementor-addons' );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => $prefix . '_typo',
				'label'     => esc_html( $typo_label ),
				'selector' => $selector,
			]
		);

		$this->add_control(
			$prefix . '_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html( $color_label ),
				'selectors' => [
					$selector => 'color: {{VALUE}};',
				],
			]
		);
	}

	/**
	 * Register render display controls
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( 'custom' === $settings['source_type'] ) {
			$post_id = is_array( $settings['source_custom'] ) ? (int) $settings['source_custom'][0] : (int) $settings['source_custom'];
			zyre_elementor()->db->switch_to_post( $post_id );
		}

		if ( ! comments_open() ) {
			return;
		}

		// Comment Form Defaults
		add_filter( 'comment_form_defaults', function ( $defaults ) use ( $settings ) {
			$commenter = wp_get_current_commenter();

			$defaults['class_container'] = 'zyre-comment-respond';
			$defaults['class_form'] = 'zyre-comment-form zy-flex zy-flex-wrap';

			// Title Reply
			$reply_title_tag = zyre_escape_tags( $settings['title_reply_tag'], 'h3' );
			$defaults['title_reply'] = ! empty( $settings['title_reply'] ) ? esc_html( $settings['title_reply'] ) : '';
			$defaults['title_reply_before'] = '<' . $reply_title_tag . ' id="reply-title" class="zyre-comment-form-reply-title">';
			$defaults['title_reply_after'] = '</' . $reply_title_tag . '>';
			$title_reply_to = ! empty( $settings['title_reply_to'] ) ? $settings['title_reply_to'] . ' %s' : $defaults['title_reply_to'];
			$defaults['title_reply_to'] = esc_html( $title_reply_to );
			$defaults['cancel_reply_link'] = ! empty( $settings['cancel_reply_text'] ) ? esc_html( $settings['cancel_reply_text'] ) : esc_html( $defaults['cancel_reply_link'] );

			// Logged in as
			if ( isset( $defaults['logged_in_as'] ) ) {
				if ( 'yes' !== $settings['show_logged_in_as'] ) {
					$defaults['logged_in_as'] = '';
				}
			}

			// Comment Settings
			$req_ne = get_option( 'require_name_email' );

			// Required
			$wp_required_indicator = ' ' . wp_required_field_indicator();
			$show_indicator = ( 'yes' === $settings['show_indicator'] );
			$required_attribute = ' required="required"';

			// Comment Note
			if ( isset( $defaults['comment_notes_before'] ) ) {
				$show_comment_note = 'yes' === $settings['show_comment_note'];
				$show_req_msg = ( 'yes' === $settings['show_indicator'] && 'yes' === $settings['show_req_msg'] );

				if ( $show_comment_note || $show_req_msg ) {
					$note = '';
					if ( $show_comment_note ) {
						$comment_note = ! empty( $settings['comment_note'] ) ? $settings['comment_note'] : __( 'Your email address will not be published.', 'zyre-elementor-addons' );
						$note = sprintf(
							'<span id="email-notes">%s</span>',
							esc_html( $comment_note )
						);
					}

					$required_msg = '';
					if ( $show_req_msg ) {
						$required_msg = ' ' . wp_required_field_message();
						if ( ! empty( $settings['required_fields_msg'] ) ) {
							$required_msg = sprintf(
								' <span class="required-field-message">%s</span>',
								esc_html( $settings['required_fields_msg'] ) . $wp_required_indicator
							);
						}
					}

					$defaults['comment_notes_before'] = sprintf(
						'<p class="zyre-comment-form-notes">%s%s</p>',
						$note,
						$required_msg
					);
				} else {
					$defaults['comment_notes_before'] = '';
				}
			}

			// Comment Field
			if ( isset( $defaults['comment_field'] ) ) {
				$defaults['comment_field'] = sprintf(
					'<div class="zyre-comment-form-field-wrap zyre-comment-form-comment">%s %s</div>',
					empty( $settings['comment_field_label'] ) ? '' : sprintf(
						'<label for="comment">%s%s</label>',
						esc_html( $settings['comment_field_label'] ),
						$show_indicator ? $wp_required_indicator : ''
					),
					sprintf(
						'<textarea id="comment" name="comment" placeholder="%s" cols="45" rows="8" maxlength="65525"%s></textarea>',
						! empty( $settings['comment_field_placeholder'] ) ? esc_attr( $settings['comment_field_placeholder'] ) : '',
						$required_attribute
					)
				);
			}

			// Name Field
			if ( isset( $defaults['fields']['author'] ) ) {
				$defaults['fields']['author'] = sprintf(
					'<div class="zyre-comment-form-field-wrap zyre-comment-form-author">%s %s</div>',
					empty( $settings['name_field_label'] ) ? '' : sprintf(
						'<label for="author" class="zyre-comment-form-label">%s%s</label>',
						esc_html( $settings['name_field_label'] ),
						( $req_ne && $show_indicator ? $wp_required_indicator : '' )
					),
					sprintf(
						'<input id="author" name="author" type="text" value="%s" placeholder="%s" size="30" maxlength="245" autocomplete="name"%s />',
						esc_attr( $commenter['comment_author'] ),
						! empty( $settings['name_field_placeholder'] ) ? esc_attr( $settings['name_field_placeholder'] ) : '',
						( $req_ne && $show_indicator ? $required_attribute : '' )
					)
				);
			}

			// Email Field
			if ( isset( $defaults['fields']['email'] ) ) {
				$defaults['fields']['email'] = sprintf(
					'<div class="zyre-comment-form-field-wrap zyre-comment-form-email">%s %s</div>',
					empty( $settings['email_field_label'] ) ? '' : sprintf(
						'<label for="email" class="zyre-comment-form-label">%s%s</label>',
						esc_html( $settings['email_field_label'] ),
						( $req_ne && $show_indicator ? $wp_required_indicator : '' )
					),
					sprintf(
						'<input id="email" name="email" type="email" value="%s" placeholder="%s" size="30" maxlength="100" aria-describedby="email-notes" autocomplete="email"%s />',
						esc_attr( $commenter['comment_author_email'] ),
						! empty( $settings['email_field_placeholder'] ) ? esc_attr( $settings['email_field_placeholder'] ) : '',
						( $req_ne && $show_indicator ? $required_attribute : '' )
					)
				);
			}

			// Website Field
			if ( isset( $defaults['fields']['url'] ) ) {
				if ( 'yes' !== $settings['url_field_switcher'] ) {
					unset( $defaults['fields']['url'] );
				} else {
					$defaults['fields']['url'] = sprintf(
						'<div class="zyre-comment-form-field-wrap zyre-comment-form-url">%s %s</div>',
						empty( $settings['url_field_label'] ) ? '' : sprintf(
							'<label for="url" class="zyre-comment-form-label">%s</label>',
							esc_html( $settings['url_field_label'] )
						),
						sprintf(
							'<input id="url" name="url" type="url" value="%s" placeholder="%s" size="30" maxlength="200" autocomplete="url" />',
							esc_attr( $commenter['comment_author_url'] ),
							! empty( $settings['url_field_placeholder'] ) ? esc_attr( $settings['url_field_placeholder'] ) : ''
						)
					);
				}
			}

			// Cookies
			if ( isset( $defaults['fields']['cookies'] ) ) {
				$consent = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';
				$cookies_note = ! empty( $settings['cookies_note'] ) ? $settings['cookies_note'] : __( 'Save my name, email, and website in this browser for the next time I comment.', 'zyre-elementor-addons' );

				$defaults['fields']['cookies'] = sprintf(
					'<div class="zyre-comment-form-field-wrap zyre-comment-form-cookies">%s %s</div>',
					sprintf(
						'<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"%s />',
						$consent
					),
					sprintf(
						'<label for="wp-comment-cookies-consent">%s</label>',
						esc_html( $cookies_note )
					)
				);
			}

			// Submit Button
			$defaults['submit_field'] = '<div class="zyre-comment-form-field-wrap zyre-comment-form-submit">%1$s %2$s</div>';
			$defaults['class_submit'] = 'zyre-comment-form-submit-btn';
			$defaults['label_submit'] = ! empty( $settings['label_submit'] ) ? esc_attr( $settings['label_submit'] ) : esc_attr( $defaults['label_submit'] );
			if ( '' === $settings['label_submit_show'] ) {
				$defaults['label_submit'] = '';
			}

			return $defaults;
		});

		// Variable "cpage" is set for pagination
		$page     = max( 1, get_query_var( 'cpage' ) );

		$comment_args = [
			'post_id' => get_the_ID(),
			'orderby' => 'comment_date_gmt',
			'order'   => 'ASC',
			'status'  => 'approve',
		];

		if ( is_user_logged_in() ) {
			$comment_args['include_unapproved'] = [ get_current_user_id() ];
		} else {
			$unapproved_email = wp_get_unapproved_comment_author_email();

			if ( $unapproved_email ) {
				$comment_args['include_unapproved'] = [ $unapproved_email ];
			}
		}

		$comments = get_comments( $comment_args );
		$total_pages = get_comment_pages_count( $comments );
		$comments_count = get_comments_number();
		?>

		<div id="comments" class="zyre-comments-area">
			<?php
			// Form Output
			if ( 'before' === $settings['form_position'] ) {
				comment_form();
			}

			// Comments List Output
			if ( (int) $comments_count > 0 ) {
				if ( 'yes' === $settings['show_comments_title'] ) {
					$comments_one = ! empty( $settings['comments_one'] ) ? $settings['comments_one'] : _x( 'One Comment', 'comments title', 'zyre-elementor-addons' );
					$comments_singular = ! empty( $settings['comments_singular'] ) ? $settings['comments_singular'] : __( 'Comment', 'zyre-elementor-addons' );
					$comments_plural = ! empty( $settings['comments_plural'] ) ? $settings['comments_plural'] : __( 'Comments', 'zyre-elementor-addons' );
					?>
					<h2 class="zyre-comments-title zy-m-0">
						<?php
						if ( '1' === $comments_count ) {
							printf( esc_html( $comments_one ) );
						} else {
							/* translators: %1$s: number of comments */
							printf(
								esc_html(
									_nx(
										'%1$s comment',
										'%1$s comments',
										$comments_count,
										'comments title',
										'zyre-elementor-addons'
									)
								),
								esc_html( number_format_i18n( $comments_count ) )
							);
						}
						?>
					</h2>
					<?php
				}

				// Pagination
				if ( 'top_bottom' === $settings['pagination_display'] || 'top' === $settings['pagination_display'] ) {
					$this->render_comments_pagination( $total_pages, $page, $settings );
				}
				?>

				<ol class="zyre-comments-list zy-m-0 zy-p-0 zy-list-none">
					<?php
					wp_list_comments(
						[
							'style'       => 'ol',
							'short_ping'  => true,
							'callback' => [ $this, 'zyre_list_comments' ],
						],
						$comments
					);
					?>
				</ol>

				<?php
				// Pagination
				if ( 'top_bottom' === $settings['pagination_display'] || 'bottom' === $settings['pagination_display'] ) {
					$this->render_comments_pagination( $total_pages, $page, $settings );
				}
			}

			// Form Output
			if ( 'after' === $settings['form_position'] ) {
				comment_form();
			}
			?>
		</div><!-- #comments -->

		<?php
		if ( 'custom' === $settings['source_type'] ) {
			zyre_elementor()->db->restore_current_post();
		}
	}

	/**
	 * Render Comments List
	 */
	public function zyre_list_comments( $comment, $args, $depth ) {
		$settings = $this->get_settings_for_display();
		$commenter = wp_get_current_commenter();
		$show_pending_links = ! empty( $commenter['comment_author'] );

		$body_class = 'comment-body';
		$show_avatars = (bool) get_option( 'show_avatars' );
		if ( $show_avatars ) {
			$body_class .= ' has-avatar';
		}

		if ( $commenter['comment_author_email'] ) {
			$moderation_note = __( 'Your comment is awaiting moderation.', 'zyre-elementor-addons' );
		} else {
			$moderation_note = __( 'Your comment is awaiting moderation. This is a preview; your comment will be visible after it has been approved.', 'zyre-elementor-addons' );
		}
		?>
		<li id="comment-<?php comment_ID(); ?>" <?php comment_class( $comment->has_children ? 'parent' : '', $comment ); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" class="<?php echo esc_attr( $body_class ); ?>">
				<?php
				if ( $show_avatars ) {
					echo get_avatar( $comment, (int) $settings['avatar_size']['size'] );
				}
				?>
				<div class="comment-content-box">
					<footer class="comment-meta zy-gap-2">
						<div class="comment-author vcard">
							<?php
							if ( 'yes' === $settings['disable_author_link'] ) {
								add_filter( 'get_comment_author_url', function ( $comment_author_url ) {
									$comment_author_url = '';
									return $comment_author_url;
								});
							}

							$comment_author = get_comment_author_link( $comment );

							if ( '0' === $comment->comment_approved && ! $show_pending_links ) {
								$comment_author = get_comment_author( $comment );
							}

							$says_text = ! empty( $settings['comment_says_text'] ) ? $settings['comment_says_text'] : '';
							printf(
								'%s <span class="says">%s</span> %s',
								is_rtl() ? '' : sprintf( '<b class="fn">%s</b>', $comment_author ),
								esc_html( $says_text ),
								is_rtl() ? sprintf( '<b class="fn">%s</b>', $comment_author ) : '',
							);
							?>
						</div><!-- .comment-author -->

						<?php if ( 'yes' === $settings['show_date_time'] || 'yes' === $settings['show_comment_edit'] ) : ?>
						<div class="comment-metadata">
							<?php
							if ( 'yes' === $settings['show_date_time'] ) {
								$date_format = ! empty( $settings['comment_date_format'] ) ? esc_html( $settings['comment_date_format'] ) : '';
								$time_format = ! empty( $settings['comment_time_format'] ) ? esc_html( $settings['comment_time_format'] ) : '';
								printf(
									'<a href="%s"><time datetime="%s">%s</time></a>',
									esc_url( get_comment_link( $comment, $args ) ),
									get_comment_time( 'c' ),
									sprintf(
										/* translators: 1: Comment date, 2: Comment time. */
										__( '%1$s at %2$s', 'zyre-elementor-addons' ),
										get_comment_date( $date_format, $comment ),
										get_comment_time( $time_format )
									)
								);
							}

							if ( 'yes' === $settings['show_comment_edit'] ) {
								edit_comment_link( __( 'Edit', 'zyre-elementor-addons' ), ' <span class="edit-link">', '</span>' );
							}
							?>
						</div><!-- .comment-metadata -->
						<?php endif; ?>

						<?php if ( '0' === $comment->comment_approved ) : ?>
						<em class="comment-awaiting-moderation"><?php echo esc_html( $moderation_note ); ?></em>
						<?php endif; ?>
					</footer><!-- .comment-meta -->

					<div class="comment-content">
						<?php comment_text(); ?>
					</div><!-- .comment-content -->
					<?php
					if ( '1' === $comment->comment_approved || $show_pending_links ) {
						comment_reply_link(
							array_merge(
								$args,
								[
									'add_below'  => 'div-comment',
									'depth'      => $depth,
									'max_depth'  => $args['max_depth'],
									'before'     => '<div class="reply">',
									'after'      => '</div>',
								]
							)
						);
					}
					?>
				</div><!-- .comment-content-box -->
			</article><!-- .comment-body -->
		</li>
		<?php
	}

	/**
	 * Render Comments Pagination
	 *
	 * @param int $total_pages Total number of pages.
	 * @param int $page The current page number.
	 * @param array $settings Get controls settings.
	 */
	protected function render_comments_pagination( $total_pages, $page, $settings ) {
		if ( $total_pages > 1 ) {
			?>
			<nav class="navigation zyre-comments-navigation zy-flex zy-justify-center zy-gap-1" aria-label="<?php esc_attr_e( 'Comments', 'zyre-elementor-addons' ); ?>">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Comments navigation', 'zyre-elementor-addons' ); ?></h2>
				<?php
				echo paginate_links([
					'base'      => add_query_arg( 'cpage', '%#%' ),
					'format'    => '',
					'total'     => $total_pages,
					'current'   => $page,
					'prev_text' => ! empty( $settings['pagination_prev_text'] ) ? esc_html( $settings['pagination_prev_text'] ) : '&laquo;',
					'next_text' => ! empty( $settings['pagination_next_text'] ) ? esc_html( $settings['pagination_next_text'] ) : '&raquo;',
				]);
				?>
			</nav>
			<?php
		}
	}
}
