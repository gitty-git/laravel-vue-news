<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\CommentReply;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentReplyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CommentReply::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'text' => $this->faker->text(200),
            'post_id' => rand(1, count(Post::all())),
            'user_id' => rand(1, count(User::all())),
            'comment_id' => rand(1, count(Comment::all())),
        ];
    }
}
