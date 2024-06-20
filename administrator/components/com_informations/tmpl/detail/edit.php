<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Informations
 * @author     Nguyen Dinh <vb.dinhxuannguyen@gmail.com>
 * @copyright  2024 Nguyen Dinh
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

use \Joomla\CMS\HTML\HTMLHelper;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Uri\Uri;
use \Joomla\CMS\Router\Route;
use \Joomla\CMS\Language\Text;

$wa = $this->document->getWebAssetManager();
$wa->useScript('keepalive')
	->useScript('form.validate');
HTMLHelper::_('bootstrap.tooltip');
?>

<form
	action="<?php echo Route::_('index.php?option=com_informations&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="detail-form" class="form-validate form-horizontal">

	
	<?php echo HTMLHelper::_('uitab.startTabSet', 'myTab', array('active' => 'detail')); ?>
	<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'detail', Text::_('COM_INFORMATIONS_TAB_DETAIL', true)); ?>
	<div class="row-fluid">
		<div class="col-md-12 form-horizontal">
			<fieldset class="adminform">
				<legend><?php echo Text::_('COM_INFORMATIONS_FIELDSET_DETAIL'); ?></legend>
                <div class="control-group" style="margin-top: 70px;">
                    <div class="control-label"><hr style="color: #0c2d66; height: 2px;"/></div>
                    <div class="controls" style="color: #0c2d66;"><strong>THÔNG TIN CHUNG</strong></div>
                </div>
				<?php echo $this->form->renderField('slogan'); ?>
				<?php echo $this->form->renderField('address_1'); ?>
				<?php echo $this->form->renderField('address_2'); ?>
				<?php echo $this->form->renderField('hotline'); ?>
				<?php echo $this->form->renderField('telephone'); ?>
				<?php echo $this->form->renderField('logo'); ?>
                <div class="control-group">
                    <div class="control-label"></div>
                    <div class="controls">
                        <?php if (!empty($this->item->logo)) : ?>
                            <a href="<?php echo Route::_(Uri::root() . 'uploads/infos' . DIRECTORY_SEPARATOR . $this->item->logo, false);?>">
                                <img src="<?php echo Route::_(Uri::root() . 'uploads/infos' . DIRECTORY_SEPARATOR . $this->item->logo, false);?>" width="200" />
                            </a>
                            <input type="hidden" name="jform[logo_hidden]" id="jform_logo_hidden" value="<?php echo $this->item->logo; ?>" />
                        <?php endif; ?>
                    </div>
                </div>
				<?php echo $this->form->renderField('email_ktx'); ?>
                <?php echo $this->form->renderField('website'); ?>

                <div class="control-group" style="margin-top: 70px;">
                    <div class="control-label"><hr style="color: #0c2d66; height: 2px;"/></div>
                    <div class="controls" style="color: #0c2d66;"><strong>MẠNG XÃ HỘI</strong></div>
                </div>
				<?php echo $this->form->renderField('facebook'); ?>
				<?php echo $this->form->renderField('zalo'); ?>
				<?php echo $this->form->renderField('twitter'); ?>
				<?php echo $this->form->renderField('instagram'); ?>

                <div class="control-group" style="margin-top: 70px;">
                    <div class="control-label"><hr style="color: #0c2d66; height: 2px;"/></div>
                    <div class="controls" style="color: #0c2d66;"><strong>SỐ LIỆU THỐNG KÊ</strong></div>
                </div>
				<?php echo $this->form->renderField('students'); ?>
				<?php echo $this->form->renderField('scholarship'); ?>
				<?php echo $this->form->renderField('rooms'); ?>

                <div class="control-group" style="margin-top: 70px;">
                    <div class="control-label"><hr style="color: #0c2d66; height: 2px;"/></div>
                    <div class="controls" style="color: #0c2d66;"><strong>THAM QUAN KTX</strong></div>
                </div>
                <?php echo $this->form->renderField('video_ktx'); ?>
                <?php echo $this->form->renderField('ktx_online');?>

                <div class="control-group" style="margin-top: 70px;">
                    <div class="control-label"><hr style="color: #0c2d66; height: 2px;"/></div>
                    <div class="controls" style="color: #0c2d66;"><strong>TRẢI NGHIỆM KTX</strong></div>
                </div>
				<?php echo $this->form->renderField('tour_video'); ?>
				<?php if (!empty($this->item->tour_video)) : ?>
                    <div class="control-group">
                        <div class="control-label"></div>
                        <div class="controls">
                            <a href="<?php echo Route::_(Uri::root() . 'uploads/infos' . DIRECTORY_SEPARATOR . $this->item->tour_video, false);?>"><?php echo $this->item->tour_video; ?></a>
                            <input type="hidden" name="jform[tour_video_hidden]" id="jform_tour_video_hidden" value="<?php echo $this->item->tour_video; ?>" />
                        </div>
                    </div>

				<?php endif; ?>
                <?php echo $this->form->renderField('experience_text'); ?>

				<?php if ($this->state->params->get('save_history', 1)) : ?>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('version_note'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('version_note'); ?></div>
					</div>
				<?php endif; ?>
			</fieldset>
		</div>
	</div>
	<?php echo HTMLHelper::_('uitab.endTab'); ?>
	<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
	<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
	<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
	<input type="hidden" name="jform[checked_out]" value="<?php echo ($this->item->checked_out > 0) ? $this->item->checked_out : 0; ?>" />
	<input type="hidden" name="jform[checked_out_time]" value="<?php echo date('Y-m-d H:i:s'); ?>" />
	<?php echo $this->form->renderField('created_by'); ?>
	<?php echo $this->form->renderField('modified_by'); ?>

	<?php if (Factory::getApplication()->getIdentity()->authorise('core.admin','informations')) : ?>
	<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'permissions', Text::_('JGLOBAL_ACTION_PERMISSIONS_LABEL', true)); ?>
		<?php echo $this->form->getInput('rules'); ?>
	<?php echo HTMLHelper::_('uitab.endTab'); ?>
<?php endif; ?>
	<?php echo HTMLHelper::_('uitab.endTabSet'); ?>

	<input type="hidden" name="task" value=""/>
	<?php echo HTMLHelper::_('form.token'); ?>

</form>
<style>
    .control-group .controls { max-width: 600px; }
</style>