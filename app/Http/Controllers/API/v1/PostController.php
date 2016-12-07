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
 
namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\PostModel;
use Illuminate\Support\Facades\Input;
use App\Libraries\v1\Helper;
use App\Libraries\v1\ValidationHelper;
use App\Repositories\Contracts\v1\PostRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
        $params = [
            'term'      => trim(Input::get('term')),
            'orderby'   => trim(Input::get('orderby')),
        ];

        if ($this->validationHelper->checkQueryArgValid(Input::all(), 'term')) {
            $params['term'] = trim(Input::get('term'));
        }

        $posts = $this->post->getPosts($params, $paginate = true);

        return view('post.post')->with('title', 'Posts')->with('posts', $posts);
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
                                            PostModel::$addPostRule
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
        if(Auth::check()){

            return view('post.post-create')->with('title', 'Posts');
        }else{

            return redirect('/post');
        }
    }

    /**
     * Get own posts
     *
     * @return view
     */
    public function getOwnPosts()
    {
        if(Auth::check()){

            $posts = $this->post->getUserPosts(Auth::User()->id, $paginate = true);

            return view('post.post-list')->with('title', 'Posts')
                        ->with('posts', $posts);

        }else{

            return redirect('/post');
        }
    }

    /**
     * Get edit post
     *
     * @return view
     */
    public function getEditPost($postId)
    {
        if(Auth::check()){

            $post = $this->post->find($postId);

            return view('post.post-edit')->with('title', 'Posts')
                        ->with('post', $post);

        }else{

            return redirect('/post');
        }

    }
}
