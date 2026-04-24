<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'nisn_nip' => '000',
            'password' => Hash::make('adminadmin'),
            'role' => 'admin',
        ]);
    }
}
