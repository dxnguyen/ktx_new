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
abstract class MjJoomlaWrapper
{
    /**
     * @return MjJoomlaWrapper
     */
    public static function getInstance()
    {
        static $joomlaWrapper;

        if ($joomlaWrapper === null) {
            $legacy = array('5.0', '4.0', '3.0', '2.5');

            foreach ($legacy as $version) {
                if (version_compare(JVERSION, $version, '>=')) {
                    require_once __DIR__ . "/joomlawrapper-{$version}.php";
                    $className = 'MjJoomlaWrapper' . str_replace('.', '', $version);
                    $joomlaWrapper = new $className();
                    break;
                }
            }

            if ($joomlaWrapper === null) {
                die('MJ: NO WRAPPER FOUND FOR THIS JOOMLA VERSION!');
            }
        }

        return $joomlaWrapper;
    }

    /**
     * @param string $option
     * @return bool
     */
    abstract public function checkACL($option);

    /**
     * @param string $name
     * @param string $default
     * @return string
     */
    abstract public function getRequestVar($name, $default = null);

    /**
     * @param string $name
     * @param string $default
     * @return string
     */
    abstract public function getRequestWord($name, $default = null);

    /**
     * @param string $name
     * @param string $default
     * @return string
     */
    abstract public function getRequestCmd($name, $default = null);

    /**
     * @param string $name
     * @param int $default
     * @return int
     */
    abstract public function getRequestInt($name, $default = null);

    /**
     * @param array $list
     */
    abstract public function setRequestVars($list);

    /**
     * @return JLanguage
     */
    abstract public function getLanguage();

    /**
     * @param string $extension
     * @param string $path
     * @return void
     */
    abstract public function loadLanguageFile($extension, $path = JPATH_BASE);

    /**
     * @param string $table
     * @param string $nameColumn
     * @param string $valueColumn
     * @return array
     */
    abstract public function dbSelectAll($table, $nameColumn = 'name', $valueColumn = 'value');

    /**
     * @param array $newData
     * @param string $table
     * @param string $nameColumn
     * @param string $valueColumn
     * @return bool
     */
    abstract public function dbSaveAll($newData, $table, $nameColumn = 'name', $valueColumn = 'value');

    /**
     * @param bool $enabled
     * @param string $group
     * @param string $name
     * @return bool
     */
    abstract public function togglePlugin($enabled, $group, $name);

    /**
     * @param string $table
     * @param int $id
     * @param string $device
     * @return bool
     */
    abstract public function changeState($table, $id, $device);

    /**
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    abstract public function getConfig($name, $default = null);

    /**
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    abstract public function setConfig($name, $value);

    /**
     * @return JDatabaseDriver
     */
    abstract public function getDbo();

    /**
     * @param string $name
     * @param string $value
     * @param bool $replace
     * @return void
     */
    abstract public function setHeader($name, $value, $replace = false);

    /** @return void */
    abstract public function clearHeaders();

    /**
     * @param bool $allow
     * @return void
     */
    abstract public function allowCache($allow);

    /**
     * @return string
     */
    abstract public function getBody();

    /**
     * @param string $content
     * @return void
     */
    abstract public function setBody($content);

    /**
     * @return JDocumentHtml
     */
    abstract public function getDocument();

    /**
     * @return JUser
     */
    abstract public function getUser();

    /**
     * @return bool
     */
    abstract public function isSite();

    /**
     * @return bool
     */
    abstract public function isAdmin();

    /**
     * @param string $subject
     * @param string $message
     * @return void
     */
    abstract public function sendMailToAdmins($subject, $message);

    /**
     * @param string $seed
     * @return string
     */
    abstract public function getHash($seed);

    /**
     * @param string $type
     * @param string $group
     * @param int $ttl
     * @param ?string $cachebase
     * @return JCacheController
     */
    abstract public function getCache($type, $group, $ttl, $cachebase = null);

    /**
     * @return string
     */
    abstract public function getCACertPath();
}
