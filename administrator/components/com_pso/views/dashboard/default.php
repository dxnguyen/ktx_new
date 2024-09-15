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

include_once JPATH_COMPONENT . '/models/settings.php';
include_once JPATH_COMPONENT . '/classes/mjadminhelper.php';

echo $this->renderView('global/header');

MJToolbarHelper::apply();

MJToolbarHelper::cancel();

if ($this->joomlaWrapper->getUser()->authorise('core.admin', 'com_pso')) {
    MJToolbarHelper::divider();
    MJToolbarHelper::preferences('com_pso');
}

// populate $settings array
$settings = new MjSettingsModel($this->joomlaWrapper);
MjAdminHelper::jsGetNotification();

$doc = $this->joomlaWrapper->getDocument();
$doc->addScript('../media/com_pso/js/mjdashboard.js?v=1.4.2');

$form = array(
    //left
    array(
        'COM_PSO__WARNINGS' => include __DIR__ . '/cards/warnings.php',
        'COM_PSO__INFORMATION' => include __DIR__ . '/cards/information.php',
        'COM_PSO__SETTINGS' => include __DIR__ . '/cards/settings.php',
        'COM_PSO__SUPPORT' => array(
            'card' => '<div class="list-group list-group-flush mj-support">'
                . '<a class="list-group-item" target="_blank" href="https://www.mobilejoomla.com/documentation.html?ref=info">'
                . '<i class="icon-file"></i>' . MJText::_('COM_PSO__DOCUMENTATION')
                . '</a>'
                . '<a class="list-group-item" target="_blank" href="https://www.mobilejoomla.com/forums.html?ref=info">'
                . '<i class="icon-comments-2"></i>' . MJText::_('COM_PSO__FORUMS')
                . '</a>'
                . '<a class="list-group-item" target="_blank" href="https://www.mobilejoomla.com/forum/18-premium-support.html?ref=info">'
                . '<i class="icon-support"></i>' . MJText::_('COM_PSO__PREMIUM_SUPPORT_FORUMS')
                . '</a>'
                . '<a class="list-group-item" target="_blank" href="https://www.mobilejoomla.com/blog.html?ref=info">'
                . '<i class="icon-calendar"></i>' . MJText::_('COM_PSO__LATEST_NEWS')
                . '</a>'
                . '<a class="list-group-item" target="_blank" href="https://www.mobilejoomla.com/account.html?ref=info">'
                . '<i class="icon-user"></i>' . MJText::_('COM_PSO__MJ_ACCOUNT')
                . '</a>'
                . '<a class="list-group-item" target="_blank" href="mailto:support@mobilejoomla.com">'
                . '<i class="icon-mail"></i>support@mobilejoomla.com'
                . '</a>'
                . '</div>'
        ),
    ),
    //right
    array(
        'COM_PSO__OPTIMIZATION' => include __DIR__ . '/cards/optimization.php',
        'COM_PSO__PAGECACHE' => include __DIR__ . '/cards/pagecache.php',
        'COM_PSO__BACKUP_RESTORE' => include __DIR__ . '/cards/backup.php',
    )
);

echo $this->renderView('global/form', array(
    'form' => $form,
    'options' => array(
        MjUI::id('enabled') => $settings->get('enabled'),
        MjUI::id('apikey') => $settings->get('apikey'),
    ),
    'controllerName' => $controllerName,
    'viewName' => $viewName,
    'settings' => $settings
));

?>
<form id="mj_ajax" method="post">
    <?php echo MJHtml::_('form.token'); ?>
    <input type="hidden" name="task" value="">
</form>

