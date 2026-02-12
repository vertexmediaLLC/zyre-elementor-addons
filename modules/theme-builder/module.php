<?php

/**
 * Theme Builder
 *
 * Package: ZyreAddons
 * @since 1.0.0
 */

namespace ZyreAddons\Elementor\ThemeBuilder;

use ZyreAddons\Elementor\Dashboard;
use Elementor\Core\Settings\Manager;

defined( 'ABSPATH' ) || die();

class Module {
	public static $instance = null;

	const POST_TYPE = 'zyre_library';
	const TAB_BASE = 'edit.php?post_type=' . self::POST_TYPE;

	private $cache;

	protected $current_theme;
	protected $current_location;

	protected $templates;
	public $singular_template;
	public $single_template;
	public $header_template;
	public $footer_template;
	protected $current_template;

	public function __construct() {
		add_action( 'wp', [ $this, 'hooks' ] );
		$this->cache = new Conditions_Cache();

		add_action( 'admin_menu', [ $this, 'modify_menu' ], 90 );
		add_filter( 'query_vars', [ $this, 'add_query_vars' ] );
		add_action( 'init', [ $this, 'create_post_type' ], 99 );
		register_activation_hook( ZYRE_ADDONS__FILE__, [ $this, 'on_plugin_activation' ] );
		add_action( 'pre_get_posts', [ $this, 'set_meta_query_to_posts_query' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_assets' ] );

		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'edit_template_condition_modal' ], 10, 2 );
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'template_element_scripts' ], 9 );

		add_action( 'current_screen', function () {
			$current_screen = get_current_screen();
			if ( ! $current_screen || ! strstr( $current_screen->post_type, self::POST_TYPE ) ) {
				return;
			}
			add_action( 'in_admin_header', function () {
				$this->render_admin_top_bar();
			} );
			add_action( 'in_admin_footer', [ $this, 'add_new_template' ], 10, 2 );
		} );

		add_filter( 'views_edit-' . self::POST_TYPE, [ $this, 'render_admin_tabs' ] );

		add_filter( 'elementor/document/config', [ $this, 'document_config_title' ], 10, 2 );
		add_action( 'admin_action_zyre_library_new_post', [ $this, 'admin_action_new_post' ] );

		add_action( 'manage_' . self::POST_TYPE . '_posts_columns', [ $this, 'admin_columns_headers' ] );
		add_action( 'manage_' . self::POST_TYPE . '_posts_custom_column', [ $this, 'admin_columns_content' ], 10, 2 );

		// Override Single Post Template
		add_filter( 'template_include', [ $this, 'template_include' ], 999 );
		add_action( 'zyreaddons_theme_builder_render', [ $this, 'single_blog_content_elementor' ], 999 );

		add_action( 'elementor/elements/categories_registered', [ $this, 'add_elementor_widget_categories' ] );
	}

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	protected function get_full_data( $post ) {
		if ( null !== $post ) {
			$tmpl_type = get_post_meta( $post->ID, '_zyre_library_type', true );
			$tpl_cond = get_post_meta( $post->ID, '_zyre_display_cond', true );

			$parsed_cond = $this->parse_condition( $tpl_cond );
			$conditions = [];

			if ( is_array( $tpl_cond ) ) {
				foreach ( $tpl_cond as $condition ) {
					$conditions[] = $this->parse_condition( $condition );
				}
			}

			return array_merge( (array) $post, [
				'type' => $tmpl_type,
				'condition_a' => $parsed_cond['name'],
				'condition_singular' => $parsed_cond['sub_name'],
				'condition_singular_id' => $parsed_cond['sub_id'],
			]);
		}
	}

	protected function load_template_element( $filters ) {
		$template_id = [];

		if ( null !== $this->templates ) {
			foreach ( $this->templates as $template ) {
				$template = $this->get_full_data( $template );
				$match_found = true;

				// WPML Language Check
				if ( defined( 'ICL_LANGUAGE_CODE' ) ) :
					$current_lang = apply_filters( 'wpml_post_language_details', null, $template['ID'] );

					if ( ! empty( $current_lang ) && ! $current_lang['different_language'] && ( ICL_LANGUAGE_CODE === $current_lang['language_code'] ) ) :
						$template_id[ $template['type'] ] = $template['ID'];
					endif;
				endif;

				foreach ( $filters as $filter ) {
					if ( 'condition_singular_id' === $filter['key'] ) {
						$ids = explode( ',', $template[ $filter['key'] ] );
						if ( ! in_array( $filter['value'], $ids, true ) ) {
							$match_found = false;
						}
					} elseif ( $template[ $filter['key'] ] !== $filter['value'] ) {
						$match_found = false;
					}
					if ( 'condition_a' === $filter['key'] && 'singular' === $template[ $filter['key'] ] && count( $filters ) < 2 ) {
						$match_found = false;
					}
				}

				if ( true === $match_found ) {
					if ( 'header' === $template['type'] ) {
						$this->header_template = isset( $template_id['header'] ) ? $template_id['header'] : $template['ID'];
					}
					if ( 'footer' === $template['type'] ) {
						$this->footer_template = isset( $template_id['footer'] ) ? $template_id['footer'] : $template['ID'];
					}
					if ( 'single' === $template['type'] ) {
						$this->single_template = isset( $template_id['single'] ) ? $template_id['single'] : $template['ID'];
					}
				}
			}
		}
	}

	protected function the_filter() {
		$arg = [
			'posts_per_page'   => -1,
			'orderby'          => 'id',
			'order'            => 'DESC',
			'post_status'      => 'publish',
			'post_type'        => self::POST_TYPE,
		];

		$this->templates = get_posts( $arg );

		$this->templates = null;

		// more conditions can be triggered at once
		// don't use switch case
		// may impliment and callable by dynamic class in future

		// entire site
		if ( ! is_admin() ) {
			$filters = [
				[
					'key'     => 'condition_a',
					'value'   => 'general',
				],
			];
			$this->load_template_element( $filters );
		}

		// all pages, all posts, 404 page
		if ( is_page() ) {
			$filters = [
				[
					'key'     => 'condition_a',
					'value'   => 'singular',
				],
				[
					'key'     => 'condition_singular',
					'value'   => 'all_pages',
				],
			];
			$this->load_template_element( $filters );
		} elseif ( is_single() ) {
			$filters = [
				[
					'key'     => 'condition_a',
					'value'   => 'posts',
				],
			];
			$this->load_template_element( $filters );
		} elseif ( is_404() ) {
			$filters = [
				[
					'key'     => 'condition_a',
					'value'   => 'singular',
				],
				[
					'key'     => 'condition_singular',
					'value'   => '404page',
				],
			];
			$this->load_template_element( $filters );
		}
	}

	public static function template_ids() {
		$cached = wp_cache_get( 'zyre_template_ids' );
		if ( false !== $cached ) {
			return $cached;
		}

		$instance = self::instance();
		$instance->the_filter();

		$ids = [
			$instance->header_template,
			$instance->footer_template,
			$instance->singular_template,
		];

		if ( null !== $instance->header_template ) {
			if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
				$css_file = new \Elementor\Core\Files\CSS\Post( $instance->header_template );
				$css_file->enqueue();
			}
		}

		if ( null !== $instance->footer_template ) {
			if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
				$css_file = new \Elementor\Core\Files\CSS\Post( $instance->footer_template );
				$css_file->enqueue();
			}
		}

		wp_cache_set( 'zyre_template_ids', $ids );
		return $ids;
	}

	public function hooks() {
		$this->current_template = basename( get_page_template_slug() );
		if ( 'elementor_canvas' === $this->current_template ) {
			return;
		}

		$this->current_theme = get_template();

		switch ( $this->current_theme ) {
			case 'astra':
				new Compatibility\Astra( self::template_ids() );
				break;

			case 'bb-theme':
			case 'bb-theme-child':
				new Compatibility\Bbtheme( self::template_ids() );
				break;

			case 'generatepress':
			case 'generatepress-child':
				new Compatibility\Generatepress( self::template_ids() );
				break;

			case 'genesis':
			case 'genesis-child':
				new Compatibility\Genesis( self::template_ids() );
				break;

			case 'oceanwp':
			case 'oceanwp-child':
				new Compatibility\Oceanwp( self::template_ids() );
				break;

			case 'twentynineteen':
				new Compatibility\TwentyNineteen( self::template_ids() );
				break;

			default:
				new Theme_Support();
				break;
		}
	}

	// Modify the existing admin menu
	public function modify_menu() {
		add_submenu_page(
			Dashboard::PAGE_SLUG, // Parent slug
			__( 'Theme Builder', 'zyre-elementor-addons' ), // Page title
			__( 'Theme Builder', 'zyre-elementor-addons' ), // Menu title
			'manage_options',
			'edit.php?post_type=' . self::POST_TYPE,
			false
		);
	}

	public function add_query_vars( $vars ) {
		$vars[] = 'zyre_library_type';
		return $vars;
	}

	public function enqueue_assets() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		wp_enqueue_style(
			'zyre-elementor-addons-admin',
			ZYRE_ADDONS_ASSETS . 'admin/css/admin.css',
			null,
			ZYRE_ADDONS_VERSION
		);

		wp_enqueue_script(
			'micromodal',
			ZYRE_ADDONS_ASSETS . 'libs/micromodal/micromodal.min.js',
			[],
			ZYRE_ADDONS_VERSION,
			true
		);

		wp_enqueue_script(
			'zyre-elementor-addons-admin',
			ZYRE_ADDONS_ASSETS . 'admin/js/admin.js',
			[ 'jquery', 'micromodal' ],
			ZYRE_ADDONS_VERSION,
			true
		);
	}

	public function edit_template_condition_modal() {
		if ( self::POST_TYPE === get_post_type() ) {
			ob_start();
			include ZYRE_ADDONS_DIR_PATH . 'modules/theme-builder/templates/template-conditions.php';
			$template = ob_get_clean();
			echo $template; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}

	public function template_element_scripts() {
		if ( self::POST_TYPE === get_post_type() ) {
			wp_enqueue_style(
				'zyre-addons-template-modal',
				ZYRE_ADDONS_DIR_URL . 'modules/theme-builder/assets/css/template-modal.css',
				[ 'elementor-editor' ],
				ZYRE_ADDONS_VERSION
			);

			$theme = Manager::get_settings_managers( 'editorPreferences' )->get_model()->get_settings( 'ui_theme' );

			if ( 'light' !== $theme ) {
				$media_queries = 'all';

				if ( 'auto' === $theme ) {
					$media_queries = '(prefers-color-scheme: dark)';
				}

				wp_enqueue_style(
					'zyre-addons-template-modal-dark',
					ZYRE_ADDONS_DIR_URL . 'modules/theme-builder/assets/css/template-modal-dark.css',
					[ 'zyre-addons-template-modal' ],
					ZYRE_ADDONS_VERSION,
					$media_queries
				);
			}

			wp_enqueue_script(
				'zyre-addons-template-modal',
				ZYRE_ADDONS_DIR_URL . 'modules/theme-builder/assets/js/template-modal.js',
				[ 'jquery', 'zyre-elementor-addons-editor' ],
				ZYRE_ADDONS_VERSION,
				true
			);

			wp_localize_script('zyre-addons-template-modal', 'zyreTemplateInfo', [
				'postType' => self::POST_TYPE,
				'templateType' => get_post_meta( get_the_ID(), '_zyre_library_type', true ),
				'postId' => get_the_ID(),
			]);

			wp_enqueue_script(
				'micromodal',
				ZYRE_ADDONS_ASSETS . 'libs/micromodal/micromodal.min.js',
				[],
				ZYRE_ADDONS_VERSION,
				true
			);
		}
	}

	// Register custom post type
	public function create_post_type() {
		$labels = [
			'name'                  => _x( 'Theme Builder', 'Post Type General Name', 'zyre-elementor-addons' ),
			'singular_name'         => _x( 'Theme Builder', 'Post Type Singular Name', 'zyre-elementor-addons' ),
			'menu_name'             => _x( 'Theme Builder', 'Admin Menu text', 'zyre-elementor-addons' ),
			'name_admin_bar'        => _x( 'Theme Builder', 'Add New on Toolbar', 'zyre-elementor-addons' ),
			'archives'              => __( 'Theme Builder Archives', 'zyre-elementor-addons' ),
			'attributes'            => __( 'Theme Builder Attributes', 'zyre-elementor-addons' ),
			'parent_item_colon'     => __( 'Parent Theme Builder:', 'zyre-elementor-addons' ),
			'all_items'             => __( 'All Theme Builder', 'zyre-elementor-addons' ),
			'add_new_item'          => __( 'Add New Theme Builder', 'zyre-elementor-addons' ),
			'add_new'               => __( 'Add New', 'zyre-elementor-addons' ),
			'new_item'              => __( 'New Theme Builder', 'zyre-elementor-addons' ),
			'edit_item'             => __( 'Edit Theme Builder', 'zyre-elementor-addons' ),
			'update_item'           => __( 'Update Theme Builder', 'zyre-elementor-addons' ),
			'view_item'             => __( 'View Theme Builder', 'zyre-elementor-addons' ),
			'view_items'            => __( 'View Theme Builder', 'zyre-elementor-addons' ),
			'search_items'          => __( 'Search Theme Builder', 'zyre-elementor-addons' ),
			'not_found'             => __( 'Not found', 'zyre-elementor-addons' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'zyre-elementor-addons' ),
			'featured_image'        => __( 'Featured Image', 'zyre-elementor-addons' ),
			'set_featured_image'    => __( 'Set featured image', 'zyre-elementor-addons' ),
			'remove_featured_image' => __( 'Remove featured image', 'zyre-elementor-addons' ),
			'use_featured_image'    => __( 'Use as featured image', 'zyre-elementor-addons' ),
			'insert_into_item'      => __( 'Insert into Theme Builder', 'zyre-elementor-addons' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Theme Builder', 'zyre-elementor-addons' ),
			'items_list'            => __( 'Theme Builder list', 'zyre-elementor-addons' ),
			'items_list_navigation' => __( 'Theme Builder list navigation', 'zyre-elementor-addons' ),
			'filter_items_list'     => __( 'Filter Theme Builder list', 'zyre-elementor-addons' ),
		];

		$args = [
			'label'               => __( 'Theme Builder', 'zyre-elementor-addons' ),
			'description'         => __( 'Build your website header, footer, single page/post template and more.', 'zyre-elementor-addons' ),
			'labels'              => $labels,
			'supports'            => [ 'title', 'elementor' ],
			'taxonomies'          => [],
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => '',
			'show_in_admin_bar'   => false,
			'show_in_nav_menus'   => false,
			'can_export'          => true,
			'has_archive'         => false,
			'hierarchical'        => false,
			'exclude_from_search' => true,
			'capability_type'     => 'page',
		];

		register_post_type( self::POST_TYPE, $args );
	}

	// Fire actions on plugin activation
	public function on_plugin_activation() {
		// Ensure post type is registered before flushing
		$this->create_post_type();

		// Then flush rewrite rules
		flush_rewrite_rules();
	}

	/**
	 * Set custom meta query parameters to posts query.
	 */
	public function set_meta_query_to_posts_query( $query ) {
		if ( ! is_admin() || empty( $query->query['post_type'] ) ) {
			return;
		}

        $post_type = $query->get( 'post_type' );

        if ( empty( $post_type ) ) {
            return;
        }

		global $pagenow;

		// use $query parameter instead of global $post_type
		if ( 'edit.php' === $pagenow && self::POST_TYPE === $post_type ) {

			if ( isset( $_GET['zyre_library_type'] ) ) {
				$meta_query = array(
					array(
						'key' => '_zyre_library_type',
						'value' => sanitize_text_field( $_GET['zyre_library_type'] ),
						'compare' => '==',
					),
				);
				$query->set( 'meta_query', $meta_query );
				$query->set( 'meta_key', '_zyre_library_type' );
			}
		}
	}

	// Render top bar
	private function render_admin_top_bar() {
		?>
		<div class="zyre-admin-top-bar-root">
			<div class="zyre-admin-top-bar">
				<div class="zyre-admin-top-bar-branding">
					<div class="zyre-admin-top-bar-branding-logo">
						<img src="<?php echo zyre_get_b64_3dicon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" alt="" width="46">
					</div>
					<h1 class="zyre-admin-top-bar-branding-title"><?php esc_html_e( 'Theme Builder', 'zyre-elementor-addons' ); ?></h1>
				</div>
				<div class="zyre-admin-top-bar-buttons">
					<a class="button-secondary button-large" id="zyre-template-library-add-new" href="<?php echo esc_url( admin_url( 'post-new.php?post_type=zyre_library' ) ); ?>"><?php esc_html_e( 'Add New', 'zyre-elementor-addons' ); ?></a>
				</div>
			</div>
		</div>
		<?php
	}

	public static function get_template_types() {
		$template_types = [
			'header'  => esc_html__( 'Header', 'zyre-elementor-addons' ),
			'footer'  => esc_html__( 'Footer', 'zyre-elementor-addons' ),
			'single'  => esc_html__( 'Single', 'zyre-elementor-addons' ),
			'archive' => esc_html__( 'Archive', 'zyre-elementor-addons' ),
		];

		return apply_filters( 'zyreaddons/theme-builder/template-types', $template_types );
	}

	public function add_new_template() {
		ob_start();
		include ZYRE_ADDONS_DIR_PATH . 'modules/theme-builder/templates/new-template.php';
		$template = ob_get_clean();
		echo $template; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	// Render tabs in the edit page
	public function render_admin_tabs( $views ) {
		$get_active = get_query_var( 'zyre_library_type' );
		?>
		<div id="zyre-template-library-tabs-wrapper" class="nav-tab-wrapper">
			<a class="nav-tab <?php echo ! $get_active ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( self::TAB_BASE ) ); ?>"><?php esc_html_e( 'All', 'zyre-elementor-addons' ); ?></a>
			<?php
			foreach ( self::get_template_types() as $key => $value ) {
				$active = ( $get_active === $key ) ? 'nav-tab-active' : '';
				$admin_filter_url = admin_url( self::TAB_BASE . '&zyre_library_type=' . $key );
                $nav_tab_link = '<a class="nav-tab ' . $active . '" href="' . esc_url( $admin_filter_url ) . '">' . esc_html( $value ) . '</a>';
				echo wp_kses_post( $nav_tab_link );
			}
			?>
		</div>
		<br>
		<?php
		return $views;
	}

	protected function parse_condition( $condition ) {
		list( $type, $name, $sub_name, $sub_id ) = array_pad( explode( '/', $condition ), 4, '' );
		return compact( 'type', 'name', 'sub_name', 'sub_id' );
	}

	/**
	 * @param Theme_Document $document
	 *
	 * @return array
	 */
	public function get_document_conditions( $post_id ) {
		$saved_conditions = get_post_meta( $post_id, '_zyre_display_cond', true );

		$conditions = [];

		if ( is_array( $saved_conditions ) ) {
			foreach ( $saved_conditions as $condition ) {
				$conditions[] = $this->parse_condition( $condition );
			}
		}

		return $conditions;
	}

	private function get_template_by_location( $location ) {
		$templates = $this->cache->get_by_location( $location );

		return $templates;
	}

	public static function admin_columns_headers( $posts_columns ) {
		$offset = 2;

		$posts_columns = array_slice( $posts_columns, 0, $offset, true ) + [
			'type' => __( 'Type', 'zyre-elementor-addons' ),
			'condition' => __( 'Conditions', 'zyre-elementor-addons' ),
		] + array_slice( $posts_columns, $offset, null, true );

		return $posts_columns;
	}

	public function admin_columns_content( $column_name, $post_id ) {

		if ( 'type' === $column_name ) {

			$type       = get_post_meta( $post_id, '_zyre_library_type', true );
			$is_active   = get_post_meta( $post_id, '_zyre_template_active', true );

			echo ucwords( str_replace( '-', ' ', $type ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			echo "<span id='tmpl-", esc_html( $post_id ), "'>";

			if ( $is_active ) {
				echo ' - <b>' . esc_html__( 'Active', 'zyre-elementor-addons' ) . '</b>';
			}

			echo '</span>';
		}

		if ( 'condition' === $column_name ) {

			$type       = get_post_meta( $post_id, '_zyre_library_type', true );

			if ( 'loop-template' != $type ) {
				// generate display condition from document conditions
				$include_conditions     = [];
				$exclude_conditions      = [];

				// get doc conditions
				$document_conditions    = $this->get_document_conditions( $post_id );

				if ( ! empty( $document_conditions ) ) {
					foreach ( $document_conditions as $key => $condition ) {
						if ( 'include' === $condition['type'] ) {
							$sub_page_id            = ! empty( $condition['sub_id'] ) ? '#' . get_the_title( $condition['sub_id'] ) : '';
							$con_label              = ! empty( $condition['sub_name'] ) && 'all' !== $condition['sub_name'] ? Conditions_Manager::instance()->get_name( $condition['sub_name'] ) . $sub_page_id : Conditions_Manager::instance()->get_all_name( $condition['name'] );
							$include_conditions[]    = $con_label;
						} elseif ( 'exclude' === $condition['type'] ) {
							$sub_page_id        = ! empty( $condition['sub_id'] ) ? '#' . get_the_title( $condition['sub_id'] ) : '';
							$con_label          = ! empty( $condition['sub_name'] ) && 'all' !== $condition['sub_name'] ? Conditions_Manager::instance()->get_name( $condition['sub_name'] ) . $sub_page_id : Conditions_Manager::instance()->get_all_name( $condition['name'] );
							$exclude_conditions[] = $con_label;
						}
					}
				}

				printf(
					/* translators: 1: included conditions, 2: excluded conditions */
					__( '<b>Include : </b> %1$s<br/><b>Exclude : </b> %2$s', 'zyre-elementor-addons' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					implode( ', ', $include_conditions ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					implode( ', ', $exclude_conditions ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				);
			} else {
				echo '<b>' . esc_html__( 'Not Applicable', 'zyre-elementor-addons' ) . '</b>';
			}
		}
	}

	protected function create_or_update_post( $type, $post_data, $meta ) {
		if ( empty( $post_data['post_title'] ) ) {
			$post_data['post_title'] = esc_html__( 'Elementor', 'zyre-elementor-addons' );
			$update_title = true;
		}

		$meta_data['_elementor_edit_mode'] = 'builder';

		$meta_data['_zyre_library_type']  = $type;
		$meta_data['_zyre_display_cond']  = $meta['display_conditions'];
		$meta_data['_wp_page_template'] = 'elementor_canvas';

		$post_data['meta_input'] = $meta_data;

		$post_id = wp_insert_post( $post_data );

		if ( ! empty( $update_title ) ) {
			$post_data['ID'] = $post_id;
			$post_data['post_title'] .= ' #' . $post_id;

			// The meta doesn't need update.
			unset( $post_data['meta_input'] );

			wp_update_post( $post_data );
		}

		return $post_id;
	}

	public function get_edit_url( $id ) {
		$url = add_query_arg(
			[
				'post' => $id,
				'action' => 'elementor',
			],
			admin_url( 'post.php' )
		);

		return $url;
	}

	public function document_config_title( $config, $post_id ) {
		$tmpl_type = get_post_meta( $post_id, '_zyre_library_type', true );

		if ( self::POST_TYPE === get_post_type( $post_id ) ) {
			$title = '';
			switch ( $tmpl_type ) {
				case 'header':
					$title = esc_html__( 'Header Settings', 'zyre-elementor-addons' );
					break;

				case 'footer':
					$title = esc_html__( 'Footer Settings', 'zyre-elementor-addons' );
					break;

				case 'single':
					$title = esc_html__( 'Single Settings', 'zyre-elementor-addons' );
					break;

				case 'archive':
					$title = esc_html__( 'Archive Settings', 'zyre-elementor-addons' );
					break;

				case 'loop-template':
					$title = esc_html__( 'Loop Template', 'zyre-elementor-addons' );
					break;
			}
			$config['settings']['panelPage']['title'] = $title;
		}

		return $config;
	}

	/**
	 * Admin action new post.
	 *
	 * When a new post action is fired, the title is set to 'Elementor' followed by the post ID.
	 *
	 * Fired by `admin_action_zyre_library_new_post` action.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_action_new_post() {

		check_admin_referer( 'zyre_library_new_post_nonce' );

		if ( empty( $_GET['post_type'] ) ) {
			$post_type = 'post';
		} else {
			$post_type = sanitize_text_field( $_GET['post_type'] );
		}

		$post_type_object = get_post_type_object( $post_type );

		if ( ! current_user_can( $post_type_object->cap->edit_posts ) ) {
			return;
		}

		if ( empty( $_GET['template_type'] ) ) {
			$type = 'post';
		} else {
			$type = sanitize_text_field( wp_unslash( $_GET['template_type'] ) );
		}

		$post_data = isset( $_GET['post_data'] ) ? zyre_sanitize_array_recursively( $_GET['post_data'] ) : [];

		$conditions = [];

		$meta = [];

		$meta['display_conditions'] = $conditions;
		$post_data['post_type'] = $post_type;

		$post_id = $this->create_or_update_post( $type, $post_data, $meta );

		if ( is_wp_error( $post_id ) ) {
			wp_die( esc_html( $post_id ) );
		}

		wp_safe_redirect( $this->get_edit_url( $post_id ) );

		die;
	}

	private function check_elementor_content( $post_id ) {
		$el_content = get_post_meta( $post_id, '_elementor_data', true );

		if ( $el_content ) {
			return true;
		}

		return false;
	}

	public function get_public_post_types( $args = [] ) {
		$post_type_args = [
			'show_in_nav_menus' => true,
		];

		// Keep for backwards compatibility
		if ( ! empty( $args['post_type'] ) ) {
			$post_type_args['name'] = $args['post_type'];
			unset( $args['post_type'] );
		}

		$post_type_args = wp_parse_args( $post_type_args );
		$_post_types = get_post_types( $post_type_args, 'objects' );

		$post_types = [];

		foreach ( $_post_types as $post_type => $object ) {
			$post_types[ $post_type ] = $object->label;
		}

		return $post_types;
	}

	public function template_include( $template ) {
		$location = '';

		if ( is_singular( array_keys( $this->get_public_post_types() ) ) || is_404() ) {
			$location = 'single';

			$is_built_with_elementor = $this->check_elementor_content( get_the_ID() );

			if ( $is_built_with_elementor ) {
				return $template;
			}
		} elseif ( function_exists( 'is_shop' ) && \is_shop() ) {
			$location = 'archive';
		} elseif ( is_archive() || is_tax() || is_home() || is_search() ) {
			$location = 'archive';
		}

		if ( class_exists( '\ElementorPro\Plugin' ) ) {
			$document = \ElementorPro\Plugin::elementor()->documents->get_doc_for_frontend( get_the_ID() );
			$page_templates_module = \ElementorPro\Plugin::elementor()->modules_manager->get_modules( 'page-templates' );

			if ( $document && $document instanceof \ElementorPro\Modules\ThemeBuilder\Documents\Theme_Document ) {
				// For editor preview iframe.
				$location = $document->get_location();

				if ( 'header' === $location || 'footer' === $location ) {
					$page_template = $page_templates_module::TEMPLATE_HEADER_FOOTER;
					$template_path = $page_templates_module->get_template_path( $page_template );

					if ( $template_path ) {
						$page_templates_module->set_print_callback( function () use ( $location ) {
							\ElementorPro\Modules\ThemeBuilder\Module::instance()->get_locations_manager()->do_location( $location );
						} );

						$template = $template_path;
					}

					return $template;
				}
			}
		}

		if ( $location ) {
			$location_documents = Conditions_Manager::instance()->get_documents_for_location( $location );

			if ( empty( $location_documents ) ) {
				return $template;
			}

			if ( 'single' === $location || 'archive' === $location ) {

				$first_key = key( $location_documents );
				$theme_document = $location_documents[ $first_key ];

				$template_type = get_post_meta( $theme_document, '_wp_page_template', true );

				$this->singular_template = $theme_document;

				if ( $theme_document ) {
					switch ( $template_type ) {
						case 'elementor_canvas':
							$template = ZYRE_ADDONS_DIR_PATH . 'modules/theme-builder/templates/singular/canvas.php';
							break;
						case 'elementor_header_footer':
							$template = ZYRE_ADDONS_DIR_PATH . 'modules/theme-builder/templates/singular/fullwidth.php';
							break;
						default:
							$template = ZYRE_ADDONS_DIR_PATH . 'modules/theme-builder/templates/singular/fullwidth.php';
							break;
					}
				}
			}
		}

		return $template;
	}

	public static function render_builder_data( $content_id ) {
		$_elementor = \Elementor\Plugin::instance();
		$has_css = false;

		if ( ( 'internal' === get_option( 'elementor_css_print_method' ) ) || \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			$has_css = true;
		}
		$content_id = apply_filters( 'wpml_object_id', $content_id, 'elementor_library' ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
		return $_elementor->frontend->get_builder_content_for_display( $content_id, $has_css );
	}

	public function render_builder_data_location( $location ) {
		$templates = Conditions_Manager::instance()->get_documents_for_location( $location );
		$first_key = key( $templates );
		$valid_template = $templates[ $first_key ];

		return $this->render_builder_data( $valid_template );
	}

	public function single_blog_content_elementor( $post ) {
		$templates = $this->singular_template;
		if ( ! empty( $templates ) ) {
			echo self::render_builder_data( $templates ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} else {
			the_content();
		}
	}

	public function add_elementor_widget_categories( $elements_manager ) {
		if ( self::POST_TYPE === get_post_type() ) {
			$elements_manager->add_category(
				'zyre_addons_theme_builder',
				[
					'title' => esc_html__( 'Happy Theme Builder', 'zyre-elementor-addons' ),
					'icon' => 'fa fa-plug',
				]
			);
		}
	}
}

Module::instance();
