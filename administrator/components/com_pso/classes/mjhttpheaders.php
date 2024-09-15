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
class MjHttpHeaders extends Ressio_HttpHeaders
{
    /** @return void */
    public function sendHeaders()
    {
        $joomlaWrapper = MjJoomlaWrapper::getInstance();
        foreach ($this->headers as $line) {
            if (is_array($line)) {
                foreach ($line as $header_line) {
                    list ($name, $value) = explode(':', $header_line);
                    $joomlaWrapper->setHeader($name, trim($value));
                }
            } else {
                list ($name, $value) = explode(':', $line);
                $joomlaWrapper->setHeader($name, trim($value));
            }
        }
    }
}
