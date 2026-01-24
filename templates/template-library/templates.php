<?php
/**
 * Template library templates
 */

defined( 'ABSPATH' ) || exit;

?>
<script type="text/template" id="tmpl-zyre-TemplateLibrary_header-logo">
	<span class="zyre-TemplateLibrary_logo-wrap">
		<i class="zy-fonticon zy-Zyre-addons"></i>
	</span>
	<span class="zyre-TemplateLibrary_logo-title">{{{ title }}}</span>
</script>

<script type="text/template" id="tmpl-zyre-TemplateLibrary_header-back">
	<i class="eicon-" aria-hidden="true"></i>
	<span><?php echo __( 'Back to Library', 'zyre-elementor-addons' ); ?></span>
</script>

<script type="text/template" id="tmpl-zyre-TemplateLibrary_header-menu">
	<# _.each( tabs, function( args, tab ) { var activeClass = args.active ? 'elementor-active' : ''; #>
		<div class="elementor-component-tab elementor-template-library-menu-item {{activeClass}}" data-tab="{{{ tab }}}">{{{ args.title }}}</div>
	<# } ); #>
</script>

<script type="text/template" id="tmpl-zyre-TemplateLibrary_header-menu-responsive">
	<div class="elementor-component-tab zyre-TemplateLibrary_responsive-menu-item elementor-active" data-tab="desktop">
		<i class="eicon-device-desktop" aria-hidden="true" title="<?php esc_attr_e( 'Desktop view', 'zyre-elementor-addons' ); ?>"></i>
		<span class="elementor-screen-only"><?php esc_html_e( 'Desktop view', 'zyre-elementor-addons' ); ?></span>
	</div>
	<div class="elementor-component-tab zyre-TemplateLibrary_responsive-menu-item" data-tab="tab">
		<i class="eicon-device-tablet" aria-hidden="true" title="<?php esc_attr_e( 'Tab view', 'zyre-elementor-addons' ); ?>"></i>
		<span class="elementor-screen-only"><?php esc_html_e( 'Tab view', 'zyre-elementor-addons' ); ?></span>
	</div>
	<div class="elementor-component-tab zyre-TemplateLibrary_responsive-menu-item" data-tab="mobile">
		<i class="eicon-device-mobile" aria-hidden="true" title="<?php esc_attr_e( 'Mobile view', 'zyre-elementor-addons' ); ?>"></i>
		<span class="elementor-screen-only"><?php esc_html_e( 'Mobile view', 'zyre-elementor-addons' ); ?></span>
	</div>
</script>

<script type="text/template" id="tmpl-zyre-TemplateLibrary_header-actions">
	<div id="zyre-TemplateLibrary_header-sync" class="elementor-templates-modal__header__item">
		<i class="eicon-sync" aria-hidden="true" title="<?php esc_attr_e( 'Sync Library', 'zyre-elementor-addons' ); ?>"></i>
		<span class="elementor-screen-only"><?php esc_html_e( 'Sync Library', 'zyre-elementor-addons' ); ?></span>
	</div>
</script>

<script type="text/template" id="tmpl-zyre-TemplateLibrary_preview">
	<iframe></iframe>
</script>

<script type="text/template" id="tmpl-zyre-TemplateLibrary_header-insert">
	<div id="elementor-template-library-header-preview-insert-wrapper" class="elementor-templates-modal__header__item">
		{{{ zyre.library.getModal().getTemplateActionButton( obj ) }}}
	</div>
</script>

<script type="text/template" id="tmpl-zyre-TemplateLibrary_insert-button">
	<a class="elementor-template-library-template-action elementor-button zyre-TemplateLibrary_insert-button">
		<i class="eicon-file-download" aria-hidden="true"></i>
		<span class="elementor-button-title"><?php esc_html_e( 'Insert', 'zyre-elementor-addons' ); ?></span>
	</a>
</script>

<script type="text/template" id="tmpl-zyre-TemplateLibrary_pro-button">
	<a class="elementor-template-library-template-action elementor-button zyre-TemplateLibrary_pro-button" href="#" target="_blank">
		<i class="eicon-external-link-square" aria-hidden="true"></i>
		<span class="elementor-button-title"><?php esc_html_e( 'Get Pro', 'zyre-elementor-addons' ); ?></span>
	</a>
</script>

<script type="text/template" id="tmpl-zyre-TemplateLibrary_loading">
	<div class="elementor-loader-wrapper">
		<div class="elementor-loader">
			<div class="elementor-loader-boxes">
				<div class="elementor-loader-box"></div>
				<div class="elementor-loader-box"></div>
				<div class="elementor-loader-box"></div>
				<div class="elementor-loader-box"></div>
			</div>
		</div>
		<div class="elementor-loading-title"><?php esc_html_e( 'Loading', 'zyre-elementor-addons' ); ?></div>
	</div>
</script>

<script type="text/template" id="tmpl-zyre-TemplateLibrary_notice">
    <em class="zyre-TemplateLibrary_notice"><?php esc_html_e( 'After importing the template, make sure to publish and reload the page to avoid any widget style reverting issues.', 'zyre-elementor-addons' ); ?></em>
</script>

<script type="text/template" id="tmpl-zyre-TemplateLibrary_templates">
	<div id="zyre-TemplateLibrary_toolbar">
		<div id="zyre-TemplateLibrary_toolbar-filter" class="zyre-TemplateLibrary_toolbar-filter">
			<# if (zyre.library.getTypeTags()) { var selectedTag = zyre.library.getFilter( 'tags' ); #>
				<# if ( selectedTag ) { #>
				<span class="zyre-TemplateLibrary_filter-btn">{{{ zyre.library.getTags()[selectedTag] }}} <i class="eicon-caret-right"></i></span>
				<# } else { #>
				<span class="zyre-TemplateLibrary_filter-btn"><?php esc_html_e( 'Filter', 'zyre-elementor-addons' ); ?> <i class="eicon-caret-right"></i></span>
				<# } #>
				<ul id="zyre-TemplateLibrary_filter-tags" class="zyre-TemplateLibrary_filter-tags">
					<li data-tag="">All</li>
					<# _.each(zyre.library.getTypeTags(), function(slug) {
						var selected = selectedTag === slug ? 'active' : '';
						#>
						<li data-tag="{{ slug }}" class="{{ selected }}">{{{ zyre.library.getTags()[slug] }}}</li>
					<# } ); #>
				</ul>
			<# } #>
		</div>
		<div id="zyre-TemplateLibrary_toolbar-counter"></div>
		<div id="zyre-TemplateLibrary_toolbar-search">
			<label for="zyre-TemplateLibrary_search" class="elementor-screen-only"><?php esc_html_e( 'Search Templates:', 'zyre-elementor-addons' ); ?></label>
			<input id="zyre-TemplateLibrary_search" placeholder="<?php esc_attr_e( 'Search', 'zyre-elementor-addons' ); ?>">
			<i class="eicon-search"></i>
		</div>
	</div>

	<div class="zyre-TemplateLibrary_templates-window">
		<div id="zyre-TemplateLibrary_templates-list"></div>
	</div>
</script>

<script type="text/template" id="tmpl-zyre-TemplateLibrary_template">
	<div class="zyre-TemplateLibrary_template-body" id="zyreTemplate-{{ template_id }}">
		<div class="zyre-TemplateLibrary_template-preview">
			<i class="eicon-zoom-in-bold" aria-hidden="true"></i>
		</div>
		<img class="zyre-TemplateLibrary_template-thumbnail" src="{{ thumbnail }}">
		<# if ( obj.isPro ) { #>
		<span class="zyre-TemplateLibrary_template-badge"><?php esc_html_e( 'Pro', 'zyre-elementor-addons' ); ?></span>
		<# } #>
	</div>
	<div class="zyre-TemplateLibrary_template-footer">
		{{{ zyre.library.getModal().getTemplateActionButton( obj ) }}}
		<a href="#" class="elementor-button zyre-TemplateLibrary_preview-button">
			<i class="eicon-device-desktop" aria-hidden="true"></i>
			<?php esc_html_e( 'Preview', 'zyre-elementor-addons' ); ?>
		</a>
	</div>
</script>

<script type="text/template" id="tmpl-zyre-TemplateLibrary_empty">
	<div class="elementor-template-library-blank-icon">
		<img src="<?php echo ELEMENTOR_ASSETS_URL . 'images/no-search-results.svg'; ?>" class="elementor-template-library-no-results" />
	</div>
	<div class="elementor-template-library-blank-title"></div>
	<div class="elementor-template-library-blank-message"></div>
	<div class="elementor-template-library-blank-footer">
		<?php esc_html_e( 'Want to learn more about the Zyre Library?', 'zyre-elementor-addons' ); ?>
		<a class="elementor-template-library-blank-footer-link" href="#" target="_blank"><?php echo __( 'Click here', 'zyre-elementor-addons' ); ?></a>
	</div>
</script>
