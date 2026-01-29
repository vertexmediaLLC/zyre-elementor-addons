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
		<iframe src="<?php echo esc_url( 'https://templates.zyreaddons.com/zyreaddons-subscription-form/' ); ?>" frameborder="0"></iframe>
		<?php
		printf(
			'<p style="text-align: center;"><span style="font-size: 13px;font-weight:700;text-decoration: underline;cursor: pointer;" id="zyre-user-subscribed" onmouseover="this.style.color=\'#000000\'" onmouseout="this.style.color=\'#999999\'">%s</span></p>',
			esc_html__( 'I already did this!', 'zyre-elementor-addons' )
		)
		?>
	</div>
</div>