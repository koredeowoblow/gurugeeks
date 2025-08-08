<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    protected $fillable = [
        'user_id',
        'category_id'
    ];
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
