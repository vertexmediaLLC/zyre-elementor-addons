<?php
/**
 * Addon elements for Elementor Page Builder.
 *
 * Plugin Name: Zyre Elementor Addons
 * Description: <a href="https://zyreaddons.com/">Zyre Elementor Addons</a> is a powerful Elementor Addons with 56+ free widgets, including Accordion, Business Hour, CTA, Countdown, Flip Box, Carousel, Menu, News Ticker, Post Grid, Subscription Form, Testimonial, & more, along with a robust Theme Builder.
 * Plugin URI: https://zyreaddons.com/
 * Version: 1.0.2
 * Author: ZyreAddons
 * Author URI: https://vertexmedia.tech/
 * Text Domain: zyre-elementor-addons
 * Domain Path: /languages/
 * Requires Plugins: elementor
 * Elementor tested up to: 3.35
 * Elementor Pro tested up to: 3.35
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * [PHP]
 * Requires PHP: 7.4
 *
 * [WP]
 * Requires at least: 5.0
 * Tested up to: 6.9
 *
 * @package ZyreAddons
 */

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2023 VertexMediaLLC <https://vertexmedia.tech/>
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'ZYRE_ADDONS_VERSION', '1.0.2' );
define( 'ZYRE_ADDONS__FILE__', __FILE__ );
define( 'ZYRE_ADDONS_DIR_PATH', plugin_dir_path( ZYRE_ADDONS__FILE__ ) );
define( 'ZYRE_ADDONS_DIR_URL', plugin_dir_url( ZYRE_ADDONS__FILE__ ) );
define( 'ZYRE_ADDONS_ASSETS', trailingslashit( ZYRE_ADDONS_DIR_URL . 'assets' ) );

define( 'ZYRE_ADDONS_REDIRECTION_FLAG', 'zyreaddons_do_activation_direct' );
define( 'ZYRE_ADDONS_WIZARD_REDIRECTION_FLAG', 'zyreaddons_do_wizard_direct' );

define( 'ZYRE_ADDONS_MINIMUM_ELEMENTOR_VERSION', '3.7.0' );
define( 'ZYRE_ADDONS_MINIMUM_PHP_VERSION', '7.4' );

/**
 * The initial setups.
 *
 * @return void Not all voids are really void!
 */
function zyre_init() {
	require ZYRE_ADDONS_DIR_PATH . 'includes/helpers.php';

	// Check for required PHP version.
	if ( version_compare( PHP_VERSION, ZYRE_ADDONS_MINIMUM_PHP_VERSION, '<' ) ) {
		add_action( 'admin_notices', 'zyre_required_php_version_missing_notice' );
		return;
	}

	// Check if Elementor installed and activated.
	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'zyre_elementor_missing_notice' );
		return;
	}

	// Check for required Elementor version.
	if ( ! version_compare( ELEMENTOR_VERSION, ZYRE_ADDONS_MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
		add_action( 'admin_notices', 'zyre_required_elementor_version_missing_notice' );
		return;
	}

	require ZYRE_ADDONS_DIR_PATH . 'base/plugin-base.php';
	\ZyreAddons\Elementor\Plugin::instance()->init();
}

add_action( 'plugins_loaded', 'zyre_init' );

/**
 * Admin notice for required php version
 *
 * @since 1.0.0
 * @return void
 */
function zyre_required_php_version_missing_notice() {
	$notice = sprintf(
		/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
		esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'zyre-elementor-addons' ),
		'<strong>' . esc_html__( 'Zyre Elementor Addons', 'zyre-elementor-addons' ) . '</strong>',
		'<strong>' . esc_html__( 'PHP', 'zyre-elementor-addons' ) . '</strong>',
		ZYRE_ADDONS_MINIMUM_PHP_VERSION
	);

	printf( '<div class="notice notice-warning is-dismissible"><p style="padding: 13px 0">%1$s</p></div>', wp_kses( $notice, zyre_get_allowed_html() ) );
}

/**
 * Admin notice for elementor if missing
 *
 * @since 1.0.0
 * @return void
 */
function zyre_elementor_missing_notice() {

	$missing_info = zyre_get_plugin_missing_info(
		[
			'plugin_title' => __( 'Elementor', 'zyre-elementor-addons' ),
			'plugin_name'  => 'elementor',
			'plugin_file'  => 'elementor/elementor.php',
		]
	);

	$missing_info_url = ! empty( $missing_info['url'] ) ? $missing_info['url'] : '#';
	$missing_info_title = ! empty( $missing_info['title'] ) ? $missing_info['title'] : '';

	$notice = sprintf(
		/* translators: 1: Plugin name 2: Elementor 3: Elementor installation link */
		__( '%1$s requires %2$s to be installed and activated to function properly. %3$s', 'zyre-elementor-addons' ),
		'<strong>' . __( 'Zyre Elementor Addons', 'zyre-elementor-addons' ) . '</strong>',
		'<strong>' . __( 'Elementor', 'zyre-elementor-addons' ) . '</strong>',
		'<a href="' . esc_url( $missing_info_url ) . '">' . esc_html( $missing_info_title ) . '</a>'
	);

	printf( '<div class="notice notice-warning is-dismissible"><p style="padding: 13px 0">%1$s</p></div>', wp_kses( $notice, zyre_get_allowed_html( 'advanced' ) ) );
}

/**
 * Admin notice for required elementor version
 *
 * @since 1.0.0
 * @return void
 */
function zyre_required_elementor_version_missing_notice() {

	$notice_title = __( 'Update Elementor', 'zyre-elementor-addons' );
	$notice_url = wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=elementor/elementor.php' ), 'upgrade-plugin_elementor/elementor.php' );

	$notice = sprintf(
		/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
		esc_html__( '"%1$s" requires "%2$s" version %4$s or greater. %3$s', 'zyre-elementor-addons' ),
		'<strong>' . esc_html__( 'Zyre Elementor Addons', 'zyre-elementor-addons' ) . '</strong>',
		'<strong>' . esc_html__( 'Elementor', 'zyre-elementor-addons' ) . '</strong>',
		'<a href="' . esc_url( $notice_url ) . '">' . $notice_title . '</a>',
		ZYRE_ADDONS_MINIMUM_ELEMENTOR_VERSION
	);

	printf( '<div class="notice notice-warning is-dismissible"><p style="padding: 13px 0">%1$s</p></div>', wp_kses( $notice, zyre_get_allowed_html( 'advanced' ) ) );
}

/**
 * Tell WooCommerce that this plugin is compatible with HPOS.
 *
 * @since 1.0.0
 */
add_action( 'before_woocommerce_init', 'zyre_declare_wc_hpos_compatibility' );
function zyre_declare_wc_hpos_compatibility() {
	if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
	}
}
