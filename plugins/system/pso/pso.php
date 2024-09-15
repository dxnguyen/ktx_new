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

if (!is_file(JPATH_ADMINISTRATOR . '/components/com_pso/legacy/proem.php')) {
    return;
}

include_once JPATH_ADMINISTRATOR . '/components/com_pso/legacy/proem.php';

jimport('joomla.environment.uri');
jimport('joomla.filesystem.file');

class plgSystemPso extends MJPlugin
{
    /** @var MjJoomlaWrapper */
    private $joomlaWrapper;

    /** @var MjSettingsModel */
    private $settings;

    /** @var bool */
    private $internalError = false;

    /**
     * @param Joomla\Event\DispatcherInterface $subject
     * @param array $config
     */
    public function __construct(&$subject, $config = array())
    {
        parent::__construct($subject, $config);

        if (false === @include_once JPATH_ADMINISTRATOR . '/components/com_pso/legacy/joomlawrapper.php') {
            $this->internalError = true;
            return;
        }
        if (false === @include_once JPATH_ADMINISTRATOR . '/components/com_pso/models/settings.php') {
            $this->internalError = true;
            return;
        }

        $this->joomlaWrapper = MjJoomlaWrapper::getInstance();
        $this->settings = new MjSettingsModel($this->joomlaWrapper);

        if (isset($_GET['pso']) && $_GET['pso'] === 'guest') {
            $_COOKIE = array();
        }
    }

    /** @return void */
    public function onAfterInitialise()
    {
        if ($this->internalError) {
            return;
        }

        /** @var JApplicationSite $app */
        $app = MJFactory::getApplication();

        MJPluginHelper::importPlugin('pso');
        $app->triggerEvent('onMobileInitialise', array($this->settings));
        $app->triggerEvent('onPsoInitialise', array($this->settings));
    }

    /** @return void */
    public function onAfterRoute()
    {
        if ($this->internalError) {
            return;
        }

        if (!$this->joomlaWrapper->isSite()) {
            return;
        }

        $option = $this->joomlaWrapper->getRequestCmd('option');
        if ($option !== 'com_pso') {
            return;
        }

        $task = $this->joomlaWrapper->getRequestCmd('task');
        switch ($task) {
            case 'cron':
                $app = MJFactory::getApplication();
                if ($this->settings->get('ress_async') === 'ajax') {
                    include_once JPATH_ADMINISTRATOR . '/components/com_pso/classes/mjhelper.php';
                    $config = MjHelper::loadJSON(JPATH_ADMINISTRATOR . '/components/com_pso/config/cron.json');
                    if (!is_array($config)) {
                        die("ERROR: Configuration file is not created yet.\n");
                    }

                    $config['worker']['enabled'] = true;

                    if (!empty($config['worker']['joomlaConfig'])) {
                        $config['db']['joomlaDriver'] = $this->getDatabaseDriver($config['worker']['joomlaConfig']);
                    }

                    include_once JPATH_ADMINISTRATOR . '/components/com_pso/ress/ressio.php';

                    $app->triggerEvent('onPsoCronRessioConfig', array(&$config));

                    $ressio = new Ressio($config);

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

                    $ressio->di->worker->run();
                }
                $app->close();
                jexit(); // just in case
        }
    }

    /** @return void */
    public function onAfterDispatch()
    {
        if ($this->internalError) {
            return;
        }
        if (!$this->joomlaWrapper->isSite()) {
            return;
        }

        $doc = $this->joomlaWrapper->getDocument();

        class_exists('MJDocumentHtml');
        if (!($doc instanceof MJDocumentHtml)) {
            return;
        }

        // for safety reason don't optimize POST requests
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return;
        }
        if (isset($_GET['pso']) && $_GET['pso'] === 'no') {
            return;
        }

        if ($this->settings->get('httpcaching')) {
            $ttl = (int)$this->settings->get('httpcachingttl');
            $this->joomlaWrapper->allowCache(true);
            $this->joomlaWrapper->setHeader('Expires', gmdate('D, d M Y H:i:s', time() + $ttl) . ' GMT');
        }

        if ($this->settings->get('ress_async') === 'ajax') {
            $doc = $this->joomlaWrapper->getDocument();
            class_exists('MJDocumentHtml');
            if ($doc instanceof MJDocumentHtml) {
                $doc->addScriptDeclaration(
                    "try{window.fetch&&addEventListener('load',function(){fetch('" . MJUri::root(true) . "/index.php?option=com_pso&task=cron')})}catch(e){}"
                );
            }
        }
    }

    /** @return void */
    public function onAfterRender()
    {
        if ($this->internalError) {
            return;
        }

        include_once JPATH_ADMINISTRATOR . '/components/com_pso/classes/mjdailytasks.php';
        if (time() >= MjDailyTasks::getNextRunTime()) {
            register_shutdown_function(array($this, 'runDailyTasks'));
        }

        if (!$this->joomlaWrapper->isSite()) {
            return;
        }

        // for safety reason don't optimize POST requests
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return;
        }

        if ((isset($_GET['pso']) && $_GET['pso'] === 'no')) {
            return;
        }

        if (defined('PSO_DONOTMINIFY')) {
            return;
        }

        $doc = $this->joomlaWrapper->getDocument();
        class_exists('MJDocumentHtml');
        if (!($doc instanceof MJDocumentHtml)) {
            return;
        }

        /** @var JApplicationSite $app */
        $app = MJFactory::getApplication();

        $settings = $this->settings;

        $option = strtolower($this->joomlaWrapper->getRequestCmd('option'));
        $exclude_options = $this->settings->get('exclude_options');
        if ($exclude_options && in_array($option, $exclude_options, true)) {
            return;
        }

        $menuId = $this->joomlaWrapper->getRequestInt('Itemid');
        $exclude_menus = $this->settings->get('exclude_menus');
        if ($exclude_menus && in_array((string)$menuId, $exclude_menus, true)) {
            return;
        }


        if ($settings->get('ress_optimize')) {
            $psoAdminDir = JPATH_ADMINISTRATOR . '/components/com_pso';
            include_once $psoAdminDir . '/classes/mjhelper.php';

            $cache_filename = "$psoAdminDir/config/ress.json";
            $options = MjHelper::loadJSON($cache_filename);
            if ($options === false) {
                $options = $this->prepareRessioConfig();
                MjHelper::saveJSON($cache_filename, $options);
            }

            $isAjaxRequest = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest');
            if ($isAjaxRequest) {
                unset($options['plugins'][Ressio_Plugin_Lazyload::class]);
            }

            $options['css']['nonce'] = $options['js']['nonce'] = $this->joomlaWrapper->getConfig('csp_nonce');

            $settings = $this->settings;
            if ($settings->get('css_atf')) {
                $isFirstTime = !isset($_COOKIE['mj_visitor']);
                $page = $_SERVER['REQUEST_URI'];
                $isHomepage = ($page === '/') || ($page === '/index.php');
                $isGlobal = (bool)$settings->get('css_atfglobal');
                if ($isFirstTime && ($isHomepage || $isGlobal)) {
                    $atfcss = $settings->getATFCSS('/', '');
                    if (!empty($atfcss)) {
                        $options['plugins'][Ressio_Plugin_AboveTheFoldCSS::class] = array(
                            'abovethefoldcss' => $atfcss,
                            'cookie' => 'mj_visitor',
                        );
                    }
                }
            }

            if (!empty($options['worker']['joomlaConfig'])) {
                $options['db']['joomlaDriver'] = $this->getDatabaseDriver($options['worker']['joomlaConfig']);
            }

            require_once $psoAdminDir . '/ress/ressio.php';
            Ressio::registerAutoloading(true);

            // slightly improve performance by preloading some required Ressio's classes
            $ress_classes_dir = $psoAdminDir . '/ress/classes';
            include_once $ress_classes_dir . '/interfaces/dispatcher.php';
            include_once $ress_classes_dir . '/interfaces/diaware.php';
            include_once $ress_classes_dir . '/interfaces/cache.php';
            include_once $ress_classes_dir . '/interfaces/filesystem.php';
            include_once $ress_classes_dir . '/interfaces/filelock.php';
            include_once $ress_classes_dir . '/interfaces/htmloptimizer.php';
            include_once $ress_classes_dir . '/interfaces/htmlnode.php';
            include_once $ress_classes_dir . '/interfaces/csscombiner.php';
            include_once $ress_classes_dir . '/interfaces/cssminify.php';
            include_once $ress_classes_dir . '/interfaces/jscombiner.php';
            include_once $ress_classes_dir . '/interfaces/jsminify.php';
            include_once $ress_classes_dir . '/interfaces/httpcompressoutput.php';
            include_once $ress_classes_dir . '/interfaces/httpheaders.php';
            include_once $ress_classes_dir . '/di.php';
            include_once $ress_classes_dir . '/dispatcher.php';
            include_once $ress_classes_dir . '/helper.php';
            include_once $ress_classes_dir . '/urlrewriter.php';
            include_once $ress_classes_dir . '/filesystem/native.php';
            include_once $ress_classes_dir . '/filelock/flock.php';
            include_once $ress_classes_dir . '/htmloptimizer/base.php';
            include_once $ress_classes_dir . '/nodewrapper.php';
            include_once $ress_classes_dir . '/csscombiner.php';
            include_once $ress_classes_dir . '/jscombiner.php';

            require_once $psoAdminDir . '/classes/mjhttpheaders.php';

            $app->triggerEvent('onPsoRessioConfig', array(&$options));

            $ressio = new Ressio($options);

            $app->triggerEvent('onPsoRessioPrepare', array($ressio));

            $text = $this->joomlaWrapper->getBody();
            $text = $ressio->run($text);
            if (!empty($text)) {
                $settings->joomlaWrapper->setBody($text);
            }
        }

        $app->triggerEvent('onPsoAfterPagePrepare');
    }

    /** @return void */
    public function runDailyTasks()
    {
        MjDailyTasks::execute($this->settings);
    }

    /**
     * @return array
     */
    private function prepareRessioConfig()
    {
        $settings = $this->settings;

        include_once JPATH_ADMINISTRATOR . '/components/com_pso/classes/mjhelper.php';
        $options = MjHelper::generateBaseRessioConfig($settings->getAll());

        $css_rules_merge_exclude = $settings->get('css_rules_merge_exclude', '') . "\nress-nomerge*=\n";
        $css_rules_merge_include = $settings->get('css_rules_merge_include', '') . "\nress-merge*=\n";
        $js_rules_merge_exclude = $settings->get('js_rules_merge_exclude', '') . "\nress-nomerge*=\n";
        $js_rules_merge_include = $settings->get('js_rules_merge_include', '') . "\nress-merge*=\n";

        $options = array_replace_recursive($options, array(
            'logginglevel' => (int)$settings->get('ress_logginglevel'),
            'html' => array(
                'mergespace' => (bool)$settings->get('html_mergespace'),
                'removecomments' => (bool)$settings->get('html_removecomments'),
                'urlminify' => (bool)$settings->get('html_minifyurl'),
                'gzlevel' => 0,
                'sortattr' => (bool)$settings->get('html_sortattr'),
                'removedefattr' => (bool)$settings->get('html_removedefattr'),
                'removeiecond' => (bool)$settings->get('html_removeiecond'),
                'rules_safe_exclude' => $this->listToRules($settings->get('html_rules_safe_exclude', '')),
            ),
            'css' => array(
                'merge' => (bool)$settings->get('css_merge'),
                'mergeinline' => (bool)$settings->get('css_mergeinline'),
                'checklinkattrs' => (bool)$settings->get('css_checklinkattrs'),
                'checkstyleattrs' => (bool)$settings->get('css_checkstyleattrs'),
                'inlinelimit' => (int)$settings->get('css_inlinelimit'),
                'minifyattribute' => (bool)$settings->get('css_minifyattribute'),
                'rules_merge_bypass' => $this->listToRules($settings->get('css_rules_merge_bypass', '')),
                'rules_merge_stop' => $this->listToRules($settings->get('css_rules_merge_stop', '')),
                'rules_merge_exclude' => $this->listToRules($css_rules_merge_exclude),
                'rules_merge_include' => $this->listToRules($css_rules_merge_include),
                'rules_merge_startgroup' => $this->listToRules($settings->get('css_rules_merge_startgroup', '')),
                'rules_merge_stopgroup' => $this->listToRules($settings->get('css_rules_merge_stopgroup', '')),
                'rules_minify_exclude' => $this->listToRules($settings->get('css_rules_minify_exclude', '')),
            ),
            'js' => array(
                'merge' => (bool)$settings->get('js_merge'),
                'mergeinline' => (bool)$settings->get('js_mergeinline'),
                'checkattrs' => (bool)$settings->get('js_checkattrs'),
                'skipinits' => (bool)$settings->get('js_skipinits'),
                'automove' => (bool)$settings->get('js_automove'),
                'forcedefer' => (bool)$settings->get('js_forcedefer'),
                'forceasync' => (bool)$settings->get('js_forceasync'),
                'wraptrycatch' => (bool)$settings->get('js_wraptrycatch'),
                'inlinelimit' => (int)$settings->get('js_inlinelimit'),
                'minifyattribute' => (bool)$settings->get('js_minifyattribute'),
                'rules_merge_bypass' => $this->listToRules($settings->get('js_rules_merge_bypass', '')),
                'rules_merge_stop' => $this->listToRules($settings->get('js_rules_merge_stop', '')),
                'rules_merge_exclude' => $this->listToRules($js_rules_merge_exclude),
                'rules_merge_include' => $this->listToRules($js_rules_merge_include),
                'rules_merge_startgroup' => $this->listToRules($settings->get('js_rules_merge_startgroup', '')),
                'rules_merge_stopgroup' => $this->listToRules($settings->get('js_rules_merge_stopgroup', '')),
                'rules_move_exclude' => $this->listToRules($settings->get('js_rules_move_exclude', '')),
                'rules_async_exclude' => $this->listToRules($settings->get('js_rules_async_exclude', '')),
                'rules_async_include' => $this->listToRules($settings->get('js_rules_async_include', '')),
                'rules_defer_exclude' => $this->listToRules($settings->get('js_rules_defer_exclude', '')),
                'rules_defer_include' => $this->listToRules($settings->get('js_rules_defer_include', '')),
                'rules_minify_exclude' => $this->listToRules($settings->get('js_rules_minify_exclude', '')),
            ),
            'img' => array(
                'minify' => (bool)$settings->get('img_optimize'),
                'rules_minify_exclude' => $this->listToRules($settings->get('img_rules_minify_exclude', '')),
            ),
            'di' => array(
                'jsMinify' => $settings->get('js_optimize') ? Ressio_JsMinify_JsMin::class : Ressio_JsMinify_None::class,
                'cssMinify' => $settings->get('css_optimize') ? Ressio_CssMinify_Simple::class : Ressio_CssMinify_None::class,
//                'filesystem' => 'MJ_Ressio_FileSystem_Joomla',
            ),
        ));

        if ($settings->get('html_preload')) {
            $preload_style = $settings->get('html_preload_style');
            $preload_font = $settings->get('html_preload_font');
            $preload_script = $settings->get('html_preload_script');
            $preload_module = $settings->get('html_preload_module');
            $preload_image = $settings->get('html_preload_image');
            $options['plugins'][Ressio_Plugin_Preload::class] = array(
                'linkheader' => (bool)$settings->get('html_preload_link'),
                'style' => MjHelper::splitLines($preload_style),
                'font' => MjHelper::splitLines($preload_font),
                'script' => MjHelper::splitLines($preload_script),
                'module' => MjHelper::splitLines($preload_module),
                'image' => MjHelper::splitLines($preload_image),
            );
        }

        if ($settings->get('html_dnsprefetch')) {
            $domains = $settings->get('html_dnsprefetch_domains');
            $options['plugins'][Ressio_Plugin_DNSPrefetch::class] = array(
                'linkheader' => (bool)$settings->get('html_dnsprefetch_link'),
                'domains' => MjHelper::splitLines($domains),
            );
        }

        if ($settings->get('html_preconnect')) {
            $urls = $settings->get('html_preconnect_urls');
            $options['plugins'][Ressio_Plugin_Preconnect::class] = array(
                'linkheader' => (bool)$settings->get('html_preconnect_link'),
                'urls' => MjHelper::splitLines($urls),
            );
        }

        $lazyload_method = $settings->get('lazyload_method');
        if ($lazyload_method !== 'none' && $lazyload_method !== '') {
            $options['plugins'][Ressio_Plugin_Lazyload::class] = array(
                'method' => $lazyload_method,
                'image' => (bool)$settings->get('img_lazyload'),
                'video' => (bool)$settings->get('video_lazyload'),
                'iframe' => (bool)$settings->get('iframe_lazyload'),
                'lqip' => $settings->get('img_lazyload_lqip') ? 'low' : 'none',
                'lqip_embed' => true,
                'noscriptpos' => $settings->get('lazyload_noscript'),
                'edgey' => $settings->get('lazyload_threshold'),
                'rules_img_exclude' => $this->listToRules($settings->get('lazyload_rules_img_exclude')),
                'rules_bg_exclude' => $this->listToRules($settings->get('lazyload_rules_img_bg_exclude', '')),
                'rules_video_exclude' => $this->listToRules($settings->get('lazyload_rules_video_exclude')),
                'rules_iframe_exclude' => $this->listToRules($settings->get('lazyload_rules_iframe_exclude')),
                'addons' => array()
            );
        }

        if ($settings->get('googlefont')) {
            $options['plugins'][Ressio_Plugin_GoogleFont::class] = array(
                'method' => $settings->get('googlefont_method'),
            );
        }

        $font_displayswap = $settings->get('font_displayswap', 'none');
        if ($font_displayswap !== 'none') {
            $options['plugins'][Ressio_Plugin_FontDisplaySwap::class] = array(
                'display' => $font_displayswap,
                'excludedFonts' => MjHelper::splitLines($settings->get('font_displayswap_exclude'))
            );
        }

        $css_inlinefirsttime = $settings->get('css_inlinefirsttime');
        $js_inlinefirsttime = $settings->get('js_inlinefirsttime');
        if ($css_inlinefirsttime || $js_inlinefirsttime) {
            $options['plugins'][Ressio_Plugin_InlineJsCss::class] = array(
                'cookie' => 'mj_visitor',
                'css' => $css_inlinefirsttime,
                'js' => $js_inlinefirsttime,
            );
        }

        if ($settings->get('js_polyfill')) {
            $regexps = array();
            $lines = explode("\n", $settings->get('js_polyfill_rules'));
            foreach ($lines as $line) {
                $regexps[] = preg_quote($line, '@');
            }
            $options['plugins'][Ressio_Plugin_LegacyPolyfill::class] = array(
                'regex' => '@' . implode('|', $regexps) . '@'
            );
        }

        $app = MJFactory::getApplication();
        $app->triggerEvent('onPsoPrepareRessioConfig', array(&$options));

        return $options;
    }

    /**
     * @param string $source
     * @return ?array
     */
    private function listToRules($source)
    {
        $regexp_content = array();
        $regexp_attrs = array();

        $lines = explode("\n", $source);
        foreach ($lines as $line) {
            if (!preg_match('/^([\w\s-]*)([*~^$]?=)(.*)$/', $line, $matches)) {
                continue;
            }
            $attr = strtolower(trim($matches[1]));
            $cond = $matches[2];
            $value = trim($matches[3]);
            switch ($cond) {
                case '~=':
                    $value = str_replace('@', '\@', $value);
                    if (preg_match("@$value@", '') === false) {
                        continue 2;
                    }
                    break;
                case '=':
                    $value = '^' . preg_quote($value, '@') . '$';
                    break;
                case '*=':
                    $value = preg_quote($value, '@');
                    break;
                case '^=':
                    $value = '^' . preg_quote($value, '@');
                    break;
                case '$=':
                    $value = preg_quote($value, '@') . '$';
                    break;
            }
            if ($attr === '') {
                $regexp_content[] = $value;
            } else {
                if (!isset($regexp_attrs[$attr])) {
                    $regexp_attrs[$attr] = array();
                }
                $regexp_attrs[$attr][] = $value;
            }
        }

        $result = array();
        if (count($regexp_content)) {
            $result['content'] = '@' . implode('|', $regexp_content) . '@';
        }
        if (count($regexp_attrs)) {
            $result['attrs'] = array();
            foreach ($regexp_attrs as $attr => $rules) {
                $result['attrs'][$attr] = '@' . implode('|', $rules) . '@';
            }
        }

        return count($result) ? $result : null;
    }

    /**
     * @param string $config_path
     * @return JDatabaseDriver|Joomla\Database\DatabaseInterface|null
     */
    private function getDatabaseDriver($config_path)
    {
        if (!is_file($config_path)) {
            return null;
        }

        $content = file_get_contents($config_path);
        if (strpos($content, 'JConfig') === false) {
            return null;
        }

        if (!preg_match_all('/\bpublic\s+\$(\w+)\s*=\s*(-?\d+|true|false|\'(?>[^\'\\\\]+|\\.)*\')\s*;/i', $content, $matches)) {
            return null;
        }
        $conf = new stdClass();
        foreach ($matches as $match) {
            $key = $match[1];
            $value = $match[2];
            if ($value === 'true') {
                $value = true;
            } elseif ($value === 'false') {
                $value = false;
            } elseif ($value[0] === "'") {
                $value = stripcslashes(substr($value, 1, -1));
            } else {
                $value = (int)$value;
            }
            $conf->$key = $value;
        }

        include_once JPATH_ADMINISTRATOR . '/components/com_pso/classes/mjhelper.php';
        $options = MjHelper::getJDatabaseOptions($conf);
        try {
            if (version_compare(JVERSION, '4.0', '>=')) {
                return (new Joomla\Database\DatabaseFactory)->getDriver($options['driver'], $options);
            }
            return JDatabaseDriver::getInstance($options);
        } catch (RuntimeException $e) {
            return null;
        }
    }

    /**
     * @param string $url
     * @param array $headers
     * @return void
     */
    public function onInstallerBeforePackageDownload(&$url, &$headers)
    {
        if ($this->internalError) {
            return;
        }

        if (strncmp($url, 'https://update.mobilejoomla.com/', 32) === 0 && strpos($url, 'apikey=') === false) {
            $apikey = $this->settings->get('apikey');
            if (!empty($apikey)) {
                $url .= (strpos($url, '?') !== false) ? '&' : '?';
                $url .= 'apikey=' . $apikey;
            }
        }
    }

    /**
     * @param string $scope
     * @param JMenuItem $children
     * @param ?stdClass $params
     * @param bool $enabled
     * @return void
     */
    public function onPreprocessMenuItems($scope, $children, $params = null, $enabled = false)
    {
        if ($scope !== 'com_menus.administrator.module' || !$enabled) {
            return;
        }
        foreach ($children as $child) {
            if ($child->element === 'com_pso' && $child->level === 1 && $child->published) {
                include_once JPATH_ADMINISTRATOR . '/components/com_pso/legacy/joomlawrapper.php';
                include_once JPATH_ADMINISTRATOR . '/components/com_pso/models/settings.php';
                MjJoomlaWrapper::getInstance()->loadLanguageFile('com_pso', JPATH_ADMINISTRATOR);
                $this->addAdminMenuItem($child, 'COM_PSO__MENU_DASHBOARD', 'index.php?option=com_pso&controller=dashboard&view=default');
                $this->addAdminMenuItem($child, 'COM_PSO__MENU_OPTIMIZATION', 'index.php?option=com_pso&controller=settings&view=optimization');
                $this->addAdminMenuItem($child, 'COM_PSO__MENU_PAGECACHE', 'index.php?option=com_pso&controller=pagecache');
                $this->addAdminMenuItem($child, 'COM_PSO__MENU_ADVANCED', 'index.php?option=com_pso&controller=settings&view=advanced');
                $this->addAdminMenuItem($child, 'COM_PSO__MENU_TROUBLESHOOTING', 'index.php?option=com_pso&controller=settings&view=troubleshooting');
            }
        }
    }

    /**
     * @param JMenuItem $parent
     * @param string $title
     * @param string $link
     * @return void
     */
    protected function addAdminMenuItem($parent, $title, $link)
    {
        $item = new \Joomla\CMS\Menu\AdministratorMenuItem();
        foreach ($parent as $key => $value) {
            $item->$key = $value;
        }
        $item->title = $title;
        $item->link = $link;
        $item->level = 2;
        $item->parent_id = $parent->id;
        $parent->addChild($item);
    }
}
