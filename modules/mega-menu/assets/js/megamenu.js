
/**
 * extension-megamenu.dev.js
 * Developer-friendly, formatted and commented version of the original extension-megamenu.min.js
 *
 * NOTE: This file is functionally equivalent to the original minified script.
 * Variable names were expanded for readability and short inline comments were added.
 */

jQuery(document).ready(function ($) {
  // DOM element references and initial variables
  var menuToEditElement = document.getElementById("menu-to-edit");
  var CARD_UPDATE_EVENT = "cardupdate";

  var badgeRadiusTopLeft = $("#zy-menu-badge-radius-topLeft");
  var badgeRadiusTopRight = $("#zy-menu-badge-radius-topRight");
  var badgeRadiusBottomLeft = $("#zy-menu-badge-radius-bottomLeft");
  var badgeRadiusBottomRight = $("#zy-menu-badge-radius-bottomRight");

  // badge radius string (topLeft, topRight, bottomLeft, bottomRight)
  var badgeRadiusString = "";

  // Observe the global nav menu header for changes to update body classes
  var navMenuHeader = $("#nav-menu-header");
  
  if (navMenuHeader.length) {
    new MutationObserver(function () {
      requestAnimationFrame(function () {
        var isMegaEnabled = $("#zy-menu-metabox-input-is-enabled").prop("checked");
        if (isMegaEnabled) {
          $("body").removeClass("is_mega_disabled").addClass("is_mega_enabled");
        } else {
          $("body").removeClass("is_mega_enabled").addClass("is_mega_disabled");
        }
      });
    }).observe(navMenuHeader[0], { childList: true, subtree: true });
  }

  // Initialize WordPress color pickers
  $(".zy-menu-wpcolor-picker").wpColorPicker();

  // Listen for custom card update events dispatched from save actions
  if (menuToEditElement) {
    menuToEditElement.addEventListener(CARD_UPDATE_EVENT, function (event) {
      if (event.detail && event.detail.isEnabled) {
        jQuery("#menu-item-" + event.detail.menuID).addClass("zyre-menu-item");
      } else {
        jQuery("#menu-item-" + event.detail.menuID).removeClass("zyre-menu-item");
      }
    });
  }

  // Add class to existing happyMenu items
  jQuery.each(zyreMegaMenu.items, function (index, selector) {
    if (jQuery(selector).length) {
      jQuery(selector).addClass("zyre-menu-item");
    }
  });

  function zyreIconsList( prefix ) {
	var icons = [
		"zy-5G",
		"zy-Hour-process",
		"zy-Abstract",
		"zy-Accordion",
		"zy-Add-folder",
		"zy-Addition",
		"zy-Advance-heading",
		"zy-Advance-tab",
		"zy-Advance-toggle",
		"zy-AI-artificial-intelligence",
		"zy-Air",
		"zy-alarm-clock",
		"zy-Alert",
		"zy-Anchor",
		"zy-Animated-text",
		"zy-Archive-Description",
		"zy-Archive-Post",
		"zy-Archive-Title",
		"zy-Arrow-down",
		"zy-Arrow-left",
		"zy-Arrow-right",
		"zy-Arrow-up",
		"zy-Arrows-all-direction",
		"zy-At",
		"zy-Audio-File",
		"zy-Audio-record",
		"zy-Audio-jack",
		"zy-Author-Box",
		"zy-Author-List",
		"zy-Automatic",
		"zy-Badge-ribbon",
		"zy-Bank-note",
		"zy-Bank",
		"zy-Basket",
		"zy-Battery-energy",
		"zy-Beaker-tall",
		"zy-Beaker",
		"zy-Bed",
		"zy-Bell-notice",
		"zy-Bell",
		"zy-Bell-2",
		"zy-Bill-Invoice",
		"zy-Bird",
		"zy-Block",
		"zy-Blockchain",
		"zy-Bluetooth",
		"zy-Board-tabs",
		"zy-Bone",
		"zy-Book-with-mark",
		"zy-Book",
		"zy-Book-2",
		"zy-Bookmark-badge",
		"zy-Bookmark",
		"zy-Border",
		"zy-Boxes-more",
		"zy-Brain-energy",
		"zy-Brain",
		"zy-Breadcrumbs",
		"zy-Briefcase-simple",
		"zy-Briefcase",
		"zy-Broom",
		"zy-Browser-expand",
		"zy-Browser",
		"zy-Brush",
		"zy-BTC-bitcoin",
		"zy-Bug",
		"zy-Building",
		"zy-Building-2",
		"zy-Bulb-idea",
		"zy-Bulb",
		"zy-Burger",
		"zy-Burger-2",
		"zy-Business-hour",
		"zy-Butterfly",
		"zy-Button",
		"zy-Cake",
		"zy-Calculator",
		"zy-Calendar",
		"zy-Call-center",
		"zy-Call-to-action",
		"zy-Camera-add",
		"zy-Camera-target",
		"zy-Camera",
		"zy-Car-electric",
		"zy-Car",
		"zy-Car-2",
		"zy-Cart",
		"zy-Castle",
		"zy-Castle-2",
		"zy-Cat",
		"zy-Celebration",
		"zy-Chafer-simple",
		"zy-Chafer-star",
		"zy-Chafer",
		"zy-Chain",
		"zy-Check-Circle",
		"zy-Check-list",
		"zy-Check-shield",
		"zy-Check-shield-2",
		"zy-Check-box",
		"zy-Check",
		"zy-Checkout",
		"zy-Checkout-2",
		"zy-Chef-cap",
		"zy-Chicken",
		"zy-Church",
		"zy-Cinema",
		"zy-Clipboard",
		"zy-Clock-3-hour",
		"zy-Clock",
		"zy-Close-eye",
		"zy-Close-lock",
		"zy-Close-umbrella",
		"zy-Close",
		"zy-Cloth-hanger",
		"zy-Cloud-rain",
		"zy-Cloud-server",
		"zy-Cloud",
		"zy-Coffee",
		"zy-Comment-star-feedback",
		"zy-Comment",
		"zy-Comparison",
		"zy-Compass",
		"zy-Computer-desktop",
		"zy-Contact-form",
		"zy-Content-card",
		"zy-Cookies-notice",
		"zy-Copy-page",
		"zy-Copy",
		"zy-Corner",
		"zy-Countdown-stopwatch",
		"zy-Creatiya",
		"zy-Credit-card-use",
		"zy-Credit-card",
		"zy-Crop",
		"zy-CSS-File",
		"zy-CSS3",
		"zy-Cursor-Click",
		"zy-Cursor-ZyreFontIcon",
		"zy-Cursor",
		"zy-Customer-male",
		"zy-Cycle",
		"zy-Cycling",
		"zy-Dashboard",
		"zy-Data-table",
		"zy-Deer",
		"zy-Devices",
		"zy-Devider-line",
		"zy-Diamond",
		"zy-Disable-walk",
		"zy-Disable",
		"zy-Document-Folder",
		"zy-Document-page",
		"zy-Dog-cat",
		"zy-Dog-foot-print",
		"zy-Dog-head",
		"zy-Dog",
		"zy-Dollar-percent",
		"zy-Dots-menu",
		"zy-Down-arrow-double-line",
		"zy-Down-arrow",
		"zy-Down-cursor",
		"zy-Down-turn",
		"zy-Down-u-turn",
		"zy-Download-arrow",
		"zy-Download",
		"zy-Dress-female",
		"zy-Dribbble",
		"zy-Drinks",
		"zy-Drop-water",
		"zy-Dropcap",
		"zy-Dropper",
		"zy-Dual-button-content",
		"zy-Dual-button",
		"zy-Dual-color-heading",
		"zy-Dumbbell-fitness",
		"zy-Edit-pen",
		"zy-Education",
		"zy-Elementor",
		"zy-Elementorin",
		"zy-Email-message",
		"zy-Energy",
		"zy-Enlarge",
		"zy-EPS-File",
		"zy-Euro",
		"zy-Event-calendar",
		"zy-Exclamatory",
		"zy-Facebook",
		"zy-Fan",
		"zy-FAQ",
		"zy-Fashion",
		"zy-Favicon",
		"zy-Featured-banner",
		"zy-Featured-list",
		"zy-Featured-slide",
		"zy-Female-student",
		"zy-Female",
		"zy-Fence",
		"zy-Filter",
		"zy-Fingerprint",
		"zy-Fire",
		"zy-Fish",
		"zy-Fish-2",
		"zy-Flag-on-Maountain",
		"zy-Flag",
		"zy-Flight-location",
		"zy-Flip-box",
		"zy-Floppy",
		"zy-Flower-plant",
		"zy-Fly",
		"zy-Font",
		"zy-Food",
		"zy-Football",
		"zy-Footer",
		"zy-Forest",
		"zy-Fork-Spoon",
		"zy-Freepiker",
		"zy-Fun-fact",
		"zy-Game-play",
		"zy-Garden",
		"zy-Gear-folder",
		"zy-Gear-bulb",
		"zy-Gear-Moon",
		"zy-Gear-user",
		"zy-Gear",
		"zy-Gears-double",
		"zy-Getapoll",
		"zy-Giftbox-top",
		"zy-Giftbox",
		"zy-Github",
		"zy-Glass",
		"zy-Globe-location",
		"zy-Globe-map",
		"zy-Globe-plant",
		"zy-Globe-recycle",
		"zy-Globe-search",
		"zy-Globe",
		"zy-Google-map",
		"zy-Googleplus",
		"zy-Gradient-background",
		"zy-Gradient-heading",
		"zy-Graduation-hat",
		"zy-Graphic-chart-arrow",
		"zy-Graphic-chart-arrow-2",
		"zy-Graphic-chart-colum",
		"zy-Graphic-chart-column-2",
		"zy-Graphic-chart-pie",
		"zy-Graphic-chart-pie-2",
		"zy-Graphic-chart",
		"zy-Graphic-chart-2",
		"zy-Growth",
		"zy-Hand-heart",
		"zy-Hand-click",
		"zy-Hand-stop",
		"zy-Hand",
		"zy-handycam",
		"zy-Happy-symbol",
		"zy-Header",
		"zy-Headphone",
		"zy-Heart-dollar",
		"zy-Heart",
		"zy-HeroSection",
		"zy-Home-building-single",
		"zy-Home-exclamatory",
		"zy-Home",
		"zy-Hotspot",
		"zy-HTML5",
		"zy-Iconbox",
		"zy-Idea-user",
		"zy-Image-carousel",
		"zy-Image-compare",
		"zy-Image-file",
		"zy-Image-folder",
		"zy-Image-grid",
		"zy-Image-heading",
		"zy-Image-list",
		"zy-Image",
		"zy-Infobox",
		"zy-Instagram",
		"zy-Interactive-box",
		"zy-Javascript",
		"zy-JPG-file",
		"zy-Key",
		"zy-Keyboard",
		"zy-Kids-boy",
		"zy-Kids-girl",
		"zy-Laptop-gear",
		"zy-Laptop-message",
		"zy-Laptop",
		"zy-Laravel",
		"zy-Launch",
		"zy-Leaf-right",
		"zy-Leaf",
		"zy-Left-arrow-double-line",
		"zy-Left-arrow",
		"zy-Left-cursor",
		"zy-Left-turn",
		"zy-Left-u-turn",
		"zy-Left-corner-cursor",
		"zy-Left-up-cursor",
		"zy-Legal-hammer",
		"zy-Life-safe",
		"zy-Linkedin",
		"zy-Lion",
		"zy-List-group",
		"zy-Location-map-pin",
		"zy-Log-in-arrow",
		"zy-Log-out-arrow",
		"zy-Log-out",
		"zy-Login-form",
		"zy-Logo-carousel",
		"zy-Logo-grid",
		"zy-Lorry-truck",
		"zy-Lottie-Animations",
		"zy-Magic-ai",
		"zy-Magnifier-glass",
		"zy-Male",
		"zy-Map-fold",
		"zy-Mask",
		"zy-Massage-wellness",
		"zy-Medal",
		"zy-Medication",
		"zy-Mega-menu",
		"zy-Megaphone-promotion",
		"zy-Melody",
		"zy-Menu-simple",
		"zy-Menu",
		"zy-Message-buble",
		"zy-Message-dots",
		"zy-Message",
		"zy-Metro",
		"zy-Mobile-message",
		"zy-Modern-popup",
		"zy-Money-bag",
		"zy-Moon",
		"zy-Mosque",
		"zy-Mountain-landscape",
		"zy-Mountain",
		"zy-Mountain-2",
		"zy-Mouse",
		"zy-Multi-language",
		"zy-Network-signal-full",
		"zy-Network-signal",
		"zy-New-badge",
		"zy-New-tab",
		"zy-News-ticker",
		"zy-No-signal-netwrok",
		"zy-Noodle",
		"zy-Notice",
		"zy-Number-list",
		"zy-Ocean-Sea",
		"zy-Ocean",
		"zy-Open-book",
		"zy-Open-box",
		"zy-Open-eye",
		"zy-Open-lock",
		"zy-Open-message",
		"zy-Open-umbrella",
		"zy-Organic-fruits",
		"zy-Padma-wellness",
		"zy-Page-Title",
		"zy-Paint",
		"zy-Paper-pen",
		"zy-Paper-clip",
		"zy-Paper-plane",
		"zy-Park",
		"zy-Parking",
		"zy-PDF-view",
		"zy-Pen",
		"zy-Pen-2",
		"zy-Percent-circle",
		"zy-PHP-file",
		"zy-Pizza",
		"zy-Plane",
		"zy-Plant-chirstmas",
		"zy-Plant-clubs",
		"zy-Plant",
		"zy-Plant-2",
		"zy-Plate-and-Spoon",
		"zy-Play",
		"zy-Plug-in",
		"zy-PNG-File",
		"zy-Post-carousel",
		"zy-Post-Comment",
		"zy-Post-Content",
		"zy-Post-Excerpt",
		"zy-Post-grid",
		"zy-Post-list",
		"zy-Post-Meta",
		"zy-Post-Navigation",
		"zy-Post-stamp",
		"zy-Post-Thumbnail",
		"zy-Post-tile",
		"zy-Post-Title",
		"zy-Power",
		"zy-Presentation-chart",
		"zy-Presentation",
		"zy-Price-menu",
		"zy-Price-table",
		"zy-Price-tag-dollar",
		"zy-Price-tag",
		"zy-Price-tag-2",
		"zy-Printer",
		"zy-Process-loading",
		"zy-Product-carousel",
		"zy-Product-grid",
		"zy-Product-table",
		"zy-Product",
		"zy-Profile-accordion",
		"zy-Profile-card",
		"zy-Promotion",
		"zy-Protected-content",
		"zy-Protected-shield",
		"zy-PSD-File",
		"zy-Python",
		"zy-QR-card",
		"zy-Question-circle",
		"zy-Question",
		"zy-Quotation-comma",
		"zy-R-registered",
		"zy-Recycle-loading",
		"zy-Recycle-switch",
		"zy-Recycle",
		"zy-Refrigerator",
		"zy-Remote",
		"zy-Retro-television",
		"zy-Rice",
		"zy-Right-arrow-double-line",
		"zy-Right-arrow",
		"zy-Right-cursor",
		"zy-Right-turn",
		"zy-Right-u-turn",
		"zy-River",
		"zy-Road",
		"zy-Rock-wellness",
		"zy-Rocket",
		"zy-Run",
		"zy-Sad-boy",
		"zy-Sale-price-tag",
		"zy-Scale-or-ruller",
		"zy-Scale",
		"zy-School",
		"zy-Scissor",
		"zy-Scrolling-image",
		"zy-Search-box",
		"zy-Search-nature",
		"zy-Services",
		"zy-Shadow-ball",
		"zy-Shake-hand",
		"zy-Share-hub-linked",
		"zy-Share-hub",
		"zy-Share-upload",
		"zy-Share",
		"zy-Shield",
		"zy-Ship",
		"zy-Shoe",
		"zy-Shop-market",
		"zy-Shop-page",
		"zy-Shopping-bag",
		"zy-Shopping-bag-pen",
		"zy-Shopping-basket",
		"zy-Shopping-basket-2",
		"zy-Shopping-cart-arrow",
		"zy-Shopping-cart",
		"zy-Shower",
		"zy-Site-logo",
		"zy-Site-tagline",
		"zy-Site-title",
		"zy-Skillbar",
		"zy-Skills-bar",
		"zy-Smart-post",
		"zy-Smartphone-use",
		"zy-Smartphone",
		"zy-Snow",
		"zy-Social-button",
		"zy-Social-feed-facebook",
		"zy-Social-feed-instagram",
		"zy-Social-feed-X",
		"zy-Social-media",
		"zy-Sofa",
		"zy-Solution",
		"zy-Source-code",
		"zy-Speaker-loud",
		"zy-Staircase",
		"zy-Star",
		"zy-Step-flow",
		"zy-Sticky-video",
		"zy-Stop-watch",
		"zy-Strategy-chase-knight",
		"zy-Strawberry",
		"zy-Subscription",
		"zy-Subtraction",
		"zy-Sun",
		"zy-Super-market",
		"zy-SVG-file",
		"zy-Swimming",
		"zy-Switch-arrow",
		"zy-Table-of-contents",
		"zy-Tablet-use",
		"zy-Tablet",
		"zy-Tacos",
		"zy-Tank-you-card",
		"zy-Target-arrow",
		"zy-Target-circle",
		"zy-Target-cricle-arrow",
		"zy-Taxi",
		"zy-Team-carousel",
		"zy-Team-member",
		"zy-Technology",
		"zy-Telephone-receiver",
		"zy-Templystock",
		"zy-Testimonial-rating",
		"zy-Testimonial",
		"zy-Text-file",
		"zy-Text-t",
		"zy-Three-dots",
		"zy-Thumbs-up",
		"zy-Tiktok",
		"zy-Tile",
		"zy-Tiles-layers",
		"zy-Time-process-2",
		"zy-Time-process",
		"zy-Timeline",
		"zy-TM-trade-mark",
		"zy-Toggle-button",
		"zy-Toggle",
		"zy-Tools",
		"zy-Tooltips",
		"zy-Tooth",
		"zy-Torch",
		"zy-Tree",
		"zy-Trees-Green",
		"zy-Trophy",
		"zy-Truck-Lorry",
		"zy-Trush",
		"zy-Tshirt",
		"zy-University",
		"zy-Up-arrow-double-line",
		"zy-Up-arrow",
		"zy-Up-cursor",
		"zy-Up-turn",
		"zy-Up-u-turn",
		"zy-Up-right-cursor",
		"zy-Upload-arrow",
		"zy-Upload",
		"zy-US-dollar-coin",
		"zy-US-dollar",
		"zy-USB-stick-2",
		"zy-USB-stick",
		"zy-User-gear",
		"zy-User-or-team",
		"zy-User-star",
		"zy-Verified-badge",
		"zy-Verified-check",
		"zy-Vertex-media",
		"zy-Video-file",
		"zy-Video-folder",
		"zy-Video-player",
		"zy-Wallet",
		"zy-Water-drop",
		"zy-Water-lily",
		"zy-Water",
		"zy-Web-templates",
		"zy-Webcam-camera",
		"zy-Wedding-ring",
		"zy-Wellness-bowl",
		"zy-Wellness-cream",
		"zy-Wellness-tree",
		"zy-Whale",
		"zy-Window",
		"zy-Wordpress",
		"zy-X-twitter",
		"zy-Yammy",
		"zy-Yoga-fitness",
		"zy-Youtube",
		"zy-Youtube-2",
		"zy-Zip-file",
		"zy-Zip-folder"
	];

	var newIcons = icons.map(function(icon){
		return prefix + " " + icon;
	});

	return newIcons;
  }

  // Initialize Aesthetic Icon Picker with a large icon library
  var zyMegaMenuIconPicker = AestheticIconPicker({
    selector: "#icon-picker-wrap",
    onClick: "#select-icon",
    iconLibrary: {
      "zyre-icons": {
        regular: {
          prefix: "zy-fonticon zy-",
          "icon-style": "zy-regular",
          "list-icon": "zy-fonticon zy-Zyre-addons",
          icons: zyreIconsList("zy-fonticon"),
        },
		bold: {
          prefix: "zy-fonticon-b zy-",
          "icon-style": "zy-bold",
          "list-icon": "zy-fonticon zy-Zyre-addons",
          icons: zyreIconsList("zy-fonticon-b"),
        }
      }
    }
  });

  // Handler: Save menu item settings button
  var saveButton = $(".zy-menu-item-save");
  saveButton.on("click", function () {
    var spinner = $(this).parent().find(".spinner");
    var checkmark = $(this).parent().find(".zy-checkmark");

    // Prepare settings payload
    var payload = {
      action: "zyreladdons_save_menuitem_settings",
      _wpnonce: zyreMegaMenu._wpnonce,
      settings: {
        menu_id: $("#zy-menu-modal-menu-id").val(),
        menu_has_child: $("#zy-menu-modal-menu-has-child").val(),
        menu_enable: $("#zy-menu-item-enable:checked").val(),
        menu_icon: $("#zy-menu-icon-field").val(),
        menu_icon_color: $("#zy-menu-icon-color-field").val(),
        menu_icon_size: $("#zy-menu-icon-size-field").val(),
        menu_item_text_hide: $("#zy-hide-menu-item-text").is(":checked") ? 1 : 0,
        menu_badge_text: $("#zy-menu-badge-text-field").val(),
        menu_badge_color: $("#zy-menu-badge-color-field").val(),
        menu_badge_enable_arrow: $("#zy-menu-item-enable-badge-arr:checked").val(),
        menu_badge_background: $("#zy-menu-badge-background-field").val(),
        menu_badge_radius: badgeRadiusString,
        megamenu_width: $("#zy-menu-megamenu-width-field").val(),
        mobile_submenu_content_type: $("#mobile_submenu_content_type input[name=content_type]:checked").val(),
        vertical_megamenu_position_type: $("#vertical_megamenu_position_type input[name=position_type]:checked").val(),
        megamenu_width_type: $("#zy_megamenu_width_type #width_type").val()
      },
      nocache: Math.floor(Date.now() / 1000)
    };

    // Show spinner while saving
    spinner.addClass("loading");

    // Send AJAX request to save settings
    $.ajax({
      url: zyreMegaMenu.ajaxUrl,
      type: "post",
      data: payload,
      success: function (response) {
        spinner.removeClass("loading");
		checkmark.removeClass("zypro-d-none");
		setTimeout(function () {
			checkmark.addClass("zypro-d-none");
		}, 1500);
      }
    });

    // Dispatch custom event to notify other parts of the UI
    var eventDetail = {
      menuID: $("#zy-menu-modal-menu-id").val(),
      isEnabled: $("#zy-menu-item-enable:checked").val()
    };
    if (menuToEditElement) {
      menuToEditElement.dispatchEvent(new CustomEvent(CARD_UPDATE_EVENT, { detail: eventDetail }));
    }
  });

  // Handler: open builder modal and load editor into iframe
  $("#zy-menu-builder-trigger").on("click", function () {
    var menuId = $("#zy-menu-modal-menu-id").val();
    var triggerElement = $(this);

    $.ajax({
      url: zyreMegaMenu.ajaxUrl,
      type: "post",
      data: { action: "zyreladdons_get_content_editor", _wpnonce: zyreMegaMenu._wpnonce, key: menuId },
      success: function (response) {
		if (response.success) {
			var responseUrl = response.data.url;
			$("#zy-menu-builder-iframe").attr("src", responseUrl);

			// Open modal (using modal plugin)
			triggerElement.modal({
			closeExisting: false,
			closeClass: "zy-modal-close",
			closeText:
				'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <line fill="none" stroke="#fff" stroke-width="1.4" x1="1" y1="1" x2="19" y2="19"></line> <line fill="none" stroke="#fff" stroke-width="1.4" x1="19" y1="1" x2="1" y2="19"></line></svg>'
			});
		}
      }
    });
  });

  // Ensure each menu item has a "Happy Menu" trigger link
  $("body").on("DOMSubtreeModified", "#menu-to-edit", function () {
    setTimeout(function () {
      $("#menu-to-edit li.menu-item").each(function () {
        var item = $(this);
        if (item.find(".zy_megamenu_trigger").length < 1) {
          $(".item-title", item).append("<a data-target='#zy__menu_settings_modal' href='#' class='zy_megamenu_trigger'>Zyre Menu</a> ");
        }
      });
    }, 200);
  });

  // Trigger once on init to ensure existing items get the link
  $("#menu-to-edit").trigger("DOMSubtreeModified");

  // Handle click on the "Happy Menu" trigger to open settings modal for that menu item
  $("#menu-to-edit").on("click", ".zy_megamenu_trigger", function (clickEvent) {
    clickEvent.preventDefault();

    var modalElement = $("#zy__menu_settings_modal");
    var menuItem = $(this).parents("li.menu-item");

    // Extract numeric menu id from element id like "menu-item-123"
    var menuId = parseInt(menuItem.attr("id").match(/[0-9]+/)[0], 10);

    // Reset active tabs and set appropriate tab depending on depth
    $(".zy_menu_control_nav > li").removeClass("attr-active");
    $(".attr-tab-pane").removeClass("attr-active");

    var hasChildFlag;
    if ($(this).parents(".menu-item").hasClass("menu-item-depth-0")) {
      // Top-level item
      hasChildFlag = 0;
      modalElement.removeClass("zy-menu-has-child");
      $("#attr_content_nav").addClass("attr-active");
      $("#attr_content_tab").addClass("attr-active");
    } else {
      // Child item
      hasChildFlag = 1;
      modalElement.addClass("zy-menu-has-child");
      $("#attr_icon_nav").addClass("attr-active");
      $("#attr_icon_tab").addClass("attr-active");
    }

    // Set hidden inputs in the modal
    $("#zy-menu-modal-menu-id").val(menuId);
    $("#zy-menu-modal-menu-has-child").val(hasChildFlag);

    // Prepare AJAX request to fetch menu item settings
    var settingsRequest = {
      action: "zyreladdons_get_menuitem_settings",
	  _wpnonce: zyreMegaMenu._wpnonce,
      menu_id: menuId,
      nocache: Math.floor(Date.now() / 1000)
    };

    // Fetch settings and populate modal controls
    $.ajax({
      url: zyreMegaMenu.ajaxUrl,
      type: "POST",
      data: settingsRequest,
      dataType: "json",
      success: function (response) {

        // response contains stored settings for this menu item
        if (response.menu_badge_radius) {
          var radii = response.menu_badge_radius.split(",");
          badgeRadiusTopLeft.val(radii[0]);
          badgeRadiusTopRight.val(radii[1]);
          badgeRadiusBottomLeft.val(radii[2]);
          badgeRadiusBottomRight.val(radii[3]);
        } else {
          badgeRadiusTopLeft.val("").trigger("change");
          badgeRadiusTopRight.val("").trigger("change");
          badgeRadiusBottomLeft.val("").trigger("change");
          badgeRadiusBottomRight.val("").trigger("change");
        }

        // Set various UI fields from response
        $("#zy-menu-item-enable").prop("checked", response.menu_enable == 1);
        $("#zy-menu-icon-color-field").wpColorPicker("color", response.menu_icon_color);
		$("#zy-menu-icon-size-field").val(response.menu_icon_size);
		$("#zy-hide-menu-item-text").prop("checked", response.menu_item_text_hide == 1);
        $("#zy-menu-icon-field").val(response.menu_icon);
        $("#zy-menu-badge-text-field").val(response.menu_badge_text);
        $("#zy-menu-badge-color-field").wpColorPicker("color", response.menu_badge_color);
        $("#zy-menu-badge-background-field").wpColorPicker("color", response.menu_badge_background);
		$("#zy-menu-item-enable-badge-arr").prop("checked", response.menu_badge_enable_arrow == 1);
        $("#zy-menu-megamenu-width-field").val(response.megamenu_width);

        // Mobile submenu content type radio handling
        $("#mobile_submenu_content_type input").prop("checked", false);
        if (response.mobile_submenu_content_type === "submenu_list") {
          $("#mobile_submenu_content_type input[value=submenu_list]").prop("checked", true);
        } else {
          $("#mobile_submenu_content_type input[value=builder_content]").prop("checked", true);
        }

        // Vertical megamenu position type radio handling
        $("#vertical_megamenu_position_type input").prop("checked", false);
        if (response.vertical_megamenu_position_type === "position_default") {
          $("#vertical_megamenu_position_type input[value=position_default]").prop("checked", true);
        } else {
          $("#vertical_megamenu_position_type input[value=position_relative]").prop("checked", true);
        }

        // Megamenu width type handling (default, full, custom)
		if ( response.megamenu_width_type ) {
			$("#zy_megamenu_width_type #width_type").val( response.megamenu_width_type );
		}

        // Toggle menu width container if custom width selected
        if ($("#zy_megamenu_width_type #width_type").val() === "custom_width") {
          $(".menu-width-container").addClass("is_enabled");
        } else {
          $(".menu-width-container").removeClass("is_enabled");
        }

        // Ensure enable toggle UI is refreshed
        $("#zy-menu-item-enable").trigger("change");

        // Populate icon field and reload icon picker
        $("#zy-menu-icon-field").val(response.menu_icon);
        zyMegaMenuIconPicker.reload();

        // Remove loading class from modal after short delay
        setTimeout(function () {
          modalElement.removeClass("zy-menu-modal-loading");
        }, 500);

        // Badge live preview bindings
        var badgePreview = $("#badge-preview");
        var badgeTextField = $("#zy-menu-badge-text-field");
        var badgeColorField = $("#zy-menu-badge-color-field");
        var badgeBackgroundField = $("#zy-menu-badge-background-field");
		var badgeEnableArr = $("#zy-menu-item-enable-badge-arr");

        badgeTextField.change(function () {
          badgePreview.find('span').text($(this).val());
        }).trigger("change");

		// When enabling/disabling badge arrow, update preview visibility
		badgeEnableArr.change(function () {
			if ($(this).is(":checked")) {
				badgePreview.find('.zy-menu-badge-arrow').css('display', 'inline-block');
			} else {
				badgePreview.find('.zy-menu-badge-arrow').css('display', 'none');
			}
		}).trigger("change");

        badgeColorField.change(function () {
          badgePreview.css("color", $(this).val());
        }).trigger("change");

        badgeColorField.wpColorPicker({
          change: function (event, ui) {
            badgePreview.css("color", ui.color.toString());
          }
        });

        badgeBackgroundField.change(function () {
          badgePreview.css("background", $(this).val());
          badgePreview.find('.zy-menu-badge-arrow').css("border-top-color", $(this).val());
        }).trigger("change");

        badgeBackgroundField.wpColorPicker({
          change: function (event, ui) {
            badgePreview.css("background", ui.color.toString());
            badgePreview.find('.zy-menu-badge-arrow').css("border-top-color", ui.color.toString());
          }
        });

        // Update badge preview border radius live as inputs change
        function updateBadgeRadiusString() {
          badgeRadiusString = badgeRadiusTopLeft.val() + "," + badgeRadiusTopRight.val() + "," + badgeRadiusBottomLeft.val() + "," + badgeRadiusBottomRight.val();
        }

        badgeRadiusTopLeft.change(function () {
          if ($(this).val()) {
            badgePreview.css("border-top-left-radius", $(this).val() + "px");
          } else {
            badgePreview.css("border-top-left-radius", "");
          }
          updateBadgeRadiusString();
        }).trigger("change");

        badgeRadiusTopRight.change(function () {
          if ($(this).val()) {
            badgePreview.css("border-top-right-radius", $(this).val() + "px");
          } else {
            badgePreview.css("border-top-right-radius", "");
          }
          updateBadgeRadiusString();
        }).trigger("change");

        badgeRadiusBottomLeft.change(function () {
          if ($(this).val()) {
            badgePreview.css("border-bottom-left-radius", $(this).val() + "px");
          } else {
            badgePreview.css("border-bottom-left-radius", "");
          }
          updateBadgeRadiusString();
        }).trigger("change");

        badgeRadiusBottomRight.change(function () {
          if ($(this).val()) {
            badgePreview.css("border-bottom-right-radius", $(this).val() + "px");
          } else {
            badgePreview.css("border-bottom-right-radius", "");
          }
          updateBadgeRadiusString();
        }).trigger("change");

      }
    });

    // Open the modal after AJAX call
    modalElement.modal();
  });

  // Toggle custom width container when width_type radios change
	$('#zy_megamenu_width_type #width_type').change(function () {
	if ($(this).val() === 'custom_width') {
		$('.menu-width-container').addClass('is_enabled');
	} else {
		$('.menu-width-container').removeClass('is_enabled');
	}
	}).trigger('change');

  // When enabling/disabling menu item, toggle builder UI availability
  $("#zy-menu-item-enable").on("change", function () {
    if ($(this).is(":checked")) {
      $("#zy-menu-builder-trigger").prop("disabled", false);
      $("#zy-menu-builder-warper").addClass("is_enabled");
    } else {
      $("#zy-menu-item-enable").prop("checked", false);
      $("#zy-menu-builder-warper").removeClass("is_enabled");
      $("#zy-menu-builder-trigger").prop("disabled", true);
    }
  });

  // Global megamenu metabox toggle (updates body classes)
  $("#nav-menu-header").on("change.ekit", "#zy-menu-metabox-input-is-enabled", function () {
    if ($(this).is(":checked")) {
      $("body").addClass("is_mega_enabled").removeClass("is_mega_disabled");
    } else {
      $("body").removeClass("is_mega_enabled").addClass("is_mega_disabled");
    }
  });


  // Insert megamenu trigger markup near menu name and trigger change event
  $(window.zy_megamenu_trigger_markup)
    .insertAfter("#nav-menu-header #menu-name")
    .parent()
    .find("#zy-megamenu-trigger")
    .trigger("change.ekit");

  // Access builder iframe window/document
  var builderIframe = document.getElementById("zy-menu-builder-iframe");
  var builderIframeWindowOrDocument = builderIframe ? (builderIframe.contentWindow || builderIframe.contentDocument) : null;

  // Helper function already defined earlier: updateBadgeRadiusString()

  // When modal is about to hide, warn if Elementor publish button indicates unsaved changes
  // and unbind beforeunload handlers inside the iframe
  var modalElementJQ = $(saveButton); // using saveButton jQuery object to bind hide event as in original code
  modalElementJQ.on("hide.bs.attr-modal", function (event) {
    if (builderIframeWindowOrDocument && builderIframeWindowOrDocument.jQuery) {
      var publishButton = builderIframeWindowOrDocument.jQuery("#elementor-panel-saver-button-publish");
      if (publishButton && !publishButton.hasClass("elementor-disabled")) {
        if (!confirm("Changes you made may not be saved.")) {
          event.preventDefault();
        }
      }
      builderIframeWindowOrDocument.jQuery(builderIframeWindowOrDocument).off("beforeunload");
    }
  });
});
