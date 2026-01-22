<?php

namespace Database\Seeders;

use App\Models\Thing;
use App\Models\Description;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DescriptionSeeder extends Seeder
{
    public function run(): void
    {
        // Получаем все вещи, у которых ещё нет описаний
        $things = Thing::doesntHave('descriptions')->get();

        foreach ($things as $thing) {
            Description::create([
                'thing_id' => $thing->id,
                'content' => 'Автоматическое описание для ' . $thing->name,
                'is_current' => true,
            ]);
        }
        
        $thingsWithHistory = Thing::has('descriptions')->inRandomOrder()->limit(10)->get();
        foreach ($thingsWithHistory as $thing) {
            // Снимаем актуальность со старого
            $thing->descriptions()->update(['is_current' => false]);
            
            // Добавляем новое
            Description::create([
                'thing_id' => $thing->id,
                'content' => 'Обновлённое описание для ' . $thing->name,
                'is_current' => true,
            ]);
        }
    }
}