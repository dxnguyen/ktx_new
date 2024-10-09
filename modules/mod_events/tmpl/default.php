<?php
/**
 * @version     1.0.0
 * @package     mod_events_1.0.0_j4x
 * @copyright   Copyright (C) 2024. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      nguyen dinh <vb.dinhxuannguyen@gmail.com> - https://componentgenerator.com
 */

use Joomla\CMS\Uri\Uri;

//No direct access
defined('_JEXEC') or die('Restricted access');
?>
<section id="g-event-comming" class="jl-section-xsmall">
    <div class="jl-container">
        <div class="g-grid">
            <div class="g-block size-60">
                <div id="jlheading-3362-particle" class="g-content g-particle news-title-box">
                    <div class="jlheading-3361 tm-secondary-font">
                        <h3 class="news-title tm-title jl-margin-remove-bottom jl-text-bold jl-h2">Sự kiện <span
                                    class="title-red"> sắp diễn ra</span></h3>
                    </div>
                </div>
            </div>
            <div class="g-block size-40">
                <div class="spacer"></div>
            </div>
        </div>
        <div class="g-grid">
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
                                                <div class="image-zoom image-cover" style="padding-top:63%;">
                                                    <img loading="lazy" decoding="async" width="1020" height="680" data-src="<?php echo $list[0]->image;?>"
                                                         src="<?php echo URI::root();?>uploads/<?php echo $list[0]->image;?>"
                                                         class="attachment-large size-large imgThumbnail" alt=""
                                                         ></div>
                                            </div>
                                            <div class="box-text text-left">
                                                <div class="box-text-inner blog-post-inner">
                                                    <h5 class="post-title is-large post-title-main "><?php echo $list[0]->title;?></h5>
                                                    <div class="is-divider"></div>
                                                    <div class="post-meta post-meta-primary">Thời gian diễn ra: <?php echo date('d/m/Y H:i', strtotime($list[0]->start_date));?></div>
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
                                <?php if ($list) :  ?>
                                    <?php foreach($list as $key=>$item) : ?>
                                        <?php if ($key == 0) continue;  ?>
                                        <div class="col post-item" data-animate="fadeInRight" data-animated="true">
                                            <div class="col-inner">
                                                <div class="box box-vertical box-text-bottom box-blog-post has-hover col-inner-box">
                                                    <div class="box-image" style="width:50%;">
                                                        <div class="image-zoom image-cover" style="padding-top:51%;">
                                                            <img loading="lazy" decoding="async" width="300" height="169" data-src="<?php echo $item->image;?>"
                                                                 src="<?php echo URI::root();?>uploads/<?php echo $item->image;?>"
                                                                 class="attachment-medium size-medium imgThumbnail" alt="<?php echo $item->title;?>">
                                                        </div>
                                                    </div>
                                                    <div class="box-text text-left">
                                                        <div class="box-text-inner blog-post-inner">
                                                            <h5 class="post-title is-large"><?php echo $item->title;?></h5>
                                                            <div class="is-divider"></div>
                                                            <div class="post-meta">Thời gian diễn ra: <?php echo date('d/m/Y H:i', strtotime($item->start_date));?></div>
                                                            <?php if (!empty($item->end_date)) : ?>
                                                            <div class="post-meta">Thời gian kết thúc: <?php echo date('d/m/Y H:i', strtotime($item->end_date));?></div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach;?>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Popup image event -->
    <div id="popupEvent" class="popup-event">
        <span id="closeEvent">&times;</span>
        <img id="fullsizeEvent" class="popup-event-content" src="<?php echo URI::root();?>uploads/<?php echo $list[0]->image;?>" alt="<?php echo $list[0]->title;?>">
    </div>

    <style>
        /* styles.css */
        .popup-event {
            display: none; /* Ẩn popup mặc định */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.8);
            z-index: 9999;
        }

        .popup-event-content {
            margin: 50px auto;
            display: block;
            width: 80%;
            max-width: 1024px;
        }

        #closeEvent {
            position: absolute;
            top: 10px;
            right: 25px;
            color: #fff;
            font-size: 35px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>

    <script>
        $(document).ready(function() {
            $('.imgThumbnail').click(function() {
               var img_name = $(this).attr('data-src');
               var imgSrc = "<?php echo URI::root();?>uploads/" + img_name;
               $('#fullsizeEvent').attr('src', imgSrc);
               $('#popupEvent').fadeIn();
            });

            $('#closeEvent').click(function() {
                $('#popupEvent').fadeOut();
            });
        });
    </script>
</section>