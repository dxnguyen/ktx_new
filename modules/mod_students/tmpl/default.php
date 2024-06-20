<?php
/**
 * @version     1.0.0
 * @package     mod_students_1.0.0_j4x
 * @copyright   Copyright (C) 2024. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      nguyen dinh <vb.dinhxuannguyen@gmail.com> - https://componentgenerator.com
 */

//No direct access
defined('_JEXEC') or die('Restricted access');
?>
<section id="g-feature" class="jl-section">
    <div class="jl-container">
        <div class="g-grid">
            <div class="g-block size-55">
                <div id="jltestimonial2-9942-particle" class="g-content g-particle student-review-box">
                    <div id="jltestimonial2-9942" class="jltestimonial2-9942 jl-slider-container-offset"
                         jl-slider="autoplay: 1;">
                        <div class="jl-position-relative jl-visible-toggle" tabindex="-1">
                            <ul class="jl-slider-items jl-grid">
                                <?php   if ($list) : ?>
                                    <?php   foreach ($list as $item) : ?>
                                    <li class="tm-testimonial jl-width-1-1 jl-width-1-1@m">
                                        <div class="inner-wrapper">
                                            <div class="jl-card jl-card-default jl-card-body jl-margin-remove-first-child">
                                                <div class="tm-content jl-panel jl-margin-top">
                                                    <blockquote>“<?php echo $item->comment;?>”</blockquote>
                                                </div>
                                                <div class="jl-child-width-expand jl-flex-middle" jl-grid>
                                                    <div class="jl-width-auto">
                                                        <div class="tm-author-container jl-text-center">
                                                            <div class="author-image">
                                                                <img src="/uploads/students/<?php echo $item->image;?>"
                                                                     width="90" height="90" loading="lazy"
                                                                     class="tm-image jl-margin-top jl-border-circle"
                                                                     alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="student-name">
                                                        <div class="item-inner jl-margin-remove-first-child">
                                                            <h3 class="tm-title jl-margin-remove-bottom jl-text-uppercase jl-margin-top jl-h5">
                                                                <?php echo $item->name;?>
                                                            </h3>
                                                            <div class="tm-meta jl-margin-small-top jl-text-meta">
                                                                <?php echo $item->university;?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tm-quote jl-text-right">
                                                            <span class="quote-right jl-icon"><svg width="80" height="80"
                                                                                                   viewBox="0 0 20 20"
                                                                                                   xmlns="http://www.w3.org/2000/svg"><path
                                                                            d="M17.27,7.79 C17.27,9.45 16.97,10.43 15.99,12.02 C14.98,13.64 13,15.23 11.56,15.97 L11.1,15.08 C12.34,14.2 13.14,13.51 14.02,11.82 C14.27,11.34 14.41,10.92 14.49,10.54 C14.3,10.58 14.09,10.6 13.88,10.6 C12.06,10.6 10.59,9.12 10.59,7.3 C10.59,5.48 12.06,4 13.88,4 C15.39,4 16.67,5.02 17.05,6.42 C17.19,6.82 17.27,7.27 17.27,7.79 L17.27,7.79 Z"></path><path
                                                                            d="M8.68,7.79 C8.68,9.45 8.38,10.43 7.4,12.02 C6.39,13.64 4.41,15.23 2.97,15.97 L2.51,15.08 C3.75,14.2 4.55,13.51 5.43,11.82 C5.68,11.34 5.82,10.92 5.9,10.54 C5.71,10.58 5.5,10.6 5.29,10.6 C3.47,10.6 2,9.12 2,7.3 C2,5.48 3.47,4 5.29,4 C6.8,4 8.08,5.02 8.46,6.42 C8.6,6.82 8.68,7.27 8.68,7.79 L8.68,7.79 Z"></path></svg></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <?php   endforeach; ?>
                                <?php   endif;  ?>
                            </ul>
                            <div class="jl-visible@s jl-hidden-hover">
                                <a class="tm-slidenav jl-icon jl-position-medium jl-position-center-left" href
                                   jl-slidenav-previous jl-slider-item="previous"></a>
                                <a class="tm-slidenav jl-icon jl-position-medium jl-position-center-right" href
                                   jl-slidenav-next jl-slider-item="next"></a>
                            </div>
                        </div>
                        <ul class="jl-slider-nav jl-dotnav jl-flex-center jl-margin-top jl-visible@s jl-position-relative">
                            <li jl-slider-item="0"><a href></a></li>
                            <li jl-slider-item="1"><a href></a></li>
                            <li jl-slider-item="2"><a href></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="g-block size-45">
                <div class="spacer"></div>
            </div>
        </div>
    </div>
</section>
