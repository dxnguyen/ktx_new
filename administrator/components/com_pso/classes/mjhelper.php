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

class MjHelper
{
    /**
     * @param string $filename
     * @return array|false
     */
    public static function loadJSON($filename)
    {
        $full_filename = $filename . '.php';
        if (is_file($full_filename)) {
            $options = file_get_contents($full_filename);
            if ($options !== false) {
                return json_decode(explode('>', $options, 2)[1], true);
            }
        }
        return false;
    }

    /**
     * @param string $filename
     * @param array|stdClass $options
     * @return bool
     */
    public static function saveJSON($filename, $options)
    {
        return (bool)file_put_contents($filename . '.php', '<?php die("O_O");__halt_compiler();?>' . json_encode($options), LOCK_EX);
    }

    /**
     * @param string $element
     * @return int (0 - not installed, 1 - inactive, 2 - active)
     */
    public static function isActiveExtension($element)
    {
        list ($type, $element) = explode(':', $element, 2);
        switch ($type) {
            case 'package':
                return is_file(JPATH_MANIFESTS . "/packages/$element.xml") ? 2 : 0;
            case 'plugin':
                list ($group, $plugin) = explode('/', $element);
                if (!is_file(JPATH_PLUGINS . "/$group/$plugin/$plugin.php")) {
                    return 0;
                }
                return MJPluginHelper::isEnabled($group, $plugin) ? 2 : 1;
            case 'module':
                if (!is_file(JPATH_SITE . "/modules/$element/$element.php")) {
                    return 0;
                }
                return MJModuleHelper::isEnabled($element) ? 2 : 1;
            case 'component':
                if (!is_dir(JPATH_ADMINISTRATOR . "/components/$element")) {
                    return 0;
                }
                return MJComponentHelper::isEnabled($element) ? 2 : 1;
            case 'template':
                return is_file(JPATH_SITE . "/templates/$element/templateDetails.xml") ? 2 : 0;
            case 'meta':
                //return is_dir(JPATH_PLUGINS . '/pso/psopro') ? 2 : 0;
                return 0;
        }
        return 0;
    }

    /**
     * @param array $data
     * @return array
     */
    public static function generateBaseRessioConfig($data)
    {
        $staticDir = $data['staticdir'];
        $options = array(
            'webrootpath' => JPATH_ROOT,
            'webrooturi' => MJUri::root(true),
            'cachedir' => JPATH_ADMINISTRATOR . '/components/com_pso/cache/ress',
            'cachettl' => (int)$data['ress_caching_ttl'],
            'staticdir' => $staticDir,
            'fileloader' => ($data['distribmode'] === 'php') ? 'php' : 'file',
            'fileloaderphppath' => JPATH_ROOT . $staticDir . '/f.php',
            'filehashsize' => (int)$data['ress_hashsize'],
            'use_symlink' => (bool)$data['use_symlink'],
            'html' => array(
                'gzlevel' => 0,
            ),
            'img' => array(
                'minify' => true,
                'minifyrescaled' => false,
                'jpegquality' => (int)$data['img_jpegquality'],
                'webpquality' => (int)$data['img_webpquality'],
                'avifquality' => (int)$data['img_avifquality'],
                'webp' => false,
                'avif' => false,
            ),
            'di' => array(
                'jsMinify' => Ressio_JsMinify_JsMin::class,
                'cssMinify' => Ressio_CssMinify_Simple::class,
                'httpHeaders' => MjHttpHeaders::class,
                'db' => Ressio_Database_Joomla::class,
                'worker' => Ressio_Worker_SyncOnly::class,
            ),
            'plugins' => array(
                Ressio_Plugin_FilecacheCleaner::class => null,
            ),
            'worker' => array(
                'enabled' => ($data['ress_async'] !== 'sync'),
                'maxworkers' => $data['ress_async_max'],
                'maxexecutiontime' => $data['ress_async_maxtime'],
                'memorylimit' => $data['ress_async_memlimit'] . 'M',
                'db' => array(
                    'tablename' => '#__pso_queue'
                ),
            )
        );

        if ($data['img_size']) {
            $options['plugins'][Ressio_Plugin_Imagesize::class] = null;
        }

        switch ($data['ress_optimizer']) {
            case 'stream':
                $options['di']['htmlOptimizer'] = Ressio_HtmlOptimizer_Stream::class;
                break;
            case 'streamfull':
                $options['di']['htmlOptimizer'] = Ressio_HtmlOptimizer_StreamFull::class;
                break;
            case 'dom':
                $options['di']['htmlOptimizer'] = Ressio_HtmlOptimizer_Dom::class;
                break;
            case 'pharse':
            default:
                $options['di']['htmlOptimizer'] = Ressio_HtmlOptimizer_Pharse::class;
        }

        $options['di']['imgOptimizer.jpg'] =
        $options['di']['imgOptimizer.png'] =
        $options['di']['imgOptimizer.gif'] =
        $options['di']['imgOptimizer.webp'] =
        $options['di']['imgOptimizer.avif'] =
        $options['di']['imgOptimizer.bmp'] = Ressio_ImgHandler_GD::class;

        $options['img']['webp'] = (bool)$data['image_webp'];
        $options['img']['avif'] = (bool)$data['image_avif'];
        if ($data['image_webp'] || $data['image_avif']) {
            include_once JPATH_ADMINISTRATOR . '/components/com_pso/ress/ressio.php';
            Ressio::registerAutoloading();
            $handler = new Ressio_ImgHandler_GD(new Ressio_DI());
            if ($data['image_webp'] && !$handler->isSupportedFormat('webp')) {
                $options['img']['webp'] = false;
            }
            if ($data['image_avif'] && !$handler->isSupportedFormat('avif')) {
                $options['img']['avif'] = false;
            }
        }

        if ($data['cacert']) {
            $options['cafile'] = MjJoomlaWrapper::getInstance()->getCACertPath();
        }

        $app = MJFactory::getApplication();
        $app->triggerEvent('onPsoPrepareBaseRessioConfig', array(&$options, $data));

        return $options;
    }

    /**
     * @param JConfig|stdClass $conf
     * @return array
     */
    public static function getJDatabaseOptions($conf)
    {
        $options = array(
            'driver' => $conf->dbtype,
            'host' => $conf->host,
            'user' => $conf->user,
            'password' => $conf->password,
            'database' => $conf->db,
            'prefix' => $conf->dbprefix,
        );
        if (isset($conf->dbencryption) && (int)$conf->dbencryption !== 0) {
            $options['ssl'] = array(
                'enable' => true,
                'verify_server_cert' => (bool)$conf->dbsslverifyservercert,
            );
            foreach (array('cipher', 'ca', 'key', 'cert') as $key) {
                $confKey = "dbssl$key";
                $confVal = trim($conf->$confKey);
                if ($confVal !== '') {
                    $options['ssl'][$key] = $confVal;
                }
            }
        }
        return $options;
    }

    /**
     * @param string $str
     * @return string[]
     */
    public static function splitLines($str)
    {
        return array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $str)));
    }
}