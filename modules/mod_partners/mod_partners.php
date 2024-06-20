<?php
/**
 * @version     1.0.0
 * @package     mod_partners_1.0.0_j4x
 * @copyright   Copyright (C) 2024. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      nguyen dinh <vb.dinhxuannguyen@gmail.com> - https://componentgenerator.com
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\Module\Partners\Site\Helper\PartnersHelper;
use Joomla\CMS\Factory;

$document = Factory::getDocument();
$document->addStyleSheet('modules/mod_partners/css/default.css');

$list = PartnersHelper:: getList();
require ModuleHelper::getLayoutPath('mod_partners');
