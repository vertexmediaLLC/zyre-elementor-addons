<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Repeater;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) || die();

class Post_Meta extends Base {

	public function get_title() {
		return esc_html__( 'Post Meta', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Post-Meta';
	}

	public function get_keywords() {
		return [ 'meta', 'post meta', 'post info', 'post', 'post data', 'post meta info', 'author', 'edit post text', 'edit post link', 'comments', 'comments count', 'tags', 'category', 'taxonomy', 'dates', 'author link' ];
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	/**
	 * Register widget content controls
	 */
	protected function register_content_controls() {
		$this->start_controls_section(
			'section_post_meta_content',
			[
				'label' => esc_html__( 'Post Meta', 'zyre-elementor-addons' ),
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$this->add_control(
			'post_meta_layout',
			[
				'label' => esc_html__( 'Post Meta Display', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'vertical' => esc_html__( 'Vertical', 'zyre-elementor-addons' ),
					'horizontal'  => esc_html__( 'Horizontal', 'zyre-elementor-addons' ),
				],
				'default' => 'horizontal',
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

		$repeater->add_control(
			'post_meta_name',
			[
				'label'   => esc_html__( 'Meta Name', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'default' => esc_html__( 'Default', 'zyre-elementor-addons' ),
					'custom'  => esc_html__( 'Custom', 'zyre-elementor-addons' ),
				],
				'default' => 'default',
				'condition' => [
					'post_meta_select' => 'author',
				],
			]
		);

		$repeater->add_control(
			'meta_custom_name',
			[
				'label' => esc_html__( 'Custom Name', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'post_meta_select' => 'author',
					'post_meta_name' => 'custom',
				],
				'ai' => false,
			]
		);

		$repeater->add_control(
			'date_format',
			[
				'label'   => esc_html__( 'Date Format', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'default' => esc_html__( 'Default', 'zyre-elementor-addons' ),
					'custom'  => esc_html__( 'Custom', 'zyre-elementor-addons' ),
				],
				'default' => 'default',
				'condition' => [
					'post_meta_select' => 'date',
				],
			]
		);

		$repeater->add_control(
			'custom_date_format',
			[
				'label' => esc_html__( 'Custom Date Format', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'F j, Y', 'zyre-elementor-addons' ),
				'condition' => [
					'post_meta_select' => 'date',
					'date_format' => 'custom',
				],
				'ai' => false,
				'render_type' => 'tempate',
			]
		);

		$repeater->add_control(
			'zero_comment',
			[
				'label' => esc_html__( '0 Comment', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( ' Comment', 'zyre-elementor-addons' ),
				'condition' => [
					'post_meta_select' => 'comments',
				],
				'ai' => false,
			]
		);

		$repeater->add_control(
			'one_comment',
			[
				'label' => esc_html__( '1 Comment', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( ' Comment', 'zyre-elementor-addons' ),
				'condition' => [
					'post_meta_select' => 'comments',
				],
				'ai' => false,
			]
		);

		$repeater->add_control(
			'multi_comment',
			[
				'label' => esc_html__( 'Multi Comments', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( ' Comments', 'zyre-elementor-addons' ),
				'condition' => [
					'post_meta_select' => 'comments',
				],
				'ai' => false,
			]
		);

		$repeater->add_control(
			'comment_block',
			[
				'label' => esc_html__( 'Comment Block', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Comment Block', 'zyre-elementor-addons' ),
				'condition' => [
					'post_meta_select' => 'comments',
				],
				'ai' => false,
			]
		);

		$repeater->add_control(
			'edit_post',
			[
				'label' => esc_html__( 'Edit Post', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Edit Post', 'zyre-elementor-addons' ),
				'condition' => [
					'post_meta_select' => 'edit',
				],
				'ai' => false,
			]
		);

		$repeater->add_control(
			'post_meta_link',
			[
				'label'   => esc_html__( 'Meta Link', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'zyre-elementor-addons' ),
					'default' => esc_html__( 'Default', 'zyre-elementor-addons' ),
				],
				'default' => 'default',
				'condition' => [
					'post_meta_select!' => [ 'author', 'edit' ],
				],
			]
		);

		$repeater->add_control(
			'post_meta_author_link',
			[
				'label'   => esc_html__( 'Meta Link', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'zyre-elementor-addons' ),
					'default' => esc_html__( 'Default', 'zyre-elementor-addons' ),
					'custom'  => esc_html__( 'Custom', 'zyre-elementor-addons' ),
				],
				'default' => 'default',
				'condition' => [
					'post_meta_select' => 'author',
				],
			]
		);

		$repeater->add_control(
			'custom_link',
			[
				'label' => esc_html__( 'Custom Link', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'label_block' => true,
				'condition' => [
					'post_meta_author_link' => 'custom',
				],
			]
		);

		$repeater->add_control(
			'post_meta_prefix',
			[
				'label' => esc_html__( 'Extra Text', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'ai' => false,
			]
		);

		$item_margin = is_rtl() ? 'margin-left' : 'margin-right';

		$repeater->add_responsive_control(
			'before_text_distance',
			[
				'label'          => esc_html__( 'Before Text Distance', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::SLIDER,
				'default'        => [
					'unit' => 'px',
				],
				'tablet_default' => [
					'unit' => 'px',
				],
				'mobile_default' => [
					'unit' => 'px',
				],
				'size_units'     => [ 'px', '%', 'em', 'custom' ],
				'range'          => [
					'%'  => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 100,
					],
					'em' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors'      => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .zyre-post-meta-extra-text' => "{$item_margin}: {{SIZE}}{{UNIT}};",
				],
				'condition' => [
					'post_meta_prefix[value]!' => '',
				],
			]
		);

		$repeater->add_control(
			'post_meta_prefix_color',
			[
				'label'     => esc_html__( 'Extra Text Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .zyre-post-meta-extra-text' => 'color: {{VALUE}};',
				],
				'condition' => [
					'post_meta_prefix[value]!' => '',
				],
			]
		);

		$repeater->add_control(
			'post_meta_separator',
			[
				'label' => esc_html__( 'Separator', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => ', ',
				'condition' => [
					'post_meta_select' => [ 'category', 'tag' ],
				],
				'ai' => false,
			]
		);

		$repeater->add_control(
			'icon_switcher',
			[
				'label' => esc_html__( 'Icon Switcher', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Off', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$repeater->add_control(
			'post_meta_icon',
			[
				'label'       => esc_html__( 'Icon Upload', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => 'true',
				'default' => [
					'value'   => 'far fa-user',
					'library' => 'fa-regular',
				],
				'condition' => [
					'icon_switcher' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'icon_size',
			[
				'label'     => esc_html__( 'Icon Size', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .zyre-post-meta-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'icon_switcher' => 'yes',
					'post_meta_icon[value]!' => '',
				],
			]
		);

		$repeater->add_responsive_control(
			'icon_distance',
			[
				'label'          => esc_html__( 'Icon Distance', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::SLIDER,
				'default'        => [
					'unit' => 'px',
				],
				'tablet_default' => [
					'unit' => 'px',
				],
				'mobile_default' => [
					'unit' => 'px',
				],
				'size_units'     => [ 'px', '%', 'em', 'custom' ],
				'range'          => [
					'%'  => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 100,
					],
					'em' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors'      => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .zyre-post-meta-icon' => "{$item_margin}: {{SIZE}}{{UNIT}};",
				],
				'condition' => [
					'icon_switcher' => 'yes',
					'post_meta_icon[value]!' => '',
				],
			]
		);

		$repeater->add_control(
			'post_meta_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .zyre-post-meta-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} .zyre-post-meta-icon svg' => 'fill: {{VALUE}};',
				],
				'condition' => [
					'icon_switcher' => 'yes',
					'post_meta_icon[value]!' => '',
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
						'post_meta_icon' => [
							'value'   => 'far fa-user',
							'library' => 'fa-regular',
						],
					],
					[
						'post_meta_select' => 'category',
						'post_meta_icon' => [
							'value'   => 'far fa-folder-open',
							'library' => 'fa-regular',
						],
					],
					[
						'post_meta_select' => 'date',
						'post_meta_icon' => [
							'value'   => 'far fa-clock',
							'library' => 'fa-regular',
						],
					],
					[
						'post_meta_select' => 'comments',
						'post_meta_icon' => [
							'value'   => 'far fa-comment-dots',
							'library' => 'fa-regular',
						],
					],
				],
				'title_field' => '{{{ post_meta_select.charAt(0).toUpperCase() + post_meta_select.slice(1) }}}',
			]
		);

		$this->add_responsive_control(
			'alignment',
			[
				'label'              => esc_html__( 'Alignment', 'zyre-elementor-addons' ),
				'type'               => Controls_Manager::CHOOSE,
				'options'            => [
					'flex-start'    => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-center',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'      => 'flex-start',
				'selectors' => [
					'{{WRAPPER}} .zyre-post-meta-horizontal.zyre-post-meta' => 'justify-content: {{VALUE}};',
					'{{WRAPPER}} .zyre-post-meta-vertical .zyre-post-meta-item' => 'align-items: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Register styles related controls
	 */
	protected function register_style_controls() {
		$this->__general_style_controls();
		$this->__meta_item_style_controls();
		$this->__meta_link_style_controls();
		$this->__divider_style_controls();
	}

	protected function __general_style_controls() {
		$this->start_controls_section(
			'section_general_style',
			[
				'label' => esc_html__( 'General', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'post_meta',
			[
				'selector' => '{{WRAPPER}} .zyre-post-meta',
				'controls' => [
					'typography'    => [],
					'icon_size'     => [
						'selector' => '{{WRAPPER}} .zyre-post-meta-icon',
					],
					'space_between' => [
						'label'        => esc_html__( 'Space Between', 'zyre-elementor-addons' ),
						'css_property' => '--gap',
					],
					'padding'       => [],
					'margin'        => [],
					'border'        => [],
					'text_color'    => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
					'icon_color'    => [
						'selector' => '{{WRAPPER}} .zyre-post-meta-icon',
					],
					'bg_color'      => [],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __meta_item_style_controls() {
		$this->start_controls_section(
			'section_item_style',
			[
				'label' => esc_html__( 'Meta Item', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'meta_item',
			[
				'selector' => '{{WRAPPER}} .zyre-post-meta-item',
				'controls' => [
					'padding' => [],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __meta_link_style_controls() {
		$this->start_controls_section(
			'section_link_style',
			[
				'label' => esc_html__( 'Meta Link', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs(
			'post_meta_style_tabs',
		);

		$this->start_controls_tab(
			'post_meta_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'post_meta_link_color',
			[
				'label'     => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-post-meta-link, {{WRAPPER}} .zyre-post-meta-link a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'post_meta_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'post_meta_hover_link_color',
			[
				'label'     => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-post-meta-link:hover, {{WRAPPER}} .zyre-post-meta-link a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function __divider_style_controls() {
		$this->start_controls_section(
			'section_divider_style',
			[
				'label' => esc_html__( 'Divider', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'meta_divider',
			[
				'label' => esc_html__( 'Divider', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Off', 'zyre-elementor-addons' ),
				'label_on' => esc_html__( 'On', 'zyre-elementor-addons' ),
			]
		);

		$this->post_meta_divider_style( 'all_child' );

		$this->add_control(
			'divider_color',
			[
				'label' => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-post-meta-item::after' => 'border-color: {{VALUE}}',
				],
				'condition' => [
					'meta_divider' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Post Thumbnail controls.
	 *
	 * @param string $prefix control ID name.
	 */
	private function post_meta_divider_style( $prefix ) {
		$this->add_control(
			$prefix . 'divider_style',
			[
				'label' => esc_html__( 'Style', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'solid' => esc_html__( 'Solid', 'zyre-elementor-addons' ),
					'double' => esc_html__( 'Double', 'zyre-elementor-addons' ),
					'dotted' => esc_html__( 'Dotted', 'zyre-elementor-addons' ),
					'dashed' => esc_html__( 'Dashed', 'zyre-elementor-addons' ),
				],
				'default' => 'solid',
				'selectors' => [
					'{{WRAPPER}} .zyre-post-meta-horizontal .zyre-post-meta-item:not(:last-child)::after' => 'border-left-style: {{VALUE}}',
					'{{WRAPPER}} .zyre-post-meta-vertical .zyre-post-meta-item:not(:last-child)::after' => 'border-bottom-style: {{VALUE}}',
				],
				'condition' => [
					'meta_divider' => 'yes',
				],
			]
		);

		$this->add_control(
			$prefix . 'divider_weight',
			[
				'label' => esc_html__( 'Weight', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'default' => [
					'unit' => 'px',
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-post-meta-item' => '--divider-width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'meta_divider' => 'yes',
				],
			]
		);

		$this->add_control(
			$prefix . 'divider_width',
			[
				'label' => esc_html__( 'Width', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-post-meta-vertical .zyre-post-meta-item:not(:last-child)::after' => 'width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'meta_divider' => 'yes',
					'post_meta_layout' => 'vertical',
				],
			]
		);

		$this->add_control(
			$prefix . 'divider_height',
			[
				'label' => esc_html__( 'Height', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'custom' ],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-post-meta-horizontal .zyre-post-meta-item:not(:last-child)::after' => 'height: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'meta_divider' => 'yes',
					'post_meta_layout' => 'horizontal',
				],
			]
		);
	}

	/**
	 * Post item before icon & extra text
	 */
	protected function render_post_item_before( $item ) {
		if ( 'yes' === $item['icon_switcher'] && '' !== $item['post_meta_icon']['value'] ) : ?>
		<span class="zyre-post-meta-icon">
			<?php zyre_render_icon( $item, 'icon', 'post_meta_icon' ); ?>
		</span>
		<?php endif; ?>
		<?php if ( '' !== $item['post_meta_prefix'] ) : ?>
		<span class="zyre-post-meta-extra-text">
			<?php echo esc_html( $item['post_meta_prefix'] ); ?>
		</span>
		<?php endif;
	}

	/**
	 * Author meta render
	 */
	protected function render_post_meta_author( $item ) {
		$author_id = get_post_field( 'post_author' );
		if ( 'default' === $item['post_meta_author_link'] || 'custom' === $item['post_meta_author_link'] ) {
			$html_tag = 'a';
			if ( ! empty( $item['custom_link']['url'] ) ) {
				$this->add_link_attributes( 'post_author', $item['custom_link'] );
			} else {
				$this->add_render_attribute( 'post_author', 'href', esc_url( get_author_posts_url( $author_id ) ) );
			}
			$this->add_render_attribute( 'post_author', 'class', 'zyre-post-meta-text zyre-post-meta-link' );
		} else {
			$html_tag = 'span';
			$this->add_render_attribute( 'post_author', 'class', 'zyre-post-meta-text' );
		}
		if ( 'custom' === $item['post_meta_name'] && '' !== $item['meta_custom_name'] ) {
			$author_name = $item['meta_custom_name'];
		} else {
			$author_name = get_the_author_meta( 'display_name', $author_id );
		}
		$this->render_post_item_before( $item );
		?>

		<<?php echo esc_attr( $html_tag ); ?> <?php $this->print_render_attribute_string( 'post_author' ); ?>>
			<?php echo esc_html( $author_name ); ?>
		</<?php echo esc_attr( $html_tag ); ?>>

		<?php
	}

	/**
	 * Date meta render
	 */
	protected function render_post_meta_date( $item ) {
		if ( 'default' === $item['post_meta_link'] ) {
			$html_tag = 'a';
			$this->add_render_attribute( 'post_date', 'href', esc_url( get_day_link( get_post_time( 'Y' ), get_post_time( 'm' ), get_post_time( 'j' ) ) ) );
			$this->add_render_attribute( 'post_date', 'class', 'zyre-post-meta-text zyre-post-meta-link' );
		} else {
			$html_tag = 'span';
			$this->add_render_attribute( 'post_date', 'class', 'zyre-post-meta-text' );
		}
		$this->render_post_item_before( $item );
		?>

		<<?php echo esc_attr( $html_tag ); ?> <?php $this->print_render_attribute_string( 'post_date' ); ?>>
			<?php if ( 'custom' === $item['date_format'] && '' !== $item['custom_date_format'] ) {
				echo esc_html( get_the_date( $item['custom_date_format'] ) );
			} else {
				echo esc_html( get_the_date( get_option( 'date_format' ) ) );
			}
			?>
		</<?php echo esc_attr( $html_tag ); ?>>

		<?php
	}

	/**
	 * Category meta render
	 */
	protected function render_post_meta_category( $item ) {
		if ( 'default' === $item['post_meta_link'] ) {
			$this->add_render_attribute( 'post_category', 'class', 'zyre-post-meta-text zyre-post-meta-link' );
		} else {
			$this->add_render_attribute( 'post_category', 'class', 'zyre-post-meta-text' );
		}

		$categories = get_the_category();
		if ( '' !== $item['post_meta_separator'] ) {
			$separator = $item['post_meta_separator'];
		} else {
			$separator = '';
		}
		$output = '';
		if ( ! empty( $categories ) ) {
			$this->render_post_item_before( $item );
			?>
			<span <?php $this->print_render_attribute_string( 'post_category' ); ?>>
			<?php
			foreach ( $categories as $category ) {
				if ( 'default' === $item['post_meta_link'] ) {
					$output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" >' . esc_html( $category->name ) . '</a>' . $separator;
				} else {
					$output .= esc_html( $category->name ) . $separator;
				}
			}
			?>
			<span <?php $this->print_render_attribute_string( 'post_category' ); ?>>
			<?php
			echo trim( $output, $separator );
		}
	}

	/**
	 * Tag meta render
	 */
	protected function render_post_meta_tag( $item ) {
		if ( 'default' === $item['post_meta_link'] ) {
			$this->add_render_attribute( 'post_tag', 'class', 'zyre-post-meta-text zyre-post-meta-link' );
		} else {
			$this->add_render_attribute( 'post_tag', 'class', 'zyre-post-meta-text' );
		}
		$tags = get_the_tags();
		if ( '' !== $item['post_meta_separator'] ) {
			$separator = $item['post_meta_separator'];
		} else {
			$separator = '';
		}
		$output = '';
		if ( ! empty( $tags ) ) {
			$this->render_post_item_before( $item );
			?>
			<span <?php $this->print_render_attribute_string( 'post_tag' ); ?>>
			<?php
			foreach ( $tags as $tag ) {
				if ( 'default' === $item['post_meta_link'] ) {
					$output .= '<a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" >' . esc_html( $tag->name ) . '</a>' . $separator;
				} else {
					$output .= esc_html( $tag->name ) . $separator;
				}
			}
			?>
			<span <?php $this->print_render_attribute_string( 'post_tag' ); ?>>
			<?php
			echo trim( $output, $separator );
		}
	}

	/**
	 * Comments meta render
	 */
	protected function render_post_meta_comments( $item ) {
		if ( 'default' === $item['post_meta_link'] ) {
			$html_tag = 'a';
			$this->add_render_attribute( 'post_comment', 'href', esc_url( get_comments_link() ) );
			$this->add_render_attribute( 'post_comment', 'class', 'zyre-post-meta-text zyre-post-meta-link' );
		} else {
			$html_tag = 'span';
			$this->add_render_attribute( 'post_comment', 'class', 'zyre-post-meta-text' );
		}
		$count = get_comments_number();
		if ( '' !== $item['zero_comment'] ) {
			$zero_comment = $item['zero_comment'];
		}
		if ( '' !== $item['one_comment'] ) {
			$one_comment = $item['one_comment'];
		}
		if ( '' !== $item['multi_comment'] ) {
			$multi_comments = $item['multi_comment'];
		}
		if ( '' !== $item['comment_block'] ) {
			$comment_block = $item['comment_block'];
		}
		if ( '1' === $count ) {
			$text = $count . $one_comment;
		} elseif ( $count > 1 ) {
			$text = $count . $multi_comments;
		} else {
			$text = '0' . $zero_comment;
		}
		if ( ! comments_open() ) {
			$text = $comment_block;
		}
		$this->render_post_item_before( $item );
		?>

		<<?php echo esc_attr( $html_tag ); ?> <?php $this->print_render_attribute_string( 'post_comment' ); ?>>
			<?php echo esc_html( $text ); ?>
		</<?php echo esc_attr( $html_tag ); ?>>

		<?php
	}

	/**
	 * Edit meta render
	 */
	protected function render_post_meta_edit( $item ) {
		if ( '' !== $item['edit_post'] ) {
			$edit_post = $item['edit_post'];
		}
		$this->render_post_item_before( $item );
		edit_post_link( esc_html( $edit_post ), '<span>', '</span>', null, 'zyre-post-meta-text zyre-post-meta-link' );
	}

	/**
	 * Register render display controls
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		echo '<ul class="zyre-post-meta zy-m-0 zy-p-0 zy-list-none zy-flex zy-flex-wrap zyre-post-meta-' . esc_attr( $settings['post_meta_layout'] ) . '" >';

		foreach ( $settings['post_meta_elements'] as $item ) {
			$item_id = $item['_id'];
			$item_meta = $item['post_meta_select'];
			$item_class = 'zyre-post-meta-item zy-relative zy-inline-flex zy-align-center elementor-repeater-item-' . $item_id . ' zyre-post-meta-';

			switch ( $item['post_meta_select'] ) {
				case 'author':
					echo '<li class="' . esc_attr( $item_class . $item_meta ) . '"><div class="zyre-post-meta-item-inner zy-inline-flex zy-align-center">';
					$this->render_post_meta_author( $item );
					echo '</div></li>';
					break;

				case 'date':
					echo '<li class="' . esc_attr( $item_class . $item_meta ) . '"><div class="zyre-post-meta-item-inner zy-inline-flex zy-align-center">';
					$this->render_post_meta_date( $item );
					echo '</div></li>';
					break;

				case 'category':
					if ( has_category() ) {
						echo '<li class="' . esc_attr( $item_class . $item_meta ) . '"><div class="zyre-post-meta-item-inner zy-inline-flex zy-align-center">';
						$this->render_post_meta_category( $item );
						echo '</div></li>';
					}
					break;

				case 'tag':
					if ( has_tag() ) {
						echo '<li class="' . esc_attr( $item_class . $item_meta ) . '"><div class="zyre-post-meta-item-inner zy-inline-flex zy-align-center">';
						$this->render_post_meta_tag( $item );
						echo '</div></li>';
					}
					break;

				case 'comments':
					echo '<li class="' . esc_attr( $item_class . $item_meta ) . '"><div class="zyre-post-meta-item-inner zy-inline-flex zy-align-center">';
					$this->render_post_meta_comments( $item );
					echo '</div></li>';
					break;

				case 'edit':
					if ( is_user_logged_in() && current_user_can( 'edit_posts' ) ) {
						echo '<li class="' . esc_attr( $item_class . $item_meta ) . '"><div class="zyre-post-meta-item-inner zy-inline-flex zy-align-center">';
						$this->render_post_meta_edit( $item );
						echo '</div></li>';
					}
					break;
			}
		}
		echo '</ul>';
	}
}
