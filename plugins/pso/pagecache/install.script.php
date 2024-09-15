<?php
/**
 * Page Speed Optimizer extension
 * https://www.mobilejoomla.com/
 *
 * @version    1.4.1
 * @license    GNU/GPL v2 - http://www.gnu.org/licenses/gpl-2.0.html
 * @copyright  (C) 2022-2024 Denis Ryabov
 * @date       June 2024
 */
defined('_JEXEC') or die('Restricted access');

class PlgPsoPagecacheInstallerScript
{
    /**
     * @param string $route
     * @param JInstallerComponent $adapter
     * @return bool
     */
    public function preflight($route, $adapter)
    {
        // check MJ component is installer
        if ($route !== 'uninstall' && !is_dir(JPATH_ADMINISTRATOR . '/components/com_pso')) {
            throw new RuntimeException('The Page Speed Optimizer extension is not installed.');
        }

        return true;
    }

    /**
     * @param JInstallerComponent $adapter
     * @return bool
     */
    public function install($adapter)
    {
        if (!class_exists(MjJoomlaWrapper::class, false)) {
            include_once JPATH_ADMINISTRATOR . '/components/com_pso/legacy/joomlawrapper.php';
        }

        $joomlaWrapper = MjJoomlaWrapper::getInstance();
        $db = $joomlaWrapper->getDbo();

        $query = new MjQueryBuilder($db);
        $query
            ->update('#__extensions')
            ->set($query->qn('enabled') . '=1')
            ->where($query->qn('type') . '=' . $query->q('plugin'))
            ->where($query->qn('element') . '=' . $query->q('pagecache'))
            ->where($query->qn('folder') . '=' . $query->q('pso'))
            ->execute();

        return true;
    }

    /**
     * @param JInstallerComponent $adapter
     * @return bool
     */
    public function update($adapter)
    {
        return true;
    }

    /**
     * @param JInstallerComponent $adapter
     * @return bool
     */
    public function uninstall($adapter)
    {
        return true;
    }

    /**
     * @param string $route
     * @param JInstallerComponent $adapter
     * @return bool
     */
    public function postflight($route, $adapter)
    {
        if ($route === 'install') {
            // create pagecache.json config
            require_once JPATH_ADMINISTRATOR . '/components/com_pso/legacy/joomlawrapper.php';
            require_once JPATH_ADMINISTRATOR . '/components/com_pso/classes/mjpagecachehelper.php';
            MjPagecacheHelper::updateConfig(false);
        }
        return true;
    }
}