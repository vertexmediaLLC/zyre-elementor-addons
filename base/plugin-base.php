<?php

namespace ZyreAddons\Elementor;

use Elementor\Controls_Manager;
use Elementor\Elements_Manager;

defined( 'ABSPATH' ) || die();

/**
 * Class Plugin
 *
 * Main Plugin class
 *
 * @since 1.0.0
 */
class Plugin {
	/**
	 * Instance
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $instance = null;

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @var Client The instance of the class.
	 */
	public $appsero = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @return Plugin An instance of the class.
	 * @since 1.0.0
	 * @access public
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
			self::$instance->init();
		}
		return self::$instance;
	}

	/**
	 * Include Files
	 * Register custom category in Elementor
	 * Register custom controls in Elementor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init() {
		add_action( 'init', [ $this, 'load_textdomain' ] );

		add_action( 'init', array( $this, 'include_files' ) );

		// Register custom category.
		add_action( 'elementor/elements/categories_registered', array( $this, 'add_category' ) );

		// Register custom controls.
		add_action( 'elementor/controls/controls_registered', array( $this, 'register_controls' ) );

		add_action( 'wp_ajax_zyre_mailchimp_ajax', [ Ajax_Handler::class, 'mailchimp_prepare_ajax' ] );
		add_action( 'wp_ajax_nopriv_zyre_mailchimp_ajax', [ Ajax_Handler::class, 'mailchimp_prepare_ajax' ] );

		$this->appsero_tracking_init();

		do_action( 'zyreaddons_loaded' );
	}

	public function load_textdomain() {
		load_plugin_textdomain( 'zyre-elementor-addons', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Initialize the appsero tracker
	 *
	 * @return void
	 */
	protected function appsero_tracking_init() {
		if ( ! class_exists( 'Appsero\Client' ) ) {
			include_once ZYRE_ADDONS_DIR_PATH . 'vendor/appsero/client/src/Client.php';
		}

		$this->appsero = new \Appsero\Client(
			'c621f52b-1ed2-4455-9977-7f020bff6564',
			'Zyre Elementor Addons',
			ZYRE_ADDONS__FILE__
		);

		$this->appsero->set_textdomain( 'zyre-elementor-addons' );

		// Active insights
		$this->appsero->insights()
			->add_plugin_data()
			->add_extra([
				'pro_installed' => zyre_has_pro() ? 'Yes' : 'No',
				'pro_version' => zyre_has_pro() ? ZYRE_ADDONS_PRO_VERSION : '',
			])
			->init();
	}

	/**
	 * Include all necessary files
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function include_files() {
		include_once ZYRE_ADDONS_DIR_PATH . 'includes/functions.php';
		include_once ZYRE_ADDONS_DIR_PATH . 'includes/filterable-functions.php';

		include_once ZYRE_ADDONS_DIR_PATH . 'classes/icons-manager.php';
		include_once ZYRE_ADDONS_DIR_PATH . 'classes/widgets-manager.php';
		include_once ZYRE_ADDONS_DIR_PATH . 'classes/assets-manager.php';
		include_once ZYRE_ADDONS_DIR_PATH . 'classes/cache-manager.php';
		include_once ZYRE_ADDONS_DIR_PATH . 'classes/widgets-cache.php';
		include_once ZYRE_ADDONS_DIR_PATH . 'classes/assets-cache.php';

		if ( is_admin() ) {
			include_once ZYRE_ADDONS_DIR_PATH . 'classes/select2-handler.php';
			add_action( 'wp_ajax_zyre_process_dynamic_select', [ Select2_Handler::class, 'process_select_request' ] );
			include_once ZYRE_ADDONS_DIR_PATH . 'classes/admin-dashboard.php';
		}

		if ( is_user_logged_in() ) {
			include_once ZYRE_ADDONS_DIR_PATH . 'classes/library-manager.php';
			include_once ZYRE_ADDONS_DIR_PATH . 'classes/library-source.php';

			include_once ZYRE_ADDONS_DIR_PATH . 'classes/prestyles-manager.php';
		}

		include_once ZYRE_ADDONS_DIR_PATH . 'classes/ajax-handler.php';

		include_once ZYRE_ADDONS_DIR_PATH . 'modules/theme-builder/conditions-cache.php';
		include_once ZYRE_ADDONS_DIR_PATH . 'modules/theme-builder/module.php';
		include_once ZYRE_ADDONS_DIR_PATH . 'modules/theme-builder/conditions-manager.php';
		include_once ZYRE_ADDONS_DIR_PATH . 'modules/theme-builder/theme-support.php';

		include_once ZYRE_ADDONS_DIR_PATH . 'modules/theme-builder/compatibility/astra.php';
		include_once ZYRE_ADDONS_DIR_PATH . 'modules/theme-builder/compatibility/bbtheme.php';
		include_once ZYRE_ADDONS_DIR_PATH . 'modules/theme-builder/compatibility/generatepress.php';
		include_once ZYRE_ADDONS_DIR_PATH . 'modules/theme-builder/compatibility/genesis.php';
		include_once ZYRE_ADDONS_DIR_PATH . 'modules/theme-builder/compatibility/oceanwp.php';
		include_once ZYRE_ADDONS_DIR_PATH . 'modules/theme-builder/compatibility/twenty-nineteen.php';
	}

	/**
	 * Add Custom Elementor Categories
	 *
	 * @param Elements_Manager $elements_manager Category Names Array.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function add_category( Elements_Manager $elements_manager ) {
		$elements_manager->add_category(
			'zyre_addons_category',
			array(
				'title' => __( 'Zyre Addons', 'zyre-elementor-addons' ),
				'icon'  => 'fa fa-plug',
			)
		);
	}

	/**
	 * Register new Elementor Controls
	 *
	 * @since 1.0.0
	 * @param Controls_Manager $controls_manager Register Controls.
	 * @access public
	 */
	public function register_controls( Controls_Manager $controls_manager ) {
		include_once ZYRE_ADDONS_DIR_PATH . 'controls/select2.php';
		include_once ZYRE_ADDONS_DIR_PATH . 'controls/style-select.php';
		include_once ZYRE_ADDONS_DIR_PATH . 'controls/typography.php';

		$select = __NAMESPACE__ . '\Controls\Select2';
		zyre_elementor()->controls_manager->register( new $select() );

		$select = __NAMESPACE__ . '\Controls\Style_Control';
		zyre_elementor()->controls_manager->register( new $select() );

		$typography = __NAMESPACE__ . '\Controls\Group_Control_Typography_Extended';
		zyre_elementor()->controls_manager->add_group_control(
			$typography::get_type(),
			new $typography()
		);
	}
}
