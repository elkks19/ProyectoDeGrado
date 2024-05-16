<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        $deletedCategorias = Categoria::onlyTrashed()->get();

        $categorias = $categorias->map(function ($user) {
            return [
                'id' => $user->id,
                'nombre' => $user->nombre,
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $user->updated_at->format('Y-m-d H:i:s'),
                'deleted_at' => $user->deleted_at == null ? null : $user->deleted_at->format('Y-m-d H:i:s'),
            ];
        });

        $deletedCategorias = $deletedCategorias->map(function ($user) {
            return [
                'id' => $user->id,
                'nombre' => $user->nombre,
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $user->updated_at->format('Y-m-d H:i:s'),
                'deleted_at' => $user->deleted_at == null ? null : $user->deleted_at->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json([
            'data' => $categorias,
            'deletedData' => $deletedCategorias,
            'columns' => [
                [ 'field' => 'id', 'header' => 'ID', 'type' => 'text'],
                [ 'field' => 'nombre', 'header' => 'Nombre', 'type' => 'text'],
                [ 'field' => 'created_at', 'header' => 'Fecha de Creación', 'type' => 'text'],
                [ 'field' => 'updated_at', 'header' => 'Ultima Actualización', 'type' => 'text'],
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

    public function store(StoreCategoriaRequest $request)
    {
        $categoria = $request->save();
        return response()->json(['message' => 'Categoria creada correctamente'], 201);
    }

    public function update(UpdateCategoriaRequest $request, Categoria $categoria)
    {
        $categoria = $request->update($categoria);
        return response()->json(['message' => 'Categoria actualizada correctamente'], 200);
    }

    public function destroy(int $id)
    {
        $categoria = Categoria::withTrashed()->find($id);

        if($categoria->trashed()){
            $categoria->restore();
            return response()->json(['message' => 'Categoria restaurada correctamente'], 200);
        }

        $categoria->delete();
        return response()->json(['message' => 'Categoria eliminada correctamente'], 200);
    }
}
