<?php
/**
 * @file    UserRepositoryInterface.php
 *
 * UserRepositoryInterface RepositoryInterface
 *
 * PHP Version 5
 *
 * @author  <Sandun Dissanayake> <sandunkdissanayake@gmail.com>
 *
 */
 
namespace App\Repositories\Contracts\v1;
 
interface UserRepositoryInterface
{
    /**
     * Insert user
     *
     * @param $data
     * @return array
     */
    public function create($data);

    public function getTokenDetails($token);

}
