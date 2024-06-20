<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Partners
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
use \Joomla\CMS\Layout\LayoutHelper;
use \Joomla\CMS\Session\Session;
use \Joomla\CMS\User\UserFactoryInterface;

HTMLHelper::_('bootstrap.tooltip');
HTMLHelper::_('behavior.multiselect');
HTMLHelper::_('formbehavior.chosen', 'select');

$user       = Factory::getApplication()->getIdentity();
$userId     = $user->get('id');
$listOrder  = $this->state->get('list.ordering');
$listDirn   = $this->state->get('list.direction');
$canCreate  = $user->authorise('core.create', 'com_partners') && file_exists(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'forms' . DIRECTORY_SEPARATOR . 'detailform.xml');
$canEdit    = $user->authorise('core.edit', 'com_partners') && file_exists(JPATH_COMPONENT .  DIRECTORY_SEPARATOR . 'forms' . DIRECTORY_SEPARATOR . 'detailform.xml');
$canCheckin = $user->authorise('core.manage', 'com_partners');
$canChange  = $user->authorise('core.edit.state', 'com_partners');
$canDelete  = $user->authorise('core.delete', 'com_partners');

// Import CSS
$wa = $this->document->getWebAssetManager();
$wa->useStyle('com_partners.list');
?>

<form action="<?php echo htmlspecialchars(Uri::getInstance()->toString()); ?>" method="post"
	  name="adminForm" id="adminForm">
	<?php if(!empty($this->filterForm)) { echo LayoutHelper::render('joomla.searchtools.default', array('view' => $this)); } ?>
	<div class="table-responsive">
		<table class="table table-striped" id="detailList">
			<thead>
			<tr>
				
					<th class=''>
						<?php echo HTMLHelper::_('grid.sort',  'COM_PARTNERS_PARTNERS_ID', 'a.id', $listDirn, $listOrder); ?>
					</th>

					<th >
						<?php echo HTMLHelper::_('grid.sort', 'JPUBLISHED', 'a.state', $listDirn, $listOrder); ?>
					</th>

					<th class=''>
						<?php echo HTMLHelper::_('grid.sort',  'COM_PARTNERS_PARTNERS_TITLE', 'a.title', $listDirn, $listOrder); ?>
					</th>

					<th class=''>
						<?php echo HTMLHelper::_('grid.sort',  'COM_PARTNERS_PARTNERS_IMAGE', 'a.image', $listDirn, $listOrder); ?>
					</th>

					<th class=''>
						<?php echo HTMLHelper::_('grid.sort',  'COM_PARTNERS_PARTNERS_IMAGE_LINK', 'a.image_link', $listDirn, $listOrder); ?>
					</th>

					<th class=''>
						<?php echo HTMLHelper::_('grid.sort',  'COM_PARTNERS_PARTNERS_CREATED_DATE', 'a.created_date', $listDirn, $listOrder); ?>
					</th>

						<?php if ($canEdit || $canDelete): ?>
					<th class="center">
						<?php echo Text::_('COM_PARTNERS_PARTNERS_ACTIONS'); ?>
					</th>
					<?php endif; ?>

			</tr>
			</thead>
			<tfoot>
			<tr>
				<td colspan="<?php echo isset($this->items[0]) ? count(get_object_vars($this->items[0])) : 10; ?>">
					<div class="pagination">
						<?php echo $this->pagination->getPagesLinks(); ?>
					</div>
				</td>
			</tr>
			</tfoot>
			<tbody>
			<?php foreach ($this->items as $i => $item) : ?>
				<?php $canEdit = $user->authorise('core.edit', 'com_partners'); ?>
				
				<tr class="row<?php echo $i % 2; ?>">
					
					<td>
						<?php echo $item->id; ?>
					</td>
					<td>
						<?php $class = ($canChange) ? 'active' : 'disabled'; ?>
						<a class="btn btn-micro <?php echo $class; ?>" href="<?php echo ($canChange) ? Route::_('index.php?option=com_partners&task=detail.publish&id=' . $item->id . '&state=' . (($item->state + 1) % 2), false, 2) : '#'; ?>">
						<?php if ($item->state == 1): ?>
							<i class="icon-publish"></i>
						<?php else: ?>
							<i class="icon-unpublish"></i>
						<?php endif; ?>
						</a>
					</td>
					<td>
						<?php echo $item->title; ?>
					</td>
					<td>
						<?php
							if (!empty($item->image)) :
								$imageArr = (array) explode(',', $item->image);
								foreach ($imageArr as $singleFile) : 
									if (!is_array($singleFile)) :
										$uploadPath = 'uploads/partners' . DIRECTORY_SEPARATOR . $singleFile;
										echo '<a href="' . Route::_(Uri::root() . $uploadPath, false) . '" target="_blank" title="See the image">' . $singleFile . '</a> ';
									endif;
								endforeach;
							else:
								echo $item->image;
							endif; ?>
					</td>
					<td>
						<?php echo $item->image_link; ?>
					</td>
					<td>
						<?php echo $item->created_date; ?>
					</td>
					<?php if ($canEdit || $canDelete): ?>
						<td class="center">
						</td>
					<?php endif; ?>

				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<?php if ($canCreate) : ?>
		<a href="<?php echo Route::_('index.php?option=com_partners&task=detailform.edit&id=0', false, 0); ?>"
		   class="btn btn-success btn-small"><i
				class="icon-plus"></i>
			<?php echo Text::_('COM_PARTNERS_ADD_ITEM'); ?></a>
	<?php endif; ?>

	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<input type="hidden" name="filter_order" value=""/>
	<input type="hidden" name="filter_order_Dir" value=""/>
	<?php echo HTMLHelper::_('form.token'); ?>
</form>

<?php
	if($canDelete) {
		$wa->addInlineScript("
			jQuery(document).ready(function () {
				jQuery('.delete-button').click(deleteItem);
			});

			function deleteItem() {

				if (!confirm(\"" . Text::_('COM_PARTNERS_DELETE_MESSAGE') . "\")) {
					return false;
				}
			}
		", [], [], ["jquery"]);
	}
?>