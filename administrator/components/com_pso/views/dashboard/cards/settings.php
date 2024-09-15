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

$anonymous_stats = MjUI::prepare('onoff', $settings, 'anonymous_stats', 'COM_PSO__ANONYMOUS_STATS');
$anonymous_stats['input'] .=
    '<button id="mj_show_anonymous_stats" class="btn btn-info ms-5">' .
    MJText::_('COM_PSO__ANONYMOUS_STATS_SHOW_DATA') .
    '</button>' .
    '<div class="modal" id="mj_anonymous_stats_modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">' . MJText::_('COM_PSO__ANONYMOUS_STATS') . '</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="' . MJText::_('JCLOSE') . '"></button>
      </div>
      <div class="modal-body">
        <textarea disabled rows="5" class="form-control text-wrap"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">' . MJText::_('JCLOSE') . '</button>
      </div>
    </div>
  </div>
</div>';
$anonymous_stats['input'] = '<div class="btn-toolbar">' . $anonymous_stats['input'] . '</div>';

return array(
    MjUI::prepare('onoff', $settings, 'autoupdate', 'COM_PSO__AUTOUPDATE'),
    MjUI::prepare('onoff', $settings, 'updatenotify', 'COM_PSO__UPDATENOTIFY'),
    $anonymous_stats,
);
