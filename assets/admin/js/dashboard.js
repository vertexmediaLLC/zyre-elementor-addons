"use strict";

; (function ($, ZyreAddonsDashboard) {
	'use strict';

	// Fetch Video ID from provided URL
	function getYouTubeVideoID(videoUrl) {
		const regex = /(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^/]+\/.+|(?:v|embed|shorts)\/|.*[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/;
		const match = videoUrl.match(regex);

		return match ? match[1] : null;
	}

	const $sidePanelToggle = $('.zyre-sidebar-toggle'),
		$sidePanelClose = $('.zyre-sidebar-close'),
		$overlay = $('.zyre-dashboard-overlay');

	var $dashboardWrapper = $('.zyre-dashboard-wrapper'),
		$contentWrapper = $('.zyre-content-wrapper'),

		$videoItem = $contentWrapper.find('.zyre-video-item'),
		videoModalSelector = '#zyre-video-modal',
		$videoModal = $contentWrapper.find(videoModalSelector),
		$videoModalScaler = $videoModal.find('.zyre-iframe-scaler'),
		$videoModalClose = $videoModal.find('.zyre-modal-close'),

		subscriptionModalSelector = '#zyre-subscription-modal',
		$subscriptionModal = $dashboardWrapper.find(subscriptionModalSelector),
		$subscriptionModalClose = $subscriptionModal.find('.zyre-modal-close'),

		$dashboardForm = $('#zyre-dashboard-form'),
		$saveButton = $dashboardForm.find('.zyre-save-settings'),
		$tabsNav = $contentWrapper.find('.zyre-dashboard-tabs-nav'),
		$tabsContent = $contentWrapper.find('.zyre-tab-panel'),

		$credentialInput = $contentWrapper.find('.content-integrations input[type="text"]'),

		$widgetsSidebar = $contentWrapper.find('.zyre-dash-widget-sidebar'),
		$widgetsList = $widgetsSidebar.find('.zyre-dash-widget-sidebar-list'),
		$widgetsContentWrapper = $contentWrapper.find('.zyre-dash-widget-content-main'),
		$widgetItems = $widgetsList.find('.zyre-dash-widget-sidebar-item'),

		widgetContentSelector = '.zyre-dash-widget-tab:not(.widget-pro-placeholder)',
		widgetStyleToggleSelector = '.zyre-widget-style-type-checkbox input[type="checkbox"]',
		widgetStyleToggleOnSelector = '.zyre-widget-style-type-checkbox input[type="checkbox"]:checked',
		widgetToggleSelector = '.zyre-tabs-up-content-right-widget input[type="checkbox"]',
		$widgetEnableAllBtn = $contentWrapper.find('.zyre-enable-all-btn'),
		$widgetDisableAllBtn = $contentWrapper.find('.zyre-disable-all-btn'),
		$widgetToggle = $contentWrapper.find(widgetContentSelector + ' ' + widgetToggleSelector),
		$widgetStyleToggle = $contentWrapper.find(widgetContentSelector + ' ' + widgetStyleToggleSelector);

	/**
	 * Video Modal
	 ============= */
	$videoItem.click(function (e) {
		e.preventDefault();

		const videoUrl = $(this).attr("href"),
			videoId = getYouTubeVideoID(videoUrl),
			videoEmbed = `<iframe class="zyre-video-iframe" src="https://www.youtube.com/embed/${videoId}?autoplay=1" frameborder="0" allowfullscreen></iframe>`;

		$videoModalScaler.append(videoEmbed);
		$videoModal.addClass('video-modal-shown').show();
	});

	// Close Video modal
	$videoModalClose.click(function () {
		$videoModal.fadeOut(function () {
			$videoModal.removeClass('video-modal-shown');
			$videoModalScaler.find('iframe').remove();
		});
	});

	// Close Video modal on background click
	$(window).click(function (e) {
		if ($(e.target).is(videoModalSelector)) {
			$videoModal.fadeOut(function () {
				$videoModal.removeClass('video-modal-shown');
				$videoModalScaler.find('iframe').remove();
			});
		}
	});

	/**
	 * Subscription Modal
	 ==================== */
	$subscriptionModalClose.click(function () {
		$subscriptionModal.fadeOut(function () {
			$subscriptionModal.removeClass('video-modal-shown');
		});
	});

	// Close Subscription modal on background click
	$(window).click(function (e) {
		if ($(e.target).is(subscriptionModalSelector)) {
			$subscriptionModal.fadeOut(function () {
				$subscriptionModal.removeClass('video-modal-shown');
			});
		}
	});

	/**
	 * Main Tabs
	 ============ */
	$tabsNav.on('click', '.zyre-tab-nav-item', function (event) {
		var $currentTab = $(event.currentTarget),
			tabTargetHash = event.currentTarget.hash,
			tabSelector = '.content-' + tabTargetHash.substring(1),
			$currentTabContent = $contentWrapper.find(tabSelector);

		event.preventDefault();

		$currentTab.addClass('nav-item-active').siblings().removeClass('nav-item-active');
		$tabsContent.removeClass('zyre-tab-panel-active');
		$currentTabContent.addClass('zyre-tab-panel-active');

		if (tabTargetHash === '#integrations') {
			$currentTabContent.addClass('integrations-tab-active');
		} else {
			$tabsContent.removeClass('integrations-tab-active');
		}

		window.location.hash = tabTargetHash;
	});

	/**
	 * Widgets Sidebar
	 ================= */

	// Widgets List Tabs
	$widgetsList.on('click', '.zyre-dash-widget-sidebar-item', function (event) {
		event.preventDefault();

		var $currentWidgetTab = $(this),
			targetTabSelector = $currentWidgetTab.data("tab"),
			targetTabContentSelector = '#' + targetTabSelector,
			$currentWidgetTabContent = $widgetsContentWrapper.find(targetTabContentSelector);

		$currentWidgetTab.addClass('active').siblings().removeClass('active');
		$currentWidgetTabContent.addClass('active').siblings().removeClass('active');
	});

	// Handle Widgets Search
	$widgetsSidebar.on('input', '#zyre-sidebar-search', function () {
		const searchTerm = $(this).val().toLowerCase();

		$widgetItems.each(function () {
			const text = $(this).text().toLowerCase();
			if (text.includes(searchTerm)) {
				$(this).show();
			} else {
				$(this).hide();
			}
		});
	});

	// Handle Widgets Sidebar Toggling
	const closeWidgetsSidebar = () => {
		if ($widgetsSidebar.hasClass('open') && $overlay.hasClass('active')) {
			$widgetsSidebar.removeClass('open');
			$overlay.removeClass('active');
		}
	};

	$sidePanelToggle.click(function (e) {
		e.stopPropagation();
		$widgetsSidebar.toggleClass('open');
		$overlay.toggleClass('active');
	});

	$(document).on('click', function (e) {
		if (!$(e.target).closest($widgetsSidebar).length && !$(e.target).closest($sidePanelToggle).length) {
			closeWidgetsSidebar();
		}
	});

	$widgetItems.click(closeWidgetsSidebar);
	$sidePanelClose.click(function () {
		closeWidgetsSidebar();
	});

	$overlay.click(function () {
		closeWidgetsSidebar();
	});

	/**
	 * Click the targeted Tab and widget
	 =================================== */
	if (window.location.hash || window.location.search) {
		var hash = window.location.hash,
			urlParams = new URLSearchParams(window.location.search),
			tabParam = urlParams.get('t'),
			widgetParam = urlParams.get('widget');

		if (hash) {
			$tabsNav.find('a[href="' + hash + '"]').trigger('click');
		} else if (tabParam) {
			$tabsNav.find('a[href="#' + tabParam + '"]').trigger('click');
		}

		// Click the targeted widget.
		if (widgetParam) {
			$widgetsList.find('[data-tab="' + widgetParam + '-widget-tab"]').trigger('click');
		}
	}

	/**
	 * Update Save Button
	 ==================== */
	var initialStates = {},
		hasChanges = false,
		hasCredentialChanges = false;

	$dashboardForm.find('input[type="text"]').each(function () {
		initialStates[$(this).attr('id')] = $(this).val();
	});

	$dashboardForm.find('input[type="checkbox"]').each(function () {
		initialStates[$(this).attr('id')] = $(this).is(':checked');
	});

	const updateSaveButton = () => {
		hasChanges = false;
		hasCredentialChanges = false;

		$dashboardForm.find('input[type="checkbox"], input[type="text"]').each(function () {
			var inputID = $(this).attr('id');

			if ( $(this).is(':checkbox') && $(this).is(':checked') !== initialStates[inputID] ) {
				hasChanges = true;
				return false;
			}

			if ( $(this).is(':text') && $(this).val() !== initialStates[inputID] ) {
				hasCredentialChanges = true;
				return false;
			}
		});

		$saveButton.attr('disabled', !(hasChanges || hasCredentialChanges));
	};

	/**
	 * Handle All Checkboxes
	 ========================= */
	// Update all widget's class
	const updateWidgetsClass = () => {
		$widgetToggle.each(function () {
			var isChecked = $(this).prop('checked'),
				$currentTabContent = $(this).closest(widgetContentSelector);
				
			if (isChecked) {
				$currentTabContent.addClass('zyre-widget-active');
			} else {
				$currentTabContent.removeClass('zyre-widget-active');
			}
		});
	}

	// Update individual widget's class
	const updateTheWidgetClass = (input, checkDefault = false) => {
		var isChecked = input.prop('checked'),
			$currentTabContent = input.closest(widgetContentSelector),
			isCheckedNone = $currentTabContent.find(widgetStyleToggleOnSelector).length === 0;
			
		if (isChecked) {
			$currentTabContent.addClass('zyre-widget-active');
			// Make the default style checked
			if(checkDefault && isCheckedNone) {
				$currentTabContent.find('.zyre-dash-each-widget-style.widget-style--active-default').find(widgetStyleToggleSelector).prop('checked', true);
			}
		} else {
			$currentTabContent.removeClass('zyre-widget-active');
		}
	}

	// Update save button for credential Inputs
	$credentialInput.on('input', function () {
		updateSaveButton();
	});

	// Enable All Widgets
	$widgetEnableAllBtn.click(function () {
		$widgetToggle.prop('checked', true);
		updateWidgetsClass();
		updateSaveButton();
	});

	// Disable All Widgets
	$widgetDisableAllBtn.click(function () {
		$widgetToggle.prop('checked', false);
		updateWidgetsClass();
		updateSaveButton();
	});

	//  Enable/Disable Individual Widget
	$widgetToggle.change(function () {
		updateTheWidgetClass($(this), true);
		updateSaveButton();
	});

	// Enable/Disable Individual Style for an Individual Widget
	$widgetStyleToggle.change(function () {
		var $currentTabContent = $(this).closest('.zyre-dash-widget-tab');
		var isCheckedNone = $currentTabContent.find(widgetStyleToggleOnSelector).length === 0;

		if (isCheckedNone) {
			$currentTabContent.find(widgetToggleSelector).prop('checked', false);
			updateTheWidgetClass($(this));
		}

		updateSaveButton();
	});

	/**
	 * Save Settings
	 */
	$dashboardForm.on('submit', function (e) {
		e.preventDefault();
		$.post({
			url: ZyreAddonsDashboard.ajaxUrl,
			data: {
				nonce: ZyreAddonsDashboard.nonce,
				action: ZyreAddonsDashboard.action,
				formData: $dashboardForm.serialize()
			},
			beforeSend: function beforeSend() {
				$saveButton.addClass('saving');
			},
			success: function success(response) {
				if (response.success) {
					var t = setTimeout(function () {
						$saveButton.removeClass('saving').attr('disabled', true).children('.zyre-save-text').text(ZyreAddonsDashboard.savedLabel);

						hasChanges = false;

						location.reload();
						clearTimeout(t);
					}, 500);
				}
			}
		});
	});

	/**
	 * Need confirmation before leaving/reloading page without savings
	 ================================================================= */
	$(window).on('beforeunload', function (e) {
		if (hasChanges) {
			e.preventDefault();
			e.returnValue = true;
		}
	});

})(jQuery, window.ZyreAddonsDashboard);
