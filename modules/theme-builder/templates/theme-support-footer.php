<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
do_action( 'zyreladdons/template/before_footer' );
?>
<div class="ekit-template-content-markup ekit-template-content-footer ekit-template-content-theme-support">
<?php
echo wp_kses(
	\ZyreAddons\Elementor\ThemeBuilder\Module::instance()->render_builder_data_location( 'footer' ),
	zyreladdons_kses_allowed_html()
);
?>
</div>
<?php do_action( 'zyreladdons/template/after_footer' ); ?>
<?php wp_footer(); ?>
</body>
</html>
