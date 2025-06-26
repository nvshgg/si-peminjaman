<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'email' => 'superradmin@email.com',
                'username' => 'superradmin',
                'password' => bcrypt('123456'),
                'name' => 'super admin walahu'
            ],
            [
                'email' => 'mamaia@email.com',
                'username' => 'mamia',
                'password' => bcrypt('123456'),
                'name' => 'mamamia lezatos'
            ]
        ];

        foreach($users as $user){
            User::create($user);
        }
    }
}
