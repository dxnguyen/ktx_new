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

class MjPageCache extends Ressio_PageCache
{
    /** @var bool */
    public $enabled = true;

    /** @var string */
    protected $root;

    /** @var string[] */
    protected $cookies_disable;

    /** @var string[] */
    protected $cookies_depend;

    /** @var string[] */
    protected $http_depend;

    /**
     * @param bool $enabled
     */
    public function __construct($enabled = true)
    {
        $psoDir = dirname(__DIR__);

        include_once $psoDir . '/classes/mjhelper.php';

        $cache_dir = $psoDir . '/cache/pagecache';

        $options = MjHelper::loadJSON($psoDir . '/config/pagecache.json');
        if ($options === false || !$options['enabled']) {
            $this->enabled = false;
            parent::__construct(null, $cache_dir, 0, false);
            return;
        }

        // detach from JPATH_ROOT (may be undefined)
        $this->root = dirname(dirname(dirname($psoDir)));

        if ($enabled) {
            $uri = $_SERVER['REQUEST_URI'];
            if (!empty($_SERVER['QUERY_STRING'])) {
                $uri = strtok($uri, '?');
                parse_str($_SERVER['QUERY_STRING'], $query_list);
                foreach ($options['params_skip'] as $param) {
                    unset($query_list[$param]);
                }
                if (count($query_list)) {
                    ksort($query_list, SORT_STRING);
                    $uri .= '?' . http_build_query($query_list);
                }
            }
            if ($uri === '/index.php') {
                $uri = '/';
            }
        } else {
            $uri = null;
        }





        $this->cookies_disable = $options['cookies_disable'];
        $this->cookies_depend = $options['cookies_depend'];
        $this->http_depend = $options['http_depend'];

        parent::__construct($uri, $cache_dir, $options['ttl'], $options['devicedependent']);
    }

    /**
     * @param int $code
     * @param string[] $headers
     * @return void
     */
    public function setHeaders($code, $headers)
    {
        if ($code !== 200) {
            $this->caching = false;
            return;
        }
        $this->headers = $headers;
    }

    /**
     * @return bool
     */
    protected function disabledCaching()
    {
        if (
            parent::disabledCaching()
            // MJ disabled mode
            || (isset($_GET['pso']) && $_GET['pso'] === 'no')
        ) {
            return true;
        }

        foreach ($this->cookies_disable as $key) {
            if (isset($_COOKIE[$key])) {
                return true;
            }
        }

        // Remember-me cookie (J!3.6+)
        foreach ($_COOKIE as $key => $dummy) {
            if (strncmp($key, 'joomla_remember_me_', 19) === 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array
     */
    protected function getRequestHashArray()
    {
        $hash_data = parent::getRequestHashArray();

        foreach ($this->cookies_depend as $name) {
            if (isset($_COOKIE[$name])) {
                $hash_data[] = $name . '=' . $_COOKIE[$name];
            }
        }

        foreach ($this->http_depend as $name) {
            if (isset($_SERVER[$name])) {
                $hash_data[] = $name . '=' . $_SERVER[$name];
            }
        }

        return $hash_data;
    }
}
