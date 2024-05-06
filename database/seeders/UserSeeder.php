<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Rafael Fabiani',
            'email' => 'rafafabiani1909@gmail.com',
            'password' => Hash::make('asdf1234'),
            'ci' => '9101085'
        ]);
        User::create([
            'name' => 'Prueba',
            'email' => 'prueba@prueba.com',
            'password' => Hash::make('prueba'),
            'ci' => '9101010'
        ]);
        User::create([
            'name' => 'Prueba 2',
            'email' => 'otraprueba@prueba.com',
            'password' => Hash::make('prueba'),
            'ci' => '12341234'
        ]);
        User::create([
            'name' => 'Prueba 3',
            'email' => 'otraprueba2@prueba.com',
            'password' => Hash::make('prueba'),
            'ci' => '910812'
        ]);
    }
}
