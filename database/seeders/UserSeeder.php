<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::truncate();

        \App\Models\User::create([
            'name'  => 'John Doe',
        	'email' => 'admin@example.com',
        	'password' => bcrypt('password'),
        ]);
    }
}
