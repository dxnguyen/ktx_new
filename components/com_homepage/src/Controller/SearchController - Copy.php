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

use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Application\SiteApplication;
use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormFactoryInterface;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\FormController;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Input\Input;
use Joomla\Utilities\ArrayHelper;

/**
 * Details class.
 *
 * @since  1.0.0
 */
class SearchController extends FormController
{

    public function display($cachable = false, $urlparams = [])
    {
        echo __FILE__;die;

        parent::display($cachable, $urlparams);
    }

    public function search() {
        $app      = Factory::getApplication();
        $formData = $app->input->get('jform', array(), 'array');
        $keyword  = $formData['keyword'];
        $model    = $this->getModel('Search');
        $lists    = $model->getSearch($keyword);

        $view = $this->getView('Search', 'html');
        $view->set('results', $lists);
        $view->display();
        print_r($lists); die;
        /*$view = $this->input->getCmd('view', 'Search');
        $view = $this->getView($view, 'html');

        $view->setModel($model, true);

        $view->data = $lists;*/
        //$this->getView()->setLayout('default')->data = $lists;
        //$view = $this->getView('Search', 'html');
        //$view->setModel($model, true);
        //$view->assign('items', $lists);
        //$view = $this->getView('Search', 'html');

        // Truyền dữ liệu cho view bằng thuộc tính của view
        /*$view->items = $lists;
        $this->set('items', $lists);*/
        //$view->assignRef('searchTerm', $searchTerm);
        //$this->setRedirect( Route::_('index.php?option=com_homepage&view=search'), false );
        //$this->setLayout('default')->addData($lists);
        //return $lists;
    }
}
