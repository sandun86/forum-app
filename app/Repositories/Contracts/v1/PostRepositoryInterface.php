<?php
/**
 * @file    PostRepositoryInterface.php
 *
 * PostRepositoryInterface RepositoryInterface
 *
 * PHP Version 5
 *
 * @author  <Sandun Dissanayake> <sandunkdissanayake@gmail.com>
 *
 */
 
namespace App\Repositories\Contracts\v1;
 
interface PostRepositoryInterface
{
    /**
     * Insert post
     *
     * @param $data
     * @return array
     */
    public function create($data);

}
