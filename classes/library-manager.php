<?php
/**
 * Library Manager
 *
 * @package ZyreAddons
 * @since 1.0.0
 */

namespace ZyreAddons\Elementor;

use Elementor\Core\Common\Modules\Ajax\Module as Ajax;

defined( 'ABSPATH' ) || die();

class Library_Manager {

	protected static $source = null;

	public static function init() {
		add_action( 'elementor/editor/footer', [ __CLASS__, 'print_template_views' ] );
		add_action( 'elementor/ajax/register_actions', [ __CLASS__, 'register_ajax_actions' ] );
	}

	public static function print_template_views() {
		include_once ZYRE_ADDONS_DIR_PATH . 'templates/template-library/templates.php';
	}

	public static function enqueue_scripts() {
		$suffix = zyre_is_script_debug_enabled() ? '.' : '.min.';

		wp_enqueue_style(
			'zyre-addons-templates-library',
			ZYRE_ADDONS_ASSETS . 'admin/css/template-library' . $suffix . 'css',
			[
				'elementor-editor',
			],
			ZYRE_ADDONS_VERSION
		);

		wp_enqueue_script(
			'zyre-addons-templates-library',
			ZYRE_ADDONS_ASSETS . 'admin/js/template-library' . $suffix . 'js',
			[
				'zyre-elementor-addons-editor',
				'jquery-hover-intent',
			],
			ZYRE_ADDONS_VERSION,
			true
		);
	}

	public static function get_source() {
		if ( is_null( self::$source ) ) {
			self::$source = new Library_Source();
		}

		return self::$source;
	}

	public static function get_library_data( array $args ) {
		$source = self::get_source();

		if ( ! empty( $args['sync'] ) ) {
			Library_Source::get_library_data( true );
		}

		return [
			'templates' => $source->get_items(),
			'tags'      => $source->get_tags(),
			'type_tags' => $source->get_type_tags(),
		];
	}

	public static function get_template_data( array $args ) {
		$source = self::get_source();
		$data = $source->get_data( $args );
		return $data;
	}

	public static function register_ajax_actions( Ajax $ajax ) {
		$ajax->register_ajax_action( 'get_zyre_library_data', function ( $data ) {
			if ( ! current_user_can( 'edit_posts' ) ) {
				throw new \Exception( __( 'Access Denied', 'zyre-elementor-addons' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped
			}

			if ( ! empty( $data['editor_post_id'] ) ) {
				$editor_post_id = absint( $data['editor_post_id'] );

				if ( ! get_post( $editor_post_id ) ) {
					throw new \Exception( __( 'Post not found.', 'zyre-elementor-addons' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped
				}

				zyre_elementor()->db->switch_to_post( $editor_post_id );
			}

			$result = self::get_library_data( $data );

			return $result;
		} );

		$ajax->register_ajax_action( 'get_zyre_template_data', function ( $data ) {
			if ( ! current_user_can( 'edit_posts' ) ) {
				throw new \Exception( __( 'Access Denied', 'zyre-elementor-addons' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped
			}

			if ( ! empty( $data['editor_post_id'] ) ) {
				$editor_post_id = absint( $data['editor_post_id'] );

				if ( ! get_post( $editor_post_id ) ) {
					throw new \Exception( __( 'Post not found', 'zyre-elementor-addons' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped
				}

				zyre_elementor()->db->switch_to_post( $editor_post_id );
			}

			if ( empty( $data['template_id'] ) ) {
				throw new \Exception( __( 'Template id missing', 'zyre-elementor-addons' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped
			}

			$result = self::get_template_data( $data );

			return $result;
		} );
	}
}

Library_Manager::init();
