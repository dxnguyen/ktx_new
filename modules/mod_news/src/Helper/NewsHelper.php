<?php
/**
 * @version     1.0.0
 * @package     mod_news_1.0.0_j4x
 * @copyright   Copyright (C) 2024. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      nguyen dinh <vb.dinhxuannguyen@gmail.com> - https://componentgenerator.com
 */

namespace Joomla\Module\News\Site\Helper;

// No direct access

use Joomla\CMS\Factory;

defined( '_JEXEC' ) or die( 'Restricted access' );

class NewsHelper
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
        $catids = $params->get('catids');

        if ($catids) {
           $results = array();
           foreach ($catids as $item) {
                $itemList = self::getItems($item);
                $results[$item] = $itemList;
           }
        }

        return $results;
    }

    public static function getItems($catid) {
        $db    = Factory::getDbo();
        $query = $db->getQuery(true)
            ->select('c.id')
            ->select('c.title')
            ->select('c.images')
            ->select('c.alias')
            ->select('c.language')
            ->select('cat.title AS cat_title')
            ->select('cat.alias AS cat_alias')
            ->from($db->quoteName('#__content', 'c'))
            ->leftJoin($db->quoteName('#__categories') . ' AS cat ON cat.id = c.catid')
            ->where($db->quoteName('c.state') . ' = 1')
            ->where($db->quoteName('c.catid'). '=' . $db->quote($catid))
            ->order($db->quoteName('c.ordering'))
            ->setLimit(6);
        $db->setQuery($query);

        return $db->loadObjectList();
    }
}
