<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<?php echo wp_kses( \Elementor\Utils::get_meta_viewport( 'theme-builder' ), [ 'meta' => [ 'name' => true, 'content' => true ] ] ); ?>
	<?php if ( ! current_theme_supports( 'title-tag' ) ) : ?>
		<title><?php echo esc_html( wp_get_document_title() ); ?></title>
	<?php endif; ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<?php do_action( 'zyreladdons/template/before_header' ); ?>

	<div class="zyre-template-content-markup zyre-template-content-header zyre-template-content-theme-support">
		<?php
		echo wp_kses(
			\VertexMediaLLC\ZyreElementorAddons\Modules\ThemeBuilder\Module::instance()->render_builder_data_location( 'header' ),
			zyreladdons_kses_allowed_html()
		);
		?>
	</div>

	<?php do_action( 'zyreladdons/template/after_header' ); ?>
