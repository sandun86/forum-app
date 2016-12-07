<?php

namespace App\Libraries\v1;

use App\Repositories\Contracts\v1\UserRepositoryInterface;
use App\Repositories\Contracts\v1\AdminUserRepositoryInterface;

class TokenValidator
{
    private $user;
    private $adminUser;
    public static $currentUser = null;
    public static $scopeAdminUser = null;

    /**
     * TokenValidator constructor.
     * @param UsersRepositoryInterface $userRepo
     */
    public function __construct(
        UserRepositoryInterface $user,
        AdminUserRepositoryInterface $adminUser
    ) {
        $this->user      = $user;
        $this->adminUser = $adminUser;
    }

    /**
     * Validate token
     *
     * @param $token
     * @return bool
     */
    public function validateToken($token)
    {
        $user = $this->user->getTokenDetails($token);
        if ($user) {
            TokenValidator::$currentUser = $user;

            return true;
        } else {

            return false;
        }
    }

    /**
     * Validate admin token
     *
     * @param $token
     * @return bool
     */
    public function validateAdminToken($token)
    {
        $adminUser = $this->adminUser->validateByToken($token);

        if (!$adminUser->isEmpty()) {
            $adminUser = $adminUser->first();
            TokenValidator::$scopeAdminUser = $adminUser;

            return true;
        } else {
            return false;
        }
    }
}
