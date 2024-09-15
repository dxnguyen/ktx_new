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

include_once dirname(__DIR__) . '/ress/classes/pagecache.php';
include_once __DIR__ . '/mjpagecache.php';

//global $mjPageCache;
$mjPageCache = new MjPageCache();
