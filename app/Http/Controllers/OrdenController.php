<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrdenRequest;
use App\Http\Requests\UpdateOrdenRequest;
use App\Models\Orden;

use Inertia\Inertia;
use App\EstadosOrden;
use App\EstadosPago;
use App\EstadosEnvio;

class OrdenController extends Controller
{
    public function index()
    {
        $ordenes = Orden::with('productos')->get();
        $deletedOrdenes = Orden::onlyTrashed()->with('productos')->get();

        $ordenes = $ordenes->map(function ($orden) {
            return [
                'id' => $orden->id,
                'estado' => [$orden->estado],
                'pago' => [
                    'monto' => $orden->pago->monto,
                    'estado' => [$orden->pago->estado],
                    'fechaPago' => $orden->pago->fechaPago,
                ],
                'envio' => [
                    'direccion' => $orden->envio->direccion,
                    'fechaEnvio' => optional($orden->envio->fechaEnvio)->format('Y-m-d H:i:s'),
                    'fechaRecepcion' => optional($orden->envio->fechaRecepcion)->format('Y-m-d H:i:s'),
                    'estado' => $orden->envio->estado,
                    'precio' => $orden->envio->precio,
                    'created_at' => $orden->envio->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $orden->envio->updated_at->format('Y-m-d H:i:s'),
                    'deleted_at' => optional($orden->envio->deleted_at)->format('Y-m-d H:i:s'),
                ],
            ];
        });

        return response()->json([
            'data' => $ordenes,
            'deletedData' => $deletedOrdenes,
            'columns' => [
                [ 'field' => 'id', 'header' => 'ID', 'type' => 'text' ],
                [ 'field' => 'estado', 'header' => 'Estado', 'type' => 'chips' ],
                [ 'field' => 'pago', 'header' => 'Pago', 'type' => '1x1',
                    'data' => [
                        [ 'field' => 'monto', 'header' => 'Monto', 'type' => 'text' ],
                        [ 'field' => 'estado', 'header' => 'Estado', 'type' => 'select', 'options' => EstadosPago::all() ],
                        [ 'field' => 'fechaPago', 'header' => 'Fecha de Pago', 'type' => 'text' ],
                        [ 'field' => 'divisa', 'header' => 'Divisa', 'type' => 'text' ],
                        [ 'field' => 'metodoPago', 'header' => 'Metodo de Pago', 'type' => 'text' ],
                    ]
                ],
                [ 'field' => 'envio', 'header' => 'Envio', 'type' => '1x1',
                    'data' => [
                        [ 'field' => 'direccion', 'header' => 'Direccion', 'type' => 'text' ],
                        [ 'field' => 'fechaEnvio', 'header' => 'Fecha de Envio', 'type' => 'text' ],
                        [ 'field' => 'fechaRecepcion', 'header' => 'Fecha de Recepcion', 'type' => 'text' ],
                        [ 'field' => 'estado', 'header' => 'Estado', 'type' => 'select', 'options' => EstadosEnvio::all() ],
                        [ 'field' => 'precio', 'header' => 'Precio', 'type' => 'text' ],
                    ]
                ],
                [ 'field' => 'productos', 'header' => 'Productos', 'type' => 'mxn',
                    'data' => [
                        [ 'field' => 'nombre', 'header' => 'Nombre', 'type' => 'text' ],
                        [ 'field' => 'descripcion', 'header' => 'Descripcion', 'type' => 'text' ],
                        [ 'field' => 'precio', 'header' => 'Precio', 'type' => 'text' ],
                    ]
                ]
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
