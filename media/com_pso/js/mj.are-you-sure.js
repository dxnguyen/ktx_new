/* Page Speed Optimizer 1.4.2 | mobilejoomla.com/license.html */
jQuery.propHooks.checked = {
    set: function (elem, value, name) {
        var ret = (elem[name] = value);
        jQuery(elem).trigger("change");
        return ret;
    }
};
jQuery(document).ready(function () {
    var form = document.getElementById("adminForm"),
        prevOnsubmit = form.onsubmit;
    form.onsubmit = function (e) {
        jQuery(this).removeClass("dirty");
        if (prevOnsubmit) {
            prevOnsubmit.call(this, e);
        }
    };
    jQuery("#adminForm").areYouSure({fieldSelector: "input:not(input[type=submit]):not(input[type=button]),select"});
});