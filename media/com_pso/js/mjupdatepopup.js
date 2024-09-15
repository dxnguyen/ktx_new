/* Page Speed Optimizer 1.4.2 | mobilejoomla.com/license.html */
jQuery(document).ready(function($) {

    var i = 0;
    var errorsFound = false;
    var $item;
    var hash;

    var baseUrl = 'index.php?' + $('form#mj-installer').serialize();

    function mjOnError() {
        errorsFound = true;
        $item.find('.mj-error').removeClass('d-none');
        setTimeout(mjIterateNext);
    }

    function mjTestStatus(textStatus) {
        switch (textStatus) {
            case "success":
            case "notmodified":
                break;
            case "error":
            case "timeout":
            case "abort":
            case "parsererror":
                $item.find('.mj-status').html(mjErrorTexts[textStatus]);
        }
    }

    function mjIterateNext() {
        i++;
        $item = $('#mj-update-' + i);
        if ($item.length === 0) {
            if (!errorsFound) {
                window.parent.location = window.location.href.split('?')[0] + '?option=com_pso';
            } else {
                var $download = $('.mj-downloadurl');
                if ($download.length) {
                    $download.removeClass('d-none')[0].scrollIntoView(false);
                }
            }
            return;
        }
        $item[0].scrollIntoView(false);
        hash = $item.attr('data-hash');
        mjAjaxDownload();
    }

    function mjAjaxDownload() {
        var $progress = $item.find('.mj-download');
        $progress.removeClass('d-none');
        $.ajax({
            dataType: "json",
            url: baseUrl + "&task=download&hash=" + hash,
            success: function (data) {
                if (data.status !== "ok") {
                    $progress.addClass('bg-danger');
                    $item.find('.mj-errors').html(data.errors.join('. '));
                    mjOnError();
                } else {
                    $progress.addClass('bg-success');
                    mjAjaxUnpack();
                }
            },
            error: function () {
                $progress.addClass('bg-danger');
                mjOnError();
            },
            complete: function (jqXHR, textStatus) {
                $progress.removeClass('progress-bar-striped progress-bar-animated');
                mjTestStatus(textStatus);
            }
        });
    }

    function mjAjaxUnpack() {
        var $progress = $item.find('.mj-unpack');
        $progress.removeClass('d-none');
        $.ajax({
            dataType: "json",
            url: baseUrl + "&task=unpack",
            success: function (data) {
                if (data.status !== "ok") {
                    $progress.addClass('bg-danger');
                    $item.find('.mj-errors').html(data.errors.join('. '));
                    mjOnError();
                } else {
                    $progress.addClass('bg-success');
                    mjAjaxInstall();
                }
            },
            error: function () {
                $progress.addClass('bg-danger');
                mjOnError();
            },
            complete: function (jqXHR, textStatus) {
                $progress.removeClass('progress-bar-striped progress-bar-animated');
                mjTestStatus(textStatus);
            }
        });
    }

    function mjAjaxInstall() {
        var $progress = $item.find('.mj-install');
        $progress.removeClass('d-none');
        $.ajax({
            dataType: "json",
            url: baseUrl + "&task=install",
            success: function (data) {
                if (data.status !== "ok") {
                    $progress.addClass('bg-danger');
                    $item.find('.mj-errors').html(data.errors.join('. '));
                    mjOnError();
                } else {
                    $progress.addClass('bg-success');
                    mjIterateNext();
                }
            },
            error: function () {
                $progress.addClass('bg-danger');
                mjOnError();
            },
            complete: function (jqXHR, textStatus) {
                $progress.removeClass('progress-bar-striped progress-bar-animated');
                mjTestStatus(textStatus);
            }
        });
    }

    mjIterateNext();

});