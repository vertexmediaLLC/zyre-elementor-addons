<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;

defined( 'ABSPATH' ) || die();

class Archive_Title extends Base {

	public function get_title() {
		return esc_html__( 'Archive Title', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Archive-Title';
	}

	public function get_keywords() {
		return [ 'archive title', 'title', 'archive', 'archive info', 'archive heading', 'heading', 'archive name', 'category', 'tag' ];
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	/**
	 * Register widget content controls
	 */
	protected function register_content_controls() {
		$this->start_controls_section(
			'section_archive_title_content',
			[
				'label' => esc_html__( 'Archive Title', 'zyre-elementor-addons' ),
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$this->add_control(
			'show_placeholder',
			[
				'label'        => esc_html__( 'Placeholder Content', 'zyre-elementor-addons' ),
				'description'  => esc_html__( 'Enabling this option will replace the real archive title with placeholder content.', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off'    => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
			]
		);

		$this->__archive_title_before_content();
		$this->__archive_title_after_content();

		$this->add_control(
			'archive_title_tag',
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

		$this->add_responsive_control(
			'archive_title_align',
			[
				'label'       => esc_html__( 'Alignment', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
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
				'default'      => 'left',
				'selectors_dictionary' => [
					'left'   => 'justify-content: flex-start; text-align: left;',
					'center' => 'justify-content: center; text-align: center;',
					'right'  => 'justify-content: flex-end; text-align: right;',
				],
				'selectors'          => [
					'{{WRAPPER}} .zyre-archive-title-heading' => '{{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->__archive_prefix_content();
	}

	/**
	 * Archive Title Before Content
	 */
	protected function __archive_title_before_content() {
		$this->archive_content_before_after( 'before' );
	}

	/**
	 * Archive Title After Content
	 */
	protected function __archive_title_after_content() {
		$this->archive_content_before_after( 'after' );
	}

	/**
	 * Archive Prefix Content
	 */
	protected function __archive_prefix_content() {
		$this->start_controls_section(
			'section_archive_prefix_content',
			[
				'label' => esc_html__( 'Archive Prefix', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'show_prefix',
			[
				'label' => esc_html__( 'Show Prefix', 'zyre-elementor-addons' ),
				'description' => esc_html__( 'Prefixes won\'t appear in the Editor Preview.', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'category_title_prefix',
			[
				'label'   => esc_html__( 'Category Prefix', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::TEXT,
				'condition' => [
					'show_prefix' => 'yes',
				],
				'ai' => false,
				'default' => esc_html__( 'Category:', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'tag_title_prefix',
			[
				'label'   => esc_html__( 'Tag Prefix', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::TEXT,
				'condition' => [
					'show_prefix' => 'yes',
				],
				'ai' => false,
				'default' => esc_html__( 'Tag:', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'author_title_prefix',
			[
				'label'   => esc_html__( 'Author Prefix', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::TEXT,
				'condition' => [
					'show_prefix' => 'yes',
				],
				'ai' => false,
				'default' => esc_html__( 'Author:', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'year_title_prefix',
			[
				'label'   => esc_html__( 'Year Prefix', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::TEXT,
				'condition' => [
					'show_prefix' => 'yes',
				],
				'ai' => false,
				'default' => esc_html__( 'Year:', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'month_title_prefix',
			[
				'label'   => esc_html__( 'Month Prefix', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::TEXT,
				'condition' => [
					'show_prefix' => 'yes',
				],
				'ai' => false,
				'default' => esc_html__( 'Month:', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'day_title_prefix',
			[
				'label'   => esc_html__( 'Day Prefix', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::TEXT,
				'condition' => [
					'show_prefix' => 'yes',
				],
				'ai' => false,
				'default' => esc_html__( 'Day:', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'archive_title_prefix',
			[
				'label'   => esc_html__( 'Archives Prefix', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::TEXT,
				'condition' => [
					'show_prefix' => 'yes',
				],
				'ai' => false,
				'default' => esc_html__( 'Archives:', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'taxonomy_title_prefix',
			[
				'label' => esc_html__( 'Texonomy Prefix', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => esc_html__( 'Default', 'zyre-elementor-addons' ),
					'custom'  => esc_html__( 'Custom', 'zyre-elementor-addons' ),
				],
				'condition' => [
					'show_prefix' => 'yes',
				],
			]
		);

		$this->add_control(
			'custom_taxonomy_prefix',
			[
				'label'   => esc_html__( 'Custom Texonomy', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::TEXT,
				'condition' => [
					'show_prefix' => 'yes',
					'taxonomy_title_prefix' => 'custom',
				],
				'ai' => false,
				'default' => esc_html__( 'Texonomy:', 'zyre-elementor-addons' ),
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Archive Title Before After Content
	 *
	 * @param string $prefix The prefix of the controls.
	 */
	private function archive_content_before_after( $prefix ) {
		$types = [
			'none'      => esc_html__( 'None', 'zyre-elementor-addons' ),
			'text'      => esc_html__( 'Text', 'zyre-elementor-addons' ),
			'separator' => esc_html__( 'Separator', 'zyre-elementor-addons' ),
			'icon'      => esc_html__( 'Icon', 'zyre-elementor-addons' ),
		];

		$margin_property = 'before' === $prefix ? ( is_rtl() ? 'margin-left' : 'margin-right' ) : ( is_rtl() ? 'margin-right' : 'margin-left' );
		$label_prefix = 'before' === $prefix ? esc_html__( 'Before ', 'zyre-elementor-addons' ) : esc_html__( 'After ', 'zyre-elementor-addons' );

		$this->add_control(
			$prefix . '_types',
			[
				'label'   => $label_prefix . esc_html__( 'Title Text', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $types,
				'default' => 'none',
				'separator' => 'before',
			]
		);

		$this->add_control(
			$prefix . '_text',
			[
				'label'   => esc_html__( 'Text', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::TEXT,
				'condition' => [
					$prefix . '_types' => 'text',
				],
				'ai' => false,
			]
		);

		$this->add_control(
			$prefix . '_icon',
			[
				'label'       => esc_html__( 'Icon', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => 'true',
				'condition' => [
					$prefix . '_types' => 'icon',
				],
			]
		);

		$this->add_control(
			$prefix . '_spacing',
			[
				'label'     => $label_prefix . esc_html__( 'Spacing', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					$prefix . '_types!' => 'none',
				],
				'default' => [
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-archive-title-' . $prefix  => "{$margin_property}: {{SIZE}}{{UNIT}};",
				],
			]
		);
	}

	/**
	 * Register styles related controls
	 */
	protected function register_style_controls() {
		$this->__archive_before_text();
		$this->__archive_before_separator();
		$this->__archive_before_icon();
		$this->__archive_title_prefix();
		$this->__archive_title_style();
		$this->__archive_after_text();
		$this->__archive_after_separator();
		$this->__archive_after_icon();
	}

	/**
	 * Before Text
	 */
	protected function __archive_before_text() {
		$this->start_controls_section(
			'archive_before_text',
			[
				'label' => esc_html__( 'Before Text', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'before_types' => 'text',
				],
			]
		);

		$this->set_style_controls(
			'before_text',
			[
				'selector' => '{{WRAPPER}} .zyre-archive-title-text-prefix',
				'controls' => [
					'typography'  => [],
					'text_color'  => [],
					'text_shadow' => [],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Before Icon
	 */
	protected function __archive_before_icon() {
		$this->start_controls_section(
			'archive_before_icon',
			[
				'label' => esc_html__( 'Before Icon', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'before_types' => 'icon',
				],
			]
		);

		$this->set_style_controls(
			'before_icon',
			[
				'selector' => '{{WRAPPER}} .zyre-archive-title-icon-prefix',
				'controls' => [
					'icon_size'  => [
						'default' => [
							'size' => 16,
						],
					],
					'icon_color' => [],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Before Separator
	 */
	protected function __archive_before_separator() {
		$this->start_controls_section(
			'archive_before_separator',
			[
				'label' => esc_html__( 'Before Separator', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'before_types' => 'separator',
				],
			]
		);

		$this->set_style_controls(
			'before_separator',
			[
				'selector' => '{{WRAPPER}} .zyre-archive-title-separator-prefix',
				'controls' => [
					'width'  => [
						'css_property' => 'max-width',
						'default'      => [
							'unit' => 'px',
						],
					],
					'border' => [
						'fields_options' => [
							'border' => [
								'default' => 'solid',
							],
							'width' => [
								'default' => [
									'top' => '1',
									'right' => '1',
									'bottom' => '1',
									'left' => '1',
									'isLinked' => true,
								],
							],
							'color' => [
								'default' => '#DDDDDD',
							],
						],
					],
					'border_radius' => [],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Title Prefix
	 */
	protected function __archive_title_prefix() {
		$this->start_controls_section(
			'archive_prefix_style',
			[
				'label'     => esc_html__( 'Title Prefix', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_prefix' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'archive_prefix',
			[
				'selector' => '{{WRAPPER}} .zyre-archive-title-prefix',
				'controls' => [
					'typography'  => [],
					'text_color'  => [],
					'text_shadow' => [],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Title
	 */
	protected function __archive_title_style() {
		$this->start_controls_section(
			'archive_title_style',
			[
				'label'     => esc_html__( 'Title', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'archive_title',
			[
				'selector' => '{{WRAPPER}} .zyre-archive-title-text',
				'controls' => [
					'typography'  => [],
					'text_color'  => [],
					'text_shadow' => [],
					'alignment'  => [
						'default' => is_rtl() ? 'right' : 'left',
					],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * After Text
	 */
	protected function __archive_after_text() {
		$this->start_controls_section(
			'archive_after_text',
			[
				'label' => esc_html__( 'After Text', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'after_types' => 'text',
				],
			]
		);

		$this->set_style_controls(
			'after_text',
			[
				'selector' => '{{WRAPPER}} .zyre-archive-title-text-suffix',
				'controls' => [
					'typography'  => [],
					'text_color'  => [],
					'text_shadow' => [],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * After Icon
	 */
	protected function __archive_after_icon() {
		$this->start_controls_section(
			'archive_after_icon',
			[
				'label' => esc_html__( 'After Icon', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'after_types' => 'icon',
				],
			]
		);

		$this->set_style_controls(
			'after_icon',
			[
				'selector' => '{{WRAPPER}} .zyre-archive-title-icon-suffix',
				'controls' => [
					'icon_size'  => [
						'default' => [
							'size' => 16,
						],
					],
					'icon_color' => [],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * After Separator
	 */
	protected function __archive_after_separator() {
		$this->start_controls_section(
			'archive_after_separator',
			[
				'label' => esc_html__( 'After Separator', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'after_types' => 'separator',
				],
			]
		);

		$this->set_style_controls(
			'after_separator',
			[
				'selector' => '{{WRAPPER}} .zyre-archive-title-separator-suffix',
				'controls' => [
					'width'  => [
						'css_property' => 'max-width',
						'default'      => [
							'unit' => 'px',
						],
					],
					'border' => [
						'fields_options' => [
							'border' => [
								'default' => 'solid',
							],
							'width' => [
								'default' => [
									'top' => '1',
									'right' => '1',
									'bottom' => '1',
									'left' => '1',
									'isLinked' => true,
								],
							],
							'color' => [
								'default' => '#DDDDDD',
							],
						],
					],
					'border_radius' => [],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register render display controls
	 */
	protected function render() {
		$settings = $this->get_settings_for_display(); ?>
		<<?php echo zyre_escape_tags( $settings['archive_title_tag'], 'h2' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> class="zyre-archive-title-heading zy-flex zy-gap-2 zy-align-center zy-m-0 zy-lh-1.5">
			<?php
			$this->__render_title_before_after( 'before', 'prefix' );
			$this->__render_title( $settings );
			$this->__render_title_before_after( 'after', 'suffix' );
			?>
		</<?php echo zyre_escape_tags( $settings['archive_title_tag'], 'h2' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<?php
	}

	/**
	 * Render Title before & after HTML.
	 *
	 * @param string $prefix The prefix of the elements.
	 * @param string $class_base This will help to select HTML elements.
	 */
	protected function __render_title_before_after( $prefix, $class_base ) {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings[ $prefix . '_types' ] ) || 'none' === $settings[ $prefix . '_types' ] ) {
			return;
		}

		if ( 'text' === $settings[ $prefix . '_types' ] && '' !== $settings[ $prefix . '_text' ] ) : ?>
			<span class="zyre-archive-title-<?php echo esc_attr( $prefix ); ?> zyre-archive-title-text-<?php echo esc_attr( $class_base ); ?>">
				<?php echo esc_html( $settings[ $prefix . '_text' ] ); ?>
			</span>
		<?php endif; ?>
		<?php if ( 'separator' === $settings[ $prefix . '_types' ] ) : ?>
			<span class="zyre-archive-title-<?php echo esc_attr( $prefix ); ?> zyre-archive-title-separator-<?php echo esc_attr( $class_base ); ?> zy-grow-1 zy-mw-2 zy-h-0"></span>
		<?php endif; ?>
		<?php if ( 'icon' === $settings[ $prefix . '_types' ] ) : ?>
			<span class="zyre-archive-title-<?php echo esc_attr( $prefix ); ?> zyre-archive-title-icon-<?php echo esc_attr( $class_base ); ?>">
				<?php zyre_render_icon( $settings, 'icon', $prefix . '_icon' ); ?>
			</span>
		<?php endif;
	}

	/**
	 * Render Title before & after HTML.
	 *
	 * @param string $prefix The prefix of the elements.
	 * @param string $class_base This will help to select HTML elements.
	 */
	protected function __render_title( $settings ) {

		$prefix = '';

		if ( 'yes' === $settings['show_prefix'] ) {
			if ( is_singular() ) {
				$post_type_obj = get_post_type_object( get_post_type() );
				$prefix = $post_type_obj->labels->singular_name . ':';
			} elseif ( is_search() ) {
				$prefix = esc_html__( 'Search Results for: ', 'zyre-elementor-addons' );
			} elseif ( is_category() ) {
				$prefix = ! empty( $settings['category_title_prefix'] ) ? $settings['category_title_prefix'] : esc_html__( 'Category:', 'zyre-elementor-addons' );
			} elseif ( is_tag() ) {
				$prefix = ! empty( $settings['tag_title_prefix'] ) ? $settings['tag_title_prefix'] : esc_html__( 'Tag:', 'zyre-elementor-addons' );
			} elseif ( is_author() ) {
				$prefix = ! empty( $settings['author_title_prefix'] ) ? $settings['author_title_prefix'] : esc_html__( 'Author:', 'zyre-elementor-addons' );
			} elseif ( is_year() ) {
				$prefix = ! empty( $settings['year_title_prefix'] ) ? $settings['year_title_prefix'] : esc_html__( 'Year:', 'zyre-elementor-addons' );
			} elseif ( is_month() ) {
				$prefix = ! empty( $settings['month_title_prefix'] ) ? $settings['month_title_prefix'] : esc_html__( 'Month:', 'zyre-elementor-addons' );
			} elseif ( is_day() ) {
				$prefix = ! empty( $settings['day_title_prefix'] ) ? $settings['day_title_prefix'] : esc_html__( 'Day:', 'zyre-elementor-addons' );
			} elseif ( is_post_type_archive() ) {
				$prefix = ! empty( $settings['archive_title_prefix'] ) ? $settings['archive_title_prefix'] : esc_html__( 'Archives:', 'zyre-elementor-addons' );
			} elseif ( is_tax() ) {
				if ( 'default' === $settings['taxonomy_title_prefix'] ) {
					$queried_object = get_queried_object();
					if ( $queried_object ) {
						$tax    = get_taxonomy( $queried_object->taxonomy );
						$prefix = sprintf(
							/* translators: %s: Taxonomy singular name. */
							_x( '%s:', 'taxonomy term archive title prefix', 'zyre-elementor-addons' ),
							$tax->labels->singular_name
						);
					}
				} elseif ( 'custom' === $settings['taxonomy_title_prefix'] && ! empty( $settings['custom_taxonomy_prefix'] ) ) {
					$prefix = $settings['custom_taxonomy_prefix'];
				}
			}
		}

		// Placeholder content
		if ( 'yes' === $settings['show_placeholder'] ) {
			$prefix = esc_html__( 'Prefix:', 'zyre-elementor-addons' );
		}

		if ( $prefix ) {
			$prefix = '<span class="zyre-archive-title-prefix">' . $prefix . '</span>';
		}

		$title = '';

		if ( is_singular() ) {
			$title = get_the_title();
		} elseif ( is_search() ) {
			$title = sprintf( esc_html( '%s %s' ), $prefix, get_search_query() );

			if ( get_query_var( 'paged' ) ) {
				/* translators: %s: Page number. */
				$title .= sprintf( esc_html__( '&nbsp;&ndash; Page %s', 'zyre-elementor-addons' ), get_query_var( 'paged' ) );
			}
		} elseif ( is_category() ) {
			$title = single_cat_title( '', false );
		} elseif ( is_tag() ) {
			$title = single_tag_title( '', false );
		} elseif ( is_author() ) {
			$title = '<span class="vcard">' . get_the_author() . '</span>';
		} elseif ( is_year() ) {
			$title = get_the_date( _x( 'Y', 'yearly archives date format', 'zyre-elementor-addons' ) );
		} elseif ( is_month() ) {
			$title = get_the_date( _x( 'F Y', 'monthly archives date format', 'zyre-elementor-addons' ) );
		} elseif ( is_day() ) {
			$title = get_the_date( _x( 'F j, Y', 'daily archives date format', 'zyre-elementor-addons' ) );
		} elseif ( is_tax( 'post_format' ) ) {
			if ( is_tax( 'post_format', 'post-format-aside' ) ) {
				$title = _x( 'Asides', 'post format archive title', 'zyre-elementor-addons' );
			} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
				$title = _x( 'Galleries', 'post format archive title', 'zyre-elementor-addons' );
			} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
				$title = _x( 'Images', 'post format archive title', 'zyre-elementor-addons' );
			} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
				$title = _x( 'Videos', 'post format archive title', 'zyre-elementor-addons' );
			} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
				$title = _x( 'Quotes', 'post format archive title', 'zyre-elementor-addons' );
			} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
				$title = _x( 'Links', 'post format archive title', 'zyre-elementor-addons' );
			} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
				$title = _x( 'Statuses', 'post format archive title', 'zyre-elementor-addons' );
			} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
				$title = _x( 'Audio', 'post format archive title', 'zyre-elementor-addons' );
			} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
				$title = _x( 'Chats', 'post format archive title', 'zyre-elementor-addons' );
			}
		} elseif ( is_post_type_archive() ) {
			$title = post_type_archive_title( '', false );
		} elseif ( is_tax() ) {
			$title = single_term_title( '', false );
		} elseif ( is_archive() ) {
			$title = esc_html__( 'Archives', 'zyre-elementor-addons' );
		} elseif ( is_404() ) {
			$title = esc_html__( 'Page Not Found', 'zyre-elementor-addons' );
		} // End if().

		// Placeholder content
		if ( 'yes' === $settings['show_placeholder'] ) {
			$title = esc_html__( 'Archive Title', 'zyre-elementor-addons' );
		}

		if ( $title ) {
			$title = $prefix . '<span class="zyre-archive-title-text">' . $title . '</span>';
		}

		/**
		 * Archive title.
		 *
		 * Filters the title of the archive pages.
		 *
		 * By default different pages have different titles depending of the page
		 * context (archive, singular, 404 etc.). This hook allows developers to
		 * alter those titles.
		 *
		 * @since 1.0.0
		 *
		 * @param string $title Page title to be displayed.
		 */
		echo apply_filters( 'zyre/widgets/get_the_archive_title', wp_kses( $title, zyre_get_allowed_html() ) ); // pphcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
