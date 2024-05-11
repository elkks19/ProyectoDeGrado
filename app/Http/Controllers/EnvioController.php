<?php

namespace App\Http\Controllers;

use App\EstadosEnvio;
use App\Http\Requests\StoreEnvioRequest;
use App\Http\Requests\UpdateEnvioRequest;
use App\Models\Envio;

class EnvioController extends Controller
{
    public function index()
    {
        $envios = Envio::withTrashed()->get();

        $envios = $envios->map(function ($role) {
            return [
                'id' => $role->id,
                'direccion' => $role->direccion,
                'fechaEnvio' => $role->fechaEnvio,
                'fechaRecepcion' => $role->fechaRecepcion,
                'estado' => array($role->estado),
                'precio' => $role->precio,
                'created_at' => $role->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $role->updated_at->format('Y-m-d H:i:s'),
                'deleted_at' => $role->deleted_at == null ? null : $role->deleted_at->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json([
            'data' => $envios,
            'columns' => [
                [ 'field' => 'id', 'header' => 'ID', 'type' => 'text' ],
                [ 'field' => 'direccion', 'header' => 'Direccion', 'type' => 'text'],
                [ 'field' => 'fechaEnvio', 'header' => 'Fecha de Envio', 'type' => 'date'],
                [ 'field' => 'fechaRecepcion', 'header' => 'Fecha de Recepcion', 'type' => 'date'],
                [ 'field' => 'estado', 'header' => 'Estado', 'type' => 'chips' ],
                [ 'field' => 'created_at', 'header' => 'Fecha de Creación', 'type' => 'date'],
                [ 'field' => 'updated_at', 'header' => 'Ultima Actualización', 'type' => 'date'],
                [ 'field' => 'deleted_at', 'header' => 'Fecha de Eliminación', 'type' => 'text' ],
            ],
            'createColumns' => [
                [ 'field' => 'direccion', 'header' => 'Direccion', 'type' => 'text' ],
                [ 'field' => 'fechaEnvio', 'header' => 'Fecha de Envio', 'type' => 'date' ],
                [ 'field' => 'fechaRecepcion', 'header' => 'Fecha de Recepcion', 'type' => 'date' ],
                [ 'field' => 'estado', 'header' => 'Estado', 'type' => 'select', 'options' => EstadosEnvio::all() ],
            ],
            'editColumns' => [
                [ 'field' => 'direccion', 'header' => 'Direccion', 'type' => 'text' ],
                [ 'field' => 'fechaEnvio', 'header' => 'Fecha de Envio', 'type' => 'date' ],
                [ 'field' => 'fechaRecepcion', 'header' => 'Fecha de Recepcion', 'type' => 'date' ],
                [ 'field' => 'estado', 'header' => 'Estado', 'type' => 'select', 'options' => EstadosEnvio::all() ],
            ],
        ]);
    }

    public function store(StoreEnvioRequest $request)
    {
        $envio = $request->save();
        return response()->json(['message' => 'Envio guardado correctamente'], 201);
    }

    public function update(UpdateEnvioRequest $request, Envio $envio)
    {
        $envio = $request->update($envio);
        return response()->json(['message' => 'Envio actualizado correctamente'], 200);
    }

    public function destroy(Envio $envio)
    {
        $envio->delete();
        return response()->json(['message' => 'Envio eliminado correctamente'], 200);
    }
}
