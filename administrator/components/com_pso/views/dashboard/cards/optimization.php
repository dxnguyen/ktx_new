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

$clear_images_stats = sprintf($pattern,
    '<span id="mj_cachesize_image_size" class="loading"></span>',
    '<span id="mj_cachesize_image_files" class="loading"></span>');
$clear_images_buttons =
    '<input type="button" id="do_clear_images" value="' . MJText::_('COM_PSO__CLEAR_ALL') . '" class="btn btn-info"/>';

$clear_imagesrescaled_stats = sprintf($pattern,
    '<span id="mj_cachesize_imagerescaled_size" class="loading"></span>',
    '<span id="mj_cachesize_imagerescaled_files" class="loading"></span>');
$clear_imagesrescaled_buttons =
    '<input type="button" id="do_clear_imagesrescaled" value="' . MJText::_('COM_PSO__CLEAR_ALL') . '" class="btn btn-info"/>';

$clear_imageslqip_stats = sprintf($pattern,
    '<span id="mj_cachesize_imagelqip_size" class="loading"></span>',
    '<span id="mj_cachesize_imagelqip_files" class="loading"></span>');
$clear_imageslqip_buttons =
    '<input type="button" id="do_clear_imageslqip" value="' . MJText::_('COM_PSO__CLEAR_ALL') . '" class="btn btn-info"/>';

$view_static_stats = sprintf($pattern,
    '<span id="mj_cachesize_static_size" class="loading"></span>',
    '<span id="mj_cachesize_static_files" class="loading"></span>');

$clear_cache_stats = sprintf($pattern,
    '<span id="mj_cachesize_ress_size" class="loading"></span>',
    '<span id="mj_cachesize_ress_files" class="loading"></span>');
$clear_cache_buttons =
    '<input type="button" id="do_clear_cache_expired" value="' . MJText::_('COM_PSO__CLEAR_EXPIRED') . '" class="btn btn-info"/>'
    . '<input type="button" id="do_clear_cache_all" value="' . MJText::_('COM_PSO__CLEAR_ALL') . '" class="btn btn-info ms-3"/>';

$clear_queue_stats = sprintf(MJText::_('COM_PSO__QUEUE_STAT'),
    '<span id="mj_cachesize_queue_size" class="loading"></span>',
    '<span id="mj_cachesize_queue_size2" class="loading"></span>',
    '<span id="mj_cachesize_queue_size3" class="loading"></span>'
);
$clear_queue_buttons =
    '<input type="button" id="do_clear_queue_all" value="' . MJText::_('COM_PSO__CLEAR_ALL') . '" class="btn btn-info"/>';

return array(
//    'class' => 'bg-success text-white',
//    'link' => MjUI::settingsbtn('index.php?option=com_pso&controller=settings&view=optimization'),
    MjUI::prepare('onoff', $settings, 'ress_optimize', 'COM_PSO__RESS_OPTIMIZE_ENABLED'),
    array(
        'label' => MjUI::label('', 'COM_PSO__PSI_SCORES', 'COM_PSO__PSI_SCORES_DESC'),
        'input' => '<div class="d-flex gap-2">' .
            '<div>' .
            '<label class="small fw-bolder">' . MJText::_('COM_PSO__PSI_DESKTOP') . '</label><br>' .
            '<div class="progress" style="width:7rem"><div id="psi_desktop" class="progress-bar progress-bar-striped progress-bar-animated w-100 fw-bolder"></div></div>' .
            '</div>' .
            '<div>' .
            '<label class="small fw-bolder">' . MJText::_('COM_PSO__PSI_MOBILE') . '</label><br>' .
            '<div class="progress" style="width:7rem"><div id="psi_mobile" class="progress-bar progress-bar-striped progress-bar-animated w-100 fw-bolder"></div></div>' .
            '</div>' .
            '</div>'
    ),
    array(
        'label' => MjUI::label('', 'COM_PSO__IMAGES_OPTIMIZED', 'COM_PSO__IMAGES_OPTIMIZED_DESC'),
        'input' => '<div class="btn-toolbar justify-content-end">' .
            '<div class="flex-fill me-3">' . MjUI::text($clear_images_stats) . '</div>' .
            $clear_images_buttons .
            '</div>'
    ),
    array(
        'label' => MjUI::label('', 'COM_PSO__IMAGES_RESCALED', 'COM_PSO__IMAGES_RESCALED_DESC'),
        'input' => '<div class="btn-toolbar justify-content-end">' .
            '<div class="flex-fill me-3">' . MjUI::text($clear_imagesrescaled_stats) . '</div>' .
            $clear_imagesrescaled_buttons .
            '</div>'
    ),
    array(
        'label' => MjUI::label('', 'COM_PSO__IMAGES_LQIP', 'COM_PSO__IMAGES_LQIP_DESC'),
        'input' => '<div class="btn-toolbar justify-content-end">' .
            '<div class="flex-fill me-3">' . MjUI::text($clear_imageslqip_stats) . '</div>' .
            $clear_imageslqip_buttons .
            '</div>'
    ),
    array(
        'label' => MjUI::label('', 'COM_PSO__STATIC', 'COM_PSO__STATIC_DESC'),
        'input' => MjUI::text($view_static_stats)
    ),
    array(
        'label' => MjUI::label('', 'COM_PSO__CACHE', 'COM_PSO__CACHE_DESC'),
        'input' => '<div class="btn-toolbar justify-content-end">' .
            '<div class="flex-fill me-3">' . MjUI::text($clear_cache_stats) . '</div>' .
            $clear_cache_buttons .
            '</div>'
    ),
    array(
        'label' => MjUI::label('', 'COM_PSO__QUEUE', 'COM_PSO__QUEUE_DESC'),
        'input' => '<div class="btn-toolbar justify-content-end">' .
            '<div class="flex-fill me-3">' . MjUI::text($clear_queue_stats) . '</div>' .
            $clear_queue_buttons .
            '</div>'
    ),
);
