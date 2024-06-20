<?php
/**
 * @version     1.0.0
 * @package     mod_maps_1.0.0_j4x
 * @copyright   Copyright (C) 2024. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      nguyen dinh <vb.dinhxuannguyen@gmail.com> - 
 */

//No direct access
defined('_JEXEC') or die('Restricted access');
?>
<section id="g-bottom" class="jl-s">
    <div class="jl-container viewmap">
        <div class="grid">
            <div class="jl-child-width-1-1 jl-child-width-1-1@s jl-child-width-1-2@m jl-grid-small jl-flex-center jl-flex-middle"
                 jl-grid>
                <div class="g-block size-40 address-box">
                    <div class="tm-content">
                        <h3 class="tm-title jl-h2">Campus</h3>
                        <?php if (!empty($sInfoweb->address_1)) : ?>
                        <p class="address-link"><i class='fas fa-map-marker-alt'
                                                   style='font-size:18px;color:red'></i><strong> KTX KHU A:</strong>
                            <?php echo $sInfoweb->address_1; ?></p>
                        </p>
                        <?php endif;    ?>
                        <?php if (!empty($sInfoweb->address_2)) : ?>
                        <p class="address-link"><i class='fas fa-map-marker-alt'
                                                   style='font-size:18px;color:red'></i><strong> KTX KHU B:</strong>
                            <?php echo $sInfoweb->address_2; ?></p>
                        <?php endif;    ?>
                    </div>
                </div>
                <div class="g-block size-60 mapBox">
                    <div id="map">
                        <iframe
                                width="100%"
                                height="450"
                                frameborder="0"
                                style="border:0"
                                src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAdVERzth-E6FIrPNnuwlOj9D0wsuncmg8&q=Tạ Quang Bửu, Khu phố 6, Phường Linh Trung, Thành phố Thủ Đức, Thành phố Hồ Chí Minh."
                                loading="lazy"
                                allowfullscreen>
                        </iframe>
                        <!--<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1107.4266119202873!2d106.77893476862384!3d10.885477839879023!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x737ea1596a22dec5!2zMTDCsDUzJzA4LjAiTiAxMDbCsDQ2JzQ2LjMiRQ!5e0!3m2!1svi!2s!4v1649922948228!5m2!1svi!2s"
                                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
