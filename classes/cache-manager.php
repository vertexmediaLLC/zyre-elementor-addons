<?php

namespace ZyreAddons\Elementor;

use Elementor\Core\Files\CSS\Post as Post_CSS;

defined( 'ABSPATH' ) || die();

/**
 * Cache_Manager class
 *
 * @since 1.0.0
 * @package ZyreAddons
 */
class Cache_Manager {

	/**
	 * Static variable to hold the widgets cache instance.
	 *
	 * @var Widgets_Cache|null
	 */
	private static $widgets_cache;

	/**
	 * Registers actions to cache widgets after Elementor editor save and delete cache after post deletion.
	 */
	public static function init() {
		add_action( 'elementor/editor/after_save', array( __CLASS__, 'cache_widgets' ), 10, 2 );
		add_action( 'after_delete_post', array( __CLASS__, 'delete_cache' ) );
	}

	/**
	 * Deletes the cache for the specified post ID.
	 *
	 * @param int $post_id The ID of the post.
	 */
	public static function delete_cache( $post_id ) {
		$assets_cache = new Assets_Cache( $post_id );
		$assets_cache->delete();
	}

	/**
	 * Caches the widgets for the specified post ID after it's saved.
	 *
	 * @since 1.0.0
	 * @param int   $post_id The ID of the post.
	 * @param array $data    Data of the saved post.
	 */
	public static function cache_widgets( $post_id, $data ) {
		if ( ! self::is_published( $post_id ) ) {
			return;
		}

		self::$widgets_cache = new Widgets_Cache( $post_id, $data );
		self::$widgets_cache->save();

		// Delete to regenerate cache file.
		$assets_cache = new Assets_Cache( $post_id, self::$widgets_cache );
		$assets_cache->delete();
	}

	/**
	 * Checks if the specified post ID is published.
	 *
	 * @param int $post_id The ID of the post.
	 */
	public static function is_published( $post_id ) {
		return get_post_status( $post_id ) === 'publish';
	}

	/**
	 * Checks if the current page is in editing mode.
	 */
	public static function is_editing_mode() {
		return (
			zyre_elementor()->editor->is_edit_mode() ||
			zyre_elementor()->preview->is_preview_mode() ||
			is_preview()
		);
	}

	/**
	 * Checks if a post is built with Elementor.
	 *
	 * @since 1.0.0
	 * @param int $post_id The ID of the post to check.
	 * @return bool True if built with Elementor, false otherwise.
	 */
	public static function is_built_with_elementor( $post_id ) {
		$post = get_post( $post_id );
		if ( ! empty( $post ) && isset( $post->ID ) ) {
			return zyre_elementor()->documents->get( $post->ID )->is_built_with_elementor();
		}

		return false;
	}

	/**
	 * Determines if assets should be enqueued for the given post.
	 *
	 * @param int $post_id The ID of the post to check.
	 */
	public static function should_enqueue( $post_id ) {
		return (
			zyre_is_on_demand_cache_enabled() &&
			self::is_built_with_elementor( $post_id ) &&
			self::is_published( $post_id ) &&
			! self::is_editing_mode()
		);
	}

	/**
	 * Determines if raw enqueueing should occur.
	 *
	 * @since 1.0.0
	 * @param int $post_id The ID of the post.
	 * @return bool Whether raw enqueueing should occur.
	 */
	public static function should_enqueue_raw( $post_id ) {
		return (
			self::is_built_with_elementor( $post_id ) &&
			(
				! zyre_is_on_demand_cache_enabled() ||
				! self::is_published( $post_id ) ||
				self::is_editing_mode()
			)
		);
	}

	/**
	 * Enqueues Font Awesome 5 fonts based on post metadata.
	 *
	 * @since 1.0.0
	 * @param int $post_id The ID of the post.
	 * @return void
	 */
	public static function enqueue_fa5_fonts( $post_id ) {
		$post_css = new Post_CSS( $post_id );
		$meta = $post_css->get_meta();

		if ( ! empty( $meta['icons'] ) ) {
			$icons_types = \Elementor\Icons_Manager::get_icon_manager_tabs();

			foreach ( $meta['icons'] as $icon_font ) {
				if ( ! isset( $icons_types[ $icon_font ] ) ) {
					continue;
				}

				zyre_elementor()->frontend->enqueue_font( $icon_font );
			}
		}
	}

	/**
	 * Enqueues assets for the specified post.
	 *
	 * @since 1.0.0
	 * @param int $post_id The ID of the post.
	 */
	public static function enqueue( $post_id ) {
		$assets_cache = new Assets_Cache( $post_id, self::$widgets_cache );
		$assets_cache->enqueue_libraries();
		$assets_cache->enqueue();
		self::enqueue_fa5_fonts( $post_id );

		wp_enqueue_style( 'zyre-elementor-addons-global-vars' );
		wp_enqueue_style( 'zyre-elementor-addons-global' );
		wp_enqueue_style( 'zyre-elementor-addons-widgets' );
		wp_enqueue_script( 'zyre-elementor-addons' );

		do_action( 'zyreaddons_enqueue_assets', $is_cache = true, $post_id );
	}

	/**
	 * Enqueues assets directly without caching.
	 *
	 * @since 1.0.0
	 */
	public static function enqueue_raw() {
		$suffix = zyre_is_script_debug_enabled() ? '.' : '.min.';
		$widgets_map = Widgets_Manager::get_active_widgets();

		foreach ( $widgets_map as $widget_key => $data ) {
			if ( isset( $data['libs'] ) ) {
				$libs = $data['libs'];

				if ( isset( $libs['css'] ) && is_array( $libs['css'] ) ) {
					foreach ( $libs['css'] as $libs_css_handle ) {
						wp_enqueue_style( $libs_css_handle );
					}
				}

				if ( isset( $libs['js'] ) && is_array( $libs['js'] ) ) {
					foreach ( $libs['js'] as $libs_js_handle ) {
						wp_enqueue_script( $libs_js_handle );
					}
				}
			}

			// Enqueue widget-specific stylesheets.
			if ( isset( $data['css'] ) ) {
				if ( isset( $data['css'] ) && is_array( $data['css'] ) ) {
					foreach ( $data['css'] as $stylesheet ) {
						$file_path = ZYRE_ADDONS_DIR_PATH . "assets/css/widgets/{$widget_key}/{$stylesheet}{$suffix}css";
						if ( is_readable( $file_path ) ) {
							wp_enqueue_style(
								"zyre-{$stylesheet}",
								ZYRE_ADDONS_ASSETS . "css/widgets/{$widget_key}/{$stylesheet}{$suffix}css",
								array( 'zyre-elementor-addons-global-vars', 'zyre-elementor-addons-global', 'zyre-elementor-addons-widgets' ),
								ZYRE_ADDONS_VERSION
							);
						}
					}
				}
			}
		}

		wp_enqueue_style( 'zyre-elementor-addons-global-vars' );
		wp_enqueue_style( 'zyre-elementor-addons-global' );
		wp_enqueue_style( 'zyre-elementor-addons-widgets' );
		wp_enqueue_script( 'zyre-elementor-addons' );

		do_action( 'zyreaddons_enqueue_assets', $is_cache = false, 0 );
	}
}

Cache_Manager::init();
