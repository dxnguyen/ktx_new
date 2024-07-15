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
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Content\Administrator\Extension\ContentComponent;
use Joomla\Component\Content\Site\Helper\RouteHelper;

// Create shortcuts to some parameters.
$params  = $this->item->params;
$canEdit = $params->get('access-edit');
$user    = Factory::getUser();
$info    = $params->get('info_block_position', 0);
$htag    = $this->params->get('show_page_heading') ? 'h2' : 'h1';
$app     = Factory::getApplication();
// Check if associations are implemented. If they are, define the parameter.
$assocParam        = (Associations::isEnabled() && $params->get('show_associations'));
$currentDate       = Factory::getDate()->format('Y-m-d H:i:s');
$isNotPublishedYet = $this->item->publish_up > $currentDate;
$isExpired         = !is_null($this->item->publish_down) && $this->item->publish_down < $currentDate;
$lang  = JFactory::getLanguage()->getTag();
$dxn   = new Dxn();
$lists = $dxn->getRelateProducts($this->item->catid, $this->item->id, $this->item->language);
$itemid = $app->getMenu()->getActive()->id;
?>
<div class="jl-container com-content-article item-page<?php echo $this->pageclass_sfx; ?>" itemscope itemtype="https://schema.org/Article">
    <?php if ($params->get('show_title')) : ?>
    <h2 class="jl-margin-top"><?php echo $this->escape($this->item->title); ?></h2>
    <?php endif; ?>

    <?php $useDefList = $params->get('show_publish_date') || $params->get('show_category'); ?>
    <?php if ($useDefList) : ?>
        <div class="param-title jl-margin-bottom">
            <span style="font-style: italic; margin-right: 20px;"><i class="far fa-clock"></i> <?php echo date('d/m/Y', strtotime($this->item->publish_up));?></span>
            <span style="font-style: italic;"><i class="fas fa-tags"></i> <?php echo $this->item->category_title;?></span>
        </div>
    <?php endif; ?>

    <div itemprop="articleBody" class="com-content-article__body jl-margin-medium-bottom">
        <?php echo $this->item->text; ?>
    </div>

    <div class="relate-articles jl-margin-medium-bottom">
        <div class="blog-title jl-margin-small-bottom"><h2 class="jl-text-uppercase">Bài viết cùng thể loại</h2></div>
        <div class="js-jlfiltergallery-1072 jl-child-width-1-1 jl-child-width-1-2@s jl-child-width-1-3@m jl-grid jl-flex-top jl-flex-wrap-top" jl-grid="masonry: pack;" jl-lightbox="toggle: a[data-type]" jl-scrollspy="target: [jl-scrollspy-class]; cls: jl-animation-slide-bottom-small; delay: false;">
            <?php foreach ($lists as $item) : ?>
                <?php
                $link = Route::_('index.php?option=com_content&view=article&catid='.$item->catid.'&Itemid='.$itemid.'&id='.$item->id);
                $imgs = json_decode($item->images);
                ?>

                <div data-tag="hoat-dong" class="jl-first-column" style="transform: translate(0px, 0px);">
                    <a class="tm-item jl-inline-clip jl-transition-toggle jl-link-toggle jl-scrollspy-inview" href="<?php echo $link;?>" title="<?php echo $item->title;?>" aria-label="Improve Startup" jl-scrollspy-class="" style="">
                        <img src="<?php echo $imgs->image_intro;?>" width="1024" height="892" class="tm-image jl-transition-scale-up jl-transition-opaque" alt="" loading="lazy">
                        <div class="jl-position-bottom-center jl-position-medium jl-tile-default jl-transition-slide-bottom-small">
                            <div class="jl-overlay jl-margin-remove-first-child">
                                <h3 class="tm-title jl-margin-remove-bottom jl-h5 jl-margin-top"><?php echo $item->title;?></h3>
                            </div>
                        </div>
                    </a>
                </div>

            <?php endforeach; ?>

        </div>
    </div>

</div>
