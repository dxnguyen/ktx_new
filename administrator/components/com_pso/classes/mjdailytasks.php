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
class MjDailyTasks
{
    /**
     * @param MjSettingsModel $settings
     * @return void
     */
    public static function execute($settings)
    {
        $psoPath = JPATH_ADMINISTRATOR . '/components/com_pso';
        $lockpath = $psoPath . '/cache/update.lock';
        $lock = @mkdir($lockpath, 0777, true);
        if (!$lock) {
            // check timestamp -> remove dir if 2+ hours difference
            if (@filemtime($lockpath) < time() - 2 * 3600) {
                @rmdir($lockpath);
            }
            return;
        }

        ignore_user_abort(true);
        flush();
        if (session_id()) {
            session_write_close();
        }
        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        } elseif (function_exists('litespeed_finish_request')) {
            litespeed_finish_request();
        }

        set_time_limit(200);

        self::setNextRunTime($settings);

        include_once $psoPath . '/ress/ressio.php';
        Ressio::registerAutoloading(true);

        include_once $psoPath . '/classes/mjhelper.php';
        $config = MjHelper::loadJSON($psoPath . '/config/cron.json');
        $ressio = is_array($config) ? new Ressio($config) : null;

        $update_mode = (int)$settings->get('autoupdate');
        $email_mode = (int)$settings->get('updatenotify');
        if ($update_mode || $email_mode) {
            self::checkUpdates($settings);
        }
        if ($ressio) {
            self::clearExpiredCache($ressio);
        }
        self::clearExpiredPageCache($settings);

        if ($settings->get('css_atfautoupdate')) {
            self::updateATFCSS($settings);
        }

        if ($ressio && $settings->get('pagecache_autowarm')) {
            self::warmPageCache($settings, $ressio);
        }

        if ($settings->get('anonymous_stats')) {
            self::sendAnonymousStats($settings);
        }

        @rmdir($lockpath);
    }

    /**
     * @return int
     */
    public static function getNextRunTime()
    {
        $path = JPATH_ADMINISTRATOR . '/components/com_pso/cache/dailyrun.stamp';
        return is_file($path) ? (int)filemtime($path) : 0;
    }

    /**
     * @param MjSettingsModel $settings
     * @return void
     */
    protected static function setNextRunTime($settings)
    {
        $current_run_time = self::getNextRunTime();
        $tomorrow_run_time = strtotime('tomorrow', $current_run_time);
        $tomorrow_run_time = max($tomorrow_run_time, strtotime('today'));

        $offset = $settings->get('dailyrun_time', '');
        if ($offset === '') {
            $offset = '00:00';
        }
        $next_run_time = strtotime($offset, $tomorrow_run_time);

        $path = JPATH_ADMINISTRATOR . '/components/com_pso/cache/dailyrun.stamp';
        touch($path, $next_run_time);
    }

    /**
     * @param MjSettingsModel $settings
     * @return void
     */
    protected static function checkUpdates($settings)
    {
        include_once JPATH_ADMINISTRATOR . '/components/com_pso/classes/mjupdate.php';

        $updates = MjUpdate::checkUpdates();
        if ($updates === null) {
            return;
        }
        foreach ($updates as $manifest => $dummy) {
            self::checkUpdate($manifest, $settings);
        }
    }

    /**
     * @param Ressio $ressio
     * @return void
     */
    protected static function clearExpiredCache($ressio)
    {
        new Ressio_Plugin_FilecacheCleaner($ressio->di, null);
    }

    /**
     * @param MjSettingsModel $settings
     * @return void
     */
    protected static function clearExpiredPageCache($settings)
    {
        global $mjPageCache;
        if (!isset($mjPageCache)) {
            include_once JPATH_ADMINISTRATOR . '/components/com_pso/ress/classes/pagecache.php';
            include_once JPATH_ADMINISTRATOR . '/components/com_pso/pagecache/mjpagecache.php';
            $mjPageCache = new MjPageCache(false);
        }
        if ($mjPageCache->enabled) {
            $ttl = (int)$settings->get('ress_caching_ttl');
            $mjPageCache->purgeCache($ttl);
        }
    }

    /**
     * @param MjSettingsModel $settings
     * @return void
     */
    protected static function updateATFCSS($settings)
    {
        $global_css_atf = $settings->get('css_atf') === '1';
        $global_css_atflocal = $settings->get('css_atflocal') !== '0';

        if (!$global_css_atf || $global_css_atflocal) {
            return;
        }
        $homepage = $settings->get('desktop_url');

        $data = array(
            'url' => $homepage . '?pso=no',
            'apikey' => $settings->get('apikey')
        );
        $url = 'https://api.mobilejoomla.com/getatfcss?' . http_build_query($data);
        $context = array(
            'http' => array(
                'method' => 'POST',
                'timeout' => 60,
                'ignore_errors' => true,
            )
        );
        if ($settings->get('cacert')) {
            $context['ssl'] = array(
                'cafile' => MjJoomlaWrapper::getInstance()->getCACertPath(),
                'verify_depth' => 5,
                'verify_peer' => true,
                'verify_peer_name' => true,
            );
        }
        $css = @file_get_contents($url, false, stream_context_create($context));

        $max_mj_atfcss_length = 131072;
        if (!is_string($css) || strlen($css) > $max_mj_atfcss_length) {
            $css = '';
        }

        $settings->saveATFCSS('/', '', $css);

        $settings->save(false);
    }

    /**
     * @param MjSettingsModel $settings
     * @param Ressio $ressio
     * @return void
     */
    protected static function warmPageCache($settings, $ressio)
    {
        //if ($settings->get('collect_psi')) {
        //    $psiActor = array('mjLoadPSI', array('url' => ''));
        //}

        $desktop_headers = array(
            'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4590.2 Safari/537.36'
        );

        $rootUri = MJUri::getInstance()->toString();

        include_once JPATH_ADMINISTRATOR . '/components/com_pso/classes/mjpagecachehelper.php';
        $urls = MjPagecacheHelper::splitLines($settings->get('pagecache_autowarm_urls'));
        if (count($urls) === 0) {
            $urls = array('/');
        }

        foreach ($urls as $url) {
            $page = rtrim($rootUri, '/') . '/' . ltrim($url, '/');

            $params = array('url' => $page, 'headers' => $desktop_headers);
            // load PSI?
            //if (isset($psiActor)) {
            //    $psiActor[1]['url'] = $page;
            //    $params['then'] = $psiActor;
            //}
            $ressio->di->worker->runTask('urlDownload', $params);
        }
    }

    /**
     * @param string $manifest
     * @param MjSettingsModel $settings
     * @return void
     */
    protected static function checkUpdate($manifest, $settings)
    {
        $result = MjUpdate::check($manifest);
        if (isset($result['error']) || !isset($result['url'])) {
            return;
        }

        $package_name = $result['package_name'];
        $new_version = $result['new_version'];
        $url = $result['url'];

        if ($package_name === 'pagespeedoptimizer') {
            $package_name = 'Page Speed Optimizer';
        }

        // Check the host is mobilejoomla.com (to avoid xml manifest modification by a malware)
        $host = parse_url($url, PHP_URL_HOST);
        if ($host !== 'update.mobilejoomla.com') {
            return;
        }

        $update_mode = (int)$settings->get('autoupdate');
        $email_mode = (int)$settings->get('updatenotify');

        if ($update_mode) {
            // auto update
            $apikey = $settings->get('apikey');
            if (!empty($apikey)) {
                $url .= (strpos($url, '?') !== false) ? '&' : '?';
                $url .= 'apikey=' . $apikey;
            }

            $packagefile = MjUpdate::download($url);
            if ($packagefile === false) {
                return;
            }

            $extractdir = MjUpdate::unpack($packagefile);
            if ($extractdir === false) {
                return;
            }

            $updated = MjUpdate::install($extractdir);

            // send notification email(s)
            if ($updated && $email_mode) {
                $replaces = array(
                    '[PACKAGE]' => $package_name,
                    '[VERSION]' => $new_version,
                    '[URL]' => MJUri::root() . 'administrator/'
                );
                $search = array_keys($replaces);
                $replace = array_values($replaces);

                $joomlaWrapper = MjJoomlaWrapper::getInstance();

                $joomlaWrapper->loadLanguageFile('com_pso', JPATH_ADMINISTRATOR);
                $subject = str_replace($search, $replace, MJText::_('COM_PSO__UPDATE_EMAIL_NOTIFICATION_SUBJECT'));
                $message = str_replace($search, $replace, MJText::_('COM_PSO__UPDATE_EMAIL_NOTIFICATION_MESSAGE'));

                $joomlaWrapper->sendMailToAdmins($subject, $message);
            }
        } elseif ($email_mode) {
            // send email notification
            $replaces = array(
                '[PACKAGE]' => $package_name,
                '[VERSION]' => $new_version,
                '[URL]' => MJUri::root()
            );
            $search = array_keys($replaces);
            $replace = array_values($replaces);

            $joomlaWrapper = MjJoomlaWrapper::getInstance();

            $joomlaWrapper->loadLanguageFile('com_pso', JPATH_ADMINISTRATOR);
            $subject = str_replace($search, $replace, MJText::_('COM_PSO__NEWVERSION_EMAIL_NOTIFICATION_SUBJECT'));
            $message = str_replace($search, $replace, MJText::_('COM_PSO__NEWVERSION_EMAIL_NOTIFICATION_MESSAGE'));

            $joomlaWrapper->sendMailToAdmins($subject, $message);
        }
    }

    /**
     * @param MjSettingsModel $settings
     * @return void
     */
    protected static function sendAnonymousStats($settings)
    {
        include_once __DIR__ . '/mjtelemetry.php';
        $stats = MjTelemetry::getStatsData($settings);
        $context = array(
            'http' => array(
                'method' => 'POST',
                'content' => json_encode($stats),
                'header' => "Content-Type: application/json\r\n",
                'timeout' => 10,
                'ignore_errors' => true,
            )
        );
        if ($settings->get('cacert')) {
            $context['ssl'] = array(
                'cafile' => MjJoomlaWrapper::getInstance()->getCACertPath(),
                'verify_depth' => 5,
                'verify_peer' => true,
                'verify_peer_name' => true,
            );
        }
        @file_get_contents('https://api.mobilejoomla.com/savestats', false, stream_context_create($context));
    }

}