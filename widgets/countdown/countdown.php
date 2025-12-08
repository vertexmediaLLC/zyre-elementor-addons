<?php

namespace ZyreAddons\Elementor\Widget;

use Elementor\Controls_Manager;

defined( 'ABSPATH' ) || die();

class Countdown extends Base {

	public function get_title() {
		return esc_html__( 'Countdown', 'zyre-elementor-addons' );
	}

	public function get_icon() {
		return 'zy-fonticon zy-Countdown-stopwatch';
	}

	public function get_keywords() {
		return [ 'countdown', 'timer', 'time', 'date', 'upcoming', 'coming soon' ];
	}

	public function get_custom_help_url() {
		return $this->set_help_url();
	}

	/**
	 * Register widget content controls
	 */
	protected function register_content_controls() {
		$this->start_controls_section(
			'section_countdown_content',
			[
				'label' => esc_html__( 'Countdown', 'zyre-elementor-addons' ),
			]
		);

		// Pre style controls
		$this->set_prestyle_controls();

		$this->add_control(
			'counting_timer',
			[
				'label'       => esc_html__( 'Countdown Due Date', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::DATE_TIME,
				'label_block' => false,
				'default'   => gmdate( 'Y-m-d H:i', strtotime( '+1 month' ) + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) ),
				'description' => sprintf(
					__( 'Set your timezone in <a href="%s" target="_blank">General Settings</a> to display the correct time.', 'zyre-elementor-addons' ),
					esc_url( admin_url('options-general.php') )
				),
			]
		);

		$this->add_control(
			'show_days',
			[
				'label' => esc_html__( 'Show Days', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_hours',
			[
				'label' => esc_html__( 'Show Hours', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_minutes',
			[
				'label' => esc_html__( 'Show Minutes', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_seconds',
			[
				'label' => esc_html__( 'Show Seconds', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_labels',
			[
				'label' => esc_html__( 'Show Labels', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'labels_days',
			[
				'label' => esc_html__( 'Days', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Days', 'zyre-elementor-addons' ),
				'ai' => false,
				'condition' => [
					'show_days' => 'yes',
					'show_labels' => 'yes',
				],
			]
		);

		$this->add_control(
			'labels_hours',
			[
				'label' => esc_html__( 'Hours', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Hours', 'zyre-elementor-addons' ),
				'ai' => false,
				'condition' => [
					'show_hours' => 'yes',
					'show_labels' => 'yes',
				],
			]
		);

		$this->add_control(
			'labels_minutes',
			[
				'label' => esc_html__( 'Minutes', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Minutes', 'zyre-elementor-addons' ),
				'ai' => false,
				'condition' => [
					'show_minutes' => 'yes',
					'show_labels' => 'yes',
				],
			]
		);

		$this->add_control(
			'labels_seconds',
			[
				'label' => esc_html__( 'Seconds', 'zyre-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Seconds', 'zyre-elementor-addons' ),
				'ai' => false,
				'condition' => [
					'show_seconds' => 'yes',
					'show_labels' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register styles related controls
	 */
	protected function register_style_controls() {
		// Item Section Styles
		$this->start_controls_section(
			'general_section_style',
			[
				'label' => esc_html__( 'General', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'general',
			[
				'selector' => '{{WRAPPER}} .zyre-addons-countdown',
				'controls' => [
					'direction'  => [
						'default' => 'row',
					],
					'align_x'    => [
						'label_block' => true,
						'default'     => 'center',
						'condition'   => [
							'general_direction' => 'row',
						],
					],
					'align_xy'   => [
						'default'   => 'center',
						'condition' => [
							'general_direction' => 'column',
						],
					],
					'column_gap' => [],
					'row_gap'    => [],
				],
			],
		);

		$this->end_controls_section();

		// Item Section Styles
		$this->start_controls_section(
			'item_section_style',
			[
				'label' => esc_html__( 'Item', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'item',
			[
				'selector' => '{{WRAPPER}} .zyre-addons-countdown-item',
				'controls' => [
					'bg_color'      => [],
					'width'         => [],
					'height'        => [],
					'padding'       => [],
					'border'        => [],
					'border_radius' => [],
					'box_shadow'    => [],
				],
			],
		);

		$this->end_controls_section();

		// Count Section Styles
		$this->start_controls_section(
			'count_section_style',
			[
				'label' => esc_html__( 'Count', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'count',
			[
				'selector' => '{{WRAPPER}} .zyre-addons-countdown-item-count',
				'controls' => [
					'typography' => [],
					'color'      => [],
					'padding'    => [],
				],
			],
		);

		$this->end_controls_section();

		// Label Section Styles
		$this->start_controls_section(
			'label_section_style',
			[
				'label' => esc_html__( 'Label', 'zyre-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->set_style_controls(
			'label',
			[
				'selector' => '{{WRAPPER}} .zyre-addons-countdown-item-label',
				'controls' => [
					'typography' => [],
					'color'      => [],
					'bg_color'   => [],
					'border'     => [],
					'padding'    => [],
				],
			],
		);

		$this->end_controls_section();
	}

	/**
	 * Register render display controls
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$day_text = ! empty( $settings['labels_days'] ) ? $settings['labels_days'] : __( 'Days', 'zyre-elementor-addons' );
		$hour_text = ! empty( $settings['labels_hours'] ) ? $settings['labels_hours'] : __( 'Hours', 'zyre-elementor-addons' );
		$minute_text = ! empty( $settings['labels_minutes'] ) ? $settings['labels_minutes'] : __( 'Minutes', 'zyre-elementor-addons' );
		$second_text = ! empty( $settings['labels_seconds'] ) ? $settings['labels_seconds'] : __( 'Seconds', 'zyre-elementor-addons' );

		$widget_id = $this->get_id();
		$offset_time  = get_option( 'gmt_offset' );
		$count_time = ! empty( $settings['counting_timer'] ) ? $settings['counting_timer'] : null;

		if ( ! empty( $count_time ) ) {
			$counting_timer = $count_time;
			$counting_timer = gmdate( 'm/d/Y H:i:s', strtotime( $counting_timer ) );
		}

		$cd_data = [
			'widgetid' => $widget_id,
			'days'     => esc_attr( $day_text ),
			'hours'    => esc_attr( $hour_text ),
			'minutes'  => esc_attr( $minute_text ),
			'seconds'  => esc_attr( $second_text ),
		];

		$other_data = [
			'offset' => $offset_time,
			'timer'  => $counting_timer,
		];

		$cd_data = array_merge( $cd_data, $other_data );
		$cd_data = htmlspecialchars( wp_json_encode( $cd_data ), ENT_QUOTES, 'UTF-8' );
		?>

		<div class="zyre-addons-countdown zy-flex zy-flex-wrap" id="zyre-countdown-widget-<?php echo esc_attr( $widget_id ); ?>" data-cd-settings="<?php echo esc_attr( $cd_data ); ?>">

			<!-- Day Count -->
			<?php if ( 'yes' === $settings['show_days'] ) : ?>
			<div class="zyre-addons-countdown-item zy-flex zy-direction-column zy-align-center zy-justify-center day">
				<span class="zyre-addons-countdown-item-count zy-my-auto zy-self-center zy-text-center zy-w-100 days">00</span>

				<?php if ( 'yes' === $settings['show_labels'] ) : ?>
					<span class="zyre-addons-countdown-item-label zy-text-center zy-w-100 days_ref">
						<?php echo esc_html( $day_text ); ?>
					</span>
				<?php endif; ?>	
			</div>
			<?php endif; ?>	

			<!-- Hour Count -->
			<?php if ( 'yes' === $settings['show_hours'] ) : ?>
			<div class="zyre-addons-countdown-item zy-flex zy-direction-column zy-align-center zy-justify-center hour">				
				<span class="zyre-addons-countdown-item-count zy-my-auto zy-self-center zy-text-center zy-w-100 hours">00</span>

				<?php if ( 'yes' === $settings['show_labels'] ) : ?>
					<span class="zyre-addons-countdown-item-label zy-text-center zy-w-100 hours_ref">
						<?php echo esc_html( $hour_text ); ?>
					</span>
				<?php endif; ?>	
			</div>
			<?php endif; ?>	

			<!-- Minute Count -->
			<?php if ( 'yes' === $settings['show_minutes'] ) : ?>
			<div class="zyre-addons-countdown-item zy-flex zy-direction-column zy-align-center zy-justify-center minute">				
				<span class="zyre-addons-countdown-item-count zy-my-auto zy-self-center zy-text-center zy-w-100 minutes">00</span>

				<?php if ( 'yes' === $settings['show_labels'] ) : ?>
					<span class="zyre-addons-countdown-item-label zy-text-center zy-w-100 minutes_ref">
						<?php echo esc_html( $minute_text ); ?>
					</span>
				<?php endif; ?>
			</div>
			<?php endif; ?>	

			<!-- Second Count -->
			<?php if ( 'yes' === $settings['show_seconds'] ) : ?>
			<div class="zyre-addons-countdown-item zy-flex zy-direction-column zy-align-center zy-justify-center second">				
				<span class="zyre-addons-countdown-item-count zy-my-auto zy-self-center zy-text-center zy-w-100 seconds">00</span>

				<?php if ( 'yes' === $settings['show_labels'] ) : ?>
					<span class="zyre-addons-countdown-item-label zy-text-center zy-w-100 seconds_ref">
						<?php echo esc_html( $second_text ); ?>
					</span>
				<?php endif; ?>	
			</div>
			<?php endif; ?>	
		</div>
		<?php
	}
}
