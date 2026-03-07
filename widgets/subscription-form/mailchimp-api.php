<?php

/**
 * MailChimp api
 *
 * @package ZyreAddons
 */

namespace ZyreAddons\Elementor\Widget\Mailchimp;

defined( 'ABSPATH' ) || die();

class Mailchimp_Api {

	private static $api_key;
	private static $credentials;
	public static $list_id;

	/**
	 * Insert subscriber into Mailchimp
	 *
	 * @param array $submitted_data
	 * @return array
	 */
	public static function insert_subscriber_to_mailchimp( $submitted_data ) {
		$return = [];

		self::$credentials = zyreladdons_get_credentials( 'mailchimp' );
		self::$api_key = self::$credentials['api'] ?? '';

		$post_id   = absint( $_POST['post_id'] ?? 0 );
		$widget_id = sanitize_text_field( wp_unslash( $_POST['widget_id'] ?? '' ) );
		$widget_settings = zyreladdons_get_el_post_widget_settings( $post_id, $widget_id );

		// Tags
		$tags = [];
		if ( ! empty( $widget_settings['mailchimp_list_tags'] ) ) {
			$tags = explode( ', ', $widget_settings['mailchimp_list_tags'] );
		}

		$auth = [
			'api_key' => self::$api_key,
			'list_id' => sanitize_text_field( wp_unslash( $_POST['list_id'] ?? '' ) ),
		];

		$status = ( ! empty( $widget_settings['enable_double_opt_in'] ) && 'yes' === $widget_settings['enable_double_opt_in'] ) ? 'pending' : 'subscribed';

		$data = [
			'email_address' => $submitted_data['email'] ?? '',
			'status'        => $status,
			'status_if_new' => $status,
			'merge_fields'  => [
				'FNAME' => $submitted_data['fname'] ?? '',
				'LNAME' => $submitted_data['lname'] ?? '',
				'PHONE' => $submitted_data['phone'] ?? '',
			],
		];

		if ( $tags ) {
			$data['tags'] = $tags;
		}

		// Validate API key
		$server = explode( '-', $auth['api_key'] );
		if ( empty( $server[1] ) || strpos( $server[1], 'us' ) === false ) {
			return [
				'status' => 0,
				'msg'    => esc_html__( 'Invalid API key.', 'zyre-elementor-addons' ),
			];
		}

		$url = sprintf(
			'https://%s.api.mailchimp.com/3.0/lists/%s/members/',
			$server[1],
			$auth['list_id']
		);

		$response = wp_remote_post(
			$url,
			[
				'method'      => 'POST',
				'data_format' => 'body',
				'timeout'     => 45,
				'headers'     => [
					'Authorization' => 'apikey ' . $auth['api_key'],
					'Content-Type'  => 'application/json; charset=utf-8',
				],
				'body'        => wp_json_encode( $data ),
			]
		);

		if ( is_wp_error( $response ) ) {
			$return['status'] = 0;
			$return['msg']    = esc_html__( 'Something went wrong: ', 'zyre-elementor-addons' ) . esc_html( $response->get_error_message() );
			return $return;
		}

		$http_code = wp_remote_retrieve_response_code( $response );
		$body      = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( is_wp_error( $response ) || $http_code >= 400 ) {
			$return['status'] = 0;
			$return['msg']    = $body['title'] ?? esc_html__( 'Something went wrong.', 'zyre-elementor-addons' );
		} elseif ( 'subscribed' === ( $body['status'] ?? '' ) ) {
			$return['status'] = 1;
			$return['msg']    = $widget_settings['mailchimp_success_message'] ?? '';
		} elseif ( 'pending' === ( $body['status'] ?? '' ) ) {
			$return['status'] = 1;
			$return['msg']    = esc_html__( 'Confirm your subscription from your email.', 'zyre-elementor-addons' );
		} else {
			$return['status'] = 0;
			$return['msg']    = esc_html__( 'Something went wrong. Try again later.', 'zyre-elementor-addons' );
		}

		return $return;
	}

	/**
	 * Get all Mailchimp lists
	 *
	 * @param string|null $api
	 * @return array
	 */
	public static function get_mailchimp_lists( $api = null ) {
		if ( $api ) {
			self::$api_key = $api;
		} elseif ( ! empty( self::$credentials['api'] ) ) {
			self::$api_key = self::$credentials['api'];
		} else {
			return [];
		}

		$server = explode( '-', self::$api_key );
		if ( empty( $server[1] ) ) {
			return [];
		}

		$url = sprintf( 'https://%s.api.mailchimp.com/3.0/lists', $server[1] );

		$response = wp_remote_post(
			$url,
			[
				'method'      => 'GET',
				'data_format' => 'body',
				'timeout'     => 45,
				'headers'     => [
					'Authorization' => 'apikey ' . self::$api_key,
					'Content-Type'  => 'application/json; charset=utf-8',
				],
				'body'        => '',
			]
		);

		$options = [];
		if ( ! is_wp_error( $response ) ) {
			$body   = json_decode( wp_remote_retrieve_body( $response ) );
			$lists  = $body->lists ?? [];

			if ( $lists && is_array( $lists ) ) {
				foreach ( $lists as $list ) {
					// extra space to maintain order in Elementor control
					$options[ ' ' . $list->id ] = $list->name;
				}
			}
		}

		return $options;
	}
}
