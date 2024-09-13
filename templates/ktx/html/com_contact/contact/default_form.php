<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Factory;
use Joomla\Component\Fields\Administrator\Helper\FieldsHelper;

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->useScript('keepalive')
    ->useScript('form.validate');

    $dxn = new Dxn();

    // Load the contact model
    $contactId = 1; // Replace with your contact ID
    $db = Factory::getDbo();
    $query = $db->getQuery(true)
        ->select('*')
        ->from($db->quoteName('#__contact_details'))
        ->where($db->quoteName('id') . ' = ' . $db->quote($contactId));
    $db->setQuery($query);
    $contact = $db->loadObject();

    if ($contact) {
        $fields = FieldsHelper::getFields('com_contact.contact', $contact, true);
        $contactArr = array();
        foreach ($fields as $field) {
            $contactArr[$field->name] = $field->value;
        }
    }
?>
<div class="grid">
    <div class="jl-child-width-1-1 jl-child-width-1-1@s jl-child-width-1-2@m jl-grid-small jl-flex-center" jl-grid>
        <div class="com-contact__form contact-form size-50">
            <form id="contact-form" action="<?php echo Route::_('index.php'); ?>" method="post" class="form-validate form-horizontal well">
                <?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
                    <?php if ($fieldset->name === 'captcha' && $this->captchaEnabled) : ?>
                        <?php continue; ?>
                    <?php endif; ?>
                    <?php $fields = $this->form->getFieldset($fieldset->name); ?>
                    <?php if (count($fields)) : ?>
                        <fieldset class="m-0">
                            <?php if (isset($fieldset->label) && ($legend = trim(Text::_($fieldset->label))) !== '') : ?>
                                <legend><?php echo $legend; ?></legend>
                            <?php endif; ?>
                            <?php foreach ($fields as $field) : ?>
                                <?php echo $field->renderField(); ?>
                            <?php endforeach; ?>
                        </fieldset>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php if ($this->captchaEnabled) : ?>
                    <?php echo $this->form->renderFieldset('captcha'); ?>
                <?php endif; ?>
                <div class="control-group">
                    <div class="controls">
                        <button class="btn btn-primary validate" type="submit"><?php echo Text::_('COM_CONTACT_CONTACT_SEND'); ?></button>
                        <input type="hidden" name="option" value="com_contact">
                        <input type="hidden" name="task" value="contact.submit">
                        <input type="hidden" name="return" value="<?php echo $this->return_page; ?>">
                        <input type="hidden" name="id" value="<?php echo $this->item->slug; ?>">
                        <?php echo HTMLHelper::_('form.token'); ?>
                    </div>
                </div>
            </form>
        </div>
        <!--<div class="com-contact__form contact-form size-50">
            <div class="appear-animation animated fadeIn appear-animation-visible" data-appear-animation="fadeIn" data-appear-animation-delay="800" style="animation-delay: 800ms;">
                <div style="text-align: center;"><span style="font-size:18px;"><span style="color:#ff0000;"><strong>TỔNG ĐÀI KÝ TÚC XÁ: 1900.055.559</strong></span></span></div>

                <div style="text-align: center;"><span style="font-size:18px;"><span style="color:#ff0000;"><strong>DANH BẠ TRUNG TÂM QUẢN LÝ KÝ TÚC XÁ ĐHQG-HCM</strong></span></span></div>

                <p><button class="accordion active" style="box-sizing: border-box; color: rgb(2, 65, 130); font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; font-size: 15px; line-height: inherit; font-family: inherit; margin: 0px; overflow: visible; text-transform: none; appearance: button; cursor: pointer; background-color: rgb(248, 180, 51); padding: 18px; width: 870px; border: none; text-align: left; outline: none; transition: all 0.4s ease 0s; orphans: 2; white-space: normal; widows: 2; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;">Các số điện thoại khẩn cấp</button><span style="color: rgb(85, 85, 85); font-family: Arial; font-size: 13px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;"></span></p>

                <div class="panel" style="box-sizing: border-box; margin-bottom: 20px; background-color: white; border: 1px solid transparent; border-radius: 4px; box-shadow: none; padding: 0px 18px; max-height: 226px; overflow: hidden; transition: max-height 0.2s ease-out 0s; color: rgb(85, 85, 85); font-family: Arial; font-size: 13px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;">
                    <table border="1" class="table table-striped table-bordered" height="207" id="NhanSu" style="box-sizing: border-box; border-collapse: collapse; border-spacing: 0px; background-color: transparent; font-family: &quot;Noto Sans&quot;, sans-serif; font-size: 16px; margin: 10px 0px; border: 1px solid black; color: rgb(34, 34, 34) !important; width: 100%;" width="832">
                        <tbody style="box-sizing: border-box;">
                        <tr style="box-sizing: border-box;">
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 83.0938px;">Stt</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 332.391px;">Tên đơn vị</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 131px;">Số nội bộ</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 283px;">Khu</td>
                        </tr>
                        <tr style="box-sizing: border-box; background-color: rgb(242, 242, 242);">
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 83.0938px;">1</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 332.391px;">Bảo vệ cổng chính</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 131px;">107</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 283px;">Khu B</td>
                        </tr>
                        <tr style="box-sizing: border-box;">
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 83.0938px;">2</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 332.391px;">Bảo vệ cổng phụ</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 131px;">108</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 283px;">Khu B</td>
                        </tr>
                        <tr style="box-sizing: border-box; background-color: rgb(242, 242, 242);">
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 83.0938px;">3</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 332.391px;">Bảo vệ cổng chính</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 131px;">109</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 283px;">Khu A</td>
                        </tr>
                        <tr style="box-sizing: border-box;">
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 83.0938px;">4</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 332.391px;">Công an phường Đông Hòa</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 131px;">(0274) 3750872</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 283px;">Khu B</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <p><button class="accordion active" style="box-sizing: border-box; color: rgb(2, 65, 130); font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; font-size: 15px; line-height: inherit; font-family: inherit; margin: 0px; overflow: visible; text-transform: none; appearance: button; cursor: pointer; background-color: rgb(248, 180, 51); padding: 18px; width: 870px; border: none; text-align: left; outline: none; transition: all 0.4s ease 0s; orphans: 2; white-space: normal; widows: 2; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;">Ký túc xá - Khu A</button><span style="color: rgb(85, 85, 85); font-family: Arial; font-size: 13px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;"></span></p>

                <div class="panel" style="box-sizing: border-box; margin-bottom: 20px; background-color: white; border: 1px solid transparent; border-radius: 4px; box-shadow: none; padding: 0px 18px; max-height: 267px; overflow: hidden; transition: max-height 0.2s ease-out 0s; color: rgb(85, 85, 85); font-family: Arial; font-size: 13px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;">
                    <table border="1" class="table" id="NhanSu" style="box-sizing: border-box; border-collapse: collapse; border-spacing: 0px; background-color: transparent; font-family: &quot;Noto Sans&quot;, sans-serif; font-size: 16px; margin: 10px 0px; border: 1px solid black; width: 100%; color: rgb(34, 34, 34) !important;">
                        <tbody style="box-sizing: border-box;">
                        <tr style="box-sizing: border-box;">
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 83.0938px;">Stt</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 332.391px;">Tên đơn vị</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 124.641px;">Số nội bộ</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 290.875px;">Khu</td>
                        </tr>
                        <tr style="box-sizing: border-box; background-color: rgb(242, 242, 242);">
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 83.0938px;">1</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 332.391px;">Bảo vệ cổng chính</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 124.641px;">109</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 290.875px;">Khu A</td>
                        </tr>
                        <tr style="box-sizing: border-box;">
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 83.0938px;">2</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 332.391px;">Trạm y tế</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 124.641px;">119</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 290.875px;">Khu A</td>
                        </tr>
                        <tr style="box-sizing: border-box; background-color: rgb(242, 242, 242);">
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 83.0938px;">3</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 332.391px;">Ban quản lý cụm nhà A.F</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 124.641px;">120</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 290.875px;">Khu A</td>
                        </tr>
                        <tr style="box-sizing: border-box;">
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 83.0938px;">4</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 332.391px;">Ban quản lý cụm nhà A.G</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 124.641px;">121</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 290.875px;">Khu A</td>
                        </tr>
                        <tr style="box-sizing: border-box; background-color: rgb(242, 242, 242);">
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 83.0938px;">5</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 332.391px;">Ban quản lý cụm nhà A.H</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 124.641px;">122</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 290.875px;">Khu A</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <p><button class="accordion active" style="box-sizing: border-box; color: rgb(2, 65, 130); font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; font-size: 15px; line-height: inherit; font-family: inherit; margin: 0px; overflow: visible; text-transform: none; appearance: button; cursor: pointer; background-color: rgb(248, 180, 51); padding: 18px; width: 870px; border: none; text-align: left; outline: none; transition: all 0.4s ease 0s; orphans: 2; white-space: normal; widows: 2; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;">Ký túc xá - Khu B</button><span style="color: rgb(85, 85, 85); font-family: Arial; font-size: 13px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;"></span></p>

                <div class="panel" style="box-sizing: border-box; margin-bottom: 20px; background-color: white; border: 1px solid transparent; border-radius: 4px; box-shadow: none; padding: 0px 18px; max-height: 1012px; overflow: hidden; transition: max-height 0.2s ease-out 0s; color: rgb(85, 85, 85); font-family: Arial; font-size: 13px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;">
                    <table border="1" class="table" id="NhanSu" style="box-sizing: border-box; border-collapse: collapse; border-spacing: 0px; background-color: transparent; font-family: &quot;Noto Sans&quot;, sans-serif; font-size: 16px; margin: 10px 0px; border: 1px solid black; width: 100%; color: rgb(34, 34, 34) !important;">
                        <tbody style="box-sizing: border-box;">
                        <tr style="box-sizing: border-box;">
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 83.0938px;">Stt</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 332.391px;">Tên đơn vị</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 124.641px;">Số nội bộ</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 290.875px;">Khu</td>
                        </tr>
                        <tr style="box-sizing: border-box; background-color: rgb(242, 242, 242);">
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 83.0938px;">1</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 332.391px;">Giám đốc Tăng Hữu Thủy</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 124.641px;">100</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 290.875px;">Khu B</td>
                        </tr>
                        <tr style="box-sizing: border-box;">
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 83.0938px;">2</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 332.391px;">Phó Giám đốc Ngô Văn Hải</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 124.641px;">102</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 290.875px;">Khu B</td>
                        </tr>
                        <tr style="box-sizing: border-box; background-color: rgb(242, 242, 242);">
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 83.0938px;">3</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 332.391px;">Phó Giám đốc Phùng Thị Hương Lan</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 124.641px;">103</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 290.875px;">Khu B</td>
                        </tr>
                        <tr style="box-sizing: border-box;">
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 83.0938px;">4</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 332.391px;">Phó Giám đốc Dương Văn Tuấn</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 124.641px;">104</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 290.875px;">Khu B</td>
                        </tr>
                        <tr style="box-sizing: border-box; background-color: rgb(242, 242, 242);">
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 83.0938px;">5</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 332.391px;">Phòng Công tác sinh viên</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 124.641px;">105</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 290.875px;">Khu B</td>
                        </tr>
                        <tr style="box-sizing: border-box;">
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 83.0938px;">6</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 332.391px;">Bộ phận An ninh - Phòng CTSV</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 124.641px;">106</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 290.875px;">Khu B</td>
                        </tr>
                        <tr style="box-sizing: border-box; background-color: rgb(242, 242, 242);">
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 83.0938px;">7</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 332.391px;">Bảo vệ cổng chính</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 124.641px;">107</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 290.875px;">Khu B</td>
                        </tr>
                        <tr style="box-sizing: border-box;">
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 83.0938px;">8</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 332.391px;">Bảo vệ cổng phụ</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 124.641px;">108</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 290.875px;">Khu B</td>
                        </tr>
                        <tr style="box-sizing: border-box; background-color: rgb(242, 242, 242);">
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 83.0938px;">9</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 332.391px;">Phòng Quản trị thiết bị</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 124.641px;">110</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 290.875px;">Khu B</td>
                        </tr>
                        <tr style="box-sizing: border-box;">
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 83.0938px;">10</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 332.391px;">Phòng Tổng hợp</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 124.641px;">111</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 290.875px;">Khu B</td>
                        </tr>
                        <tr style="box-sizing: border-box; background-color: rgb(242, 242, 242);">
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 83.0938px;">11</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 332.391px;">Phòng Kế hoạch - tài chính</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 124.641px;">112</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 290.875px;">Khu B</td>
                        </tr>
                        <tr style="box-sizing: border-box;">
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 83.0938px;">12</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 332.391px;">Phòng Dịch vụ - dự án</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 124.641px;">113</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 290.875px;">Khu B</td>
                        </tr>
                        <tr style="box-sizing: border-box; background-color: rgb(242, 242, 242);">
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 83.0938px;">13</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 332.391px;">Phòng CNTT-DL(Hỗ trợ kỹ thuật mạng - phần cứng)</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 124.641px;">114</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 290.875px;">Khu B</td>
                        </tr>
                        <tr style="box-sizing: border-box;">
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 83.0938px;">14</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 332.391px;">Phòng CNTT-DL (Hỗ trợ kỹ thuật phần mềm)</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 124.641px;">115</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 290.875px;">Khu B</td>
                        </tr>
                        <tr style="box-sizing: border-box; background-color: rgb(242, 242, 242);">
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 83.0938px;">15</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 332.391px;">Trạm y tế (Văn phòng B1)</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 124.641px;">116</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 290.875px;">Khu B</td>
                        </tr>
                        <tr style="box-sizing: border-box;">
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 83.0938px;">16</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 332.391px;">Trạm y tế (Hỗ trợ sức khỏe tinh thần B1)</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 124.641px;">117</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 290.875px;">Khu B</td>
                        </tr>
                        <tr style="box-sizing: border-box; background-color: rgb(242, 242, 242);">
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 83.0938px;">17</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 332.391px;">Trạm y tế (Phòng khám B1)</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 124.641px;">118</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 290.875px;">Khu B</td>
                        </tr>
                        <tr style="box-sizing: border-box;">
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 83.0938px;">18</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 332.391px;">Ban quản lý cụm nhà B.A</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 124.641px;">123</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 290.875px;">Khu B</td>
                        </tr>
                        <tr style="box-sizing: border-box; background-color: rgb(242, 242, 242);">
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 83.0938px;">19</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 332.391px;">Ban quản lý cụm nhà B.B</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 124.641px;">124</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 290.875px;">Khu B</td>
                        </tr>
                        <tr style="box-sizing: border-box;">
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 83.0938px;">20</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 332.391px;">Ban quản lý cụm nhà B.C</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 124.641px;">125</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 290.875px;">Khu B</td>
                        </tr>
                        <tr style="box-sizing: border-box; background-color: rgb(242, 242, 242);">
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 83.0938px;">21</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 332.391px;">Ban quản lý cụm nhà B.D</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 124.641px;">126</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 290.875px;">Khu B</td>
                        </tr>
                        <tr style="box-sizing: border-box;">
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 83.0938px;">22</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 332.391px;">Ban quản lý cụm nhà B.E</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 124.641px;">127</td>
                            <td style="box-sizing: border-box; padding: 8px; border: 1px solid rgb(221, 221, 221); width: 290.875px;">Khu B</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="layoutmanager">&nbsp;</div>

                <div class="layoutmanager">&nbsp;</div>

                <div class="layoutmanager">&nbsp;</div>

                <div class="layoutmanager">&nbsp;</div>

                <div class="layoutmanager">&nbsp;</div>
            </div>
        </div>-->

        <?php echo $contactArr['hotlines']; ?>

    </div>
</div>
