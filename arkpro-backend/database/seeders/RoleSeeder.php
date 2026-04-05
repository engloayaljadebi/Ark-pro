<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        \App\Models\Role::create(['name' => 'Manager', 'description' => 'مدير النظام']);
        \App\Models\Role::create(['name' => 'Technician', 'description' => 'فني صيانة']);
        \App\Models\Role::create(['name' => 'Reception', 'description' => 'موظف استقبال']);
    }
}
