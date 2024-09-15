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

?>
<div id="mj">
    <?php if (isset($params['menu'])) : ?>
        <?php echo $params['menu']; ?>
    <?php endif; ?>
    <div id="mjmsgarea"></div>
    <div id="mjupdatearea"></div>
    <?php if (isset($params['banner'])) : ?>
        <?php echo $params['banner']; ?>
    <?php endif; ?>
    <?php echo $params['content']; ?>
</div>