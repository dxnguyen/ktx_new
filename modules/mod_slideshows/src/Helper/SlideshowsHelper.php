<?php
/**
 * @version     1.0.0
 * @package     mod_slideshows_1.0.0_j4x
 * @copyright   Copyright (C) 2024. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      nguyen dinh <vb.dinhxuannguyen@gmail.com> - https://componentgenerator.com
 */

namespace Joomla\Module\Slideshows\Site\Helper;

// No direct access
use Joomla\CMS\Factory;

defined( '_JEXEC' ) or die( 'Restricted access' );

class SlideshowsHelper
{
    public static function getList() {
        $db    = Factory::getDbo();
        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__slideshows', 's'))
            ->where($db->quoteName('s.state') . ' = 1')
            ->order($db->quoteName('s.ordering'));
        $db->setQuery($query);

        return $db->loadObjectList();
    }
}
