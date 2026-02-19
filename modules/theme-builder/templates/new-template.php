<?php

use ZyreAddons\Elementor\ThemeBuilder\Module;

defined( 'ABSPATH' ) || die();

$types = Module::get_template_types();
$selected = get_query_var( 'zyre_library_type' );

?>

<script type="text/template" id="zyre-modal-new-template-container">
	<div class="modal micromodal-slide modal-template-condition zyre-template-element-modal" id="zyre-modal-new-template" aria-hidden="false">
		<div class="modal__overlay" tabindex="-1">
			<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-login-title">
				<header class="modal__header">
					<h3 class="modal__title">
						<img src="<?php echo esc_attr( zyre_get_b64_3dicon() ); ?>" width="40" alt="">
						<span><?php esc_html_e( 'Create New Template', 'zyre-elementor-addons' ); ?></span>
					</h3>
					<button class="modal__close" aria-label="<?php esc_attr_e( 'Close modal', 'zyre-elementor-addons' ); ?>" data-micromodal-close=""></button>
				</header>
				<div class="modal__content new-template">
					<div class="modal__information">
						<div class="modal__info-subtitle"><?php esc_html_e( 'ZyreAddons Theme Builder', 'zyre-elementor-addons' ); ?></div>
						<div class="modal__info-title"><?php esc_html_e( 'Enables fast and efficient design creation.', 'zyre-elementor-addons' ); ?></div>
						<div class="modal__info-message"><?php esc_html_e( 'Easily build reusable site components, such as headers and footers, and deploy them effortlessly across your projects', 'zyre-elementor-addons' ); ?></div>
					</div>
					<form id="zyre-new-template-form" action="">
						<input type="hidden" name="post_type" value="zyre_library">
						<input type="hidden" name="action" value="zyre_library_new_post">
						<input type="hidden" name="_wpnonce" value="<?php echo esc_attr( wp_create_nonce( 'zyre_library_new_post_nonce' ) ); ?>">
						<div id="zyre-new-template-form__template-type-wrapper" class="elementor-form-field">
							<div class="zyre-new-template-form__select-wrapper">
								<select id="zyre-new-template-form__template-type" class="elementor-form-field__select" name="template_type" required>
									<option value=""><?php esc_html_e( 'Choose type', 'zyre-elementor-addons' ); ?></option>
									<?php
									foreach ( $types as $value => $type_title ) {
										printf( '<option value="%1$s" %2$s>%3$s</option>', esc_attr( $value ), selected( $selected, $value, false ), esc_html( $type_title ) );
									}
									?>
								</select>
							</div>
						</div>

						<div id="zyre-new-template-form__post-title__wrapper" class="elementor-form-field">
							<div class="zyre-new-template-form__text__wrapper">
								<input type="text" placeholder="<?php esc_attr_e( 'Enter name', 'zyre-elementor-addons' ); ?>" id="zyre-new-template-form__post-title" class="zyre-new-template-form__field__text" name="post_data[post_title]" required>
							</div>
						</div>

						<button id="zyre-new-template-form__submit" class="zyre-btn zyre-btn-primary" disabled><?php esc_html_e( 'Create Template', 'zyre-elementor-addons' ); ?></button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</script>