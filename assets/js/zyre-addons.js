"use strict";

function haObserveTarget(target, callback) {
  var options =
    arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
  var observer = new IntersectionObserver(function (entries, observer) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        callback(entry);
      }
    });
  }, options);
  observer.observe(target);
}

(function ($) {
  "use strict";

  var $window = $(window);

  function debounce(func, wait, immediate) {
    var timeout;
    return function () {
      var context = this,
        args = arguments;
      var later = function later() {
        timeout = null;
        if (!immediate) func.apply(context, args);
      };
      var callNow = immediate && !timeout;
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
      if (callNow) func.apply(context, args);
    };
  }

  function initFilterNav($scope, filterFn) {
    var $filterNav = $scope.find(".zyre-js-filter-tabs"),
      defaultFilter = $filterNav.data("default-filter");
    if ($filterNav.length) {
      $filterNav.on("click.onFilterNav", "a", function (event) {
        event.stopPropagation();
        var $current = $(this);
        $current
          .addClass("zyre-filter-tab--active")
          .parent()
          .siblings()
          .find(".zyre-filter-tab--active")
          .removeClass("zyre-filter-tab--active");
        filterFn($current.data("filter"));
      });
      $filterNav.find('[data-filter="' + defaultFilter + '"]').click();
    }
  }

  function adjustInputHeight($selector) {
    $selector.each(function () {
      var $this = $(this),
        prevHeight = getComputedStyle(this).getPropertyValue("height");

      $this.on("input", function () {
        if (!$this.val().trim()) {
          $this.css("height", prevHeight);
          return;
        }

        if (this.scrollHeight >= parseFloat(prevHeight)) {
          $this.css("height", this.scrollHeight + "px");
        }
      });
    });
  }

  $window.on("elementor/frontend/init", function () {
    var ModuleHandler = elementorModules.frontend.handlers.Base;

    // Toggle Switcher
    var Toggle_Switcher = function Toggle_Switcher($scope) {
      var parent = $scope.find(".zyre-toggle-wrapper"),
        toggleType = parent.data("toggle-type");
      if (toggleType == "button") {
        var buttons = parent.find(".zyre-toggle-switch-button"),
          contents = parent.find(".zyre-toggle-content-section");
        buttons.each(function (inx, btn) {
          $(this).on("click", function (e) {
            e.preventDefault();

            if ($(this).hasClass("active")) {
              return;
            } else {
              buttons.removeClass("active");
              $(this).addClass("active");
              contents.removeClass("active");
              var contentId = $(this).data("content-id");
              parent.find("#" + contentId).addClass("active");
            }
          });
        });
      } else {
        var toggleSwitch = parent.find(".zyre-toggle-input-label"),
          input = parent.find("input.zyre-toggle-switch-input"),
          primarySwitcher = parent.find(".zyre-toggle-switch-text-primary"),
          secondarySwitcher = parent.find(".zyre-toggle-switch-text-secondary"),
          primaryContent = parent.find(".zyre-toggle-content-primary"),
          secondaryContent = parent.find(".zyre-toggle-content-secondary");

        toggleSwitch.on("click", function (e) {
          if (input.is(":checked")) {
            toggleSwitch.addClass("active");
            primarySwitcher.removeClass("active");
            primaryContent.removeClass("active");
            secondarySwitcher.addClass("active");
            secondaryContent.addClass("active");
          } else {
            toggleSwitch.removeClass("active");
            secondarySwitcher.removeClass("active");
            secondaryContent.removeClass("active");
            primarySwitcher.addClass("active");
            primaryContent.addClass("active");
          }
        });
      }
    };

    // Team Member
    var Team_Member = function Team_Member($scope) {
      var btn = $scope.find(".zyre-button");
      var lightBox = $scope.find(".zyre-member-lightbox");
      if (lightBox.length > 0) {
        var close = lightBox.find(".zyre-member-lightbox-close");
        btn.on("click", function (e) {
          e.preventDefault();
          lightBox.addClass("zyre-member-lightbox-show");
        });
        lightBox.on("click", function (e) {
          if (lightBox.hasClass("zyre-member-lightbox-show")) {
            if (e.target == lightBox[0]) {
              lightBox.removeClass("zyre-member-lightbox-show");
            } else if (e.target == close[0]) {
              lightBox.removeClass("zyre-member-lightbox-show");
            }
          }
        });
      }
    };

    // Fun Fact
    var FunFact = function FunFact($scope) {
      haObserveTarget($scope[0], function () {
        var $fun_fact = $scope.find(".zyre-fun-fact-number");

        if ($fun_fact.data("animated")) {
          return;
        }

        var animationData = $fun_fact.data("animation");

        // Check if we need to insert a decimal before the last N digits
        if (animationData.placeDecimal && animationData.placeDecimal > 0) {
          function insertDecimal(value, decimalDigits) {
            const str = value.toString().padStart(decimalDigits + 1, "0");
            const pointIndex = str.length - decimalDigits;
            return str.slice(0, pointIndex) + "." + str.slice(pointIndex);
          }

          // Add the custom onStep function
          animationData.onStep = function (now) {
            const formatted = insertDecimal(
              Math.floor(now),
              animationData.placeDecimal,
            );
            $fun_fact.text(formatted);
          };
        }

        $fun_fact.data("animated", true);
        $fun_fact.numerator(animationData);
      });
    };

    // Skill Bar / Progressbar
    var SkillHandler = function SkillHandler($scope) {
      haObserveTarget($scope[0], function () {
        var isRTL = $("html").attr("dir") === "rtl",
          positionProp = isRTL ? "right" : "left";

        $scope.find(".zyre-progress-bar").each(function () {
          var $current = $(this),
            $percent = $current.find(".zyre-progress-percent"),
            percentage = $current.data("percentage"),
            duration = $current.data("duration");

          $current.find(".zyre-progress-fill").animate(
            {
              width: percentage + "%",
            },
            duration ?? 1300,
          );
          $current.find(".zyre-progress-number-mark").animate(
            {
              [positionProp]: percentage + "%",
            },
            duration ?? 1300,
          );

          $percent.numerator({
            toValue: percentage + "%",
            duration: duration ?? 1300,
            onStep: function onStep() {
              $percent.append("%");
            },
          });
        });
      });
    };

    // PDF View
    var PDF_View = function PDF_View($scope) {
      var $id = $scope.data("id");
      var $settings = $scope.find(".viewer-" + $id).data("pdf-settings");
      var options = {
        width: $settings.width,
        height: $settings.height,
        page: $settings.page_number,
        pdfOpenParams: {
          toolbar: $settings.toolbar,
        },
      };

      PDFObject.embed($settings.pdf_url, "#" + $settings.unique_id, options);
    };

    // Lottie Animations
    var LottieAnimations = function LottieAnimations($scope) {
      var lottieAnimations = $scope.find(".zyre-lottie-animation"),
        lottieJSON = JSON.parse(lottieAnimations.attr("data-settings"));

      var animation = lottie.loadAnimation({
        container: lottieAnimations[0], // Required
        path: lottieAnimations.attr("data-json-url"), // Required
        renderer: lottieJSON.lottie_renderer, // Required
        loop: "yes" === lottieJSON.loop ? true : false, // Optional
        autoplay: "yes" === lottieJSON.autoplay ? true : false,
      });

      animation.setSpeed(lottieJSON.speed);

      if (lottieJSON.reverse) {
        animation.setDirection(-1);
      }

      animation.addEventListener("DOMLoaded", function () {
        if ("hover" !== lottieJSON.trigger && "none" !== lottieJSON.trigger) {
          // if ( 'viewport' === lottieJSON.trigger ) {
          initLottie("load");
          $(window).on("scroll", initLottie);
        }

        if ("hover" === lottieJSON.trigger) {
          animation.pause();
          lottieAnimations.hover(
            function () {
              animation.play();
            },
            function () {
              animation.pause();
            },
          );
        }

        function initLottie(event) {
          animation.pause();

          if (typeof lottieAnimations[0].getBoundingClientRect === "function") {
            var height = document.documentElement.clientHeight;
            var scrollTop =
              (lottieAnimations[0].getBoundingClientRect().top / height) * 100;
            var scrollBottom =
              (lottieAnimations[0].getBoundingClientRect().bottom / height) *
              100;
            var scrollEnd = scrollTop < lottieJSON.scroll_end;
            var scrollStart = scrollBottom > lottieJSON.scroll_start;

            if ("viewport" === lottieJSON.trigger) {
              scrollStart && scrollEnd ? animation.play() : animation.pause();
            }

            if ("scroll" === lottieJSON.trigger) {
              if (scrollStart && scrollEnd) {
                animation.pause();

                // $(window).scroll(function() {
                // calculate the percentage the user has scrolled down the page
                var scrollPercent =
                  (100 * $(window).scrollTop()) /
                  ($(document).height() - $(window).height());

                var scrollPercentRounded = Math.round(scrollPercent);

                animation.goToAndStop((scrollPercentRounded / 100) * 4000); // why 4000
                // });
              }
            }
          }
        }
      });
    };

    // Navigation Menu
    var ZyreMenu = function ZyreMenu($scope) {
      var widgetId = $scope.data("id");
      var widgetClass = widgetId
        ? ".elementor-element.elementor-element-" + widgetId
        : ".zyre-nav-menu";
      var navMenu = $scope.find(".zyre-nav-menu");
      var $openIcon = navMenu.find(".zyre-menu-open-icon");
      var $closeIcon = navMenu.find(".zyre-menu-close-icon");
      var humBurgerBtn = navMenu.find(".zyre-menu-toggler");
      var classAttr = navMenu.attr("class");
      var match = classAttr.match(/breakpoint-(-?\d+)/);
      var breakpoint = match ? Math.round(match[1]) : null;

      function addResponsiveCSS(breakpoint) {
        var settings = $scope.data("settings");

        var cssDesktop = `
				${widgetClass} .zyre-hamburger-wrapper{display:none}
				${widgetClass} ul.menu{--flex-grow: 0;display:flex;flex-wrap:wrap;align-items:center;column-gap:20px;row-gap:20px}
				${widgetClass} ul.menu > li {justify-content: center;flex-grow:var(--flex-grow)}
				${widgetClass} ul.menu > li > a {padding: 20px 0;}
				${widgetClass} ul.menu li .submenu-indicator{display:inline-block;vertical-align:middle;margin:auto 0;margin-inline-start:5px;text-align:center;cursor:pointer}
				${widgetClass} ul.sub-menu{position:absolute;transform:translateY(20px);transition:.3s;visibility:hidden;opacity:0;z-index:9999;background-color:#fff;min-width:260px;top:100%}
				body:not(.rtl) ${widgetClass} ul.sub-menu{left:0;box-shadow:4px 6px 12px rgba(0,0,0,.1)}
				body.rtl ${widgetClass} ul.sub-menu{right:0;box-shadow:-4px 6px 12px rgba(0,0,0,.1)}
				${widgetClass} ul.sub-menu li .submenu-indicator{padding-left:20px;padding-right:20px;transform:rotate(-90deg)}
				${widgetClass} ul.menu li.menu-item-has-children:hover>ul.sub-menu{transform:translateY(0);visibility:visible;opacity:1}
				${widgetClass} ul.sub-menu li a{padding:20px 25px}
				body:not(.rtl) ${widgetClass} ul.sub-menu ul.sub-menu{left:100%}
				body.rtl ${widgetClass} ul.sub-menu ul.sub-menu{right:100%}
				${widgetClass} ul.sub-menu li.menu-item-has-children:hover>ul.sub-menu{transform:translateY(0);visibility:visible;opacity:1;top:0;}
				body:not(.rtl) ${widgetClass} ul.sub-menu li.menu-item-has-children:hover>ul.sub-menu{left:100%}
				body.rtl ${widgetClass} ul.sub-menu li.menu-item-has-children:hover>ul.sub-menu{right:100%}
				`;

        if (settings && settings.menu_item_rm_border) {
          cssDesktop += `${widgetClass}:not(.zyre-menu__mobile) ul.menu>li:${settings.menu_item_rm_border} {border: none;}`;
        }

        if (settings && settings.submenu_item_rm_border) {
          cssDesktop += `${widgetClass}:not(.zyre-menu__mobile) ul.sub-menu>li:${settings.submenu_item_rm_border} {border: none;}`;
        }

        var cssResponsive = `
				${widgetClass} .zyre-hamburger-wrapper{display:flex}
				${widgetClass} ul.menu,
				${widgetClass} ul.menu ul.sub-menu{display:none}
				${widgetClass} ul.menu ul.sub-menu{width:100%;z-index:10;margin-inline-start:15px}
				${widgetClass} ul.menu > li {justify-content: space-between}
				${widgetClass} ul.menu li{flex-wrap: wrap;}
				${widgetClass} ul.menu li:not(:last-child){border-bottom:1px solid var(--zy-hue2)}
				${widgetClass} ul.menu li a{padding: 15px 0}
				${widgetClass} ul.menu li .submenu-indicator{cursor:pointer;padding-left:20px;padding-right:20px;align-content:center;align-self: stretch}
				${widgetClass} ul.menu li .submenu-indicator svg{fill:#8C919B;transition:transform var(--zy-transition-duration),color var(--zy-transition-duration)}
				${widgetClass} ul.menu li .submenu-indicator.active svg{transform:rotate(-180deg)}
				${widgetClass} ul.menu li .submenu-indicator.active svg,
				${widgetClass} ul.menu li .submenu-indicator:hover svg{fill:#000}
				${widgetClass} ul.sub-menu li a{padding-left: 0;padding-right: 0}
				`;

        if (settings && settings.mobile_menu_item_rm_border) {
          cssResponsive += `${widgetClass}.zyre-menu__mobile ul.menu li:${settings.mobile_menu_item_rm_border} {border: none !important;}`;
        }

        var css = "";
        if (breakpoint && "-1" == breakpoint) {
          css += cssResponsive;
        } else if (breakpoint && breakpoint > 0) {
          css += `@media (min-width: ${breakpoint + 1}px) { ${cssDesktop} }`;
          css += `@media (max-width: ${breakpoint}px) { ${cssResponsive} }`;
        } else {
          css += cssDesktop;
        }

        var styleEl = document.createElement("style");
        styleEl.id = `zyreladdons-nav-menu-${widgetId}-inline`;
        styleEl.textContent = css;

        // detect Elementor edit mode
        if (window.elementorFrontend && elementorFrontend.isEditMode()) {
          $scope.prepend(styleEl);
        } else {
          document.head.appendChild(styleEl);
        }
      }

      if (navMenu.length) {
        navMenu.addClass("initialized");
        addResponsiveCSS(breakpoint);
      }

      humBurgerBtn.on("click", function (e) {
        var $icon = $(this);

        var humberger = $icon.data("humberger");
        var $menu = navMenu.find("ul.menu");

        if ("open" == humberger) {
          $openIcon.removeClass("zy-icon-hide");
          $openIcon.addClass("zy-icon-hide");
          $closeIcon.removeClass("zy-icon-hide");
          $menu.slideDown();
        } else {
          $closeIcon.removeClass("zy-icon-hide");
          $closeIcon.addClass("zy-icon-hide");
          $openIcon.removeClass("zy-icon-hide");
          $menu.slideUp();
        }
      });

      function childrenToggle() {
        $scope.addClass("zyre-menu__mobile");
        var subMenuIndicator = navMenu.find(".submenu-indicator");
        subMenuIndicator.off("click").on("click", function () {
          $(this).toggleClass("active");
          var $parentEl = $(this).parent("li.menu-item-has-children");
          if ($parentEl) {
            $parentEl.children("ul.sub-menu").slideToggle();
          }
        });
      }

      if ("-1" == breakpoint) {
        childrenToggle();
      } else {
        function burgerClsAdd() {
          if (breakpoint && jQuery(window).outerWidth() <= breakpoint) {
            childrenToggle();
          } else {
            $scope.removeClass("zyre-menu__mobile");
            navMenu.find("ul.menu").removeAttr("style");
            navMenu.find("ul.sub-menu").css("display", "");
            $closeIcon.addClass("zy-icon-hide");
            $openIcon.removeClass("zy-icon-hide");
          }
        }

        burgerClsAdd();
        $window.on("resize", debounce(burgerClsAdd, 100));
      }
    };

    // Mega Menu
    var ZyreMegaMenu = function ZyreMegaMenu($scope) {
      var widgetId = $scope.data("id");
      var widgetClass = widgetId
        ? ".elementor-element.elementor-element-" + widgetId
        : ".zyre-mega-menu";
      var navMenu = $scope.find(".zyre-mega-menu");
      var navMenuHasVr = navMenu.hasClass("zyre-mega-menu--vr");
      var $menu = navMenu.find("ul.menu");
      var $openIcon = navMenu.find(".zyre-menu-open-icon");
      var $closeIcon = navMenu.find(".zyre-menu-close-icon");
      var humBurgerBtn = navMenu.find(".zyre-menu-toggler");
      var classAttr = navMenu.attr("class");
      var match = classAttr.match(/breakpoint-(-?\d+)/);
      var breakpoint = match ? Math.round(match[1]) : null;
      var megaMenu = navMenu.find(".zy-megamenu-has");
      var mobileMenuClass = "zyre-menu__mobile";
      var dataCss = navMenu.find("[data-css]");

      function addMegaMenuCSS(breakpoint) {
        var settings = $scope.data("settings");

        var cssDesktop = `
			${widgetClass} .zyre-hamburger-wrapper,
			${widgetClass} .zy-megamenu-has ul.sub-menu:not(.zy-megamenu-panel) {display: none}
			${widgetClass} ul.menu{--flex-grow: 0;display:flex;flex-wrap:wrap;align-items:center;column-gap:20px;row-gap:20px}
			${widgetClass} .zyre-mega-menu--vr ul.menu{row-gap: 0;width: 280px;}
			${widgetClass} .zyre-mega-menu--vr.submenu--pos_top ul.menu{position:relative}
			${widgetClass} ul.menu > li.menu-item {justify-content: center;flex-grow:var(--flex-grow)}
			${widgetClass} .zyre-mega-menu--vr ul.menu > li.menu-item {width:100%;justify-content: space-between;column-gap: 15px;}
			${widgetClass} .zyre-mega-menu--vr.submenu--pos_top ul.menu li.menu-item-has-children {position:static;}
			${widgetClass} ul.menu > li.menu-item > a {padding: 20px 0;}
			${widgetClass} ul.menu li.menu-item .submenu-indicator{display:inline-block; vertical-align:middle;margin:auto 0;margin-inline-start:5px;text-align:center;cursor:pointer}
			${widgetClass} ul.sub-menu{position:absolute;transform:translateY(20px);transition:.3s;visibility:hidden;opacity:0;z-index:9999;background-color:#fff;min-width:260px;top:100%}
			body:not(.rtl) ${widgetClass} ul.sub-menu{left:0;box-shadow:4px 6px 12px rgba(0,0,0,.1);}
			body.rtl ${widgetClass} ul.sub-menu{right:0;box-shadow:4px 6px 12px rgba(0,0,0,.1);}
			${widgetClass} .zyre-mega-menu--vr.submenu--pos_top ul.sub-menu{transform:translateY(0)}
			${widgetClass} .zyre-mega-menu--vr.submenu--pos_top.submenu--h_full ul.sub-menu:not(.zy-megamenu-panel) {bottom: 0;}
			${widgetClass} .zyre-mega-menu--vr ul.sub-menu{top: 0;}
			body:not(.rtl) ${widgetClass} .zyre-mega-menu--vr ul.sub-menu{left:100%;}
			body.rtl ${widgetClass} .zyre-mega-menu--vr ul.sub-menu{right:100%;}
			${widgetClass} .zyre-mega-menu ul.sub-menu li.menu-item .submenu-indicator svg,
			${widgetClass} .zyre-mega-menu ul.sub-menu li.menu-item .submenu-indicator i,
			${widgetClass} .zyre-mega-menu--vr ul.menu > li.menu-item .submenu-indicator svg,
			${widgetClass} .zyre-mega-menu--vr ul.menu > li.menu-item .submenu-indicator i{transform:rotate(-90deg)}
			${widgetClass} ul.menu li.menu-item-has-children:hover>ul.sub-menu,
			${widgetClass} ul.menu li.zy-megamenu-has:hover>ul.sub-menu{transform:translateY(0);visibility:visible;opacity:1}
			${widgetClass} ul.sub-menu li.menu-item a{padding:18px 20px}
			body:not(.rtl) ${widgetClass} ul.sub-menu ul.sub-menu{left:100%}
			body.rtl ${widgetClass} ul.sub-menu ul.sub-menu{right:100%}
			${widgetClass} ul.sub-menu li.menu-item-has-children:hover>ul.sub-menu{transform:translateY(0);visibility:visible;opacity:1;top:0;}
			body:not(.rtl) ${widgetClass} ul.sub-menu li.menu-item-has-children:hover>ul.sub-menu{left:100%}
			body.rtl ${widgetClass} ul.sub-menu li.menu-item-has-children:hover>ul.sub-menu{right:100%}
				`;

        if (settings && settings.menu_item_rm_border) {
          cssDesktop += `${widgetClass}:not(.zyre-menu__mobile) ul.menu>li.menu-item:${settings.menu_item_rm_border} {border: none;}`;
        }

        if (settings && settings.submenu_item_rm_border) {
          cssDesktop += `${widgetClass}:not(.zyre-menu__mobile) ul.sub-menu>li.menu-item:${settings.submenu_item_rm_border} {border: none;}`;
        }

        var cssResponsive = `
			${widgetClass} .zyre-hamburger-wrapper{display:flex}
			${widgetClass} ul.menu,
			${widgetClass} .zy-megamenu-has.zy-mobile-submenu-items ul.zy-megamenu-panel,
			${widgetClass} ul.menu ul.sub-menu{display:none}
			${widgetClass} ul.menu ul.sub-menu{width:100%;z-index:10;margin-inline-start:15px}
			${widgetClass} ul.menu > li.menu-item {justify-content: space-between}
			${widgetClass} ul.menu li.menu-item{flex-wrap: wrap;}
			${widgetClass} ul.menu li.menu-item:not(:last-child){border-bottom:1px solid var(--zy-hue2)}
			${widgetClass} ul.menu li.menu-item a{padding: 15px 0}
			${widgetClass} ul.menu li.menu-item .submenu-indicator{cursor:pointer;padding-left:20px;padding-right:20px;align-content:center;align-self: stretch}
			${widgetClass} ul.menu li.menu-item .submenu-indicator svg{fill:#8C919B;transition:transform var(--zy-transition-duration),color var(--zy-transition-duration)}
			${widgetClass} ul.menu li.menu-item .submenu-indicator.active svg{transform:rotate(-180deg)}
			${widgetClass} ul.menu li.menu-item .submenu-indicator.active svg,
			${widgetClass} ul.menu li.menu-item .submenu-indicator:hover svg{fill:#000}
			${widgetClass} ul.sub-menu li.menu-item a{padding-left: 0;padding-right: 0}
				`;

        if (settings && settings.mobile_menu_item_rm_border) {
          cssResponsive += `${widgetClass}.zyre-menu__mobile ul.menu li.menu-item:${settings.mobile_menu_item_rm_border} {border: none !important;}`;
        }

        var css = "";
        if (breakpoint && "-1" == breakpoint) {
          css += cssResponsive;
        } else if (breakpoint && breakpoint > 0) {
          css += `@media (min-width: ${breakpoint + 1}px) { ${cssDesktop} }`;
          css += `@media (max-width: ${breakpoint}px) { ${cssResponsive} }`;
        } else {
          css += cssDesktop;
        }

        var styleEl = document.createElement("style");
        styleEl.id = `zyreladdons-mega-menu-${widgetId}-inline`;
        styleEl.textContent = css;

        // detect Elementor edit mode
        if (window.elementorFrontend && elementorFrontend.isEditMode()) {
          $scope.prepend(styleEl);
        } else {
          document.head.appendChild(styleEl);
        }
      }

      if (navMenu.length) {
        navMenu.addClass("initialized");
        addMegaMenuCSS(breakpoint);
      }

      if (dataCss.length > 0) {
        dataCss.each(function () {
          var css = $(this).attr("data-css");
          $(this).attr("style", css).removeAttr("data-css");
        });
      }

      humBurgerBtn.on("click", function (e) {
        var $icon = $(this);

        var humberger = $icon.data("humberger");
        var $menu = navMenu.find("ul.menu");

        if ("open" == humberger) {
          $openIcon.removeClass("zy-icon-hide");
          $openIcon.addClass("zy-icon-hide");
          $closeIcon.removeClass("zy-icon-hide");
          $menu.slideDown();
        } else {
          $closeIcon.removeClass("zy-icon-hide");
          $closeIcon.addClass("zy-icon-hide");
          $openIcon.removeClass("zy-icon-hide");
          $menu.slideUp();
        }
      });

      function childrenToggle() {
        $scope.addClass(mobileMenuClass);
        var subMenuIndicator = navMenu.find(".submenu-indicator");
        subMenuIndicator.off("click").on("click", function () {
          $(this).toggleClass("active");
          var $parentEl = $(this).parent("li.menu-item");
          var hasMegaMenu = $parentEl.hasClass("zy-megamenu-has");

          if (hasMegaMenu && $parentEl.hasClass("zy-mobile-builder-content")) {
            $parentEl.children("ul.sub-menu.zy-megamenu-panel").slideToggle();
          } else if (
            hasMegaMenu &&
            $parentEl.hasClass("zy-mobile-submenu-items")
          ) {
            $parentEl
              .children("ul.sub-menu:not(.zy-megamenu-panel)")
              .slideToggle();
          } else if ($parentEl.hasClass("menu-item-has-children")) {
            $parentEl.children("ul.sub-menu").slideToggle();
          }
        });
      }

      if ("-1" == breakpoint) {
        childrenToggle();
      } else {
        function burgerClsAdd() {
          if (breakpoint && jQuery(window).outerWidth() <= breakpoint) {
            childrenToggle();
          } else {
            $scope.removeClass(mobileMenuClass);
            navMenu.find("ul.menu").removeAttr("style");
            navMenu.find("ul.sub-menu").css("display", "");
            $closeIcon.addClass("zy-icon-hide");
            $openIcon.removeClass("zy-icon-hide");
          }
        }

        burgerClsAdd();
        $window.on("resize", debounce(burgerClsAdd, 100));
      }

      if (megaMenu.length) {
        megaMenu.each(function () {
          var $megaMenuItem = $(this);
          var mmWidth = $megaMenuItem.attr("data-megamenu-width");
          var mmPanel = $megaMenuItem.children(".zy-megamenu-panel");
          var mmIsFullWidth =
            $megaMenuItem.hasClass("zy-dropdown-menu-full_width") &&
            $megaMenuItem.hasClass("position_default");
          var mmIsFullWidthRel =
            $megaMenuItem.hasClass("zy-dropdown-menu-full_width") &&
            $megaMenuItem.hasClass("position_relative");

          if (mmWidth && mmWidth !== undefined) {
            if ("string" == typeof mmWidth) {
              if (/^[0-9]/.test(mmWidth)) {
                mmWidth = parseFloat(mmWidth);
                $(window)
                  .on(
                    "resize",
                    debounce(function () {
                      var hasMobileMenu = $scope.hasClass(mobileMenuClass);
                      if (hasMobileMenu) {
                        mmPanel.css("width", "");
                      } else {
                        mmPanel.css({
                          width: mmWidth + "px",
                        });
                      }
                    }, 150),
                  )
                  .trigger("resize");
              }
            }
          } else if (!navMenuHasVr && mmIsFullWidth) {
            $(window)
              .on(
                "resize",
                debounce(function () {
                  var posleft = Math.floor(
                    $megaMenuItem.position().left - $megaMenuItem.offset().left,
                  );
                  mmPanel.css({
                    width: $(window).width() + "px",
                    left: posleft + "px",
                  });
                }, 150),
              )
              .trigger("resize");
          } else if (!navMenuHasVr && mmIsFullWidthRel) {
            $(window)
              .on(
                "resize",
                debounce(function () {
                  var menuWidth = $menu.outerWidth();
                  var hasMobileMenu = $scope.hasClass(mobileMenuClass);

                  if (hasMobileMenu) {
                    mmPanel.css("width", "");
                  } else {
                    mmPanel.css({
                      width: menuWidth + "px",
                    });
                  }
                }, 150),
              )
              .trigger("resize");
          }
        });
      }
    };

    // Count Down
    var ZyreCountDown = function ZyreCountDown($scope) {
      const $countdown = $scope.find(".zyre-addons-countdown");
      $countdown.each(function () {
        var $this = $(this),
          cdJSON = JSON.parse($this.attr("data-cd-settings"));

        $this.downCount({
          date: cdJSON.timer ?? null,
          offset: cdJSON.offset || null,
          text_day: cdJSON.days ?? "days",
          text_hour: cdJSON.hours ?? "hours",
          text_minute: cdJSON.minutes ?? "minutes",
          text_second: cdJSON.seconds ?? "seconds",
        });
      });
    };

    // Subscription Form
    var ZyreMailChimp = function ZyreMailChimp($scope) {
      var mcForm = $scope.find(".zyre-subscription-form"),
        mcMessage = $scope.find(".zyre-mc-response-message");
      mcForm.on("submit", function (e) {
        e.preventDefault();
        var data = {
          action: "zyreladdons_mailchimp_ajax",
          security: ZyreLocalize.nonce,
          subscriber_info: mcForm.serialize(),
          list_id: mcForm.data("list-id"),
          post_id: mcForm.data("post-id"),
          widget_id: mcForm.data("widget-id"),
        };
        $.ajax({
          type: "post",
          url: ZyreLocalize.ajax_url,
          data: data,
          success: function success(response) {
            mcForm.trigger("reset");

            if (response.status) {
              if (window !== window.parent) {
                window.parent.postMessage({ subscribed: true }, "*");
              }
              mcMessage
                .removeClass("mc-error")
                .addClass("mc-success")
                .text(response.msg);
            } else {
              mcMessage
                .addClass("mc-error")
                .removeClass("mc-success")
                .text(response.msg);
            }
            var hideMsg = setTimeout(function () {
              mcMessage.removeClass("mc-error").removeClass("mc-success");
              clearTimeout(hideMsg);
            }, 5000);
          },
          error: function error(_error3) {},
        });
      });
    };

    // Accordion
    var ZyreAccordion = function ZyreAccordion($scope) {
      var $accordion = $scope.find(".zyre-accordion-tab-content"),
        accordionType = $accordion.data("accordion-type"),
        $accordionItems = $scope.find(".zyre-advance-accordion-section"),
        $accordionToggle = $scope.find(".zyre-accordion-toggle");

      // Toggle on click
      $accordionToggle.on("click", function () {
        var $currentItem = $(this).closest(".zyre-advance-accordion-section"),
          $currentItemContent = $currentItem.find(".zyre-accordion-contents");

        // Hide current Item
        if ($currentItem.hasClass("active")) {
          $currentItemContent.slideUp(function () {
            $currentItem.removeClass("active");
          });
        } else {
          // Close all others
          if ("accordion" === accordionType) {
            $accordionItems.each(function () {
              var $eachItem = $(this);
              if ($eachItem.hasClass("active")) {
                $eachItem.find(".zyre-accordion-contents").slideUp(function () {
                  $eachItem.removeClass("active");
                });
              }
            });
          }

          // Show current Item
          $currentItemContent.slideDown();
          $currentItem.addClass("active");
        }
      });
    };

    // Swiper Carousel Settings
    class ZyreCarousel extends elementorModules.frontend.handlers.CarouselBase {
      getDefaultSettings() {
        const settings = super.getDefaultSettings();

        settings.selectors.carousel = ".zyre-carousel-wrapper";

        return settings;
      }

      getSwiperSettings() {
        const baseSettings = super.getSwiperSettings(),
          settings = this.getElementSettings(),
          elementorBreakpoints =
            elementorFrontend.config.responsive.activeBreakpoints;

        baseSettings.slidesPerView =
          +settings.slides_per_view || baseSettings.slidesPerView;
        baseSettings.speed = settings.speed || baseSettings.speed;
        baseSettings.loop = "yes" === settings.loop;

        const isSingleSlide = 1 === baseSettings.slidesPerView,
          defaultSlidesToShowMap = {
            mobile: 1,
            tablet: isSingleSlide ? 1 : 2,
          };

        // Breakpoints
        baseSettings.breakpoints = {};

        let lastBreakpointSlidesToShowValue = baseSettings.slidesPerView;

        Object.keys(elementorBreakpoints)
          .reverse()
          .forEach((breakpointName) => {
            // Tablet has a specific default `slides_to_show`.
            const defaultSlidesToShow = defaultSlidesToShowMap[breakpointName]
              ? defaultSlidesToShowMap[breakpointName]
              : lastBreakpointSlidesToShowValue;

            baseSettings.breakpoints[
              elementorBreakpoints[breakpointName].value
            ] = {
              slidesPerView:
                +settings["slides_per_view_" + breakpointName] ||
                defaultSlidesToShow,
              slidesPerGroup:
                +settings["slides_to_scroll_" + breakpointName] || 1,
            };

            lastBreakpointSlidesToShowValue =
              +settings["slides_per_view_" + breakpointName] ||
              defaultSlidesToShow;
          });

        // Autoplay
        baseSettings.autoplay =
          "yes" === settings.autoplay
            ? {
                delay: +settings.autoplay_speed,
                disableOnInteraction: "yes" === settings.pause_on_interaction,
                pauseOnMouseEnter: "yes" === settings.pause_on_hover,
              }
            : false;

        // Effect
        if (isSingleSlide) {
          baseSettings.effect = settings.effect ?? "slide";

          if ("fade" === settings.effect) {
            baseSettings.fadeEffect = { crossFade: true };
          }
        } else {
          baseSettings.slidesPerGroup = +settings.slides_to_scroll || 1;
        }

        // Arrows & Navigation
        const showArrows =
            "arrows" === settings.navigation || "both" === settings.navigation,
          showPagination =
            "dots" === settings.navigation ||
            "both" === settings.navigation ||
            settings.pagination;

        if (baseSettings.pagination && showPagination) {
          baseSettings.pagination.type = settings.pagination || "bullets";
        }

        if (baseSettings.navigation && showArrows) {
          baseSettings.navigation = {
            prevEl: ".zyre-swiper-button-prev",
            nextEl: ".zyre-swiper-button-next",
          };
        }

        // Lazyload
        if (settings.lazyload && "yes" === settings.lazyload) {
          baseSettings.lazy = {
            loadPrevNext: true,
            loadPrevNextAmount: 1,
          };
        }

        return baseSettings;
      }
    }

    // Image Carousel
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/zyre-image-carousel.default",
      ($scope) => {
        new ZyreCarousel({ $element: $scope });
      },
    );

    // Logo Carousel
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/zyre-logo-carousel.default",
      ($scope) => {
        new ZyreCarousel({ $element: $scope });
      },
    );

    // News Ticker
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/zyre-news-ticker.default",
      ($scope) => {
        new ZyreCarousel({ $element: $scope });
      },
    );

    // Contact Form 7
    var ZyreCF7 = function ZyreCF7($scope) {
      const $textarea = $scope.find(".wpcf7-textarea");
      adjustInputHeight($textarea);
    };

    // Image Grid
    var ImageGrid = ModuleHandler.extend({
      onInit: function onInit() {
        ModuleHandler.prototype.onInit.apply(this, arguments);
        this.run();
        this.runFilter();
        $window.on("resize", debounce(this.run.bind(this), 100));
      },
      getLayoutMode: function getLayoutMode() {
        // var layout = this.getElementSettings('layout');
        // return layout === 'even' ? 'masonry' : layout;
      },
      getDefaultSettings: function getDefaultSettings() {
        return {
          itemSelector: ".zyre-image-grid-item",
          // layoutMode: this.getLayoutMode(),
          masonry: {
            columnWidth: 1,
          },
        };
      },
      getDefaultElements: function getDefaultElements() {
        return {
          $container: this.findElement(".zyre-isotope"),
        };
      },
      runFilter: function runFilter() {
        var self = this;
        initFilterNav(this.$element, function (filter) {
          self.elements.$container.isotope({
            filter: filter,
          });
        });
      },
      onElementChange: function onElementChange(changedProp) {
        if (
          [
            "item_height",
            "item_height_tablet",
            "item_height_mobile",
            "item_padding",
            "item_padding_tablet",
            "item_padding_mobile",
            "item_content_margin",
            "item_content_margin_tablet",
            "item_content_margin_mobile",
            "item_title_margin",
            "item_category_margin",
            "item_description_margin",
            "items_wrap_margin",
            "image_height",
            "image_height",
            "image_height_tablet",
            "image_height_mobile",
            "columns",
            "columns_tablet",
            "columns_mobile",
            "content_display",
            "filter_tabs_show",
            "enable_lightbox",
          ].indexOf(changedProp) !== -1
        ) {
          this.run();
        }
      },
      run: function run() {
        var self = this;

        if (!self.elements.$container.length) {
          return;
        }

        self.elements.$container
          .isotope(self.getDefaultSettings())
          .imagesLoaded()
          .progress(function () {
            self.elements.$container.isotope("layout");
          });
      },
    });

    // Post Comments
    var PostComments = function PostComments($scope) {
      const $comment = $scope.find("#comment");
      adjustInputHeight($comment);
    };

    // Testimonial
    var Testimonial = function Testimonial($scope) {
      var $rated = $scope.find(".zyre-testimonial-rated"),
        ratedW = $rated.data("width");
      if ($rated.length && ratedW) {
        $rated.css("width", ratedW + "%");
      }
    };

    // Search Box
    var SearchBox = function SearchBox($scope) {
      var $searchToggle = $scope.find(".zyre-search-toggle"),
        $searchCat = $scope.find(".zyre-search-form-select"),
        $searchField = $scope.find(".zyre-search-field"),
        $postTypes = $scope.find("#post-types");

      $searchCat.on("change", function () {
        var selectedCat = $(this).val();
        if (selectedCat) {
          $(this).attr("name", "cat_id");
        } else {
          $(this).removeAttr("name");
        }

        var selectedPostType = $(this).find(":selected").attr("data-post_type");
        if (selectedPostType) {
          $postTypes.attr("name", "post_types").val(selectedPostType);
        } else {
          $postTypes.removeAttr("name").val("");
        }
      });

      $searchToggle.on("click", function (e) {
        e.preventDefault();

        var $el = $searchField.closest(".zyre-search-form-search");

        if ($el.is(":visible")) {
          $el.fadeOut();
        } else {
          $el.css("display", "inline-flex").hide().fadeIn();
        }
      });
    };

    // Function Handlers
    var fnHanlders = {
      "zyre-toggle.default": Toggle_Switcher,
      "zyre-team-member.default": Team_Member,
      "zyre-fun-fact.default": FunFact,
      "zyre-skill-bar.default": SkillHandler,
      "zyre-pdf-view.default": PDF_View,
      "zyre-lottie-animation.default": LottieAnimations,
      "zyre-menu.default": ZyreMenu,
      "zyre-mega-menu.default": ZyreMegaMenu,
      "zyre-countdown.default": ZyreCountDown,
      "zyre-subscription-form.default": ZyreMailChimp,
      "zyre-advance-accordion.default": ZyreAccordion,
      "zyre-advance-toggle.default": ZyreAccordion,
      "zyre-cf7.default": ZyreCF7,
      "zyre-post-comments.default": PostComments,
      "zyre-testimonial.default": Testimonial,
      "zyre-search-box.default": SearchBox,
    };
    $.each(fnHanlders, function (widgetName, handlerFn) {
      elementorFrontend.hooks.addAction(
        "frontend/element_ready/" + widgetName,
        handlerFn,
      );
    });

    // Class Handlers
    var classHandlers = {
      "zyre-image-grid.default": ImageGrid,
    };
    $.each(classHandlers, function (widgetName, handlerClass) {
      elementorFrontend.hooks.addAction(
        "frontend/element_ready/" + widgetName,
        function ($scope) {
          elementorFrontend.elementsHandler.addHandler(handlerClass, {
            $element: $scope,
          });
        },
      );
    });

    // Off Canvas
    var $trigger;
    var OffCanvas = function OffCanvas($scope) {
      this.node = $scope;
      this.wrap = $scope.find(".zyre-offcanvas-content-wrap");
      this.cart_wrap = $scope.find(".zyre-offcanvas-cart-container");
      this.content = $scope.find(".zyre-offcanvas-content");
      this.button = $scope.find(".zyre-offcanvas-toggle");
      this.settings = this.wrap.data("settings");
      this.toggle_source = this.settings.toggle_source;
      this.id = this.settings.content_id;
      this.toggle_id = this.settings.toggle_id;
      this.toggle_class = this.settings.toggle_class;
      this.transition = this.settings.transition;
      this.esc_close = this.settings.esc_close;
      this.body_click_close = this.settings.body_click_close;
      this.direction = this.settings.direction;
      this.duration = 500;
      this.destroy();
      this.init();
    };
    OffCanvas.prototype = {
      id: "",
      node: "",
      wrap: "",
      content: "",
      button: "",
      settings: {},
      transition: "",
      duration: 400,
      initialized: false,
      animations: ["slide", "slide-along", "reveal", "push"],
      init: function init() {
        if (!this.wrap.length) {
          return;
        }
        $("html").addClass("zyre-offcanvas-content-widget");
        if ($(".zyre-offcanvas-container").length === 0) {
          $("body").wrapInner('<div class="zyre-offcanvas-container" />');

          this.content.insertBefore(".zyre-offcanvas-container");
        }
        if (this.wrap.find(".zyre-offcanvas-content").length > 0) {
          if (
            $(".zyre-offcanvas-container > .zyre-offcanvas-content-" + this.id)
              .length > 0
          ) {
            $(
              ".zyre-offcanvas-container > .zyre-offcanvas-content-" + this.id,
            ).remove();
          }
          if ($("body > .zyre-offcanvas-content-" + this.id).length > 0) {
            $("body > .zyre-offcanvas-content-" + this.id).remove();
          }
          $("body").prepend(this.wrap.find(".zyre-offcanvas-content"));
        }
        this.bindEvents();
      },
      destroy: function destroy() {
        this.close();
        this.animations.forEach(function (animation) {
          if ($("html").hasClass("zyre-offcanvas-content-" + animation)) {
            $("html").removeClass("zyre-offcanvas-content-" + animation);
          }
        });
        if ($("body > .zyre-offcanvas-content-" + this.id).length > 0) {
        }
      },
      setTrigger: function setTrigger() {
        var $trigger = false;
        if (this.toggle_source == "element-id" && this.toggle_id != "") {
          $trigger = $("#" + this.toggle_id);
        } else if (
          this.toggle_source == "element-class" &&
          this.toggle_class != ""
        ) {
          $trigger = $("." + this.toggle_class);
        } else {
          $trigger = this.node.find(".zyre-offcanvas-toggle");
        }
        return $trigger;
      },
      bindEvents: function bindEvents() {
        $trigger = this.setTrigger();
        if ($trigger) {
          $trigger.on("click", $.proxy(this.toggleContent, this));
        }
        $("body").delegate(
          ".zyre-offcanvas-content .zyre-offcanvas-close",
          "click",
          $.proxy(this.close, this),
        );
        if (this.esc_close === "yes") {
          this.closeESC();
        }
        if (this.body_click_close === "yes") {
          this.closeClick();
        }
        $(window).resize($.proxy(this._resize, this));
      },
      toggleContent: function toggleContent(e) {
        e.preventDefault();
        if (!$("html").hasClass("zyre-offcanvas-content-open")) {
          this.show();
        } else {
          this.close();
        }
        this._resize();
      },
      show: function show() {
        $(".zyre-offcanvas-content-" + this.id).addClass(
          "zyre-offcanvas-content-visible",
        );
        // init animation class.
        $("html").addClass("zyre-offcanvas-content-" + this.transition);
        $("html").addClass("zyre-offcanvas-content-" + this.direction);
        $("html").addClass("zyre-offcanvas-content-open");
        $("html").addClass("zyre-offcanvas-content-" + this.id + "-open");
        $("html").addClass("zyre-offcanvas-content-reset");
        this.button.addClass("zyre-is-active");
        this._resize();
      },
      close: function close() {
        $("html").removeClass("zyre-offcanvas-content-open");
        $("html").removeClass("zyre-offcanvas-content-" + this.id + "-open");
        setTimeout(
          $.proxy(function () {
            $("html").removeClass("zyre-offcanvas-content-reset");
            $("html").removeClass("zyre-offcanvas-content-" + this.transition);
            $("html").removeClass("zyre-offcanvas-content-" + this.direction);
            $(".zyre-offcanvas-content-" + this.id).removeClass(
              "zyre-offcanvas-content-visible",
            );
          }, this),
          500,
        );
        this.button.removeClass("zyre-is-active");
      },
      closeESC: function closeESC() {
        var self = this;
        if ("" === self.settings.esc_close) {
          return;
        }
        // menu close on ESC key
        $(document).on("keydown", function (e) {
          if (e.keyCode === 27) {
            self.close();
          }
        });
      },
      closeClick: function closeClick() {
        var self = this;
        if (this.toggle_source == "element-id" && this.toggle_id != "") {
          $trigger = "#" + this.toggle_id;
        } else if (
          this.toggle_source == "element-class" &&
          this.toggle_class != ""
        ) {
          $trigger = "." + this.toggle_class;
        } else {
          $trigger = ".zyre-offcanvas-toggle";
        }
        $(document).on("click", function (e) {
          if (
            $(e.target).is(".zyre-offcanvas-content") ||
            $(e.target).parents(".zyre-offcanvas-content").length > 0 ||
            $(e.target).is(".zyre-offcanvas-toggle") ||
            $(e.target).parents(".zyre-offcanvas-toggle").length > 0 ||
            $(e.target).is($trigger) ||
            $(e.target).parents($trigger).length > 0 ||
            !$(e.target).is(".zyre-offcanvas-container")
          ) {
            return;
          } else {
            self.close();
          }
        });
      },
      _resize: function _resize() {
        if (!this.cart_wrap.length) {
          return;
        }
        var off_canvas = $(".zyre-offcanvas-content-" + this.id);
        if (off_canvas && off_canvas.length > 0) {
          if (this.buttons_position === "bottom") {
            var winHeight = window.innerHeight;
            var offset = 0;
            if ($("body").hasClass("admin-bar")) {
              offset = 32;
            }
            winHeight = winHeight - offset;
            off_canvas.find(".zyre-offcanvas-inner").css({
              height: winHeight + "px",
              top: offset,
            });
            headerHeight = off_canvas
              .find(".zyre-offcanvas-cart-header")
              .outerHeight(true);
            wrapHeight = off_canvas.find(".zyre-offcanvas-wrap").outerHeight();
            cartTotalHeight = off_canvas
              .find(".woocommerce-mini-cart__total")
              .outerHeight();
            cartButtonsHeight = off_canvas
              .find(".woocommerce-mini-cart__buttons")
              .outerHeight();
            cartMessageHeight = off_canvas
              .find(".zyre-woo-menu-cart-message")
              .outerHeight();
            itemsHeight =
              winHeight -
              (headerHeight +
                cartTotalHeight +
                cartButtonsHeight +
                cartMessageHeight);
            finalItemsHeight = itemsHeight - (winHeight - wrapHeight);
            finalItemsHeight += "px";
          } else {
            finalItemsHeight = "auto";
          }
          var style = '<style id="zyre-woo-style-' + this.id + '">';
          style +=
            "#" + off_canvas.attr("id") + " .woocommerce-mini-cart.cart_list {";
          style += "height: " + finalItemsHeight;
          style += "}";
          style += "</style>";
          if ($("#zyre-woopack-style-" + this.id).length > 0) {
            $("#zyre-woopack-style-" + this.id).remove();
          }
          $("head").append(style);
        }
      },
    };

    var initOffCanvas = function initOffCanvas($scope, $) {
      var content_wrap = $scope.find(".zyre-offcanvas-content-wrap");
      if ($(content_wrap).length > 0) {
        new OffCanvas($scope);
      }
    };
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/zyre-off-canvas.default",
      initOffCanvas,
    );
  });
})(jQuery);
