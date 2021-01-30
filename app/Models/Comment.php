<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function post() {
        return $this->belongsTo('App\Models\Post');
    }

    public function comment_replies()
    {
        return $this->hasMany('App\Models\CommentReply')->latest();
    }

    public function likes(){
        return $this->belongsToMany(User::class, 'users_comments_likes', 'comment_id', 'user_id');
    }

//    public function reply_likes(){
//        return $this->belongsToMany(User::class, 'users_comments_replies_likes', 'comment_reply_id', 'user_id');
//    }
}
