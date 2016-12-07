<?php
/**
 * @file    UserModel.php
 *
 * UserModel Request
 *
 * PHP Version 5
 *
 * @author  <Sandun Dissanayake> <sandunkdissanayake@gmail.com>
 *
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
    ];

    public static $insertUser = [
            'first_name'        => 'script_tags_free|required|max:50',
            'last_name'         => 'script_tags_free|required|max:50',
            'password'          => 'script_tags_free|required|min:6|max:30',
            'confirm_password'  => 'script_tags_free|required|min:6|max:30|same:password',
            'email'             => 'script_tags_free|required|max:320|email|unique:users,email,NULL',
    ];

    public static $updateUser = [
            'first_name'        => 'script_tags_free|required|max:50',
            'last_name'         => 'script_tags_free|required|max:50',
    ];
}
