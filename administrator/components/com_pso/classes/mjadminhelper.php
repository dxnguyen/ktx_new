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

class MjAdminHelper
{
    /** @return void */
    public static function jsGetNotification()
    {
        include_once JPATH_ADMINISTRATOR . '/components/com_pso/legacy/joomlawrapper.php';
        $joomlaWrapper = MjJoomlaWrapper::getInstance();
        $joomlaWrapper->loadLanguageFile('com_pso', JPATH_ADMINISTRATOR);

        // free / pro
        $version = '1.4.2';
        if (MJPluginHelper::isEnabled('pso', 'psopro')) {
            $version .= '.pro';
        }

        $doc = $joomlaWrapper->getDocument();
        $doc->addScriptDeclaration(
            'var mj_updater={'
            . 'text: "' . addslashes(MJText::_('COM_PSO__NEW_VERSION_AVAILABLE')) . '"'
            . ', text_btn: "' . addslashes(MJText::_('COM_PSO__NEW_VERSION_UPDATE_NOW')) . '"'
            . ', v: "' . $version . '"'
            . ', j: "' . JVERSION . '"'
            . '};'
        );
        $doc->addScript('../media/com_pso/js/mj_update_checker.js?v=1.4.2');
    }

    /**
     * @param string $images_dir
     * @param int $size
     * @param int $files
     * @return void
     */
    public static function getImagesStats($images_dir, &$size, &$files)
    {
        $size = 0;
        $files = 0;

        if (is_dir($images_dir)) {
            // Loop through files
            foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($images_dir)) as $file) {
                if ($file->isFile() && $file->getFilename() !== '.htaccess') {
                    $size += $file->getSize();
                    $files++;
                }
            }
        }
    }

    /**
     * @param string $dir
     * @param int &$size
     * @param int &$files
     * @param bool $recursively
     * @return void
     */
    public static function getDirectoryStats($dir, &$size, &$files, $recursively = true)
    {
        $size = 0;
        $files = 0;

        $dir = realpath($dir);
        if ($dir === false) {
            return;
        }

        if (DIRECTORY_SEPARATOR !== '/') {
            $dir = strtr($dir, DIRECTORY_SEPARATOR, '/');
        }
        $dir = rtrim($dir, '/');

        self::getDirectoryStatsRecursive($dir, $size, $files, $recursively);
    }

    /**
     * @param string $dir
     * @param int $size
     * @param int $files
     * @param bool $recursively
     * @return void
     */
    protected static function getDirectoryStatsRecursive($dir, &$size, &$files, $recursively = true)
    {
        foreach (glob($dir . '/*', GLOB_NOSORT) as $item) {
            if (is_file($item)) {
                $size += filesize($item);
                $files++;
            } elseif ($recursively) {
                self::getDirectoryStatsRecursive($item, $size, $files);
            }
        }
    }

    /**
     * @param int $bytes
     * @return string
     */
    public static function formatSize($bytes)
    {
        $value = (int)$bytes;

        $prefix = '';
        if ($value >= 1000) {
            foreach (array('K', 'M', 'G', 'T') as $prefix) {
                $value /= 1024;
                if ($value < 1000) {
                    break;
                }
            }
        }
        $precision = ($value < 10 && $prefix !== '') ? 1 : 0;
        return number_format($value, $precision, '.', '') . " {$prefix}B";
    }
}