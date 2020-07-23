<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use Faker\Generator as Faker;
use App\Models\Category;
use App\User;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'content' => $faker->text(250),
        'slug' => $faker->slug,
        'owner_id' =>  function () {
            return factory(User::class)->create()->id;
        },
        'category_id' =>  function () {
            return factory(Category::class)->create()->id;
        }
    ];
});
