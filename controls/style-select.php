<?php
/**
 * Style_Control class
 *
 * @since 1.0.0
 * @package ZyreAddons
 */

namespace ZyreAddons\Elementor\Controls;

use Elementor\Base_Data_Control;

defined( 'ABSPATH' ) || die();

class Style_Control extends Base_Data_Control {

	const TYPE = 'zyre_style_select';

	public function get_type() {
		return self::TYPE;
	}

	protected function get_default_settings() {
		return [
			'options'        => [],
			'disabled'       => [],
			'pro_data'       => [],
		];
	}

	public function content_template() {
		$tooltip = __( 'Switching to another style may alter your current style and content.', 'zyre-elementor-addons' );
		?>
		<div class="elementor-control-field">
			<# if ( data.label ) {#>
			<label for="<?php $this->print_control_uid(); ?>" class="elementor-control-title">{{{ data.label }}}</label>
			<# } #>
			<div class="elementor-control-input-wrapper elementor-control-unit-5">
				<select id="<?php $this->print_control_uid(); ?>" data-setting="{{ data.name }}">
					<# _.each( data.options, function( option_title, option_value ) {
						var value = data.controlValue;
						if ( typeof value == 'string' ) {
							var selected = ( option_value === value ) ? 'selected' : '';
						} else if ( null !== value ) {
							var value = _.values( value );
							var selected = ( -1 !== value.indexOf( option_value ) ) ? 'selected' : '';
						}
						var disabled = ( -1 !== data.disabled.indexOf( option_value ) ) ? 'disabled' : '';
						var pro_data = ( -1 !== data.pro_data.indexOf( option_value ) ) ? 'data-pro=true' : '';
					#>
					<option {{ selected }} {{ disabled }} {{ pro_data }} value="{{ option_value }}">{{{ option_title }}}</option>
					<# } ); #>
				</select>

				<# if ( _.size( data.options ) > 1 ) { #>
				<span class="zyre-tooltip"><?php echo esc_html( $tooltip ); ?></span>
				<# } #>
			</div>
		</div>
		<# if ( data.description ) { #>
		<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}
}
