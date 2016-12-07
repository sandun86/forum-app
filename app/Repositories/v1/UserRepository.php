<?php
/**
 * @file    UserRepository.php
 *
 * UserRepository Repository
 *
 * PHP Version 5
 *
 * @author  <Sandun Dissanayake> <sandunkdissanayake@gmail.com>
 *
 */
 
namespace App\Repositories\v1;

use App\Repositories\Contracts\v1\UserRepositoryInterface;
use App\Models\UserModel;
use App\Libraries\v1\Helper;
use Illuminate\Support\Facades\Auth;
 
class UserRepository implements UserRepositoryInterface
{
    //Private variables
    private $user;
    private $helper;

    /**
    * UserModel $user
    * Helper $helper
    */
    public function __construct(UserModel $user, Helper $helper)
    {
        $this->user     = $user;
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
        return $this->user->create($data);
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
        return  $query = $this->user->where('id', $id)
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
        return $this->user->find($id)->delete();
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
        return $this->user->find($id, $columns);
    }

    /**
     * Check user login
     *
     * @param $data
     *
     * @return array
     */
    public function chekUserLogin($data)
    {
        $userLogin = array(
            'email'    => $data['email'],
            'password' => $data['password'],
        );

        $userDetails = $this->getUserDetailsWithEmail($data['email']);
        if (isset($userDetails)) {

            if(Auth::attempt($userLogin)){
                $userTokens = $this->updateToken($userDetails);
                $userDetails->token = $userTokens->token;
                if ($userTokens) {

                    return array('success' => true, 'data' => $userDetails);
                } else {

                    return array('success' => false, 'msg' => 'User details are not correct.');
                }
            }
        } else {
            return array('success' => false, 'msg' => 'This email is not valid.');
        }
    }

    /**
     * Get user details by email
     *
     * @param $email
     * @return mixed
     */
    public function getUserDetailsWithEmail($email)
    {
        return $this->user->select(
                            'id',
                            'first_name',
                            'last_name',
                            'token',
                            'email',
                            'status',
                            'created_at',
                            'updated_at')
                    ->where('email', $email)
                    ->where('status', '=', 1)
                    ->first();
    }

    /**
     * Update token
     *
     * @param $user
     * @return mixed
     */
    private function updateToken($user)
    {
        $token = $this->helper->generateToken($user->id);

        $updateTokenForUser        = $this->user->find($user->id);
        $updateTokenForUser->token = $token;
        $updateTokenForUser->save();

        return $updateTokenForUser;
    }

    /**
     * Get Token details
     *
     * @param $token
     * @return mixed
     */
    public function getTokenDetails($token)
    {
        return $this->user->select(
                    'id',
                    'first_name',
                    'last_name',
                    'email')
                    ->where('token', $token)
                    ->where('status', '=', 1)
                    ->first();
    }

    /**
     * @description Get users
     *
     * $params array params
     * $paginate boolean
     * @return array users
     */
    public function getUsers($params, $paginate = false)
    {
        $query = $this->user
                    ->where(function ($query) use ($params) {
                        $query->where('first_name', 'LIKE', '%' . $this->helper->escapeLike($params['term']) . '%')
                            ->orWhere('last_name', 'LIKE', '%' . $this->helper->escapeLike($params['term']) . '%');
                    })
                    ->where('status', 1);
        $query = $query->select('id', 'first_name', 'last_name', 'status', 'created_at', 'email');

        $query = $query->orderBy('first_name', 'ASC');

        if ($paginate) {
            $query = $query->paginate(10);
        } else {
            $query = $query->get();
        }

        return $query;
    }

}
