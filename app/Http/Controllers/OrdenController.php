<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrdenRequest;
use App\Http\Requests\UpdateOrdenRequest;
use App\Models\Orden;
use App\Models\User;
use App\Models\Producto;
use App\Models\Divisa;
use App\Models\MetodoPago;

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
                'estado' => $orden->estado,
                'user' => $orden->user->name,

                'pago' => [
                    'monto' => $orden->pago?->monto,
                    'estado' => $orden->pago?->estado,
                    'fechaPago' => $orden->pago?->fechaPago?->format('Y-m-d'),
                    'divisa' => $orden->pago?->divisa?->nombre,
                    'metodoPago' => $orden->pago?->metodoPago?->nombre,
                ],
                'envio' => [
                    'direccion' => $orden->envio?->direccion,
                    'fechaEnvio' => $orden->envio?->fechaEnvio?->format('Y-m-d'),
                    'fechaRecepcion' => $orden->envio?->fechaRecepcion?->format('Y-m-d'),
                    'estado' => $orden->envio?->estado,
                    'precio' => $orden->envio?->precio,
                    'created_at' => $orden->envio?->created_at?->format('Y-m-d H:i:s'),
                    'updated_at' => $orden->envio?->updated_at?->format('Y-m-d H:i:s'),
                    'deleted_at' => $orden->envio?->deleted_at?->format('Y-m-d H:i:s'),
                ],

                'productos' => $orden->productos->pluck('nombre'),

                'created_at' => $orden->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $orden->updated_at->format('Y-m-d H:i:s'),
                'deleted_at' => $orden->deleted_at?->format('Y-m-d H:i:s'),
            ];
        });

        $deletedOrdenes = $deletedOrdenes->map(function ($orden) {
            return [
                'id' => $orden->id,
                'estado' => $orden->estado,
                'user' => $orden->user->name,
                'pago' => [
                    'monto' => $orden->pago?->monto,
                    'estado' => $orden->pago?->estado,
                    'fechaPago' => $orden->pago?->fechaPago?->format('Y-m-d'),
                    'divisa' => $orden->pago?->divisa?->nombre,
                    'metodoPago' => $orden->pago?->metodoPago?->nombre,
                ],
                'envio' => [
                    'direccion' => $orden->envio->direccion,
                    'fechaEnvio' => $orden->envio?->fechaEnvio?->format('Y-m-d'),
                    'fechaRecepcion' => $orden->envio?->fechaRecepcion?->format('Y-m-d'),
                    'estado' => $orden->envio?->estado,
                    'precio' => $orden->envio?->precio,
                    'created_at' => $orden->envio?->created_at?->format('Y-m-d H:i:s'),
                    'updated_at' => $orden->envio?->updated_at?->format('Y-m-d H:i:s'),
                    'deleted_at' => $orden->envio?->deleted_at?->format('Y-m-d H:i:s'),
                ],

                'productos' => $orden->productos->pluck('nombre'),

                'created_at' => $orden->envio->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $orden->envio->updated_at->format('Y-m-d H:i:s'),
                'deleted_at' => optional($orden->envio->deleted_at)->format('Y-m-d H:i:s'),
            ];
        });


        return response()->json([
            'data' => $ordenes,
            'deletedData' => $deletedOrdenes,
            'columns' => [
                [ 'field' => 'id', 'header' => 'ID', 'type' => 'text' ],
                [ 'field' => 'estado', 'header' => 'Estado', 'type' => 'chip' ],
                [ 'field' => 'user', 'header' => 'Usuario', 'type' => 'text' ],
                [ 'field' => 'pago', 'header' => 'Pago', 'type' => '1x1',
                    'data' => [
                        [ 'field' => 'monto', 'header' => 'Monto', 'type' => 'text' ],
                        [ 'field' => 'estado', 'header' => 'Estado', 'type' => 'select', 'options' => EstadosPago::all() ],
                        [ 'field' => 'fechaPago', 'header' => 'Fecha de Pago', 'type' => 'date' ],
                        [ 'field' => 'divisa', 'header' => 'Divisa', 'type' => 'select', 'options' => Divisa::all()->pluck('nombre') ],
                        [ 'field' => 'metodoPago', 'header' => 'Metodo de Pago', 'type' => 'select', 'options' => MetodoPago::all()->pluck('nombre') ],
                    ],
                    'url' => '/pagos'
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
                [ 'field' => 'productos', 'header' => 'Productos', 'type' => 'mxn', 'options' => Producto::all()->pluck('nombre')],
                [ 'field' => 'created_at', 'header' => 'Fecha de Creación', 'type' => 'text' ],
                [ 'field' => 'updated_at', 'header' => 'Ultima Actualización', 'type' => 'text' ],
                [ 'field' => 'deleted_at', 'header' => 'Fecha de Eliminación', 'type' => 'status' ],
            ],
            'createColumns' => [
                [ 'field' => 'estado', 'header' => 'Estado', 'type' => 'select', 'options' => EstadosOrden::all() ],
                [ 'field' => 'user', 'header' => 'Usuario', 'type' => 'select', 'options' => User::all()->pluck('name') ],
            ],

            'editColumns' => [
                [ 'field' => 'estado', 'header' => 'Estado', 'type' => 'select', 'options' => EstadosOrden::all() ],
                [ 'field' => 'user', 'header' => 'Usuario', 'type' => 'select', 'options' => User::all()->pluck('name') ],
            ]
        ]);
    }

    public function store(StoreOrdenRequest $request)
    {
        $orden = $request->store();
        return response()->json(['message' => 'Orden creada correctamente.'], 201);
    }

    public function update(UpdateOrdenRequest $request, Orden $orden)
    {
        $orden = $request->update($orden);
        return response()->json(['message' => 'Orden actualizada correctamente.'], 200);
    }

    public function destroy(int $id)
    {
        $orden = Orden::withTrashed()->find($id);

        if($orden->trashed()) {
            $orden->restore();
            return response()->json(['message' => 'Orden restaurada correctamente.'], 200);
        }

        $orden->delete();
        return response()->json(['message' => 'Orden eliminada correctamente.'], 200);
    }
}
