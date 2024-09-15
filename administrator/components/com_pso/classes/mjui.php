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

class MjUI
{
    /**
     * @param string $type
     * @param MjSettingsModel $settings
     * @param string|string[] $name
     * @param string|false $label
     * @return array
     */
    public static function prepare($type, $settings, $name, $label /* , ... */)
    {
        $result = array();

        if (is_array($name)) {
            $result['depends'] = $name[1];
            $name = $name[0];
        }

        $result['id'] = $name;

        if (preg_match('/^([^.]*)\.?css_atfcss$/', $name, $matches)) {
            $device = $matches[1];
            $value = $settings->getATFCSS('/', $device);
        } else {
            $value = $settings->get($name, '');
        }

        $params = array_slice(func_get_args(), 4);
        array_unshift($params, $name, $value);

        if (strpos($type, ':') !== false) {
            list($type, $wrap) = explode(':', $type, 2);
            $result['wrapClass'] = $wrap;
        }

        if ($label !== false) {
            $overwrites = ($type !== 'template') && (strpos($name, '.') > 0);
            $result['label'] = self::label($name, $label, $label . '_DESC', ($overwrites ? 'COM_PSO__OVERWRITES_GLOBAL' : ''));
        }

        $result['input'] = self::$type(...$params);

        return $result;
    }

    /**
     * @param string $type
     * @param string $name
     * @param string|false $label
     * @return array
     */
    public static function proprepare($type, $name, $label /* , ... */)
    {
        $result = array();
        $result['id'] = $name;

        $params = array_slice(func_get_args(), 3);

        if ($label !== false) {
            $result['label'] = self::prolabel($label);
        }

        $result['input'] = '<div class="mjpro">'
            . call_user_func_array(array(__CLASS__, "pro$type"), $params)
            . '</div>';

        return $result;
    }

    /**
     * @param string $name
     * @param string $text_code
     * @param string $tooltip_code
     * @param string $tooltip_extra
     * @return string
     */
    public static function label($name, $text_code, $tooltip_code = '', $tooltip_extra = '')
    {
        if ($name !== '') {
            $name = self::id($name);
        }

        $html =
            '<label class="col-sm-4 col-form-label"' .
            ($name !== '' ? ' for="' . $name . '"' : '') .
            ($tooltip_code ? ' data-bs-toggle="tooltip" title="' . htmlspecialchars(MJText::_($tooltip_code) . MJText::_($tooltip_extra)) . '"' : '') .
            '>' .
            MJText::_($text_code) .
            '</label>';

        return $html;
    }

    /**
     * @param string $name
     * @return string
     */
    public static function id($name)
    {
        return 'mj_' . str_replace('.', '-', $name);
    }

    /**
     * @param string $text
     * @return string
     */
    public static function text($text)
    {
        $html = '<p class="form-control-plaintext">' . $text . '</p>';
        return $html;
    }

    /**
     * @param string $name
     * @param string $value
     * @param array $attrs
     * @return string
     */
    public static function textinput($name, $value, $attrs = array())
    {
        $name = self::id($name);

        $attrs['name'] = $name;
        $attrs['id'] = $name;
        $attrs['value'] = htmlspecialchars($value);
        $attrs['class'] = isset($attrs['class']) ? $attrs['class'] . ' ' : '';
        $attrs['class'] .= 'form-control';

        $html = '<input type="text"';
        foreach ($attrs as $attrName => $attrValue) {
            $html .= ' ' . $attrName . '="' . $attrValue . '"';
        }
        $html .= '>';

        return $html;
    }

    /**
     * @param string $name
     * @param string $value
     * @param string|bool $unit
     * @param string $default
     * @param array $attrs
     * @return string
     */
    public static function numberinput($name, $value, $unit = false, $default = '', $attrs = array())
    {
        $name = self::id($name);

        $attrs['name'] = $name;
        $attrs['id'] = $name;
        $attrs['value'] = htmlspecialchars($value);
        $attrs['class'] = (isset($attrs['class']) ? $attrs['class'] . ' ' : '') . 'form-control text-end';
        $attrs['placeholder'] = htmlspecialchars($default);

        $html = '<input type="number"';
        foreach ($attrs as $attrName => $attrValue) {
            $html .= ' ' . $attrName . '="' . $attrValue . '"';
        }
        $html .= '>';

        if ($unit !== false) {
            $html = '<div class="input-group">'
                . $html
                . '<span class="input-group-text">' . $unit . '</span>'
                . '</div>';
        }

        return $html;

    }

    /**
     * @param string $name
     * @param string $value
     * @param array $items
     * @return string
     */
    public static function radio($name, $value, $items)
    {
        $name = self::id($name);

        if ($value === null) {
            $value = ''; // "global" value
        }

        $value = (string)$value;

        $html = '';
        foreach ($items as $key => $title) {
            $disabled = false;
            if (isset($key[1]) && $key[0] === '-') {
                $disabled = true;
                $key = substr($key, 1);
            }
            $html .=
                '<div class="form-check form-check-inline">' .
                '<input type="radio"' .
                ' name="' . $name . '"' .
                ' id="jform_' . $name . $key . '"' .
                ' value="' . $key . '"' .
                ($value === (string)$key ? ' checked="checked"' : '') .
                ($disabled ? ' disabled="disabled"' : '') .
                ' class="form-check-input"' .
                '>' .
                '<label for="jform_' . $name . $key . '" class="form-check-label' . ($disabled ? ' disabled' : '') . '">' .
                $title .
                '</label>' .
                '</div>';
        }
        return $html;
    }

    /**
     * @param string $name
     * @param bool $value
     * @return string
     */
    public static function onoff($name, $value)
    {
        $name = self::id($name);

        $html =
            '<div class="btn-group flex-wrap">' .
            '<label for="jform_' . $name . '1" class="btn btn-outline-success' . ($value ? ' active' : '') . '">' .
            '<input type="radio" name="' . $name . '" id="jform_' . $name . '1" value="1"' . ($value ? ' checked="checked"' : '') . '>' .
            '<span>' . MJText::_('JYES') . '</span>' .
            '</label>' .
            '<label for="jform_' . $name . '0" class="btn btn-outline-danger' . ($value ? '' : ' active') . '">' .
            '<input type="radio" name="' . $name . '" id="jform_' . $name . '0" value="0"' . ($value ? '' : ' checked="checked"') . '>' .
            '<span>' . MJText::_('JNO') . '</span>' .
            '</label>' .
            '</div>';
        return $html;
    }

    /**
     * @param string $name
     * @param string $value
     * @param array $items
     * @return string
     */
    public static function nswitch($name, $value, $items)
    {
        $name = self::id($name);

        $html = '<div class="btn-group flex-wrap">';
        foreach ($items as $key => $title) {
            $class = 'btn btn-outline-info';
            $disabled = false;
            if (isset($key[1])) {
                if ($key[0] === '-') {
                    $disabled = true;
                    $class .= ' disabled';
                    $key = substr($key, 1);
                } elseif ($key[0] === '$') {
                    $disabled = true;
                    $class .= ' mjpro';
                    $key = substr($key, 1);
                }
            }
            $active = ($value === (string)$key);
            $html .=
                '<label for="jform_' . $name . $key . '" class="' . $class . ($active ? ' active' : '') . '">' .
                '<input type="radio" name="' . $name
                . '" id="jform_' . $name . $key
                . '" value="' . $key
                . '"'
                . ($disabled ? ' disabled' : '')
                . ($active ? ' checked' : '')
                . '>' .
                '<span>' . $title . '</span>' .
                '</label>';
        }
        $html .= '</div>';
        return $html;
    }

    /**
     * @param string $name
     * @param string $value
     * @return string
     */
    public static function gonoff($name, $value)
    {
        $name = self::id($name);

        if ($value === null) {
            $value = ''; // "global" value
        } else {
            $value = (string)$value;
        }

        $items = array(
            array('1', 'success', MJText::_('JYES')),
            array('', 'info', MJText::_('COM_PSO__GLOBAL')),
            array('0', 'danger', MJText::_('JNO')),
        );
        $html = '<div class="btn-group flex-wrap">';
        foreach ($items as $item) {
            $active = ($value === $item[0]);
            $html .=
                '<label for="jform_' . $name . $item[0] . '" class="btn btn-outline-' . $item[1] . ($active ? ' active' : '') . '">' .
                '<input type="radio" name="' . $name . '" id="jform_' . $name . $item[0] . '" value="' . $item[0] . '"' . ($active ? ' checked="checked"' : '') . '>' .
                '<span>' . $item[2] . '</span>' .
                '</label>';
        }
        $html .= '</div>';

        return $html;
    }

    /**
     * @param string $name
     * @param int $value
     * @param int $min
     * @param int $max
     * @param string $unit
     * @return string
     */
    public static function slider($name, $value, $min = 0, $max = 100, $unit = '%')
    {
        $name = self::id($name);

        $html = '<div class="row">'
            . '<div class="col">'
            . '<input type="range" value="' . $value . '" min="' . $min . '" max="' . $max . '" class="form-range mt-2" id="' . $name . '_slider" oninput="document.getElementById(\'' . $name . '\').value=this.value">'
            . '</div>'
            . '<div class="col-auto">'
            . '<div class="input-group">'
            . '<input type="number" value="' . $value . '" min="' . $min . '" max="' . $max . '" class="form-control text-end px-1" style="width:3.3rem;min-width:auto;" id="' . $name . '" name="' . $name . '" size="2" oninput="document.getElementById(\'' . $name . '_slider\').value=this.value">'
            . '<span class="input-group-text">' . $unit . '</span>'
            . '</div>'
            . '</div>'
            . '</div>';
        return $html;
    }

    /**
     * @param string $name
     * @param string $value
     * @param array $attrs
     * @return string
     */
    public static function color($name, $value, $attrs = array())
    {
        $name = self::id($name);

        $attrs['name'] = $name;
        $attrs['id'] = $name;
        $attrs['value'] = htmlspecialchars($value);
        $attrs['class'] = isset($attrs['class']) ? $attrs['class'] . ' ' : '';
        $attrs['class'] .= 'form-control form-control-color';

        $html = '<input type="color"';
        foreach ($attrs as $attrName => $attrValue) {
            $html .= ' ' . $attrName . '="' . $attrValue . '"';
        }
        $html .= '>';

        return $html;
    }

    /**
     * @param string $name
     * @param string $value
     * @param array $attrs
     * @return string
     */
    public static function time($name, $value, $attrs = array())
    {
        $name = self::id($name);

        $attrs['name'] = $name;
        $attrs['id'] = $name;
        $attrs['value'] = htmlspecialchars($value);
        $attrs['class'] = isset($attrs['class']) ? $attrs['class'] . ' ' : '';
        $attrs['class'] .= 'form-control w-auto';

        $html = '<input type="time"';
        foreach ($attrs as $attrName => $attrValue) {
            $html .= ' ' . $attrName . '="' . $attrValue . '"';
        }
        $html .= '>';

        return $html;
    }

    /**
     * @param ?string $name
     * @param array|string $value
     * @param bool $multiple
     * @param string $updateName
     * @param bool $sef
     * @return string
     */
    public static function menulisturl($name, $value, $multiple = false, $updateName = '', $sef = false)
    {
        $menuoptions = self::menuoptions();

        $sizeLimit = max(1, min(7, count($menuoptions)));
        $html = '<select class="form-select bg-white" size="' . $sizeLimit . '"';
        if ($name) {
            $html .= ' name="' . self::id($name) . ($multiple ? '[]' : '') . '"';
        }
        if ($multiple) {
            $html .= ' multiple="multiple"';
        }
        if ($updateName) {
            $html .= ' onchange="document.getElementById(\'' . self::id($updateName) . '\').value=this.value"';
        }
        $html .= '>';

        $value = (array)$value;

        if ($sef) {
            /** @var JRouterSite $router */
            if (version_compare(JVERSION, '5.0', '>=')) {
                $router = Joomla\CMS\Factory::getContainer()->get(Joomla\CMS\Router\SiteRouter::class);
            } elseif (version_compare(JVERSION, '3.2', '>=')) {
                $router = JApplicationAdministrator::getRouter('site');
            } else {
                $router = JAdministrator::getRouter('site');
            }
        }

        foreach ($menuoptions as $id => $item) {
            if ($multiple && $item['value'] === '') {
                continue;
            }
            switch ($item['value']) {
                case '<OPTGROUP>':
                    $html .= '<optgroup label="' . $item['text'] . '">';
                    break;
                case '</OPTGROUP>':
                    $html .= '</optgroup>';
                    break;
                default:
                    if ($sef) {
                        $item['value'] = $router->build($item['value'])->toString(array('path', 'query', 'fragment'));
                    }
                    $html .=
                        '<option value="' . $item['value'] . '"' .
                        (in_array($item['value'], $value, true) ? ' selected' : '') .
                        ($item['disabled'] ? ' disabled' : '') .
                        '>' .
                        $item['text'] .
                        '</option>';
            }
        }

        $html .= '</select>';
        return $html;
    }

    /**
     * @param string $name
     * @param array|string $value
     * @param bool $multiple
     * @param string $updateName
     * @return string
     */
    public static function menulistid($name, $value, $multiple = false, $updateName = '')
    {
        $value = (array)$value;

        $menuoptions = self::menuoptions();

        $html_items = '';
        $size = 0;
        foreach ($menuoptions as $item) {
            if ($multiple && $item['value'] === '') {
                continue;
            }
            switch ($item['value']) {
                case '<OPTGROUP>':
                    $size++;
                    $html_items .= '<optgroup label="' . $item['text'] . '">';
                    break;
                case '</OPTGROUP>':
                    $html_items .= '</optgroup>';
                    break;
                default:
                    $size++;
                    $html_items .=
                        '<option value="' . $item['id'] . '"' .
                        (in_array((string)$item['id'], $value, true) ? ' selected' : '') .
                        ($item['disabled'] ? ' disabled' : '') .
                        '>' . $item['text'] . '</option>';
            }
        }

        $html = '';
        if ($multiple) {
            $html .= '<input type="hidden" name="' . self::id($name) . '[]" value="">';
        }
        $sizeLimit = max(1, min(7, $size));
        $html .= '<select class="form-select bg-white" size="' . $sizeLimit . '"';
        if ($name) {
            $html .= ' name="' . self::id($name) . ($multiple ? '[]' : '') . '"';
        }
        if ($multiple) {
            $html .= ' multiple="multiple"';
        }
        if ($updateName) {
            $html .= ' onchange="document.getElementById(\'' . self::id($updateName) . '\').value=this.value"';
        }
        $html .= '>' . $html_items . '</select>';
        return $html;
    }

    /**
     * @return array
     */
    private static function menuoptions()
    {
        static $menuoptions;
        if ($menuoptions !== null) {
            return $menuoptions;
        }

        $db = MjJoomlaWrapper::getInstance()->getDbo();

        $query = new MjQueryBuilder($db);
        if (version_compare(JVERSION, '3.0', '>=')) { // 3.0+
            $query
                ->select('id', 'menutype', 'title', 'link', 'type', 'parent_id')
                ->from('#__menu')
                ->where($query->qn('published') . '=1')
                ->where($query->qn('client_id') . '=0')
                ->order('menutype', 'parent_id', 'lft');
        } else { //1.6-2.5
            $query
                ->select('id', 'menutype', 'title', 'link', 'type', 'parent_id')
                ->from('#__menu')
                ->where($query->qn('published') . '=1')
                ->where($query->qn('client_id') . '=0')
                ->order('menutype', 'parent_id', 'ordering');
        }
        /** @var array $mitems */
        $mitems = $query->loadObjectList();
        $children = array();
        foreach ($mitems as $v) {
            $pt = $v->parent_id;
            $list = !empty($children[$pt]) ? $children[$pt] : array();
            $list[] = $v;
            $children[$pt] = $list;
        }
        $list = array();
        $id = 1;
        if (!empty($children[$id])) {
            self::TreeRecurse($id, '', $list, $children);
        }

        $mitems = array();
        $mitems[] = array('value' => '', 'text' => '&nbsp;', 'id' => 0, 'disabled' => false);
        $lastMenuType = null;
        foreach ($list as $list_a) {
            if ($list_a->menutype !== $lastMenuType) {
                if ($lastMenuType) {
                    $mitems[] = array('value' => '</OPTGROUP>');
                }
                $mitems[] = array('value' => '<OPTGROUP>', 'text' => $list_a->menutype);
                $lastMenuType = $list_a->menutype;
            }
            if ($list_a->type === 'component') {
                $link = $list_a->link . '&Itemid=' . $list_a->id;
            } else {
                $link = '-';
            }
            $mitems[] = array('value' => $link, 'text' => $list_a->treename, 'id' => $list_a->id, 'disabled' => ($link === '-'));
        }
        if ($lastMenuType !== null) {
            $mitems[] = array('value' => '</OPTGROUP>');
        }

        $menuoptions = $mitems;
        return $mitems;
    }

    /**
     * @param int $id
     * @param string $indent
     * @param array $list
     * @param array $children
     * @param int $level
     * @return void
     */
    private static function TreeRecurse($id, $indent, &$list, &$children, $level = 0)
    {
        foreach ($children[$id] as $v) {
            $id = $v->id;
            $list[$id] = $v;
            $list[$id]->treename = $indent . $v->title;
            if (!empty($children[$id]) && $level <= 99) {
                self::TreeRecurse($id, $indent . '&nbsp;&nbsp;', $list, $children, $level + 1);
            }
        }
    }

    /**
     * @param string $name
     * @param string $value
     * @param array $items
     * @return string
     */
    public static function select($name, $value, $items)
    {
        $name = self::id($name);

        if ($value === null) {
            $value = ''; // "global" value
        }

        $value = (string)$value;

        $html = '<select name="' . $name . '" class="form-select">';
        foreach ($items as $key => $item) {
            $disabled = false;
            if (isset($key[1]) && $key[0] === '-') {
                $disabled = true;
                $key = substr($key, 1);
            }
            $html .= '<option value="' . $key . '"'
                . ($value === (string)$key ? ' selected="selected"' : '')
                . ($disabled ? ' disabled="disabled"' : '')
                . '>'
                . $item
                . '</option>';
        }
        $html .= '</select>';
        return $html;
    }

    /**
     * @param string $name
     * @param string $value
     * @param string[] $attrs
     * @return string
     */
    public static function textarea($name, $value, $attrs = array())
    {
        $name = self::id($name);
        $value = (string)$value;

        if (!isset($attrs['rows'])) {
            $attrs['rows'] = 2;
        }

        $attrs['class'] = isset($attrs['class']) ? $attrs['class'] . ' ' : '';
        $attrs['class'] .= 'form-control mj-textarea-autogrow';

        $maxlength = isset($attrs['maxlength']) ? (int)$attrs['maxlength'] : null;
        if ($maxlength !== null) {
            unset($attrs['maxlength']);
            $attrs['class'] .= ' mj-textarea-maxlength';
        }

        $html = '<textarea name="' . $name . '"';
        foreach ($attrs as $attrName => $attrValue) {
            $html .= ' ' . $attrName . '="' . $attrValue . '"';
        }
        $html .= '>' . htmlspecialchars($value) . '</textarea>';

        if ($maxlength !== null) {
            $html .= '<div class="mj-textarea-stats text-end fs-6" data-maxlength="' . $maxlength . '"></div>';
        }

        return $html;
    }

    /**
     * @param string $name
     * @param string $value
     * @return string
     */
    public static function duration($name, $value)
    {
        static $units = array( // Note: desc order is required
            24 * 60 * 60 => 'day',
            60 * 60 => 'hr',
            60 => 'min',
            1 => 'sec',
        );

        $name = self::id($name);

        $unit = 1; // sec [min hr day]
        $value_u = (int)$value;
        if ($value_u > 0) {
            foreach ($units as $u => $title) {
                if ($value_u % $u === 0) {
                    $value_u /= $u;
                    $unit = $u;
                    break;
                }
            }
        }

        $html =
            '<div class="input-group mj-duration">'
            . '<input type="number" min="0" value="' . $value_u . '" class="form-control">'
            . '<input type="hidden" name="' . $name . '" value="' . $value . '">'
            . '<select class="form-select">';
        foreach ($units as $u => $title) {
            $html .= '<option value="' . $u . '"' . ($unit === $u ? ' selected' : '') . '>' . $title . '</option>';
        }
        $html .= '</select>'
            . '</div>';
        return $html;
    }

    /**
     * @param string $name
     * @param string $value
     * @param array $attrs
     * @return string
     */
    public static function hidden($name, $value, $attrs = array())
    {
        $name = self::id($name);

        $attrs['name'] = $name;
        $attrs['id'] = $name;
        $attrs['value'] = htmlspecialchars($value);

        $html = '<input type="hidden"';
        foreach ($attrs as $attrName => $attrValue) {
            $html .= ' ' . $attrName . '="' . $attrValue . '"';
        }
        $html .= '>';

        return $html;
    }

    /**
     * @param string $text_code
     * @return string
     */
    public static function prolabel($text_code)
    {
        return '<label class="mjpro control-label col-sm-4 col-form-label">' . MJText::_($text_code) . '</label>';
    }

    /** @return string */
    public static function proonoff()
    {
        $html =
            '<div class="btn-group flex-wrap">' .
            '<label class="btn btn-outline-success">' .
            '<input type="radio" value="1">' .
            '<span>' . MJText::_('JYES') . '</span>' .
            '</label>' .
            '<label class="btn btn-outline-danger">' .
            '<input type="radio" value="0">' .
            '<span>' . MJText::_('JNO') . '</span>' .
            '</label>' .
            '</div>';
        return $html;
    }

    /** @return string */
    public static function progonoff()
    {
        $html =
            '<div class="btn-group flex-wrap">' .
            '<label class="btn btn-outline-success">' .
            '<input type="radio" value="1">' .
            '<span>' . MJText::_('JYES') . '</span>' .
            '</label>' .
            '<label class="btn btn-outline-info">' .
            '<input type="radio" value="">' .
            '<span>' . MJText::_('COM_PSO__GLOBAL') . '</span>' .
            '</label>' .
            '<label class="btn btn-outline-danger">' .
            '<input type="radio" value="0">' .
            '<span>' . MJText::_('JNO') . '</span>' .
            '</label>' .
            '</div>';
        return $html;
    }

    /**
     * @param string|int $value
     * @param int $min
     * @param int $max
     * @param string $unit
     * @return string
     */
    public static function proslider($value, $min = 0, $max = 100, $unit = '%')
    {
        $html = '<div class="row">'
            . '<div class="col">'
            . '<input type="range" disabled value="' . $value . '" min="' . $min . '" max="' . $max . '" class="form-range mt-2">'
            . '</div>'
            . '<div class="col-auto">'
            . '<div class="input-group">'
            . '<input type="number" disabled value="' . $value . '" min="' . $min . '" max="' . $max . '" class="form-control text-end px-1" style="width:3.3rem;min-width:auto" size="2">'
            . '<span class="input-group-text">' . $unit . '</span>'
            . '</div>'
            . '</div>'
            . '</div>';
        return $html;
    }

    /**
     * @return string
     */
    public static function proinput()
    {
        $html = '<input type="text" class="form-control"/>';

        return $html;
    }

    /**
     * @param array $items
     * @return string
     */
    public static function pronswitch($items)
    {
        $html = '<div class="btn-group flex-wrap">';
        foreach ($items as $title) {
            $html .= '<label class="btn btn-outline-info"><span>' . $title . '</span></label>';
        }
        $html .= '</div>';
        return $html;
    }

    /**
     * @param array $items
     * @return string
     */
    public static function proselect($items)
    {
        $html = '<select class="form-select">';
        foreach ($items as $key => $item) {
            $html .= '<option value="' . $key . '" disabled="disabled">' . $item . '</option>';
        }
        $html .= '</select>';
        return $html;
    }

    /**
     * @return string
     */
    public static function protextarea()
    {
        $html = '<textarea class="form-control" rows="2"></textarea>';

        return $html;
    }

    /**
     * @param string $name
     * @param string|null $accept
     * @return string
     */
    public static function file($name, $accept = null, $disabled = false)
    {
        $html = '<div class="custom-file">'
            . '<input type="file" class="custom-file-input"'
            . ($accept === null ? '' : ' accept="' . $accept . '"') . ' name="' . $name . '" id="' . $name . '">'
            . '<label class="custom-file-label" for="' . $name . '" data-browse="' . MJText::_('COM_PSO__BROWSE') . '">' . MJText::_('COM_PSO__CHOOSE_FILE') . '</label>'
            . '</div>';
        return $html;
    }

    /**
     * @param string $name
     * @param array|string $value
     * @param bool $multiple
     * @return string
     */
    public static function componentslist($name, $value, $multiple = false)
    {
        $options = MJFolder::folders(JPATH_ROOT . '/components');

        $html = '';
        if ($multiple) {
            $html .= '<input type="hidden" name="' . self::id($name) . '[]" value="">';
        }
        $sizeLimit = max(1, min(7, count($options)));
        $html .= '<select class="form-select bg-white" size="' . $sizeLimit . '"';
        if ($name) {
            $html .= ' name="' . self::id($name) . ($multiple ? '[]' : '') . '"';
        }
        if ($multiple) {
            $html .= ' multiple="multiple"';
        }
        $html .= '>';

        $value = (array)$value;

        foreach ($options as $item) {
            $html .=
                '<option value="' . $item . '"' .
                (in_array($item, $value, true) ? ' selected' : '') .
                '>' .
                $item .
                '</option>';
        }

        $html .= '</select>';
        return $html;
    }

    /**
     * @param string|false $url
     * @return string
     */
    public static function settingsbtn($url)
    {
        $html = ($url ? '<a href="' . $url . '">' : '')
            . '<span class="btn btn-outline-info py-1' . ($url ? '' : ' disabled') . '">'
            . MJText::_('COM_PSO__SETTINGS')
            . '<i class="icon-chevron-right ms-2 me-n2"></i>'
            . '</span>'
            . ($url ? '</a>' : '');

        return $html;
    }
}