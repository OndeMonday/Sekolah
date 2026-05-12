<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class GuruSeeder extends Seeder
{
   public function run(): void
    {
        User::create([
            'name' => 'A1guru',
            'nisn_nip' => '001',
            'password' => Hash::make('guruguru'),
            'role' => 'guru',
        ]);
                User::create([
            'name' => 'A2guru',
            'nisn_nip' => '002',
            'password' => Hash::make('guruguru'),
            'role' => 'guru',
        ]);
                User::create([
            'name' => 'A3guru',
            'nisn_nip' => '003',
            'password' => Hash::make('guruguru'),
            'role' => 'guru',
        ]);
                User::create([
            'name' => 'A4guru',
            'nisn_nip' => '004',
            'password' => Hash::make('guruguru'),
            'role' => 'guru',
        ]);
    }
}
