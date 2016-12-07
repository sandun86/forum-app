<?php
/**
 * @file    DateHelper.php
 *
 * DateHelper Helper
 *
 * PHP Version 5
 *
 * @author  Sandun Dissanayake <sandunkdissanayake@gmail.com>
 *
 */

namespace App\Libraries\v1;

use Carbon\Carbon;
use DateTime;
use App\Libraries\v1\Helper;

class DateHelper
{
    private $carbon;
    private $helper;

    /**
     * @param Carbon $carbon
     * @param Helper $helper
     */
    public function __construct(Carbon $carbon, Helper $helper)
    {
        $this->carbon = $carbon;
        $this->helper = $helper;
    }

    /**
     * Get current date
     *
     * @param string $format
     * @return string
     */
    public function getCurrentDate($format = null)
    {
        $format = ($format == null) ? $this->dateFormat : $format;

        return $this->carbon->timezone($this->timeZone)->format($format);
    }

    /**
     * Convert date to another format
     *
     * @param $date
     * @param string $format
     * @return string
     */
    public function processDate($date, $format = null)
    {
        $format = ($format == null) ? $this->dateFormat : $format;

        return $this->carbon->parse($date)->format($format);
    }

}
