<?php
/**
 * @version     1.0.0
 * @package     mod_menubottom_1.0.0_j4x
 * @copyright   Copyright (C) 2024. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      nguyen dinh <vb.dinhxuannguyen@gmail.com> - https://componentgenerator.com
 */

namespace Joomla\Module\Menubottom\Site\Helper;

// No direct access
use Joomla\CMS\Factory;

defined( '_JEXEC' ) or die( 'Restricted access' );

class MenubottomHelper
{
    public static function getListMenuAbout() {
        $app         = Factory::getApplication();
        $menuManager = $app->getMenu();
        $menuType    = 'menu-about';
        $menuItems   = $menuManager->getItems('menutype', $menuType);

        return $menuItems;
        /*$db    = Factory::getDbo();
        $query = $db->getQuery(true)
            ->select('m.title')
            ->select('m.link')
            ->select('m.browserNav')
            ->from($db->quoteName('#__menu', 'm'))
            ->where($db->quoteName('m.published') . ' = 1')
            ->where($db->quoteName('m.menutype') . ' = "menu-about"');
            //->order($db->quoteName('m.ordering'));
        $db->setQuery($query);

        return $db->loadObjectList();*/
    }

    public static function getListMenuDepartment() {
        $app         = Factory::getApplication();
        $menuManager = $app->getMenu();
        $menuType    = 'menu-department';
        $menuItems   = $menuManager->getItems('menutype', $menuType);

        return $menuItems;


        /*$db    = Factory::getDbo();
        $query = $db->getQuery(true)
            ->select('m.title')
            ->select('m.link')
            ->from($db->quoteName('#__menu', 'm'))
            ->where($db->quoteName('m.published') . ' = 1')
            ->where($db->quoteName('m.menutype') . ' = "menu-department"');
        $db->setQuery($query);

        return $db->loadObjectList();*/
    }

    public static function getListMenuBql() {
        $app         = Factory::getApplication();
        $menuManager = $app->getMenu();
        $menuType    = 'menu-bqlcn';
        $menuItems   = $menuManager->getItems('menutype', $menuType);

        return $menuItems;

        /*$db    = Factory::getDbo();
        $query = $db->getQuery(true)
            ->select('m.title')
            ->select('m.link')
            ->from($db->quoteName('#__menu', 'm'))
            ->where($db->quoteName('m.published') . ' = 1')
            ->where($db->quoteName('m.menutype') . ' = "menu-bqlcn"');
        $db->setQuery($query);

        return $db->loadObjectList();*/
    }

}
