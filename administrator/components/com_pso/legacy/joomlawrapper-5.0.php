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

JLoader::registerAlias('MJBrowser', Joomla\CMS\Environment\Browser::class);
JLoader::registerAlias('MJComponentHelper', Joomla\CMS\Component\ComponentHelper::class);
JLoader::registerAlias('MJDocumentHtml', Joomla\CMS\Document\HtmlDocument::class);
JLoader::registerAlias('MJFactory', Joomla\CMS\Factory::class);
JLoader::registerAlias('MJFile', Joomla\Filesystem\File::class);
JLoader::registerAlias('MJFolder', Joomla\Filesystem\Folder::class);
JLoader::registerAlias('MJHtml', Joomla\CMS\HTML\HTMLHelper::class);
JLoader::registerAlias('MJInstaller', Joomla\CMS\Installer\Installer::class);
JLoader::registerAlias('MJInstallerHelper', Joomla\CMS\Installer\InstallerHelper::class);
JLoader::registerAlias('MJLanguageHelper', Joomla\CMS\Language\LanguageHelper::class);
JLoader::registerAlias('MJModuleHelper', Joomla\CMS\Helper\ModuleHelper::class);
JLoader::registerAlias('MJPluginHelper', Joomla\CMS\Plugin\PluginHelper::class);
JLoader::registerAlias('MJRegistry', Joomla\Registry\Registry::class);
JLoader::registerAlias('MJRoute', Joomla\CMS\Router\Route::class);
JLoader::registerAlias('MJSession', Joomla\CMS\Session\Session::class);
JLoader::registerAlias('MJText', Joomla\CMS\Language\Text::class);
JLoader::registerAlias('MJToolbarHelper', Joomla\CMS\Toolbar\ToolbarHelper::class);
JLoader::registerAlias('MJUri', Joomla\CMS\Uri\Uri::class);
JLoader::registerAlias('MJVersion', Joomla\CMS\Version::class);

class MjJoomlaWrapper50 extends MjJoomlaWrapper
{
    /**
     * @param string $option
     * @return bool
     */
    public function checkACL($option)
    {
        $user = Joomla\CMS\Factory::getApplication()->getIdentity();
        if ($user === null) {
            return false;
        }
        return $user->authorise('core.manage', $option);
    }

    /**
     * @param string $name
     * @param string $default
     * @return string
     */
    public function getRequestVar($name, $default = null)
    {
        return Joomla\CMS\Factory::getApplication()->getInput()->get($name, $default);
    }

    /**
     * @param string $name
     * @param string $default
     * @return string
     */
    public function getRequestWord($name, $default = null)
    {
        return Joomla\CMS\Factory::getApplication()->getInput()->getWord($name, $default);
    }

    /**
     * @param string $name
     * @param string $default
     * @return string
     */
    public function getRequestCmd($name, $default = null)
    {
        return Joomla\CMS\Factory::getApplication()->getInput()->getCmd($name, $default);
    }

    /**
     * @param string $name
     * @param int $default
     * @return int
     */
    public function getRequestInt($name, $default = null)
    {
        return Joomla\CMS\Factory::getApplication()->getInput()->getInt($name, $default);
    }

    /**
     * @param array $list
     */
    public function setRequestVars($list)
    {
        $input = Joomla\CMS\Factory::getApplication()->getInput();
        foreach ($list as $key => $value) {
            $input->set($key, $value);
        }
    }

    /**
     * @return JLanguage
     */
    public function getLanguage()
    {
        return Joomla\CMS\Factory::getApplication()->getLanguage();
    }

    /**
     * @param string $extension
     * @param string $path
     * @return void
     */
    public function loadLanguageFile($extension, $path = JPATH_BASE)
    {
        $lang = Joomla\CMS\Factory::getApplication()->getLanguage();
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

        $db = $this->getDbo();

        $query = $db->getQuery(true);
        $query->select($db->quoteName($nameColumn));
        $query->select($db->quoteName($valueColumn));
        $query->from($table);

        $db->setQuery($query);
        /** @var array $rows */
        $rows = $db->loadAssocList();
        foreach ($rows as $row) {
            $result[$row[$nameColumn]] = $row[$valueColumn];
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
        $db = $this->getDbo();

        $origData = $this->dbSelectAll($table, $nameColumn, $valueColumn);
        foreach ($origData as $key => $value) {
            if (!isset($newData[$key])) {
                $query = $db->getQuery(true);
                $query->delete($table);
                $query->where($db->quoteName($nameColumn) . '=' . $db->quote($key));
                $db->setQuery($query);
                $db->execute();
            }
        }

        foreach ($newData as $key => $value) {
            if (isset($origData[$key])) {
                if ($origData[$key] !== $value) {
                    $query = $db->getQuery(true);
                    $query->update($table);
                    $query->set($db->quoteName($valueColumn) . '=' . $db->quote($value));
                    $query->where($db->quoteName($nameColumn) . '=' . $db->quote($key));
                    $db->setQuery($query);
                    $db->execute();
                }
            } else {
                $query = $db->getQuery(true);
                $query->insert($table);
                $query->set($db->quoteName($nameColumn) . '=' . $db->quote($key));
                $query->set($db->quoteName($valueColumn) . '=' . $db->quote($value));
                $db->setQuery($query);
                $db->execute();
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
        $db = $this->getDbo();

        $query = $db->getQuery(true);
        $query->update('#__extensions');
        $query->set($db->quoteName('enabled') . '=' . ($enabled ? '1' : '0'));
        $query->where($db->quoteName('type') . '=' . $db->quote('plugin'));
        $query->where($db->quoteName('folder') . '=' . $db->quote($group));
        $query->where($db->quoteName('element') . '=' . $db->quote($name));

        $db->setQuery($query);
        return $db->execute();
    }

    /**
     * @param string $table
     * @param int $id
     * @param string $device
     * @return bool
     */
    public function changeState($table, $id, $device)
    {
        $db = $this->getDbo();

        $query = $db->getQuery(true);
        $query->select('COUNT(*)');
        $query->from($db->quoteName($table));
        $query->where($db->quoteName('id') . '=' . (int)$id);
        $query->where($db->quoteName('device') . '=' . $db->quote($device));

        $db->setQuery($query);
        $unpublished = $db->loadResult();

        $query = $db->getQuery(true);
        if ($unpublished) {
            $query->delete($db->quoteName($table));
            $query->where($db->quoteName('id') . '=' . (int)$id);
            $query->where($db->quoteName('device') . '=' . $db->quote($device));
        } else {
            $query->insert($db->quoteName($table));
            $query->columns($db->quoteName(array('id', 'device')));
            $query->values(implode(',', array((int)$id, $db->quote($device))));
        }
        $db->setQuery($query);
        $db->execute();
        return (bool)$unpublished;
    }

    /**
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getConfig($name, $default = null)
    {
        return Joomla\CMS\Factory::getApplication()->get($name, $default);
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    public function setConfig($name, $value)
    {
        return Joomla\CMS\Factory::getApplication()->set($name, $value);
    }

    /**
     * @return JDatabaseDriver
     */
    public function getDbo()
    {
        if (!class_exists(MjQueryBuilder::class, false)) {
            require_once dirname(__DIR__) . '/classes/mjquerybuilder.php';
        }
        return Joomla\CMS\Factory::getContainer()->get('DatabaseDriver');
    }

    /**
     * @param string $name
     * @param string $value
     * @param bool $replace
     */
    public function setHeader($name, $value, $replace = false)
    {
        /** @var JApplicationWeb $app */
        $app = Joomla\CMS\Factory::getApplication();
        $app->setHeader($name, $value, $replace);
    }

    /** @return void */
    public function clearHeaders()
    {
        /** @var JApplicationWeb $app */
        $app = Joomla\CMS\Factory::getApplication();
        $app->clearHeaders();
    }

    /**
     * @param bool $allow
     * @return void
     */
    public function allowCache($allow)
    {
        /** @var JApplicationWeb $app */
        $app = Joomla\CMS\Factory::getApplication();
        $app->allowCache($allow);
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return Joomla\CMS\Factory::getApplication()->getBody();
    }

    /**
     * @param string $content
     * @return void
     */
    public function setBody($content)
    {
        /** @var JApplicationWeb $app */
        $app = Joomla\CMS\Factory::getApplication();
        $app->setBody($content);
    }

    /**
     * @return JDocumentHtml
     */
    public function getDocument()
    {
        return Joomla\CMS\Factory::getApplication()->getDocument();
    }

    /**
     * @return JUser
     */
    public function getUser()
    {
        return Joomla\CMS\Factory::getApplication()->getIdentity();
    }

    /**
     * @return bool
     */
    public function isSite()
    {
        return Joomla\CMS\Factory::getApplication()->isClient('site');
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return Joomla\CMS\Factory::getApplication()->isClient('administrator');
    }

    /**
     * @param string $subject
     * @param string $message
     * @return void
     */
    public function sendMailToAdmins($subject, $message)
    {
        /** @var JApplicationWeb $app */
        $app = Joomla\CMS\Factory::getApplication();
        $mailfrom = $app->get('mailfrom');
        $fromname = $app->get('fromname');
        $db = $this->getDbo();
        $query = new MjQueryBuilder($db);
        $rows = $query
            ->select('id, name, email')
            ->from('#__users')
            ->where($query->qn('sendEmail') . '=1')
            ->where($query->qn('block') . '=0')
            ->loadObjectList();

        $userFactory = Joomla\CMS\Factory::getContainer()->get(Joomla\CMS\User\UserFactoryInterface::class);
        $mailer = Joomla\CMS\Factory::getMailer();
        foreach ($rows as $row) {
            if ($userFactory->loadUserById($row->id)->authorise('core.create', 'com_users')) {
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
        return Joomla\CMS\Application\ApplicationHelper::getHash($seed);
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
        $options = array(
            'defaultgroup' => $group,
            'lifetime' => $ttl / 60,
            'cachebase' => $cachebase !== null ? $cachebase : $this->getConfig('cache_path'),
            'storage' => $this->getConfig('cache_handler', 'file')
        );
        return Joomla\CMS\Factory::getContainer()->get(Joomla\CMS\Cache\CacheControllerFactoryInterface::class)->createCacheController($type, $options);
    }

    /**
     * @return string
     */
    public function getCACertPath()
    {
        return JPATH_LIBRARIES . '/vendor/composer/ca-bundle/res/cacert.pem';
    }
}