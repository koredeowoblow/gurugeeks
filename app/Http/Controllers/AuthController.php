<?php

namespace App\Http\Controllers;

use App\Class\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest ;


use App\Http\Resources\AdminResource;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use App\Services\AuthServices;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function __construct(private AuthService $authService)
    {
        $this->authService = $authService;

    }

    public function signup(SignupRequest $request){
        $validData = $request->validated();
        $resp = $this->authService->createUserAccount($validData);
        return ApiResponse::success("Account created successfully", $resp);
    }

    public function login(LoginRequest $request){
        $validData = $request->validated();
        $resp = $this->authService->userLogin($validData);
        return ApiResponse::success("Login successful", $resp);
    }


    public function logout(Request $request){
        $this->authService->userLogout();
        return ApiResponse::success("User logged out successfully");
    }
}
