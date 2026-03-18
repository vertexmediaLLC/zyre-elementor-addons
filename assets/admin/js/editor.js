"use strict";

(function ($) {
  "use strict";

  window.zyreGetTranslated = function (stringKey, templateArgs) {
    return elementorCommon.translate(
      stringKey,
      null,
      templateArgs,
      ZyreAddonsEditor.i18n,
    );
  };

  /**
   * Add promotion widgets
   */
  elementor.hooks.addFilter("panel/elements/regionViews", function (panel) {
    if (
      ZyreAddonsEditor.hasPro ||
      ZyreAddonsEditor.promotion_widgets.length <= 0
    ) {
      return panel;
    }

    var ZyreElementView,
      zyreCategoryIndex,
      zyreElementsView = panel.elements.view,
      zyreCategoriesView = panel.categories.view,
      zyreElementsCollection = panel.elements.options.collection,
      zyreCategoriesCollection = panel.categories.options.collection,
      zyreProWidgets = [];

    _.each(ZyreAddonsEditor.promotion_widgets, function (widget, name) {
      zyreElementsCollection.add({
        name: "zyre-" + name,
        title: widget.title,
        icon: widget.icon,
        categories: ["zyre-elements-pro"],
        editable: false,
      });
    });

    zyreElementsCollection.each(function (widget) {
      "zyre-elements-pro" === widget.get("categories")[0] &&
        zyreProWidgets.push(widget);
    });

    zyreCategoryIndex = zyreCategoriesCollection.findIndex({
      name: "zyreladdons_category",
    });

    zyreCategoryIndex &&
      zyreCategoriesCollection.add(
        {
          name: "zyreladdons_pro_category",
          title: "Zyre Addons Pro",
          icon: "eicon-lock",
          defaultActive: false,
          sort: true,
          hideIfEmpty: true,
          items: zyreProWidgets,
          promotion: false,
        },
        {
          at: zyreCategoryIndex + 1,
        },
      );

    ZyreElementView = {
      className: function className() {
        var className = "elementor-element-wrapper";
        if (!this.isEditable()) {
          className += " elementor-element--promotion";
        }
        if (!this.isEditable() && this.isZyreWidget()) {
          className += " zyre-element--promotion";
        }

        return className;
      },

      isZyreWidget: function () {
        return 0 === this.model.get("name").indexOf("zyre-");
      },

      onMouseDown: function () {
        if (!this.isZyreWidget()) {
          this.constructor.__super__.onMouseDown.call(this);
          return;
        }

        elementor.promotion.showDialog({
          title: zyreGetTranslated("promotionDialogTitle", [
            this.model.get("title"),
          ]),
          content: zyreGetTranslated("promotionDialogMessage", [
            this.model.get("title"),
          ]),
          targetElement: this.el,
          position: {
            blockStart: "-7",
          },
          actionButton: {
            url: "#",
            text: ZyreAddonsEditor.i18n.promotionDialogBtnText,
            classes: ["elementor-button", "zyre-btn--promotion", "go-pro"],
          },
        });
      },
    };

    panel.elements.view = zyreElementsView.extend({
      childView: zyreElementsView.prototype.childView.extend(ZyreElementView),
    });

    panel.categories.view = zyreCategoriesView.extend({
      childView: zyreCategoriesView.prototype.childView.extend({
        childView:
          zyreCategoriesView.prototype.childView.prototype.childView.extend(
            ZyreElementView,
          ),
      }),
    });

    return panel;
  });

  /**
   * Remove 'Zy ' prefix from getSocialNetworkNameFromIcon() if it exists
   */
  elementor.hooks.addFilter(
    "elementor/social_icons/network_name",
    function (social, iconsControl, fallbackControl, toUpperCase, withIcon) {
      return social.replace(/^Zy /, "");
    },
  );

  /**
   * Do something when section activated
   */
  elementor.channels.editor.on(
    "section:activated",
    function (sectionName, editor) {
      var editedElement = editor.getOption("editedElementView");
      if ("zyre-flipbox" !== editedElement.model.get("widgetType")) {
        return;
      }

      var isSideBSection =
        -1 !==
        [
          "section_back_content",
          "section_back_style",
          "section_back_btn_style",
          "section_back_btn_icon_style",
        ].indexOf(sectionName);
      editedElement.$el.toggleClass("zyre-flipbox--flipped", isSideBSection);
      var $backLayer = editedElement.$el.find(".zyre-flipbox-back");
      if (isSideBSection) {
        $backLayer.css("transition", "none");
      }
      if (!isSideBSection) {
        setTimeout(function () {
          $backLayer.css("transition", "");
        }, 10);
      }
    },
  );

  /**
   * Select2 Control
   *
   * Ajax Request to: zyreladdons_process_dynamic_select
   */
  var ZyreSelect2 = elementor.modules.controls.BaseData.extend({
    getSelect2Placeholder: function () {
      return (
        this.ui.select.children('option:first[value=""]').text() ||
        this.model.get("placeholder")
      );
    },
    getDependencyArgs: function getDependencyArgs() {
      var self = this,
        args = self.model.get("dynamic_params");
      if (!_.isObject(args)) {
        args = {};
      }
      if (args.control_dependency && _.isObject(args.control_dependency)) {
        _.each(args.control_dependency, function (prop, key) {
          args[key] = self.container.settings.get(prop);
        });
      }
      return args;
    },
    getControlDependency: function (postTypes, callback) {
      var self = this;

      $.ajax({
        url: ajaxurl,
        type: "POST",
        data: {
          nonce: ZyreAddonsEditor.editor_nonce,
          action: "zyreladdons_process_el_dynamic_select",
          post_types: postTypes,
        },
        success: function (response) {
          if (!response.success) return;

          var taxonomies = response.data;
          if (!taxonomies || !taxonomies.length) return;

          var params = self.model.get("dynamic_params") || {};
          params.term_taxonomy = taxonomies;

          // callback execute
          if (typeof callback === "function") {
            callback(params);
          }
        },
      });
    },
    getSelect2DefaultOptions: function () {
      var _this = this;

      return {
        allowClear: true,
        placeholder: this.getSelect2Placeholder(),
        dir: elementorCommon.config.isRTL ? "rtl" : "ltr",
        minimumInputLength: 1,
        ajax: {
          url: ajaxurl,
          dataType: "json",
          method: "POST",
          delay: 250,
          data: function data(params) {
            var defaults = {
              nonce: ZyreAddonsEditor.editor_nonce,
              action: "zyreladdons_process_dynamic_select",
              object_type: "post",
              query_term: params.term,
            };
            return $.extend(
              defaults,
              _this.model.get("dynamic_params"),
              _this.getDependencyArgs(),
            );
          },
          processResults: function (response) {
            if (!response.success || response.data.length === 0) {
              return {
                results: [
                  {
                    id: -1,
                    text: ZyreAddonsEditor.i18n.NoResultsMessage,
                    disabled: true,
                  },
                ],
              };
            }
            var data = [];
            _.each(response.data, function (title, id) {
              data.push({
                id: id,
                text: title,
              });
            });
            return {
              results: data,
            };
          },
          cache: true,
        },
      };
    },
    getSelect2Options: function () {
      return $.extend(
        this.getSelect2DefaultOptions(),
        this.model.get("select2options"),
      );
    },
    addLoadingSpinner: function () {
      this.$el
        .find(".elementor-control-title")
        .after(
          '<span class="elementor-control-spinner">&nbsp;<i class="eicon-spinner eicon-animation-spin"></i>&nbsp;</span>',
        );
    },
    onBeforeRender: function () {
      if (this.isRendered) {
        return;
      }

      var _this = this;
      var savedValues = this.getControlValue();
      var dynamicParams = this.model.get("dynamic_params") || {};

      // if has dependency then wait
      if (dynamicParams.select2_dependency) {
        var postTypes = this.container.settings.get("post_type") || [];

        if (postTypes.length) {
          this.getControlDependency(postTypes, function (params) {
            // update first
            var oldParams = _this.model.get("dynamic_params") || {};
            _this.model.set("dynamic_params", _.extend({}, oldParams, params));

            // AJAX call
            _this.loadSavedValues(savedValues);
          });

          return; // STOP normal flow
        }
      }

      // normal flow
      this.loadSavedValues(savedValues);
    },
    loadSavedValues: function (savedValues) {
      var _this = this;

      if (_.isEmpty(savedValues)) {
        return;
      }

      if (!_.isArray(savedValues)) {
        savedValues = [savedValues];
      }

      var defaults = {
        nonce: ZyreAddonsEditor.editor_nonce,
        action: "zyreladdons_process_dynamic_select",
        object_type: "post",
        saved_values: savedValues,
      };
      $.ajax({
        url: ajaxurl,
        type: "POST",
        data: $.extend(
          defaults,
          _this.model.get("dynamic_params"),
          _this.getDependencyArgs(),
        ),
        beforeSend: _this.addLoadingSpinner.bind(this),
        success: function success(response) {
          if (response.success && response.data.length !== 0) {
            // Prefix an extra space to maintain order and backward compatibility
            var ids = (ids = _.keys(response.data).map(function (id) {
              return " " + $.trim(id);
            }));
            _this.container.settings.set(_this.model.get("name"), ids);
            _this.model.set("options", response.data);
            _this.render();
          }
        },
      });
    },
    applySavedValue: function () {
      elementor.modules.controls.BaseData.prototype.applySavedValue.apply(
        this,
        arguments,
      );

      var select2Instance = this.ui.select.data("select2");

      if (!select2Instance) {
        var self = this;
        var dynamicParams = this.model.get("dynamic_params") || {};
        var savedValues = this.getControlValue();

        // check if select2_dependency exists
        if (dynamicParams.select2_dependency) {
          // override dynamic_params based on select2_dependency
          var postTypes = this.container.settings.get("post_type") || [];
          if (postTypes.length) {
            this.getControlDependency(postTypes, function (params) {
              // only update taxonomy
              var oldParams = self.model.get("dynamic_params") || {};
              self.model.set("dynamic_params", _.extend({}, oldParams, params));

              // DO NOT clear if saved values exist
              if (_.isEmpty(savedValues)) {
                self.container.settings.set(self.model.get("name"), []);
                self.ui.select.val(null).trigger("change");
              }
            });
          }
        }
        // Now set select2 options
        this.ui.select.select2(this.getSelect2Options());
        if (this.model.get("sortable")) {
          this.initSortable();
        }
      } else {
        this.ui.select.trigger("change");
      }
    },
    initSortable: function () {
      var $sortable = this.$el.find("ul.select2-selection__rendered"),
        _this = this;
      $sortable.sortable({
        containment: "parent",
        update: function update() {
          _this._orderSortedOption($sortable);
          _this.container.settings.setExternalChange(
            _this.model.get("name"),
            _this.ui.select.val(),
          );
          _this.model.set("options", _this.ui.select.val());
        },
      });
    },
    _orderSortedOption: function ($sortable) {
      var _this = this;
      $sortable.children("li[title]").each(function (i, obj) {
        var $elment = _this.ui.select.children("option").filter(function () {
          return $(this).html() == obj.title;
        });
        _this._moveOptionToEnd($elment);
      });
    },
    _moveOptionToEnd: function ($elment) {
      var $parent = $elment.parent();
      $elment.detach();
      $parent.append($elment);
    },
    onBeforeDestroy: function () {
      // We always destroy the select2 instance because there are cases where the DOM element's data cache
      // itself has been destroyed but the select2 instance on it still exists
      this.ui.select.select2("destroy");
      this.$el.remove();
    },
  });
  elementor.addControlView("zyreladdons_select2", ZyreSelect2);
})(jQuery);
