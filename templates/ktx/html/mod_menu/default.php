<?php
    /**
     * @package     Joomla.Site
     * @subpackage  mod_menu
     *
     * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
     * @license     GNU General Public License version 2 or later; see LICENSE.txt
     */

    defined('_JEXEC') or die;

    use Joomla\CMS\Helper\ModuleHelper;
    use Joomla\CMS\Factory;

    $app      = Factory::getApplication();
    $sitename = htmlspecialchars($app->get('sitename'), ENT_QUOTES, 'UTF-8');
    $dxn      = new Dxn();
    $infoweb  = $dxn->getInfoweb();

    /** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
    $wa = $app->getDocument()->getWebAssetManager();
    $wa->registerAndUseScript('mod_menu', 'mod_menu/menu.min.js', [], ['type' => 'module']);
    $wa->registerAndUseScript('mod_menu', 'mod_menu/menu-es5.min.js', [], ['nomodule' => true, 'defer' => true]);

    $id = '';

    if ($tagId = $params->get('tag_id', '')) {
        $id = ' id="' . $tagId . '"';
    }

    // The menu class is deprecated. Use mod-menu instead
?>
<nav class="jl-navbar navbar navbar-expand-lg">
    <a class="jl-navbar-item jl-logo" href="/"
       title="<?php echo $sitename; ?>>" aria-label="Back to the homepage" rel="home">
        <img src="<?php echo JURI::root().'uploads/infos/'.$infoweb->logo; ?>" />
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"><i class="fa fa-bars" aria-hidden="true"></i></span>
    </button>

    <div class="jl-navbar-right collapse navbar-collapse" id="navbarSupportedContent">
        <ul<?php echo $id; ?> class="<?php echo $class_sfx; ?> jl-navbar-nav navbar-nav me-auto">
            <?php foreach ($list as $i => &$item) {
                $itemParams = $item->getParams();
                $class = 'item-type-url nav-item item-' . $item->id;

                if ($item->id == $default_id) {
                    $class .= ' default';
                }

                if ($item->id == $active_id || ($item->type === 'alias' && $itemParams->get('aliasoptions') == $active_id)) {
                    $class .= ' current';
                }

                if (in_array($item->id, $path)) {
                    $class .= ' active';
                } elseif ($item->type === 'alias') {
                    $aliasToId = $itemParams->get('aliasoptions');

                    if (count($path) > 0 && $aliasToId == $path[count($path) - 1]) {
                        $class .= ' active';
                    } elseif (in_array($aliasToId, $path)) {
                        $class .= ' alias-parent-active';
                    }
                }

                if ($item->type === 'separator') {
                    $class .= ' divider';
                }

                if ($item->deeper) {
                    $class .= ' deeper dropdown';
                }

                if ($item->parent) {
                    $class .= ' parent';
                }

                echo '<li class="' . $class . '">';

                switch ($item->type) :
                    case 'separator':
                    case 'component':
                    case 'heading':
                    case 'url':
                        require ModuleHelper::getLayoutPath('mod_menu', 'default_' . $item->type);
                        break;

                    default:
                        require ModuleHelper::getLayoutPath('mod_menu', 'default_url');
                        break;
                endswitch;

                // The next item is deeper.
                if ($item->deeper) {
                    echo '<ul class="dropdown-menu ">';
                } elseif ($item->shallower) {
                    // The next item is shallower.
                    echo '</li>';
                    echo str_repeat('</ul></li>', $item->level_diff);
                } else {
                    // The next item is on the same level.
                    echo '</li>';
                }
            }
            ?></ul>
    </div>
</nav>
