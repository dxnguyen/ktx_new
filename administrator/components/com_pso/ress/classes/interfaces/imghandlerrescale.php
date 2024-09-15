<?php
/*
 * RESSIO Responsive Server Side Optimizer
 * https://github.com/ressio/
 *
 * @copyright   Copyright (C) 2013-2024 Kuneri Ltd. / Denis Ryabov, PageSpeed Ninja Team. All rights reserved.
 * @license     GNU General Public License version 2
 */

defined('RESSIO_PATH') || die();

interface IRessio_ImgHandlerRescale extends IRessio_ImgHandler
{
    /**
     * @param string $srcFile
     * @param string $destFile
     * @param int $width
     * @param int $height
     * @param string $format
     * @return bool
     */
    public function rescale($srcFile, $destFile, $width, $height, $format = null);
}
