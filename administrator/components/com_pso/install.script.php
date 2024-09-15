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

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

class com_psoInstallerScript
{
    /**
     * @param JInstallerComponent $adapter
     * @return bool
     */
    public function install($adapter)
    {
        if (version_compare(JVERSION, '5.0', '>=')) {
            $app = Joomla\CMS\Factory::getApplication();
        } else {
            $app = JFactory::getApplication();
        }
        $app->getLanguage()->load('com_pso.sys', JPATH_ADMINISTRATOR, null, true);

        //update config & files
        return $this->updateConfig();
    }

    /**
     * @param JInstallerComponent $adapter
     * @return bool
     */
    public function update($adapter)
    {
        if (!class_exists(MjJoomlaWrapper::class, false)) {
            include_once JPATH_ADMINISTRATOR . '/components/com_pso/legacy/joomlawrapper.php';
        }

        $joomlaWrapper = MjJoomlaWrapper::getInstance();
        $joomlaWrapper->loadLanguageFile('com_pso');

        // check for upgrade
        $prev_version = null;
        $manifest = JPATH_ADMINISTRATOR . '/components/com_pso/pso.xml';
        if (is_file($manifest)) {
            $xml = simplexml_load_file($manifest);
            if (isset($xml->version)) {
                $prev_version = (string)$xml->version;
            }
        }

        //update config & files
        return $this->updateConfig($prev_version);
    }

    /**
     * @param JInstallerComponent $adapter
     * @return bool
     */
    public function uninstall($adapter)
    {
        if (!class_exists(MjJoomlaWrapper::class, false)) {
            include_once JPATH_ADMINISTRATOR . '/components/com_pso/legacy/joomlawrapper.php';
        }

        $joomlaWrapper = MjJoomlaWrapper::getInstance();
        $joomlaWrapper->loadLanguageFile('com_pso');

        // remove settings table
        $db = $joomlaWrapper->getDbo();
        $query = new MjQueryBuilder($db);
        $query->dropTable('#__pso_settings');

        // drop worker table
        $query = new MjQueryBuilder($db);
        $query->dropTable('#__pso_queue');

        // remove directories
        MJFolder::delete(JPATH_ROOT . '/media/pso');

        // remove quick page cache file
        $definesPhp = JPATH_ROOT . '/defines.php';
        if (is_file($definesPhp) && strpos(file_get_contents($definesPhp), 'com_pso') !== false) {
            unlink($definesPhp);
        }

        return true;
    }

    /**
     * @param string $prev_version
     * @return bool
     */
    private function updateConfig($prev_version = null)
    {
        $psoDir = JPATH_ADMINISTRATOR . '/components/com_pso';

        if (!class_exists(MjJoomlaWrapper::class, false)) {
            include_once "$psoDir/legacy/joomlawrapper.php";
        }
        if (!class_exists(MjSettingsModel::class, false)) {
            include_once "$psoDir/models/settings.php";
        }

        $joomlaWrapper = MjJoomlaWrapper::getInstance();
        $joomlaWrapper->loadLanguageFile('com_pso');

        $db = $joomlaWrapper->getDbo();
        $query = new MjQueryBuilder($db);

        //table for settings





        $query->createTable(
            '#__pso_settings',
            array(
                'name' => array('type' => 'varchar', 'size' => 32, 'notnull' => true),
                'value' => array('type' => 'varchar', 'size' => 16350, 'notnull' => true)
            ),
            array(),
            array('if_not_exists' => true, 'charset' => 'utf8mb4')
        );

        //worker's queue table
        $table_structure = array(
            'hash' => array('type' => 'binary', 'size' => 16, 'notnull' => true),
            'action' => array('type' => 'char', 'size' => 16, 'notnull' => true),
            'params' => array('type' => 'text', 'notnull' => true),
            'added' => array('type' => 'integer', 'notnull' => true),
            'pid' => array('type' => 'integer', 'notnull' => true),
            'counter' => array('type' => 'integer', 'notnull' => true),
        );
        switch ($joomlaWrapper->getConfig('dbtype')) {
            case 'mysql':
            case 'mysqli':
            case 'pdomysql':
            case 'jdiction_mysqli':
                break;
            case 'pgsql':
            case 'postgresql':
                $table_structure['hash']['type'] = 'uuid';
                break;
            default:
                return false;
        }
        $query->createTable(
            '#__pso_queue',
            $table_structure,
            array('!' => array('hash'), 'pid_counter' => array('pid', 'counter')),
            array('if_not_exists' => true, 'charset' => 'utf8mb4')
        );

        //directory for ress cache
        MJFolder::create("$psoDir/cache/ress");
        MJFolder::create("$psoDir/cache/atfcss");
        MJFolder::create("$psoDir/cache/pagecache/tags");
        MJFolder::create("$psoDir/config");
        MJFolder::create(JPATH_ROOT . '/media/pso/s');

        $path = "$psoDir/cache/dailyrun.stamp";
        if (!is_file($path)) {
            touch($path);
        }

        //update settings
        $settings = new MjSettingsModel($joomlaWrapper);

        $settings->def('ress_optimizer', class_exists(DOMDocument::class, false) ? 'dom' : 'stream');

        $defconfig = json_decode(file_get_contents("$psoDir/defconfig.json"));
        $settings->def($defconfig);

        $distribmode = $settings->get('distribmode');
        if ($distribmode === null) {
            $settings->set('distribmode', 'php');
            if (isset($_SERVER['SERVER_SOFTWARE'])
                && function_exists('apache_get_modules')
                && strpos($_SERVER['SERVER_SOFTWARE'], 'Apache/') !== false
            ) {
                $apache_modules = apache_get_modules();
                if (in_array('mod_rewrite', $apache_modules, true)) {
                    if (in_array('mod_mime', $apache_modules, true) && in_array('mod_headers', $apache_modules, true)) {
                        $settings->set('distribmode', 'apache');
                    } else {
                        $settings->set('distribmode', 'apachephp');
                    }
                }
            }
        }

        $updates_dir = "$psoDir/updates";
        if (empty($prev_version)) { // first install
            $settings->set('html_minifyurl', $joomlaWrapper->getConfig('sef') && $joomlaWrapper->getConfig('sef_rewrite') ? '1' : '0');
        } else { // update from previous version
            /** @var string[]|false $updates */
            $updates = scandir($updates_dir, SCANDIR_SORT_NONE);
            usort($updates, 'version_compare');
            foreach ($updates as $file) {
                if (preg_match('/^(\d.*)\.php$/', $file, $match)) {
                    $version = $match[1];
                    if (version_compare($version, $prev_version, '>')) {
                        include "{$updates_dir}/{$version}.php";
                    }
                }
            }
        }
        // empty updates directory
        MJFolder::delete($updates_dir);
        MJFolder::create($updates_dir);

        $settings->set('desktop_url', MJUri::root());

        // check for GD2 library
        if (!function_exists('imagecopyresized')) {
            MJFactory::getApplication()->enqueueMessage(MJText::_('COM_PSO__GD2_LIBRARY_IS_NOT_LOADED'), 'warning');
        }

        $settings->save(false);

        return true;
    }
}
