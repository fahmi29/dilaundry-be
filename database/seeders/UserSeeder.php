<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
                'name' => 'blacknumbers',
                'username' => 'number',
                'email' => 'number@gmail.com',
                'password' => Hash::make('12345678')
            ],
        ];
        foreach ($user as $userItem) {
            User::create($userItem);
        }
    }
}
