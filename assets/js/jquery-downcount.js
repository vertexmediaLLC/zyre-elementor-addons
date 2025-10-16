(function($) {
    $.fn.downCount = function(options, callback) {
        // Default settings
        var settings = $.extend({
            date: null,
            offset: null,
            text_day: "days",
            text_hour: "hours",
            text_minute: "minutes",
            text_second: "seconds"
        }, options);

        // Validate settings
        if (!settings.date) {
            $.error("Date is not defined.");
        }

        if (!Date.parse(settings.date)) {
            $.error("Incorrect date format. It should look like this: 12/24/2012 12:00:00.");
        }

        // Store reference to the countdown container
        var $this = this;

        // Helper function to get current time with offset
        var getCurrentTime = function() {
            var now = new Date();
            var utc = now.getTime() + (now.getTimezoneOffset() * 60000);
            var localTime = new Date(utc + (3600000 * settings.offset));
            return localTime;
        };

        // Update countdown every second
        var countdown = setInterval(function() {
            var targetDate = new Date(settings.date);
            var currentTime = getCurrentTime();
            var remainingTime = targetDate - currentTime;

            // If countdown is over
            if (remainingTime <= 0) {
                clearInterval(countdown);
                if (typeof callback === "function") {
                    callback();
                }
                return;
            }

            // Time calculations
            var days    = Math.floor(remainingTime / 86400000);
            var hours   = Math.floor((remainingTime % 86400000) / 3600000);
            var minutes = Math.floor((remainingTime % 3600000) / 60000);
            var seconds = Math.floor((remainingTime % 60000) / 1000);

            // Pad values with leading zero if needed
            days    = (days    < 10 ? "0" : "") + days;
            hours   = (hours   < 10 ? "0" : "") + hours;
            minutes = (minutes < 10 ? "0" : "") + minutes;
            seconds = (seconds < 10 ? "0" : "") + seconds;

            // Singular or plural text
            var textDay    = days == 1 ? "day"    : settings.text_day;
            var textHour   = hours == 1 ? "hour"   : settings.text_hour;
            var textMinute = minutes == 1 ? "minute" : settings.text_minute;
            var textSecond = seconds == 1 ? "second" : settings.text_second;

            // Update DOM
            $this.find(".days").text(days);
            $this.find(".hours").text(hours);
            $this.find(".minutes").text(minutes);
            $this.find(".seconds").text(seconds);

            $this.find(".days_ref").text(textDay);
            $this.find(".hours_ref").text(textHour);
            $this.find(".minutes_ref").text(textMinute);
            $this.find(".seconds_ref").text(textSecond);

        }, 1000);
    };
})(jQuery);
