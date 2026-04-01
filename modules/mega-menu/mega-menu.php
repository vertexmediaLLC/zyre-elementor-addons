<?php
/**
 * MegaMenu Support for Navigation Widget
 *
 * @package ZyreAddons
 */

namespace VertexMediaLLC\ZyreElementorAddons\Modules;

use VertexMediaLLC\ZyreElementorAddons\Modules\Mega_Menu\Cpt;
use VertexMediaLLC\ZyreElementorAddons\Modules\Mega_Menu\Options;

defined( 'ABSPATH' ) || die();

class Mega_Menu {

	public $dir;
	public $url;
	public $iconManager;

	public static $menuitem_settings_key = 'zyreladdons_menuitem_settings';
	public static $megamenu_settings_key = 'zyreladdons_megamenu_settings';

	private static $instance = null;

	/**
	 * @var Collection
	 */
	protected $config;

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {
		$this->include_files();

		// enqueue scripts
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_styles' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );

		Cpt::instance();
		Cpt::flush_rewrites();
		new Options();

		// AJAX Handlers
		add_action( 'wp_ajax_zyreladdons_save_menuitem_settings', [__CLASS__, 'save_menuitem_settings'] );
		add_action( 'wp_ajax_zyreladdons_get_menuitem_settings', [__CLASS__, 'get_menuitem_settings'] );
		add_action( 'wp_ajax_zyreladdons_get_content_editor', [__CLASS__, 'get_content_editor'] );
	}

	public function include_files() {
		include_once ZYRELADDONS_DIR_PATH . 'modules/mega-menu/cpt.php';
		include_once ZYRELADDONS_DIR_PATH . 'modules/mega-menu/options.php';
		include_once ZYRELADDONS_DIR_PATH . 'modules/mega-menu/icon-list.php';
		include_once ZYRELADDONS_DIR_PATH . 'modules/mega-menu/walker.php';
	}

	public function admin_enqueue_styles() {
		$screen = get_current_screen();

		if ( 'nav-menus' === $screen->base ) {
			wp_enqueue_style( 'wp-color-picker' );

			wp_enqueue_style(
				'zyreladdons-aesthetic-icon-picker',
				ZYRELADDONS_DIR_URL . 'modules/mega-menu/assets/aesthetic-icon-picker/css/aesthetic-icon-picker.min.css',
				false,
				ZYRELADDONS_VERSION
			);

			if ( defined( 'ELEMENTOR_ASSETS_URL' ) ) {
				wp_enqueue_style(
					'zyreladdons-font-awesome',
					ELEMENTOR_ASSETS_URL . 'lib/font-awesome/css/all.min.css',
					[],
					'4.7.0'
				);
			}

			wp_enqueue_style(
				'zyreladdons-jquery-modal',
				ZYRELADDONS_DIR_URL . 'modules/mega-menu/assets/jquery-modal/jquery.modal.min.css',
				false,
				'0.9.1'
			);

			wp_enqueue_style(
				'zyreladdons-megamenu-admin-style',
				ZYRELADDONS_DIR_URL . 'modules/mega-menu/assets/css/extension-megamenu.css',
				false,
				ZYRELADDONS_VERSION
			);

			wp_enqueue_style(
				'zyreladdons-icons',
				ZYRELADDONS_ASSETS . 'fonts/zyre-icons/zyre-icons.min.css',
				false,
				ZYRELADDONS_VERSION
			);

			wp_enqueue_style(
				'zyreladdons-icons-bold',
				ZYRELADDONS_ASSETS . 'fonts/zyre-icons/zyre-icons-b.css',
				[],
				ZYRELADDONS_VERSION
			);
		}
	}

	public function admin_enqueue_scripts() {
		$screen = get_current_screen();
		if ( 'nav-menus' === $screen->base ) {
			wp_enqueue_script(
				'zyreladdons-aesthetic-icon-picker',
				ZYRELADDONS_DIR_URL . 'modules/mega-menu/assets/aesthetic-icon-picker/js/aesthetic-icon-picker.js',
				array( 'jquery' ),
				ZYRELADDONS_VERSION,
				true
			);

			wp_enqueue_script(
				'zyreladdons-jquery-modal',
				ZYRELADDONS_DIR_URL . 'modules/mega-menu/assets/jquery-modal/jquery.modal.min.js',
				array( 'jquery' ),
				'0.9.1',
				true
			);

			wp_enqueue_script(
				'zyreladdons-megamenu',
				ZYRELADDONS_DIR_URL . 'modules/mega-menu/assets/js/megamenu.js',
				array( 'jquery', 'wp-color-picker' ),
				ZYRELADDONS_VERSION,
				true
			);

			wp_localize_script(
				'zyreladdons-megamenu',
				'zyreMegaMenu',
				[
					'items'    => $this->get_menu_items(),
					'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
					'_wpnonce' => wp_create_nonce( 'zyreladdons_mm__nonce' ),
				]
			);
		}
	}

	function get_menu_items() {

		$args = [
			'post_type'   => 'nav_menu_item',
			'post_status' => 'publish',
			'nopaging'    => true,
			'fields'      => 'ids',
		];

		$items = new \WP_Query( $args );
		$menuItems = [];

		foreach ( $items->posts as $item ) {

			$data = get_post_meta( $item, self::$menuitem_settings_key, true );

			if ( ! is_array( $data ) ) {
				continue;
			}

			if ( ! empty( $data['menu_enable'] ) && $data['menu_enable'] == 1 ) {
				$menuItems[] = "#menu-item-" . $item;
			}
		}

		return $menuItems;
	}

	private static function validate() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( [ 'message' => __( 'Permission denied', 'zyre-elementor-addons' ) ] );
		}

		if ( empty( $_POST['_wpnonce'] ) ) {
			wp_send_json_error( [ 'message' => __( 'Invalid request', 'zyre-elementor-addons' ) ] );
		}

		$nonce = sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) );

		if ( ! wp_verify_nonce( $nonce, 'zyreladdons_mm__nonce' ) ) {
			wp_send_json_error( [ 'message' => __( 'Invalid nonce', 'zyre-elementor-addons' ) ] );
		}
	}

	/**
	 * Save item settings
	 */
	public static function save_menuitem_settings() {
		self::validate();

		if ( empty( $_POST['settings'] ) || ! is_array( $_POST['settings'] ) ) {
			wp_send_json_error( [ 'message' => __( 'Invalid data', 'zyre-elementor-addons' ) ] );
		}
		
		$settings = zyreladdons_sanitize_array_recursively( $_POST['settings'] );

		$menu_item_id = absint( $settings['menu_id'] );

		update_post_meta( $menu_item_id, self::$menuitem_settings_key, $settings );

		wp_send_json_success( [
			'saved'   => 1,
			'message' => esc_html__( 'Saved', 'zyre-elementor-addons' ),
		] );
	}

	/**
	 * Get item settings
	 */
	public static function get_menuitem_settings() {
		self::validate();

		$menu_item_id = absint( $_POST['menu_id'] );
		$data = get_post_meta( $menu_item_id, self::$menuitem_settings_key, true );

		if ( empty( $data ) || ! is_array( $data ) ) {
			$data = [
				'menu_id'                         => $menu_item_id,
				'menu_has_child'                  => '',
				'menu_enable'                     => '',
				'menu_icon'                       => '',
				'menu_icon_color'                 => '',
				'menu_icon_size'                  => '',
				'menu_item_text_hide'             => '',
				'menu_badge_text'                 => '',
				'menu_badge_color'                => '',
				'menu_badge_background'           => '',
				"menu_badge_enable_arrow"         => '',
				'menu_badge_radius'               => '',
				'megamenu_width'             => '',
				'mobile_submenu_content_type'     => '',
				'vertical_megamenu_position_type' => '',
				'megamenu_width_type'             => '',
			];
		}

		wp_send_json( $data );
	}

	/**
	 * Get Menu Item iframe URL
	 */
	public static function get_content_editor() {
		self::validate();

		$content_key = absint( $_POST['key'] );

		$builder_post_title = 'zyreladdons-mm-content-' . $content_key;

		$query = new \WP_Query(
			[
				'post_type'              => 'zyreladdons_mm',
				'title'                  => $builder_post_title,
				'post_status'            => 'all',
				'posts_per_page'         => 1,
				'no_found_rows'          => true,
				'ignore_sticky_posts'    => true,
				'update_post_term_cache' => false,
				'update_post_meta_cache' => false,
				'orderby'                => 'post_date ID',
				'order'                  => 'ASC',
			]
		);

		if ( ! empty( $query->post ) ) {
			$builder_post_id = $query->post->ID;
		} else {
			$defaults = [
				'post_content' => '',
				'post_title'   => $builder_post_title,
				'post_status'  => 'publish',
				'post_type'    => 'zyreladdons_mm',
			];
			$builder_post_id = wp_insert_post( $defaults );

			update_post_meta( $builder_post_id, '_wp_page_template', 'elementor_canvas' );
		}

		$url = add_query_arg(
			[
				'post'   => $builder_post_id,
				'action' => 'elementor',
			],
			admin_url( 'post.php' )
		);

		wp_send_json_success( [
			'url' => $url,
		] );
	}
}
