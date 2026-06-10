<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@dimak.cl'],
            [
                'name' => 'Administrador Principal',
                'password' => Hash::make('12345678'),
                'role' => 'superadmin',
            ]
        );
    }
}