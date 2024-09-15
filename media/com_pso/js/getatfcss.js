/* Page Speed Optimizer 1.4.2 | mobilejoomla.com/license.html */
(function () {
    'use strict';

    var modalAtfCss;

    function updateATFExternal(url, callback) {
        jQuery.ajax({
            type: 'POST',
            url: 'https://api.mobilejoomla.com/getatfcss',
            data: {
                url: url,
                apikey: mj_apikey
            },
            success: function (content) {
                callback(content);
            },
            error: function () {
                callback(null);
            },
            cache: false
        });
    }

    function updateATFInternal(url, callback) {
        getATFCSS(url, function (content) {
            callback(content);
        });
    }

    function getAtfCssMode(url, local, callback) {
        if (local) {
            updateATFInternal(url, callback);
        } else {
            updateATFExternal(url, callback);
        }
    }

    window.runAtfCssModal = function (device) {
        document.getElementById('getatfcss-animation').classList.remove('d-none');
        document.getElementById('getatfcss-error').classList.add('d-none');
        document.getElementById('getatfcss-table').classList.add('d-none');
        document.querySelector('#getatfcssmodal .modal-footer').classList.add('d-none');

        modalAtfCss.show();

        var url = location.href.replace(/\/administrator\/index\.php.*$/, '/');
        url += '?pso=no';
        if (device) {
            url += '&device=' + device;
        }

        var local_node = document.querySelector('input[name=mj_css_atflocal]:checked');
        var local = (local_node && local_node.value === '0') ? false : true;

        getAtfCssMode(url, local, function (result) {
            document.getElementById('getatfcss-animation').classList.add('d-none');
            if (result === null) {
                document.getElementById('getatfcss-error').classList.remove('d-none');
            } else {
                var list;

                list = document.getElementById('form_getatfcss_css');
                list.value = result;

                document.getElementById('getatfcss-table').classList.remove('d-none');
                document.querySelector('#getatfcssmodal .modal-footer').classList.remove('d-none');
            }

            modalAtfCss.handleUpdate();
        });
    };

    window.clearAtfCss = function () {
        document.querySelector('textarea[name=mj_css_atfcss]').value = '';
    };

    function applyAtfCss() {
        var textarea_atfcss = document.querySelector('textarea[name=mj_css_atfcss]'),
            styles = document.querySelector('#form_getatfcss_css').value.trim();
        textarea_atfcss.value = styles;
        modalAtfCss.hide();
    }

    addEventListener('DOMContentLoaded', function () {
        var modal = document.getElementById('getatfcssmodal');
        //document.body.appendChild(modal);
        modalAtfCss = new bootstrap.Modal(modal);

        document.getElementById('getatfcss_apply').addEventListener('click', applyAtfCss);
    });
})();
