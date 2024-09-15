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

include_once JPATH_COMPONENT . '/classes/mjadminhelper.php';

$resscachedir = JPATH_COMPONENT . '/cache/ress';
MjAdminHelper::getDirectoryStats($resscachedir, $size, $files);
$filecachecleaner_stamp = "$resscachedir/filecachecleaner.stamp";
if (is_file($filecachecleaner_stamp) && filesize($filecachecleaner_stamp) === 0) {
    $files--;
}

echo json_encode(array('size' => MjAdminHelper::formatSize($size), 'files' => $files));
jexit();
