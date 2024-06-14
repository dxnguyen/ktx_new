<?php
/**
 * @version     1.0.0
 * @package     mod_menutop_1.0.0_j4x
 * @copyright   Copyright (C) 2024. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      nguyen dinh <vb.dinhxuannguyen@gmail.com> - https://componentgenerator.com
 */

//No direct access
defined('_JEXEC') or die('Restricted access');

$dxn = new Dxn();
$infoweb = $dxn->getInfoweb();
?>
<section id="g-header-topbar" class="nomarginall nopaddingall">
    <div class="box-menu-topbar jl-navbar-container jl-navbar-transparent jl-light">
        <div class="jl-container container-mb" style="display: none;">
            <div class="hotline-mb size-100">
                <span style="float:left; line-height: 13px; color: #ffffff;">Tổng đài:</span>
                <ul class="phone-list">
                    <li><a href="tel:<?php echo $infoweb->hotline;?>>" class="" title="<?php echo $infoweb->hotline;?>">
                            <span><?php echo $infoweb->hotline;?></span>
                        </a></li>
                    <li><a href="tel:<?php echo $infoweb->hotline;?>>" class="" title="<?php echo $infoweb->hotline;?>">
                            <span><?php echo $infoweb->hotline;?></span>
                        </a></li>
                    <li><a href="tel:<?php echo $infoweb->hotline;?>>" class="" title="<?php echo $infoweb->hotline;?>">
                            <span><?php echo $infoweb->hotline;?></span>
                        </a></li>
                    <li><a href="tel:<?php echo $infoweb->hotline;?>>" class="" title="<?php echo $infoweb->hotline;?>">
                            <span><?php echo $infoweb->hotline;?></span>
                        </a></li>
                </ul>
            </div>
        </div>
        <div class="jl-container box-top-bar">
            <div class="size-10 boxlang hidden-phone"><a id="Vn" href="#"><span
                            class="hidden-phone">English</span> <img src="<?php echo $template_path;?>templates/en.svg"></a></div>
            <div class="size-70" style="display: flex; align-items: center;">
                <div class="hotline hidden-phone">
                    <span style="float:left; line-height: 13px; color: #ff0000;">Tổng đài:</span>
                    <ul class="phone-list">
                        <li><a href="tel:<?php echo $infoweb->hotline;?>" class="" title="<?php echo $infoweb->hotline;?>">
                                <span><?php echo $infoweb->hotline;?></span>
                            </a></li>
                        <li><a href="tel:<?php echo $infoweb->hotline;?>" class="" title="<?php echo $infoweb->hotline;?>">
                                <span><?php echo $infoweb->hotline;?></span>
                            </a></li>
                        <li><a href="tel:<?php echo $infoweb->hotline;?>" class="" title="<?php echo $infoweb->hotline;?>">
                                <span><?php echo $infoweb->hotline;?></span>
                            </a></li>
                        <li><a href="tel:<?php echo $infoweb->hotline;?>" class="" title="<?php echo $infoweb->hotline;?>">
                                <span><?php echo $infoweb->hotline;?></span>
                            </a></li>
                    </ul>
                </div>
                <ul class="top-menus">
                    <?php   if ($list) :    ?>
                        <?php   foreach($list as $item) :   ?>
                                    <li><a href="<?php echo $item->link;?>"><?php echo $item->title;?></a></li>
                        <?php   endforeach; ?>
                    <?php   endif;  ?>
                </ul>

            </div>
            <div class="">
                <a class="lang-mb" id="" href="#"> <img src="<?php echo $template_path;?>templates/en.svg"> </a>
            </div>
            <div class="size-20 hidden-phone hidden@s">
                <form id="searchHome" action="" method="post">
                    <input type="text" value="" nane="keyword" class="keyword"/>
                    <button id="searchBtn" type="submit" class="btn-sm"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function ($) {
            var typed = new Typed('#searchHome .keyword', {
                strings: ["Tiếp nhận sinh viên", "Khám sức khỏe", "phòng ở sinh viên",],
                typeSpeed: 100,
                startDelay: 0,
                backSpeed: 60,
                backDelay: 2000,
                loop: true,
                attr: 'placeholder',
                bindInputFocusEvents: true,
                cursorChar: "|",
                contentType: 'html'
            });

        });
    </script>
</section>