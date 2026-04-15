<?php

namespace VertexMediaLLC\ZyreElementorAddons\Modules\ThemeBuilder;

defined( 'ABSPATH' ) || die();

use Exception;

class Conditions_Manager {
	public static $instance = null;

	private $cache;
	private $location_cache = [];

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {
		$this->cache = new Conditions_Cache();

		add_action( 'wp_ajax_zyreladdons_condition_autocomplete', [ $this, 'condition_autocomplete' ] );
		add_action( 'wp_ajax_zyreladdons_condition_update', [ $this, 'condition_update' ] );
		add_action( 'wp_ajax_zyreladdons_condition_template_type', [ $this, 'get_template_type' ] );
		add_action( 'wp_ajax_zyreladdons_condition_current', [ $this, 'get_current_condition' ] );
	}

	protected function parse_condition( $condition ) {
		list( $type, $name, $sub_name, $sub_id ) = array_pad( explode( '/', $condition ), 4, '' );

		return compact( 'type', 'name', 'sub_name', 'sub_id' );
	}

	private function get_condition( $cond_name ) {
		$all_conds = $this->process_conditions();
		return $all_conds[ $cond_name ];
	}

	private function check_name( $name ) {
		$conds = $this->get_condition( 'name' );
		if ( 'general' === $name ) {
			return in_array( $name, $conds );
		}
		return in_array( $name, $conds ) && $this->check_wp_page( $name );
	}

	private function check_sub_name( $sub_name ) {
		return $this->check_wp_page( $sub_name );
	}

	private function check_sub_id( $sub_name, $sub_id ) {
		return $this->check_wp_page( $sub_name, $sub_id );
	}

	private function check_wp_page( $name, $sub_id = '' ) {
		$check_page = false;

		switch ( $name ) {
			case 'archive':
				$check_page = is_archive() || is_home() || is_search();
				// If installed then let WooCommerce handle it.
				if ( $check_page && class_exists( 'woocommerce' ) && \is_woocommerce() ) {
					$check_page = false;
				}
				break;
			case 'singular':
				$check_page = ( is_singular() && ! is_embed() ) || is_404();
				break;
		}

		$check_page = apply_filters( 'zyreladdons/conditions/check_wp_page', $check_page, $name, $sub_id );

		return $check_page;
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

	public function get_theme_templates_ids( $location ) {
		$templates = $this->get_location_templates( $location );
		return $templates;
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
					$condition_pass = $this->check_sub_name( $sub_name );
				}

				if ( $condition_pass && $sub_id ) {
					$condition_pass = $this->check_sub_id( $sub_name, $sub_id );
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
		$all_conds_list = $this->process_conditions_list();
		return $all_conds_list[ $cond ]['title'] ?? '';
	}

	public function get_all_name( $cond ) {
		$all_conds_list = $this->process_conditions_list();
		return $all_conds_list[ $cond ]['all_label'] ?? '';
	}

	public function get_conditions_list( $type = 'initial' ) {
		$conditions = [];

		switch ( $type ) {
			case 'initial':
				$conditions = $this->initial_conditions();
				break;
			case 'archive':
				$conditions = $this->archive_conditions();
				break;
			case 'singular':
				$conditions = $this->singular_conditions();
				break;
		}

		return $conditions;
	}

	private function initial_conditions() {
		$conditions_default = [
			'general' => [
				'title' => __( 'Entire Site', 'zyre-elementor-addons' ),
				'all_label' => __( 'Entire Site', 'zyre-elementor-addons' ),
			],
			'archive' => [
				'title' => __( 'Archives', 'zyre-elementor-addons' ),
				'all_label' => __( 'All Archives', 'zyre-elementor-addons' ),
			],
			'singular' => [
				'title' => __( 'Singular', 'zyre-elementor-addons' ),
				'all_label' => __( 'All Singular', 'zyre-elementor-addons' ),
			],
		];

		$conditions = apply_filters( 'zyreladdons/conditions/initial', $conditions_default );
		return $conditions;
	}

	private function get_archive_conditions() {
		$conditions = [
			'' => [
				'title' => __( 'All Archives', 'zyre-elementor-addons' ),
				'all_label' => __( 'All Archives', 'zyre-elementor-addons' ),
			],
		];

		return apply_filters( 'zyreladdons/conditions/archive', $conditions );
	}

	private function process_conditions() {
		$conditions = array(
			'name' => array_keys( $this->initial_conditions() ),
			'sub_name' => array(
				'archive' => array_keys( $this->archive_conditions() ),
				'singular' => $this->flatten_singular_array( $this->singular_conditions() ),
			),
		);

		return $conditions;
	}

	private function process_conditions_list() {
		$tmp_singular = $this->singular_conditions();
		$all_cond_list = $this->initial_conditions() + $this->archive_conditions() + $tmp_singular;
		$all_cond_list = apply_filters( 'zyreladdons/conditions/all_conditions_list', $all_cond_list );

		unset($all_cond_list['']);

		$unset_groups = [ 'post_group', 'page_group' ];
		$unset_groups = apply_filters( 'zyreladdons/conditions/process/unset/groups', $unset_groups );
		
		foreach ( $unset_groups as $key ) {
			if ( isset( $all_cond_list[ $key ]['conditions'] ) ) {
				$all_cond_list += $all_cond_list[ $key ]['conditions'];
				unset($all_cond_list[ $key ]);
			}
		}
		
		return $all_cond_list;
	}

	protected function flatten_singular_array( $arr ) {
		$post_sub_cond = [];
		$page_sub_cond = [];

		if ( isset( $arr['post_group']['conditions'] ) ) {
			$post_sub_cond = array_keys( $arr['post_group']['conditions'] );
			unset( $arr['post_group'] );
		}

		if ( isset( $arr['page_group']['conditions'] ) ) {
			$page_sub_cond = array_keys( $arr['page_group']['conditions'] );
			unset( $arr['page_group'] );
		}

		$keys = array_keys( $arr );
		$keys = array_merge( $keys, $post_sub_cond, $page_sub_cond );

		return $keys;
	}

	public static function is_the_same_author( $post_id ) {
		$author_id = get_post_field( 'post_author', $post_id );
		return ( get_current_user_id() == $author_id );
	}

	protected function validate_reqeust( $nonce = '' ) {
		if ( ! current_user_can( 'edit_posts' ) ) {
			throw new Exception( esc_html__( 'Unauthorized request', 'zyre-elementor-addons' ) );
		}

		$nonce = sanitize_text_field( wp_unslash( $nonce ?: $_GET['nonce'] ) );

		if ( ! wp_verify_nonce( $nonce, 'zyreladdons_editor_nonce' ) ) {
			throw new Exception( esc_html__( 'Invalid request', 'zyre-elementor-addons' ) );
		}
	}

	public function condition_autocomplete() {
		try {
			$this->validate_reqeust();

			$object_type = ! empty( $_GET['object_type'] ) ? sanitize_text_field( wp_unslash( $_GET['object_type'] ) ) : '';

			$object_types = [ 'post', 'singular', 'tax', 'archive', 'author' ];
			$object_types = apply_filters( 'zyreladdons/conditions/autocomplete/object_types', $object_types );

			if ( ! in_array( $object_type, $object_types, true ) ) {
				throw new Exception( esc_html__( 'Invalid object type', 'zyre-elementor-addons' ) );
			}

			$response = [];

			if ( 'post' === $object_type ) {
				$response = $this->process_post();
			}

			if ( 'singular' === $object_type ) {
				$response = $this->singular_conditions();
			}

			if ( 'tax' === $object_type ) {
				$response = $this->process_term();
			}

			if ( 'archive' === $object_type ) {
				$response = $this->archive_conditions();
			}

			if ( 'author' === $object_type ) {
				$response = $this->process_author();
			}

			$response = apply_filters( 'zyreladdons/conditions/autocomplete', $response, $object_type );

			wp_send_json_success( $response );
		} catch ( Exception $e ) {
			wp_send_json_error( $e->getMessage() );
		}
	}

	private function process_post() {
		$post_type  = sanitize_text_field( wp_unslash( $_GET['object_term'] ?? 'any' ) );
    	$query_term = sanitize_text_field( wp_unslash( $_GET['q'] ?? '' ) );

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
			$out[ (string) $post->ID ] = esc_html( $post->post_title );
		}

		return $out;
	}

	private function singular_conditions() {
		$conditions = [
			'' => [
				'title' => __( 'All Singular', 'zyre-elementor-addons' ),
				'all_label' => __( 'All Singular', 'zyre-elementor-addons' ),
			],
			'front_page' => [
				'title' => __( 'Front Page', 'zyre-elementor-addons' ),
				'all_label' => __( 'Front Page', 'zyre-elementor-addons' ),
			],
		];

		return apply_filters( 'zyreladdons/conditions/singular', $conditions );
	}

	public function process_term() {
		$term_taxonomy = sanitize_text_field( wp_unslash( $_GET['object_term'] ?? '' ) );
    	$query_term    = sanitize_text_field( wp_unslash( $_GET['q'] ?? '' ) );

		if ( empty( $term_taxonomy ) ) {
			throw new Exception( esc_html__( 'Invalid taxonomy', 'zyre-elementor-addons' ) );
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
			$out[ (string) $term->term_id ] = $term->name;
		}

		return $out;
	}

	private function archive_conditions() {
		return $this->get_archive_conditions();
	}

	public function process_author() {
		$query_term = ! empty( $_GET['q'] ) ? sanitize_text_field( wp_unslash( $_GET['q'] ) ) : '';

		$args = [
			'who' => 'authors',
			'orderby' => 'display_name',
			'order' => 'ASC',
			'number' => -1,
		];

		if ( $query_term ) {
			$args['search'] = "*{$query_term}*";
			$args['search_columns'] = [ 'user_nicename', 'user_login', 'display_name' ];
		}

		$authors = get_users( $args );

		if ( empty( $authors ) ) {
			return [];
		}

		$out = [];

		foreach ( $authors as $author ) {
			$out[ "{$author->ID}" ] = esc_html( $author->display_name );
		}

		return $out;
	}

	public function get_all_conditions() {
		$conditions = [];

		// WP_Query arguments
		$args = array(
			'post_type'              => array( 'zyreladdons_library' ),
			'post_status'            => array( 'publish' ),
			'posts_per_page'         => -1,
			'order'                  => 'DESC',
			'orderby'                => 'date',
			'meta_query'             => array(
				array(
					'key' => 'zyreladdons_display_cond',
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

				$saved_conditions = get_post_meta( get_the_ID(), 'zyreladdons_display_cond', true );
				$tpl_type = get_post_meta( get_the_ID(), 'zyreladdons_library_type', true );

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
			$this->validate_reqeust( $_POST['nonce'] );

			$template_id = isset( $_POST['template_id'] ) ? absint( $_POST['template_id'] ) : null;

			$post_status = get_post_status( $template_id );
			$same_author = self::is_the_same_author( $template_id );

			if ( ( 'private' === $post_status || 'draft' === $post_status ) && ! $same_author ) {
				throw new Exception( esc_html__( 'Unauthorized request', 'zyre-elementor-addons' ) );
			}

			if ( post_password_required( $template_id ) && ! $same_author ) {
				throw new Exception( esc_html__( 'Unauthorized request', 'zyre-elementor-addons' ) );
			}

			$request_conditions = isset( $_POST['conds'] ) ? zyreladdons_sanitize_array_recursively( wp_unslash( $_POST['conds'] ) ) : [];

			$exits_conditions = get_post_meta( $template_id, 'zyreladdons_display_cond', true );
			$merged_conditions = ! empty( $exits_conditions ) ? array_diff( $request_conditions, $exits_conditions ) : $request_conditions;

			if ( $template_id ) {

				$all_extits_condition = $this->get_all_conditions();
				$template_type = get_post_meta( $template_id, 'zyreladdons_library_type', true );

				$duplicate = $this->check_template_conditions( $template_type, $request_conditions, $merged_conditions, $all_extits_condition );

				if ( ! $duplicate ) {
					$cond = update_post_meta( $template_id, 'zyreladdons_display_cond', array_unique( $request_conditions ) );
					$updates = get_post_meta( $template_id, 'zyreladdons_display_cond' );

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
			self::validate_reqeust();

			$id = isset( $_GET['post_id'] ) ? absint( $_GET['post_id'] ) : null;
			if ( $id ) {
				$tpl_type = get_post_meta( $id, 'zyreladdons_library_type', true );
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
			self::validate_reqeust();

			$template_id = isset( $_GET['template_id'] ) ? absint( $_GET['template_id'] ) : null;
			if ( $template_id ) {
				$cond = get_post_meta( $template_id, 'zyreladdons_display_cond', true );
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

		$all_conds_list = $this->process_conditions_list();

		foreach ( $cond as $condition ) {
			$parsed_condition = $this->parse_condition( $condition );

			$include  = $parsed_condition['type'];
			$name     = $parsed_condition['name'];
			$sub_name = $parsed_condition['sub_name'];
			$sub_id   = $parsed_condition['sub_id'];

			$title = Module::get_condition_title( $sub_name, $sub_id );

			$uuid = uniqid();

			$sub_name_html = $sub_name
				? '<option value="' . esc_attr( $sub_name ) . '" selected="selected">' . esc_html( $all_conds_list[ $sub_name ]['title'] ) . '</option>'
				: '';

			$sub_id_html = $sub_id
				? '<option value="' . esc_attr( $sub_id ) . '" selected="selected">' . esc_html( $title ) . '</option>'
				: '';

			$icon = zyreladdons_get_svg_icon( 'trash-can' );

			ob_start();
			?>
			<div id="zyre-template-condition-item-<?php echo esc_attr( $uuid ); ?>" class="zyre-template-condition-item">
				<div class="zyre-template-condition-item-row">

					<div class="zyre-tce-type">
						<select
                            id="type-<?php echo esc_attr( $uuid ); ?>"
							data-id="type-<?php echo esc_attr( $uuid ); ?>"
							data-parent="<?php echo esc_attr( $uuid ); ?>"
							data-setting="type"
							data-selected="<?php echo esc_attr( $include ); ?>"
							class="modal__form-select">
							<option value="include" <?php selected( $include, 'include' ); ?>>Include</option>
							<option value="exclude" <?php selected( $include, 'exclude' ); ?>>Exclude</option>
						</select>
					</div>

					<div class="zyre-tce-name">
						<select
							id="name-<?php echo esc_attr( $uuid ); ?>"
							data-id="name-<?php echo esc_attr( $uuid ); ?>"
							data-parent="<?php echo esc_attr( $uuid ); ?>"
							data-setting="name"
							data-selected="<?php echo esc_attr( $name ); ?>"
							class="modal__form-select">
							<?php if ( ! empty( $this->get_conditions_list() ) ) : ?>
							<optgroup label="General">
								<?php foreach ( $this->get_conditions_list() as $key => $cond ) : ?>
									<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $name, $key ); ?>><?php echo esc_html( $cond['title'] ); ?></option>
								<?php endforeach; ?>
							</optgroup>
							<?php endif; ?>
						</select>
					</div>

					<div class="zyre-tce-sub_name<?php echo $sub_name ? '' : ' zyre-d-none'; ?>">
						<select
							id="sub_name-<?php echo esc_attr( $uuid ); ?>"
							data-id="sub_name-<?php echo esc_attr( $uuid ); ?>"
							data-parent="<?php echo esc_attr( $uuid ); ?>"
							data-setting="sub_name"
							data-selected="<?php echo esc_attr( $sub_name ); ?>"
							class="modal__form-select">
							<?php
							echo wp_kses(
								$sub_name_html,
								[
									'option'   => [
										'value'    => [],
										'selected' => [],
									],
									'optgroup' => [
										'label' => [],
									],
								]
							);
							?>
						</select>
					</div>

                    <div class="zyre-tce-sub_id<?php echo $sub_id ? '' : ' zyre-d-none'; ?>">
						<select
							id="sub_id-<?php echo esc_attr( $uuid ); ?>"
							data-id="sub_id-<?php echo esc_attr( $uuid ); ?>"
							data-parent="<?php echo esc_attr( $uuid ); ?>"
							data-setting="sub_id"
							data-selected="<?php echo esc_attr( $sub_id ); ?>"
							class="modal__form-select">
							<?php
							echo wp_kses(
								$sub_id_html,
								[
									'option'   => [
										'value'    => [],
										'selected' => [],
									],
									'optgroup' => [
										'label' => [],
									],
								]
							);
							?>
						</select>
					</div>

				</div>

				<div class="zyre-template-condition-remove">
					<?php echo wp_kses( $icon, zyreladdons_allowed_icon_html() ); ?>
					<span class="elementor-screen-only"><?php esc_html_e( 'Remove this item', 'zyre-elementor-addons' ); ?></span>
				</div>
			</div>
			<?php
			echo ob_get_clean(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
}

Conditions_Manager::instance();
