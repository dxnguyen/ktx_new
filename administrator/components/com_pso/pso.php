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

include_once JPATH_COMPONENT . '/legacy/joomlawrapper.php';
$joomlaWrapper = MjJoomlaWrapper::getInstance();

if (!$joomlaWrapper) {
    echo 'NO WRAPPER FOUND FOR THIS JOOMLA VERSION!';
    return;
}

$joomlaWrapper->loadLanguageFile('com_pso');

$app = MJFactory::getApplication();

//ACL check
if (!$joomlaWrapper->checkACL('com_pso')) {
    $app->enqueueMessage(MJText::_('JERROR_ALERTNOAUTHOR'), 'error');
    return;
}

include_once JPATH_COMPONENT . '/models/settings.php';
include_once JPATH_COMPONENT . '/classes/mjhelper.php';

$controllerName = $joomlaWrapper->getRequestWord('controller', 'dashboard'); // default controller
$action = $joomlaWrapper->getRequestWord('task', 'display');

$path = "/controllers/{$controllerName}.php";
$filename = JPATH_COMPONENT . $path;
if (!is_file($filename)) {
    $filename = JPATH_PLUGINS . "/pso/psopro$path";
}
if (!is_file($filename)) {
    $app->enqueueMessage('Controller file is not found', 'error');
    return;
}
require_once $filename;

$classname = 'Mj' . $controllerName . 'Controller';
if (!class_exists($classname)) {
    $app->enqueueMessage('Controller class does not exist', 'error');
    return;
}

/** @var MjBaseController $controller */
$controller = new $classname($joomlaWrapper);
$controller->name = $controllerName;

/** @var JApplicationAdministrator $app */
$app = MJFactory::getApplication();

MJPluginHelper::importPlugin('pso');
$app->triggerEvent('onPsoBeforeDispatch', array($controller, $action));

$controller->execute($action);
$controller->redirect();
