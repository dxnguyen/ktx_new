<?php
    /**
     * @version    CVS: 1.0.0
     * @package    com_homepage
     * @author     Nguyen Dinh <vb.dinhxuannguyen@gmail.com>
     * @copyright  2024 Nguyen Dinh
     * @license    GNU General Public License version 2 or later; see LICENSE.txt
     */
    // No direct access
    defined('_JEXEC') or die;

    use \Joomla\CMS\HTML\HTMLHelper;
    use \Joomla\CMS\Factory;
    use \Joomla\CMS\Uri\Uri;
    use \Joomla\CMS\Router\Route;
    use \Joomla\CMS\Language\Text;
    use \Joomla\CMS\Layout\LayoutHelper;
    use \Joomla\CMS\Session\Session;
    use \Joomla\CMS\User\UserFactoryInterface;

    HTMLHelper::_('bootstrap.tooltip');
    HTMLHelper::_('behavior.multiselect');
    HTMLHelper::_('formbehavior.chosen', 'select');

    $user = Factory::getApplication()->getIdentity();
    $userId = $user->get('id');
    $listOrder = $this->state->get('list.ordering');
    $listDirn = $this->state->get('list.direction');


    // Import CSS
    $wa = $this->document->getWebAssetManager();
    $wa->useStyle('com_homepage.list');

    $dxn = new Dxn();
?>
<form action="<?php //echo htmlspecialchars(Uri::getInstance()->toString()); ?>" method="post"
      name="adminForm" id="pageSearchForm">
    <?php if (!empty($this->filterForm)) {
        echo LayoutHelper::render('joomla.searchtools.default', array('view' => $this));
    } ?>
    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="boxchecked" value="0"/>
    <input type="hidden" name="filter_order" value=""/>
    <input type="hidden" name="filter_order_Dir" value=""/>
    <?php echo HTMLHelper::_('form.token'); ?>
</form>
<div class="jl-container searchContainer">
    <h2 style="font-weight: 900; padding: 20px; color: #0a2051;">Kết quả tìm kiếm </h2>
    <?php if ($this->items) : ?>
        <?php foreach ($this->items as $i => $item) : ?>
            <?php
            $imgs = json_decode($item->images);
            $link = new Uri(Route::_('index.php?option=com_content&view=article&catid=' . $item->catid . '&id=' . $item->id, false));
            ?>
            <div class="searchItem g-grid">
                <div class="g-block size-20 imgBox"><a href="<?php echo $link; ?>"><img
                                src="<?php echo $imgs->image_intro; ?>" width="" height=""
                                class="tm-image jl-transition-scale-up jl-transition-opaque" alt="" loading="lazy"></a>
                </div>
                <div class="g-block size-80 textDes">
                    <h4 class="titleItem"><a href="<?php echo $link; ?>"><?php echo $item->title ?></a></h4>
                    <p><?php echo $dxn->cutString(strip_tags($item->introtext), 300); ?></p>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="pagination">
            <?php echo $this->pagination->getPagesLinks(); ?>
        </div>
    <?php else : ?>
        <h2 style="font-weight: 900; padding: 20px; color: #0a2051;">Không tìm thấy kết quả phù hợp. </h2>
    <?php endif; ?>
</div>
