<?php
/**
 * @version     1.0.0
 * @package     mod_partners_1.0.0_j4x
 * @copyright   Copyright (C) 2024. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      nguyen dinh <vb.dinhxuannguyen@gmail.com> - https://componentgenerator.com
 */

//No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Uri\Uri;

?>

<section id="g-partner" class="jl-section-xsmall">
    <div class="jl-container">

        <div class="g-grid">

            <div class="g-block size-100">
                <div class="g-content g-particle">
                    <h2 class="tm-title jl-margin-remove-bottom jl-text-bold jl-h2 title-h2">Đối tác - <span
                                class="title-red"> Khách hàng</span></h2>
                </div>
                <div id="jlcarousel-9721-particle" class="g-content g-particle">
                    <div id="jlcarousel-9721" class="jlcarousel-9721 client-boxed" jl-slider="animation: {fade, slide}; autoplay: true; autoplay-interval: 5000">
                        <div class="jl-position-relative jl-visible-toggle">
                            <ul class="jl-slider-items jl-grid">
                                <?php if ($list) : ?>
                                    <?php foreach ($list as $item) : ?>
                                        <li class="tm-item jl-width-1-2 jl-width-1-3@s jl-width-1-5@m">
                                        <div class="jl-cover-container">
                                            <a href="<?php echo $item->image_link;?>" target="_blank"><img
                                                        src="<?php echo URI::root()?>uploads/partners/<?php echo $item->image;?>"
                                                        width="500" height="333" class="tm-image jl-transition-opaque"
                                                        alt=""
                                                        loading="lazy"></a>
                                        </div>
                                    </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>

                            <div class="jl-visible@s jl-hidden-hover">
                                <a class="tm-slidenav jl-icon jl-position-medium jl-position-center-left" href="#"
                                   jl-slidenav-previous jl-slider-item="previous"></a>
                                <a class="tm-slidenav jl-icon jl-position-medium jl-position-center-right" href="#"
                                   jl-slidenav-next jl-slider-item="next"></a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
