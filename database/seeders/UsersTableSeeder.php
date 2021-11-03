<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'admin',
            'phone' => '12345678',
            'email' => 'admin@email.com',
            'city' => 'Dubai',
            'country' => 'United Arab Emirates',
            'status' => 1,
            'password' => Hash::make('12345678'),
            'user_type' => 'admin',
            'email_verified_at' => now(),
            
        ]);
        $admin->assignRole('admin');

        $staff = User::create([
            'name' => 'staff',
            'phone' => '12345678',
            'email' => 'staff@email.com',
            'user_type' => 'staff',
            'city' => 'Dubai',
            'country' => 'United Arab Emirates',
            'status' => 1,
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
        ]);
        $staff->assignRole('staff');

        $user = User::create([
            'name' => 'user',
            'phone' => '12345678',
            'email' => 'user@email.com',
            'user_type' => 'user',
            'city' => 'Dubai',
            'country' => 'United Arab Emirates',
            'status' => 1,
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
        ]);
        $user->assignRole('user');
    }
}
