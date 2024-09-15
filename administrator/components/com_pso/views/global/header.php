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

/** @var MjController $this */
/** @var array $params */
/** @var string $controllerName */
/** @var string $viewName */

MJToolbarHelper::title(MJText::_('COM_PSO__PSO'), 'config');

$doc = $this->joomlaWrapper->getDocument();

// sboxmodal is used for update popup and mobile previews
$doc->addStyleSheet('../media/com_pso/css/sboxmodal.css?v=1.4.2');
$doc->addScript('../media/com_pso/js/sboxmodal.js?v=1.4.2');

$doc->addScript('../media/com_pso/js/jquery.are-you-sure.js?v=1.4.2');
$doc->addScript('../media/com_pso/js/mj.are-you-sure.js?v=1.4.2');
