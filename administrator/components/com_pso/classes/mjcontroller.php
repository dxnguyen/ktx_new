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

require_once JPATH_ADMINISTRATOR . '/components/com_pso/classes/mjbasecontroller.php';

abstract class MjController extends MjBaseController
{
    /** @var string */
    private $banner = 'This feature is available in <a href="https://www.mobilejoomla.com/upgrade-psopro?utm_source=psobackend&amp;utm_medium=Advanced-tab-upgrade&amp;utm_campaign=Admin-upgrade" target="_blank">Page Speed Optimizer <b>Pro</b></a>';

    /** @return void */
    public function display()
    {
        $this->loadFramework();

        $viewName = $this->joomlaWrapper->getRequestWord('view', 'default');

        echo $this->renderView('global/page', array(
            'banner' => $this->getBanner(),
            'menu' => $this->renderView('global/menu', array(
                'controllerName' => $this->name,
                'viewName' => $viewName
            )),
            'content' => $this->renderView($viewName)
        ));
    }

    /**
     * @param string $msg
     * @return void
     */
    public function save($msg = '')
    {
        if ($msg !== '') {
            /** @var JApplicationAdministrator $app */
            $app = MJFactory::getApplication();
            $app->enqueueMessage($msg);
        }

        $redirectUrl = 'index.php?option=com_pso&controller=' . $this->name;

        $viewName = $this->joomlaWrapper->getRequestWord('view', 'default');
        if ($viewName !== 'default') {
            $redirectUrl .= '&view=' . $viewName;
        }

        $this->setRedirect($redirectUrl);
    }

    /** @return void */
    public function apply()
    {
        $this->save();
    }

    /** @return void */
    public function cancel()
    {
        $redirectUrl = 'index.php?option=com_pso';
        $this->setRedirect($redirectUrl);
    }

    /** @return void */
    protected function loadFramework()
    {
        $doc = $this->joomlaWrapper->getDocument();

        $doc->addStyleSheet('../media/com_pso/css/mj.bootstrap.min.css?v=1.4.2');
        $doc->addStyleSheet('../media/com_pso/css/mjfix.css?v=1.4.2');
        if (MJFactory::getApplication()->getTemplate() === 'atum') {
            $doc->addStyleSheet('../media/com_pso/css/atum_compat.css?v=1.4.2');
        }

        if (version_compare(JVERSION, '3.0', '>=')) {
            MJHtml::_('jquery.framework');
        } else {
            $doc->addScript('../media/com_pso/js/jquery.min.js?v=1.4.2');
            $doc->addScript('../media/com_pso/js/jquery-noconflict.js?v=1.4.2');
        }

        if (version_compare(JVERSION, '4.0', '>=')) {
            MJHtml::_('bootstrap.collapse');
            MJHtml::_('bootstrap.tooltip');
            MJHtml::_('bootstrap.modal');
            MJHtml::_('bootstrap.alert');
        } else {
            $doc->addScript('../media/com_pso/js/bootstrap.bundle.min.js?v=1.4.2');
        }

        $doc->addScript('../media/com_pso/js/mj.js?v=1.4.2');
    }

    /**
     * @return string
     */
    protected function getBanner()
    {
        if (MJPluginHelper::isEnabled('pso', 'psopro')) {
            return '';
        }

        $doc = MjJoomlaWrapper::getInstance()->getDocument();
        $doc->addStyleSheet('../media/com_pso/css/mjprostub.css?v=1.4.2');
        $doc->addScript('../media/com_pso/js/mjprostub.js?v=1.4.2');

        return '<div id="mjprobanner">' . $this->banner . '</div>';
    }
}