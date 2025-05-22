<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Juan Pérez',
            'email' => 'juan@gmail.com',
            'password' => Hash::make('123'),
            'userTypeId' => 1,
        ]);

        User::create([
            'name' => 'Carlos López',
            'email' => 'carlos@gmail.com',
            'password' => Hash::make('123'),
            'userTypeId' => 1,
        ]);

        User::create([
            'name' => 'Adriana Elías',
            'email' => 'aelias@gmail.com',
            'password' => Hash::make('123'),
            'userTypeId' => 1,
        ]);

        User::create([
            'name' => 'María Fernández',
            'email' => 'mfernandez@gmail.com',
            'password' => Hash::make('123'),
            'userTypeId' => 1,
        ]);

        User::create([
            'name' => 'Gos Maco',
            'email' => 'gosmaco@gmail.com',
            'password' => Hash::make('123'),
            'userTypeId' => 2,
        ]);

        User::create([
            'name' => 'Bird Friends',
            'email' => 'birdfriends@gmail.com',
            'password' => Hash::make('123'),
            'userTypeId' => 2,
        ]);

        User::create([
            'name' => 'Galgos112',
            'email' => 'galgos112@gmail.com',
            'password' => Hash::make('123'),
            'userTypeId' => 2,
        ]);
        
        User::create([
            'name' => 'Brigada Animalista Barcelona',
            'email' => 'brigadanimal@gmail.com',
            'password' => Hash::make('123'),
            'userTypeId' => 2,
        ]);
    }
}
