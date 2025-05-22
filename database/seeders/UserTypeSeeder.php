<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { 
        UserType::create(['name' => 'user', 'description' => 'Voluntario que se apunta a eventos']);
        UserType::create(['name' => 'org', 'description' => 'Organización que crea un evento']);
    }
}
