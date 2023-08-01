<?php

namespace Database\Seeders;

use App\Models\API\v1\Film;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Film::factory(20)->create();
    }
}
