/* Page Speed Optimizer 1.4.2 | mobilejoomla.com/license.html */
(function ($) {
    'use strict';
    $(document).ready(function () {
        var $banner = $("#mjprobanner"),
            mj = document.getElementById("mj"),
            timerID = 0;
        function showBanner(el) {
            if (timerID) {
                clearTimeout(timerID);
                timerID = 0;
            }
            if (el != null) {
                var calc = el.currentTarget.getBoundingClientRect(),
                    calc_mj = mj.getBoundingClientRect();
                $banner.css({
                    left: Math.ceil(calc.left - calc_mj.left + 3),
                    bottom: Math.ceil(calc_mj.bottom - calc.top + 5)
                });
            }
            $banner.css("display", "block");
        }

        function hideBanner() {
            if (timerID) {
                return;
            }
            timerID = setTimeout(function () {
                timerID = 0;
                $banner.css("display", "none");
            }, 300);
        }

        $(".mjpro")
            .on("mouseenter", showBanner)
            .on("mouseleave", hideBanner);
        $banner
            .on("mouseenter", function () {
                showBanner(null);
            })
            .on("mouseleave", hideBanner)
            .load("https://api.mobilejoomla.com/psopro.html");
    });
})(jQuery);
