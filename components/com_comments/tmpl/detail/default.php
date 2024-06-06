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
use \Joomla\CMS\Session\Session;
use Joomla\Utilities\ArrayHelper;


?>

<div class="item_fields">

	<table class="table">
		

		<tr>
			<th><?php echo Text::_('COM_COMMENTS_FORM_LBL_DETAIL_NAME'); ?></th>
			<td><?php echo $this->item->name; ?></td>
		</tr>

		<tr>
			<th><?php echo Text::_('COM_COMMENTS_FORM_LBL_DETAIL_COMMENT'); ?></th>
			<td><?php echo nl2br($this->item->comment); ?></td>
		</tr>

		<tr>
			<th><?php echo Text::_('COM_COMMENTS_FORM_LBL_DETAIL_IMAGE'); ?></th>
			<td>
			<?php
			foreach ((array) $this->item->image as $singleFile) : 
				if (!is_array($singleFile)) : 
					$uploadPath = 'uploads/students' . DIRECTORY_SEPARATOR . $singleFile;
					 echo '<a href="' . Route::_(Uri::root() . $uploadPath, false) . '" target="_blank">' . $singleFile . '</a> ';
				endif;
			endforeach;
		?></td>
		</tr>

		<tr>
			<th><?php echo Text::_('COM_COMMENTS_FORM_LBL_DETAIL_UNIVERSITY'); ?></th>
			<td><?php echo $this->item->university; ?></td>
		</tr>

		<tr>
			<th><?php echo Text::_('COM_COMMENTS_FORM_LBL_DETAIL_CREATED_DATE'); ?></th>
			<td>				<?php
			$date = $this->item->created_date;
			echo $date > 0 ? HTMLHelper::_('date', $date, Text::_('DATE_FORMAT_LC4')) : '-';
			?>

			</td>
		</tr>

	</table>

</div>

