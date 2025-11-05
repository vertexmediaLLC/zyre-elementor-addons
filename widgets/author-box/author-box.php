<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Author_Box extends Base {
	/**
	 * Widget Name
	 */
	public function get_title() {
		return esc_html__( 'Author Box', 'zyre-elementor-addons' );
	}

	/**
	 * Widget Icon
	 */
	public function get_icon() {
		return 'zy-fonticon zy-Author-Box';
	}

	/**
	 * Widget search keywords
	 */
	public function get_keywords() {
		return [ 'author box', 'author meta', 'author', 'author description', 'author details', 'author name', 'author info', 'author link', 'author bio', 'bio' ];
	}

	/**
	 * Register widget content controls
	 */
	protected function register_content_controls() {
		$this->start_controls_section(
			'section_author_box_content',
			[
				'label' => esc_html__( 'Author Box', 'zyre-elementor-addons' ),
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		// Grid Layout
		$this->add_control(
			'grid_layout__heading',
			[
				'label'        => esc_html__( 'Grid Layout', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'enable_grid',
			[
				'label'        => esc_html__( 'Enable Grid', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
			]
		);

		$this->add_responsive_control(
			'grid_columns',
			[
				'label' => esc_html__( 'Grid Columns', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'selectors' => [
					'{{WRAPPER}} .zyre-author-box' => '--grid-columns: {{VALUE}};',
				],
				'condition' => [
					'enable_grid' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'grid_gap',
			[
				'label'      => esc_html__( 'Gap', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', '%', 'custom'],
				'selectors'  => [
					'{{WRAPPER}} .zyre-author-box' => 'gap: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'enable_grid' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'grid_align_y',
			[
				'label'     => esc_html__( 'Vertical Align', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'start'  => [
						'label' => esc_html__( 'Top', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-top',
					],
					'center' => [
						'label' => esc_html__( 'Middle', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'end'    => [
						'label' => esc_html__( 'Bottom', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-author-box' => 'align-items: {{VALUE}};',
				],
				'condition' => [
					'enable_grid' => 'yes',
				],
			]
		);

		// Avatar
		$this->add_control(
			'avatar__heading',
			[
				'label'        => esc_html__( 'Avatar', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::HEADING,
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'show_avatar',
			[
				'label'        => esc_html__( 'Show Avatar', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'avatar_size',
			[
				'label' => esc_html__( 'Avatar Size', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 500,
				'step' => 1,
				'default' => 96,
				'condition' => [
					'show_avatar' => 'yes',
				],
			]
		);

		$this->add_control(
			'avatar_link',
			[
				'label'        => esc_html__( 'Enable Avatar Link', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
				'condition' => [
					'show_avatar' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'avatar_direction',
			[
				'label'                => esc_html__( 'Avatar Direction', 'zyre-elementor-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'left'   => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
					'top'    => [
						'title' => esc_html__( 'Top', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-top',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'default'              => 'left',
				'tablet_default'       => 'left',
				'mobile_default'       => 'left',
				'prefix_class'         => 'zyre-author-box-avatar%s-dir-',
				'selectors_dictionary' => [
					'left'   => 'flex-wrap: nowrap;flex-direction: row;--info-width: auto;',
					'right'  => 'flex-wrap: nowrap;flex-direction: row-reverse;--info-width: auto;',
					'top'    => 'flex-wrap: wrap;flex-direction: column;--info-width: 100%;',
					'bottom' => 'flex-wrap: wrap;flex-direction: column-reverse;--info-width: 100%;',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-author-box' => '{{VALUE}};',
				],
				'style_transfer'       => true,
				'condition'            => [
					'show_avatar' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'avatar_position',
			[
				'label'                => esc_html__( 'Avatar Position', 'zyre-elementor-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'top'    => [
						'title' => esc_html__( 'Top', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'default'              => 'center',
				'tablet_default'       => 'center',
				'mobile_default'       => 'center',
				'selectors_dictionary' => [
					'top'    => 'align-self: flex-start;',
					'center' => 'align-self: center;',
					'bottom' => 'align-self: flex-end;',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-author-img' => '{{VALUE}}',
				],
				'condition'            => [
					'show_avatar' => 'yes',
				],
			]
		);

		$this->add_grid_layout( 'avatar', '{{WRAPPER}} .zyre-author-img', [ 'show_avatar' => 'yes' ] );

		// Author
		$this->add_control(
			'author__heading',
			[
				'label'        => esc_html__( 'Author', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::HEADING,
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'show_author',
			[
				'label'        => esc_html__( 'Show Author Name', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'author_link',
			[
				'label'        => esc_html__( 'Enable Author Link', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
				'condition' => [
					'show_author' => 'yes',
				],
			]
		);

		$this->add_control(
			'author_meta_tag',
			[
				'label' => esc_html__( 'Author Name Tag', 'zyre-elementor-addons' ),
				'label_block' => true,
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'h1'  => [
						'title' => esc_html__( 'H1', 'zyre-elementor-addons' ),
						'icon' => 'eicon-editor-h1',
					],
					'h2'  => [
						'title' => esc_html__( 'H2', 'zyre-elementor-addons' ),
						'icon' => 'eicon-editor-h2',
					],
					'h3'  => [
						'title' => esc_html__( 'H3', 'zyre-elementor-addons' ),
						'icon' => 'eicon-editor-h3',
					],
					'h4'  => [
						'title' => esc_html__( 'H4', 'zyre-elementor-addons' ),
						'icon' => 'eicon-editor-h4',
					],
					'h5'  => [
						'title' => esc_html__( 'H5', 'zyre-elementor-addons' ),
						'icon' => 'eicon-editor-h5',
					],
					'h6'  => [
						'title' => esc_html__( 'H6', 'zyre-elementor-addons' ),
						'icon' => 'eicon-editor-h6',
					],
				],
				'default' => 'h4',
				'toggle' => false,
				'condition' => [
					'show_author' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_username',
			[
				'label'        => esc_html__( 'Show Username', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
			]
		);

		$this->add_grid_layout( 'author', '{{WRAPPER}} .zyre-author-user-name', [ 'show_author' => 'yes' ] );

		// Bio
		$this->add_control(
			'bio__heading',
			[
				'label'        => esc_html__( 'Bio', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::HEADING,
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'show_bio',
			[
				'label'        => esc_html__( 'Show Short Bio', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
			]
		);

		$this->add_grid_layout( 'bio', '{{WRAPPER}} .zyre-author-desc', [ 'show_bio' => 'yes' ] );

		// Post Count
		$this->add_control(
			'post_count__heading',
			[
				'label'        => esc_html__( 'Post Count', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::HEADING,
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'show_post_count',
			[
				'label'        => esc_html__( 'Show number of posts', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'post_count_text',
			[
				'label'        => esc_html__( 'Post Count Text', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::TEXT,
				'condition' => [
					'show_post_count' => 'yes',
				],
			]
		);

		$this->add_grid_layout( 'post_count', '{{WRAPPER}} .zyre-author-post-counter', [ 'show_post_count' => 'yes' ] );

		// Author Posts Link
		$this->add_control(
			'posts_link__heading',
			[
				'label'        => esc_html__( 'Posts Link', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::HEADING,
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'show_posts_link',
			[
				'label'        => esc_html__( 'Show Author Post Link', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'btn_text',
			[
				'label'   => esc_html__( 'Link Text', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::TEXT,
				'condition' => [
					'show_posts_link' => 'yes',
				],
				'ai' => false,
				'default' => esc_html__( 'View All', 'zyre-elementor-addons' ),
			]
		);

		$this->add_grid_layout( 'posts_link', '{{WRAPPER}} .zyre-author-post-link', [ 'show_posts_link' => 'yes' ] );

		// Registered
		$this->add_control(
			'reg__heading',
			[
				'label'        => esc_html__( 'Registered', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::HEADING,
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'show_reg_date',
			[
				'label'        => esc_html__( 'Show Registered Date', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'reg_label',
			[
				'label'        => esc_html__( 'Registered Label', 'zyre-elementor-addons' ),
				'default'      => esc_html__( 'Member since', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::TEXT,
				'condition' => [
					'show_reg_date' => 'yes',
				],
			]
		);

		$this->add_control(
			'reg_date_format',
			[
				'label'        => esc_html__( 'Format Date', 'zyre-elementor-addons' ),
				'default'      => 'Y',
				'placeholder'  => 'd F, Y',
				'type'         => Controls_Manager::TEXT,
				'condition' => [
					'show_reg_date' => 'yes',
				],
			]
		);

		$this->add_grid_layout( 'reg', '{{WRAPPER}} .zyre-author-reg', [ 'show_reg_date' => 'yes' ] );

		$this->add_responsive_control(
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
				'style_transfer' => true,
				'selectors' => [
					'{{WRAPPER}} .zyre-author-info' => 'text-align: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Add grid layout control
	 * @param string $prefix Prefix for control IDs
	 * @param string $selector CSS selector to apply styles
	 * @param array $condition_args Condition arguments for controls
	 */
	protected function add_grid_layout( $prefix, $selector, $condition_args = [] ) {
		
		if ( ! empty( $condition_args ) ) {
			$condition_args = array_merge( $condition_args, [ 'enable_grid' => 'yes' ] );
		}

		$this->add_responsive_control(
			$prefix . '_gr_rs',
			[
				'label' => esc_html__( 'Grid Row Start', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::NUMBER,
				'min' => -10,
				'max' => 10,
				'condition' => $condition_args,
				'selectors' => [
					$selector => 'grid-row-start: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			$prefix . '_gr_re',
			[
				'label' => esc_html__( 'Grid Row End', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::NUMBER,
				'min' => -10,
				'max' => 10,
				'condition' => $condition_args,
				'selectors' => [
					$selector => 'grid-row-end: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			$prefix . '_gr_cs',
			[
				'label' => esc_html__( 'Grid Column Start', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::NUMBER,
				'min' => -10,
				'max' => 10,
				'condition' => $condition_args,
				'selectors' => [
					$selector => 'grid-column-start: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			$prefix . '_gr_ce',
			[
				'label' => esc_html__( 'Grid Column End', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::NUMBER,
				'min' => -10,
				'max' => 10,
				'condition' => $condition_args,
				'selectors' => [
					$selector => 'grid-column-end: {{VALUE}};',
				],
			]
		);
	}

	/**
	 * Register styles related controls
	 */
	protected function register_style_controls() {
		$this->__author_box_avatar();
		$this->__author_box_name();
		$this->__author_box_bio();
		$this->__author_box_post_count();
		$this->__author_box_link();
		$this->__author_box_registered();
	}

	/**
	 * Author Image
	 */
	protected function __author_box_avatar() {
		$this->start_controls_section(
			'section_author_img_style',
			[
				'label' => esc_html__( 'Avatar', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_avatar' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'author_img',
			[
				'selector' => '{{WRAPPER}} .zyre-author-img img',
				'controls' => [
					'width'         => [],
					'bg_color'      => [],
					'padding'       => [],
					'border'        => [],
					'border_radius' => [],
					'align'         => [
						'selector' => '{{WRAPPER}} .zyre-author-img',
					],
				],
			],
		);

		$this->end_controls_section();
	}

	/**
	 * Author
	 */
	protected function __author_box_name() {
		$this->start_controls_section(
			'section_author_name_style',
			[
				'label' => esc_html__( 'Author', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_author' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'author_name',
			[
				'selector' => '{{WRAPPER}} .zyre-author-name',
				'controls' => [
					'typo'         => [],
					'color'        => [],
					'margin'       => [
						'selector' => '{{WRAPPER}} .zyre-author-user-name',
					],
					'align_self_y' => [
						'selector'  => '{{WRAPPER}} .zyre-author-user-name',
						'condition' => [
							'enable_grid' => 'yes',
						],
					],
					'align'        => [
						'selector' => '{{WRAPPER}} .zyre-author-user-name',
					],
				],
			],
		);

		$this->set_style_controls(
			'author_name_hover',
			[
				'selector'  => '{{WRAPPER}} .zyre-author-name:hover',
				'controls'  => [
					'color' => [
						'label' => esc_html__( 'Hover Color', 'zyre-elementor-addons' ),
					],
				],
				'condition' => [
					'author_link' => 'yes',
				],
			],
		);

		// Username
		$this->set_style_controls(
			'author_username',
			[
				'selector'  => '{{WRAPPER}} .zyre-author-username',
				'controls'  => [
					'heading' => [
						'label'     => esc_html__( 'Username', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
					'typo'    => [],
					'color'   => [],
					'margin'  => [],
				],
				'condition' => [
					'show_username' => 'yes',
				],
			],
		);

		$this->end_controls_section();
	}

	/**
	 * Author Bio
	 */
	protected function __author_box_bio() {
		$this->start_controls_section(
			'section_author_bio_style',
			[
				'label' => esc_html__( 'Author Bio', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_bio' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'author_info',
			[
				'selector' => '{{WRAPPER}} .zyre-author-desc',
				'controls' => [
					'typo'   => [],
					'color'  => [],
					'margin' => [],
					'align'  => [],
				],
			],
		);

		$this->end_controls_section();
	}

	/**
	 * Post Count
	 */
	protected function __author_box_post_count() {
		$this->start_controls_section(
			'section_author_post_count_style',
			[
				'label' => esc_html__( 'Post Count', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_post_count' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'author_post_counter',
			[
				'selector' => '{{WRAPPER}} .zyre-author-post-counter',
				'controls' => [
					'typo'       => [],
					'color'      => [],
					'margin'     => [],
				],
			],
		);

		$this->set_style_controls(
			'author_post_count_text',
			[
				'selector'  => '{{WRAPPER}} .zyre-author-post-count-text',
				'controls'  => [
					'typo'  => [
						'label' => esc_html__( 'Count Text Typography', 'zyre-elementor-addons' ),
					],
					'color' => [
						'label' => esc_html__( 'Count Text Color', 'zyre-elementor-addons' ),
					],
				],
				'condition' => [
					'post_count_text!' => '',
				],
			],
		);

		$this->add_item_grid( 'author_post_count', '{{WRAPPER}} .zyre-author-post-counter', '{{WRAPPER}} .zyre-author-post-count', [ 'post_count_text!' => '' ] );

		$this->add_responsive_control(
			'author_post_count_align',
			[
				'label'                => esc_html__( 'Alignment', 'zyre-elementor-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'default'              => is_rtl() ? 'right' : 'left',
				'options'              => [
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
				'selectors_dictionary' => [
					'left'   => 'justify-content: flex-start; text-align: left;',
					'center' => 'justify-content: center; text-align: center;',
					'right'  => 'justify-content: flex-end; text-align: right;',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-author-post-counter' => '{{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Author Posts Link
	 */
	protected function __author_box_link() {
		$this->start_controls_section(
			'section_btn_link_style',
			[
				'label'     => esc_html__( 'Author Posts Link', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'btn_text!' => '',
				],
			]
		);

		$this->set_style_controls(
			'author_post',
			[
				'selector' => '{{WRAPPER}} .zyre-author-post-link',
				'controls' => [
					'typography'    => [],
					'padding'       => [],
					'border'        => [],
					'border_radius' => [],
				],
			],
		);

		$this->start_controls_tabs(
			'tabs_author_post_link_colors',
		);

		$this->start_controls_tab(
			'tab_normal_author_post_link_colors',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'author_post',
			[
				'selector' => '{{WRAPPER}} .zyre-author-post-link',
				'controls' => [
					'text_color' => [],
					'bg_color'   => [],
				],
			],
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_hover_author_post_link_colors',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'author_post_hover',
			[
				'selector' => '{{WRAPPER}} .zyre-author-post-link:hover',
				'controls' => [
					'text_color'   => [],
					'bg_color'     => [],
					'border_color' => [],
				],
			],
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'author_post_link_align',
			[
				'label'                => esc_html__( 'Alignment', 'zyre-elementor-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'default'              => is_rtl() ? 'right' : 'left',
				'options'              => [
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
				'selectors_dictionary' => [
					'left'   => 'justify-content: flex-start; text-align: left;',
					'center' => 'justify-content: center; text-align: center;',
					'right'  => 'justify-content: flex-end; text-align: right;',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-author-post-link' => '{{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Registered
	 */
	protected function __author_box_registered() {
		$this->start_controls_section(
			'section_author_registered_style',
			[
				'label' => esc_html__( 'Registered', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_reg_date' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'author_registered',
			[
				'selector' => '{{WRAPPER}} .zyre-author-reg',
				'controls' => [
					'typo'  => [
						'label' => esc_html__( 'Typography', 'zyre-elementor-addons' ),
					],
					'color' => [
						'label' => esc_html__( 'Color', 'zyre-elementor-addons' ),
					],
					'margin' => [],
				],
			],
		);

		$this->set_style_controls(
			'author_registered_label',
			[
				'selector'  => '{{WRAPPER}} .zyre-author-reg-label',
				'controls'  => [
					'typo'  => [
						'label' => esc_html__( 'Label Typography', 'zyre-elementor-addons' ),
					],
					'color' => [
						'label' => esc_html__( 'Label Color', 'zyre-elementor-addons' ),
					],
				],
				'condition' => [
					'reg_label!' => '',
				],
			],
		);

		$this->add_item_grid( 'author_registered', '{{WRAPPER}} .zyre-author-reg', '{{WRAPPER}} .zyre-author-reg-label', [ 'reg_label!' => '' ] );

		$this->add_responsive_control(
			'author_registered_align',
			[
				'label'                => esc_html__( 'Alignment', 'zyre-elementor-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'default'              => is_rtl() ? 'right' : 'left',
				'options'              => [
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
				'selectors_dictionary' => [
					'left'   => 'justify-content: flex-start; text-align: left;',
					'center' => 'justify-content: center; text-align: center;',
					'right'  => 'justify-content: flex-end; text-align: right;',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-author-reg' => '{{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Add grid item controls 
	 * @param string $prefix Prefix for control IDs
	 * @param string $selector_parent CSS selector to apply view styles
	 * @param string $selector_child CSS selector to apply order styles
	 * @param array $condition_args Condition arguments for controls
	 */
	protected function add_item_grid( $prefix, $selector_parent, $selector_child, $condition_args = [] ) {
		$this->add_responsive_control(
			$prefix . '_view',
			[
				'label'                => esc_html__( 'View', 'zyre-elementor-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'inline' => [
						'title' => esc_html__( 'Inline (Horizontal)', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-ellipsis-h',
					],
					'block'  => [
						'title' => esc_html__( 'Block (Vertical)', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-editor-list-ul',
					],
				],
				'selectors_dictionary' => [
					'inline' => 'display: flex;flex-direction: row;',
					'block'  => 'display: flex;flex-direction: column;',
				],
				'selectors'            => [
					$selector_parent => '{{VALUE}}',
				],
				'condition'            => $condition_args,
			]
		);

		$this->add_responsive_control(
			$prefix . '_gap',
			[
				'label'      => esc_html__( 'Gap', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', '%', 'custom'],
				'selectors'  => [
					$selector_parent => 'gap: {{SIZE}}{{UNIT}};',
				],
				'condition'  => $condition_args,
			]
		);

		$this->add_responsive_control(
			$prefix . '_order',
			[
				'label'     => esc_html__( 'Order', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'0' => [
						'title' => esc_html__( 'Start', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-order-start',
					],
					'1' => [
						'title' => esc_html__( 'End', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-flex eicon-order-end',
					],
				],
				'selectors' => [
					$selector_child => 'order: {{VALUE}};',
				],
				'condition' => $condition_args,
			]
		);
	}

	/**
	 * Register render display controls
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$user_id = get_post_field( 'post_author', get_the_ID() );
		$avatar = get_avatar( $user_id, $settings['avatar_size'] );
		$display_name = get_the_author_meta( 'display_name', $user_id );
		$username = get_the_author_meta( 'user_login', $user_id );
		$reg_date = get_the_author_meta( 'user_registered', $user_id );
		$bio = get_the_author_meta( 'description', $user_id );
		$post_url = get_author_posts_url( $user_id );
		$total_posts = count_user_posts( $user_id );

		$allowed_format_chars = '/^[dDjlNSwzWFmMntLoYyaABgGhHisueIOPTZcrU\-\/,\s:.|]+$/';
		$reg_date_format = ! empty( $settings['reg_date_format'] ) ? trim( $settings['reg_date_format'] ) : '';
		if ( $reg_date_format && preg_match( $allowed_format_chars, $reg_date_format ) ) {
			$reg_date_f = $reg_date_format;
		} else {
			$reg_date_f = 'd F, Y'; // fallback format
		}

		$this->add_render_attribute( 'author_box', 'class', 'zyre-author-box zy-text-left' );
		if ( 'yes' === $settings['enable_grid'] ) {
			$this->add_render_attribute( 'author_box', 'class', 'zy-grid zy-align-start' );
		}

		$this->add_render_attribute( 'author_img', 'class', 'zyre-author-img zy-overflow-hidden' );
		$this->add_render_attribute( 'author_name', 'class', 'zyre-author-name zy-inline-block' );

		$author_img_tag = 'div';
		if ( 'yes' === $settings['avatar_link'] ) {
			$author_img_tag = Utils::validate_html_tag( 'a' );
			$this->add_render_attribute( 'author_img', 'class', 'zyre-author-img-link' );
			$this->add_render_attribute( 'author_img', 'href', esc_url( $post_url ) );
		}

		$author_name_tag = 'span';
		if ( 'yes' === $settings['author_link'] ) {
			$author_name_tag = Utils::validate_html_tag( 'a' );
			$this->add_render_attribute( 'author_name', 'class', 'zyre-author-name-link zy-inline-block' );
			$this->add_render_attribute( 'author_name', 'href', esc_url( $post_url ) );
		}
		?>
		<div <?php $this->print_render_attribute_string( 'author_box' ); ?>>
			<?php if ( 'yes' === $settings['show_avatar'] ) : ?>
				<<?php Utils::print_validated_html_tag( $author_img_tag ); ?> <?php $this->print_render_attribute_string( 'author_img' ); ?>>
					<?php echo $avatar; ?>
				</<?php Utils::print_validated_html_tag( $author_img_tag ); ?>>
			<?php endif; ?>

			<?php if ( 'yes' === $settings['show_author'] || 'yes' === $settings['show_username'] ) : ?>
				<div class="zyre-author-user-name zy-self-center">
					<?php if ( 'yes' === $settings['show_author'] ) : ?>
						<<?php echo zyre_escape_tags( $settings ['author_meta_tag'], 'h4' ); ?> class="zyre-author-name-heading zy-m-0">
							<<?php Utils::print_validated_html_tag( $author_name_tag ); ?> <?php $this->print_render_attribute_string( 'author_name' ); ?>>
								<?php echo esc_html( $display_name ); ?>
							</<?php Utils::print_validated_html_tag( $author_name_tag ); ?>>
						</<?php echo zyre_escape_tags( $settings ['author_meta_tag'], 'h4' ); ?>>
					<?php endif; ?>

					<?php if ( 'yes' === $settings['show_username'] ) : ?>
						<p class="zyre-author-username zy-m-0"><?php echo esc_html( $username ); ?></p>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( 'yes' === $settings['show_bio'] ) : ?>
				<p class="zyre-author-desc zy-m-0"><?php echo esc_html( $bio ); ?></p>
			<?php endif; ?>

			<?php if ( 'yes' === $settings['show_post_count'] ) : ?>
				<div class="zyre-author-post-counter">
					<span class="zyre-author-post-count"><?php echo esc_html( $total_posts ); ?></span>
					<?php if ( ! empty( $settings['post_count_text'] ) ) : ?>
						<span class="zyre-author-post-count-text"><?php echo esc_html( $settings['post_count_text'] ); ?></span>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( 'yes' === $settings['show_posts_link'] && '' !== $settings['btn_text'] ) : ?>
				<a href="<?php echo esc_url( $post_url ); ?>" class="zyre-author-post-link">
					<?php echo esc_html( $settings['btn_text'] ); ?>
				</a>
			<?php endif; ?>

			<?php if ( 'yes' === $settings['show_reg_date'] ) : ?>
				<div class="zyre-author-reg">
					<?php if ( ! empty( $settings['reg_label'] ) ) : ?>
						<span class="zyre-author-reg-label"><?php echo esc_html( $settings['reg_label'] ); ?></span>
					<?php endif; ?>
					<span class="zyre-author-reg-date"><?php echo date( $reg_date_f, strtotime( $reg_date )); ?></span>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}
}
