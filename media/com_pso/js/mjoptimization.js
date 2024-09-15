/* Page Speed Optimizer 1.4.2 | mobilejoomla.com/license.html */
(function () {
    'use strict';

    jQuery(document).ready(function () {
        jQuery('#mj_exclude_js').on('change', 'input[type=checkbox]', function () {
            updateExcludeList(this, '#mj_config_js_rules_merge_exclude', 'src');
        });

        jQuery('#mj_exclude_css').on('change', 'input[type=checkbox]', function () {
            updateExcludeList(this, '#mj_config_css_rules_merge_exclude', 'href');
        });
    });

    function updateExcludeList(checkbox, target, attr) {
        var url = jQuery.trim(jQuery(checkbox).closest('tr').children(':first').text()),
            $el = jQuery(target),
            list = jQuery.trim($el.val()).split('\n'),
            index = -1,
            rule = attr + '*=' + url;
        for (var i = 0; i < list.length; i++) {
            if (list[i] === rule) {
                index = i;
                break;
            }
        }
        if (checkbox.checked) {
            if (index === -1) {
                list.push(rule);
            }
        } else {
            if (index > -1) {
                list.splice(index, 1);
            }
        }
        $el.val(jQuery.trim(list.join('\n'))).trigger('change');
    }
})();