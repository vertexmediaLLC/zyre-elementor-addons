<?php

namespace ZyreAddons\Elementor;

defined( 'ABSPATH' ) || die();

/**
 * Credentials_Manager class
 *
 * @since 1.0.0
 * @package ZyreAddons
 */
class Credentials_Manager {

	const CREDENTIALS_DB_KEY = 'zyreaddons_credentials';

	/**
	 * Get credentials map
	 *
	 * @return array
	 */
	public static function get_credentials_map() {
		$credentials_map = [];

		$local_credentials_map = self::get_local_credentials_map();
		$credentials_map = array_merge( $credentials_map, $local_credentials_map );

		return apply_filters( 'zyreaddons_get_credentials_map', $credentials_map );
	}

	public static function get_saved_credentials() {
		return get_option( self::CREDENTIALS_DB_KEY, [] );
	}

	public static function save_credentials( $credentials = [] ) {
		update_option( self::CREDENTIALS_DB_KEY, $credentials );
	}

	/**
	 * Get the free credentials map
	 *
	 * @return array
	 */
	public static function get_local_credentials_map() {
		return [
			'mailchimp' => [
				'title' => __( 'MailChimp', 'zyre-elementor-addons' ),
				'icon' => 'zy-fonticon zy-Subscription',
				'fields' => [
					[
						'label' => esc_html__( 'Enter API Key. ', 'zyre-elementor-addons' ),
						'type' => 'text',
						'name' => 'api',
						'help' => [
							'instruction' => esc_html__( 'Get your api key here', 'zyre-elementor-addons' ),
							'link' => 'https://admin.mailchimp.com/account/api/',
						],
					],
				],
				'demo' => 'https://happyaddons.com/mailchimp/',
				'is_pro' => false,
			],
		];
	}
}
