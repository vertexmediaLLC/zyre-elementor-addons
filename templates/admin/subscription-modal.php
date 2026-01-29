<?php
/**
 * Subscription modal template
 */

defined( 'ABSPATH' ) || die();
?>

<div id="zyre-subscription-modal" class="zyre-modal zyre-subscription-modal video-modal-shown">
	<div class="zyre-modal-content">
		<span class="zyre-modal-close">&times;</span>
		<h3 style="margin-bottom: 15px;"><?php _e( 'Get Zyre Addons <span>Pro</span> Notification', 'zyre-elementor-addons' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h3>
		<iframe style="min-height: 220px;width:100%;" src="<?php echo esc_url( 'https://templates.zyreaddons.com/zyreaddons-subscription-form/' ); ?>" frameborder="0"></iframe>
	</div>
</div>