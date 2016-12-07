<?php
/**
 * @file    PostController.php
 *
 * PostController Controller
 *
 * PHP Version 5
 *
 * @author  <Sandun Dissanayake> <sandunkdissanayake@gmail.com>
 *
 */
 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostModel;
use App\Libraries\v1\Helper;
use App\Libraries\v1\ValidationHelper;
use App\Repositories\Contracts\v1\PostRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Sentinel;

class PostController extends Controller
{
    //private variables
    private $post;
    private $helper;
    private $validationHelper;

    /**
     * @param Helper $helper
     * @param ValidationHelper $validationHelper
     * @param UserRepositoryInterface $user
     */
    public function __construct(
        Helper $helper,
        ValidationHelper $validationHelper,
        PostRepositoryInterface $post
    ) {
        $this->helper = $helper;
        $this->validationHelper = $validationHelper;
        $this->post = $post;
    }

    /**
     * Get posts
     *
     * @return view
     */
    public function index()
    {
        if(Sentinel::check()) {
            $params = [
                'term' => trim(Input::get('term')),
                'order_by' => trim(Input::get('order_by')),
            ];

            if ($this->validationHelper->checkQueryArgValid(Input::all(), 'term')) {
                $params['term'] = trim(Input::get('term'));
            }

            $posts = $this->post->getPosts($params, $paginate = true);

            return view('admin.post.post-list')->with('title', 'Posts')->with('posts', $posts);
        }else{

            return redirect('admin/login');
        }
    }


    /**
     * Save the resource
     *
     * @return array
     */
    public function store()
    {
        $data = Input::all();
        $validatorUserModel = $this->validationHelper->validation(
                                        $data,
                                        PostModel::$addPostRule
                                    );
        if ($validatorUserModel->fails()) {
            return $this->helper->response(
                422,
                ['errors' => $validatorUserModel->messages()]
            );
        }

        $addPost = $this->post->create($data);
        if ($addPost) {
            return $this->helper
                ->response(200, [
                    'message' => 'You have added post successfully.!',
                    'data' => $addPost
                ]);
        } else {
            return $this->helper
                ->response(
                    400,
                    ['message' => 'Something went wrong, Please try again later.']
                );
        }
    }

    /**
     * Post update
     *
     * @return $this
     */
    public function update($postId)
    {
        if($this->validationHelper->validateInteger($postId)){
            $data = Input::all();
            $validatorUserModel = $this->validationHelper->validation(
                                            $data,
                                            PostModel::$adminPostRule
                                        );
            if ($validatorUserModel->fails()) {
                return $this->helper->response(
                    422,
                    ['errors' => $validatorUserModel->messages()]
                );
            }
            $isUpdate = $this->post->update($data, $postId);

            if ($isUpdate) {
                $post = $this->post->find($postId);

                return $this->helper->response(
                            200, [
                            'message' => 'You have updated post successfully.!',
                            'data' => $post]
                        );
            } else {

                return $this->helper->response(
                    400,
                    ['message' => 'There has a error.Please try again later.']
                );
            }
        }else{

            return $this->helper->response(
                    422,
                    ['errors' => 'Post id is not valid.']
                );
        }
    }

    /**
     * Post delete
     *
     * @return $this
     */
    public function destroy($postId)
    {
        if($this->validationHelper->validateInteger($postId)){

            $isUpdate = $this->post->update(['status' => 0], $postId);
            if ($isUpdate) {

                return $this->helper->response(
                            200, [
                            'message' => 'You have deleted post successfully.!'
                            ]
                        );
            } else {

                return $this->helper->response(
                            400,
                            ['message' => 'There has a error.Please try again later.']
                        );
            }
        }else{

            return $this->helper->response(
                    422,
                    ['errors' => 'Post id is not valid.']
                );
        }
    }

    /**
     * Create posts view
     *
     * @return view
     */
    public function getPost()
    {
        if(Sentinel::check()){
            return view('admin.post.post-create')->with('title', 'Posts');
        }

        return redirect('admin/login');
    }

    /**
     * Edit posts
     *
     * @return view
     */
    public function getEditPost($postId)
    {
        if(Sentinel::check()){
            $post = $this->post->find($postId);

            return view('admin.post.post-edit')->with('title', 'Posts')
                        ->with('post', $post);
        }

        return redirect('admin/login');
    }
}
