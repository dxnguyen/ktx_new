<?php
    namespace Homepage\Component\Homepage\Site\Service;
    defined('_JEXEC') or die;

    use Joomla\CMS\Component\Router\RouterView;
    use Joomla\CMS\Component\Router\Rules\RulesInterface;

    /**
     * Rule to process URLs without a menu item
     *
     * @since  3.4
     */
    class HomepageNomenuRules implements RulesInterface
    {

        protected $router;

        public function __construct(RouterView $router)
        {
            $this->router = $router;
        }

        public function preprocess(&$query)
        {
            //$test = 'Test';
        }

        /**
         * Parse a menu-less URL
         *
         * @param   array  &$segments  The URL segments to parse
         * @param   array  &$vars      The vars that result from the segments
         *
         * @return  void
         *
         * @since   3.4
         */
        public function parse(&$segments, &$vars)
        {

            $vars['view'] = 'Details';
            $vars['id'] = substr($segments[0], strpos($segments[0], '-') + 1);
            array_shift($segments);
            array_shift($segments);
            return;
        }


        public function build(&$query, &$segments)
        {

            if (!isset($query['view']) || (isset($query['view']) && $query['view'] !== 'Details') || isset($query['format']))
            {
                return;
            }
            $segments[] = $query['view'] . '-' . $query['id'];
            // the last part of the url may be missing
            if (isset($query['slug'])) {
                $segments[] = $query['slug'];
                unset($query['slug']);
            }
            unset($query['view']);
            unset($query['id']);

        }
    }