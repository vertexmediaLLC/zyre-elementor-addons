<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;

defined( 'ABSPATH' ) || die();

class Drop_Cap extends Base {

	public function get_title() {
		return esc_html__( 'Drop Cap', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Dropcap';
	}

	public function get_keywords() {
		return [ 'dropcap', 'content', 'title', 'text' ];
	}

	protected function register_content_controls() {
		$this->start_controls_section(
			'section_heading',
			[
				'label' => esc_html__( 'Drop Cap Content', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$this->add_control(
			'dropcap_content',
			[
				'label'     => esc_html__( 'Content', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::TEXTAREA,
				'default'   => __( 'New york lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod lipsum dolor-sit tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam.<br>Uis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.', 'zyre-elementor-addons' ),
				'description' => zyre_get_allowed_html_desc(),
			]
		);

		// Show/Hide dropcap Toggle
		$this->add_control(
			'show_dropcap',
			[
				'label'        => esc_html__( 'Show Drop Cap', 'zyre-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'zyre-elementor-addons' ),
				'label_off'    => esc_html__( 'Off', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'prefix_class' => 'zyre-drop-cap-',
			]
		);

		$this->add_control(
			'dropcap_css_class',
			[
				'label'       => esc_html__( 'Class', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Class Name', 'zyre-elementor-addons' ),
				'prefix_class' => '',
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_controls() {
		$this->__text_style_controls();
		$this->__dropcap_style_controls();
	}

	// Text style controls.
	protected function __text_style_controls() {
		$this->start_controls_section(
			'section_text_style',
			[
				'label' => esc_html__( 'Text', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'dropcap_text',
			[
				'selector' => '{{WRAPPER}} .zyre-dropcap',
				'controls' => [
					'typography' => [],
					'color'      => [],
					'alignment'  => [],
				],
			]
		);

		$this->end_controls_section();
	}

	// Drop Cap style controls.
	protected function __dropcap_style_controls() {
		$this->start_controls_section(
			'section_dropcap_style',
			[
				'label' => esc_html__( 'Drop Cap', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_dropcap' => 'yes',
				],
			]
		);

		$this->set_style_controls(
			'dropcap',
			[
				'selector' => '{{WRAPPER}}.zyre-drop-cap-yes .zyre-dropcap::first-letter',
				'controls' => [
					'typography'    => [],
					'color'         => [],
					'background'    => [
						'fields_options' => [
							'color' => [
								'label' => esc_html__( 'Background Color', 'zyre-elementor-addons' ),
							],
						],
					],
					'padding'       => [],
					'margin'        => [],
					'border'        => [],
					'border_radius' => [],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_inline_editing_attributes( 'dropcap_content' );
		$this->add_render_attribute( 'dropcap_content', 'class', 'zyre-dropcap' );
		?>
	
		<p <?php echo $this->get_render_attribute_string( 'dropcap_content' ); ?>>
			<?php echo zyre_kses_basic( html_entity_decode( $settings['dropcap_content'] ) ); ?>
		</p>
	
		<?php
	}
}
