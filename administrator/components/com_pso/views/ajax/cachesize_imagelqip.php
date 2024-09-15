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

/** @var MjAjaxController $this */
/** @var array $params */
/** @var string $controllerName */
/** @var string $viewName */

include_once JPATH_COMPONENT . '/models/settings.php';
include_once JPATH_COMPONENT . '/classes/mjadminhelper.php';

$settings = new MjSettingsModel($this->joomlaWrapper);

$staticdir = JPATH_ROOT . $settings->get('staticdir');

$imgDir = $staticdir . '/img-lqip';
MjAdminHelper::getImagesStats($imgDir, $size, $files);

echo json_encode(array('size' => MjAdminHelper::formatSize($size), 'files' => $files));
jexit();
