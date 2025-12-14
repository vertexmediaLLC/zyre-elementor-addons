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
    var $filterNav = $scope.find('.zyre-js-filter-tabs'),
      defaultFilter = $filterNav.data('default-filter');
    if ($filterNav.length) {
      $filterNav.on('click.onFilterNav', 'a', function (event) {
        event.stopPropagation();
        var $current = $(this);
        $current.addClass('zyre-filter-tab--active').parent().siblings().find('.zyre-filter-tab--active').removeClass('zyre-filter-tab--active');
        filterFn($current.data('filter'));
      });
      $filterNav.find('[data-filter="' + defaultFilter + '"]').click();
    }
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
              animationData.placeDecimal
            );
            $fun_fact.text(formatted);
          };
        }

        $fun_fact.numerator(animationData);
      });
    };

    // Skill Bar / Progressbar
	var SkillHandler = function SkillHandler($scope) {
      haObserveTarget($scope[0], function () {
		var isRTL = $('html').attr('dir') === 'rtl',
		positionProp = isRTL ? 'right' : 'left';

        $scope.find('.zyre-progress-bar').each(function () {
          var $current = $(this),
			$percent = $current.find('.zyre-progress-percent'),
            percentage = $current.data('percentage'),
            duration = $current.data('duration');

          $current.find('.zyre-progress-fill').animate({
            width: percentage + '%'
          }, duration ?? 1300);
		  $current.find('.zyre-progress-number-mark').animate({
            [positionProp]: percentage + '%'
          }, duration ?? 1300);

          $percent.numerator({
            toValue: percentage + '%',
            duration: duration ?? 1300,
            onStep: function onStep() {
              $percent.append('%');
            }
          });

        });
      });
    };

	// PDF View
	var PDF_View = function PDF_View($scope) {
      var $id = $scope.data('id');
      var $settings = $scope.find(".viewer-" + $id).data('pdf-settings');
      var options = {
        width: $settings.width,
        height: $settings.height,
        page: $settings.page_number,
		pdfOpenParams: {
			toolbar: $settings.toolbar,
		}
      };
	  
      PDFObject.embed($settings.pdf_url, "#" + $settings.unique_id, options);
    };

	// Lottie Animations
	var LottieAnimations = function LottieAnimations($scope) {
		var lottieAnimations = $scope.find('.zyre-lottie-animation'),
			lottieJSON = JSON.parse(lottieAnimations.attr('data-settings'));

		var animation = lottie.loadAnimation({
			container: lottieAnimations[0], // Required
			path: lottieAnimations.attr('data-json-url'), // Required
			renderer: lottieJSON.lottie_renderer, // Required
			loop: 'yes' === lottieJSON.loop ? true : false, // Optional
			autoplay: 'yes' === lottieJSON.autoplay ? true : false
		});

		animation.setSpeed(lottieJSON.speed);

		if( lottieJSON.reverse ) {
			animation.setDirection(-1);
		} 

		animation.addEventListener('DOMLoaded', function () {
			
			if ( 'hover' !== lottieJSON.trigger && 'none' !== lottieJSON.trigger ) {
			
			// if ( 'viewport' === lottieJSON.trigger ) {
				initLottie('load');
				$(window).on('scroll', initLottie);
			}
			
			if ( 'hover' === lottieJSON.trigger ) {
				animation.pause();
				lottieAnimations.hover(function () {
					animation.play();
				}, function () {
					animation.pause();
				});
			}

			function initLottie(event) {
				animation.pause();

				if (typeof lottieAnimations[0].getBoundingClientRect === "function") {
										
					var height = document.documentElement.clientHeight;
					var scrollTop = (lottieAnimations[0].getBoundingClientRect().top)/height * 100;
					var scrollBottom = (lottieAnimations[0].getBoundingClientRect().bottom)/height * 100;
					var scrollEnd = scrollTop < lottieJSON.scroll_end;
					var scrollStart = scrollBottom > lottieJSON.scroll_start;

					if ( 'viewport' === lottieJSON.trigger ) {
						scrollStart && scrollEnd ? animation.play() : animation.pause();
					}
					
					if ( 'scroll' === lottieJSON.trigger ) {
						if( scrollStart && scrollEnd) {
							animation.pause();
							
							// $(window).scroll(function() {
								// calculate the percentage the user has scrolled down the page
								var scrollPercent = 100 * $(window).scrollTop() / ($(document).height() - $(window).height());
								
								var scrollPercentRounded = Math.round(scrollPercent);
						
								animation.goToAndStop( (scrollPercentRounded / 100) * 4000); // why 4000
							// });
						}
					};
				}
			}
		});
	};

	// Navigation Menu
    var ZyreMenu = function ZyreMenu($scope) {
		var navMenu = $scope.find('.zyre-nav-menu');
		var $openIcon = navMenu.find('.zyre-menu-open-icon');
		var $closeIcon = navMenu.find('.zyre-menu-close-icon');
		var humBurgerBtn = navMenu.find('.zyre-menu-toggler');
		var classAttr = navMenu.attr('class');
		var match = classAttr.match(/breakpoint-(-?\d+)/);
		var breakpoint = match ? Math.round(match[1]) : null;

		if(navMenu.length) {
			navMenu.addClass('initialized');
		}
	
		humBurgerBtn.on('click', function (e) {
			var $icon = $(this);
			
			var humberger = $icon.data('humberger');
			var $menu = navMenu.find('ul.menu');
			
			if ('open' == humberger) {
				$openIcon.removeClass('zy-icon-hide');
				$openIcon.addClass('zy-icon-hide');
				$closeIcon.removeClass('zy-icon-hide');
				$menu.slideDown();
			} else {
				$closeIcon.removeClass('zy-icon-hide');
				$closeIcon.addClass('zy-icon-hide');
				$openIcon.removeClass('zy-icon-hide');
				$menu.slideUp();
			}
		});

		function childrenToggle() {
			$scope.addClass('zyre-menu__mobile');
			var subMenuIndicator = navMenu.find('.submenu-indicator');
			subMenuIndicator.off('click').on('click', function () {
				$(this).toggleClass('active');
				var $parentEl = $(this).parent('li.menu-item-has-children');
				if ($parentEl) {
					$parentEl.children('ul.sub-menu').slideToggle();
				}
			});
		}

		if ( '-1' == breakpoint ) {
			childrenToggle();
		} else {
			function burgerClsAdd() {
				if ( breakpoint && jQuery(window).outerWidth() <= breakpoint ) {
					childrenToggle();
				}
				else {
					$scope.removeClass('zyre-menu__mobile');
					navMenu.find('ul.menu').removeAttr('style');
					navMenu.find('ul.sub-menu').css('display', '');
					$closeIcon.addClass('zy-icon-hide');
					$openIcon.removeClass('zy-icon-hide');
				}
			}

			burgerClsAdd();
			$window.on('resize', debounce(burgerClsAdd, 100));
		}
	};

	// Count Down
	var ZyreCountDown = function ZyreCountDown($scope) {
		const $countdown = $scope.find('.zyre-addons-countdown');
		$countdown.each(function () {
			var $this = $(this),
				cdJSON = JSON.parse($this.attr('data-cd-settings'));

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
		var mcForm = $scope.find('.zyre-subscription-form'),
			mcMessage = $scope.find('.zyre-mc-response-message');
		mcForm.on('submit', function (e) {
			e.preventDefault();
			var data = {
				action: 'zyre_mailchimp_ajax',
				security: ZyreLocalize.nonce,
				subscriber_info: mcForm.serialize(),
				list_id: mcForm.data('list-id'),
				post_id: mcForm.data('post-id'),
				widget_id: mcForm.data('widget-id')
			};
			$.ajax({
				type: 'post',
				url: ZyreLocalize.ajax_url,
				data: data,
				success: function success(response) {
					mcForm.trigger('reset');
					
					if (response.status) {
						mcMessage.removeClass('mc-error');
						mcMessage.addClass('mc-success');
						mcMessage.text(response.msg);
					} else {
						mcMessage.addClass('mc-error');
						mcMessage.removeClass('mc-success');
						mcMessage.text(response.msg);
					}
					var hideMsg = setTimeout(function () {
						mcMessage.removeClass('mc-error');
						mcMessage.removeClass('mc-success');
						clearTimeout(hideMsg);
					}, 5000);
				},
				error: function error(_error3) { }
			});
		});
	};

	// Accordion
	var ZyreAccordion = function ZyreAccordion($scope) {
		var $accordion = $scope.find('.zyre-accordion-tab-content'),
			accordionType = $accordion.data('accordion-type'),
			$accordionItems = $scope.find('.zyre-advance-accordion-section'),
			$accordionToggle = $scope.find('.zyre-accordion-toggle');

		// Toggle on click
		$accordionToggle.on('click', function () {
			var $currentItem = $(this).closest('.zyre-advance-accordion-section'),
				$currentItemContent = $currentItem.find('.zyre-accordion-contents');
			
			// Hide current Item
			if ($currentItem.hasClass('active')) {
				$currentItemContent.slideUp(function() {
					$currentItem.removeClass('active');
				});
			} else {
				// Close all others
				if ( 'accordion' === accordionType ) {
					$accordionItems.each(function () {
						var $eachItem = $(this);
						if ($eachItem.hasClass('active')) {
							$eachItem.find('.zyre-accordion-contents').slideUp(function() {
								$eachItem.removeClass('active');
							});
						}
					});
				}

				// Show current Item
				$currentItemContent.slideDown();
				$currentItem.addClass('active');
			}
		});
	};

	// Swiper Carousel Settings
	class ZyreCarousel extends elementorModules.frontend.handlers.CarouselBase {
		getDefaultSettings() {
			const settings = super.getDefaultSettings();

			settings.selectors.carousel = '.zyre-carousel-wrapper';

			return settings;
		}

		getSwiperSettings() {
			const baseSettings = super.getSwiperSettings(),
				settings = this.getElementSettings(),
				elementorBreakpoints = elementorFrontend.config.responsive.activeBreakpoints;

			baseSettings.slidesPerView = +settings.slides_per_view || baseSettings.slidesPerView;
			baseSettings.speed = settings.speed || baseSettings.speed;
			baseSettings.loop = 'yes' === settings.loop;

			const isSingleSlide = 1 === baseSettings.slidesPerView,
				defaultSlidesToShowMap = {
					mobile: 1,
					tablet: isSingleSlide ? 1 : 2,
				};

			// Breakpoints
			baseSettings.breakpoints = {};

			let lastBreakpointSlidesToShowValue = baseSettings.slidesPerView;

			Object.keys(elementorBreakpoints).reverse().forEach((breakpointName) => {
				// Tablet has a specific default `slides_to_show`.
				const defaultSlidesToShow = defaultSlidesToShowMap[breakpointName] ? defaultSlidesToShowMap[breakpointName] : lastBreakpointSlidesToShowValue;

				baseSettings.breakpoints[elementorBreakpoints[breakpointName].value] = {
					slidesPerView: +settings['slides_per_view_' + breakpointName] || defaultSlidesToShow,
					slidesPerGroup: +settings['slides_to_scroll_' + breakpointName] || 1,
				};

				lastBreakpointSlidesToShowValue = +settings['slides_per_view_' + breakpointName] || defaultSlidesToShow;
			});

			// Autoplay
			baseSettings.autoplay = 'yes' === settings.autoplay ? {
				delay: +settings.autoplay_speed,
				disableOnInteraction: 'yes' === settings.pause_on_interaction,
				pauseOnMouseEnter: 'yes' === settings.pause_on_hover,
			} : false;

			// Effect
			if (isSingleSlide) {
				baseSettings.effect = settings.effect ?? 'slide';

				if ('fade' === settings.effect) {
					baseSettings.fadeEffect = { crossFade: true };
				}
			} else {
				baseSettings.slidesPerGroup = +settings.slides_to_scroll || 1;
			}

			// Arrows & Navigation
			const showArrows = 'arrows' === settings.navigation || 'both' === settings.navigation,
				showPagination = 'dots' === settings.navigation || 'both' === settings.navigation || settings.pagination;

			if (baseSettings.pagination && showPagination) {
				baseSettings.pagination.type = settings.pagination || 'bullets';
			}

			if (baseSettings.navigation && showArrows) {
				baseSettings.navigation = {
					prevEl: '.zyre-swiper-button-prev',
					nextEl: '.zyre-swiper-button-next',
				};
			}

			// Lazyload
			if (settings.lazyload && 'yes' === settings.lazyload) {
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
		'frontend/element_ready/zyre-image-carousel.default',
		($scope) => {
			new ZyreCarousel({ $element: $scope });
		}
	);

	// Logo Carousel
	elementorFrontend.hooks.addAction(
		'frontend/element_ready/zyre-logo-carousel.default',
		($scope) => {
			new ZyreCarousel({ $element: $scope });
		}
	);

	// News Ticker
	elementorFrontend.hooks.addAction(
		'frontend/element_ready/zyre-news-ticker.default',
		($scope) => {
			new ZyreCarousel({ $element: $scope });
		}
	);

	// Contact Form 7
	var ZyreCF7 = function ZyreCF7($scope) {
		const $textarea = $scope.find('.wpcf7-textarea');
		$textarea.each(function () {
			var $this = $(this),
				prevHeight = getComputedStyle(this).getPropertyValue('height');

			$this.on('input', function () {
				if(!$this.val().trim()) {
					$this.css('height', prevHeight);
					return;
				}

				if( this.scrollHeight >= parseFloat(prevHeight) ) {
					$this.css('height', this.scrollHeight + 'px');
				}
			});
		});
	};

	// Image Grid
	var ImageGrid = ModuleHandler.extend({
		onInit: function onInit() {
			ModuleHandler.prototype.onInit.apply(this, arguments);
			this.run();
			this.runFilter();
			$window.on('resize', debounce(this.run.bind(this), 100));
		},
		getLayoutMode: function getLayoutMode() {
			// var layout = this.getElementSettings('layout');
			// return layout === 'even' ? 'masonry' : layout;
		},
		getDefaultSettings: function getDefaultSettings() {
			return {
				itemSelector: '.zyre-image-grid-item',
				// layoutMode: this.getLayoutMode(),
				masonry: {
					columnWidth: 1,
				},
			};
		},
		getDefaultElements: function getDefaultElements() {
			return {
				$container: this.findElement('.zyre-isotope')
			};
		},
		runFilter: function runFilter() {
			var self = this;
			initFilterNav(this.$element, function (filter) {
				self.elements.$container.isotope({
					filter: filter
				});
			});
		},
		onElementChange: function onElementChange(changedProp) {
			if (['item_height', 'item_padding', 'item_title_margin', 'item_category_margin', 'item_description_margin', 'items_wrap_margin', 'image_height', 'columns', 'columns_tablet', 'columns_mobile', 'filter_tabs_show', 'enable_lightbox'].indexOf(changedProp) !== -1) {
				this.run();
			}
		},
		run: function run() {
			var self = this;
			self.elements.$container.isotope(self.getDefaultSettings()).imagesLoaded().progress(function () {
				self.elements.$container.isotope('layout');
			});
		}
	});

    // Function Handlers
    var fnHanlders = {
      "zyre-toggle.default": Toggle_Switcher,
      "zyre-team-member.default": Team_Member,
      "zyre-fun-fact.default": FunFact,
      "zyre-skill-bar.default": SkillHandler,
      "zyre-pdf-view.default": PDF_View,
      "zyre-lottie-animation.default": LottieAnimations,
      "zyre-menu.default": ZyreMenu,
      "zyre-countdown.default": ZyreCountDown,
	  "zyre-subscription-form.default": ZyreMailChimp,
	  "zyre-advance-accordion.default": ZyreAccordion,
	  "zyre-advance-toggle.default": ZyreAccordion,
	  "zyre-cf7.default": ZyreCF7,
    };
    $.each(fnHanlders, function (widgetName, handlerFn) {
      elementorFrontend.hooks.addAction(
        "frontend/element_ready/" + widgetName,
        handlerFn
      );
    });

	var classHandlers = {
		"zyre-image-grid.default": ImageGrid,
	};
	$.each(classHandlers, function (widgetName, handlerClass) {
		elementorFrontend.hooks.addAction("frontend/element_ready/" + widgetName, function ($scope) {
			elementorFrontend.elementsHandler.addHandler(handlerClass, {
				$element: $scope,
			});
		});
	});
  });
})(jQuery);