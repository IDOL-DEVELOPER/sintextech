<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();
        $names = [];

        for ($i = 0; $i < 100; $i++) {
            $uniqueName = $faker->unique()->word;
            $names[] = $uniqueName;
        }

        foreach ($names as $name) {
            Category::insert([
                'name' => $name,
            ]);
        }
    }
}
