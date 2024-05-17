<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Orden;
use App\EstadosOrden;

class OrdenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Orden::create([
            'estado' => EstadosOrden::PENDIENTE,
            'pago_id' => 1,
            'envio_id' => 1,
            'user_id' => 1,
        ])->productos()->attach([1, 2, 3]);
        Orden::create([
            'estado' => EstadosOrden::PENDIENTE,
            'pago_id' => 2,
            'envio_id' => 2,
            'user_id' => 2,
        ])->productos()->attach([4, 5, 6]);
        Orden::create([
            'estado' => EstadosOrden::PENDIENTE,
            'pago_id' => 3,
            'envio_id' => 3,
            'user_id' => 1,
        ])->productos()->attach([1, 3, 5]);
        Orden::create([
            'estado' => EstadosOrden::PENDIENTE,
            'pago_id' => 4,
            'envio_id' => 4,
            'user_id' => 1,
        ])->productos()->attach([2, 4, 6]);
        Orden::create([
            'estado' => EstadosOrden::PENDIENTE,
            'pago_id' => 5,
            'envio_id' => 5,
            'user_id' => 1,
        ])->productos()->attach([1, 2, 3, 4, 5, 6]);
        Orden::create([
            'estado' => EstadosOrden::PENDIENTE,
            'pago_id' => 6,
            'envio_id' => 6,
            'user_id' => 1,
        ])->productos()->attach([1, 6]);
    }
}
