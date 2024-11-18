<?php

// database/seeders/UserSeeder.php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        if(User::where('email' , 'admin@example.com')->doesntExist()){
            User::factory()->admin()->create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
            ]);
        }


        // Create regular users
        User::factory()->count(10)->create();
    }
}
