<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MuridSeeder extends Seeder
{
   public function run(): void
    {
        User::create([
            'name' => 'MuridA1',
            'nisn_nip' => '111',
            'password' => Hash::make('muridmurid'),
            'role' => 'murid',
        ]);
                User::create([
            'name' => 'MuridA2',
            'nisn_nip' => '112',
            'password' => Hash::make('muridmurid'),
            'role' => 'murid',
        ]);
                User::create([
            'name' => 'MuridB1',
            'nisn_nip' => '113',
            'password' => Hash::make('muridmurid'),
            'role' => 'murid',
        ]);
                User::create([
            'name' => 'MuridB2',
            'nisn_nip' => '114',
            'password' => Hash::make('muridmurid'),
            'role' => 'murid',
        ]);
    }
}
