"use strict";

(function ($) {

	var templateModalContainer = $("#zyre-modal-new-template-container");
	if ( ! templateModalContainer.length ) {
		return;
	}
	
	$("body").append(templateModalContainer.html());
	MicroModal.init();

	$("#zyre-template-library-add-new").on("click", function (e) {
		e.preventDefault();
		MicroModal.show("zyre-modal-new-template");
	});

	var $templateType = $("#zyre-new-template-form__template-type"),
	$templateName = $("#zyre-new-template-form__post-title"),
	$templateButton = $("#zyre-new-template-form__submit");

	$templateType.on("change", updateButton);
	$templateName.on("input", updateButton);

	function updateButton() {
		var typeVal = $templateType.val();
		var nameVal = $templateName.val();
		if (typeVal && nameVal) {
			$templateButton.prop("disabled", false);
		} else {
			$templateButton.prop("disabled", true);
		}
	}

})(jQuery);
