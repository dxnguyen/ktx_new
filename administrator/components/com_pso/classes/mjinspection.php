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

class MjInspection
{
    /** @var array */
    private $blob;

    /**
     * @param MjSettingsModel $settings
     * @return array
     */
    public function getWarnings($settings)
    {
        $this->blob = array();
        $this->checkEnabled();
        $this->checkDebug();
        $this->checkOpenSSL();
        $this->checkGD2();
        $this->checkDailyRuns();
        if (($settings->get('css_atf') && !$settings->get('css_atflocal')) || MJPluginHelper::isEnabled('pso', 'psopro')) {
            $this->checkAPIKey($settings);
            $this->checkRemoteConnection();
        }
        $this->checkPluginsOrdering();


        return $this->blob;
    }

    /** @return void */
    private function checkEnabled()
    {
        $psoEnabled = MJPluginHelper::isEnabled('system', 'pso');
        $psoProEnabled = !is_file(JPATH_PLUGINS . '/pso/psopro/psopro.xml') || MJPluginHelper::isEnabled('pso', 'psopro');
        if ($psoEnabled && $psoProEnabled) {
            return;
        }

        $db = MjJoomlaWrapper::getInstance()->getDbo();
        $query = new MjQueryBuilder($db);
        $rows = $query
            ->select('element', $query->qn('extension_id') . ' AS ' . $query->qn('id'))
            ->from('#__extensions')
            ->where($query->qn('type') . '=' . $query->q('plugin'))
            ->where($query->qn('element') . ' IN (' .
                $query->q('pso') . ', ' .
                $query->q('psopro') . ')')
            ->loadObjectList('element');

        $input = array();
        $pluginUrl = 'index.php?option=com_plugins&task=plugin.edit&extension_id=';
        if (!$psoEnabled) {
            $title = 'System - Page Speed Optimizer';
            if (isset($rows['pso'])) {
                $title = '<a href="' . $pluginUrl . $rows['pso']->id . '">' . $title . '</a>';
            }
            $input[] = $title;
        }

        if (!$psoProEnabled) {
            $title = 'Page Speed Optimizer - Pro';
            if (isset($rows['psopro'])) {
                $title = '<a href="' . $pluginUrl . $rows['psopro']->id . '">' . $title . '</a>';
            }
            $input[] = $title;
        }

        $this->blob[] = array(
            'label' => MjUI::label('', 'COM_PSO__WARNING_DISABLED_PLUGINS'),
            'input' => MjUI::text(implode('<br>', $input))
        );
    }

    /** @return void */
    private function checkDebug()
    {
        if (JDEBUG) {
            $this->blob[] = array(
                'label' => MjUI::label('', 'COM_PSO__WARNING_DEBUG'),
                'input' => MjUI::text(MJText::_('COM_PSO__WARNING_DEBUG_TEXT'))
            );
        }
    }

    /** @return void */
    private function checkOpenSSL()
    {
        if (!extension_loaded('openssl')) {
            $this->blob[] = array(
                'label' => MjUI::label('', 'COM_PSO__WARNING_OPENSSL'),
                'input' => MjUI::text(MJText::_('COM_PSO__WARNING_OPENSSL_TEXT'))
            );
        }
    }

    /** @return void */
    private function checkGD2()
    {
        if (!function_exists('imagecopyresized')) {
            $this->blob[] = array(
                'label' => MjUI::label('', 'COM_PSO__WARNING_GD2'),
                'input' => MjUI::text(MJText::_('COM_PSO__WARNING_GD2_TEXT'))
            );
        }
    }

    /** @return void */
    private function checkDailyRuns()
    {
        include_once JPATH_ADMINISTRATOR . '/components/com_pso/classes/mjdailytasks.php';
        $next = MjDailyTasks::getNextRunTime();
        if ($next < time() - 25 * 60 * 60) {
            $this->blob[] = array(
                'label' => MjUI::label('', 'COM_PSO__WARNING_LAST_DAILY_RUNS'),
                'input' => MjUI::text($next === 0 ? MJText::_('COM_PSO__WARNING_LAST_DAILY_RUNS_NEVER_TEXT') : date('r', $next))
            );
        }
    }

    /**
     * @param MjSettingsModel $settings
     * @return void
     */
    private function checkAPIKey($settings)
    {
        if (empty($settings->get('apikey'))) {
            $this->blob[] = array(
                'label' => MjUI::label('', 'COM_PSO__WARNING_NOAPIKEY'),
                'input' =>
                    '<div class="btn-toolbar">' .
                    '<div><p class="form-control-plaintext">' . MJText::_('COM_PSO__WARNING_NOAPIKEY_TEXT') . '</p></div>' .
                    '</div>'
            );
        }
    }

    /** @return void */
    private function checkRemoteConnection()
    {
        if (!function_exists('fsockopen')
            && !function_exists('curl_init')
            && !ini_get('allow_url_fopen')
        ) {
            $this->blob[] = array(
                'label' => MjUI::label('', 'COM_PSO__WARNING_REMOTE'),
                'input' => MjUI::text(MJText::_('COM_PSO__WARNING_REMOTE_TEXT'))
            );
        }
    }

    /** @return void */
    private function checkPluginsOrdering()
    {
        $plugins = array(
            'system:sef',
            'system:pso',
            'system:cache',
        );

        $titles = array(
            'sef' => 'System - SEF',
            'pso' => 'System - Page Speed Optimizer',
            'cache' => 'System - Page Cache',
        );

        $orderings = array(
            array('sef', 'pso'),
            array('pso', 'cache'),
        );

        $db = MjJoomlaWrapper::getInstance()->getDbo();
        $query = new MjQueryBuilder($db);

        $plugins_enabled = array();
        $deps = array();
        foreach ($plugins as $groupName) {
            list($group, $name) = explode(':', $groupName);
            $plugins_enabled[$name] = MJPluginHelper::isEnabled($group, $name);
            $deps[] = $query->q($name);
        }

        $rows = $query
            ->select('element', 'ordering')
            ->from('#__extensions')
            ->where($query->qn('element') . ' IN (' . implode(', ', $deps) . ')')
            ->where($query->qn('folder') . ' IN (' . $query->q('system') . ', ' . $query->q('pso') . ')')
            ->loadObjectList('element');

        foreach ($orderings as $ordering) {
            list($plugin1, $plugin2) = $ordering;
            if ($plugins_enabled[$plugin1] && $plugins_enabled[$plugin2]
                && $rows[$plugin1]->ordering >= $rows[$plugin2]->ordering
            ) {
                $this->blob[] = array(
                    'label' => MjUI::label('', 'COM_PSO__WARNING_PLUGINS_ORDERING'),
                    'input' => MjUI::text(
                        MJText::sprintf('COM_PSO__WARNING_PLUGINS_ORDERING_TEXT', $titles[$plugin1], $titles[$plugin2])
                    )
                );
            }
        }
    }
}