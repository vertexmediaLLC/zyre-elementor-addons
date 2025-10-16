"use strict";

function _sliceIterable(r, e) {
	return (
		_checkIfArray(r) ||
		_iterableToLimitedArray(r, e) ||
		_handleUnsupportedIterable(r, e) ||
		_throwNonIterableError()
	);
}

function _throwNonIterableError() {
	throw new TypeError(
		"Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."
	);
}

function _handleUnsupportedIterable(r, a) {
	if (r) {
		if ("string" == typeof r) return _convertArrayLike(r, a);
		var t = {}.toString.call(r).slice(8, -1);
		return (
			"Object" === t && r.constructor && (t = r.constructor.name),
			"Map" === t || "Set" === t
				? Array.from(r)
				: "Arguments" === t ||
					/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t)
					? _convertArrayLike(r, a)
					: void 0
		);
	}
}

function _convertArrayLike(r, a) {
	(null == a || a > r.length) && (a = r.length);
	for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e];
	return n;
}

function _iterableToLimitedArray(r, l) {
	var t =
		null == r
			? null
			: ("undefined" != typeof Symbol && r[Symbol.iterator]) || r["@@iterator"];
	if (null != t) {
		var e,
			n,
			i,
			u,
			a = [],
			f = !0,
			o = !1;
		try {
			if (((i = (t = t.call(r)).next), 0 === l)) {
				if (Object(t) !== t) return;
				f = !1;
			} else
				for (
					;
					!(f = (e = i.call(t)).done) && (a.push(e.value), a.length !== l);
					f = !0
				);
		} catch (r) {
			(o = !0), (n = r);
		} finally {
			try {
				if (!f && null != t["return"] && ((u = t["return"]()), Object(u) !== u))
					return;
			} finally {
				if (o) throw n;
			}
		}
		return a;
	}
}

function _checkIfArray(r) {
	if (Array.isArray(r)) return r;
}

(function ($) {
	var modalTemplate = document.getElementById("tmpl-modal-template-condition");
	var conditionTemplate = document.getElementById(
		"tmpl-elementor-new-template"
	);

	var templateType = "";
	var postId = 0;
	var newConditions = [];
	var oldConditionCache = "";
	if (typeof elementor !== "undefined") {
		elementor.on("panel:init", function ($e) {
			postId = elementor.config.document.id;
			fetchTemplateType( postId );
			fetchTemplateConditions(postId);
			if ("loop-template" != zyreTemplateInfo.templateType) {
				elementor
					.getPanelView()
					.footer.currentView.addSubMenuItem("saver-options", {
						before: "save-draft",
						name: "zyreconditions",
						icon: "zyre-template-elements",
						title: window.wp ? window.wp.i18n.__("Template Conditions", "zyre-elementor-addons") : "Template Conditions",
						callback: function callback() {
							return elementor.trigger("zyre:templateCondition");
						},
					});
			}
		});

		elementor.channels.editor.on(
			"elementorThemeBuilder:ApplyPreview",
			function ( $e ) {
				fetchTemplateType( postId );
			}
		);

		elementor.on("set:page", function ($e) { });
	}

	 //Elementor V2 App Bar
	 if (typeof elementor !== "undefined") {
		if (window.elementorV2 && window.elementorV2.editorAppBar && window.elementorV2.editorAppBar.documentOptionsMenu) {
		  var documentOptionsMenu = window.elementorV2.editorAppBar.documentOptionsMenu;
		  documentOptionsMenu.registerAction({
			id: "zyre-template-condition",
			group: ["save"],
			priority: 10,
			props: {
			  icon: function icon() {
				return React ? React.createElement("i", {
				  className: "zy-fonticon zy-Zyre-addons"
				}) : null;
			  },
			  title: window.wp ? window.wp.i18n.__("Template Conditions", "zyre-elementor-addons") : "Template Conditions",
			  visible: true,
			  onClick: function onClick(e) {
				e.preventDefault();
				return elementor.trigger("zyre:templateCondition");
			  }
			}
		  });
		}
	}

	$("body").append(modalTemplate.innerHTML);
	if (typeof elementor !== "undefined") {
		elementor.on("zyre:templateCondition", function ($e) {
			//oldConditionCache
			var conditionContainer = $(".zyre-template-condition-wrap");
			if (conditionContainer.html() == "") {
				conditionContainer.append(oldConditionCache);
				conditionContainer.find("select").trigger("change");
				// elementor.trigger("zyre:templateConditionChange");
			}

			// notice remove
			$(".zyre-template-notice").removeClass("error").text("");
			MicroModal.show("modal-new-template-condition");
		});
		elementor.on("zyre:templateConditionChange", function ($e) {
			updateTemplateConditions();
		});
	}

	$(document).on("click", ".zyre-cond-repeater-add", function () {
		var conditionContainer = $(".zyre-template-condition-wrap");
		var uniqify = generateUniqeDom(conditionTemplate.innerHTML);
		conditionContainer.append(uniqify);
		elementor.trigger("zyre:templateConditionChange");
		// zyre_check_contradictory_condition();
	});

	$(document).on("click", ".zyre-template-condition-remove", function () {
		$(this).parent().remove();
		elementor.trigger("zyre:templateConditionChange");
	});

	$(document).on("click", "#zyre-template-save-data", function () {
		saveConditions();
	});

	$(document).on(
		"change",
		".zyre-template-condition-wrap select",
		function (event) {
			handleSelectChange(event);
			elementor.trigger("zyre:templateConditionChange");
		}
	);

	function generateUniqeDom(dom) {
		var randomid = Math.random().toString(36).replace("0.", "");
		dom = dom.replace(/{{([^{}]+)}}/g, randomid);
		return dom;
	}

	function handleSelectChange(event) {
		if (event.target.localName == "select") {
			var parentID = event.target.dataset.parent;
			var selectedType = event.target.dataset.setting;
			var selected = event.target.value;
			var type = $("[data-id='type-" + parentID + "']");
			var name = $("[data-id='name-" + parentID + "']");
			var sub_name = $("[data-id='sub_name-" + parentID + "']");
			var sub_id = $("[data-id='sub_id-" + parentID + "']");
			if (selectedType == "type") {
				//TODO: Add prefix icon later on
			}
			if (selectedType == "name") {
				if (selected == "general") {
					sub_name.parent().hide();
					sub_id.parent().hide();
				} else {
					sub_name.parent().show();
					var selectedVal = sub_name.data("selected")
						? sub_name.data("selected")
						: "";
					add_sub_name(sub_name, name.val(), selectedVal);
				}
			}
			if (selectedType == "sub_name") {
				var dataPair = {
					post: "post",
					in_category: "category",
					in_category_children: "category",
					in_post_tag: "post_tag",
					post_by_author: "author",
					page: "page",
					page_by_author: "author",
					child_of: "page",
					any_child_of: "page",
					by_author: "author",
				};
				if (dataPair.hasOwnProperty(selected)) {
					// Toggle Visibility
					sub_id.parent().show();
					var dataType = dataPair[selected];
					var dataVal = selected;
					if (["post", "page"].includes(dataType)) {
						dataVal = dataType;
						dataType = "post";
					}
					if (["category", "post_tag"].includes(dataType)) {
						dataVal = dataType;
						dataType = "tax";
					}
					sub_id.select2({
						ajax: {
							url: ajaxurl,
							dataType: "json",
							delay: 250,
							data: function data(params) {
								var query = {
									nonce: ZyreAddonsEditor.editor_nonce,
									action: "zyre_condition_autocomplete",
									q: params.term,
									object_type: dataType,
									object_term: dataVal,
								};
								return query;
							},
							processResults: function processResults(response) {
								if (!response.success || response.data.length === 0) {
									return {
										results: [
											{
												id: -1,
												text: "No results found",
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
						},
						minimumInputLength: 2,
						cache: true,
						placeholder: "All",
						allowClear: true,
						dropdownCssClass: "zyre-template-condition-dropdown",
					});
				} else {
					sub_id.parent().hide();
				}
			}
			if (selectedType == "sub_id") {
			}
		}
	}

	function updateTemplateConditions() {
		var conditions = [];
		var conditionItems = $(".zyre-template-condition-wrap").find(
			".zyre-template-condition-item"
		);
		conditionItems.each(function () {
			var type = $(this).find(".zyre-tce-type select").val();
			var name = $(this).find(".zyre-tce-name select").val();
			var sub_name = $(this).find(".zyre-tce-sub_name select").val();
			var sub_id = $(this).find(".zyre-tce-sub_id select").val();
			var localCond = type + "/" + name;
			if (sub_name) {
				localCond += "/" + sub_name;
			}
			if (sub_id) {
				localCond += "/" + sub_id.trim();
			}
			conditions.push(localCond);
		});
		newConditions = conditions;
	}

	  function fetchTemplateType ( id ) {
		jQuery.ajax( {
			url: ajaxurl,
			type: "get",
			dataType: "json",
			data: {
				nonce: ZyreAddonsEditor.editor_nonce,
				action: "zyre_condition_template_type", // AJAX action for admin-ajax.php
				post_id: id,
			},
			success: function ( response ) {
				if ( response && response.data ) {
					templateType = response.data;
				}
			},
		} );
	}

	function fetchTemplateConditions(id) {
		jQuery.ajax({
			url: ajaxurl,
			type: "get",
			dataType: "json",
			data: {
				nonce: ZyreAddonsEditor.editor_nonce,
				action: "zyre_condition_current",
				// AJAX action for admin-ajax.php
				template_id: id,
			},
			success: function success(response) {
				if (response && response.data) {
					oldConditionCache = response.data;
				}
			},
		});
	}

	function add_sub_name(target, dataType, selectedVal) {
		jQuery.ajax({
			url: ajaxurl,
			type: "get",
			dataType: "json",
			data: {
				nonce: ZyreAddonsEditor.editor_nonce,
				action: "zyre_condition_autocomplete",
				// AJAX action for admin-ajax.php
				object_type: dataType,
			},
			success: function success(data) {
				if (data) {
					if (data.data) {
						var optionHTML = populateOption(data.data, selectedVal);
						target.html(optionHTML);
					}
				}
			},
		});
	}

	function populateOption(optionData, selectedVal) {
		var optionHTML = "";
		for (
			var _i = 0, _Object$entries = Object.entries(optionData);
			_i < _Object$entries.length;
			_i++
		) {
			var _Object$entries$_i = _sliceIterable(_Object$entries[_i], 2),
				key = _Object$entries$_i[0],
				option = _Object$entries$_i[1];
			if (option.hasOwnProperty("type")) {
				optionHTML += "<optgroup label='" + option.title + "'>";
				for (
					var _i2 = 0, _Object$entries2 = Object.entries(option.conditions);
					_i2 < _Object$entries2.length;
					_i2++
				) {
					var _Object$entries2$_i = _sliceIterable(_Object$entries2[_i2], 2),
						subkey = _Object$entries2$_i[0],
						suboption = _Object$entries2$_i[1];
					var isPro = suboption.is_pro;
					var optionTitle = suboption.title;
					var optionKey = subkey;
					var isDisabled = "";
					var isSelected = selectedVal == optionKey ? " selected" : "";
					if (isPro) {
						optionTitle = optionTitle + " [Pro]";
						isDisabled = " disabled";
					}
					optionHTML +=
						"<option value='" +
						optionKey +
						"' " +
						isDisabled +
						isSelected +
						">" +
						optionTitle +
						"</option>";
				}
				optionHTML += "</optgroup>";
			} else {
				var isPro = option.is_pro;
				var optionTitle = option.title;
				var optionKey = key;
				var isDisabled = "";
				var isSelected = selectedVal == optionKey ? " selected" : "";
				if (isPro) {
					optionTitle = optionTitle + " [Pro]";
					isDisabled = " disabled";
				}
				optionHTML +=
					"<option value='" +
					optionKey +
					"' " +
					isDisabled +
					isSelected +
					">" +
					optionTitle +
					"</option>";
			}
		}
		return optionHTML;
	}

	function saveConditions() {
		var $elBtn = document.getElementById(
			"elementor-panel-saver-button-publish"
		);
		$elBtn.classList.add("elementor-button-state");
		postId = elementor.config.document.id;
		jQuery.ajax({
			url: ajaxurl,
			type: "post",
			dataType: "json",
			data: {
				nonce: ZyreAddonsEditor.editor_nonce,
				action: "zyre_condition_update",
				// AJAX action for admin-ajax.php
				conds: newConditions,
				template_id: postId,
			},
			success: function success(response) {
				if (response) {
					if (response.success) {
						MicroModal.close("modal-new-template-condition");
						$(".zyre-template-notice").removeClass("error").text("");
					} else {
						// show notice
						if (
							response.hasOwnProperty("data") &&
							response.data.hasOwnProperty("msg")
						) {
							$(".zyre-template-notice")
								.addClass("error")
								.text(response.data.msg);
						} else {
							MicroModal.close("modal-new-template-condition");
							$(".zyre-template-notice").removeClass("error").text("");
						}
					}
				}
			},
		});
		setTimeout(function () {
			$elBtn.classList.remove("elementor-button-state");
		}, 500);
	}

	elementor.saver.on("after:save", function (data) {
		if (
			data.status != "inherit" &&
			"loop-template" != zyreTemplateInfo.templateType
		) {
			elementor.trigger("zyre:templateCondition");
		}
	});
})(jQuery);
