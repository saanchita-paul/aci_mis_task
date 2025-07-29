<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Services\Auth\UserLoginService;
use App\Services\Auth\UserLogoutService;
use App\Services\Auth\UserRegisterService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        $registerService = new UserRegisterService();
        $data = $registerService->register($request->validated());

        return response()->json($data, 201);
    }


    public function login(LoginUserRequest $request)
    {
        $loginService = new UserLoginService();
        $data = $loginService->login($request->validated());

        return response()->json($data);
    }


    public function logout(Request $request)
    {
        $logoutService = new UserLogoutService();
        $logoutService->logout($request);

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}

