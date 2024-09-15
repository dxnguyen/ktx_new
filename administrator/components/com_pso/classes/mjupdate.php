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

jimport('joomla.installer.helper');
jimport('joomla.installer.installer');
class MjUpdate
{
    /** @var string[][] */
    protected static $manifests = array(
        'free' => array(
            JPATH_MANIFESTS . '/packages/pkg_pso.xml',
        ),
        'pro' => array(
            JPATH_MANIFESTS . '/packages/pkg_pso_pro.xml',
        ),
    );

    /**
     * @return string[][]
     */
    public static function getManifests()
    {
        return self::$manifests;
    }

    /**
     * @return string[]
     */
    public static function getManifestsList()
    {
        return array_merge(...array_values(self::$manifests));
    }

    /**
     * @param bool $returnAll
     * @return array|null
     */
    public static function checkUpdates($returnAll = false)
    {
        // @note self::loadUrl is cacheable
        $list_xml = 'https://update.mobilejoomla.com/pso/list.xml';

        $xml = self::loadUrl($list_xml);
        if ($xml === false) {
            return null;
        }

        $xml = simplexml_load_string($xml);
        if ($xml === false) {
            return null;
        }

        $list_updates = array();
        foreach ($xml->extension as $extension) {
            if ((string)$extension['type'] === 'plugin') {
                $element = $extension['folder'] . '/' . $extension['element'];
            } else {
                $element = (string)$extension['element'];
            }
            $list_updates[$element] = (string)$extension['version'];
        }

        $updates = array();
        foreach (self::getManifestsList() as $manifest) {
            if (is_file($manifest)) {
                $xml = simplexml_load_file($manifest);
                if ($xml) {
                    $current_version = (string)$xml->version;
                    switch ((string)$xml['type']) {
                        case 'component':
                            $element = 'com_' . $xml->name;
                            break;
                        case 'plugin':
                            $element = $xml['group'] . '/' . $xml->xpath('//filename[@plugin]/@plugin')[0];
                            break;
                        case 'module':
                            $element = (string)$xml->xpath('//filename[@module]/@module')[0];
                            break;
                        case 'template':
                            $element = 'tpl_' . $xml->name;
                            break;
                        case 'package':
                            $element = 'pkg_' . $xml->packagename;
                            break;
                        default:
                            continue 2;
                    }
                    if (isset($list_updates[$element])) {
                        if ($returnAll || version_compare($current_version, $list_updates[$element], '<')) {
                            $updates[$manifest] = $list_updates[$element];
                        }
                    } elseif ($xml->updateservers->server !== null) {
                        $update_server = (string)$xml->updateservers->server[0];
                        $update_manifest = self::loadUrl($update_server);
                        $update_xml = simplexml_load_string($update_manifest);
                        if ($update_xml) {
                            $new_version = (string)$update_xml->update[0]->version;
                            if ($returnAll || version_compare($current_version, $new_version, '<')) {
                                $updates[$manifest] = $new_version;
                            }
                        }
                    }
                }
            }
        }

        return $updates;
    }

    /**
     * @param string $url
     * @return string|false
     */
    protected static function loadUrl($url)
    {
        $cache = MjJoomlaWrapper::getInstance()->getCache('', 'com_pso', 3 * 60 * 60);
        if ($cache === null) {
            return false;
        }

        $cache_id = $url;

        $result = $cache->get($cache_id);

        if ($result === false) {
            // just to wait for TTL in the case of error
            $cache->store('', $cache_id);
            if (strncmp($url, 'https', 5) === 0 && !extension_loaded('openssl')) {
                // downgrade to plain HTTP
                $url = 'http' . substr($url, 5);
            }
            $context = stream_context_create(array(
                'http' => array(
                    'follow_location' => true,
                    'ignore_errors' => true,
                    'max_redirects' => 10,
                    'protocol_version' => 1.1,
                    'timeout' => 10,
                    'user_agent' => (new MJVersion())->getUserAgent('MJ/1.4.2')
                )
            ));
            $result = @file_get_contents($url, false, $context);

            $cache->store($result, $cache_id);
        }

        return $result;
    }

    /**
     * @param string $manifest
     * @return array
     */
    public static function check($manifest)
    {
        $xmlManifest = simplexml_load_file($manifest);
        if ($xmlManifest === false || $xmlManifest->updateservers->server === null) {
            return array(
                'error' => 'COM_PSO__ERROR_LOCAL_MANIFEST_NOT_FOUND'
            );
        }

        $current_version = (string)$xmlManifest->version;
        $updateServer = (string)$xmlManifest->updateservers->server[0];

        $xml = self::loadUrl($updateServer);
        if ($xml === false) {
            return array(
                'error' => 'COM_PSO__ERROR_DOWNLOAD_REMOTE_MANIFEST'
            );
        }

        $xml = simplexml_load_string($xml);
        if ($xml === false) {
            return array(
                'error' => 'COM_PSO__ERROR_INVALID_REMOTE_MANIFEST'
            );
        }

        if ($xml->getName() !== 'extensionset') {
            $new_version = (string)$xml->update->version;
        } else {
            $type = (string)$xmlManifest['type'];
            $folder = '';
            switch ($type) {
                case 'component':
                    $element = 'com_' . $xmlManifest->name;
                    break;
                case 'plugin':
                    $folder = (string)$xmlManifest['group'];
                    $element = (string)$xmlManifest->xpath('//filename[@plugin]/@plugin')[0];
                    break;
                case 'module':
                    $element = (string)$xmlManifest->xpath('//filename[@module]/@module')[0];
                    break;
                case 'package':
                    $element = 'pkg_' . $xmlManifest->packagename;
                    break;
            }
            foreach ($xml->extension as $update) {
                if ((string)$update['type'] === $type && (string)$update['element'] === $element && (string)$update['folder'] === $folder) {
                    $new_version = (string)$update['version'];
                    if (version_compare($current_version, $new_version, '<')) {
                        $updateServer = (string)$update['detailsurl'];
                        $xml = self::loadUrl($updateServer);
                        if ($xml === false) {
                            return array(
                                'error' => 'COM_PSO__ERROR_DOWNLOAD_REMOTE_MANIFEST'
                            );
                        }
                        $xml = simplexml_load_string($xml);
                        if ($xml === false) {
                            return array(
                                'error' => 'COM_PSO__ERROR_INVALID_REMOTE_MANIFEST'
                            );
                        }
                    }
                    break;
                }
            }
        }

        $result = array(
            'package_name' => (string)$xmlManifest->name,
            'current_version' => $current_version,
            'new_version' => $new_version
        );

        if (version_compare($current_version, $new_version, '<')) {
            $url = null;
            foreach ($xml->update as $update) {
                if (preg_match('/^' . $update->targetplatform['version'] . '/', JVERSION)) {
                    $url = (string)$update->downloads->downloadurl;
                    break;
                }
            }
            if ($url !== null) {
                $result['url'] = $url;
            }
        }

        return $result;
    }

    /**
     * @param string $url
     * @return string|false
     */
    public static function download($url)
    {
        try {
            $tmp_filename = MJInstallerHelper::downloadPackage($url);
        } catch (Exception $e) {
            $tmp_filename = false;
        }
        return $tmp_filename;
    }

    /**
     * @param string $tmp_filename
     * @return string|false
     */
    public static function unpack($tmp_filename)
    {
        $dir = false;
        try {
            if (version_compare(JVERSION, '4.0', '>=')) {
                $tmp_path = MJFactory::getApplication()->get('tmp_path');
            } else {
                $tmp_path = JFactory::getConfig()->get('tmp_path');
            }
            $path = "$tmp_path/$tmp_filename";
            $result = MJInstallerHelper::unpack($path);
            if ($result !== false) {
                /** @var array $result */
                $dir = $result['dir'];
            }
            MJFile::delete($path);
        } catch (Exception $e) {
        }
        return $dir;
    }

    /**
     * @param string $dir
     * @return bool
     */
    public static function install($dir)
    {
        try {
            (new MJInstaller())->install($dir);
            MJFolder::delete($dir);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }
}