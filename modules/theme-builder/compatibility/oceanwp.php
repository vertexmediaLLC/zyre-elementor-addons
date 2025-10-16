<?php

namespace ZyreAddons\Elementor\ThemeBuilder\Compatibility;

use ZyreAddons\Elementor\ThemeBuilder\Module;

defined( 'ABSPATH' ) || exit;

/**
 * Oceanwp theme compatibility.
 */
class Oceanwp {

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
			add_action( 'template_redirect', [ $this, 'remove_theme_header_markup' ], 10 );
			add_action( 'ocean_header', [ $this, 'add_plugin_header_markup' ] );
		}

		if ( null !== $this->footer ) {
			add_action( 'template_redirect', [ $this, 'remove_theme_footer_markup' ], 10 );
			add_action( 'ocean_footer', [ $this, 'add_plugin_footer_markup' ] );
		}
	}

	// header actions
	public function remove_theme_header_markup() {
		remove_action( 'ocean_top_bar', 'oceanwp_top_bar_template' );
		remove_action( 'ocean_header', 'oceanwp_header_template' );
		remove_action( 'ocean_page_header', 'oceanwp_page_header_template' );
	}

	public function add_plugin_header_markup() {
		do_action( 'zyreaddons/template/before_header' );
		echo '<div class="ekit-template-content-markup ekit-template-content-header">';
		echo Module::render_builder_data( $this->header );
		echo '</div>';
		do_action( 'zyreaddons/template/after_header' );
	}

	// footer actions
	public function remove_theme_footer_markup() {
		remove_action( 'ocean_footer', 'oceanwp_footer_template' );
	}

	public function add_plugin_footer_markup() {
		do_action( 'zyreaddons/template/before_footer' );
		echo '<div class="ekit-template-content-markup ekit-template-content-footer">';
		echo Module::render_builder_data( $this->footer );
		echo '</div>';
		do_action( 'zyreaddons/template/after_footer' );
	}
}
