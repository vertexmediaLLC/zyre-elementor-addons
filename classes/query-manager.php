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
	public static function get_page_template_options( $type = '' ) {
		$page_templates = self::get_elementor_templates( $type );

		$options = [];

		if ( count( $page_templates ) ) {
			foreach ( $page_templates as $id => $name ) {
				$options[$id] = $name;
			}
		} else {
			$options['no_template'] = __( 'No saved templates found!', 'zyre-elementor-addons' );
		}

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

	/**
	 * Get all elementor page templates
	 *
	 * @param  null    $type
	 * @return array
	 */
	public static function get_elementor_templates( $type = null ) {
		$options = [];

		if ( $type ) {
			$args = [
				'post_type'      => 'elementor_library',
				'posts_per_page' => -1,
			];
			$args['tax_query'] = [
				[
					'taxonomy' => 'elementor_library_type',
					'field'    => 'slug',
					'terms'    => $type,
				],
			];

			$page_templates = get_posts( $args );

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
     * Query Posts
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
	 * Get all public post types
	 *
	 * @return array
	 */
	public static function get_post_types() {
		$post_types = get_post_types( array( 'public' => true ), 'objects' );
		$list = [];

		if ( ! empty( $post_types ) ) {
			foreach ( $post_types as $post_type ) {
				$list[ $post_type->name ] = $post_type->labels->name;
			}
		}

		return $list;
	}
}
