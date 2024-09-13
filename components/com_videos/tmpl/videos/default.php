<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Videos
 * @author     Nguyen Dinh <vb.dinhxuannguyen@gmail.com>
 * @copyright  2024 Nguyen Dinh
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

use \Joomla\CMS\HTML\HTMLHelper;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Uri\Uri;
use \Joomla\CMS\Router\Route;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Layout\LayoutHelper;
use \Joomla\CMS\Session\Session;
use \Joomla\CMS\User\UserFactoryInterface;

HTMLHelper::_('bootstrap.tooltip');
HTMLHelper::_('behavior.multiselect');
HTMLHelper::_('formbehavior.chosen', 'select');

$user       = Factory::getApplication()->getIdentity();
$userId     = $user->get('id');
$listOrder  = $this->state->get('list.ordering');
$listDirn   = $this->state->get('list.direction');
$canCreate  = $user->authorise('core.create', 'com_videos') && file_exists(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'forms' . DIRECTORY_SEPARATOR . 'detailform.xml');
$canEdit    = $user->authorise('core.edit', 'com_videos') && file_exists(JPATH_COMPONENT .  DIRECTORY_SEPARATOR . 'forms' . DIRECTORY_SEPARATOR . 'detailform.xml');
$canCheckin = $user->authorise('core.manage', 'com_videos');
$canChange  = $user->authorise('core.edit.state', 'com_videos');
$canDelete  = $user->authorise('core.delete', 'com_videos');

// Import CSS
$wa = $this->document->getWebAssetManager();
$wa->useStyle('com_videos.list');
?>

    <div class="jl-container video-list">
        <div class="g-grid">
            <div class="blog-title"><h2 class="jl-margin-top">Videos</h2></div>

            <div id="jlfiltergallery-1072-particle" class="g-content g-particle news-items">
                <div class="js-jlfiltergallery-1072 jl-child-width-1-1 jl-child-width-1-2@s jl-child-width-1-3@m jl-grid jl-flex-top jl-flex-wrap-top"
                     jl-grid="masonry: pack;" jl-lightbox="toggle: a[data-type]"
                     jl-scrollspy="target: [jl-scrollspy-class]; cls: jl-animation-slide-bottom-small; delay: false;">
                    <?php
                        foreach ($this->items as $i => $item) :
                            $this->item = &$item;
                            $video_img  = empty($item->image) ? 'no_image.jpg' : 'videos/'. $item->image;
                        ?>
                            <div class="jl-first-column" style="transform: translate(0px, 0px);">
                                <a class="tm-item youtube-id jl-inline-clip jl-transition-toggle jl-link-toggle jl-scrollspy-inview"
                                   href="javascript::void(0);" title="<?php echo $item->title; ?>" aria-label=""
                                   jl-scrollspy-class="" style="display: flex; align-items: center; text-align: center;" data-id="<?php echo $item->youtube_id;?>">
                                    <img src="<?php echo URI::root();?>/uploads/<?php echo $video_img;?>" width="1024" height="892"
                                         class="tm-image jl-transition-scale-up jl-transition-opaque youtube-id" alt="" loading="lazy" data-id="<?php echo $item->youtube_id;?>">
                                    <div class="jl-position-bottom-center jl-position-medium jl-tile-default jl-transition-slide-bottom-small">
                                        <div class="jl-overlay jl-margin-remove-first-child">
                                            <h3 class="tm-title jl-margin-remove-bottom jl-h5 jl-margin-top"><?php echo $item->title; ?></h3>
                                        </div>
                                    </div>
                                    <span class="icon-youtube-play"><i class="far fa-play-circle"></i></span>
                                </a>
                            </div>
                    <?php
                        endforeach;
                    ?>
                </div>
            </div>
            <?php if (($this->params->def('show_pagination', 1) == 1 || ($this->params->get('show_pagination') == 2)) && ($this->pagination->pagesTotal > 1)) : ?>
            <div id="" style="width: 100%; clear:both; padding: 10px; text-align: center;">
                <div class="com-content-category-blog__pagination jl-clearfix">
                    <?php echo $this->pagination->getPagesLinks(); ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>
    </div>

