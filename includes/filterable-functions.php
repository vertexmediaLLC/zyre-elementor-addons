<?php
/**
 * Filterable functions defination
 *
 * @package ZyreAddons
 * @since 1.0.0
 * @author Elmentorin
 */

defined( 'ABSPATH' ) || die();

if ( ! function_exists( 'zyre_is_on_demand_cache_enabled' ) ) {
	/**
	 * Checks if on-demand cache feature is enabled.
	 *
	 * @since 1.0.0
	 * @return bool Whether on-demand cache feature is enabled.
	 */
	function zyre_is_on_demand_cache_enabled() {
		return apply_filters( 'zyreaddons/features/on_demand_cache', true );
	}
}
