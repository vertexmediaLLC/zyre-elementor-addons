<?php

namespace ZyreAddons\Elementor;

defined( 'ABSPATH' ) || die();

class Ajax_Handler {

	/**
	 * Mailchimp subscriber handler Ajax call
	 */
	public static function mailchimp_prepare_ajax() {

		if ( ! check_ajax_referer( 'zyreladdons_nonce', 'security', false ) ) {
			wp_send_json_error( 'Invalid request', 403 );
		}

		if ( empty( $_POST['subscriber_info'] ) ) {
			wp_send_json_error( 'Missing data', 400 );
		}

		parse_str( wp_unslash( $_POST['subscriber_info'] ), $subscriber );
    	$subscriber = zyreladdons_sanitize_array_recursively( $subscriber );

		if ( empty( $subscriber['email'] ) || ! is_email( $subscriber['email'] ) ) {
			wp_send_json_error( 'Invalid email', 400 );
		}

		if ( ! class_exists( 'ZyreAddons\Elementor\Widget\Mailchimp\Mailchimp_Api' ) ) {
			include_once ZYRE_ADDONS_DIR_PATH . 'widgets/subscription-form/mailchimp-api.php';
		}

		$response = Widget\Mailchimp\Mailchimp_Api::insert_subscriber_to_mailchimp( $subscriber );

		wp_send_json( $response );
	}
}
