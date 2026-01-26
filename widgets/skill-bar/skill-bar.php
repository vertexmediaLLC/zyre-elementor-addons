<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;

defined( 'ABSPATH' ) || die();

class Skill_Bar extends Base {

	public function get_title() {
		return esc_html__( 'Skill Bars', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Skillbar';
	}

	public function get_keywords() {
		return [ 'skill bars', 'progress bar', 'skill', 'progress', 'bar', 'status' ];
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	protected function is_dynamic_content(): bool {
		return false;
	}

	protected function register_content_controls() {
		$this->start_controls_section(
			'section_skills_content',
			[
				'label' => esc_html__( 'Skill Bars Content', 'zyre-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		// Pre-styles
		$this->set_prestyle_controls();

		$repeater = new Repeater();

		$repeater->add_control(
			'name',
			[
				'type' => Controls_Manager::TEXT,
				'label' => esc_html__( 'Name', 'zyre-elementor-addons' ),
				'default' => esc_html__( 'Skill Name', 'zyre-elementor-addons' ),
				'placeholder' => esc_html__( 'Type a skill name', 'zyre-elementor-addons' ),
			]
		);

		$repeater->add_control(
			'level',
			[
				'label' => esc_html__( 'Level (Out Of 100)', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
					'size' => 95,
				],
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'animate_duration',
			[
				'label'     => esc_html__( 'Animation Duration', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 100,
				'max'       => 10000,
				'step'      => 10,
				'default'   => 1300,
			]
		);

		$repeater->add_control(
			'customize',
			[
				'label' => esc_html__( 'Want To Customize?', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'No', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'description' => esc_html__( 'Modify this skill bar color here, or in the Style tab', 'zyre-elementor-addons' ),
				'style_transfer' => true,
			]
		);

		$repeater->add_control(
			'color',
			[
				'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .zyre-progress-title' => 'color: {{VALUE}};',
				],
				'condition' => [ 'customize' => 'yes' ],
				'style_transfer' => true,
			]
		);

		$repeater->add_control(
			'level_color',
			[
				'label' => esc_html__( 'Level Color', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .zyre-progress-fill' => 'background-color: {{VALUE}};',
				],
				'condition' => [ 'customize' => 'yes' ],
				'style_transfer' => true,
			]
		);

		$repeater->add_control(
			'base_color',
			[
				'label' => esc_html__( 'Base Color', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .zyre-progress-bg' => 'background-color: {{VALUE}};',
				],
				'condition' => [ 'customize' => 'yes' ],
				'style_transfer' => true,
			]
		);

		$this->add_control(
			'skills',
			[
				'label' => esc_html__( 'Skills', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '<# print((name || level.size) ? (name || "Skill") + " - " + level.size + level.unit : "Skill - 0%") #>',
				'default' => [
					[
						'name' => esc_html__( 'Design', 'zyre-elementor-addons' ),
						'level' => [
							'size' => 97,
							'unit' => '%',
						],
					],
					[
						'name' => esc_html__( 'Development', 'zyre-elementor-addons' ),
						'level' => [
							'size' => 88,
							'unit' => '%',
						],
					],
					[
						'name' => esc_html__( 'Coding', 'zyre-elementor-addons' ),
						'level' => [
							'size' => 95,
							'unit' => '%',
						],
					],
					[
						'name' => esc_html__( 'Idea making', 'zyre-elementor-addons' ),
						'level' => [
							'size' => 85,
							'unit' => '%',
						],
					],
					[
						'name' => esc_html__( 'Team management', 'zyre-elementor-addons' ),
						'level' => [
							'size' => 100,
							'unit' => '%',
						],
					],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_controls() {
		$this->__skill_bars_style_controls();
		$this->__title_style_controls();
		$this->__percent_style_controls();
	}

	protected function __skill_bars_style_controls() {

		$this->start_controls_section(
			'section_skill_bars_style',
			[
				'label' => esc_html__( 'Skill Bars', 'zyre-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'height',
			[
				'label' => esc_html__( 'Height', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 250,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-progress-bg' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .zyre-progress-fill' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'spacing',
			[
				'label' => esc_html__( 'Spacing Between', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 250,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .zyre-progress-item' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .zyre-progress-bg, {{WRAPPER}} .zyre-progress-fill' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'level_color',
			[
				'label' => esc_html__( 'Level Color', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-progress-fill' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'base_color',
			[
				'label' => esc_html__( 'Base Color', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-progress-bg' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .zyre-progress-bg',
			]
		);

		// Background Stripe
		$this->add_control(
			'heading_stripe',
			[
				'label'     => esc_html__( 'Background Stripe', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_stripe',
			[
				'label' => esc_html__( 'Show Stripe', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'No', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'style_transfer' => true,
			]
		);

		$this->add_control(
			'stripe_color',
			[
				'label' => esc_html__( 'Stripe Color', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zyre-progress-fill' => '--stripe-color: {{VALUE}};',
				],
				'condition' => [
					'show_stripe' => 'yes',
				],
			]
		);

		$this->add_control(
			'stripe_size',
			[
				'label' => esc_html__( 'Stripe Size', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'rem',
					'size' => '1',
				],
				'size_units' => [ 'rem', 'em', 'px' ],
				'selectors' => [
					'{{WRAPPER}} .zyre-progress-fill' => '--stripe-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'show_stripe' => 'yes',
				],
			]
		);

		$this->add_control(
			'stripe_angle',
			[
				'label' => esc_html__( 'Stripe Angle', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'deg',
					'size' => '135',
				],
				'size_units' => [ 'deg' ],
				'selectors' => [
					'{{WRAPPER}} .zyre-progress-fill' => '--stripe-angle: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'show_stripe' => 'yes',
				],
			]
		);

		$this->add_control(
			'stripe_animation',
			[
				'label' => esc_html__( 'Stripe Animation', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'Off', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'style_transfer' => true,
				'condition' => [
					'show_stripe' => 'yes',
				],
			]
		);

		$this->add_control(
			'stripe_anim_duration',
			[
				'label'     => esc_html__( 'Animation Duration', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1500,
				'selectors' => [
					'{{WRAPPER}} .zyre-progress-fill' => '--stripe-animation-duration: {{VALUE}}ms;',
				],
				'condition' => [
					'show_stripe'       => 'yes',
					'stripe_animation!' => '',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __title_style_controls() {
		$this->start_controls_section(
			'section_skill_name_style',
			[
				'label' => esc_html__( 'Name', 'zyre-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->info_style_controls( 'title', '{{WRAPPER}} .zyre-progress-title' );

		$left_right = is_rtl() ? 'right' : 'left';

		$this->add_responsive_control(
			'title_position_x',
			[
				'label' => esc_html__( 'Horizontal Position', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -300,
						'max' => 300,
					],
					'%' => [
						'min' => -50,
						'max' => 50,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-progress-title' => "{$left_right}: {{SIZE}}{{UNIT}};",
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __percent_style_controls() {
		$this->start_controls_section(
			'section_percent_style',
			[
				'label' => esc_html__( 'Percent Text', 'zyre-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->info_style_controls( 'number', '{{WRAPPER}} .zyre-progress-number-mark' );

		$this->add_responsive_control(
			'number_offset_x',
			[
				'label' => esc_html__( 'Horizontal Offset', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range' => [
					'%' => [
						'min' => -300,
						'max' => 300,
					],
					'px' => [
						'min' => -300,
						'max' => 300,
					],
				],
				'default' => [
					'unit' => '%',
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-progress-number-mark' => '--translate-x: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Arrow
		$this->add_control(
			'heading_number_arrow',
			[
				'label'     => esc_html__( 'Arrow', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_number_arrow',
			[
				'label' => esc_html__( 'Show Arrow', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'zyre-elementor-addons' ),
				'label_off' => esc_html__( 'No', 'zyre-elementor-addons' ),
				'return_value' => 'yes',
				'style_transfer' => true,
			]
		);

		$this->add_responsive_control(
			'number_arrow_border',
			[
				'label'      => esc_html__( 'Arrow Shape', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top'      => '5',
					'right'    => is_rtl() ? '10' : '0',
					'bottom'   => '0',
					'left'     => is_rtl() ? '0' : '10',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-progress-number-mark' => '--arrow-border-left: {{LEFT}}{{UNIT}}; --arrow-border-top: {{TOP}}{{UNIT}}; --arrow-border-right: {{RIGHT}}{{UNIT}};',
				],
				'condition' => [
					'show_number_arrow' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'number_arrow_position_x',
			[
				'label' => esc_html__( 'Horizontal Position', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'default' => [
					'unit' => '%',
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-progress-number-arrow::after' => 'left: calc({{SIZE}}{{UNIT}} - ((var(--arrow-border-left) + var(--arrow-border-right)) / 2));',
				],
				'condition' => [
					'show_number_arrow' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Title & Percent Style Controls.
	 *
	 * @param string $prefix The prefix of the controls.
	 * @param string $selector The HTML selector.
	 */
	private function info_style_controls( string $prefix, string $selector ) {
		$this->set_style_controls(
			$prefix,
			[
				'selector' => $selector,
				'controls' => [
					'typo'        => [],
					'color'       => [
						'label' => esc_html__( 'Text Color', 'zyre-elementor-addons' ),
					],
					'text_shadow' => [],
				],
			]
		);

		$this->add_control(
			$prefix . '_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					$selector => 'number' === $prefix ? '--progress-number-bg: {{VALUE}};' : 'background-color: {{VALUE}};',
				],
			]
		);

		$this->set_style_controls(
			$prefix,
			[
				'selector' => $selector,
				'controls' => [
					'border'        => [],
					'border_radius' => [],
					'box_shadow'    => [],
					'padding'       => [],
				],
			]
		);

		$this->add_responsive_control(
			$prefix . '_position_y',
			[
				'label' => esc_html__( 'Vertical Position', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -300,
						'max' => 300,
					],
					'%' => [
						'min' => -50,
						'max' => 50,
					],
				],
				'selectors'  => [
					$selector => 'bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( ! is_array( $settings['skills'] ) ) {
			return;
		}

		$arrow_class = ( 'yes' === $settings['show_number_arrow'] ) ? ' zyre-progress-number-arrow' : '';
		$this->add_render_attribute( 'mark', 'class', 'zyre-progress-number-mark zy-absolute zy-bottom-0 zy-index-1' . $arrow_class );

		$stripe_class = ( 'yes' === $settings['show_stripe'] ) ? ' zyre-progress-striped' : '';
		$this->add_render_attribute( 'progress_fill', 'class', 'zyre-progress-fill' . $stripe_class );
		$this->add_render_attribute( 'progress_fill', 'class', ( 'yes' === $settings['stripe_animation'] ) ? ' zyre-progress-animated' : '' );

		$left_right = is_rtl() ? 'right' : 'left';

		foreach ( $settings['skills'] as $index => $skill ) :
			$name_key = $this->get_repeater_setting_key( 'name', 'bars', $index );
			$this->add_render_attribute( $name_key, 'class', "zyre-progress-title zy-absolute zy-bottom-4 zy-{$left_right}-0 zy-index-1" );
			?>

			<div class="zyre-progress-item zy-relative elementor-repeater-item-<?php echo esc_attr( $skill['_id'] ); ?>">
				<div class="zyre-progress-bar" data-percentage="<?php echo esc_attr( $skill['level']['size'] ); ?>" data-duration="<?php echo esc_attr( $skill['animate_duration'] ); ?>">
					<?php if ( ! empty( $skill['name'] ) ) : ?>
						<span <?php $this->print_render_attribute_string( $name_key ); ?>><?php echo esc_html( $skill['name'] ); ?></span>
					<?php endif; ?>

					<?php if ( ! empty( $skill['level']['size'] ) ) : ?>
						<div class="zyre-progress-number zy-relative">
							<div <?php $this->print_render_attribute_string( 'mark' ); ?>>
								<span class="zyre-progress-percent"></span>
							</div>
						</div>
					<?php endif; ?>

					<div class="zyre-progress-bg zy-overflow-hidden">
						<div <?php $this->print_render_attribute_string( 'progress_fill' ); ?>></div>
					</div>
				</div>
			</div>
			<?php
		endforeach;
	}

	protected function content_template() {
		$left_right = is_rtl() ? 'right' : 'left';
		?>
		<#
		if (_.isArray(settings.skills)) {
			var arrowClass = settings.show_number_arrow === 'yes' ? ' zyre-progress-number-arrow' : '';
			view.addRenderAttribute('mark', 'class', 'zyre-progress-number-mark zy-absolute zy-bottom-0 zy-index-1' + arrowClass);

			var stripeClass = settings.show_stripe === 'yes' ? ' zyre-progress-striped' : '';
			view.addRenderAttribute('progress_fill', 'class', 'zyre-progress-fill' + stripeClass);
			view.addRenderAttribute('progress_fill', 'class', settings.stripe_animation === 'yes' ? ' zyre-progress-animated' : '');

			_.each(settings.skills, function(skill, index) {
				var nameKey = view.getRepeaterSettingKey( 'name', 'skills', index );
				view.addRenderAttribute( nameKey, 'class', 'zyre-progress-title zy-absolute zy-bottom-4 zy-<?php echo esc_attr( $left_right ); ?>-0 zy-index-1' );
				#>
				<div class="zyre-progress-item zy-relative elementor-repeater-item-{{skill._id}}">
					<div class="zyre-progress-bar" data-percentage="{{skill.level.size}}" data-duration="{{skill.animate_duration}}">
						<# if ( skill.name ) { #>
						<span {{{view.getRenderAttributeString( nameKey )}}}>{{skill.name}}</span>
						<# } #>

						<# if ( skill.level && skill.level.size ) { #>
						<div class="zyre-progress-number zy-relative">
							<div {{{view.getRenderAttributeString('mark')}}}>
								<span class="zyre-progress-percent"></span>
							</div>
						</div>
						<# } #>

						<div class="zyre-progress-bg zy-overflow-hidden">
							<div {{{view.getRenderAttributeString('progress_fill')}}}></div>
						</div>
					</div>
				</div>
				<#
			});
		}
		#>
		<?php
	}
}
