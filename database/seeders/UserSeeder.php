<?php

namespace Database\Seeders;

use App\Models\Role;
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
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Customer',
                'email' => 'customer@gmail.com',
                'password' => bcrypt('password'),
            ]
        ];

        foreach ($users as $user) {
            $createdUser = User::create($user);
            if($createdUser->email == 'admin@gmail.com'){
                $adminRole = Role::where('slug', 'admin')->first();
                $createdUser->roles()->attach($adminRole);
            }else{
                $customerRole = Role::where('slug', 'customer')->first();
                $createdUser->roles()->attach($customerRole);
            }
        }
    }
}
