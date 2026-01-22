<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        Unit::insert([
            ['name' => 'Штуки', 'symbol' => 'шт.'],
            ['name' => 'Килограммы', 'symbol' => 'кг'],
            ['name' => 'Литры', 'symbol' => 'л'],
            ['name' => 'Метры', 'symbol' => 'м'],
            ['name' => 'Упаковки', 'symbol' => 'уп.'],
        ]);
    }
}