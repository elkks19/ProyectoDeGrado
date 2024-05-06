<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            MetodoPagoSeeder::class,
            EnvioSeeder::class,
            DivisaSeeder::class,
            PagoSeeder::class,
            OrdenSeeder::class,
            CategoriaSeeder::class,
            ProductoSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}
