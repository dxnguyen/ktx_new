<?php
    /**
     * @version     1.0.0
     * @package     mod_news_1.0.0_j4x
     * @copyright   Copyright (C) 2024. All rights reserved.
     * @license     GNU General Public License version 2 or later; see LICENSE.txt
     * @author      nguyen dinh <vb.dinhxuannguyen@gmail.com> - https://componentgenerator.com
     */

//No direct access
    defined('_JEXEC') or die('Restricted access');

    use Joomla\CMS\Router\Route;
    use Joomla\CMS\Uri\Uri;
    use Joomla\Component\Content\Administrator\Extension\ContentComponent;
    use Joomla\Component\Content\Site\Helper\RouteHelper;

?>
<?php if ($list) : ?>
    <!-- News -->
    <section id="g-above" class="jl-section-xsmall">
        <div class="jl-container">
            <div class="g-grid">
                <div class="g-block size-60">
                    <div id="jlheading-3361-particle" class="g-content g-particle news-title-box">
                        <div class="jlheading-3361 tm-secondary-font">
                            <h3 class="news-title tm-title jl-margin-remove-bottom jl-text-bold jl-h2"><a href="#">Tin
                                    tức -
                                    <span class="title-red">Sự kiện</span></a></h3>
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
                                <?php foreach ($list as $item) : ?>
                                    <li jl-filter-control="[data-tag~='<?php echo $item[0]->cat_alias; ?>']">
                                        <a href><?php echo $item[0]->cat_title; ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>

                            <div class="js-jlfiltergallery-1072 jl-child-width-1-1 jl-child-width-1-2@s jl-child-width-1-3@m"
                                 jl-grid="masonry: pack;" jl-lightbox="toggle: a[data-type]"
                                 jl-scrollspy="target: [jl-scrollspy-class]; cls: jl-animation-slide-bottom-small; delay: false;">

                                <?php foreach ($list as $key => $item) :
                                    if ($item) :
                                        foreach ($item as $value) :
                                            $images = json_decode($value->images);
                                            $slug = $value->id . ':' . $value->alias;
                                            $articleUrl = new Uri(Route::_(RouteHelper::getArticleRoute($value->id, $key), false));
                                            //$link = Route::_('index.php?option=com_content&view=article&catid='.$key.'&Itemid=119&id='.$value->id);
                                            ?>
                                            <div data-tag="<?php echo $item[0]->cat_alias; ?>">
                                                <a class="tm-item jl-inline-clip jl-transition-toggle jl-link-toggle"
                                                   href="<?php echo htmlspecialchars($articleUrl, ENT_QUOTES, 'UTF-8'); ?>" itemprop="url"
                                                   target="" title="<?php echo $value->title; ?>"
                                                   aria-label="Improve Startup" jl-scrollspy-class>
                                                    <img src="<?php echo $images->image_intro; ?>" width="1024"
                                                         height="892"
                                                         class="tm-image jl-transition-scale-up jl-transition-opaque"
                                                         alt="" loading="lazy">
                                                    <div class="jl-position-bottom-center jl-position-medium jl-tile-default jl-transition-slide-bottom-small">
                                                        <div class="jl-overlay jl-margin-remove-first-child">
                                                            <h3 class="tm-title jl-margin-remove-bottom jl-h5 jl-margin-top">
                                                                <?php echo $value->title; ?>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        <?php
                                        endforeach;
                                    endif;
                                endforeach;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>