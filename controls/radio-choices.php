<?php
/**
 * Radio_Choices class
 *
 * @since 2.1.7
 * @package ZyreAddons
 */

namespace VertexMediaLLC\ZyreElementorAddons\Controls;

use Elementor\Base_Data_Control;

defined( 'ABSPATH' ) || exit;

/**
 * Renders radio inputs as a text-based button group.
 */
class Radio_Choices extends Base_Data_Control {

	const TYPE = 'zyreladdons_radio_choices';

	/**
	 * Get control type.
	 *
	 * @return string
	 */
	public function get_type() {
		return self::TYPE;
	}

	/**
	 * Default control settings.
	 *
	 * @return array
	 */
	protected function get_default_settings() {
		return [
			'options' => [],
			'toggle'  => false,
		];
	}

	/**
	 * Enqueue editor assets.
	 */
	public function enqueue() {
		// Reuse Elementor's Choose view, it already handles radio inputs.
		wp_add_inline_script(
			'elementor-editor',
			"jQuery( window ).on( 'elementor:init', function () {
				elementor.addControlView( '" . self::TYPE . "', elementor.modules.controls.Choose );
			} );"
		);
	}

	/**
	 * Control content template.
	 */
	public function content_template() {
		?>
		<div class="elementor-control-field">
			<# if ( data.label ) { #>
				<label class="elementor-control-title">{{{ data.label }}}</label>
			<# } #>
			<div class="elementor-control-input-wrapper">
				<div class="elementor-choices">
					<# _.each( data.options, function( label, value ) { #>
						<input id="<?php $this->print_control_uid( '{{ value }}' ); ?>" type="radio" name="elementor-choose-{{ data.name }}-{{ data._cid }}" value="{{ value }}">
						<label class="elementor-choices-label elementor-control-unit-1" for="<?php $this->print_control_uid( '{{ value }}' ); ?>">{{{ label }}}</label>
					<# } ); #>
				</div>
			</div>
		</div>
		<# if ( data.description ) { #>
			<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}
}
