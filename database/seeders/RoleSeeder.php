<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::updateOrCreate(['name' => 'doctor'], ['name' => 'doctor']);
        Role::updateOrCreate(['name' => 'patient'], ['name' => 'patient']);
        Role::updateOrCreate(['name' => 'gov'], ['name' => 'gov']);
    }
}
