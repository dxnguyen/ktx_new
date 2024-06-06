<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Comments
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
	action="<?php echo Route::_('index.php?option=com_comments&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="detail-form" class="form-validate form-horizontal">

	
	<?php echo HTMLHelper::_('uitab.startTabSet', 'myTab', array('active' => 'detail')); ?>
	<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'detail', Text::_('COM_COMMENTS_TAB_DETAIL', true)); ?>
	<div class="row-fluid">
		<div class="col-md-12 form-horizontal">
			<fieldset class="adminform">
				<legend><?php echo Text::_('COM_COMMENTS_FIELDSET_DETAIL'); ?></legend>
				<?php echo $this->form->renderField('name'); ?>
				<?php echo $this->form->renderField('comment'); ?>
				<?php echo $this->form->renderField('image'); ?>
				<?php if (!empty($this->item->image)) : ?>
                    <div class="control-group">
                        <div class="control-label"> </div>
                        <div class="controls has-success">
                            <a href="<?php echo Route::_(Uri::root() . 'uploads/students' . DIRECTORY_SEPARATOR . $this->item->image, false);?>">
                                <img src="<?php echo Route::_(Uri::root() . 'uploads/students' . DIRECTORY_SEPARATOR . $this->item->image, false);?>" width="200" />
                            </a>
                        </div>
                    </div>
					<input type="hidden" name="jform[image_hidden]" id="jform_image_hidden" value="<?php echo $this->item->image; ?>" />
				<?php endif; ?>
				<?php echo $this->form->renderField('university'); ?>
				<?php //echo $this->form->renderField('created_date'); ?>
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
	<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
	<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />
    <?php if (!$this->item->id) : ?>
        <input type="hidden" name="jform[created_date]" value="<?php echo $this->item->created_date; ?>" />
    <?php endif; ?>
	<?php echo $this->form->renderField('created_by'); ?>
	<?php echo $this->form->renderField('modified_by'); ?>

	<?php if (Factory::getApplication()->getIdentity()->authorise('core.admin','comments')) : ?>
	<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'permissions', Text::_('JGLOBAL_ACTION_PERMISSIONS_LABEL', true)); ?>
		<?php echo $this->form->getInput('rules'); ?>
	<?php echo HTMLHelper::_('uitab.endTab'); ?>
<?php endif; ?>
	<?php echo HTMLHelper::_('uitab.endTabSet'); ?>

	<input type="hidden" name="task" value=""/>
	<?php echo HTMLHelper::_('form.token'); ?>

</form>
