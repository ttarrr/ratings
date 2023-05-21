<?php

namespace App\Rating\Infrastructure\Database\Factories;

use App\Rating\Domain\Entities\Rating;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RatingFactory extends Factory
{
    /** @var string */
    protected $model = Rating::class;

    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail,
            'user_name' => $this->faker->name,
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->text,
            'photo' => $this->faker->imageUrl(),
        ];
    }
}
