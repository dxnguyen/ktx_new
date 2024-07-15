<?php

    /**
     * @package     Joomla.Site
     * @subpackage  com_content
     *
     * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
     * @license     GNU General Public License version 2 or later; see LICENSE.txt
     */

    defined('_JEXEC') or die;

    use Joomla\CMS\Factory;
    use Joomla\CMS\HTML\HTMLHelper;
    use Joomla\CMS\Language\Text;
    use Joomla\CMS\Layout\FileLayout;
    use Joomla\CMS\Layout\LayoutHelper;

    $app = Factory::getApplication();

    $this->category->text = $this->category->description;
    $app->triggerEvent('onContentPrepare', [$this->category->extension . '.categories', &$this->category, &$this->params, 0]);
    $this->category->description = $this->category->text;

    $results = $app->triggerEvent('onContentAfterTitle', [$this->category->extension . '.categories', &$this->category, &$this->params, 0]);
    $afterDisplayTitle = trim(implode("\n", $results));

    $results = $app->triggerEvent('onContentBeforeDisplay', [$this->category->extension . '.categories', &$this->category, &$this->params, 0]);
    $beforeDisplayContent = trim(implode("\n", $results));

    $results = $app->triggerEvent('onContentAfterDisplay', [$this->category->extension . '.categories', &$this->category, &$this->params, 0]);
    $afterDisplayContent = trim(implode("\n", $results));

    $htag = $this->params->get('show_page_heading') ? 'h2' : 'h1';
?>
<div class="jl-container">
    <div class="g-grid">
        <div class="blog-title"><h2 class="jl-margin-top"><?php echo $this->category->title; ?></h2></div>

        <div id="jlfiltergallery-1072-particle" class="g-content g-particle news-items">
            <div class="js-jlfiltergallery-1072 jl-child-width-1-1 jl-child-width-1-2@s jl-child-width-1-3@m jl-grid jl-flex-top jl-flex-wrap-top"
             jl-grid="masonry: pack;" jl-lightbox="toggle: a[data-type]"
             jl-scrollspy="target: [jl-scrollspy-class]; cls: jl-animation-slide-bottom-small; delay: false;">
            <?php
                foreach ($this->lead_items as $key => &$item) :
                    $this->item = &$item;
                    echo $this->loadTemplate('item');
                endforeach;
            ?>
            <?php
                foreach ($this->intro_items as $key => &$item) :
                    $this->item = &$item;
                    echo $this->loadTemplate('item');
                endforeach;
            ?>
        </div>
        </div>
        <?php if (($this->params->def('show_pagination', 1) == 1 || ($this->params->get('show_pagination') == 2)) && ($this->pagination->pagesTotal > 1)) : ?>
        <div id="" style="width: 100%; clear:both; padding: 10px; text-align: center;">
            <div class="com-content-category-blog__pagination jl-clearfix">
                <?php echo $this->pagination->getPagesLinks(); ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

</div>
</div>
