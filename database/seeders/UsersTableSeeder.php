<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                User::create([
                    'name' => 'Sileu',
                    'email' => 'sileu@example.com',
                    'password' => Hash::make('1234'),
                ]);

                User::create([
                    'name' => 'Deamal',
                    'email' => 'deamal@example.com',
                    'password' => Hash::make('1234'),
                ]);

                User::create([
                    'name' => 'Ossai',
                    'email' => 'ossai@example.com',
                    'password' => Hash::make('1234'),
                ]);

                User::create([
                    'name' => 'Isis',
                    'email' => 'isis@example.com',
                    'password' => Hash::make('1234'),
                ]);
    }
}
