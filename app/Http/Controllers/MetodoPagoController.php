<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMetodoPagoRequest;
use App\Http\Requests\UpdateMetodoPagoRequest;
use App\Models\MetodoPago;

class MetodoPagoController extends Controller
{
    public function index()
    {
        $metodosPago = MetodoPago::all();
        $deletedMetodosPago = MetodoPago::onlyTrashed()->get();

        $metodosPago= $metodosPago->map(function ($user) {
            return [
                'id' => $user->id,
                'nombre' => $user->nombre,
                'deleted_at' => $user->deleted_at?->format('Y-m-d H:i:s'),
            ];
        });

        $deletedMetodosPago = $deletedMetodosPago->map(function ($user) {
            return [
                'id' => $user->id,
                'nombre' => $user->nombre,
                'deleted_at' => $user->deleted_at?->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json([
            'data' => $metodosPago,
            'deletedData' => $deletedMetodosPago,
            'columns' => [
                [ 'field' => 'id', 'header' => 'ID', 'type' => 'text'],
                [ 'field' => 'nombre', 'header' => 'Nombre', 'type' => 'text'],
                [ 'field' => 'deleted_at', 'header' => 'Fecha de Eliminación', 'type' => 'status'],
            ],
            'createColumns' => [
                [ 'field' => 'nombre', 'header' => 'Nombre', 'type' => 'text' ],
            ],
            'editColumns' => [
                [ 'field' => 'nombre', 'header' => 'Nombre', 'type' => 'text' ],
            ],
        ]);
    }

    public function store(StoreMetodoPagoRequest $request)
    {
        $request->save();
        return response()->json(['message' => 'Metodo de Pago Guardado Correctamente'], 201);
    }

    public function update(UpdateMetodoPagoRequest $request, MetodoPago $metodoPago)
    {
        $request->update($metodoPago);
        return response()->json(['message' => 'Metodo de Pago Actualizado Correctamente'], 200);
    }

    public function destroy(int $id)
    {
        $metodoPago = MetodoPago::withTrashed()->find($id);

        if ($metodoPago->trashed()) {
            $metodoPago->restore();
            return response()->json(['message' => 'Metodo de Pago Restaurado Correctamente'], 200);
        }

        $metodoPago->delete();
        return response()->json(['message' => 'Metodo de Pago Eliminado Correctamente'], 200);
    }
}
