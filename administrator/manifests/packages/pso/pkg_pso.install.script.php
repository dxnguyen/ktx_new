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

class pkg_psoInstallerScript
{
    public function __construct()
    {
        $this->declareClasses();
    }

    /**
     * @param string $route
     * @param JInstallerComponent $adapter
     * @return bool
     */
    public function preflight($route, $adapter)
    {
        if ($route === 'install') {
            if (version_compare(JVERSION, '2.5', '<')) {
                throw new RuntimeException('Inappropriate Joomla version (2.5 or higher is required).');
            }
            if (version_compare(PHP_VERSION, '5.6', '<')) {
                throw new RuntimeException('Inappropriate PHP version (5.6 or higher is required).');
            }
            if (is_dir(JPATH_ADMINISTRATOR . '/components/com_mobilejoomla')) {
                throw new RuntimeException('Page Speed Optimizer cannot work with Mobile extension. Please uninstall it before installing Page Speed Optimizer.');
            }
        }

        return true;
    }

    /** @return void */
    public function install()
    {
        // Remove Mobile Pro package if installed
        $table = MJTable::getInstance('extension');
        $id = $table->find(array('type' => 'package', 'element' => 'pkg_pso_pro'));

        if ($id) {
            $table->delete($id);
            MJFile::delete(JPATH_MANIFESTS . '/packages/pkg_pso_pro.xml');
            MJFolder::delete(JPATH_MANIFESTS . '/packages/pso_pro');
            $db = MJFactory::getDbo();
            $db->setQuery(
                $db->getQuery(true)->delete('#__update_sites_extensions')->where('extension_id='. $id)
            )->execute();

            // Disable PSO Pro plugin
            $id1 = (int) $table->find((array('type' => 'plugin', 'folder' => 'pso', 'element' => 'psopro')));
            $query = $db->getQuery(true)->update('#__extensions')->set('enabled=0')->where('extension_id IN (' . $id1 . ')');
            if (version_compare(JVERSION, '3.7', '>=')) {
                // detach plugins from the package
                $query->set('package_id=0');
            }
            $db->setQuery($query)->execute();
        }
    }

    /** @return void */
    public function uninstall()
    {
        $this->reloadSysLanguage();
    }

    /**
     * @param string $route
     * @param JInstallerPackage $adapter
     * @return bool
     */
    public function postflight($route, $adapter)
    {
        $this->reloadSysLanguage();

        $adapter->getParent()->message = '';

        $version_name = '1.4.2';

        if ($route !== 'uninstall') {
            //Show install status
            ?>
            <link rel="stylesheet" type="text/css" href="../media/com_pso/css/mj.bootstrap.min.css">
            <div id="mj">
                <div class="well">
                    <h1 class='fw-bold text-success'>
                        <?php echo MJText::sprintf('COM_PSO__INSTALL_OK', $version_name); ?>
                    </h1>
                    <p>
                        <?php echo MJText::_('COM_PSO__INSTALL_OK_DESC'); ?>
                    </p>
                    <div>
                        <a href='index.php?option=com_pso' class='btn btn-success py-3 mt-1 me-1'>
                            <?php echo MJText::_('COM_PSO__INSTALL_OK_BTN1'); ?>
                        </a> &nbsp; <a href='https://www.mobilejoomla.com/documentation/12-getting-started/' target='_blank' class='btn btn-info py-3 mt-1'>
                            <?php echo MJText::_('COM_PSO__INSTALL_OK_BTN2'); ?>
                        </a>
                    </div>
                </div>
            </div>
            <?php
        } else {
            //Show uninstall status
            ?>
            <style>#mj h1{margin-top:0;margin-bottom:.5rem;font-weight:700;line-height:1.2;font-size:calc(1.29rem + .48vw);color:rgb(42,105,184)}@media (min-width:1200px){#mj h1{font-size:1.65rem}}</style>
            <div id="mj">
                <div class="well">
                    <h1 class='fw-bold text-info'>
                        <?php echo MJText::sprintf('COM_PSO__UNINSTALL_OK', $version_name); ?>
                    </h1>
                </div>
            </div>
            <?php
        }

        return true;
    }

    /** @return void */
    protected function reloadSysLanguage()
    {
        $lang = version_compare(JVERSION, '4.0', '>=') ? MJFactory::getApplication()->getLanguage() : JFactory::getLanguage();
        $lang->load('com_pso.sys', JPATH_ADMINISTRATOR, null, true);
    }

    /** @return void */
    private function declareClasses()
    {
        if (version_compare(JVERSION, '5.0', '>=')) {
            JLoader::registerAlias('MJFactory', Joomla\CMS\Factory::class);
            JLoader::registerAlias('MJFile', Joomla\Filesystem\File::class);
            JLoader::registerAlias('MJFolder', Joomla\Filesystem\Folder::class);
            JLoader::registerAlias('MJTable', Joomla\CMS\Table\Table::class);
            JLoader::registerAlias('MJText', Joomla\CMS\Language\Text::class);
        } else {
            JLoader::registerAlias('MJFactory', JFactory::class);
            JLoader::registerAlias('MJFile', JFile::class);
            JLoader::registerAlias('MJFolder', JFolder::class);
            JLoader::registerAlias('MJTable', JTable::class);
            JLoader::registerAlias('MJText', JText::class);
        }
    }
}