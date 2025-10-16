<?php

namespace ZyreAddons\Elementor\ThemeBuilder;

defined( 'ABSPATH' ) || die();

class Conditions_Cache {
	const OPTION_NAME = 'zyre_theme_builder_conditions';

	protected $conditions = [];

	public function __construct() {
		$this->get();
	}

	public function add( $location, $post_id, array $conditions ) {

		if ( $location ) {
			if ( is_array( $this->conditions ) && ! isset( $this->conditions[ $location ] ) ) {
				$this->conditions[ $location ] = [];
			}
			$this->conditions[ $location ][ $post_id ] = $conditions;
		}

		return $this;
	}

	public function remove( $post_id ) {
		$post_id = absint( $post_id );

		foreach ( $this->conditions as $location => $templates ) {
			foreach ( $templates as $id => $template ) {
				if ( $post_id === $id ) {
					unset( $this->conditions[ $location ][ $id ] );
				}
			}
		}

		return $this;
	}

	public function update( $location, $post_id, $conditions ) {
		return $this->remove( $post_id )->add( $location, $post_id, $conditions );
	}

	public function save() {
		return update_option( self::OPTION_NAME, $this->conditions );
	}

	public function get() {
		$this->conditions = get_option( self::OPTION_NAME, [] );

		return $this;
	}

	public function clear() {
		$this->conditions = [];

		return $this;
	}

	public function get_by_location( $location ) {
		if ( isset( $this->conditions[ $location ] ) ) {
			return $this->conditions[ $location ];
		}

		return [];
	}

	public function regenerate() {
		$this->clear();

		$post_type = [
			Module::POST_TYPE,
		];

		$query = new \WP_Query([
			'posts_per_page' => -1,
			'post_type' => $post_type,
			'fields' => 'ids',
			'meta_key' => '_zyre_display_cond',
		]);

		foreach ( $query->posts as $post_id ) {
			$conditions = get_post_meta( $post_id, '_zyre_display_cond', true );
			$location = get_post_meta( $post_id, '_zyre_library_type', true );

			$this->add( $location, $post_id, $conditions );
		}

		$this->save();

		return $this;
	}
}
