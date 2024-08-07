<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Handle login
     *
     * @param array $credentials
     * @return boolean
     */
    public function handleLogin(array $credentials)
    {
        $user = $this->userRepository->getUserLogin($credentials);
        if (!$user) {
            return false;
        }
        if (Auth::loginUsingId($user->id)) {
            return true;
        }

        return false;
    }
}
