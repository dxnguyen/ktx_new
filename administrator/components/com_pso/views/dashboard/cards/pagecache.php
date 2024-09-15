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
/** @var MjSettingsModel $settings */

$pattern = MJText::_('COM_PSO__FILES_STAT');

$clear_pagecache_stats = sprintf($pattern,
    '<span id="mj_cachesize_page_size" class="loading"></span>',
    '<span id="mj_cachesize_page_files" class="loading"></span>');
$clear_pagecache_buttons =
    '<input type="button" id="do_clear_pagecache_expired" value="' . MJText::_('COM_PSO__CLEAR_EXPIRED') . '" class="btn btn-info"/>'
    . '<input type="button" id="do_clear_pagecache_all" value="' . MJText::_('COM_PSO__CLEAR_ALL') . '" class="btn btn-info ms-3"/>';

return array(
    //'link' => MjUI::settingsbtn($settings->get('pagecache_enabled') ? 'index.php?option=com_pso&controller=pagecache' : false),
    MjUI::prepare('onoff', $settings, 'pagecache_enabled', 'COM_PSO__PAGECACHE_ENABLED'),
    array(
        'label' => MjUI::label('', 'COM_PSO__PAGECACHE', 'COM_PSO__PAGECACHE_DESC'),
        'input' => '<div class="btn-toolbar justify-content-end">' .
            '<div class="flex-fill me-3">' . MjUI::text($clear_pagecache_stats) . '</div>' .
            $clear_pagecache_buttons .
            '</div>'
    ),
);
