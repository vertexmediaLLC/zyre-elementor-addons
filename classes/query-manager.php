<?php

namespace VertexMediaLLC\ZyreElementorAddons;

defined( 'ABSPATH' ) || die();

class Query_Manager {

	/**
	 * Get Elementor template list as Select
	 *
	 * @param  string $type
	 * @return array
	 */
	public static function get_page_template_options( $type = '', $args = [] ) {
		static $cache = [];

		$key = md5( wp_json_encode( [ $type, $args ] ) );

		if ( isset( $cache[ $key ] ) ) {
			return $cache[ $key ];
		}

		$page_templates = self::get_elementor_templates( $type, $args );

		$options = [];

		if ( count( $page_templates ) ) {
			foreach ( $page_templates as $id => $name ) {
				$options[$id] = $name;
			}
		} else {
			$options['no_template'] = __( 'No saved templates found!', 'zyre-elementor-addons' );
		}

		$cache[ $key ] = $options;

		return $options;
	}

	/**
	 * Get all elementor page templates
	 *
	 * @param  null    $type
	 * @param  array   $args
	 * @return array
	 */
	public static function get_elementor_templates( $type = null, $args = [] ) {
		$options = [];

		if ( $type ) {
			$defaults = [
				'post_type'      => 'elementor_library',
				'posts_per_page' => -1,
				'tax_query'      => [
					[
						'taxonomy' => 'elementor_library_type',
						'field'    => 'slug',
						'terms'    => $type,
					],
				],
			];

			$parsed_args = wp_parse_args( $args, $defaults );

			$page_templates = get_posts( $parsed_args );

			if ( ! empty( $page_templates ) && ! is_wp_error( $page_templates ) ) {
				foreach ( $page_templates as $post ) {
					$options[$post->ID] = $post->post_title;
				}
			}
		} else {
			$options = self::get_query_post_list( 'elementor_library' );
		}

		return $options;
	}


    /**
     * Get a list of posts based on specified criteria such as post type, limit, and search term.
     *
     * @param string $post_type
     * @param integer $limit
     * @param string $search
     * @return array
     */
	public static function get_query_post_list( $post_type = 'any', $limit = -1, $search = '' ) {
		global $wpdb;
		$data = [];

		$where  = "WHERE post_status = 'publish'";
		$params = [];

		// POST TYPE
		if ( 'any' === $post_type ) {
			$types = get_post_types( [ 'exclude_from_search' => false ] );

			if ( empty( $types ) ) {
				$where .= " AND 1=0";
			} else {
				$placeholders = implode( ',', array_fill( 0, count( $types ), '%s' ) );
				$where       .= " AND post_type IN ($placeholders)";
				$params       = array_merge( $params, $types );
			}
		} elseif ( ! empty( $post_type ) ) {
			$where   .= " AND post_type = %s";
			$params[] = $post_type;
		}

		// SEARCH
		if ( ! empty( $search ) ) {
			$where   .= " AND post_title LIKE %s";
			$params[] = '%' . $wpdb->esc_like( $search ) . '%';
		}

		// LIMIT
		if ( -1 == $limit ) {
			$limit_sql = '';
		} elseif ( 0 == $limit ) {
			$limit_sql = ' LIMIT 0,1';
		} else {
			$limit_sql = ' LIMIT %d';
			$params[]  = $limit;
		}

		// BUILD + EXECUTE IN ONE PLACE (important)
		if ( ! empty( $params ) ) {
			$results = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT post_title, ID FROM {$wpdb->posts} $where $limit_sql",
					$params
				)
			);
		} else {
			// no dynamic input → safe static query
			$results = $wpdb->get_results(
				"SELECT post_title, ID FROM {$wpdb->posts} WHERE post_status = 'publish'"
			);
		}

		if ( ! empty( $results ) ) {
			foreach ( $results as $row ) {
				$data[ $row->ID ] = $row->post_title;
			}
		}

		return $data;
	}
	
	/**
	 * Get author list based on specified roles, with options to include or exclude certain roles.
	 * 
	 * @param array $args {
	 *    @type array $exclude_roles Roles to exclude from the author list.
	 *    @type array $include_roles Roles to include in the author list.
	 * }
	 *
	 * @return array Array of authors with user ID as key and display name as value.
	 */
	public static function get_author_list( $args = [] ) {
		$allowed_roles = [ 'contributor', 'author', 'editor', 'administrator' ];

		if ( ! empty( $args['exclude_roles'] ) && is_array( $args['exclude_roles'] ) ) {
			foreach ( $args['exclude_roles'] as $role ) {
				if ( in_array( $role, $allowed_roles ) ) {
					$allowed_roles = array_diff( $allowed_roles, [ $role ] );
					$allowed_roles = array_values( $allowed_roles ); // Reindex array after removal
				}
			}
		}

		if ( ! empty( $args['include_roles'] ) && is_array( $args['include_roles'] ) ) {
			foreach ( $args['include_roles'] as $role ) {
				if ( ! in_array( $role, $allowed_roles ) ) {
					$allowed_roles[] = $role;
				}
			}
		}

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
	 * Get all public post types
	 *
	 * @param array $args
	 * @return array
	 */
	public static function get_post_types( $args = [] ) {
		$default_args = [
			'public' => true,
		];

		if ( isset( $args['show_in_nav_menus'] ) ) {
			$default_args['show_in_nav_menus'] = (bool) $args['show_in_nav_menus'];
		}

		$post_types = get_post_types( $default_args, 'objects' );

		if ( ! empty( $args['exclude'] ) && is_array( $args['exclude'] ) ) {
			foreach ( $args['exclude'] as $name ) {
				if ( isset( $post_types[ $name ] ) ) {
					unset( $post_types[ $name ] );
				}
			}
		}

		$list = [];

		if ( ! empty( $post_types ) ) {
			foreach ( $post_types as $post_type ) {
				$list[ $post_type->name ] = $post_type->labels->name;
			}
		}

		if ( ! empty( $args['include'] ) && is_array( $args['include'] ) ) {
			foreach ( $args['include'] as $name => $label ) {
				if ( ! isset( $post_types[ $name ] ) ) {
					$list[ $name ] = esc_html( $label );
				}
			}
		}

		return $list;
	}

	/**
	 * Get term list based on specified taxonomy and other arguments, with the option to specify which field to use as the key in the returned array.
	 * 
	 * @param array $args {
	 *   @type string $taxonomy The taxonomy to retrieve terms from (default: 'category').
	 *   @type bool $hide_empty Whether to hide terms that have no posts (default: true).
	 * }
	 * @param string $field The field of the term object to use as the key in the returned array (default: 'term_id').
	 *
	 * @return array
	 */
	 public static function get_term_list( $args = [], $field = 'term_id' ) {
		static $cache = [];

		$default_args = [
			'taxonomy' => 'category',
			'hide_empty' => true,
		];

		$args = wp_parse_args( $args, $default_args );

		$key = md5( wp_json_encode( [ $args, $field ] ) );

		if ( isset( $cache[ $key ] ) ) {
			return $cache[ $key ];
		}

		$options = [];
		$terms = get_terms( $args );

		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			foreach ( $terms as $term ) {
				$options[ $term->{$field} ] = $term->name;
			}
		}

		$cache[ $key ] = $options;

		return $options;
	}

	/**
	 * Get all WordPress registered widgets
	 *
	 * @return array
	 */
	public static function get_registered_sidebars() {
		global $wp_registered_sidebars;
		$options = [];

		if ( ! empty( $wp_registered_sidebars ) && is_array( $wp_registered_sidebars ) ) {
			foreach ( $wp_registered_sidebars as $sidebar_id => $sidebar ) {
				$options[$sidebar_id] = $sidebar['name'];
			}
		}

		return $options;
	}
}
