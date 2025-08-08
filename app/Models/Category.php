<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = [
        'name'
    ];


    public function users()
    {
        return $this->belongsToMany(User::class, 'user_preferences', 'category_id', 'user_id');
    }
}
