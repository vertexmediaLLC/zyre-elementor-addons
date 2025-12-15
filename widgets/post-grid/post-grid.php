<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

defined( 'ABSPATH' ) || die();

class Post_Grid extends Base {

	public $settings = [];

	public function get_title() {
		return esc_html__( 'Post Grid', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Post-grid';
	}

	public function get_keywords() {
		return [ 'posts', 'grid', 'post grid', 'posts grid', 'post list', 'blog post', 'archive posts', 'category posts', 'tag posts', 'taxonomy posts', 'author posts', 'custom post type posts', 'articles', 'blog view' ];
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	/**
	 * Register widget content controls
	 */
	protected function register_content_controls() {
		$this->__general_content();
		$this->__qurey_content();
		$this->__contents();
		$this->__pagination();
	}

	/**
	 * Content - General
	 */
	protected function __general_content() {
		$this->start_controls_section(
			'section_post_grid_content',
			[
				'label' => esc_html__( 'General', 'zyre-elementor-addons' ),
			]
		);

		// Pre styles
		$this->set_prestyle_controls();

		$this->add_responsive_control(
			'post_grid_columns',
			[
				'label'          => esc_html__( 'Columns', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::SELECT,
				'options'        => [
					'1' => esc_html__( 'Column - 1', 'zyre-elementor-addons' ),
					'2' => esc_html__( 'Columns - 2', 'zyre-elementor-addons' ),
					'3' => esc_html__( 'Columns - 3', 'zyre-elementor-addons' ),
					'4' => esc_html__( 'Columns - 4', 'zyre-elementor-addons' ),
					'5' => esc_html__( 'Columns - 5', 'zyre-elementor-addons' ),
					'6' => esc_html__( 'Columns - 6', 'zyre-elementor-addons' ),
				],
				'default'        => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'selectors'      => [
					'{{WRAPPER}} .zyre-post-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
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
	 * Content - Qurey
	 */
	protected function __qurey_content() {
		$this->start_controls_section(
			'section_qurey_content',
			[
				'label' => esc_html__( 'Query', 'zyre-elementor-addons' ),
			]
		);

		$post_types = zyre_get_post_types();

		$this->add_control(
			'query_source',
			[
				'label' => esc_html__( 'Source', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'post',
				'options' => $post_types,
			]
		);

		$this->add_control(
			'choose_posts',
			[
				'label' => esc_html__( 'Search & Select', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => zyre_get_all_type_posts(),
				'condition' => [
					'query_source' => 'manual',
				],
			]
		);

		$this->add_control(
			'author_list',
			[
				'label' => esc_html__( 'Author Posts', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'placeholder' => esc_html__( 'Search Post', 'zyre-elementor-addons' ),
				'options' => zyre_get_all_author(),
				'condition' => [
					'query_source!' => 'manual',
				],
			]
		);

		$taxonomies = get_taxonomies( [ 'public' => true ], 'objects' );

		foreach ( $taxonomies as $taxonomy => $object ) {
			// Skip taxonomies not assigned to allowed post types
			if ( ! isset( $object->object_type[0] ) || ! array_intersect( $object->object_type, array_keys( $post_types ) ) ) {
				continue;
			}

			// Primary taxonomy SELECT2 control
			$this->add_control(
				$taxonomy . '_list',
				[
					'label' => $object->label,
					'type' => Controls_Manager::SELECT2,
					'label_block' => true,
					'multiple' => true,
					'options' => zyre_get_category_list( $taxonomy ), // Use your existing helper to get terms
					'condition' => [
						'query_source' => $object->object_type,
						'query_source!' => 'manual',
					],
				]
			);

			// Add child category toggle for specific taxonomies
			$show_child_cat_control = in_array( $taxonomy, [ 'category', 'product_cat' ], true );
			$is_dynamic_gallery = ( 'eael-dynamic-filterable-gallery' === $this->get_name() ); // Replace with your widget name if needed

			if ( $show_child_cat_control && $is_dynamic_gallery ) {
				$this->add_control(
					$taxonomy . '_show_child_items',
					[
						'label' => __( 'Show Child Category Items', 'zyre-elementor-addons' ),
						'type' => Controls_Manager::SWITCHER,
						'label_on' => __( 'Yes', 'zyre-elementor-addons' ),
						'label_off' => __( 'No', 'zyre-elementor-addons' ),
						'return_value' => 'yes',
						'default' => 'no',
						'condition' => [
							$taxonomy . '_list!' => '',
							'query_source' => $object->object_type,
						],
					]
				);
			}
		}

		$this->add_control(
			'exclude_posts',
			[
				'label' => esc_html__( 'Exclude Posts', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'placeholder' => esc_html__( 'Search Post', 'zyre-elementor-addons' ),
				'options' => zyre_get_all_posts(),
				'condition' => [
					'query_source!' => 'manual',
				],
			]
		);

		$this->add_control(
			'show_sticky',
			[
				'label' => esc_html__( 'Ignore Sticky Posts', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'query_source!' => 'manual',
				],
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label' => esc_html__( 'Posts Per Page', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 6,
				'min' => 1,
				'max' => 96,
				'condition' => [
					'query_source!' => 'manual',
				],
			]
		);

		$this->add_control(
			'query_offset',
			[
				'label' => esc_html__( 'Offset', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0,
				'min' => 0,
				'max' => 10,
				'condition' => [
					'query_source!' => 'manual',
					'post_orderby!' => 'rand',
				],
			]
		);

		$this->add_control(
			'post_orderby',
			[
				'label' => esc_html__( 'Order By', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'ID'            => esc_html__( 'Post ID', 'zyre-elementor-addons' ),
					'author'        => esc_html__( 'Post Author', 'zyre-elementor-addons' ),
					'title'         => esc_html__( 'Title', 'zyre-elementor-addons' ),
					'date'          => esc_html__( 'Date', 'zyre-elementor-addons' ),
					'modified'      => esc_html__( 'Last Modified Date', 'zyre-elementor-addons' ),
					'parent'        => esc_html__( 'Parent Id', 'zyre-elementor-addons' ),
					'rand'          => esc_html__( 'Random', 'zyre-elementor-addons' ),
					'comment_count' => esc_html__( 'Comment Count', 'zyre-elementor-addons' ),
					'most_viewed'   => esc_html__( 'Most Viewed', 'zyre-elementor-addons' ),
					'menu_order'    => esc_html__( 'Menu Order', 'zyre-elementor-addons' ),
				],
				'condition' => [
					'query_source!' => 'manual',
				],
			]
		);

		$this->add_control(
			'post_order',
			[
				'label'   => __( 'Order', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'asc' => esc_html__( 'Ascending', 'zyre-elementor-addons' ),
					'desc' => esc_html__( 'Descending', 'zyre-elementor-addons' ),
				],
				'default' => 'desc',
				'condition' => [
					'query_source!' => 'manual',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Contents
	 */
	protected function __contents() {
		$this->start_controls_section(
			'section_contents',
			[
				'label' => esc_html__( 'Contents', 'zyre-elementor-addons' ),
			]
		);

		$this->thumbnail();

		$this->add_control(
			'heading_header_meta',
			[
				'label' => esc_html__( 'Header Meta', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->header_meta();

		$this->add_control(
			'heading_post_date',
			[
				'label' => esc_html__( 'Post Date', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->post_date();

		$this->add_control(
			'heading_title',
			[
				'label' => esc_html__( 'Title', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->title();

		$this->add_control(
			'heading_excerpt',
			[
				'label' => esc_html__( 'Excerpt', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->excerpt();

		$this->add_control(
			'heading_footer_meta',
			[
				'label' => esc_html__( 'Footer Meta', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->footer_meta();

		$this->add_control(
			'heading_read_more',
			[
				'label' => esc_html__( 'Read More', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->read_more();

		$this->add_control(
			'content_display',
			[
				'label'        => esc_html__( 'Content Display', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SELECT,
				'separator'    => 'before',
				'default'      => 'normal',
				'options'      => [
					'normal' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
					'float'  => esc_html__( 'Float', 'zyre-elementor-addons' ),
				],
				'prefix_class' => 'zyre-post-content-display-',
				'conditions'   => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'thumbnail_overlay',
							'operator' => '==',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Thumbnail
	 */
	protected function thumbnail() {
		$this->add_control(
			'show_thumbnail',
			[
				'label'        => esc_html__( 'Show Thumbnail', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( ' Yes', 'zyre-elementor-addons' ),
				'label_off'    => esc_html__( 'No', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'post_thumbnail_img',
				'exclude'   => [ 'custom' ],
				'default'   => 'medium_large',
				'condition' => [
					'show_thumbnail' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_thumbnail_link',
			[
				'label'        => esc_html__( 'Show Thumbnail Link', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( ' Yes', 'zyre-elementor-addons' ),
				'label_off'    => esc_html__( 'No', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition' => [
					'show_thumbnail' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'thumbnail_position',
			[
				'label'                => esc_html__( 'Position', 'zyre-elementor-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'left'  => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'top'   => [
						'title' => esc_html__( 'Top', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-top',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'default'              => 'top',
				'toggle'               => false,
				'selectors_dictionary' => [
					'left'  => 'display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;-ms-flex-direction:row;flex-direction:row;justify-content:space-between;',
					'top'   => 'display:block;',
					'right' => 'display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:reverse;-webkit-flex-direction:row-reverse;-ms-flex-direction:row-reverse;flex-direction:row-reverse;justify-content:space-between;',
					'bottom' => 'display:flex;-webkit-box-orient:vertical;-webkit-box-direction:reverse;-webkit-flex-direction:column-reverse;-ms-flex-direction:column-reverse;flex-direction:column-reverse;justify-content:space-between;',

				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-post-grid-item' => '{{VALUE}}',
				],
				'prefix_class'         => 'zyre-post-grid-item-thumb-dir%s-',
				'condition'            => [
					'show_thumbnail' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'thumbnail_gap',
			[
				'label'      => esc_html__( 'Spacing', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .zyre-post-grid-item' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'show_thumbnail'     => 'yes',
					'thumbnail_position' => [ 'left', 'right' ],
				],
			]
		);

		$this->add_control(
			'thumbnail_overlay',
			[
				'label'       => esc_html__( 'Overlay Contents', 'zyre-elementor-addons' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'default'     => [],
				'multiple'    => true,
				'options'     => [
					'header_meta' => esc_html__( 'Header Meta', 'zyre-elementor-addons' ),
					'post_date'   => esc_html__( 'Post Date', 'zyre-elementor-addons' ),
					'title'       => esc_html__( 'Title', 'zyre-elementor-addons' ),
					'excerpt'     => esc_html__( 'Excerpt', 'zyre-elementor-addons' ),
					'footer_meta' => esc_html__( 'Footer Meta', 'zyre-elementor-addons' ),
					'read_more'   => esc_html__( 'Read More', 'zyre-elementor-addons' ),
				],
				'condition'   => [
					'show_thumbnail' => 'yes',
				],
			]
		);

		$this->add_control(
			'_alert_thumbnail_overlay_note',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'Note: Ensure the selected items are enabled, and disable the Thumbnail Link to prevent link issues.', 'zyre-elementor-addons' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'conditions'      => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'show_thumbnail',
							'operator' => '==',
							'value'    => 'yes',
						],
						[
							'relation' => 'or',
							'terms'    => [
								[
									'name'     => 'thumbnail_overlay',
									'operator' => '!=',
									'value'    => '',
								],
							],
						],
					],
				],
			]
		);
	}

	/**
	 * Header Post Meta
	 */
	protected function header_meta() {
		$this->add_control(
			'show_header_meta',
			[
				'label'     => esc_html__( 'Show Header Meta', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'default'   => '',
			]
		);

		$this->meta_controls();
	}

	/**
	 * Post Date
	 */
	protected function post_date() {
		$this->add_control(
			'show_post_date',
			[
				'label'        => esc_html__( 'Show Post Date', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'zyre-elementor-addons' ),
				'label_off'    => esc_html__( 'No', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'post_date_format',
			[
				'label'      => esc_html__( 'Format Date', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::TEXT,
				'ai'         => false,
				'condition'   => [
					'show_post_date' => 'yes',
				],
			]
		);

		$this->add_control(
			'post_date_type',
			[
				'label'     => esc_html__( 'Date Type', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'publish',
				'options'   => [
					'publish'  => esc_html__( 'Publish', 'zyre-elementor-addons' ),
					'modified' => esc_html__( 'Modified', 'zyre-elementor-addons' ),
				],
				'condition' => [
					'show_post_date' => 'yes',
				],
			]
		);

		$this->add_control(
			'post_date_display',
			[
				'label'        => esc_html__( 'Date Display', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'normal',
				'options'      => [
					'normal' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
					'float'  => esc_html__( 'Float', 'zyre-elementor-addons' ),
				],
				'prefix_class' => 'zyre-post-date-display-',
				'conditions'      => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'show_post_date',
							'operator' => '==',
							'value'    => 'yes',
						],
						[
							'name'     => 'thumbnail_overlay',
							'operator' => 'contains',
							'value'    => 'post_date',
						],
					],
				],
			]
		);
	}

	/**
	 * Title
	 */
	protected function title() {
		$this->add_control(
			'show_title',
			[
				'label'        => esc_html__( 'Show Title', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'zyre-elementor-addons' ),
				'label_off'    => esc_html__( 'No', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'     => esc_html__( 'Title HTML Tag', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				],
				'default'   => 'h3',
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_length',
			[
				'label'     => esc_html__( 'Word Length', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);
	}

	/**
	 * Excerpt
	 */
	protected function excerpt() {
		$this->add_control(
			'show_excerpt',
			[
				'label'        => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'zyre-elementor-addons' ),
				'label_off'    => esc_html__( 'No', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'excerpt_length',
			[
				'label'       => __( 'Length', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::NUMBER,
				'condition'   => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->add_control(
			'excerpt_expanison_indicator',
			[
				'label'       => esc_html__( 'Expansion Indicator', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'ai'          => false,
				'label_block' => false,
				'default'     => esc_html__( '...', 'zyre-elementor-addons' ),
				'condition'   => [
					'show_excerpt' => 'yes',
				],
			]
		);
	}

	/**
	 * Footer Post Meta
	 */
	protected function footer_meta() {
		$this->add_control(
			'show_footer_meta',
			[
				'label'     => esc_html__( 'Show Footer Meta', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'default'   => '',
			]
		);

		$this->meta_controls( 'footer_meta' );
	}

	/**
	 * Read more
	 */
	protected function read_more() {
		$this->add_control(
			'show_read_more',
			[
				'label'     => esc_html__( 'Show Read More', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'default'   => '',
			]
		);

		$this->add_control(
			'read_more_text',
			[
				'label'     => esc_html__( 'Read More Text', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Read more', 'zyre-elementor-addons' ),
				'condition' => [
					'show_read_more' => 'yes',
				],
				'ai'   => false,
			]
		);
	}

	protected function meta_controls( $id_base = 'header_meta' ) {
		$this->add_control(
			$id_base,
			[
				'label'       => esc_html__( 'Meta Data', 'zyre-elementor-addons' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'default'     => ( 'footer_meta' === $id_base ) ? [ 'comments' ] : [ 'category', 'author' ],
				'multiple'    => true,
				'options'     => [
					'category' => esc_html__( 'Category', 'zyre-elementor-addons' ),
					'tag'      => esc_html__( 'Tags', 'zyre-elementor-addons' ),
					'author'   => esc_html__( 'Author', 'zyre-elementor-addons' ),
					'date'     => esc_html__( 'Date', 'zyre-elementor-addons' ),
					'modified' => esc_html__( 'Date Modified', 'zyre-elementor-addons' ),
					'comments' => esc_html__( 'Comments', 'zyre-elementor-addons' ),
				],
				'condition'   => [
					'show_' . $id_base => 'yes',
				],
			]
		);

		$this->add_control(
			$id_base . '_date_format',
			[
				'label'      => esc_html__( 'Format Date', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::TEXT,
				'ai'         => false,
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'show_' . $id_base,
							'operator' => '==',
							'value'    => 'yes',
						],
						[
							'relation' => 'or',
							'terms'    => [
								[
									'name'     => $id_base,
									'operator' => 'contains',
									'value'    => 'date',
								],
								[
									'name'     => $id_base,
									'operator' => 'contains',
									'value'    => 'modified',
								],
							],
						],
					],
				],
			]
		);

		$this->add_control(
			$id_base . '_author_by',
			[
				'label'     => esc_html__( 'Author Prefix', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'By', 'zyre-elementor-addons' ),
				'ai'        => false,
				'condition' => [
					'show_' . $id_base => 'yes',
					$id_base           => 'author',
				],
			]
		);

		$this->add_control(
			$id_base . '_author_avatar',
			[
				'label'     => esc_html__( 'Show Author Avatar', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'default'   => '',
				'condition' => [
					'show_' . $id_base => 'yes',
					$id_base           => 'author',
				],
			]
		);

		$this->add_control(
			$id_base . '_category_separator',
			[
				'label'     => esc_html__( 'Category Separator', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( ', ', 'zyre-elementor-addons' ),
				'ai'        => false,
				'condition' => [
					'show_' . $id_base => 'yes',
					$id_base           => 'category',
				],
			]
		);

		$this->add_control(
			$id_base . '_category_prefix',
			[
				'label'     => esc_html__( 'Category Prefix', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => [
					'show_' . $id_base => 'yes',
					$id_base           => 'category',
				],
			]
		);

		$this->add_control(
			$id_base . '_tag_separator',
			[
				'label'     => esc_html__( 'Tag Separator', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( ', ', 'zyre-elementor-addons' ),
				'ai'        => false,
				'condition' => [
					'show_' . $id_base => 'yes',
					$id_base           => 'tag',
				],
			]
		);

		$this->add_control(
			$id_base . '_tag_prefix',
			[
				'label'     => esc_html__( 'Tag Prefix', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => [
					'show_' . $id_base => 'yes',
					$id_base           => 'tag',
				],
			]
		);

		$this->add_control(
			$id_base . '_comments_icon',
			[
				'label'       => esc_html__( 'Comments Icon', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default' => [
					'value'   => 'far fa-comment-alt',
					'library' => 'fa-regular',
				],
				'condition' => [
					'show_' . $id_base => 'yes',
					$id_base           => 'comments',
				],
			]
		);

		$this->add_control(
			$id_base . '_no_comments',
			[
				'label'     => esc_html__( 'No Comments Text', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'ai'        => false,
				'condition' => [
					'show_' . $id_base => 'yes',
					$id_base           => 'comments',
				],
			]
		);

		$this->add_control(
			$id_base . '_separator',
			[
				'label'     => esc_html__( 'Meta Separator', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '',
				'ai'        => false,
				'selectors' => [
					"{{WRAPPER}} .zyre-post-{$id_base} > .zyre-post-meta-item + .zyre-post-meta-item:before" => 'content: "{{VALUE}}"',
				],
				'condition' => [
					'show_' . $id_base => 'yes',
					"{$id_base}!"      => [],
				],
			]
		);
	}

	/**
	 * Pagination - Content
	 */
	protected function __pagination() {
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
				'default'   => '',
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
					'{{WRAPPER}} .zyre-post-grid-pagination' => 'text-align: {{VALUE}};',
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
		$this->__general_style();
		$this->__post_style();
		$this->__thumbnail_style();
		$this->__thumbnail_overlay_style();
		$this->__content_overflow_style();
		$this->__header_meta_style();
		$this->__content_wrapper_style();
		$this->__content_body_style();
		$this->__date_style();
		$this->__title_style();
		$this->__excerpt_style();
		$this->__footer_meta_style();
		$this->__read_more_style();
		$this->__pagination_style();
	}

	/**
	 * Style - General
	 */
	protected function __general_style() {
		$this->start_controls_section(
			'section_general_style',
			[
				'label' => esc_html__( 'General', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'grid_gap',
			[
				'selector' => '{{WRAPPER}} .zyre-post-grid',
				'controls'  => [
					'gap' => [],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style - Post Box
	 */
	protected function __post_style() {
		$this->start_controls_section(
			'section_post_style',
			[
				'label' => esc_html__( 'Box', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'post',
			[
				'selector' => '{{WRAPPER}} .zyre-post',
				'controls' => [
					'bg_color'      => [],
					'border'        => [],
					'border_radius' => [],
					'box_shadow'    => [],
					'padding'       => [],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style - Thumbnail
	 */
	protected function __thumbnail_style() {
		$this->start_controls_section(
			'section_thumbnail_style',
			[
				'label' => esc_html__( 'Thumbnail', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_thumbnail' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'thumbnail',
			[
				'selector' => '{{WRAPPER}} .zyre-post-thumbnail img',
				'controls' => [
					'width'         => [
						'selector' => '{{WRAPPER}} .zyre-post-thumbnail',
					],
					'height'        => [
						'default' => [
							'unit' => 'px',
							'size' => 305,
						],
					],
					'object_fit'    => [
						'default' => 'cover',
					],
					'border'        => [],
					'border_radius' => [],
					'padding'       => [],
					'space'         => [
						'label'        => esc_html__( 'Margin Bottom', 'zyre-elementor-addons' ),
						'selector'     => '{{WRAPPER}} .zyre-post > .zyre-post-thumbnail-link, {{WRAPPER}} .zyre-post > .zyre-post-thumbnail',
						'css_property' => 'margin-bottom',
						'condition'    => [
							'thumbnail_position' => 'top',
						],
					],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style - Thumbnail Overlay
	 */
	protected function __thumbnail_overlay_style() {
		$this->start_controls_section(
			'section_thumbnail_overlay_style',
			[
				'label'      => esc_html__( 'Thumbnail Overlay', 'zyre-elementor-addons' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'show_thumbnail',
							'operator' => '==',
							'value'    => 'yes',
						],
						[
							'relation' => 'or',
							'terms'    => [
								[
									'name'     => 'thumbnail_overlay',
									'operator' => '!=',
									'value'    => '',
								],
							],
						],
					],
				],
			]
		);

		$this->set_style_controls(
			'thumbnail_overlay',
			[
				'selector' => '{{WRAPPER}} .zyre-post-thumbnail-overlay',
				'controls' => [
					'bg'            => [],
					'padding'       => [],
					'border_radius' => [],
					'align_y'       => [
						'css_property' => 'align-content',
					],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style - Content Float
	 */
	protected function __content_overflow_style() {
		$this->start_controls_section(
			'section_content_overflow_style',
			[
				'label' => esc_html__( 'Content Float', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'content_display' => 'float',
				],
			]
		);

		$this->set_style_controls(
			'content_overflow',
			[
				'selector' => '{{WRAPPER}}.zyre-post-content-display-float .zyre-post-content',
				'controls' => [
					'height'   => [
						'selector' => '{{WRAPPER}}.zyre-post-content-display-float .zyre-post,
								{{WRAPPER}}.zyre-post-content-display-float .zyre-post-thumbnail img',
					],
					'bg_color' => [],
					'padding'  => [],
					'align_y'  => [
						'css_property' => 'align-content',
					],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style - Header Meta
	 */
	protected function __header_meta_style() {
		$this->start_controls_section(
			'section_header_meta_style',
			[
				'label' => esc_html__( 'Header Meta', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_header_meta' => 'yes',
				],
			]
		);

		$this->post_meta_style();

		$this->end_controls_section();
	}

	/**
	 * Style - Content Wrapper
	 */
	protected function __content_wrapper_style() {
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content Wrapper', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'content',
			[
				'selector' => '{{WRAPPER}} .zyre-post-content',
				'controls' => [
					'width'         => [
						'condition' => [
							'thumbnail_position' => [ 'left', 'right' ],
						],
					],
					'bg_color'      => [],
					'border'        => [],
					'border_radius' => [],
					'box_shadow'    => [],
					'padding'       => [],
					'margin'        => [],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style - Content Body
	 */
	protected function __content_body_style() {
		$this->start_controls_section(
			'section_content_body_style',
			[
				'label' => esc_html__( 'Content Body', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'content_body',
			[
				'selector' => '{{WRAPPER}} .zyre-post-content-body',
				'controls' => [
					'padding'       => [],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style - Post Date
	 */
	protected function __date_style() {
		$this->start_controls_section(
			'section_post_date_style',
			[
				'label' => esc_html__( 'Date', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_post_date' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'post_date',
			[
				'selector' => '{{WRAPPER}} .zyre-post-date:not(.zyre-post-meta-item)',
				'controls' => [
					'typography'    => [],
					'color'         => [],
					'border'        => [],
					'border_radius' => [],
					'padding'       => [],
					'align'         => [],
					'space'      => [
						'label'        => esc_html__( 'Margin Bottom', 'zyre-elementor-addons' ),
						'css_property' => 'margin-bottom',
					],
				],
			]
		);

		$this->set_style_controls(
			'post_date',
			[
				'selector'  => '{{WRAPPER}}.zyre-post-date-display-float .zyre-post-date:not(.zyre-post-meta-item)',
				'controls'  => [
					'width'      => [],
					'offset_x'   => [
						'css_property' => is_rtl() ? 'right' : 'left',
						'range'        => [
							'%'  => [
								'min' => 0,
							],
							'px' => [
								'min' => 0,
								'max' => 500,
							],
							'vw' => [
								'min' => 0,
							],
						],
					],
					'offset_y'   => [
						'css_property' => 'top',
						'range'        => [
							'%'  => [
								'min' => 0,
							],
							'px' => [
								'min' => 0,
								'max' => 500,
							],
							'vh' => [
								'min' => 0,
							],
						],
					],
					'bg_color'   => [],
					'box_shadow' => [],
				],
				'condition' => [
					'post_date_display' => 'float',
				],
			]
		);

		// HTML b Tag/Element
		$this->add_control(
			'post_date_b_heading',
			[
				'label' => esc_html__( 'HTML b Tag/Element', 'zyre-elementor-addons' ),
				'type'  => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'post_date_b_desc',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw'  => esc_html__( 'Make sure you have added HTML b Tags in "Format Date" input. e.g. <b>d</b> M Y', 'zyre-elementor-addons' ),
				'content_classes' => 'elementor-descriptor',
			]
		);

		$this->set_style_controls(
			'post_date_b',
			[
				'selector' => '{{WRAPPER}} .zyre-post-date:not(.zyre-post-meta-item) b',
				'controls' => [
					'typography' => [],
					'color'      => [],
					'layout'     => [
						'label'                => __( 'Display Type', 'zyre-elementor-addons' ),
						'options'              => [
							'block'  => [
								'title' => esc_html__( 'Block', 'zyre-elementor-addons' ),
								'icon'  => 'eicon-ellipsis-v',
							],
							'inline' => [
								'title' => esc_html__( 'Inline', 'zyre-elementor-addons' ),
								'icon'  => 'eicon-ellipsis-h',
							],
						],
						'default'              => 'block',
						'tablet_default'       => 'block',
						'mobile_default'       => 'block',
						'selectors_dictionary' => [
							'inline' => 'display:inline;',
							'block'  => 'display:block;',
						],
					],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style - Post Title
	 */
	protected function __title_style() {
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'post_title',
			[
				'selector' => '{{WRAPPER}} .zyre-post-title',
				'controls' => [
					'typography' => [],
					'border'     => [],
					'padding'    => [],
					'align'      => [],
					'space'      => [
						'label'        => esc_html__( 'Margin Bottom', 'zyre-elementor-addons' ),
						'css_property' => 'margin-bottom',
					],
				],
			]
		);

		$this->set_style_controls(
			'post_title_link',
			[
				'selector' => '{{WRAPPER}} .zyre-post-title a',
				'controls' => [
					'color' => [],
				],
			]
		);

		$this->set_style_controls(
			'post_title_link_hover',
			[
				'selector' => '{{WRAPPER}} .zyre-post-title a:hover',
				'controls' => [
					'color' => [
						'label' => esc_html__( 'Hover Color', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style - Excerpt
	 */
	protected function __excerpt_style() {
		$this->start_controls_section(
			'section_excerpt_style',
			[
				'label' => esc_html__( 'Excerpt', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'post_excerpt',
			[
				'selector' => '{{WRAPPER}} .zyre-post-excerpt',
				'controls' => [
					'typography' => [],
					'color'      => [],
					'border'     => [],
					'padding'    => [],
					'align'      => [],
					'space'      => [
						'label'        => esc_html__( 'Margin Bottom', 'zyre-elementor-addons' ),
						'css_property' => 'margin-bottom',
					],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style - Footer Meta
	 */
	protected function __footer_meta_style() {
		$this->start_controls_section(
			'section_footer_meta_style',
			[
				'label' => esc_html__( 'Footer Meta', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_footer_meta' => 'yes',
				],
			]
		);

		$this->post_meta_style( 'footer_meta' );

		$this->end_controls_section();
	}

	/**
	 * Style - Read More
	 */
	protected function __read_more_style() {
		$this->start_controls_section(
			'section_read_more_style',
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
				'selector' => '{{WRAPPER}} .zyre-post-readmore-link',
				'controls' => [
					'typography'    => [],
					'padding'       => [],
					'border'        => [],
					'border_radius' => [],
					'margin'        => [
						'selector' => '{{WRAPPER}} .zyre-post-readmore',
					],
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
				'selector' => '{{WRAPPER}} .zyre-post-readmore-link',
				'controls' => [
					'color' => [],
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
				'selector' => '{{WRAPPER}} .zyre-post-readmore-link:hover',
				'controls' => [
					'color' => [],
					'bg_color' => [],
					'border_color' => [],
				],
			],
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->set_style_controls(
			'read_more_hrline',
			[
				'selector' => '{{WRAPPER}} .zyre-post-readmore-hrline',
				'controls' => [
					'heading' => [
						'label'     => esc_html__( 'Horizontal Line', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
					'switch'  => [
						'label' => esc_html__( 'Show Horizontal Line', 'zyre-elementor-addons' ),
					],
					'gap'     => [
						'label'     => esc_html__( 'Space Between', 'zyre-elementor-addons' ),
						'selector'  => '{{WRAPPER}} .zyre-post-readmore',
						'condition' => [
							'read_more_hrline_switch' => 'yes',
						],
					],
					'border'  => [
						'condition' => [
							'read_more_hrline_switch' => 'yes',
						],
					],
					'margin'  => [
						'condition' => [
							'read_more_hrline_switch' => 'yes',
						],
					],
				],
			],
		);

		$this->end_controls_section();
	}

	protected function post_meta_style( $id_base = 'header_meta' ) {
		$controls_args = [
			'typography' => [
				'selector' => "{{WRAPPER}} .zyre-post-{$id_base} .zyre-post-meta-item",
			],
			'color'      => [],
			'icon_color' => [
				'selector'  => "{{WRAPPER}} .zyre-post-{$id_base} .zyre-post-meta-item",
				'condition' => [
					$id_base                            => 'comments',
					$id_base . '_comments_icon[value]!' => '',
				],
			],
			'icon_size'  => [
				'selector'  => "{{WRAPPER}} .zyre-post-{$id_base} .zyre-post-meta-icon",
				'condition' => [
					$id_base                            => 'comments',
					$id_base . '_comments_icon[value]!' => '',
				],
			],
			'spacing'    => [
				'label'        => esc_html__( 'Icon Spacing', 'zyre-elementor-addons' ),
				'selector'     => "{{WRAPPER}} .zyre-post-{$id_base} .zyre-post-meta-icon",
				'css_property' => 'margin-inline-end',
				'condition'    => [
					$id_base                            => 'comments',
					$id_base . '_comments_icon[value]!' => '',
				],
			],
			'border'     => [],
			'padding'    => [],
			'gap'        => [
				'condition' => [
					$id_base . '_separator' => '',
				],
			],
			'space'      => [
				'label'        => esc_html__( 'Margin Bottom', 'zyre-elementor-addons' ),
				'css_property' => 'margin-bottom',
			],
			'align'      => [],
			'align_x'    => [
				'options' => [
					'flex-start'    => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-justify-start-h',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-justify-center-h',
					],
					'flex-end' => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-justify-end-h',
					],
				],
			],
		];

		if ( 'header_meta' === $id_base ) {
			$controls_args['space'] = [
				'label'        => esc_html__( 'Margin Bottom', 'zyre-elementor-addons' ),
				'css_property' => 'margin-bottom',
			];
		}

		$this->set_style_controls(
			$id_base,
			[
				'selector' => '{{WRAPPER}} .zyre-post-' . $id_base,
				'controls' => $controls_args,
			]
		);

		$this->set_style_controls(
			$id_base . '_avatar',
			[
				'selector'  => "{{WRAPPER}} .zyre-post-{$id_base} .zyre-post-author-avatar img",
				'controls'  => [
					'heading'       => [
						'label'     => esc_html__( 'Avatar', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
					'width_height'  => [],
					'border_radius' => [],
					'space'         => [
						'selector'     => "{{WRAPPER}} .zyre-post-{$id_base} .zyre-post-author-avatar",
						'css_property' => 'margin-inline-end',
					],
				],
				'condition' => [
					$id_base . '_author_avatar' => 'yes',
					$id_base                    => 'author',
				],
			]
		);

		$this->set_style_controls(
			$id_base . '_prefix',
			[
				'selector' => "{{WRAPPER}} .zyre-post-{$id_base} .zyre-post-categories-prefix,
										{{WRAPPER}} .zyre-post-{$id_base} .zyre-post-tags-prefix,
										{{WRAPPER}} .zyre-post-{$id_base} .zyre-post-author-by",
				'controls' => [
					'heading'    => [
						'label'     => esc_html__( 'Prefix', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
					'typography' => [],
					'color'      => [],
					'space'         => [
						'css_property' => 'margin-inline-end',
					],
				],
			]
		);

		$this->set_style_controls(
			$id_base . '_separator',
			[
				'selector'  => "{{WRAPPER}} .zyre-post-{$id_base} > .zyre-post-meta-item + .zyre-post-meta-item:before",
				'controls'  => [
					'heading' => [
						'label'     => esc_html__( 'Separator', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
					'color'   => [],
					'margin'  => [],
				],
				'condition' => [
					$id_base . '_separator!' => '',
				],
			]
		);

		$this->set_style_controls(
			$id_base . '_link',
			[
				'selector' => "{{WRAPPER}} .zyre-post-{$id_base} .zyre-post-meta-item a",
				'controls' => [
					'heading' => [
						'label'     => esc_html__( 'Link Colors', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
					'color'   => [],
				],
			]
		);

		$this->set_style_controls(
			$id_base . '_link_hover',
			[
				'selector' => "{{WRAPPER}} .zyre-post-{$id_base} .zyre-post-meta-item a:hover",
				'controls' => [
					'color' => [
						'label' => esc_html__( 'Hover Color', 'zyre-elementor-addons' ),
					],
				],
			]
		);
	}

	/**
	 * Pagination - Style
	 */
	protected function __pagination_style() {
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
				'selector' => '{{WRAPPER}} .zyre-post-grid-pagination',
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
				'selector' => '{{WRAPPER}} .zyre-post-grid-pagination .page-numbers',
				'controls' => [
					'heading'       => [
						'label'     => esc_html__( 'Page Numbers', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
					'typography'    => [],
					'padding'       => [],
					'border'        => [],
					'border_radius' => [],
					'margin'        => [
						'selector' => '{{WRAPPER}} .zyre-post-grid-pagination .page-numbers:not(:last-child)',
					],
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
				'selector' => '{{WRAPPER}} .zyre-post-grid-pagination .page-numbers',
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
				'selector' => '{{WRAPPER}} .zyre-post-grid-pagination .page-numbers:not(.current):hover',
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
				'selector' => '{{WRAPPER}} .zyre-post-grid-pagination .page-numbers.current',
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

		// Determine if sticky posts should be ignored
		$ignore_sticky = ( 'yes' === $this->settings['show_sticky'] );

		// Set post type
		$post_type = ! empty( $this->settings['query_source'] ) ? $this->settings['query_source'] : 'post';
		if ( 'manual' === $this->settings['query_source'] ) {
			$post_type = 'any';
			$ignore_sticky = true;
		}

		$query_args = [
			'post_type'           => $post_type,
			'post_status'         => 'publish',
			'posts_per_page'      => $this->settings['posts_per_page'],
			'ignore_sticky_posts' => $ignore_sticky,
			'offset'              => $this->settings['query_offset'],
			'orderby'             => $this->settings['post_orderby'],
			'order'               => $this->settings['post_order'],
		];

		// Add manual includes
		if ( ! empty( $this->settings['choose_posts'] ) ) {
			$query_args['post__in'] = array_map( 'intval', (array) $this->settings['choose_posts'] );
		}

		if ( ! empty( $this->settings['exclude_posts'] ) ) {
			$query_args['post__not_in'] = array_map( 'intval', (array) $this->settings['exclude_posts'] );
		}

		if ( ! empty( $this->settings['author_list'] ) ) {
			$query_args['author__in'] = array_map( 'intval', (array) $this->settings['author_list'] );
		}

		// Add dynamic taxonomy filters here (from the loop above)
		$tax_query = [];
		$taxonomies = get_taxonomies( [ 'public' => true ], 'objects' );
		foreach ( $taxonomies as $taxonomy => $object ) {
			$field_key = $taxonomy . '_list';

			if ( ! empty( $this->settings[ $field_key ] ) ) {
				$term_ids = array_map( 'intval', (array) $this->settings[ $field_key ] );

				$tax_query[] = [
					'taxonomy' => $taxonomy,
					'field'    => 'term_id',
					'terms'    => $term_ids,
					'operator' => 'IN',
				];
			}
		}
		if ( ! empty( $tax_query ) ) {
			$query_args['tax_query'] = [
				'relation' => 'AND',
				...$tax_query,
			];
		}

		// Final query
		$the_query = new \WP_Query( $query_args );

		if ( $the_query->have_posts() ) {
			echo '<div class="zyre-post-grid zy-grid zy-gap-x-6 zy-gap-y-6 zy-grid-columns-3">';
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$this->render_post_loop();
			}
			wp_reset_postdata();
			echo '</div>';
			$this->render_pagination( $the_query, $this->settings );
		} else {
			echo '<div class="zyre-no-posts">' . esc_html( $this->settings['nothing_found_message'] ) . '</div>';
		}
	}

	protected function render_thumbnail() {

		if ( 'yes' !== $this->settings['show_thumbnail'] || ! has_post_thumbnail() ) {
			return;
		}

		if ( 'yes' === $this->settings['show_thumbnail_link'] ) {
			printf(
				'<a href="%1$s" class="zyre-post-thumbnail-link zy-block"><div class="zyre-post-thumbnail zy-relative zy-overflow-hidden zy-overflow-y-auto">%2$s%3$s</div></a>',
				esc_url( get_the_permalink() ),
				get_the_post_thumbnail(
					get_the_ID(),
					$this->settings['post_thumbnail_img_size'],
					[
						'class' => 'zy-w-100',
					]
				),
				! empty( $this->settings['thumbnail_overlay'] ) ? sprintf(
					'<div class="zyre-post-thumbnail-overlay zy-absolute zy-left-0 zy-top-0 zy-w-100 zy-h-100 zy-index-1 zy-content-end">%s</div>',
					$this->thumbnail_overlay_contents( $this->settings['thumbnail_overlay'] ),
				) : '',
			);
		} else {
			?>
			<div class="zyre-post-thumbnail zy-relative zy-overflow-hidden zy-overflow-y-auto">
				<?php
				the_post_thumbnail( $this->settings['post_thumbnail_img_size'], [ 'class' => 'zy-w-100' ] );
				if ( ! empty( $this->settings['thumbnail_overlay'] ) ) {
					?>
					<div class="zyre-post-thumbnail-overlay zy-absolute zy-left-0 zy-top-0 zy-w-100 zy-h-100 zy-index-1 zy-content-end">
						<?php echo $this->thumbnail_overlay_contents( $this->settings['thumbnail_overlay'] ); ?>
					</div>
					<?php
				}
				?>
			</div>
			<?php
		}
	}

	protected function thumbnail_overlay_contents( $contents ) {
		ob_start();

		if ( in_array( 'header_meta', $contents, true ) ) {
			$this->render_meta_data( 'header_meta' );
		}

		if ( in_array( 'post_date', $contents, true ) ) {
			$this->render_post_date();
		}

		if ( in_array( 'title', $contents, true ) ) {
			$this->render_title();
		}

		if ( in_array( 'excerpt', $contents, true ) ) {
			$this->render_excerpt();
		}

		if ( in_array( 'footer_meta', $contents, true ) ) {
			$this->render_meta_data( 'footer_meta' );
		}

		if ( in_array( 'read_more', $contents, true ) ) {
			$this->render_read_more();
		}

		return ob_get_clean();
	}

	protected function render_post_date() {
		if ( 'yes' !== $this->settings['show_post_date'] ) {
			return;
		}

		$date_format = ! empty( $this->settings['post_date_format'] ) ? $this->settings['post_date_format'] : '';
		$date_type = 'publish';
		if ( ! empty( $this->settings['post_date_type'] ) && in_array( $this->settings['post_date_type'], [ 'publish', 'modified' ] ) ) {
			$date_type = $this->settings['post_date_type'];
		}
		$this->render_date_by_type( $date_type, $date_format, false );
	}

	protected function render_title() {
		if ( 'yes' !== $this->settings['show_title'] ) {
			return;
		}
		?>
		<<?php echo zyre_escape_tags( $this->settings['title_tag'], 'h3' ); ?> class="zyre-post-title zy-m-0">
			<a href="<?php echo esc_url( get_the_permalink() ); ?>">
				<?php
				if ( empty( $this->settings['title_length'] ) ) {
					echo esc_html( get_the_title() );
				} else {
					echo wp_kses( implode( ' ', array_slice( explode( ' ', get_the_title() ), 0, $this->settings['title_length'] ) ), zyre_get_allowed_html() );
				}
				?>
			</a>
		</<?php echo zyre_escape_tags( $this->settings['title_tag'], 'h3' ); ?>>
		<?php
	}

	protected function render_excerpt() {

		if ( 'yes' !== $this->settings['show_excerpt'] ) {
			return;
		}

		$excerpt_length = ! empty( $this->settings['excerpt_length'] ) ? (int) $this->settings['excerpt_length'] : 20;
		$excerpt_more   = ! empty( $this->settings['excerpt_expanison_indicator'] ) ? $this->settings['excerpt_expanison_indicator'] : '';

		$excerpt = get_the_excerpt();
		$excerpt = wp_trim_words( $excerpt, $excerpt_length, $excerpt_more );

		if ( $excerpt ) : ?>
			<p class="zyre-post-excerpt zy-m-0"><?php echo zyre_kses_basic( $excerpt ); ?></p>
		<?php endif;
	}

	protected function render_meta_data( $type = 'header_meta' ) {
		$meta_data = $this->settings[ $type ];
		$meta_show_key = 'show_' . $type;
		if ( 'yes' !== $this->settings[ $meta_show_key ] || empty( $meta_data ) ) {
			return;
		}
		?>
		<div class="zyre-post-<?php echo esc_attr( $type ); ?> zy-flex zy-flex-wrap zy-align-center">
			<?php
			if ( in_array( 'category', $meta_data ) ) {
				$this->render_category( $type );
			}

			if ( in_array( 'tag', $meta_data ) ) {
				$this->render_tag( $type );
			}

			if ( in_array( 'author', $meta_data ) ) {
				$this->render_author( $type );
			}

			if ( in_array( 'date', $meta_data ) ) {
				$date_format_key = $type . '_date_format';
				$date_format = ! empty( $this->settings[ $date_format_key ] ) ? $this->settings[ $date_format_key ] : '';
				$this->render_date_by_type( 'publish', $date_format );
			}

			if ( in_array( 'modified', $meta_data ) ) {
				$this->render_date_by_type( 'modified' );
			}

			if ( in_array( 'comments', $meta_data ) ) {
				$this->render_comments( $type );
			}
			?>
		</div>
		<?php
	}

	protected function render_author( $type ) {
		$author_key = $type . '_author';
		$this->set_render_attribute(
			$author_key,
			[
				'class' => 'zyre-post-meta-item zyre-post-author',
			]
		);
		?>
		<span <?php $this->print_render_attribute_string( $author_key ); ?>>
			<?php
			if ( is_rtl() ) {
				the_author();
				$this->render_avatar( $type );
				$this->render_author_by( $type );
			} else {
				$this->render_author_by( $type );
				$this->render_avatar( $type );
				the_author();
			}
			?>
		</span>
		<?php
	}

	protected function render_author_by( $type ) {
		$author_by_key = $type . '_author_by';
		if ( empty( $this->settings[ $author_by_key ] ) ) {
			return;
		}

		?>
		<span class="zyre-post-author-by"><?php echo esc_html( $this->settings[ $author_by_key ] ); ?></span>
		<?php
	}

	protected function render_avatar( $type ) {
		if ( 'yes' !== $this->settings[ $type . '_author_avatar' ] ) {
			return;
		}

		$user_id = get_post_field( 'post_author', get_the_ID() );
		?>
		<span class="zyre-post-author-avatar">
			<?php echo get_avatar( $user_id, 32 ); ?>
		</span>
		<?php
	}

	protected function render_date_by_type( $type = 'publish', $date_format = '', $in_meta = true ) {
		echo $in_meta ? '<span class="zyre-post-meta-item zyre-post-date">' : '<div class="zyre-post-date">';

		switch ( $type ) :
			case 'modified':
				$date = get_the_modified_date( $date_format );
				break;
			default:
				$date = get_the_date( $date_format );
		endswitch;

		/** This filter is documented in wp-includes/general-template.php */
		// PHPCS - The date is safe.
		echo apply_filters( 'the_date', $date, get_option( 'date_format' ), '', '' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		echo $in_meta ? '</span>' : '</div>';
	}

	protected function render_comments( $type ) {
		?>
		<span class="zyre-post-meta-item zyre-post-comments zy-inline-flex zy-align-center">
			<?php
			$comments_icon_key = $type . '_comments_icon';
			if ( '' !== $this->settings[ $comments_icon_key ]['value'] ) : ?>
				<span class="zyre-post-comments-icon zyre-post-meta-icon zy-mie-2">
					<?php zyre_render_icon( $this->settings, 'icon', $comments_icon_key ); ?>
				</span>
			<?php endif; ?>

			<?php
			$no_comments_key = $type . '_no_comments';
			comments_number( isset( $this->settings[ $no_comments_key ] ) && '' !== $this->settings[ $no_comments_key ] ? esc_html( $this->settings[ $no_comments_key ] ) : false ); ?>
		</span>
		<?php
	}

	protected function render_category( $type ) {
		if ( has_category() ) {
			$categories = get_the_category();

			if ( ! empty( $categories ) ) {
				$category_separator_key = $type . '_category_separator';
				$category_prefix_key = $type . '_category_prefix';
				$category_separator = ! empty( $this->settings[ $category_separator_key ] ) ? esc_html( $this->settings[ $category_separator_key ] ) : '';
				$category_prefix = '';
				$names = [];

				echo '<span class="zyre-post-meta-item zyre-post-categories">';

				if ( ! empty( $this->settings[ $category_prefix_key ] ) ) {
					$category_prefix = '<span class="zyre-post-categories-prefix">' . esc_html( $this->settings[ $category_prefix_key ] ) . '</span> ';
				}

				if ( ! is_rtl() ) {
					echo $category_prefix;
				}

				foreach ( $categories as $category ) {
					$names[] = '<a class="zyre-post-category-link" href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>';
				}

				echo implode( $category_separator, $names );

				if ( is_rtl() ) {
					echo $category_prefix;
				}

				echo '</span>';
			}
		}
	}

	protected function render_tag( $type ) {
		if ( has_tag() ) {

			$tags = get_the_tags();

			if ( ! empty( $tags ) ) {
				$tag_separator_key = $type . '_tag_separator';
				$tag_prefix_key = $type . '_tag_prefix';
				$tag_separator = ! empty( $this->settings[ $tag_separator_key ] ) ? esc_html( $this->settings[ $tag_separator_key ] ) : '';
				$tag_prefix = '';
				$names = [];

				echo '<span class="zyre-post-meta-item zyre-post-tags">';

				if ( ! empty( $this->settings[ $tag_prefix_key ] ) ) {
					$tag_prefix = '<span class="zyre-post-tags-prefix">' . esc_html( $this->settings[ $tag_prefix_key ] ) . '</span> ';
				}

				if ( ! is_rtl() ) {
					echo $tag_prefix;
				}

				foreach ( $tags as $tag ) {
					$names[] = '<a class="zyre-post-tag-link" href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" >' . esc_html( $tag->name ) . '</a>';
				}

				echo implode( $tag_separator, $names );

				if ( is_rtl() ) {
					echo $tag_prefix;
				}

				echo '</span>';
			}
		}
	}

	protected function render_read_more() {
		$show_read_more = $this->settings['show_read_more'];
		$read_more_text = $this->settings['read_more_text'];

		if ( 'yes' === $show_read_more && ! empty( $read_more_text ) ) {
			printf(
				'<div class="zyre-post-readmore zy-w-100 zy-flex zy-align-center zy-gap-2"><a class="%1$s" href="%2$s">%3$s</a>%4$s</div>',
				'zyre-post-readmore-link zy-inline-block zy-transition',
				esc_url( get_the_permalink( get_the_ID() ) ),
				esc_html( $read_more_text ),
				( 'yes' === $this->settings['read_more_hrline_switch'] ) ? '<span class="zyre-post-readmore-hrline zy-grow-1 zy-border-t-1"></span>' : '',
			);
		}
	}

	protected function render_post_body_before() {
		echo '<div class="zyre-post-content-body">';
	}

	protected function render_post_body_after() {
		echo '</div>';
	}

	/**
	 * Post Loop Show
	 */
	protected function render_post_loop() {
		$this->add_render_attribute( 'posts', 'class', [
			'zyre-post zyre-post-grid-item zy-overflow-hidden zy-relative',
			'post-' . get_the_ID(),
			'type-' . get_post_type(),
			'status-' . get_post_status(),
		], true );

		$thumbnail_overlay = ! empty( $this->settings['thumbnail_overlay'] ) ? $this->settings['thumbnail_overlay'] : [];
		?>
		<article <?php $this->print_render_attribute_string( 'posts' ); ?>>
			<?php $this->render_thumbnail(); ?>
			<div class="zyre-post-content zy-relative">
				<?php

				if( ! in_array( 'header_meta', $thumbnail_overlay, true ) ) {
					$this->render_meta_data( 'header_meta' );
				}

				$this->render_post_body_before();
	
				if ( ! in_array( 'post_date', $thumbnail_overlay, true ) ) {
					$this->render_post_date();
				}

				if ( ! in_array( 'title', $thumbnail_overlay, true ) ) {
					$this->render_title();
				}

				if ( ! in_array( 'excerpt', $thumbnail_overlay, true ) ) {
					$this->render_excerpt();
				}
				
				$this->render_post_body_after();

				if ( ! in_array( 'footer_meta', $thumbnail_overlay, true ) ) {
					$this->render_meta_data( 'footer_meta' );
				}

				if ( ! in_array( 'read_more', $thumbnail_overlay, true ) ) {
					$this->render_read_more();
				}
				?>
			</div>
		</article>
		<?php
	}

	/**
	 * Display pagination
	 */
	public function render_pagination( $the_query, $settings ) {
		if ( 'yes' !== $settings['pagination_show'] ) {
			return;
		}

		$total   = isset( $the_query->max_num_pages ) ? $the_query->max_num_pages : 1;
		$paged = intval( isset( $the_query->query['paged'] ) ? $the_query->query['paged'] : max( 1, get_query_var( 'paged' ) ) );

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
				'prev_text' => $settings['pagination_prev_label'],
				'next_text' => $settings['pagination_next_label'],
			]
		);

		if ( ! empty( $html ) ) {
			printf(
				'<div class="zyre-post-grid-pagination">%s</div>',
				wp_kses( $html, zyre_get_allowed_html( 'advanced' ) )
			);
		}
	}
}
