<?php
/**
 * @version     1.0.0
 * @package     mod_news_1.0.0_j4x
 * @copyright   Copyright (C) 2024. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      nguyen dinh <vb.dinhxuannguyen@gmail.com> - https://componentgenerator.com
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\Module\News\Site\Helper\NewsHelper;
use Joomla\CMS\Factory;
/*
use Joomla\CMS\Router\RouterBase;
use Joomla\Module\News\Site\Router;

    $router = Router::ModNewsRouter();

    $app = Factory::getApplication();
    $app->getRouter()->attachBuildRule([$router, 'build']);
    $app->getRouter()->attachParseRule([$router, 'parse']);*/

$document = Factory::getDocument();
$document->addStyleSheet('modules/mod_news/css/default.css');

$list = NewsHelper::getList($params);
require ModuleHelper::getLayoutPath('mod_news');
