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

include_once JPATH_COMPONENT . '/classes/mjadminhelper.php';

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

$lists['ress_hashsize'] = array(
    '6' => '6',
    '8' => '8',
    '10' => '10',
    '12' => '12',
    '16' => '16',
);

$form = array(
    //left
    array(
        'COM_PSO__RESS' => array(
            MjUI::prepare('nswitch', $settings, array('ress_optimizer', '[ress_optimize]==1'), 'COM_PSO__RESS_OPTIMIZER',
                array('stream' => 'Stream', 'dom' => 'XML', 'streamfull' => 'Stream-Full', 'pharse' => 'Pharse')
            ),
            MjUI::proprepare('nswitch', 'cache_driver', 'COM_PSO__CACHE_DRIVER',
                array('$0' => 'File', '$1' => 'Redis')
            ),
            MjUI::proprepare('input', 'redis_uri', 'COM_PSO__REDIS_URI'),
            MjUI::prepare('textinput', $settings, array('staticdir', '[ress_optimize]==1'), 'COM_PSO__STATICDIR'),
            MjUI::prepare('onoff', $settings, array('use_symlink', '[ress_optimize]==1'), 'COM_PSO__USE_SYMLINK'),
            MjUI::prepare('nswitch', $settings, array('ress_hashsize', '[ress_optimize]==1'), 'COM_PSO__HASHSIZE', $lists['ress_hashsize']),
            MjUI::proprepare('nswitch', 'exec_mode', 'COM_PSO__EXEC_MODE',
                array('$0' => 'exec', '$1' => 'popen', '$2' => 'proc_open')
            ),
        ),
        'COM_PSO__SCHEDULER' => array(
            MjUI::prepare('time', $settings, 'dailyrun_time', 'COM_PSO__DAILY_RUN_TIME'),
        ),
        'COM_PSO__LOADEXTERNAL' => array(
            MjUI::prepare('nswitch', $settings, 'cacert', 'COM_PSO__CACERT_SOURCE',
                array('0' => MJText::_('COM_PSO__CACERT_SYSTEM'), '1' => MJText::_('COM_PSO__CACERT_JOOMLA'))
            ),
            MjUI::proprepare('onoff', 'load_css', 'COM_PSO__LOADEXTERNAL_CSS'),
            MjUI::proprepare('onoff', 'load_js', 'COM_PSO__LOADEXTERNAL_JS'),
            MjUI::proprepare('onoff', 'load_image', 'COM_PSO__LOADEXTERNAL_IMAGE'),
            MjUI::proprepare('onoff', 'load_font', 'COM_PSO__LOADEXTERNAL_FONT'),
            MjUI::proprepare('onoff', 'load_ga', 'COM_PSO__LOADEXTERNAL_GOOGLE_ANALYTICS'),
            MjUI::proprepare('onoff', 'load_disable_php', 'COM_PSO__LOADEXTERNAL_DISABLE_PHP'),
            MjUI::proprepare('onoff', 'load_disable_query', 'COM_PSO__LOADEXTERNAL_DISABLE_QUERY'),
            MjUI::proprepare('input', 'load_domains', 'COM_PSO__LOADEXTERNAL_ALLOWED_DOMAINS'),
            MjUI::proprepare('nswitch', 'load_method', 'COM_PSO__LOADEXTERNAL_METHOD',
                array('stream' => 'PHP stream', 'curl' => 'curl', 'sock' => 'sock')),
            MjUI::proprepare('input', 'load_timeout', 'COM_PSO__LOADEXTERNAL_TIMEOUT'),
            MjUI::proprepare('input', 'load_useragent', 'COM_PSO__LOADEXTERNAL_USER_AGENT'),
        ),
        'COM_PSO__WORKER' => array(
            MjUI::proprepare('input', 'worker_joomlaconfig', 'COM_PSO__WORKER_JOOMLA_PATH'),
            MjUI::proprepare('input', 'worker_group', 'COM_PSO__WORKER_GROUP'),
        ),
    ),
    //right
    array(
        'COM_PSO__IMAGE' => array(
            MjUI::proprepare('nswitch', 'image_driver', 'COM_PSO__IMAGE_OPTIMIZER',
                array('$0' => 'PHP GD2', '$1' => 'ImageMagic', '$2' => 'Command')
            ),
            MjUI::proprepare('onoff', 'image_chroma420', 'COM_PSO__IMAGE_CHROMA420'),
            MjUI::proprepare('select', 'img_driver_jpeg', 'COM_PSO__IMAGE_DRIVER_JPEG',
                array('' => 'Default', 'none' => 'None', 'gd2' => 'PHP GD2', 'imagick' => 'ImageMagic', 'exec' => 'Command')
            ),
            MjUI::proprepare('input', 'img_exec_jpeg', 'COM_PSO__IMAGE_EXEC_JPEG'),
            MjUI::proprepare('select', 'img_driver_png', 'COM_PSO__IMAGE_DRIVER_PNG',
                array('' => 'Default', 'none' => 'None', 'gd2' => 'PHP GD2', 'imagick' => 'ImageMagic', 'exec' => 'Command')
            ),
            MjUI::proprepare('input', 'img_exec_png', 'COM_PSO__IMAGE_EXEC_PNG'),
            MjUI::proprepare('select', 'img_driver_gif', 'COM_PSO__IMAGE_DRIVER_GIF',
                array('' => 'Default', 'none' => 'None', 'gd2' => 'PHP GD2', 'imagick' => 'ImageMagic', 'exec' => 'Command')
            ),
            MjUI::proprepare('input', 'img_exec_gif', 'COM_PSO__IMAGE_EXEC_GIF'),
            MjUI::proprepare('select', 'img_driver_svg', 'COM_PSO__IMAGE_DRIVER_SVG',
                array('none' => 'None', 'exec' => 'Command')
            ),
            MjUI::proprepare('input', 'img_exec_svg', 'COM_PSO__IMAGE_EXEC_SVG'),
            MjUI::proprepare('select', 'img_driver_webp', 'COM_PSO__IMAGE_DRIVER_WEBP',
                array('' => 'Default', 'none' => 'None', 'gd2' => 'PHP GD2', 'imagick' => 'ImageMagic', 'exec' => 'Command')
            ),
            MjUI::proprepare('input', 'img_exec_webp', 'COM_PSO__IMAGE_EXEC_WEBP'),
            MjUI::proprepare('select', 'img_driver_avif', 'COM_PSO__IMAGE_DRIVER_AVIF',
                array('' => 'Default', 'none' => 'None', 'gd2' => 'PHP GD2', 'imagick' => 'ImageMagic', 'exec' => 'Command')
            ),
            MjUI::proprepare('input', 'img_exec_avif', 'COM_PSO__IMAGE_EXEC_AVIF'),
            MjUI::prepare('onoff', $settings, array('image_webp', '[ress_optimize]==1 && [img_optimize]==1'), 'COM_PSO__IMAGE_WEBP'),
            MjUI::prepare('onoff', $settings, array('image_avif', '[ress_optimize]==1 && [img_optimize]==1'), 'COM_PSO__IMAGE_AVIF'),
        ),
        'COM_PSO__LAZYLOAD' => array(
            MjUI::proprepare('input', 'lazyload_img_skip', 'COM_PSO__LAZYLOAD_SKIP_IMAGES'),
            MjUI::proprepare('input', 'lazyload_img_bg_skip', 'COM_PSO__LAZYLOAD_SKIP_BACKGROUND_IMAGES'),
            MjUI::proprepare('input', 'lazyload_video_skip', 'COM_PSO__LAZYLOAD_SKIP_VIDEOS'),
            MjUI::proprepare('input', 'lazyload_iframe_skip', 'COM_PSO__LAZYLOAD_SKIP_IFRAMES'),
        ),
        'COM_PSO__CSS' => array(
            MjUI::proprepare('nswitch', 'css_minify_driver', 'COM_PSO__CSS_MINIFY_DRIVER',
                array('$0' => 'PSO', '$1' => 'Command')
            ),
            MjUI::proprepare('input', 'css_minify_exec', 'COM_PSO__CSS_MINIFY_EXEC'),
            MjUI::prepare('onoff', $settings, array('css_checklinkattrs', '[ress_optimize]==1'), 'COM_PSO__CSS_CHECKLINKATTRS'),
            MjUI::prepare('onoff', $settings, array('css_checkstyleattrs', '[ress_optimize]==1'), 'COM_PSO__CSS_CHECKSTYLEATTRS'),
        ),
        'COM_PSO__JS' => array(
            MjUI::proprepare('nswitch', 'js_minify_driver', 'COM_PSO__JS_MINIFY_DRIVER',
                array('$0' => 'JsMin', '$1' => 'Command')
            ),
            MjUI::proprepare('input', 'js_minify_exec', 'COM_PSO__JS_MINIFY_EXEC'),
            MjUI::prepare('onoff', $settings, array('js_checkattrs', '[ress_optimize]==1'), 'COM_PSO__JS_CHECKATTRS'),
            MjUI::prepare('onoff', $settings, array('js_skipinits', '[ress_optimize]==1'), 'COM_PSO__JS_SKIPINITS'),
            MjUI::prepare('onoff', $settings, array('js_forcedefer', '[ress_optimize]==1'), 'COM_PSO__JS_FORCEDEFER'),
            MjUI::prepare('onoff', $settings, array('js_forceasync', '[ress_optimize]==1'), 'COM_PSO__JS_FORCEASYNC'),
            MjUI::proprepare('onoff', 'js_nonblockjs', 'COM_PSO__JS_NONBLOCKJS'),
            MjUI::proprepare('onoff', 'js_widgets_delay', 'COM_PSO__JS_WIDGETS_DELAY'),
            MjUI::proprepare('onoff', 'js_widgets_delay_async', 'COM_PSO__JS_WIDGETS_DELAY_ASYNC'),
            MjUI::proprepare('onoff', 'js_widgets_delay_scripts', 'COM_PSO__JS_WIDGETS_DELAY_SCRIPTS'),
            MjUI::proprepare('textarea', 'js_widgets_delay_scripts_list', 'COM_PSO__JS_WIDGETS_DELAY_SCRIPTS_LIST'),
            MjUI::prepare('onoff', $settings, array('js_polyfill', '[ress_optimize]==1'), 'COM_PSO__JS_FIX_POLYFILLS'),
            MjUI::prepare('textarea', $settings, array('js_polyfill_rules', '[ress_optimize]==1 && [js_polyfill]==1'), 'COM_PSO__JS_FIX_POLYFILLS_RULES'),
        ),
    )
);

echo $this->renderView('global/form', array(
    'form' => $form,
    'options' => array(
        MjUI::id('enabled') => $settings->get('enabled'),
        MjUI::id('ress_optimize') => $settings->get('ress_optimize'),
        MjUI::id('ress_async') => $settings->get('ress_async'),
        MjUI::id('img_optimize') => $settings->get('img_optimize'),
        MjUI::id('css_optimize') => $settings->get('css_optimize'),
        MjUI::id('js_optimize') => $settings->get('js_optimize'),
        MjUI::id('lazyload_method') => $settings->get('lazyload_method'),
        MjUI::id('img_lazyload') => $settings->get('img_lazyload'),
        MjUI::id('img_bg_lazyload') => $settings->get('img_bg_lazyload'),
        MjUI::id('video_lazyload') => $settings->get('video_lazyload'),
        MjUI::id('iframe_lazyload') => $settings->get('iframe_lazyload'),
    ),
    'controllerName' => $controllerName,
    'viewName' => $viewName,
    'settings' => $settings
));
