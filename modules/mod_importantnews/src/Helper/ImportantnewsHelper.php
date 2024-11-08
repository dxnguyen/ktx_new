<?php
/**
 * @version     1.0.0
 * @package     mod_importantnews_1.0.0_j4x
 * @copyright   Copyright (C) 2024. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      nguyen dinh <vb.dinhxuannguyen@gmail.com> - https://componentgenerator.com
 */

namespace Joomla\Module\Importantnews\Site\Helper;

// No direct access
use Joomla\CMS\Factory;

defined( '_JEXEC' ) or die( 'Restricted access' );

class ImportantnewsHelper
{
    /**
     * Get list articles by category in homepage
     *
     * @param   \Joomla\Registry\Registry  &$params  The module options.
     *
     * @return  array
     *
     * @since   1.5
     */
    public static function getList(&$params) {
        $catid = $params->get('catids');
        $db    = Factory::getDbo();
        $query = $db->getQuery(true)
            ->select('c.id')
            ->select('c.catid')
            ->select('c.title')
            ->select('c.images')
            ->select('c.alias')
            ->select('c.language')
            ->from($db->quoteName('#__content', 'c'))
            ->where($db->quoteName('c.state') . ' = 1')
            ->where($db->quoteName('c.catid'). '=' . $db->quote($catid))
            ->order($db->quoteName('c.created'). ' DESC')
            ->setLimit(6);
        $db->setQuery($query);

        return $db->loadObjectList();
    }



}
