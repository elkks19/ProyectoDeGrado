<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Producto;
use App\Models\Categoria;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        $deletedProductos = Producto::onlyTrashed()->get();

        $productos = $productos->map(function ($role) {
            return [
                'id' => $role->id,
                'nombre' => $role->nombre,
                'descripcion' => $role->descripcion,
                'precio' => $role->precio,
                'categorias' => $role->categorias->pluck('nombre'),
                'created_at' => $role->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $role->updated_at->format('Y-m-d H:i:s'),
                'deleted_at' => optional($role->deleted_at)->format('Y-m-d H:i:s'),
            ];
        });

        $deletedProductos = $deletedProductos->map(function ($role) {
            return [
                'id' => $role->id,
                'nombre' => $role->nombre,
                'descripcion' => $role->descripcion,
                'precio' => $role->precio,
                'categorias' => $role->categorias->pluck('nombre'),
                'created_at' => $role->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $role->updated_at->format('Y-m-d H:i:s'),
                'deleted_at' => optional($role->deleted_at)->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json([
            'data' => $productos,
            'deletedData' => $deletedProductos,
            'columns' => [
                [ 'field' => 'id', 'header' => 'ID', 'type' => 'text' ],
                [ 'field' => 'nombre', 'header' => 'Nombre', 'type' => 'text'],
                [ 'field' => 'descripcion', 'header' => 'Descripcion', 'type' => 'text'],
                [ 'field' => 'precio', 'header' => 'Precio', 'type' => 'text'],
                [ 'field' => 'categorias', 'header' => 'Categorias', 'type' => 'mxn', 'options' => Categoria::all()->pluck('nombre') ],
                [ 'field' => 'created_at', 'header' => 'Fecha de Creación', 'type' => 'date'],
                [ 'field' => 'updated_at', 'header' => 'Ultima Actualización', 'type' => 'date'],
                [ 'field' => 'deleted_at', 'header' => 'Fecha de Eliminación', 'type' => 'text' ],
            ],
            'createColumns' => [
                [ 'field' => 'nombre', 'header' => 'Nombre', 'type' => 'text' ],
                [ 'field' => 'descripcion', 'header' => 'Descripcion', 'type' => 'text' ],
                [ 'field' => 'precio', 'header' => 'Precio', 'type' => 'text' ],
            ],
            'editColumns' => [
                [ 'field' => 'nombre', 'header' => 'Nombre', 'type' => 'text' ],
                [ 'field' => 'descripcion', 'header' => 'Descripcion', 'type' => 'text' ],
                [ 'field' => 'precio', 'header' => 'Precio', 'type' => 'text' ],
            ],
        ]);
    }

    public function store(StoreProductoRequest $request)
    {
        $producto = $request->save();
        return response()->json(['message' => 'Producto creado correctamente'], 201);
    }

    public function update(UpdateProductoRequest $request, Producto $producto)
    {
        $producto = $request->update($producto);
        return response()->json(['message' => 'Producto actualizado correctamente'], 200);
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return response()->json(['message' => 'Producto eliminado correctamente'], 200);
    }
}
