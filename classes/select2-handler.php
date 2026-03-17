<?php
namespace VertexMediaLLC\ZyreElementorAddons;

defined( 'ABSPATH' ) || die();

use Exception;

class Select2_Handler {

	protected static function validate_reqeust() {
		if ( ! current_user_can( 'edit_posts' ) ) {
			throw new Exception( esc_html__( 'Unauthorized request', 'zyre-elementor-addons' ) );
		}

		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';

		if ( ! wp_verify_nonce( $nonce, 'zyreladdons_editor_nonce' ) ) {
			throw new Exception( esc_html__( 'Invalid request', 'zyre-elementor-addons' ) );
		}
	}

	public static function process_select_request() {
		try {
			self::validate_reqeust();

			$object_type = ! empty( $_POST['object_type'] ) ? sanitize_text_field( wp_unslash( $_POST['object_type'] ) ) : '';

			if ( ! in_array( $object_type, [ 'post', 'term', 'user', 'mailchimp_list' ], true ) ) {
				throw new Exception( esc_html__( 'Invalid object type', 'zyre-elementor-addons' ) );
			}

			$response = [];

			if ( 'post' === $object_type ) {
				$response = self::process_post();
			}

			if ( 'term' === $object_type ) {
				$response = self::process_term();
			}

			if ( 'mailchimp_list' === $object_type ) {
				$response = self::process_mailchimp_list();
			}

			wp_send_json_success( $response );
		} catch ( Exception $e ) {
			wp_send_json_error( $e->getMessage() );
		}
	}

	public static function process_post() {
		$post_type  = ! empty( $_POST['post_type'] ) ? sanitize_text_field( wp_unslash( $_POST['post_type'] ) ) : 'any';
		$query_term = ! empty( $_POST['query_term'] ) ? sanitize_text_field( wp_unslash( $_POST['query_term'] ) ) : '';
		$saved_values = ! empty( $_POST['saved_values'] ) ? zyreladdons_sanitize_array_recursively( wp_unslash( $_POST['saved_values'] ) ) : [];

		$args = [
			'post_type'        => $post_type,
			'suppress_filters' => false,
			'posts_per_page'   => 20,
			'orderby'          => 'title',
			'order'            => 'ASC',
			'post_status'      => 'publish',
		];

		if ( $query_term ) {
			$args['s'] = $query_term;
		}

		if ( $saved_values ) {
			$args['post__in'] = $saved_values;
			$args['posts_per_page'] = count( $saved_values );
			$args['orderby'] = 'post__in';
		}

		$posts = get_posts( $args );

		if ( empty( $posts ) ) {
			return [];
		}

		$out = [];

		foreach ( $posts as $post ) {
			// extra space is needed to maintain order in elementor control
			$out[ " {$post->ID}" ] = esc_html( $post->post_title );
		}

		return $out;
	}

	public static function process_term() {
		$term_taxonomy = ! empty( $_POST['term_taxonomy'] ) ? sanitize_text_field( wp_unslash( $_POST['term_taxonomy'] ) ) : '';
		$query_term = ! empty( $_POST['query_term'] ) ? sanitize_text_field( wp_unslash( $_POST['query_term'] ) ) : '';
		$saved_values = ! empty( $_POST['saved_values'] ) ? zyreladdons_sanitize_array_recursively( wp_unslash( $_POST['saved_values'] ) ) : [];

		if ( empty( $term_taxonomy ) ) {
			throw new Exception( esc_html__( 'Invalid taxonomy', 'zyre-elementor-addons' ) );
		}

		$args = [
			'taxonomy'   => $term_taxonomy,
			'hide_empty' => false,
			'orderby'    => 'name',
			'order'      => 'ASC',
			'number'     => 20,
		];

		if ( $query_term ) {
			$args['search'] = $query_term;
			$args['count'] = true;
		}

		if ( $saved_values ) {
			$args['include'] = $saved_values;
			$args['number'] = count( $saved_values );
			$args['orderby'] = 'include';
		}

		$terms = get_terms( $args );

		if ( empty( $terms ) || is_wp_error( $terms ) ) {
			return [];
		}

		$out = [];

		foreach ( $terms as $term ) {
			$title = ! empty( $query_term ) ? "{$term->name} ({$term->count})" : $term->name;
			// extra space is needed to maintain order in elementor control
			$out[ " {$term->term_id}" ] = $title;
		}

		return $out;
	}

	public static function process_mailchimp_list() {
		$global_api   = ! empty( $_POST['global_api'] ) ? sanitize_text_field( wp_unslash( $_POST['global_api'] ) ) : '';
		$saved_values = ! empty( $_POST['saved_values'] ) ? zyreladdons_sanitize_array_recursively( wp_unslash( $_POST['saved_values'] ) ) : [];

		if ( empty( $global_api ) ) {
			throw new Exception( esc_html__( 'Invalid API key', 'zyre-elementor-addons' ) );
		}

		if ( ! class_exists( 'VertexMediaLLC\ZyreElementorAddons\Widget\Mailchimp\Mailchimp_Api' ) ) {
			include_once ZYRELADDONS_DIR_PATH . 'widgets/subscription-form/mailchimp-api.php';
		}

		$options = Widget\Mailchimp\Mailchimp_Api::get_mailchimp_lists( $global_api );

		if ( $saved_values ) {
			$saved_values[0] = ' ' . $saved_values[0];
			return ( array_key_exists( $saved_values[0], $options ) ? [ $saved_values[0] => $options[ $saved_values[0] ] ] : [] );
		} else {
			return $options;
		}
	}

	public static function process_el_select_request() {
		try {
			self::validate_reqeust();

			$post_types = ! empty( $_POST['post_types'] ) ? zyreladdons_sanitize_array_recursively( wp_unslash( $_POST['post_types'] ) ) : [];

			$taxonomies = [];

			foreach ( $post_types as $post_type ) {

				$object_taxonomies = get_object_taxonomies( $post_type, 'names' );

				if ( ! empty( $object_taxonomies ) ) {
					$taxonomies = array_merge( $taxonomies, $object_taxonomies );
				}
			}

			$taxonomies = array_unique( $taxonomies );

			wp_send_json_success( $taxonomies );

		} catch ( Exception $e ) {
			wp_send_json_error( $e->getMessage() );
		}
	}
}
