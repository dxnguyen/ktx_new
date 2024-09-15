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

/** @var MjController $this */
/** @var array $params */
/** @var string $controllerName */
/** @var string $viewName */
/** @var MjSettingsModel $settings */

return array(
    array(
        'id' => 'backup_create',
        'label' => MjUI::prolabel('COM_PSO__BACKUP_SETTINGS'),
        'input' => '<div class="mjpro">'
            . '<a id="backup-settings" href="#" onclick="return false;" class="btn btn-info disabled w-100">' . MJText::_('COM_PSO__BACKUP') . '</a>'
            . '</div>'
    ),
    array(
        'id' => 'backup_restore',
        'label' => MjUI::prolabel('COM_PSO__RESTORE'),
        'input' => '<div class="mjpro"><div class="custom-file" id="restore_file">'
            . '<input type="file" disabled class="custom-file-input"/>'
            . '<label class="custom-file-label" data-browse="' . MJText::_('COM_PSO__BROWSE') . '">' . MJText::_('COM_PSO__CHOOSE_FILE') . '</label>'
            . '<div class="disabled-input-overlay"></div>'
            . '</div>'
            . '<a href="#" class="btn btn-info disabled w-100 mt-2" onclick="return false;">' . MJText::_('COM_PSO__RESTORE_BTN') . '</a>'
            . '</div>'
    )
);
