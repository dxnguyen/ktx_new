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

$isPro = MJPluginHelper::isEnabled('pso', 'psopro');
$subscription_title = $isPro ? 'Pro' : 'Free';

include_once JPATH_COMPONENT . '/classes/mjupdate.php';
$manifests = MjUpdate::getManifests();
$psoVersion = '';
foreach ($manifests as $type => $files) {
    foreach ($files as $manifest) {
        if (is_file($manifest)) {
            $xmlManifest = simplexml_load_file($manifest);
            $psoVersion = (string)$xmlManifest->version;
            break;
        }
    }
}
if ($isPro) {
    $psoVersion = 'Pro ' . $psoVersion;
}

return array(
    MjUI::prepare('textinput', $settings, 'apikey', 'COM_PSO__API_KEY'),
    array(
        'label' => MjUI::label('', 'COM_PSO__SUBSCRIPTION'),
        'input' =>
            '<div class="row">'
            . '<div class="col-auto">'
            . '<b class="btn border-info text-info fw-bold">' . $subscription_title . '</b> '
            . '</div>'
            . ($subscription_title === 'Pro' ? '' :
                '<div class="col-auto">'
                . '<a href="https://www.mobilejoomla.com/upgrade-psopro?utm_source=psobackend&amp;utm_medium=General-tab-upgrade&amp;utm_campaign=Admin-upgrade"
                            target="_blank" class="btn btn-primary">'
                . MJText::_('COM_PSO__UPGRADE')
                . '</a>'
                . '</div>'
            )
            . '</div>'
    ),
    array(
        'label' => MjUI::label('', 'COM_PSO__CURRENT_VERSION'),
        'input' => MjUI::text('<span id="mjversion">' . $psoVersion . '</span>')
    ),
    array(
        'label' => MjUI::label('', 'COM_PSO__LATEST_VERSION'),
        'input' =>
            '<div class="row">'
            . '<div class="col-auto">'
            . '<span id="mjconfig_latestver" class="form-control-plaintext"><span id="mjlatestver"></span></span>'
            . '</div>'
            . '</div>'
    ),
);
