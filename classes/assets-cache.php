<?php

namespace ZyreAddons\Elementor;

defined( 'ABSPATH' ) || die();

/**
 * Assets_Cache class
 *
 * @since 1.0.0
 * @package ZyreAddons
 */
class Assets_Cache {

	const FILE_PREFIX = 'zyre-';

	const BASE_DIR = 'zyre-addons';

	const CSS_DIR = 'css';

	/**
	 * Is common CSS loaded.
	 *
	 * @var $is_common_loaded
	 */
	protected static $is_common_loaded = false;

	/**
	 * The Widgets_Cache instance.
	 *
	 * @var $post_id
	 */
	protected $post_id = 0;

	/**
	 * The Widgets_Cache instance.
	 *
	 * @var $widgets_cache Widgets_Cache
	 */
	protected $widgets_cache = null;

	/**
	 * The Upload direcotory PATH
	 *
	 * @var $upload_path Upload direcotory PATH.
	 */
	protected $upload_path;

	/**
	 * The Upload direcotory URL
	 *
	 * @var $upload_url Upload direcotory URL.
	 */
	protected $upload_url;

	/**
	 * Constructor for initializing a new instance.
	 *
	 * @since 1.0.0
	 * @param int           $post_id The ID of the associated post.
	 * @param Widgets_Cache $widget_cache_instance Optional.
	 */
	public function __construct( $post_id = 0, ?Widgets_Cache $widget_cache_instance = null ) {
		$this->post_id = $post_id;
		$this->widgets_cache = $widget_cache_instance;

		$upload_dir = wp_upload_dir();
		$this->upload_path = trailingslashit( $upload_dir['basedir'] );
		$this->upload_url = trailingslashit( $upload_dir['baseurl'] );

		// Mixed content issue overcome when using ssl.
		$this->upload_url = is_ssl() ? str_replace( 'http://', 'https://', (string) $this->upload_url ) : $this->upload_url;
	}

	/**
	 * Retrieves the widgets cache instance associated with the current post ID.
	 *
	 * @since 1.0.0
	 * @return Widgets_Cache The widgets cache instance.
	 */
	public function get_widgets_cache() {
		if ( is_null( $this->widgets_cache ) ) {
			$this->widgets_cache = new Widgets_Cache( $this->get_post_id() );
		}

		return $this->widgets_cache;
	}

	/**
	 * Get the directory name for the cache.
	 *
	 * @since 1.0.0
	 * @return string The directory name for the cache.
	 */
	public function get_cache_dir_name() {
		return trailingslashit( self::BASE_DIR ) . trailingslashit( self::CSS_DIR );
	}

	/**
	 * Get the ID of the post associated with the cache.
	 *
	 * @since 1.0.0
	 * @return int The ID of the post.
	 */
	public function get_post_id() {
		return $this->post_id;
	}

	/**
	 * Get the path of the cache directory.
	 *
	 * @since 1.0.0
	 * @return string The path of the cache directory.
	 */
	public function get_cache_dir() {
		return wp_normalize_path( $this->upload_path . $this->get_cache_dir_name() );
	}

	/**
	 * Get the URL of the cache directory.
	 *
	 * @since 1.0.0
	 * @return string The URL of the cache directory.
	 */
	public function get_cache_url() {
		return $this->upload_url . $this->get_cache_dir_name();
	}

	/**
	 * Get the file name of the cached CSS file.
	 *
	 * @since 1.0.0
	 * @return string The file name of the cached CSS file.
	 */
	public function get_file_name() {
		return $this->get_cache_dir() . self::FILE_PREFIX . "{$this->get_post_id()}.css";
	}

	/**
	 * Get the URL of the cached CSS file.
	 *
	 * @since 1.0.0
	 * @return string The URL of the cached CSS file.
	 */
	public function get_file_url() {
		return $this->get_cache_url() . self::FILE_PREFIX . "{$this->get_post_id()}.css";
	}

	/**
	 * Check if the cached file exists.
	 *
	 * @return bool True if the cached file exists, false otherwise.
	 */
	public function cache_exists() {
		return file_exists( $this->get_file_name() );
	}

	/**
	 * Checks if the cache exists, and saves it if it doesn't.
	 *
	 * @since 1.0.0
	 * @return bool True if the cache exists, false otherwise.
	 */
	public function has() {
		if ( ! $this->cache_exists() ) {
			$this->save();
		}

		return $this->cache_exists();
	}

	/**
	 * Delete the cached file if it exists.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function delete() {
		if ( $this->cache_exists() ) {
			wp_delete_file( $this->get_file_name() );
		}
	}

	/**
	 * Delete all cached files in the cache directory.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function delete_all() {
		$files = glob( $this->get_cache_dir() . '*' );
		foreach ( $files as $file ) {
			if ( is_file( $file ) ) {
				wp_delete_file( $file );
			}
		}
	}

	/**
	 * Enqueues the cached stylesheet if it exists.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function enqueue() {
		$this->enqueue_common();

		if ( $this->has() ) {
			wp_enqueue_style(
				'zyre-elementor-addons-' . $this->get_post_id(),
				$this->get_file_url(),
				[ 'elementor-frontend', 'zyre-elementor-addons-global-vars', 'zyre-elementor-addons-global' ],
				ZYRE_ADDONS_VERSION . '.' . get_post_modified_time()
			);
		}
	}

	/**
	 * Enqueues common CSS styles used by widgets if not already loaded.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function enqueue_common() {
		if ( self::$is_common_loaded ) {
			return;
		}

		$widgets_map = Widgets_Manager::get_widgets_map();
		$base_widget = isset( $widgets_map[ Widgets_Manager::get_base_widget_key() ] ) ? $widgets_map[ Widgets_Manager::get_base_widget_key() ] : [];

		// Get common css styles.
		if ( ! isset( $base_widget['css'] ) || ! is_array( $base_widget['css'] ) ) {
			return;
		}

		wp_add_inline_style(
			'elementor-frontend',
			$this->get_css( $base_widget['css'] )
		);

		self::$is_common_loaded = true;
	}

	/**
	 * Enqueues libraries.
	 *
	 * Enqueues CSS and JS libraries defined by base widget and individual widgets.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function enqueue_libraries() {
		$widgets_map = Widgets_Manager::get_widgets_map();
		$base_widget = isset( $widgets_map[ Widgets_Manager::get_base_widget_key() ] ) ? $widgets_map[ Widgets_Manager::get_base_widget_key() ] : [];

		if ( isset( $base_widget['libs'], $base_widget['libs']['css'] ) && is_array( $base_widget['libs']['css'] ) ) {
			foreach ( $base_widget['libs']['css'] as $libs_css_handle ) {
				wp_enqueue_style( $libs_css_handle );
			}
		}

		if ( isset( $base_widget['libs'], $base_widget['libs']['js'] ) && is_array( $base_widget['libs']['js'] ) ) {
			foreach ( $base_widget['libs']['js'] as $libs_js_handle ) {
				wp_enqueue_script( $libs_js_handle );
			}
		}

		/**
		 * Return early if there's no widget cache
		 */
		$widgets = $this->get_widgets_cache()->get();

		if ( empty( $widgets ) || ! is_array( $widgets ) ) {
			return;
		}

		foreach ( $widgets as $widget_key ) {
			if ( ! isset( $widgets_map[ $widget_key ], $widgets_map[ $widget_key ]['libs'] ) ) {
				continue;
			}

			$libs = $widgets_map[ $widget_key ]['libs'];

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
	}

	/**
	 * Saves CSS for widgets.
	 *
	 * Retrieves widgets from cache, processes their CSS, and saves it to a file.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function save() {
		$widgets = $this->get_widgets_cache()->get();
		$widgets_map = Widgets_Manager::get_widgets_map();
		$widgets_processed = [];
		$css = '';

		foreach ( $widgets as $widget_key ) {
			if ( isset( $widgets_processed[ $widget_key ] ) || ! isset( $widgets_map[ $widget_key ], $widgets_map[ $widget_key ]['css'] ) ) {
				continue;
			}

			$is_pro = ( isset( $widgets_map[ $widget_key ]['is_pro'] ) && $widgets_map[ $widget_key ]['is_pro'] );
			$css .= $this->get_css( $widgets_map[ $widget_key ]['css'], $is_pro );

			$widgets_processed[ $widget_key ] = true;
		}

		if ( empty( $css ) ) {
			return;
		}

		$css .= sprintf( '/** Widgets: %s **/', implode( ', ', array_keys( $widgets_processed ) ) );

		if ( ! is_dir( $this->get_cache_dir() ) ) {
			wp_mkdir_p( $this->get_cache_dir() );
		}

		file_put_contents( $this->get_file_name(), $css );
	}

	/**
	 * Retrieves CSS content from specified files.
	 *
	 * @since 1.0.0
	 * @param array   $file_names The names of the CSS files.
	 * @param boolean $is_pro     Indicates if the widget is a pro version.
	 * @param string  $widget_key The key of the widget.
	 * @return string             The concatenated CSS content.
	 */
	protected function get_css( $file_names, $is_pro = false, $widget_key = '' ) {
		$suffix = zyre_is_script_debug_enabled() ? '.' : '.min.';
		$css = '';

		foreach ( $file_names as $file_name ) {
			$widget_name = ! empty( $widget_key ) ? $widget_key : $file_name;
			$file_path = ZYRE_ADDONS_DIR_PATH . "assets/css/widgets/{$widget_name}/{$file_name}{$suffix}css";
			$file_path = apply_filters( 'zyreaddons_get_styles_file_path', $file_path, $file_name, $is_pro );

			if ( is_readable( $file_path ) ) {
				$css .= file_get_contents( $file_path );
			}
		}

		return $css;
	}
}
