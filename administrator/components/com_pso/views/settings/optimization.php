<?php
/**
 * Page Speed Optimizer extension
 * https://www.mobilejoomla.com/
 *
 * @version    1.4.2
 * @license    GNU/GPL v2 - http://www.gnu.org/licenses/gpl-2.0.html
 * @copyright  (C) 2022-2024 Denis Ryabov
 * @date       June 2024
 */
defined('_JEXEC') or die('Restricted access');

/** @var MjController $this */
/** @var array $params */
/** @var string $controllerName */
/** @var string $viewName */

echo $this->renderView('global/header');

MJToolbarHelper::apply();
MJToolbarHelper::cancel();

// populate $settings array
include_once JPATH_COMPONENT . '/models/settings.php';
$settings = new MjSettingsModel($this->joomlaWrapper);

$lists = array();

$enable_apache = true;
$enable_apachephp = true;
/*
if (function_exists('apache_get_modules')) {
    $enable_apache = false;
    $enable_apachephp = false;
    $apache_modules = apache_get_modules();
    if (in_array('mod_rewrite', $apache_modules, true)) {
        $enable_apachephp = true;
        if (in_array('mod_headers', $apache_modules, true)
            && in_array('mod_mime', $apache_modules, true)
            && in_array('mod_expires', $apache_modules, true)
        ) {
            $enable_apache = true;
        }
    }
}
*/

$lists['ress_async'] = array(
    'sync' => MJText::_('COM_PSO__RESS_OPTIMIZE_ASYNC__SYNC'),
    'ajax' => MJText::_('COM_PSO__RESS_OPTIMIZE_ASYNC__AJAX'),
    'cron' => MJText::_('COM_PSO__RESS_OPTIMIZE_ASYNC__CRON')
);

$lists['distribmode'] = array(
    '' => MJText::_('COM_PSO__DISTRIBMODE__DEFAULT'),
    ($enable_apache ? '' : '-') . 'apache' => MJText::_('COM_PSO__DISTRIBMODE__APACHE'),
    ($enable_apachephp ? '' : '-') . 'apachephp' => MJText::_('COM_PSO__DISTRIBMODE__APACHEPHP'),
    'php' => MJText::_('COM_PSO__DISTRIBMODE__PHP')
);

$lists['atf_type'] = array(
    '0' => MJText::_('COM_PSO__CSS_ATFTYPE_EXTERNAL'),
    '1' => MJText::_('COM_PSO__CSS_ATFTYPE_LOCAL')
);

$lists['lazyload_method'] = array(
    'none' => MJText::_('COM_PSO__LAZYLOAD_DISABLED'),
    'native' => MJText::_('COM_PSO__LAZYLOAD_NATIVE'),
    'js' => MJText::_('COM_PSO__LAZYLOAD_JS')
);

$lists['lazyload_noscript'] = array(
    'before' => MJText::_('COM_PSO__LAZYLOAD_NOSCRIPT_BEFORE'),
    'after' => MJText::_('COM_PSO__LAZYLOAD_NOSCRIPT_AFTER'),
    'none' => MJText::_('COM_PSO__LAZYLOAD_NOSCRIPT_NONE')
);

$lists['font_display'] = array(
    'none' => MJText::_('COM_PSO__FONT_DISPLAY__NONE'),
    'auto' => MJText::_('COM_PSO__FONT_DISPLAY__AUTO'),
    'block' => MJText::_('COM_PSO__FONT_DISPLAY__BLOCK'),
    'swap' => MJText::_('COM_PSO__FONT_DISPLAY__SWAP'),
    'fallback' => MJText::_('COM_PSO__FONT_DISPLAY__FALLBACK'),
    'optional' => MJText::_('COM_PSO__FONT_DISPLAY__OPTIONAL'),
);

$form = array(
    //left
    array(
        'COM_PSO__RESS' => array(
            MjUI::prepare('onoff', $settings, 'ress_optimize', 'COM_PSO__RESS_OPTIMIZE_ENABLED'),
            MjUI::proprepare('input', 'cdndomain', 'COM_PSO__CDN_DOMAIN'),
            MjUI::prepare('nswitch', $settings, array('ress_async', '[ress_optimize]==1'), 'COM_PSO__RESS_OPTIMIZE_ASYNC_ENABLED', $lists['ress_async']),
            MjUI::prepare('numberinput', $settings, array('ress_async_max', '[ress_optimize]==1 && [ress_async]!="sync"'), 'COM_PSO__RESS_OPTIMIZE_ASYNC_MAX', false, 1),
            MjUI::prepare('duration', $settings, array('ress_async_maxtime', '[ress_optimize]==1 && [ress_async]!="sync"'), 'COM_PSO__RESS_OPTIMIZE_ASYNC_MAXTIME'),
            MjUI::prepare('numberinput', $settings, array('ress_async_memlimit', '[ress_optimize]==1 && [ress_async]!="sync"'), 'COM_PSO__RESS_OPTIMIZE_ASYNC_MEMLIMIT', 'MB'),
        ),
        'COM_PSO__SERVER' => array(
            MjUI::prepare('select', $settings, array('distribmode', '[ress_optimize]==1'), 'COM_PSO__DISTRIBUTE_USING', $lists['distribmode']),
            MjUI::prepare('onoff', $settings, array('htaccess_gzip', '[ress_optimize]==1'), 'COM_PSO__HTACCESS_GZIP'),
            MjUI::prepare('onoff', $settings, array('htaccess_caching', '[ress_optimize]==1'), 'COM_PSO__HTACCESS_CACHING'),
        ),
        'COM_PSO__CACHING' => array(
            MjUI::prepare('duration', $settings, array('ress_caching_ttl', '[ress_optimize]==1'), 'COM_PSO__CACHINGTTL'),
            MjUI::prepare('onoff', $settings, array('httpcaching', '[ress_optimize]==1'), 'COM_PSO__BROWSER_CACHING'),
            MjUI::prepare('duration', $settings, array('httpcachingttl', '[ress_optimize]==1 && [httpcaching]==1'), 'COM_PSO__BROWSER_CACHINGTTL'),
        ),
        'COM_PSO__DNSPREFETCH' => array(
            MjUI::prepare('onoff', $settings, array('html_dnsprefetch', '[ress_optimize]==1'), 'COM_PSO__HTML_DNSPREFETCH_ENABLED'),
            MjUI::prepare('onoff', $settings, array('html_dnsprefetch_link', '[ress_optimize]==1 && [html_dnsprefetch]==1'), 'COM_PSO__HTML_DNSPREFETCH_LINK_HEADERS'),
            array(
                'id' => 'dnsprefetch_suggestions',
                'depends' => '[ress_optimize]==1 && [html_dnsprefetch]==1',
                'input' =>
                    '<div class="mjpro">' .
                    '<input type="button" onclick="return false;" value="' . MJText::_('COM_PSO__HTML_DNSPREFETCH_SUGGESTIONS') . '" class="btn btn-primary me-3"/>' .
                    '<input type="button" onclick="return false;" value="' . MJText::_('COM_PSO__HTML_DNSPREFETCH_CLEAR_LISTS') . '" class="btn btn-secondary"/>' .
                    '</div>'
            ),
            MjUI::prepare('textarea', $settings, array('html_dnsprefetch_domains', '[ress_optimize]==1 && [html_dnsprefetch]==1'), 'COM_PSO__HTML_DNSPREFETCH_DOMAINS', array('maxlength' => 16350)),
        ),
        'COM_PSO__PRECONNECT' => array(
            MjUI::prepare('onoff', $settings, array('html_preconnect', '[ress_optimize]==1'), 'COM_PSO__HTML_PRECONNECT_ENABLED'),
            MjUI::prepare('onoff', $settings, array('html_preconnect_link', '[ress_optimize]==1 && [html_preconnect]==1'), 'COM_PSO__HTML_PRECONNECT_LINK_HEADERS'),
            array(
                'id' => 'preconnect_suggestions',
                'depends' => '[ress_optimize]==1 && [html_preconnect]==1',
                'input' =>
                    '<div class="mjpro">' .
                    '<input type="button" onclick="return false;" value="' . MJText::_('COM_PSO__HTML_PRECONNECT_SUGGESTIONS') . '" class="btn btn-primary me-3"/>' .
                    '<input type="button" onclick="return false;" value="' . MJText::_('COM_PSO__HTML_PRECONNECT_CLEAR_LISTS') . '" class="btn btn-secondary"/>' .
                    '</div>'
            ),
            MjUI::prepare('textarea', $settings, array('html_preconnect_urls', '[ress_optimize]==1 && [html_preconnect]==1'), 'COM_PSO__HTML_PRECONNECT_URLS', array('maxlength' => 16350)),
        ),
        'COM_PSO__PRELOAD_URLS' => array(
            MjUI::prepare('onoff', $settings, array('html_preload', '[ress_optimize]==1'), 'COM_PSO__HTML_PRELOAD_ENABLED'),
            MjUI::prepare('onoff', $settings, array('html_preload_link', '[ress_optimize]==1 && [html_preload]==1'), 'COM_PSO__HTML_PRELOAD_LINK_HEADERS'),
            array(
                'id' => 'preloadurls_suggestions',
                'depends' => '[ress_optimize]==1 && [html_preload]==1',
                'input' =>
                    '<div class="mjpro">' .
                    '<input type="button" onclick="return false;" value="' . MJText::_('COM_PSO__HTML_PRELOADS_SUGGESTIONS') . '" class="btn btn-primary me-3"/>' .
                    '<input type="button" onclick="return false;" value="' . MJText::_('COM_PSO__HTML_PRELOADS_CLEAR_LISTS') . '" class="btn btn-secondary"/>' .
                    '</div>'
            ),
            MjUI::prepare('textarea', $settings, array('html_preload_style', '[ress_optimize]==1 && [html_preload]==1'), 'COM_PSO__HTML_PRELOAD_STYLE', array('maxlength' => 16350)),
            MjUI::prepare('textarea', $settings, array('html_preload_font', '[ress_optimize]==1 && [html_preload]==1'), 'COM_PSO__HTML_PRELOAD_FONT', array('maxlength' => 16350)),
            MjUI::prepare('textarea', $settings, array('html_preload_script', '[ress_optimize]==1 && [html_preload]==1'), 'COM_PSO__HTML_PRELOAD_SCRIPT', array('maxlength' => 16350)),
            MjUI::prepare('textarea', $settings, array('html_preload_module', '[ress_optimize]==1 && [html_preload]==1'), 'COM_PSO__HTML_PRELOAD_MODULE', array('maxlength' => 16350)),
            MjUI::prepare('textarea', $settings, array('html_preload_image', '[ress_optimize]==1 && [html_preload]==1'), 'COM_PSO__HTML_PRELOAD_IMAGE', array('maxlength' => 16350)),
        ),
    ),
    //right
    array(
        'COM_PSO__HTML' => array(
            MjUI::prepare('onoff', $settings, array('html_removecomments', '[ress_optimize]==1'), 'COM_PSO__HTML_REMOVE_COMMENTS'),
            MjUI::prepare('onoff', $settings, array('html_mergespace', '[ress_optimize]==1'), 'COM_PSO__HTML_MERGE_SPACES'),
            MjUI::prepare('onoff', $settings, array('html_minifyurl', '[ress_optimize]==1'), 'COM_PSO__HTML_MINIFY_URL'),
            MjUI::prepare('onoff', $settings, array('html_sortattr', '[ress_optimize]==1'), 'COM_PSO__HTML_SORT_ATTR'),
            MjUI::prepare('onoff', $settings, array('html_removedefattr', '[ress_optimize]==1'), 'COM_PSO__HTML_REMOVE_DEF_ATTR'),
            MjUI::prepare('onoff', $settings, array('html_removeiecond', '[ress_optimize]==1'), 'COM_PSO__HTML_REMOVE_IE_COND'),
            MjUI::proprepare('onoff', 'html_dom_slim', 'COM_PSO__REDUCE_DOM_SIZE'),
            MjUI::proprepare('textarea', 'html_dom_slim_elements', 'COM_PSO__REDUCE_DOM_SIZE_ELEMENTS'),
            MjUI::proprepare('input', 'html_dom_slim_max', 'COM_PSO__REDUCE_DOM_SIZE_THRESHOLD'),
        ),
        'COM_PSO__IMAGE' => array(
            MjUI::prepare('onoff', $settings, array('img_optimize', '[ress_optimize]==1'), 'COM_PSO__IMAGE_OPTIMIZE'),
            MjUI::prepare('slider', $settings, array('img_jpegquality', '[ress_optimize]==1 && [img_optimize]==1'), 'COM_PSO__IMAGE_JPEG_QUALITY'),
            MjUI::prepare('slider', $settings, array('img_webpquality', '[ress_optimize]==1 && [img_optimize]==1'), 'COM_PSO__IMAGE_WEBP_QUALITY'),
            MjUI::prepare('slider', $settings, array('img_avifquality', '[ress_optimize]==1 && [img_optimize]==1'), 'COM_PSO__IMAGE_AVIF_QUALITY'),
            MjUI::prepare('onoff', $settings, array('img_size', '[ress_optimize]==1'), 'COM_PSO__IMAGE_SIZE_ATTRS'),
            MjUI::proprepare('onoff', 'img_srcset', 'COM_PSO__IMAGE_SRCSET'),
            MjUI::proprepare('input', 'img_srcsetwidth', 'COM_PSO__IMAGE_SRCSETWIDTH'),
        ),
        'COM_PSO__LAZYLOAD' => array(
            MjUI::prepare('nswitch', $settings, array('lazyload_method', '[ress_optimize]==1'), 'COM_PSO__LAZYLOAD_METHOD', $lists['lazyload_method']),
            MjUI::prepare('onoff', $settings, array('img_lazyload', '[ress_optimize]==1 && [lazyload_method]!="none"'), 'COM_PSO__IMAGE_LAZYLOAD'),
            MjUI::proprepare('onoff', 'img_bg_lazyload', 'COM_PSO__BACKGROUND_IMAGE_LAZYLOAD'),
            MjUI::prepare('onoff', $settings, array('video_lazyload', '[ress_optimize]==1 && [lazyload_method]!="none"'), 'COM_PSO__VIDEO_LAZYLOAD'),
            MjUI::prepare('onoff', $settings, array('iframe_lazyload', '[ress_optimize]==1 && [lazyload_method]!="none"'), 'COM_PSO__HTML_IFRAME_LAZYLOAD'),
            MjUI::proprepare('onoff', 'youtube_lazyload', 'COM_PSO__YOUTUBE_LAZYLOAD'),
            MjUI::prepare('onoff', $settings, array('img_lazyload_lqip', '[ress_optimize]==1 && [lazyload_method]=="js" && [img_lazyload]==1'), 'COM_PSO__IMAGE_LAZYLOAD_LQIP'),
            MjUI::prepare('numberinput', $settings, array('lazyload_threshold', '[ress_optimize]==1 && [lazyload_method]=="js"'), 'COM_PSO__LAZYLOAD_THRESHOLD', 'px'),
            MjUI::prepare('nswitch', $settings, array('lazyload_noscript', '[ress_optimize]==1 && [lazyload_method]=="js"'), 'COM_PSO__LAZYLOAD_NOSCRIPT', $lists['lazyload_noscript']),
        ),
        'COM_PSO__CSS' => array(
            MjUI::prepare('onoff', $settings, array('css_merge', '[ress_optimize]==1'), 'COM_PSO__CSS_MERGE'),
            MjUI::prepare('onoff', $settings, array('css_mergeinline', '[ress_optimize]==1'), 'COM_PSO__CSS_MERGEINLINE'),
            MjUI::prepare('onoff', $settings, array('css_optimize', '[ress_optimize]==1'), 'COM_PSO__CSS_OPTIMIZE'),
            MjUI::prepare('onoff', $settings, array('css_minifyattribute', '[ress_optimize]==1'), 'COM_PSO__CSS_MINIFY_ATTRIBUTE'),
            MjUI::prepare('numberinput', $settings, array('css_inlinelimit', '[ress_optimize]==1'), 'COM_PSO__CSS_INLINE_LIMIT', 'bytes'),
            MjUI::prepare('onoff', $settings, array('css_inlinefirsttime', '[ress_optimize]==1'), 'COM_PSO__CSS_INLINE_FIRSTTIME'),
        ),
        'COM_PSO__CSS_ABOVETHEFOLD' => array(
            MjUI::prepare('onoff', $settings, array('css_atf', '[ress_optimize]==1'), 'COM_PSO__CSS_ABOVETHEFOLD_ENABLED'),
            MjUI::prepare('nswitch', $settings, array('css_atflocal', '[ress_optimize]==1 && [css_atf]==1'), 'COM_PSO__CSS_ABOVETHEFOLD_TYPE', $lists['atf_type']),
            array(
                'depends' => '[ress_optimize]==1 && [css_atf]==1',
                'input' =>
                    '<input type="button" onclick="runAtfCssModal()" value="' . MJText::_('COM_PSO__CSS_ATFCSS_LOAD') . '" class="btn btn-primary me-3"/>' .
                    '<input type="button" onclick="clearAtfCss()" value="' . MJText::_('COM_PSO__CSS_ATFCSS_CLEAR') . '" class="btn btn-secondary"/>'
            ),
            MjUI::prepare('textarea', $settings, array('css_atfcss', '[ress_optimize]==1 && [css_atf]==1'), 'COM_PSO__CSS_ATFABOVETHEFOLD_CSS', array('class' => 'text-wrap', 'maxlength' => 131072)),
            MjUI::prepare('onoff', $settings, array('css_atfglobal', '[ress_optimize]==1 && [css_atf]==1'), 'COM_PSO__CSS_ABOVETHEFOLD_GLOBAL'),
            MjUI::proprepare('onoff', 'css_atfautoupdate', 'COM_PSO__CSS_ABOVETHEFOLD_AUTOUPDATE'),
        ),
        'COM_PSO__JS' => array(
            MjUI::prepare('onoff', $settings, array('js_merge', '[ress_optimize]==1'), 'COM_PSO__JS_MERGE'),
            MjUI::prepare('onoff', $settings, array('js_mergeinline', '[ress_optimize]==1'), 'COM_PSO__JS_MERGEINLINE'),
            MjUI::prepare('onoff', $settings, array('js_optimize', '[ress_optimize]==1'), 'COM_PSO__JS_OPTIMIZE'),
            MjUI::prepare('onoff', $settings, array('js_minifyattribute', '[ress_optimize]==1'), 'COM_PSO__JS_MINIFY_ATTRIBUTE'),
            MjUI::prepare('onoff', $settings, array('js_wraptrycatch', '[ress_optimize]==1'), 'COM_PSO__JS_WRAPTRYCATCH'),
            MjUI::prepare('onoff', $settings, array('js_automove', '[ress_optimize]==1'), 'COM_PSO__JS_AUTOMOVE'),
            MjUI::prepare('numberinput', $settings, array('js_inlinelimit', '[ress_optimize]==1'), 'COM_PSO__JS_INLINE_LIMIT', 'bytes'),
            MjUI::prepare('onoff', $settings, array('js_inlinefirsttime', '[ress_optimize]==1'), 'COM_PSO__JS_INLINE_FIRSTTIME'),
            MjUI::proprepare('onoff', 'passivelistener', 'COM_PSO__FORCE_PASSIVE_LISTENER'),
        ),
        'COM_PSO__FONTS' => array(
            MjUI::prepare('onoff', $settings, array('googlefont', '[ress_optimize]==1'), 'COM_PSO__GOOGLEFONT_MERGE'),
            MjUI::prepare('select', $settings, array('googlefont_method', '[ress_optimize]==1 && [googlefont]==1'), 'COM_PSO__GOOGLEFONT_METHOD', $lists['font_display']),
            MjUI::proprepare('onoff', 'googlefont_async', 'COM_PSO__GOOGLEFONT_ASYNC'),
            MjUI::prepare('select', $settings, array('font_displayswap', '[ress_optimize]==1'), 'COM_PSO__FONT_SWAP', $lists['font_display']),
            MjUI::prepare('textarea', $settings, array('font_displayswap_exclude', '[ress_optimize]==1 && [font_displayswap]!="none"'), 'COM_PSO__FONT_SWAP_EXCLUDE'),
        ),
    )
);


echo $this->renderView('global/form', array(
    'form' => $form,
    'options' => array(
        MjUI::id('enabled') => $settings->get('enabled'),
        MjUI::id('staticdir') => $settings->get('staticdir'),
    ),
    'controllerName' => $controllerName,
    'viewName' => $viewName,
    'settings' => $settings
));

echo $this->renderView('global/getpreloads');
echo $this->renderView('global/getdnsprefetch');
echo $this->renderView('global/getpreconnect');
echo $this->renderView('global/getatfcss');
