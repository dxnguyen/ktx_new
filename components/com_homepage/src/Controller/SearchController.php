<?php
    /**
     * @version    CVS: 1.0.0
     * @package    Com_Events
     * @author     Nguyen Dinh <vb.dinhxuannguyen@gmail.com>
     * @copyright  2024 Nguyen Dinh
     * @license    GNU General Public License version 2 or later; see LICENSE.txt
     */

    namespace Homepage\Component\Homepage\Site\Controller;

    \defined('_JEXEC') or die;

    use Joomla\CMS\Application\SiteApplication;
    use Joomla\CMS\Factory;
    use Joomla\CMS\Language\Multilanguage;
    use Joomla\CMS\Language\Text;
    use Joomla\CMS\MVC\Controller\FormController;
    use Joomla\CMS\Router\Route;
    use Joomla\CMS\Uri\Uri;
    use Joomla\Utilities\ArrayHelper;

    /**
     * Events class.
     *
     * @since  1.0.0
     */
    class SearchController extends FormController
    {
        /**
         * Proxy for getModel.
         *
         * @param   string  $name    The model name. Optional.
         * @param   string  $prefix  The class prefix. Optional
         * @param   array   $config  Configuration array for model. Optional
         *
         * @return  object	The model
         *
         * @since   1.0.0
         */
        public function getModel($name = 'Search', $prefix = 'Site', $config = array())
        {
            return parent::getModel($name, $prefix, array('ignore_request' => true));
        }


    }
