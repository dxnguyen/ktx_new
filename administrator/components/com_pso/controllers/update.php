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

require_once JPATH_COMPONENT . '/classes/mjbasecontroller.php';
include_once JPATH_COMPONENT . '/classes/mjupdate.php';

class MjUpdateController extends MjBaseController
{
    /** @return void */
    public function display()
    {
        $viewName = $this->joomlaWrapper->getRequestWord('view', 'default');
        echo $this->renderView($viewName);
    }

    /** @return void */
    public function download()
    {
        $hash = $_GET['hash'];
        $manifests = MjUpdate::getManifestsList();
        $manifest = false;
        foreach ($manifests as $manifestFile) {
            if (sha1($manifestFile) === $hash) {
                $manifest = $manifestFile;
            }
        }
        if ($manifest === false) {
            $this->errors[] = MJText::_('COM_PSO__UPDATE_UNKNOWN_EXTENSION');
        }

        $result = MjUpdate::check($manifest);

        if (isset($result['error'])) {
            $this->errors[] = MJText::_($result['error']);
        } elseif (!isset($result['url'])) {
            $this->errors[] = MJText::_('COM_PSO__UPDATE_UNAVAILABLE');
        } else {
            $url = $result['url'];

            include_once JPATH_COMPONENT . '/models/settings.php';
            $apikey = (new MjSettingsModel($this->joomlaWrapper))->get('apikey');
            if (!empty($apikey)) {
                $url .= (strpos($url, '?') !== false) ? '&' : '?';
                $url .= 'apikey=' . $apikey;
            }

            $packagefile = MjUpdate::download($url);
            if ($packagefile === false) {
                $this->errors[] = MJText::_('COM_PSO__UPDATE_DOWNLOAD_ERROR');
            } else {
                MJFactory::getApplication()->setUserState('com_pso.updatefilename', $packagefile);
            }
        }
    }

    /** @return void */
    public function unpack()
    {
        $app = MJFactory::getApplication();
        $filename = $app->getUserState('com_pso.updatefilename', false);
        $app->setUserState('com_pso.updatefilename', false);

        if ($filename) {
            $dir = MjUpdate::unpack($filename);
            if ($dir !== false) {
                $app->setUserState('com_pso.updatedir', $dir);
            } else {
                $this->errors[] = MJText::_('COM_PSO__UPDATE_UNPACK_ERROR');
            }
        } else {
            $this->errors[] = MJText::_('JLIB_INSTALLER_ABORT_NOINSTALLPATH');
        }
    }

    /** @return void */
    public function install()
    {
        $app = MJFactory::getApplication();
        $dir = $app->getUserState('com_pso.updatedir', false);
        $app->setUserState('com_pso.updatedir', false);

        if ($dir) {
            $status = MjUpdate::install($dir);
            if (!$status) {
                $this->errors[] = MJText::_('COM_PSO__UPDATE_INSTALL_ERROR');
            }
        } else {
            $this->errors[] = MJText::_('JLIB_INSTALLER_ABORT_NOINSTALLPATH');
        }
    }
}