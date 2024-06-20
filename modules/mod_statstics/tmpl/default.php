<?php
/**
 * @version     1.0.0
 * @package     mod_statstics_1.0.0_j4x
 * @copyright   Copyright (C) 2024. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      nguyen dinh <vb.dinhxuannguyen@gmail.com> - https://componentgenerator.com
 */

//No direct access
defined('_JEXEC') or die('Restricted access');
?>

<header id="g-header" class="jl-section">
    <div class="jl-container">
        <div class="g-grid">
            <div class="g-block size-100 jl-light">
                <div id="jlsimplecounter-5893-particle" class="g-content g-particle">
                    <div class="jlsimplecounter-5893 jl-child-width-1-1 jl-child-width-1-1@s jl-child-width-1-3@m jl-grid-small jl-flex-center jl-flex-middle"
                         jl-grid>
                        <div>
                            <div class="jl-panel">
                                <div class="jl-child-width-expand" jl-grid>
                                    <div class="jl-width-1-3@m">
                                        <div class="jl-counter-icon jl-h3">
                                            <i class="fa fa-users" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <div class="jl-margin-remove-first-child counting-number">
                                        <div class="el-counter jl-h3 jl-margin-small-top jl-margin-remove-bottom">
                                            <div class="tm-counter-number jl-inline" data-refresh-interval="50"
                                                 data-speed="<?php echo $delayTime;?>" data-from="0" data-to="<?php echo $list->students;?>"
                                                 data-refresh-interval="50"></div>
                                            <div id="jlsimplecounter-5893" class="jl-inline indicator">+</div>
                                        </div>
                                        <div class="tm-counter-title jl-text-lead jl-margin-small-top">Sinh viên nội
                                            trú
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div>
                            <div class="jl-panel building">
                                <div class="jl-child-width-expand" jl-grid>
                                    <div class="jl-width-1-3@m">
                                        <div class="jl-counter-icon jl-h3">
                                            <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                                        </div>

                                    </div>
                                    <div class="jl-margin-remove-first-child counting-number">
                                        <div class="el-counter jl-h3 jl-margin-small-top jl-margin-remove-bottom">

                                            <div class="tm-counter-number jl-inline" data-refresh-interval="50"
                                                 data-speed="<?php echo $delayTime;?>" data-from="0" data-to="<?php echo $list->scholarship;?>"
                                                 data-refresh-interval="50"></div>

                                        </div>
                                        <div class="tm-counter-title jl-text-lead jl-margin-small-top">Suất học bổng</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="jl-panel">
                                <div class="jl-child-width-expand" jl-grid>
                                    <div class="jl-width-1-3@m">
                                        <div class="jl-counter-icon jl-h3">
                                            <i class="fa fa-bed" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <div class="jl-margin-remove-first-child counting-number">
                                        <div class="el-counter jl-h3 jl-margin-small-top jl-margin-remove-bottom">
                                            <div class="tm-counter-number jl-inline" data-refresh-interval="50"
                                                 data-speed="<?php echo $delayTime;?>" data-from="0" data-to="<?php echo $list->rooms;?>"
                                                 data-refresh-interval="50"></div>
                                            <div id="jlsimplecounter-5893" class="jl-inline indicator">+</div>
                                        </div>
                                        <div class="tm-counter-title jl-text-lead jl-margin-small-top">Phòng ở</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>