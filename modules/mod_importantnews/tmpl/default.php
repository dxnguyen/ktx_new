<?php
/**
 * @version     1.0.0
 * @package     mod_importantnews_1.0.0_j4x
 * @copyright   Copyright (C) 2024. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      nguyen dinh <vb.dinhxuannguyen@gmail.com> - https://componentgenerator.com
 */

//No direct access
defined('_JEXEC') or die('Restricted access');

    use Joomla\CMS\Router\Route;
    use Joomla\Component\Content\Administrator\Extension\ContentComponent;
    use Joomla\Component\Content\Site\Helper\RouteHelper;
    use Joomla\CMS\Factory;

    $app = Factory::getApplication();
    $menu = $app->getMenu();
?>
<div class="sidebar-right hidden-phone">
    <div class="modBox featureNewsMod">
        <h2>Tin nổi bật</h2>
        <ul class="titleLinks">
            <?php
                if ($list) :
                    foreach ($list as $value) :
                        $categoryLink = 'index.php?option=com_content&view=category&layout=blog&id='.$value->catid;
                        $itemMenu = $menu->getItems('link', $categoryLink);
                        $articleUrl = Route::_(ContentHelperRoute::getArticleRoute($value->id).'&Itemid='.$itemMenu[0]->id);
                        //$link = Route::_('index.php?option=com_content&view=article&id='.$value->id.'&Itemid=173');
                ?>
                        <li><a href="<?php echo htmlspecialchars($articleUrl, ENT_QUOTES, 'UTF-8'); ?>"><i class='far fa-hand-point-right'></i> <?php echo $value->title; ?></a> </li>
                <?php
                    endforeach;
                endif;
                ?>
        </ul>
    </div>
</div>
