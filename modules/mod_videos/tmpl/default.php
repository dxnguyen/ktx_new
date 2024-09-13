<?php
/**
 * @version     1.0.0
 * @package     mod_videos_1.0.0_j4x
 * @copyright   Copyright (C) 2024. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      nguyen dinh <vb.dinhxuannguyen@gmail.com> - 
 */

//No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Helper\ContentHelper;
use Joomla\CMS\Router\Route;
use Joomla\Component\Content\Site\Helper\RouteHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Factory;

$app  = Factory::getApplication();
$menu = $app->getMenu();
$featureItem   = $menu->getItems('link', 'index.php?option=com_content&view=category&layout=blog&id='.$list[0]->catid);
$featureImage  = json_decode($list[0]->images);
$featureArticleLink = Route::_(RouteHelper::getArticleRoute($list[0]->id).'&Itemid='.$featureItem[0]->id);

?>

<section id="g-video" class="jl-section-xsmall">
    <div class="jl-container">
        <div class="g-grid">
            <div class="g-block size-50 has-hover">
                <div class="tieu-diem">
                    <div class="g-block size-100">
                        <div id="jlheading-3362-particle" class="g-content g-particle news-title-box">
                            <div class="jlheading-3361 tm-secondary-font">
                                <h3 class="news-title tm-title jl-margin-remove-bottom jl-text-bold jl-h2 jl-panel">
                                    Thư viện <span class="title-red">Video</span>
                                    <span class="viewAll">
                                        <a id="viewAllLink" style="font-size: 18px;" href="<?php echo URI::root().'videos';?>" title="Xem tất cả"><i class='fas fa-external-link-alt'></i></a>
                                    </span>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="g-video-items-box">
                    <div class="g-block size-100 nopaddingtop nopaddingbottom">
                        <div class="row" id="row-876782046">
                            <div id="col-152373325" class="col pb-0 small-12 large-12">
                                <style>
                                    #col-152373325 > .col-inner {
                                        padding: 27px 0px 0px 0px;
                                    }

                                    @media (min-width: 550px) {
                                        #col-152373325 > .col-inner {
                                            padding: 20px 0px 0px 0px;
                                        }
                                    }
                                </style>
                            </div>
                            <?php if ($videos) : ?>
                            <div id="col-1979035021" class="col pb-0 medium-6 small-12 large-6">
                                <div class="col-inner">
                                    <div class="row large-columns-1 medium-columns-1 small-columns-1">
                                        <div class="col post-item items-box" data-animate="fadeInLeft" data-animated="true">
                                            <div class="col-inner">
                                                <div class="box box-normal box-text-bottom box-blog-post has-hover">
                                                    <div class="box-image">
                                                        <div class="image-zoom image-cover" style="">
                                                            <img id="open-popup" loading="lazy" decoding="async" width="1020"
                                                                 height="680" src="<?php echo URI::root();?>/uploads/videos/<?php echo $videos[0]->image;?>"
                                                                 class="attachment-large size-large wp-post-image"
                                                                 alt=""
                                                                 sizes="(max-width: 1020px) 100vw, 1020px">
                                                        </div>
                                                    </div>
                                                    <div class="box-text text-left">
                                                        <div class="box-text-inner blog-post-inner">
                                                            <h5 class="post-title is-large post-title-main ">
                                                                <a class="youtube-id" data-id="<?php echo $videos[0]->youtube_id;?>" href="javascript:void(0);"><?php echo $videos[0]->title;?></a></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="col-1655344358" class="col pb-0 medium-6 small-12 large-6">
                                <div class="col-inner">
                                    <div class="row large-columns-1 medium-columns-1 small-columns- 1">
                                        <?php if ($videos) : ?>
                                            <?php foreach ($videos as $k=>$value) :
                                                    if ($k == 0) continue;
                                                ?>
                                                <div class="col post-item items-box" data-animate="fadeInRight" data-animated="true">
                                                    <div class="col-inner">
                                                        <div class="box box-vertical box-text-bottom box-blog-post has-hover col-inner-box">
                                                            <div class="box-text text-left">
                                                                <div class="box-text-inner blog-post-inner">
                                                                    <h5 class="post-title is-large "><a href="#" class="youtube-id" data-id="<?php echo $value->youtube_id;?>"><?php echo $value->title;?></a></h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php else : ?>
                                <?php echo '<h3 style="color: #cccccc;">Video đang được cập nhật.</h3>'; ?>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>

            <div class="g-block size-50">
                <div class="tieu-diem">
                    <div class="g-block size-100">
                        <div id="jlheading-3362-particle" class="g-content g-particle news-title-box">
                            <div class="jlheading-3361 tm-secondary-font">
                                <h3 class="news-title tm-title jl-margin-remove-bottom jl-text-bold jl-h2 jl-panel">
                                    Tiêu điểm <span class="title-red"> Nổi bật</span>

                                    <span class="viewAll">
                                        <a id="viewAllLink" style="font-size: 18px;" href="<?php echo Route::_('index.php?option=com_content&view=category&layout=blog&id='.$list[0]->catid);?>" title="Xem tất cả"><i class='fas fa-external-link-alt'></i></a>
                                    </span>
                                </h3>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="g-block size-100 nopaddingtop nopaddingbottom">
                        <div class="row" id="row-876782046">
                            <div id="col-152373325" class="col pb-0 small-12 large-12">
                                <style>
                                    #col-152373325 > .col-inner {
                                        padding: 27px 0px 0px 0px;
                                    }

                                    @media (min-width: 550px) {
                                        #col-152373325 > .col-inner {
                                            padding: 20px 0px 0px 0px;
                                        }
                                    }
                                </style>
                            </div>
                            <div id="col-1979035021" class="col pb-0 medium-6 small-12 large-6">
                                <div class="col-inner">
                                    <div class="row large-columns-1 medium-columns-1 small-columns-1">
                                        <div class="col post-item" data-animate="fadeInLeft" data-animated="true">
                                            <div class="col-inner">
                                                <div class="box box-normal box-text-bottom box-blog-post has-hover">
                                                    <div class="box-image">
                                                        <div class="image-zoom image-cover" style="">
                                                            <a href="<?php echo $featureArticleLink; ?>">
                                                                <img loading="lazy" decoding="async" width="1020"
                                                                     height="680" src="<?php echo $featureImage->image_intro; ?>"
                                                                     class="attachment-large size-large wp-post-image"
                                                                     alt=""
                                                                     sizes="(max-width: 1020px) 100vw, 1020px">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="box-text text-left">
                                                        <div class="box-text-inner blog-post-inner">
                                                            <h5 class="post-title is-large post-title-main ">
                                                                <a href="<?php echo $featureArticleLink; ?>"><?php echo $list[0]->title; ?>"</a>
                                                            </h5>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="col-1655344358" class="col pb-0 medium-6 small-12 large-6">
                                <div class="col-inner">
                                    <div class="row large-columns-1 medium-columns-1 small-columns-1">
                                        <?php foreach ($list as $key=>$item) :
                                            if ($key==0) continue;
                                            $itemObj = $menu->getItems('link', 'index.php?option=com_content&view=category&layout=blog&id='.$item->catid);
                                            $articleUrl = Route::_(RouteHelper::getArticleRoute($item->id).'&Itemid='.$itemObj[0]->id);
                                        ?>
                                        <div class="col post-item" data-animate="fadeInRight" data-animated="true">
                                            <div class="col-inner">
                                                <div class="box box-vertical box-text-bottom box-blog-post has-hover col-inner-box">
                                                    <div class="box-text text-left">
                                                        <div class="box-text-inner blog-post-inner">
                                                            <h5 class="post-title is-large "><a href="<?php echo $articleUrl; ?>"><?php echo $item->title; ?></a></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</section>