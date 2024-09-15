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
/** @var MjSettingsModel $settings */

include_once JPATH_COMPONENT . '/classes/mjinspection.php';

$inspection = new MjInspection();
$warnings = $inspection->getWarnings($settings);
unset($inspection);
if (count($warnings)) {
    $warnings['class'] = 'bg-warning text-white';
}

return $warnings;
