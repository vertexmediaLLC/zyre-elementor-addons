<?php
namespace ZyreAddons\Elementor\Traits;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

trait List_Item_Trait {

	/**
	 * Register content controls for list items.
	 *
	 * @param array $args {
	 *     Optional. An array of arguments for adjusting the controls.
	 *
	 *     @type string $id_prefix     Prefix for the control IDs.
	 *     @type bool   $prevent_empty Whether to prevent empty items. Default true.
	 * }
	 */
	protected function register_list_item_content_controls( $args = [] ) {
		$default_args = [
			'id_prefix' => '',
			'prevent_empty' => true,
		];

		$args = wp_parse_args( $args, $default_args );

		$prefix = ! empty( $args['id_prefix'] ) ? $args['id_prefix'] . '_' : '';

		$this->add_control(
			$prefix . 'view',
			[
				'label'          => esc_html__( 'Layout', 'zyre-elementor-addons' ),
				'type'           => Controls_Manager::CHOOSE,
				'default'        => 'block',
				'options'        => [
					'block'  => [
						'title' => esc_html__( 'Block', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-editor-list-ul',
					],
					'inline' => [
						'title' => esc_html__( 'Inline', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-ellipsis-h',
					],
				],
				'render_type'    => 'template',
				'style_transfer' => true,
				'classes'        => 'elementor-control-start-end',
				'prefix_class'   => 'elementor-icon-list--layout-',
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'text',
			[
				'label'       => esc_html__( 'Text', 'zyre-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'List Item', 'zyre-elementor-addons' ),
				'default'     => esc_html__( 'List Item', 'zyre-elementor-addons' ),
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'selected_icon',
			[
				'label'            => esc_html__( 'Icon', 'zyre-elementor-addons' ),
				'type'             => Controls_Manager::ICONS,
				'default'          => [
					'value'   => 'fas fa-check',
					'library' => 'fa-solid',
				],
				'fa4compatibility' => 'icon',
			]
		);

		$repeater->add_control(
			'link',
			[
				'label'   => esc_html__( 'Link', 'zyre-elementor-addons' ),
				'type'    => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			$prefix . 'items',
			[
				'label'         => esc_html__( 'Items', 'zyre-elementor-addons' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'title_field'   => '{{{ elementor.helpers.renderIcon( this, selected_icon, {}, "i", "panel" ) || \'<i class="{{ icon }}" aria-hidden="true"></i>\' }}} {{{ text }}}',
				'prevent_empty' => $args['prevent_empty'],
				'default'       => [],
			]
		);

		$this->add_responsive_control(
			$prefix . 'align',
			[
				'label'     => esc_html__( 'Alignment', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-center',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'zyre-elementor-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'toggle'    => true,
				'selectors' => [
					'{{WRAPPER}} .zyre-list-items-inline, {{WRAPPER}} .zyre-list-item' => 'justify-content: {{VALUE}};',
				],
			]
		);
	}

	/**
	 * Register content controls for list items.
	 *
	 * @param array $args {
	 *     Optional. An array of arguments for adjusting the controls.
	 *
	 *     @type string $id_prefix     Prefix for the control IDs.
	 * }
	 */
	protected function register_list_item_style_controls( $args = [] ) {
		$default_args = [
			'id_prefix' => '',
		];

		$args = wp_parse_args( $args, $default_args );

		$prefix = ! empty( $args['id_prefix'] ) ? $args['id_prefix'] . '_' : '';

		$this->add_responsive_control(
			$prefix . 'space_between',
			[
				'label'      => esc_html__( 'Space Between', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'range'      => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .zyre-list-items.zyre-list-items-inline'                                         => 'gap: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .zyre-list-items:not(.zyre-list-items-inline) .zyre-list-item:not(:last-child)'  => 'padding-bottom: calc({{SIZE}}{{UNIT}} / 2)',
					'{{WRAPPER}} .zyre-list-items:not(.zyre-list-items-inline) .zyre-list-item:not(:first-child)' => 'margin-top: calc({{SIZE}}{{UNIT}} / 2)',
				],
			]
		);

		$this->add_control(
			'_heading_list_icon',
			[
				'type'  => Controls_Manager::HEADING,
				'label' => esc_html__( 'Icon Style', 'zyre-elementor-addons' ),
			]
		);

		$this->start_controls_tabs( $prefix . 'icon_colors' );

		$this->start_controls_tab(
			$prefix . 'icon_colors_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			$prefix . 'icon_color',
			[
				'label'     => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .zyre-list-item-icon i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-list-item-icon svg' => 'fill: {{VALUE}};',
				],
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			$prefix . 'icon_colors_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			$prefix . 'icon_color_hover',
			[
				'label'     => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .zyre-list-item:hover .zyre-list-item-icon i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .zyre-list-item:hover .zyre-list-item-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			$prefix . 'icon_size',
			[
				'label'      => esc_html__( 'Size', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'range'      => [
					'px' => [
						'min' => 6,
					],
					'%'  => [
						'min' => 6,
					],
					'vw' => [
						'min' => 6,
					],
				],
				'separator'  => 'before',
				'selectors'  => [
					'{{WRAPPER}} .zyre-list-item-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'_heading_list_text',
			[
				'type'  => Controls_Manager::HEADING,
				'label' => esc_html__( 'Text Style', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			$prefix . 'text_indent',
			[
				'label'      => esc_html__( 'Gap', 'zyre-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'range'      => [
					'px' => [
						'max' => 100,
					],
				],
				'separator'  => 'after',
				'selectors'  => [
					'{{WRAPPER}} .zyre-list-item, {{WRAPPER}} .zyre-list-item > a' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => $prefix . 'icon_typography',
				'selector' => '{{WRAPPER}} .zyre-list-item .zyre-list-item-text',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->start_controls_tabs( $prefix . 'text_colors' );

		$this->start_controls_tab(
			$prefix . 'text_colors_normal',
			[
				'label' => esc_html__( 'Normal', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			$prefix . 'text_color',
			[
				'label'     => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .zyre-list-item-text' => 'color: {{VALUE}};',
				],
				'global'    => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			$prefix . 'text_colors_hover',
			[
				'label' => esc_html__( 'Hover', 'zyre-elementor-addons' ),
			]
		);

		$this->add_control(
			$prefix . 'text_color_hover',
			[
				'label'     => esc_html__( 'Color', 'zyre-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .zyre-list-item:hover .zyre-list-item-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
	}

	/**
	 * Render list output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @param \Elementor\Widget_Base|null $instance
	 *
	 * @param array $args {
	 *     Optional. An array of arguments for adjusting the controls.
	 *
	 *     @type string $id_prefix     Prefix for the control IDs.
	 * }
	 *
	 * @access protected
	 */
	protected function render_list_items( ?Widget_Base $instance = null, $args = [] ) {
		if ( empty( $instance ) ) {
			$instance = $this;
		}

		$default_args = [
			'id_prefix' => '',
		];

		$args = wp_parse_args( $args, $default_args );
		$prefix = ! empty( $args['id_prefix'] ) ? $args['id_prefix'] . '_' : '';

		$settings = $this->get_settings_for_display();
		$fallback_defaults = [
			'fa fa-check',
			'fa fa-times',
			'fa fa-dot-circle-o',
		];

		// Elements
		$items = "{$prefix}items";

		if ( ! empty( $settings[ $items ] ) ) {

			$instance->add_render_attribute( $items, 'class', 'zyre-list-items' );
			$instance->add_render_attribute( 'list_item', 'class', 'zyre-list-item' );

			if ( 'inline' === $settings[ $prefix . 'view' ] ) {
				$instance->add_render_attribute( $items, 'class', 'zyre-list-items-inline' );
				$instance->add_render_attribute( 'list_item', 'class', 'zyre-list-item-inline' );
			}
			?>

			<ul <?php $instance->print_render_attribute_string( $items ); ?>>
				<?php
				foreach ( $settings[ $items ] as $index => $item ) :
					$repeater_setting_key = $instance->get_repeater_setting_key( 'text', $items, $index );

					$instance->add_render_attribute( $repeater_setting_key, 'class', 'zyre-list-item-text' );

					$instance->add_inline_editing_attributes( $repeater_setting_key );
					$migration_allowed = Icons_Manager::is_migration_allowed();
					?>
					<li <?php $instance->print_render_attribute_string( 'list_item' ); ?>>
						<?php
						if ( ! empty( $item['link']['url'] ) ) {
							$link_key = 'link_' . $index;

							$instance->add_link_attributes( $link_key, $item['link'] );
							?>
							<a <?php $instance->print_render_attribute_string( $link_key ); ?>>

							<?php
						}

						// add old default
						if ( ! isset( $item['icon'] ) && ! $migration_allowed ) {
							$item['icon'] = isset( $fallback_defaults[ $index ] ) ? $fallback_defaults[ $index ] : 'fa fa-check';
						}

						$migrated = isset( $item['__fa4_migrated']['selected_icon'] );
						$is_new = ! isset( $item['icon'] ) && $migration_allowed;
						if ( ! empty( $item['icon'] ) || ( ! empty( $item['selected_icon']['value'] ) && $is_new ) ) :
							?>
							<span class="zyre-list-item-icon">
								<?php
								if ( $is_new || $migrated ) {
									Icons_Manager::render_icon( $item['selected_icon'], [ 'aria-hidden' => 'true' ] );
								} else { ?>
									<i class="<?php echo esc_attr( $item['icon'] ); ?>" aria-hidden="true"></i>
								<?php } ?>
							</span>
						<?php endif; ?>
						<span <?php $instance->print_render_attribute_string( $repeater_setting_key ); ?>><?php $instance->print_unescaped_setting( 'text', $items, $index ); ?></span>
						<?php if ( ! empty( $item['link']['url'] ) ) : ?>
							</a>
						<?php endif; ?>
					</li>
					<?php
				endforeach; ?>
			</ul>
			<?php
		}
	}
}
