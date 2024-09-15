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

include_once dirname(__DIR__) . '/classes/mjmodel.php';
include_once dirname(__DIR__) . '/classes/mjhelper.php';

class MjSettingsModel extends MjModel
{
    /** @var array */
    private $data;
    /** @var stdClass */
    private $defaults;

    /** @var string[] */
    private $arrayBasedOptions = array(
        'exclude_options',
        'exclude_menus',
        'pagecache_exclude_options',
        'pagecache_exclude_menus',
    );

    /**
     * @param MjJoomlaWrapper $joomlaWrapper
     */
    public function __construct($joomlaWrapper)
    {
        parent::__construct($joomlaWrapper);
        $this->data = $this->joomlaWrapper->dbSelectAll('#__pso_settings');

        if ($joomlaWrapper->isAdmin()) {
            jimport('joomla.plugin.helper');
            $this->data['enabled'] = (int)MJPluginHelper::isEnabled('system', 'pso');
            $this->data['pagecache_enabled'] = (int)MJPluginHelper::isEnabled('pso', 'pagecache');
        }

        // toArray
        foreach ($this->arrayBasedOptions as $name) {
            if (isset($this->data[$name])) {
                $this->data[$name] = $this->toArray($this->data[$name]);
            }
        }

        $this->defaults = json_decode(file_get_contents(dirname(__DIR__) . '/defconfig.json'), true);
        $defconfigPro = JPATH_PLUGINS . '/pso/psopro/plugins/defconfig.pro.json';
        if (is_file($defconfigPro)) {
            $this->defaults += json_decode(file_get_contents($defconfigPro), true);
        }
        if (!is_object($this->defaults)) {
            $this->defaults = new stdClass();
        }
    }

    /**
     * Get list of all key-value pairs
     * @return array
     */
    public function getAll()
    {
        return $this->data;
    }

    /**
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function get($name, $default = null)
    {

        if (isset($this->data[$name])) {
            return $this->data[$name];
        }
        if ($default === null && isset($this->defaults->$name)) {
            return $this->defaults->$name;
        }

        return $default;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * @param string $name
     * @return void
     */
    public function remove($name)
    {
        unset($this->data[$name]);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function bind($data)
    {
        foreach ($data as $key => $value) {
            if (strpos($key, '.') > 0 && $value === '' && !preg_match('/\.(?:domain|template)$/', $key)) {
                unset($this->data[$key]);
            } else {
                $this->data[$key] = $value;
            }
        }
        return true;
    }

    /**
     * @param string|array $keys
     * @param mixed $value
     * @return bool
     */
    public function def($keys, $value = null)
    {
        if (is_array($keys) || is_object($keys)) {
            foreach ($keys as $key => $val) {
                if (!isset($this->data[$key])) {
                    $this->data[$key] = $val;
                }
            }
        } elseif (!isset($this->data[$keys])) {
            $this->data[$keys] = $value;
        }
        return true;
    }

    /**
     * @param bool $process_plugins
     * @return bool
     */
    public function save($process_plugins = true)
    {
        $data = $this->data;

        unset(
            $data['enabled'],
            $data['pagecache_enabled']
        );

        if (!empty($data['worker_joomlaconfig'])) {
            $path = $data['worker_joomlaconfig'];
            $path = preg_replace('/[\/\\\\]configuration\.php$/i', '', trim($path));
            $data['worker_joomlaconfig'] = $this->data['worker_joomlaconfig'] = $path;
        }

        // fromArray
        foreach ($this->arrayBasedOptions as $name) {
            if (isset($data[$name])) {
                $data[$name] = $this->fromArray($data[$name]);
            }
        }

        if (substr($data['staticdir'], 0, 1) !== '/') {
            $data['staticdir'] = '/' . $data['staticdir'];
        }

        foreach ($data as $name => $value) {
            if (preg_match('/^([^.]*)\.?css_atfcss$/', $name, $matches)) {
                $device = $matches[1];
                $this->saveATFCSS('/', $device, $value);
                unset($data[$name]);
            }
        }

        $app = MJFactory::getApplication();
        $app->triggerEvent('onPsoSaveConfig', array(&$data));

        if (!$this->joomlaWrapper->dbSaveAll($data, '#__pso_settings')) {
            return false;
        }

        if (!$this->joomlaWrapper->isAdmin()) {
            // Update from MjDailyTasks
            return true;
        }

        $configDir = JPATH_ADMINISTRATOR . '/components/com_pso/config';

        // Cron config
        $cronConfig = MjHelper::generateBaseRessioConfig($data);
        switch ($this->joomlaWrapper->getConfig('dbtype')) {
            case 'mysql':
            case 'mysqli':
            case 'pdomysql':
                $cronConfig['di']['worker'] = Ressio_Worker_MySQL::class;
                break;
            case 'pgsql':
            case 'postgresql':
                $cronConfig['di']['worker'] = Ressio_Worker_PgSQL::class;
                break;
            default:
                return false;
        }
        MjHelper::saveJSON($configDir . '/cron.json', $cronConfig);


        // clear frontend config caches
        foreach (scandir($configDir, SCANDIR_SORT_NONE) as $filename) {
            if (preg_match('/^ress(?:-\w*)?\.json\.php$/', $filename)) {
                unlink("$configDir/$filename");
            }
        }


        // enable plugins
        if ($process_plugins) {
            /** @var JApplicationAdministrator $app */
            $app = MJFactory::getApplication();
//            if (!$this->joomlaWrapper->togglePlugin($this->data['opt_enabled'], 'system', 'pso')) {
//                $app->enqueueMessage(JText::sprintf('COM_PSO__CANNOT_ENABLE_PLUGIN', 'System - Page Speed Optimizer'), 'error');
//            }
            if (!$this->joomlaWrapper->togglePlugin($this->data['pagecache_enabled'], 'pso', 'pagecache')) {
                $app->enqueueMessage(MJText::sprintf('COM_PSO__CANNOT_ENABLE_PLUGIN', 'Page Speed Optimizer - Page Cache'), 'error');
            }

            $this->cleanCacheGroup('com_plugins');
        }
        $srcDir = JPATH_ADMINISTRATOR . '/components/com_pso/assets/ress';
        if (!is_dir($srcDir)) {
            return false;
        }

        $destDir = JPATH_ROOT . $data['staticdir'];
        jimport('joomla.filesystem.folder');
        MJFolder::create($destDir);
        switch ($data['distribmode']) {
            case '':
                $path = $destDir . '/.htaccess';
                if (is_file($path)) {
                    @unlink($path);
                }
                break;
            case 'php':
                $path = $destDir . '/.htaccess';
                if (is_file($path)) {
                    @unlink($path);
                }
                copy($srcDir . '/f.php.sample', $destDir . '/f.php');
                break;
            case 'apache':
                copy($srcDir . '/sample_apache_static.htaccess', $destDir . '/.htaccess');
                break;
            case 'apachephp':
                copy($srcDir . '/sample_php.htaccess', $destDir . '/.htaccess');
                copy($srcDir . '/f.php.sample', $destDir . '/f.php');
                break;
        }

        $htaccess =
            file_get_contents($srcDir . '/sample_apache_static_subdir.htaccess') . "\n" .
            file_get_contents($srcDir . '/gzip.htaccess') . "\n" .
            file_get_contents($srcDir . '/cache.htaccess') . "\n";
        $subdirs = array('img', 'img-r', 'img-lqip', 'loaded');
        foreach ($subdirs as $subdir) {
            @mkdir("$destDir/$subdir", 0775, true);
            file_put_contents("$destDir/$subdir/.htaccess", $htaccess);
        }

        $htaccess = '';
        if ($data['htaccess_gzip']) {
            $htaccess .= file_get_contents($srcDir . '/gzip.htaccess');
        }
        if ($data['htaccess_caching']) {
            $htaccess .= file_get_contents($srcDir . '/cache.htaccess');
        }
        $this->updateHtaccess(JPATH_ROOT, $htaccess);

        return true;
    }

    /**
     * @param string $page
     * @param string $device
     * @return ?string
     */
    public function getATFCSS($page, $device = '')
    {
        $atfcss_path = $this->getATFCSSPath($page, $device);
        if (!is_file($atfcss_path)) {
            return null;
        }
        return file_get_contents($atfcss_path);
    }

    /**
     * @param string $page
     * @param string $device
     * @param ?string $css
     * @return void
     */
    public function saveATFCSS($page, $device, $css)
    {
        $atfcss_path = $this->getATFCSSPath($page, $device);
        if ($css !== null) {
            file_put_contents($atfcss_path, $css, LOCK_EX);
        } else {
            unlink($atfcss_path);
        }
    }

    /**
     * @param string $page
     * @param string $device
     * @return string
     */
    protected function getATFCSSPath($page, $device)
    {
        return JPATH_ADMINISTRATOR . '/components/com_pso/cache/atfcss/' . md5($page) . '.css';
    }

    /**
     * @param string $str
     * @return string[]
     */
    protected function toArray($str)
    {
        return empty($str) ? array() : explode(',', $str);
    }

    /**
     * @param string[] $list
     * @return string
     */
    protected function fromArray($list)
    {
        if (empty($list)) {
            return '';
        }
        if (isset($list[0]) && $list[0] === '') {
            array_shift($list);
        }
        return implode(',', $list);
    }

    /**
     * @param string $folder
     * @param string $code
     * @return void
     */
    protected function updateHtaccess($folder, $code)
    {
        $filename = "$folder/.htaccess";
        if ($code === '' && !is_file($filename)) {
            return;
        }

        $start_marker = '### BEGIN MJ';
        $end_marker = '### END MJ';

        if ($code !== '') {
            $code = "\n{$start_marker}\n{$code}\n{$end_marker}";
        }

        $htaccess = '' . @file_get_contents($filename);
        if (preg_match("/\\n?^{$start_marker}\$.*?^{$end_marker}\$/ms", $htaccess, $match, PREG_OFFSET_CAPTURE)) {
            $offset = $match[0][1];
            $htaccess = substr($htaccess, 0, $offset) . $code . substr($htaccess, $offset + strlen($match[0][0]));
        } else {
            $htaccess .= $code;
        }

        @file_put_contents($filename, $htaccess, LOCK_EX);
        if ($htaccess === '') {
            @unlink($filename);
        }
    }

    /**
     * @param string $group
     * @return void
     */
    protected function cleanCacheGroup($group)
    {
        try {
            $cachebase = $this->joomlaWrapper->getConfig('cache_path', JPATH_SITE . '/cache');
            $this->joomlaWrapper->getCache('callback', $group, 0, JPATH_ADMINISTRATOR . '/cache')->clean();
            $this->joomlaWrapper->getCache('callback', $group, 0, $cachebase)->clean();
        } catch (JCacheException $exception) {
        } catch (Joomla\CMS\Cache\Exception\CacheExceptionInterface $exception) {
        }
    }
}