<?php
/**
 * Page Speed Optimizer extension
 * https://www.mobilejoomla.com/
 *
 * @version    1.4.2
 * @license    GNU/GPL v2 - http://www.gnu.org/licenses/gpl-2.0.html
 * @copyright  (C) 2022-2024 Denis Ryabov
 * @date       June 2024
 */
defined('_JEXEC') or die('Restricted access');

abstract class MjModel
{
    /** @var MjJoomlaWrapper */
    public $joomlaWrapper;

    /**
     * @param MjJoomlaWrapper $joomlaWrapper
     */
    public function __construct($joomlaWrapper)
    {
        $this->joomlaWrapper = $joomlaWrapper;
    }

    /**
     * @param array $data
     * @return bool
     */
    abstract public function bind($data);

    /**
     * @return bool
     */
    abstract public function save();
}