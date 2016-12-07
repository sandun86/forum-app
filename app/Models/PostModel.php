<?php
/**
 * @file    PostModel.php
 *
 * PostModel Request
 *
 * PHP Version 5
 *
 * @author  <Sandun Dissanayake> <sandunkdissanayake@gmail.com>
 *
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostModel extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'title', 'description', 'tag', 'user_id'
    ];

    public static $addPostRule = [
        'title'         => 'script_tags_free|required|max:100',
        'description'   => 'script_tags_free|required|max:5000',
        'tag'           => 'script_tags_free|required|max:100',
        'user_id'       => 'script_tags_free|required|max:99999'
    ];

    public static $adminPostRule = [
        'title'         => 'script_tags_free|required|max:100',
        'description'   => 'script_tags_free|required|max:5000',
        'tag'           => 'script_tags_free|required|max:100'
    ];
}
