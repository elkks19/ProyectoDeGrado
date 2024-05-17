<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDivisaRequest;
use App\Http\Requests\UpdateDivisaRequest;
use App\Models\Divisa;

class DivisaController extends Controller
{
    public function index()
    {
        $divisas = Divisa::all();
        $deletedDivisas = Divisa::onlyTrashed()->get();

        $divsas = $divisas->map(function ($user) {
            return [
                'id' => $user->id,
                'nombre' => $user->nombre,
                'simbolo' => $user->simbolo,
                'tasa' => $user->tasa,
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $user->updated_at->format('Y-m-d H:i:s'),
                'deleted_at' => optional($user->deleted_at)->format('Y-m-d H:i:s'),
            ];
        });

        $deletedDivisas = $deletedDivisas->map(function ($user) {
            return [
                'id' => $user->id,
                'nombre' => $user->nombre,
                'simbolo' => $user->simbolo,
                'tasa' => $user->tasa,
            ];
        });

        return response()->json([
            'data' => $users,
            'deletedData' => $deletedUsers,
            'columns' => [
                [ 'field' => 'id', 'header' => 'ID', 'type' => 'text'],
                [ 'field' => 'nombre', 'header' => 'Nombre', 'type' => 'text'],
                [ 'field' => 'simbolo', 'header' => 'Simbolo', 'type' => 'text'],
                [ 'field' => 'tasa', 'header' => 'Tasa', 'type' => 'text'],
                [ 'field' => 'created_at', 'header' => 'Fecha de Creación', 'type' => 'text'],
                [ 'field' => 'updated_at', 'header' => 'Ultima Actualización', 'type' => 'text'],
                [ 'field' => 'deleted_at', 'header' => 'Fecha de Eliminación', 'type' => 'status'],
            ],
            'createColumns' => [
                [ 'field' => 'nombre', 'header' => 'Nombre', 'type' => 'text' ],
                [ 'field' => 'simbolo', 'header' => 'Simbolo', 'type' => 'text' ],
                [ 'field' => 'tasa', 'header' => 'Tasa', 'type' => 'text' ],
            ],
            'editColumns' => [
                [ 'field' => 'nombre', 'header' => 'Nombre', 'type' => 'text' ],
                [ 'field' => 'simbolo', 'header' => 'Simbolo', 'type' => 'text' ],
                [ 'field' => 'tasa', 'header' => 'Tasa', 'type' => 'text' ],
            ],
        ]);
    }

    public function store(StoreDivisaRequest $request)
    {
        //
    }

    public function update(UpdateDivisaRequest $request, Divisa $divisa)
    {
        //
    }

    public function destroy(Divisa $divisa)
    {
        //
    }
}
