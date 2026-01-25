<?php

namespace ZyreAddons\Elementor\ThemeBuilder\Compatibility;

use ZyreAddons\Elementor\ThemeBuilder\Module;

defined( 'ABSPATH' ) || exit;

/**
 * BB theme theme compatibility.
 */
class Bbtheme {

	/**
	 * Instance of Elementor Frontend class.
	 *
	 * @var \Elementor\Frontend()
	 */
	private $elementor;

	private $header;
	private $footer;

	/**
	 * Run all the Actions / Filters.
	 */
	public function __construct( $template_ids ) {
		$this->header = $template_ids[0];
		$this->footer = $template_ids[1];

		if ( defined( 'ELEMENTOR_VERSION' ) && is_callable( 'Elementor\Plugin::instance' ) ) {
			$this->elementor = \Elementor\Plugin::instance();
		}

		if ( null !== $this->header ) {
			add_filter( 'fl_header_enabled', '__return_false' );
			add_action( 'fl_before_header', [ $this, 'add_plugin_header_markup' ] );
		}

		if ( null !== $this->footer ) {
			add_filter( 'fl_footer_enabled', '__return_false' );
			add_action( 'fl_after_content', [ $this, 'add_plugin_footer_markup' ] );
		}
	}

	// header actions
	public function add_plugin_header_markup() {

		if ( class_exists( '\FLTheme' ) ) {
			$header_layout = \FLTheme::get_setting( 'fl-header-layout' );

			if ( 'none' == $header_layout || is_page_template( 'tpl-no-header-footer.php' ) ) {
				return;
			}
		}

		do_action( 'zyreaddons/template/before_header' ); ?>

		<header id="masthead" itemscope="itemscope" itemtype="https://schema.org/WPHeader">
			<div class="ekit-template-content-markup ekit-template-content-header">
				<?php echo Module::render_builder_data( $this->header ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		</header>
		<style>
			[data-type="header"] {
				display: none !important;
			}
		</style>

		<?php do_action( 'zyreaddons/template/after_header' );
	}

	// footer actions
	public function add_plugin_footer_markup() {
		if ( is_page_template( 'tpl-no-header-footer.php' ) ) {
			return;
		}

		do_action( 'zyreaddons/template/before_footer' ); ?>

		<footer itemscope="itemscope" itemtype="https://schema.org/WPFooter">
		<?php echo Module::render_builder_data( $this->footer ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</footer>

		<?php do_action( 'zyreaddons/template/after_footer' );
	}
}