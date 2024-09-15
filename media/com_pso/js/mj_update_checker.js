/* Page Speed Optimizer 1.4.2 | mobilejoomla.com/license.html */
jQuery(document).ready(function ($) {
    'use strict';

    var query = $.param({v: mj_updater.v, j: mj_updater.j});
    $('#mjmsgarea').load('https://api.mobilejoomla.com/msg_pso.html?' + query);

    $.ajax({
        url: 'index.php?option=com_pso&controller=ajax&task=check_updates&format=raw',
        success: function (response) {
            var list = [];
            for (var i=0; i<response.updates.length; i++) {
                var update = response.updates[i];
                list.push(update.title + ' <span class="badge bg-danger">' + update.version + '</span>');
                $('#mj-update-' + update.hash)
                    .addClass('mj-update-available')
                    .children('.badge').text(update.version);
            }
            $('.mj-update-loading').removeClass('mj-update-loading');

            $('#mjlatestver').text(response.latest).addClass(list.length ? 'text-danger fw-bold' : '');

            if (list.length) {
                $('.mj-update-button').removeClass('disabled');
                if (mj_updater.text !== undefined) {
                    list = '<span class="fw-bold text-danger"><span class="text-nowrap">'
                        + list.join('</span>, <span class="text-nowrap">')
                        + '</span></span>';
                    $('#mjupdatearea').append(
                        '<div class="alert alert-warning alert-dismissible fade show mt-n1">'
                        + '<div class="d-flex align-items-center"><div class="text-nowrap">'
                        + '<a href="index.php?option=com_pso&controller=update&view=update&tmpl=component"'
                        + ' class="btn btn-info fw-bold sboxmodal me-3" rel=\'{"size":{"x":480,"y":320}}\'>'
                        + mj_updater.text_btn
                        + '</a></div><div class="flex-grow-1">' + mj_updater.text.replace('%s', list) + '</div></div>'
                        + '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>'
                        + '</div>'
                    );
                }
            }
        },
        error: function () {
            $('.mj-update-loading').removeClass('mj-update-loading').addClass('mj-update-error');
        }
    });

});
