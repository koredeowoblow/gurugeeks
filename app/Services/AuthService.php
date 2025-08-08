<?php

namespace App\Services;

use App\Enums\UserEnums;
use App\Repositories\AdminRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AuthService
{
    public $userRepo;
    public $adminRepo;
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;

    }

    public function createUserAccount($data){
        $resp = $this->userRepo->create($data);
        return $resp;
    }

    public function userLogin($data){
        $user = $this->userRepo->findByEmail($data["email"]);
        if(!$user)
            abort(401, "Invalid login details");
        if(!Hash::check($data["password"], $user->password))
            abort(401, "Invalid login details");
        $this->userRepo->update($user->id, [
            "last_login" => now()->toDateTime()
        ]);
        $token = $this->userRepo->createAccessToken($user, UserEnums::tokenIdentifier($user->id));
        $user->token = $token;
        return $user;
    }



    public function userLogout(){
        $user = auth()->user();
        $this->userRepo->revokeAccessToken($user);
        return $user;
    }
}
