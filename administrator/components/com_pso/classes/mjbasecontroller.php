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

abstract class MjBaseController
{
    /** @var string */
    public $name = '';

    /** @var string */
    public $action = 'display';

    /** @var MjJoomlaWrapper */
    protected $joomlaWrapper;

    /** @var bool */
    protected $isAjaxRequest;

    /** @var ?string */
    protected $redirectUrl;

    /** @var ?string[] */
    protected $errors;

    /**
     * @param MjJoomlaWrapper $joomlaWrapper
     */
    public function __construct($joomlaWrapper)
    {
        $this->joomlaWrapper = $joomlaWrapper;
        $this->isAjaxRequest = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest');
    }

    /**
     * @param string $action
     * @return bool
     */
    public function execute($action)
    {
        $this->action = $action;

        if (method_exists(__CLASS__, $action) || !method_exists($this, $action) || !(new ReflectionMethod($this, $action))->isPublic()) {
            $this->enqueueError('Action is not found');
            return false;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            MJSession::checkToken() || jexit(MJText::_('JINVALID_TOKEN'));
        }

        if ($this->isAjaxRequest) {
            set_time_limit(1200);
            $this->errors = array();
            header('Content-Type: application/json');
        }

        $result = $this->$action();

        if ($this->isAjaxRequest) {
            $response = new stdClass();
            if (count($this->errors)) {
                $response->status = 'error';
                $response->errors = $this->errors;
            } else {
                $response->status = 'ok';
                if ($result !== null) {
                    $response->data = $result;
                }
            }
            echo json_encode($response);
            MJFactory::getApplication()->close();
            jexit();
        }

        return $result;
    }

    /** @return void */
    public function redirect()
    {
        if ($this->redirectUrl !== null) {
            /** @var JApplicationAdministrator $app */
            $app = MJFactory::getApplication();
            $app->redirect($this->redirectUrl);
        }
    }

    /**
     * @param string $redirectUrl
     * @return void
     */
    protected function setRedirect($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * @param string $viewName
     * @param array $params
     * @return ?string
     */
    protected function renderView($viewName, $params = array())
    {
        include_once JPATH_COMPONENT . '/classes/mjui.php';

        /** @var JApplicationAdministrator $app */
        $app = MJFactory::getApplication();

        MJPluginHelper::importPlugin('pso');
        $app->triggerEvent('onPsoRenderView', array($viewName, &$params));

        if (strpos($viewName, '/') !== false) {
            list($controllerName, $viewName) = explode('/', $viewName, 2);
        } else {
            $controllerName = $this->name;
        }

        $path = "/views/{$controllerName}/{$viewName}.php";
        $filename = JPATH_PLUGINS . "/pso/psopro$path";
        if (!is_file($filename)) {
            $filename = JPATH_COMPONENT . $path;
        }
        if (!is_file($filename)) {
            $this->enqueueError('View is not found: ' . $filename);
            return null;
        }

        ob_start();
        // variables visible in the layout file:
        /** JApplicationAdministrator $app */
        /** string                    $controllerName */
        /** string                    $filename */
        /** array                     $params */
        /** string                    $viewName */
        include $filename;
        return ob_get_clean();
    }

    /**
     * @param string $message
     * @return void
     */
    protected function enqueueError($message)
    {
        if ($this->isAjaxRequest) {
            $this->errors[] = $message;
        } else {
            MJFactory::getApplication()->enqueueMessage($message, 'error');
        }
    }
}