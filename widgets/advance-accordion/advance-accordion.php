<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Repeater;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) || die();

class Advance_Accordion extends Base {
	/**
	 * Widget Name
	 */
	public function get_title() {
		return esc_html__( 'Advance Accordion', 'zyre-elementor-addons' );
	}

	/**
	 * Widget Icon
	 */
	public function get_icon() {
		return 'zy-fonticon zy-Accordion';
	}

	/**
	 * Widget search keywords
	 */
	public function get_keywords() {
		return [ 'advance accordion', 'accordion', 'toggle', 'collapse', 'expand', 'faq', 'advanced toggle', 'content toggle', 'expandable content' ];
	}

	/**
	 * Elementor Library Container & Section
	 */
	public function select_elementor_page( $type ) {
		$args  = [
			'tax_query'      => [
				[
					'taxonomy' => 'elementor_library_type',
					'field'    => 'slug',
					'terms'    => $type,
				],
			],
			'post_type'      => 'elementor_library',
			'posts_per_page' => -1,
		];
		$query = new \WP_Query( $args );

		$posts = $query->posts;
		foreach ( $posts as $post ) {
			$items[ $post->ID ] = $post->post_title;
		}

		if ( empty( $items ) ) {
			$items = [];
		}

		return $items;
	}

	/**
	 * Register widget content controls
	 */
	protected function register_content_controls() {
		$this->start_controls_section(
			'section_advance_accordion_content',
			[
				'label' => esc_html__( 'Advance Accordion', 'zyre-elementor-addons' ),
			]
		);

		// Pre styles
		$this->set_prestyle_controls();

		$repeater = new Repeater();

		$repeater->add_control(
			'accordion_title',
			[
				'label'       => esc_html__( 'Accordion Title', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'ai' => false,
			]
		);

		$repeater->add_control(
			'_content_type',
			[
				'label'   => esc_html__( 'Content Type', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'custom_content' => esc_html__( 'Custom Content', 'zyre-elementor-addons' ),
					'saved_section' => esc_html__( 'Saved Section', 'zyre-elementor-addons' ),
					'saved_container' => esc_html__( 'Saved Container', 'zyre-elementor-addons' ),
				],
				'default' => 'custom_content',
			]
		);

		$saved_sections = [ '0' => esc_html__( '--- Select Section ---', 'zyre-elementor-addons' ) ];
		$saved_sections = $saved_sections + $this->select_elementor_page( 'section' );

		$repeater->add_control(
			'_saved_section',
			[
				'label'     => esc_html__( 'Sections', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => $saved_sections,
				'default'   => '0',
				'condition' => [
					'_content_type' => 'saved_section',
				],
			]
		);

		$saved_container = [ '0' => esc_html__( '--- Select Container ---', 'zyre-elementor-addons' ) ];
		$saved_container = $saved_container + $this->select_elementor_page( 'container' );

		$repeater->add_control(
			'_saved_container',
			[
				'label'     => esc_html__( 'Container', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => $saved_container,
				'default'   => '0',
				'condition' => [
					'_content_type' => 'saved_container',
				],
			]
		);

		$repeater->add_control(
			'accordion_content',
			[
				'label'       => esc_html__( 'Accordion Content', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::WYSIWYG,
				'label_block' => true,
				'ai' => false,
				'condition' => [
					'_content_type' => 'custom_content',
				],
			]
		);

		$this->add_control(
			'accordion_list',
			[
				'label'       => esc_html__( 'Accordion List', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::REPEATER,
				'default'     => [
					[
						'accordion_title' => esc_html__( 'Magna aliquam erat volutpat', 'zyre-elementor-addons' ),
						'accordion_content' => esc_html__( 'Ipsum dolor sit amet, consectetuer adipiscing elitsed diam nonummy nibh euismod tinciduntut laoreet dolore magna aliquam erat volutpat. Utwisi enim ad minim veniam quisnostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.', 'zyre-elementor-addons' ),
					],
					[
						'accordion_title' => esc_html__( 'Quis nostrud exerci tation ullamcorper suscipit', 'zyre-elementor-addons' ),
						'accordion_content' => esc_html__( 'Ipsum dolor sit amet, consectetuer adipiscing elitsed diam nonummy nibh euismod tinciduntut laoreet dolore magna aliquam erat volutpat. Utwisi enim ad minim veniam quisnostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.', 'zyre-elementor-addons' ),
					],
					[
						'accordion_title' => esc_html__( 'Duis autem vel eum iriure dolor in hendrerit', 'zyre-elementor-addons' ),
						'accordion_content' => esc_html__( 'LIpsum dolor sit amet, consectetuer adipiscing elitsed diam nonummy nibh euismod tinciduntut laoreet dolore magna aliquam erat volutpat. Utwisi enim ad minim veniam quisnostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.', 'zyre-elementor-addons' ),
					],
					[
						'accordion_title' => esc_html__( 'Vulputate velit esse molestie consequat velillum', 'zyre-elementor-addons' ),
						'accordion_content' => esc_html__( 'Ipsum dolor sit amet, consectetuer adipiscing elitsed diam nonummy nibh euismod tinciduntut laoreet dolore magna aliquam erat volutpat. Utwisi enim ad minim veniam quisnostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.', 'zyre-elementor-addons' ),
					],
					[
						'accordion_title' => esc_html__( 'Nulla facilisis at vero', 'zyre-elementor-addons' ),
						'accordion_content' => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci quas optio dignissimos earum quam ab possimus vitae aliquid quibusdam autem, modi doloribus recusandae laboriosam aspernatur, dicta sapiente quia ut nihil.', 'zyre-elementor-addons' ),
					],
				],
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ accordion_title }}}',
			]
		);

		$this->add_control(
			'active_item',
			[
				'label' => esc_html__( 'Active Item Index', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::NUMBER,
				'label_block' => false,
				'default' => 1,
				'min' => 0,
				'render_type' => 'template',
				'frontend_available' => true,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'icon_position',
			[
				'label'   => esc_html__( 'Icon Position', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'left' => esc_html__( 'Left', 'zyre-elementor-addons' ),
					'right' => esc_html__( 'Right', 'zyre-elementor-addons' ),
				],
				'default' => 'left',
				'selectors_dictionary' => [
					'left'     => 'flex-direction: row;',
					'right'  => 'flex-direction: row-reverse; justify-content: space-between;',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-accordion-toggle' => '{{VALUE}};',
				],
			]
		);

		$this->add_control(
			'open_icon',
			[
				'label'       => esc_html__( 'Open Icon', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => 'true',
				'default' => [
					'value'   => 'fas fa-chevron-right',
					'library' => 'fa-solid',
				],
				'recommended'      => [
					'fa-regular'   => [
						'plus-square',
						'caret-square-down',
						'caret-square-left',
						'caret-square-right',
						'caret-square-up',
					],
					'fa-solid'   => [
						'angle-down',
						'angle-right',
						'angle-left',
						'angle-up',
						'chevron-right',
						'chevron-left',
						'caret-down',
						'caret-left',
						'caret-right',
						'caret-up',
						'caret-square-down',
						'caret-square-left',
						'caret-square-right',
						'caret-square-up',
						'plus',
						'plus-square',
						'plus-circle',
					],
				],
			]
		);

		$this->add_control(
			'collapse_icon',
			[
				'label'       => esc_html__( 'Collapse Icon', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => 'true',
				'default' => [
					'value'   => 'fas fa-chevron-down',
					'library' => 'fa-solid',
				],
				'recommended'      => [
					'fa-regular'   => [
						'minus-square',
						'caret-square-down',
						'caret-square-left',
						'caret-square-right',
						'caret-square-up',
					],
					'fa-solid'   => [
						'angle-down',
						'angle-right',
						'angle-left',
						'angle-up',
						'chevron-right',
						'chevron-left',
						'caret-down',
						'caret-left',
						'caret-right',
						'caret-up',
						'caret-square-down',
						'caret-square-left',
						'caret-square-right',
						'caret-square-up',
						'minus',
						'minus-square',
						'minus-circle',
					],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register styles related controls
	 */
	protected function register_style_controls() {
		$this->__item_style();
		$this->__title_style();
		$this->__description_style();
	}

	/**
	 * Style - Item
	 */
	protected function __item_style() {
		$this->start_controls_section(
			'section_item_style',
			[
				'label' => esc_html__( 'Item', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'item',
			[
				'selector' => '{{WRAPPER}} .zyre-advance-accordion-section',
				'controls' => [
					'space'         => [
						'label'        => esc_html__( 'Margin Bottom', 'zyre-elementor-addons' ),
						'selector'     => '{{WRAPPER}} .zyre-accordion-tab-content > .zyre-advance-accordion-section:not(:last-child)',
						'css_property' => 'margin-bottom',
					],
					'bg_color'      => [],
					'padding'       => [],
					'border'        => [],
					'border_radius' => [],
					'box_shadow'    => [],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style - Title
	 */
	protected function __title_style() {
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'title',
			[
				'selector' => '{{WRAPPER}} .zyre-accordion-toggle',
				'controls' => [
					'typography' => [],
					'gap'        => [],
					'padding'    => [],
					'border'     => [],
				],
			]
		);

		$this->set_style_controls(
			'title_icon',
			[
				'selector' => '{{WRAPPER}} .zyre-accordion-toggle .toggle-icon',
				'controls' => [
					'heading'       => [
						'label' => esc_html__( 'Title Icon', 'zyre-elementor-addons' ),
					],
					'font_size'     => [
						'label' => esc_html__( 'Icon Size', 'zyre-elementor-addons' ),
					],
					'padding'       => [],
					'border'        => [],
					'border_radius' => [],
				],
			]
		);

		// Tabs
		$this->start_controls_tabs( 'title_tabs' );

		$this->start_controls_tab(
			'title_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'title',
			[
				'selector' => '{{WRAPPER}} .zyre-accordion-toggle',
				'controls' => [
					'color' => [],
				],
			]
		);

		$this->set_style_controls(
			'title_icon',
			[
				'selector' => '{{WRAPPER}} .zyre-accordion-toggle .toggle-icon',
				'controls' => [
					'bg_color' => [
						'label' => esc_html__( 'Icon Background', 'zyre-elementor-addons' ),
					],
					'icon_color'    => [],
				],
			]
		);

		$this->end_controls_tab();

		// Tab: Hover
		$this->start_controls_tab(
			'title_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'title_hover',
			[
				'selector' => '{{WRAPPER}} .zyre-accordion-toggle.active, {{WRAPPER}} .zyre-accordion-toggle:hover',
				'controls' => [
					'color' => [],
				],
			]
		);

		$this->set_style_controls(
			'title_icon_hover',
			[
				'selector' => '{{WRAPPER}} .zyre-accordion-toggle.active > .toggle-icon.open, {{WRAPPER}} .zyre-accordion-toggle:hover .toggle-icon',
				'controls' => [
					'bg_color' => [
						'label' => esc_html__( 'Icon Background', 'zyre-elementor-addons' ),
					],
					'icon_color'    => [],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Style - Description
	 */
	protected function __description_style() {
		$this->start_controls_section(
			'section_description_style',
			[
				'label' => esc_html__( 'Description', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'description',
			[
				'selector' => '{{WRAPPER}} .zyre-accordion-content-description',
				'controls' => [
					'bg_color'   => [],
					'color'      => [],
					'typography' => [],
					'margin'     => [],
					'padding'    => [],
					'border'     => [],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register render display controls
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$content_type = '_content_type';
		$saved_container = '_saved_container';
		$saved_section = '_saved_section';

		$accordion_list = $settings['accordion_list'];
		if ( empty( $accordion_list ) ) {
			return;
		}
		?>
		<div class="zyre-accordion-tab-content" data-accordion-type="accordion">
			<?php
			foreach ( $accordion_list as $index => $accordion ) :
				$tab_id = $index + 1;
				$item_key = $this->get_repeater_setting_key( 'item', 'accordion_list', $index );
				$content_key = $this->get_repeater_setting_key( 'tab_content', 'accordion_list', $index );

				$active_class = $tab_id === $settings['active_item'] ? 'active' : '';

				$this->add_render_attribute(
					$item_key,
					[
						'class' => [ 'zyre-advance-accordion-section', $active_class ],
					]
				);

				$this->add_render_attribute(
					$content_key,
					[
						'class' => [ 'zyre-accordion-contents' ],
					]
				);

				$item_descripton = '';
				if ( '' !== $accordion['accordion_content'] ) {
					$descripton_key = $this->get_repeater_setting_key( 'accordion_content', 'accordion_list', $index );
					$this->add_inline_editing_attributes( $descripton_key );
					$this->add_render_attribute( $descripton_key, 'class', 'zyre-accordion-content-description' );
					$descripton_attr = $this->get_render_attribute_string( $descripton_key );
					$descripton_text = $accordion['accordion_content'];
					$item_descripton = sprintf( '<div %1$s>%2$s</div>', $descripton_attr, $descripton_text );
				}
				?>
				<div <?php $this->print_render_attribute_string( $item_key ); ?>>
					<!-- Accordion Title -->
					<?php if ( '' !== $accordion['accordion_title'] ) : ?>
					<h4 class="zyre-accordion-toggle zy-flex align-center zy-m-0 zy-transition zy-c-pointer">
						<?php if ( isset( $settings['open_icon']['value'] ) && '' !== $settings['open_icon']['value'] ) : ?>
							<span class="toggle-icon toggle-icon-closed zy-self-center">
								<?php zyre_render_icon( $settings, 'icon', 'open_icon' ); ?>
							</span>
						<?php endif; ?>

						<?php if ( isset( $settings['collapse_icon']['value'] ) && '' !== $settings['collapse_icon']['value'] ) : ?>
							<span class="toggle-icon toggle-icon-opened zy-self-center">
								<?php zyre_render_icon( $settings, 'icon', 'collapse_icon' ); ?>
							</span>
						<?php endif; ?>
						<?php echo esc_html( $accordion['accordion_title'] ); ?>
					</h4>
					<?php endif; ?>

					<!-- Accordion Content -->
					<?php if ( isset( $accordion[ $content_type ] ) && 'custom_content' === $accordion[ $content_type ] ) : ?>				
					<div <?php echo $this->get_render_attribute_string( $content_key ); ?>>
						<?php echo wp_kses_post( $item_descripton ); ?>
					</div>
					<?php elseif ( isset( $accordion[ $content_type ] ) && 'saved_section' === $accordion[ $content_type ] && 'publish' === get_post_status( $accordion[ $saved_section ] ) ) : ?>
					<div <?php echo $this->get_render_attribute_string( $content_key ); ?>>
						<?php $accordion[ $saved_section ] = apply_filters( 'wpml_object_id', $accordion[ $saved_section ], 'elementor_library' );
						echo zyre_elementor()->frontend->get_builder_content_for_display( $accordion[ $saved_section ] ); ?>
					</div>
					<?php elseif ( isset( $accordion[ $content_type ] ) && 'saved_container' === $accordion[ $content_type ] && 'publish' === get_post_status( $accordion[ $saved_container ] ) ) : ?>
					<div <?php echo $this->get_render_attribute_string( $content_key ); ?>>
						<?php $accordion[ $saved_container ] = apply_filters( 'wpml_object_id', $accordion[ $saved_container ], 'elementor_library' );
						echo zyre_elementor()->frontend->get_builder_content_for_display( $accordion[ $saved_container ] ); ?>
					</div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
			<!-- Loop End -->
		</div>
		<?php
	}
}
