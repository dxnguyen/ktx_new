<?php
    defined('_JEXEC') or die;

    use Joomla\CMS\Component\Router\RouterBase;
    use Joomla\CMS\Component\Router\Route;
    use Joomla\CMS\Uri\Uri;

    class ModNewsRouter extends RouterBase
    {
        public function build(&$query)
        {
            $segments = [];

            if (isset($query['view'])) {
                $segments[] = $query['view'];
                unset($query['view']);
            }

            if (isset($query['id'])) {
                $segments[] = $query['id'];
                unset($query['id']);
            }

            return $segments;
        }

        public function parse(&$segments)
        {
            $vars = [];

            $vars['view'] = $segments[0];

            if (isset($segments[1])) {
                $vars['id'] = $segments[1];
            }

            return $vars;
        }
    }
