<?php
/**
 *  Functions list
 *
 * @package ZyreAddons
 * @since 1.0.0
 * @author Elmentorin
 */

defined( 'ABSPATH' ) || die();

/**
 * Get database settings of a widget by widget id and elements
 *
 * @param array $elements
 * @param string $widget_id
 * @param array $value
 */
function zyre_get_elementor_widget_settings( $elements, $widget_id ) {

	if ( is_array( $elements ) ) {
		foreach ( $elements as $element ) {
			if ( $element && ! empty( $element['id'] ) && $element['id'] === $widget_id ) {
				return $element;
			}
			if ( $element && ! empty( $element['elements'] ) && is_array( $element['elements'] ) ) {
				$value = zyre_get_elementor_widget_settings( $element['elements'], $widget_id );
				if ( $value ) {
					return $value;
				}
			}
		}
	}

	return false;
}

/**
 * Get database settings of a widget by widget id and post id
 *
 * @param number $post_id
 * @param string $widget_id
 * @param array
 */
function zyre_get_el_post_widget_settings( $post_id, $widget_id ) {

	$elementor_data = @json_decode( get_post_meta( $post_id, '_elementor_data', true ), true );

	if ( $elementor_data ) {
		$element = zyre_get_elementor_widget_settings( $elementor_data, $widget_id );
		return isset( $element['settings'] ) ? $element['settings'] : '';
	}

	return false;
}

/**
 * get credentials function
 *
 * @param string $key
 *
 * @return void
 * @since 1.0.0
 */
function zyre_get_credentials( $key = '' ) {
	if ( ! class_exists( 'ZyreAddons\Elementor\Credentials_Manager' ) ) {
		include_once ZYRE_ADDONS_DIR_PATH . 'classes/credentials-manager.php';
	}

	$credentials = \ZyreAddons\Elementor\Credentials_Manager::get_saved_credentials();
	if ( ! empty( $key ) ) {
		return isset( $credentials[ $key ] ) ? $credentials[ $key ] : esc_html__( 'invalid key', 'zyre-elementor-addons' );
	}

	return $credentials;
}

/**
 * @param $suffix. e.g. &t=dashboard
 */
function zyre_get_dashboard_link( $suffix = 'dashboard' ) {
	$params = [
		'page' => 'zyre-addons',
		't'    => $suffix,
	];

	return add_query_arg( $params, admin_url('admin.php') );
}
