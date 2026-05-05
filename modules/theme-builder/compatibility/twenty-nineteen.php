<?php

namespace VertexMediaLLC\ZyreElementorAddons\Modules\ThemeBuilder\Compatibility;

use VertexMediaLLC\ZyreElementorAddons\Modules\ThemeBuilder\Conditions_Manager;

defined( 'ABSPATH' ) || exit;

/**
 * TwentyNineteen support for the header footer.
 */
class TwentyNineteen {

	/**
	 * Run all the Actions / Filters.
	 */
	public function __construct() {
		$headers = Conditions_Manager::instance()->get_documents_for_location( 'header' );
		$footers = Conditions_Manager::instance()->get_documents_for_location( 'footer' );

		if ( ! empty( $headers ) ) {
			add_action( 'get_header', [ $this, 'get_header' ] );
		}

		if ( ! empty( $footers ) ) {
			add_action( 'get_footer', [ $this, 'get_footer' ] );
		}
	}

	public function get_header( $name ) {
		add_action( 'zyreladdons/template/after_header', function () {
			echo '<div id="page" class="site">';
			echo '<div id="content" class="site-content">';
		} );

		require ZYRELADDONS_DIR_PATH . 'modules/theme-builder/templates/theme-support-header.php';

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
		add_action( 'zyreladdons/template/after_footer', function () {
			echo '</div></div>';
		} );

		require ZYRELADDONS_DIR_PATH . 'modules/theme-builder/templates/theme-support-footer.php';

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
