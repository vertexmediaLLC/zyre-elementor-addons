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
	 * Get the pro credentials map for dashboard only
	 *
	 * @return array
	 */
	public static function get_pro_credentials_map() {
		return [
			'twitter_feed' => [
				'title' => __( 'Twitter Feed', 'zyre-elementor-addons' ),
				'icon' => 'zy-fonticon zy-Social-feed-X',
				'fields' => [
					[
						'label' => esc_html__( 'User Name. (Use @ sign with your Twitter user name)', 'zyre-elementor-addons' ),
						'type' => 'text',
						'name' => 'user_name',
					],
					[
						'label' => esc_html__( 'Consumer Key', 'zyre-elementor-addons' ),
						'type' => 'text',
						'name' => 'consumer_key',
						'help' => [
							'instruction' => esc_html__( 'Get Consumer Key', 'zyre-elementor-addons' ),
							'link' => 'https://apps.twitter.com/app/',
						],
					],
					[
						'label' => esc_html__( 'Consumer Secret', 'zyre-elementor-addons' ),
						'type' => 'text',
						'name' => 'consumer_secret',
						'help' => [
							'instruction' => esc_html__( 'Get Consumer Secret', 'zyre-elementor-addons' ),
							'link' => 'https://apps.twitter.com/app/',
						],
					],
				],
				'is_pro' => true,
			],
			'facebook_feed' => [
				'title' => __( 'Facebook Feed', 'zyre-elementor-addons' ),
				'icon' => 'zy-fonticon zy-Social-feed-facebook',
				'fields' => [
					[
						'label' => esc_html__( 'Page ID. ', 'zyre-elementor-addons' ),
						'type' => 'text',
						'name' => 'page_id',
						'help' => [
							'instruction' => esc_html__( 'Get Page ID', 'zyre-elementor-addons' ),
							'link' => 'https://developers.facebook.com/apps/',
						],
					],
					[
						'label' => esc_html__( 'Access Token. ', 'zyre-elementor-addons' ),
						'type' => 'text',
						'name' => 'access_token',
						'help' => [
							'instruction' => esc_html__( 'Get Access Token.', 'zyre-elementor-addons' ),
							'link' => 'https://developers.facebook.com/apps/',
						],
					],
				],
				'is_pro' => true,
			],
			'instagram' => [
				'title' => __( 'Instagram', 'zyre-elementor-addons' ),
				'icon' => 'zy-fonticon zy-Social-feed-instagram',
				'fields' => [
					[
						'label' => esc_html__( 'Access Token. ', 'zyre-elementor-addons' ),
						'type' => 'text',
						'name' => 'access_token',
						'help' => [
							'instruction' => esc_html__( 'Get Access Token', 'zyre-elementor-addons' ),
							'link' => 'https://developers.facebook.com/docs/instagram-basic-display-api/getting-started',
						],
					],
				],
				'is_pro' => true,
			],
			'google_calendar' => [
				'title' => __( 'Google Calendar', 'zyre-elementor-addons' ),
				'icon' => 'zy-fonticon zy-Event-calendar',
				'fields' => [
					[
						'label' => esc_html__( 'Google API Key. ', 'zyre-elementor-addons' ),
						'type' => 'text',
						'name' => 'api_key',
						'help' => [
							'instruction' => esc_html__( 'Get API Key', 'zyre-elementor-addons' ),
							'link' => 'https://console.developers.google.com/',
						],
					],
				],
				'is_pro' => true,
			],
			'google_map' => [
				'title' => __( 'Google Map', 'zyre-elementor-addons' ),
				'icon' => 'zy-fonticon zy-Google-map',
				'fields' => [
					[
						'label' => esc_html__( 'Google Map API Key. ', 'zyre-elementor-addons' ),
						'type' => 'text',
						'name' => 'api_key',
						'help' => [
							'instruction' => esc_html__( 'Get API Key', 'zyre-elementor-addons' ),
							'link' => 'https://console.developers.google.com/',
						],
					],
				],
				'is_pro' => true,
			],
		];
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
