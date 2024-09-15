<?php
/*
 * RESSIO Responsive Server Side Optimizer
 * https://github.com/ressio/
 *
 * @copyright   Copyright (C) 2013-2024 Kuneri Ltd. / Denis Ryabov, PageSpeed Ninja Team. All rights reserved.
 * @license     GNU General Public License version 2
 */

defined('RESSIO_PATH') || die();

class Ressio_Plugin_Preconnect extends Ressio_Plugin
{
    /**
     * @var array
     */
    public $urls_list;
    /**
     * @var string
     */
    public $current_domain;

    /**
     * @param Ressio_DI $di
     * @param null|stdClass $params
     */
    public function __construct($di, $params = null)
    {
        parent::__construct($di);
        $this->loadConfig(__DIR__ . '/config.json', $params);
    }

    /**
     * @return array
     */
    public function getEventPriorities()
    {
        return array(
            'HtmlBeforeStringify' => -1
        );
    }

    /**
     * @param Ressio_Event $event
     * @param IRessio_HtmlOptimizer $optimizer
     * @return void
     */
    public function onHtmlIterateBefore($event, $optimizer)
    {
        $this->current_domain = $_SERVER['HTTP_HOST'];
        $this->urls_list = array();
        foreach ($this->params->urls as $url) {
            $this->urls_list[$url] = 1;
        }
    }

    /**
     * @param Ressio_Event $event
     * @param IRessio_HtmlOptimizer $optimizer
     * @return void
     */
    public function onHtmlBeforeStringify($event, $optimizer)
    {
        if (!count($this->urls_list)) {
            return;
        }

        $tags = array();
        foreach (array_keys($this->urls_list) as $url) {
            $tags[] = array('link', array('rel' => 'preconnect', 'href' => $url), false);
        }

        if (count($tags)) {
            $optimizer->prependHead(...$tags);
        }

        if ($this->params->linkheader) {
            foreach ($tags as $tag) {
                $attrs = $tag[1];
                $href = $attrs['href'];
                $this->di->httpHeaders->setHeader("Link: <{$href}>; rel=preconnect", false);
            }
        }
    }

    /**
     * @param string $url
     * @return void
     */
    public function addURL($url)
    {
        if (strpos($url, '//') === false) {
            return;
        }
        $scheme = parse_url($url, PHP_URL_SCHEME);
        $domain = parse_url($url, PHP_URL_HOST);
        if ($scheme !== null && $domain !== null && $domain !== $this->current_domain) {
            $url = "$scheme://$domain";
            if (!isset($this->urls_list[$url])) {
                $this->urls_list[$url] = 1;
            }
        }
    }

    /**
     * @param Ressio_Event $event
     * @param string $url
     * @return void
     */
    public function onPreconnectDomain($event, $url)
    {
        $this->addURL($url);
    }
}