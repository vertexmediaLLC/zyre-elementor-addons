<?php

namespace ZyreAddons\Elementor\ThemeBuilder\Compatibility;

defined( 'ABSPATH' ) || exit;

/**
 * TwentyNineteen support for the header footer.
 */
class TwentyNineteen {

	/**
	 * Run all the Actions / Filters.
	 */
	public function __construct( $template_ids ) {
		if ( null !== $template_ids[0] ) {
			add_action( 'get_header', [ $this, 'get_header' ] );
		}

		if ( null !== $template_ids[1] ) {
			add_action( 'get_footer', [ $this, 'get_footer' ] );
		}
	}

	public function get_header( $name ) {
		add_action( 'zyreaddons/template/after_header', function () {
			echo '<div id="page" class="site">';
			echo '<div id="content" class="site-content">';
		} );

		require ZYRE_ADDONS_DIR_PATH . 'modules/theme-builder/templates/theme-support-header.php';

		$templates = [];
		$name = (string) $name;
		if ( '' !== $name ) {
			$templates[] = "header-{$name}.php";
		}

		$templates[] = 'header.php';

		// Avoid running wp_head hooks again
		remove_all_actions( 'wp_head' );
		ob_start();
		// It cause a `require_once` so, in the get_header it self it will not be required again.
		locate_template( $templates, true );
		ob_get_clean();
	}

	public function get_footer( $name ) {
		add_action( 'zyreaddons/template/after_footer', function () {
			echo '</div></div>';
		} );

		require ZYRE_ADDONS_DIR_PATH . 'modules/theme-builder/templates/theme-support-footer.php';

		$templates = [];
		$name = (string) $name;
		if ( '' !== $name ) {
			$templates[] = "footer-{$name}.php";
		}

		$templates[] = 'footer.php';

		ob_start();
		// It cause a `require_once` so, in the get_header it self it will not be required again.
		locate_template( $templates, true );
		ob_get_clean();
	}
}
