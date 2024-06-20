<?php
/**
 * @version     1.0.0
 * @package     mod_students_1.0.0_j4x
 * @copyright   Copyright (C) 2024. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      nguyen dinh <vb.dinhxuannguyen@gmail.com> - https://componentgenerator.com
 */

namespace Joomla\Module\Students\Site\Helper;

// No direct access
use Joomla\CMS\Factory;

defined( '_JEXEC' ) or die( 'Restricted access' );

class StudentsHelper
{
    public static function getList() {
        $db    = Factory::getDbo();
        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__comments', 'c'))
            ->where($db->quoteName('c.state') . ' = 1')
            ->order($db->quoteName('c.ordering'));
        $db->setQuery($query);

        return $db->loadObjectList();
    }
}
