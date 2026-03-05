<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
do_action( 'zyreaddons/template/before_footer' );
?>
<div class="ekit-template-content-markup ekit-template-content-footer ekit-template-content-theme-support">
<?php
echo wp_kses(
	\ZyreAddons\Elementor\ThemeBuilder\Module::instance()->render_builder_data_location( 'footer' ),
	zyre_kses_allowed_html()
);
?>
</div>
<?php do_action( 'zyreaddons/template/after_footer' ); ?>
<?php wp_footer(); ?>
</body>
</html>
