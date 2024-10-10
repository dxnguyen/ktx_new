<?php
defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;

$module = ModuleHelper::getModule('mod_id');
$dxn = new Dxn();

    $dxn->showModule('slideshow');
    $dxn->showModule('stastics');
    $dxn->showModule('tourktx');
    $dxn->showModule('news');
    $dxn->showModule('experience');
    $dxn->showModule('videos');
    $dxn->showModule('eventcoming');
    $dxn->showModule('comments');
    $dxn->showModule('partner');
    $dxn->showModule('campus');

