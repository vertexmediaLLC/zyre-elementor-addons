<?php
/**
 * Library Source
 *
 * @package ZyreAddons
 * @since 1.0.0
 */

namespace ZyreAddons\Elementor;

use Elementor\TemplateLibrary\Source_Base;

defined( 'ABSPATH' ) || die();

class Library_Source extends Source_Base {

	const LIBRARY_CACHE_KEY = 'zyre_library_cache';

	const TEMPLATES_INFO_API_URL = 'https://templates.zyreaddons.com/wp-json/zyre/v1/templates';

	const TEMPLATE_DATA_API_URL = 'https://templates.zyreaddons.com/wp-json/zyre/v1/templates/download/';

	public function get_id() {
		return 'zyre-library';
	}

	public function get_title() {
		return __( 'Zyre Library', 'zyre-elementor-addons' );
	}

	public function register_data() {}

	public function save_item( $template_data ) {
		return new \WP_Error( 'invalid_request', 'Cannot save template to a zyre library' );
	}

	public function update_item( $new_data ) {
		return new \WP_Error( 'invalid_request', 'Cannot update template to a zyre library' );
	}

	public function delete_template( $template_id ) {
		return new \WP_Error( 'invalid_request', 'Cannot delete template from a zyre library' );
	}

	public function export_template( $template_id ) {
		return new \WP_Error( 'invalid_request', 'Cannot export template from a zyre library' );
	}

	public function get_items( $args = [] ) {
		$library_data = self::get_library_data();

		$templates = [];

		if ( ! empty( $library_data['templates'] ) ) {
			foreach ( $library_data['templates'] as $template_data ) {
				$templates[] = $this->prepare_template( $template_data );
			}
		}

		return $templates;
	}

	/**
	 * Prepare template items to match model
	 *
	 * @param array $template_data
	 * @return array
	 */
	private function prepare_template( array $template_data ) {
		return [
			'template_id' => $template_data['id'],
			'title'       => $template_data['title'],
			'type'        => $template_data['type'],
			'thumbnail'   => $template_data['thumbnail'],
			'date'        => $template_data['created_at'],
			'tags'        => $template_data['tags'],
			'isPro'       => $template_data['is_pro'],
			'url'         => $template_data['url'],
		];
	}

	public function get_tags() {
		$library_data = self::get_library_data();

		return ( ! empty( $library_data['tags'] ) ? $library_data['tags'] : [] );
	}

	public function get_type_tags() {
		$library_data = self::get_library_data();

		return ( ! empty( $library_data['type_tags'] ) ? $library_data['type_tags'] : [] );
	}

	/**
	 * Get library data from remote source and cache
	 *
	 * @param boolean $force_update
	 * @return array
	 */
	private static function request_library_data( $force_update = false ) {
		$data = get_option( self::LIBRARY_CACHE_KEY );

		if ( $force_update || false === $data || empty( $data ) ) {
			$timeout = ( $force_update ) ? 25 : 8;

			$response = wp_remote_get( self::TEMPLATES_INFO_API_URL, [
				'timeout' => $timeout,
			] );

			if ( is_wp_error( $response ) || 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
				update_option( self::LIBRARY_CACHE_KEY, [] );
				return false;
			}

			$data = json_decode( wp_remote_retrieve_body( $response ), true );

			if ( empty( $data ) || ! is_array( $data ) ) {
				update_option( self::LIBRARY_CACHE_KEY, [] );
				return false;
			}

			update_option( self::LIBRARY_CACHE_KEY, $data, 'no' );
		}

		return $data;
	}

	/**
	 * Get library data
	 *
	 * @param boolean $force_update
	 * @return array
	 */
	public static function get_library_data( $force_update = false ) {
		self::request_library_data( $force_update );

		$data = get_option( self::LIBRARY_CACHE_KEY );

		if ( empty( $data ) ) {
			return [];
		}

		return $data;
	}

	public static function request_template_data( $template_id ) {
		if ( empty( $template_id ) ) {
			return;
		}

		$body = [
			'home_url' => trailingslashit( home_url() ),
			'version' => ZYRE_ADDONS_VERSION,
		];

		if ( zyre_has_pro() ) {
			$body['has_pro'] = 1;
			$body['pro_version'] = ZYRE_ADDONS_PRO_VERSION;
		}

		$response = wp_remote_get(
			self::TEMPLATE_DATA_API_URL . $template_id,
			[
				'body' => $body,
				'timeout' => 25,
			]
		);

		return wp_remote_retrieve_body( $response );
	}

	/**
	 * Retrieve a single remote template from its server.
	 *
	 * @param int $template_id The template ID.
	 * @return array Remote template.
	 */
	public function get_item( $template_id ) {
		$templates = $this->get_items();

		return $templates[ $template_id ];
	}

	/**
	 * Retrieve the data of a single remote template from its server.
	 *
	 * @return array|\WP_Error Remote Template data.
	 */
	public function get_data( array $args, $context = 'display' ) {
		$data = self::request_template_data( $args['template_id'] );

		$data = json_decode( $data, true );

		if ( empty( $data ) || empty( $data['content'] ) ) {
			throw new \Exception( esc_html__( 'Template does not have any content', 'zyre-elementor-addons' ) );
		}

		$data['content'] = $this->replace_elements_ids( $data['content'] );
		$data['content'] = $this->process_export_import_content( $data['content'], 'on_import' );

		$post_id = $args['editor_post_id'];
		$document = zyre_elementor()->documents->get( $post_id );

		if ( $document ) {
			$data['content'] = $document->get_elements_raw_data( $data['content'], true );
		}

		return $data;
	}
}
