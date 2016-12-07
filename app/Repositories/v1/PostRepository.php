<?php
/**
 * @file    PostRepository.php
 *
 * PostRepository Repository
 *
 * PHP Version 5
 *
 * @author  <Sandun Dissanayake> <sandunkdissanayake@gmail.com>
 *
 */
 
namespace App\Repositories\v1;

use App\Repositories\Contracts\v1\PostRepositoryInterface;
use App\Models\PostModel;
use App\Libraries\v1\Helper;
use Illuminate\Support\Facades\Auth;
 
class PostRepository implements PostRepositoryInterface
{
    //Private variables
    private $post;
    private $helper;

    public function __construct(PostModel $post, Helper $helper)
    {
        $this->post     = $post;
        $this->helper   = $helper;
    }
    
    /**
     * @description Save details
     *
     * @param $data
     *
     * @return bool|int
     */
    public function create($data)
    {
        return $this->post->create($data);
    }
    
    /**
     * @description Update details
     *
     * @param $data
     * @param $id
     *
     * @return bool|int
     */
    public function update($data, $id)
    {
        return  $query = $this->post->where('id', $id)
                                ->update($data);
    }
    
    /**
     * @description Delete record
     *
     * @param $id
     *
     * @return bool|int
     */
    public function delete($id)
    {
        return $this->post->find($id)->delete();
    }
    
    /**
     * @description Get details of single item
     *
     * @param $id
     * @param $columns
     *
     * @return array
     */
    public function find($id, $columns = ['*'])
    {
        return $this->post->find($id, $columns);
    }

    /**
     * @description Get posts
     *
     * @return array posts
     */
    public function getPosts($params, $paginate = false)
    {
        $orderBy = (!empty($params['order_by'])) ? $params['order_by'] : '';

        $orderOptions = [1 => 'created_at', 2 => 'tag'];

        $query = $this->post
                    ->join('users', 'posts.user_id', '=', 'users.id')
                    ->where(function ($query) use ($params) {
                        $query->where('title', 'LIKE', '%' . $this->helper->escapeLike($params['term']) . '%')
                        ->orWhere('description', 'LIKE', '%' . $this->helper->escapeLike($params['term']) . '%')
                         ->orWhere('tag', 'LIKE', '%' . $this->helper->escapeLike($params['term']) . '%')
                        ;
                        })
                    ->where('posts.status', 1);
        $query = $query->select('posts.id', 'title', 'description', 'posts.status', 'posts.created_at', 'tag',
                    \DB::raw("CONCAT(users.first_name, ' ', users.last_name) as full_name")
                    );

        if($orderBy != ''){
            $query = $query->orderBy($orderOptions[$orderBy], 'ASC');
        }

        if ($paginate) {
            $query = $query->paginate(10);
        } else {
            $query = $query->get();
        }

        return $query;
    }

    public function getUserPosts($userId, $paginate = false){

        $query = $this->post
                    ->join('users', 'posts.user_id', '=', 'users.id')
                    // ->where(function ($query) use ($params) {
                    //     $query->where('title', 'LIKE', '%' . $this->helper->escapeLike($params['term']) . '%')
                    //     ->orWhere('description', 'LIKE', '%' . $this->helper->escapeLike($params['term']) . '%')
                    //     // ->orWhere('tag', 'LIKE', '%' . $this->helper->escapeLike($params['term']) . '%')
                    //     ;
                    //     })
                    ->where('posts.status', 1)
                    ->orderBy('posts.created_at', 'DESC');
        $query = $query->select('posts.id', 'title', 'description', 'tag', 'posts.status', 'posts.created_at');

        // if($orderBy != ''){
        //     $query = $query->orderBy($orderOptions[$orderBy], 'ASC');
        // }

        if ($paginate) {
            $query = $query->paginate(10);
        } else {
            $query = $query->get();
        }

        return $query;
    }

}
