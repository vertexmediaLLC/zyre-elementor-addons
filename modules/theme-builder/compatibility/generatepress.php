<?php

namespace ZyreAddons\Elementor\ThemeBuilder\Compatibility;

use ZyreAddons\Elementor\ThemeBuilder\Module;

defined( 'ABSPATH' ) || exit;

/**
 * GeneratePress theme compatibility.
 */
class Generatepress {

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
			add_action( 'generate_header', [ $this, 'add_plugin_header_markup' ] );
		}

		if ( null !== $this->footer ) {
			add_action( 'template_redirect', [ $this, 'remove_theme_footer_markup' ], 10 );
			add_action( 'generate_footer', [ $this, 'add_plugin_footer_markup' ] );
		}
	}

	// header actions
	public function remove_theme_header_markup() {
		remove_action( 'generate_header', 'generate_construct_header' );
	}

	public function add_plugin_header_markup() {
		do_action( 'zyreaddons/template/before_header' );
		echo '<div class="ekit-template-content-markup ekit-template-content-header">';
		echo Module::render_builder_data( $this->header ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '</div>';
		do_action( 'zyreaddons/template/after_header' );
	}

	// footer actions
	public function remove_theme_footer_markup() {
		remove_action( 'generate_footer', 'generate_construct_footer_widgets', 5 );
		remove_action( 'generate_footer', 'generate_construct_footer' );
	}

	public function add_plugin_footer_markup() {
		do_action( 'zyreaddons/template/before_footer' );
		echo '<div class="ekit-template-content-markup ekit-template-content-footer">';
		echo Module::render_builder_data( $this->footer ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '</div>';
		do_action( 'zyreaddons/template/after_footer' );
	}
}
