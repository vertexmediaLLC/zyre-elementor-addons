<?php
/**
 * Helper functions
 *
 * @package ZyreAddons
 */

defined( 'ABSPATH' ) || die();

/**
 * Get a list of all the allowed html tags.
 *
 * @since 1.0.0
 * @param string $level Allowed levels are basic, advanced and all.
 * @return array
 */
function zyre_get_allowed_html( $level = 'basic' ) {

	$allowed_html = array(
		'b'      => array(
			'class' => array(),
			'id'    => array(),
			'style' => array(),
		),
		'i'      => array(
			'class' => array(),
			'id'    => array(),
			'style' => array(),
		),
		'u'      => array(
			'class' => array(),
			'id'    => array(),
			'style' => array(),
		),
		's'      => array(
			'class' => array(),
			'id'    => array(),
			'style' => array(),
		),
		'br'     => array(
			'class' => array(),
			'id'    => array(),
			'style' => array(),
		),
		'em'     => array(
			'class' => array(),
			'id'    => array(),
			'style' => array(),
		),
		'del'    => array(
			'class' => array(),
			'id'    => array(),
			'style' => array(),
		),
		'ins'    => array(
			'class' => array(),
			'id'    => array(),
			'style' => array(),
		),
		'sub'    => array(
			'class' => array(),
			'id'    => array(),
			'style' => array(),
		),
		'sup'    => array(
			'class' => array(),
			'id'    => array(),
			'style' => array(),
		),
		'code'   => array(
			'class' => array(),
			'id'    => array(),
			'style' => array(),
		),
		'mark'   => array(
			'class' => array(),
			'id'    => array(),
			'style' => array(),
		),
		'small'  => array(
			'class' => array(),
			'id'    => array(),
			'style' => array(),
		),
		'strike' => array(
			'class' => array(),
			'id'    => array(),
			'style' => array(),
		),
		'abbr'   => array(
			'title' => array(),
			'class' => array(),
			'id'    => array(),
			'style' => array(),
		),
		'span'   => array(
			'class' => array(),
			'id'    => array(),
			'style' => array(),
		),
		'strong' => array(
			'class' => array(),
			'id'    => array(),
			'style' => array(),
		),
		'svg' => array(
            'xmlns' => array(),
            'width' => array(),
            'height' => array(),
            'viewbox' => array(),
            'aria-hidden' => array(),
            'role' => array(),
            'focusable' => array(),
        ),
        'path' => array(
            'd' => array(),
            'fill' => array(),
            'style' => array(),
        ),
	);

	$allowed_html_extra = array(
		'a'       => array(
			'href'   => array(),
			'title'  => array(),
			'class'  => array(),
			'id'     => array(),
			'style'  => array(),
			'rel'    => array(),
			'target' => array(),
		),
		'q'       => array(
			'cite'  => array(),
			'class' => array(),
			'id'    => array(),
			'style' => array(),
		),
		'dfn'     => array(
			'title' => array(),
			'class' => array(),
			'id'    => array(),
			'style' => array(),
		),
		'time'    => array(
			'datetime' => array(),
			'class'    => array(),
			'id'       => array(),
			'style'    => array(),
		),
		'cite'    => array(
			'title' => array(),
			'class' => array(),
			'id'    => array(),
			'style' => array(),
		),
		'acronym' => array(
			'title' => array(),
			'class' => array(),
			'id'    => array(),
			'style' => array(),
		),
		'hr'      => array(
			'class' => array(),
			'id'    => array(),
			'style' => array(),
		),
	);

	if ( 'advanced' === $level ) {
		$allowed_html = array_merge( $allowed_html, $allowed_html_extra );
	}

	if ( 'all' === $level ) {
		$allowed_html_extra['img'] = [
			'src'           => array(),
			'alt'           => array(),
			'height'        => array(),
			'width'         => array(),
			'class'         => array(),
			'id'            => array(),
			'style'         => array(),
			'srcset'        => array(),
			'sizes'         => array(),
			'decoding'      => array(),
			'fetchpriority' => array(),
		];

		$allowed_html = array_merge( $allowed_html, $allowed_html_extra );
	}

	return $allowed_html;
}

/**
 * Strip all the tags except allowed html tags
 *
 * The name is based on inline editing toolbar name
 *
 * @since 1.0.0
 * @param string $str
 * @return string
 */
function zyre_kses_basic( $str = '' ) {
	return wp_kses( $str, zyre_get_allowed_html() );
}

/**
 * Strip all the tags except allowed html tags
 *
 * The name is based on inline editing toolbar name
 *
 * @since 1.0.0
 * @param string $str
 * @return string
 */
function zyre_kses_advanced( $str = '' ) {
	return wp_kses( $str, zyre_get_allowed_html( 'advanced' ) );
}

/**
 * Check elementor version
 *
 * @since 1.0.0
 * @param string $operator '<'.
 * @param string $version Elementor Version.
 * @return bool
 */
function zyre_is_elementor_version( $operator = '<', $version = '2.6.0' ) {
	return defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, $version, $operator );
}

/**
 * Get elementor instance
 *
 * @since 1.0.0
 * @return \Elementor\Plugin
 */
function zyre_elementor() {
	return \Elementor\Plugin::instance();
}

/**
 * Checks if script debugging is enabled.
 *
 * @since 1.0.0
 * @return bool True if script debugging is enabled, false otherwise.
 */
function zyre_is_script_debug_enabled() {
	return ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG );
}


/**
 * Get a translatable string with allowed html tags.
 *
 * @param string $level Allowed levels are basic and intermediate.
 * @return string
 */
function zyre_get_allowed_html_desc( $level = 'basic' ) {
	if ( ! in_array( $level, array( 'basic', 'advanced' ), true ) ) {
		$level = 'basic';
	}

	$tags_str = '<' . implode( '>,<', array_keys( zyre_get_allowed_html( $level ) ) ) . '>';

	// Translators: translate with allowed HTML tags.
	return sprintf( __( 'This input field has support for the following HTML tags: %1$s', 'zyre-elementor-addons' ), '<code>' . esc_html( $tags_str ) . '</code>' );
}

/**
 * Escaped title html tags
 *
 * @param string $tag input string of title tag.
 * @return string $default_tag default tag will be return during no matches.
 */
function zyre_escape_tags( $tag, $default_tag = 'span', $extra = array() ) {
	$supports = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'span', 'p' );

	$supports = array_merge( $supports, $extra );

	if ( ! in_array( $tag, $supports, true ) ) {
		return $default_tag;
	}

	return $tag;
}

/**
 * Get icon html with backward compatibility
 *
 * @since 1.0.0
 * @param array $settings
 * @param string $old_icon_id
 * @param string $new_icon_id
 * @param array $attributes
 */
function zyre_get_icon_html( $settings = [], $old_icon_id = 'icon', $new_icon_id = 'selected_icon', $attributes = [] ) {
	// Check if its already migrated.
	$migrated = isset( $settings['__fa4_migrated'][ $new_icon_id ] );
	// Check if its a new widget without previously selected icon using the old Icon control.

	$is_new = empty( $settings[ $old_icon_id ] );

	$attributes['aria-hidden'] = 'true';

	if ( zyre_is_elementor_version( '>=', '2.6.0' ) && ( $is_new || $migrated ) ) {
		return \Elementor\Icons_Manager::try_get_icon_html( $settings[ $new_icon_id ], $attributes );
	} else {
		if ( empty( $attributes['class'] ) ) {
			$attributes['class'] = $settings[ $old_icon_id ];
		} elseif ( is_array( $attributes['class'] ) ) {
				$attributes['class'][] = $settings[ $old_icon_id ];
		} else {
			$attributes['class'] .= ' ' . $settings[ $old_icon_id ];
		}
		return sprintf( '<i %s></i>', \Elementor\Utils::render_html_attributes( $attributes ) );
	}
}

/**
 * Render icon html with backward compatibility
 *
 * @since 1.0.0
 * @param array $settings
 * @param string $old_icon_id
 * @param string $new_icon_id
 * @param array $attributes
 */
function zyre_render_icon( $settings = [], $old_icon_id = 'icon', $new_icon_id = 'selected_icon', $attributes = [] ) {
	echo zyre_get_icon_html( $settings, $old_icon_id, $new_icon_id, $attributes ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Render icon html with backward compatibility
 *
 * @since 1.0.0
 * @param array $settings
 * @param string $old_icon_id
 * @param string $new_icon_id
 * @param array $attributes
 */
function zyre_get_icon( $settings = [], $old_icon_id = 'icon', $new_icon_id = 'selected_icon', $attributes = [] ) {
	return zyre_get_icon_html( $settings, $old_icon_id, $new_icon_id, $attributes );
}

/**
 * Get all SVG Icons
 *
 * @since 1.0.0
 * @return array The array of SVG Icons.
 */
function zyre_get_svg_icons() {
	return array(
		'up-right-from-square' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M352 0c-12.9 0-24.6 7.8-29.6 19.8s-2.2 25.7 6.9 34.9L370.7 96 201.4 265.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L416 141.3l41.4 41.4c9.2 9.2 22.9 11.9 34.9 6.9s19.8-16.6 19.8-29.6l0-128c0-17.7-14.3-32-32-32L352 0zM80 32C35.8 32 0 67.8 0 112L0 432c0 44.2 35.8 80 80 80l320 0c44.2 0 80-35.8 80-80l0-112c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 112c0 8.8-7.2 16-16 16L80 448c-8.8 0-16-7.2-16-16l0-320c0-8.8 7.2-16 16-16l112 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L80 32z"/></svg>',
		'home' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M280.4 148.3L96 300.1V464a16 16 0 0 0 16 16l112.1-.3a16 16 0 0 0 15.9-16V368a16 16 0 0 1 16-16h64a16 16 0 0 1 16 16v95.6a16 16 0 0 0 16 16.1L464 480a16 16 0 0 0 16-16V300L295.7 148.3a12.2 12.2 0 0 0 -15.3 0zM571.6 251.5L488 182.6V44.1a12 12 0 0 0 -12-12h-56a12 12 0 0 0 -12 12v72.6L318.5 43a48 48 0 0 0 -61 0L4.3 251.5a12 12 0 0 0 -1.6 16.9l25.5 31A12 12 0 0 0 45.2 301l235.2-193.7a12.2 12.2 0 0 1 15.3 0L530.9 301a12 12 0 0 0 16.9-1.6l25.5-31a12 12 0 0 0 -1.7-16.9z"/></svg>',
		'cube' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M234.5 5.7c13.9-5 29.1-5 43.1 0l192 68.6C495 83.4 512 107.5 512 134.6l0 242.9c0 27-17 51.2-42.5 60.3l-192 68.6c-13.9 5-29.1 5-43.1 0l-192-68.6C17 428.6 0 404.5 0 377.4L0 134.6c0-27 17-51.2 42.5-60.3l192-68.6zM256 66L82.3 128 256 190l173.7-62L256 66zm32 368.6l160-57.1 0-188L288 246.6l0 188z"/></svg>',
		'cog' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M487.4 315.7l-42.6-24.6c4.3-23.2 4.3-47 0-70.2l42.6-24.6c4.9-2.8 7.1-8.6 5.5-14-11.1-35.6-30-67.8-54.7-94.6-3.8-4.1-10-5.1-14.8-2.3L380.8 110c-17.9-15.4-38.5-27.3-60.8-35.1V25.8c0-5.6-3.9-10.5-9.4-11.7-36.7-8.2-74.3-7.8-109.2 0-5.5 1.2-9.4 6.1-9.4 11.7V75c-22.2 7.9-42.8 19.8-60.8 35.1L88.7 85.5c-4.9-2.8-11-1.9-14.8 2.3-24.7 26.7-43.6 58.9-54.7 94.6-1.7 5.4 .6 11.2 5.5 14L67.3 221c-4.3 23.2-4.3 47 0 70.2l-42.6 24.6c-4.9 2.8-7.1 8.6-5.5 14 11.1 35.6 30 67.8 54.7 94.6 3.8 4.1 10 5.1 14.8 2.3l42.6-24.6c17.9 15.4 38.5 27.3 60.8 35.1v49.2c0 5.6 3.9 10.5 9.4 11.7 36.7 8.2 74.3 7.8 109.2 0 5.5-1.2 9.4-6.1 9.4-11.7v-49.2c22.2-7.9 42.8-19.8 60.8-35.1l42.6 24.6c4.9 2.8 11 1.9 14.8-2.3 24.7-26.7 43.6-58.9 54.7-94.6 1.5-5.5-.7-11.3-5.6-14.1zM256 336c-44.1 0-80-35.9-80-80s35.9-80 80-80 80 35.9 80 80-35.9 80-80 80z"/></svg>',
		'star' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"/></svg>',
		'floppy-disk' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M48 96l0 320c0 8.8 7.2 16 16 16l320 0c8.8 0 16-7.2 16-16l0-245.5c0-4.2-1.7-8.3-4.7-11.3l33.9-33.9c12 12 18.7 28.3 18.7 45.3L448 416c0 35.3-28.7 64-64 64L64 480c-35.3 0-64-28.7-64-64L0 96C0 60.7 28.7 32 64 32l245.5 0c17 0 33.3 6.7 45.3 18.7l74.5 74.5-33.9 33.9L320.8 84.7c-.3-.3-.5-.5-.8-.8L320 184c0 13.3-10.7 24-24 24l-192 0c-13.3 0-24-10.7-24-24L80 80 64 80c-8.8 0-16 7.2-16 16zm80-16l0 80 144 0 0-80L128 80zm32 240a64 64 0 1 1 128 0 64 64 0 1 1 -128 0z"/></svg>',
		'5stars' => '<svg xmlns="http://www.w3.org/2000/svg" width="137.09" height="24" viewBox="0 0 137.09 24"><polygon points="12.62 0 16.52 7.9 25.23 9.17 18.93 15.32 20.42 24 12.62 19.9 4.82 24 6.31 15.32 0 9.17 8.72 7.9 12.62 0" fill="#f5c80a"/><polygon points="40.58 0 44.48 7.9 53.2 9.17 46.89 15.32 48.38 24 40.58 19.9 32.78 24 34.27 15.32 27.96 9.17 36.68 7.9 40.58 0" fill="#f5c80a"/><polygon points="68.55 0 72.45 7.9 81.17 9.17 74.86 15.32 76.34 24 68.55 19.9 60.75 24 62.24 15.32 55.93 9.17 64.65 7.9 68.55 0" fill="#f5c80a"/><polygon points="96.51 0 100.41 7.9 109.13 9.17 102.82 15.32 104.31 24 96.51 19.9 88.71 24 90.2 15.32 83.89 9.17 92.61 7.9 96.51 0" fill="#f5c80a"/><polygon points="124.48 0 128.38 7.9 137.09 9.17 130.78 15.32 132.28 24 124.48 19.9 116.68 24 118.17 15.32 111.86 9.17 120.58 7.9 124.48 0" fill="#f5c80a"/></svg>',
		'knowledge-base' => '<svg xmlns="http://www.w3.org/2000/svg" width="38.56" height="48" viewBox="0 0 38.56 48"><path d="M37.11,0H8.93A9,9,0,0,0,0,8.93V39.07A9,9,0,0,0,8.93,48H37.11a1.45,1.45,0,0,0,1.45-1.45V1.45A1.45,1.45,0,0,0,37.11,0Zm.51,46.55a.51.51,0,0,1-.51.51H8.93a8,8,0,0,1-8-7.85H37.62Zm0-8.28H.94V8.93a8,8,0,0,1,8-8H37.11a.51.51,0,0,1,.51.51Zm-20.54-27-.45.09.3,1.38-8.64.81L8.76,22l9.59,6.54,7.87-2.05.13-6.22h0v-.12l4.08-1.21.39-4.31.2-2.08L22.9,10.44ZM9.53,21.53l-.41-7L18,19.23l.05,8.1Zm16-1.71-.13,6L18.8,27.55l-.05-8.2,6.83-.86Zm4.13-1.53-3.34,1V17.86h0L20,15.13l10.14-1.85ZM17.33,14.81l7.08,3-6,.72-8.37-4.44,7.83-.72.81-.09,1.79-.18L22.29,13l.81-.09.34-.25-4.24-.88,3.66-.52,5.93,1.51ZM17.6,12l2.48.52-2.32.22Z"/></svg>',
		'support-center' => '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"><path d="M48,24A23.76,23.76,0,0,0,43.26,9.69a3.85,3.85,0,0,0,.25-1.35,3.78,3.78,0,0,0-5.13-3.55,24,24,0,0,0-28.77,0,3.9,3.9,0,0,0-4,.86A3.78,3.78,0,0,0,4.54,8.34a4,4,0,0,0,.23,1.29,24,24,0,0,0,0,28.75,3.77,3.77,0,0,0,.86,4,3.78,3.78,0,0,0,4,.86,24,24,0,0,0,28.65,0,3.84,3.84,0,0,0,1.38.26,3.79,3.79,0,0,0,3.8-3.8,3.76,3.76,0,0,0-.26-1.38A23.78,23.78,0,0,0,48,24Zm-.94,0a22.79,22.79,0,0,1-4.33,13.42,2.51,2.51,0,0,0-.33-.4L36.18,30.8a3.18,3.18,0,0,0-.79-.57,12.92,12.92,0,0,0,0-12.4,3.92,3.92,0,0,0,.76-.58L42.4,11c.13-.14.24-.29.35-.43A22.82,22.82,0,0,1,47.06,24ZM29.69,33.49a3.59,3.59,0,0,0,.16,1,12.28,12.28,0,0,1-11.65,0,3.85,3.85,0,0,0,.16-1.07,3.77,3.77,0,0,0-4.88-3.62,12,12,0,0,1,0-11.69,3.76,3.76,0,0,0,4.73-4.73,12.31,12.31,0,0,1,11.68,0,3.94,3.94,0,0,0-.17,1.09,3.79,3.79,0,0,0,3.8,3.8,3.85,3.85,0,0,0,1.07-.16,12,12,0,0,1,0,11.68,3.86,3.86,0,0,0-3.72.92A3.78,3.78,0,0,0,29.69,33.49Zm12-27.17a2.86,2.86,0,0,1,0,4l-6.21,6.21a2.92,2.92,0,0,1-4.05,0,2.86,2.86,0,0,1,0-4l6.21-6.21a2.86,2.86,0,0,1,4,0ZM24,.94A22.86,22.86,0,0,1,37.46,5.29a3.83,3.83,0,0,0-.44.36L30.8,11.87a4,4,0,0,0-.56.74,13.26,13.26,0,0,0-12.44,0,3.44,3.44,0,0,0-.55-.72L11,5.65a4.22,4.22,0,0,0-.46-.38A22.89,22.89,0,0,1,24,.94ZM6.32,6.32a2.86,2.86,0,0,1,4,0l6.21,6.21a2.86,2.86,0,0,1,0,4,2.92,2.92,0,0,1-4,0L6.32,10.37a2.86,2.86,0,0,1,0-4ZM.94,24A22.82,22.82,0,0,1,5.27,10.57a5.58,5.58,0,0,0,.38.47l6.22,6.21a3.44,3.44,0,0,0,.72.55,13,13,0,0,0,0,12.44,4,4,0,0,0-.74.56L5.65,37a3.83,3.83,0,0,0-.36.44A22.86,22.86,0,0,1,.94,24ZM6.32,41.73a2.86,2.86,0,0,1,0-4l6.21-6.21a2.86,2.86,0,0,1,4,0,2.86,2.86,0,0,1,0,4.05l-6.21,6.21A2.92,2.92,0,0,1,6.32,41.73ZM24,47.06a22.87,22.87,0,0,1-13.4-4.31A3.65,3.65,0,0,0,11,42.4l6.22-6.21a3.84,3.84,0,0,0,.57-.77,13,13,0,0,0,12.4,0,4,4,0,0,0,.58.79L37,42.4a3,3,0,0,0,.4.33A22.79,22.79,0,0,1,24,47.06Zm17.73-5.33a2.92,2.92,0,0,1-4,0l-6.21-6.21a2.86,2.86,0,1,1,4.05-4.05l6.21,6.21a2.86,2.86,0,0,1,0,4Z"/></svg>',
		'ask-question' => '<svg xmlns="http://www.w3.org/2000/svg" width="49.31" height="47.1" viewBox="0 0 49.31 47.1"><path d="M14.09,17.28a3.47,3.47,0,1,0,3.47,3.47A3.48,3.48,0,0,0,14.09,17.28Zm0,5.84a2.37,2.37,0,1,1,2.37-2.37A2.38,2.38,0,0,1,14.09,23.12Zm21.12-5.84a3.47,3.47,0,1,0,3.47,3.47A3.48,3.48,0,0,0,35.21,17.28Zm0,5.84a2.37,2.37,0,1,1,2.37-2.37A2.38,2.38,0,0,1,35.21,23.12ZM24.65,17.28a3.47,3.47,0,1,0,3.47,3.47A3.48,3.48,0,0,0,24.65,17.28Zm0,5.84A2.37,2.37,0,1,1,27,20.75,2.37,2.37,0,0,1,24.65,23.12ZM37.84,0H11.46A11.47,11.47,0,0,0,0,11.47v34.7A.91.91,0,0,0,.48,47a.92.92,0,0,0,.45.12,1,1,0,0,0,.5-.14L9.6,41.81a5.54,5.54,0,0,1,3-.85H37.84A11.49,11.49,0,0,0,49.31,29.49v-18A11.48,11.48,0,0,0,37.84,0ZM48.21,29.49A10.38,10.38,0,0,1,37.84,39.86H12.56a6.66,6.66,0,0,0-3.55,1l-7.91,5V11.47A10.38,10.38,0,0,1,11.46,1.1H37.84A10.38,10.38,0,0,1,48.21,11.47Z"/></svg>',
		'search' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M24,22.6l-7.09-7.09a9.42,9.42,0,0,0,2.15-6,9.55,9.55,0,1,0-3.29,7.17l7.07,7.08A.82.82,0,0,0,24,22.6ZM1.64,9.51a7.87,7.87,0,1,1,7.87,7.87A7.88,7.88,0,0,1,1.64,9.51Z" fill="#000"/></svg>',
		'trash-can' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0L284.2 0c12.1 0 23.2 6.8 28.6 17.7L320 32l96 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 96C14.3 96 0 81.7 0 64S14.3 32 32 32l96 0 7.2-14.3zM32 128l384 0 0 320c0 35.3-28.7 64-64 64L96 512c-35.3 0-64-28.7-64-64l0-320zm96 64c-8.8 0-16 7.2-16 16l0 224c0 8.8 7.2 16 16 16s16-7.2 16-16l0-224c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16l0 224c0 8.8 7.2 16 16 16s16-7.2 16-16l0-224c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16l0 224c0 8.8 7.2 16 16 16s16-7.2 16-16l0-224c0-8.8-7.2-16-16-16z"/></svg>',
		'mailchimp' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path d="M427 307.5C430.1 307.1 433.2 307.1 436.3 307.5C438 303.7 438.3 297.1 436.8 289.9C434.6 279.2 431.5 272.8 425.3 273.8C419.1 274.8 418.8 282.5 421.1 293.2C422.4 299.2 424.6 304.3 427.1 307.5L427.1 307.5zM373.4 316C377.9 318 380.6 319.3 381.7 318.1C383.6 316.2 378.2 308.7 369.6 305C364.6 302.9 359.2 302.2 353.8 302.8C348.4 303.4 343.3 305.5 339 308.6C336 310.8 333.2 313.8 333.6 315.7C334.5 319.4 343.6 313 356.2 312.2C363.2 311.8 369 314 373.5 315.9L373.5 315.9zM364.4 321.1C355.3 322.5 349.4 327.6 350.9 331.2C351.8 331.5 352.1 332 356.1 330.4C362.1 328.1 368.5 327.5 374.8 328.5C377.7 328.8 379.1 329 379.7 328C381.2 325.8 374 320 364.3 321.1L364.3 321.1zM418.6 338.2C422 331.3 407.7 324.3 404.3 331.2C400.9 338.1 415.2 345.1 418.6 338.2L418.6 338.2zM434.3 317.7C426.6 317.6 426.3 333.5 434 333.6C441.7 333.7 442 317.8 434.3 317.6L434.3 317.6zM215.5 396.7C214.2 397 209.5 398.2 207 394.4C201.8 386.4 218.1 374 210 358.6C200.9 341.1 182.2 345.1 175 353.1C166.3 362.7 166.3 376.6 170 377.2C174.3 377.8 174.1 370.7 177.4 365.6C178.3 364.2 179.5 363 180.9 362C182.3 361 183.9 360.4 185.5 360C187.1 359.6 188.9 359.6 190.5 360C192.1 360.4 193.8 361 195.2 361.9C206.8 369.5 196.6 379.7 197.5 390.5C198.9 407.2 215.9 406.9 219.1 399.5C219.3 399.1 219.4 398.7 219.4 398.3C219.4 397.9 219.2 397.5 218.9 397.2C218.9 398.1 219.6 395.9 215.5 396.8L215.5 396.8zM515.2 379.6C511.9 367.9 512.6 370.4 508.4 359.1C510.8 355.4 523.7 335.1 505.3 315.8C494.9 304.9 471.4 299.3 464.2 297.3C462.7 285.9 468.8 238.6 442.7 214.3C463.5 192.7 476.5 169 476.4 148.6C476.3 109.4 428.2 97.6 369 122.1L356.5 127.4C356.4 127.4 333.8 105.1 333.4 104.8C265.9 45.9 54.6 280.7 122.1 337.7L136.9 350.2C132.9 360.9 131.5 372.4 132.8 383.7C136.2 417.1 168.8 444.1 200.3 444.1C258 577.2 468.2 577.4 522.6 447.1C524.3 442.6 531.7 422.5 531.7 404.7C531.7 386.9 521.6 379.4 515.2 379.4L515.2 379.4zM199.2 427.8C176.4 427.2 151.7 406.7 149.3 382.3C143.1 321 223.6 307 233.3 370C237.8 399.6 228.6 428.5 199.2 427.8L199.2 427.8zM180.7 313.6C165.5 316.6 152.2 325.1 144 337.1C139.1 333 130 325.1 128.4 322.1C115.4 297.3 142.6 249.1 161.7 221.9C208.8 154.7 282.6 103.8 316.7 113C322.2 114.6 340.6 135.9 340.6 135.9C340.6 135.9 306.5 154.8 274.8 181.2C232.2 214 200 261.7 180.7 313.6zM419.6 414.7C419.6 414.7 383.9 420 350.1 407.6C356.3 387.4 377.1 413.7 446.5 393.8C461.8 389.4 481.9 380.8 497.5 368.4C500.9 376.2 503.3 384.3 504.6 392.7C508.3 392 518.8 392.2 516 410.8C512.7 430.7 504.3 446.8 490.1 461.6C481.2 471.2 470.7 479.1 458.9 484.9C452.4 488.3 445.6 491.2 438.6 493.5C385.1 511 330.3 491.8 312.6 450.5C311.2 447.4 310 444.1 309 440.8C301.5 413.6 307.9 381 327.8 360.4C329 359.1 330.3 357.5 330.3 355.6C330.1 353.9 329.5 352.3 328.4 351.1C321.4 341 297.2 323.7 302.1 290.3C305.6 266.3 326.6 249.4 346.2 250.4L351.2 250.7C359.7 251.2 367.1 252.3 374.1 252.6C385.8 253.1 396.3 251.4 408.7 241C412.9 237.5 416.3 234.5 422 233.5C424.3 232.9 426.7 232.8 429 233.2C431.3 233.6 433.6 234.4 435.6 235.7C445.6 242.3 447 258.4 447.5 270.2C447.8 276.9 448.6 293.2 448.9 297.8C449.5 308.5 452.3 310 458 311.8C461.2 312.8 464.2 313.6 468.5 314.9C481.7 318.6 489.5 322.4 494.5 327.2C497 329.7 498.7 333 499.2 336.5C500.8 347.9 490.4 361.9 462.9 374.7C416.2 396.4 369.2 389.1 362.4 388.4C342.2 385.7 330.8 411.7 342.9 429.5C365.5 462.9 465.3 449.5 494.3 408.1C495 407.1 494.4 406.5 493.6 407.1C451.8 435.7 396.5 445.3 365.1 433.1C360.3 431.3 350.4 426.7 349.2 416.4C392.8 429.9 420.2 417.1 420.2 417.1C420.2 417.1 422.2 414.3 419.6 414.6zM267.7 221.5C284.4 202.1 305.1 185.3 323.5 175.9C323.6 175.8 323.8 175.8 324 175.8C324.2 175.8 324.3 175.9 324.4 176C324.5 176.1 324.6 176.3 324.6 176.4C324.6 176.5 324.6 176.7 324.5 176.9C323 179.6 320.2 185.2 319.3 189.6C319.3 189.7 319.3 189.9 319.3 190C319.3 190.1 319.5 190.3 319.6 190.4C319.7 190.5 319.9 190.5 320 190.5C320.1 190.5 320.3 190.5 320.4 190.4C331.9 182.6 351.9 174.2 369.4 173.1C369.6 173.1 369.7 173.1 369.9 173.2C370.1 173.3 370.1 173.4 370.2 173.6C370.3 173.8 370.3 173.9 370.2 174.1C370.1 174.3 370.1 174.4 369.9 174.5C367 176.7 364.4 179.3 362.2 182.2C362.1 182.3 362.1 182.4 362.1 182.6C362.1 182.8 362.1 182.9 362.2 183C362.3 183.1 362.4 183.2 362.5 183.3C362.6 183.4 362.7 183.4 362.9 183.4C375.2 183.5 392.6 187.8 403.9 194.1C404.7 194.5 404.1 196 403.3 195.8C333.8 179.9 280.2 214.3 268.8 222.6C268.6 222.7 268.5 222.7 268.3 222.7C268.1 222.7 268 222.6 267.8 222.5C267.6 222.4 267.6 222.2 267.6 222C267.6 221.8 267.7 221.6 267.8 221.5L267.7 221.5z"/></svg>',
	);
}

/**
 * Get the SVG Icon by its ID.
 *
 * @since 1.0.0
 * @param string $id The icon ID
 * @return string The selected icon
 */
function zyre_get_svg_icon( $icon_id ) {
	if ( empty( $icon_id ) && ! isset( $icons[ $icon_id ] ) ) {
		return;
	}

	$icons = zyre_get_svg_icons();

	return $icons[ $icon_id ];
}

/**
 * Get the base64 zyre icon which is converted from svg.
 *
 * @since 1.0.0
 * @return string Base64 code of zyre icon
 */
function zyre_get_b64_icon() {
	return 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz48c3ZnIGlkPSJhIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGZpbGw9IiNkZGRkZGQiIHdpZHRoPSIyMDAiIGhlaWdodD0iMjQwIiB2aWV3Qm94PSIwIDAgMjAwIDI0MCI+PHBhdGggZD0ibTEyOC4zNyw2My4zOWwtLjEtLjAyLTUwLjksNy4xMy00LjI5LDEuMDIsMi41NSwxMS44TC40Nyw5MC4zNGw0LjEyLDc0LjIxLDgzLjU3LDU2Ljk2LjE5LjEzLDY5LjItMTguMDEsMS4yMS01NC4wN2guMDl2LTFsMzUuNDQtMTAuNjMsMy40OC0zNy44MywxLjc3LTE4LjQ2LTcxLjE2LTE4LjI1Wm0yOS42OSw2NC41N2wtNTMuMTUtMjMuMDgsODYuMDMtMTUuNTMtMy45Niw0Mi41OS0yOC4xNCw4LjQ0di0xMi4zNGwtLjc4LS4xWm0tNjUuNDYsMTMuODlsNTguNDItNy4yOHYxMS4wMmwtMS4xNiw1MS45Ni01Ni45LDE0LjgxLS4zNi03MC41Wm0tNy40OC01MS42Mmw0NS4wOS00LjU3LDMuNzUtMy4wMy0zNS4xLTcuMjYsMjguOTctNC4wNSw0OS4xNiwxMi42MS05OS4wMSwxNy44Nyw2MS40NCwyNi40NS00OS45OSw2LjEyTDE4LjI5LDk2LjUzbDY2LjI4LTYuMi41NS0uMDloMFptMTUuMTEtNy45OGwtMTYuNDgsMS42Mi0xLjE0LTUuMjYsMTcuNjEsMy42NFptLTE1LjEsMTI3LjczTDEyLjE4LDE2MC4yNmwtMy4zMy01OS44OSw3NS45Miw0MC4zOS4zNSw2OS4yMloiIHN0cm9rZS13aWR0aD0iMCIvPjwvc3ZnPg==';
}

/**
 * Get the base64 zyre circle icon which is converted from svg.
 *
 * @since 1.0.0
 * @return string Base64 code of zyre circle icon
 */
function zyre_get_b64_icon_circle() {
	return 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA5MCA5MCI+PGRlZnM+PHN0eWxlPi5jbHMtMXtmaWxsOiNmZmY7fTwvc3R5bGU+PC9kZWZzPjxnIGlkPSJMYXllcl8yIiBkYXRhLW5hbWU9IkxheWVyIDIiPjxnIGlkPSJXb3JrcyI+PHBvbHlnb24gY2xhc3M9ImNscy0xIiBwb2ludHM9IjUxLjM2IDMxLjY1IDQ2LjE0IDMyLjM0IDIwLjQgMzUuMjggNDEuMDEgNDcuNTIgNTYuOSA0NC43IDQwLjAzIDM3LjEzIDY3LjI1IDMxLjYgNTIuOCAyNy42NyA0My40NSAyOS4wOSA1MS4zNiAzMS42NSIvPjxwYXRoIGNsYXNzPSJjbHMtMSIgZD0iTTQ1LDBBNDUsNDUsMCwxLDAsOTAsNDUsNDUsNDUsMCwwLDAsNDUsMFpNNzMuNTQsMzMuMTJsLTEsMTEuMUw2MS4yNiw0Ny41OWwtLjM4LDE3LjMyLTIwLjM3LDUuM2gwTDE1LjA4LDUyLjg3bC0uODQtMTUuMTgtLjM2LTYuNDFMMzcuNzcsMjlsLS44NC0zLjkuMDgsMGgwbDE1Ljc4LTIuMjJMNzQsMjguMzVaIi8+PC9nPjwvZz48L3N2Zz4=';
}

/**
 * Get the base64 zyre 3d icon which is converted from svg.
 *
 * @since 1.0.0
 * @return string Base64 code of zyre 3d icon
 */
function zyre_get_b64_3dicon() {
	return 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2aWV3Qm94PSIwIDAgODMuNDIgNjYuOTkiPjxkZWZzPjxzdHlsZT4uY2xzLTF7aXNvbGF0aW9uOmlzb2xhdGU7fS5jbHMtMTMsLmNscy0yLC5jbHMtMjR7bWl4LWJsZW5kLW1vZGU6bXVsdGlwbHk7fS5jbHMtMntvcGFjaXR5OjAuNDt9LmNscy0ze2ZpbGw6I2I3NWUxNTt9LmNscy00e2ZpbGw6IzgxM2IxNTt9LmNscy01e2ZpbGw6IzQyMDAwMDt9LmNscy02e2ZpbGw6dXJsKCNyYWRpYWwtZ3JhZGllbnQpO30uY2xzLTd7ZmlsbDp1cmwoI3JhZGlhbC1ncmFkaWVudC0yKTt9LmNscy04e2ZpbGw6dXJsKCNyYWRpYWwtZ3JhZGllbnQtMyk7fS5jbHMtOXtmaWxsOnVybCgjcmFkaWFsLWdyYWRpZW50LTQpO30uY2xzLTEwe2ZpbGw6Izg0MmYwZjt9LmNscy0xMXtmaWxsOnVybCgjcmFkaWFsLWdyYWRpZW50LTUpO30uY2xzLTEye2ZpbGw6dXJsKCNyYWRpYWwtZ3JhZGllbnQtNik7fS5jbHMtMTMsLmNscy0yNHtvcGFjaXR5OjAuNDU7fS5jbHMtMTN7ZmlsbDp1cmwoI2xpbmVhci1ncmFkaWVudCk7fS5jbHMtMTR7ZmlsbDp1cmwoI3JhZGlhbC1ncmFkaWVudC03KTt9LmNscy0xNXtmaWxsOnVybCgjcmFkaWFsLWdyYWRpZW50LTgpO30uY2xzLTE2e2ZpbGw6dXJsKCNyYWRpYWwtZ3JhZGllbnQtOSk7fS5jbHMtMTd7ZmlsbDojZjViNDAwO30uY2xzLTE4e2ZpbGw6dXJsKCNyYWRpYWwtZ3JhZGllbnQtMTApO30uY2xzLTE5e2ZpbGw6dXJsKCNyYWRpYWwtZ3JhZGllbnQtMTEpO30uY2xzLTIwe2ZpbGw6dXJsKCNyYWRpYWwtZ3JhZGllbnQtMTIpO30uY2xzLTIxe2ZpbGw6dXJsKCNyYWRpYWwtZ3JhZGllbnQtMTMpO30uY2xzLTIye2ZpbGw6dXJsKCNyYWRpYWwtZ3JhZGllbnQtMTQpO30uY2xzLTIze2ZpbGw6I2NjNmQxNTt9LmNscy0yNHtmaWxsOiNiNzRhMDA7fTwvc3R5bGU+PHJhZGlhbEdyYWRpZW50IGlkPSJyYWRpYWwtZ3JhZGllbnQiIGN4PSIwLjYzIiBjeT0iMjUuMDEiIHI9IjM2LjY2IiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHN0b3Agb2Zmc2V0PSIwIiBzdG9wLWNvbG9yPSIjZTk5NzAwIi8+PHN0b3Agb2Zmc2V0PSIxIiBzdG9wLWNvbG9yPSIjY2M2ZDE1Ii8+PC9yYWRpYWxHcmFkaWVudD48cmFkaWFsR3JhZGllbnQgaWQ9InJhZGlhbC1ncmFkaWVudC0yIiBjeD0iMzUuNjIiIGN5PSI1MC4xOSIgcj0iMjYuNjQiIGdyYWRpZW50VHJhbnNmb3JtPSJ0cmFuc2xhdGUoMS4yMyAwLjc0KSIgZ3JhZGllbnRVbml0cz0idXNlclNwYWNlT25Vc2UiPjxzdG9wIG9mZnNldD0iMCIgc3RvcC1jb2xvcj0iI2VmOWUwMCIvPjxzdG9wIG9mZnNldD0iMSIgc3RvcC1jb2xvcj0iI2RkOGEyNSIvPjwvcmFkaWFsR3JhZGllbnQ+PHJhZGlhbEdyYWRpZW50IGlkPSJyYWRpYWwtZ3JhZGllbnQtMyIgY3g9IjgwLjMyIiBjeT0iMjEuMjQiIHI9IjI0LjgiIGdyYWRpZW50VHJhbnNmb3JtPSJ0cmFuc2xhdGUoMS4yMyAwLjc0KSIgZ3JhZGllbnRVbml0cz0idXNlclNwYWNlT25Vc2UiPjxzdG9wIG9mZnNldD0iMCIgc3RvcC1jb2xvcj0iI2I5NTExOCIvPjxzdG9wIG9mZnNldD0iMSIgc3RvcC1jb2xvcj0iI2E2NDEzMSIvPjwvcmFkaWFsR3JhZGllbnQ+PHJhZGlhbEdyYWRpZW50IGlkPSJyYWRpYWwtZ3JhZGllbnQtNCIgY3g9IjM0LjQ3IiBjeT0iMy40NSIgcj0iNi4wMSIgZ3JhZGllbnRUcmFuc2Zvcm09InRyYW5zbGF0ZSgxLjIzIDAuNzQpIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHN0b3Agb2Zmc2V0PSIwIiBzdG9wLWNvbG9yPSIjYzg1ZDE4Ii8+PHN0b3Agb2Zmc2V0PSIxIiBzdG9wLWNvbG9yPSIjOTY0MzI4Ii8+PC9yYWRpYWxHcmFkaWVudD48cmFkaWFsR3JhZGllbnQgaWQ9InJhZGlhbC1ncmFkaWVudC01IiBjeD0iMC42MyIgY3k9IjI1LjAxIiByPSIzNi42NiIgZ3JhZGllbnRVbml0cz0idXNlclNwYWNlT25Vc2UiPjxzdG9wIG9mZnNldD0iMCIgc3RvcC1jb2xvcj0iI2Y0YTUwMCIvPjxzdG9wIG9mZnNldD0iMSIgc3RvcC1jb2xvcj0iI2QzN2YwMCIvPjwvcmFkaWFsR3JhZGllbnQ+PHJhZGlhbEdyYWRpZW50IGlkPSJyYWRpYWwtZ3JhZGllbnQtNiIgY3g9IjgwLjkiIGN5PSI3LjMxIiByPSIzNi41OSIgZ3JhZGllbnRUcmFuc2Zvcm09InRyYW5zbGF0ZSgxLjIzIDAuNzQpIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHN0b3Agb2Zmc2V0PSIwIiBzdG9wLWNvbG9yPSIjZDU3MTE1Ii8+PHN0b3Agb2Zmc2V0PSIxIiBzdG9wLWNvbG9yPSIjYjA1NzE4Ii8+PC9yYWRpYWxHcmFkaWVudD48bGluZWFyR3JhZGllbnQgaWQ9ImxpbmVhci1ncmFkaWVudCIgeDE9IjU3Ljc2IiB5MT0iMjkuNDEiIHgyPSI2NS43NSIgeTI9IjEzLjY4IiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHN0b3Agb2Zmc2V0PSIwLjQ2IiBzdG9wLWNvbG9yPSIjNjYzNTAwIi8+PHN0b3Agb2Zmc2V0PSIwLjQ3IiBzdG9wLWNvbG9yPSIjNzQzYjAwIiBzdG9wLW9wYWNpdHk9IjAuOSIvPjxzdG9wIG9mZnNldD0iMC41NCIgc3RvcC1jb2xvcj0iI2QxNjAwMSIgc3RvcC1vcGFjaXR5PSIwLjI1Ii8+PHN0b3Agb2Zmc2V0PSIwLjU3IiBzdG9wLWNvbG9yPSIjZjU2ZTAyIiBzdG9wLW9wYWNpdHk9IjAiLz48L2xpbmVhckdyYWRpZW50PjxyYWRpYWxHcmFkaWVudCBpZD0icmFkaWFsLWdyYWRpZW50LTciIGN4PSIzNS4zMiIgY3k9IjMyLjIyIiByPSIzMC4zMyIgZ3JhZGllbnRUcmFuc2Zvcm09InRyYW5zbGF0ZSgxLjIzIDAuNzQpIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHN0b3Agb2Zmc2V0PSIwIiBzdG9wLWNvbG9yPSIjZjZiMTAwIi8+PHN0b3Agb2Zmc2V0PSIxIiBzdG9wLWNvbG9yPSIjZWY5ZTAwIi8+PC9yYWRpYWxHcmFkaWVudD48cmFkaWFsR3JhZGllbnQgaWQ9InJhZGlhbC1ncmFkaWVudC04IiBjeD0iNDUuODciIGN5PSIxMy44MSIgcj0iNDguNDUiIGdyYWRpZW50VHJhbnNmb3JtPSJ0cmFuc2xhdGUoMS4yMyAwLjc0KSIgZ3JhZGllbnRVbml0cz0idXNlclNwYWNlT25Vc2UiPjxzdG9wIG9mZnNldD0iMCIgc3RvcC1jb2xvcj0iI2ZmZTAwMCIvPjxzdG9wIG9mZnNldD0iMSIgc3RvcC1jb2xvcj0iI2Y1YmIwMiIvPjwvcmFkaWFsR3JhZGllbnQ+PHJhZGlhbEdyYWRpZW50IGlkPSJyYWRpYWwtZ3JhZGllbnQtOSIgY3g9IjE4MDAuOTkiIGN5PSIxMDY4IiByPSIxNi4yOSIgZ3JhZGllbnRUcmFuc2Zvcm09InRyYW5zbGF0ZSgtMzAwNS4zNyAtMTgxMS4yNykgc2NhbGUoMS43MSkiIGdyYWRpZW50VW5pdHM9InVzZXJTcGFjZU9uVXNlIj48c3RvcCBvZmZzZXQ9IjAiIHN0b3AtY29sb3I9IiNmZmY1NzgiLz48c3RvcCBvZmZzZXQ9IjEiIHN0b3AtY29sb3I9IiNmNWI1MDAiLz48L3JhZGlhbEdyYWRpZW50PjxyYWRpYWxHcmFkaWVudCBpZD0icmFkaWFsLWdyYWRpZW50LTEwIiBjeD0iMzUuMzQiIGN5PSI0MC44OSIgcj0iMTcuODYiIGdyYWRpZW50VHJhbnNmb3JtPSJ0cmFuc2xhdGUoMS4yMyAwLjc0KSIgZ3JhZGllbnRVbml0cz0idXNlclNwYWNlT25Vc2UiPjxzdG9wIG9mZnNldD0iMCIgc3RvcC1jb2xvcj0iI2ZmY2QzYSIvPjxzdG9wIG9mZnNldD0iMSIgc3RvcC1jb2xvcj0iI2VjYTYxNSIvPjwvcmFkaWFsR3JhZGllbnQ+PHJhZGlhbEdyYWRpZW50IGlkPSJyYWRpYWwtZ3JhZGllbnQtMTEiIGN4PSIxNzYyLjA4IiBjeT0iMTA3OS43NSIgcj0iOC4wNCIgZ3JhZGllbnRUcmFuc2Zvcm09InRyYW5zbGF0ZSgtMzAwNS4zNyAtMTgxMS4yNykgc2NhbGUoMS43MSkiIGdyYWRpZW50VW5pdHM9InVzZXJTcGFjZU9uVXNlIj48c3RvcCBvZmZzZXQ9IjAiIHN0b3AtY29sb3I9IiM5YTRkMDAiLz48c3RvcCBvZmZzZXQ9IjAuNjEiIHN0b3AtY29sb3I9IiNhNDU3MDAiLz48c3RvcCBvZmZzZXQ9IjAuODEiIHN0b3AtY29sb3I9IiNhZTVlMDAiLz48c3RvcCBvZmZzZXQ9IjEiIHN0b3AtY29sb3I9IiNiZDY4MDAiLz48L3JhZGlhbEdyYWRpZW50PjxyYWRpYWxHcmFkaWVudCBpZD0icmFkaWFsLWdyYWRpZW50LTEyIiBjeD0iMTc5OS44NiIgY3k9IjEwOTAuOCIgcj0iOS43NCIgZ3JhZGllbnRUcmFuc2Zvcm09InRyYW5zbGF0ZSgtMzAwNS4zNyAtMTgxMS4yNykgc2NhbGUoMS43MSkiIGdyYWRpZW50VW5pdHM9InVzZXJTcGFjZU9uVXNlIj48c3RvcCBvZmZzZXQ9IjAiIHN0b3AtY29sb3I9IiNjMzVmMTYiLz48c3RvcCBvZmZzZXQ9IjAuNTIiIHN0b3AtY29sb3I9IiNkMjc0MDAiLz48c3RvcCBvZmZzZXQ9IjAuNzEiIHN0b3AtY29sb3I9IiNkYTdlMDAiLz48c3RvcCBvZmZzZXQ9IjEiIHN0b3AtY29sb3I9IiNlZDk4MDAiLz48L3JhZGlhbEdyYWRpZW50PjxyYWRpYWxHcmFkaWVudCBpZD0icmFkaWFsLWdyYWRpZW50LTEzIiBjeD0iMTgwOS4zNyIgY3k9IjEwNzYuNjIiIHI9IjguNCIgZ3JhZGllbnRUcmFuc2Zvcm09InRyYW5zbGF0ZSgtMzAwNS4zNyAtMTgxMS4yNykgc2NhbGUoMS43MSkiIGdyYWRpZW50VW5pdHM9InVzZXJTcGFjZU9uVXNlIj48c3RvcCBvZmZzZXQ9IjAiIHN0b3AtY29sb3I9IiM3OTI2MDAiLz48c3RvcCBvZmZzZXQ9IjAuNjEiIHN0b3AtY29sb3I9IiM3ZjNhMDAiLz48c3RvcCBvZmZzZXQ9IjAuNzUiIHN0b3AtY29sb3I9IiM4OTNmMDAiLz48c3RvcCBvZmZzZXQ9IjAuOTgiIHN0b3AtY29sb3I9IiNhNTRkMDAiLz48c3RvcCBvZmZzZXQ9IjEiIHN0b3AtY29sb3I9IiNhODRlMDAiLz48L3JhZGlhbEdyYWRpZW50PjxyYWRpYWxHcmFkaWVudCBpZD0icmFkaWFsLWdyYWRpZW50LTE0IiBjeD0iMTc4Mi43MSIgY3k9IjEwODEuMDIiIHI9IjIwLjYiIGdyYWRpZW50VHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTMwMDUuMzcgLTE4MTEuMjcpIHNjYWxlKDEuNzEpIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHN0b3Agb2Zmc2V0PSIwIiBzdG9wLWNvbG9yPSIjZmZmNTc4Ii8+PHN0b3Agb2Zmc2V0PSIxIiBzdG9wLWNvbG9yPSIjZmZjNjJjIi8+PC9yYWRpYWxHcmFkaWVudD48L2RlZnM+PGcgY2xhc3M9ImNscy0xIj48ZyBpZD0iTGF5ZXJfMiIgZGF0YS1uYW1lPSJMYXllciAyIj48ZyBpZD0iV29ya3MiPjxnIGNsYXNzPSJjbHMtMiI+PHBvbHlnb24gcG9pbnRzPSI4Mi42NiAxNS43OSA0MC43MiAyNi4zOCA1Ni4yNiAzNi41MiAzNi41NiA0MC4xOSAzNi41NiA0MC4wNCAwLjU3IDIxLjk1IDEuNzQgNDIuOTggMzYuOTggNjYuOTkgMzYuOTggNjYuOTcgNjUuMTkgNTkuNjMgNjUuNzMgMzUuNzkgODEuMjUgMzEuMTQgODIuNjYgMTUuNzkiLz48L2c+PHBvbHlnb24gY2xhc3M9ImNscy0zIiBwb2ludHM9IjY1Ljc1IDM0LjE2IDM2LjU2IDM5LjYgMzYuOTggNjYuMzggNjUuMTkgNTkuMDMgNjUuNzUgMzQuMTYiLz48cG9seWdvbiBjbGFzcz0iY2xzLTQiIHBvaW50cz0iMzYuNTYgMzkuNDQgMC41NyAyMS4zNiAxLjc0IDQyLjM5IDM2Ljk4IDY2LjQgMzYuNTYgMzkuNDQiLz48cG9seWdvbiBjbGFzcz0iY2xzLTUiIHBvaW50cz0iNDAuNzIgMjUuNzkgNTguNDggMzcuMzcgODEuMjUgMzAuNTQgODIuNjYgMTUuMiA0MC43MiAyNS43OSIvPjxwb2x5Z29uIGNsYXNzPSJjbHMtNiIgcG9pbnRzPSIzNi41NiAzOC43NyAwLjU3IDIwLjY5IDEuNzQgNDEuNzIgMzYuOTggNjUuNzMgMzYuNTYgMzguNzciLz48cG9seWdvbiBjbGFzcz0iY2xzLTciIHBvaW50cz0iNjUuNzUgMzMuNTEgMzYuNTYgMzguOTUgMzYuOTggNjUuNzMgNjUuMTkgNTguMzkgNjUuNzUgMzMuNTEiLz48cG9seWdvbiBjbGFzcz0iY2xzLTgiIHBvaW50cz0iNDAuNzIgMjQuOTYgNTguNTEgMzYuNTcgODEuMzIgMjkuNzMgODIuNzMgMTQuMzUgNDAuNzIgMjQuOTYiLz48cG9seWdvbiBjbGFzcz0iY2xzLTkiIHBvaW50cz0iMzIuMDcgMy4yOCAzMy42IDkuNjUgMzcuNjMgMTEuMyA0NS44OSA3LjUxIDMyLjA3IDMuMjgiLz48cG9seWdvbiBjbGFzcz0iY2xzLTEwIiBwb2ludHM9IjMyLjEyIDMuMjcgMzMuODEgOS42MSAzMy40IDkuNzEgMzIuMDEgMy4zIDMyLjEyIDMuMjcgMzIuMTIgMy4yNyIvPjxwb2x5Z29uIGNsYXNzPSJjbHMtMTEiIHBvaW50cz0iMzYuNDcgMzMuMDYgMzYuNzkgNTMuODIgMS4wNiAyOS40OCAwLjA4IDExLjggMzYuNDcgMzMuMDYiLz48cG9seWdvbiBjbGFzcz0iY2xzLTEyIiBwb2ludHM9IjQwLjMzIDE2LjM2IDUyLjcgMjkuMjggODIuMTUgMjAuNDQgODMuMzYgNy43OCA4Mi45MSA3Ljg0IDQwLjMzIDE2LjM2Ii8+PHBvbHlnb24gY2xhc3M9ImNscy0xMyIgcG9pbnRzPSI4Mi43MyAxNC4zNSA4My4zNiA3Ljc4IDgyLjU0IDcuOTEgNDAuMzMgMTYuMzYgNDcuMDMgMjMuMzYgNDAuNzIgMjQuOTYgNDEuNjMgMjUuNTUgNDAuNzIgMjUuNzkgNTguNDggMzcuMzcgODEuMjUgMzAuNTQgODIuNjYgMTUuMiA4Mi42NSAxNS4yIDgyLjczIDE0LjM1IDgyLjczIDE0LjM1Ii8+PHBvbHlnb24gY2xhc3M9ImNscy0xNCIgcG9pbnRzPSI2NS40NiA0Ni4zNiAzNi43OSA1My44MiAzNi40NyAzMy4wNiA2NS44NyAyNy44NiA2NS40NiA0Ni4zNiIvPjxwb2x5Z29uIGNsYXNzPSJjbHMtMTUiIHBvaW50cz0iNDAuMzMgMTYuMzYgODMuMzEgNy43OCA4My4zNiA3Ljc0IDUzLjk5IDAuMjEgMzIuMDcgMy4yOCA0NS44OSA3LjUxIDAuMDggMTEuOCAzNi40NyAzMy4wNiA2NS44NyAyNy44NiA0MC4zMyAxNi4zNiIvPjxwYXRoIGNsYXNzPSJjbHMtMTYiIGQ9Ik04My4zNyw3Ljc4Yy4yLS4yNy00My42LDguNDUtNDMuNjIsOC4zN2EuMjEuMjEsMCwwLDAsMCwuNEw2NS44NiwyNy45Yy4yNy0uMS0yMS4xMi05LjcxLTI0Ljg4LTExLjQ2WiIvPjxwYXRoIGNsYXNzPSJjbHMtMTciIGQ9Ik00Ni44OCw3LjMxLDMyLjA4LDMuMjRjLS4yNy4xMyw5LjcsMy4xNywxMi44Miw0LjE2QzM4LjMxLDguMDYsMCwxMS42OSwwLDExLjhzNDYuNzUtNC4xMiw0Ni44LTQuMDhBLjIxLjIxLDAsMCwwLDQ2Ljg4LDcuMzFaIi8+PHBhdGggY2xhc3M9ImNscy0xNyIgZD0iTTgzLjM5LDcuNjZDODMuMzEsNy42Nyw1NCwwLDU0LDBMMzIuMDUsMy4yYy0uMTEsMC0uMDguMTksMCwuMTdMNTQsLjU5Yy0uMzUsMCwyOS4zNiw3LjIzLDI5LjM1LDcuMjRhLjExLjExLDAsMCwwLC4wOC0uMDhBLjExLjExLDAsMCwwLDgzLjM5LDcuNjZaIi8+PHBhdGggY2xhc3M9ImNscy0xOCIgZD0iTTM2LjU3LDMzLjA2Yy4zNCwxMC44OS42NywyMS43OC41MSwzMi42N2gtLjJjLS4yNy01LjQ1LS4zOC0xMC44OS0uNDMtMTYuMzRzLS4xMS0xMC44OS0uMDktMTYuMzRaIi8+PHBhdGggY2xhc3M9ImNscy0xOSIgZD0iTTEuNzQsNDIuMzlDMSwzMi40My40MywyMS43OCwwLDExLjhILjEzYy41MSw3LjQ3LDEsMTUsMS4zNywyMi40My4xMywyLjQ5LjI1LDUsLjMyLDcuNDhsLS4wOC42OFoiLz48cGF0aCBjbGFzcz0iY2xzLTIwIiBkPSJNNjUuMTIsNTguMzljMC0xMC4xOC4zMy0yMC4zNi42OC0zMC41M0g2NmMwLDUuMDktLjE0LDEwLjE4LS4yMiwxNS4yN3MtLjIyLDEwLjE4LS40NiwxNS4yNloiLz48cGF0aCBjbGFzcz0iY2xzLTIxIiBkPSJNODEuMTcsMzAuNTZjLjIxLTMuNjguNjItOC4xOCwxLTExLjg0cy43LTcuMjYsMS4xNC0xMC45MWwuMTQtLjA2Yy0uMjQsMy42Ny0uNTQsNy4zNC0uODcsMTFzLS44LDguMTMtMS4yOCwxMS43OGwtLjEsMFoiLz48cGF0aCBjbGFzcz0iY2xzLTIyIiBkPSJNLjEzLDExLjhjLS4wOCwwLDM3LjIxLDIxLDM2LjM5LDIwLjczbDI5LjM0LTQuNzQsMCwuMTRMMzYuNDIsMzMuMzZDMzYuMzksMzMuMjEtLjIsMTIsLjEzLDExLjhaIi8+PHBvbHlnb24gY2xhc3M9ImNscy0yMyIgcG9pbnRzPSIwLjEzIDExLjggMC41NCAxMi4xMyAyLjI4IDQyLjA4IDEuODEgNDEuNzggMC4xMyAxMS44Ii8+PHBhdGggY2xhc3M9ImNscy0yNCIgZD0iTTgzLjI4LDcuODEsODIuMSwxOS4xNWwtLjg5LDEwLjYxLS4zLjA4LjgyLTEwLjYzTDgzLDcuODVBLjgzLjgzLDAsMCwxLDgzLjI4LDcuODFaIi8+PC9nPjwvZz48L2c+PC9zdmc+';
}

/**
 * Get the base64 zyre 3d white icon which is converted from svg.
 *
 * @since 1.0.0
 * @return string Base64 code of zyre 3d white icon
 */
function zyre_get_b64_3dicon_white() {
	return 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDI4LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPgo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9ImEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IgoJIHdpZHRoPSIyMDBweCIgaGVpZ2h0PSIxNzcuOXB4IiB2aWV3Qm94PSIwIDAgMjAwIDE3Ny45IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCAyMDAgMTc3Ljk7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPHN0eWxlIHR5cGU9InRleHQvY3NzIj4KCS5zdDB7ZmlsbDojRkZGRkZGO30KPC9zdHlsZT4KPHBhdGggY2xhc3M9InN0MCIgZD0iTTEyOC40LDBMNzcuNCwxMS40djE5LjJMMCw0MS40djcxLjVsODUuOSw2NC45bDcwLjctMjAuN1Y5OS42TDIwMCw4NS45VjI2LjJMMTI4LjQsMHogTTgyLjgsMTY1LjFMNy43LDExMC4zCglWNDguOGw3NS4xLDQxLjRMODIuOCwxNjUuMUw4Mi44LDE2NS4xeiBNODIuNCwxNS43bDI5LjQsMTAuNmwtMjkuNCwzLjVWMTUuN3ogTTE0OS45LDE1MmwtNTguNiwxNi41VjkxLjlsNTguNi03LjJWMTUyTDE0OS45LDE1MnoKCSBNMTkyLjgsODEuM0wxNTcuMyw5MlY3OS4xbC01MS43LTIyLjdsODcuMS0yMy45QzE5Mi44LDMyLjQsMTkyLjgsODEuMywxOTIuOCw4MS4zeiIvPgo8L3N2Zz4K';
}

/**
 * Check whether pro version is defined.
 *
 * @since 1.0.0
 * @return bool whether pro version is active
 */
function zyre_has_pro() {
	return defined( 'ZYRE_ADDONS_PRO_VERSION' );
}

/**
 * Sanitize array recursively.
 *
 * @since 1.0.0
 * @return array with sanitization
 */
function zyre_sanitize_array_recursively( $arr ) {

	foreach ( $arr as $key => &$value ) {
		if ( is_array( $value ) ) {
			$value = zyre_sanitize_array_recursively( $value );
		} else {
			$value = sanitize_text_field( $value );
		}
	}

	return $arr;
}

/**
 * Check contact form 7 plugin activated
 *
 */
function zyre_is_cf7_activated() {
	return class_exists( '\WPCF7' );
}

/**
 * Get a list of all CF7 forms
 *
 * @return array
 */
function zyre_get_cf7_forms(): array {
	$forms = [];

	if ( zyre_is_cf7_activated() ) {
		$_forms = get_posts( [
			'post_type'      => 'wpcf7_contact_form',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
		] );

		if ( ! empty( $_forms ) ) {
			$forms = wp_list_pluck( $_forms, 'post_title', 'ID' );
		}
	}

	return $forms;
}

/**
 * Get plugin missing notice
 *
 * @param string $plugin_name Name of the plugin that is missing.
 * @return void
 */
function zyre_show_plugin_missing_alert( $plugin_name ) {
	if ( current_user_can( 'activate_plugins' ) && ! empty( $plugin_name ) ) {
		printf(
			'<div %1$s><strong>%2$s</strong> %3$s</div>',
			'style="margin: 1rem;padding: 1rem 1.25rem;border-left: 5px solid #f5c848;color: #856404;background-color: #fff3cd;"',
			esc_html( $plugin_name ),
			esc_html__( 'plugin is missing! Please install and activate it.', 'zyre-elementor-addons' )
		);
	}
}

/**
 * Get plugin missing info.
 *
 * If the plugin is not installed or not activated.
 *
 * @param array $args
 * @since 1.0.0
 * @return array
 */
function zyre_get_plugin_missing_info( $args = [] ) {
	$elementor_info = [
		'installed' => false,
	];

	if ( empty( $args ) ) {
		return $elementor_info;
	}

	$plugin_title = ! empty( $args['plugin_title'] ) ? $args['plugin_title'] : '';
	$plugin_name = ! empty( $args['plugin_name'] ) ? $args['plugin_name'] : '';
	$plugin_file = ! empty( $args['plugin_file'] ) ? $args['plugin_file'] : '';

	if ( ! empty( $plugin_file ) && file_exists( WP_PLUGIN_DIR . '/' . $plugin_file ) ) {
		/* translators: %s is the plugin name */
		$elementor_info['title'] = sprintf( __( 'Activate %s', 'zyre-elementor-addons' ), esc_html( $plugin_title ) );
		$elementor_info['url'] = wp_nonce_url( 'plugins.php?action=activate&plugin=' . $plugin_file . '&plugin_status=all&paged=1', 'activate-plugin_' . $plugin_file );
		$elementor_info['installed'] = true;
	} else {
		/* translators: %s is the plugin name */
		$elementor_info['title'] = sprintf( __( 'Install %s', 'zyre-elementor-addons' ), esc_html( $plugin_title ) );
		$elementor_info['url'] = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=' . $plugin_name ), 'install-plugin_' . $plugin_name );
	}

	return $elementor_info;
}

/**
 * All Page List
 */
function zyre_get_all_pages() {
	$page_list = get_posts( [
		'post_type'      => 'page',
		'orderby'        => 'date',
		'order'          => 'DESC',
		'posts_per_page' => -1,
	] );
	$pages = [];
	if ( ! empty( $page_list ) && ! is_wp_error( $page_list ) ) {
		foreach ( $page_list as $page ) {
			$pages[ $page->ID ] = $page->post_title;
		}
	}
	return $pages;
}

/**
 * All Post List
 */
function zyre_get_all_posts() {
	$post_list = get_posts( [
		'post_type'      => 'post',
		'orderby'        => 'date',
		'order'          => 'DESC',
		'posts_per_page' => -1,
	] );
	$posts = [];
	if ( ! empty( $post_list ) && ! is_wp_error( $post_list ) ) {
		foreach ( $post_list as $post ) {
			$posts[ $post->ID ] = $post->post_title;
		}
	}
	return $posts;
}

/**
 * Get All Post Types
 */
function zyre_get_post_types() {
	// Get all public post types that are shown in nav menus
	$post_types = get_post_types(
		[
			'public' => true,
			'show_in_nav_menus' => true,
		],
		'object'
	);

	// Exclude specific post types
	$exclude_post_types = [ 'elementor_library', 'attachment' ];
	foreach ( $exclude_post_types as $exclude ) {
		unset( $post_types[ $exclude ] );
	}

	// Build array of post type slug => label
	$types = [];
	foreach ( $post_types as $type ) {
		$types[ $type->name ] = $type->label;
	}

	// Add manual option at the beginning (optional: you can place it at the end too)
	$types = $types + [ 'manual' => esc_html__( 'Manual Selection', 'zyre-elementor-addons' ) ];

	return $types;
}

/**
 * Get All Post Types post
 */
function zyre_get_all_type_posts() {
	$post_list = get_posts( [
		'post_type'      => 'any',
		'orderby'        => 'date',
		'order'          => 'DESC',
		'posts_per_page' => -1,
	] );

	$posts = [];
	if ( ! empty( $post_list ) && ! is_wp_error( $post_list ) ) {
		foreach ( $post_list as $post ) {
			$posts[ $post->ID ] = $post->post_title;
		}
	}
	return $posts;
}

/**
 * Get all real post authors (exclude subscribers)
 *
 * @return array Array of authors with user ID as key and display name as value.
 */
function zyre_get_all_author() {
	$allowed_roles = [ 'contributor', 'author', 'editor', 'administrator' ];

	$users = get_users( [
		'role__in'            => $allowed_roles,
		'fields'              => [ 'ID', 'display_name' ],
	] );

	if ( ! empty( $users ) ) {
		return wp_list_pluck( $users, 'display_name', 'ID' );
	}

	return [];
}

/**
 * Get Post Categories
 *
 * @return array
 */
function zyre_get_category_list( $taxonomy = 'category', $key = 'term_id' ) {
	$options = [];
	$terms = get_terms([
		'taxonomy' => $taxonomy,
		'hide_empty' => true,
	]);
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		foreach ( $terms as $term ) {
			$options[ $term->{$key} ] = $term->name;
		}
	}
	return $options;
}

/**
 * Get all Tags
 *
 * @param  array  $args
 *
 * @return array
 */
function zyre_get_tags_list( $args = [] ) {
	$options = [];
	$tags = get_tags( $args );
	if ( ! is_wp_error( $tags ) && ! empty( $tags ) ) {
		foreach ( $tags as $tag ) {
			$options[ $tag->term_id ] = $tag->name;
		}
	}
	return $options;
}

/**
 * Get all taxonomy list
 */
function zyre_get_texonomy_list( $taxonomy = 'category', $key = 'term_id' ) {
	$options = [];
	$terms = get_terms( [
		'taxonomy'   => $taxonomy,
		'hide_empty' => false,
	] );
	if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
		foreach ( $terms as $term ) {
			$options[ $term->{$key} ] = $term->name;
		}
	}
	return $options;
}

/**
 * Properly strips all HTML tags including 'script' and 'style'.
 *
 * This differs from strip_tags() because it removes the contents of
 * the `<script>` and `<style>` tags. E.g. `strip_tags( '<script>something</script>' )`
 * will return 'something'. zyre_strip_all_tags() will return an empty string.
 *
 * @since 1.0.0
 *
 * @param string $text          String containing HTML tags
 * @param bool   $remove_breaks Optional. Whether to remove left over line breaks and white space chars
 * @return string The processed string.
 */
function zyre_strip_all_tags( $text, $remove_breaks = false ) {
	if ( is_null( $text ) ) {
		return '';
	}

	if ( ! is_scalar( $text ) ) {
		/*
		 * To maintain consistency with pre-PHP 8 error levels,
		 * wp_trigger_error() is used to trigger an E_USER_WARNING,
		 * rather than _doing_it_wrong(), which triggers an E_USER_NOTICE.
		 */
		wp_trigger_error(
			'',
			sprintf(
				/* translators: 1: The function name, 2: The argument number, 3: The argument name, 4: The expected type, 5: The provided type. */
				__( 'Warning: %1$s expects parameter %2$s (%3$s) to be a %4$s, %5$s given.', 'zyre-elementor-addons' ),
				__FUNCTION__,
				'#1',
				'$text',
				'string',
				gettype( $text )
			),
			E_USER_WARNING
		);

		return '';
	}

	$text = preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', $text );
	$text = strip_tags( $text, '<br>' );

	if ( $remove_breaks ) {
		$text = preg_replace( '/[\r\n\t ]+/', ' ', $text );
	}

	return trim( $text );
}

/**
 * Trims text to a certain number of words.
 *
 * This function is localized. For languages that count 'words' by the individual
 * character (such as East Asian languages), the $num_words argument will apply
 * to the number of individual characters.
 *
 * @since 1.0.0
 *
 * @param string $text      Text to trim.
 * @param int    $num_words Number of words. Default 55.
 * @param string $more      Optional. What to append if $text needs to be trimmed. Default '&hellip;'.
 * @return string Trimmed text.
 */
function zyre_trim_words( $text, $num_words = 55, $more = null ) {
	if ( null === $more ) {
		$more = __( '&hellip;', 'zyre-elementor-addons' );
	}

	$original_text = $text;
	$text          = zyre_strip_all_tags( $text );
	$text_count = str_replace( '<br>', ' ', $text ); // Make sure <br> does NOT count as a word
	$num_words     = (int) $num_words;

	if ( str_starts_with( wp_get_word_count_type(), 'characters' ) && preg_match( '/^utf\-?8$/i', get_option( 'blog_charset' ) ) ) {
		$text_count = trim( preg_replace( "/[\n\r\t ]+/", ' ', $text_count ), ' ' );
		preg_match_all( '/./u', $text_count, $words_array );
		$words_array = array_slice( $words_array[0], 0, $num_words + 1 );
		$sep         = '';
	} else {
		$words_array = preg_split( "/[\n\r\t ]+/", $text_count, $num_words + 1, PREG_SPLIT_NO_EMPTY );
		$sep         = ' ';
	}

	if ( count( $words_array ) > $num_words ) {
		array_pop( $words_array );
		$text = implode( $sep, $words_array );
		$text = $text . $more;
	} else {
		$text = implode( $sep, $words_array );
	}

	/**
	 * Filters the text content after words have been trimmed.
	 *
	 * @since 1.0.0
	 *
	 * @param string $text          The trimmed text.
	 * @param int    $num_words     The number of words to trim the text to. Default 55.
	 * @param string $more          An optional string to append to the end of the trimmed text, e.g. &hellip;.
	 * @param string $original_text The text before it was trimmed.
	 */
	return apply_filters( 'zyre_trim_words', $text, $num_words, $more, $original_text );
}