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

JLoader::registerAlias('MJBrowser', JBrowser::class);
JLoader::registerAlias('MJComponentHelper', JComponentHelper::class);
JLoader::registerAlias('MJDocumentHtml', JDocumentHtml::class);
JLoader::registerAlias('MJFactory', JFactory::class);
JLoader::registerAlias('MJFile', JFile::class);
JLoader::registerAlias('MJFolder', JFolder::class);
JLoader::registerAlias('MJHtml', JHtml::class);
JLoader::registerAlias('MJInstaller', JInstaller::class);
JLoader::registerAlias('MJInstallerHelper', JInstallerHelper::class);
JLoader::registerAlias('MJLanguageHelper', JLanguageHelper::class);
JLoader::registerAlias('MJModuleHelper', JModuleHelper::class);
JLoader::registerAlias('MJPluginHelper', JPluginHelper::class);
JLoader::registerAlias('MJRegistry', JRegistry::class);
JLoader::registerAlias('MJRoute', JRoute::class);
JLoader::registerAlias('MJSession', JSession::class);
JLoader::registerAlias('MJText', JText::class);
JLoader::registerAlias('MJToolbarHelper', JToolbarHelper::class);
JLoader::registerAlias('MJUri', JUri::class);
JLoader::registerAlias('MJVersion', JVersion::class);

class MjJoomlaWrapper25 extends MjJoomlaWrapper
{
    /**
     * @param string $option
     * @return bool
     */
    public function checkACL($option)
    {
        return JFactory::getUser()->authorise('core.manage', $option);
    }

    /**
     * @param string $name
     * @param string $default
     * @return string
     */
    public function getRequestVar($name, $default = null)
    {
        return JRequest::getVar($name, $default);
    }

    /**
     * @param string $name
     * @param string $default
     * @return string
     */
    public function getRequestWord($name, $default = null)
    {
        return JRequest::getWord($name, $default);
    }

    /**
     * @param string $name
     * @param string $default
     * @return string
     */
    public function getRequestCmd($name, $default = null)
    {
        return JRequest::getCmd($name, $default);
    }

    /**
     * @param string $name
     * @param int $default
     * @return int
     */
    public function getRequestInt($name, $default = null)
    {
        return JRequest::getInt($name, $default);
    }

    /**
     * @param array $list
     */
    public function setRequestVars($list)
    {
        JRequest::set($list, 'get');
    }

    /**
     * @return JLanguage
     */
    public function getLanguage()
    {
        return JFactory::getLanguage();
    }

    /**
     * @param string $extension
     * @param string $path
     * @return void
     */
    public function loadLanguageFile($extension, $path = JPATH_BASE)
    {
        $lang = JFactory::getLanguage();
        $lang->load($extension, $path, 'en-GB', true);
        $lang->load($extension, $path, null, true);
    }

    /**
     * @param string $table
     * @param string $nameColumn
     * @param string $valueColumn
     * @return array
     */
    public function dbSelectAll($table, $nameColumn = 'name', $valueColumn = 'value')
    {
        $result = array();

        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query->select($db->nameQuote($nameColumn));
        $query->select($db->nameQuote($valueColumn));
        $query->from($table);

        $db->setQuery($query);
        /** @var array $rows */
        $rows = $db->loadAssocList();
        if (count($rows)) {
            foreach ($rows as $row) {
                $result[$row[$nameColumn]] = $row[$valueColumn];
            }
        }

        return $result;
    }

    /**
     * @param array $newData
     * @param string $table
     * @param string $nameColumn
     * @param string $valueColumn
     * @return bool
     */
    public function dbSaveAll($newData, $table, $nameColumn = 'name', $valueColumn = 'value')
    {
        $db = JFactory::getDbo();

        $origData = $this->dbSelectAll($table, $nameColumn, $valueColumn);

        foreach ($origData as $key => $value) {
            if (!isset($newData[$key])) {
                $query = $db->getQuery(true);
                $query->delete($table);
                $query->where($db->nameQuote($nameColumn) . '=' . $db->Quote($key));
                $db->setQuery($query);
                $db->query();
            }
        }

        foreach ($newData as $key => $value) {
            if (isset($origData[$key])) {
                if ($origData[$key] !== $value) {
                    $query = $db->getQuery(true);
                    $query->update($table);
                    $query->set($db->nameQuote($valueColumn) . '=' . $db->Quote($value));
                    $query->where($db->nameQuote($nameColumn) . '=' . $db->Quote($key));
                    $db->setQuery($query);
                    $db->query();
                }
            } else {
                $query = $db->getQuery(true);
                $query->insert($table);
                $query->set($db->nameQuote($nameColumn) . '=' . $db->Quote($key));
                $query->set($db->nameQuote($valueColumn) . '=' . $db->Quote($value));
                $db->setQuery($query);
                $db->query();
            }
        }
        return true;
    }

    /**
     * @param bool $enabled
     * @param string $group
     * @param string $name
     * @return bool
     */
    public function togglePlugin($enabled, $group, $name)
    {
        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query->update($db->nameQuote('#__extensions'));
        $query->set($db->nameQuote('enabled') . '=' . ($enabled ? '1' : '0'));
        $query->where($db->nameQuote('type') . '=' . $db->Quote('plugin'));
        $query->where($db->nameQuote('folder') . '=' . $db->Quote($group));
        $query->where($db->nameQuote('element') . '=' . $db->Quote($name));

        $db->setQuery($query);
        return $db->query();
    }

    /**
     * @param string $table
     * @param int $id
     * @param string $device
     * @return bool
     */
    public function changeState($table, $id, $device)
    {
        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query->select('COUNT(*)');
        $query->from($db->nameQuote($table));
        $query->where($db->nameQuote('id') . '=' . (int)$id);
        $query->where($db->nameQuote('device') . '=' . $db->Quote($device));

        $db->setQuery($query);
        $unpublished = $db->loadResult();

        $query = $db->getQuery(true);
        if ($unpublished) {
            $query->delete($db->nameQuote($table));
            $query->where($db->nameQuote('id') . '=' . (int)$id);
            $query->where($db->nameQuote('device') . '=' . $db->Quote($device));
        } else {
            $query->insert($db->nameQuote($table));
            $query->columns($db->nameQuote(array('id', 'device')));
            $query->values(implode(',', array((int)$id, $db->Quote($device))));
        }
        $db->setQuery($query);
        $db->query();
        return (bool)$unpublished;
    }

    /**
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getConfig($name, $default = null)
    {
        $config = JFactory::getConfig();
        return $config->get($name, $default);
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    public function setConfig($name, $value)
    {
        $config = JFactory::getConfig();
        return $config->set($name, $value);
    }

    /**
     * @return JDatabaseDriver
     */
    public function getDbo()
    {
        if (!class_exists(MjQueryBuilder::class, false)) {
            require_once dirname(__DIR__) . '/classes/mjquerybuilder.php';
        }
        return JFactory::getDbo();
    }

    /**
     * @param string $name
     * @param string $value
     * @param bool $replace
     */
    public function setHeader($name, $value, $replace = false)
    {
        JResponse::setHeader($name, $value, $replace);
    }

    /** @return void */
    public function clearHeaders()
    {
        JResponse::clearHeaders();
    }

    /**
     * @param bool $allow
     * @return void
     */
    public function allowCache($allow)
    {
        JResponse::allowCache($allow);
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return JResponse::getBody();
    }

    /**
     * @param string $content
     * @return void
     */
    public function setBody($content)
    {
        JResponse::setBody($content);
    }

    /**
     * @return JDocumentHtml
     */
    public function getDocument()
    {
        return JFactory::getDocument();
    }

    /**
     * @return JUser
     */
    public function getUser()
    {
        return JFactory::getUser();
    }

    /**
     * @return bool
     */
    public function isSite()
    {
        return !JFactory::getApplication()->isAdmin();
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return JFactory::getApplication()->isAdmin();
    }

    /**
     * @param string $subject
     * @param string $message
     * @return void
     */
    public function sendMailToAdmins($subject, $message)
    {
        $app = JFactory::getApplication();
        $mailfrom = $app->getCfg('mailfrom');
        $fromname = $app->getCfg('fromname');
        $db = $this->getDbo();
        $query = new MjQueryBuilder($db);
        $rows = $query
            ->select('id, name, email')
            ->from('#__users')
            ->where($query->qn('sendEmail') . '=1')
            ->where($query->qn('block') . '=0')
            ->loadObjectList();

        foreach ($rows as $row) {
            $user = JFactory::getUser($row->id);
            if ($user->authorise('core.create', 'com_users')) {
                $mailer = JFactory::getMailer();
                $mailer->sendMail($mailfrom, $fromname, $row->email, $subject, $message);
            }
        }
    }

    /**
     * @param string $seed
     * @return string
     */
    public function getHash($seed)
    {
        return JApplication::getHash($seed);
    }

    /**
     * @param string $type
     * @param string $group
     * @param int $ttl
     * @param ?string $cachebase
     * @return JCacheController
     */
    public function getCache($type, $group, $ttl, $cachebase = null)
    {
        jimport('joomla.cache.cache');
        $options = array(
            'defaultgroup' => $group,
            'lifetime' => $ttl / 60,
            'cachebase' => $cachebase !== null ? $cachebase : $this->getConfig('cache_path'),
            'storage' => $this->getConfig('cache_handler', 'file')
        );
        return JCache::getInstance($type, $options);
    }

    /**
     * @return string
     */
    public function getCACertPath()
    {
        return JPATH_LIBRARIES . '/joomla/http/transport/cacert.pem';
    }
}