<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrdenRequest;
use App\Http\Requests\UpdateOrdenRequest;
use App\Models\Orden;

use Inertia\Inertia;
use App\EstadosOrden;

class OrdenController extends Controller
{
    public function index()
    {
        $ordenes = Orden::with('productos')->get();

        return response()->json([
            'data' => $ordenes,
            'columns' => [
                [ 'field' => 'id', 'header' => 'ID' ],
                [ 'field' => 'estado', 'header' => 'Estado' ],
                [ 'field' => 'pago', 'header' => 'Pago' ],
                [ 'field' => 'envio', 'header' => 'Envio' ],
            ],
            'createColumns' => [
                [ 'field' => 'estado', 'header' => 'Estado', 'type' => 'select', 'options' => EstadosOrden::all() ],
                [ 'field' => 'pago', 'header' => 'Pago', 'type' => '' ],
                [ 'field' => 'envio', 'header' => 'Envio', 'type' => 'button' ],
            ],

            'editColumns' => [
                [ 'field' => 'estado', 'header' => 'Estado', 'type' => 'select', 'options' => EstadosOrden::all() ],
                [ 'field' => 'pago', 'header' => 'Pago', 'type' => 'text' ],
                [ 'field' => 'envio', 'header' => 'Envio', 'type' => 'text' ],
            ]
        ]);
    }

    public function store(StoreOrdenRequest $request)
    {
        $orden = $request->save();
    }

    public function update(UpdateOrdenRequest $request, Orden $orden)
    {
        //
    }

    public function destroy(Orden $orden)
    {
        //
    }
}
