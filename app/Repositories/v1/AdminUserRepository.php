<?php
/**
 * @file    AdminUserRepository.php
 *
 * AdminUserRepository Repository
 *
 * PHP Version 5
 *
 * @author  <Sandun Dissanayake> <sandunkdissanayake@gmail.com>
 *
 */
 
namespace App\Repositories\v1;

use App\Models\AdminUserModel;
use App\Libraries\v1\Helper;
use App\Repositories\Contracts\v1\AdminUserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
 
class AdminUserRepository implements AdminUserRepositoryInterface
{
    //Private variables
    private $adminUser;
    private $helper;

    public function __construct(AdminUserModel $adminUser, Helper $helper)
    {
        $this->adminUser     = $adminUser;
        $this->helper        = $helper;
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
        return $this->adminUser->find($id, $columns);
    }

    /**
     * @param $data
     *
     * @return array
     */
    public function chekLogin($data)
    {

        $adminUserDetails = $this->checkConditions($data['email'], md5($data['password']));
        if (isset($adminUserDetails)) {

            $adminUserTokens = $this->updateToken($adminUserDetails);
            $adminUserDetails->token = $adminUserTokens->token;
            if ($adminUserTokens) {

                return array('success' => true, 'data' => $adminUserDetails);
            } else {

                return array('success' => false, 'msg' => 'Admin user details are not correct.');
            }
            
        } else {
            return array('success' => false, 'msg' => 'This email is not valid.');
        }
    }

    /**
     * @param $email
     *
     * @return mixed
     */
    private function checkConditions($email, $password)
    {
        return $this->adminUser->select(
                            'id',
                            'first_name',
                            'last_name',
                            'token',
                            'email',
                            'status',
                            'created_at',
                            'updated_at')
                    ->where('email', $email)
                    ->where('password', $password)
                    ->where('status', '=', 1)
                    ->first();
    }

    /**
     * Update admin token
     *
     * @param $adminUser
     * @return array $updateTokenForUser
     */
    public function updateToken($adminUser)
    {
        $token = $this->helper->generateToken($adminUser->id);

        $query = $this->adminUser
                    ->where('id', $adminUser->id)
                    ->update(['token' => $token]);
        if($query){
            return $this->adminUser->find($adminUser->id);
        }

        return false;
    }

    /**
     * @param $token
     *
     * @return mixed
     */
    public function getTokenDetails($token)
    {
        return $this->adminUser->select(
                    'id',
                    'first_name',
                    'last_name',
                    'email')
                    ->where('token', $token)
                    ->where('status', '=', 1)
                    ->first();

    }

    /**
     * Logout
     *
     * @param $userId
     * @return array $tokendetails
     */
    public function logOut($userId)
    {
        $updateToken        = $this->adminUser->find($userId);
        if($updateToken){
            $updateToken->token = '';
            $updateToken->save();

            return $updateToken;
        }

        return false;
    }

    /**
     * Validate by token
     *
     * @param $token
     * @return array Admin user details
     */
    public function validateByToken($token)
    {
        return $this->adminUser->where('token', $token)
                                ->select(['id', 'first_name', 'last_name', 'email', 'token'])
                                ->get();
    }

}
