<?php
defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;

$module = ModuleHelper::getModule('mod_id');
$dxn = new Dxn();

 ?>
<div class="jl-container item-list">
 <div class="blog-title"><h2 class="jl-text-uppercase jl-margin-top"><?php echo 'Có '. count($this->search). ' kết quả được tìm thấy.'; ?></h2></div>
 <div class="js-jlfiltergallery-1072 jl-child-width-1-1 jl-child-width-1-2@s jl-child-width-1-3@m jl-grid jl-flex-top jl-flex-wrap-top" jl-grid="masonry: pack;" jl-lightbox="toggle: a[data-type]" jl-scrollspy="target: [jl-scrollspy-class]; cls: jl-animation-slide-bottom-small; delay: false;">
  <?php foreach ($this->search as $item) : ?>
   <?php
   $link = Route::_('index.php?option=com_content&view=article&catid='.$item->catid.'&id='.$item->id);
   $imgs = json_decode($item->images);
   ?>

   <div data-tag="hoat-dong" class="jl-first-column" style="transform: translate(0px, 0px);">
    <a class="tm-item jl-inline-clip jl-transition-toggle jl-link-toggle jl-scrollspy-inview" href="<?php echo $link;?>" title="<?php echo $item->title;?>" aria-label="Improve Startup" jl-scrollspy-class="" style="">
     <img src="<?php echo $imgs->image_intro;?>" width="1024" height="892" class="tm-image jl-transition-scale-up jl-transition-opaque" alt="" loading="lazy">
     <div class="jl-position-bottom-center jl-position-medium jl-tile-default jl-transition-slide-bottom-small">
      <div class="jl-overlay jl-margin-remove-first-child">
       <h3 class="tm-title jl-margin-remove-bottom jl-h5 jl-margin-top"><?php echo $item->title;?></h3>
      </div>
     </div>
    </a>
   </div>

  <?php endforeach; ?>

  <div id="" style="width: 100%; clear:both; padding: 10px; text-align: center;">
   <div class="com-content-category-blog__pagination jl-clearfix">
    <?php echo $this->pagination->getPagesLinks();?>
   </div>
  </div>
 </div>
</div>