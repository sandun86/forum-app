<?php
/**
 * @file    AdminUserRepositoryInterface.php
 *
 * AdminUserRepositoryInterface RepositoryInterface
 *
 * PHP Version 5
 *
 * @author  <Sandun Dissanayake> <sandunkdissanayake@gmail.com>
 *
 */
 
namespace App\Repositories\Contracts\v1;
 
interface AdminUserRepositoryInterface
{

    public function getTokenDetails($token);

}
