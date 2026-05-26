<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
    //    User::create([
    //        'name' => 'Admin',
    //        'email' => 'admin@example.com',
    //        'password' => bcrypt('password'),
    //        'role' => 'admin',
    //    ]);

    //    User::create([
    //        'name' => 'Reviewer',
    //        'email' => 'reviewer@example.com',
    //        'password' => bcrypt('password'),
    //        'role' => 'reviewer',
    //    ]);

        User::create([
            'name' => 'User1',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
    }
}
