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
$pageclass = $menu !== null ? $menu->getParams()->get('pageclass_sfx', '') : '';

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

    <link rel="icon" href="favicon-32x32.png" type="image/png">

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
                <form id="searchHome" action="" method="post">
                    <input type="text" value="" nane="keyword" class="keyword"/>
                    <button id="searchBtn" type="submit" class="btn-sm"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div>

    </section>

    <jdoc:include type="message" />

    <?php if ($this->countModules('slideshow')) : ?>
        <jdoc:include type="modules" name="slideshow" style="" />
    <?php endif; ?>

    <?php if ($this->countModules('stastics')) : ?>
        <jdoc:include type="modules" name="stastics" style="" />
    <?php endif; ?>

    <!--<main>
        <jdoc:include type="component" />
    </main>-->

    <section id="g-showcase" class="jl-section">
        <div class="jl-container">
            <div class="g-grid">
                <div class="g-block size-100">
                    <div id="jlcard-4831-particle" class="g-content g-particle g-showcase-text-box">
                        <div class="jlcard-4831 jl-panel">
                            <div class="jl-child-width-expand jl-flex-middle" jl-grid>

                                <div class="jl-margin-remove-first-child">
                                    <!--<div class="tm-meta jl-text-meta jl-text-primary jl-margin-top jl-text-uppercase">
                                        Why choose us
                                    </div>-->
                                    <h3 class=" tham-quan-title tm-title jl-margin-remove-bottom jl-h2 jl-margin-top title-h2">
                                        Tham quan <span class="title-red">Ký túc xá</span>
                                    </h3>
                                    <div class="tm-content jl-panel jl-margin-medium-top">
                                        <p class="btn-tqonline-text"><a href="#" target="_blank">
                                                <button class="tham-quan-btn jl-button-primary jl-button">THAM QUAN ONLINE
                                                    <i class="fas fa-arrow-right"></i></button>
                                            </a></p>
                                        <div id="module-jlvideo-213-particle" class="g-particle">
                                            <div id="module-jlvideo-213" class="module-jlvideo-213 jl-width-medium">
                                                <div class="tm-video-item">
                                                    <div class="video-view-box jl-child-width-expand jl-flex-middle jl-grid"
                                                         jl-grid>
                                                        <div class="jl-width-1-4">
                                                            <div class="tm-video-player">
                                                                <div class="btn-video-wrap">
                                                                    <a class="btn-video jl-icon-button"
                                                                       href="#module-jlvideo-213" jl-toggle
                                                                       aria-label="Open Video"><i class="jl-icon"
                                                                                                  jl-icon="play; ratio: 2">
                                                                            <svg width="40" height="40" viewBox="0 0 20 20"
                                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                                <polygon fill="none" stroke="#000"
                                                                                         points="6.5,5 14.5,10 6.5,15"></polygon>
                                                                            </svg>
                                                                        </i><i class="ripple"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="jl-margin-remove-first-child watch-video-text">
                                                            XEM VIDEO VỀ KÝ TÚC XÁ
                                                        </div>
                                                    </div>
                                                    <div id="module-jlvideo-213" class="jl-flex-top" jl-modal>
                                                        <div class="jl-modal-dialog jl-width-auto jl-margin-auto-vertical">
                                                            <button class="jl-modal-close-outside" type="button"
                                                                    jl-close></button>
                                                            <video src="<?php echo $template_path;?>templates/ktx_video.mp4"
                                                                   controls jl-video></video>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <section id="g-above" class="jl-section-xsmall">
        <div class="jl-container">
            <div class="g-grid">

                <div class="g-block size-60">
                    <div id="jlheading-3361-particle" class="g-content g-particle news-title-box">
                        <div class="jlheading-3361 tm-secondary-font">
                            <h3 class="news-title tm-title jl-margin-remove-bottom jl-text-bold jl-h2">Tin tức - <span
                                        class="title-red">Sự kiện</span></h3>
                        </div>
                    </div>
                </div>


                <div class="g-block size-40">
                    <div class="spacer"></div>
                </div>
            </div>
            <div class="g-grid">

                <div class="g-block size-100 nopaddingtop nopaddingbottom">
                    <div id="jlfiltergallery-1072-particle" class="g-content g-particle news-items">
                        <div id="jlfiltergallery-1072" class="jlfiltergallery-1072 jl-margin-remove-vertical"
                             jl-filter="target: .js-jlfiltergallery-1072;">


                            <ul class="jl-subnav jl-subnav-divider jl-margin">


                                <li class="jl-active" jl-filter-control><a href class="active">Tất cả</a></li>


                                <li jl-filter-control="[data-tag~='Branding']">
                                    <a href>Hoạt động</a>
                                </li>


                                <li jl-filter-control="[data-tag~='Design']">
                                    <a href>Sức khỏe</a>
                                </li>

                            </ul>


                            <div class="js-jlfiltergallery-1072 jl-child-width-1-1 jl-child-width-1-2@s jl-child-width-1-3@m"
                                 jl-grid="masonry: pack;" jl-lightbox="toggle: a[data-type]"
                                 jl-scrollspy="target: [jl-scrollspy-class]; cls: jl-animation-slide-bottom-small; delay: false;"
                            >


                                <div data-tag="Branding">


                                    <a class="tm-item jl-inline-clip jl-transition-toggle jl-link-toggle"
                                       href="#" target="_blank" title="Improve Startup" aria-label="Improve Startup"
                                       jl-scrollspy-class>
                                        <img src="<?php echo $template_path;?>templates/jl_double_pro/custom/images/portfolio-img-1.jpg"
                                             width="1024" height="892"
                                             class="tm-image jl-transition-scale-up jl-transition-opaque" alt=""
                                             loading="lazy">
                                        <div class="jl-position-bottom-center jl-position-medium jl-tile-default jl-transition-slide-bottom-small">

                                            <div class="jl-overlay jl-margin-remove-first-child">


                                                <h3 class="tm-title jl-margin-remove-bottom jl-h5 jl-margin-top">
                                                    TTQLKTX khẳng định mô hình tự chủ, trách nhiệm trong năm 2024
                                                </h3>


                                            </div>

                                        </div>
                                    </a>


                                </div>


                                <div data-tag="Design">


                                    <a class="tm-item jl-inline-clip jl-transition-toggle jl-link-toggle"
                                       href="<?php echo $template_path;?>templates/jl_double_pro/custom/images/portfolio-img-2.jpg"
                                       target="_blank"
                                       title="Adventure Engine" aria-label="Adventure Engine" jl-scrollspy-class>

                                        <img src="<?php echo $template_path;?>templates/jl_double_pro/custom/images/portfolio-img-2.jpg"
                                             width="1024" height="892"
                                             class="tm-image jl-transition-scale-up jl-transition-opaque" alt=""
                                             loading="lazy">


                                        <div class="jl-position-bottom-center jl-position-medium jl-tile-default jl-transition-slide-bottom-small">

                                            <div class="jl-overlay jl-margin-remove-first-child">


                                                <h3 class="tm-title jl-margin-remove-bottom jl-h5 jl-margin-top">
                                                    TTQLKTX ký kết hợp tác toàn diện với Ngân hàng BIDV – Chi nhánh Đông
                                                    Sài Gòn
                                                </h3>


                                            </div>

                                        </div>


                                    </a>


                                </div>


                                <div data-tag="Identity">
                                    <a class="tm-item jl-inline-clip jl-transition-toggle jl-link-toggle"
                                       href="<?php echo $template_path;?>templates/jl_double_pro/custom/images/portfolio-img-3.jpg"
                                       target="_blank"
                                       title="Design Promotion" aria-label="Design Promotion" jl-scrollspy-class>
                                        <img src="<?php echo $template_path;?>templates/jl_double_pro/custom/images/portfolio-img-3.jpg"
                                             width="1024" height="892"
                                             class="tm-image jl-transition-scale-up jl-transition-opaque" alt=""
                                             loading="lazy">
                                        <div class="jl-position-bottom-center jl-position-medium jl-tile-default jl-transition-slide-bottom-small">

                                            <div class="jl-overlay jl-margin-remove-first-child">


                                                <h3 class="tm-title jl-margin-remove-bottom jl-h5 jl-margin-top">
                                                    Khai mạc hội thao sinh viên Ký túc xá ĐHQG-HCM năm 2024
                                                </h3>


                                            </div>

                                        </div>
                                    </a>
                                </div>

                                <div data-tag="Identity">
                                    <a class="tm-item jl-inline-clip jl-transition-toggle jl-link-toggle"
                                       href="<?php echo $template_path;?>templates/jl_double_pro/custom/images/portfolio-img-4.jpg"
                                       target="_blank"
                                       title="Marketing Rules" aria-label="Marketing Rules" jl-scrollspy-class>
                                        <img src="<?php echo $template_path;?>templates/jl_double_pro/custom/images/portfolio-img-4.jpg"
                                             width="1024" height="892"
                                             class="tm-image jl-transition-scale-up jl-transition-opaque" alt=""
                                             loading="lazy">
                                        <div class="jl-position-bottom-center jl-position-medium jl-tile-default jl-transition-slide-bottom-small">

                                            <div class="jl-overlay jl-margin-remove-first-child">


                                                <h3 class="tm-title jl-margin-remove-bottom jl-h5 jl-margin-top">
                                                    Tổ chức lớp bồi dưỡng nghiệp vụ soạn thảo văn bản
                                                </h3>


                                            </div>

                                        </div>
                                    </a>
                                </div>
                                <div data-tag="Design">
                                    <a class="tm-item jl-inline-clip jl-transition-toggle jl-link-toggle"
                                       href="<?php echo $template_path;?>templates/jl_double_pro/custom/images/portfolio-img-5.jpg"
                                       target="_blank"
                                       title="Marketing Role" aria-label="Marketing Role" jl-scrollspy-class>
                                        <img src="<?php echo $template_path;?>templates/jl_double_pro/custom/images/portfolio-img-5.jpg"
                                             width="1024" height="892"
                                             class="tm-image jl-transition-scale-up jl-transition-opaque" alt=""
                                             loading="lazy">
                                        <div class="jl-position-bottom-center jl-position-medium jl-tile-default jl-transition-slide-bottom-small">

                                            <div class="jl-overlay jl-margin-remove-first-child">


                                                <h3 class="tm-title jl-margin-remove-bottom jl-h5 jl-margin-top">
                                                    Ngày hội tân sinh viên – School Fest 2023, gieo ước mơ và hy vọng
                                                </h3>


                                            </div>

                                        </div>
                                    </a>
                                </div>
                                <div data-tag="Branding">
                                    <a class="tm-item jl-inline-clip jl-transition-toggle jl-link-toggle"
                                       href="<?php echo $template_path;?>templates/jl_double_pro/custom/images/portfolio-img-6.jpg"
                                       target="_blank"
                                       title="Design promotion" aria-label="Design promotion" jl-scrollspy-class>
                                        <img src="<?php echo $template_path;?>templates/jl_double_pro/custom/images/portfolio-img-6.jpg"
                                             width="1024" height="892"
                                             class="tm-image jl-transition-scale-up jl-transition-opaque" alt=""
                                             loading="lazy">
                                        <div class="jl-position-bottom-center jl-position-medium jl-tile-default jl-transition-slide-bottom-small">

                                            <div class="jl-overlay jl-margin-remove-first-child">


                                                <h3 class="tm-title jl-margin-remove-bottom jl-h5 jl-margin-top">
                                                    Chương trình Kết nối biên cương: Xe đạp cũ, niềm vui mới
                                                </h3>


                                            </div>

                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <section id="g-below" class="bg-gradient-cold jl-light">
        <div class="banner has-hover has-video" id="banner-910595725">
            <div class="banner-inner fill">
                <div class="banner-bg fill">
                    <div class="bg fill bg-fill bg-loaded"></div>
                    <div class="video-overlay no-click fill"></div>
                    <video class="video-bg fill" preload="" playsinline="" autoplay="" muted="" loop="">
                        <source src="<?php echo $template_path;?>templates/trai_nghiem.mp4" type="video/mp4">
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
                                    <p class="jl-text-justify text-trai-nghiem">Với gần 35,000 sinh viên đang sinh sống
                                        và học tập. Bạn sẽ được bắt đầu cho một hành trình sống và học tập đầy màu sắc
                                        tại Ký túc xá, từ cơ sở vật chất hiện đại, các hoạt động
                                        ngoại khóa phong phú, đến những câu chuyện đời thường của sinh viên. Hãy khám
                                        phá và cùng trải nghiệm những điều tuyệt vời mà Ký túc xá mang lại!
                                    </p>
                                    <p><a href="https://thamquan.ktxhcm.edu.vn/" target="_blank"
                                          class="button secondary lowercase" rel="noopener">
                                            <span>360° Virtual Tour  <i class="fas fa-arrow-right"></i></span>
                                        </a><a href="#" target="_blank" class="button secondary lowercase" rel="noopener">
                                            <span>Hỗ trợ đăng ký phòng ở <i class="fas fa-arrow-right"></i></span>
                                        </a>
                                    </p>
                                    <!--
                                                                        <p><a href="#" target="_blank" class="button secondary lowercase" rel="noopener">
                                                                            <span>Hỗ trợ đăng ký phòng ở <i class="fas fa-arrow-right"></i></span>
                                                                            </a>
                                                                        </p>-->
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

    <!-- Video -->
    <section id="g-video" class="jl-section-xsmall">
        <div class="jl-container">
            <div class="g-grid">
                <div class="g-block size-50 has-hover">
                    <!--<div id="jlheading-3369-particle" class="g-content g-particle news-title-box">
                        <div class="jlheading-3361 tm-secondary-font">
                            <h3 class="video-title tm-title jl-margin-remove-bottom text-center jl-text-bold jl-h2 title-h2 jl-panel">
                                Thư viện <span class="title-red">Video</span></h3>
                        </div>
                    </div>
                    <div class="video-img image-zoom">
                        <a href="#"><img class="" src="<?php echo $template_path;?>templates/video.jpg"/> </a>
                    </div>-->
                    <div class="tieu-diem">
                        <div class="g-block size-100">
                            <div id="jlheading-3362-particle" class="g-content g-particle news-title-box">
                                <div class="jlheading-3361 tm-secondary-font">
                                    <h3 class="news-title tm-title jl-margin-remove-bottom jl-text-bold jl-h2 jl-panel">
                                        Thư viện <span class="title-red">Video</span></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="g-video-items-box">
                        <div class="g-block size-100 nopaddingtop nopaddingbottom">
                            <div class="row" id="row-876782046">
                                <div id="col-152373325" class="col pb-0 small-12 large-12">
                                    <style>
                                        #col-152373325 > .col-inner {
                                            padding: 27px 0px 0px 0px;
                                        }

                                        @media (min-width: 550px) {
                                            #col-152373325 > .col-inner {
                                                padding: 20px 0px 0px 0px;
                                            }
                                        }
                                    </style>
                                </div>
                                <div id="col-1979035021" class="col pb-0 medium-6 small-12 large-6">
                                    <div class="col-inner">
                                        <div class="row large-columns-1 medium-columns-1 small-columns-1">
                                            <div class="col post-item items-box" data-animate="fadeInLeft" data-animated="true">
                                                <div class="col-inner">
                                                    <div class="box box-normal box-text-bottom box-blog-post has-hover">
                                                        <div class="box-image">
                                                            <div class="image-zoom image-cover" style="">
                                                                <img id="open-popup" loading="lazy" decoding="async" width="1020"
                                                                     height="680" src="<?php echo $template_path;?>templates/video.jpg"
                                                                     class="attachment-large size-large wp-post-image"
                                                                     alt=""
                                                                     srcset="<?php echo $template_path;?>templates/video.jpg 1024w, templates/video.jpg 300w, templates/video.jpg 768w, templates/video.jpg 1200w"
                                                                     sizes="(max-width: 1020px) 100vw, 1020px"></div>
                                                        </div>
                                                        <div class="box-text text-left">
                                                            <div class="box-text-inner blog-post-inner">
                                                                <h5 class="post-title is-large post-title-main ">
                                                                    <a class="youtube-id" data-id="9tM68iMoxTE" href="#">Ra mắt sổ tay "Chăm sóc sức khỏe tinh
                                                                        thần cho sinh viên"</a></h5>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="col-1655344358" class="col pb-0 medium-6 small-12 large-6">
                                    <div class="col-inner">
                                        <div class="row large-columns-1 medium-columns-1 small-columns-1">
                                            <div class="col post-item items-box" data-animate="fadeInRight" data-animated="true">
                                                <div class="col-inner">
                                                    <div class="box box-vertical box-text-bottom box-blog-post has-hover col-inner-box">
                                                        <!--<div class="box-image" style="width:50%;">
                                                            <div class="image-zoom image-cover" style="padding-top:51%;">
                                                                <img loading="lazy" decoding="async" width="300" height="169" src="<?php echo $template_path;?>templates/chienluocdhqg.jpg" class="attachment-medium size-medium wp-post-image" alt="" srcset="<?php echo $template_path;?>templates/chienluocdhqg.jpg 300w, templates/chienluocdhqg.jpg 1024w, templates/chienluocdhqg.jpg 768w, templates/chienluocdhqg.jpg 1536w, templates/chienluocdhqg.jpg 2048w" sizes="(max-width: 300px) 100vw, 300px">  							  							  						</div>
                                                        </div>-->
                                                        <div class="box-text text-left">
                                                            <div class="box-text-inner blog-post-inner">
                                                                <h5 class="post-title is-large "><a href="#" class="youtube-id" data-id="9tM68iMoxTE">Chiến lược
                                                                        phát triển ĐHQG-HCM giai đoạn 2021-2030, tầm nhìn
                                                                        2045</a></h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col post-item" data-animate="fadeInRight" data-animated="true">
                                                <div class="col-inner">
                                                    <div class="box box-vertical box-text-bottom box-blog-post has-hover col-inner-box">
                                                        <!--<div class="box-image" style="width:50%;">
                                                            <div class="image-zoom image-cover" style="padding-top:51%;">
                                                                <img loading="lazy" decoding="async" width="300" height="169" src="<?php echo $template_path;?>templates/camnang2023.jpg" class="attachment-medium size-medium wp-post-image" alt="" srcset="<?php echo $template_path;?>templates/camnang2023.jpg 300w, templates/camnang2023.jpg 1024w, templates/camnang2023.jpg 768w, templates/camnang2023.jpg 1536w, templates/camnang2023.jpg 2048w" sizes="(max-width: 300px) 100vw, 300px">  							  							  						</div>
                                                        </div>-->
                                                        <div class="box-text text-left">
                                                            <div class="box-text-inner blog-post-inner">
                                                                <h5 class="post-title is-large "><a href="#" class="youtube-id" data-id="9tM68iMoxTE">Cẩm nang
                                                                        sinh viên nội trú năm học 2023-2024</a></h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col post-item" data-animate="fadeInRight" data-animated="true">
                                                <div class="col-inner">
                                                    <div class="box box-vertical box-text-bottom box-blog-post has-hover col-inner-box">
                                                        <!--<div class="box-image" style="width:50%;">
                                                            <div class="image-zoom image-cover" style="padding-top:51%;">
                                                                <img loading="lazy" decoding="async" width="300" height="169" src="<?php echo $template_path;?>templates/noiquy.jpg" class="attachment-medium size-medium wp-post-image" alt="" srcset="<?php echo $template_path;?>templates/noiquy.jpg 300w, templates/noiquy.jpg 1024w, templates/noiquy.jpg 768w, templates/noiquy.jpg 1536w, templates/noiquy.jpg 2048w" sizes="(max-width: 300px) 100vw, 300px">  							  							  						</div>
                                                        </div>-->
                                                        <div class="box-text text-left">
                                                            <div class="box-text-inner blog-post-inner">
                                                                <h5 class="post-title is-large "><a href="#">Nội quy ký
                                                                        túc xá</a></h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col post-item" data-animate="fadeInRight" data-animated="true">
                                                <div class="col-inner">
                                                    <div class="box box-vertical box-text-bottom box-blog-post has-hover col-inner-box">
                                                        <!--<div class="box-image" style="width:50%;">
                                                            <div class="image-zoom image-cover" style="padding-top:51%;">
                                                                <img loading="lazy" decoding="async" width="300" height="169" src="<?php echo $template_path;?>templates/noiquy.jpg" class="attachment-medium size-medium wp-post-image" alt="" srcset="<?php echo $template_path;?>templates/noiquy.jpg 300w, templates/noiquy.jpg 1024w, templates/noiquy.jpg 768w, templates/noiquy.jpg 1536w, templates/noiquy.jpg 2048w" sizes="(max-width: 300px) 100vw, 300px">  							  							  						</div>
                                                        </div>-->
                                                        <div class="box-text text-left">
                                                            <div class="box-text-inner blog-post-inner">
                                                                <h5 class="post-title is-large "><a href="#" class="youtube-id" data-id="9tM68iMoxTE">Hành Trình
                                                                        của con luôn có Baba và mama</a></h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col post-item" data-animate="fadeInRight" data-animated="true">
                                                <div class="col-inner">
                                                    <div class="box box-vertical box-text-bottom box-blog-post has-hover col-inner-box">
                                                        <!--<div class="box-image" style="width:50%;">
                                                            <div class="image-zoom image-cover" style="padding-top:51%;">
                                                                <img loading="lazy" decoding="async" width="300" height="169" src="<?php echo $template_path;?>templates/noiquy.jpg" class="attachment-medium size-medium wp-post-image" alt="" srcset="<?php echo $template_path;?>templates/noiquy.jpg 300w, templates/noiquy.jpg 1024w, templates/noiquy.jpg 768w, templates/noiquy.jpg 1536w, templates/noiquy.jpg 2048w" sizes="(max-width: 300px) 100vw, 300px">  							  							  						</div>
                                                        </div>-->
                                                        <div class="box-text text-left">
                                                            <div class="box-text-inner blog-post-inner">
                                                                <h5 class="post-title is-large "><a href="#" class="youtube-id" data-id="9tM68iMoxTE">Học tập làm
                                                                        theo tấm gương Đạo đức Hồ chí Minh</a></h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col post-item" data-animate="fadeInRight" data-animated="true">
                                                <div class="col-inner">
                                                    <div class="box box-vertical box-text-bottom box-blog-post has-hover col-inner-box">
                                                        <!--<div class="box-image" style="width:50%;">
                                                            <div class="image-zoom image-cover" style="padding-top:51%;">
                                                                <img loading="lazy" decoding="async" width="300" height="169" src="<?php echo $template_path;?>templates/noiquy.jpg" class="attachment-medium size-medium wp-post-image" alt="" srcset="<?php echo $template_path;?>templates/noiquy.jpg 300w, templates/noiquy.jpg 1024w, templates/noiquy.jpg 768w, templates/noiquy.jpg 1536w, templates/noiquy.jpg 2048w" sizes="(max-width: 300px) 100vw, 300px">  							  							  						</div>
                                                        </div>-->
                                                        <div class="box-text text-left">
                                                            <div class="box-text-inner blog-post-inner">
                                                                <h5 class="post-title is-large "><a href="#" class="youtube-id" data-id="9tM68iMoxTE">Thông tin
                                                                        cần biết để phòng chống bệnh viêm phổi do virus
                                                                        nCoV</a></h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="g-block size-50">
                    <div class="tieu-diem">
                        <div class="g-block size-100">
                            <div id="jlheading-3362-particle" class="g-content g-particle news-title-box">
                                <div class="jlheading-3361 tm-secondary-font">
                                    <h3 class="news-title tm-title jl-margin-remove-bottom jl-text-bold jl-h2 jl-panel">
                                        Tiêu điểm <span class="title-red"> Nổi bật</span></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="g-block size-100 nopaddingtop nopaddingbottom">
                            <div class="row" id="row-876782046">
                                <div id="col-152373325" class="col pb-0 small-12 large-12">
                                    <style>
                                        #col-152373325 > .col-inner {
                                            padding: 27px 0px 0px 0px;
                                        }

                                        @media (min-width: 550px) {
                                            #col-152373325 > .col-inner {
                                                padding: 20px 0px 0px 0px;
                                            }
                                        }
                                    </style>
                                </div>
                                <div id="col-1979035021" class="col pb-0 medium-6 small-12 large-6">
                                    <div class="col-inner">
                                        <div class="row large-columns-1 medium-columns-1 small-columns-1">
                                            <div class="col post-item" data-animate="fadeInLeft" data-animated="true">
                                                <div class="col-inner">
                                                    <div class="box box-normal box-text-bottom box-blog-post has-hover">
                                                        <div class="box-image">
                                                            <div class="image-zoom image-cover" style="">
                                                                <img loading="lazy" decoding="async" width="1020"
                                                                     height="680" src="<?php echo $template_path;?>templates/sotay_cssk.jpg"
                                                                     class="attachment-large size-large wp-post-image"
                                                                     alt=""
                                                                     srcset="<?php echo $template_path;?>templates/sotay_cssk.jpg 1024w, templates/sotay_cssk.jpg 300w, templates/sotay_cssk.jpg 768w, templates/sotay_cssk.jpg 1200w"
                                                                     sizes="(max-width: 1020px) 100vw, 1020px"></div>
                                                        </div>
                                                        <div class="box-text text-left">
                                                            <div class="box-text-inner blog-post-inner">
                                                                <h5 class="post-title is-large post-title-main "><a
                                                                            href="#">Ra mắt sổ tay "Chăm sóc sức khỏe tinh
                                                                        thần cho sinh viên"</a></h5>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="col-1655344358" class="col pb-0 medium-6 small-12 large-6">
                                    <div class="col-inner">
                                        <div class="row large-columns-1 medium-columns-1 small-columns-1">
                                            <div class="col post-item" data-animate="fadeInRight" data-animated="true">
                                                <div class="col-inner">
                                                    <div class="box box-vertical box-text-bottom box-blog-post has-hover col-inner-box">
                                                        <!--<div class="box-image" style="width:50%;">
                                                            <div class="image-zoom image-cover" style="padding-top:51%;">
                                                                <img loading="lazy" decoding="async" width="300" height="169" src="<?php echo $template_path;?>templates/chienluocdhqg.jpg" class="attachment-medium size-medium wp-post-image" alt="" srcset="<?php echo $template_path;?>templates/chienluocdhqg.jpg 300w, templates/chienluocdhqg.jpg 1024w, templates/chienluocdhqg.jpg 768w, templates/chienluocdhqg.jpg 1536w, templates/chienluocdhqg.jpg 2048w" sizes="(max-width: 300px) 100vw, 300px">  							  							  						</div>
                                                        </div>-->
                                                        <div class="box-text text-left">
                                                            <div class="box-text-inner blog-post-inner">
                                                                <h5 class="post-title is-large "><a href="#">Chiến lược
                                                                        phát triển ĐHQG-HCM giai đoạn 2021-2030, tầm nhìn
                                                                        2045</a></h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col post-item" data-animate="fadeInRight" data-animated="true">
                                                <div class="col-inner">
                                                    <div class="box box-vertical box-text-bottom box-blog-post has-hover col-inner-box">
                                                        <!--<div class="box-image" style="width:50%;">
                                                            <div class="image-zoom image-cover" style="padding-top:51%;">
                                                                <img loading="lazy" decoding="async" width="300" height="169" src="<?php echo $template_path;?>templates/camnang2023.jpg" class="attachment-medium size-medium wp-post-image" alt="" srcset="<?php echo $template_path;?>templates/camnang2023.jpg 300w, templates/camnang2023.jpg 1024w, templates/camnang2023.jpg 768w, templates/camnang2023.jpg 1536w, templates/camnang2023.jpg 2048w" sizes="(max-width: 300px) 100vw, 300px">  							  							  						</div>
                                                        </div>-->
                                                        <div class="box-text text-left">
                                                            <div class="box-text-inner blog-post-inner">
                                                                <h5 class="post-title is-large "><a href="#">Cẩm nang
                                                                        sinh viên nội trú năm học 2023-2024</a></h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col post-item" data-animate="fadeInRight" data-animated="true">
                                                <div class="col-inner">
                                                    <div class="box box-vertical box-text-bottom box-blog-post has-hover col-inner-box">
                                                        <!--<div class="box-image" style="width:50%;">
                                                            <div class="image-zoom image-cover" style="padding-top:51%;">
                                                                <img loading="lazy" decoding="async" width="300" height="169" src="<?php echo $template_path;?>templates/noiquy.jpg" class="attachment-medium size-medium wp-post-image" alt="" srcset="<?php echo $template_path;?>templates/noiquy.jpg 300w, templates/noiquy.jpg 1024w, templates/noiquy.jpg 768w, templates/noiquy.jpg 1536w, templates/noiquy.jpg 2048w" sizes="(max-width: 300px) 100vw, 300px">  							  							  						</div>
                                                        </div>-->
                                                        <div class="box-text text-left">
                                                            <div class="box-text-inner blog-post-inner">
                                                                <h5 class="post-title is-large "><a href="#">Nội quy ký
                                                                        túc xá</a></h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col post-item" data-animate="fadeInRight" data-animated="true">
                                                <div class="col-inner">
                                                    <div class="box box-vertical box-text-bottom box-blog-post has-hover col-inner-box">
                                                        <!--<div class="box-image" style="width:50%;">
                                                            <div class="image-zoom image-cover" style="padding-top:51%;">
                                                                <img loading="lazy" decoding="async" width="300" height="169" src="<?php echo $template_path;?>templates/noiquy.jpg" class="attachment-medium size-medium wp-post-image" alt="" srcset="<?php echo $template_path;?>templates/noiquy.jpg 300w, templates/noiquy.jpg 1024w, templates/noiquy.jpg 768w, templates/noiquy.jpg 1536w, templates/noiquy.jpg 2048w" sizes="(max-width: 300px) 100vw, 300px">  							  							  						</div>
                                                        </div>-->
                                                        <div class="box-text text-left">
                                                            <div class="box-text-inner blog-post-inner">
                                                                <h5 class="post-title is-large "><a href="#">Hành Trình
                                                                        của con luôn có Baba và mama</a></h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col post-item" data-animate="fadeInRight" data-animated="true">
                                                <div class="col-inner">
                                                    <div class="box box-vertical box-text-bottom box-blog-post has-hover col-inner-box">
                                                        <!--<div class="box-image" style="width:50%;">
                                                            <div class="image-zoom image-cover" style="padding-top:51%;">
                                                                <img loading="lazy" decoding="async" width="300" height="169" src="<?php echo $template_path;?>templates/noiquy.jpg" class="attachment-medium size-medium wp-post-image" alt="" srcset="<?php echo $template_path;?>templates/noiquy.jpg 300w, templates/noiquy.jpg 1024w, templates/noiquy.jpg 768w, templates/noiquy.jpg 1536w, templates/noiquy.jpg 2048w" sizes="(max-width: 300px) 100vw, 300px">  							  							  						</div>
                                                        </div>-->
                                                        <div class="box-text text-left">
                                                            <div class="box-text-inner blog-post-inner">
                                                                <h5 class="post-title is-large "><a href="#">Học tập làm
                                                                        theo tấm gương Đạo đức Hồ chí Minh</a></h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col post-item" data-animate="fadeInRight" data-animated="true">
                                                <div class="col-inner">
                                                    <div class="box box-vertical box-text-bottom box-blog-post has-hover col-inner-box">
                                                        <!--<div class="box-image" style="width:50%;">
                                                            <div class="image-zoom image-cover" style="padding-top:51%;">
                                                                <img loading="lazy" decoding="async" width="300" height="169" src="<?php echo $template_path;?>templates/noiquy.jpg" class="attachment-medium size-medium wp-post-image" alt="" srcset="<?php echo $template_path;?>templates/noiquy.jpg 300w, templates/noiquy.jpg 1024w, templates/noiquy.jpg 768w, templates/noiquy.jpg 1536w, templates/noiquy.jpg 2048w" sizes="(max-width: 300px) 100vw, 300px">  							  							  						</div>
                                                        </div>-->
                                                        <div class="box-text text-left">
                                                            <div class="box-text-inner blog-post-inner">
                                                                <h5 class="post-title is-large "><a href="#">Thông tin
                                                                        cần biết để phòng chống bệnh viêm phổi do virus
                                                                        nCoV</a></h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- End video -->

    <section id="g-event-comming" class="jl-section-xsmall">
        <div class="jl-container">
            <div class="g-grid">
                <div class="g-block size-60">
                    <div id="jlheading-3362-particle" class="g-content g-particle news-title-box">
                        <div class="jlheading-3361 tm-secondary-font">
                            <h3 class="news-title tm-title jl-margin-remove-bottom jl-text-bold jl-h2">Sự kiện <span
                                        class="title-red"> sắp diễn ra</span></h3>
                        </div>
                    </div>
                </div>
                <div class="g-block size-40">
                    <div class="spacer"></div>
                </div>
            </div>
            <div class="g-grid">
                <div class="g-block size-100 nopaddingtop nopaddingbottom">
                    <div class="row" id="row-876782046">
                        <div id="col-152373325" class="col pb-0 small-12 large-12">
                            <style>
                                #col-152373325 > .col-inner {
                                    padding: 27px 0px 0px 0px;
                                }

                                @media (min-width: 550px) {
                                    #col-152373325 > .col-inner {
                                        padding: 20px 0px 0px 0px;
                                    }
                                }
                            </style>
                        </div>
                        <div id="col-1979035021" class="col pb-0 medium-6 small-12 large-6">
                            <div class="col-inner">
                                <div class="row large-columns-1 medium-columns-1 small-columns-1">
                                    <div class="col post-item" data-animate="fadeInLeft" data-animated="true">
                                        <div class="col-inner">
                                            <div class="box box-normal box-text-bottom box-blog-post has-hover">
                                                <div class="box-image">
                                                    <div class="image-zoom image-cover" style="padding-top:63%;">
                                                        <img loading="lazy" decoding="async" width="1020" height="680"
                                                             src="<?php echo $template_path;?>templates/event-1024x683.jpg"
                                                             class="attachment-large size-large wp-post-image" alt=""
                                                             srcset="<?php echo $template_path;?>templates/event-1024x683.jpg 1024w, templates/event-1024x683.jpg 300w, templates/event-1024x683.jpg 768w, templates/event-1024x683.jpg 1200w"
                                                             sizes="(max-width: 1020px) 100vw, 1020px"></div>
                                                </div>
                                                <div class="box-text text-left">
                                                    <div class="box-text-inner blog-post-inner">
                                                        <h5 class="post-title is-large post-title-main ">Ngày hội tân
                                                            sinh viên – School Fest 2024, gieo ước mơ và hy vọng</h5>
                                                        <div class="is-divider"></div>
                                                        <!--<p class="from_the_blog_excerpt ">NTTU – Hội đồng tuyển sinh Trường ĐH Nguyễn Tất Thành (NTTU) vừa công bố đề án tuyển sinh dự kiến năm 2024 với khoảng 10.000 chỉ...		</p>
                                                        -->
                                                        <div class="post-meta post-meta-primary">Thời gian diễn ra:
                                                            25/05/2024
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="col-1655344358" class="col pb-0 medium-6 small-12 large-6">
                            <div class="col-inner">
                                <div class="row large-columns-1 medium-columns-1 small-columns-1">
                                    <div class="col post-item" data-animate="fadeInRight" data-animated="true">
                                        <div class="col-inner">
                                            <div class="box box-vertical box-text-bottom box-blog-post has-hover col-inner-box">
                                                <div class="box-image" style="width:50%;">
                                                    <div class="image-zoom image-cover" style="padding-top:51%;">
                                                        <img loading="lazy" decoding="async" width="300" height="169"
                                                             src="<?php echo $template_path;?>templates/event_2-1024x683.jpg"
                                                             class="attachment-medium size-medium wp-post-image" alt=""
                                                             srcset="<?php echo $template_path;?>templates/event_2-1024x683.jpg 300w, templates/event_2-1024x683.jpg 1024w, templates/event_2-1024x683.jpg 768w, templates/event_2-1024x683.jpg 1536w, templates/event_2-1024x683.jpg 2048w"
                                                             sizes="(max-width: 300px) 100vw, 300px"></div>
                                                </div>
                                                <div class="box-text text-left">
                                                    <div class="box-text-inner blog-post-inner">
                                                        <h5 class="post-title is-large ">Khai mạc hội thao sinh viên Ký
                                                            túc xá ĐHQG-HCM năm 2024</h5>
                                                        <div class="is-divider"></div>
                                                        <div class="post-meta">Thời gian diễn ra: 19/05/2024</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col post-item" data-animate="fadeInRight" data-animated="true">
                                        <div class="col-inner">
                                            <div class="box box-vertical box-text-bottom box-blog-post has-hover col-inner-box">
                                                <div class="box-image" style="width:50%;">
                                                    <div class="image-zoom image-cover" style="padding-top:51%;">
                                                        <img loading="lazy" decoding="async" width="300" height="169"
                                                             src="<?php echo $template_path;?>templates/event_3-1024x683.jpg"
                                                             class="attachment-medium size-medium wp-post-image" alt=""
                                                             srcset="<?php echo $template_path;?>templates/event_3-1024x683.jpg 300w, templates/event_3-1024x683.jpg 1024w, templates/event_3-1024x683.jpg 768w, templates/event_3-1024x683.jpg 1536w, templates/event_3-1024x683.jpg 2048w"
                                                             sizes="(max-width: 300px) 100vw, 300px"></div>
                                                </div>
                                                <div class="box-text text-left">
                                                    <div class="box-text-inner blog-post-inner">
                                                        <h5 class="post-title is-large ">"Hành trình mùa xuân” - đưa
                                                            sinh viên Đại học Quốc gia TPHCM về quê đón Tết</h5>
                                                        <div class="is-divider"></div>
                                                        <div class="post-meta">Thời gian diễn ra: 30/01/2024</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col post-item" data-animate="fadeInRight" data-animated="true">
                                        <div class="col-inner">
                                            <div class="box box-vertical box-text-bottom box-blog-post has-hover col-inner-box">
                                                <div class="box-image" style="width:50%;">
                                                    <div class="image-zoom image-cover" style="padding-top:51%;">
                                                        <img loading="lazy" decoding="async" width="300" height="169"
                                                             src="<?php echo $template_path;?>templates/event_4-1024x683.jpg"
                                                             class="attachment-medium size-medium wp-post-image" alt=""
                                                             srcset="<?php echo $template_path;?>templates/event_4-1024x683.jpg 300w, templates/event_4-1024x683.jpg 1024w, templates/event_4-1024x683.jpg 768w, templates/event_4-1024x683.jpg 1536w, templates/event_4-1024x683.jpg 2048w"
                                                             sizes="(max-width: 300px) 100vw, 300px"></div>
                                                </div>
                                                <div class="box-text text-left">
                                                    <div class="box-text-inner blog-post-inner">
                                                        <h5 class="post-title is-large ">Ngày Quốc tế thiếu nhi
                                                            01/06</h5>
                                                        <div class="is-divider"></div>
                                                        <div class="post-meta">Thời gian diễn ra: 01/06/2024</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section id="g-feature" class="jl-section">
        <div class="jl-container">
            <div class="g-grid">
                <div class="g-block size-55">
                    <div id="jltestimonial2-9942-particle" class="g-content g-particle student-review-box">
                        <div id="jltestimonial2-9942" class="jltestimonial2-9942 jl-slider-container-offset"
                             jl-slider="autoplay: 1;">
                            <div class="jl-position-relative jl-visible-toggle" tabindex="-1">
                                <ul class="jl-slider-items jl-grid">
                                    <li class="tm-testimonial jl-width-1-1 jl-width-1-1@m">
                                        <div class="inner-wrapper">
                                            <div class="jl-card jl-card-default jl-card-body jl-margin-remove-first-child">
                                                <div class="tm-content jl-panel jl-margin-top">
                                                    <blockquote>“Outstanding job and exceeded all expectations. It was a
                                                        pleasure to work with them on a sizable first project and am
                                                        looking forward to start the next one asap.”
                                                    </blockquote>
                                                </div>
                                                <div class="jl-child-width-expand jl-flex-middle" jl-grid>
                                                    <div class="jl-width-auto">
                                                        <div class="tm-author-container jl-text-center">
                                                            <div class="author-image">
                                                                <img src="<?php echo $template_path;?>templates/jl_double_pro/custom/images/lead/reviews/avatar-brian-newton.jpg"
                                                                     width="90" height="90" loading="lazy"
                                                                     class="tm-image jl-margin-top jl-border-circle"
                                                                     alt="">
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="student-name">
                                                        <div class="item-inner jl-margin-remove-first-child">
                                                            <h3 class="tm-title jl-margin-remove-bottom jl-text-uppercase jl-margin-top jl-h5">
                                                                Brian Newton

                                                            </h3>

                                                            <div class="tm-meta jl-margin-small-top jl-text-meta">
                                                                Mina Inc.
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
                                    <li class="tm-testimonial jl-width-1-1 jl-width-1-1@m">
                                        <div class="inner-wrapper">
                                            <div class="jl-card jl-card-default jl-card-body jl-margin-remove-first-child">
                                                <div class="tm-content jl-panel jl-margin-top">
                                                    <blockquote>“Outstanding job and exceeded all expectations. It was a
                                                        pleasure to work with them on a sizable first project and am
                                                        looking forward to start the next one asap.”
                                                    </blockquote>
                                                </div>
                                                <div class="jl-child-width-expand jl-flex-middle" jl-grid>
                                                    <div class="jl-width-auto">
                                                        <div class="tm-author-container jl-text-center">
                                                            <div class="author-image">
                                                                <img src="<?php echo $template_path;?>templates/jl_double_pro/custom/images/lead/reviews/avatar-brian-newton.jpg"
                                                                     width="90" height="90" loading="lazy"
                                                                     class="tm-image jl-margin-top jl-border-circle"
                                                                     alt="">
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="student-name">
                                                        <div class="item-inner jl-margin-remove-first-child">
                                                            <h3 class="tm-title jl-margin-remove-bottom jl-text-uppercase jl-margin-top jl-h5">
                                                                Brian Newton

                                                            </h3>
                                                            <div class="tm-meta jl-margin-small-top jl-text-meta">
                                                                Mina Inc.
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
                                    <li class="tm-testimonial jl-width-1-1 jl-width-1-1@m">
                                        <div class="inner-wrapper">
                                            <div class="jl-card jl-card-default jl-card-body jl-margin-remove-first-child">
                                                <div class="tm-content jl-panel jl-margin-top">
                                                    <blockquote>“Outstanding job and exceeded all expectations. It was a
                                                        pleasure to work with them on a sizable first project and am
                                                        looking forward to start the next one asap.”
                                                    </blockquote>
                                                </div>
                                                <div class="jl-child-width-expand jl-flex-middle" jl-grid>
                                                    <div class="jl-width-auto">
                                                        <div class="tm-author-container jl-text-center">
                                                            <div class="author-image">
                                                                <img src="<?php echo $template_path;?>templates/jl_double_pro/custom/images/lead/reviews/avatar-june-oliver.jpg"
                                                                     width="90" height="90" loading="lazy"
                                                                     class="tm-image jl-margin-top jl-border-circle"
                                                                     alt="">
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="student-name">
                                                        <div class="item-inner jl-margin-remove-first-child">
                                                            <h3 class="tm-title jl-margin-remove-bottom jl-text-uppercase jl-margin-top jl-h5">
                                                                June Oliver

                                                            </h3>

                                                            <div class="tm-meta jl-margin-small-top jl-text-meta">
                                                                UnSlash Inc.
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
                                    <li class="tm-item jl-width-1-2 jl-width-1-3@s jl-width-1-5@m">
                                        <div class="jl-cover-container">
                                            <a href="#" target="_blank"><img
                                                        src="<?php echo $template_path;?>templates/jl_double_pro/custom/images/lead/clients/logo1.png"
                                                        width="500" height="333" class="tm-image jl-transition-opaque"
                                                        alt=""
                                                        loading="lazy"></a>
                                        </div>
                                    </li>
                                    <li class="tm-item jl-width-1-2 jl-width-1-3@s jl-width-1-5@m">
                                        <div class="jl-cover-container">
                                            <a href="#" target="_blank"><img
                                                        src="<?php echo $template_path;?>templates/jl_double_pro/custom/images/lead/clients/logo2.jpg"
                                                        width="500" height="333" class="tm-image jl-transition-opaque"
                                                        alt=""
                                                        loading="lazy"></a>
                                        </div>
                                    </li>


                                    <li class="tm-item jl-width-1-2 jl-width-1-3@s jl-width-1-5@m">


                                        <div class="jl-cover-container">

                                            <a href="#" target="_blank"><img
                                                        src="<?php echo $template_path;?>templates/jl_double_pro/custom/images/lead/clients/logo3.png"
                                                        width="500" height="333" class="tm-image jl-transition-opaque"
                                                        alt=""
                                                        loading="lazy"></a>


                                        </div>


                                    </li>


                                    <li class="tm-item jl-width-1-2 jl-width-1-3@s jl-width-1-5@m">


                                        <div class="jl-cover-container">

                                            <a href="#" target="_blank"><img
                                                        src="<?php echo $template_path;?>templates/jl_double_pro/custom/images/lead/clients/logo4.jpg"
                                                        width="500" height="333" class="tm-image jl-transition-opaque"
                                                        alt=""
                                                        loading="lazy"></a>


                                        </div>


                                    </li>


                                    <li class="tm-item jl-width-1-2 jl-width-1-3@s jl-width-1-5@m">


                                        <div class="jl-cover-container">

                                            <a href="#" target="_blank"><img
                                                        src="<?php echo $template_path;?>templates/jl_double_pro/custom/images/lead/clients/logo1.png"
                                                        width="500" height="333" class="tm-image jl-transition-opaque"
                                                        alt=""
                                                        loading="lazy"></a>


                                        </div>


                                    </li>


                                    <li class="tm-item jl-width-1-2 jl-width-1-3@s jl-width-1-5@m">


                                        <div class="jl-cover-container">

                                            <a href="#" target="_blank"><img
                                                        src="<?php echo $template_path;?>templates/jl_double_pro/custom/images/lead/clients/logo3.png"
                                                        width="500" height="333" class="tm-image jl-transition-opaque"
                                                        alt=""
                                                        loading="lazy"></a>


                                        </div>


                                    </li>


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

    <section id="g-bottom" class="jl-s">
        <div class="jl-container viewmap">
            <div class="grid">
                <div class="jl-child-width-1-1 jl-child-width-1-1@s jl-child-width-1-2@m jl-grid-small jl-flex-center jl-flex-middle"
                     jl-grid>
                    <div class="g-block size-40 address-box">
                        <div class="tm-content">
                            <h3 class="tm-title jl-h2">Campus</h3>
                            <p class="address-link"><i class='fas fa-map-marker-alt'
                                                       style='font-size:18px;color:red'></i><strong> KTX KHU A:</strong>
                                Tạ Quang Bửu, Khu phố 6, Phường Linh Trung, Thành phố Thủ Đức, Thành phố Hồ Chí Minh.
                            </p>
                            <p class="address-link"><i class='fas fa-map-marker-alt'
                                                       style='font-size:18px;color:red'></i><strong> KTX KHU B:</strong>
                                Mạc Đĩnh Chi, Khu phố Tân Hòa, Phường Đông Hòa, Dĩ An, Bình Dương.</p>
                        </div>
                    </div>
                    <div class="g-block size-60 mapBox">
                        <div id="map">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1107.4266119202873!2d106.77893476862384!3d10.885477839879023!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x737ea1596a22dec5!2zMTDCsDUzJzA4LjAiTiAxMDbCsDQ2JzQ2LjMiRQ!5e0!3m2!1svi!2s!4v1649922948228!5m2!1svi!2s"
                                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer id="g-footer" class="jl-section nopaddingbottom jl-s">
        <div class="jl-container">
            <div class="g-grid">
                <div class="jl-child-width-1-1 jl-child-width-1-2@s jl-child-width-1-4@m jl-grid-small jl-flex-center jl-flex-middle"
                     jl-grid>
                    <div class="g-block size-25">
                        <div id="jlfooterinfo-7949-particle" class="g-content g-particle">
                            <div id="jlfooterinfo-7949" class="jlfooterinfo-7949">
                                <div class="tm-content jl-panel jl-margin-remove-top">
                                    <h3 class="g5-title jl-text-emphasis jl-h3 jl-text-uppercase">Thông tin liên hệ</h3>
                                    <p><i class="fas fa-map-marker-alt"></i> <strong>Địa chỉ:</strong> Đường Tạ Quang
                                        Bửu, Khu phố 6, Phường Linh Trung, Thành phố Thủ Đức, Thành phố Hồ Chí Minh.</p>
                                    <p class="g-footer-phone"><i class="fas fa-phone-volume"></i> <strong>Điện
                                            thoại:</strong> <a href="tel:1900.055.559"> 1900.055.559</a></p>
                                    <p class="g-footer-email"><i class="far fa-envelope"></i> <strong>Email:</strong> <a
                                                href="mailto:ktx@vnuhcm.edu.vn">ktx@vnuhcm.edu.vn</a> hoặc <a
                                                href="mailto:ktx@vnuhcm.edu.vn">info@ktxhcm.edu.vn</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="g-block  size-25">
                        <div id="jllist-3285-particle" class="g-content g-particle jl-panel">
                            <h3 class="g5-title jl-h3 jl-text-uppercase">Giới thiệu</h3>
                            <div class="jllist-3285">
                                <ul class="jl-list">
                                    <li class="tm-item">

                                        <div class="tm-content jl-panel">
                                            <a href="#" jl-scroll>
                                                Về Trung tâm Quản lý Ký túc xá
                                            </a>
                                        </div>
                                    </li>
                                    <li class="tm-item">
                                        <div class="tm-content jl-panel">
                                            <a href="#" jl-scroll>
                                                Về Thanh tra pháp chế
                                            </a>
                                        </div>
                                    </li>
                                    <li class="tm-item">
                                        <div class="tm-content jl-panel">
                                            <a href="#" jl-scroll>
                                                Về nhân sự
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="g-block size-25">
                        <div id="jllist-3285-particle" class="g-content g-particle jl-panel">
                            <h3 class="g5-title jl-h3 jl-text-uppercase">Đơn vị trực thuộc</h3>
                            <div class="jllist-3285">
                                <ul class="jl-list">
                                    <li class="tm-item">
                                        <div class="tm-content jl-panel">
                                            <a href="#" jl-scroll>
                                                Phòng Tổng hợp
                                            </a>
                                        </div>
                                    </li>
                                    <li class="tm-item">
                                        <div class="tm-content jl-panel">
                                            <a href="#" jl-scroll>
                                                Phòng Công nghệ thông tin - Dữ liệu
                                            </a>
                                        </div>
                                    </li>
                                    <li class="tm-item">
                                        <div class="tm-content jl-panel">
                                            <a href="#" jl-scroll>
                                                Phòng Dịch vụ - Dự án
                                            </a>
                                        </div>
                                    </li>
                                    <li class="tm-item">
                                        <div class="tm-content jl-panel">
                                            <a href="#" jl-scroll>
                                                Phòng Công tác Sinh viên
                                            </a>
                                        </div>
                                    </li>
                                    <li class="tm-item">
                                        <div class="tm-content jl-panel">
                                            <a href="#" jl-scroll>
                                                Phòng Kế hoạch - Tài chính
                                            </a>
                                        </div>
                                    </li>
                                    <li class="tm-item">
                                        <div class="tm-content jl-panel">
                                            <a href="#" jl-scroll>
                                                Phòng Quản trị - Thiết bị
                                            </a>
                                        </div>
                                    </li>
                                    <li class="tm-item">
                                        <div class="tm-content jl-panel">
                                            <a href="#" jl-scroll>
                                                Trạm Y tế
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="g-block size-25">
                        <div id="jllist-3285-particle" class="g-content g-particle jl-panel">
                            <h3 class="g5-title jl-h3 jl-text-uppercase">Đơn vị trực thuộc</h3>
                            <div class="jllist-3285">
                                <ul class="jl-list ">
                                    <li class="tm-item">
                                        <div class="tm-content jl-panel">
                                            <a href="#" jl-scroll>
                                                Ban quản lý Cụm nhà AF
                                            </a>
                                        </div>
                                    </li>
                                    <li class="tm-item">
                                        <div class="tm-content jl-panel">
                                            <a href="#" jl-scroll>
                                                Ban quản lý Cụm nhà AG
                                            </a>
                                        </div>
                                    </li>
                                    <li class="tm-item">
                                        <div class="tm-content jl-panel">
                                            <a href="#" jl-scroll>
                                                Ban quản lý Cụm nhà AH
                                            </a>
                                        </div>
                                    </li>
                                    <li class="tm-item">
                                        <div class="tm-content jl-panel">
                                            <a href="#" jl-scroll>
                                                Ban quản lý Cụm nhà BA
                                            </a>
                                        </div>
                                    </li>
                                    <li class="tm-item">
                                        <div class="tm-content jl-panel">
                                            <a href="#" jl-scroll>
                                                Ban quản lý Cụm nhà BB
                                            </a>
                                        </div>
                                    </li>
                                    <li class="tm-item">
                                        <div class="tm-content jl-panel">
                                            <a href="#" jl-scroll>
                                                Ban quản lý Cụm nhà BC
                                            </a>
                                        </div>
                                    </li>
                                    <li class="tm-item">
                                        <div class="tm-content jl-panel">
                                            <a href="#" jl-scroll>
                                                Ban quản lý Cụm nhà BD
                                            </a>
                                        </div>
                                    </li>
                                    <li class="tm-item">
                                        <div class="tm-content jl-panel">
                                            <a href="#" jl-scroll>
                                                Ban quản lý Cụm nhà BE
                                            </a>
                                        </div>
                                    </li>
                                    <li class="tm-item recruitment">
                                        <div class="tm-content jl-panel" style="padding-left: 0px;">
                                            <a href="#" jl-scroll>
                                                Tuyển dụng <i class="fas fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </li>
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

    <section id="g-copyright">
        <div class="jl-container">
            <div class="g-grid">

                <div class="g-block size-50">
                    <div id="branding-2132-particle" class="g-content g-particle">
                        <div class="g-branding ">
                            Bản quyền© 2024 Trung tâm Quản lý Ký túc xá. <br/>
                            Thiết kế và xây dựng bởi Phòng Công nghệ thông tin - Dữ liệu.
                        </div>
                    </div>
                </div>

                <div class="g-block size-50">
                    <div id="social-9948-particle" class="g-content g-particle social-link">
                        <div class="el-social square-icon jl-text-right@m jl-text-right@s  jl-text-right">
                            <div class="jl-child-width-auto jl-grid-small jl-flex-inline jl-grid" jl-grid>
                                <div class="note-social-text">Theo dõi chúng tôi trên:</div>
                                <div>
                                    <a href="https://www.facebook.com/JoomLead" title="Facebook" aria-label="Facebook">
                                        <span class="fab fa-facebook-f"></span> <span
                                                class="g-social-text"></span> </a>
                                </div>
                                <div>
                                    <a href="http://www.twitter.com/joomlead" title="Twitter" aria-label="">
                                        <span class="fab fa-twitter"></span> <span class="g-social-text"></span>
                                    </a>
                                </div>
                                <div>
                                    <a href="#" title="Github" aria-label="Github">
                                        <span class="fab fa-github"></span> <span class="g-social-text"></span>
                                    </a>
                                </div>
                                <div>
                                    <a href="#" title="Linkedin" aria-label="Linkedin">
                                        <span class="fab fa-linkedin-in"></span> <span
                                                class="g-social-text"></span> </a>
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
            <iframe id="youtube-video" width="640" height="360" src="" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
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


<!--<script type="text/javascript"
        src="//maps.google.com/maps/api/js?key=AIzaSyCmCmdHIiIjJd8rnkRzTAF2mpOBcNJwXis"></script>-->
<!----Maps--->
<script type="text/javascript">

    // script.js
    document.addEventListener('DOMContentLoaded', function() {
        var openPopupBtn = document.getElementById('open-popup');
        var popup = document.getElementById('video-popup');
        var closeBtn = document.querySelector('.close-btn');
        var iframe = document.getElementById('youtube-video');
        var linkElement = document.querySelector('.youtube-id');

        // Loop through each element and add an event listener
        /* linkElement.addEventListener('click', function() {
                 var videoId = this.getAttribute('data-id');
             var videoUrl = 'https://www.youtube.com/embed/' + videoId + '?autoplay=1';
             });*/
        var videoId  = '9tM68iMoxTE';
        var videoUrl = 'https://www.youtube.com/embed/' + videoId + '?autoplay=1';

        //var videoId = '9tM68iMoxTE'; // Replace YOUR_VIDEO_ID with the actual video ID


        openPopupBtn.addEventListener('click', function() {
            iframe.src = videoUrl;
            popup.style.display = 'block';
        });

        closeBtn.addEventListener('click', function() {
            popup.style.display = 'none';
            iframe.src = '';
        });

        // Close the popup when clicking outside the content
        window.addEventListener('click', function(event) {
            if (event.target == popup) {
                popup.style.display = 'none';
                iframe.src = ''; // Stop the video when popup is closed
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

