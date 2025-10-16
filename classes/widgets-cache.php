<?php

namespace ZyreAddons\Elementor;

defined( 'ABSPATH' ) || die();

/**
 * Widgets_Cache class
 *
 * @since 1.0.0
 * @package ZyreAddons
 */
class Widgets_Cache {

	const OPTION_KEY = 'zyreaddons_data_cache';

	const META_KEY = '_zyreaddons_data_cache';

	/**
	 * The ID of the post associated with this cache.
	 *
	 * @var int
	 */
	protected $post_id = 0;

	/**
	 * Elementor data associated with the post.
	 *
	 * @var array|null
	 */
	protected $elementor_data = null;

	/**
	 * Indicates whether the post is built with Elementor.
	 *
	 * @var bool
	 */
	protected $is_built_with_elementor = false;

	/**
	 * Indicates whether the post is published.
	 *
	 * @var bool
	 */
	protected $is_published = false;

	/**
	 * Constructs a new Widgets_Cache object.
	 *
	 * @since 1.0.0
	 * @param int   $post_id The ID of the post.
	 * @param array $data    Data associated with the post.
	 */
	public function __construct( $post_id = 0, $data = null ) {
		if ( ! $post_id ) {
			return;
		}

		$post = get_post( $post_id );
		$post_ID = ! empty( $post ) && isset( $post->ID ) ? $post->ID : 0;
		if ( ! $post_ID || ! Cache_Manager::is_built_with_elementor( $post_ID ) || ! Cache_Manager::is_published( $post_ID ) ) {
			return;
		}

		if ( ! is_null( $data ) ) {
			$this->elementor_data = $data;
		}

		$this->post_id = $post_id;
		$this->is_published = true;
		$this->is_built_with_elementor = true;
	}

	/**
	 * Retrieves the post ID associated with this cache.
	 *
	 * @return int The post ID.
	 */
	public function get_post_id() {
		return $this->post_id;
	}

	/**
	 * Retrieves global widget type for a given template ID.
	 *
	 * Fetches local template data based on the ID.
	 *
	 * @since 1.0.0
	 * @param int $template_id The template ID.
	 * @return string Global widget type, or empty if not found.
	 */
	protected function get_global_widget_type( $template_id ) {
		$template_data = zyre_elementor()->templates_manager->get_template_data(
			[
				'source'      => 'local',
				'template_id' => $template_id,
			]
		);

		if ( is_wp_error( $template_data ) ) {
			return '';
		}

		if ( empty( $template_data['content'] ) ) {
			return '';
		}

		$original_widget_type = zyre_elementor()->widgets_manager->get_widget_types( $template_data['content'][0]['widgetType'] );

		return $original_widget_type ? $template_data['content'][0]['widgetType'] : '';
	}

	/**
	 * Retrieves widget type for the given element.
	 *
	 * Returns 'widgetType' if available, otherwise 'elType'.
	 * If type is 'global' with a template ID, retrieves global widget type.
	 *
	 * @since 1.0.0
	 * @param array $element Elementor element data.
	 * @return string Widget type.
	 */
	public function get_widget_type( $element ) {
		if ( empty( $element['widgetType'] ) ) {
			$type = $element['elType'];
		} else {
			$type = $element['widgetType'];
		}

		if ( 'global' === $type && ! empty( $element['templateID'] ) ) {
			$type = $this->get_global_widget_type( $element['templateID'] );
		}

		return $type;
	}

	/**
	 * Retrieves cached data from post meta based on the associated post ID.
	 *
	 * @since 1.0.0
	 * @return array Cached data.
	 */
	public function get_cache_data() {
		$cache = get_post_meta( $this->get_post_id(), self::META_KEY, true );
		if ( empty( $cache ) || ! is_array( $cache ) ) {
			$cache = $this->save();
		}

		return $cache;
	}

	/**
	 * Retrieves widget data from cached data.
	 * Remaining only keys and styles array, clear others.
	 *
	 * @since 1.0.0
	 * @return array Widget styles with keys.
	 */
	public function get_styles() {
		$cache = $this->get_cache_data();

		return array_reduce(
			array_keys( $cache ),
			function ( $result, $widget_key ) use ( $cache ) {
				$new_key = str_replace( 'zyre-', '', $widget_key );
				$result[ $new_key ] = [
					'styles' => array_map(
						function ( $style ) use ( $new_key ) {
							return $new_key . '-' . $style; // Add the key as a prefix to each style
						},
						$cache[ $widget_key ]['styles']
					),
				];
				return $result;
			},
			[]
		);
	}

	/**
	 * Retrieves widget keys from cached data.
	 *
	 * @since 1.0.0
	 * @return array Widget keys.
	 */
	public function get() {
		$cache = $this->get_cache_data();

		return array_map(
			function ( $widget_key ) {
				return str_replace( 'zyre-', '', $widget_key );
			},
			array_keys( $cache )
		);
	}

	/**
	 * Checks if cached data contains any widget keys.
	 *
	 * @since 1.0.0
	 * @return bool True.
	 */
	public function has() {
		$cache = $this->get();
		return ! empty( $cache );
	}

	/**
	 * Deletes the cache.
	 *
	 * @since 1.0.0
	 */
	public function delete() {
		delete_post_meta( $this->get_post_id(), self::META_KEY );
	}

	/**
	 * Get the post type of the current post.
	 *
	 * @since 1.0.0
	 * @return string The post type.
	 */
	public function get_post_type() {
		return get_post_type( $this->get_post_id() );
	}

	/**
	 * Retrieves Elementor data associated with the current post ID.
	 *
	 * If the instance is not built with Elementor or not published, returns an empty array.
	 *
	 * @since 1.0.0
	 * @return array Elementor data.
	 */
	public function get_elementor_data() {
		if ( ! $this->is_built_with_elementor || ! $this->is_published ) {
			return [];
		}

		if ( is_null( $this->elementor_data ) ) {
			$document = zyre_elementor()->documents->get( $this->get_post_id() );
			$data = $document ? $document->get_elements_data() : [];
		} else {
			$data = $this->elementor_data;
		}

		return $data;
	}

	/**
	 * Saves Elementor data associated with the current instance.
	 *
	 * Retrieves Elementor data and iterates through elements to count widget types.
	 * Updates both post meta and global cache with the widget type counts.
	 *
	 * @since 1.0.0
	 * @return array The saved cache data.
	 */
	public function save() {
		$data = $this->get_elementor_data();

		if ( empty( $data ) ) {
			return [];
		}

		$cache = [];
		$styles = [ 'one' ];
		zyre_elementor()->db->iterate_data(
			$data,
			function ( $element ) use ( &$cache, &$styles ) {
				$type = $this->get_widget_type( $element );

				if ( strpos( $type, 'zyre-' ) !== false ) {
					if ( ! isset( $cache[ $type ] ) ) {
						$cache[ $type ]['used'] = 0;
					}
					$cache[ $type ]['used']++;

					$style_key = str_replace( 'zyre-', '', $type ) . '_style';

					if ( isset( $element['settings'][ $style_key ] ) && ! empty( $element['settings'][ $style_key ] ) ) {
						$cache[ $type ]['styles'][] = $element['settings'][ $style_key ];
					} else {
						$cache[ $type ]['styles'] = $styles;
					}
				}

				return $element;
			}
		);

		// Handle global cache here.
		$doc_type = $this->get_post_type();
		$prev_cache = get_post_meta( $this->get_post_id(), self::META_KEY, true );
		$global_cache = get_option( self::OPTION_KEY, [] );

		if ( is_array( $prev_cache ) ) {
			foreach ( $prev_cache as $type => $info ) {
				if ( isset( $global_cache[ $doc_type ][ $type ] ) ) {
					$global_cache[ $doc_type ][ $type ] -= $prev_cache[ $type ]['used'];

					if ( 0 === $global_cache[ $doc_type ][ $type ] ) {
						unset( $global_cache[ $doc_type ][ $type ] );
					}
				}
			}
		}

		foreach ( $cache as $type => $info ) {
			if ( ! isset( $global_cache[ $doc_type ] ) ) {
				$global_cache[ $doc_type ] = [];
			}

			if ( ! isset( $global_cache[ $doc_type ][ $type ] ) ) {
				$global_cache[ $doc_type ][ $type ] = 0;
			}

			$global_cache[ $doc_type ][ $type ] += $cache[ $type ]['used'];
		}

		// Save cache.
		update_option( self::OPTION_KEY, $global_cache );
		update_post_meta( $this->get_post_id(), self::META_KEY, $cache );

		return $cache;
	}
}
