<?php

namespace App\Rating\Infrastructure\Database\Seeders;

use App\Rating\Domain\Entities\Rating;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rating::factory()->count(2)->create();
    }
}
