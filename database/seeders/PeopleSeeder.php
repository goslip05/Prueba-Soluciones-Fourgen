<?php

namespace Database\Seeders;

use App\Models\People;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PeopleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 20) as $i) {
            People::create([
                'name' => $faker->name,
                'document' => $faker->unique()->randomNumber(8),
                'email' => $faker->unique()->safeEmail,
                'birthday' => $faker->date('Y-m-d', '2025-12-31'),
                'phone' => $faker->phoneNumber,
            ]);
        }
    }
}
