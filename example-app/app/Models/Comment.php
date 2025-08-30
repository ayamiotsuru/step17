<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'post_id',
        'user_id',
        'content',
    ];

    //一つの投稿は必ず一つのポストに属する
    public function post() {
        return $this->belongsTo(Post::class);
    }
    //一つの投稿は必ず一つのユーザーに属する
    public function user() {
        return $this->belongsTo(User::class);
    }
}
