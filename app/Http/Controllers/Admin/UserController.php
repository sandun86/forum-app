<?php
/**
 * @file    UserController.php
 *
 * UserController Controller
 *
 * PHP Version 5
 *
 * @author  <Sandun Dissanayake> <sandunkdissanayake@gmail.com>
 *
 */
 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Illuminate\Support\Facades\Input;
use App\Libraries\v1\Helper;
use App\Libraries\v1\ValidationHelper;
use App\Repositories\Contracts\v1\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Sentinel;

class UserController extends Controller
{
    //private variables
    private $user;
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
        UserRepositoryInterface $user
    ) {
        $this->helper = $helper;
        $this->validationHelper = $validationHelper;
        $this->user = $user;
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
                                        UserModel::$insertUser
                                    );
        if ($validatorUserModel->fails()) {
            return $this->helper->response(
                422,
                ['errors' => $validatorUserModel->messages()]
            );
        }

        $data['password'] = Hash::make($data['password']);

        $insertUser = $this->user->create($data);
        if ($insertUser) {
            return $this->helper
                ->response(200, [
                    'message' => 'User has created successfully.!',
                    'data' => $insertUser
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
     * User update
     *
     * @return $this
     */
    public function update($userId)
    {
        $data = Input::all();
        $validatorUserModel = $this->validationHelper->validation(
                                        $data,
                                        UserModel::$updateUser
                                    );
        if ($validatorUserModel->fails()) {
            return $this->helper->response(
                422,
                ['errors' => $validatorUserModel->messages()]
            );
        }

        if($data['password'] == '' && $data['confirm_password'] == ''){
                $updateData = [
                    'first_name' => $data['first_name'],
                    'last_name'  => $data['last_name'],
                ];
        }else{
            $updateData = [
                        'first_name' => $data['first_name'],
                        'last_name'  => $data['last_name'],
                        'password'   => Hash::make($data['password'])
                    ];            
        }

        $isUpdate = $this->user->update($updateData, $userId);
        if ($isUpdate) {
            $user = $this->user->find($userId);

            return $this->helper->response(
                200,
                [
                'message' => 'User has updated successfully.',
                'data' => $user
                ]
            );
        } else {
            return $this->helper->response(
                400,
                ['message' => 'There has a error.Please try again.']
            );
        }
    }

    public function destroy($userId)
    {
        if($this->validationHelper->validateInteger($userId)){

            $isUpdate = $this->user->update(['status' => 0], $userId);
            if ($isUpdate) {

                return $this->helper->response(
                            200, [
                            'message' => 'You have deleted user successfully.!'
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
                    ['errors' => 'User id is not valid.']
                );
        }
    }

    /**
     * Get users
     *
     * @return view
     */
    public function index()
    {
        $params = [
            'term'    => trim(Input::get('term'))
        ];

        if ($this->validationHelper->checkQueryArgValid(Input::all(), 'term')) {
            $params['term'] = trim(Input::get('term'));
        }

        $users = $this->user->getUsers($params, $paginate = true);

        return view('admin.user.user-list')->with('title', 'Users')->with('users', $users);
    }

    public function getEditUser($userId)
    {
        if(Sentinel::check()){
            $user = $this->user->find($userId);

            return view('admin.user.user-edit')->with('title', 'Users')
                        ->with('user', $user);
        }

        return redirect('admin/login');
    }

    /**
     * Create user view
     *
     * @return view
     */
    public function getUser()
    {
        if(Sentinel::check()){
            return view('admin.user.user-create')->with('title', 'User');
        }

        return redirect('admin/login');
    }
}
