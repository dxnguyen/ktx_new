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

class PlgSystempsoInstallerScript
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
        $joomlaWrapper->loadLanguageFile('com_pso');

        $db = $joomlaWrapper->getDbo();
        $query = new MjQueryBuilder($db);
        $sef_ordering = $query
            ->select('ordering')
            ->from('#__extensions')
            ->where($query->qn('element') . '=' . $query->q('sef'))
            ->where($query->qn('folder') . '=' . $query->q('system'))
            ->loadResult();

        $ordering = 9;
        if ($sef_ordering !== null && $ordering <= $sef_ordering) {
            $ordering = $sef_ordering + 1;
        }

        $query = new MjQueryBuilder($db);
        $query
            ->update('#__extensions')
            ->set($query->qn('enabled') . '=1')
            ->set($query->qn('ordering') . '=' . $ordering)
            ->where($query->qn('type') . '=' . $query->q('plugin'))
            ->where($query->qn('element') . '=' . $query->q('pso'))
            ->where($query->qn('folder') . '=' . $query->q('system'))
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
}