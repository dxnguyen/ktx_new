<?php
/**
 * @version     1.0.0
 * @package     mod_menutop_1.0.0_j4x
 * @copyright   Copyright (C) 2024. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      nguyen dinh <vb.dinhxuannguyen@gmail.com> - https://componentgenerator.com
 */

namespace Joomla\Module\Menutop\Site\Helper;

// No direct access
use Joomla\CMS\Factory;
use Joomla\CMS\Menu\MenuManager;

defined( '_JEXEC' ) or die( 'Restricted access' );

class MenutopHelper
{
	public static function getList() {
        $app         = Factory::getApplication();
        $menuManager = $app->getMenu();
        $menuType    = 'menu-top';
        $menuItems   = $menuManager->getItems('menutype', $menuType);

        return $menuItems;
        /*$db    = Factory::getDbo();
        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__menu', 'm'))
            ->where($db->quoteName('m.menutype') . ' = "menu-top"')
            ->where($db->quoteName('m.published'). '=1')
            ->order($db->quoteName('m.id'));
        $db->setQuery($query);

        return $db->loadObjectList();*/
    }
}
