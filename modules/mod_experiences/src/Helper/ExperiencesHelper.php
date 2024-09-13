<?php
/**
 * @version     1.0.0
 * @package     mod_experiences_1.0.0_j4x
 * @copyright   Copyright (C) 2024. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      nguyen dinh <vb.dinhxuannguyen@gmail.com> - https://componentgenerator.com
 */

namespace Joomla\Module\Experiences\Site\Helper;

// No direct access
use Joomla\CMS\Factory;

defined( '_JEXEC' ) or die( 'Restricted access' );

class ExperiencesHelper
{
    public static function getInfos() {
        $db    = Factory::getDbo();
        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__informations'))
            ->where($db->quoteName('id') . ' = 1');
        $db->setQuery($query);

        return $db->loadObject();
    }
}
