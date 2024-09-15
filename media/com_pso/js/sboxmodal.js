/* Page Speed Optimizer 1.4.2 | mobilejoomla.com/license.html */

/* Based on SqueezeBox for MooTools (http://digitarald.de/project/squeezebox/) */
(function ($) {
    'use strict';

    var $overlay,
        $win,
        $content,
        $close,
        $body,
        root,
        classWindow = '',
        onClose = undefined,
        scrollOffset;

    function initialize(selector) {
        $overlay = $('<div id="sbox-overlay" aria-hidden="true" tabindex="-1" style="z-index:65555;opacity:0.7"></div>');
        $win = $('<div id="sbox-window" role="dialog" aria-hidden="true" class="shadow" style="z-index:65557"></div>');
        $content = $('<div id="sbox-content"></div>');
        $close = $('<a id="sbox-btn-close" href="#" role="button" aria-controls="sbox-window"></a>');
        $body = $('body');
        root = document.documentElement || document.body;

        $win.append($content).append($close);
        $body.append($overlay).append($win);

        $overlay.on('click', close);
        $close.on('click', close);

        $body.delegate(selector, 'click', open);
    }

    function open(e) {
        var $el = $(e.currentTarget);
        var obj = JSON.parse($el.attr('rel'));

        $win.removeClass(classWindow);

        var size = obj.size || {x: 600, y: 450};
        classWindow = obj.classWindow || '';
        var onOpen = obj.onOpen;
        onClose = obj.onClose;

        $win.addClass(classWindow);

        var $iframe = $('<iframe frameborder="0"></iframe>');
        $iframe.attr('src', $el.attr('href'));
        $iframe.attr('width', size.x);
        $iframe.attr('height', size.y);
        $content.empty().append($iframe);

        toggleOverlay(true);

        reposition();

        $(document).on('keydown', onKey).on('mousewheel', checkTarget);
        $(window).on('resize scroll', reposition);

        onOpen && eval(onOpen);

        return false;
    }

    function close() {
        onClose && eval(onClose);

        $content.empty();

        toggleOverlay(false);

        $(document).off('keydown', onKey).off('mousewheel', checkTarget);
        $(window).off('resize scroll', reposition);
    }

    function toggleOverlay(state) {
        var full = root.offsetWidth;
        $overlay.attr('aria-hidden', state ? 'false' : 'true');
        $win.attr('aria-hidden', state ? 'false' : 'true');
        $body.toggleClass('body-overlayed', state);
        if (state) {
            scrollOffset = root.offsetWidth - full;
        } else {
            $body.css('margin-right', '');
        }
    }

    function reposition() {
        var j = parseInt($overlay.css('height'));
        if (root.scrollHeight > j && root.offsetHeight >= j) {
            $overlay.css({
                width: root.scrollWidth + 'px',
                height: root.scrollHeight + 'px'
            });
        }
        $win.css({
            left: Math.round(root.scrollLeft + (window.innerWidth - $win[0].offsetWidth) / 2 - scrollOffset) + 'px',
            top: Math.round(root.scrollTop + (window.innerHeight - $win[0].offsetHeight) / 2) + 'px'
        });
    }

    function onKey(e) {
        switch (e.key) {
            case 'esc':
                close();
                return false;
            case 'up':
            case 'down':
                return false;
        }
    }

    function checkTarget(e) {
        return $content.contains(e.target);
    }

    $(document).ready(function () {
        initialize('a.sboxmodal');
    });

})(jQuery);
