<?php

namespace ZyreAddons\Elementor\ThemeBuilder;

defined( 'ABSPATH' ) || die();

use Exception;

class Conditions_Manager {
	public static $instance = null;

	private $cache;
	private $all_conds;
	private $all_conds_list;
	private $location_cache = [];

	public function __construct() {
		$this->cache = new Conditions_Cache();

		add_action( 'wp_ajax_zyre_condition_autocomplete', [ $this, 'condition_autocomplete' ] );
		add_action( 'wp_ajax_zyre_condition_update', [ $this, 'condition_update' ] );
		add_action( 'wp_ajax_zyre_condition_template_type', [ $this, 'get_template_type' ] );
		add_action( 'wp_ajax_zyre_condition_current', [ $this, 'get_current_condition' ] );

		$this->process_condition();
	}

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	protected function parse_condition( $condition ) {
		list( $type, $name, $sub_name, $sub_id ) = array_pad( explode( '/', $condition ), 4, '' );

		return compact( 'type', 'name', 'sub_name', 'sub_id' );
	}

	private function get_condition( $cond_name ) {
		return $this->all_conds[ $cond_name ];
	}

	private function check_name( $name ) {
		$conds = $this->get_condition( 'name' );
		return in_array( $name, $conds );
	}

	private function check_sub_name( $sub_name, $parsed_condition ) {
		$name = $parsed_condition['name'];

		if ( 'all' === $sub_name ) {
			if ( 'archive' === $name ) {
				$is_archive = is_archive() || is_home() || is_search();

				// If installed then let WooCommerce handle it.
				if ( $is_archive && class_exists( 'woocommerce' ) && \is_woocommerce() ) {
					$is_archive = false;
				}
				return $is_archive;
			}
			if ( 'singular' === $name ) {
				return ( is_singular() && ! is_embed() ) || is_404();
			}
			return false;
		}
		return apply_filters( 'zyreaddons/conditions/check/sub_name', $sub_name, $parsed_condition );
	}

	private function get_priority_by_key( $key ) {
		$priority = 100;
		switch ( $key ) {
			case 'archive':
				return 80;
				break;
			case 'author':
			case 'date':
			case 'search':
			case 'post_archive':
				return 70;
				break;
			case 'singular':
				return 60;
				break;
			case 'post':
			case 'in_category':
			case 'in_category_children':
			case 'in_post_tag':
			case 'post_by_author':
			case 'page':
			case 'page_by_author':
			case 'child_of':
			case 'any_child_of':
			case 'by_author':
				return 40;
				break;
			case 'front_page':
				return 30;
				break;
			case 'not_found404':
				return 20;
				break;
		}

		return $priority;
	}

	private function get_condition_priority( $name, $sub_name, $sub_id ) {
		$priority = 100;
		if ( 'general' !== $name ) {
			$priority = $this->get_priority_by_key( $name );

			if ( 'all' !== $sub_name ) {
				$sub_priority = $this->get_priority_by_key( $sub_name );
				if ( $sub_priority < $priority ) {
					$priority = $sub_priority;
				}

				$priority -= 10;

				if ( $sub_id ) {
					$priority -= 10;
				}
			}
		}

		return $priority;
	}

	public function get_location_templates( $location ) {
		$tpl_priority = [];

		$conditions_groups = $this->cache->get_by_location( $location );

		if ( empty( $conditions_groups ) ) {
			return $tpl_priority;
		}

		$excludes = [];
		foreach ( $conditions_groups as $template_id => $conditions ) {

			foreach ( $conditions as $condition ) {
				$parsed_condition = $this->parse_condition( $condition );

				$include = $parsed_condition['type'];
				$name = $parsed_condition['name'];
				$sub_name = $parsed_condition['sub_name'];
				$sub_id = $parsed_condition['sub_id'];

				$is_include = 'include' === $include;

				$condition_pass = $this->check_name( $name );

				if ( $condition_pass && $sub_name ) {
					$condition_pass = $this->check_sub_name( $sub_name, $parsed_condition );
				}

				if ( $condition_pass ) {

					$post_status = get_post_status( $template_id );

					if ( 'publish' !== $post_status ) {
						continue;
					}

					if ( $is_include ) {
						$tpl_priority[ $template_id ] = $this->get_condition_priority( $name, $sub_name, $sub_id );
					} else {
						$excludes[] = $template_id;
					}
				}
			}
		}

		foreach ( $excludes as $exclude_id ) {
			unset( $tpl_priority[ $exclude_id ] );
		}

		asort( $tpl_priority );

		return $tpl_priority;
	}

	public function get_theme_templates_ids( $location ) {
		$templates = $this->get_location_templates( $location );
		return $templates;
	}

	public function get_documents_for_location( $location ) {
		if ( isset( $this->location_cache[ $location ] ) ) {
			return $this->location_cache[ $location ];
		}

		$theme_templates_ids = $this->get_theme_templates_ids( $location );

		$documents = [];

		foreach ( $theme_templates_ids as $theme_template_id => $priority ) {
			$documents[] = $theme_template_id;
		}

		return $documents;
	}

	public function get_name( $cond ) {
		return $this->all_conds_list[ $cond ]['title'] ?? '';
	}

	public function get_all_name( $cond ) {
		return $this->all_conds_list[ $cond ]['all_label'] ?? '';
	}

	private function initial_conditions() {
		$conditions = [
			'general' => [
				'title' => __( 'General', 'zyre-elementor-addons' ),
				'all_label' => __( 'Entire Site', 'zyre-elementor-addons' ),
				'is_pro' => false,
			],
			'archive' => [
				'title' => __( 'Archives', 'zyre-elementor-addons' ),
				'all_label' => __( 'All Archives', 'zyre-elementor-addons' ),
				'is_pro' => false,
			],
			'singular' => [
				'title' => __( 'Singular', 'zyre-elementor-addons' ),
				'all_label' => __( 'All Singular', 'zyre-elementor-addons' ),
				'is_pro' => false,
			],
		];

		return $conditions;
	}

	private function archive_conditions() {
		$conditions = [
			'all' => [
				'title' => __( 'All Archives', 'zyre-elementor-addons' ),
				'all_label' => __( 'All Archives', 'zyre-elementor-addons' ),
				'is_pro' => false,
			],
			'author' => [
				'title' => __( 'Author Archive', 'zyre-elementor-addons' ),
				'all_label' => __( 'Author Archive', 'zyre-elementor-addons' ),
				'is_pro' => true,
			],
			'date' => [
				'title' => __( 'Date Archive', 'zyre-elementor-addons' ),
				'all_label' => __( 'Date Archive', 'zyre-elementor-addons' ),
				'is_pro' => true,
			],
			'search' => [
				'title' => __( 'Search Results', 'zyre-elementor-addons' ),
				'all_label' => __( 'Search Results', 'zyre-elementor-addons' ),
				'is_pro' => true,
			],
			'post_archive' => [
				'title' => __( 'Posts Archive', 'zyre-elementor-addons' ),
				'all_label' => __( 'Posts Archive', 'zyre-elementor-addons' ),
				'is_pro' => true,
			],
		];

		return apply_filters( 'zyreaddons/conditions/archive', $conditions );
	}

	private function singular_conditions() {
		$conditions = [
			'all' => [
				'title' => __( 'All Singular', 'zyre-elementor-addons' ),
				'all_label' => __( 'All Singular', 'zyre-elementor-addons' ),
				'is_pro' => false,
			],
			'front_page' => [
				'title' => __( 'Front Page', 'zyre-elementor-addons' ),
				'all_label' => __( 'Front Page', 'zyre-elementor-addons' ),
				'is_pro' => false,
			],
			'post_group' => [
				'title' => __( 'Posts', 'zyre-elementor-addons' ),
				'all_label' => __( 'Posts', 'zyre-elementor-addons' ),
				'type' => 'condition-group',
				'conditions' => [
					'post' => [
						'title' => __( 'Posts', 'zyre-elementor-addons' ),
						'all_label' => __( 'All Posts', 'zyre-elementor-addons' ),
						'is_pro' => true,
					],
					'in_category' => [
						'title' => __( 'In Category', 'zyre-elementor-addons' ),
						'all_label' => __( 'Site', 'zyre-elementor-addons' ),
						'is_pro' => true,
					],
					'in_category_children' => [
						'title' => __( 'In Category', 'zyre-elementor-addons' ),
						'all_label' => __( 'Site', 'zyre-elementor-addons' ),
						'is_pro' => true,
					],
					'in_post_tag' => [
						'title' => __( 'In Tag', 'zyre-elementor-addons' ),
						'all_label' => __( 'Site', 'zyre-elementor-addons' ),
						'is_pro' => true,
					],
					'post_by_author' => [
						'title' => __( 'Posts By Author', 'zyre-elementor-addons' ),
						'all_label' => __( 'Posts By Author', 'zyre-elementor-addons' ),
						'is_pro' => true,
					],
				],
			],
			'page_group' => [
				'title' => __( 'Page', 'zyre-elementor-addons' ),
				'all_label' => __( 'Site', 'zyre-elementor-addons' ),
				'type' => 'condition-group',
				'is_pro' => true,
				'conditions' => [
					'page' => [
						'title' => __( 'Pages', 'zyre-elementor-addons' ),
						'all_label' => __( 'All Pages', 'zyre-elementor-addons' ),
						'is_pro' => true,
					],
					'page_by_author' => [
						'title' => __( 'Pages By Author', 'zyre-elementor-addons' ),
						'all_label' => __( 'Pages By Author', 'zyre-elementor-addons' ),
						'is_pro' => true,
					],
				],
			],
			'child_of' => [
				'title' => __( 'Direct Child Of', 'zyre-elementor-addons' ),
				'all_label' => __( 'Direct Child Of', 'zyre-elementor-addons' ),
				'is_pro' => true,
			],
			'any_child_of' => [
				'title' => __( 'Any Child Of', 'zyre-elementor-addons' ),
				'all_label' => __( 'Any Child Of', 'zyre-elementor-addons' ),
				'is_pro' => true,
			],
			'by_author' => [
				'title' => __( 'By Author', 'zyre-elementor-addons' ),
				'all_label' => __( 'By Author', 'zyre-elementor-addons' ),
				'is_pro' => true,
			],
			'not_found404' => [
				'title' => __( '404 Page', 'zyre-elementor-addons' ),
				'all_label' => __( '404 Page', 'zyre-elementor-addons' ),
				'is_pro' => true,
			],
		];

		return apply_filters( 'zyreaddons/conditions/singular', $conditions );
	}

	protected function flatten_singular_array( $arr ) {
		$post_sub_cond = array_keys( $arr['post_group']['conditions'] );
		$page_sub_cond = array_keys( $arr['page_group']['conditions'] );

		unset( $arr['post_group'] );
		unset( $arr['page_group'] );

		$keys = array_keys( $arr );
		$keys = array_merge( $keys, $post_sub_cond, $page_sub_cond );

		return $keys;
	}

	protected function process_condition() {
		$conditions = array(
			'name' => array_keys( $this->initial_conditions() ),
			'sub_name' => array(
				'archive' => array_keys( $this->archive_conditions() ),
				'singular' => $this->flatten_singular_array( $this->singular_conditions() ),
			),
		);

		$tmp_singular = $this->singular_conditions();
		$tmp_post = $tmp_singular['post_group']['conditions'];
		$tmp_page = $tmp_singular['page_group']['conditions'];

		unset( $tmp_singular['post_group'] );
		unset( $tmp_singular['page_group'] );

		$all_cond_list = $this->initial_conditions() + $this->archive_conditions() + $tmp_singular + $tmp_post + $tmp_page;

		$this->all_conds_list = $all_cond_list;
		$this->all_conds = $conditions;
	}

	public static function is_the_same_author( $post_id ) {
		$author_id = get_post_field( 'post_author', $post_id );
		return ( get_current_user_id() == $author_id );
	}

	protected function validate_reqeust() {
		$nonce = ! empty( $_REQUEST['nonce'] ) ? $_REQUEST['nonce'] : '';
		$template_id = isset( $_REQUEST['template_id'] ) ? absint( $_REQUEST['template_id'] ) : null;

		if ( ! wp_verify_nonce( $nonce, 'zyre_editor_nonce' ) ) {
			throw new Exception( 'Invalid request' );
		}

		if ( ! current_user_can( 'edit_posts' ) ) {
			throw new Exception( 'Unauthorized request' );
		}

		$post_status = get_post_status( $template_id );
		$same_author = self::is_the_same_author( $template_id );

		if ( ( 'private' === $post_status || 'draft' === $post_status ) && ! $same_author ) {
			throw new Exception( 'Unauthorized request' );
		}

		if ( post_password_required( $template_id ) && ! $same_author ) {
			throw new Exception( 'Unauthorized request' );
		}
	}

	private function process_post() {
		$post_type    = ! empty( $_REQUEST['object_term'] ) ? sanitize_text_field( $_REQUEST['object_term'] ) : 'any';
		$query_term   = ! empty( $_REQUEST['q'] ) ? sanitize_text_field( $_REQUEST['q'] ) : '';

		$args = [
			'post_type'        => $post_type,
			'suppress_filters' => false,
			'posts_per_page'   => -1,
			'orderby'          => 'title',
			'order'            => 'ASC',
			'post_status'      => 'publish',
		];

		if ( $query_term ) {
			$args['s'] = $query_term;
		}

		$posts = get_posts( $args );

		if ( empty( $posts ) ) {
			return [];
		}

		$out = [];

		foreach ( $posts as $post ) {
			$out[ "{$post->ID}" ] = esc_html( $post->post_title );
		}

		return $out;
	}

	public function process_term() {
		$term_taxonomy = ! empty( $_REQUEST['object_term'] ) ? sanitize_text_field( $_REQUEST['object_term'] ) : '';
		$query_term    = ! empty( $_REQUEST['q'] ) ? sanitize_text_field( $_REQUEST['q'] ) : '';

		$prefix = __( 'Categories: ', 'zyre-elementor-addons' );

		if ( 'post_tag' === $term_taxonomy ) {
			$prefix = __( 'Tags: ', 'zyre-elementor-addons' );
		}

		if ( empty( $term_taxonomy ) ) {
			throw new Exception( 'Invalid taxonomy' );
		}

		$args = [
			'taxonomy'   => $term_taxonomy,
			'hide_empty' => false,
			'orderby'    => 'name',
			'order'      => 'ASC',
			'number'     => -1,
		];

		if ( $query_term ) {
			$args['search'] = $query_term;
		}

		$terms = get_terms( $args );

		if ( empty( $terms ) || is_wp_error( $terms ) ) {
			return [];
		}

		$out = [];

		foreach ( $terms as $term ) {
			$title = ! empty( $query_term ) ? $prefix . $term->name : $prefix . $term->name;
			$out[ "{$term->term_id}" ] = $title;
		}

		return $out;
	}

	public function condition_autocomplete() {
		try {
			$this->validate_reqeust();

			$object_type = ! empty( $_REQUEST['object_type'] ) ? trim( sanitize_text_field( $_REQUEST['object_type'] ) ) : '';

			if ( ! in_array( $object_type, [ 'post', 'tax', 'author', 'archive', 'singular' ], true ) ) {
				throw new Exception( __( 'Invalid object type', 'zyre-elementor-addons' ) );
			}

			$response = [];

			if ( 'post' === $object_type ) {
				$response = $this->process_post();
			}

			if ( 'tax' === $object_type ) {
				$response = $this->process_term();
			}

			if ( 'singular' === $object_type ) {
				$response = $this->singular_conditions();
			}

			if ( 'archive' === $object_type ) {
				$response = $this->archive_conditions();
			}

			wp_send_json_success( $response );
		} catch ( Exception $e ) {
			wp_send_json_error( $e->getMessage() );
		}
	}

	public function get_all_conditions() {
		$conditions = [];

		// WP_Query arguments
		$args = array(
			'post_type'              => array( 'zyre_library' ),
			'post_status'            => array( 'publish' ),
			'posts_per_page'         => -1,
			'order'                  => 'DESC',
			'orderby'                => 'date',
			'meta_query'             => array(
				array(
					'key' => '_zyre_display_cond',
					'compare' => 'EXISTS',
				),
			),
		);

		// The Query
		$query = new \WP_Query( $args );

		// The Loop
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();

				$saved_conditions = get_post_meta( get_the_ID(), '_zyre_display_cond', true );
				$tpl_type = get_post_meta( get_the_ID(), '_zyre_library_type', true );

				if ( is_array( $saved_conditions ) ) {
					foreach ( $saved_conditions as $condition ) {
						$conditions[ $tpl_type ][] = $condition;
					}
				}
			}
		}

		// Restore original Post Data
		wp_reset_postdata();

		return $conditions;
	}

	private function check_template_conditions( $template_type = '', $request_conditions = [], $merged_conditions = [], $exits_conditions = [] ) {
		$result = false;
		if ( ! $template_type && ! $request_conditions && ! $merged_conditions && ! $exits_conditions ) {
			return $result;
		}

		$new_requests = [];
		foreach ( $request_conditions as $val ) {
			$new_requests[] = substr( strstr( $val, '/' ), strlen( '/' ) );
		}

		if ( count( $new_requests ) !== count( array_unique( $new_requests ) ) ) {
			$result = true;
			return $result;
		}

		$generated_conditions = [];
		foreach ( $merged_conditions as $key => $value ) {
			$generated_conditions[] = substr( strstr( $value, '/' ), strlen( '/' ) );
		}

		$filtered_conditions = [];
		$existing_type_condition = isset( $exits_conditions[ $template_type ] ) ? $exits_conditions[ $template_type ] : [];
		foreach ( $existing_type_condition as $key => $value ) {
			$filtered_conditions[] = substr( strstr( $value, '/' ), strlen( '/' ) );
		}

		foreach ( $generated_conditions as $key => $value ) {
			if ( in_array( $value, $filtered_conditions, true ) ) {
				$result = true;
				break;
			}
		}

		return $result;
	}

	public function condition_update() {
		try {
			$this->validate_reqeust();
			$template_id = isset( $_REQUEST['template_id'] ) ? absint( $_REQUEST['template_id'] ) : null;
			$request_conditions = isset( $_REQUEST['conds'] ) ? zyre_sanitize_array_recursively( $_REQUEST['conds'] ) : [];

			$exits_conditions = get_post_meta( $template_id, '_zyre_display_cond', true );
			$merged_conditions = ! empty( $exits_conditions ) ? array_diff( $request_conditions, $exits_conditions ) : $request_conditions;

			if ( $template_id ) {

				$all_extits_condition = $this->get_all_conditions();
				$template_type = get_post_meta( $template_id, '_zyre_library_type', true );

				$duplicate = $this->check_template_conditions( $template_type, $request_conditions, $merged_conditions, $all_extits_condition );

				if ( ! $duplicate ) {
					$cond = update_post_meta( $template_id, '_zyre_display_cond', array_unique( $request_conditions ) );
					$updates = get_post_meta( $template_id, '_zyre_display_cond' );

					if ( null !== $cond ) {
						$this->cache->regenerate();
						wp_send_json_success( $updates );
					} else {
						wp_send_json_error();
					}
				} else {
					wp_send_json_error( [ 'msg' => esc_html__( 'Unable to save, as conflicting include and exclude conditions were detected. Please adjust the conditions accordingly.', 'zyre-elementor-addons' ) ] );
				}
			} else {
				wp_send_json_error();
			}
		} catch ( Exception $e ) {
			wp_send_json_error( $e->getMessage() );
		}
	}

	public function get_template_type() {
		try {
			$id = isset( $_REQUEST['post_id'] ) ? absint( $_REQUEST['post_id'] ) : null;
			if ( $id ) {
				$tpl_type = get_post_meta( $id, '_zyre_library_type', true );
				wp_send_json_success( $tpl_type );
			} else {
				wp_send_json_error();
			}
		} catch ( Exception $e ) {
			wp_send_json_error( $e->getMessage() );
		}
	}

	public function get_current_condition() {
		try {
			$template_id = isset( $_REQUEST['template_id'] ) ? absint( $_REQUEST['template_id'] ) : null;
			if ( $template_id ) {
				$cond = get_post_meta( $template_id, '_zyre_display_cond', true );
				if ( $cond ) {
					ob_start();
					$this->cond_to_html( $cond );
					$html = ob_get_contents();
					ob_end_clean();
					wp_send_json_success( $html );
				} else {
					wp_send_json_error();
				}
			} else {
				wp_send_json_error();
			}
		} catch ( Exception $e ) {
			wp_send_json_error( $e->getMessage() );
		}
	}

	private function cond_to_html( $cond ) {
		$html = '';
		foreach ( $cond as $condition ) {
			$parsed_condition = $this->parse_condition( $condition );

			$include = $parsed_condition['type'];
			$name = $parsed_condition['name'];
			$sub_name = $parsed_condition['sub_name'];
			$sub_id = $parsed_condition['sub_id'];

			$sub_name_html = ( $sub_name ) ? '<option value="' . $sub_name . '" selected="selected">' . $this->all_conds_list[ $sub_name ]['title'] . '</option>' : '';

			$sub_id_html = ( $sub_id ) ? '<option value="' . $sub_id . '" selected="selected">' . get_the_title( $sub_id ) . '</option>' : '';

			$uuid = uniqid();
			$if = function ( $condition, $true, $false ) {
				return $condition ? $true : $false;
			};

			$sub_name_visibility = ( $sub_name ) ? '' : 'style="display:none"';
			$sub_id_visibility = ( $sub_id ) ? '' : 'style="display:none"';

			$icon = zyre_get_svg_icon( 'trash-can' );

			$html .= <<<EOF
			<div id="zyre-template-condition-item-$uuid" class="zyre-template-condition-item">
				<div class="zyre-template-condition-item-row">
					<div class="zyre-tce-type">
						<select data-id="type-$uuid" data-parent="$uuid" data-setting="type" data-selected="$include" class="modal__form-select">
							<option value="include" {$if($include == 'include', "selected", "")}>Include</option>
							<option value="exclude" {$if($include == 'exclude', "selected", "")}>Exclude</option>
						</select>
					</div>
					<div class="zyre-tce-name">
						<select data-id="name-$uuid" data-parent="$uuid" data-setting="name" data-selected="$name" class="modal__form-select">
							<optgroup label="General">
								<option value="general" {$if($name == 'general', "selected", "")}>Entire Site</option>
								<option value="archive" {$if($name == 'archive', "selected", "")}>Archives</option>
								<option value="singular" {$if($name == 'singular', "selected", "")}>Singular</option>
							</optgroup>
						</select>
					</div>
					<div class="zyre-tce-sub_name" $sub_name_visibility>
						<select data-id="sub_name-$uuid" data-parent="$uuid" data-setting="sub_name" data-selected="$sub_name" class="modal__form-select">
						$sub_name_html
						</select>
					</div>
					<div class="zyre-tce-sub_id" $sub_id_visibility>
						<select data-id="sub_id-$uuid" data-parent="$uuid" data-setting="sub_id" data-selected="$sub_id" class="modal__form-select">
						$sub_id_html
						</select>
					</div>
				</div>
				<div class="zyre-template-condition-remove">
					{$icon}
					<span class="elementor-screen-only">Remove this item</span>
				</div>
			</div>
			EOF;
		}

		echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

Conditions_Manager::instance();
