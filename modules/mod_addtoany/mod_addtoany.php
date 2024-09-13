<?php
/**
 * AddToAny Module Entry Point
 * 
 * @package    addtoany
 * @subpackage Modules
 * @copyright (C) AddToAny
 * @license GNU/GPLv3
 */
 
defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;

require_once dirname(__FILE__) . '/helper.php';
 
$addtoany = modAddToAnyHelper::getAddToAny($params);

$kit_size = $addtoany['kit_size'];
$services_html = $addtoany['services_html'];
$follow_classname = $addtoany['follow_classname'];
$icon_color_attr = $addtoany['icon_color_attr'];
$url_attr = $addtoany['url_attr'];
$title_attr = $addtoany['title_attr'];

require ModuleHelper::getLayoutPath('mod_addtoany');