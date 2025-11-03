<?php
/**
 * Group_Control_Typography_Extended class
 *
 * @since 1.0.0
 * @package ZyreAddons
 */

namespace ZyreAddons\Elementor\Controls;

use Elementor\Group_Control_Typography;

defined( 'ABSPATH' ) || die();

class Group_Control_Typography_Extended extends Group_Control_Typography {

	protected function init_fields() {
		$fields = parent::init_fields();

		// Decoration Thickness
		$decoration_thickness_data = [
			'label'      => esc_html__( 'Decoration Thickness', 'zyre-elementor-addons' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em' ],
			'range'      => [
				'px' => [
					'min' => 0,
					'max' => 10,
				],
				'em' => [
					'min' => 0,
					'max' => 1,
					'step' => 0.01,
				],
			],
			'selector_value' => 'text-decoration-thickness: {{SIZE}}{{UNIT}};',
			'condition' => [
				'text_decoration' => [ 'underline', 'overline', 'line-through' ],
			],
		];

		// Underline Offset
		$underline_offset_data = [
			'label'      => esc_html__( 'Underline Offset', 'zyre-elementor-addons' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em' ],
			'selector_value' => 'text-underline-offset: {{SIZE}}{{UNIT}};',
			'condition' => [
				'text_decoration' => [ 'underline' ],
			],
		];

		// Insert after 'text_decoration' in one line
		array_splice( $fields, array_search( 'text_decoration', array_keys( $fields ), true ) + 1, 0, [
			'text_decoration_thickness' => $decoration_thickness_data,
			'text_underline_offset'     => $underline_offset_data,
		] );

		return $fields;
	}
}
