<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
do_action( 'zyreladdons/template/before_footer' );
?>
<div class="ekit-template-content-markup ekit-template-content-footer ekit-template-content-theme-support">
	<?php echo \VertexMediaLLC\ZyreElementorAddons\Modules\ThemeBuilder\Module::instance()->render_builder_data_location( 'footer' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</div>
<?php do_action( 'zyreladdons/template/after_footer' ); ?>
<?php wp_footer(); ?>
</body>
</html>
