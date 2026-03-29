<?php
namespace VertexMediaLLC\ZyreElementorAddons;

defined( 'ABSPATH' ) || die();

class Search_Handler {

	public function __construct() {
		add_action( 'pre_get_posts', [ $this, 'pre_get_posts' ], 999 );
	}

	public function pre_get_posts( $query ) {
		if ( ! is_admin() && $query->is_main_query() && $query->is_search() ) {
			// Set post types for search query
			if ( ! empty( $_GET['post_types'] ) ) {
				$post_types = explode( ',', sanitize_text_field( wp_unslash( $_GET['post_types'] ) ) );
				$query->set( 'post_type', $post_types );
			}

			// Set tax query for search query
			if ( ! empty( $_GET['cat_id'] ) ) {
				$term = get_term( absint( $_GET['cat_id'] ) );
				if ( ! is_wp_error( $term ) ) {
					$tax_query = [
						'taxonomy' => $term->taxonomy,
						'field'    => 'term_id',
						'terms'    => $term->term_id,
					];
					$query->set( 'tax_query', $tax_query );
				}
			}
		}
	}
}

new Search_Handler();
