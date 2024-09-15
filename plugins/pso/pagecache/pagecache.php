<?php
/**
 * Page Speed Optimizer extension
 * https://www.mobilejoomla.com/
 *
 * @version    1.4.1
 * @license    GNU/GPL v2 - http://www.gnu.org/licenses/gpl-2.0.html
 * @copyright  (C) 2022-2024 Denis Ryabov
 * @date       June 2024
 */
defined('_JEXEC') or die('Restricted access');

include_once JPATH_ADMINISTRATOR . '/components/com_pso/legacy/proem.php';

jimport('joomla.environment.uri');

class plgPsoPageCache extends MJPlugin
{
    /** @var MjSettingsModel */
    private $settings;

    /** @var MjJoomlaWrapper */
    private $joomlaWrapper;

    /** @var MjPageCache */
    private $mjPageCache;

    /** @var bool */
    private $hasExtraSupport;

    /** @var bool */
    private $hasDefaultSupport;

    /** @var string[] */
    private static $defaultComponents = array(
        'com_banners',
        'com_contact',
        'com_content',
        'com_finder',
        'com_newsfeeds',
        'com_search',
        'com_tags',
    );

    /**
     * @param MjSettingsModel $settings
     * @return void
     */
    public function onMobileInitialise($settings)
    {
        $this->settings = $settings;
        $this->joomlaWrapper = $settings->joomlaWrapper;

        global $mjPageCache;
        $this->mjPageCache = isset($mjPageCache) ? $mjPageCache : $this->getPageCacheInstance();

        if (!$this->joomlaWrapper->isSite()) {
            return;
        }

        if (isset($_GET['option'], $_GET['task']) &&
            $_GET['option'] === 'com_pso' &&
            $_GET['task'] === 'getcsrf'
        ) {
            header('Content-Type: text/plain');
            // Browsers don't allow to get this response content from hacker's domain javascript
            // But anyway, we do extra check for the Referer header matches the Host header
            if (!isset($_SERVER['HTTP_REFERER']) || MJUri::getInstance($_SERVER['HTTP_REFERER'])->getHost() === $_SERVER['HTTP_HOST']) {
                echo MJSession::getFormToken();
            }
            MJFactory::getApplication()->close();
            exit(0);
        }

        if (isset($_POST['MJCSRF'])) {
            // If POST request contains MJCSRF field => disable caching for this user
            /** @var JApplicationSite $app */
            $app = MJFactory::getApplication();
            $options = array(
                'expires' => time() + 365 * 86400, // 1 year
                'path' => $this->joomlaWrapper->getConfig('cookie_path', '/'),
                'domain' => $this->joomlaWrapper->getConfig('cookie_domain', ''),
                'secure' => $this->joomlaWrapper->getConfig('force_ssl', 0) === 2,
                'httponly' => true,
            );
            if (version_compare(JVERSION, '3.9', '>=')) {
                $app->input->cookie->set('mjnopagecache', '1', $options);
            } else {
                $app->input->cookie->set('mjnopagecache', '1',
                    $options['expires'], $options['path'], $options['domain'], $options['secure'], $options['httponly']);
            }
        }

        if (!empty($_SERVER['QUERY_STRING']) && $this->settings->get('pagecache_disable_queries')) {
            $this->mjPageCache->caching = false;
        }
        if ($this->mjPageCache->enabled && $this->mjPageCache->caching) {
            $this->mjPageCache->addTagDependence('GLOBAL');
        }
    }

    /** @return void */
    public function onAfterRoute()
    {
        $option = $this->joomlaWrapper->getRequestCmd('option');
        if (empty($option)) {
            // unknown request
            return;
        }

        $option = strtolower($option);
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $mjPageCache = $this->mjPageCache;

        /** @var JApplicationCms $app */
        $app = MJFactory::getApplication();

        // Is there a 3rdparty plugin to deal with cache tags?
        $supported = $app->triggerEvent('onPsoPageCacheSupported', array('option' => $option));
        $this->hasExtraSupport = in_array(true, $supported);
        $this->hasDefaultSupport = in_array($option, self::$defaultComponents, true);

        if ($this->joomlaWrapper->isSite()) {
            // Disable caching if $option is in exclude list
            $exclude_options = $this->settings->get('pagecache_exclude_options');
            if ($exclude_options && in_array($option, $exclude_options, true)) {
                $mjPageCache->caching = false;
                return;
            }

            $menuId = $this->joomlaWrapper->getRequestInt('Itemid');

            // Disable for menu items
            $exclude_menus = $this->settings->get('pagecache_exclude_menus');
            if ($exclude_menus && in_array((string)$menuId, $exclude_menus, true)) {
                $mjPageCache->caching = false;
                return;
            }

            if ($mjPageCache->caching) {
                // Support onPageCacheSetCaching from pagecache group plugins
                MJPluginHelper::importPlugin('pagecache');
                if (in_array(false, $app->triggerEvent('onPageCacheSetCaching'), true)) {
                    $mjPageCache->caching = false;
                    return;
                }
            }

            $mjPageCache->addTagDependence('menu-' . $menuId);

            if ($this->hasExtraSupport) {
                if (!in_array(true, $supported, true)) {
                    $mjPageCache->caching = false;
                }
                return;
            }
        } else {
            $mjPageCache->caching = false;
            if (
                $requestMethod === 'POST' &&
                !$this->hasExtraSupport && !$this->hasDefaultSupport &&
                $this->joomlaWrapper->getUser()->id
            ) {
                $mjPageCache->updateTag($option);
            }
            return;
        }

        if (!$this->hasDefaultSupport) {
            // Set/update tags
            switch ($requestMethod) {
                case 'GET':
                case 'HEAD':
                    $mjPageCache->addTagDependence($option);
                    break;
                case 'POST':
                    if ($this->joomlaWrapper->getUser()->id) {
                        $mjPageCache->updateTag($option);
                    }
                    break;
            }
            return;
        }

        switch ($option) {
            case 'com_banners':
                $this->processRoute_com_banners();
                break;
            case 'com_contact':
                $this->processRoute_com_contact();
                break;
            case 'com_content':
                $this->processRoute_com_content();
                break;
            case 'com_finder':
            case 'com_search':
                $this->processRoute_com_finder();
                break;
            case 'com_newsfeeds':
                $this->processRoute_com_newsfeeds();
                break;
            case 'com_tags':
                $this->processRoute_com_tags();
                break;
        }
    }

    public function onPsoPageCacheDisable()
    {
        $this->mjPageCache->caching = false;
    }

    public function onPsoPageCacheReset()
    {
        $this->mjPageCache->updateTag('GLOBAL');
    }

    /**
     * @param string[]|string $tags
     * @return void
     */
    public function onPsoPageCacheTagsUse($tags)
    {
        if ($this->mjPageCache->enabled) {
            $this->mjPageCache->addTagDependence($tags);
        }
    }

    /**
     * @param string[] $tags
     * @return void
     */
    public function onPsoPageCacheTagsUpdate($tags)
    {
        foreach ($tags as $tag) {
            $this->mjPageCache->updateTag($tag);
        }
    }

    /** @return void */
    public function onAfterRender()
    {
        // @note Check backend mode before access $this->mjPageCache
        if (!isset($this->settings, $this->mjPageCache) || !$this->mjPageCache->enabled || !$this->joomlaWrapper->isSite()) {
            return;
        }

        // Disable caching in the case of message queue
        /** @var JApplicationSite $app */
        $app = MJFactory::getApplication();
        if ($app->getMessageQueue()) {
            return;
        }

        // Save page for guests only
        $user = $this->joomlaWrapper->getUser();
        if ($user->id) {
            return;
        }

        // Support onPageCacheIsExcluded from pagecache group plugins
        MJPluginHelper::importPlugin('pagecache');
        if (in_array(true, $app->triggerEvent('onPageCacheIsExcluded'), true)) {
            return;
        }

        $status = 200;
        $contentType = false;
        $headers = array();

        /** @var JApplicationSite $app */
        $app = MJFactory::getApplication();
        $j_headers = version_compare(JVERSION, '3.2', '>=') ? $app->getHeaders() : JResponse::getHeaders();
        foreach ($j_headers as $header) {
            switch ($header['name']) {
                case 'Status':
                case 'status':
                    $status = $header['value'];
                    break;
                case 'Content-Type':
                    $contentType = $header['value'];
                    $headers[] = 'Content-Type: ' . $contentType;
                    break;
                case 'ETag':
                case 'Cache-Control':
                    break;
                default:
                    $headers[] = $header['name'] . ': ' . $header['value'];
            }
        }

        if ($contentType === false) {
            $headers[] = 'Content-Type: ' . $app->mimeType . '; charset=' . $app->charSet;
        }

        $this->mjPageCache->setHeaders($status, $headers);

        $text = $this->joomlaWrapper->getBody();
        // Replace CSRF token
        $csrfToken = MJSession::getFormToken();

        if (strpos($text, $csrfToken) !== false) {
            $text = str_replace($csrfToken, 'MJCSRF', $text);

            // inject JS to load CSRF token
            // Note: it relies on the browser's CORS policy (and missed Access-Control-Allow-Origin header in the response)
            if (version_compare(JVERSION, '3.8', '>=') &&
                strpos($text, 'joomla-script-options') !== false &&
                strpos($text, 'csrf.token') !== false
            ) {
                $js = "addEventListener('DOMContentLoaded',function(){"
                    . "fetch('" . MJUri::root(true) . "/index.php?option=com_pso&task=getcsrf',{credentials:'same-origin'})"
                    . '.then(function(r,t){'
                    . 'r.ok&&('
                    . 't=r.text(),'
                    . "document.querySelectorAll('input[type=hidden][name=MJCSRF]').forEach(function(e){e.name=t}),"
                    //. "Joomla&&(Joomla.loadOptions(),Joomla.optionsStorage['csrf.token']=t),"
                    . "Joomla&&(Joomla.loadOptions(),Joomla.loadOptions({'csrf.token':t}))"
                    . ')'
                    . '})'
                    . '})';
            } else {
                $js = "addEventListener('DOMContentLoaded',function(){"
                    . "var i=document.querySelectorAll('input[type=hidden][name=MJCSRF]');"
                    . 'i.length&&'
                    . "fetch('" . MJUri::root(true) . "/index.php?option=com_pso&task=getcsrf',{credentials:'same-origin'})"
                    . '.then(function(r){'
                    . 'r.ok&&i.forEach(function(e){e.name=r.text()})'
                    . '})'
                    . '})';
            }

            $pos = strripos($text, '</body>');
            if ($pos === false) {
                $pos = strlen($text);
            }
            $attr = (MJPluginHelper::isEnabled('system', 'pso') && $this->settings->get('js_nonblockjs')) ? ' type="text/ress"' : '';
            $text = substr($text, 0, $pos) . "<script$attr>$js</script>" . substr($text, $pos);
        }

        $etag = $this->mjPageCache->save($text);

        if ($etag !== null) {
            $this->joomlaWrapper->setHeader('Cache-Control', 'public');
            $this->joomlaWrapper->setHeader('ETag', $etag, true);
        }
    }

    /** @return void */
    public function onUserLogin()
    {
        if (version_compare(JVERSION, '3.6', '<')) {
            /** @var JApplicationSite $app */
            $app = JFactory::getApplication();
            $app->input->cookie->set(
                'joomla_user_state',
                'logged_in',
                time() + 365 * 86400,
                $this->joomlaWrapper->getConfig('cookie_path', '/'),
                $this->joomlaWrapper->getConfig('cookie_domain', ''),
                $this->joomlaWrapper->getConfig('force_ssl', 0) === 2,
                true
            );
        }
    }

    /** @return void */
    public function onUserLogout()
    {
        if (version_compare(JVERSION, '3.6', '<')) {
            /** @var JApplicationSite $app */
            $app = JFactory::getApplication();
            $app->input->cookie->set(
                'joomla_user_state',
                '',
                1,
                $this->joomlaWrapper->getConfig('cookie_path', '/'),
                $this->joomlaWrapper->getConfig('cookie_domain', ''),
                $this->joomlaWrapper->getConfig('force_ssl', 0) === 2,
                true
            );
        }
    }

    /**
     * @return MjPageCache
     */
    private function getPageCacheInstance()
    {
        include_once JPATH_ADMINISTRATOR . '/components/com_pso/ress/classes/pagecache.php';
        include_once JPATH_ADMINISTRATOR . '/components/com_pso/pagecache/mjpagecache.php';
        return new MjPageCache($this->joomlaWrapper->isSite());
    }

    /** @return void */
    private function processRoute_com_banners()
    {
        $this->mjPageCache->addTagDependence('com_banners');
    }

    /** @return void */
    private function processRoute_com_contact()
    {
        switch ($this->joomlaWrapper->getRequestVar('view')) {
            case 'category':
                $id = $this->joomlaWrapper->getRequestInt('id');
                $this->mjPageCache->addTagDependence('cat-' . $id);
                break;
            case 'contact':
                $id = $this->joomlaWrapper->getRequestInt('id');
                $this->mjPageCache->addTagDependence('contact-' . $id);
                break;
            default:
                $this->mjPageCache->addTagDependence('com_contact');
        }
    }

    /** @return void */
    private function processRoute_com_content()
    {
        switch ($this->joomlaWrapper->getRequestVar('view')) {
            case 'archive':
                $catid = $this->joomlaWrapper->getRequestInt('catid');
                $this->mjPageCache->addTagDependence('cat-' . $catid);
                break;
            case 'article':
                $id = $this->joomlaWrapper->getRequestInt('id');
                $this->mjPageCache->addTagDependence('content-' . $id);
                break;
            case 'category':
            case 'categories':
                $id = $this->joomlaWrapper->getRequestInt('id');
                $this->mjPageCache->addTagDependence('cat-' . $id);
                break;
            case 'featured':
            case 'form':
            default:
                $this->mjPageCache->addTagDependence('com_content');
        }
    }

    /** @return void */
    private function processRoute_com_finder()
    {

        $this->mjPageCache->addTagDependence('ANY');
    }

    /** @return void */
    private function processRoute_com_newsfeeds()
    {
        switch ($this->joomlaWrapper->getRequestVar('view')) {
            case 'category':
                $id = $this->joomlaWrapper->getRequestInt('id');
                $this->mjPageCache->addTagDependence('cat-' . $id);
                break;
            case 'newsfeed':
                $id = $this->joomlaWrapper->getRequestInt('id');
                $this->mjPageCache->addTagDependence('newsfeed-' . $id);
                break;
            default:
                $this->mjPageCache->addTagDependence('com_newsfeeds');
        }
    }

    /** @return void */
    private function processRoute_com_tags()
    {
        switch ($this->joomlaWrapper->getRequestVar('view')) {
            case 'tag':
                $ids = MJFactory::getApplication()->input->get('id');
                foreach ($ids as $id) {
                    $this->mjPageCache->addTagDependence('tag-' . (int)$id);
                }
                break;
            case 'tags':
            default:
                $this->mjPageCache->addTagDependence('com_tags');
        }
    }

    /**
     * @param string $context
     * @param object $data
     * @param JRegistry $params
     * @param int $offset
     * @return void
     */
    public function onContentPrepare($context, $data, $params, $offset)
    {
        switch ($context) {
            case 'com_content.article':
            case 'com_content.category':
                $this->mjPageCache->addTagDependence('com_content');
                $this->mjPageCache->addTagDependence('content-' . $data->id);
                $this->mjPageCache->addTagDependence('cat-' . $data->catid);
                $this->mjPageCache->addTagDependence('user-' . $data->created_by);
                $this->mjPageCache->addTagDependence('user-' . $data->modified_by);
                break;
            case 'com_content.categories':
                if ($data->extension === 'com_content') {
                    $this->mjPageCache->addTagDependence('cat-' . $data->id);
                    $this->mjPageCache->addTagDependence('user-' . $data->created_user_id);
                    $this->mjPageCache->addTagDependence('user-' . $data->modified_user_id);
                }
                break;
        }
    }

    /**
     * @param string $context
     * @param object $table
     * @param bool $isNew
     * @param ?object $data
     * @return void
     */
    public function onContentBeforeSave($context, $table, $isNew, $data = null)
    {
        switch ($context) {
            case 'com_content.article':
            case 'com_contact.contact':
            case 'com_newsfeeds.newsfeed':
                if ($table->catid) {
                    $this->updateTagCategoriesHierarchy($table->catid);
                }
                if ($table->tagsHelper) {
                    $this->updateTagTagsHierarchy($table->tagsHelper);
                }
                break;
        }
    }

    /**
     * @param string $context
     * @param object $table
     * @param bool $isNew
     * @param ?object $data
     * @return void
     */
    public function onContentAfterSave($context, $table, $isNew, $data = null)
    {
        switch ($context) {
            case 'com_banners.banner':
                $this->mjPageCache->updateTag('com_banners');
                break;

            case 'com_categories.category':
                $this->updateTagCategoriesHierarchy($table->catid);
                break;

            case 'com_content.article':
                $this->mjPageCache->updateTag('content-' . $table->id);
                $this->updateTagCategoriesHierarchy($table->catid);
                if (!empty($table->tagsHelper)) {
                    $this->updateTagTagsHierarchy($table->tagsHelper);
                }
                break;

            case 'com_contact.contact':
                $this->mjPageCache->updateTag('contact-' . $table->id);
                $this->updateTagCategoriesHierarchy($table->catid);
                break;

            case 'com_menus.item':
                $this->mjPageCache->updateTag('menu-' . $table->id);
                $this->mjPageCache->updateTag('GLOBAL');
                break;

            case 'com_newsfeeds.newsfeed':
                $this->mjPageCache->updateTag('com_newsfeeds');
                $this->mjPageCache->updateTag('newsfeed-' . $table->id);
                $this->updateTagCategoriesHierarchy($table->catid);
                break;
        }
    }

    /**
     * @param string $context
     * @param object $table
     * @return void
     */
    public function onContentAfterDelete($context, $table)
    {
        switch ($context) {
            case 'com_contact.contact':
                $this->mjPageCache->updateTag('contact-' . $table->id);
                $this->updateTagCategoriesHierarchy($table->catid);
                break;

            case 'com_newsfeeds.newsfeed':
                $this->mjPageCache->updateTag('com_newsfeeds');
                $this->mjPageCache->updateTag('newsfeed-' . $table->id);
                $this->updateTagCategoriesHierarchy($table->catid);
                break;
        }
    }

    /**
     * @param string $context
     * @param int[] $pks
     * @param int $value
     * @return void
     */
    public function onContentChangeState($context, $pks, $value)
    {
        switch ($context) {
            case 'com_banners.banner':
                $this->mjPageCache->updateTag('com_banners');
                break;

            case 'com_contact.contact':
                foreach ($pks as $id) {
                    $this->mjPageCache->updateTag('contact-' . $id);
                }
                $db = $this->joomlaWrapper->getDbo();
                $query = $db->getQuery(true)
                    ->select('catid')
                    ->from('#__contact_details')
                    ->where($db->quoteName('id') . ' IN (' . implode(',', $pks) . ')');
                $db->setQuery($query);
                $ids = $db->loadColumn();
                $this->updateTagCategoriesHierarchy(array_unique($ids));
                break;

            case 'com_content.article':
                $this->mjPageCache->updateTag('com_content');
                foreach ($pks as $id) {
                    $this->mjPageCache->updateTag('content-' . $id);
                }
                $db = $this->joomlaWrapper->getDbo();
                $query = $db->getQuery(true)
                    ->select('catid')
                    ->from('#__content')
                    ->where($db->quoteName('id') . ' IN (' . implode(',', $pks) . ')');
                $db->setQuery($query);
                $ids = $db->loadColumn();
                $this->updateTagCategoriesHierarchy(array_unique($ids));
                break;

            case 'com_categories.category':
                $this->updateTagCategoriesHierarchy($pks);
                break;

            case 'com_menus.item':
                foreach ($pks as $id) {
                    $this->mjPageCache->updateTag('menu-' . $id);
                }
                $this->mjPageCache->updateTag('GLOBAL');
                break;

            case 'com_newsfeeds.newsfeed':
                foreach ($pks as $id) {
                    $this->mjPageCache->updateTag('newsfeed-' . $id);
                }
                $db = $this->joomlaWrapper->getDbo();
                $query = $db->getQuery(true)
                    ->select('catid')
                    ->from('#__newsfeeds')
                    ->where($db->quoteName('id') . ' IN (' . implode(',', $pks) . ')');
                $db->setQuery($query);
                $ids = $db->loadColumn();
                $this->updateTagCategoriesHierarchy(array_unique($ids));
                break;
        }
    }

    /**
     * @param string $extension
     * @param int[] $pks
     * @param int $value
     * @return void
     */
    public function onCategoryChangeState($extension, $pks, $value)
    {
        if ($extension === 'com_content') {
            $this->mjPageCache->updateTag('com_content');
            $this->updateTagCategoriesHierarchy($pks);
        }
    }

    /**
     * @param string $context
     * @param object $table
     * @param bool $isNew
     * @param object $data
     * @return void
     */
    public function onUserAfterSave($context, $table, $isNew, $data)
    {
        if ($context === 'com_users') {
            $this->mjPageCache->updateTag('user-' . $table->id);
        }
    }

    /**
     * @param string $context
     * @param object $table
     * @return void
     */
    public function onUserAfterDelete($context, $table)
    {
        if ($context === 'com_users') {
            $this->mjPageCache->updateTag('user-' . $table->id);
        }
    }

    /**
     * @param string $defaultgroup
     * @param string $cachebase
     * @return void
     */
    public function onContentCleanCache($defaultgroup, $cachebase)
    {
        $this->mjPageCache->updateTag($defaultgroup);
    }

    /**
     * @param object $config
     * @return void
     */
    public function onApplicationAfterSave($config)
    {
        $this->mjPageCache->updateTag('GLOBAL');
    }

    /**
     * @param int[]|int $catid
     * @return void
     */
    private function updateTagCategoriesHierarchy($catid)
    {
        $db = $this->joomlaWrapper->getDbo();
        $query = $db->getQuery(true)
            ->select('a.id')
            ->from('#__categories AS a')
            ->from('#__categories AS b')
            ->where($db->quoteName('b.id') . ' IN (' . implode(',', (array)$catid) . ')')
            ->where('a.lft<=b.lft AND a.rgt>=b.rgt AND a.level>0');
        $db->setQuery($query);
        $ids = $db->loadColumn();

        foreach ($ids as $id) {
            $this->mjPageCache->updateTag('cat-' . $id);
        }
    }

    /**
     * @param Joomla\CMS\Helper\TagsHelper $tagHelper
     * @return void
     */
    private function updateTagTagsHierarchy($tagHelper)
    {
        if (!is_array($tagHelper->itemTags) || count($tagHelper->itemTags) === 0) {
            return;
        }

        $tag_ids = array();
        foreach ($tagHelper->itemTags as $tag) {
            $tag_ids[] = $tag->tag_id;
        }

        $db = $this->joomlaWrapper->getDbo();
        $query = $db->getQuery(true)
            ->select('a.id')
            ->from('#__tags AS a')
            ->from('#__tags AS b')
            ->where($db->quoteName('b.id') . ' IN (' . implode(',', $tag_ids) . ')')
            ->where('a.lft<=b.lft AND a.rgt>=b.rgt AND a.level>0');
        $db->setQuery($query);
        $ids = $db->loadColumn();

        foreach ($ids as $id) {
            $this->mjPageCache->updateTag('cat-' . $id);
        }
    }
}
