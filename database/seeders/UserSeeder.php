<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Diego jimenez',
            'email' => 'diego.jimenez205@gmail.com',
            'password' => bcrypt('Dev2025*'),
        ]);

        User::create([
            'name' => 'Usuario Prueba',
            'email' => 'prueba@prueba.com',
            'password' => bcrypt('12345678'),
        ]);
    }
}
