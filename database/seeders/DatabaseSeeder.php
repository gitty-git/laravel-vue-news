<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\NumberOfPrimaryPost;
use App\Models\Post;
use App\Models\PrimaryCategoryPost;
use App\Models\PrimaryPost;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();

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
                'slug' => strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $cat)))
            ]);
        }

        Post::factory(10)->create(['type' => 'front_page_post']);
        Post::factory(50)->create(['type' => 'primary_post']);
        Post::factory(400)->create(['type' => 'post']);
    }
}
