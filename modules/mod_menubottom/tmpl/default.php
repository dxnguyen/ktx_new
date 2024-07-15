<?php
/**
 * @version     1.0.0
 * @package     mod_menubottom_1.0.0_j4x
 * @copyright   Copyright (C) 2024. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      nguyen dinh <vb.dinhxuannguyen@gmail.com> - https://componentgenerator.com
 */

//No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Router\Route;
use Joomla\Component\Content\Site\Helper\RouteHelper;

$dxn = new Dxn();
$sInfoweb = $dxn->getSession('sInfoweb');

?>
<footer id="g-footer" class="jl-section nopaddingbottom jl-s">
    <div class="jl-container">
        <div class="g-grid">
            <div class="jl-child-width-1-1 jl-child-width-1-2@s jl-child-width-1-4@m jl-grid-small jl-flex-center jl-flex-middle"
                 jl-grid>
                <div class="g-block size-25">
                    <div id="jlfooterinfo-7949-particle" class="g-content g-particle">
                        <div id="jlfooterinfo-7949" class="jlfooterinfo-7949">
                            <div class="tm-content jl-panel jl-margin-remove-top">
                                <h3 class="g5-title jl-text-emphasis jl-h3 jl-text-uppercase">Liên hệ</h3>
                                <p><i class="fas fa-map-marker-alt"></i> <strong>Địa chỉ:</strong> <?php echo $sInfoweb->address_1; ?></p>
                                <p class="g-footer-phone"><i class="fas fa-phone-volume"></i> <strong>Điện
                                        thoại:</strong> <a href="tel:<?php echo $sInfoweb->hotline; ?>"> <?php echo $sInfoweb->hotline; ?></a></p>
                                <p class="g-footer-email"><i class="far fa-envelope"></i> <strong>Email:</strong> <a
                                            href="mailto:<?php echo $sInfoweb->email_ktx; ?>"><?php echo $sInfoweb->email_ktx; ?></a><!-- hoặc <a
                                            href="mailto:<?php /*echo $sInfoweb->email_ktx; */?>"><?php /*echo $sInfoweb->email_ktx; */?></a>--></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="g-block  size-25">
                    <div id="jllist-3285-particle" class="g-content g-particle jl-panel">
                        <h3 class="g5-title jl-h3 jl-text-uppercase">Giới thiệu</h3>
                        <div class="jllist-3285">
                            <ul class="jl-list">
                                <?php if ($listMenuAbout) : ?>
                                    <?php foreach ($listMenuAbout as $item) : ?>
                                        <?php   $attributes = ($item->browserNav == 1) ? ' target="_blank"' : ''; ?>
                                        <li class="tm-item">
                                            <div class="tm-content jl-panel">
                                                <a href="<?php echo Route::_($item->link);?>" <?php echo $attributes;?> jl-scroll>
                                                    <?php echo $item->title;?>
                                                </a>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="g-block size-25">
                    <div id="jllist-3285-particle" class="g-content g-particle jl-panel">
                        <h3 class="g5-title jl-h3 jl-text-uppercase">Đơn vị trực thuộc</h3>
                        <div class="jllist-3285">
                            <ul class="jl-list">
                                <?php if ($listMenuDepartment) : ?>
                                    <?php foreach ($listMenuDepartment as $item) : ?>
                                        <?php   $attributes = ($item->browserNav == 1) ? ' target="_blank"' : ''; ?>
                                        <li class="tm-item">
                                            <div class="tm-content jl-panel">
                                                <a href="<?php echo Route::_($item->link);?>" <?php echo $attributes;?> jl-scroll>
                                                    <?php echo $item->title;?>
                                                </a>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="g-block size-25">
                    <div id="jllist-3285-particle" class="g-content g-particle jl-panel">
                        <h3 class="g5-title jl-h3 jl-text-uppercase">Đơn vị trực thuộc</h3>
                        <div class="jllist-3285">
                            <ul class="jl-list ">
                                <?php if ($listMenuBql) : ?>
                                    <?php foreach ($listMenuBql as $item) : ?>
                                        <?php   $attributes = ($item->browserNav == 1) ? ' target="_blank"' : ''; ?>
                                        <li class="tm-item">
                                            <div class="tm-content jl-panel">
                                                <a href="<?php echo Route::_($item->link);?>" <?php echo $attributes;?> jl-scroll>
                                                    <?php echo $item->title;?>
                                                </a>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="g-grid">
            <div class="g-block size-100 nopaddingbottom nomarginbottom">
                <div id="jldivider-9642-particle" class="g-content g-particle">
                    <div class="jldivider-9642">
                        <hr class="jl-hr">
                    </div>
                </div>
            </div>
        </div>
    </div>

</footer>
