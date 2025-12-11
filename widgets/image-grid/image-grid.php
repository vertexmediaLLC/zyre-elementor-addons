<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Image_Grid extends Base {

	/**
	 * The default filter acts as the global filter
	 * and can be overridden in the settings.
	 *
	 * @var string
	 */
	protected $_default_filter = '*';

	public function get_title() {
		return esc_html__( 'Image Grid', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Image-grid';
	}

	public function get_keywords() {
		return [ 'image list', 'images lists', 'image grid', 'media grid', 'media filter', 'gallery', 'image gallery', 'media gallery', 'portfolio' ];
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	protected function register_content_controls() {
		$this->start_controls_section(
			'section_content_general',
			[
				'label' => esc_html__( 'General', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();
		
		$this->__items_content();

		$this->end_controls_section();
	}

	protected function __items_content() {
	
		$repeater = new Repeater();

		$repeater->add_control(
			'image',
			[
				'label'   => esc_html__( 'Upload Image', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'category',
			[
				'label'       => esc_html__( 'Category', 'zyre-elementor-addons' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Separate multiple categories with commas \',\'', 'zyre-elementor-addons' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'link',
			[
				'label'       => esc_html__( 'Link', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://example.com/',
				'label_block' => true,
			]
		);

		$repeater->add_responsive_control(
			'width',
			[
				'label'          => esc_html__( 'Span Width', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::NUMBER,
				'min'            => 1,
				'max'            => 12,
				'default'        => 1,
				'tablet_default' => 1,
        		'mobile_default' => 1,
				'selectors'      => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.zyre-image-grid-item' => 'width: calc((100% / var(--image-grid-column)) * {{VALUE}});',
				],
				'render_type'    => 'template',
				'style_transfer' => true,
			]
		);

		$this->add_control(
			'all_items',
			[
				'label'              => esc_html__( 'All Items', 'zyre-elementor-addons' ),
				'type'               => Controls_Manager::REPEATER,
				'default'            => [
					[
						'title'    => 'Image #1',
						'category' => 'Category 1',
					],
					[
						'title'    => 'Image #2',
						'category' => 'Category 2',
					],
					[
						'title'    => 'Image #3',
						'category' => 'Category 3',
					],
					[
						'title'    => 'Image #4',
						'category' => 'Category 1',
					],
					[
						'title'    => 'Image #5',
						'category' => 'Category 2',
					],
					[
						'title'    => 'Image #6',
						'category' => 'Category 3',
					],
				],
				'frontend_available' => true,
				'fields'             => $repeater->get_controls(),
				'title_field'        => '{{{ "" !== title ? title : "Image" }}} - {{{ "" !== category ? category : "No Categories" }}}',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'default'   => 'medium_large',
				'separator' => 'before',
				'exclude'   => [
					'custom',
				],
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'              => esc_html__( 'Columns', 'zyre-elementor-addons' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => [
					'1' => esc_html__( 'Column - 1', 'zyre-elementor-addons' ),
					'2' => esc_html__( 'Columns - 2', 'zyre-elementor-addons' ),
					'3' => esc_html__( 'Columns - 3', 'zyre-elementor-addons' ),
					'4' => esc_html__( 'Columns - 4', 'zyre-elementor-addons' ),
					'5' => esc_html__( 'Columns - 5', 'zyre-elementor-addons' ),
					'6' => esc_html__( 'Columns - 6', 'zyre-elementor-addons' ),
				],
				'default'            => '4',
				'tablet_default'     => '3',
				'mobile_default'     => '2',
				'selectors'          => [
					'{{WRAPPER}} .zyre-image-grid-item' => '--image-grid-column: {{VALUE}};',
				],
				'frontend_available' => true,
				'style_transfer'     => true,
			]
		);

		$this->add_control(
			'link_switch',
			[
				'label'   => esc_html__( 'Set Link to', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'image',
				'options' => [
					'image'       => esc_html__( 'Image Only', 'zyre-elementor-addons' ),
					'title'       => esc_html__( 'Title Only', 'zyre-elementor-addons' ),
					'image_title' => esc_html__( 'Both Title & Image', 'zyre-elementor-addons' ),
					'item'        => esc_html__( 'Item Only', 'zyre-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'category_display',
			[
				'label'     => esc_html__( 'Display Category', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'On', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Off', 'zyre-elementor-addons' ),
			]
		);

		$this->add_responsive_control(
			'category_order',
			[
				'label'     => esc_html__( 'Category Order', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => -1,
				'max'       => 5,
				'selectors' => [
					'{{WRAPPER}} .zyre-image-grid-item-category' => 'order: {{VALUE}};',
				],
				'condition' => [
					'category_display' => 'yes',
				],
			]
		);

		$this->add_control(
			'content_display',
			[
				'label'        => esc_html__( 'Content Display', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => '',
				'options'      => [
					''        => esc_html__( 'Default', 'zyre-elementor-addons' ),
					'overlay' => esc_html__( 'Overlay', 'zyre-elementor-addons' ),
				],
				'prefix_class' => 'zyre-image-grid-content-display--',
				'render_type'  => 'template',
			]
		);

		$this->add_control(
			'filter_tabs_show',
			[
				'label'     => esc_html__( 'Filter Tabs', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'On', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Off', 'zyre-elementor-addons' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'filter_tabs_all',
			[
				'label'       => esc_html__( 'Filter All Label', 'zyre-elementor-addons' ),
				'default'     => esc_html__( 'All', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'condition'   => [
					'filter_tabs_show' => 'yes',
				],
			]
		);

		$this->add_control(
			'filter_tabs_separator',
			[
				'label'     => esc_html__( 'Tabs Separator', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'On', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Off', 'zyre-elementor-addons' ),
				'condition' => [
					'filter_tabs_show' => 'yes',
				],
			]
		);

		$this->add_control(
			'enable_lightbox',
			[
				'label'              => esc_html__( 'Enable Lightbox', 'zyre-elementor-addons' ),
				'type'               => Controls_Manager::SWITCHER,
				'separator'          => 'before',
				'return_value'       => 'yes',
				'frontend_available' => true,
			]
		);
	}

	protected function register_style_controls() {
		$this->__general_style_controls();
		$this->__item_style_controls();
		$this->__image_style_controls();
	}

	protected function __general_style_controls() {
		$this->start_controls_section(
			'section_general_style',
			[
				'label' => esc_html__( 'General', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,

			]
		);

		$this->end_controls_section();
	}

	protected function __item_style_controls() {
		$this->start_controls_section(
			'section_style_item',
			[
				'label' => esc_html__( 'Grid Item', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'item',
			[
				'selector'  => '{{WRAPPER}} .zyre-image-grid-item',
				'controls'  => [
					'height' => [],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __image_style_controls() {
		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__( 'Image', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'image',
			[
				'selector'  => '{{WRAPPER}} .zyre-image-grid-item',
				'controls'  => [
					'height' => [
						'description' => esc_html__( 'Image height is only applicable for Even layout', 'zyre-elementor-addons' ),
					],
					'margin' => [],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Format Category
	 *
	 * Format Category to be inserted in class attribute.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param string $category category slug.
	 *
	 * @return string The filtered $category_slug.
	 */
	public function format_category( $category ) {

		$category_slug = trim( $category );

		$category_slug = extension_loaded( 'mbstring' ) ? mb_strtolower( $category_slug ) : strtolower( $category_slug );

		if ( strpos( $category_slug, 'class' ) || strpos( $category_slug, 'src' ) ) {
			$category_slug = substr( $category_slug, strpos( $category_slug, '"' ) + 1 );
			$category_slug = strtok( $category_slug, '"' );
			$category_slug = preg_replace( '/[http:.]/', '', $category_slug );
			$category_slug = str_replace( '/', '', $category_slug );
		}

		$category_slug = str_replace( ', ', ',', $category_slug );
		$category_slug = preg_replace( '/[\s_`\'&@!#%]/', '-', $category_slug );
		$category_slug = str_replace( ',', ' ', $category_slug );

		return $category_slug;
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$show_filter_tabs = $settings['filter_tabs_show'];
		$is_enable_lightbox = ( 'yes' === $settings['enable_lightbox'] );

		$link_switch = ! empty( $settings['link_switch'] ) ? $settings['link_switch'] : 'image';
		$display_category = ( 'yes' === $settings['category_display'] );

		$this->add_render_attribute( 'items_wrap', 'class', 'zyre-image-grid-items zyre-isotope' );

		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			$this->add_render_attribute( 'items_wrap', 'class', 'zyre-isotope-' . $this->get_id() );
		}

		$content_display = $settings['content_display'] ?? '';

		$this->add_render_attribute(
			'content',
			'class',
			[
				'zyre-image-grid-item-content zy-flex zy-flex-wrap zy-relative',
			]
		);

		if ( 'overlay' === $content_display ) {
			$this->add_render_attribute(
				'content',
				'class',
				'zy-absolute zy-w-100 zy-h-100 zy-top-0 zy-left-0 zy-content-end zy-p-3 zy-index-1',
			);
		}

		if ( 'yes' === $show_filter_tabs ) {
			$filter_tabs = [];
			foreach ( $settings['all_items'] as $index => $item ) {
				if ( ! empty( $item['category'] ) ) {
					$formatted_category = $this->format_category( $item['category'] );
					$filter_tabs[$formatted_category] = [
						'item_cat' => $item['category'],
						'item_id'  => $item['_id'],
					];
				}
			}
			if ( ! empty( $filter_tabs ) ) :
				?>
				<div class="zyre-image-grid-filter-tabs zy-flex zy-align-center zy-gap-3">
					<?php if ( 'yes' === $settings['filter_tabs_separator'] ) : ?>
						<span class="zyre-image-grid-filter-separator zyre-image-grid-filter-separator zy-grow-1 zy-h-1 zy-bg-black"></span>
					<?php endif; ?>
					<ul class="zy-flex zy-m-0 zy-list-none zy-gap-2 zyre-js-filter-tabs" data-default-filter="<?php echo $this->_default_filter; ?>">
						<?php if ( ! empty( $settings['filter_tabs_all'] ) ) : ?>
							<li>
								<a href="javascript:;" class="zyre-image-grid-filter-tab" data-filter="*"><?php echo esc_html( $settings['filter_tabs_all'] ); ?></a>
							</li>
						<?php endif; ?>
						<?php
						foreach ( $filter_tabs as $key => $tab ) {
							$this->add_render_attribute(
								$key,
								'class',
								[
									'zyre-image-grid-filter-tab',
									'elementor-repeater-item-' . $tab['item_id'],
								]
							);

							$slug = sprintf( '.%s', $key );
							$this->add_render_attribute( $key, 'data-filter', $slug );
							?>
							<li>
								<a href="javascript:;" <?php echo wp_kses_post( $this->get_render_attribute_string( $key ) ); ?>><?php echo esc_html( $tab['item_cat'] ); ?></a>
							</li>
							<?php
						}
						?>
					</ul>
				</div>
				<?php
			endif;
		}
		?>
		
		<div <?php $this->print_render_attribute_string( 'items_wrap' ); ?>>
			<?php
			$items_total = count( $settings['all_items'] );

			foreach ( $settings['all_items'] as $index => $item ) :
				
				$key = 'item_' . $index;
				$image = $item['image'] ?? [];

				$link_key = 'link_' . $index;
				$image_link_key = 'image_' . $link_key;
				$this->add_link_attributes( $link_key, $item['link'] );

				$image_wrapper_tag = 'div';

				if ( ( 'image' === $link_switch || 'image_title' === $link_switch ) && ! empty( $item['link']['url'] ) ) {
					$image_wrapper_tag = 'a';
					$this->add_render_attribute(
						$image_link_key,
						$this->get_render_attributes( $link_key )
					);
				}

				$this->add_render_attribute(
					$key,
					[
						'class' => [
							'zyre-image-grid-item zy-relative',
							'elementor-repeater-item-' . $item['_id'],
							$this->format_category( $item['category'] ),
						],
					]
				);
				?>

				<div <?php echo wp_kses_post( $this->get_render_attribute_string( $key ) ); ?>>
					<<?php Utils::print_validated_html_tag( $image_wrapper_tag ); ?> <?php echo wp_kses_post( $this->get_render_attribute_string( $image_link_key ) ); ?> class="zyre-image-grid-item-img-wrapper zy-relative">
						<?php
						$url = $image['url'] ? $image['url'] : Utils::get_placeholder_image_src();
						$img_html = sprintf( '<img src="%s" class="zyre-image-grid-item-img" alt="%s">',
							esc_url( $url ),
							esc_attr( $item['title'] )
						);

						if ( isset( $image['source'] ) && $image['id'] && isset( $settings['image_size'] ) ) :
							$url = wp_get_attachment_image_src( $image['id'], 'full' );
							$img_html = wp_get_attachment_image(
								$image['id'],
								$settings['image_size'],
								[ 'class' => 'zyre-image-grid-item-img' ],
							);
						endif;

						echo $img_html;

						if ( $is_enable_lightbox ) {
							$lightbox_key = 'lightbox_' . $index;
							$this->add_render_attribute(
								$lightbox_key,
								[
									'href'                              => esc_url( $url ),
									'class'                             => 'zyre-js-lightbox zy-absolute zy-index-1',
									'data-elementor-open-lightbox'      => 'yes',
									'data-elementor-lightbox-slideshow' => $items_total > 1 ? $this->get_id() : false,
									'data-elementor-lightbox-title'     => esc_attr( $item['title'] ),
								]
							);
							?>
							<a <?php echo wp_kses_post( $this->get_render_attribute_string( $lightbox_key ) ); ?>>&times;</a>
							<?php
						}
						?>
					</<?php Utils::print_validated_html_tag( $image_wrapper_tag ); ?>>

					<?php 
					$title       = $item['title']       ?? '';
					$category    = $item['category']    ?? '';
					$description = $item['description'] ?? '';

					if ( $title || ( $display_category && $category ) || $description ) : ?>
						<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'content' ) ); ?>>
							<?php if ( $title ) : ?>
								<h3 class="zyre-image-grid-item-title zy-m-0 zy-w-100">
									<?php
									if ( ( 'title' === $link_switch || 'image_title' === $link_switch ) && ! empty( $item['link']['url'] ) ) {
										printf( '<a href="%s" %s>%s</a>',
											esc_url( $item['link']['url'] ),
											( $item['link']['is_external'] ?? '' ) ? 'target="_blank"' : '',
											esc_html( $item['title'] )
										);
									} else {
										echo esc_html( $item['title'] );
									}
									?>
								</h3>
							<?php endif; ?>

							<?php if ( $display_category && $category ) : ?>
								<p class="zyre-image-grid-item-category zy-m-0 zy-w-100"><?php echo esc_html( $item['category'] ); ?></p>
							<?php endif; ?>

							<?php if ( $description ) : ?>
								<p class="zyre-image-grid-item-description zy-m-0 zy-w-100"><?php echo esc_html( $item['description'] ); ?></p>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
				<?php
			endforeach; 
			?>
		</div>
		
		<?php
		/**
		 * Zyre Isotope adjustment.
		 *
		 * This code may look unnecessary,
		 * but it resolves a critical issue.
		 */
		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
			printf( '<script>jQuery(".zyre-isotope-%s").isotope();</script>', $this->get_id() );
		endif;
	}
}
