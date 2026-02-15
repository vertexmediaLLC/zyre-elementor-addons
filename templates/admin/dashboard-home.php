<?php
/**
 * Dashboard main template
 */

defined( 'ABSPATH' ) || die();

$widgets = self::get_widgets();
$widget_key_first = array_key_first( $widgets );
$used_widgets = self::get_widgets_raw_usage();
$unused_widgets = self::get_widgets_unusage();

$inactive_widgets = \ZyreAddons\Elementor\Widgets_Manager::get_inactive_widgets();
$active_styles = \ZyreAddons\Elementor\Widgets_Manager::get_widgets_active_styles();

$total_widgets_count = count( $widgets );
$total_used_widgets_count = count( $used_widgets );
$total_unused_widgets_count = count( $unused_widgets );

$total_styles = 0;

foreach ($widgets as $widget) {
    if ( ! empty( $widget['styles'] ) && is_array( $widget['styles'] ) ) {
        $total_styles += count( $widget['styles'] );
    }
}

$widget_style_thumb_ph = ZYRE_ADDONS_ASSETS . 'img/widget-style-thumb-placeholder.png';

$has_pro = zyre_has_pro();

// Get credentials list and data
$credential_list = self::get_credentials();
$credential_data = zyre_get_credentials();
?>

<div class="wrap">
	<div class="zyre-dashboard-wrapper">

		<!-- Dashboard Header -->
		<div class="zyre-dashboard-header">
			<div class="zyre-dashboard-header-left">
				<div class="zyre-logo-wrapper">
					<div class="zyre-logo">
						<img src="<?php echo esc_url( ZYRE_ADDONS_ASSETS . 'img/logo-dashboard.svg' ); ?>" alt="<?php echo esc_attr( 'Zyre Logo' ); ?>" width="190">
					</div>
					<div class="zyre-addons-type">
						<span class="badge-free">Free</span>
						<!-- <span class="badge-pro"><i class="fa-solid fa-star" style="color: #ffaa19;"></i> <span class="badge-pro-text">Pro</span></span> -->
					</div>
				</div>
				
				<div class="zyre-version">
					<span class="version-number"><?php /* translators: %s is the plugin version */ printf( esc_html__( 'Version %s', 'zyre-elementor-addons' ), esc_html( ZYRE_ADDONS_VERSION ) ); ?></span>
					<a href="<?php echo esc_url( 'https://raw.githubusercontent.com/vertexmediaLLC/zyre-elementor-addons/master/changelog.txt' ); ?>" class="changelog" target="_blank"><span class="changelog-text"><?php esc_html_e( 'View Changelog', 'zyre-elementor-addons' ); ?></span> <span class="zyre-icon-svg changelog-icon"><?php echo zyre_get_svg_icon( 'up-right-from-square' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span></a>
				</div>
			</div>
			<div class="zyre-dashboard-header-right" style="display: none;"> <!---- ToDo: Show this part when pro version is released ---->
				<p><?php _e( 'Looking to unlock more opportunities<br>and elevate your journey?', 'zyre-elementor-addons' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
				<a href="#" class="zyre-button-header zyre-button-link">
					<span class="zyre-button-inner">
						<span class="zyre-button-text"><?php esc_html_e( 'Get Pro', 'zyre-elementor-addons' ); ?></span>
					</span>
				</a>
			</div>
		</div>

		<!-- Widgets Counter -->
		<div class="zyre-widgets-counter">
			<div class="zyre-widget-count">
				<span><?php echo esc_html( $total_widgets_count ); ?></span>
				<p><?php esc_html_e( 'Total Widgets', 'zyre-elementor-addons' ); ?></p>
			</div>
			<div class="zyre-widget-in-use">
				<span><?php echo esc_html( $total_used_widgets_count ); ?></span>
				<p><?php esc_html_e( 'In-Use', 'zyre-elementor-addons' ); ?></p>
			</div>
			<div class="zyre-widget-not-in-use">
				<span><?php echo esc_html( $total_unused_widgets_count ); ?></span>
				<p><?php esc_html_e( 'Not In-Use', 'zyre-elementor-addons' ); ?></p>
			</div>
		</div>

		<!-- Content Wrapper -->
		<form id="zyre-dashboard-form" method="POST">
			<div class="zyre-content-wrapper">
				<div class="zyre-tab-up-content">
					<div class="zyre-tab-section">
						<div class="zyre-dashboard-tabs-nav">
							<?php
							$tab_count = 1;
							foreach ( self::get_tabs() as $key => $value ) :
								$class = 'zyre-tab-nav-item';

								if ( 1 === $tab_count ) {
									$class .= ' nav-item-active';
								}

								if ( 'pro' === $key ) {
									$class .= ' nav-item-pro';
								}

								if ( ! empty( $value['href'] ) ) {
									$href = esc_url( $value['href'] );
								} else {
									$href = '#' . $key;
								}

								printf( '<a href="%1$s" aria-controls="tab-content-%2$s" id="tab-nav-%2$s" class="%3$s" role="tab">%4$s %5$s</a>',
									esc_url( $href ),
									esc_attr( $key ),
									esc_attr( $class ),
									isset( $value['icon'] ) ? '<span class="zyre-icon-svg">' . wp_kses( $value['icon'], zyre_get_allowed_html() ) . '</span>' : '',
									isset( $value['title'] ) ? esc_html( $value['title'] ) : sprintf(
										/* translators: %s is the tab number */
										esc_html__( 'Tab %s', 'zyre-elementor-addons' ),
										esc_html( $tab_count )
									)
								);

								++$tab_count; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							endforeach;
							?>
						</div>
						<div class="zyre-save-button">
							<button class="zyre-save-settings" type="submit" disabled><span class="zyre-icon-svg"><?php echo zyre_get_svg_icon( 'floppy-disk' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>&nbsp; <span class="zyre-save-text"><?php esc_html_e( 'Save Settings', 'zyre-elementor-addons' ); ?></span></button>
						</div>
					</div>

					<div class="zyre-tab-content">
						<!-- Dashboard -->
						<div id="content-dashboard" class="zyre-tab-panel zyre-tab-panel-active content-dashboard zyre-tab-full-content">
							<div class="zyre-welcome-content">
								<div class="zyre-tabs-up-content-left">
									<div class="zyre-up-logos">
										<div class="zyre-logo">
											<img src="<?php echo esc_url( ZYRE_ADDONS_ASSETS . 'img/logo-dashboard.svg' ); ?>" alt="<?php echo esc_attr( 'Zyre Logo' ); ?>" width="76">
										</div>
										<span class="zyre-vertical-line"></span>
										<div class="elementor-logo">
											<img src="<?php echo esc_url( ZYRE_ADDONS_ASSETS . 'img/elementor-logo.png' ); ?>" alt="<?php echo esc_attr( 'Elementor Logo' ); ?>" width="140">
										</div>
									</div>
									<div class="zyre-up-content-welcome">
										<h2 class="zyre-welcome-note"><?php esc_html_e( 'Welcome!', 'zyre-elementor-addons' ); ?></h2>
										<p class="zyre-welcome-description"><?php esc_html_e( 'Build your next stunning, pixel-perfect WordPress site quickly and easily with professional Elementor widgets.', 'zyre-elementor-addons' ); ?></p>

										<a href="<?php echo esc_url( 'https://zyreaddons.com/all-widgets/ '); ?>" class="zyre-button-explore zyre-button-link" target="_blank">
											<span class="zyre-button-inner-explore"><?php esc_html_e( 'Explore Elements Library', 'zyre-elementor-addons' ); ?></span>
										</a>
									</div>
								</div>
								<div class="zyre-tabs-up-content-right">
									<figure class="zyre-elements">
										<img src="<?php echo esc_url( ZYRE_ADDONS_ASSETS . 'img/welcome-image.png' ); ?>" alt="<?php echo esc_attr_e( 'Welcome Image', 'zyre-elementor-addons' ); ?>">
									</figure>
								</div>
							</div>
						</div>

						<!-- Widgets -->
						<div id="content-widgets" class="zyre-tab-panel content-widgets">
							<h2 class="zyre-welcome-note zyre-tab-widgets-heading"><?php esc_html_e( 'Elements Library', 'zyre-elementor-addons' ); ?></h2>
							<div class="widgets-control">
								<div class="zyre-tabs-up-content-left">
									<p class="zyre-tab-sub-heading"><?php esc_html_e( 'Global Control', 'zyre-elementor-addons' ); ?></p>
									<p class="zyre-widget-description"><?php esc_html_e( 'Use toggle button to active or deactive all widgets at once.', 'zyre-elementor-addons' ); ?></p>
								</div>
								<div class="zyre-tabs-all-content-right-widget">
									<div class="zyre-widget-ctrl-btns">
										<button class="zyre-widget-ctrl-btn zyre-disable-all-btn" type="button"><?php esc_html_e( 'Disable all', 'zyre-elementor-addons' ); ?></button>
										<button class="zyre-widget-ctrl-btn zyre-enable-all-btn" type="button"><?php esc_html_e( 'Enable all', 'zyre-elementor-addons' ); ?></button>
									</div>
								</div>
							</div>
						</div>

						<!-- Integrations -->
						<div id="content-integrations" class="zyre-tab-panel content-integrations">
							<div class="zyre-tabs-up-content-left">
								<div class="zyre-tab-content-headings">
									<p class="zyre-tab-sub-heading"><?php esc_html_e( 'Third-Party Credentials & Plugin Integrations', 'zyre-elementor-addons' ); ?></p>
									<p class="zyre-integration-description"><?php esc_html_e( 'Below is the list of credentials and plugins. You can enter credentials and install third-party plugins from this section. After making any changes, be sure to click the "Save Settings" button.', 'zyre-elementor-addons' ); ?></p>
								</div>

								<div class="zyre-dashboard-credentials">
									<?php foreach ( $credential_list as $credential_key => $credential ) :
										$label = isset( $credential['title'] ) ? $credential['title'] : '';
										$help = isset( $credential['help'] ) ? $credential['help'] : '';
										$icon = isset( $credential['icon'] ) ? $credential['icon'] : '';
										$is_pro = isset( $credential['is_pro'] ) && $credential['is_pro'] ? true : false;
										$is_placeholder = $is_pro && ! zyre_has_pro();
										$item_class = 'zyre-credential__item zyre-credential__item-' . $credential_key;

										$fields = isset( $credential['fields'] ) ? $credential['fields'] : '';

										if ( $is_pro ) {
											$item_class .= ' item-is-pro';
										}

										$checked = '';

										if ( $is_placeholder ) {
											$item_class .= ' item-is-placeholder';
											$checked = 'disabled';
										}
										?>

										<div class="<?php echo esc_attr( $item_class ); ?>">
											<div class="zyre-credential__item-title-wrap">
												<?php if ( $is_pro ) : ?>
													<span class="zyre-credential__item-badge"><?php esc_html_e( 'Pro', 'zyre-elementor-addons' ); ?></span>
												<?php endif; ?>
												<span class="zyre-credential__item-icon">
													<?php if ( 'mailchimp' === $credential_key ) :
														echo zyre_get_svg_icon( 'mailchimp' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
															else : ?>
															<i class="<?php echo esc_attr( $icon ); ?>"></i>
													<?php endif; ?>
												</span>
												<h3 class="zyre-credential__item-title">
													<label for="zyre-widget-<?php echo esc_attr( $credential_key ); ?>" <?php echo $is_placeholder ? 'data-tooltip="Get pro"' : ''; ?>>
														<?php echo esc_html( $label ); ?>
													</label>
												</h3>
											</div>
											<div class="zyre-credential__item-input-wrap">
												<?php foreach ( $fields as $key => $value ) : ?>
													<div class="zyre-credential__item-input">
														<label for="<?php echo esc_attr( $credential_key . '-' . $value['name'] ); ?>">
															<?php echo esc_html( $value['label'] ); ?>
															<?php if ( ! empty( $value['help'] ) ) : ?>
																<a href="<?php echo esc_url( $value['help']['link'] ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $value['help']['instruction'] ); ?></a>
															<?php endif; ?>
														</label>
														<?php if ( 'textarea' === $value['type'] ) : ?>
															<textarea id="<?php echo esc_attr( $credential_key ); ?>" <?php echo esc_attr( $checked ); ?> class="zyre-credential-textarea" name="credentials[<?php echo esc_attr( $credential_key ); ?>][<?php echo esc_attr( $value['name'] ); ?>]" cols="30" rows="10"><?php echo esc_attr( isset( $credential_data[ $credential_key ][ $value['name'] ] ) ? esc_html( $credential_data[ $credential_key ][ $value['name'] ] ) : '' ); ?></textarea>
														<?php else : ?>
															<input id="<?php echo esc_attr( $credential_key ) . '-' . esc_attr( $value['name'] ); ?>" <?php echo esc_attr( $checked ); ?> type="<?php echo esc_attr( $value['type'] ); ?>" class="zyre-credential-input" name="credentials[<?php echo esc_attr( $credential_key ); ?>][<?php echo esc_attr( $value['name'] ); ?>]" value="<?php echo esc_attr( isset( $credential_data[ $credential_key ][ $value['name'] ] ) ? esc_attr( $credential_data[ $credential_key ][ $value['name'] ] ) : '' ); ?>">
														<?php endif; ?>
													</div>
												<?php endforeach; ?>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						</div>

						<!-- Get Pro -->
						<div id="content-pro" class="zyre-tab-panel content-pro" style="display: none;"> <!-- ToDo: Show this part when pro version is released -->
							<div class="zyre-tabs-up-content-left">
								<div class="zyre-tab-content-headings">
									<p class="zyre-tab-sub-heading"><?php esc_html_e( 'Enhance Elementor experience and elevate your journey by unlocking Pro-Version.', 'zyre-elementor-addons' ); ?></p>
									<p class="zyre-integration-description"><?php esc_html_e( 'Get access to automatic updates & keep your website up-to-dates.', 'zyre-elementor-addons' ); ?></p>
								</div>
								<a href="#" class="zyre-button-pro zyre-button-link">
									<span class="zyre-button-inner-pro"><?php esc_html_e( 'Get Pro Now', 'zyre-elementor-addons' ); ?></span>
								</a>
							</div>
						</div>
					</div>
				</div>

				<!-- Dashboard part -->
				<div class="zyre-tab-panel zyre-tab-panel-active content-dashboard zyre-dashboard-full">
					<div class="zyre-dash-content">
						<!-- Main Content -->
						<div class="zyre-content-main zyre-home-content-left">
							<h2><?php esc_html_e( 'Video Tutorials', 'zyre-elementor-addons' ); ?></h2>
							<div class="zyre-video-wrapper">
								<a class="zyre-video-item" href="<?php echo esc_url('https://www.youtube.com/watch?v=im5FkD2gvUQ'); ?>">
									<div class="zyre-video zyre-flex-center">
										<img class="zyre-video-bg" src="<?php echo esc_url( ZYRE_ADDONS_ASSETS . 'img/manage-widgets-styles.jpg' ); ?>" alt="">
										<div class="zyre-video-play-btn"></div>
									</div>
									<h3 class="zyre-video-title"><?php esc_html_e( 'How to Manage Widgets and Styles', 'zyre-elementor-addons' ); ?></h3>
								</a>
								<a class="zyre-video-item" href="<?php echo esc_url('https://www.youtube.com/watch?v=aPPgxrB-8Bw'); ?>">
									<div class="zyre-video zyre-flex-center">
										<img class="zyre-video-bg" src="<?php echo esc_url( ZYRE_ADDONS_ASSETS . 'img/design-from-scratch.jpg' ); ?>" alt="">
										<div class="zyre-video-play-btn"></div>
									</div>
									<h3 class="zyre-video-title"><?php esc_html_e( 'How to Design From Scratch', 'zyre-elementor-addons' ); ?></h3>
								</a>
								<a class="zyre-video-item" href="<?php echo esc_url('https://www.youtube.com/watch?v=cPH6I2ancMI'); ?>">
									<div class="zyre-video zyre-flex-center">
										<img class="zyre-video-bg" src="<?php echo esc_url( ZYRE_ADDONS_ASSETS . 'img/import-templates.jpg' ); ?>" alt="">
										<div class="zyre-video-play-btn"></div>
									</div>
									<h3 class="zyre-video-title"><?php esc_html_e( 'How to Import Templates', 'zyre-elementor-addons' ); ?></h3>
								</a>
								<a class="zyre-video-item" href="<?php echo esc_url('https://www.youtube.com/watch?v=KhoMkFSeGE4'); ?>">
									<div class="zyre-video zyre-flex-center">
										<img class="zyre-video-bg" src="<?php echo esc_url( ZYRE_ADDONS_ASSETS . 'img/build-header-template.jpg' ); ?>" alt="">
										<div class="zyre-video-play-btn"></div>
									</div>
									<h3 class="zyre-video-title"><?php esc_html_e( 'How to Design Header Template', 'zyre-elementor-addons' ); ?></h3>
								</a>
							</div>
			
							<a href="<?php echo esc_url( 'https://www.youtube.com/watch?v=dVWxTTj64F8&list=PLtZBNkN6i7pBSeD6oblNEeJhZ2jGkE4Sj' ); ?>" target="_blank" class="zyre-button-header zyre-browse-button">
								<span class="zyre-button-inner">
									<span class="zyre-button-text"><?php esc_html_e( 'View More Videos', 'zyre-elementor-addons' ); ?> <span class="zyre-icon-svg"><?php echo wp_kses( zyre_get_svg_icon( 'up-right-from-square' ), zyre_get_allowed_html() ); ?></span></span>
								</span>
							</a>
			
							<div class="zyre-rating">
								<div class="zyre-rating-stars"><?php echo wp_kses( zyre_get_svg_icon( '5stars' ), zyre_get_allowed_html() ); ?></div>
								<h2 class="zyre-rating-heading"><?php esc_html_e( 'Happy with ZyreAddons', 'zyre-elementor-addons' ); ?></h2>
								<a href="#" class="zyre-rating-link" target="_blank"><span class="rate-us-link-text"><?php esc_html_e( 'Please rate us', 'zyre-elementor-addons' ); ?></span> <span class="zyre-icon-svg"><?php echo wp_kses( zyre_get_svg_icon( 'up-right-from-square' ), zyre_get_allowed_html() ); ?></span></a>
							</div>
			
							<!-- Modal -->
							<div id="zyre-video-modal" class="zyre-modal">
								<div class="zyre-modal-content">
									<div class="zyre-iframe-scaler">
										<span class="zyre-modal-close">&times;</span>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Sidebar -->
						<div class="zyre-home-content-sidebar">
							<h3><?php esc_html_e( 'Quick Help Links', 'zyre-elementor-addons' ); ?></h3>
							<div class="zyre-sidebar-content">
								<div class="zyre-sidebar-header">
									<div class="zyre-help-knowledge-logo"><?php echo wp_kses( zyre_get_svg_icon( 'knowledge-base' ), zyre_get_allowed_html() ); ?></div>
									<h2 class="zyre-sidebar-header-heading"><?php esc_html_e( 'Knowledge Base', 'zyre-elementor-addons' ); ?></h2>
								</div>
								<p class="zyre-sidebar-description"><?php esc_html_e( 'Explore our comprehensive documentation to familiarize yourself with Zyre.', 'zyre-elementor-addons' ); ?></p>
								<a href="<?php echo esc_url( 'https://zyreaddons.com/docs/' ); ?>" target="_blank" class="zyre-button-header zyre-browse-button">
									<span class="zyre-button-inner">
										<span class="zyre-button-text"><?php esc_html_e( 'Browse Documentation', 'zyre-elementor-addons' ); ?></span>
									</span>
								</a>
							</div>
							<div class="zyre-sidebar-content" style="display: none;"> <!-- ToDo: show when support center is available -->
								<div class="zyre-sidebar-header">
									<div class="zyre-help-knowledge-logo"><?php echo wp_kses( zyre_get_svg_icon( 'support-center' ), zyre_get_allowed_html() ); ?></div>
									<h2 class="zyre-sidebar-header-heading"><?php esc_html_e( 'Support Center', 'zyre-elementor-addons' ); ?></h2>
								</div>
								<p class="zyre-sidebar-description"><?php esc_html_e( 'We may have already answered your question— visit our Support Forum to find the solution.', 'zyre-elementor-addons' ); ?></p>
								<a href="#" target="_blank" class="zyre-button-header zyre-browse-button">
									<span class="zyre-button-inner">
										<span class="zyre-button-text"><?php esc_html_e( 'Visit Suppport Forum', 'zyre-elementor-addons' ); ?></span>
									</span>
								</a>
							</div>
							<div class="zyre-sidebar-content">
								<div class="zyre-sidebar-header">
									<div class="zyre-help-knowledge-logo"><?php echo wp_kses( zyre_get_svg_icon( 'ask-question' ), zyre_get_allowed_html() ); ?></div>
									<h2 class="zyre-sidebar-header-heading"><?php esc_html_e( 'Ask a Question', 'zyre-elementor-addons' ); ?></h2>
								</div>
								<p class="zyre-sidebar-description"><?php esc_html_e( 'Need further help? Submit a support request for quick assistance.', 'zyre-elementor-addons' ); ?></p>
								<a href="<?php echo esc_url( 'https://zyreaddons.com/contact/' ); ?>" target="_blank" class="zyre-button-header zyre-browse-button">
									<span class="zyre-button-inner">
										<span class="zyre-button-text"><?php esc_html_e( 'Submit a Question', 'zyre-elementor-addons' ); ?></span>
									</span>
								</a>
							</div>
						</div>
					</div>
				</div>

				<?php if ( ! zyre_is_cf7_activated() ) : // ToDo: Update this condition when the Elementor theme is released. ?>
				<div class="zyre-tab-panel zyre-tab-panel-active content-integrations content-dashboard">
					<div class="zyre-dash-plugin-install">
						<h2 class="zyre-dash-widget-install-header"><?php esc_html_e( 'ZyreAddons Integrations', 'zyre-elementor-addons' ); ?></h2>
						<div class="zyre-plugin-install">
							<!-- Elementorin Theme -->
							<div class="zyre-each-plugin" style="display: none;">
								<div class="zyre-each-plugin-header">
									<div><img src="<?php echo esc_url( ZYRE_ADDONS_ASSETS . 'img/integration-elementorin.png' ); ?>" alt=""></div>
									<p><?php esc_html_e( 'Free', 'zyre-elementor-addons' ); ?></p>
								</div>
								<div class="zyre-each-plugin-body">
									<h2 class="zyre-plugin-name"><?php echo esc_html( 'Elementorin' ); ?></h2>
									<p class="zyre-plugin-description"><?php _e( 'Free Elementor WordPress<br>theme and addons', 'zyre-elementor-addons' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
								</div>
								<a href="#" class="zyre-button-header zyre-install-button">
									<span class="zyre-button-inner"><span class="zyre-button-text"><?php esc_html_e( 'Install Now', 'zyre-elementor-addons' ); ?></span></span>
								</a>
							</div>
							<!-- Contact Form 7 -->
							<?php if ( ! zyre_is_cf7_activated() ) :
								$cf7_missing_info = zyre_get_plugin_missing_info(
									[
										'plugin_name' => 'contact-form-7',
										'plugin_file' => 'contact-form-7/wp-contact-form-7.php',
									]
								);
								$cf7_missing_url = ! empty( $cf7_missing_info['url'] ) ? $cf7_missing_info['url'] : '#';
								$cf7_missing_title = ! empty( $cf7_missing_info['title'] ) ? $cf7_missing_info['title'] : '';
								?>
								<div class="zyre-each-plugin">
									<div class="zyre-each-plugin-header">
										<div><img src="<?php echo esc_url( ZYRE_ADDONS_ASSETS . 'img/integration-cf7.png' ); ?>" alt=""></div>
										<p><?php esc_html_e( 'Free', 'zyre-elementor-addons' ); ?></p>
									</div>
									<div class="zyre-each-plugin-body">
										<h2 class="zyre-plugin-name"><?php esc_html_e( 'Contact Form 7', 'zyre-elementor-addons' ); ?></h2>
										<p class="zyre-plugin-description"><?php _e( 'Enable your visitors to connect<br>with you', 'zyre-elementor-addons' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
									</div>
									<?php
									printf(
										'<a href="%s" class="zyre-button-header zyre-install-button"><span class="zyre-button-inner"><span class="zyre-button-text">%s</span></span></a>',
										esc_url( $cf7_missing_url ),
										esc_html( $cf7_missing_title ) . esc_html__( ' Now', 'zyre-elementor-addons' )
									)
									?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<?php endif; ?>
				
				<!-- Widget part -->
				<div class="zyre-tab-panel content-widgets zyre-widget-main">
					<div class="zyre-widget-header-part">
						<!-- Sidebar Toggle -->
						<div class="zyre-sidebar-toggle">
							<span><i class="fa-solid fa-bars" style="font-size: 30px;"></i></span>
						</div>

						<h2 class="zyre-widget-title">
							<?php
							printf(
								'%1$s <span class="zyre-widget-count">%2$d</span> <span class="zyre-total-styles">%3$d %4$s</span>',
								esc_html( _n( 'Widget', 'Widgets', $total_widgets_count, 'zyre-elementor-addons' ) ),
								esc_html( number_format_i18n( $total_widgets_count ) ),
                                esc_html( number_format_i18n( $total_styles ) ),
                                esc_html( _n( 'Style', 'Styles', $total_styles, 'zyre-elementor-addons' ) ),
							);
							?>
						</h2>
					</div>
						
					<div class="zyre-dash-content zyre-dash-widget-content">
						<!-- overlay -->
						<div class="zyre-dashboard-overlay"></div>

						<!-- Widgets Sidebar -->
						<div class="zyre-sidebar zyre-dash-widget-sidebar">
							<div class="zyre-sidebar-close" style="color: #bec5cf;">
								<span><i class="fa-solid fa-xmark"></i></span>
							</div>

							<!-- Widgets Search Box -->
							<form action="">
								<div class="zyre-search-box">
									<input type="search" class="zyre-search-box-input" id="zyre-sidebar-search" placeholder="<?php esc_attr_e( 'Search Widgets', 'zyre-elementor-addons' ); ?>">
									<button class="zyre-search-box-button" type="submit">
										<?php echo wp_kses( zyre_get_svg_icon( 'search' ), zyre_get_allowed_html() ); ?>
									</button>
								</div>
							</form>

							<!-- Sidebar Widgets List -->
							<ul class="zyre-dash-widget-sidebar-list">
								<?php foreach ( $widgets as $widget_key => $widget ) : ?>
									<li data-tab="<?php echo esc_attr( $widget_key ); ?>-widget-tab" class="zyre-dash-widget-sidebar-item <?php echo $widget_key === $widget_key_first ? esc_attr( 'active' ) : ''; ?>">
										<i class="<?php echo esc_attr( $widget['icon'] ); ?>"></i><?php echo esc_html( $widget['title'] ); ?> <span class="zyre-widget-count-list"><?php echo esc_html( count( $widget['styles'] ) ); ?></span>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>

						<!-- All Widgets Content -->
						<div class="zyre-content-main zyre-content-left zyre-dash-widget-content-main">
							<?php foreach ( $widgets as $widget_key => $widget ) :
								$is_pro = isset( $widget['is_pro'] ) && $widget['is_pro'] ? true : false;
								$is_pro_placeholder = $is_pro && ! zyre_has_pro();
								$widget_styles = $widget['styles'];
								$widget_styles_count = count( $widget_styles );
								$widget_class = 'zyre-dash-widget-tab';

								$widget_active = false;
								$default_style_key = self::get_widget_default_style_key( $widget_key );
								$checked = '';

								if ( ! $is_pro_placeholder && ! in_array( $widget_key, $inactive_widgets, true ) ) {
									$widget_active = true;
									$checked = 'checked';
									$widget_class .= ' zyre-widget-active';
								}

								if ( $widget_key === $widget_key_first ) {
									$widget_class .= ' active';
								}

								if ( $is_pro_placeholder ) {
									$widget_class .= ' widget-pro-placeholder';
									$checked = 'disabled';
								}

								$demo_url = ! empty( $widget['demo'] ) ? $widget['demo'] : '#';
								$doc_url = ! empty( $widget['doc'] ) ? $widget['doc'] : '#';
								?>
								<div id="<?php echo esc_attr( $widget_key ); ?>-widget-tab" class="<?php echo esc_attr( $widget_class ); ?>">
									<!-- Pro Badge -->
									<?php if ( $is_pro_placeholder ) : ?>
										<div class="zyre-widget-pro-badge"><span class="zyre-widget-pro-badge-text"><?php esc_html_e( 'Pro', 'zyre-elementor-addons' ); ?></span></div>
									<?php endif; ?>

									<!-- Individual widget header -->
									<div class="zyre-dash-widget-tab-header">
										<h2 class="zyre-dash-widget-header">
											<?php
											printf(
												'%1$s <span class="widget-header-count">%2$s</span>',
												esc_html( $widget['title'] ),
												sprintf(
													/* translators: %s is the style count */
													esc_html( _n( '%s style', '%s styles', $widget_styles_count, 'zyre-elementor-addons' ) ),
													esc_html( $widget_styles_count )
												)
											);
											?>
										</h2>
										
										<div class="zyre-tabs-up-content-right-widget">
											<p class="zyre-tab-disable"><?php esc_html_e( 'Inactive', 'zyre-elementor-addons' ); ?></p>
											<input type="checkbox" name="widgets[]" value="<?php echo esc_attr( $widget_key ); ?>" id="<?php echo esc_attr( $widget_key ); ?>-widget-checkbox" <?php echo esc_attr( $checked ); ?>>
											<p class="zyre-tab-enable"><?php esc_html_e( 'Active', 'zyre-elementor-addons' ); ?></p>
										</div>

										<div class="zyre-widget-help-links">
											<a href="<?php echo esc_url( $demo_url ); ?>" target="_blank"><?php esc_html_e( 'View Demo', 'zyre-elementor-addons' ); ?> <i class="fas fa-external-link-alt"></i></a>
											<a href="<?php echo esc_url( $doc_url ); ?>" target="_blank"><?php esc_html_e( 'Documentation', 'zyre-elementor-addons' ); ?> <i class="fas fa-external-link-alt"></i></a>
										</div>
									</div>

									<!-- Individual widget styles -->
									<div class="zyre-dash-widget-tab-body">
										<?php
										$i = 1;
										foreach ( $widget_styles as $style_key => $style ) :
											$thumb_url = ! empty( $style['thumb'] ) ? $style['thumb'] : $widget_style_thumb_ph;
											$is_default_style = $default_style_key === $style_key;

											$is_active = isset( $active_styles[ $widget_key ] ) && ! empty( $active_styles[ $widget_key ] ) ? in_array( $style_key, $active_styles[ $widget_key ], true ) : $style['is_active'];
											$checked_style = $is_active ? 'checked' : '';

											if ( $is_pro_placeholder ) {
												$checked_style = 'disabled';
											}
											?>
											<div class="zyre-dash-each-widget-style <?php echo $is_default_style ? 'widget-style--active-default' : ''; ?>">
												<figure>
													<img src="<?php echo esc_url( $thumb_url ); ?>" alt="">
												</figure>
												<div class="zyre-dash-each-widget-style-content">
													<p class="zyre-widget-style-type">
														<?php
														printf(
															/* translators: 1: style number, 2: style name */
															'%1$s<span class="zyre-widget-style-option">- %2$s</span>',
															sprintf(
																/* translators: %d is the style number */
																esc_html__( 'Style %d', 'zyre-elementor-addons' ),
																esc_html( $i )
															),
															esc_html( $style['name'] )
														);
														?>
													</p>
													<div class="zyre-widget-style-type-checkbox">
														<input type="checkbox" name="widgets_styles[<?php echo esc_attr( $widget_key ); ?>][]" value="<?php echo esc_attr( $style_key ); ?>" id="<?php echo esc_attr( $widget_key ); ?>-widget-style-<?php echo esc_attr( $style_key ); ?>-checkbox" <?php echo esc_attr( $checked_style ); ?>>
													</div>
												</div>
											</div>
											<?php
											++$i;
										endforeach;
										?>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>

				<!-- Get-Pro part-->
				<div class="zyre-tab-panel zyre-dash-content content-pro"></div>
			</div>
		</form>

		<?php
		// Subscription Modal
		if ( ! self::is_user_subscribed() ) {
			include_once ZYRE_ADDONS_DIR_PATH . 'templates/admin/subscription-modal.php';
		}
		?>
	</div> <!-- .zyre-dashboard-wrapper -->
</div>