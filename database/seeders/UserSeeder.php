<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@app.com'],
            ['name' => 'Admin', 'password' => bcrypt('password'), 'role' => 'admin']
        );

        \App\Models\User::firstOrCreate(
            ['email' => 'kitchen@app.com'],
            ['name' => 'Kitchen', 'password' => bcrypt('password'), 'role' => 'kitchen']
        );

        \App\Models\User::firstOrCreate(
            ['email' => 'cashier@app.com'],
            ['name' => 'Cashier User', 'password' => bcrypt('password'), 'role' => 'cashier']
        );

        \App\Models\User::firstOrCreate(
            ['email' => 'customer@app.com'],
            ['name' => 'Customer User', 'password' => bcrypt('password'), 'role' => 'customer']
        );
    }
}
