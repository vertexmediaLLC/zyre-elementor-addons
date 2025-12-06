<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Logo_Grid extends Base {

	public function get_title() {
		return esc_html__( 'Logo Grid', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Logo-grid';
	}

	public function get_keywords() {
		return [ 'logo', 'logo grids', 'logos grid', 'logo list', 'image grid', 'images', 'images grid', 'brand', 'client', 'brands', 'clients' ];
	}

	protected function register_content_controls() {
		$this->start_controls_section(
			'section_logo_content',
			[
				'label' => esc_html__( 'Logo Grids Content', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$repeater = new Repeater();

		$repeater->add_control(
			'logo_image',
			[
				'label'     => esc_html__( 'Logo Image', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'website_link',
			[
				'label'       => esc_html__( 'Website Link', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::URL,
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'Paste URL or type', 'zyre-elementor-addons' ),
				'default'     => [
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

		$repeater->add_control(
			'brand_name',
			[
				'label'       => esc_html__( 'Brand Name', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Brand Name', 'zyre-elementor-addons' ),
				'placeholder' => esc_html__( 'Enter Brand Name', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			'logo_list',
			[
				'label'       => esc_html__( 'Logo List', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'logo_image' => [
							'url' => Utils::get_placeholder_image_src(),
						],
						'website_link'  => [
							'url'         => '#',
							'is_external' => true,
							'nofollow'    => true,
						],
					],
					[
						'logo_image' => [
							'url' => Utils::get_placeholder_image_src(),
						],
						'website_link'  => [
							'url'         => '#',
							'is_external' => true,
							'nofollow'    => true,
						],
					],
					[
						'logo_image' => [
							'url' => Utils::get_placeholder_image_src(),
						],
						'website_link'  => [
							'url'         => '#',
							'is_external' => true,
							'nofollow'    => true,
						],
					],
					[
						'logo_image' => [
							'url' => Utils::get_placeholder_image_src(),
						],
						'website_link'  => [
							'url'         => '#',
							'is_external' => true,
							'nofollow'    => true,
						],
					],
					[
						'logo_image' => [
							'url' => Utils::get_placeholder_image_src(),
						],
						'website_link'  => [
							'url'         => '#',
							'is_external' => true,
							'nofollow'    => true,
						],
					],
					[
						'logo_image' => [
							'url' => Utils::get_placeholder_image_src(),
						],
						'website_link'  => [
							'url'         => '#',
							'is_external' => true,
							'nofollow'    => true,
						],
					],
					[
						'logo_image' => [
							'url' => Utils::get_placeholder_image_src(),
						],
						'website_link'  => [
							'url'         => '#',
							'is_external' => true,
							'nofollow'    => true,
						],
					],
					[
						'logo_image' => [
							'url' => Utils::get_placeholder_image_src(),
						],
						'website_link'  => [
							'url'         => '#',
							'is_external' => true,
							'nofollow'    => true,
						],
					],
				],
				'title_field' => '{{ brand_name }}',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'thumbnail',
				'default'   => 'full',
				'separator' => 'before',
				'exclude'   => ['custom'],
			]
		);

		$this->add_responsive_control(
			'logo_columns',
			[
				'label'           => esc_html__( 'Columns', 'zyre-elementor-addons' ),
				'type'            => Controls_Manager::SELECT,
				'options'         => [
					'1' => esc_html__( '1 Columns', 'zyre-elementor-addons' ),
					'2' => esc_html__( '2 Columns', 'zyre-elementor-addons' ),
					'3' => esc_html__( '3 Columns', 'zyre-elementor-addons' ),
					'4' => esc_html__( '4 Columns', 'zyre-elementor-addons' ),
					'5' => esc_html__( '5 Columns', 'zyre-elementor-addons' ),
					'6' => esc_html__( '6 Columns', 'zyre-elementor-addons' ),
				],
				'desktop_default' => '4',
				'tablet_default'  => '2',
				'mobile_default'  => '2',
				'prefix_class'    => 'zyre-logo-grid--col-%s',
				'style_transfer'  => true,
				'selectors'       => [
					'{{WRAPPER}} .zyre-logo-grid-contents' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
				],
			]
		);

		$this->add_control(
			'logo_grid_css_class',
			[
				'label'       => esc_html__( 'Class', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Class Name', 'zyre-elementor-addons' ),
				'prefix_class' => '',
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_controls() {
		$this->__general_style_controls();
		$this->__logo_box_style_controls();
		$this->__logo_item_style_controls();
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
			'logo',
			[
				'selector' => '{{WRAPPER}} .zyre-logo-grid-contents',
				'controls' => [
					'gap' => [],
				],
			]
		);

		$this->end_controls_section();
	}
	
	protected function __logo_box_style_controls() {

		$this->start_controls_section(
			'section_logo_box_style',
			[
				'label' => esc_html__( 'Logo Box', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'logo_box',
			[
				'selector' => '{{WRAPPER}} .zyre-logo-grid-content',
				'controls' => [
					'padding' => [],
					'margin'  => [],
				],
			]
		);

		// Tabs
		$this->start_controls_tabs( 'tabs_logo_box_style' );

		// Start Normal Tab
		$this->start_controls_tab(
			'tab_logo_box_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'logo_box',
			[
				'selector' => '{{WRAPPER}} .zyre-logo-grid-content',
				'controls' => [
					'background' => [],
					'border'     => [],
					'box_shadow' => [],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_logo_box_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'logo_box_hover',
			[
				'selector' => '{{WRAPPER}} .zyre-logo-grid-content:hover',
				'controls' => [
					'background'   => [],
					'border_color' => [],
					'box_shadow'   => [],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->set_style_controls(
			'logo_box',
			[
				'selector' => '{{WRAPPER}} .zyre-logo-grid-content',
				'controls' => [
					'border_radius' => [
						'separator' => 'before',
					],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __logo_item_style_controls() {

		$this->start_controls_section(
			'section_logo_item_style',
			[
				'label' => esc_html__( 'Logo Item', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'logo_image',
			[
				'selector' => '{{WRAPPER}} .zyre-logo-grid-content img',
				'controls' => [
					'width'      => [
						'label' => esc_html__( 'Image Width', 'zyre-elementor-addons' ),
						'range' => [
							'%'  => [
								'min' => 1,
								'max' => 100,
							],
							'px' => [
								'min' => 20,
								'max' => 2000,
							],
						],
					],
					'height'     => [
						'label' => esc_html__( 'Image Height', 'zyre-elementor-addons' ),
						'range' => [
							'%'  => [
								'min' => 1,
							],
							'px' => [
								'min' => 20,
								'max' => 1000,
							],
						],
					],
					'object_fit' => [
						'default' => 'cover',
					],
				],
			]
		);

		$this->set_style_controls(
			'logo_item',
			[
				'selector' => '{{WRAPPER}} .zyre-logo-grid-img-wrap',
				'controls' => [
					'width'   => [
						'label' => esc_html__( 'Item Width', 'zyre-elementor-addons' ),
						'range' => [
							'%'  => [
								'min' => 1,
								'max' => 100,
							],
							'px' => [
								'min' => 50,
								'max' => 2000,
							],
						],
					],
					'height'  => [
						'label' => esc_html__( 'Item Height', 'zyre-elementor-addons' ),
						'range' => [
							'%'  => [
								'min' => 1,
								'max' => 100,
							],
							'px' => [
								'min' => 50,
								'max' => 2000,
							],
						],
					],
					'padding' => [],
				],
			]
		);

		// Tabs
		$this->start_controls_tabs( 'tabs_logo_item_style' );

		// Start Normal Tab
		$this->start_controls_tab(
			'tab_logo_item_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'logo_image',
			[
				'selector' => '{{WRAPPER}} .zyre-logo-grid-content img',
				'controls' => [
					'opacity'    => [],
					'css_filter' => [],
				],
			]
		);

		$this->set_style_controls(
			'logo_item',
			[
				'selector' => '{{WRAPPER}} .zyre-logo-grid-img-wrap',
				'controls' => [
					'border'     => [],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_logo_item_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->set_style_controls(
			'logo_image_hover',
			[
				'selector' => '{{WRAPPER}} .zyre-logo-grid-content:hover img',
				'controls' => [
					'opacity'    => [],
					'css_filter' => [],
				],
			]
		);

		$this->add_control(
			'logo_image_hover_transition',
			[
				'label' => esc_html__( 'Transition Duration', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-logo-grid-content' => '--transition-duration: {{SIZE}}s;',
					'{{WRAPPER}} .zyre-logo-grid-content img' => '--transition-duration: {{SIZE}}s;',
				],
			]
		);

		$this->add_control(
			'logo_hover_animation',
			[
				'label' => esc_html__( 'Hover Animation', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
				'label_block' => true,
			]
		);

		$this->set_style_controls(
			'logo_item_hover',
			[
				'selector' => '{{WRAPPER}} .zyre-logo-grid-content:hover .zyre-logo-grid-img-wrap',
				'controls' => [
					'border_color' => [],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->set_style_controls(
			'logo_item',
			[
				'selector' => '{{WRAPPER}} .zyre-logo-grid-img-wrap',
				'controls' => [
					'border_radius' => [
						'separator' => 'before',
					],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['logo_list'] ) ) {
			return;
		}
		?>
	
		<div class="zyre-logo-grid-contents zy-grid zy-align-center zy-justify-center">
			<?php foreach ( $settings['logo_list'] as $index => $item ) :
				$image = $item['logo_image'];
				$repeater_key = 'grid_item' . $index;
				$tag = 'div';
				$this->add_render_attribute( $repeater_key, 'class', 'zyre-logo-grid-content zy-justify-center zy-align-center zy-flex' );

				if ( $item['website_link']['url'] ) {
					$tag = 'a';
					$this->add_render_attribute( $repeater_key, 'class', 'zyre-logo-grid-link' );
					$this->add_link_attributes( $repeater_key, $item['website_link'] );
				}
				?>
				<<?php echo $tag; ?> <?php $this->print_render_attribute_string( $repeater_key ); ?>>
					<?php if ( isset( $image['source'] ) && $image['id'] ) :
						$output = '<div class="zyre-logo-grid-img-wrap zy-self-stretch zy-content-center zy-grow-1 zy-text-center">';
						$output .= wp_get_attachment_image(
							$image['id'],
							$settings['thumbnail_size'],
							false,
							[
								'class' => 'zyre-logo-grid-img elementor-animation-' . esc_attr( $settings['logo_hover_animation'] ),
							]
						);
						$output .= '</div>';
						echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						else :
							$url = $image['url'] ? $image['url'] : Utils::get_placeholder_image_src();
							printf( '<div class="zyre-logo-grid-img-wrap zy-self-stretch zy-content-center zy-grow-1 zy-text-center"><img class="zyre-logo-grid-img elementor-animation-%s" src="%s" alt="%s"></div>',
								esc_attr( $settings['logo_hover_animation'] ),
								esc_url( $url ),
								esc_attr( $item['brand_name'] )
							);
						endif; ?>
				</<?php echo $tag; ?>>
			<?php endforeach; ?>
		</div>
	
		<?php
	}
}
