<?php do_action( 'zyreaddons/template/before_footer' ); ?>
<div class="ekit-template-content-markup ekit-template-content-footer ekit-template-content-theme-support">
<?php
echo \ZyreAddons\Elementor\ThemeBuilder\Module::instance()->render_builder_data_location( 'footer' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
?>
</div>
<?php do_action( 'zyreaddons/template/after_footer' ); ?>
<?php wp_footer(); ?>
</body>
</html>
