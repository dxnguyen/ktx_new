<?php

    /**
     * @version    CVS: 1.0.0
     * @package    Com_Prints
     * @author     Nguyen Dinh <vb.dinhxuannguyen@gmail.com>
     * @copyright  2024 Nguyen Dinh
     * @license    GNU General Public License version 2 or later; see LICENSE.txt
     */

    namespace Homepage\Component\Homepage\Site\Service;

    // No direct access
    defined('_JEXEC') or die;

    use Joomla\CMS\Component\Router\RouterViewConfiguration;
    use Joomla\CMS\Component\Router\RouterView;
    use Joomla\CMS\Component\Router\Rules\StandardRules;
    use Joomla\CMS\Component\Router\Rules\NomenuRules;
    use Joomla\CMS\Component\Router\Rules\MenuRules;
    use Joomla\CMS\Factory;
    use Joomla\CMS\Categories\Categories;
    use Joomla\CMS\Application\SiteApplication;
    use Joomla\CMS\Categories\CategoryFactoryInterface;
    use Joomla\CMS\Categories\CategoryInterface;
    use Joomla\Database\DatabaseInterface;
    use Joomla\CMS\Menu\AbstractMenu;
    use Joomla\CMS\Component\ComponentHelper;

    /**
     * Class HomepageRouter
     *
     */
    class Router extends RouterView
    {
        private $noIDs;
        /**
         * The category factory
         *
         * @var    CategoryFactoryInterface
         *
         * @since  1.0.0
         */
        private $categoryFactory;

        /**
         * The category cache
         *
         * @var    array
         *
         * @since  1.0.0
         */
        private $categoryCache = [];

        public function __construct(SiteApplication $app, AbstractMenu $menu, CategoryFactoryInterface $categoryFactory, DatabaseInterface $db)
        {
            $params = ComponentHelper::getParams('com_homepage');
            $this->noIDs = (bool) $params->get('sef_ids');
            $this->categoryFactory = $categoryFactory;


            $prints = new RouterViewConfiguration('details');
            $this->registerView($prints);
            $ccDetail = new RouterViewConfiguration('detail');
            $ccDetail->setKey('id')->setParent($prints);
            $this->registerView($ccDetail);

            parent::__construct($app, $menu);

            $this->attachRule(new MenuRules($this));
            $this->attachRule(new StandardRules($this));
            $this->attachRule(new NomenuRules($this));
        }



        /**
         * Method to get the segment(s) for an detail
         *
         * @param   string  $id     ID of the detail to retrieve the segments for
         * @param   array   $query  The request that is built right now
         *
         * @return  array|string  The segments of this item
         */
        public function getDetailSegment($id, $query)
        {
            return array((int) $id => $id);
        }


        /**
         * Method to get the segment(s) for an detail
         *
         * @param   string  $segment  Segment of the detail to retrieve the ID for
         * @param   array   $query    The request that is parsed right now
         *
         * @return  mixed   The id of this item or false
         */
        public function getDetailId($segment, $query)
        {
            return (int) $segment;
        }

        /**
         * Method to get categories from cache
         *
         * @param   array  $options   The options for retrieving categories
         *
         * @return  CategoryInterface  The object containing categories
         *
         * @since   1.0.0
         */
        private function getCategories(array $options = []): CategoryInterface
        {
            $key = serialize($options);

            if (!isset($this->categoryCache[$key]))
            {
                $this->categoryCache[$key] = $this->categoryFactory->createCategory($options);
            }

            return $this->categoryCache[$key];
        }
    }
