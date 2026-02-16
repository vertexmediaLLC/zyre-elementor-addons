<?php

use ZyreAddons\Elementor\ThemeBuilder\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$types    = Module::get_template_types();
$selected = get_query_var( 'zyre_library_type' );
?>

<script type="text/template" id="tmpl-modal-template-condition">
	<div class="modal micromodal-slide modal-template-condition zyre-template-element-modal" id="modal-new-template-condition" aria-hidden="false">
		<div class="modal__overlay" tabindex="-1">
			<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-login-title">
				<header class="modal__header">
					<h3 class="modal__title">
						<img src="<?php echo zyre_get_b64_3dicon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" width="40" alt="">
						<span><?php esc_html_e( 'Template Elements Condition', 'zyre-elementor-addons' ); ?></span>
					</h3>
					<button class="modal__close" aria-label="<?php esc_attr_e( 'Close modal', 'zyre-elementor-addons' ); ?>" data-micromodal-close=""></button>
				</header>
				<div class="modal__content">
					<div class="modal__form-data">
						<div class="modal__information">
							<div class="modal__info-subtitle"><?php esc_html_e( 'Set Condition', 'zyre-elementor-addons' ); ?></div>
							<div class="modal__info-title"><?php esc_html_e( 'Select where to show your template.', 'zyre-elementor-addons' ); ?></div>
							<div class="modal__info-message"><?php esc_html_e( 'For example, select \'Entire Site\' to display it everywhere.', 'zyre-elementor-addons' ); ?></div>
						</div>
						<p class="zyre-template-notice"></p>
						<form id="zyre-template-edit-form">
							<div class="zyre-template-condition-wrap"></div>
							<button class="zyre-cond-repeater-add" type="button"><?php esc_html_e( '+ Add More', 'zyre-elementor-addons' ); ?></button>
						</form>
					</div>
				</div>
				<footer class="modal__footer">
					<button class="modal__close modal__btn" aria-label="<?php esc_attr_e( 'Close modal', 'zyre-elementor-addons' ); ?>" data-micromodal-close=""><?php esc_html_e( '&times; Cancel', 'zyre-elementor-addons' ); ?></button>
					<button id="zyre-template-save-data" class="modal__btn modal__btn-primary"><?php esc_html_e( 'Save & Close', 'zyre-elementor-addons' ); ?></button>
				</footer>
			</div>
		</div>
	</div>
</script>

<script type="text/template" id="tmpl-elementor-new-template">
	<div id="zyre-template-condition-item-{{uniqeID}}" class="zyre-template-condition-item">
		<div class="zyre-template-condition-item-row">
			<div class="zyre-tce-type">
				<select id="type-{{uniqeID}}" data-id="type-{{uniqeID}}" data-parent="{{uniqeID}}" data-setting="type" class="modal__form-select">
					<option value="include"><?php esc_html_e( 'Include', 'zyre-elementor-addons' ); ?></option>
					<option value="exclude"><?php esc_html_e( 'Exclude', 'zyre-elementor-addons' ); ?></option>
				</select>
			</div>
			<div class="zyre-tce-name">
				<select id="name-{{uniqeID}}" data-id="name-{{uniqeID}}" data-parent="{{uniqeID}}" data-setting="name" class="modal__form-select">
					<optgroup label="<?php esc_attr_e( 'General', 'zyre-elementor-addons' ); ?>">
						<option value="general"><?php esc_html_e( 'Entire Site', 'zyre-elementor-addons' ); ?></option>
						<option value="archive"><?php esc_html_e( 'Archives', 'zyre-elementor-addons' ); ?></option>
						<option value="singular"><?php esc_html_e( 'Singular', 'zyre-elementor-addons' ); ?></option>
					</optgroup>
				</select>
			</div>
			<div class="zyre-tce-sub_name" style="display:none">
				<select id="sub_name-{{uniqeID}}" data-id="sub_name-{{uniqeID}}" data-parent="{{uniqeID}}" data-setting="sub_name" class="modal__form-select">
				</select>
			</div>
			<div class="zyre-tce-sub_id" style="display:none">
				<select id="sub_id-{{uniqeID}}" data-id="sub_id-{{uniqeID}}" data-parent="{{uniqeID}}" data-setting="sub_id" class="modal__form-select">
				</select>
			</div>
		</div>
		<div class="zyre-template-condition-remove">
			<?php echo zyre_get_svg_icon( 'trash-can' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<span class="elementor-screen-only"><?php esc_html_e( 'Remove this item', 'zyre-elementor-addons' ); ?></span>
		</div>
	</div>
</script>