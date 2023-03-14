<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::updateOrCreate(
            ['username' => 'admin'],
            [
                'password' => Hash::make('secret'),
                'email' => 'hemantd983983@gmail.com',
                'aadhar_no' => '1234123412345',
                'mob_no' => '1234567890',
                'name' => 'Admin Admin',
                // 'api_token' => Str::uuid(),
            ]
        );

        Doctor::updateOrCreate(
            ['user_id' => $user1->id],
            ['hospital_name' => 'adfasdfadsf asdfadf', 'address' => 'asdfasdfdf']
        );

        $user2 = User::updateOrCreate(
            ['username' => 'p1'],
            [
                'password' => Hash::make('secret'),
                'email' => 'pubg983983@gmail.com',
                'aadhar_no' => '123412341234',
                'mob_no' => '1234567891',
                'name' => 'P1',
                // 'api_token' => Str::uuid(),
            ]
        );

        UserRole::updateOrCreate(
            ['user_id' => $user1->id, 'role_id' => Role::whereName('doctor')->first()->id],
            ['user_id' => $user1->id, 'role_id' => Role::whereName('doctor')->first()->id]
        );

        UserRole::updateOrCreate(
            ['user_id' => $user2->id, 'role_id' => Role::whereName('patient')->first()->id],
            ['user_id' => $user2->id, 'role_id' => Role::whereName('patient')->first()->id]
        );
    }
}
