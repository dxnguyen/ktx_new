<?php
/**
 * @version     1.0.0
 * @package     mod_slideshows_1.0.0_j4x
 * @copyright   Copyright (C) 2024. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      nguyen dinh <vb.dinhxuannguyen@gmail.com> - https://componentgenerator.com
 */

//No direct access
defined('_JEXEC') or die('Restricted access');
?>

<section id="g-slideshow" class="nomarginall nopaddingall">
    <div class="g-grid">
        <div class="g-block size-100 jl-light">
            <div id="jlslideshow-7035-particle" class="g-content g-particle">
                <div class="jlslideshow-7035" jl-slideshow="minHeight: 450; maxHeight: 760; animation: {fade, slide}; autoplay: true; autoplay-interval: 5000">
                    <div class="jl-position-relative">
                        <ul class="jl-slideshow-items">
                            <?php if ($list) : ?>
                            <?php foreach($list as $item) : ?>
                            <li class="tm-item">
                                <a href="<?php echo $item->image_link;?>" target="_blank">
                                    <img src="<?php echo JURI::root();?>uploads/banners/<?php echo $item->image;?>" width="1920" height="760" class="tm-image slider-img" alt="" jl-cover loading="lazy">
                                </a>
                            </li>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                        <div class="jl-visible@s">
                            <a class="tm-slidenav jl-icon jl-position-medium jl-position-center-left" href="#"
                               jl-slidenav-previous jl-slideshow-item="previous"></a>
                            <a class="tm-slidenav jl-icon jl-position-medium jl-position-center-right" href="#"
                               jl-slidenav-next jl-slideshow-item="next"></a>
                        </div>
                        <div class="jl-position-bottom-center jl-position-medium jl-visible@s">
                            <ul class="tm-nav jl-slideshow-nav jl-dotnav jl-flex-center" jl-margin>
                                <li jl-slideshow-item="0">
                                    <a href="#">
                                        Digital Marketing Services
                                    </a>
                                </li>
                                <li jl-slideshow-item="1">
                                    <a href="#">
                                        Better design for your digital products.
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>