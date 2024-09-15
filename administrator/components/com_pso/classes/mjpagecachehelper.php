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
class MjPagecacheHelper
{
    /**
     * @param bool $enabled
     */
    public static function updateConfig($enabled)
    {
        include_once JPATH_ADMINISTRATOR . '/components/com_pso/classes/mjhelper.php';

        $joomlaWrapper = MjJoomlaWrapper::getInstance();
        $settings = new MjSettingsModel($joomlaWrapper);

        // Update pagecache.json config
        $configDir = JPATH_ADMINISTRATOR . '/components/com_pso/config';

        $params_skip = self::splitLines($settings->get('pagecache_params_skip'));

        $cookies_disable = self::splitLines($settings->get('pagecache_cookies_disable'));
        $cookies_disable_std = array(
            'mjnopagecache',
            'joomla_user_state',
            $joomlaWrapper->getHash('JLOGIN_REMEMBER'), // Joomla! 2.5-3.1
            $joomlaWrapper->getHash(version_compare(JVERSION, '3.1', '>=') ? 'PlgSystemLogout' : 'plgSystemLogout')
        );

        $cookies_depend = self::splitLines($settings->get('pagecache_cookies_depend'));
        $cookies_depend_std = array(
            $joomlaWrapper->getHash('language')
        );

        $http_depend = self::splitLines($settings->get('pagecache_http_depend'));
        foreach ($http_depend as $i => $http_header_name) {
            if ($http_header_name !== '') {
                $http_depend[$i] = 'HTTP_' . strtoupper(strtr(trim($http_header_name), '-', '_'));
            }
        }

        $pagecacheConfig = array(
            'enabled' => $settings->get('enabled') && $enabled,
            'ttl' => (int)$settings->get('pagecache_ttl'),
            'devicedependent' => false,
            'params_skip' => $params_skip,
            'cookies_disable' => array_merge($cookies_disable_std, $cookies_disable),
            'cookies_depend' => array_merge($cookies_depend_std, $cookies_depend),
            'http_depend' => $http_depend,
        );
        MjHelper::saveJSON($configDir . '/pagecache.json', $pagecacheConfig);
    }

    /**
     * @param string $tag
     * @return void
     */
    public static function updateTag($tag)
    {
        include_once JPATH_ADMINISTRATOR . '/components/com_pso/ress/classes/pagecache.php';
        include_once JPATH_ADMINISTRATOR . '/components/com_pso/pagecache/mjpagecache.php';
        $mjPageCache = new MjPageCache(false);
        if ($mjPageCache->enabled) {
            $mjPageCache->updateTag($tag);
        }
    }

    /**
     * @param bool $enabled
     * @return void
     */
    public static function updateQuickCache($enabled)
    {
        $definesPhp = JPATH_ROOT . '/defines.php';
        // Note: shipped defines.php may be changed between MJ released, so we cannot rely on the content equality
        $isCustomFile = is_file($definesPhp) && strpos(file_get_contents($definesPhp), 'com_pso') === false;
        if ($isCustomFile) {
            return;
        }

        if ($enabled) {
            @copy(JPATH_ADMINISTRATOR . '/components/com_pso/pagecache/defines.php', $definesPhp);
        } else {
            if (is_file($definesPhp)) {
                @unlink($definesPhp);
            }
        }
    }

    /**
     * @param string $text
     * @return string[]
     */
    public static function splitLines($text)
    {
        return array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $text)));
    }
}
