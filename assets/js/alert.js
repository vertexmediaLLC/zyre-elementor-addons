jQuery(document).ready(function ($) {
  $(".zyre-addon-alert").each(function () {
    var $alert = $(this);
    var $dismissButton = $alert.find(".zyre-alert-dismiss");

    $dismissButton.on("click", function () {
      $alert.fadeOut();
    });
  });
});