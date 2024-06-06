<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Informations
 * @author     Nguyen Dinh <vb.dinhxuannguyen@gmail.com>
 * @copyright  2024 Nguyen Dinh
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Informations\Component\Informations\Administrator\Table;
// No direct access
defined('_JEXEC') or die;

use \Joomla\Utilities\ArrayHelper;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Access\Access;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Table\Table as Table;
use \Joomla\CMS\Versioning\VersionableTableInterface;
use Joomla\CMS\Tag\TaggableTableInterface;
use Joomla\CMS\Tag\TaggableTableTrait;
use \Joomla\Database\DatabaseDriver;
use \Joomla\CMS\Filter\OutputFilter;
use \Joomla\CMS\Filesystem\File;
use \Joomla\Registry\Registry;
use \Informations\Component\Informations\Administrator\Helper\InformationsHelper;
use \Joomla\CMS\Helper\ContentHelper;


/**
 * Detail table
 *
 * @since 1.0.0
 */
class DetailTable extends Table implements VersionableTableInterface, TaggableTableInterface
{
	use TaggableTableTrait;

	/**
     * Indicates that columns fully support the NULL value in the database
     *
     * @var    boolean
     * @since  4.0.0
     */
    protected $_supportNullValue = true;

	
	/**
	 * Constructor
	 *
	 * @param   JDatabase  &$db  A database connector object
	 */
	public function __construct(DatabaseDriver $db)
	{
		$this->typeAlias = 'com_informations.detail';
		parent::__construct('#__informations', 'id', $db);
		$this->setColumnAlias('published', 'state');
		
	}

	/**
	 * Get the type alias for the history table
	 *
	 * @return  string  The alias as described above
	 *
	 * @since   1.0.0
	 */
	public function getTypeAlias()
	{
		return $this->typeAlias;
	}

	/**
	 * Overloaded bind function to pre-process the params.
	 *
	 * @param   array  $array   Named array
	 * @param   mixed  $ignore  Optional array or list of parameters to ignore
	 *
	 * @return  boolean  True on success.
	 *
	 * @see     Table:bind
	 * @since   1.0.0
	 * @throws  \InvalidArgumentException
	 */
	public function bind($array, $ignore = '')
	{
		$date = Factory::getDate();
		$task = Factory::getApplication()->input->get('task');
		$user = Factory::getApplication()->getIdentity();
		
		$input = Factory::getApplication()->input;
		$task = $input->getString('task', '');

		if ($array['id'] == 0 && empty($array['created_by']))
		{
			$array['created_by'] = Factory::getUser()->id;
		}

		if ($array['id'] == 0 && empty($array['modified_by']))
		{
			$array['modified_by'] = Factory::getUser()->id;
		}

		if ($task == 'apply' || $task == 'save')
		{
			$array['modified_by'] = Factory::getUser()->id;
		}
		// Support for multi file field: logo
		if (!empty($array['logo']))
		{
			if (is_array($array['logo']))
			{
				$array['logo'] = implode(',', $array['logo']);
			}
			elseif (strpos($array['logo'], ',') != false)
			{
				$array['logo'] = explode(',', $array['logo']);
			}
		}
		else
		{
			$array['logo'] = '';
		}

		// Support for multi file field: tour_video
		if (!empty($array['tour_video']))
		{
			if (is_array($array['tour_video']))
			{
				$array['tour_video'] = implode(',', $array['tour_video']);
			}
			elseif (strpos($array['tour_video'], ',') != false)
			{
				$array['tour_video'] = explode(',', $array['tour_video']);
			}
		}
		else
		{
			$array['tour_video'] = '';
		}


		if (isset($array['params']) && is_array($array['params']))
		{
			$registry = new Registry;
			$registry->loadArray($array['params']);
			$array['params'] = (string) $registry;
		}

		if (isset($array['metadata']) && is_array($array['metadata']))
		{
			$registry = new Registry;
			$registry->loadArray($array['metadata']);
			$array['metadata'] = (string) $registry;
		}

		if (!$user->authorise('core.admin', 'com_informations.detail.' . $array['id']))
		{
			$actions         = Access::getActionsFromFile(
				JPATH_ADMINISTRATOR . '/components/com_informations/access.xml',
				"/access/section[@name='detail']/"
			);
			$default_actions = Access::getAssetRules('com_informations.detail.' . $array['id'])->getData();
			$array_jaccess   = array();

			foreach ($actions as $action)
			{
				if (key_exists($action->name, $default_actions))
				{
					$array_jaccess[$action->name] = $default_actions[$action->name];
				}
			}

			$array['rules'] = $this->JAccessRulestoArray($array_jaccess);
		}

		// Bind the rules for ACL where supported.
		if (isset($array['rules']) && is_array($array['rules']))
		{
			$this->setRules($array['rules']);
		}

		return parent::bind($array, $ignore);
	}

	/**
	 * Method to store a row in the database from the Table instance properties.
	 *
	 * If a primary key value is set the row with that primary key value will be updated with the instance property values.
	 * If no primary key value is set a new row will be inserted into the database with the properties from the Table instance.
	 *
	 * @param   boolean  $updateNulls  True to update fields even if they are null.
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   1.0.0
	 */
	public function store($updateNulls = true)
	{
		
		return parent::store($updateNulls);
	}

	/**
	 * This function convert an array of Access objects into an rules array.
	 *
	 * @param   array  $jaccessrules  An array of Access objects.
	 *
	 * @return  array
	 */
	private function JAccessRulestoArray($jaccessrules)
	{
		$rules = array();

		foreach ($jaccessrules as $action => $jaccess)
		{
			$actions = array();

			if ($jaccess)
			{
				foreach ($jaccess->getData() as $group => $allow)
				{
					$actions[$group] = ((bool)$allow);
				}
			}

			$rules[$action] = $actions;
		}

		return $rules;
	}

	/**
	 * Overloaded check function
	 *
	 * @return bool
	 */
	public function check()
	{
		// If there is an ordering column and this is a new row then get the next ordering value
		if (property_exists($this, 'ordering') && $this->id == 0)
		{
			$this->ordering = self::getNextOrder();
		}
		
		
		// Support multi file field: logo
		$app = Factory::getApplication();
		$files = $app->input->files->get('jform', array(), 'raw');
		$array = $app->input->get('jform', array(), 'ARRAY');
		if (empty($files['logo'][0])){
			$temp = $files;
			$files = array();
			$files['logo'][] = $temp['logo'];
		}

		if ($files['logo'][0]['size'] > 0)
		{
			// Deleting existing files
			$oldFiles = InformationsHelper::getFiles($this->id, $this->_tbl, 'logo');

			foreach ($oldFiles as $f)
			{
				$oldFile = JPATH_ROOT . '/uploads/infos/' . $f;

				if (file_exists($oldFile) && !is_dir($oldFile))
				{
					unlink($oldFile);
				}
			}

			$this->logo = "";

			foreach ($files['logo'] as $singleFile )
			{
				jimport('joomla.filesystem.file');

				// Check if the server found any error.
				$fileError = $singleFile['error'];
				$message = '';

				if ($fileError > 0 && $fileError != 4)
				{
					switch ($fileError)
					{
						case 1:
							$message = Text::_('File size exceeds allowed by the server');
							break;
						case 2:
							$message = Text::_('File size exceeds allowed by the html form');
							break;
						case 3:
							$message = Text::_('Partial upload error');
							break;
					}

					if ($message != '')
					{
						$app->enqueueMessage($message, 'warning');

						return false;
					}
				}
				elseif ($fileError == 4)
				{
					if (isset($array['logo']))
					{
						$this->logo = $array['logo'];
					}
				}
				else
				{

					// Replace any special characters in the filename
					jimport('joomla.filesystem.file');
                    $extension = File::getExt($singleFile['name']);
                    $okExtensionTypes = array('jpg','jpeg','png','gif','bmp');

                    if (!in_array($extension, $okExtensionTypes))
                    {
                        $app->enqueueMessage('This filetype is not allowed', 'warning');

                        return false;
                    }

                    $filename = File::stripExt($singleFile['name']);
					$filename = preg_replace("/[^A-Za-z0-9]/i", "-", $filename);
					$filename = $filename . '_' . time() . '.' . $extension;
					$uploadPath = JPATH_ROOT . '/uploads/infos/' . $filename;
					$fileTemp = $singleFile['tmp_name'];

					if (!File::exists($uploadPath))
					{
						if (!File::upload($fileTemp, $uploadPath))
						{
							$app->enqueueMessage('Error moving file', 'warning');

							return false;
						}
					}

					$this->logo .= (!empty($this->logo)) ? "," : "";
					$this->logo .= $filename;
				}
			}
		}
		else
		{
			$this->logo .= $array['logo_hidden'];
		}
		// Support multi file field: tour_video
		$app = Factory::getApplication();
		$files = $app->input->files->get('jform', array(), 'raw');
		$array = $app->input->get('jform', array(), 'ARRAY');
		if (empty($files['tour_video'][0])){
			$temp = $files;
			$files = array();
			$files['tour_video'][] = $temp['tour_video'];
		}

		if ($files['tour_video'][0]['size'] > 0)
		{
			// Deleting existing files
			$oldFiles = InformationsHelper::getFiles($this->id, $this->_tbl, 'tour_video');

			foreach ($oldFiles as $f)
			{
				$oldFile = JPATH_ROOT . '/uploads/infos/' . $f;

				if (file_exists($oldFile) && !is_dir($oldFile))
				{
					unlink($oldFile);
				}
			}

			$this->tour_video = "";

			foreach ($files['tour_video'] as $singleFile )
			{
				jimport('joomla.filesystem.file');

				// Check if the server found any error.
				$fileError = $singleFile['error'];
				$message = '';

				if ($fileError > 0 && $fileError != 4)
				{
					switch ($fileError)
					{
						case 1:
							$message = Text::_('File size exceeds allowed by the server');
							break;
						case 2:
							$message = Text::_('File size exceeds allowed by the html form');
							break;
						case 3:
							$message = Text::_('Partial upload error');
							break;
					}

					if ($message != '')
					{
						$app->enqueueMessage($message, 'warning');

						return false;
					}
				}
				elseif ($fileError == 4)
				{
					if (isset($array['tour_video']))
					{
						$this->tour_video = $array['tour_video'];
					}
				}
				else
				{

					// Replace any special characters in the filename
					jimport('joomla.filesystem.file');
                    $extension = File::getExt($singleFile['name']);
                    $okExtensionTypes = array('mp4');

                    if (!in_array($extension, $okExtensionTypes))
                    {
                        $app->enqueueMessage('This filetype is not allowed', 'warning');

                        return false;
                    }

					$filename = File::stripExt($singleFile['name']);
					$filename = preg_replace("/[^A-Za-z0-9]/i", "-", $filename);
					$filename = $filename . '_' . time() . '.' . $extension;
					$uploadPath = JPATH_ROOT . '/uploads/infos/' . $filename;
					$fileTemp = $singleFile['tmp_name'];

					if (!File::exists($uploadPath))
					{
						if (!File::upload($fileTemp, $uploadPath))
						{
							$app->enqueueMessage('Error moving file', 'warning');

							return false;
						}
					}

					$this->tour_video .= (!empty($this->tour_video)) ? "," : "";
					$this->tour_video .= $filename;
				}
			}
		}
		else
		{
			$this->tour_video .= $array['tour_video_hidden'];
		}

		return parent::check();
	}

	/**
	 * Define a namespaced asset name for inclusion in the #__assets table
	 *
	 * @return string The asset name
	 *
	 * @see Table::_getAssetName
	 */
	protected function _getAssetName()
	{
		$k = $this->_tbl_key;

		return $this->typeAlias . '.' . (int) $this->$k;
	}

	/**
	 * Returns the parent asset's id. If you have a tree structure, retrieve the parent's id using the external key field
	 *
	 * @param   Table   $table  Table name
	 * @param   integer  $id     Id
	 *
	 * @see Table::_getAssetParentId
	 *
	 * @return mixed The id on success, false on failure.
	 */
	protected function _getAssetParentId($table = null, $id = null)
	{
		// We will retrieve the parent-asset from the Asset-table
		$assetParent = Table::getInstance('Asset');

		// Default: if no asset-parent can be found we take the global asset
		$assetParentId = $assetParent->getRootId();

		// The item has the component as asset-parent
		$assetParent->loadByName('com_informations');

		// Return the found asset-parent-id
		if ($assetParent->id)
		{
			$assetParentId = $assetParent->id;
		}

		return $assetParentId;
	}

	//XXX_CUSTOM_TABLE_FUNCTION

	
    /**
     * Delete a record by id
     *
     * @param   mixed  $pk  Primary key value to delete. Optional
     *
     * @return bool
     */
    public function delete($pk = null)
    {
        $this->load($pk);
        $result = parent::delete($pk);
        
		if ($result)
		{
			jimport('joomla.filesystem.file');

			$checkImageVariableType = gettype($this->logo);

			switch ($checkImageVariableType)
			{
			case 'string':
				File::delete(JPATH_ROOT . '/uploads/infos/' . $this->logo);
			break;
			default:
			foreach ($this->logo as $logoFile)
			{
				File::delete(JPATH_ROOT . '/uploads/infos/' . $logoFile);
			}
			}
			jimport('joomla.filesystem.file');

			$checkImageVariableType = gettype($this->tour_video);

			switch ($checkImageVariableType)
			{
			case 'string':
				File::delete(JPATH_ROOT . '/uploads/infos/' . $this->tour_video);
			break;
			default:
			foreach ($this->tour_video as $tour_videoFile)
			{
				File::delete(JPATH_ROOT . '/uploads/infos/' . $tour_videoFile);
			}
			}
		}

        return $result;
    }
}
