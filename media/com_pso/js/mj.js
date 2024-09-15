/* Page Speed Optimizer 1.4.2 | mobilejoomla.com/license.html */
(function ($) {
    'use strict';

    var dependsList = [],
        mjForm;

    function updateDependencies(e) {
        var name = (e && e.target.name) || '';
        for (var i = 0; i < dependsList.length; i++) {
            var el = dependsList[i],
                condition = el.mjDepends;
            if (condition.indexOf(name) >= 0) {
                condition = condition.replace(/\[.*?]/g, function (m) {
                    return '"' + mjForm[m.slice(1, -1)].value + '"';
                });
                $(el).toggleClass('disabled', !eval(condition));
            }
        }
    }

    function updateTextareaStat(el) {
        var count = el.value.length,
            div = el.nextSibling,
            maxlength = parseInt(div.dataset.maxlength, 10);
        div.innerText = count + ' / ' + maxlength;
        div.classList.toggle('mj-textarea-overshoot', count > maxlength);
    }

    var autogrowMaxLines = 7;
    function updateAutogrow(el) {
        el.style.height = 'inherit';
        var styles = window.getComputedStyle(el),
            lineHeight = parseInt(styles.getPropertyValue('line-height'), 10),
            paddingY =
                parseInt(styles.getPropertyValue('padding-top'), 10) +
                parseInt(styles.getPropertyValue('padding-bottom'), 10),
            borderY =
                parseInt(styles.getPropertyValue('border-top-width'), 10) +
                parseInt(styles.getPropertyValue('border-bottom-width'), 10),
            height = Math.min(el.scrollHeight, autogrowMaxLines * lineHeight + paddingY);
        el.style.height = (height + borderY) + 'px';
    }

    $(document).ready(function () {
        [].slice.call(
            document.querySelectorAll('[data-bs-toggle="tooltip"]')
        ).map(function (el) {
            return new bootstrap.Tooltip(el, {container: '#mj'})
        });

        $('#mj .btn-group > label.btn > input[type=radio]').on('change', function () {
            var label = $(this).parent();
            label.parent().find('label').removeClass('active');
            label.addClass('active');
        });

        $('.mj-duration').on('change', function () {
            var $this = $(this);
            try {
                var value = parseFloat($this.find('input[type=number]').val());
                var unit = parseInt($this.find('select').val(), 10);
                $this.find('input[type=hidden]').val(value * unit);
            } catch (e) {
            }
        });

        $('#mj .card-header[data-toggle=collapse] > *').on('click', function (e) {
            e.stopPropagation();
        });

        $('#mj textarea.mj-textarea-maxlength').each(function () {
            updateTextareaStat(this);
        }).on('input', function () {
            updateTextareaStat(this);
        });

        $('#mj textarea.mj-textarea-autogrow').each(function () {
            updateAutogrow(this);
        }).on('input', function () {
            updateAutogrow(this);
        });

        mjForm = document.getElementById('adminForm');
        mjForm.addEventListener('change', updateDependencies);
        $('[data-mj-depends]').each(function () {
            this.mjDepends = '[mj_enabled]==1 && ' + this.getAttribute('data-mj-depends').replace(/\[/g, '[mj_').replace(/\./g, '-');
            dependsList.push(this);
        });
        updateDependencies();
    });
})(jQuery);
