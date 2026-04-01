<?php
namespace  VertexMediaLLC\ZyreElementorAddons\Modules\Mega_Menu;

defined( 'ABSPATH' ) || exit;

class Cpt {

	private static $instance = null;
	
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

    public function __construct() {
        $this->post_type();
    }

    public function post_type() {

        $labels = array(
            'name'                  => _x( 'Zyre Mega Menu items', 'Post Type General Name', 'zyre-elementor-addons' ),
            'singular_name'         => _x( 'Zyre Mega Menu item', 'Post Type Singular Name', 'zyre-elementor-addons' ),
            'menu_name'             => esc_html__( 'Zyre Mega Menu item', 'zyre-elementor-addons' ),
            'name_admin_bar'        => esc_html__( 'Zyre Mega Menu item', 'zyre-elementor-addons' ),
            'archives'              => esc_html__( 'Item Archives', 'zyre-elementor-addons' ),
            'attributes'            => esc_html__( 'Item Attributes', 'zyre-elementor-addons' ),
            'parent_item_colon'     => esc_html__( 'Parent Item:', 'zyre-elementor-addons' ),
            'all_items'             => esc_html__( 'All Items', 'zyre-elementor-addons' ),
            'add_new_item'          => esc_html__( 'Add New Item', 'zyre-elementor-addons' ),
            'add_new'               => esc_html__( 'Add New', 'zyre-elementor-addons' ),
            'new_item'              => esc_html__( 'New Item', 'zyre-elementor-addons' ),
            'edit_item'             => esc_html__( 'Edit Item', 'zyre-elementor-addons' ),
            'update_item'           => esc_html__( 'Update Item', 'zyre-elementor-addons' ),
            'view_item'             => esc_html__( 'View Item', 'zyre-elementor-addons' ),
            'view_items'            => esc_html__( 'View Items', 'zyre-elementor-addons' ),
            'search_items'          => esc_html__( 'Search Item', 'zyre-elementor-addons' ),
            'not_found'             => esc_html__( 'Not found', 'zyre-elementor-addons' ),
            'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'zyre-elementor-addons' ),
            'featured_image'        => esc_html__( 'Featured Image', 'zyre-elementor-addons' ),
            'set_featured_image'    => esc_html__( 'Set featured image', 'zyre-elementor-addons' ),
            'remove_featured_image' => esc_html__( 'Remove featured image', 'zyre-elementor-addons' ),
            'use_featured_image'    => esc_html__( 'Use as featured image', 'zyre-elementor-addons' ),
            'insert_into_item'      => esc_html__( 'Insert into item', 'zyre-elementor-addons' ),
            'uploaded_to_this_item' => esc_html__( 'Uploaded to this item', 'zyre-elementor-addons' ),
            'items_list'            => esc_html__( 'Items list', 'zyre-elementor-addons' ),
            'items_list_navigation' => esc_html__( 'Items list navigation', 'zyre-elementor-addons' ),
            'filter_items_list'     => esc_html__( 'Filter items list', 'zyre-elementor-addons' ),
        );

        $rewrite = array(
            'slug'                  => 'zyreladdons-mm-content',
            'with_front'            => true,
            'pages'                 => false,
            'feeds'                 => false,
        );

        $args = array(
            'label'                 => esc_html__( 'Zyre Mega Menu Item', 'zyre-elementor-addons' ),
            'description'           => esc_html__( 'Zyre Mega Menu Content', 'zyre-elementor-addons' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'elementor', 'permalink' ),
            'hierarchical'          => true,
            'public'                => false,
            'show_ui'               => true,
            'show_in_menu'          => false,
            'menu_position'         => 5,
            'show_in_admin_bar'     => false,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => false,
            'rewrite'               => $rewrite,
            'query_var'             => true,
            'exclude_from_search'   => true,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
            'show_in_rest'          => false,
            'rest_base'             => 'zyreladdons-mm-content',
        );

        register_post_type( 'zyreladdons_mm', $args );
    }

    public static function flush_rewrites() {
        flush_rewrite_rules();
    }
}
