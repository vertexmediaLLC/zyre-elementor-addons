<?php

/**
 * Admin Dashboard Manager
 *
 * Package: ZyreAddons
 * @since 1.0.0
 */
namespace ZyreAddons\Elementor;

defined( 'ABSPATH' ) || die();

class Dashboard {

	const PAGE_SLUG = 'zyre-addons';

	const DASHBOARD_NONCE = 'zyre_save_dashboard_settings';

	const SUBSCRIBED_META_KEY = 'zyreaddons_subscribed';

	protected static $menu_slug = '';

	public static function is_page() {
		return ( isset( $_GET['page'] ) && ( wp_unslash( $_GET['page'] ) === self::PAGE_SLUG ) );
	}

	public static function add_body_class( $classes ) {
		if ( self::is_page() ) {
			$classes .= ' zyre-elementor-addons-dashboard';
		}
		return $classes;
	}

	public static function remove_admin_notices() {
		if ( self::is_page() ) {
			remove_all_actions( 'admin_notices' );
			remove_all_actions( 'all_admin_notices' );
		}
	}

	public static function save_settings() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( ! check_ajax_referer( self::DASHBOARD_NONCE, 'nonce' ) ) {
			wp_send_json_error();
		}

		$posted_data = ! empty( $_POST['formData'] ) ? zyre_sanitize_array_recursively( $_POST['formData'] ) : '';
		$data = [];
		parse_str( $posted_data, $data );

		do_action( 'zyreaddons_save_dashboard_settings', $data );

		wp_send_json_success();
	}

	public static function save_widgets( $data ) {
		$widgets = ! empty( $data['widgets'] ) ? $data['widgets'] : [];
		$inactive_widgets = array_values( array_diff( array_keys( Widgets_Manager::get_real_widgets_map() ), $widgets ) );
		Widgets_Manager::save_inactive_widgets( $inactive_widgets );
	}

	public static function save_widgets_styles( $data ) {
		$widgets_styles = ! empty( $data['widgets_styles'] ) ? $data['widgets_styles'] : [];

		$widgets = Widgets_Manager::get_real_widgets_map();
		$widgets_all_styles = array_map( function ( $widget ) {
			return array_keys( $widget['styles'] );
		}, $widgets);

		// Check and clean up styles keys
		$filtered_styles = [];
		foreach ( $widgets_styles as $key => $check_values ) {
			if ( isset( $widgets_all_styles[ $key ] ) ) {
				$filtered_styles[ $key ] = array_intersect( $check_values, $widgets_all_styles[ $key ] );
			}
		}

		Widgets_Manager::save_widgets_active_styles( $filtered_styles );
	}

	public static function save_credentials( $data ) {
		$credentials = ! empty( $data['credentials'] ) ? $data['credentials'] : [];
		Credentials_Manager::save_credentials( $credentials );
	}

	public static function enqueue_scripts( $hook ) {
		if ( self::$menu_slug !== $hook || ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$suffix = zyre_is_script_debug_enabled() ? '.' : '.min.';

		wp_enqueue_style(
			'zyre-icons',
			ZYRE_ADDONS_ASSETS . 'fonts/zyre-icons/zyre-icons' . $suffix . 'css',
			null,
			ZYRE_ADDONS_VERSION
		);

		wp_enqueue_style(
			'zyre-elementor-addons-global-vars',
			ZYRE_ADDONS_ASSETS . 'css/global-vars' . $suffix . 'css',
			null,
			ZYRE_ADDONS_VERSION
		);

		wp_enqueue_style(
			'zyre-elementor-addons-dashboard',
			ZYRE_ADDONS_ASSETS . 'admin/css/dashboard' . $suffix . 'css',
			null,
			ZYRE_ADDONS_VERSION
		);

		wp_enqueue_script(
			'zyre-elementor-addons-dashboard',
			ZYRE_ADDONS_ASSETS . 'admin/js/dashboard' . $suffix . 'js',
			[ 'jquery' ],
			ZYRE_ADDONS_VERSION,
			true
		);

		wp_localize_script(
			'zyre-elementor-addons-dashboard',
			'ZyreAddonsDashboard',
			[
				'nonce' => wp_create_nonce( self::DASHBOARD_NONCE ),
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'action' => self::DASHBOARD_NONCE,
				'saveSettingsLabel' => esc_html__( 'Save Settings', 'zyre-elementor-addons' ),
				'savedLabel' => esc_html__( 'Settings Saved', 'zyre-elementor-addons' ),
			]
		);
	}

	public static function dequeue_scripts() {
		// Check if current theme is Hello Elementor
		$theme = wp_get_theme();
		if ( 'hello-elementor' !== $theme->get( 'TextDomain' ) ) {
			return;
		}

		// Check and dequeue the banner script
		if ( wp_script_is( 'hello-conversion-banner', 'enqueued' ) ) {
			wp_dequeue_script( 'hello-conversion-banner' );
		}

		if ( wp_script_is( 'hello-conversion-banner', 'registered' ) ) {
			wp_deregister_script( 'hello-conversion-banner' );
		}
	}

	public static function get_widgets() {
		$widgets_map = Widgets_Manager::get_real_widgets_map();
		$widgets_map = apply_filters( 'zyreaddons_dashboard_get_widgets', $widgets_map );

		uksort( $widgets_map, [ __CLASS__, 'sort_widgets' ] );
		return $widgets_map;
	}

	public static function sort_widgets( $key1, $key2 ) {
		return strcasecmp( $key1, $key2 );
	}

	public static function get_widget_default_style_key( string $widget_id ) {
		$style_key = Widgets_Manager::get_the_widget_style_default( $widget_id );
		return $style_key;
	}

	public static function add_menu() {
		self::$menu_slug = add_menu_page(
			__( 'Zyre Elementor Addons Dashboard', 'zyre-elementor-addons' ),
			__( 'Zyre Addons', 'zyre-elementor-addons' ),
			'manage_options',
			self::PAGE_SLUG,
			[ __CLASS__, 'render_home' ],
			zyre_get_b64_3dicon_white(),
			58.6
		);

		$tabs = self::get_tabs();
		if ( is_array( $tabs ) ) {
			foreach ( $tabs as $key => $tab ) {
				add_submenu_page(
					self::PAGE_SLUG,
					sprintf( esc_html( '%s - Zyre Elementor Addons' ), $tab['title'] ),
					$tab['title'],
					'manage_options',
					self::PAGE_SLUG . '&t=' . $key,
					[ __CLASS__, 'render_home' ]
				);
			}
		}
	}

	public static function update_menu_items() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		global $submenu;
		$menu = $submenu[ self::PAGE_SLUG ];
		array_shift( $menu );
		$submenu[ self::PAGE_SLUG ] = $menu; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
	}

	public static function update_submenu_file( $submenu_file ) {
		if ( isset( $_GET['t'] ) ) {
			$submenu_file = self::PAGE_SLUG . '&t=' . sanitize_text_field( $_GET['t'] );
		}
		return $submenu_file;
	}

    public static function get_widgets_raw_usage() {

        $usage = [];

        $posts = get_posts([
            'post_type'      => get_post_types(['public' => true]),
            'posts_per_page' => -1,
            'meta_key'       => '_elementor_data',
            'meta_compare'   => 'EXISTS',
            'fields'         => 'ids'
        ]);

        foreach ( $posts as $post_id ) {

            $data = get_post_meta( $post_id, '_elementor_data', true );

            if ( empty( $data ) ) {
                continue;
            }

            $elements = json_decode( $data, true );

            if ( ! is_array( $elements ) ) {
                continue;
            }

            self::parse_elements_recursive( $elements, $usage );
        }

        return $usage;
    }

    private static function parse_elements_recursive( $elements, &$usage ) {

        foreach ( $elements as $element ) {

            // Check if widget
            if ( isset( $element['elType'] ) && $element['elType'] === 'widget' ) {

                if ( isset( $element['widgetType'] ) && strpos( $element['widgetType'], 'zyre-' ) === 0 ) {

                    $widget_key = str_replace( 'zyre-', '', $element['widgetType'] );

                    if ( isset( $usage[ $widget_key ] ) ) {
                        $usage[ $widget_key ]++;
                    } else {
                        $usage[ $widget_key ] = 1;
                    }
                }
            }

            // Check nested elements
            if ( isset( $element['elements'] ) && is_array( $element['elements'] ) ) {
                self::parse_elements_recursive( $element['elements'], $usage );
            }
        }
    }

	public static function get_widgets_unusage() {
		$all_widgets = self::get_widgets();
		$widgets_used = self::get_widgets_raw_usage();
		$widgets_unused = array_diff( array_keys( $all_widgets ), array_keys( $widgets_used ) );

		return array_values( $widgets_unused );
	}

	public static function get_tabs() {
		$tabs = [
			'dashboard' => [
				'title' => esc_html__( 'Dashboard', 'zyre-elementor-addons' ),
				'icon' => zyre_get_svg_icon( 'home' ),
			],
			'widgets' => [
				'title' => esc_html__( 'Widgets', 'zyre-elementor-addons' ),
				'icon' => zyre_get_svg_icon( 'cube' ),
			],
			'integrations' => [
				'title' => esc_html__( 'Integrations', 'zyre-elementor-addons' ),
				'icon' => zyre_get_svg_icon( 'cog' ),
			],
		];

		/* 
		ToDo: Uncomment this part when pro version is released
		if ( ! zyre_has_pro() ) {
			$tabs['pro'] = [
				'title' => esc_html__( 'Get Pro', 'zyre-elementor-addons' ),
				'icon' => zyre_get_svg_icon( 'star' ),
			];
		} */

		return apply_filters( 'zyreaddons_dashboard_get_tabs', $tabs );
	}

	private static function load_template( $template ) {
		$file = ZYRE_ADDONS_DIR_PATH . 'templates/admin/dashboard-' . $template . '.php';
		if ( is_readable( $file ) ) {
			include $file;
		}
	}

	public static function render_home() {
		self::load_template( 'home' );
	}

	/**
	 * Get all credentials
	 *
	 * @return array
	 */
	public static function get_credentials() {
		$credentail_map = Credentials_Manager::get_credentials_map();
		$credentail_map = array_merge( $credentail_map, Credentials_Manager::get_pro_credentials_map() );

		return $credentail_map;
	}

	/**
	 * Check if user subscribed to newsletter
	 *
	 * @return bool
	 */
	public static function is_user_subscribed() {
		if ( ! is_user_logged_in() ) {
			return false;
		}

		$subscribed = get_user_meta( get_current_user_id(), self::SUBSCRIBED_META_KEY, true );
        if ( 'yes' === $subscribed ) {
            return true;
        }

		// Fallback: check cookie (optional)
		if ( isset( $_COOKIE['ZY_SB_MODAL_CLOSED'] ) && 'yes' === sanitize_text_field( wp_unslash( $_COOKIE['ZY_SB_MODAL_CLOSED'] ) ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Mark user as subscribed via ajax
	 */
	public static function user_subscribed() {
		if ( ! is_user_logged_in() || ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error();
		}

		check_ajax_referer( self::DASHBOARD_NONCE, 'nonce' );

		update_user_meta(
			get_current_user_id(),
			'zyreaddons_subscribed',
			'yes'
		);

		wp_send_json_success();
	}
}

/**
 * Ajax action to mark user as subscribed
 */
add_action(
    'wp_ajax_zyreaddons_user_subscribed',
    [ __NAMESPACE__ . '\Dashboard', 'user_subscribed' ]
);
