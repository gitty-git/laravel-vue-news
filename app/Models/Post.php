<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category() {
        return $this->belongsTo('App\Models\Category');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function likes(){
        return $this->belongsToMany(User::class, 'users_posts_likes', 'post_id', 'user_id');
    }
}
