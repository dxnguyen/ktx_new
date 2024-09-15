<?php
/**
 * Page Speed Optimizer extension
 * https://www.mobilejoomla.com/
 *
 * @version    1.4.2
 * @license    GNU/GPL v2 - http://www.gnu.org/licenses/gpl-2.0.html
 * @copyright  (C) 2022-2024 Denis Ryabov
 * @date       June 2024
 */
defined('_JEXEC') or die('Restricted access');

die(); __halt_compiler();
?>

CHANGELOG

1.4.2 Stable Release
- Fixed processing of query delimiters in Stream and Pharse parsers

1.4.1 Stable Release
- Added Preconnect settings section
- Added JavaScript Modules section to Preloads
- Fixed issue with CSS relocation in Inline CSS for first-time visitors
- Fixed issue with scripts execution order in "Non-blocking JavaScript" mode [Pro]
- Improved detection of width and height for SVG images
- Improved work of native lazy loading
- Minor bugfixes

1.4.0 Stable Release
- Added "Display" options for loading Web Fonts/Google Fonts
- Added error message when installing together with Mobile extension.
- Added initial support for Redis/KeyDB cache [Pro]
- Added "Passive event listeners" option [Pro]
- Fixed issue with JavaScript minification
- Fixed issue with "Link headers" mode for DNS-prefetch
- Fixed work of DNSPrefetch and Preload wizards [Pro]
- Improved caching under heavy load
- Improved work of Non-blocking JavaScript feature
- Improved asynchronous loading of CSS with Critical CSS feature
- Improved work of preload tags generation
- Minor bugfixes/typos

1.3.4 Stable Release
- Added clearing the page cache after global Joomla settings changes.
- Fixed issue with lazy video loading

1.3.3 Stable Release
- Fixed issue with LQIP and native lazy loading of transparent images
- Fixed possible warning message during JS merging

1.3.2 Stable Release
- Added "Depend on HTTP headers" setting for page cache
- Fixed error with reading of invalid WebP files
- Fixed issue with merging of pre-minified CSS files
- Improved javascript merging
- Improved CSS optimization
- Improved loading of external fonts [Pro]
- Performance optimizations

1.3.1 Stable Release
- Added more logging to image processing
- Fixed several possible PHP notices and warnings
- Fixed displaying of subscription status [Pro]

1.3.0 Stable Release
- Added option to fix serving polyfills to modern browsers
- Added optimization of video's poster and input[type=image] images
- Added support of inlining JS/CSS for first-time visitors
- Added support of DOM size reduction [Pro]
- Added option to lazy YouTube loading [Pro]
- Fixed issue with empty @media in optimized CSS
- Fixed clearing pagecache
- Fixed issue with moving of script and link nodes
- Fixed issue with lazy loading of background images [Pro]
- Performance optimizations

1.2.0 Stable Release
- Added Google PageSpeed Insignts score displaying
- Added option to monitor and clear LQIP images cache
- Added detection of width and height for SVG images
- Added Brotli compression for optimized assets
- Added option to disable symlinks usage
- Added support of CDN Domain feature [Pro]
- Added asynchronous Google Fonts loading [Pro]
- Added lazy loading of background images [Pro]
- Added options to skip first lazy load elements [Pro]
- Fixed execution order for defer and module scripts
- Fixed issue with "Preload URLs" feature
- Fixed issue with lazy video loading
- Fixed issue with JavaScript minification
- Fixed page cache clearing
- Fixed incorrect processing of animated APNG images
- Fixed removal of cache directory during uninstall
- Fixed self-hosting of WebP and AVIF images [Pro]
- Performance optimization

1.1.1 Stable Release
- Added generation of data-uri for deferred scripts
- Added several MIME types for Gzip compression via .htaccess
- Fixed PHP8.3 deprecation message
- Fixed Distribute Method's mod_rewrite mode
- Fixed optimization of WebP/AVIF images
- Fixed optimization of scripts excluded from merging
- Disabled "Wrap to try/catch" for single scripts
- Improved merging of stylesheets with @import

1.1.0 Stable Release
- Added support of converting CSS images to next-gen formats
- Added support of self-hosting CSS images [Pro]
- Added support of self-hosting webfonts [Pro]
- Fixed work with active plugin but uninstalled component

1.0.4 Stable Release
- Fixed work of "Logging Level" option
- Fixed work of "Swap Webfonts" option

1.0.3 Stable Release
- Added loading of external images from srcset attribute [Pro]
- Fixed some possible notice-level messages generated by PHP8
- Fixed issue with inserted empty script tag

1.0.2 Stable Release
- Fixed possible error when saving article with pagecache enabled

1.0.1 Stable Release
- Fixed database access in pagecache handler

1.0.0 Stable Release
- Transition from RC to Stable

1.0.rc Release Candidate
- Added support of Joomla 5
- Added Troubleshooting section
- Added support of CLI tools for optimization [Pro]
- Added support of font-display:swap
- Added "Set width/height" settings
- Added separate qualities for JPEG, WebP, and AVIF formats
- Fixed work of tagged page cache
- Fixed DNSPrefetch suggestions popup [Pro]
- Fixed size of LQIP
- Fixed work of background processes during update [Pro]
- Fixed working on servers with symlink disabled
- Fixed processing of noscript tag by DOM HTML parser
- Fixed possible warning message during uninstall and upgrade
- Improved DNSPrefetch and Preloads suggestions [Pro]
- Improved delayed script loading [Pro]

1.0.b6 Beta Release
- Initial public release