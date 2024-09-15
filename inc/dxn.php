<?php
defined('_JEXEC') or die('Restricted access');


use PhpOffice\PhpSpreadsheet\IOFactory;


class Dxn
{
    function showModule($position, $style = '')
    {
        $document = \Joomla\CMS\Factory::getDocument();
        $renderer = $document->loadRenderer('modules');
        $options = array('style' => $style);
        echo $renderer->render($position, $options, null);
    }

    function getInfoweb($field = null)
    {
        $db = \Joomla\CMS\Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*')
            ->from($db->quoteName('#__informations'))
            ->where('id = 1');
        $db->setQuery($query);
        $result = $db->loadObject();
        if ($field != null) {
            return $result->$field;
        } else {
            return $result;
        }

        return;

    }

//check image exist
        function isAvailableImage($imgUrl)
        {
            $response = get_headers($imgUrl, 1);
            return (strpos($response[0], "404") === false);
        }

        function rrmdir($path)
        {
            $i = new DirectoryIterator($path);
            foreach ($i as $f) {
                if ($f->isFile()) {
                    unlink($f->getRealPath());
                } else if (!$f->isDot() && $f->isDir()) {
                    rrmdir($f->getRealPath());
                    rmdir($f->getRealPath());
                }
            }
            rmdir($path);
        }

        function getAttribsByArticle($article_id, $group_id = 0)
        {  //using for both article and categories
            $db = \Joomla\CMS\Factory::getDbo();
            $query = $db->getQuery(true);
            $query->select('f.name AS fieldname, fv.value AS fieldvalue');
            $query->from('`#__fields_values` AS fv');
            $query->join('LEFT', '#__fields AS f ON f.id = fv.field_id');
            $query->where('fv.item_id = ' . $article_id);
            if ($group_id > 0) {
                $query->where('f.group_id=' . $group_id);
            }
            $db->setQuery($query);
            $rs = $db->loadObjectList();
            if ($rs) {
                $result = array();
                foreach ($rs as $item) {
                    $result["{$item->fieldname}"] = $item->fieldvalue;
                }
                return $result;
            }
        }

        function getSubcategoryIDFromCatID($catid)
        {
            $categories = JCategories::getInstance('Content');
            $cat = $categories->get($catid);
            return $cat->getChildren();
        }

        function getFieldsNameByCatID($catid)
        {
            JLoader::register('FieldsHelper', JPATH_ADMINISTRATOR . '/components/com_fields/helpers/fields.php');
            $catFields = FieldsHelper::getFields('com_content.categories', $catid, true);
            return $catFields;
        }

        function getFieldsValuesByCatID($catid)
        {
            JLoader::register('FieldsHelper', JPATH_ADMINISTRATOR . '/components/com_fields/helpers/fields.php');
            $catFields = FieldsHelper::getFields('com_content.categories', $catid, true);
            $model = JModelLegacy::getInstance('Field', 'FieldsModel', array('ignore_request' => true));

            $categoryFieldsIds = array('21', '22');
            $currentCatFields = $model->getFieldValues($categoryFieldsIds, $catid);
            return $currentCatFields;
        }

        function getFetchAllFieldsFromCatID($catid)
        {
            JLoader::register('FieldsHelper', JPATH_ADMINISTRATOR . '/components/com_fields/helpers/fields.php');
            $jcategories = JCategories::getInstance('Content');
            $category = $jcategories->get($catid);
            $currentCatFields = FieldsHelper::getFields('com_content.categories', $category, true);
            return $currentCatFields;
        }

        function getCategory($catid)
        {
            $categories = JCategories::getInstance('Content');
            return $categories->get($catid);
        }

        function getSubmenu($parent_id)
        { //chon list menu con
            $db = \Joomla\CMS\Factory::getDbo();
            $query = $db->getQuery(true);
            $query->select('*')
                ->from($db->quoteName('#__menu'))
                ->where('parent_id = ' . $db->quote($parent_id));
            $db->setQuery($query);
            return $db->loadObjectList();
        }

        function getRowsByFieldValue($table, $field, $value)
        {
            $db = \Joomla\CMS\Factory::getDbo();
            $query = $db->getQuery(true);
            $query->select('*')
                ->from($db->quoteName("{$table}"))
                ->where("{$field} = " . $db->quote($value));
            //->order('name ASC');
            $db->setQuery($query);

            return $db->loadObjectList();
        }

        function getListStoreInPrograms($ids)
        {
            $arrids = @explode(',', $ids);
            $rs = array();
            foreach ($arrids as $id) {
                $db = \Joomla\CMS\Factory::getDbo();
                $query = $db->getQuery(true);
                $query->select('d.*')
                    ->from('#__district AS d')
                    ->join('INNER', '#__strores AS s ON s.district = d.id')
                    ->where('d.province_id =' . $id)
                    ->where('d.state = 1')
                    ->group('s.district')
                    ->order('d.name ASC');
                $db->setQuery($query);
                $results = $db->loadObjectList();
                if ($results):
                    $arrstores = array();
                    foreach ($results as $val):
                        $objStores = new stdClass();
                        $liststore = getRowsTableByFieldValue('#__strores', 'district', $val->id);
                        $objStores->district_id = $val->id;
                        $objStores->district_name = $val->name;
                        if ($liststore) {
                            $objStores->list_store = $liststore;
                        }
                        $arrstores[] = $objStores;
                    endforeach;
                    $rs[$id] = $arrstores;
                endif;

            }
            return $rs;
        }

        function getSubmenuImage()
        {
            $lang = \Joomla\CMS\Factory::getLanguage()->getTag();
            $menu = \Joomla\CMS\Factory::getApplication()->getMenu();
            $parentid = ($lang == 'vi-VN') ? 137 : 161;
            $childs = $menu->getItems('parent_id', $parentid);
            return $childs;
        }

        function getRelateProducts($catid, $id, $lang)
        {
            $db = \Joomla\CMS\Factory::getDbo();
            $query = $db->getQuery(true);
            $query->select('*')
                ->from('#__content')
                ->where('state = 1')
                ->where('catid = ' . $catid)
                ->where('language = "' . $lang . '"')
                ->where('id != ' . $id)
                ->setLimit(6)
                ->order('ordering ASC');
            $db->setQuery($query);
            $items = $db->loadObjectList();

            return $items;
        }

        function getFieldById($table, $id, $field = null)
        {
            $db = \Joomla\CMS\Factory::getDbo();
            $query = $db->getQuery(true);
            $query->select('*')
                ->from($db->quoteName($table))
                ->where('id =' . $db->quote($id));
            $db->setQuery($query);
            $result = $db->loadObject();
            if ($field != null) {
                return $result->$field;
            } else {
                return $result;
            }
        }

        function checkPermisionUpdateInDay($update_date)
        {
            $upd = date('Y-m-d 00:00:00', strtotime($update_date));
            $today = date('Y-m-d H:i:s');
            $datetime = new DateTime($upd);
            $datetime->modify('+1 day');
            $expireday = $datetime->format('Y-m-d H:i:s');
            if (strtotime($upd) <= strtotime($today) && strtotime($today) < strtotime($expireday)) {
                $ischecked = true;
            } else {
                $ischecked = false;
            }
            return $ischecked;
        }

        function getCurrentUrl()
        {
            return JURI::current();
        }

// khoi tao session
        function setSession($sName, $sValue)
        {
            $session = \Joomla\CMS\Factory::getSession();
            $session->set($sName, $sValue);
        }

//get session
        function getSession($sName)
        {
            $session = \Joomla\CMS\Factory::getSession();
            return $session->get($sName);
        }

//huy session
        function deleteSession($sName)
        {
            $session = \Joomla\CMS\Factory::getSession();
            $session->set($sName, NULL);
        }

        function share()
        {
            $str = '<!-- AddThis Button BEGIN -->
			<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
				<a class="addthis_button_preferred_2"></a>
				<a class="addthis_button_preferred_3"></a>
				<a class="addthis_button_preferred_1"></a>
				<a class="addthis_button_preferred_4"></a>
				<a class="addthis_button_compact"></a>
			</div>
			<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4f9f765d777c2fee"></script>
			<!-- AddThis Button END -->';
            return $str;
        }

        public function shareFb() {
            echo '<div class="fb-share-button" data-href="<?php echo JUri::current(); ?>" data-layout="button_count"></div>
    
            <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v12.0" nonce="1q2w3e4r"></script>
            ';
        }

        function ham_loc_dau($st)
        {
            /*
             * Func trả về một chuỗi ký tự không dấu
             * Ví dụ: "trả Về một chuỗi ký" =>"tra-Ve-mot-chuoi-ky"
             *
             */
            $codau = array("à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă",
                "ằ", "ắ", "ặ", "ẳ", "ẵ", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề"
            , "ế", "ệ", "ể", "ễ",
                "ì", "í", "ị", "ỉ", "ĩ",
                "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ"
            , "ờ", "ớ", "ợ", "ở", "ỡ",
                "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ",
                "ỳ", "ý", "ỵ", "ỷ", "ỹ",
                "đ",
                "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă"
            , "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ",
                "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ",
                "Ì", "Í", "Ị", "Ỉ", "Ĩ",
                "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ"
            , "Ờ", "Ớ", "Ợ", "Ở", "Ỡ",
                "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ",
                "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ",
                "Đ", " ", "/");
            $khongdau = array("a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a"
            , "a", "a", "a", "a", "a", "a",
                "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e",
                "i", "i", "i", "i", "i",
                "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o"
            , "o", "o", "o", "o", "o",
                "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u",
                "y", "y", "y", "y", "y",
                "d",
                "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A"
            , "A", "A", "A", "A", "A",
                "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E",
                "I", "I", "I", "I", "I",
                "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O"
            , "O", "O", "O", "O", "O",
                "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U",
                "Y", "Y", "Y", "Y", "Y",
                "D", "-", "-");
            return str_replace($codau, $khongdau, $st);
        }

        function cutString($str, $num)
        {
            /*
             * hàm trả về một chuỗi ký tự sau khi cắt
             *
             * $str là chuỗi ký tự đưa vào
             *
             * $num là ký tự đã cắt
             *
             */
            if (strlen($str) > $num) {
                $str = substr($str, 0, $num);
                $str = substr($str, 0, strripos($str, ' '));
                return $str . '...';
            }
            return $str;
        }

        function get_first_image($text)
        {
            /*
             * Trả về image đầu tiên của bài viết
             * $text là nội dung của bài viết
             */

            preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $text, $matches);
            if (count($matches[1]) > 0) {
                $first_img = $matches [1][0];
            } else {
                $first_img = '/uploads/no-image.jpg';
            }
            return $first_img;
        }

        function getItemByID($table, $id)
        {
            $db = \Joomla\CMS\Factory::getDbo();
            $query = $db->getQuery(true);
            $query->select('*')
                ->from($db->quoteName($table))
                ->where('id = ' . $id);
            $db->setQuery($query);
            return $db->loadObject();

        }

        public function makeThumbnail($sourcefile, $max_width, $max_height, $endfile, $type)
        {
            // Takes the sourcefile (path/to/image.jpg) and makes a thumbnail from it
            // and places it at endfile (path/to/thumb.jpg).
            // Load image and get image size.
            //
            switch ($type) {
                case'image/png':
                    $img = imagecreatefrompng($sourcefile);
                    break;
                case'image/jpeg':
                    $img = imagecreatefromjpeg($sourcefile);
                    break;
                case'image/gif':
                    $img = imagecreatefromgif($sourcefile);
                    break;
                default :
                    return 'Un supported format';
            }

            $width = imagesx($img);
            $height = imagesy($img);

            if ($width > $height) {
                if ($width < $max_width)
                    $newwidth = $width;

                else

                    $newwidth = $max_width;


                $divisor = $width / $newwidth;
                $newheight = floor($height / $divisor);
            } else {

                if ($height < $max_height)
                    $newheight = $height;
                else
                    $newheight = $max_height;

                $divisor = $height / $newheight;
                $newwidth = floor($width / $divisor);
            }

            // Create a new temporary image.
            $tmpimg = imagecreatetruecolor($newwidth, $newheight);

            imagealphablending($tmpimg, false);
            imagesavealpha($tmpimg, true);

            // Copy and resize old image into new image.
            imagecopyresampled($tmpimg, $img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

            // Save thumbnail into a file.

            //compressing the file


            switch ($type) {
                case'image/png':
                    imagepng($tmpimg, $endfile, 0);
                    break;
                case'image/jpeg':
                    imagejpeg($tmpimg, $endfile, 100);
                    break;
                case'image/gif':
                    imagegif($tmpimg, $endfile, 0);
                    break;

            }

            // release the memory
            imagedestroy($tmpimg);
            imagedestroy($img);
        }

        /**
         * get answers existed in the default list
         * @param $componentId
         * @param $question
         * @return array|false|string[]
         */
        public function getAnswerList($componentId, $question) {
            $db    = \Joomla\CMS\Factory::getDbo();
            $query = $db->getQuery(true);
            $query->select($db->qn('p.PropertyValue'))
                ->from($db->qn('#__rsform_properties','p'))
                ->where($db->qn('p.PropertyName') . ' = ' . $db->q('ITEMS'))
                ->where($db->qn('p.ComponentId') . ' = ' . $db->q($componentId));
            $result = $db->setQuery($query)->loadResult();
            $items = array();
            if(!empty($result)) {
                $items = @explode(PHP_EOL, $result);
            }
            return $items;
        }

        /**
         * Chec if there is any the survey link
         * @param $componentId
         * @param $question
         * @return array|false|string[]
         */
        public function hasSurverAvailable() {
            $db    = \Joomla\CMS\Factory::getDbo();
            $query = $db->getQuery(true);
            $query->select('COUNT(*)')
                ->from($db->qn('#__menu','m'))
                ->where($db->qn('m.menutype') . ' = ' . $db->q('surveymenu'))
                ->where($db->qn('m.published') . ' = 1')
                ->where('NOW() BETWEEN ' . $db->qn('m.start_date'). ' AND (DATE_ADD(' . $db->qn('m.end_date'). ', INTERVAL 1 DAY) - INTERVAL 1 SECOND)')
            ;
            $rs = $db->setQuery($query)->loadResult();

            return ($rs > 0);
        }

        public function getPropertyValueCaption($componentId) {
            $db    = \Joomla\CMS\Factory::getDbo();
            $query = $db->getQuery(true);
            $query->select('rp.PropertyValue')
                ->from($db->qn('#__rsform_properties', 'rp'))
                ->where($db->qn('rp.ComponentId') . ' = ' . $db->q($componentId))
                ->where($db->qn('rp.PropertyName') . ' = ' . $db->q('CAPTION'));
            return $db->setQuery($query)->loadResult();
        }

        public function getExistSubmit($id, $formId){
            $db    = \Joomla\CMS\Factory::getDbo();
            $query = $db->getQuery(true)
                ->select('s.UserId')
                ->from($db->qn('#__rsform_submissions', 's'))
                ->where($db->qn('s.FormId') . ' = ' . $formId)
                ->where($db->qn('s.UserId') . ' = ' . $db->q($id));
            return $db->setQuery($query)->loadResult();
        }

        public function getUserGroup($group) {
            $db    = \Joomla\CMS\Factory::getDbo();
            $query = $db->getQuery(true);
            $query->select('id')
                ->from($db->qn('#__usergroups'))
                ->where($db->qn('title').' = ' . $db->quote($group));

            $db->setQuery($query);
            return $db->loadResult();
        }

        public function getAccessLevels($formId) {
            $form = $this->getForm($formId);
            if(empty($form->Access)) {
                return '';
            }

            $db = \Joomla\CMS\Factory::getDbo();
            $query = $db->getQuery(true);
            $query->select('rules')
                ->from($db->qn('#__viewlevels'))
                ->where($db->qn('id').' = ' .$db->q($form->Access));
            $db->setQuery($query);
            return $db->loadResult();
        }

        public function getForm($formId) {
            $formId = (int) $formId;

            if (isset($formId)) {
                $db    = \Joomla\CMS\Factory::getDbo();
                $query = $db->getQuery(true);
                $query->clear()
                    ->select('*')
                    ->from($db->qn('#__rsform_forms'))
                    ->where($db->qn('FormId').'='.$db->q($formId));

                $db->setQuery($query);
                return $db->loadObject();
            }
        }

        public function checkGroupAccessPermission($groupName, $formId) {
            $groupId     = @$this->getUserGroup($groupName);
            $accessLevel = @$this->getAccessLevels($formId);

            if( empty($accessLevel) ) {
                return true;
            }

            $accessLevel = explode(',', trim($accessLevel, '[]'));

            if( in_array($groupId, $accessLevel) ) {
                return true;
            }

            return false;
        }

        public function checkPersonAccessPermission($cccd, $formid) {
            $dxn = new Dxn();
            $accessForm = $dxn->getRowsByFieldValue('#__importsv', 'cccd', $cccd);
            if ($accessForm && in_array($formid, $accessForm[0]->formid)) {
                return true;
            }

            return false;
        }

        public function getFieldDataBySubmissionId($submissionId, $formId) {
            $db    = \Joomla\CMS\Factory::getDbo();
            $query = $db->getQuery(true);
            $query->clear()
                ->select('*')
                ->from($db->qn('#__rsform_submission_values'))
                ->where($db->qn('formid').'='.$db->q($formId))
                ->where($db->qn('submissionId').'='.$db->q($submissionId));
            $db->setQuery($query);
            $result  = $db->loadObjectList();
            if ($result) {
                foreach($result as $value) {

                }
            }
        }

        public function readExcel($filePath)
        {
            set_time_limit(0);
            $spreadsheet = IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();

            $highestColumn = $sheet->getHighestColumn();
            $highestRow = $sheet->getHighestRow();
            $result = array();
            for ($row = 1; $row <= $highestRow; $row++) {
                $rowData = array();
                for ($col = 'A'; $col <= $highestColumn; $col++) {
                    $cellValue = $sheet->getCell($col . $row)->getValue();
                    $rowData[] = $cellValue;
                }
                $result[] = $rowData;
            }

            return $result;
        }

        /**
         * export excel
         * @param $data
         * @return void
         */
        function exportReportExcel($excelData)
        {
            require_once JPATH_ROOT.'/inc/PhpXlsxGenerator.php';

            // Excel file name for download
            $fileName = "Xuat_danh_sach_" . date('Y-m-d') . ".xlsx";

            // Define column names
            /*$excelData[] = array('ID', 'FIRST NAME', 'LAST NAME', 'EMAIL', 'GENDER', 'COUNTRY', 'CREATED', 'STATUS');

            // Fetch records from database and store in an array
            $query = $db->query("SELECT * FROM members ORDER BY id ASC");
            if($query->num_rows > 0){
                while($row = $query->fetch_assoc()){
                    $status = ($row['status'] == 1)?'Active':'Inactive';
                    $lineData = array($row['id'], $row['first_name'], $row['last_name'], $row['email'], $row['gender'], $row['country'], $row['created'], $status);
                    $excelData[] = $lineData;
                }
            }*/

            // Export data to excel and download as xlsx file
            $xlsx = CodexWorld\PhpXlsxGenerator::fromArray($excelData);
            $xlsx->downloadAs($fileName);
            //$xlsx->saveAs('members-data.xlsx'); // save on server
            exit;
        }

        public function log($data){
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $text = date('Y-m-d H:i:s').' ------------- '.PHP_EOL;
            $filePath = '../administrator/logs/dxn.log';

            $file = fopen($filePath, 'a');
            fwrite($file, print_r($text, true));
            fwrite($file, print_r($data, true));
            fwrite($file, print_r(PHP_EOL));


            fclose($file);
        }

    }