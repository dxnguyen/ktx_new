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

require_once JPATH_COMPONENT . '/controllers/settings.php';

class MjDashboardController extends MjSettingsController
{
    /**
     * @param string $msg
     * @return void
     */
    public function save($msg = '')
    {
        require_once JPATH_COMPONENT . '/classes/mjpagecachehelper.php';

        parent::save($msg);

        $settings = new MjSettingsModel($this->joomlaWrapper);

        // generate pagecache.json and tag GLOBAL
        $pagecache_enabled = (bool)$_POST['mj_pagecache_enabled'];
        MjPagecacheHelper::updateConfig($pagecache_enabled);
        MjPagecacheHelper::updateTag('GLOBAL');
        $quickcache_enabled = $pagecache_enabled && $settings->get('pagecache_quick');
        MjPagecacheHelper::updateQuickCache($quickcache_enabled);
    }
}