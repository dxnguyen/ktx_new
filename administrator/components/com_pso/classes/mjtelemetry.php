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

class MjTelemetry
{
    /** @var string[] */
    public static $defaultComponents = array(
        'com_ajax',
        'com_banners',
        'com_config',
        'com_contact',
        'com_content',
        'com_contenthistory',
        'com_fields',
        'com_finder',
        'com_mailto',
        'com_media',
        'com_menus',
        'com_pso',
        'com_modules',
        'com_newsfeeds',
        'com_privacy',
        'com_search',
        'com_tags',
        'com_users',
        'com_weblinks',
        'com_wrapper',
    );

    /** @var string[] */
    public static $defaultModules = array(
        'mod_articles_archive',
        'mod_articles_categories',
        'mod_articles_category',
        'mod_articles_latest',
        'mod_articles_news',
        'mod_articles_popular',
        'mod_banners',
        'mod_breadcrumbs',
        'mod_custom',
        'mod_feed',
        'mod_finder',
        'mod_footer',
        'mod_languages',
        'mod_login',
        'mod_menu',
        'mod_random_image',
        'mod_related_items',
        'mod_search',
        'mod_stats',
        'mod_syndicate',
        'mod_tags_popular',
        'mod_tags_similar',
        'mod_users_latest',
        'mod_weblinks',
        'mod_whosonline',
        'mod_wrapper',
    );

    /** @var string[][] */
    public static $defaultPlugins = array(
        'actionlog' => array('joomla'),
        'api-authentication' => array('basic', 'token'),
        'authentication' => array('cookie', 'gmail', 'joomla', 'ldap'),
        'behaviour' => array('compat', 'taggable', 'versionable'),
        'captcha' => array('recaptcha', 'recaptcha_invisible'),
        'content' => array('confirmconsent', 'contact', 'emailcloak', 'fields', 'finder', 'geshi', 'joomla', 'loadmodule', 'pagebreak', 'pagenavigation', 'vote'),
        'editors' => array('codemirror', 'none', 'tinymce'),
        'editors-xtd' => array('article', 'contact', 'fields', 'image', 'menu', 'module', 'pagebreak', 'readmore'),
        'extension' => array('finder', 'joomla', 'namespacemap'),
        'fields' => array('calendar', 'checkboxes', 'color', 'editor', 'imagelist', 'integer', 'list', 'media', 'radio', 'repeatable', 'sql', 'subform', 'text', 'textarea', 'url', 'user', 'usergrouplist'),
        'filesystem' => array('local'),
        'finder' => array('categories', 'contacts', 'content', 'newsfeeds', 'tags', 'weblinks'),
        'installer' => array('folderinstaller', 'override', 'packageinstaller', 'urlinstaller', 'webinstaller'),
        'media-action' => array('crop', 'resize', 'rotate'),
        'multifactorauth' => array('email', 'totp', 'webauthn', 'yubikey'),
        'privacy' => array('actionlogs', 'consents', 'contact', 'content', 'message', 'user'),
        'quickicon' => array('downloadkey', 'eos', 'eos310', 'eosnotify', 'extensionupdate', 'joomlaupdate', 'overridecheck', 'phpversioncheck', 'privacycheck'),
        'sampledata' => array('blog', 'multilang'),
        'schemaorg' => array('blogposting', 'book', 'event', 'jobposting', 'organization', 'person', 'recipe'),
        'search' => array('categories', 'contacts', 'content', 'newsfeeds', 'tags', 'weblinks'),
        'system' => array('accessibility', 'actionlogs', 'cache', 'debug', 'fields', 'guidedtours', 'highlight', 'httpheaders', 'jooa11y', 'languagecode', 'languagefilter', 'log', 'logout', 'logrotation', 'p3p', 'privacyconsent', 'pso', 'redirect', 'remember', 'schedulerunner', 'schemaorg', 'sef', 'sessiongc', 'shortcut', 'skipto', 'stats', 'tasknotification', 'updatenotification', 'webauthn'),
        'task' => array('checkfiles', 'deleteactionlogs', 'demotasks', 'globalcheckin', 'privacyconsent', 'requests', 'rotatelogs', 'sessiongc', 'sitestatus', 'updatenotification'),
        'twofactorauth' => array('totp', 'yubikey'),
        'user' => array('contactcreator', 'joomla', 'profile', 'terms', 'token'),
        'webservices' => array('banners', 'config', 'contact', 'content', 'installer', 'languages', 'media', 'menus', 'messages', 'modules', 'newsfeeds', 'plugins', 'privacy', 'redirect', 'tags', 'templates', 'users'),
        'workflow' => array('featuring', 'notification', 'publishing'),
    );

    /**
     * @param MjSettingsModel $settings
     *
     * @return array
     */
    public static function getStatsData($settings)
    {
        $joomlaWrapper = MjJoomlaWrapper::getInstance();
        $db = $joomlaWrapper->getDbo();

        $stats = array(
            'joomla' => JVERSION,
            'php' => PHP_VERSION,
            'pso' => '1.4.2',
            'os' => PHP_OS,
            'webserver' => isset($_SERVER['SERVER_SOFTWARE']) ? explode('/', $_SERVER['SERVER_SOFTWARE'], 2)[0] : '',
            'sapi' => PHP_SAPI,
            'dbtype' => $joomlaWrapper->getConfig('dbtype'),
            'cache_handler' => $joomlaWrapper->getConfig('cache_handler'),
            'extensions' => array(
                'components' => array(),
                'modules' => array(),
                'plugins' => array(),
                'templates' => array(),
            ),
        );

        $query = new MjQueryBuilder($db);
        $modules = $query
            ->select('module')
            ->from('#__modules')
            ->where($query->qn('published') . '=1')
            ->where($query->qn('client_id') . '=0')
            ->loadColumn();
        $modules = array_unique($modules);

        $query = new MjQueryBuilder($db);
        $rows = $query
            ->select('type', 'element', 'folder', 'client_id')
            ->from('#__extensions')
            ->where($query->qn('enabled') . '=1')
            ->loadObjectList();
        foreach ($rows as $row) {
            $element = $row->element;
            switch ($row->type) {
                case 'component':
                    if (is_dir(JPATH_ROOT . '/components/' . $element) && !in_array($element, self::$defaultComponents, true)) {
                        $stats['extensions']['components'][] = $element;
                    }
                    break;
                case 'module':
                    if ($row->client_id === 0 && in_array($element, $modules, true) && !in_array($element, self::$defaultModules, true)) {
                        $stats['extensions']['modules'][] = $element;
                    }
                    break;
                case 'plugin':
                    if (!isset(self::$defaultPlugins[$row->folder]) || !in_array($element, self::$defaultPlugins[$row->folder])) {
                        if (!isset($stats['extensions']['plugins'][$row->folder])) {
                            $stats['extensions']['plugins'][$row->folder] = array();
                        }
                        $stats['extensions']['plugins'][$row->folder][] = $element;
                    }
                    break;
            }
        }

        $query = new MjQueryBuilder($db);
        $styles = $query
            ->select('template_style_id')
            ->from('#__menu')
            ->where($query->qn('client_id') . '=0')
            ->where($query->qn('published') . '=1')
            ->where($query->qn('template_style_id') . '>0')
            ->loadColumn();
        $styles = array_unique($styles);

        $query = new MjQueryBuilder($db);
        $rows = $query
            ->select('id', 'template', 'home')
            ->from('#__template_styles')
            ->where($query->qn('client_id') . '=0')
            ->loadObjectList();
        $templates = array();
        $default_template = null;
        foreach ($rows as $row) {
            if (in_array($row->id, $styles)) {
                $templates[$row->template] = true;
            }
            if ($row->home) {
                $default_template = $row->template;
            }
        }
        $templates = array_diff(array_keys($templates), array($default_template));
        array_unshift($templates, $default_template);

        $stats['extensions']['templates'] = $templates;

        return $stats;
    }
}
