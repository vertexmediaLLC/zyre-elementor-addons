<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Archive_Posts extends Base {

	public $query;

	public $settings = [];
	private $current_permalink;

	public function get_title() {
		return esc_html__( 'Archive Posts', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Archive-Post';
	}

	public function get_keywords() {
		return [ 'archive posts', 'posts', 'post', 'recent post', 'category posts', 'taxonomy posts', 'tags posts', 'tag post', 'post grid', 'post list' ];
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	/**
	 * Register widget content controls
	 */
	protected function register_content_controls() {
		$this->__content_general();
		$this->__content_post_thumbnail();
		$this->__content_post_title();
		$this->__content_post_meta();
		$this->__content_post_excerpt();
		$this->__content_read_more();
		$this->__content_post_pagination();
	}

	/**
	 * General Settings
	 */
	protected function __content_general() {
		$this->start_controls_section(
			'section_general_content',
			[
				'label' => esc_html__( 'General', 'zyre-elementor-addons' ),
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$this->add_responsive_control(
			'columns',
			[
				'label'          => esc_html__( 'Columns', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '4',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'1' => esc_html__( 'Column - 1', 'zyre-elementor-addons' ),
					'2' => esc_html__( 'Columns - 2', 'zyre-elementor-addons' ),
					'3' => esc_html__( 'Columns - 3', 'zyre-elementor-addons' ),
					'4' => esc_html__( 'Columns - 4', 'zyre-elementor-addons' ),
					'5' => esc_html__( 'Columns - 5', 'zyre-elementor-addons' ),
					'6' => esc_html__( 'Columns - 6', 'zyre-elementor-addons' ),
				],
				'selectors'       => [
					'{{WRAPPER}} .zyre-archive-post-container' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
				],
			]
		);

		$this->add_control(
			'nothing_found_message',
			[
				'label'   => esc_html__( 'Nothing Found Message', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'There are no post here...', 'zyre-elementor-addons' ),
				'ai' => false,
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Post Thumbnail - Content
	 */
	protected function __content_post_thumbnail() {
		$this->start_controls_section(
			'section_archive_thumbnail_content',
			[
				'label' => esc_html__( 'Post Thumbnail', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'show_thumbnail',
			[
				'label'     => esc_html__( 'Thumbnail', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'default'   => 'yes',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'         => 'thumbnail_size',
				'default'      => 'medium',
				'condition'    => [
					'show_thumbnail' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'img_position',
			[
				'label'                => esc_html__( 'Thumbnail Position', 'zyre-elementor-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'top'   => [
						'title' => esc_html__( 'Top', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-top',
					],
					'left'  => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'              => 'top',
				'tablet_default'       => 'top',
				'mobile_default'       => 'top',
				'selectors_dictionary' => [
					'top'   => 'all: unset;',
					'left'  => 'display:flex;align-items: flex-start;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;-ms-flex-direction:row;flex-direction:row;',
					'right' => 'display:flex;align-items: flex-start;-webkit-box-orient:horizontal;-webkit-box-direction:reverse;-webkit-flex-direction:row-reverse;-ms-flex-direction:row-reverse;flex-direction:row-reverse;',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-archive-post' => '{{VALUE}}',
				],
				'condition'            => [
					'show_thumbnail' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'thumbnail_gap',
			[
				'label'                => esc_html__( 'Space Between', 'zyre-elementor-addons' ),
				'type'                 => Controls_Manager::SLIDER,
				'selectors'            => [
					'{{WRAPPER}} .zyre-archive-post' => 'gap: {{SIZE}}{{UNIT}};',
				],
				'condition'            => [
					'show_thumbnail' => 'yes',
					'img_position' => [ 'left', 'right' ],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Post Title - Content
	 */
	protected function __content_post_title() {
		$this->start_controls_section(
			'section_archive_title_content',
			[
				'label' => esc_html__( 'Post Title', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'show_title',
			[
				'label'     => esc_html__( 'Title', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'default'   => 'yes',
			]
		);

		$this->add_control(
			'title_tag',
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
				'default' => 'h3',
				'toggle'  => false,
				'condition'    => [
					'show_title' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Post Meta - Content
	 */
	protected function __content_post_meta() {
		$this->start_controls_section(
			'section_archive_meta_content',
			[
				'label' => esc_html__( 'Post Meta', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'post_meta_switcher',
			[
				'label' => esc_html__( 'Post Meta Switcher', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Off', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$meta_types = [
			'author'   => esc_html__( 'Author', 'zyre-elementor-addons' ),
			'date'     => esc_html__( 'Date', 'zyre-elementor-addons' ),
			'category' => esc_html__( 'Category', 'zyre-elementor-addons' ),
			'tag'      => esc_html__( 'Tag', 'zyre-elementor-addons' ),
			'comments' => esc_html__( 'Comments', 'zyre-elementor-addons' ),
			'edit'     => esc_html__( 'Post Edit', 'zyre-elementor-addons' ),
		];

		$repeater = new Repeater();

		$repeater->add_control(
			'post_meta_select',
			[
				'label' => esc_html__( 'Select Meta', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'author',
				'options' => $meta_types,
			]
		);

		// Author Meta
		$repeater->add_control(
			'author_link',
			[
				'label'     => esc_html__( 'Author Link Enable', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'default'   => 'yes',
				'condition' => [
					'post_meta_select' => 'author',
				],
			]
		);

		$repeater->add_control(
			'author_icon_switcher',
			[
				'label' => esc_html__( 'Icon Switcher', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Off', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'post_meta_select' => 'author',
				],
			]
		);

		$repeater->add_control(
			'author_meta_icon',
			[
				'label'       => esc_html__( 'Icon Upload', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => 'true',
				'default' => [
					'value'   => 'far fa-user',
					'library' => 'fa-regular',
				],
				'condition' => [
					'post_meta_select' => 'author',
					'author_icon_switcher' => 'yes',
				],
			]
		);

		// Date Meta
		$repeater->add_control(
			'post_date_link',
			[
				'label'     => esc_html__( 'Date Link Enable', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'default'   => 'yes',
				'condition' => [
					'post_meta_select' => 'date',
				],
			]
		);

		$repeater->add_control(
			'date_icon_switcher',
			[
				'label' => esc_html__( 'Icon Switcher', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Off', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'post_meta_select' => 'date',
				],
			]
		);

		$repeater->add_control(
			'date_meta_icon',
			[
				'label'       => esc_html__( 'Icon Upload', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => 'true',
				'default' => [
					'value'   => 'far fa-clock',
					'library' => 'fa-regular',
				],
				'condition' => [
					'post_meta_select' => 'date',
					'date_icon_switcher' => 'yes',
				],
			]
		);

		// Comment Meta
		$repeater->add_control(
			'comment_link',
			[
				'label'     => esc_html__( 'Comment Link Enable', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'default'   => 'yes',
				'condition' => [
					'post_meta_select' => 'comments',
				],
			]
		);

		$repeater->add_control(
			'comment_icon_switcher',
			[
				'label' => esc_html__( 'Icon Switcher', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Off', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'post_meta_select' => 'comments',
				],
			]
		);

		$repeater->add_control(
			'comment_meta_icon',
			[
				'label'       => esc_html__( 'Icon Upload', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => 'true',
				'default' => [
					'value'   => 'far fa-comment-dots',
					'library' => 'fa-regular',
				],
				'condition' => [
					'post_meta_select' => 'comments',
					'comment_icon_switcher' => 'yes',
				],
			]
		);

		// Category Meta
		$repeater->add_control(
			'category_separator_text',
			[
				'label'     => esc_html__( 'Separator Text', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( ', ', 'zyre-elementor-addons' ),
				'condition' => [
					'post_meta_select' => 'category',
				],
				'ai'   => false,
			]
		);

		$repeater->add_control(
			'category_icon_switcher',
			[
				'label' => esc_html__( 'Icon Switcher', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Off', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'post_meta_select' => 'category',
				],
			]
		);

		$repeater->add_control(
			'category_meta_icon',
			[
				'label'       => esc_html__( 'Icon Upload', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => 'true',
				'default' => [
					'value'   => 'far fa-folder-open',
					'library' => 'fa-regular',
				],
				'condition' => [
					'post_meta_select' => 'category',
					'category_icon_switcher' => 'yes',
				],
			]
		);

		// Tag Meta
		$repeater->add_control(
			'tag_separator_text',
			[
				'label'     => esc_html__( 'Separator Text', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( ', ', 'zyre-elementor-addons' ),
				'condition' => [
					'post_meta_select' => 'tag',
				],
				'ai'   => false,
			]
		);

		$repeater->add_control(
			'tag_icon_switcher',
			[
				'label' => esc_html__( 'Icon Switcher', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Off', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'post_meta_select' => 'tag',
				],
			]
		);

		$repeater->add_control(
			'tag_meta_icon',
			[
				'label'       => esc_html__( 'Icon Upload', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => 'true',
				'default' => [
					'value'   => 'fas fa-tags',
					'library' => 'fa-solid',
				],
				'condition' => [
					'post_meta_select' => 'tag',
					'tag_icon_switcher' => 'yes',
				],
			]
		);

		// Post Edit
		$repeater->add_control(
			'edit_text',
			[
				'label'     => esc_html__( 'Edit Meta Text', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Edit Post', 'zyre-elementor-addons' ),
				'ai'   => false,
				'condition' => [
					'post_meta_select' => 'edit',
				],
			]
		);

		$repeater->add_control(
			'edit_icon_switcher',
			[
				'label' => esc_html__( 'Icon Switcher', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Off', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'post_meta_select' => 'edit',
				],
			]
		);

		$repeater->add_control(
			'edit_meta_icon',
			[
				'label'       => esc_html__( 'Icon Upload', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => 'true',
				'default' => [
					'value'   => 'far fa-edit',
					'library' => 'fa-regular',
				],
				'condition' => [
					'post_meta_select' => 'edit',
					'edit_icon_switcher' => 'yes',
				],
			]
		);

		$this->add_control(
			'post_meta_elements',
			[
				'label' => esc_html__( 'Post Meta Elements', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'post_meta_select' => 'author',
					],
					[
						'post_meta_select' => 'category',
					],
					[
						'post_meta_select' => 'date',
					],
					[
						'post_meta_select' => 'comments',
					],
					[
						'post_meta_select' => 'tag',
					],
					[
						'post_meta_select' => 'edit',
					],
				],
				'condition' => [
					'post_meta_switcher' => 'yes',
				],
				'title_field' => '{{{ post_meta_select.charAt(0).toUpperCase() + post_meta_select.slice(1) }}}',
			]
		);

		// Separator
		$this->add_control(
			'post_meta_separator',
			[
				'label'     => esc_html__( 'Separator Between', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => [
					'post_meta_switcher' => 'yes',
				],
				'ai'   => false,
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Post Excerpt - Content
	 */
	protected function __content_post_excerpt() {
		$this->start_controls_section(
			'section_archive_excerpt_content',
			[
				'label' => esc_html__( 'Post Excerpt', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'show_excerpt',
			[
				'label'     => esc_html__( 'Excerpt', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'default'   => 'yes',
			]
		);

		$this->add_control(
			'excerpt_length',
			[
				'type'        => Controls_Manager::NUMBER,
				'label'       => esc_html__( 'Excerpt Length', 'zyre-elementor-addons' ),
				'min'         => 0,
				'default'     => 22,
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Read More - Content
	 */
	protected function __content_read_more() {
		$this->start_controls_section(
			'section_archive_read_more_content',
			[
				'label' => esc_html__( 'Read More', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'show_read_more',
			[
				'label'     => esc_html__( 'Read More', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'default'   => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'read_more_text',
			[
				'label'     => esc_html__( 'Read More Text', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Read More »', 'zyre-elementor-addons' ),
				'condition' => [
					'show_read_more' => 'yes',
				],
				'ai'   => false,
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Pagination - Content
	 */
	protected function __content_post_pagination() {
		$this->start_controls_section(
			'section_archive_pagination_content',
			[
				'label' => esc_html__( 'Pagination', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'pagination_show',
			[
				'label'     => esc_html__( 'Pagination Show', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'default'   => 'yes',
			]
		);

		$this->add_control(
			'pagination_prev_label',
			[
				'label'     => esc_html__( 'Previous Label', 'zyre-elementor-addons' ),
				'default'   => esc_html__( '&laquo; Previous', 'zyre-elementor-addons' ),
				'condition' => [
					'pagination_show' => 'yes',
				],
				'ai'   => false,
			]
		);

		$this->add_control(
			'pagination_next_label',
			[
				'label'     => esc_html__( 'Next Label', 'zyre-elementor-addons' ),
				'default'   => esc_html__( 'Next &raquo;', 'zyre-elementor-addons' ),
				'condition' => [
					'pagination_show' => 'yes',
				],
				'ai'   => false,
			]
		);

		$this->add_responsive_control(
			'pagination_align',
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
				],
				'default' => is_rtl() ? 'right' : 'left',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .zyre-archive-post-pagination' => 'text-align: {{VALUE}};',
				],
				'condition' => [
					'pagination_show' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register styles related controls
	 */
	protected function register_style_controls() {
		$this->__style_general();
		$this->__style_post_layout();
		$this->__style_post_thumbnail();
		$this->__style_post_title();
		$this->__style_post_meta();
		$this->__style_post_excerpt();
		$this->__style_read_more();
		$this->__style_post_pagination();
	}

	/**
	 * General - Style
	 */
	protected function __style_general() {
		$this->start_controls_section(
			'section_general_style',
			[
				'label' => esc_html__( 'General', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'post_container',
			[
				'selector' => '{{WRAPPER}} .zyre-archive-post-container',
				'controls' => [
					'column_gap' => [],
					'row_gap'    => [],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Post - Style
	 */
	protected function __style_post_layout() {
		$this->start_controls_section(
			'post_layout_style',
			[
				'label' => esc_html__( 'Post', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'post',
			[
				'selector' => '{{WRAPPER}} .zyre-archive-post',
				'controls' => [
					'bg_color'      => [],
					'padding'       => [],
					'border'        => [],
					'border_radius' => [],
					'box_shadow'    => [],
					'alignment'     => [],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Post Thumbnail - Style
	 */
	protected function __style_post_thumbnail() {
		$this->start_controls_section(
			'post_thumbnail_style',
			[
				'label' => esc_html__( 'Post Thumbnail', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'    => [
					'show_thumbnail' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'post_thumbnail',
			[
				'selector' => '{{WRAPPER}} .zyre-archive-post-thumbnail img',
				'controls' => [
					'width'         => [],
					'height'        => [],
					'object_fit'    => [
						'default' => 'cover',
					],
					'bg_color'      => [],
					'padding'       => [],
					'margin'        => [],
					'border'        => [],
					'border_radius' => [],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Post Title - Style
	 */
	protected function __style_post_title() {
		$this->start_controls_section(
			'post_title_style',
			[
				'label' => esc_html__( 'Post Title', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'    => [
					'show_title' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'post_title',
			[
				'selector' => '{{WRAPPER}} .zyre-archive-post-title',
				'controls' => [
					'typography' => [],
					'space'      => [
						'label' => esc_html__( 'Margin Bottom', 'zyre-elementor-addons' ),
					],
				],
			],
		);

		// Tabs
		$this->start_controls_tabs( 'tabs_post_title_link_colors' );

		// Tab: Normal
		$this->start_controls_tab(
			'tab_post_title_link_color_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'post_title_link',
			[
				'selector' => '{{WRAPPER}} .zyre-archive-post-title a',
				'controls' => [
					'color' => [],
				],
			],
		);

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab(
			'tab_post_title_link_color_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'post_title_link_hover',
			[
				'selector' => '{{WRAPPER}} .zyre-archive-post-title a:hover',
				'controls' => [
					'color' => [],
				],
			],
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Post Meta - Style
	 */
	protected function __style_post_meta() {
		$this->start_controls_section(
			'post_meta_style',
			[
				'label' => esc_html__( 'Post Meta', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'post_meta_switcher' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'post_meta',
			[
				'selector' => '{{WRAPPER}} .zyre-archive-post-meta',
				'controls' => [
					'typography'    => [],
					'color'         => [],
					'bg_color'      => [],
					'space'         => [
						'label' => esc_html__( 'Bottom Space', 'zyre-elementor-addons' ),
					],
					'column_gap'    => [],
					'row_gap'       => [],
					'padding'       => [],
					'border'        => [],
					'border_radius' => [],
					'align_x'       => [
						'options' => [
							'flex-start' => [
								'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
								'icon'  => 'eicon-justify-start-h',
							],
							'center'     => [
								'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
								'icon'  => 'eicon-justify-center-h',
							],
							'flex-end'   => [
								'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
								'icon'  => 'eicon-justify-end-h',
							],
						],
					],
				],
			]
		);

		$this->set_style_controls(
			'meta',
			[
				'selector' => '{{WRAPPER}} .zyre-archive-post-meta-item-icon',
				'controls' => [
					'heading'    => [
						'label'     => esc_html__( 'Icon, Separator & Link', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
					'icon_size'  => [],
					'icon_color' => [],
				],
			]
		);

		$this->set_style_controls(
			'meta_separator',
			[
				'selector' => '{{WRAPPER}} .zyre-archive-post-meta-separator',
				'controls' => [
					'color' => [
						'label'     => __( 'Separator Color', 'zyre-elementor-addons' ),
					],
				],
				'condition' => [
					'post_meta_separator!' => '',
				],
			]
		);

		// Tabs
		$this->start_controls_tabs( 'tabs_meta_link_colors' );

		// Tab: Normal
		$this->start_controls_tab(
			'tab_meta_link_color_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'meta_link',
			[
				'selector' => '{{WRAPPER}} .zyre-archive-post-meta-link, {{WRAPPER}} .zyre-archive-post-meta-link a',
				'controls' => [
					'color' => [
						'label' => esc_html__( 'Link Color', 'zyre-elementor-addons' ),
					],
				],
			],
		);

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab(
			'tab_meta_link_color_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'meta_link_hover',
			[
				'selector' => '{{WRAPPER}} .zyre-archive-post-meta-link:hover, {{WRAPPER}} .zyre-archive-post-meta-link a:hover',
				'controls' => [
					'color' => [
						'label' => esc_html__( 'Link Color', 'zyre-elementor-addons' ),
					],
				],
			],
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Post Excerpt - Style
	 */
	protected function __style_post_excerpt() {
		$this->start_controls_section(
			'post_excerpt_style',
			[
				'label' => esc_html__( 'Post Excerpt', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'post_excerpt',
			[
				'selector' => '{{WRAPPER}} .zyre-archive-post-excerpt',
				'controls' => [
					'typography' => [],
					'color'      => [],
					'space'      => [
						'label' => esc_html__( 'Margin Bottom', 'zyre-elementor-addons' ),
					],
				],
			],
		);

		$this->end_controls_section();
	}

	/**
	 * Read More - Style
	 */
	protected function __style_read_more() {
		$this->start_controls_section(
			'read_more_style',
			[
				'label' => esc_html__( 'Read More', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_read_more' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'read_more',
			[
				'selector' => '{{WRAPPER}} .zyre-archive-post-readmore',
				'controls' => [
					'typography' => [],
				],
			]
		);

		// Tabs
		$this->start_controls_tabs( 'tabs_read_more_colors' );

		// Tab: Normal
		$this->start_controls_tab(
			'tab_read_more_color_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'read_more',
			[
				'selector' => '{{WRAPPER}} .zyre-archive-post-readmore',
				'controls' => [
					'color'    => [],
					'bg_color' => [],
				],
			],
		);

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab(
			'tab_read_more_color_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'read_more_hover',
			[
				'selector' => '{{WRAPPER}} .zyre-archive-post-readmore:hover',
				'controls' => [
					'color'        => [],
					'bg_color'     => [],
					'border_color' => [],
				],
			],
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'_separator_line',
			[
				'type'      => Controls_Manager::RAW_HTML,
				'raw'       => '<div style="border-block-start: var(--e-a-border);border-block-start-width: 1px;"></div>',
			]
		);

		$this->set_style_controls(
			'read_more',
			[
				'selector' => '{{WRAPPER}} .zyre-archive-post-readmore',
				'controls' => [
					'padding'       => [],
					'border'        => [],
					'border_radius' => [],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Pagination - Style
	 */
	protected function __style_post_pagination() {
		$this->start_controls_section(
			'post_pagination_style',
			[
				'label' => esc_html__( 'Pagination', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'pagination_show' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'pagination',
			[
				'selector' => '{{WRAPPER}} .zyre-archive-post-pagination',
				'controls' => [
					'bg_color'      => [],
					'padding'       => [],
					'margin'        => [],
					'border'        => [],
					'border_radius' => [],
				],
			]
		);

		$this->set_style_controls(
			'pagination_numbers',
			[
				'selector' => '{{WRAPPER}} .zyre-archive-post-pagination .page-numbers',
				'controls' => [
					'heading'       => [
						'label'     => esc_html__( 'Page Numbers', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
					'typography'    => [],
					'padding'       => [],
					'margin'        => [
						'selector' => '{{WRAPPER}} .zyre-archive-post-pagination .page-numbers:not(:last-child)',
					],
					'border'        => [],
					'border_radius' => [],
				],
			]
		);

		// Tabs
		$this->start_controls_tabs( 'tabs_pagination_numbers_colors' );

		// Tab: Normal
		$this->start_controls_tab(
			'tab_pagination_numbers_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'pagination_numbers',
			[
				'selector' => '{{WRAPPER}} .zyre-archive-post-pagination .page-numbers',
				'controls' => [
					'color'    => [],
					'bg_color' => [],
				],
			],
		);

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab(
			'tab_pagination_numbers_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'pagination_numbers_hover',
			[
				'selector' => '{{WRAPPER}} .zyre-archive-post-pagination .page-numbers:not(.current):hover',
				'controls' => [
					'color'        => [],
					'bg_color'     => [],
					'border_color' => [],
				],
			],
		);

		$this->end_controls_tab();

		// Tab: Current
		$this->start_controls_tab(
			'tab_pagination_numbers_current',
			[
				'label' => esc_html__( 'Current', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'pagination_numbers_current',
			[
				'selector' => '{{WRAPPER}} .zyre-archive-post-pagination .page-numbers.current',
				'controls' => [
					'color'        => [],
					'bg_color'     => [],
					'border_color' => [],
				],
			],
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Register render display controls
	 */
	protected function render() {
		$this->settings = $this->get_settings_for_display();
		global $wp_query;

		$query_vars = $wp_query->query_vars;

		if ($query_vars !== $wp_query->query_vars) {
            $this->query = new \WP_Query($query_vars); // SQL_CALC_FOUND_ROWS is used.
        } else {
            $this->query = $wp_query;
        }

		if ( zyre_elementor()->editor->is_edit_mode() || is_preview() ) {
			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			$args = [
				'post_type'      => [ 'post' ],
				'post_status'    => [ 'publish' ],
				'paged'          => $paged,
				'offset'         => 1,
				'posts_per_page' => 12,
				'order'          => 'DESC',
				'orderby'        => 'date',

			];
			$this->query = new \WP_Query( $args );
		}

		// It's the global `wp_query` it self. and the loop was started from the theme.
		if ($this->query->in_the_loop) {
			$this->current_permalink = get_permalink();
			$this->render_post();
		} else {
			if ( $this->query->have_posts() ) {
				echo '<div class="zyre-archive-post-container zy-grid zy-gap-x-4 zy-gap-y-6">';

				while ( $this->query->have_posts() ) {
					$this->query->the_post();

					$this->current_permalink = get_permalink();
					$this->render_post();
				}
				echo '</div>';

				$this->render_pagination( $this->query );
			} else {
				echo '<div class="zyre-archive-post-container">' . esc_html( $this->settings['nothing_found_message'] ) . '</div>';
			}
		}

		wp_reset_postdata();
	}

	/**
	 * Display post item
	 */
	protected function render_post() {
		$this->add_render_attribute( 'posts', 'class', [
			'zyre-archive-post',
			'post-' . get_the_ID(),
			'type-' . get_post_type(),
			'status-' . get_post_status(),
		], true );
		?>

		<article <?php $this->print_render_attribute_string( 'posts' ); ?>>
			<?php
			$this->render_thumbnail();
			echo '<div class="zyre-archive-post-content zy-w-100">';
			$this->render_title();
			$this->render_meta();
			$this->render_excerpt();
			$this->render_read_more();
			echo '</div>';
			?>
		</article>
		<?php
	}

	protected function render_thumbnail() {
		if ( 'yes' !== $this->settings['show_thumbnail'] ) {
			return;
		}

		$this->settings['thumbnail_size'] = [
			'id' => get_post_thumbnail_id(),
		];

		$thumbnail_html = Group_Control_Image_Size::get_attachment_image_html( $this->settings, 'thumbnail_size' );

		if ( empty( $thumbnail_html ) ) {
			return;
		}
		?>

		<a class="zyre-archive-post-thumbnail zyre-archive-post-thumbnail__link" href="<?php echo esc_attr( $this->current_permalink ); ?>">
			<?php echo wp_kses_post( $thumbnail_html ); ?>
		</a>
		<?php
	}

	/**
	 * Display post title
	 */
	protected function render_title() {
		$show_title = $this->settings['show_title'];
		if ( 'yes' === $show_title && get_the_title() ) {
			$title_tag = $this->settings['title_tag'];

			printf(
				'<%1$s %2$s><a href="%3$s">%4$s</a></%1$s>',
				zyre_escape_tags( $title_tag, 'h3' ),
				'class="zyre-archive-post-title zy-m-0"',
				esc_url( get_the_permalink( get_the_ID() ) ),
				zyre_kses_basic( get_the_title() )
			);
		}
	}

	/**
	 * Display post meta
	 */
	protected function render_meta() {
		$post_meta = $this->settings['post_meta_elements'];
		if ( empty( $post_meta ) ) {
			return;
		}

		$separator = ! empty( $this->settings['post_meta_separator'] ) ? '<span class="zyre-archive-post-meta-separator">' . esc_html( $this->settings ['post_meta_separator'] ) . '</span>' : '';
		$post_meta_count = count( $post_meta );

		echo '<div class="zyre-archive-post-meta zy-flex zy-flex-wrap zy-align-center zy-gap-x-2">';

		foreach ( $post_meta as $index => $meta_item ) {
			// Set separator to blank for the last item
			$is_last = ( $index === $post_meta_count - 1 );
			$cur_separator = $is_last ? '' : $separator;

			switch ( $meta_item ['post_meta_select'] ) {
				case 'author':
					$this->render_author( $meta_item );
					echo $cur_separator;
					break;

				case 'date':
					$this->render_date( $meta_item );
					echo $cur_separator;
					break;

				case 'comments':
					$this->render_comments( $meta_item );
					echo $cur_separator;
					break;

				case 'category':
					$this->render_category( $meta_item, $cur_separator );
					break;

				case 'tag':
					$this->render_tag( $meta_item, $cur_separator );
					break;

				case 'edit':
					$this->render_edit( $meta_item, $cur_separator );
					break;
			}
		}

		echo '</div>';
	}

	/**
	 * Display post meta - author
	 */
	protected function render_author( $meta_item ) {
		$author_tag = 'span';
		$author_class = 'zyre-archive-post-meta-item zyre-archive-post-meta-author';
		if ( 'yes' === $meta_item['author_link'] ) {
			$author_tag = 'a';
			$this->add_render_attribute( 'post_author', 'href', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) );
			$author_class .= ' zyre-archive-post-meta-link';
		}
		?>

		<<?php Utils::print_validated_html_tag( $author_tag ); ?> <?php $this->print_render_attribute_string( 'post_author' ); ?> class="<?php echo esc_attr( $author_class ); ?>">
			<?php if ( '' !== $meta_item['author_meta_icon']['value'] ) : ?>
				<span class="zyre-archive-post-meta-item-icon">
					<?php zyre_render_icon( $meta_item, 'icon', 'author_meta_icon' ); ?>
				</span>
			<?php endif; ?>

			<?php the_author(); ?>
		</<?php Utils::print_validated_html_tag( $author_tag ); ?>>
	<?php }

	/**
	 * Display post meta - Date
	 */
	protected function render_date( $meta_item ) {
		$date_tag = 'span';
		$date_class = 'zyre-archive-post-meta-item zyre-archive-post-meta-date';
		if ( 'yes' === $meta_item['post_date_link'] ) {
			$date_tag = 'a';
			$this->add_render_attribute( 'post_date', 'href', esc_url( get_day_link( get_post_time( 'Y' ), get_post_time( 'm' ), get_post_time( 'j' ) ) ) );
			$date_class .= ' zyre-archive-post-meta-link';
		}
		?>
		
		<<?php Utils::print_validated_html_tag( $date_tag ); ?> <?php $this->print_render_attribute_string( 'post_date' ); ?> class="<?php echo esc_attr( $date_class ); ?>">
			<?php if ( '' !== $meta_item['date_meta_icon']['value'] ) : ?>
				<span class="zyre-archive-post-meta-item-icon">
					<?php zyre_render_icon( $meta_item, 'icon', 'date_meta_icon' ); ?>
				</span>
			<?php endif; ?>
			<?php echo esc_html( get_the_date( get_option( 'date_format' ) ) ); ?>
		</<?php Utils::print_validated_html_tag( $date_tag ); ?>>
		<?php
	}

	/**
	 * Display post meta - Comments
	 */
	protected function render_comments( $meta_item ) {
		$comment_class = 'zyre-archive-post-meta-item zyre-archive-post-meta-comment';
		$comment_tag = 'span';
		if ( 'yes' === $meta_item['comment_link'] && comments_open() ) {
			$comment_tag = 'a';
			$comment_class .= ' zyre-archive-post-meta-link';
			$this->add_render_attribute( 'post_comment', 'href', esc_url( get_comments_link() ) );
		}

		$comments_number = (int) get_comments_number();
		if ( $comments_number > 1 ) {
			$text = sprintf(
				/* translators: %s: Number of comments. */
				_n( '%s comment', '%s comments', $comments_number, 'zyre-elementor-addons' ),
				number_format_i18n( $comments_number )
			);
		} elseif ( 0 === $comments_number ) {
			$text = __( '0 comment', 'zyre-elementor-addons' );
		} else { // Must be one.
			$text = __( '1 comment', 'zyre-elementor-addons' );
		}

		if ( ! comments_open() ) {
			$text = __( 'comments off', 'zyre-elementor-addons' );
		}
		?>

		<<?php Utils::print_validated_html_tag( $comment_tag ); ?> <?php $this->print_render_attribute_string( 'post_comment' ); ?> class="<?php echo esc_attr( $comment_class ); ?>">
			<?php if ( '' !== $meta_item['comment_meta_icon']['value'] ) : ?>
				<span class="zyre-archive-post-meta-item-icon">
					<?php zyre_render_icon( $meta_item, 'icon', 'comment_meta_icon' ); ?>
				</span>
			<?php endif; ?>
			<?php echo esc_html( $text ); ?>
		</<?php Utils::print_validated_html_tag( $comment_tag ); ?>>
		<?php
	}

	/**
	 * Display post meta - Category
	 */
	protected function render_category( $meta_item, $separator ) {
		if ( has_category() ) {
			$categories = get_the_category();

			if ( ! empty( $categories ) ) {
				$category_separator = ! empty( $meta_item['category_separator_text'] ) ? esc_html( $meta_item['category_separator_text'] ) : '';
				$names = [];

				echo '<span class="zyre-archive-post-meta-item zyre-archive-post-meta-category zyre-archive-post-meta-link">';

				if ( '' !== $meta_item['category_meta_icon']['value'] ) : ?>
					<span class="zyre-archive-post-meta-item-icon">
						<?php zyre_render_icon( $meta_item, 'icon', 'category_meta_icon' ); ?>
					</span>
				<?php endif;

				foreach ( $categories as $category ) {
					$names[] = '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>';
				}

				echo implode( $category_separator, $names ) . '</span>' . $separator;
			}
		}
	}

	/**
	 * Display post meta - Tag
	 */
	protected function render_tag( $meta_item, $separator ) {
		if ( has_tag() ) {

			$tags = get_the_tags();

			if ( ! empty( $tags ) ) {
				$tag_separator = ! empty( $meta_item['tag_separator_text'] ) ? esc_html( $meta_item['tag_separator_text'] ) : '';
				$names = [];

				echo '<span class="zyre-archive-post-meta-item zyre-archive-post-meta-tag zyre-archive-post-meta-link">';

				if ( '' !== $meta_item['tag_meta_icon']['value'] ) : ?>
					<span class="zyre-archive-post-meta-item-icon">
						<?php zyre_render_icon( $meta_item, 'icon', 'tag_meta_icon' ); ?>
					</span>
				<?php endif;

				foreach ( $tags as $tag ) {
					$names[] = '<a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" >' . esc_html( $tag->name ) . '</a>';
				}

				echo implode( $tag_separator, $names ) . '</span>' . $separator;
			}
		}
	}

	/**
	 * Display post meta - Post Edit
	 */
	protected function render_edit( $meta_item, $separator ) {
		if ( is_user_logged_in() && current_user_can( 'edit_posts' ) ) {

			echo '<span class="zyre-archive-post-meta-item zyre-archive-post-meta-post-edit zyre-archive-post-meta-link">';

			if ( '' !== $meta_item['edit_meta_icon']['value'] ) : ?>
				<span class="zyre-archive-post-meta-item-icon">
					<?php zyre_render_icon( $meta_item, 'icon', 'edit_meta_icon' ); ?>
				</span>
			<?php endif;

			$text = ! empty( $meta_item['edit_text'] ) ? $meta_item['edit_text'] : '';
			edit_post_link( esc_html( $text ) );
			echo '</span>' . $separator;
		}
	}

	/**
	 * Display post excerpt
	 */
	protected function render_excerpt() {
		$excerpt_length = (int) $this->settings['excerpt_length'];

		if ( empty( $excerpt_length ) ) {
			return;
		}

		$excerpt = apply_filters( 'get_the_excerpt', wp_trim_words( get_the_excerpt(), $excerpt_length ) );
		if ( $excerpt ) : ?>
			<p class="zyre-archive-post-excerpt zy-m-0"><?php echo zyre_kses_basic( $excerpt ); ?></p>
		<?php endif;
	}

	/**
	 * Display read more button
	 */
	protected function render_read_more() {
		$show_read_more = $this->settings['show_read_more'];
		$read_more_text = $this->settings['read_more_text'];

		if ( 'yes' === $show_read_more && ! empty( $read_more_text ) ) {
			printf(
				'<a class="%1$s" href="%2$s">%3$s</a>',
				'zyre-archive-post-readmore',
				esc_url( get_the_permalink( get_the_ID() ) ),
				esc_html( $read_more_text ),
			);
		}
	}

	/**
	 * Display pagination
	 */
	public function render_pagination( $query ) {
		if ( 'yes' !== $this->settings['pagination_show'] ) {
			return;
		}

		$total   = isset( $query->max_num_pages ) ? $query->max_num_pages : 1;
		$paged = intval( isset( $query->query['paged'] ) ? $query->query['paged'] : max( 1, get_query_var( 'paged' ) ) );

		$big = 99999999; // need an unlikely integer
		$html = paginate_links(
			[
				'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'    => '/page/%#%',
				'current'   => max( 1, $paged ),
				'total'     => $total,
				'end_size'  => 2,
				'show_all'  => 'yes',
				'type'      => 'list',
				'prev_text' => $this->settings['pagination_prev_label'],
				'next_text' => $this->settings['pagination_next_label'],
			]
		);

		printf(
			'<div class="zyre-archive-post-pagination">%s</div>',
			wp_kses( $html, zyre_get_allowed_html( 'advanced' ) )
		);
	}
}
