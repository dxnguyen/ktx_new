<?php
/*
 * RESSIO Responsive Server Side Optimizer
 * https://github.com/ressio/
 *
 * @copyright   Copyright (C) 2013-2024 Kuneri Ltd. / Denis Ryabov, PageSpeed Ninja Team. All rights reserved.
 * @license     GNU General Public License version 2
 */

defined('RESSIO_PATH') || die();

class Ressio_Database_Joomla implements IRessio_Database, IRessio_DIAware
{
    /** @var JDatabaseDriver */
    protected $db;

    /**
     * Database object constructor
     * @param Ressio_DI $di
     * @throws ERessio_DBError
     */
    public function __construct($di)
    {
        if (isset($di->config->db->joomlaDriver)) {
            $this->db = $di->config->db->joomlaDriver;
        } elseif (defined('JVERSION')) {
            if (version_compare(JVERSION, '4.0', '>=')) {
                $this->db = Joomla\CMS\Factory::getContainer()->get('DatabaseDriver');
            } else {
                $this->db = JFactory::getDbo();
            }
        } else {
            throw new ERessio_DBError('No Joomla DB Driver found');
        }
    }

    /**
     * @param string $str
     * @return string
     */
    public function quote($str)
    {
        return $this->db->quote($str);
    }

    /**
     * @param string $sql
     * @return void
     */
    public function query($sql)
    {
        $this->db->setQuery($sql);
        $this->db->execute();
    }

    /**
     * @param string $sql
     * @return ?mixed
     */
    public function loadValue($sql)
    {
        $this->db->setQuery($sql);
        return $this->db->loadResult();
    }

    /**
     * @param string $sql
     * @return ?stdClass
     */
    public function loadRow($sql)
    {
        $this->db->setQuery($sql);
        return $this->db->loadObject();
    }

    /**
     * @param string $sql
     * @return stdClass[]|null
     */
    public function loadRows($sql)
    {
        $this->db->setQuery($sql);
        return $this->db->loadObjectList();
    }

    /**
     * @param string $sql
     * @return array
     */
    public function loadColumn($sql)
    {
        $this->db->setQuery($sql);
        return $this->db->loadColumn();
    }
}
