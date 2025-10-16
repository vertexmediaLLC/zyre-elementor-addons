<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use ZyreAddons\Elementor\Traits\List_Item_Advanced_Trait;

defined( 'ABSPATH' ) || die();

class List_Group extends Base {

	use List_Item_Advanced_Trait;

	public function get_title() {
		return esc_html__( 'List Group', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-List-group';
	}

	public function get_keywords() {
		return [ 'list group', 'features lists', 'image list', 'images lists', 'image grid', 'numeric lists', 'number lists', 'lists icons', 'list icon', 'icon list', 'icons lists', 'lists items', 'list item', 'text', 'feature content' ];
	}

	protected function register_content_controls() {
		$this->start_controls_section(
			'section_content_heading',
			[
				'label' => esc_html__( 'List Group Content', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$this->register_list_item_advanced_content_controls( [ 'id_prefix' => 'group' ] );

		$this->end_controls_section();
	}

	protected function register_style_controls() {
		$this->__general_style_controls();
		$this->__item_style_controls();
		$this->__content_style_controls();
		$this->__title_style_controls();
		$this->__description_style_controls();
		$this->__item_type_style_controls();
		$this->__items_icon_style_controls();
	}

	protected function __general_style_controls() {
		$this->start_controls_section(
			'section_general_style',
			[
				'label' => esc_html__( 'General', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,

			]
		);

		$this->register_general_style_controls( [ 'id_prefix' => 'group' ] );

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

		$this->register_item_style_controls( [ 'id_prefix' => 'group' ] );

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

		$this->register_content_style_controls( [ 'id_prefix' => 'group' ] );

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
				'widget_base' => 'group',
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
				'widget_base' => 'group',
			]
		);

		$this->end_controls_section();
	}

	protected function __item_type_style_controls() {
		$this->start_controls_section(
			'section_media_style',
			[
				'label'     => esc_html__( 'Number, Icon & Image', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_item_type_element_style_controls( [ 'id_prefix' => 'group' ] );

		$this->end_controls_section();
	}

	protected function __items_icon_style_controls() {
		$this->start_controls_section(
			'section_items_icon_style',
			[
				'label'     => esc_html__( 'Items Icon', 'zyre-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition'       => [
					'group_items_icon[value]!' => '',
				],
			]
		);

		$this->register_items_icon_style_controls( [ 'id_prefix' => 'group' ] );

		$this->end_controls_section();
	}

	protected function render() {
		$this->render_items( null, [ 'id_prefix' => 'group' ] );
	}
}
