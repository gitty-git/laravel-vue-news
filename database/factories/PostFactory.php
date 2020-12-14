<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(100);
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        return [
            'title' => $title,
            'brief' => $this->faker->text(200),
            'image' => 'http://127.0.0.1:8000/img/pic-('. rand(25, 29) . ').jpg',
//            'image' => 'https://source.unsplash.com/random',
            'body' => $this->faker->paragraph,
            'slug' => $slug,
            'is_published' => 1,
            'user_id' => rand(1, count(User::all())),
            'category_id' => rand(1, count(Category::all())),
        ];
    }
}
