<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name',
    ];

    // 一つのタグは複数の投稿を持つことができる
    public function posts() {
        return $this->belongsToMany(Post::class);
    }
}
