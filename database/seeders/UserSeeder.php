<?php 

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder{
    public function run(): void{
        $users = [
            [
                'name' => 'Owner GOR A',
                'email' => 'gora@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'owner',
                'phone' => '087830614484'
            ],
            [
                'name' => 'Owner GOR B',
                'email' => 'gorb@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'owner',
                'phone' => '087830614484'
            ],
            [
                'name' => 'Owner GOR C',
                'email' => 'gorc@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'owner',
                'phone' => '087830614484'
            ],
            [
                'name' => 'Admin Bos',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '087830614484'
            ],
        ];

        foreach ($users as $user){
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}

