<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use ZyreAddons\Elementor\Controls\Select2;

defined( 'ABSPATH' ) || die();

class Post_Content extends Base {
	public function get_title() {
		return esc_html__( 'Post Content', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Post-Content';
	}

	public function get_keywords() {
		return [ 'post content', 'post info', 'post', 'full post', 'full content', 'post data' ];
	}

	/**
	 * Register widget content controls
	 */
	protected function register_content_controls() {
		$this->start_controls_section(
			'section_post_content_content',
			[
				'label' => esc_html__( 'Post Content', 'zyre-elementor-addons' ),
			]
		);

		$this->set_prestyle_controls();

		// Content Source
		$this->add_control(
			'source_type',
			[
				'label'     => esc_html__( 'Content Source', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'current_post' => esc_html__( 'Current Post', 'zyre-elementor-addons' ),
					'custom'       => esc_html__( 'Custom', 'zyre-elementor-addons' ),
				],
				'default'   => 'current_post',
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

		$this->end_controls_section();
	}

	/**
	 * Register styles related controls
	 */
	protected function register_style_controls() {
		$this->__paragraph_style_controls();
		$this->__heading_style_controls();
		$this->__link_style_controls();
		$this->__image_style_controls();
		$this->__quote_style_controls();
		$this->__pre_code_style_controls();
		$this->__table_style_controls();
		$this->__list_style_controls();
	}

	protected function __paragraph_style_controls() {
		$this->start_controls_section(
			'section_paragraph_style',
			[
				'label' => esc_html__( 'Paragraphs', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'paragraph',
			[
				'selector' => '{{WRAPPER}} .zyre-post-content p',
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

	protected function __heading_style_controls() {
		$this->start_controls_section(
			'section_headings_style',
			[
				'label' => esc_html__( 'Headings', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'h1',
			[
				'selector' => '{{WRAPPER}} .zyre-post-content h1',
				'controls' => [
					'margin'     => [
						'selector' => '{{WRAPPER}} .zyre-post-content h1, {{WRAPPER}} .zyre-post-content h2, {{WRAPPER}} .zyre-post-content h3, {{WRAPPER}} .zyre-post-content h4, {{WRAPPER}} .zyre-post-content h5, {{WRAPPER}} .zyre-post-content h6',
					],
					'heading'    => [
						'label' => esc_html__( 'H1 Style', 'zyre-elementor-addons' ),
					],
					'typography' => [],
					'color'      => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->set_style_controls(
			'h2',
			[
				'selector' => '{{WRAPPER}} .zyre-post-content h2',
				'controls' => [
					'heading'    => [
						'label' => esc_html__( 'H2 Style', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
					'typography' => [],
					'color'      => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->set_style_controls(
			'h3',
			[
				'selector' => '{{WRAPPER}} .zyre-post-content h3',
				'controls' => [
					'heading'    => [
						'label' => esc_html__( 'H3 Style', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
					'typography' => [],
					'color'      => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->set_style_controls(
			'h4',
			[
				'selector' => '{{WRAPPER}} .zyre-post-content h4',
				'controls' => [
					'heading'    => [
						'label' => esc_html__( 'H4 Style', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
					'typography' => [],
					'color'      => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->set_style_controls(
			'h5',
			[
				'selector' => '{{WRAPPER}} .zyre-post-content h5',
				'controls' => [
					'heading'    => [
						'label' => esc_html__( 'H5 Style', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
					'typography' => [],
					'color'      => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->set_style_controls(
			'h6',
			[
				'selector' => '{{WRAPPER}} .zyre-post-content h6',
				'controls' => [
					'heading'    => [
						'label' => esc_html__( 'H6 Style', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
					'typography' => [],
					'color'      => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __link_style_controls() {
		$this->start_controls_section(
			'section_link_style',
			[
				'label' => esc_html__( 'Links', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'link',
			[
				'selector' => '{{WRAPPER}} .zyre-post-content a',
				'controls' => [
					'typography' => [],
				],
			]
		);

		$this->start_controls_tabs(
			'link_style_tabs',
		);

		$this->start_controls_tab(
			'link_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'link',
			[
				'selector' => '{{WRAPPER}} .zyre-post-content a',
				'controls' => [
					'text_color' => [
						'label'     => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'link_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'link_hover',
			[
				'selector' => '{{WRAPPER}} .zyre-post-content a:hover',
				'controls' => [
					'text_color' => [
						'label'     => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function __image_style_controls() {
		$this->start_controls_section(
			'section_image_style',
			[
				'label' => esc_html__( 'Images', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'image',
			[
				'selector' => '{{WRAPPER}} .zyre-post-content img',
				'controls' => [
					'border'        => [],
					'border_radius' => [],
					'bg_color'      => [],
					'box_shadow'    => [],
					'padding'       => [],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __quote_style_controls() {
		$this->start_controls_section(
			'section_quote_style',
			[
				'label' => esc_html__( 'Quotations', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'quote',
			[
				'selector' => '{{WRAPPER}} .zyre-post-content blockquote',
				'controls' => [
					'typography'    => [
						'selector' => '{{WRAPPER}} .zyre-post-content blockquote, {{WRAPPER}} .zyre-post-content blockquote p',
					],
					'color'         => [
						'selector' => '{{WRAPPER}} .zyre-post-content blockquote, {{WRAPPER}} .zyre-post-content blockquote p',
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
					'bg_color'      => [],
					'border'        => [],
					'border_radius' => [],
					'margin'        => [],
					'padding'       => [],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __pre_code_style_controls() {
		$this->start_controls_section(
			'section_pre_style',
			[
				'label' => esc_html__( 'Preformats', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'pre',
			[
				'selector' => '{{WRAPPER}} .zyre-post-content pre',
				'controls' => [
					'typography'    => [],
					'color'         => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
					'bg_color'      => [],
					'border'        => [],
					'border_radius' => [],
					'margin'        => [],
					'padding'       => [],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __table_style_controls() {

		$this->start_controls_section(
			'section_table_style',
			[
				'label' => esc_html__( 'Tables', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'table',
			[
				'selector' => '{{WRAPPER}} .zyre-post-content table',
				'controls' => [
					'typography' => [],
					'color'      => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
					'border'     => [
						'selector' => '{{WRAPPER}} .zyre-post-content table th, {{WRAPPER}} .zyre-post-content table td',
					],
					'padding'    => [
						'selector' => '{{WRAPPER}} .zyre-post-content table th, {{WRAPPER}} .zyre-post-content table td',
					],
					'align'      => [
						'selector'  => '{{WRAPPER}} .zyre-post-content table th, {{WRAPPER}} .zyre-post-content table td',
					],
				],
			]
		);

		// Table: Header
		$this->add_control(
			'table_head_style',
			[
				'label'     => esc_html__( 'Table Header', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->set_style_controls(
			'table_head',
			[
				'selector' => '{{WRAPPER}} .zyre-post-content table thead',
				'controls' => [
					'typography' => [],
					'color'      => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
					'bg_color'   => [],
					'align'      => [
						'selector' => '{{WRAPPER}} .zyre-post-content table thead th',
					],
				],
			]
		);

		// Table: Odd Row
		$this->add_control(
			'table_odd_style',
			[
				'label' => esc_html__( 'Odd Row', 'zyre-elementor-addons' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->__table_odd_even_style( 'table_odd', '{{WRAPPER}} .zyre-post-content table tbody tr:nth-child(odd)' );

		// Table: Even Row
		$this->add_control(
			'table_even_style',
			[
				'label' => esc_html__( 'Even Row', 'zyre-elementor-addons' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->__table_odd_even_style( 'table_even', '{{WRAPPER}} .zyre-post-content table tbody tr:nth-child(even)' );

		// Table: Footer
		$this->add_control(
			'table_footer_style',
			[
				'label'     => esc_html__( 'Table Footer', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->set_style_controls(
			'table_footer',
			[
				'selector' => '{{WRAPPER}} .zyre-post-content table tfoot',
				'controls' => [
					'typography' => [],
					'color'      => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
					'bg_color'   => [],
					'align'      => [
						'selector' => '{{WRAPPER}} .zyre-post-content table tfoot td',
					],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __list_style_controls() {
		$this->start_controls_section(
			'section_list_style',
			[
				'label' => esc_html__( 'Lists', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'list',
			[
				'selector' => '{{WRAPPER}} .zyre-post-content ul, {{WRAPPER}} .zyre-post-content ol, {{WRAPPER}} .zyre-post-content dl',
				'controls' => [
					'typography' => [],
					'color'      => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
					'spacing'    => [
						'label'        => esc_html__( 'Horizontal Space', 'zyre-elementor-addons' ),
						'css_property' => is_rtl() ? 'padding-right' : 'padding-left',
						'default'      => [
							'size' => 16,
						],
					],
					'margin'     => [],
				],
			]
		);

		$this->add_control(
			'list_style_type',
			[
				'label'     => esc_html__( 'Unordered List Type', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''                  => esc_html__( 'Default', 'zyre-elementor-addons' ),
					'none'              => esc_html__( 'None', 'zyre-elementor-addons' ),
					'circle'            => esc_html__( 'Circle', 'zyre-elementor-addons' ),
					'decimal'           => esc_html__( 'Decimal', 'zyre-elementor-addons' ),
					'disc'              => esc_html__( 'Disc', 'zyre-elementor-addons' ),
					'disclosure-closed' => esc_html__( 'Disclosure Closed', 'zyre-elementor-addons' ),
					'disclosure-open'   => esc_html__( 'Disclosure Open', 'zyre-elementor-addons' ),
					'square'            => esc_html__( 'Square', 'zyre-elementor-addons' ),
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-post-content ul' => 'list-style-type: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'list_style_ol_type',
			[
				'label'     => esc_html__( 'Ordered List Type', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''                  => esc_html__( 'Default', 'zyre-elementor-addons' ),
					'none'              => esc_html__( 'None', 'zyre-elementor-addons' ),
					'circle'            => esc_html__( 'Circle', 'zyre-elementor-addons' ),
					'decimal'           => esc_html__( 'Decimal', 'zyre-elementor-addons' ),
					'disc'              => esc_html__( 'Disc', 'zyre-elementor-addons' ),
					'disclosure-closed' => esc_html__( 'Disclosure Closed', 'zyre-elementor-addons' ),
					'disclosure-open'   => esc_html__( 'Disclosure Open', 'zyre-elementor-addons' ),
					'square'            => esc_html__( 'Square', 'zyre-elementor-addons' ),
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-post-content ol' => 'list-style-type: {{VALUE}};',
				],
			]
		);

		$this->set_style_controls(
			'list_item',
			[
				'selector' => '{{WRAPPER}} .zyre-post-content li ul, {{WRAPPER}} .zyre-post-content li ol',
				'controls' => [
					'heading' => [
						'label'     => esc_html__( 'Nested Child List', 'zyre-elementor-addons' ),
						'separator' => 'before',
					],
					'spacing' => [
						'label'        => esc_html__( 'Horizontal Space', 'zyre-elementor-addons' ),
						'css_property' => is_rtl() ? 'padding-right' : 'padding-left',
					],
					'margin'  => [],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Normal & hover tab for color, background & border color controls.
	 *
	 * @param string $prefix control ID name.
	 * @param string $selector selector of the controls.
	 */
	private function __table_odd_even_style( $prefix, $selector ) {
		$this->start_controls_tabs(
			$prefix . 'post_content_style_tabs',
		);

		$this->start_controls_tab(
			$prefix . 'post_content_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			$prefix,
			[
				'selector' => "{$selector} th, {$selector} td",
				'controls' => [
					'text_color' => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
					'bg_color'   => [],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			$prefix . '_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			$prefix . '_hover',
			[
				'selector' => "{$selector}:hover th, {$selector}:hover td",
				'controls' => [
					'text_color' => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
					'bg_color'   => [],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
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

		static $have_posts = [];
		$post = get_post();
		// Exit early if there's no valid post object
		if ( ! $post ) {
			return;
		}

		if ( post_password_required( $post->ID ) ) {
			echo get_the_password_form( $post->ID );
			return;
		}

		if ( isset( $have_posts[ $post->ID ] ) ) {
			return;
		}
		$have_posts[ $post->ID ] = true;
		?>

		<div class="zyre-post-content">
			<?php echo apply_filters( 'the_content', get_the_content() ); ?>
		</div>

		<?php
		if ( 'custom' === $settings['source_type'] ) {
			zyre_elementor()->db->restore_current_post();
		}
	}
}
