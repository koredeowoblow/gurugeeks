<?php
namespace App\Traits;

use Illuminate\Contracts\Auth\Authenticatable;

trait HasAuthToken{
    public function  createAccessToken( Authenticatable $model, $name, $abilities = []){
        $token = $model->createToken($name, $abilities)->plainTextToken;
        return $token;
    }

    public function getAccessTokens(Authenticatable $model, $idParam = null){
        $data = $model->tokens;
        if($idParam){
            return $data->where("id", $idParam)->orWhere("name", $idParam)->first();
        }
        return $data;
    }

    public function revokeAllAccessToken(Authenticatable $model){
        return $model->tokens()->delete();
    }

    public function revokeAccessToken(Authenticatable $model){
        return $model->currentAccessToken()->delete();
    }
}
