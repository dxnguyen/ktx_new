<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Homepage
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
 * Details class.
 *
 * @since  1.0.0
 */
class SearchController extends FormController
{

    public function search() {
        $app      = Factory::getApplication();
        //$config = $app->getConfig()->get('lifetime'); print_r($config);die;
        $formData = $app->input->get('jform', array(), 'array');
        $keyword  = $formData['keyword'];

        $model = $this->getModel('Search');
        $lists = $model->getSearch($keyword);

        return $lists;
    }
}
