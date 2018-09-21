<?php

declare(strict_types=1);

use Faker\Generator as Faker;

$factory->define(Rinvex\Pages\Models\Page::class, function (Faker $faker) {
    return [
        'uri' => $faker->slug,
        'slug' => $faker->slug,
        'route' => $faker->slug,
        'title' => $faker->title,
        'view' => $faker->slug,
    ];
});
