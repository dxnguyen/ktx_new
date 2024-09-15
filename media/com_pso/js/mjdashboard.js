/* Page Speed Optimizer 1.4.2 | mobilejoomla.com/license.html */
(function () {
    'use strict';

    function updatePSIScore(score, el) {
        var $el = jQuery(el);

        if (score === '') {
            $el.removeClass('progress-bar-striped progress-bar-animated')
                .addClass('bg-light');
            return;
        }

        el.innerHTML = score;

        $el.removeClass('progress-bar-striped progress-bar-animated w-100')
            .css({'width': score + '%'});

        if (score < 50) {
            $el.addClass('bg-danger');
        } else if (score < 90) {
            $el.addClass('bg-warning text-dark');
        } else {
            $el.addClass('bg-success');
        }
    }

    var waitAJAX = [];

    jQuery(document).ready(function () {

        var ajaxurl = 'index.php?option=com_pso&controller=ajax&format=raw',
            $form = jQuery('#mj_ajax'),
            $task = jQuery('#mj_ajax input[name=task]');

        jQuery('#mj_show_anonymous_stats').on('click', function () {
            var $btn = jQuery(this);
            $btn.attr('disabled', 'disabled');
            jQuery.get(ajaxurl, {view: 'anonymous_stats'}, function (response) {
                $btn.removeAttr('disabled');
                jQuery('#mj_anonymous_stats_modal textarea').text(response);
                bootstrap.Modal.getOrCreateInstance(document.getElementById('mj_anonymous_stats_modal')).show();
            });
        });

        function updateCachesize(type) {
            jQuery('#mj_cachesize_' + type + '_size').text('');
            jQuery('#mj_cachesize_' + type + '_size2').text('');
            jQuery('#mj_cachesize_' + type + '_size3').text('');
            jQuery('#mj_cachesize_' + type + '_files').text('');
            return jQuery.get(ajaxurl, {view: 'cachesize_' + type}, function (response) {
                jQuery('#mj_cachesize_' + type + '_size').text(response.size);
                jQuery('#mj_cachesize_' + type + '_size2').text(response.size2);
                jQuery('#mj_cachesize_' + type + '_size3').text(response.size3);
                jQuery('#mj_cachesize_' + type + '_files').text(response.files);
            });
        }

        function doClear(btn, task, updates) {
            var $btn = jQuery(btn);
            $btn.attr('disabled', 'disabled');
            $task.val(task);
            jQuery.post(ajaxurl, $form.serialize(), function () {
                $btn.removeAttr('disabled');
                updates.forEach(update => { updateCachesize(update) });
            });
        }

        jQuery('#do_clear_images').on('click', function () {
            if (confirm('Are you sure?')) {
                doClear(this, 'clear_images', ['image']);
            }
        });
        jQuery('#do_clear_imagesrescaled').on('click', function () {
            if (confirm('Are you sure?')) {
                doClear(this, 'clear_imagesrescaled', ['imagerescaled']);
            }
        });
        jQuery('#do_clear_imageslqip').on('click', function () {
            if (confirm('Are you sure?')) {
                doClear(this, 'clear_imageslqip', ['imagelqip']);
            }
        });
        jQuery('#do_clear_cache_expired').on('click', function () {
            doClear(this, 'clear_cache_expired', ['static', 'ress']);
        });
        jQuery('#do_clear_cache_all').on('click', function () {
            if (confirm('Are you sure?')) {
                doClear(this, 'clear_cache_all', ['static', 'ress']);
            }
        });
        jQuery('#do_clear_queue_all').on('click', function () {
            if (confirm('Are you sure?')) {
                doClear(this, 'clear_queue_all', ['queue']);
            }
        });
        jQuery('#do_clear_pagecache_expired').on('click', function () {
            doClear(this, 'clear_pagecache_expired', ['page']);
        });
        jQuery('#do_clear_pagecache_all').on('click', function () {
            if (confirm('Are you sure?')) {
                doClear(this, 'clear_pagecache_all', ['page']);
            }
        });

        waitAJAX = [
            updateCachesize('image'),
            updateCachesize('imagerescaled'),
            updateCachesize('imagelqip'),
            updateCachesize('static'),
            updateCachesize('ress'),
            updateCachesize('queue'),
        ];
        if (document.getElementById('do_clear_pagecache_all')) {
            waitAJAX.push(
                updateCachesize('page')
            );
        }
    });

    jQuery(window).on('load', function () {
        var pagespeed_api = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed',
            url = location.href.split('/').slice(0, -2).join('/') + '/',
            psi_desktop_score = '',
            psi_mobile_score = '';

        jQuery.when.apply(jQuery, waitAJAX).always(function () {
            jQuery.get(pagespeed_api, {strategy: 'desktop', url: url}).done(function (response) {
                try {
                    psi_desktop_score = Math.round(100 * response.lighthouseResult.categories.performance.score);
                } catch (e) {
                    console.log(e);
                }
            }).always(function () {
                updatePSIScore(psi_desktop_score, document.getElementById('psi_desktop'));
                jQuery.get(pagespeed_api, {strategy: 'mobile', url: url}).done(function (response) {
                    try {
                        psi_mobile_score = Math.round(100 * response.lighthouseResult.categories.performance.score);
                    } catch (e) {
                        console.log(e);
                    }
                }).always(function () {
                    updatePSIScore(psi_mobile_score, document.getElementById('psi_mobile'));
                });
            });
        });

        waitAJAX = [];
    });
})();