<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@researchgroup.it',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Mario Rossi',
            'email' => 'mario.rossi@researchgroup.it',
            'password' => Hash::make('password'),
            'role' => 'docente',
        ]);

        User::create([
            'name' => 'Laura Bianchi',
            'email' => 'laura.bianchi@researchgroup.it',
            'password' => Hash::make('password'),
            'role' => 'docente',
        ]);

        User::create([
            'name' => 'Giuseppe Verdi',
            'email' => 'giuseppe.verdi@researchgroup.it',
            'password' => Hash::make('password'),
            'role' => 'collaboratore',
        ]);
    }
}
