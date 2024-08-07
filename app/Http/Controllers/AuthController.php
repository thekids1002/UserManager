<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Libs\ConfigUtil;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected AuthService $authService;

    protected UserRepository $userRepository;

    public function __construct(AuthService $authService, UserRepository $userRepository) {
        $this->authService = $authService;
        $this->userRepository = $userRepository;
    }

    /**
     * Render login page
     */
    public function login() {
        if (Auth::check() && Auth::user()->deleted_date == null) {
            return redirect()->route('admin.userList');
        }
        return view('screens.auth.login');
    }

    /**
     * Handle login
     * @param LoginRequest $request
     */
    public function handleLogin(LoginRequest $request) {
        $checkDuplicate = $this->userRepository->checkDuplicateEmailForLogin($request->email,$request->password);
        if ($checkDuplicate) {
            return back()->withError(ConfigUtil::getMessage('EBT016'))->withInput();
        }
        if (Auth::attempt([...$request->only(['email', 'password']), 'deleted_date' => null])) {
            $ridirecTo = 'admin/user';
            if ($request->session()->get('previous_url')) {
                $ridirecTo = $request->session()->get('previous_url');
                $request->session()->forget('previous_url');
            }
            return redirect()->intended($ridirecTo);
        }

        return back()->withError(ConfigUtil::getMessage('EBT016'))->withInput();
    }

    /**
     * Logout the currently authenticated user.
     */
    public function logout() {
        Auth::logout();
        session()->flush();
        session()->invalidate();

        return redirect()->route('login');
    }
}
