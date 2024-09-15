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

// Allow CLI execution only
PHP_SAPI === 'cli' || die('Restricted access');

// Path: /administrator/components/com_pso
define('JPATH_COMPONENT', dirname(__DIR__));
define('RESSIO_PATH', JPATH_COMPONENT . '/ress');

// load Joomla config & framework
// Path: /
$jRoot = dirname(dirname(dirname(JPATH_COMPONENT)));
define('_JEXEC', 1);
if (file_exists("$jRoot/defines.php")) {
    // to bypass pagecache code
    define('PSO_CRON', 1);
    include_once "$jRoot/defines.php";
}
if (!defined('_JDEFINES')) {
    define('JPATH_BASE', $jRoot);
    require_once "$jRoot/includes/defines.php";
}
require_once "$jRoot/includes/framework.php";

// load cron config
include_once JPATH_COMPONENT . '/classes/mjhelper.php';
$config = MjHelper::loadJSON(JPATH_COMPONENT . '/config/cron.json');
if (!is_array($config)) {
    die("ERROR: Configuration file is not created yet.\n");
}

$options = MjHelper::getJDatabaseOptions(new JConfig());
if (version_compare(JVERSION, '4.0', '>=')) {
    $config['db']['joomlaDriver'] = (new Joomla\Database\DatabaseFactory)->getDriver($options['driver'], $options);
} else {
    $config['db']['joomlaDriver'] = JDatabaseDriver::getInstance($options);
}
$config['worker']['enabled'] = true;

include_once RESSIO_PATH . '/ressio.php';
$ressio = new Ressio($config);
$ressio->di->worker->run();
