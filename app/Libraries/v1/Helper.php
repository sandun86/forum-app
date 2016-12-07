<?php
/**
 * @file    Helper.php
 *
 * Helper Helper
 *
 * PHP Version 5
 *
 * @author  Sandun Dissanayake <sandunkdissanayake@gmail.com>
 *
 */

namespace App\Libraries\v1;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class Helper
{
    public function __construct()
    {
    }

    /**
     * Get response
     *
     * @param $status
     * @param $message
     * @return $this
     */
    public function response($status, $message)
    {
        return (new Response($message, $status))
            ->header('Content-Type', 'application/json');
    }

    /**
     * Get constants value from config
     *
     * @param $file
     * @param $key
     *
     * @return mixed
     */
    public function getConstants($file, $key)
    {
        return Config::get('constants.' . $file . '.' . $key);
    }

    /**
     * Get constants value from config
     *
     * @param $file
     * @param $key
     *
     * @return mixed
     */
    public function getConstantsWithOutArrayKeys($file, $key)
    {
        return array_values(Config::get('constants.' . $file . '.' . $key));
    }

    public function generateToken($userId)
    {
        return \sha1($userId . date('Y-m-d h:i:s'));
    }

    /**
     * Escape some char from string
     *
     * @param $string
     * @return object
     */
    public function escapeLike($string)
    {
        $search = array('%', '_');
        $replace   = array('\%', '\_');
        
        return str_replace($search, $replace, $string);
    }

}
