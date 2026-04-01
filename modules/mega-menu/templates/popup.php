<?php
/**
 * Nav menu item: MegaMenu settings popup.
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="zy__modal modal" id="zy__menu_settings_modal">

    <div class="zy__modal-header">
        <div class="zy__modal-title">
            <span class="branding"></span>
            <span class="title"><?php echo esc_html( 'Zyre Mega Menu' ); ?></span>
        </div>
        <div class="zy__modal-close">
            <a href="#" rel="modal:close"><i class="eicon-close" aria-hidden="true" title="Close"></i></a>
        </div>
    </div>
    <div class="zy__modal-body zy-wid-con">
        <table class="form-table" role="presentation">
            <tbody>
                <tr>
                    <th scope="row"><label for="blogname"><?php echo esc_html_e( 'Enable Mega Menu', 'zyre-elementor-addons' ); ?></label></th>
                    <td>
                        <div class="zy-dashboard-widgets__item-toggle zy-toggle">
                            <input id="zy-menu-item-enable" type="checkbox" class="zy-toggle__check zy-widget" value="1">
                            <b class="zy-toggle__switch"></b>
                            <b class="zy-toggle__track"></b>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="blogname"><?php echo esc_html_e( 'Mega Menu Width', 'zyre-elementor-addons' ); ?></label></th>
                    <td id="zy_megamenu_width_type">
						<select name="width_type" id="width_type">
							<option value="custom_width"><?php esc_html_e( 'Custom Width', 'zyre-elementor-addons' ); ?></option>
							<option value="full_width"><?php esc_html_e( 'Full Width', 'zyre-elementor-addons' ); ?></option>
						</select>
						<p class="zyre-lh-1.1">
							<i class="fas fa-exclamation-triangle zyre-color-orange-2"></i>
							<small>
								<?php
								echo wp_kses(
									__( '<b>Full Width</b> option doesn’t work if <b>Mega Menu layout</b> is set to <b>Vertical</b>.', 'zyre-elementor-addons' ),
									[
										'b' => [],
									]
								);
								?>
							</small>
						</p>
                    </td>
                </tr>
                <tr class="menu-width-container">
                    <th scope="row"><label for="zy-menu-megamenu-width-field"><?php esc_html_e( 'Menu Width', 'zyre-elementor-addons' ); ?></label></th>
                    <td>
                        <input type="text" placeholder="<?php esc_html_e( '750px', 'zyre-elementor-addons' ); ?>" id="zy-menu-megamenu-width-field" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="blogname"><?php echo esc_html_e( 'Mega Menu Position', 'zyre-elementor-addons' ); ?></label></th>
                    <td id="vertical_megamenu_position_type">
                        <input type="radio" id="position_type_top" name="position_type" value="position_default">
                        <label for="position_type_top"><?php esc_html_e( 'Default', 'zyre-elementor-addons' ); ?></label>
                        <input type="radio" name="position_type" id="position_type_relative" checked value="position_relative">
                        <label for="position_type_relative"><?php esc_html_e( 'Relative', 'zyre-elementor-addons' ); ?></label>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="blogname"><?php echo esc_html_e( 'Mobile Submenu Content', 'zyre-elementor-addons' ); ?></label></th>
                    <td id="mobile_submenu_content_type">
                        <input type="radio" id="content_type_builder_content" name="content_type" checked value="builder_content">
                        <label for="content_type_builder_content"><?php esc_html_e( 'Builder Content', 'zyre-elementor-addons' ); ?></label>
                        <input type="radio" id="content_type_submenu_list" name="content_type" value="submenu_list">
                        <label for="content_type_submenu_list"><?php esc_html_e( 'Default Submenu items', 'zyre-elementor-addons' ); ?></label>
                    </td>
                </tr>
                <tr>
                    <th scope="row"></th>
                    <td>
                        <a id="zy-menu-builder-trigger" class="zy-menu-elementor-button zy-btn elementor" href="#zy-menu-builder-modal"><?php esc_html_e( 'Edit Mega Menu Content', 'zyre-elementor-addons' ); ?></a>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="zy__section_heading">
            <span><?php esc_html_e( 'Icon', 'zyre-elementor-addons' ); ?></span>
            <span class="sep"></span>
        </div>

        <table class="form-table" role="presentation">
            <tbody>
                <tr>
                    <th scope="row"><label for="zy-menu-icon-field"><?php esc_html_e('Select Icon', 'zyre-elementor-addons'); ?></label></th>
                    <td>
                        <div class="aim-icon-picker-wrap" id="icon-picker-wrap">
                            <ul class="icon-picker">
                                <li id='select-icon' class="select-icon" title="Icon Library"><i class="fas fa-circle"></i></li>
                                <li class="icon-none" title="None"><i class="fas fa-ban"></i></li>
                                <input type="hidden" name="icon_value" id="zy-menu-icon-field" value="">
                            </ul>
                        </div>
                    </td>
					<th scope="row" class="zyre-v-middle zyre-text-r"><label for="zy-menu-icon-color-field"><?php esc_html_e('Icon Color', 'zyre-elementor-addons'); ?></label></th>
                    <td>
                        <input type="text" value="#888888" class="zy-menu-wpcolor-picker" id="zy-menu-icon-color-field" />
                    </td>
					<th scope="row" class="zyre-v-middle zyre-text-r"><label for="zy-menu-icon-size-field"><?php esc_html_e('Icon Size', 'zyre-elementor-addons'); ?></label></th>
                    <td>
                        <input class="zyre-mw-60" type="number" value="" id="zy-menu-icon-size-field" />
                    </td>
                </tr>
				<tr>
					<td class="zyre-pl-0 zyre-pt-0" colspan="6">
                        <input type="checkbox" value="" id="zy-hide-menu-item-text" />
						<label for="zy-hide-menu-item-text" class="zyre-mr-0 zyre-fw-600"><?php esc_html_e('Hide this Menu Item Text?', 'zyre-elementor-addons'); ?></label>
                    </td>
				</tr>
            </tbody>
        </table>

        <div class="zy__section_heading">
            <span><?php esc_html_e('Badge', 'zyre-elementor-addons'); ?></label></span>
            <span class="sep"></span>
        </div>

        <div class="zy__flex zy-badge-wrapper">
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="zy-menu-badge-text-field"><?php esc_html_e('Badge Text', 'zyre-elementor-addons'); ?></label></th>
                        <td>
                            <input type="text" class="badge-text" placeholder="<?php esc_html_e('Badge Text', 'zyre-elementor-addons'); ?>" id="zy-menu-badge-text-field" />
                        </td>
                    </tr>

                    <tr>
                        <th scope="row"><label for="zy-menu-badge-color-field"><?php esc_html_e('Text Color', 'zyre-elementor-addons'); ?></label></th>
                        <td>
                            <input type="text" class="zy-menu-wpcolor-picker" value="#ffffff" id="zy-menu-badge-color-field" />
                        </td>
                    </tr>

                    <tr>
                        <th scope="row"><label for="zy-menu-badge-background-field"><?php esc_html_e('Badge Background', 'zyre-elementor-addons'); ?></label></th>
                        <td>
                            <input type="text" class="zy-menu-wpcolor-picker" value="#2d41fa" id="zy-menu-badge-background-field" />
                        </td>
                    </tr>
					<tr>
                        <th scope="row" class="w-170"><label for=""><?php esc_html_e( 'Badge Radius', 'zyre-elementor-addons' ); ?></label></th>
                        <td>
                            <ul class="zy__control-dimensions">
                                <li class="elementor-control-dimension">
                                    <input id="zy-menu-badge-radius-topLeft" type="number" data-setting="topLeft" min="0">
                                    <label for="zy-menu-badge-radius-topLeft" class="elementor-control-dimension-label"><?php echo esc_html( 'T Left' ); ?></label>
                                </li>
                                    <li class="elementor-control-dimension">
                                    <input id="zy-menu-badge-radius-topRight" type="number" data-setting="topRight" min="0">
                                    <label for="zy-menu-badge-radius-topRight" class="elementor-control-dimension-label"><?php echo esc_html( 'T Right' ); ?></label>
                                </li>
                                <li class="elementor-control-dimension">
                                    <input id="zy-menu-badge-radius-bottomLeft" type="number" data-setting="bottomLeft" min="0">
                                    <label for="zy-menu-badge-radius-bottomLeft" class="elementor-control-dimension-label"><?php echo esc_html( 'B Left' ); ?></label>
                                </li>
                                <li class="elementor-control-dimension">
                                    <input id="zy-menu-badge-radius-bottomRight" type="number" data-setting="bottomRight" min="0">
                                    <label for="zy-menu-badge-radius-bottomRight" class="elementor-control-dimension-label"><?php echo esc_html( 'B Right' ); ?></label>
                                </li>
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="form-table zy-badge-preview" role="presentation">
                <tbody>
					<tr>
						<th scope="row" class="badge-arrow-th"><label for="blogname"><?php echo esc_html_e( 'Enable Arrow', 'zyre-elementor-addons' ); ?></label></th>
						<td class="badge-arrow-td">
							<div class="zy-dashboard-widgets__item-toggle zy-toggle">
								<input id="zy-menu-item-enable-badge-arr" type="checkbox" class="zy-toggle__check zy-widget" value="1">
								<b class="zy-toggle__switch"></b>
								<b class="zy-toggle__track"></b>
							</div>
						</td>
					</tr>
                    <tr>
						<th scope="row"><label for=""><?php esc_html_e('Badge Preview', 'zyre-elementor-addons'); ?></label></th>
                        <td>
                            <div id="badge-preview-backdrop">
                                <div id="badge-preview"><span></span><i class="zy-menu-badge-arrow"></i></div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="zy__tab-content">
            <div role="tabpanel" class="zy__tab-pane zy__active" id="attr_content_tab">
                <?php if( defined( 'ELEMENTOR_VERSION' ) ): ?>
					<div id="zy-menu-builder-warper">
					</div>
					<?php else: ?>
						<p class="no-elementor-notice">
							<?php esc_html_e( 'This plugin requires Elementor page builder to edt megamenu items content', 'zyre-elementor-addons' ); ?>
						</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="zy__modal-footer">
        <input type="hidden" id="zy-menu-modal-menu-id">
        <input type="hidden" id="zy-menu-modal-menu-has-child">
        <span class='spinner'></span>
		<?php
		echo wp_kses(
			get_submit_button(
				__( 'Save', 'zyre-elementor-addons' ),
				'zy-menu-item-save aligncenter',
				'',
				false
			),
			[
				'input' => [
					'type'  => true,
					'name'  => true,
					'value' => true,
					'class' => true,
					'id' => true,
				],
				'p' => [
					'class' => true,
					'id' => true,
				],
			]
		);
		?>
		<i class="fas fa-check zy-checkmark zyre-color-white zyre-d-none zyre-fs-11 zyre-ml--6"></i>
    </div>

</div>

<div class="modal" id="zy-menu-builder-modal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="zy__modal-dialog zy__modal-dialog-centered" role="document">
        <div class="zy__modal-content">
            <div class="zy__modal-body">
                <iframe id="zy-menu-builder-iframe" src="" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>
