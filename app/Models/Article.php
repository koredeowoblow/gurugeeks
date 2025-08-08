<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'content',
        'slug',
        'author_id',
        'source_id',
    ];

    public function author()
    {
        return $this->belongsTo(Authors::class);
    }

    public function source()
    {
        return $this->belongsTo(Source::class);
    }
}
