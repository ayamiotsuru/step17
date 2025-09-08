<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'user_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    //一つの投稿は複数のコメントを持つことができる
    public function comments() {
        return $this->hasmany(Comment::class);
    }

    // 一つの投稿は複数のタグを持つことができる
    public function tags() {
        return $this->belongsToMany(Tag::class);
    }
}
