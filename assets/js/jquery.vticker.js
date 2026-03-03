
/*
  Vertical News Ticker 1.21

  Original by: Tadas Juozapaitis ( kasp3rito [eta] gmail (dot) com )
               https://github.com/kasp3r/vTicker

  Forked/Modified by: Richard Hollis @richhollis - richhollis.co.uk
 */
(function ($) {

    var defaults = {
        speed: 700,
        pause: 4000,
        showItems: 1,
        mousePause: true,
        height: 0,
        animate: true,
        margin: 0,
        padding: 0,
        startPaused: false,
        autoAppend: true
    };

    var internal = {

        moveUp: function (state, options) {
            return internal.showNextItem(state, options, "up");
        },

        moveDown: function (state, options) {
            return internal.showNextItem(state, options, "down");
        },

        nextItemState: function (state, direction) {

            var ul = state.element.children("ul"),
                itemHeight = state.itemHeight;

            if (state.options.height > 0) {
                itemHeight = ul.children("li:first").height();
            }

            return {
                height: itemHeight + state.options.margin + (2 * state.options.padding),
                options: state.options,
                el: state.element,
                obj: ul,
                selector: direction === "up" ? "li:first" : "li:last",
                dir: direction
            };
        },

        showNextItem: function (state, options, direction) {

            var data = internal.nextItemState(state, direction);
            data.el.trigger("vticker.beforeTick");

            var item = data.obj.children(data.selector).clone(true);

            if (data.dir === "down") {
                data.obj.css("top", "-" + data.height + "px").prepend(item);
            }

            if (options && options.animate) {
                if (!state.animating) {
                    internal.animateNextItem(data, state);
                }
            } else {
                internal.nonAnimatedNextItem(data);
            }

            if (data.dir === "up" && state.options.autoAppend) {
                item.appendTo(data.obj);
            }

            data.el.trigger("vticker.afterTick");
        },

        animateNextItem: function (data, state) {

            state.animating = true;

            data.obj.animate(
                data.dir === "up"
                    ? { top: "-=" + data.height + "px" }
                    : { top: 0 },
                state.options.speed,
                function () {
                    $(data.obj).children(data.selector).remove();
                    $(data.obj).css("top", "0px");
                    state.animating = false;
                }
            );
        },

        nonAnimatedNextItem: function (data) {
            data.obj.children(data.selector).remove();
            data.obj.css("top", "0px");
        },

        nextUsePause: function () {
            var state = $(this).data("state"),
                options = state.options;

            if (!state.isPaused && !internal.hasSingleItem(state)) {
                methods.next.call(this, { animate: options.animate });
            }
        },

        startInterval: function () {
            var self = this,
                state = $(this).data("state"),
                options = state.options;

            state.intervalId = setInterval(function () {
                internal.nextUsePause.call(self);
            }, options.pause);
        },

        stopInterval: function () {
            var state = $(this).data("state");

            if (state && state.intervalId) {
                clearInterval(state.intervalId);
                state.intervalId = undefined;
            }
        },

        restartInterval: function () {
            internal.stopInterval.call(this);
            internal.startInterval.call(this);
        },

        getState: function (method, element) {
            var state = $(element).data("state");
            if (state) return state;
            throw Error("vTicker: No state available from " + method);
        },

        hasMultipleItems: function (state) {
            return state.itemCount > 1;
        },

        hasSingleItem: function (state) {
            return !internal.hasMultipleItems(state);
        },

        isAnimatingOrSingleItem: function (state) {
            return state.animating || internal.hasSingleItem(state);
        },

        bindMousePausing: function (el, state) {

            el.bind("mouseenter", function () {
                if (!state.isPaused) {
                    state.pausedByCode = true;
                    internal.stopInterval.call(this);
                    methods.pause.call(this, true);
                }
            });

            el.bind("mouseleave", function () {
                if (!state.isPaused || state.pausedByCode) {
                    state.pausedByCode = false;
                    methods.pause.call(this, false);
                    internal.startInterval.call(this);
                }
            });
        },

        setItemLayout: function (el, state, options) {

            el.css({
                overflow: "hidden",
                position: "relative"
            })
            .children("ul")
            .css({
                position: "relative",
                margin: 0,
                padding: 0
            })
            .children("li")
            .css({
                margin: options.margin,
                padding: options.padding
            });

            if (isNaN(options.height) || options.height === 0) {

                el.children("ul").children("li").each(function () {
                    if ($(this).height() > state.itemHeight) {
                        state.itemHeight = $(this).height();
                    }
                });

                el.children("ul").children("li").each(function () {
                    $(this).height(state.itemHeight);
                });

                var total = options.margin + (2 * options.padding);
                el.height((state.itemHeight + total) * options.showItems + options.margin);

            } else {
                el.height(options.height);
            }
        },

        defaultStateAttribs: function (el, options) {
            return {
                itemCount: el.children("ul").children("li").length,
                itemHeight: 0,
                itemMargin: 0,
                element: el,
                animating: false,
                options: options,
                isPaused: options.startPaused,
                pausedByCode: false
            };
        }
    };

    var methods = {

        init: function (options) {

            if ($(this).data("state")) {
                methods.stop.call(this);
            }

            var opts = $.extend({}, defaults);
            options = $.extend(opts, options);

            var el = $(this),
                state = internal.defaultStateAttribs(el, options);

            $(this).data("state", state);

            internal.setItemLayout(el, state, options);

            if (!options.startPaused) {
                internal.startInterval.call(this);
            }

            if (options.mousePause) {
                internal.bindMousePausing(el, state);
            }
        },

        pause: function (pause) {
            var state = internal.getState("pause", this);

            if (!internal.hasMultipleItems(state)) return false;

            state.isPaused = pause;

            if (pause) {
                $(this).addClass("paused");
                state.element.trigger("vticker.pause");
            } else {
                $(this).removeClass("paused");
                state.element.trigger("vticker.resume");
            }
        },

        next: function (options) {
            var state = internal.getState("next", this);

            if (!internal.isAnimatingOrSingleItem(state)) {
                internal.restartInterval.call(this);
                internal.moveUp(state, options);
            }
        },

        prev: function (options) {
            var state = internal.getState("prev", this);

            if (!internal.isAnimatingOrSingleItem(state)) {
                internal.restartInterval.call(this);
                internal.moveDown(state, options);
            }
        },

        stop: function () {
            internal.getState("stop", this);
            internal.stopInterval.call(this);
        },

        remove: function () {
            var state = internal.getState("remove", this);
            internal.stopInterval.call(this);
            var el = state.element;
            el.unbind();
            el.remove();
        }
    };

    $.fn.vTicker = function (method) {

        if (methods[method]) {
            return methods[method].apply(
                this,
                Array.prototype.slice.call(arguments, 1)
            );
        } else if (typeof method === "object" || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error("Method " + method + " does not exist on jQuery.vTicker");
        }
    };

})(jQuery);