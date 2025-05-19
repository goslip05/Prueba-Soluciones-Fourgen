<?php

namespace Database\Seeders;

use App\Models\People;
use App\Models\Pet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $personIds = People::pluck('id')->toArray();

        foreach (range(1, 20) as $i) {
            Pet::create([
                'person_id' => $faker->randomElement($personIds),
                'name' => $faker->firstName,
                'species' => $faker->randomElement(['Dog', 'Cat']),
                'breed' => $faker->word,
                'age' => $faker->numberBetween(1, 15),
                'image' => $faker->imageUrl(400, 300, 'animals', true),
            ]);
        }
    }
}
