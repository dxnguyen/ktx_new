<?php
/**
 * @version     1.0.0
 * @package     mod_videos_1.0.0_j4x
 * @copyright   Copyright (C) 2024. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      nguyen dinh <vb.dinhxuannguyen@gmail.com> - 
 */

namespace Joomla\Module\Videos\Site\Helper;

// No direct access
use Joomla\CMS\Factory;

defined( '_JEXEC' ) or die( 'Restricted access' );

class VideosHelper
{
    public static function getList(&$params) {
        $catid   = $params->get('right_cat_id');
        $results = self::getItems($catid);

        return $results;
    }

    public static function getItems($catid) {
        $db    = Factory::getDbo();
        $query = $db->getQuery(true)
            ->select('c.id')
            ->select('c.title')
            ->select('c.images')
            ->select('cat.title AS cat_title')
            ->select('cat.alias AS cat_alias')
            ->select('cat.id AS catid')
            ->from($db->quoteName('#__content', 'c'))
            ->leftJoin($db->quoteName('#__categories') . ' AS cat ON cat.id = c.catid')
            ->where($db->quoteName('c.state') . ' = 1')
            ->where($db->quoteName('c.catid'). '=' . $db->quote($catid))
            ->order($db->quoteName('c.ordering'))
            ->setLimit(7);
        $db->setQuery($query);

        return $db->loadObjectList();
    }

    public static function getVideos() {
        $db    = Factory::getDbo();
        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__videos', 'v'))
            ->where($db->quoteName('v.state') . ' = 1')
            ->order($db->quoteName('v.ordering'))
            ->setLimit(7);
        $db->setQuery($query);

        return $db->loadObjectList();
    }
}
