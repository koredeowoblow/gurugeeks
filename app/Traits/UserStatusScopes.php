<?php

namespace App\Traits;

use App\Enums\UserEnums;
use Illuminate\Database\Eloquent\Builder;

trait UserStatusScopes
{
    //
    public function scopeActive(Builder $builder){
        return $builder->where("status", UserEnums::ACTIVE);
    }

    public function scopeInactive(Builder $builder){
        return $builder->where("status", UserEnums::INACTIVE);
    }

    public function scopeSuspended(Builder $builder){
        return $builder->where("status", UserEnums::SUSPENDED);
    }
}
