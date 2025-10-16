<?php

namespace ZyreAddons\Elementor;

defined( 'ABSPATH' ) || die();

class PreStyles_Manager {

	const NONCE = 'zyre_widget_prestyles_nonce';

	public static function init() {
		add_action( 'elementor/editor/after_enqueue_scripts', [ __CLASS__, 'enqueue_editor_scripts' ] );
		add_action( 'wp_ajax_zyre_widget_set_prestyle', [ __CLASS__, 'set_prestyle' ] );
	}

	protected static function get_prestyles( $style_name ) {
		$json_file = is_rtl() ? $style_name . '-rtl.json' : $style_name . '.json';

		$style = ZYRE_ADDONS_DIR_PATH . 'assets/pre-styles/' . $style_name . '/' . $json_file;
		if ( ! is_readable( $style ) ) {
			return false;
		}

		return file_get_contents( $style );
	}

	public static function set_prestyle() {
		if ( ! check_ajax_referer( self::NONCE, 'security' ) ) {
			wp_send_json_error( __( 'Invalid prestyle request', 'zyre-elementor-addons' ), 403 );
		}

		if ( empty( $_GET['widget'] ) ) {
			wp_send_json_error( __( 'Incomplete prestyle request', 'zyre-elementor-addons' ), 404 );
		}

		$widget_name = sanitize_text_field( substr( $_GET['widget'], 5 ) );
		$widget_id = sanitize_text_field( $_GET['widgetID'] );
		$post_id = intval( $_GET['post_id'] );

		// Check if the reset parameter is set
		$is_reset = isset( $_GET['reset'] ) && 'true' === $_GET['reset'];

		$styles = self::get_prestyles( $widget_name );
		if ( ! $styles ) {
			wp_send_json_error( __( 'Prestyle not found', 'zyre-elementor-addons' ), 404 );
		}

		$elementor_data = self::get_elementor_data( $post_id, $widget_id );
		if ( $elementor_data ) {
			$prestyles = json_decode( $styles, true );
			$merged_styles = $is_reset
			? array_merge( $elementor_data, $prestyles ) // Reset: elementor_data takes precedence
			: array_merge( $prestyles, $elementor_data ); // Default: prestyles take precedence

			$styles = wp_json_encode( $merged_styles );
		}

		// Got the widget prestyle
		wp_send_json_success( $styles, 200 );
		exit;
	}

	public static function get_elementor_data( $post_id, $widget_id ) {
		$document = zyre_elementor()->documents->get( $post_id );

		if ( ! $document->is_built_with_elementor() ) {
			return [];
		}

		$cache = [];
		$style_key_default = 'one';
		$widgets_cache = new Widgets_Cache(); // Create an instance

		if ( $document ) {
			$data = $document ? $document->get_elements_data() : [];

			if ( empty( $data ) ) {
				return [];
			}

			zyre_elementor()->db->iterate_data(
				$data,
				function ( $element ) use ( &$cache, $style_key_default, $widgets_cache, $widget_id ) {
					$type = $widgets_cache->get_widget_type( $element );

					if ( strpos( $type, 'zyre-' ) !== false && $widget_id === $element['id'] ) {
						$style_key = str_replace( 'zyre-', '', $type ) . '_style';

						if ( isset( $element['settings'][ $style_key ] ) && ! empty( $element['settings'][ $style_key ] ) ) {
							$style_key = $element['settings'][ $style_key ];
							$cache[ $style_key ] = $element['settings'];
						} else {
							$cache[ $style_key_default ] = $element['settings'];
						}
					}

					return $cache;
				}
			);
		}

		return $cache;
	}

	public static function enqueue_editor_scripts() {
		wp_enqueue_script(
			'zyre-pre-styles',
			ZYRE_ADDONS_ASSETS . 'admin/js/pre-styles.js',
			[ 'elementor-editor' ],
			ZYRE_ADDONS_VERSION,
			true
		);

		wp_localize_script(
			'zyre-pre-styles',
			'zyrePreStyles',
			[
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'security'  => wp_create_nonce( self::NONCE ),
				'resetStyleAlert'  => __( 'This action will reset the current style and may also reset your content. Are you sure you want to proceed?', 'zyre-elementor-addons' ),
			]
		);
	}
}

PreStyles_Manager::init();
