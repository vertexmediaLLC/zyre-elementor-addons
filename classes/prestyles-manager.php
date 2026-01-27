<?php

namespace ZyreAddons\Elementor;

defined( 'ABSPATH' ) || die();

class PreStyles_Manager {

	const NONCE = 'zyre_widget_prestyles_nonce';

	public static function init() {
		add_action( 'elementor/editor/after_enqueue_scripts', [ __CLASS__, 'enqueue_editor_scripts' ] );
		add_action( 'wp_ajax_zyre_widget_set_prestyle', [ __CLASS__, 'set_prestyle' ] );
	}

	public static function set_prestyle() {
		if ( ! check_ajax_referer( self::NONCE, 'security' ) ) {
			wp_send_json_error( __( 'Invalid prestyle request', 'zyre-elementor-addons' ), 403 );
		}

		if ( empty( $_GET['widget'] ) ) {
			wp_send_json_error( __( 'Incomplete prestyle request', 'zyre-elementor-addons' ), 404 );
		}

		$widget_name = sanitize_text_field( substr( wp_unslash( $_GET['widget'] ), 5 ) );
		$widget_id = sanitize_text_field( wp_unslash( $_GET['widgetID'] ) );
		$post_id = intval( $_GET['post_id'] );
		$is_pro = isset( $_GET['isPro'] ) ? filter_var( $_GET['isPro'], FILTER_VALIDATE_BOOLEAN ) : false;

		// Check if the reset parameter is set
		$is_reset = isset( $_GET['reset'] ) && 'true' === $_GET['reset'];

		$styles = self::get_prestyles( $widget_name, $is_pro);
		if ( ! $styles ) {
			wp_send_json_error( __( 'Prestyle not found', 'zyre-elementor-addons' ), 404 );
		}

		$elementor_data = self::get_elementor_data( $post_id, $widget_id );
		if ( $elementor_data ) {
			$prestyles = json_decode( $styles, true );

			if ( $is_reset ) {
				// SYNC mode → return pure JSON, no merge
				$styles = wp_json_encode( $prestyles );
			} else {
				// normal load → keep merge behavior
				$merged_styles = array_merge( $prestyles, $elementor_data );
				$styles = wp_json_encode( $merged_styles );
			}
		}

		// Got the widget prestyle
		wp_send_json_success( $styles, 200 );
		exit;
	}

	protected static function get_prestyles( $widget_name, $is_pro = false ) {
		$json_file = is_rtl() ? $widget_name . '-rtl.json' : $widget_name . '.json';

		$dir = ZYRE_ADDONS_DIR_PATH;
		if ( zyre_has_pro() && $is_pro ) {
			$dir = ZYRE_ADDONS_PRO_DIR_PATH;
		}

		$style = $dir . 'assets/pre-styles/' . $widget_name . '/' . $json_file;
		if ( ! is_readable( $style ) ) {
			return false;
		}

		return file_get_contents( $style );
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
				'resetStyleAlert'  => __( "This action will remove the current preset permanently.\nDo you wish to proceed?", 'zyre-elementor-addons' ),
				'syncStyleAlert'  => __( "This action will revert the Pre-styles to its default state.\nDo you wish to proceed?", 'zyre-elementor-addons' ),
				'syncTitleText'  => __( "Click to reset the Pre-styles", 'zyre-elementor-addons' ),
			]
		);
	}
}

PreStyles_Manager::init();
