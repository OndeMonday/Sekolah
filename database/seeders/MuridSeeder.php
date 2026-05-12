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
            'nisn_nip' => '101',
            'password' => Hash::make('muridmurid'),
            'role' => 'murid',
        ]);
                User::create([
            'name' => 'MuridA2',
            'nisn_nip' => '102',
            'password' => Hash::make('muridmurid'),
            'role' => 'murid',
        ]);
                User::create([
            'name' => 'MuridA3',
            'nisn_nip' => '103',
            'password' => Hash::make('muridmurid'),
            'role' => 'murid',
        ]);
                User::create([
            'name' => 'MuridA4',
            'nisn_nip' => '104',
            'password' => Hash::make('muridmurid'),
            'role' => 'murid',
        ]);
        User::create([
            'name' => 'MuridA5',
            'nisn_nip' => '105',
            'password' => Hash::make('muridmurid'),
            'role' => 'murid',
        ]);
        User::create([
            'name' => 'MuridA6',
            'nisn_nip' => '106',
            'password' => Hash::make('muridmurid'),
            'role' => 'murid',
        ]);
        User::create([
            'name' => 'MuridA7',
            'nisn_nip' => '107',
            'password' => Hash::make('muridmurid'),
            'role' => 'murid',
        ]);
        User::create([
            'name' => 'MuridA8',
            'nisn_nip' => '108',
            'password' => Hash::make('muridmurid'),
            'role' => 'murid',
        ]);
        User::create([
            'name' => 'MuridA9',
            'nisn_nip' => '109',
            'password' => Hash::make('muridmurid'),
            'role' => 'murid',
        ]);
        user::create([
            'name' => 'MuridA10',
            'nisn_nip' => '110',
            'password' => Hash::make('muridmurid'),
            'role' => 'murid',
        ]);
          }

}
