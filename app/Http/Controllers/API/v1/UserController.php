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
 
namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Illuminate\Support\Facades\Input;
use App\Libraries\v1\Helper;
use App\Libraries\v1\ValidationHelper;
use App\Repositories\Contracts\v1\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
                    'message' => 'You have sign up successfully.!',
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
     * User login
     *
     * @return $this
     */
    public function userLogin()
    {
        $checkLogged = $this->user->chekUserLogin(Input::all());

        if ($checkLogged['success']) {
            return $this->helper->response(
                200,
                ['data' => $checkLogged['data'],
                  'message' => 'You have logged successfully.']
            );
        } else {
            return $this->helper->response(
                400,
                ['message' => $checkLogged['msg']]
            );
        }
    }

    /**
     * User logout
     *
     * @return $this
     */
    public function logout()
    {
        Auth::logout();

        return 'true';
    }
}
