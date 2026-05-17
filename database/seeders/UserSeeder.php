<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@app.com'],
            ['name' => 'Admin', 'password' => bcrypt('password'), 'role' => 'admin']
        );

        User::firstOrCreate(
            ['email' => 'kitchen@app.com'],
            ['name' => 'Kitchen', 'password' => bcrypt('password'), 'role' => 'kitchen']
        );

        User::firstOrCreate(
            ['email' => 'cashier@app.com'],
            ['name' => 'Cashier User', 'password' => bcrypt('password'), 'role' => 'cashier']
        );

        User::firstOrCreate(
            ['email' => 'customer@app.com'],
            ['name' => 'Customer User', 'password' => bcrypt('password'), 'role' => 'customer']
        );
    }
}
