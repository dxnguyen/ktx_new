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

$db = $this->joomlaWrapper->getDbo();
$query = new MjQueryBuilder($db);
$rows = $query
    ->select('pid', 'counter', 'COUNT(*) AS cnt')
    ->from('#__pso_queue')
    ->group('pid', 'counter')
    ->loadObjectList();
$workers_awaiting = 0;
$workers_running = 0;
$workers_failed = 0;
foreach ($rows as $row) {
    if ($row->pid > 0) {
        $workers_running += $row->cnt;
    } elseif ($row->counter >= 5) {
        $workers_failed += $row->cnt;
    } else {
        $workers_awaiting += $row->cnt;
    }
}

echo json_encode(array('size' => $workers_awaiting, 'size2' => $workers_running, 'size3' => $workers_failed));
jexit();
