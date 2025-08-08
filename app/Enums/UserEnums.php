<?php

namespace App\Enums;

enum UserEnums
{
    //
    const UNVERIFIED = "unverified";
    const ACTIVE = 'active';
    const INACTIVE = 'inactive';
    const SUSPENDED = 'suspended';

    static function tokenIdentifier($id){
        return "app_token_".$id;
    }

    static function adminTokenIdentifier($id){
        return "admin_app_token_". $id;
    }
}
