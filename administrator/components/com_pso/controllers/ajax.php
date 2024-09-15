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

jimport('joomla.cache.cache');
require_once JPATH_COMPONENT . '/classes/mjcontroller.php';

class MjAjaxController extends MjBaseController
{
    /** @return void */
    public function redirect()
    {
        // exit instead of redirect processing
        MJFactory::getApplication()->close();
        jexit();
    }

    /** @return void */
    public function display()
    {
        header('Content-Type: application/json');
        $viewName = $this->joomlaWrapper->getRequestWord('view', 'default');
        echo $this->renderView($viewName);
    }

    /** @return void */
    public function check_updates()
    {

        $this->joomlaWrapper->loadLanguageFile('com_pso.sys');

        include_once JPATH_COMPONENT . '/classes/mjupdate.php';
        $manifests = MjUpdate::getManifests();
        $updates = MjUpdate::checkUpdates(true);

        $response = new stdClass();
        $response->updates = array();
        $latest_by_type = array();
        foreach ($manifests as $type => $files) {
            $latest_version = '';
            foreach ($files as $manifest) {
                if (is_file($manifest)) {
                    $xml = simplexml_load_file($manifest);
                    $current_version = (string)$xml->version;
                    if (isset($updates[$manifest])) {
                        $new_version = $updates[$manifest];
                        if (version_compare($new_version, $latest_version, '>')) {
                            $latest_version = $new_version;
                        }
                        if (version_compare($new_version, $current_version, '>')) {
                            $response->updates[] = array(
                                'hash' => sha1($manifest),
                                'title' => MJText::_((string)$xml->name),
                                'version' => $new_version,
                            );
                        }
                    }
                }
            }
            $latest_by_type[$type] = $latest_version;
        }

        $latest_version = $latest_by_type['free'];
        if (MJPluginHelper::isEnabled('pso', 'psopro')) {
            if (version_compare($latest_by_type['pro'], $latest_version, '>')) {
                $latest_version = $latest_by_type['pro'];
            }
            $latest_version = 'Pro ' . $latest_version;
        }
        $response->latest = $latest_version;

        echo json_encode($response);
        jexit();
    }

    /**
     * @param string $path
     * @return void
     */
    protected function clearDirectory($path)
    {
        if (!is_dir($path)) {
            return;
        }

        $files = MJFolder::files($path, '.', false, true, array('.htaccess'), array());
        if (!empty($files)) {
            MJFile::delete($files);
        }
        $folders = MJFolder::folders($path, '.', false, true, array(), array());
        foreach ($folders as $folder) {
            if (is_link($folder)) {
                MJFile::delete($folder);
            } else {
                MJFolder::delete($folder);
            }
        }
    }

    /** @return void */
    public function clear_images()
    {
        include_once JPATH_COMPONENT . '/models/settings.php';
        $settings = new MjSettingsModel($this->joomlaWrapper);

        $staticdir = JPATH_ROOT . $settings->get('staticdir');
        $imgDir = $staticdir . '/img';
        $this->clearDirectory($imgDir);
    }

    /** @return void */
    public function clear_imagesrescaled()
    {
        include_once JPATH_COMPONENT . '/models/settings.php';
        $settings = new MjSettingsModel($this->joomlaWrapper);

        $staticdir = JPATH_ROOT . $settings->get('staticdir');
        $imgRescaledDir = $staticdir . '/img-r';
        $this->clearDirectory($imgRescaledDir);
    }

    /** @return void */
    public function clear_imageslqip()
    {
        include_once JPATH_COMPONENT . '/models/settings.php';
        $settings = new MjSettingsModel($this->joomlaWrapper);

        $staticdir = JPATH_ROOT . $settings->get('staticdir');
        $imgLQIPDir = $staticdir . '/img-lqip';
        $this->clearDirectory($imgLQIPDir);
    }

    /**
     * @param int $ttl (seconds)
     * @return void
     */
    protected function clear_cache($ttl)
    {
        include_once JPATH_COMPONENT . '/models/settings.php';
        $settings = new MjSettingsModel($this->joomlaWrapper);

        if (!class_exists(Ressio::class, false)) {
            include_once dirname(__DIR__) . '/ress/ressio.php';
        }

        try {
            Ressio::registerAutoloading(true);
        } catch (Exception $e) {
            trigger_error("Caught exception 'Exception' with message '" . $e->getMessage() . "' in " . $e->getFile() . ':' . $e->getLine());
            return;
        }

        $di = new Ressio_DI();
        $di->set('config', new stdClass());
        $di->set('filesystem', Ressio_Filesystem_Native::class);
        $di->set('filelock', Ressio_FileLock_flock::class);
        $di->config->cachedir = JPATH_COMPONENT . '/cache/ress';
        $di->config->cachettl = $ttl;
        $di->config->webrootpath = JPATH_ROOT;
        $di->config->staticdir = $settings->get('staticdir');
        $di->config->change_group = null;

        $lock = $di->config->cachedir . '/filecachecleaner.stamp';
        @unlink($lock);

        new Ressio_Plugin_FilecacheCleaner($di, null);

        // invalidate page cache (empty cache triggers /s clearing, including files referenced by page cache)
        MJFactory::getApplication()->triggerEvent('onPsoPageCacheTagsUpdate', array('GLOBAL'));
    }

    /** @return void */
    public function clear_cache_expired()
    {
        include_once JPATH_COMPONENT . '/models/settings.php';
        $settings = new MjSettingsModel($this->joomlaWrapper);

        $ttl = (int)$settings->get('ress_caching_ttl');
        $this->clear_cache($ttl);
    }

    /** @return void */
    public function clear_cache_all()
    {
        $this->clear_cache(1);
    }

    /** @return void */
    public function clear_queue_all()
    {
        $db = $this->joomlaWrapper->getDbo();
        $query = new MjQueryBuilder($db);
        $query
            ->delete('#__pso_queue')
            ->execute();
    }

    /**
     * @param int $ttl (seconds)
     * @return void
     */
    protected function clear_pagecache($ttl)
    {
        global $mjPageCache;
        if (!isset($mjPageCache)) {
            include_once JPATH_COMPONENT . '/ress/classes/pagecache.php';
            include_once JPATH_COMPONENT . '/pagecache/mjpagecache.php';
            $mjPageCache = new MjPageCache(false);
        }
        if ($mjPageCache->enabled) {
            $mjPageCache->purgeCache($ttl);
        }
    }

    /** @return void */
    public function clear_pagecache_expired()
    {
        include_once JPATH_COMPONENT . '/models/settings.php';
        $settings = new MjSettingsModel($this->joomlaWrapper);

        $ttl = (int)$settings->get('ress_caching_ttl');
        $this->clear_pagecache($ttl);
    }

    /** @return void */
    public function clear_pagecache_all()
    {
        $this->clear_pagecache(0);
    }
}