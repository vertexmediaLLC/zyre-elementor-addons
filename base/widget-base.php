<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use ZyreAddons\Elementor\Controls\Style_Control;
use ZyreAddons\Elementor\Widgets_Manager;

defined( 'ABSPATH' ) || die();

/**
 * Base class for the Widgets
 *
 * @since 1.0.0
 * @package ZyreAddons
 */
abstract class Base extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		/**
		 * Automatically generate widget name from class
		 *
		 * Button will be button
		 */
		$name = str_replace( strtolower( __NAMESPACE__ ), '', strtolower( $this->get_class_name() ) );
		$name = str_replace( '_', '-', $name );
		$name = ltrim( $name, '\\' );
		return 'zyre-' . $name;
	}

	/**
	 * Get widget categories.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'zyre_addons_category' );
	}

	/**
	 * Overriding custom wrapper class.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	protected function get_custom_wrapper_class() {
		return '';
	}

	/**
	 * Overriding default function to add custom html class.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_html_wrapper_class() {
		$html_class = parent::get_html_wrapper_class();
		$html_class .= ' zyre-addon';
		$html_class .= ' ' . str_replace( 'zyre', 'zyre-addon', $this->get_name() );
		$html_class .= ' ' . $this->get_custom_wrapper_class();

		return rtrim( $html_class );
	}

	/**
	 * Register widget controls
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		do_action( 'zyreaddons_before_register_content_controls', $this );

		$this->register_content_controls();

		do_action( 'zyreaddons_after_register_content_controls', $this );

		$this->register_style_controls();

		do_action( 'zyreaddons_after_register_style_controls', $this );
	}

	/**
	 * Register content controls
	 *
	 * @since 1.0.0
	 * @return void
	 */
	abstract protected function register_content_controls();

	/**
	 * Register style controls
	 *
	 * @since 1.0.0
	 * @return void
	 */
	abstract protected function register_style_controls();

	/**
	 * Set pre-style controls.
	 * @since 1.0.0
	 */
	protected function set_prestyle_controls() {
		$widget_name = str_replace( 'zyre-', '', $this->get_name() );

		$this->add_control(
			$widget_name . '_style',
			[
				'label'          => $this->get_title() . esc_html__( ' Style', 'zyre-elementor-addons' ),
				'label_block'    => true,
				'type'           => Style_Control::TYPE,
				'options'        => Widgets_Manager::get_the_widget_style_options( $widget_name ),
				'disabled'       => Widgets_Manager::get_the_widget_inactive_styles_keys( $widget_name ),
				'default'        => Widgets_Manager::get_the_widget_style_default( $widget_name ),
				'style_transfer' => true,
				'prefix_class'   => "zyre-{$widget_name}-style-",
			]
		);

		$this->add_control(
			'_alert_' . $widget_name . '_style',
			[
				'type'      => Controls_Manager::RAW_HTML,
				'raw'       => Widgets_Manager::get_the_styles_notice( $widget_name ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);
	}

	/**
	 * Set style controls.
	 *
	 * @param string $prefix The prefix of the controls.
	 * @param array $args The element selector, controls list and more.
	 */
	protected function set_style_controls( string $prefix, array $args ) {
		$selector = ! empty( $args['selector'] ) ? $args['selector'] : '{{WRAPPER}}';
		$controls = ! empty( $args['controls'] ) ? $args['controls'] : [];
		$condition = ! empty( $args['condition'] ) && is_array( $args['condition'] ) ? $args['condition'] : [];

		if ( ! empty( $controls ) && is_array( $controls ) ) {
			foreach ( $controls as $key => $values ) {

				$control_name = $prefix . '_' . $key;

				switch ( $key ) {

					case 'heading':
						$control_args = [
							'label' => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Heading', 'zyre-elementor-addons' ),
							'type' => Controls_Manager::HEADING,
							'condition' => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_control( 'heading_' . $prefix, $control_args );
						break;

					case 'typography':
					case 'typo':
						$control_args = [
							'name'           => $control_name,
							'label'          => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Typography', 'zyre-elementor-addons' ),
							'fields_options' => ! empty( $values['fields_options'] ) && is_array( $values['fields_options'] ) ? $values['fields_options'] : [],
							'selector'       => ! empty( $values['selector'] ) ? $values['selector'] : $selector,
							'condition'      => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						$this->add_group_control( Group_Control_Typography::get_type(), $control_args );
						break;

					case 'stroke':
						$control_args = [
							'name'           => $control_name,
							'label'          => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Text Stroke', 'zyre-elementor-addons' ),
							'selector'       => ! empty( $values['selector'] ) ? $values['selector'] : $selector,
							'condition'      => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						$this->add_group_control( Group_Control_Text_Stroke::get_type(), $control_args );
						break;

					case 'font_size':
					case 'icon_size':
						$allowed_props = [ 'font-size', '--icon-size' ];
						$css_property = ! empty( $values['css_property'] ) && in_array( $values['css_property'], $allowed_props, true ) ? $values['css_property'] : 'font-size';
						$control_args = [
							'label'      => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Icon Size', 'zyre-elementor-addons' ),
							'type'       => Controls_Manager::SLIDER,
							'size_units' => ! empty( $values['size_units'] ) ? $values['size_units'] : [ 'px', 'em', 'rem', 'custom' ],
							'range'      => ! empty( $values['range'] ) ? $values['range'] : [
								'px' => [
									'max' => 100,
								],
							],
							'default'    => isset( $values['default'] ) && is_array( $values['default'] ) ? $values['default'] : [],
							'selectors'  => [
								! empty( $values['selector'] ) ? $values['selector'] : $selector => "{$css_property}: {{SIZE}}{{UNIT}};",
							],
							'condition' => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_responsive_control( $control_name, $control_args );
						break;

					case 'font_weight':
						$allowed_defaults = [ '200', '300', '400', '500', '600', '700', '800', '900' ];
						$control_args = [
							'label'   => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Font Weight', 'zyre-elementor-addons' ),
							'type'    => Controls_Manager::SELECT,
							'options' => ! empty( $values['options'] ) && is_array( $values['options'] ) ? $values['options'] : [
								'300' => esc_html__( '300 (Light)', 'zyre-elementor-addons' ),
								'400' => esc_html__( '400 (Normal)', 'zyre-elementor-addons' ),
								'500' => esc_html__( '500 (Medium)', 'zyre-elementor-addons' ),
								'600' => esc_html__( '600 (Semi Bold)', 'zyre-elementor-addons' ),
								'700' => esc_html__( '700 (Bold)', 'zyre-elementor-addons' ),
							],
							'default' => ! empty( $values['default'] ) && in_array( $values['default'], $allowed_defaults, true ) ? $values['default'] : '400',
							'selectors'            => [
								! empty( $values['selector'] ) ? $values['selector'] : $selector => 'font-weight: {{VALUE}};',
							],
							'condition' => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						$this->add_control( $control_name, $control_args );
						break;

					case 'background':
					case 'bg':
						$control_args = [
							'name'           => $control_name,
							'label'          => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Background', 'zyre-elementor-addons' ),
							'types'          => ! empty( $values['types'] ) && is_array( $values['types'] ) ? $values['types'] : [ 'classic', 'gradient' ],
							'exclude'        => isset( $values['exclude'] ) && is_array( $values['exclude'] ) ? $values['exclude'] : [ 'image' ],
							'fields_options' => ! empty( $values['fields_options'] ) && is_array( $values['fields_options'] ) ? $values['fields_options'] : [],
							'selector'       => ! empty( $values['selector'] ) ? $values['selector'] : $selector,
						];
						$this->add_group_control( Group_Control_Background::get_type(), $control_args );
						break;

					case 'background_clip':
						$allowed_defaults = [ 'content-box', 'padding-box', 'text', 'inherit' ];
						$control_args = [
							'label'     => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Background Clip', 'zyre-elementor-addons' ),
							'type'      => Controls_Manager::SELECT,
							'options'   => ! empty( $values['options'] ) && is_array( $values['options'] ) ? $values['options'] : [
								'content-box' => esc_html__( 'Content Box', 'zyre-elementor-addons' ),
								'padding-box' => esc_html__( 'Padding Box', 'zyre-elementor-addons' ),
								'text'        => esc_html__( 'Text', 'zyre-elementor-addons' ),
								'inherit'     => esc_html__( 'Inherit', 'zyre-elementor-addons' ),
							],
							'default'   => ! empty( $values['default'] ) && in_array( $values['default'], $allowed_defaults, true ) ? $values['default'] : 'text',
							'selectors' => [
								! empty( $values['selector'] ) ? $values['selector'] : $selector => 'background-clip: {{VALUE}};',
							],
							'condition' => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						$this->add_control( $control_name, $control_args );
						break;

					case 'bg_color':
					case 'bg_color_hover':
						$priority = isset( $values['priority'] ) && true === $values['priority'] ? ' !important' : '';
						$control_args = [
							'label' => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Background Color', 'zyre-elementor-addons' ),
							'type' => Controls_Manager::COLOR,
							'default' => ! empty( $values['default'] ) ? sanitize_hex_color( $values['default'] ) : '',
							'selectors' => [
								! empty( $values['selector'] ) ? $values['selector'] : $selector => 'background-color: {{VALUE}}' . $priority,
							],
							'condition' => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_control( $control_name, $control_args );
						break;

					case 'color':
					case 'color_hover':
					case 'text_color':
						$priority = isset( $values['priority'] ) && true === $values['priority'] ? ' !important' : '';
						$control_args = [
							'label' => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Color', 'zyre-elementor-addons' ), //priority
							'type' => Controls_Manager::COLOR,
							'default' => ! empty( $values['default'] ) ? sanitize_hex_color( $values['default'] ) : '',
							'selectors' => [
								! empty( $values['selector'] ) ? $values['selector'] : $selector => 'color: {{VALUE}}' . $priority,
							],
							'condition' => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_control( $control_name, $control_args );
						break;

					case 'shadow':
					case 'text_shadow':
						$control_args = [
							'label' => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Text Shadow', 'zyre-elementor-addons' ),
							'name'     => $control_name,
							'selector' => ! empty( $values['selector'] ) ? $values['selector'] : $selector,
							'condition' => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						$this->add_group_control( Group_Control_Text_Shadow::get_type(), $control_args );
						break;

					case 'icon_color':
						$control_args = [
							'label'     => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Icon Color', 'zyre-elementor-addons' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => ! empty( $values['default'] ) ? sanitize_hex_color( $values['default'] ) : '',
							'selectors' => [
								! empty( $values['selector'] ) ? $values['selector'] . ' i' : $selector . ' i'     => 'color: {{VALUE}}',
								! empty( $values['selector'] ) ? $values['selector'] . ' svg' : $selector . ' svg' => 'fill: {{VALUE}}',
							],
							'condition' => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_control( $control_name, $control_args );
						break;

					case 'border':
						$control_args = [
							'name'      => $control_name,
							'label'     => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Border', 'zyre-elementor-addons' ),
							'fields_options' => ! empty( $values['fields_options'] ) ? $values['fields_options'] : [],
							'selector'  => ! empty( $values['selector'] ) ? $values['selector'] : $selector,
							'condition' => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_group_control( Group_Control_Border::get_type(), $control_args );
						break;

					case 'border_color':
						$priority = isset( $values['priority'] ) && true === $values['priority'] ? ' !important' : '';
						$allowed_props = [ 'border-color', 'border-left-color', 'border-top-color', 'border-right-color', 'border-bottom-color' ];
						$css_property = ! empty( $values['css_property'] ) && in_array( $values['css_property'], $allowed_props, true ) ? $values['css_property'] : 'border-color';
						$control_args = [
							'label' => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Border Color', 'zyre-elementor-addons' ),
							'type' => Controls_Manager::COLOR,
							'default' => ! empty( $values['default'] ) ? sanitize_hex_color( $values['default'] ) : '',
							'selectors' => [
								! empty( $values['selector'] ) ? $values['selector'] : $selector => "{$css_property}: {{VALUE}}" . $priority,
							],
							'condition' => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_control( $control_name, $control_args );
						break;

					case 'border_width':
						$allowed_props = [ 'border-width', 'border-left-width', 'border-top-width', 'border-right-width', 'border-bottom-width', 'border-block-start-width', 'border-inline-start-width' ];
						$css_property = ! empty( $values['css_property'] ) && in_array( $values['css_property'], $allowed_props, true ) ? $values['css_property'] : 'border-inline-start-width';
						$control_args = [
							'label' => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Border Width', 'zyre-elementor-addons' ),
							'type' => Controls_Manager::SLIDER,
							'size_units' => ! empty( $values['size_units'] ) && is_array( $values['size_units'] ) ? $values['size_units'] : [ 'px', 'em', 'rem', 'custom' ],
							'default' => ! empty( $values['default'] ) && is_array( $values['default'] ) ? $values['default'] : [
								'size' => 1,
							],
							'range' => ! empty( $values['range'] ) && is_array( $values['range'] ) ? $values['range'] : [
								'px' => [
									'min' => 1,
									'max' => 20,
								],
							],
							'condition' => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
							'selectors' => [
								! empty( $values['selector'] ) ? $values['selector'] : $selector => "{$css_property}: {{SIZE}}{{UNIT}}",
							],
						];
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_control( $control_name, $control_args );
						break;

					case 'border_radius':
						$control_args = [
							'label'      => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Border Radius', 'zyre-elementor-addons' ),
							'type'       => Controls_Manager::DIMENSIONS,
							'size_units' => ! empty( $values['size_units'] ) ? $values['size_units'] : [ 'px', '%' ],
							'default' => ! empty( $values['default'] ) ? $values['default'] : [],
							'selectors'  => [
								! empty( $values['selector'] ) ? $values['selector'] : $selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							],
							'condition'  => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_responsive_control( $control_name, $control_args );
						break;

					case 'box_shadow':
						$control_args = [
							'name'      => $control_name,
							'label'     => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Box Shadow', 'zyre-elementor-addons' ),
							'fields_options' => ! empty( $values['fields_options'] ) ? $values['fields_options'] : [],
							'exclude' => isset( $values['exclude'] ) && is_array( $values['exclude'] ) ? $values['exclude'] : [],
							'selector'  => ! empty( $values['selector'] ) ? $values['selector'] : $selector,
							'condition' => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_group_control( Group_Control_Box_Shadow::get_type(), $control_args );
						break;

					case 'opacity':
						$control_args = [
							'label'     => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Opacity', 'zyre-elementor-addons' ),
							'type'      => Controls_Manager::SLIDER,
							'range'     => ! empty( $values['range'] ) && is_array( $values['range'] ) ? $values['range'] : [
								'px' => [
									'max'  => 1,
									'min'  => 0.10,
									'step' => 0.01,
								],
							],
							'selectors' => [
								! empty( $values['selector'] ) ? $values['selector'] : $selector => 'opacity: {{SIZE}}',
							],
							'condition' => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						$this->add_control( $control_name, $control_args );
						break;

					case 'css_filter':
						$this->add_group_control(
							Group_Control_Css_Filter::get_type(),
							[
								'name' => $control_name,
								'selector' => ! empty( $values['selector'] ) ? $values['selector'] : $selector,
								'condition' => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
							]
						);
						break;

					case 'margin':
						$control_args = [
							'label'      => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Margin', 'zyre-elementor-addons' ),
							'type'       => Controls_Manager::DIMENSIONS,
							'size_units' => ! empty( $values['size_units'] ) ? $values['size_units'] : [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
							'default' => isset( $values['default'] ) && is_array( $values['default'] ) ? $values['default'] : [],
							'selectors'  => [
								! empty( $values['selector'] ) ? $values['selector'] : $selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							],
							'condition'  => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_responsive_control( $control_name, $control_args );
						break;

					case 'padding':
						$control_args = [
							'label'      => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Padding', 'zyre-elementor-addons' ),
							'type'       => Controls_Manager::DIMENSIONS,
							'size_units' => ! empty( $values['size_units'] ) ? $values['size_units'] : [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
							'default'    => isset( $values['default'] ) && is_array( $values['default'] ) ? $values['default'] : [],
							'selectors'  => [
								! empty( $values['selector'] ) ? $values['selector'] : $selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							],
							'condition'  => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_responsive_control( $control_name, $control_args );
						break;

					case 'space':
					case 'spacing':
					case 'bottom_spacing':
					case 'margin_bottom':
					case 'margin_top':
						$allowed_props = [ 'padding-left', 'padding-top', 'padding-right', 'padding-inline-end', 'padding-inline-start', 'padding-block-start', 'padding-block-end', 'padding-bottom', 'margin-left', 'margin-top', 'margin-right', 'margin-top', 'margin-inline-end', 'margin-inline-start', 'margin-block-start', 'margin-block-end' ];
						$css_property = ! empty( $values['css_property'] ) && in_array( $values['css_property'], $allowed_props, true ) ? $values['css_property'] : 'margin-bottom';
						$priority = isset( $values['priority'] ) && true === $values['priority'] ? ' !important' : '';
						$control_args = [
							'label'       => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Spacing', 'zyre-elementor-addons' ),
							'description' => ! empty( $values['description'] ) ? esc_html( $values['description'] ) : '',
							'size_units'  => ! empty( $values['size_units'] ) ? $values['size_units'] : [ 'px', '%', 'em', 'rem', 'custom' ],
							'range'       => ! empty( $values['range'] ) ? $values['range'] : [
								'px' => [
									'max' => 100,
								],
							],
							'default'     => isset( $values['default'] ) && is_array( $values['default'] ) ? $values['default'] : [],
							'type'        => Controls_Manager::SLIDER,
							'selectors'   => [
								! empty( $values['selector'] ) ? $values['selector'] : $selector => "{$css_property}: {{SIZE}}{{UNIT}}{$priority};",
							],
							'condition' => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_responsive_control( $control_name, $control_args );
						break;

					case 'width':
					case 'min_width':
					case 'max_width':
						$allowed_props = [ 'width', 'min-width', 'max-width', '--width', 'border-width', '--border-width' ];
						$css_property = ! empty( $values['css_property'] ) && in_array( $values['css_property'], $allowed_props, true ) ? $values['css_property'] : 'width';
						$control_args = [
							'label'      => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Width', 'zyre-elementor-addons' ),
							'size_units' => ! empty( $values['size_units'] ) ? $values['size_units'] : [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
							'range'      => ! empty( $values['range'] ) ? $values['range'] : [
								'px' => [
									'max'  => 1000,
								],
								'em' => [
									'min'  => 0.1,
								],
								'rem' => [
									'min'  => 0.1,
								],
							],
							'default' => ! empty( $values['default'] ) ? $values['default'] : [],
							'type'       => Controls_Manager::SLIDER,
							'selectors'  => [
								! empty( $values['selector'] ) ? $values['selector'] : $selector => ! empty( $values['css_value'] ) ? esc_html( $values['css_value'] ) : "{$css_property}: {{SIZE}}{{UNIT}};",
							],
							'condition'  => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_responsive_control( $control_name, $control_args );
						break;

					case 'height':
					case 'min_height':
						$allowed_props = [ 'height', 'min-height', 'max-height' ];
						$css_property = ! empty( $values['css_property'] ) && in_array( $values['css_property'], $allowed_props, true ) ? $values['css_property'] : 'height';
						$control_args = [
							'label'      => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Height', 'zyre-elementor-addons' ),
							'size_units' => ! empty( $values['size_units'] ) ? $values['size_units'] : [ 'px', '%', 'em', 'rem', 'vh', 'custom' ],
							'default'    => ! empty( $values['default'] ) ? $values['default'] : [ 'unit' => 'px' ],
							'range'      => ! empty( $values['range'] ) ? $values['range'] : [
								'px'  => [
									'max' => 1000,
								],
								'em'  => [
									'min' => 0.1,
								],
								'rem' => [
									'min' => 0.1,
								],
							],
							'type'       => Controls_Manager::SLIDER,
							'selectors'  => [
								! empty( $values['selector'] ) ? $values['selector'] : $selector => "{$css_property}: {{SIZE}}{{UNIT}};",
							],
							'condition'  => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_responsive_control( $control_name, $control_args );
						break;

					case 'width_height':
						$allowed_props_w = [ 'width', 'min-width', 'max-width' ];
						$allowed_props_h = [ 'height', 'min-height', 'max-height' ];
						$css_property_w = ! empty( $values['css_property_w'] ) && in_array( $values['css_property_w'], $allowed_props_w, true ) ? $values['css_property_w'] : 'width';
						$css_property_h = ! empty( $values['css_property_h'] ) && in_array( $values['css_property_h'], $allowed_props_h, true ) ? $values['css_property_h'] : 'height';
						$control_args = [
							'label'      => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Size', 'zyre-elementor-addons' ),
							'size_units' => ! empty( $values['size_units'] ) && is_array( $values['size_units'] ) ? $values['size_units'] : [ 'px', '%', 'em', 'rem', 'custom' ],
							'range'      => ! empty( $values['range'] ) && is_array( $values['range'] ) ? $values['range'] : [
								'px' => [
									'max'  => 1000,
								],
								'em' => [
									'min'  => 0.1,
								],
								'rem' => [
									'min'  => 0.1,
								],
							],
							'type'       => Controls_Manager::SLIDER,
							'selectors'  => [
								! empty( $values['selector'] ) ? $values['selector'] : $selector => "{$css_property_w}: {{SIZE}}{{UNIT}};{$css_property_h}: {{SIZE}}{{UNIT}};",
							],
							'condition'  => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_responsive_control( $control_name, $control_args );
						break;

					case 'direction':
					case 'layout':
						$allowed_defaults = [ 'row', 'column', 'block', 'inline' ];
						$control_args = [
							'label'                => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Direction', 'zyre-elementor-addons' ),
							'type'                 => Controls_Manager::CHOOSE,
							'default'              => ! empty( $values['default'] ) && in_array( $values['default'], $allowed_defaults, true ) ? $values['default'] : '',
							'tablet_default'       => ! empty( $values['tablet_default'] ) && in_array( $values['tablet_default'], $allowed_defaults, true ) ? $values['tablet_default'] : '',
							'mobile_default'       => ! empty( $values['mobile_default'] ) && in_array( $values['mobile_default'], $allowed_defaults, true ) ? $values['mobile_default'] : '',
							'options'              => ! empty( $values['options'] ) && is_array( $values['options'] ) ? $values['options'] : [
								'row'    => [
									'title' => esc_html__( 'Row - horizontal', 'zyre-elementor-addons' ),
									'icon'  => 'eicon-arrow-right',
								],
								'column' => [
									'title' => esc_html__( 'Column - vertical', 'zyre-elementor-addons' ),
									'icon'  => 'eicon-arrow-down',
								],
							],
							'toggle'               => false,
							'selectors_dictionary' => isset( $values['selectors_dictionary'] ) && is_array( $values['selectors_dictionary'] ) ? $values['selectors_dictionary'] : [
								'row'    => '-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;-ms-flex-direction:row;flex-direction:row;',
								'column' => '-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;-ms-flex-direction:column;flex-direction:column;',
							],
							'selectors'            => [
								! empty( $values['selector'] ) ? $values['selector'] : $selector => '{{VALUE}}',
							],
							'prefix_class'         => ! empty( $values['prefix_class'] ) ? esc_html( $values['prefix_class'] ) : '',
							'condition'            => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_responsive_control( $control_name, $control_args );
						break;

					case 'gap':
					case 'space_between':
						$allowed_props = [ 'gap', '--gap' ];
						$css_property = ! empty( $values['css_property'] ) && in_array( $values['css_property'], $allowed_props, true ) ? $values['css_property'] : 'gap';
						$control_args = [
							'label'      => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Gap', 'zyre-elementor-addons' ),
							'description'      => ! empty( $values['description'] ) ? esc_html( $values['description'] ) : '',
							'size_units' => ! empty( $values['size_units'] ) && is_array( $values['size_units'] ) ? $values['size_units'] : [ 'px' ],
							'default'    => ! empty( $values['default'] ) && is_array( $values['default'] ) ? $values['default'] : [],
							'range'      => ! empty( $values['range'] ) && is_array( $values['range'] ) ? $values['range'] : [
								'px' => [
									'min' => 0,
								],
							],
							'type'       => Controls_Manager::SLIDER,
							'selectors'  => [
								! empty( $values['selector'] ) ? $values['selector'] : $selector => "{$css_property}: {{SIZE}}{{UNIT}};",
							],
							'condition'  => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_responsive_control( $control_name, $control_args );
						break;

					case 'column_gap':
						$control_args = [
							'label'      => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Column Gap', 'zyre-elementor-addons' ),
							'size_units' => ! empty( $values['size_units'] ) && is_array( $values['size_units'] ) ? $values['size_units'] : [ 'px' ],
							'range'      => ! empty( $values['range'] ) && is_array( $values['range'] ) ? $values['range'] : [
								'px' => [
									'min' => 0,
								],
							],
							'type'       => Controls_Manager::SLIDER,
							'selectors'  => [
								! empty( $values['selector'] ) ? $values['selector'] : $selector => 'column-gap: {{SIZE}}{{UNIT}};',
							],
							'condition'  => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_responsive_control( $control_name, $control_args );
						break;

					case 'row_gap':
						$control_args = [
							'label'      => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Row Gap', 'zyre-elementor-addons' ),
							'size_units' => ! empty( $values['size_units'] ) && is_array( $values['size_units'] ) ? $values['size_units'] : [ 'px' ],
							'range'      => ! empty( $values['range'] ) && is_array( $values['range'] ) ? $values['range'] : [
								'px' => [
									'min' => 0,
								],
							],
							'type'       => Controls_Manager::SLIDER,
							'selectors'  => [
								! empty( $values['selector'] ) ? $values['selector'] : $selector => 'row-gap: {{SIZE}}{{UNIT}};',
							],
							'condition'  => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_responsive_control( $control_name, $control_args );
						break;

					case 'align':
					case 'alignment':
						$allowed_defaults = [ 'left', 'center', 'right', 'justify' ];
						$control_args = [
							'label'     => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Alignment', 'zyre-elementor-addons' ),
							'type'      => Controls_Manager::CHOOSE,
							'default'   => ! empty( $values['default'] ) && in_array( $values['default'], $allowed_defaults, true ) ? $values['default'] : '',
							'options'   => ! empty( $values['options'] ) && is_array( $values['options'] ) ? $values['options'] : [
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
								'justify'  => [
									'title' => esc_html__( 'Justify', 'zyre-elementor-addons' ),
									'icon'  => 'eicon-text-align-justify',
								],
							],
							'selectors' => [
								! empty( $values['selector'] ) ? $values['selector'] : $selector => 'text-align: {{VALUE}};',
							],
							'condition'  => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						if ( ! empty( $values['prefix_class'] ) ) {
							$control_args['prefix_class'] = sanitize_key( $values['prefix_class'] );
						}
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_responsive_control( $control_name, $control_args );
						break;

					case 'align_x':
					case 'justify_content':
						$allowed_defaults = [ 'flex-start', 'center', 'flex-end', 'space-between', 'space-around', 'space-evenly' ];
						$control_args = [
							'label'       => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Horizontal Align', 'zyre-elementor-addons' ),
							'type'        => Controls_Manager::CHOOSE,
							'label_block' => isset( $values['label_block'] ) ? true : false,
							'default'     => ! empty( $values['default'] ) && in_array( $values['default'], $allowed_defaults, true ) ? $values['default'] : '',
							'options'     => ! empty( $values['options'] ) && is_array( $values['options'] ) ? $values['options'] : [
								'flex-start'    => [
									'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
									'icon'  => 'eicon-justify-start-h',
								],
								'center'        => [
									'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
									'icon'  => 'eicon-justify-center-h',
								],
								'flex-end'      => [
									'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
									'icon'  => 'eicon-justify-end-h',
								],
								'space-between' => [
									'title' => esc_html__( 'Space Between', 'zyre-elementor-addons' ),
									'icon'  => 'eicon-justify-space-between-h',
								],
								'space-around'  => [
									'title' => esc_html__( 'Space Around', 'zyre-elementor-addons' ),
									'icon'  => 'eicon-justify-space-around-h',
								],
								'space-evenly'  => [
									'title' => esc_html__( 'Space Evenly', 'zyre-elementor-addons' ),
									'icon'  => 'eicon-justify-space-evenly-h',
								],
							],
							'selectors'   => [
								! empty( $values['selector'] ) ? $values['selector'] : $selector => 'justify-content: {{VALUE}};',
							],
							'condition'   => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_responsive_control( $control_name, $control_args );
						break;

					case 'align_xy':
						$allowed_defaults = [ 'flex-start', 'center', 'flex-end', 'stretch' ];
						$control_args = [
							'label'     => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Horizontal Align', 'zyre-elementor-addons' ),
							'type'      => Controls_Manager::CHOOSE,
							'default'   => ! empty( $values['default'] ) && in_array( $values['default'], $allowed_defaults, true ) ? $values['default'] : '',
							'options'   => ! empty( $values['options'] ) && is_array( $values['options'] ) ? $values['options'] : [
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
							'selectors' => [
								! empty( $values['selector'] ) ? $values['selector'] : $selector => 'align-items: {{VALUE}};',
							],
							'condition'  => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_responsive_control( $control_name, $control_args );
						break;

					case 'align_y':
					case 'vertical_align':
						$allowed_defaults = [ 'flex-start', 'center', 'flex-end', 'stretch' ];
						$allowed_props = [ 'align-items', 'align-content' ];
						$css_property = ! empty( $values['css_property'] ) && in_array( $values['css_property'], $allowed_props, true ) ? $values['css_property'] : 'align-items';
						$control_args = [
							'label'     => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Vertical Align', 'zyre-elementor-addons' ),
							'type'      => Controls_Manager::CHOOSE,
							'default'   => ! empty( $values['default'] ) && in_array( $values['default'], $allowed_defaults, true ) ? $values['default'] : '',
							'options'   => ! empty( $values['options'] ) && is_array( $values['options'] ) ? $values['options'] : [
								'flex-start'    => [
									'title' => esc_html__( 'Top', 'zyre-elementor-addons' ),
									'icon'  => 'eicon-v-align-top',
								],
								'center' => [
									'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
									'icon'  => 'eicon-v-align-middle',
								],
								'flex-end' => [
									'title' => esc_html__( 'Bottom', 'zyre-elementor-addons' ),
									'icon'  => 'eicon-v-align-bottom',
								],
							],
							'selectors' => [
								! empty( $values['selector'] ) ? $values['selector'] : $selector => "{$css_property}: {{VALUE}};",
							],
							'condition'  => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_responsive_control( $control_name, $control_args );
						break;

					case 'align_self_x':
					case 'position_x':
						$allowed_defaults = [ 'left', 'center', 'right', 'stretch', 'flex-start', 'flex-end' ];
						$control_args = [
							'label'                => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Horizontal Align', 'zyre-elementor-addons' ),
							'type'                 => Controls_Manager::CHOOSE,
							'default'              => isset( $values['default'] ) && in_array( $values['default'], $allowed_defaults, true ) ? $values['default'] : '',
							'options'              => ! empty( $values['options'] ) && is_array( $values['options'] ) ? $values['options'] : [
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
								'stretch' => [
									'title' => esc_html__( 'Stretch', 'zyre-elementor-addons' ),
									'icon'  => 'eicon-text-align-justify',
								],
							],
							'toggle'               => ! empty( $values['toggle'] ) ? (bool) $values['toggle'] : true,
							'selectors_dictionary' => ! empty( $values['selectors_dictionary'] ) && is_array( $values['selectors_dictionary'] ) ? $values['selectors_dictionary'] : [
								'left'    => '-webkit-align-self:flex-start;-ms-flex-item-align:start;align-self:flex-start;',
								'center'  => '-webkit-align-self:center;-ms-flex-item-align:center;align-self:center;',
								'right'   => '-webkit-align-self:flex-end;-ms-flex-item-align:end;align-self:flex-end;',
								'stretch' => '-webkit-align-self:stretch;-ms-flex-item-align:stretch;align-self:stretch;width: 100%;max-width: 100%;',
							],
							'selectors'            => [
								! empty( $values['selector'] ) ? $values['selector'] : $selector => '{{VALUE}}',
							],
							'condition'            => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_responsive_control( $control_name, $control_args );
						break;

					case 'align_self_y':
					case 'position_y':
						$allowed_defaults = [ 'top', 'center', 'bottom', 'stretch', 'flex-start', 'flex-end' ];
						$control_args = [
							'label'                => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Vertical Align', 'zyre-elementor-addons' ),
							'type'                 => Controls_Manager::CHOOSE,
							'default'              => ! empty( $values['default'] ) && in_array( $values['default'], $allowed_defaults, true ) ? $values['default'] : '',
							'options'              => ! empty( $values['options'] ) && is_array( $values['options'] ) ? $values['options'] : [
								'top'     => [
									'title' => esc_html__( 'Top', 'zyre-elementor-addons' ),
									'icon'  => 'eicon-v-align-top',
								],
								'center'  => [
									'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
									'icon'  => 'eicon-v-align-middle',
								],
								'bottom'  => [
									'title' => esc_html__( 'Bottom', 'zyre-elementor-addons' ),
									'icon'  => 'eicon-v-align-bottom',
								],
							],
							'toggle'               => ! empty( $values['toggle'] ) ? (bool) $values['toggle'] : true,
							'selectors_dictionary' => ! empty( $values['selectors_dictionary'] ) && is_array( $values['selectors_dictionary'] ) ? $values['selectors_dictionary'] : [
								'top'     => '-webkit-align-self: flex-start; -ms-flex-item-align: start; align-self: flex-start;',
								'center'  => '-webkit-align-self: center; -ms-flex-item-align: center; align-self: center;',
								'bottom'  => '-webkit-align-self: flex-end; -ms-flex-item-align: end; align-self: flex-end;',
							],
							'selectors'            => [
								! empty( $values['selector'] ) ? $values['selector'] : $selector => '{{VALUE}}',
							],
							'condition'            => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_responsive_control( $control_name, $control_args );
						break;

					case 'rotate':
						$priority = isset( $values['priority'] ) && true === $values['priority'] ? ' !important' : '';
						$control_args = [
							'label' => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Rotate', 'zyre-elementor-addons' ),
							'type' => Controls_Manager::SLIDER,
							'size_units' => ! empty( $values['size_units'] ) && is_array( $values['size_units'] ) ? $values['size_units'] : [ 'deg', 'grad', 'rad', 'turn', 'custom' ],
							'default' => ! empty( $values['default'] ) && is_array( $values['default'] ) ? $values['default'] : [
								'unit' => 'deg',
							],
							'tablet_default' => ! empty( $values['tablet_default'] ) && is_array( $values['tablet_default'] ) ? $values['tablet_default'] : [
								'unit' => 'deg',
							],
							'mobile_default' => ! empty( $values['mobile_default'] ) && is_array( $values['mobile_default'] ) ? $values['mobile_default'] : [
								'unit' => 'deg',
							],
							'range'      => ! empty( $values['range'] ) && is_array( $values['range'] ) ? $values['range'] : [
								'deg'  => [
									'min' => -360,
									'max' => 360,
								],
							],
							'selectors' => [
								! empty( $values['selector'] ) ? $values['selector'] : $selector => "transform: rotate({{SIZE}}{{UNIT}}){$priority};",
							],
						];
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_responsive_control( $control_name, $control_args );
						break;

					case 'transition_effect':
						$allowed_defaults = [ 'ease', 'linear', 'ease-in', 'ease-out', 'ease-in-out' ];
						$control_args = [
							'label'     => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Transition Effect', 'zyre-elementor-addons' ),
							'type'      => Controls_Manager::SELECT,
							'default'   => ! empty( $values['default'] ) && in_array( $values['default'], $allowed_defaults, true ) ? $values['default'] : 'ease',
							'options'   => ! empty( $values['options'] ) && is_array( $values['options'] ) ? $values['options'] : [
								'ease'        => esc_html__( 'ease', 'zyre-elementor-addons' ),
								'linear'      => esc_html__( 'linear', 'zyre-elementor-addons' ),
								'ease-in'     => esc_html__( 'ease-in', 'zyre-elementor-addons' ),
								'ease-out'    => esc_html__( 'ease-out', 'zyre-elementor-addons' ),
								'ease-in-out' => esc_html__( 'ease-in-out', 'zyre-elementor-addons' ),
							],
							'selectors' => [
								! empty( $values['selector'] ) ? $values['selector'] : $selector => 'transition-timing-function: {{VALUE}};',
							],
							'condition' => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_control( $control_name, $control_args );
						break;

					case 'transition_duration':
						$allowed_props = [ 'transition-duration', '--transition-duration' ];
						$css_property = ! empty( $values['css_property'] ) && in_array( $values['css_property'], $allowed_props, true ) ? $values['css_property'] : 'transition-duration';
						$control_args = [
							'label' => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Transition Duration', 'zyre-elementor-addons' ) . ' (s)',
							'type' => Controls_Manager::SLIDER,
							'range' => ! empty( $values['range'] ) && is_array( $values['range'] ) ? $values['range'] : [
								'px' => [
									'min' => 0,
									'max' => 3,
									'step' => 0.1,
								],
							],
							'selectors' => [
								! empty( $values['selector'] ) ? $values['selector'] : $selector => "{$css_property}: {{SIZE}}s;",
							],
							'condition' => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_control( $control_name, $control_args );
						break;

					case 'object_fit':
						$allowed_defaults = [ 'cover', 'contain', 'fill', 'none', 'scale-down' ];
						$control_args = [
							'label'     => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Object Fit', 'zyre-elementor-addons' ),
							'type'      => Controls_Manager::SELECT,
							'default'   => ! empty( $values['default'] ) && in_array( $values['default'], $allowed_defaults, true ) ? $values['default'] : 'fill',
							'options'   => ! empty( $values['options'] ) && is_array( $values['options'] ) ? $values['options'] : [
								'cover'      => esc_html__( 'Cover', 'zyre-elementor-addons' ),
								'contain'    => esc_html__( 'Contain', 'zyre-elementor-addons' ),
								'fill'       => esc_html__( 'Fill', 'zyre-elementor-addons' ),
								'scale-down' => esc_html__( 'Scale Down', 'zyre-elementor-addons' ),
								'none'       => esc_html__( 'None', 'zyre-elementor-addons' ),
							],
							'selectors' => [
								! empty( $values['selector'] ) ? $values['selector'] : $selector => 'object-fit: {{VALUE}};',
							],
							'condition' => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_control( $control_name, $control_args );
						break;

					case 'zindex':
					case 'z_index':
						$control_args = [
							'label'      => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Z-Index', 'zyre-elementor-addons' ),
							'type'       => Controls_Manager::NUMBER,
							'min'        => ! empty( $values['min'] ) ? absint( $values['min'] ) : -10,
							'max'        => 100,
							'selectors'  => [
								! empty( $values['selector'] ) ? $values['selector'] : $selector => 'z-index: {{SIZE}};',
							],
							'condition' => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_responsive_control( $control_name, $control_args );
						break;

					case 'offset_x':
						$allowed_props = [ '--translateX', '--translate-x', 'left', 'right' ];
						$css_property = ! empty( $values['css_property'] ) && in_array( $values['css_property'], $allowed_props, true ) ? $values['css_property'] : '--translateX';
						$control_args = [
							'label'      => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Horizontal Offset', 'zyre-elementor-addons' ),
							'type'       => Controls_Manager::SLIDER,
							'size_units' => ! empty( $values['size_units'] ) && is_array( $values['size_units'] ) ? $values['size_units'] : [ '%', 'px', 'vw', 'custom' ],
							'range'      => ! empty( $values['range'] ) && is_array( $values['range'] ) ? $values['range'] : [
								'%'  => [
									'min' => -100,
								],
								'px' => [
									'min' => -1000,
									'max' => 1000,
								],
								'vw'  => [
									'min' => -100,
								],
							],
							'selectors'  => [
								! empty( $values['selector'] ) ? $values['selector'] : $selector => "{$css_property}: {{SIZE}}{{UNIT}};",
							],
							'condition' => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_responsive_control( $control_name, $control_args );
						break;

					case 'offset_y':
						$allowed_props = [ '--translateY', '--translate-y', 'top', 'bottom' ];
						$css_property = ! empty( $values['css_property'] ) && in_array( $values['css_property'], $allowed_props, true ) ? $values['css_property'] : '--translateY';
						$control_args = [
							'label'      => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Vertical Offset', 'zyre-elementor-addons' ),
							'type'       => Controls_Manager::SLIDER,
							'size_units' => ! empty( $values['size_units'] ) && is_array( $values['size_units'] ) ? $values['size_units'] : [ '%', 'px', 'vh' ],
							'range'      => ! empty( $values['range'] ) && is_array( $values['range'] ) ? $values['range'] : [
								'%'  => [
									'min' => -100,
								],
								'px' => [
									'min' => -1000,
									'max' => 1000,
								],
								'vh'  => [
									'min' => -100,
								],
							],
							'selectors'  => [
								! empty( $values['selector'] ) ? $values['selector'] : $selector => "{$css_property}: {{SIZE}}{{UNIT}};",
							],
							'condition' => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_responsive_control( $control_name, $control_args );
						break;

					case 'options':
						$control_args = [
							'label'        => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Options', 'zyre-elementor-addons' ),
							'type'         => Controls_Manager::SELECT,
							'default'      => ! empty( $values['default'] ) ? esc_html( $values['default'] ) : '',
							'options'      => ! empty( $values['options'] ) ? $values['options'] : [],
							'condition'    => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						if ( ! empty( $values['prefix_class'] ) ) {
							$control_args['prefix_class'] = sanitize_key( $values['prefix_class'] );
						}
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_control( $prefix . '_opt', $control_args );
						break;

					case 'divider':
						$allowed_defaults = [ 'yes', 'no', 'on', 'off', 'show', 'hide' ];
						$control_args = [
							'label'        => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Divider', 'zyre-elementor-addons' ),
							'label_on'     => ! empty( $values['label_on'] ) ? esc_html( $values['label_on'] ) : esc_html__( 'On', 'zyre-elementor-addons' ),
							'label_off'    => ! empty( $values['label_off'] ) ? esc_html( $values['label_off'] ) : esc_html__( 'Off', 'zyre-elementor-addons' ),
							'type'         => Controls_Manager::SWITCHER,
							'default'      => ! empty( $values['default'] ) && in_array( $values['default'], $allowed_defaults, true ) ? $values['default'] : 'no',
							'return_value' => ! empty( $values['return_value'] ) ? esc_html( $values['return_value'] ) : 'yes',
							'condition'    => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
							'selectors' => [
								! empty( $values['selector'] ) ? $values['selector'] : $selector => 'content: ""',
							],
						];
						if ( ! empty( $values['prefix_class'] ) ) {
							$control_args['prefix_class'] = sanitize_key( $values['prefix_class'] );
						}
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_control( $control_name, $control_args );
						break;

					case 'switch':
						$return_values = [ 'yes', 'on' ];
						$control_args = [
							'label'        => ! empty( $values['label'] ) ? esc_html( $values['label'] ) : esc_html__( 'Show Separators', 'zyre-elementor-addons' ),
							'type'         => Controls_Manager::SWITCHER,
							'label_on'     => ! empty( $values['label_on'] ) ? esc_html( $values['label_on'] ) : esc_html__( 'SHOW', 'zyre-elementor-addons' ),
							'label_off'    => ! empty( $values['label_off'] ) ? esc_html( $values['label_off'] ) : esc_html__( 'HIDE', 'zyre-elementor-addons' ),
							'return_value' => ! empty( $values['return_value'] ) && in_array( $values['return_value'], $return_values, true ) ? $values['return_value'] : 'yes',
							'condition'    => ! empty( $values['condition'] ) && is_array( $values['condition'] ) ? $values['condition'] : $condition,
						];
						if ( ! empty( $values['separator'] ) ) {
							$control_args['separator'] = $values['separator'];
						}
						$this->add_control( $control_name, $control_args );
						break;
				}
			}
		}
	}

	/**
	 * Fix for 2.6.*
	 *
	 * @since 1.0.0
	 * Elementor 2.6.0 no longer supports the render_edit_tools method.
	 */
	protected function render_edit_tools() {
		if ( zyre_is_elementor_version( '<=', '2.5.16' ) ) {
			parent::render_edit_tools();
		}
	}

	/**
	 * Override the parent method to facilitate inline editing.
	 *
	 * This method allows for the addition of inline editing attributes, defining specific editable areas within the element.
	 * Users can specify the type of toolbar—basic or advanced—based on the control being used.
	 *
	 * Note: wysiwyg control should use the advanced toolbar, while textarea control should opt for the basic toolbar.
	 * Text control does not require a toolbar.
	 *
	 * PHP usage example (inside Widget_Base::render() method):
	 *
	 * $this->add_inline_editing_attributes( 'text', 'advanced' );;
	 * echo '<div ' . $this->get_render_attribute_string( 'text' ) . '>' . $this->get_settings( 'text' ) . '</div>';
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param string $key Element key.
	 * @param string $toolbar Optional. Toolbar type. Accepted values are advanced, basic, or none. Default is basic.
	 *
	 * @param string $setting_key Additional settings key in case $key != $setting_key.
	 */
	public function add_inline_editing_attributes( $key, $toolbar = 'basic', $setting_key = '' ) {
		if ( ! zyre_elementor()->editor->is_edit_mode() ) {
			return;
		}

		if ( empty( $setting_key ) ) {
			$setting_key = $key;
		}

		$this->add_render_attribute(
			$key,
			array(
				'class'                      => 'elementor-inline-editing',
				'data-elementor-setting-key' => $setting_key,
			)
		);

		if ( 'basic' !== $toolbar ) {
			$this->add_render_attribute(
				$key,
				array(
					'data-elementor-inline-editing-toolbar' => $toolbar,
				)
			);
		}
	}

	/**
	 * Add link render attributes.
	 *
	 * Adds link tag attributes to a specific HTML element.
	 *
	 * The HTML link tag is represented by the $element parameter.
	 * The $url_control parameter must be an array of link settings in the same format as set by Elementor's URL control.
	 *
	 * Example usage:
	 * `$this->add_link_attributes( 'button', $settings['link'] );`
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array|string $element The HTML element.
	 * @param array        $url_control Array of link settings.
	 * @param bool         $overwrite Optional. Whether to overwrite existing attribute. Default is false, not to overwrite.
	 *
	 * @return \Elementor\Element_Base instance
	 */
	public function add_link_attributes( $element, array $url_control, $overwrite = false ) {
		// The add_link_attributes method is available starting from Elementor version 2.8.0.
		if ( zyre_is_elementor_version( '>=', '2.8.0' ) ) {
			return parent::add_link_attributes( $element, $url_control, $overwrite );
		}

		$attributes = array();

		if ( ! empty( $url_control['url'] ) ) {
			$attributes['href'] = $url_control['url'];
		}

		if ( ! empty( $url_control['is_external'] ) ) {
			$attributes['target'] = '_blank';
		}

		if ( ! empty( $url_control['nofollow'] ) ) {
			$attributes['rel'] = 'nofollow';
		}

		if ( ! empty( $url_control['custom_attributes'] ) ) {
			// Custom URL attributes should be provided as a string of comma-delimited key|value pairs.
			// A blacklist of certain attributes, such as onclick or onfocus, is applied to prevent potential security risks.
			$custom_attributes = explode( ',', $url_control['custom_attributes'] );
			$blacklist = array( 'onclick', 'onfocus', 'onblur', 'onchange', 'onresize', 'onmouseover', 'onmouseout', 'onkeydown', 'onkeyup' );

			foreach ( $custom_attributes as $attribute ) {
				// Trim key and value to remove any unwanted spaces.
				list( $attr_key, $attr_value ) = explode( '|', $attribute );

				// Cover cases where key/value have spaces both before and/or after the actual value.
				$attr_key = trim( $attr_key );
				$attr_value = trim( $attr_value );

				// Add the attribute to the $attributes array if it is not blacklisted.
				if ( ! in_array( strtolower( $attr_key ), $blacklist, true ) ) {
					$attributes[ $attr_key ] = $attr_value;
				}
			}
		}

		if ( $attributes ) {
			$this->add_render_attribute( $element, $attributes, $overwrite );
		}

		return $this;
	}
}
