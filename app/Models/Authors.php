<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Authors extends Model
{

    protected $fillable = [
        'name',
        'email',
        'source_id',
    ];

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
