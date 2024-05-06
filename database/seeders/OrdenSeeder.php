<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Orden;

class OrdenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Orden::create([
            'estado' => 'pendiente',
            'pago_id' => 1,
            'envio_id' => 1,
        ]);
        Orden::create([
            'estado' => 'pendiente',
            'pago_id' => 2,
            'envio_id' => 2,
        ]);
        Orden::create([
            'estado' => 'pendiente',
            'pago_id' => 3,
            'envio_id' => 3,
        ]);
        Orden::create([
            'estado' => 'pendiente',
            'pago_id' => 4,
            'envio_id' => 4,
        ]);
        Orden::create([
            'estado' => 'pendiente',
            'pago_id' => 5,
            'envio_id' => 5,
        ]);
        Orden::create([
            'estado' => 'pendiente',
            'pago_id' => 6,
            'envio_id' => 6,
        ]);


    }
}
