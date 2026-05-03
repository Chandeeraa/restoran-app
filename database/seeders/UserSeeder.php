<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@app.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        
        \App\Models\User::create([
            'name' => 'Kitchen',
            'email' => 'kitchen@app.com',
            'password' => bcrypt('password'),
            'role' => 'kitchen',
        ]);

        \App\Models\User::create([
            'name' => 'Cashier User',
            'email' => 'cashier@app.com',
            'password' => bcrypt('password'),
            'role' => 'cashier',
        ]);

        \App\Models\User::create([
            'name' => 'Customer User',
            'email' => 'customer@app.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);
    }
}
