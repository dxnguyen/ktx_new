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
require_once JPATH_ADMINISTRATOR . '/components/com_pso/classes/mjcontroller.php';

class MjSettingsController extends MjController
{
    /**
     * @param string $msg
     * @return void
     */
    public function save($msg = '')
    {
        include_once JPATH_COMPONENT . '/models/settings.php';
        $settings = new MjSettingsModel($this->joomlaWrapper);

        $bindData = array();
        foreach ($_POST as $key => $value) {
            if (strncmp($key, 'mj_', 3) === 0) {
                $param = substr($key, 3);
                if (strncmp($param, '__', 2) !== 0) { // skip PWA's internal names
                    $param = str_replace('-', '.', $param);
                    $bindData[$param] = $value;
                }
            }
        }

        $settings->set('desktop_url', MJUri::root());

        if (!$settings->bind($bindData)) {
            $msg = MJText::_('COM_PSO__ERROR_IN_DATA');
        } elseif (!$settings->save()) {
            $msg = MJText::_('COM_PSO__ERROR_CANNOT_SAVE_DATA');
        } else {
            $msg = MJText::_('COM_PSO__ERROR_DATA_HAVE_BEEN_SAVED_SUCCESSFULLY');
        }

        parent::save($msg);
    }
}