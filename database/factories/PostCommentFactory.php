<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\PostComment;
use Faker\Generator as Faker;

$factory->define(PostComment::class, function (Faker $faker) {
    return [
        'content' => "This is a fake content",
        'post_id' => 1,
        'parent_id' => null,
        'level' => 1,
        'created_by' => 1,
        'created_at' => \Carbon::now()
    ];
});

$factory->state(PostComment::class, 'child', function ($faker) {
    return [
        'parent_id' => 1,
    ];
});
