(function ($, elementor) {
    // Global flag to track whether styles have been fetched
    window.zyrePreStylesInitialized = window.zyrePreStylesInitialized || {};

    var ZyreStyleSelectControl = elementor.modules.controls.Select.extend({
        onReady: function () {

            window.zyrePreStylesStore = window.zyrePreStylesStore || {};
			window.zyrePreStylesCached = window.zyrePreStylesCached || {};
            window.currentSelectedValue = this.ui.select.val();
			
            // Check if styles have already been fetched for this widget
            if (!window.zyrePreStylesInitialized[this.getWidgetID()]) {
                this.fetchStyles(this.isDuplicated() ? false : true);

                // Mark the styles as fetched for this widget
                window.zyrePreStylesInitialized[this.getWidgetID()] = true;
            }
        },

        onRender: function () {
            this.constructor.__super__.onRender.apply(this, arguments);
            // this.addResetButton();
        },

		onElementChange: function () {
			this.$el.find('.zyre-reset-style').removeAttr('disabled');
		},

        addResetButton: function () {
            var self = this;

            this.ui.select.parent().prev().after(
                '<button class="zyre-reset-style" title="Reset Current Style">' +
                '<i class="eicon-undo" aria-hidden="true"></i> Reset' +
                '</button>'
            );

            this.$el.find(".zyre-reset-style").on("click", function () {
                self.onResetClick();
            });
        },

        onResetClick: function () {
			var selectedValue = this.ui.select.val();
			var styles = this.getStylesMerged(true);
			if (styles[selectedValue]) {
				var confirmed = window.confirm(zyrePreStyles.resetStyleAlert);
				if (confirmed) {
					this.resetStyle(styles[selectedValue]);
				}
            }
        },

        getElementSettingsModel: function () {
            return this.container.settings;
        },

		getWidgetAction: function () {
			var history = this.container.document.history.currentItem?.attributes;

			return history?.action !== undefined ? history.action.toLowerCase() : '';
		},

		isDuplicated: function() {
			return this.getWidgetAction() === 'duplicate';
		},

        getWidgetName: function () {
            return this.getElementSettingsModel().get("widgetType");
        },

		getWidgetID: function () {
			return this.container.model.id;
		},

        fetchStyles: function (applyInitial = false, isReset = false) {
            var self = this;

            if (!this.getWidgetName()) {
                return;
            }

			var postId = elementor.config.initial_document.id;

			// Prepare the AJAX request data
			var requestData = {
				action: "zyre_widget_set_prestyle",
				widget: this.getWidgetName(),
				widgetID: this.getWidgetID(),
				post_id: postId,
				security: zyrePreStyles.security
			};

			// Add the 'reset' parameter if isReset is true
			if (isReset) {
				requestData.reset = true;
			}

            $.get(zyrePreStyles.ajaxUrl, requestData).done(function (response) {
                if (response.success) {
                    // Parse and set the styles
                    self.setStyles(response.data);

					// Apply initial design if `applyInitial` is true
                    if (applyInitial) {
						var selectedValue = self.ui.select.val();
						var styles = self.getStyles();
						
						if (styles[selectedValue]) {
							self.applyStyle(styles[selectedValue]);
						}
					}
                }
            });
        },

        setStyles: function (data) {
            window.zyrePreStylesStore[this.getWidgetName()] = JSON.parse(data);
        },

        getStyles: function () {
            return window.zyrePreStylesStore[this.getWidgetName()] || {};
        },

        onBaseInputChange: function (event) {
            this.constructor.__super__.onBaseInputChange.apply(this, arguments);

            if (!event.currentTarget.value) {
                return;
            }

			var selectedValue = event.currentTarget.value;

			// Cache the current style before switching
			this.cacheCurrentStyle( window.currentSelectedValue );

			// Update the stored value to the newly selected value
			window.currentSelectedValue = selectedValue;

			var styles = this.getStylesMerged();
			if (styles[selectedValue]) {
				this.applyStyle(styles[selectedValue]);
            }
        },

		cacheCurrentStyle: function (selectedValue) {
			var currentSettings = this.getElementSettingsModel().toJSON();

			// Fix pre-selected style option value before switching to another.
			var selectSettingKey = this.ui.select.attr('data-setting') || '';
			if( currentSettings.hasOwnProperty(selectSettingKey) ) {
				currentSettings[selectSettingKey] = selectedValue;
			}

			// Get the Widget's ID and store it.
			var cacheID = this.getWidgetID();
			
			// Ensure the widget-specific cache exists
			if (!window.zyrePreStylesCached[cacheID]) {
				window.zyrePreStylesCached[cacheID] = {};
			}

			// Ensure the selected style cache exists
			if (!window.zyrePreStylesCached[cacheID][selectedValue]) {
				window.zyrePreStylesCached[cacheID][selectedValue] = {};
			}
		
			// Cache the current settings under the selected value
			window.zyrePreStylesCached[cacheID][selectedValue] = currentSettings;
		},

		getStylesCached: function () {
			return window.zyrePreStylesCached || {};
		},

		getStylesMerged: function (isReset = false) {
			var stylesCachedAll = this.getStylesCached();
			var stylesCached = stylesCachedAll[this.getWidgetID()];
			var preStyles = this.getStyles();
			var styles = isReset ? { ...stylesCached, ...preStyles } : { ...preStyles, ...stylesCached };

			return styles;
		},

        applyStyle: function (styleData) {
			
            var controls = this.getElementSettingsModel().controls;
            var updates = {};

            // Prepare the updates object
            _.each(controls, function (control, controlName) {
				if (control.type === "repeater") {
					return; // continue to next iteration
				}
				
                if (styleData.hasOwnProperty(controlName)) {
                    // If the value is empty, clear the field
                    if (styleData[controlName] === "") {
                        updates[controlName] = "";
                    } else {
                        updates[controlName] = styleData[controlName];
                    }
                }
            });

            // Update the settings and trigger a preview refresh
            this.getElementSettingsModel().setExternalChange(updates);

            // Manually trigger a re-render of the widget
            this.container.render();
        },

		resetStyle: function (styleData) {
			
            var defaults = this.getElementSettingsModel().defaults;
            var updates = {};
			
            // Prepare the updates object
            _.each(defaults, function (control, controlName) {
                if (styleData.hasOwnProperty(controlName)) {
                    // If the value is empty, clear the field
                    if (styleData[controlName] === "") {
                        updates[controlName] = "";
                    } else {
                        updates[controlName] = styleData[controlName];
                    }
                } else {
					updates[controlName] = defaults[controlName];
				}
            });

            // Update the settings and trigger a preview refresh
            this.getElementSettingsModel().setExternalChange(updates);

            // Manually trigger a re-render of the widget
            this.container.render();
        }
    });

    elementor.addControlView("zyre_style_select", ZyreStyleSelectControl);
})(jQuery, window.elementor);
