<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // вставляю только если не существует (иначе выдает Integrity constraint violation)
        Role::firstOrCreate(['name' => 'user']);
        Role::firstOrCreate(['name' => 'admin']);
    }
}