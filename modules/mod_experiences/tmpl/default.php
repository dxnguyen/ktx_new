<?php
/**
 * @version     1.0.0
 * @package     mod_experiences_1.0.0_j4x
 * @copyright   Copyright (C) 2024. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      nguyen dinh <vb.dinhxuannguyen@gmail.com> - https://componentgenerator.com
 */

//No direct access
defined('_JEXEC') or die('Restricted access');

?>

<section id="g-below" class="bg-gradient-cold jl-light">
    <div class="banner has-hover has-video" id="banner-910595725">
        <div class="banner-inner fill">
            <div class="banner-bg fill">
                <div class="bg fill bg-fill bg-loaded"></div>
                <div class="video-overlay no-click fill"></div>
                <video class="video-bg fill" preload="" playsinline="" autoplay="" muted="" loop="">
                    <source src="uploads/infos/<?php echo $sInfoweb->tour_video;?>" type="video/mp4">
                </video>
            </div>

            <div class="jl-container banner-layers">
                <div class="fill banner-link"></div>
                <div id="text-box-325691391"
                     class="text-box banner-layer x0 md-x0 lg-x0 y90 md-y90 lg-y90 res-text">
                    <div data-animate="blurIn" data-animate-transform="true" data-animate-transition="true"
                         data-animated="true">
                        <div class="text-box-content text dark">
                            <div class="text-inner text-left">
                                <h3 class="jl-h2 title-h2"><strong>Trải nghiệm <span
                                            class="title-red">Ký túc xá</span></strong></h3>
                                <p class="jl-text-justify text-trai-nghiem"> <?php echo @$sInfoweb->experience_text;?> </p>
                                <p><a href="<?php echo @$sInfoweb->ktx_online;?>" target="_blank"
                                      class="button secondary lowercase" rel="noopener">
                                        <span>360° Virtual Tour  <i class="fas fa-arrow-right"></i></span>
                                    </a>
                                    <a href="https://sv.ktxhcm.edu.vn/" target="_blank" class="button secondary lowercase" rel="noopener">
                                        <span>Hỗ trợ đăng ký phòng ở <i class="fas fa-arrow-right"></i></span>
                                    </a>
                                </p>

                            </div>
                        </div>
                    </div>

                    <style>
                        #text-box-325691391 .text-box-content {
                            background-color: rgba(12, 45, 102, 0.75); /*rgba(255, 50, 17, 0.75);*/
                            font-size: 100%;
                        }

                        #text-box-325691391 .text-inner {
                            padding: 30px 20px 30px 20px;
                        }

                        #text-box-325691391 {
                            width: 96%;
                        }

                        @media (min-width: 550px) {
                            #text-box-325691391 {
                                width: 64%;
                            }
                        }

                        @media (min-width: 850px) {
                            #text-box-325691391 .text-inner {
                                padding: 60px 40px 60px 40px;
                            }

                            #text-box-325691391 {
                                width: 49%;
                            }
                        }
                    </style>
                </div>
            </div>
        </div>
    </div>

</section>
