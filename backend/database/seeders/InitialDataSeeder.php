<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InitialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'jaibey',
            'email' => 'jpisco@coarms.com',
            'password' => bcrypt('password'),
            'status' => 'ACTIVO'
        ]);
    }
}
