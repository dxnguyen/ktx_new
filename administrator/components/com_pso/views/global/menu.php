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

/** @var MjController $this */
/** @var array $params */
/** @var string $controllerName */
/** @var string $viewName */

$viewName = $params['viewName'];
$controllerName = $params['controllerName'];

$active = $controllerName;
if ($viewName !== 'default') {
    $active .= '/' . $viewName;
}

$menu = array(
    'dashboard' => array(
        'dashboard' => 'dashboard'
    ),
    'settings' => array(
        'optimization' => 'settings/optimization',
        'pagecache' => 'pagecache',
        'advanced' => 'settings/advanced',
        'troubleshooting' => 'settings/troubleshooting',
    ),
);



// Reloading of raw settings (don't rely on plugin's instance)
include_once JPATH_COMPONENT . '/models/settings.php';
$settings = new MjSettingsModel($this->joomlaWrapper);

/**
 * @param array $menu
 * @param string $active
 * @return void
 */
function MjRecursiveMenu($menu, $active)
{
    $joomlaWrapper = MjJoomlaWrapper::getInstance();
    $lang = $joomlaWrapper->getLanguage();
    foreach ($menu as $name => $action) {
        if (is_array($action)) {
            if (count($action) > 0) {
                echo '<ul class="list-group' . (count($action) > 1 ? ' list-group-horizontal' : '') . ' flex-wrap p-0 ms-0 me-2 mb-2">';
                MjRecursiveMenu($action, $active);
                echo '</ul>';
            }
        } else {
            $title_lang_key = 'COM_PSO__MENU_' . strtoupper($name);
            $title = $lang->hasKey($title_lang_key) ? $lang->_($title_lang_key) : ucfirst($name);

            list($itemController, $itemView) = explode('/', $action . '/default');

            $url = 'index.php?option=com_pso';
            if ($itemController !== '') {
                $url .= '&controller=' . $itemController;
            }
            if ($itemView !== 'default') {
                $url .= '&view=' . $itemView;
            }
            echo '<li class="list-group-item d-flex align-items-center p-0' . ($action === $active ? ' active' : '') . '">';
            if ($action === $active) {
                echo '<span class="btn btn-primary text-reset fw-bold px-3 py-2 my-0 h-100">' . $title . '</span>';
            } else {
                echo '<a class="btn btn-outline-light text-primary px-3 py-2 my-0 h-100" href="' . MJRoute::_($url) . '">' . $title . '</a>';
            }
            echo '</li>';
        }
    }
}

?>
    <nav class="navbar navbar-expand-md navbar-light align-items-start p-0 mb-2">
        <button class="navbar-toggler col-auto bg-white mb-2 me-2" type="button" data-bs-toggle="collapse" data-bs-target="#mjnavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse px-0" id="mjnavbar">
            <div class="d-flex flex-wrap">
                <?php
                MjRecursiveMenu($menu, $active);
                ?>
            </div>
        </div>
    </nav>
<?php
