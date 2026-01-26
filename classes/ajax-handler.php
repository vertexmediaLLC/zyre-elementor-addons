<?php

namespace ZyreAddons\Elementor;

defined( 'ABSPATH' ) || die();

class Ajax_Handler {

	/**
	 * Mailchimp subscriber handler Ajax call
	 */
	public static function mailchimp_prepare_ajax() {

		$security = check_ajax_referer( 'zyre_addons_nonce', 'security' );

		if ( ! $security ) {
			return;
		}

		parse_str( isset( $_POST['subscriber_info'] ) ? wp_unslash( $_POST['subscriber_info'] ) : '', $subscriber );
		$subscriber = zyre_sanitize_array_recursively( $subscriber );

		if ( ! class_exists( 'ZyreAddons\Elementor\Widget\Mailchimp\Mailchimp_Api' ) ) {
			include_once ZYRE_ADDONS_DIR_PATH . 'widgets/subscription-form/mailchimp-api.php';
		}

		$response = Widget\Mailchimp\Mailchimp_Api::insert_subscriber_to_mailchimp( $subscriber );

		echo wp_send_json( $response ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		wp_die();
	}
}
