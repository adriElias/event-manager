<?php

namespace Database\Seeders;

use App\Models\Participation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParticipationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Participation::create(['id_user' => '1', 'id_event' =>1]);
        Participation::create(['id_user' => '3', 'id_event' =>2]);
    }
}
