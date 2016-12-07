<?php
/**
 * @file    AdminUserController.php
 *
 * AdminUserController Controller
 *
 * PHP Version 5
 *
 * @author  <Sandun Dissanayake> <sandunkdissanayake@gmail.com>
 *
 */
 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminUserModel;
use App\Repositories\Contracts\v1\AdminUserRepositoryInterface;
use App\Repositories\Contracts\v1\PostRepositoryInterface;
use App\Libraries\v1\Helper;
use App\Libraries\v1\ValidationHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Sentinel;

class AdminUserController extends Controller
{
    //private variables
    private $adminUser;
    private $helper;
    private $validationHelper;
    private $post;

    /**
     * @param Helper $helper
     * @param ValidationHelper $validationHelper
     * @param AdminUserRepositoryInterface $adminUser
     */
    public function __construct(
        Helper $helper,
        ValidationHelper $validationHelper,
        AdminUserRepositoryInterface $adminUser,
        PostRepositoryInterface $post
    ) {
        $this->helper           = $helper;
        $this->validationHelper = $validationHelper;
        $this->adminUser        = $adminUser;
        $this->post             = $post;
    }

    /**
     * Admin user login

     * @return $this
    */
    public function postLogin()
    {
        try {
            $validator = $this->validationHelper->validation(Input::all(), AdminUserModel::$loginRules);

            if ($validator->fails()) {
                return $this->helper->response(
                    422,
                    ['errors' => $validator->messages()]
                );
            } else {
                $credentials = [
                    'email' => trim(Input::get('email')),
                    'password' => trim(Input::get('password'))
                ];

                $adminUser = Sentinel::authenticate($credentials);
                if ($adminUser) {
                        $adminUser = $this->adminUser->updateToken($adminUser);

                        $scopeAdminUser = [
                            'id'         => $adminUser->id,
                            'first_name' => $adminUser->first_name,
                            'last_name'  => $adminUser->last_name,
                            'email'      => $adminUser->email,
                            'status'     => $adminUser->status,
                            'created_at' => $adminUser->created_at,
                            'updated_at' => $adminUser->updated_at,
                            'last_login' => $adminUser->last_login,
                            'token'      => $adminUser->token
                        ];

                    return $this->helper
                        ->response(200, ['data' => $scopeAdminUser]);
                } else {
                    return $this->helper
                        ->response(
                            400,
                            ['message' => 'Login failed.']
                        );
                }
            }
        }catch(Exception $ex){
            dd($ex->getMessage());
        }
    }

    /**
     * Get login
     *
     * @return view
     */
    public function getLogin()
    {
        if(!Sentinel::check()){
            return view('admin.admin-login')->with('title', 'Admin Login');
        }

        return redirect('admin/dashboard');
    }

    /**
     * Get dashboard
     *
     * @return view
     */
    public function getDashboard()
    {
        if(Sentinel::check()){
            $params = [
                'term'      => ''       
                ];
            $posts = $this->post->getPosts($params, $paginate = true);

            return view('admin.post.post')
                        ->with('title', 'Admin')
                        ->with('posts', $posts);
        }

        return redirect('admin/login');
    }

    /**
     * Post Logout
     *
     * @return view
     */
    public function postLogout()
    {
        $adminId = trim(Input::get('admin_id'));
        if(Sentinel::logout()){

            return 'true';
        }else{
            redirect('admin/login');
        }
    }
}
