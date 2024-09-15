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

$doc = $this->joomlaWrapper->getDocument();

$doc->addStyleSheet('../media/com_pso/css/mj.bootstrap.min.css?v=1.4.2');
$doc->addStyleSheet('../media/com_pso/css/mjfix.css?v=1.4.2');

if (version_compare(JVERSION, '3.0', '>=')) {
    MJHtml::_('jquery.framework');
} else {
    $doc->addScript('../media/com_pso/js/jquery.min.js?v=1.4.2');
    $doc->addScript('../media/com_pso/js/jquery-noconflict.js?v=1.4.2');
}

$doc->addScript('../media/com_pso/js/mjupdatepopup.js?v=1.4.2');

$this->joomlaWrapper->loadLanguageFile('com_pso.sys');

include_once JPATH_COMPONENT . '/classes/mjupdate.php';
$updates = MjUpdate::checkUpdates();

?>
<div id="mj">
<h1><?php echo MJText::_('COM_PSO__UPDATE_HEADER'); ?></h1>
<?php

$i = 0;
foreach ($updates as $manifest => $new_version) {
    ++$i;
    $xml = simplexml_load_file($manifest);
    ?>
        <div class="mj-update-item" id="mj-update-<?php echo $i; ?>" data-hash="<?php echo sha1($manifest); ?>">
            <h2><?php echo MJText::_($xml->name) . ' ' . $new_version; ?></h2>
            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated d-none mj-download" role="progressbar" style="width: 33%"><?php echo MJText::_('COM_PSO__UPDATE_DOWNLOAD'); ?></div>
                <div class="progress-bar progress-bar-striped progress-bar-animated d-none mj-unpack"   role="progressbar" style="width: 33%"><?php echo MJText::_('COM_PSO__UPDATE_UNPACK'); ?></div>
                <div class="progress-bar progress-bar-striped progress-bar-animated d-none mj-install"  role="progressbar" style="width: 34%"><?php echo MJText::_('COM_PSO__UPDATE_INSTALL'); ?></div>
            </div>
            <div class="mj-error text-danger d-none"><span class="mj-status"></span><span class="mj-errors"></span></div>
        </div>
        <hr>
    <?php
}
?>
<div class="mj-downloadurl d-none"><?php echo MJText::_('COM_PSO__UPDATE_DOWNLOAD_LINK'); ?></div>
<script type="text/javascript">
    var mjErrorTexts = {
        'error': "<?php echo MJText::_('COM_PSO__UPDATE_AJAX_ERROR'); ?>",
        'timeout': "<?php echo MJText::_('COM_PSO__UPDATE_AJAX_TIMEOUT'); ?>",
        'abort': "<?php echo MJText::_('COM_PSO__UPDATE_AJAX_ABORT'); ?>",
        'parsererror': "<?php echo MJText::_('COM_PSO__UPDATE_AJAX_PARSEERROR'); ?>",
    };
</script>
<form id="mj-installer">
    <input type="hidden" name="option" value="com_pso">
    <input type="hidden" name="controller" value="update">
    <input type="hidden" name="format" value="raw">
</form>
</div>