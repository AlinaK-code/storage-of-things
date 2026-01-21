<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Place;
use App\Models\Thing;
use App\Models\UseRecord;

class TestDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(5)->create();
        Place::factory(10)->create();
        Thing::factory(20)->create();
        UseRecord::factory(30)->create();
    }
}