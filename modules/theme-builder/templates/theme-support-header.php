<?php
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<?php echo Utils::get_meta_viewport( 'theme-builder' ); ?>
	<?php if ( ! current_theme_supports( 'title-tag' ) ) : ?>
		<title>
			<?php echo wp_get_document_title(); ?>
		</title>
	<?php endif; ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<?php do_action( 'zyreaddons/template/before_header' ); ?>

	<div class="zyre-template-content-markup zyre-template-content-header zyre-template-content-theme-support">
		<?php
		echo \ZyreAddons\Elementor\ThemeBuilder\Module::instance()->render_builder_data_location( 'header' );
		?>
	</div>

	<?php do_action( 'zyreaddons/template/after_header' ); ?>
