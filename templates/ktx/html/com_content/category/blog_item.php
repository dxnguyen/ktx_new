<?php

    /**
     * @package     Joomla.Site
     * @subpackage  com_content
     *
     * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
     * @license     GNU General Public License version 2 or later; see LICENSE.txt
     */

    defined('_JEXEC') or die;

    use Joomla\CMS\Factory;
    use Joomla\CMS\Language\Associations;
    use Joomla\CMS\Layout\LayoutHelper;
    use Joomla\CMS\Router\Route;
    use Joomla\CMS\Uri\Uri;
    use Joomla\Component\Content\Administrator\Extension\ContentComponent;
    use Joomla\Component\Content\Site\Helper\RouteHelper;

    // Create a shortcut for params.
    $params = $this->item->params;
    $canEdit = $this->item->params->get('access-edit');
    $info = $params->get('info_block_position', 0);

    // Check if associations are implemented. If they are, define the parameter.
    $assocParam = (Associations::isEnabled() && $params->get('show_associations'));
    $currentDate = Factory::getDate()->format('Y-m-d H:i:s');
?>


<?php
    $imgs = json_decode($this->item->images);
    $image_intro = !empty($imgs->image_intro) ? $imgs->image_intro : URI::root().'uploads/no_image.jpg';
    $menu = Factory::getApplication()->getMenu();
    $active = $menu->getActive();
    $itemId = $active->id;
    $link = new Uri(Route::_('index.php?option=com_content&view=article&catid=' . $this->item->catid . '&id=' . $this->item->id . '&Itemid=' . $itemId, false));
    //$link->setVar('return', base64_encode(RouteHelper::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language)));
?>

<div class="jl-first-column" style="transform: translate(0px, 0px);">
    <a class="tm-item jl-inline-clip jl-transition-toggle jl-link-toggle jl-scrollspy-inview"
       href="<?php echo $link; ?>" title="<?php echo $this->item->title; ?>" aria-label="Improve Startup"
       jl-scrollspy-class="" style="">
        <img src="<?php echo $image_intro; ?>" width="1024" height="892"
             class="tm-image jl-transition-scale-up jl-transition-opaque" alt="" loading="lazy">
        <div class="jl-position-bottom-center jl-position-medium jl-tile-default jl-transition-slide-bottom-small">
            <div class="jl-overlay jl-margin-remove-first-child">
                <h3 class="tm-title jl-margin-remove-bottom jl-h5 jl-margin-top"><?php echo $this->item->title; ?></h3>
            </div>
        </div>
    </a>
</div>

