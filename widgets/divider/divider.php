<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Icons_Manager;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Divider extends Base {

	public function get_title() {
		return esc_html__( 'Divider', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Devider-line';
	}

	public function get_keywords() {
		return [ 'divider', 'line', 'border', 'horizontal', 'vertical' ];
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	protected function register_content_controls() {
		$this->start_controls_section(
			'section_divider_content',
			[
				'label' => esc_html__( 'Divider Content', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$this->add_control(
			'show_element',
			[
				'label'        => esc_html__( 'Show Element', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::CHOOSE,
				'default'      => 'text',
				'options'      => [
					'none' => [
						'title' => esc_html__( 'None', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-ban',
					],
					'text' => [
						'title' => esc_html__( 'Text', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-text',
					],
					'icon' => [
						'title' => esc_html__( 'Icon', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-star',
					],
				],
				'prefix_class' => 'zyre-divider--',
				'render_type'  => 'template', // Important for live preview to update
				'toggle' => false,
			]
		);

		$this->add_control(
			'divider_text',
			[
				'label'     => esc_html__( 'Text', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Divider', 'zyre-elementor-addons' ),
				'condition' => [
					'show_element' => 'text',
				],
			]
		);

		$this->add_control(
			'divider_text_html_tag',
			[
				'label'     => esc_html__( 'Text HTML Tag', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'span',
				'options'   => [
					'span' => 'span',
					'div'  => 'div',
					'h2'   => 'h2',
					'h3'   => 'h3',
					'h4'   => 'h4',
					'h5'   => 'h5',
					'h6'   => 'h6',
					'p'    => 'p',
				],
				'condition' => [
					'show_element' => 'text',
				],
			]
		);

		$this->add_control(
			'divider_icon',
			[
				'label'       => esc_html__( 'Icon', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => [
					'value'   => 'fas fa-asterisk',
					'library' => 'fa-solid',
				],
				'skin'        => 'inline',
				'label_block' => false,
				'condition'   => [
					'show_element' => 'icon',
				],
			]
		);

		$this->add_control(
			'divider_css_class',
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
		$this->__divider_style_controls();
		$this->__divider_text_style_controls();
		$this->__divider_icon_style_controls();
	}

	protected function __divider_style_controls() {
		$this->start_controls_section(
			'section_divider_style',
			[
				'label'     => esc_html__( 'Divider', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'divider',
			[
				'selector' => '{{WRAPPER}} .zyre-divider-separator',
				'controls' => [
					'width'      => [
						'default' => [
							'unit' => '%',
						],
					],
					'height'     => [
						'default' => [
							'unit' => 'px',
						],
					],
					'direction'  => [
						'default'      => 'row',
						'prefix_class' => 'zyre-divider--',
					],
					'align_x'    => [
						'selector' => '{{WRAPPER}} .zyre-divider',
						'options'  => [
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
					'position_y' => [
						'condition' => [
							'divider_direction' => 'vertical',
						],
					],
					'gap'        => [],
				],
			]
		);

		$this->add_control(
			'_heading_left_line',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Left Separator', 'zyre-elementor-addons' ),
				'separator' => 'before',
				'condition' => [
					'icon_opt!' => 'left',
					'text_opt!' => 'left',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'left_line',
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width'  => [
						'default' => [
							'top'      => "1",
							'right'    => "0",
							'bottom'   => "0",
							'left'     => "0",
							'isLinked' => false,
						],
					],
					'color'  => [
						'default' => '#8C919B',
					],
				],
				'selector'       => '{{WRAPPER}} .zyre-divider-separator::before',
				'condition'      => [
					'icon_opt!' => 'left',
					'text_opt!' => 'left',
				],
			]
		);

		$this->add_control(
			'_heading_right_line',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Right Separator', 'zyre-elementor-addons' ),
				'separator' => 'before',
				'condition' => [
					'icon_opt!' => 'right',
					'text_opt!' => 'right',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'right_line',
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width'  => [
						'default' => [
							'top'      => "1",
							'right'    => "0",
							'bottom'   => "0",
							'left'     => "0",
							'isLinked' => false,
						],
					],
					'color'  => [
						'default' => '#8C919B',
					],
				],
				'selector'       => '{{WRAPPER}} .zyre-divider-separator::after',
				'condition'      => [
					'icon_opt!' => 'right',
					'text_opt!' => 'right',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __divider_text_style_controls() {

		$this->start_controls_section(
			'section_divider_text_style',
			[
				'label'     => esc_html__( 'Divider Text', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_element' => 'text',
				],
			]
		);

		$this->set_style_controls(
			'text',
			[
				'selector' => '{{WRAPPER}} .zyre-divider-text',
				'controls' => [
					'typography'    => [
						'fields_options' => [
							'typography'  => [
								'default' => 'custom',
							],
							'font_family' => [
								'default' => 'Inter Tight',
							],
							'font_size'   => [
								'default' => [
									'size' => 36,
									'unit' => 'px',
								],
							],
						],
					],
					'background'    => [],
					'color'         => [
						'default' => '#000000',
					],
					'border_radius' => [],
					'width'         => [],
					'options'       => [
						'label'        => esc_html__( 'Position', 'zyre-elementor-addons' ),
						'options'      => [
							'left'   => [
								'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
								'icon'  => 'eicon-h-align-left',
							],
							'center' => [
								'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
								'icon'  => 'eicon-h-align-center',
							],
							'right'  => [
								'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
								'icon'  => 'eicon-h-align-right',
							],
						],
						'default'      => 'center',
						'prefix_class' => 'zyre-divider--element-align-',
						'separator'    => 'before',
					],
					'rotate'        => [
						'selector' => '{{WRAPPER}} .zyre-divider-text',
					],
					'padding'       => [],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __divider_icon_style_controls() {
		$this->start_controls_section(
			'section_divider_icon_style',
			[
				'label'     => esc_html__( 'Divider Icon', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_element' => 'icon',
				],
			]
		);

		$this->set_style_controls(
			'icon',
			[
				'selector' => '{{WRAPPER}} .zyre-divider-icon',
				'controls' => [
					'icon_size'     => [
						'label' => esc_html__( 'Size', 'zyre-elementor-addons' ),
						'range' => [
							'px' => [
								'min' => 6,
								'max' => 300,
							],
						],
					],
					'background'    => [],
					'icon_color'    => [
						'default' => '#000000',
					],
					'width'         => [
						'label' => esc_html__( 'Icon Background Width', 'zyre-elementor-addons' ),
					],
					'height'        => [
						'label' => esc_html__( 'Icon Background Height', 'zyre-elementor-addons' ),
					],
					'border'        => [],
					'border_radius' => [],
					'options'       => [
						'label'        => esc_html__( 'Position', 'zyre-elementor-addons' ),
						'options'      => [
							'left'   => [
								'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
								'icon'  => 'eicon-h-align-left',
							],
							'center' => [
								'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
								'icon'  => 'eicon-h-align-center',
							],
							'right'  => [
								'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
								'icon'  => 'eicon-h-align-right',
							],
						],
						'default'      => 'center',
						'prefix_class' => 'zyre-divider--element-align-',
						'separator'    => 'before',
					],
					'rotate'        => [
						'selector' => '{{WRAPPER}} .zyre-divider-icon i, {{WRAPPER}} .zyre-divider-icon svg',
					],
					'padding'       => [],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$text_html_tag = $settings['divider_text_html_tag'];

		$has_icon = 'icon' === ( $settings['show_element'] ) && ! empty( $settings['divider_icon'] );
		$has_text = 'text' === ( $settings['show_element'] ) && ! empty( $settings['divider_text'] );
		?>

		<div class="zyre-divider zy-flex">
			<div class="zyre-divider-separator zy-flex zy-align-center">
				<?php if ( $has_text ) :
					$this->add_inline_editing_attributes( 'divider_text' );
					$this->add_render_attribute( 'divider_text', 'class', 'zyre-divider-text zy-relative zy-index-1 zy-shrink-0' );
					?>
					<<?php Utils::print_validated_html_tag( $text_html_tag ); ?> <?php $this->print_render_attribute_string( 'divider_text' ); ?>>
						<?php echo zyre_kses_basic( $settings['divider_text'] ); ?>
					</<?php Utils::print_validated_html_tag( $text_html_tag ); ?>>
				<?php elseif ( $has_icon ) : ?>
					<span class="zyre-divider-icon zy-relative zy-index-1 zy-text-center zy-content-center zy-shrink-0">
						<?php
						Icons_Manager::render_icon( $settings['divider_icon'], [
							'aria-hidden' => 'true',
						] );
						?>
					</span>
				<?php endif; ?>
			</div>
		</div>

		<?php
	}
}