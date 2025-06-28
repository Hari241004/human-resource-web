<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'super admin',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('poweradmin'),
                'role' => 'superadmin',
            ],

            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ],

            [
                'name' => 'employee',
                'email' => 'employee@gmail.com',
                'password' => Hash::make('employee123'),
                'role' => 'user',
            ],
            [
                'name' => '123',
                'email' => '123',
                'password' => Hash::make('123'),
                'role' => 'user',
            ]
        ];

        foreach ($users as $value) {
            User::create([
                'name' => $value['name'],
                'email' => $value['email'],
                'password' => $value['password'],
                'role' => $value['role'],
            ]);
        }
    }
}
