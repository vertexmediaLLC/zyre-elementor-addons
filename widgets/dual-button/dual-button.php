<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use ZyreAddons\Elementor\Traits\Button_Trait;

defined( 'ABSPATH' ) || die();

/**
 * The Button widget class
 *
 * @since 1.0.0
 * @package ZyreAddons
 */
class Dual_Button extends Base {

	use Button_Trait;

	/**
	 * Get widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Dual Button', 'zyre-elementor-addons' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'zy-fonticon zy-Dual-button';
	}

	/**
	 * Get widget search keywords.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_keywords() {
		return [ 'button', 'buttons', 'dual button', 'btn', 'link', 'links', 'actions' ];
	}

	/**
	 * Register widget content controls
	 */
	protected function register_content_controls() {
		$this->start_controls_section(
			'section_dual_button',
			[
				'label' => esc_html__( 'Dual Button Content', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		// Start Tabs
		$this->start_controls_tabs( 'tabs_dual_button' );

		// Primary Tab
		$this->start_controls_tab(
			'tab_primary',
			[
				'label' => esc_html__( 'Primary', 'zyre-elementor-addons' ),
			]
		);

		// Register content
		$this->register_button_content_controls(
			[
				'id_prefix' => 'primary',
				'button_default_text' => esc_html__( 'Get started', 'zyre-elementor-addons' ),
			]
		);

		$this->end_controls_tab();

		// Connector Tab
		$this->start_controls_tab(
			'tab_connector',
			[
				'label' => esc_html__( 'Connector', 'zyre-elementor-addons' ),
			]
		);

		$this->__connector_content_controls();

		$this->end_controls_tab();

		// Secondary Tab
		$this->start_controls_tab(
			'tab_secondary',
			[
				'label' => esc_html__( 'Secondary', 'zyre-elementor-addons' ),
			]
		);

		// Register content
		$this->register_button_content_controls( [ 'id_prefix' => 'secondary' ] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Connector Content Controls.
	 */
	protected function __connector_content_controls() {
		$this->add_control(
			'show_button_connector',
			[
				'label'        => esc_html__( 'Show Connector', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'zyre-elementor-addons' ),
				'label_off'    => esc_html__( 'Hide', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'button_connector_type',
			[
				'label'     => esc_html__( 'Connector Type', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'text' => esc_html__( 'Text', 'zyre-elementor-addons' ),
					'icon' => esc_html__( 'Icon', 'zyre-elementor-addons' ),
				],
				'default'   => 'text',
				'condition' => [
					'show_button_connector' => 'yes',
				],
			]
		);

		$this->add_control(
			'button_connector_text',
			[
				'label'       => esc_html__( 'Connector Text', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => esc_html__( 'OR', 'zyre-elementor-addons' ),
				'condition'   => [
					'show_button_connector'  => 'yes',
					'button_connector_type'  => 'text',
				],
				'ai' => false,
			]
		);

		$this->add_control(
			'button_connector_icon',
			[
				'label'     => esc_html__( 'Connector Icon', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'library' => 'fa-solid',
					'value'   => 'fa fa-angle-right',
				],
				'condition' => [
					'show_button_connector'  => 'yes',
					'button_connector_type'  => 'icon',
				],
			]
		);
	}

	/**
	 * Register widget style controls
	 */
	protected function register_style_controls() {
		$this->__general_style_controls();

		// Primary button style controls
		$this->start_controls_section(
			'section_primary_button_style',
			[
				'label' => esc_html__( 'Primary Button', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_button_style_controls( [ 'id_prefix' => 'primary' ] );

		$this->end_controls_section();

		// Primary Button Icon style controls
		$this->start_controls_section(
			'section_primary_button_icon_style',
			[
				'label'      => esc_html__( 'Primary Button Icon', 'zyre-elementor-addons' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'primary_button_icon[value]',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->register_button_icon_style_controls( [ 'id_prefix' => 'primary' ] );

		$this->end_controls_section();

		// Secondary button style controls
		$this->start_controls_section(
			'section_secondary_button_style',
			[
				'label' => esc_html__( 'Secondary Button', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_button_style_controls( [ 'id_prefix' => 'secondary' ] );

		$this->end_controls_section();

		// Secondary Button Icon style controls
		$this->start_controls_section(
			'section_secondary_button_icon_style',
			[
				'label'      => esc_html__( 'Secondary Button Icon', 'zyre-elementor-addons' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'secondary_button_icon[value]',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->register_button_icon_style_controls( [ 'id_prefix' => 'secondary' ] );

		$this->end_controls_section();

		// Connector style controls
		$this->__connector_style_controls();
	}

	/**
	 * General style controls
	 */
	protected function __general_style_controls() {
		$this->start_controls_section(
			'section_general_style',
			[
				'label' => esc_html__( 'General', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'dual_button',
			[
				'selector' => '{{WRAPPER}} .zyre-dual-button-wrapper',
				'controls' => [
					'width'          => [
						'range'      => [
							'%'  => [
								'min' => 5,
							],
							'px' => [
								'min' => 50,
							],
						],
					],
					'layout'          => [
						'label'     => esc_html__( 'Layout', 'zyre-elementor-addons' ),
						'default'   => 'row',
						'prefix_class' => 'zyre-dual-button--layout-',
					],
					'justify_content' => [
						'label'       => esc_html__( 'Justify Content', 'zyre-elementor-addons' ),
						'label_block' => true,
						'condition'   => [
							'dual_button_layout' => 'row',
						],
					],
					'gap'             => [
						'label'     => esc_html__( 'Spacing', 'zyre-elementor-addons' ),
						'default'   => [
							'unit' => 'px',
						],
						'range'     => [
							'px' => [
								'max' => 500,
							],
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'dual_button_position',
			[
				'label'        => esc_html__( 'Position', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'left'    => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'   => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'selectors_dictionary' => [
					'left'     => 'margin-right: auto;align-items:flex-start;',
					'center'  => 'margin-left: auto;margin-right: auto;align-items:center;',
					'right'  => 'margin-left: auto;align-items:flex-end;',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-dual-button-wrapper' => '{{VALUE}};',
				],
			]
		);

		$this->set_style_controls(
			'dual_button',
			[
				'selector' => '{{WRAPPER}} .zyre-dual-button-wrapper',
				'controls' => [
					'background'    => [],
					'box_shadow'    => [],
					'border'        => [
						'separator' => 'before',
					],
					'border_radius' => [],
					'padding'       => [],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Connector style controls
	 */
	protected function __connector_style_controls() {
		$this->start_controls_section(
			'section_button_connector_style',
			[
				'label'      => esc_html__( 'Connector', 'zyre-elementor-addons' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_button_connector'  => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'button_connector',
			[
				'selector' => '{{WRAPPER}} .zyre-button-connector-text',
				'controls' => [
					'typography' => [],
				],
				'condition' => [
					'button_connector_type'  => 'text',
					'button_connector_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_connector_color',
			[
				'label'     => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .zyre-button-connector, {{WRAPPER}} .zyre-button-connector > i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-button-connector > svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->set_style_controls(
			'button_connector',
			[
				'selector' => '{{WRAPPER}} .zyre-button-connector',
				'controls' => [
					'background' => [],
					'icon_size'  => [
						'selector'  => '{{WRAPPER}} .zyre-button-connector-icon',
						'default'   => [
							'unit' => 'px',
						],
						'range'     => [
							'px' => [
								'min' => 5,
								'max' => 500,
							],
						],
						'condition' => [
							'button_connector_type'         => 'icon',
							'button_connector_icon[value]!' => '',
						],
					],
					'width'      => [
						'size_units' => [ 'px' ],
						'range'      => [
							'px' => [
								'min' => 5,
								'max' => 500,
							],
						],
					],
					'height'     => [
						'size_units' => [ 'px' ],
						'range'      => [
							'px' => [
								'min' => 5,
								'max' => 500,
							],
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'button_connector_align',
			[
				'label'        => esc_html__( 'Align', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'left'    => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'   => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'selectors_dictionary' => [
					'left'     => 'margin-right: auto;',
					'center'  => 'margin-left: auto;margin-right: auto;',
					'right'  => 'margin-left: auto;',
				],
				'selectors'            => [
					'{{WRAPPER}} .zyre-button-connector-wrapper' => '{{VALUE}};',
				],
			]
		);

		$this->set_style_controls(
			'button_connector_wrapper',
			[
				'selector' => '{{WRAPPER}} .zyre-button-connector-wrapper',
				'controls' => [
					'width' => [
						'label'     => esc_html__( 'Wrapper Width', 'zyre-elementor-addons' ),
						'condition' => [
							'dual_button_layout' => 'column',
						],
					],
				],
			]
		);

		$this->add_control(
			'button_connector_position',
			[
				'label' => esc_html__( 'Position', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => esc_html__( 'Default', 'zyre-elementor-addons' ),
					'absolute' => esc_html__( 'Absolute', 'zyre-elementor-addons' ),
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-button-connector' => 'position: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'button_connector_offset_x',
			[
				'label' => esc_html__( 'Horizontal Offset', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'%' => [
						'min' => -100,
						'max' => 100,
					],
					'px' => [
						'min' => -1000,
						'max' => 1000,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => -50,
				],
				'size_units' => [ '%', 'px' ],
				'selectors' => [
					'{{WRAPPER}} .zyre-button-connector' => '--translate-x: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'button_connector_position!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'button_connector_offset_y',
			[
				'label' => esc_html__( 'Vertical Offset', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'%' => [
						'min' => -100,
						'max' => 100,
					],
					'px' => [
						'min' => -1000,
						'max' => 1000,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => -50,
				],
				'size_units' => [ '%', 'px' ],
				'selectors' => [
					'{{WRAPPER}} .zyre-button-connector' => '--translate-y: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'button_connector_position!' => '',
				],
			]
		);

		$this->set_style_controls(
			'button_connector',
			[
				'selector' => '{{WRAPPER}} .zyre-button-connector',
				'controls' => [
					'z_index'       => [
						'min' => 0,
					],
					'border'        => [
						'separator' => 'before',
					],
					'border_radius' => [],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Rendering HTML
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<div class="zyre-dual-button-wrapper zy-flex zy-align-center zy-justify-center">
			<?php $this->render_button( null, [ 'id_prefix' => 'primary' ] ); ?>

			<?php if ( 'yes' === $settings['show_button_connector'] ) { ?>
			<span class="zyre-button-connector-wrapper zy-relative">
				<?php if ( 'text' === $settings['button_connector_type'] ) { ?>
					<span class="zyre-button-connector zyre-button-connector-text zy-flex zy-align-center zy-justify-center zy-nowrap"><?php echo esc_html( $settings['button_connector_text'] ); ?></span>
				<?php } ?>
				<?php if ( 'icon' === $settings['button_connector_type'] ) { ?>
					<span class="zyre-button-connector zyre-button-connector-icon zy-flex zy-align-center zy-justify-center zy-nowrap"><?php Icons_Manager::render_icon( $settings['button_connector_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
				<?php } ?>
			</span>
			<?php } ?>

			<?php $this->render_button( null, [ 'id_prefix' => 'secondary' ] ); ?>
		</div>
		<?php
	}
}
