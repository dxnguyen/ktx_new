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
$lists['logging_level'] = array(
    0 => MJText::_('COM_PSO__LOGGING_LEVEL_NONE'),
    1 => MJText::_('COM_PSO__LOGGING_LEVEL_EMERGENCY'),
    2 => MJText::_('COM_PSO__LOGGING_LEVEL_ALERT'),
    3 => MJText::_('COM_PSO__LOGGING_LEVEL_CRITICAL'),
    4 => MJText::_('COM_PSO__LOGGING_LEVEL_ERROR'),
    5 => MJText::_('COM_PSO__LOGGING_LEVEL_WARNING'),
    6 => MJText::_('COM_PSO__LOGGING_LEVEL_NOTICE'),
    7 => MJText::_('COM_PSO__LOGGING_LEVEL_INFO'),
    8 => MJText::_('COM_PSO__LOGGING_LEVEL_DEBUG')
);

$form = array(
    //left
    array(
        'COM_PSO__LOGGING' => array(
            MjUI::prepare('select', $settings, array('ress_logginglevel', '[ress_optimize]==1'), 'COM_PSO__LOGGING_LEVEL', $lists['logging_level']),
        ),
        'COM_PSO__TROUBLESHOOTING_DISABLE' => array(
            MjUI::prepare('componentslist', $settings, array('exclude_options', '[ress_optimize]==1'), 'COM_PSO__EXCLUDE_COMPONENTS', true),
            MjUI::prepare('menulistid', $settings, array('exclude_menus', '[ress_optimize]==1'), 'COM_PSO__EXCLUDE_MENUS', true),
        ),
        'COM_PSO__EXCLUDE_RULES_INFO' => array(
            array('label' => MjUI::text(str_replace("\n", '<br>', MJText::_('COM_PSO__EXCLUDE_RULES_INFO_DESC')))),
        ),
        'COM_PSO__HTML_EXCLUDE_RULES' => array(
            MjUI::prepare('textarea', $settings, array('html_rules_safe_exclude', '[ress_optimize]==1'), 'COM_PSO__HTML_RULES_SAFE_EXCLUDE'),
        ),
        'COM_PSO__IMG_EXCLUDE_RULES' => array(
            MjUI::prepare('textarea', $settings, array('img_rules_minify_exclude', '[ress_optimize]==1 && [img_optimize]==1'), 'COM_PSO__IMG_RULES_MINIFY_EXCLUDE'),
        ),
        'COM_PSO__LAZYLOAD_EXCLUDE_RULES' => array(
            MjUI::prepare('textarea', $settings, array('lazyload_rules_img_exclude', '[ress_optimize]==1 && [lazyload_method]!="none" && [img_lazyload]==1'), 'COM_PSO__LAZYLOAD_RULES_IMG_EXCLUDE'),
            MjUI::proprepare('textarea', 'lazyload_rules_img_bg_exclude', 'COM_PSO__LAZYLOAD_RULES_IMG_BG_EXCLUDE'),
            MjUI::prepare('textarea', $settings, array('lazyload_rules_video_exclude', '[ress_optimize]==1 && [lazyload_method]!="none" && [video_lazyload]==1'), 'COM_PSO__LAZYLOAD_RULES_VIDEO_EXCLUDE'),
            MjUI::prepare('textarea', $settings, array('lazyload_rules_iframe_exclude', '[ress_optimize]==1 && [lazyload_method]!="none" && [iframe_lazyload]==1'), 'COM_PSO__LAZYLOAD_RULES_IFRAME_EXCLUDE'),
        ),
    ),
    //right
    array(
        'COM_PSO__CSS_EXCLUDE_RULES' => array(
            MjUI::prepare('textarea', $settings, array('css_rules_minify_exclude', '[ress_optimize]==1 && [css_optimize]==1'), 'COM_PSO__CSS_RULES_MINIFY_EXCLUDE'),
            MjUI::prepare('textarea', $settings, array('css_rules_merge_bypass', '[ress_optimize]==1 && [css_merge]==1'), 'COM_PSO__CSS_RULES_MERGE_BYPASS'),
            MjUI::prepare('textarea', $settings, array('css_rules_merge_stop', '[ress_optimize]==1 && [css_merge]==1'), 'COM_PSO__CSS_RULES_MERGE_STOP'),
            MjUI::prepare('textarea', $settings, array('css_rules_merge_exclude', '[ress_optimize]==1 && [css_merge]==1'), 'COM_PSO__CSS_RULES_MERGE_EXCLUDE'),
            MjUI::prepare('textarea', $settings, array('css_rules_merge_include', '[ress_optimize]==1 && [css_merge]==1'), 'COM_PSO__CSS_RULES_MERGE_INCLUDE'),
            MjUI::prepare('textarea', $settings, array('css_rules_merge_startgroup', '[ress_optimize]==1 && [css_merge]==1'), 'COM_PSO__CSS_RULES_MERGE_STARTGROUP'),
            MjUI::prepare('textarea', $settings, array('css_rules_merge_stopgroup', '[ress_optimize]==1 && [css_merge]==1'), 'COM_PSO__CSS_RULES_MERGE_STOPGROUP'),
        ),
        'COM_PSO__JS_EXCLUDE_RULES' => array(
            MjUI::prepare('textarea', $settings, array('js_rules_minify_exclude', '[ress_optimize]==1 && [js_optimize]==1'), 'COM_PSO__JS_RULES_MINIFY_EXCLUDE'),
            MjUI::prepare('textarea', $settings, array('js_rules_merge_bypass', '[ress_optimize]==1 && [js_merge]==1'), 'COM_PSO__JS_RULES_MERGE_BYPASS'),
            MjUI::prepare('textarea', $settings, array('js_rules_merge_stop', '[ress_optimize]==1 && [js_merge]==1'), 'COM_PSO__JS_RULES_MERGE_STOP'),
            MjUI::prepare('textarea', $settings, array('js_rules_merge_exclude', '[ress_optimize]==1 && [js_merge]==1'), 'COM_PSO__JS_RULES_MERGE_EXCLUDE'),
            MjUI::prepare('textarea', $settings, array('js_rules_merge_include', '[ress_optimize]==1 && [js_merge]==1'), 'COM_PSO__JS_RULES_MERGE_INCLUDE'),
            MjUI::prepare('textarea', $settings, array('js_rules_merge_startgroup', '[ress_optimize]==1 && [js_merge]==1'), 'COM_PSO__JS_RULES_MERGE_STARTGROUP'),
            MjUI::prepare('textarea', $settings, array('js_rules_merge_stopgroup', '[ress_optimize]==1 && [js_merge]==1'), 'COM_PSO__JS_RULES_MERGE_STOPGROUP'),
            MjUI::prepare('textarea', $settings, array('js_rules_move_exclude', '[ress_optimize]==1'), 'COM_PSO__JS_RULES_MOVE_EXCLUDE'),
            MjUI::prepare('textarea', $settings, array('js_rules_async_exclude', '[ress_optimize]==1'), 'COM_PSO__JS_RULES_ASYNC_EXCLUDE'),
            MjUI::prepare('textarea', $settings, array('js_rules_async_include', '[ress_optimize]==1'), 'COM_PSO__JS_RULES_ASYNC_INCLUDE'),
            MjUI::prepare('textarea', $settings, array('js_rules_defer_exclude', '[ress_optimize]==1'), 'COM_PSO__JS_RULES_DEFER_EXCLUDE'),
            MjUI::prepare('textarea', $settings, array('js_rules_defer_include', '[ress_optimize]==1'), 'COM_PSO__JS_RULES_DEFER_INCLUDE'),
        ),
    )
);

echo $this->renderView('global/form', array(
    'form' => $form,
    'options' => array(
        MjUI::id('enabled') => $settings->get('enabled'),
        MjUI::id('ress_optimize') => $settings->get('ress_optimize'),
        MjUI::id('img_optimize') => $settings->get('img_optimize'),
        MjUI::id('lazyload_method') => $settings->get('lazyload_method'),
        MjUI::id('img_lazyload') => $settings->get('img_lazyload'),
        MjUI::id('img_bg_lazyload') => $settings->get('img_bg_lazyload'),
        MjUI::id('video_lazyload') => $settings->get('video_lazyload'),
        MjUI::id('iframe_lazyload') => $settings->get('iframe_lazyload'),
        MjUI::id('css_optimize') => $settings->get('css_optimize'),
        MjUI::id('css_merge') => $settings->get('css_merge'),
        MjUI::id('js_optimize') => $settings->get('js_optimize'),
        MjUI::id('js_merge') => $settings->get('js_merge'),
    ),
    'controllerName' => $controllerName,
    'viewName' => $viewName,
    'settings' => $settings
));
