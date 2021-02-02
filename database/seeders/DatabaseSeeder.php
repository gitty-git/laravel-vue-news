<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\CommentReply;
use App\Models\Post;
use App\Models\PostLike;
use App\Models\Role;
use App\Models\User;
use Database\Factories\PostLikeFactory;
use Database\Factories\PostLikesFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(50)->create();

        $roles = ['admin', 'redactor', 'user'];
        foreach ($roles as $role) {
            Role::query()->create([
                'role' => $role,
            ]);
        }

        $roles = Role::all();
        User::all()->each(function ($user) use ($roles) {
            $user->roles()->attach(
                $roles->random(rand(1, count($roles)))->pluck('id')->toArray()
            );
        });

        $categories = ['Politics', 'World', 'Health', 'Business', 'Entertainment', 'Arts', 'Games'];
        foreach ($categories as $cat) {
            Category::query()->create([
                'name' => $cat,
                'slug' => Str::slug($cat)
            ]);
        }

        Post::factory(10)->create(['type' => 'front_page_post']);
        Post::factory(50)->create(['type' => 'primary_post']);
        Post::factory(200)->create(['type' => 'post']);

        Comment::factory(500)->create();
        CommentReply::factory(500)->create();

        User::all()->each(function ($user) {
            Post::all()->random(50)->each(function ($post) use ($user) {
                $post->likes()->attach($user->id);
            });
        });


        User::all()->random(25)->each(function ($user) {
            Comment::all()->random(100)->each(function ($comment) use ($user) {
//                $comment->liked = true; --- CHECK THIS!
                $comment->likes()->attach($user->id);
            });
        });

        User::all()->random(25)->each(function ($user) {
            CommentReply::all()->random(100)->each(function ($comment) use ($user) {
                $comment->likes()->attach($user->id);
            });
        });
    }
}
