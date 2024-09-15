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

if (version_compare(JVERSION, '5.0', '>=')) {
    class_alias(Joomla\CMS\Plugin\CMSPlugin::class, 'MJPlugin');
} else {
    class_alias(JPlugin::class, 'MJPlugin');
}
