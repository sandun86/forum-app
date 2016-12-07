<?php
/**
 * @file    ValidationHelper.php
 *
 * ValidationHelper Helper
 *
 * PHP Version 5
 *
 * @author  Sandun Dissanayake <sandunkdissanayake@gmail.com>
 *
 */

namespace App\Libraries\v1;

use App\Libraries\v1\DateHelper;
use Illuminate\Support\Facades\App;
use App\Libraries\v1\Helper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class ValidationHelper
{

    private $validationDateHelper;
    private $helper;

    /**
     * @param DateHelper $validationDateHelper
     * @param Carbon $carbon
     * @param Helper $helper
     */
    public function __construct(DateHelper $validationDateHelper, Carbon $carbon, Helper $helper)
    {
        $this->validationDateHelper = $validationDateHelper;
        $this->carbon = $carbon;
        $this->helper = $helper;
    }

    /**
     * Common validation with models rules
     *
     * @param $inputAll
     * @param $commonRules
     * @return object
     */
    public function validation($inputAll, $commonRules, $messages = [])
    {
        return $validator = \Validator::make($inputAll, $commonRules, $messages);
    }

    /**
     * Check the GET REQUEST parameter passed is set and not empty
     *
     * @param $params
     * @param $key
     * @return bool
     */
    public static function checkQueryArgValid($params, $key)
    {
        return (isset($params[$key]) && $params[$key] != '' && $params[$key] != null) ? true : false;
    }


    /**
         * Check the parameter passed is set and not empty
         *
         * @param $arg
         * @return bool
         */
    public static function isNotEmpty($arg)
    {
        return (isset($arg) && $arg != '' && $arg != null) ? true : false;
    }

    /**
     * Remove script tags from given input
     *
     * @param $value
     * @return mixed
     */
    public function removeScripts($value)
    {
        return preg_replace('#<script(.*?)>(.*?)</script>#is', '', $value);
    }

    /**
     * Check is an integer, if not return default value
     *
     * @param $val
     * @param $default
     * @return mixed
     */
    public function validateNumber($val, $default)
    {
        if (is_numeric($val) &&  (int)$val == $val && $val > 0) {
            return $val;
        } else {
            return $default;
        }
    }

    /**
     * Check is an integer
     *
     * @param $num
     * @return bool
     */
    public function validateInteger($num)
    {
        if (is_numeric($num) && (int)$num == $num && (int)$num > 0) {
            return true;
        } else {
            return false;
        }
    }

}
