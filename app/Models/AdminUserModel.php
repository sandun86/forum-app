<?php
/**
 * @file    AdminUserModel.php
 *
 * AdminUserModel Request
 *
 * PHP Version 5
 *
 * @author  <Sandun Dissanayake> <sandunkdissanayake@gmail.com>
 *
 */

namespace App\Models;

use Cartalyst\Sentinel\Users\EloquentUser;

class AdminUserModel extends EloquentUser
{
    protected $table = 'admin_users';

    protected $fillable = [
        'email',
        'password',
        'last_name',
        'first_name',
        'permissions',
        'name',
        'status',
        'token'
    ];

    public static $loginRules = [
        'email'    => 'required|email|script_tags_free',
        'password' => 'required|script_tags_free|max:30|min:6'
    ];
}
