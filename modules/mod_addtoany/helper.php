<?php
/**
 * Helper class for the AddToAny module
 * 
 * @package     addtoany
 * @subpackage  Modules
 * @copyright   (C) AddToAny
 * @license     GNU/GPLv3
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

class ModAddToAnyHelper
{
	/**
	 * Retrieves an AddToAny instance.
	 *
	 * @param  array  $params An associative array containing the module parameters.
	 *
	 * @access public
	 */
	public static function getAddToAny($params)
	{
		$doc = Factory::getDocument();
		
		// Add AddToAny CSS
		$doc->addStyleSheet(Uri::base() . 'plugins/content/addtoany/addtoany.css');
		
		// Add AddToAny JavaScript asynchronously
		$doc->addScript('https://static.addtoany.com/menu/page.js', array(), array(
			'type' => 'text/javascript',
			'defer' => true,
		));
		
		// AddToAny follow buttons?
		$follow_classname = $params->get('service_type', 'share') == 'follow' ? ' a2a_follow' : '';
		
		// Custom shared URL, title?
		$url_attr   = $follow_classname == '' && $params->get('url') ? ' data-a2a-url="' . urldecode($params->get('url')) . '"' : '';
		$title_attr = $follow_classname == '' && $params->get('title') ? ' data-a2a-title="' . htmlspecialchars($params->get('title'), ENT_QUOTES) . '"' : '';
		// Custom icon color?
		$icon_color_attr = $params->get('icon_color') ? ' data-a2a-icon-color="' . $params->get('icon_color') . '"' : '';
		
		$addtoany_instance = array(
			'kit_size'          => $params->get('icon_size', '32'),
			'follow_classname'  => $follow_classname,
			'services_html'     => $params->get('service_buttons_html_code') . PHP_EOL,
			'icon_color_attr'   => $icon_color_attr,
			'url_attr'          => $url_attr,
			'title_attr'        => $title_attr,
		);
		
		return $addtoany_instance;
	}
}