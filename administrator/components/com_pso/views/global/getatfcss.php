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

include_once JPATH_COMPONENT . '/models/settings.php';

// populate $settings array
$settings = new MjSettingsModel($this->joomlaWrapper);

$doc = $this->joomlaWrapper->getDocument();
$doc->addScript('../media/com_pso/js/atfbundle.js?v=1.4.2');
$doc->addScript('../media/com_pso/js/getatfcss.js?v=1.4.2');
$doc->addScriptDeclaration('var mj_apikey="' . addslashes($settings->get('apikey')) . '"');

?>
<div class="modal" tabindex="-1" id="getatfcssmodal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><?php echo MJText::_('COM_PSO__GETATFCSS_MODAL'); ?></h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="getatfcss-animation" class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden"><?php echo MJText::_('COM_PSO__GETATFCSS_LOADING'); ?></span>
                    </div>
                </div>
                <div id="getatfcss-error">
                    <p class="text-danger"><?php echo MJText::_('COM_PSO__GETATFCSS_ERROR_LOADING'); ?></p>
                </div>
                <div id="getatfcss-table">
                    <form>
                        <textarea disabled id="form_getatfcss_css" rows="5" class="text-wrap w-100"></textarea>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo MJText::_('JTOOLBAR_CLOSE'); ?></button>
                <button type="button" class="btn btn-primary" id="getatfcss_apply"><?php echo MJText::_('COM_PSO__GETATFCSS_APPLY'); ?></button>
            </div>
        </div>
    </div>
</div>
