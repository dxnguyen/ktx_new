<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.cassiopeia
 *
 * @copyright   (C) 2017 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Registry\Registry;
use Joomla\CMS\Router\Route;

/** @var Joomla\CMS\Document\HtmlDocument $this */

$app   = Factory::getApplication();
$input = $app->getInput();
$wa    = $this->getWebAssetManager();

// Browsers support SVG favicons
$this->addHeadLink(HTMLHelper::_('image', 'joomla-favicon.svg', '', [], true, 1), 'icon', 'rel', ['type' => 'image/svg+xml']);
$this->addHeadLink(HTMLHelper::_('image', 'favicon.ico', '', [], true, 1), 'alternate icon', 'rel', ['type' => 'image/vnd.microsoft.icon']);
$this->addHeadLink(HTMLHelper::_('image', 'joomla-favicon-pinned.svg', '', [], true, 1), 'mask-icon', 'rel', ['color' => '#000']);

// Detecting Active Variables
$option   = $input->getCmd('option', '');
$view     = $input->getCmd('view', '');
$layout   = $input->getCmd('layout', '');
$task     = $input->getCmd('task', '');
$itemid   = $input->getCmd('Itemid', '');
$sitename = htmlspecialchars($app->get('sitename'), ENT_QUOTES, 'UTF-8');
$menu     = $app->getMenu()->getActive();
$activeMenu = $app->getMenu()->getActive()->id;
$pageclass = $menu !== null ? $menu->getParams()->get('pageclass_sfx', '') : '';

$homeMenuId = $app->getMenu()->getDefault()->id;
$isHome = ($activeMenu == $homeMenuId);


// Color Theme
$paramsColorName = $this->params->get('colorName', 'colors_standard');
$assetColorName  = 'theme.' . $paramsColorName;
$wa->registerAndUseStyle($assetColorName, 'media/templates/site/ktx/css/global/' . $paramsColorName . '.css');

// Use a font scheme if set in the template style options
$paramsFontScheme = $this->params->get('useFontScheme', false);
$fontStyles       = '';

$activeTemplate = $app->getTemplate(true)->template;
$template_path  = JURI::root().'templates/'.$activeTemplate.'/';

if ($paramsFontScheme) {
    if (stripos($paramsFontScheme, 'https://') === 0) {
        $this->getPreloadManager()->preconnect('https://fonts.googleapis.com/', ['crossorigin' => 'anonymous']);
        $this->getPreloadManager()->preconnect('https://fonts.gstatic.com/', ['crossorigin' => 'anonymous']);
        $this->getPreloadManager()->preload($paramsFontScheme, ['as' => 'style', 'crossorigin' => 'anonymous']);
        $wa->registerAndUseStyle('fontscheme.current', $paramsFontScheme, [], ['media' => 'print', 'rel' => 'lazy-stylesheet', 'onload' => 'this.media=\'all\'', 'crossorigin' => 'anonymous']);

        if (preg_match_all('/family=([^?:]*):/i', $paramsFontScheme, $matches) > 0) {
            $fontStyles = '--cassiopeia-font-family-body: "' . str_replace('+', ' ', $matches[1][0]) . '", sans-serif;
			--cassiopeia-font-family-headings: "' . str_replace('+', ' ', isset($matches[1][1]) ? $matches[1][1] : $matches[1][0]) . '", sans-serif;
			--cassiopeia-font-weight-normal: 400;
			--cassiopeia-font-weight-headings: 700;';
        }
    } else {
        $wa->registerAndUseStyle('fontscheme.current', $paramsFontScheme, ['version' => 'auto'], ['media' => 'print', 'rel' => 'lazy-stylesheet', 'onload' => 'this.media=\'all\'']);
        $this->getPreloadManager()->preload($wa->getAsset('style', 'fontscheme.current')->getUri() . '?' . $this->getMediaVersion(), ['as' => 'style']);
    }
}

// Enable assets
$wa->usePreset('template.ktx.' . ($this->direction === 'rtl' ? 'rtl' : 'ltr'))
    ->useStyle('template.active.language')
    ->useStyle('template.user')
    ->useScript('template.user')
    ->addInlineStyle(":root {
		--hue: 214;
		--template-bg-light: #f0f4fb;
		--template-text-dark: #495057;
		--template-text-light: #ffffff;
		--template-link-color: #2a69b8;
		--template-special-color: #001B4C;
		$fontStyles
	}");

// Override 'template.active' asset to set correct ltr/rtl dependency
$wa->registerStyle('template.active', '', [], [], ['template.ktx.' . ($this->direction === 'rtl' ? 'rtl' : 'ltr')]);

// Logo file or site title param
if ($this->params->get('logoFile')) {
    $logo = HTMLHelper::_('image', Uri::root(false) . htmlspecialchars($this->params->get('logoFile'), ENT_QUOTES), $sitename, ['loading' => 'eager', 'decoding' => 'async'], false, 0);
} elseif ($this->params->get('siteTitle')) {
    $logo = '<span title="' . $sitename . '">' . htmlspecialchars($this->params->get('siteTitle'), ENT_COMPAT, 'UTF-8') . '</span>';
} else {
    $logo = HTMLHelper::_('image', 'logo.svg', $sitename, ['class' => 'logo d-inline-block', 'loading' => 'eager', 'decoding' => 'async'], true, 0);
}


$hasClass = '';
if ($this->countModules('sidebar-left', true)) {
    $hasClass .= ' has-sidebar-left';
}

if ($this->countModules('sidebar-right', true)) {
    $hasClass .= ' has-sidebar-right';
}

// Container
$wrapper = $this->params->get('fluidContainer') ? 'wrapper-fluid' : 'wrapper-static';

$this->setMetaData('viewport', 'width=device-width, initial-scale=1');

$stickyHeader = $this->params->get('stickyHeader') ? 'position-sticky sticky-top' : '';

// Defer fontawesome for increased performance. Once the page is loaded javascript changes it to a stylesheet.
$wa->getAsset('style', 'fontawesome')->setAttribute('rel', 'lazy-stylesheet');

// get infoweb
$dxn     = new Dxn();
$infoweb = $dxn->getInfoweb();

?>
<!DOCTYPE html>
<html lang="en-GB" dir="ltr">

<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    <meta charset="utf-8">
    <meta name="description" content="<?php echo $app->getConfig()->get('MetaDesc');?>">
    <jdoc:include type="head" />

    <link href="<?php echo $template_path;?>media/com_convertforms/css/convertformsa7fc.css?2f978bcf04dcc23579c9dffe3871c4e8" rel="stylesheet"/>
    <link href="<?php echo $template_path;?>templates/jl_double_pro/css/jluikit.min.css" rel="stylesheet"/>
    <link href="<?php echo $template_path;?>media/gantry5/engines/nucleus/css-compiled/nucleus.css" rel="stylesheet"/>
    <link href="<?php echo $template_path;?>templates/jl_double_pro/custom/css-compiled/double_39.css" rel="stylesheet"/>
    <link href="<?php echo $template_path;?>media/gantry5/engines/nucleus/css-compiled/bootstrap5.css" rel="stylesheet"/>
    <link href="<?php echo $template_path;?>media/system/css/joomla-fontawesome.min.css" rel="stylesheet"/>
    <link href="<?php echo $template_path;?>media/system/css/debug.css" rel="stylesheet"/>
    <link href="<?php echo $template_path;?>media/gantry5/assets/css/font-awesome5-all.min.css" rel="stylesheet"/>
    <link href="<?php echo $template_path;?>templates/jl_double_pro/custom/css-compiled/double-joomla_39.css" rel="stylesheet"/>
    <link href="<?php echo $template_path;?>templates/jl_double_pro/custom/css-compiled/custom_39.css" rel="stylesheet"/>
    <link href="<?php echo $template_path;?>templates/jl_double_pro/css/pe-icon-7-stroke.css" rel="stylesheet"/>
    <link href="<?php echo $template_path;?>templates/jl_double_pro/css/leaflet.css" rel="stylesheet"/>
    <link href="<?php echo $template_path;?>templates/jl_double_pro/css/flatsome.css" rel="stylesheet"/>
    <link href="<?php echo $template_path;?>templates/jl_double_pro/custom/common.css" rel="stylesheet"/>

    <link rel="icon" href="<?php echo $template_path;?>favicon-32x32.png" type="image/png">

    <script src="<?php echo $template_path;?>media/system/js/core.mind6dc.js?ee06c8994b37d13d4ad21c573bbffeeb9465c0e2"></script>
    <script src="<?php echo $template_path;?>media/system/js/keepalive-es5.min544d.js?4eac3f5b0c42a860f0f438ed1bea8b0bdddb3804" defer nomodule></script>
    <script src="<?php echo $template_path;?>media/system/js/keepalive.mind58a.js?9f10654c2f49ca104ca0449def6eec3f06bd19c0" type="module"></script>
    <script src="<?php echo $template_path;?>media/vendor/jquery/js/jquery.min8a0c.js?3.7.1"></script>
    <script src="<?php echo $template_path;?>media/legacy/js/jquery-noconflict.min02ca.js?647005fc12b79b3ca2bb30c059899d5994e3e34d"></script>
    <script src="<?php echo $template_path;?>media/com_convertforms/js/sitea7fc.js?2f978bcf04dcc23579c9dffe3871c4e8"></script>
    <script src="<?php echo $template_path;?>media/com_convertforms/js/vendor/inputmask.mina7fc.js?2f978bcf04dcc23579c9dffe3871c4e8"></script>
    <script src="<?php echo $template_path;?>media/com_convertforms/js/inputmaska7fc.js?2f978bcf04dcc23579c9dffe3871c4e8"></script>
    <script src="<?php echo $template_path;?>templates/jl_double_pro/js/jluikit.min.js"></script>
    <script src="<?php echo $template_path;?>templates/jl_double_pro/js/jlcomponents/slideshow.min.js"></script>
    <script src="<?php echo $template_path;?>templates/jl_double_pro/js/jlcomponents/slideshow-parallax.min.js"></script>
    <script src="<?php echo $template_path;?>templates/jl_double_pro/js/jlcomponents/filter.min.js"></script>
    <script src="<?php echo $template_path;?>templates/jl_double_pro/js/jlcomponents/lightbox.min.js"></script>
    <script src="<?php echo $template_path;?>templates/jl_double_pro/js/jlcomponents/lightbox-panel.min.js"></script>
    <script src="<?php echo $template_path;?>templates/jl_double_pro/js/jlcomponents/slider.min.js"></script>

</head>

<body class="gantry site com_gantry5 view-custom no-layout no-task dir-ltr itemid-288 outline-39 g-default g-style-preset1">

<div id="g-page-surround">
    <?php if ($this->countModules('topbar')) : ?>
            <jdoc:include type="modules" name="topbar" style="" />
    <?php endif; ?>

    <section id="g-g-top-bar" class="nomarginall nopaddingall">
        <div class="g-grid">
            <div class="g-block size-100">
                <div jl-sticky media="@m" cls-active="jl-navbar-sticky"
                     cls-inactive="jl-navbar-transparent jl-light" sel-target=".jl-navbar-container">
                    <div class="jl-container">

                        <?php if ($this->countModules('menu')) : ?>
                            <jdoc:include type="modules" name="menu" style="" />
                        <?php endif; ?>

                    </div>
                </div>
            </div>
            <div class="g-block size-100 jl-hidden@m">
                <form id="searchHome" action="<?php echo @Route::_('index.php?option=com_homepage&view=Search&Itemid=177')?>" method="get">
                    <input type="text" value="" name="jform[keyword]" class="keyword"/>
                    <button id="searchBtn" type="submit" class="btn-sm"><i class="fa fa-search"></i></button>
                    <!--<input type="hidden" name="option" value="com_homepage" />
                    <input type="hidden" name="task" value="search.search" />-->
                </form>
            </div>
        </div>
    </section>

    <jdoc:include type="message" />

    <div id="componentBox" class="jl-section-xsmall">
    <jdoc:include type="component"/>
    </div>

    <section id="g-copyright">
        <div class="jl-container">
            <div class="g-grid">

                <div class="g-block size-50">
                    <div id="branding-2132-particle" class="g-content g-particle">
                        <div class="g-branding ">
                            Bản quyền©2024 thuộc Trung tâm Quản lý Ký túc xá. <br/>
                            Thiết kế và xây dựng bởi <a href="//cntt-dl.ktxhcm.edu.vn/" target="_blank" style="color: #ff8f40;">Phòng Công nghệ thông tin - Dữ liệu</a> .
                        </div>
                    </div>
                </div>

                <div class="g-block size-50">
                    <div id="social-9948-particle" class="g-content g-particle social-link">
                        <div class="el-social square-icon jl-text-right@m jl-text-right@s  jl-text-right">
                            <div class="jl-child-width-auto jl-grid-small jl-flex-inline jl-grid" jl-grid>
                                <div class="note-social-text">Theo dõi chúng tôi trên:</div>
                                <div>
                                    <a href="<?php echo $infoweb->facebook;?>" title="Facebook" aria-label="Facebook" target="_blank">
                                        <span class="fab fa-facebook-f"></span> <span class="g-social-text"></span>
                                    </a>
                                </div>
                                <div>
                                    <a href="<?php echo $infoweb->twitter;?>" title="Twitter" aria-label="" target="_blank">
                                        <span class="fab fa-twitter"></span> <span class="g-social-text"></span>
                                    </a>
                                </div>
                                <div>
                                    <a href="<?php echo $infoweb->instagram;?>" title="Youtube" aria-label="Youtube" target="_blank">
                                        <span class="fab fa-youtube"></span> <span class="g-social-text"></span>
                                    </a>
                                </div>
                                <div>
                                    <a href="<?php echo $infoweb->zalo;?>" title="Google plus" aria-label="Google plus" target="_blank">
                                        <span class="fab fa-google-plus-g"></span>  <span class="g-social-text"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

<!-- go to top -->
<button id="back-to-top" title="Go to top"><i class="fas fa-arrow-up"></i></button>
<!-- end -->

<!-- Html popup Video -->
<!-- Popup modal -->
<div id="video-popup" class="popup">
    <div class="popup-content">
        <span class="close-btn">&times;</span>
        <div class="video-container">
            <iframe id="youtube-video" src="https://www.youtube.com/embed/9tM68iMoxTE" width="640" height="360" src="" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
        </div>
    </div>
</div>

<!-- end popup video -->

<script type="text/javascript">
    jlUIkit.util.ready(function () {
        jlUIkit.scrollspyNav('.jl-navbar-nav, .g-toplevel, .jl-nav', {closest: 'li', offset: 80});
        jlUIkit.util.ready(function () {
            document.querySelectorAll('.jl-navbar-nav li a, .g-toplevel li a, .jl-nav li a').forEach(function (el) {
                if (location.hostname == el.hostname && location.pathname == el.pathname && el.href != '#') {
                    jlUIkit.scroll(el, {offset: 30});
                }
            });
        });
        jlUIkit.util.on(this, 'beforescroll', function () {
            jlUIkit.offcanvas('.jl-offcanvas').hide();
        });
    });
</script>
<script type="text/javascript" src="<?php echo $template_path;?>templates/jl_double_pro/js/jquery.appear.js"></script>
<script type="text/javascript" src="<?php echo $template_path;?>templates/jl_double_pro/js/jquery.countTo.js"></script>
<script type="text/javascript">
    jQuery(function ($) {
        $('.jlsimplecounter-5893 .tm-counter-number').appear(function () {
            $('.jlsimplecounter-5893 .tm-counter-number').countTo(
            );
        });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $template_path;?>templates/jl_double_pro/js/leaflet.js"></script>
<script type="text/javascript" src="<?php echo $template_path;?>templates/jl_double_pro/js/leaflet-providers.js"></script>
<script type="text/javascript" src="<?php echo $template_path;?>templates/jl_double_pro/js/typed.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!--<script type="text/javascript"
        src="//maps.google.com/maps/api/js?key=AIzaSyCmCmdHIiIjJd8rnkRzTAF2mpOBcNJwXis"></script>-->
<!----Maps--->
<script type="text/javascript">

    // script.js
    document.addEventListener('DOMContentLoaded', function() {
        $('a.youtube-id').click(function(e) {
            e.preventDefault();
            let videoId  = $(this).attr('data-id');
            $('#youtube-video').attr('src', 'https://www.youtube.com/embed/'+videoId+'?autoplay=1');

            setTimeout(function () {
                $('#video-popup').fadeIn();
            }, 200);
        });

        $('.close-btn').on('click', function() {
            $('#video-popup').fadeOut();
            $('#youtube-video').attr('src', '');
        });

        $(window).on('click', function(e) {
            if ($(e.target).is('#videoPopup')) {
                $('#video-popup').fadeOut();
                $('#youtube-video').attr('src', '');
            }
        });

    });

    // Button go to top
    $(window).scroll(function () {
        if ($(this).scrollTop() > 20) {
            $('#back-to-top').fadeIn();
        } else {
            $('#back-to-top').fadeOut();
        }
    });

    // Khi click vào sẽ cuộn lên đầu trang
    $('#back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 'slow');
        return false;
    });

    $(document).ready(function() {
        $('#jlcarousel-9721').carousel({
            //pause: true,
            interval: 2000,
        });
    });


</script>
<!------End maps---------->

</body>

</html>

