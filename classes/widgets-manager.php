<?php

namespace ZyreAddons\Elementor;

use Elementor\Element_Base;

defined( 'ABSPATH' ) || die();

/**
 * Widgets_Manager class
 *
 * @since 1.0.0
 * @package ZyreAddons
 */
class Widgets_Manager {

	const WIDGETS_KEY_INACTIVE = 'zyreaddons_inactive_widgets';
	const WIDGETS_STYLES_KEY_ACTIVE = 'zyreaddons_widgets_active_styles';

	/**
	 * Initialize
	 */
	public static function init() {
		// original hook for register widgets.
		add_action( 'elementor/widgets/register', [ __CLASS__, 'register' ] );

		add_action( 'elementor/frontend/before_render', [ __CLASS__, 'add_global_widget_render_attributes' ] );
	}

	/**
	 * Adds global widget render attributes.
	 *
	 * Adds render attributes to a global widget instance if it exists and belongs to the Zyre Addons plugin.
	 *
	 * @since 1.0.0
	 * @param Element_Base $widget The widget instance.
	 * @return void
	 */
	public static function add_global_widget_render_attributes( Element_Base $widget ) {
		if ( $widget->get_name() === 'global' && method_exists( $widget, 'get_original_element_instance' ) ) {
			$original_instance = $widget->get_original_element_instance();
			if ( method_exists( $original_instance, 'get_html_wrapper_class' ) && strpos( $original_instance->get_data( 'widgetType' ), 'zyre-' ) !== false ) {
				$widget->add_render_attribute(
					'_wrapper',
					[
						'class' => $original_instance->get_html_wrapper_class(),
					]
				);
			}
		}
	}

	/**
	 * Get the styles control notice.
	 *
	 * @since 1.0.0
	 *
	 * @param string $widget_id The widget ID
	 * @return string The notice.
	 */
	public static function get_the_styles_notice( string $widget_id ) {
		return sprintf(
			/* translators: %s is the widget URL */
			__( '<a href="%s" target="_blank">Click here</a> to make Active / Inactive Styles', 'zyre-elementor-addons' ),
			esc_url( admin_url( 'admin.php?page=zyre-addons&t=widgets&widget=' . $widget_id ) )
		);
	}

	/**
	 * Retrieves the base widget key.
	 *
	 * @since 1.0.0
	 *
	 * @return string The base widget key.
	 */
	public static function get_base_widget_key() {
		return apply_filters( 'zyreaddons_get_base_widget_key', '_zyreaddons_base' );
	}

	/**
	 * Get Inactive Widgets Keys from Database.
	 *
	 * @since 1.0.0
	 */
	public static function get_inactive_widgets() {
		return get_option( self::WIDGETS_KEY_INACTIVE, [] );
	}

	/**
	 * Save Inactive Widgets Keys to Database.
	 *
	 * @since 1.0.0
	 */
	public static function save_inactive_widgets( $widgets = [] ) {
		update_option( self::WIDGETS_KEY_INACTIVE, $widgets );
	}

	/**
	 * Get Widgets Active Styles Keys from Database.
	 *
	 * @since 1.0.0
	 */
	public static function get_widgets_active_styles() {
		return get_option( self::WIDGETS_STYLES_KEY_ACTIVE, [] );
	}

	/**
	 * Save Widgets Active Styles Keys to Database.
	 *
	 * @since 1.0.0
	 */
	public static function save_widgets_active_styles( $widgets_styles = [] ) {
		update_option( self::WIDGETS_STYLES_KEY_ACTIVE, $widgets_styles );
	}

	/**
	 * Get widget thumbnail url.
	 *
	 * @param string $widget_id The widget id
	 * @param string $file_name Name of the file. e.g. style-one.jpg
	 *
	 * @return string File url or ''.
	 */
	public static function get_widget_thumbnail_url( $widget_id, $file_name ) {
		$widget_id = sanitize_key( $widget_id );
		$file_name = basename( $file_name );
		$relative_path = 'img/widgets-thumbs/' . $widget_id . '/' . $file_name;

		$file_path = trailingslashit( ZYRE_ADDONS_DIR_PATH . 'assets' ) . $relative_path;
		$file_url = ZYRE_ADDONS_ASSETS . $relative_path;

		return file_exists( $file_path ) ? $file_url : '';
	}

	/**
	 * Retrieves the free widgets map.
	 *
	 * @since 1.0.0
	 * @return array The free widgets map.
	 */
	public static function get_free_widgets_map() {
		return [
			'heading' => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/heading/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/heading/',
				'title'     => esc_html__( 'Heading', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Text-t',
				'css'       => [ 'heading' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Standard', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'heading', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Creative', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'heading', 'style-two.jpg' ),
					],
					'three' => [
						'name'      => esc_html__( 'Simple', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'heading', 'style-three.jpg' ),
					],
					'four'  => [
						'name'      => esc_html__( 'Two Layers', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'heading', 'style-four.jpg' ),
					],
					'five'  => [
						'name'      => esc_html__( 'Modern', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'heading', 'style-five.jpg' ),
					],
					'six'  => [
						'name'      => esc_html__( 'Dual Font', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'heading', 'style-six.jpg' ),
					],
				],
				'js'        => [],
			],
			'advance-heading' => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/advanced-heading/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/advanced-heading/',
				'title'     => esc_html__( 'Advance Heading', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Advance-heading',
				'css'       => [ 'advance-heading' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Default', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'advance-heading', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Dual Font', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'advance-heading', 'style-two.jpg' ),
					],
					'three' => [
						'name'      => esc_html__( 'Modern', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'advance-heading', 'style-three.jpg' ),
					],
					'four'  => [
						'name'      => esc_html__( 'Three Layers', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'advance-heading', 'style-four.jpg' ),
					],
				],
				'style_default' => 'one',
				'js'        => [],
			],
			'gradient-heading' => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/gradient-heading/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/gradient-heading/',
				'title'     => esc_html__( 'Gradient Heading', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Gradient-heading',
				'css'       => [ 'gradient-heading' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Dual Font', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'gradient-heading', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Modern', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'gradient-heading', 'style-two.jpg' ),
					],
				],
				'js'        => [],
			],
			'dual-color-heading' => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/dual-color-heading/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/dual-color-heading/',
				'title'     => esc_html__( 'Dual Color Heading', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Dual-color-heading',
				'css'       => [ 'dual-color-heading' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'dual-color-heading', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Background', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'dual-color-heading', 'style-two.jpg' ),
					],
					'three'   => [
						'name'      => esc_html__( 'Modern', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'dual-color-heading', 'style-three.jpg' ),
					],
				],
				'js'        => [],
			],
			'image-heading' => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/image-heading/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/image-heading/',
				'title'     => esc_html__( 'Image Heading', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Image-heading',
				'css'       => [ 'image-heading' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Standard', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'image-heading', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Complex', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'image-heading', 'style-two.jpg' ),
					],
					'three'   => [
						'name'      => esc_html__( 'Modern', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'image-heading', 'style-three.jpg' ),
					],
				],
				'js'        => [],
			],
			'button'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/button/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/button/',
				'title'     => esc_html__( 'Button', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Button',
				'css'       => [ 'button' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Primary', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'button', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Primary Two', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'button', 'style-two.jpg' ),
					],
					'three'  => [
						'name'      => esc_html__( 'Advance', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'button', 'style-three.jpg' ),
					],
					'four'  => [
						'name'      => esc_html__( 'Iconic', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'button', 'style-four.jpg' ),
					],
					'five' => [
						'name'      => esc_html__( '3D', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'button', 'style-five.jpg' ),
					],
				],
				'js'        => [],
			],
			'dual-button'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/dual-button/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/dual-button/',
				'title'     => esc_html__( 'Dual Button', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Dual-button',
				'css'       => [ 'dual-button' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Primary', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'dual-button', 'style-one.jpg' ),
					],
					'two' => [
						'name'      => esc_html__( 'Primary Two', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'dual-button', 'style-two.jpg' ),
					],
					'three' => [
						'name'      => esc_html__( 'Join Buttons', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'dual-button', 'style-three.jpg' ),
					],
					'four'   => [
						'name'      => esc_html__( 'Join Buttons Two', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'dual-button', 'style-four.jpg' ),
					],
				],
				'js'        => [],
			],
			'infobox' => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/info-box/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/info-box/',
				'title'     => esc_html__( 'Info Box', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Infobox',
				'css'       => [ 'infobox' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Simple', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'infobox', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Standard', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'infobox', 'style-two.jpg' ),
					],
					'three' => [
						'name'      => esc_html__( 'Modern', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'infobox', 'style-three.jpg' ),
					],
				],
				'js'        => [],
			],
			'iconbox' => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/icon-box/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/icon-box/',
				'title'     => esc_html__( 'Icon Box', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Iconbox',
				'css'       => [ 'iconbox' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Standard', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'iconbox', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Advance', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'iconbox', 'style-two.jpg' ),
					],
					'three' => [
						'name'      => esc_html__( 'Modern', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'iconbox', 'style-three.jpg' ),
					],
					'four'  => [
						'name'      => esc_html__( 'Simple', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'iconbox', 'style-four.jpg' ),
					],
					'five'  => [
						'name'      => esc_html__( 'Minimal', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'iconbox', 'style-five.jpg' ),
					],
				],
				'js'        => [],
			],
			'flipbox' => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/flip-box/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/flip-box/',
				'title'     => esc_html__( 'Flip Box', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Flip-box',
				'css'       => [ 'flipbox' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Image Card', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'flipbox', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Team Card', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'flipbox', 'style-two.jpg' ),
					],
				],
				'js'        => [],
			],
			'call-to-action' => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/call-to-action/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/call-to-action/',
				'title'     => esc_html__( 'Call to Action ', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Call-to-action',
				'css'       => [ 'call-to-action' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Standard', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'call-to-action', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Dual Button', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'call-to-action', 'style-two.jpg' ),
					],
					'three' => [
						'name'      => esc_html__( 'Simple', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'call-to-action', 'style-three.jpg' ),
					],
					'four' => [
						'name'      => esc_html__( 'Advance', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'call-to-action', 'style-four.jpg' ),
					],
					'five' => [
						'name'      => esc_html__( 'Standard-2', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'call-to-action', 'style-five.jpg' ),
					],
				],
				'js'        => [],
			],
			'featured-banner'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/featured-banner/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/featured-banner/',
				'title'     => esc_html__( 'Featured Banner', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Featured-banner',
				'css'       => [ 'featured-banner' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Banner', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'featured-banner', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Overlay Image', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'featured-banner', 'style-two.jpg' ),
					],
					'three'   => [
						'name'      => esc_html__( 'Product Banner', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'featured-banner', 'style-three.jpg' ),
					],
					'four' => [
						'name'      => esc_html__( 'Product Banner-2', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'featured-banner', 'style-four.jpg' ),
					],
				],
				'js'        => [],
			],
			'feature-list'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/feature-list/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/feature-list/',
				'title'     => esc_html__( 'Feature List', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Featured-list',
				'css'       => [ 'feature-list' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Advance', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'feature-list', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Advance 2', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'feature-list', 'style-two.jpg' ),
					],
					'three' => [
						'name'      => esc_html__( 'Modern', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'feature-list', 'style-three.jpg' ),
					],
				],
				'js'        => [],
			],
			'numeric-list'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/numeric-list/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/numeric-list/',
				'title'     => esc_html__( 'Numeric List', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Number-list',
				'css'       => [ 'numeric-list' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Minimal', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'numeric-list', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Standard', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'numeric-list', 'style-two.jpg' ),
					],
					'three' => [
						'name'      => esc_html__( 'Advance', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'numeric-list', 'style-three.jpg' ),
					],
					'four' => [
						'name'      => esc_html__( 'Boxed', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'numeric-list', 'style-four.jpg' ),
					],
				],
				'js'        => [],
			],
			'image-list'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/image-list/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/image-list/',
				'title'     => esc_html__( 'Image List', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Image-list',
				'css'       => [ 'image-list' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Horizontal', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'image-list', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Standard', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'image-list', 'style-two.jpg' ),
					],
					'three' => [
						'name'      => esc_html__( 'Boxed', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'image-list', 'style-three.jpg' ),
					],
				],
				'js'        => [],
			],
			'list-group'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/list-group/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/list-group/',
				'title'     => esc_html__( 'List Group', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-List-group',
				'css'       => [ 'list-group' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Standard', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'list-group', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Modern', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'list-group', 'style-two.jpg' ),
					],
					'three' => [
						'name'      => esc_html__( 'Simple', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'list-group', 'style-three.jpg' ),
					],
				],
				'js'        => [],
			],
			'image-carousel'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/image-carousel/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/mage-carousel/',
				'title'     => esc_html__( 'Image Carousel', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Image-carousel',
				'css'       => [ 'image-carousel' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Standard', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'image-carousel', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Advance', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'image-carousel', 'style-two.jpg' ),
					],
				],
				'js'        => [],
			],
			'team-member'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/team-member/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/team-member/',
				'title'     => esc_html__( 'Team Member', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Team-member',
				'css'       => [ 'team-member' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Standard', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'team-member', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Simple', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'team-member', 'style-two.jpg' ),
					],
				],
				'js'        => [],
			],
			'testimonial'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/testimonial/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/testimonial/',
				'title'     => esc_html__( 'Testimonial', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Testimonial',
				'css'       => [ 'testimonial' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Standard', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'testimonial', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'With Review', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'testimonial', 'style-two.jpg' ),
					],
					'three'   => [
						'name'      => esc_html__( 'Message', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'testimonial', 'style-three.jpg' ),
					],
				],
				'js'        => [],
			],
			'post-grid'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/post-grid/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/post-grid/',
				'title'     => esc_html__( 'Post Grid', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Post-grid',
				'css'       => [ 'post-grid' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Advance', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'post-grid', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Standard', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'post-grid', 'style-two.jpg' ),
					],
					'three' => [
						'name'      => esc_html__( 'Minimal', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'post-grid', 'style-three.jpg' ),
					],
					'four' => [
						'name'      => esc_html__( 'Overlay', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'post-grid', 'style-four.jpg' ),
					],
					'five' => [
						'name'      => esc_html__( 'Simple', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'post-grid', 'style-five.jpg' ),
					],
					'six' => [
						'name'      => esc_html__( 'Boxed', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'post-grid', 'style-six.jpg' ),
					],
					'seven' => [
						'name'      => esc_html__( 'Modern', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'post-grid', 'style-seven.jpg' ),
					],
					'eight' => [
						'name'      => esc_html__( 'Modern-2', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'post-grid', 'style-eight.jpg' ),
					],
				],
				'js'        => [],
			],
			'image-grid'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/image-grid/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/image-grid/',
				'title'     => esc_html__( 'Image Grid', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Image-grid',
				'css'       => [ 'image-grid' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Standard', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'image-grid', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Advance', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'image-grid', 'style-two.jpg' ),
					],
					'three' => [
						'name'      => esc_html__( 'Modern', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'image-grid', 'style-three.jpg' ),
					],
					'four' => [
						'name'      => esc_html__( 'Creative', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'image-grid', 'style-four.jpg' ),
					],
				],
				'js'        => [],
				'libs'      => [
					'css'   => [ 'e-swiper' ],
					'js'    => [ 'zyre-isotope', 'imagesloaded' ]
				],
			],
			'logo-grid'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/logo-grid/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/logo-grid/',
				'title'     => esc_html__( 'Logo Grid', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Logo-grid',
				'css'       => [ 'logo-grid' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Standard', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'logo-grid', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Advance', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'logo-grid', 'style-two.jpg' ),
					],
					'three' => [
						'name'      => esc_html__( 'Modern', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'logo-grid', 'style-three.jpg' ),
					],
				],
				'js'        => [],
			],
			'logo-carousel'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/logo-carousel/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/logo-carousel/',
				'title'     => esc_html__( 'Logo Carousel', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Logo-carousel',
				'css'       => [ 'logo-carousel' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Standard', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'logo-carousel', 'style-one.jpg' ),
					],
				],
				'js'        => [],
			],
			'social-icon'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/social-icons/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/social-icons/',
				'title'     => esc_html__( 'Social Icon', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Social-media',
				'css'       => [ 'social-icon' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Standard', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'social-icon', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Modern', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'social-icon', 'style-two.jpg' ),
					],
				],
				'js'        => [],
			],
			'social-share'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/social-share/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/social-share/',
				'title'     => esc_html__( 'Social Share', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Social-button',
				'css'       => [ 'social-share' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Standard', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'social-share', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Modern', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'social-share', 'style-two.jpg' ),
					],
				],
				'js'        => [],
				'libs' => [
					'js'  => [ 'sharer-js' ],
					'css' => [],
				],
			],
			'advance-accordion'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/advance-accordion/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/advance-accordion/',
				'title'     => esc_html__( 'Advance Accordion', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Accordion',
				'css'       => [ 'advance-accordion' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Standard', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'advance-accordion', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Advance', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'advance-accordion', 'style-two.jpg' ),
					],
					'three' => [
						'name'      => esc_html__( 'Smart', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'advance-accordion', 'style-three.jpg' ),
					],
				],
				'js'        => [],
			],
			'advance-toggle'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/advance-toggle/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/advance-toggle/',
				'title'     => esc_html__( 'Advance Toggle', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Advance-toggle',
				'css'       => [ 'advance-toggle' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Standard', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'advance-toggle', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Modern', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'advance-toggle', 'style-two.jpg' ),
					],
					'three' => [
						'name'      => esc_html__( 'Simple', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'advance-toggle', 'style-three.jpg' ),
					],
				],
				'js'        => [],
			],
			'fun-fact'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/fun-fact/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/fun-fact/',
				'title'     => esc_html__( 'Fun Fact', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Fun-fact',
				'css'       => [ 'fun-fact' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Standard', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'fun-fact', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Boxed', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'fun-fact', 'style-two.jpg' ),
					],
					'three' => [
						'name'      => esc_html__( 'Advance', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'fun-fact', 'style-three.jpg' ),
					],
					'four' => [
						'name'      => esc_html__( 'Minimal', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'fun-fact', 'style-four.jpg' ),
					],
				],
				'js'        => [],
				'libs' => [
					'js'  => [ 'jquery-numerator' ],
					'css' => [],
				],
			],
			'alert'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/alert/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/alert/',
				'title'     => esc_html__( 'Alert', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Alert',
				'css'       => [ 'alert' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Standard', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'alert', 'style-one.jpg' ),
					],
				],
				'js'        => [],
				'libs' => [
					'js'  => [ 'alert-handler' ],
					'css' => [],
				],
			],
			'skill-bar'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/skill-bars/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/skill-bars/',
				'title'     => esc_html__( 'Skill Bar', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Skills-bar',
				'css'       => [ 'skill-bar' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Individuals', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'skill-bar', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Company', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'skill-bar', 'style-two.jpg' ),
					],
				],
				'js'        => [],
				'libs' => [
					'js'  => [ 'jquery-numerator' ],
					'css' => [],
				],
			],
			'countdown'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/countdown/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/countdown/',
				'title'     => esc_html__( 'Countdown', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Countdown-stopwatch',
				'css'       => [ 'countdown' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Standard', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'countdown', 'style-one.jpg' ),
					],
				],
				'js'        => [],
				'libs' => [
					'js'  => [ 'zyre-jquery-downcount' ],
					'css' => [],
				],
			],
			'business-hour'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/business-hour/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/business-hour/',
				'title'     => esc_html__( 'Business Hour', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Business-hour',
				'css'       => [ 'business-hour' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Primary', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'business-hour', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Minimal', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'business-hour', 'style-two.jpg' ),
					],
					'three' => [
						'name'      => esc_html__( 'Boxed', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'business-hour', 'style-three.jpg' ),
					],
				],
				'js'        => [],
			],
			'drop-cap'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/drop-cap/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/drop-cap/',
				'title'     => esc_html__( 'Drop Cap', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Dropcap',
				'css'       => [ 'drop-cap' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Minimal', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'drop-cap', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Standard', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'drop-cap', 'style-two.jpg' ),
					],
				],
				'js'        => [],
			],
			'animated-text'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/animated-text/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/animated-text/',
				'title'     => esc_html__( 'Animated Text', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Animated-text',
				'css'       => [ 'animated-text' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Changing Word', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'animated-text', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Changing Color', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'animated-text', 'style-two.jpg' ),
					],
					'three' => [
						'name'      => esc_html__( 'Flashing', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'animated-text', 'style-three.jpg' ),
					],
				],
				'js'        => [],
				'libs'      => [
					'js' => [ 'zyre-animated-text', 'zyre-typed', 'zyre-vticker' ],
					'css' => [],
				],
			],
			'news-ticker'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/news-ticker/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/news-ticker/',
				'title'     => esc_html__( 'News Ticker', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-News-ticker',
				'css'       => [ 'news-ticker' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Modern', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'news-ticker', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Standard', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'news-ticker', 'style-two.jpg' ),
					],
					'three' => [
						'name'      => esc_html__( 'Simple', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'news-ticker', 'style-three.jpg' ),
					],
					'four' => [
						'name'      => esc_html__( 'Breaking', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'news-ticker', 'style-four.jpg' ),
					],
				],
				'js'        => [],
			],
			'divider'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/divider/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/divider/',
				'title'     => esc_html__( 'Divider', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Devider-line',
				'css'       => [ 'divider' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Standard', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'divider', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Dotted', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'divider', 'style-two.jpg' ),
					],
				],
				'js'        => [],
			],
			'toggle'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/toggle/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/toggle/',
				'title'     => esc_html__( 'Toggle', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Toggle',
				'css'       => [ 'toggle' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Primary', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'toggle', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'On-Off', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'toggle', 'style-two.jpg' ),
					],
					'three' => [
						'name'      => esc_html__( 'Minimal', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'toggle', 'style-three.jpg' ),
					],
					'four' => [
						'name'      => esc_html__( 'Modern', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'toggle', 'style-four.jpg' ),
					],
				],
				'js'        => [],
			],
			'subscription-form'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/subscription-form/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/subscription-form/',
				'title'     => esc_html__( 'Subscription Form', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Subscription',
				'css'       => [ 'subscription-form' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Simple', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'subscription-form', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Standard', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'subscription-form', 'style-two.jpg' ),
					],
					'three' => [
						'name'      => esc_html__( 'Advance', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'subscription-form', 'style-three.jpg' ),
					],
				],
				'js'        => [],
			],
			'cf7'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/contact-form-7/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/contact-form-7/',
				'title'     => esc_html__( 'Contact Form 7', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Contact-form',
				'css'       => [ 'cf7' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Standard', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'cf7', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Minimal', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'cf7', 'style-two.jpg' ),
					],
				],
				'js'        => [],
			],
			'site-title'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/site-title/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/site-title/',
				'title'     => esc_html__( 'Site Title', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Site-title',
				'css'       => [ 'site-title' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Style One', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'site-title', 'style-one.jpg' ),
					],
				],
				'js'        => [],
			],
			'site-tagline'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/site-tagline/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/site-tagline/',
				'title'     => esc_html__( 'Site Tagline', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Site-tagline',
				'css'       => [ 'site-tagline' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Style One', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'site-tagline', 'style-one.jpg' ),
					],
				],
				'js'        => [],
			],
			'site-logo'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/site-logo/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/site-logo/',
				'title'     => esc_html__( 'Site Logo', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Site-logo',
				'css'       => [ 'site-logo' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Style One', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'site-logo', 'style-one.jpg' ),
					],
				],
				'js'        => [],
			],
			'menu'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/menu/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/menu/',
				'title'     => esc_html__( 'Menu', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Menu',
				'css'       => [],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Style One', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'menu', 'style-one.jpg' ),
					],
				],
				'js'        => [],
				'libs' => [
					'js'  => [],
					'css' => [ 'zyre-elementor-addons-nav-menu' ],
				],
			],
			'post-title'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/post-title/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/post-title/',
				'title'     => esc_html__( 'Post Title', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Post-Title',
				'css'       => [ 'post-title' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Style One', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'post-title', 'style-one.jpg' ),
					],
				],
				'js'        => [],
			],
			'page-title'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/page-title/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/page-title/',
				'title'     => esc_html__( 'Page Title', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Page-Title',
				'css'       => [ 'page-title' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Standard', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'page-title', 'style-one.jpg' ),
					],
				],
				'js'        => [],
			],
			'post-excerpt'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/post-excerpt/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/post-excerpt/',
				'title'     => esc_html__( 'Post Excerpt', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Post-Excerpt',
				'css'       => [ 'post-excerpt' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Style One', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'post-excerpt', 'style-one.jpg' ),
					],
				],
				'js'        => [],
			],
			'post-content'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/post-content/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/post-content/',
				'title'     => esc_html__( 'Post Content', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Post-Content',
				'css'       => [ 'post-content' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Standard', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'post-content', 'style-one.jpg' ),
					],
				],
				'js'        => [],
			],
			'post-thumbnail'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/post-thumbnail/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/post-thumbnail/',
				'title'     => esc_html__( 'Post Thumbnail', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Post-Thumbnail',
				'css'       => [ 'post-thumbnail' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Style One', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'post-thumbnail', 'style-one.jpg' ),
					],
				],
				'js'        => [],
			],
			'post-meta'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/post-meta/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/post-meta/',
				'title'     => esc_html__( 'Post Meta', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Post-Meta',
				'css'       => [ 'post-meta' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Style One', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'post-meta', 'style-one.jpg' ),
					],
				],
				'js'        => [],
			],
			'post-navigation'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/post-navigation/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/post-navigation/',
				'title'     => esc_html__( 'Post Navigation', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Post-Navigation',
				'css'       => [ 'post-navigation' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Standard', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'post-navigation', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Simple', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'post-navigation', 'style-two.jpg' ),
					],
				],
				'js'        => [],
			],
			'post-comments'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/post-comments/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/post-comments/',
				'title'     => esc_html__( 'Post Comments', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Post-Comment',
				'css'       => [ 'post-comments' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Basic', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'post-comments', 'style-one.jpg' ),
					],
				],
				'js'        => [],
			],
			'archive-title'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/archive-title/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/archive-title/',
				'title'     => esc_html__( 'Archive Title', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Archive-Title',
				'css'       => [ 'archive-title' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Basic', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'archive-title', 'style-one.png' ),
					],
				],
				'js'        => [],
			],
			'archive-description'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/archive-description/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/archive-description/',
				'title'     => esc_html__( 'Archive Description', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Archive-Description',
				'css'       => [ 'archive-description' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Standard', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'archive-description', 'style-one.png' ),
					],
				],
				'js'        => [],
			],
			'archive-posts'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/archive-post/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/archive-post/',
				'title'     => esc_html__( 'Archive Posts', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Archive-Post',
				'css'       => [ 'archive-posts' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Basic', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'archive-posts', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Modern', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'archive-posts', 'style-two.jpg' ),
					],
				],
				'js'        => [],
			],
			'author-box'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/author-box/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/author-box/',
				'title'     => esc_html__( 'Author Box', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Author-Box',
				'css'       => [ 'author-box' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Basic', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'author-box', 'style-one.jpg' ),
					],
					'two'   => [
						'name'      => esc_html__( 'Advance', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'author-box', 'style-two.png' ),
					],
				],
				'js'        => [],
			],
			'pdf-view'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/pdf-view/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/pdf-view/',
				'title'     => esc_html__( 'PDF View', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-PDF-view',
				'css'       => [ 'pdf-view' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Basic', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'pdf-view', 'style-one.jpg' ),
					],'two'   => [
						'name'      => esc_html__( 'Advance', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'pdf-view', 'style-two.jpg' ),
					],
				],
				'js'        => [],
				'libs'      => [
					'js' => [ 'zyre-pdf-js' ],
					'css' => [],
				],
			],
			'lottie-animation'  => [
				'cat'       => 'general',
				'is_active' => true,
				'demo'      => 'https://zyreaddons.com/demos/lottie-animations/',
				'doc'       => 'https://zyreaddons.com/docs/zyre-elementor-addons/widgets/lottie-animations/',
				'title'     => esc_html__( 'Lottie Animations', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Lottie-Animations',
				'css'       => [ 'lottie-animation' ],
				'styles'    => [
					'one'   => [
						'name'      => esc_html__( 'Style One', 'zyre-elementor-addons' ),
						'is_active' => true,
						'thumb'     => self::get_widget_thumbnail_url( 'lottie-animation', 'style-one.jpg' ),
					],
				],
				'js'        => [],
				'libs'      => [
					'js' => [ 'zyre-lottie-js' ],
					'css' => [],
				],
			],
		];
	}

	/**
	 * Retrieves the pro widgets map.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public static function get_pro_widget_map() {
		return [
			'mega-menu' => [
				'cat'       => 'general',
				'is_pro'    => true,
				'demo'      => 'https://elementorin.com/zyre-addons/demo-info-box',
				'title'     => __( 'Mega Menu', 'zyre-elementor-addons' ),
				'icon'      => 'zy-fonticon zy-Mega-menu',
				'styles'    => [],
			],
		];
	}

	/**
	 * Retrieves the widgets map.
	 *
	 * Combines the base widget key with local widgets map and applies filters.
	 *
	 * @since 1.0.0
	 * @return array The widgets map.
	 */
	public static function get_widgets_map() {
		$widgets_map = [
			self::get_base_widget_key() => [
				'css'  => [],
				'js'   => [],
				'libs' => [
					'js'  => [],
					'css' => [ 'font-awesome' ],
				],
			],
		];

		$free_widgets_map = self::get_free_widgets_map();
		$widgets_map = array_merge( $widgets_map, $free_widgets_map );

		return apply_filters( 'zyreaddons_get_widgets_map', $widgets_map );
	}

	/**
	 * Retrieves the real widgets map, exclude which is not a widget.
	 *
	 * @since 1.0.0
	 * @return array The real widgets map.
	 */
	public static function get_real_widgets_map() {
		$widgets_map = self::get_widgets_map();
		unset( $widgets_map[ self::get_base_widget_key() ] );
		return $widgets_map;
	}

	/**
	 * Retrieves all active widgets.
	 *
	 * @since 1.0.0
	 * @return array The active widgets.
	 */
	public static function get_active_widgets() {
		$widgets_map = self::get_real_widgets_map();
		$inactive_widgets = self::get_inactive_widgets();
		foreach ( $inactive_widgets as $inactive_widget ) {
			unset( $widgets_map[ $inactive_widget ] );
		}
		return $widgets_map;
	}

	/**
	 * Retrieves a single widget map by ID.
	 *
	 * @since 1.0.0
	 * @return array The widget map.
	 */
	public static function get_the_widget_map( string $widget_id ) {
		$widgets_map = self::get_widgets_map();

		if ( isset( $widgets_map[ $widget_id ] ) ) {
			return $widgets_map[ $widget_id ];
		}
	}

	/**
	 * Retrieves a single widget map styles by ID.
	 *
	 * @since 1.0.0
	 * @return array The widget map styles.
	 */
	public static function get_the_widget_styles( string $widget_id ) {
		$widget_id = str_replace( 'zyre-', '', $widget_id );

		$widget_map = self::get_the_widget_map( $widget_id );
		$all_active_styles = self::get_widgets_active_styles();
		$active_styles = isset( $all_active_styles[ $widget_id ] ) ? $all_active_styles[ $widget_id ] : [];

		$widget_styles = [];

		if ( ! empty( $widget_map['styles'] ) && is_array( $widget_map['styles'] ) ) {
			$i = 1;
			foreach ( $widget_map['styles'] as $key => $style ) {
				$is_active = ! empty( $active_styles ) ? in_array( $key, $active_styles, true ) : $style['is_active'];

				$inactive_text = ! $is_active ? esc_html__( '(Inactive)', 'zyre-elementor-addons' ) : '';
				/* translators: 1: style number, 2: style name, 3: additional text */
				$widget_styles[ $key ]['name'] = sprintf( esc_html__( 'Style %1$d - %2$s %3$s', 'zyre-elementor-addons' ), $i, $style['name'], $inactive_text );
				$widget_styles[ $key ]['is_active'] = $is_active;

				++$i;
			}
		}

		return $widget_styles;
	}

	/**
	 * Retrieves a single widget map active styles by ID.
	 *
	 * @since 1.0.0
	 * @return array The widget map active styles.
	 */
	public static function get_the_widget_active_styles( string $widget_id ) {
		$widget_styles = self::get_the_widget_styles( $widget_id );

		$active_styles = array_filter( $widget_styles, function ( $style ) {
			return true === $style['is_active'];
		});

		return $active_styles;
	}

	/**
	 * Retrieves a single widget style options by ID.
	 *
	 * @since 1.0.0
	 * @return array The widget style options.
	 */
	public static function get_the_widget_style_options( string $widget_id ) {
		$default_style = [
			'default' => [
				'name'      => esc_html__( 'Default - No Style', 'zyre-elementor-addons' ),
				'is_active' => true,
			],
		];
		$widget_styles = self::get_the_widget_styles( $widget_id );
		// $widget_styles = array_merge( $default_style, $widget_styles );

		return array_map( fn( $style ) => $style['name'], $widget_styles );
	}

	/**
	 * Retrieves the widget's default style key for default activation by its ID.
	 *
	 * @since 1.0.0
	 *
	 * @param string $widget_id The ID of the widget.
	 * @return string The widget's default style key.
	 */
	public static function get_the_widget_style_default( string $widget_id ) {
		$widget_map = self::get_the_widget_map( $widget_id );
		$style_options = self::get_the_widget_style_options( $widget_id );
		$inactive_styles = self::get_the_widget_inactive_styles_keys( $widget_id );
		$style_options = array_diff_key( $style_options, array_flip( $inactive_styles ) );

		if ( isset( $widget_map['style_default'] ) && array_key_exists( $widget_map['style_default'], $style_options ) ) {
			return $widget_map['style_default'];
		}

		return array_key_first( $style_options );
	}

	/**
	 * Retrieves a single widget inactive styles keys by ID.
	 *
	 * @since 1.0.0
	 * @return array The widget inactive styles keys.
	 */
	public static function get_the_widget_inactive_styles_keys( string $widget_id ) {
		$widget_styles = self::get_the_widget_styles( $widget_id );

		return array_keys( array_filter( $widget_styles, fn( $style ) => ! $style['is_active'] ) );
	}

	/**
	 * Retrieve the widget document/help url.
	 *
	 * @param string $widget_id The ID of the widget.
	 * @return array The widget doc url.
	 * @since 1.0.0
	 */
	public static function get_widget_doc_url( string $widget_id ) {
		$widget_map = self::get_the_widget_map( $widget_id );

		if ( isset( $widget_map[ 'doc' ] ) ) {
			return $widget_map[ 'doc' ];
		}

		return null;
	}

	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 *
	 * @param Widgets_Manager $widgets_manager The widgets manager.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public static function register( $widgets_manager = null ) {
		include_once ZYRE_ADDONS_DIR_PATH . 'base/widget-base.php';
		include_once ZYRE_ADDONS_DIR_PATH . 'traits/button-trait.php';
		include_once ZYRE_ADDONS_DIR_PATH . 'traits/list-item-trait.php';
		include_once ZYRE_ADDONS_DIR_PATH . 'traits/list-item-advanced-trait.php';
		include_once ZYRE_ADDONS_DIR_PATH . 'traits/social-trait.php';
		include_once ZYRE_ADDONS_DIR_PATH . 'traits/swiper-trait.php';

		$inactive_widgets = self::get_inactive_widgets();

		foreach ( self::get_free_widgets_map() as $widget_key => $data ) {
			if ( ! in_array( $widget_key, $inactive_widgets, true ) ) {
				self::register_widget( $widget_key, $widgets_manager );
			}
		}

		/**
		 * Fires after ZyreAddons widgets are registered.
		 *
		 * @since 1.0.0
		 * @param Widgets_Manager $widgets_manager The widgets manager.
		 */
		do_action( 'zyreaddons/widgets/register', $widgets_manager );
	}

	/**
	 * Registers a widget by including its file, instantiating its class, and registering it with the widgets manager.
	 *
	 * @since 1.0.0
	 * @param string      $widget_key The key of the widget.
	 * @param object|null $widgets_manager The Elementor widgets manager.
	 * @return void
	 */
	protected static function register_widget( $widget_key, $widgets_manager = null ) {
		$widget_file = ZYRE_ADDONS_DIR_PATH . 'widgets/' . $widget_key . '/' . $widget_key . '.php';

		if ( is_readable( $widget_file ) ) {

			include_once $widget_file;

			$widget_class = '\ZyreAddons\Elementor\Widget\\' . str_replace( '-', '_', $widget_key );
			if ( class_exists( $widget_class ) ) {
				$widgets_manager->register( new $widget_class() );
			}
		}
	}
}

Widgets_Manager::init();
