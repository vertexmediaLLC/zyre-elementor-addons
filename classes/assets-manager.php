<?php

namespace ZyreAddons\Elementor;

use Elementor\Core\Files\CSS\Post as Post_CSS;
use Elementor\Core\Settings\Manager as SettingsManager;

defined( 'ABSPATH' ) || die();

/**
 * Assets_Manager class
 *
 * @since 1.0.0
 */
class Assets_Manager {

	public static $suffix;

	/**
	 * Bind hook and run internal methods here
	 */
	public static function init() {
		self::$suffix = zyre_is_script_debug_enabled() ? '.' : '.min.';

		// Frontend scripts.
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'frontend_register' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'frontend_enqueue' ), 100 );
		add_action( 'elementor/css-file/post/enqueue', array( __CLASS__, 'frontend_elementor_post_enqueue' ) );

		// Edit and enqueue in Elementor preview mode.
		add_action( 'elementor/preview/enqueue_styles', array( __CLASS__, 'enqueue_elementor_preview_styles' ) );

		// Enqueue Elementor editor scripts.
		add_action( 'elementor/editor/after_enqueue_scripts', array( __CLASS__, 'elementor_editor_enqueue' ) );

		// Registers the paragraph toolbar for Elementor editor.
		add_filter( 'elementor/editor/localize_settings', array( __CLASS__, 'add_inline_editing_intermediate_toolbar' ) );
	}

	/**
	 * Registers the inline editing paragraph toolbar configuration.
	 *
	 * @since 1.0.0
	 * @param array $config The current Elementor editor settings.
	 * @return array
	 */
	public static function add_inline_editing_intermediate_toolbar( $config ) {
		if ( ! isset( $config['inlineEditing'] ) ) {
			return $config;
		}

		$tools = array(
			'bold',
			'underline',
			'italic',
			'createlink',
		);

		if ( isset( $config['inlineEditing']['toolbar'] ) ) {
			$config['inlineEditing']['toolbar']['intermediate'] = $tools;
		} else {
			$config['inlineEditing'] = array(
				'toolbar' => array(
					'intermediate' => $tools,
				),
			);
		}

		return $config;
	}

	/**
	 * Registers frontend assets.
	 *
	 * This function handles the registration of frontend assets used in widgets maps to load widget assets on demand.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function frontend_register() {

		wp_register_style(
			'zyre-icons',
			ZYRE_ADDONS_ASSETS . 'fonts/zyre-icons/zyre-icons' . self::$suffix . 'css',
			null,
			ZYRE_ADDONS_VERSION
		);

		wp_register_style(
			'zyre-elementor-addons-global-vars',
			ZYRE_ADDONS_ASSETS . 'css/global-vars' . self::$suffix . 'css',
			null,
			ZYRE_ADDONS_VERSION
		);

		wp_register_style(
			'zyre-elementor-addons-global',
			ZYRE_ADDONS_ASSETS . 'css/global' . self::$suffix . 'css',
			[ 'zyre-elementor-addons-global-vars' ],
			ZYRE_ADDONS_VERSION
		);

		wp_register_style(
			'zyre-elementor-addons-widgets',
			ZYRE_ADDONS_ASSETS . 'css/widgets-main' . self::$suffix . 'css',
			[ 'zyre-elementor-addons-global' ],
			ZYRE_ADDONS_VERSION
		);

		wp_register_style(
			'zyre-elementor-addons-nav-menu',
			ZYRE_ADDONS_ASSETS . 'css/menu' . self::$suffix . 'css',
			[ 'zyre-elementor-addons-widgets' ],
			ZYRE_ADDONS_VERSION
		);

		// Carousel and Slider.
		wp_register_style(
			'slick',
			ZYRE_ADDONS_ASSETS . 'libs/slick/slick.css',
			[ 'zyre-elementor-addons-widgets' ],
			ZYRE_ADDONS_VERSION
		);

		wp_register_style(
			'slick-theme',
			ZYRE_ADDONS_ASSETS . 'libs/slick/slick-theme.css',
			[ 'slick' ],
			ZYRE_ADDONS_VERSION
		);

		wp_register_script(
			'jquery-slick',
			ZYRE_ADDONS_ASSETS . 'libs/slick/slick.min.js',
			array( 'jquery' ),
			ZYRE_ADDONS_VERSION,
			true
		);

		// Sharer JS
		wp_register_script(
			'sharer-js',
			ZYRE_ADDONS_ASSETS . 'js/sharer' . self::$suffix . 'js',
			[ 'jquery' ],
			ZYRE_ADDONS_VERSION,
			true
		);

		// Alert Handler
		wp_register_script(
			'alert-handler',
			ZYRE_ADDONS_ASSETS . 'js/alert' . self::$suffix . 'js',
			[ 'jquery' ],
			ZYRE_ADDONS_VERSION,
			true
		);

		// Number animation
		wp_register_script(
			'jquery-numerator',
			ZYRE_ADDONS_ASSETS . 'libs/jquery-numerator/jquery-numerator.min.js',
			[ 'jquery' ],
			ZYRE_ADDONS_VERSION,
			true
		);

		// Typed JS
		wp_register_script(
			'zyre-typed',
			ZYRE_ADDONS_ASSETS . 'js/typed' . self::$suffix . 'js',
			[],
			ZYRE_ADDONS_VERSION,
			true
		);

		// vTicker JS
		wp_register_script(
			'zyre-vticker',
			ZYRE_ADDONS_ASSETS . 'js/vticker' . self::$suffix . 'js',
			[],
			ZYRE_ADDONS_VERSION,
			true
		);

		// Animated Text JS
		wp_register_script(
			'zyre-animated-text',
			ZYRE_ADDONS_ASSETS . 'js/animated-text' . self::$suffix . 'js',
			[ 'jquery', 'zyre-typed', 'zyre-vticker' ],
			ZYRE_ADDONS_VERSION,
			true
		);

		// Animated Text JS
		wp_register_script(
			'zyre-animated-text',
			ZYRE_ADDONS_ASSETS . 'js/animated-text' . self::$suffix . 'js',
			[ 'jquery', 'zyre-typed', 'zyre-vticker' ],
			ZYRE_ADDONS_VERSION,
			true
		);

		// View PDF JS
		wp_register_script(
			'zyre-pdf-js',
			'//cdnjs.cloudflare.com/ajax/libs/pdfobject/2.3.1/pdfobject.min.js',
			[],
			ZYRE_ADDONS_VERSION,
			false
		);

		// Lottie
		wp_register_script(
			'zyre-lottie-js',
			ZYRE_ADDONS_ASSETS . 'js/lottie.min.js',
			[],
			ZYRE_ADDONS_VERSION,
			false
		);

		// jQuery DownCount.
		wp_register_script(
			'zyre-jquery-downcount',
			ZYRE_ADDONS_ASSETS . 'js/jquery-downcount.js',
			[ 'jquery' ],
			ZYRE_ADDONS_VERSION,
			true
		);

		// Zyre addons script.
		wp_register_script(
			'zyre-elementor-addons',
			ZYRE_ADDONS_ASSETS . 'js/zyre-addons' . self::$suffix . 'js',
			[ 'jquery' ],
			ZYRE_ADDONS_VERSION,
			true
		);

		// Localize scripts.
		wp_localize_script(
			'zyre-elementor-addons',
			'ZyreLocalize',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'zyre_addons_nonce' ),
			)
		);
	}

	/**
	 * This method checks if the given CSS file is for the current queried post, it enqueues the assets for the specified post.
	 *
	 * @since 1.0.0
	 * @param Post_CSS $file The CSS file to enqueue.
	 * @return void
	 */
	public static function frontend_elementor_post_enqueue( Post_CSS $file ) {
		$post_id = $file->get_post_id();

		if ( get_queried_object_id() === $post_id ) {
			return;
		}

		$template_type = get_post_meta( $post_id, '_elementor_template_type', true );

		if ( 'kit' === $template_type ) {
			return;
		}

		self::enqueue( $post_id );
	}

	/**
	 * Enqueues frontend assets.
	 *
	 * This method enqueues frontend assets, but only if the current page is a singular post or page.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function frontend_enqueue() {
		if ( ! is_singular() ) {
			return;
		}

		self::enqueue( get_the_ID() );
	}

	/**
	 * Just enqueue the assets
	 *
	 * It just processes the assets from cache if avilable otherwise raw assets
	 *
	 * @since 1.0.0
	 * @param int $post_id the ID of Post.
	 * @return void
	 */
	public static function enqueue( $post_id ) {
		if ( Cache_Manager::should_enqueue( $post_id ) ) {
			Cache_Manager::enqueue( $post_id );
		}

		// Only for edit & preview mode.
		if ( Cache_Manager::should_enqueue_raw( $post_id ) ) {
			Cache_Manager::enqueue_raw( $post_id );
		}
	}

	/**
	 * Get the URL of the dark stylesheet.
	 *
	 * @return string The URL of the dark stylesheet.
	 */
	public static function get_dark_stylesheet_url() {
		return ZYRE_ADDONS_ASSETS . 'admin/css/editor-dark' . self::$suffix . 'css';
	}

	/**
	 * Enqueues the dark stylesheet for the Elementor editor based on the user's UI theme preference.
	 *
	 * @since 1.0.0
	 */
	public static function enqueue_dark_stylesheet() {
		$theme = SettingsManager::get_settings_managers( 'editorPreferences' )->get_model()->get_settings( 'ui_theme' );

		if ( 'light' !== $theme ) {
			$media_queries = 'all';

			if ( 'auto' === $theme ) {
				$media_queries = '(prefers-color-scheme: dark)';
			}

			wp_enqueue_style(
				'zyre-addons-editor-dark',
				self::get_dark_stylesheet_url(),
				array(
					'elementor-editor',
				),
				ZYRE_ADDONS_VERSION,
				$media_queries
			);
		}
	}

	/**
	 * Enqueue Elementor editor assets
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function elementor_editor_enqueue() {

		wp_enqueue_style(
			'zyre-icons',
			ZYRE_ADDONS_ASSETS . 'fonts/zyre-icons/zyre-icons' . self::$suffix . 'css',
			null,
			ZYRE_ADDONS_VERSION
		);

		wp_enqueue_style(
			'zyre-elementor-addons-editor',
			ZYRE_ADDONS_ASSETS . 'admin/css/editor' . self::$suffix . 'css',
			null,
			ZYRE_ADDONS_VERSION
		);

		wp_enqueue_script(
			'zyre-elementor-addons-editor',
			ZYRE_ADDONS_ASSETS . 'admin/js/editor' . self::$suffix . 'js',
			array( 'elementor-editor', 'jquery' ),
			ZYRE_ADDONS_VERSION,
			true
		);

		Library_Manager::enqueue_scripts();

		// Ensures that the dark stylesheet is enqueued at the end otherwise it may not work.
		self::enqueue_dark_stylesheet();

		$localize_data = array(
			'editor_nonce'        => wp_create_nonce( 'zyre_editor_nonce' ),
			'dark_stylesheet_url' => self::get_dark_stylesheet_url(),
			'promotion_widgets' => [],
			'hasPro'              => zyre_has_pro(),
			'i18n' => [
				'promotionDialogTitle'     => esc_html( '%s Widget' ),
				/* translators: %s is the widget name */
				'promotionDialogMessage'    => esc_html__( 'Use %s widget and dozens more pro widgets with pro features to extend your toolbox and build sites faster and better.', 'zyre-elementor-addons' ),
				'promotionDialogBtnText'    => esc_html__( 'Upgrade Zyre Addons', 'zyre-elementor-addons' ),
				'templatesEmptyTitle'       => esc_html__( 'No Templates Found', 'zyre-elementor-addons' ),
				'templatesEmptyMessage'     => esc_html__( 'Try different category or sync for new templates.', 'zyre-elementor-addons' ),
				'templatesNoResultsTitle'   => esc_html__( 'No Results Found', 'zyre-elementor-addons' ),
				'templatesNoResultsMessage' => esc_html__( 'Please make sure your search is spelled correctly or try a different words.', 'zyre-elementor-addons' ),
				'NoResultsMessage' => esc_html__( 'No results found.', 'zyre-elementor-addons' ),
			],
		);

		if ( ! zyre_has_pro() ) {
			$localize_data['promotion_widgets'] = Widgets_Manager::get_pro_widget_map();
		}

		wp_localize_script(
			'zyre-elementor-addons-editor',
			'ZyreAddonsEditor',
			$localize_data
		);
	}

	/**
	 * Enqueues stylesheets specifically for the Elementor preview window during editing.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function enqueue_elementor_preview_styles() {

		$data = '
		.elementor-add-section[data-view=choose-action] .elementor-add-new-section {
			display: inline-flex !important;
			flex-wrap: wrap;
			align-items: center;
			justify-content: center;
		}
		.elementor-add-section-drag-title{
			flex-basis: 100%;
		}
		.elementor-add-new-section .elementor-add-zyre-button {
			margin-left: 5px;
			font-size: 20px;
			color: #fff;
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 0 !important;
			background-color: transparent !important;
		}
		.elementor-add-new-section .elementor-add-zyre-button img {
			transition: filter 0.2s;
		}
		.elementor-add-new-section .elementor-add-zyre-button:hover img {
			filter: grayscale(0.7);
		';
		wp_add_inline_style( 'zyre-elementor-addons-global', $data );
	}
}

Assets_Manager::init();
