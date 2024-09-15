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

$doc = $this->joomlaWrapper->getDocument();

MJToolbarHelper::apply();
MJToolbarHelper::cancel();

// populate settings
include_once JPATH_COMPONENT . '/models/settings.php';
$settings = new MjSettingsModel($this->joomlaWrapper);

$form = array(
    //left
    array(
        'COM_PSO__PAGECACHE' => array(
            MjUI::prepare('onoff', $settings, 'pagecache_enabled', 'COM_PSO__PAGECACHE_ENABLED'),
            MjUI::prepare('onoff', $settings, array('pagecache_quick', '[pagecache_enabled]==1'), 'COM_PSO__PAGECACHE_QUICK_MODE'),
            MjUI::proprepare('onoff', 'pagecache_autowarm', 'COM_PSO__PAGECACHE_AUTO_WARM'),
            MjUI::proprepare('textarea', 'pagecache_autowarm_urls', 'COM_PSO__PAGECACHE_AUTO_WARM_URLS'),
            MjUI::prepare('onoff', $settings, array('pagecache_disable_queries', '[pagecache_enabled]==1'), 'COM_PSO__PAGECACHE_DISABLE_QUERIES'),
            MjUI::prepare('duration', $settings, array('pagecache_ttl', '[pagecache_enabled]==1'), 'COM_PSO__PAGECACHE_TTL'),
            MjUI::prepare('textarea', $settings, array('pagecache_params_skip', '[pagecache_enabled]==1'), 'COM_PSO__PAGECACHE_SKIP_PARAMS', array('maxlength' => 16350)),
        ),
    ),
    //right
    array(
        'COM_PSO__PAGECACHE_SETTINGS' => array(
            MjUI::prepare('componentslist', $settings, array('pagecache_exclude_options', '[pagecache_enabled]==1'), 'COM_PSO__PAGECACHE_EXCLUDE_COMPONENTS', true),
            MjUI::prepare('menulistid', $settings, array('pagecache_exclude_menus', '[pagecache_enabled]==1'), 'COM_PSO__PAGECACHE_EXCLUDE_MENUS', true),
            MjUI::prepare('textarea', $settings, array('pagecache_cookies_disable', '[pagecache_enabled]==1'), 'COM_PSO__PAGECACHE_DISABLE_COOKIES', array('maxlength' => 16350)),
            MjUI::prepare('textarea', $settings, array('pagecache_cookies_depend', '[pagecache_enabled]==1'), 'COM_PSO__PAGECACHE_DEPEND_COOKIES', array('maxlength' => 16350)),
            MjUI::prepare('textarea', $settings, array('pagecache_http_depend', '[pagecache_enabled]==1'), 'COM_PSO__PAGECACHE_DEPEND_HTTP', array('maxlength' => 16350)),
        ),
    )
);

echo $this->renderView('global/form', array(
    'form' => $form,
    'options' => array(
        MjUI::id('enabled') => $settings->get('enabled'),
    ),
    'controllerName' => $controllerName,
    'viewName' => $viewName,
    'settings' => $settings
));
