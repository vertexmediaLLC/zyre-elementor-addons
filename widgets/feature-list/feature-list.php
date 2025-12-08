<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use ZyreAddons\Elementor\Traits\List_Item_Advanced_Trait;

defined( 'ABSPATH' ) || die();

class Feature_List extends Base {

	use List_Item_Advanced_Trait;

	public function get_title() {
		return esc_html__( 'Feature List', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Featured-list';
	}

	public function get_keywords() {
		return [ 'feature list', 'features lists', 'image list', 'images lists', 'image grid', 'lists icons', 'list icon', 'icon list', 'icons lists', 'lists items', 'list item', 'text', 'feature content', 'featured content' ];
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	protected function register_content_controls() {
		$this->start_controls_section(
			'section_content_heading',
			[
				'label' => esc_html__( 'Feature List Content', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->set_prestyle_controls();

		$this->register_list_item_advanced_content_controls( [ 'id_prefix' => 'feature' ] );

		$this->end_controls_section();
	}

	protected function register_style_controls() {
		$this->__general_style_controls();
		$this->__item_style_controls();
		$this->__content_style_controls();
		$this->__title_style_controls();
		$this->__description_style_controls();
		$this->__item_type_style_controls();
	}

	protected function __general_style_controls() {
		$this->start_controls_section(
			'section_general_style',
			[
				'label' => esc_html__( 'General', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,

			]
		);

		$this->register_general_style_controls( [ 'id_prefix' => 'feature' ] );

		$this->end_controls_section();
	}

	protected function __item_style_controls() {

		$this->start_controls_section(
			'section_item_style',
			[
				'label' => esc_html__( 'List Item', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_item_style_controls( [ 'id_prefix' => 'feature' ] );

		$this->end_controls_section();
	}

	protected function __content_style_controls() {
		$this->start_controls_section(
			'section_item_content_style',
			[
				'label' => esc_html__( 'Item Content', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,

			]
		);

		$this->register_content_style_controls( [ 'id_prefix' => 'feature' ] );

		$this->end_controls_section();
	}

	protected function __title_style_controls() {

		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_text_style_controls(
			[
				'id_prefix'   => 'item_title',
				'widget_base' => 'feature',
			]
		);

		$this->end_controls_section();
	}

	protected function __description_style_controls() {

		$this->start_controls_section(
			'section_description_style',
			[
				'label' => esc_html__( 'Description', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_text_style_controls(
			[
				'id_prefix'   => 'item_text',
				'widget_base' => 'feature',
			]
		);

		$this->end_controls_section();
	}

	protected function __item_type_style_controls() {
		$this->start_controls_section(
			'section_media_style',
			[
				'label'     => esc_html__( 'Image or Icon', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,

			]
		);

		$this->register_item_type_element_style_controls( [ 'id_prefix' => 'feature' ] );

		$this->end_controls_section();
	}

	protected function render() {
		$this->render_items( null, [ 'id_prefix' => 'feature' ] );
	}
}
