<?php

namespace VertexMediaLLC\ZyreElementorAddons\Modules\Mega_Menu;

use Elementor\Icons_Manager;
use VertexMediaLLC\ZyreElementorAddons\Modules\Mega_Menu as Mega_Menu;

class Zyre_Walker_Nav extends \Walker_Nav_Menu {

	/**
	 * @var mixed
	 */
	public $menu_Settings;

	/**
	 * @param $menu_item_id
	 */
	public function get_item_meta( $menu_item_id ) {

		$meta_key = Mega_Menu::$menuitem_settings_key;
		$data     = get_post_meta( $menu_item_id, $meta_key, true );

		if ( ! is_array( $data ) ) {
			$data = [];
		}

		$default = [
			"menu_id"                         => null,
			"menu_has_child"                  => '',
			"menu_enable"                     => 0,
			"menu_icon"                       => '',
			"menu_icon_color"                 => '',
			"menu_icon_size"                  => '',
			"menu_badge_text"                 => '',
			"menu_badge_color"                => '',
			"menu_badge_background"           => '',
			"menu_badge_enable_arrow"         => '',
			"mobile_submenu_content_type"     => 'builder_content',
			"vertical_megamenu_position_type" => 'position_relative',
			"megamenu_width"                  => '',
			"megamenu_width_type"             => 'custom_width',
		];

		return array_merge( $default, $data );
	}

	/**
	 * @param $menu_slug
	 * @return mixed
	 */
	public function is_megamenu( $menu_slug ) {
		$menu_slug = ( ( ( gettype( $menu_slug ) == 'object' ) && ( isset( $menu_slug->slug ) ) ) ? $menu_slug->slug : $menu_slug );

		$cache_key = 'zyreladdons_mm_data_' . $menu_slug;
		$cached    = wp_cache_get( $cache_key );
		if ( false !== $cached ) {
			return $cached;
		}

		$return = 0;

		$settings = Options::get_megamenu_settings( [] );
		$term     = get_term_by( 'slug', $menu_slug, 'nav_menu' );

		if (
			isset($term->term_id)
			&& isset( $settings[ 'menu_location_' . $term->term_id ] )
			&& $settings[ 'menu_location_' . $term->term_id ]['is_enabled'] == '1'
		) {

			$return = 1;
		}

		wp_cache_set($cache_key, $return);

		return $return;
	}

	/**
	 * @param $item_meta
	 * @param $menu
	 */
	public function is_megamenu_item( $item_meta, $menu ) {
		if ( $this->is_megamenu( $menu ) == 1 && $item_meta['menu_enable'] == 1 && class_exists( 'Elementor\Plugin' ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Starts the list before the elements are added.
	 *
	 *
	 *
	 * @see Walker::start_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul class=\"sub-menu\">\n";
	}
	/**
	 * Ends the list of after the elements are added.
	 *
	 *
	 *
	 * @see Walker::end_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 */
	public function end_lvl(&$output, $depth = 0, $args = array()) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}
	/**
	 * Start the element output.
	 *
	 *
	 *
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 * @param int    $id     Current item ID.
	 */
	public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$classes = empty( $item->classes ) ? [] : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;
		$args = (object) $args;

		/**
		 * Filter the CSS class(es) applied to a menu item's list item element.
		 *
		 *
		 * @since 3.0.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
		 * @param object $item    The current menu item.
		 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
		 * @param int    $depth   Depth of menu item. Used for padding.
		 */
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );

		// New
		$class_names .= ' nav-item';
		$item_meta        = $this->get_item_meta($item->ID);
		$is_megamenu_item = $this->is_megamenu_item( $item_meta, $args->menu );

		if ( in_array( 'menu-item-has-children', $classes ) || $is_megamenu_item == true ) {
			$class_names .= ' ' . $item_meta['vertical_megamenu_position_type'] . ' zy-dropdown-menu-' . $item_meta['megamenu_width_type'] . '';
		}

		if ( $is_megamenu_item == true ) {
			$class_names .= ' zy-megamenu-has';
		}

		if ( $item->ID == $item_meta['menu_id'] && $item_meta['mobile_submenu_content_type'] == 'builder_content' ) {
			$class_names .= ' zy-mobile-builder-content';
		}

		if ( $item->ID == $item_meta['menu_id'] && $item_meta['mobile_submenu_content_type'] == 'submenu_list' ) {
			$class_names .= ' zy-mobile-submenu-items';
		}

		// Add Icon Class for Megamenu Item
		if ( $this->is_megamenu( $args->menu ) == 1 ) {
			if ( $item_meta['menu_icon'] != '' ) {
				$class_names .= ' menu-item-has-icon';
			}
		}

		$class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

		/**
		 * Filter the ID applied to a menu item's list item element.
		 *
		 *
		 * @since 3.0.1
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
		 * @param object $item    The current menu item.
		 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
		 * @param int    $depth   Depth of menu item. Used for padding.
		 */
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
		$id = $id ? ' id="' . esc_attr($id) . '"' : '';
		// New
		$data_attr = '';
		switch ( $item_meta['megamenu_width_type'] ) {
			case 'default_width':
				$data_attr = esc_attr( ' data-megamenu-width=750px' );
				break;

			case 'full_width':
				$data_attr = esc_attr( ' data-megamenu-width=' );
				break;

			case 'custom_width':
				$data_attr = $item_meta['megamenu_width'] === '' ? esc_attr( ' data-megamenu-width=750px' ) : esc_attr( ' data-megamenu-width=' . $item_meta['megamenu_width'] . '' );
				break;

			default:
				$data_attr = esc_attr( ' data-megamenu-width=750px' );
				break;
		}
		//
		$output .= $indent . '<li' . $id . $class_names . $data_attr . '>';
		$atts           = array();
		$atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
		$atts['target'] = !empty($item->target) ? $item->target : '';
		$atts['rel']    = !empty($item->xfn) ? $item->xfn : '';
		$atts['href']   = !empty($item->url) ? $item->url : '';

		$submenu_indicator = '';

		// New
		if ( $depth === 0 ) {
			$atts['class'] = 'zy-menu-nav-link';
		}
		if ( $depth === 0 && ( in_array( 'menu-item-has-children', $classes ) || ( $is_megamenu_item == true ) ) ) {
			$atts['class'] .= ' zy-menu-dropdown-toggle';
		}
		if ( ! empty( $args->sub_indicator ) && ( in_array( 'menu-item-has-children', $classes ) || ( $is_megamenu_item == true ) || ( $is_megamenu_item == true && $item_meta['mobile_submenu_content_type'] == 'builder_content' ) ) ) {
			$submenu_indicator .= '<span class="submenu-indicator">' . $args->sub_indicator . '</span>';
		}
		if ( $depth > 0 ) {
			$manual_class = array_values( $classes )[0] . ' ' . 'dropdown-item';
			$atts['class'] = $manual_class;
		}
		if ( in_array( 'current-menu-item', $item->classes ) ) {
			$atts['class'] .= ' active';
		}

		/**
		 * Filter the HTML attributes applied to a menu item's anchor element.
		 *
		 *
		 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 * @type  string $title  Title attribute.
		 * @type  string $target Target attribute.
		 * @type  string $rel    The rel attribute.
		 * @type  string $href   The href attribute.
		 * }
		 * @since 3.6.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array  $atts   {
		 * @param object $item   The current menu item.
		 * @param array  $args   An array of {@see wp_nav_menu()} arguments.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}
		$item_output = $args->before;
		// New

		//
		$item_output .= '<a' . $attributes . '>';

		if ( $this->is_megamenu( $args->menu ) == 1 ) {
			// add badge text
			if ( $item_meta['menu_badge_text'] != '' ) {
				$badge_styles = [];
				if ( $item_meta['menu_badge_background'] ) {
					$badge_styles['background'] = $item_meta['menu_badge_background'];
				}
				if ( $item_meta['menu_badge_color'] ) {
					$badge_styles['color'] = $item_meta['menu_badge_color'];
				}
				if ( $item_meta['menu_badge_radius'] != '' ) {
					$rad = explode( ',', $item_meta['menu_badge_radius'] );
					if ( $rad[0] ) {
						$badge_styles['border-top-left-radius'] = $rad[0] . 'px';
					}
					if ( $rad[1] ) {
						$badge_styles['border-top-right-radius'] = $rad[1] . 'px';
					}
					if ( $rad[2] ) {
						$badge_styles['border-bottom-left-radius'] = $rad[2] . 'px';
					}
					if ( $rad[3] ) {
						$badge_styles['border-bottom-right-radius'] = $rad[3] . 'px';
					}
				}

				$badge_style = implode( ';', array_map(
					fn( $k, $v ) => "$k:$v",
					array_keys( $badge_styles ),
					$badge_styles
				) );
				
				$item_output .= '<span data-css="' . esc_attr( $badge_style ) . '" class="zy-menu-badge">' . $item_meta['menu_badge_text'];
				if ( '1' === $item_meta['menu_badge_enable_arrow'] ) {
					$badge_carret_style = ! empty( $badge_styles['background'] ) ? 'border-top-color:' . $badge_styles['background'] : '';
					$item_output .= '<i data-css="' . esc_attr( $badge_carret_style ) . '" class="zy-menu-badge-arrow"></i>';
				}
				$item_output .= '</span>';
			}

			// add menu icon & style
			if ( $item_meta['menu_icon'] != '' ) {

				$fa_icon_atts = [ 'aria-hidden' => 'true' ];
				$fa_font_size = '';
				$icon_styles = [];

				if ( ! empty( $item_meta['menu_icon_color'] ) ) {
					$icon_styles['color'] = $item_meta['menu_icon_color'];
					$fa_icon_atts['fill'] = esc_attr( $item_meta['menu_icon_color'] );
				}

				if ( ! empty( $item_meta['menu_icon_size'] ) ) {
					$icon_styles['font-size'] = absint( $item_meta['menu_icon_size'] ) . 'px';
					$fa_font_size = 'data-css=font-size:' . absint( $item_meta['menu_icon_size'] ) . 'px';
				}

				// If font-awesome icon found
				if ( preg_match( '/\b(fas|far|fab|fal|fat)\b\s+fa-[\w-]+/', $item_meta['menu_icon'], $match ) ) {
					$map = [
						'fas' => 'fa-solid',
						'far' => 'fa-regular',
						'fab' => 'fa-brands',
						'fal' => 'fa-light',
						'fat' => 'fa-thin',
					];

					$this->fa_icon = [
						'library' => $map[ $match[1] ] ?? '',
						'value'   => $item_meta['menu_icon'],
					];

					$item_output .= '<span class="zy-menu-icon" ' . esc_attr( $fa_font_size ) . '>' . Icons_Manager::try_get_icon_html( $this->fa_icon, $fa_icon_atts ) . '</span>';
				} else {
					$icon_style = implode( ';', array_map(
						fn( $k, $v ) => "$k:$v",
						array_keys( $icon_styles ),
						$icon_styles
					) );
					$item_output .= '<i class="zy-menu-icon ' . $item_meta['menu_icon'] . '" data-css="' . esc_attr( $icon_style ) . '" ></i>';
				}
			}
		}

		$title = $item->title;

		if( isset( $item_meta['menu_item_text_hide'] ) && $item_meta['menu_item_text_hide'] ) {
			$title = '';
		}

		/**
		 * This filter is documented in wp-includes/post-template.php
		 */
		$item_output .= $args->link_before . apply_filters( 'the_title', $title, $item->ID ) . $args->link_after;
		// Add description if it exists.
		$item_output .= ! empty( $item->description ) ? '<span class="menu-item-description">' . esc_html( $item->description ) . '</span>' : '';
		$item_output .= '</a>';
		$item_output .= $submenu_indicator;
		$item_output .= $args->after;

		/**
		 * Filter a menu item's starting output.
		 *
		 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
		 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
		 * no filter for modifying the opening and closing `<li>` for a menu item.
		 *
		 *
		 * @since 3.0.0
		 *
		 * @param string $item_output The menu item's starting HTML output.
		 * @param object $item        Menu item data object.
		 * @param int    $depth       Depth of menu item. Used for padding.
		 * @param array  $args        An array of {@see wp_nav_menu()} arguments.
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
	/**
	 * Ends the element output, if needed.
	 *
	 *
	 *
	 * @see Walker::end_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Page data object. Not used.
	 * @param int    $depth  Depth of page. Not Used.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 */
	public function end_el(&$output, $item, $depth = 0, $args = array()) {
		if ($depth === 0) {
			$args = (object) $args;
			if ( $this->is_megamenu( $args->menu ) == 1 ) {
				$item_meta = $this->get_item_meta( $item->ID );

				if ( $item_meta['menu_enable'] == 1 && class_exists( 'Elementor\Plugin' ) ) {
					$builder_post_title = 'zyreladdons-mm-content-' . $item->ID;

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
						$builder_post = $query->post;
					} else {
						$builder_post = null;
					}

					$output .= '<ul class="sub-menu zy-megamenu-panel">';

					if ( $builder_post != null ) {
						// Elementor Instance
						$elementor = \Elementor\Plugin::instance();

						// Check if using elementor
						$data = $this->query_elementor( $elementor, $builder_post->ID );

						// List all Used Widgets
						$widgetUsed = [];
						$templates = [];
						if ( ! empty( $data ) && is_array( $data ) ) {
							array_walk_recursive( $data, function ( $v, $k ) use ( &$widgetUsed, &$templates ) {
								if ( $k == 'template_id' ) {
									$templates[] = $v;
								}
								if ( $k == 'widgetType' ) {
									$widgetUsed[] = $v;
								}
							} );
						}

						if ( $templates ) {
							foreach ( $templates as $template ) {
								$tplData = $this->query_elementor( $elementor, $template );
								if ( ! empty( $tplData ) && is_array( $tplData ) ) {
									array_walk_recursive( $tplData, function ( $v, $k ) use ( &$widgetUsed, &$templates ) {
										if ( $k == 'template_id' ) {
											$templates[] = $v;
										}
										if ( $k == 'widgetType' ) {
											$widgetUsed[] = $v;
										}
									} );
								}
							}
						}

						// Check For MegaMenu & Avoid Recursion
						if ( in_array( 'zy-nav-menu', $widgetUsed ) ) {
							$output .= '<div class="elementor-alert elementor-alert-danger">' . esc_html__( 'Invalid Data: You can\'t use Happy Mega Menu inside a Happy Mega Menu.', 'zyre-elementor-addons' ) . '</div>';
						} else {
							$output .= $elementor->frontend->get_builder_content_for_display( $builder_post->ID );
						}
					} else {
						$output .= esc_html__( 'No content found', 'zyre-elementor-addons' );
					}

					$output .= '</ul>';
				}
			}
			$output .= "</li>\n";
		}
	}

	private function query_elementor( $elementor, $post_id ) {
		$document = $elementor->documents->get_doc_for_frontend( $post_id );
		if ( ! $document || ! $document->is_built_with_elementor() ) {
			return '';
		}

		// Change the current post, so widgets can use `documents->get_current`.
		$elementor->documents->switch_to_document( $document );
		$data = $document->get_elements_data();

		return $data;
	}
}
