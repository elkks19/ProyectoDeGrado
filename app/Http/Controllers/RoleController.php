<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withTrashed()->where('id', '!=', Auth::id())->get();

        $roles = $roles->map(function ($role) {
            return [
                'id' => $role->id,
                'name' => $role->name,
                'created_at' => $role->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $role->updated_at->format('Y-m-d H:i:s'),
                'deleted_at' => $role->deleted_at == null ? null : $role->deleted_at->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json([
            'data' => $roles,
            'columns' => [
                [ 'field' => 'id', 'header' => 'ID', 'type' => 'text' ],
                [ 'field' => 'name', 'header' => 'Nombre', 'type' => 'text'],
                [ 'field' => 'created_at', 'header' => 'Fecha de Creación', 'type' => 'date'],
                [ 'field' => 'updated_at', 'header' => 'Ultima Actualización', 'type' => 'date'],
                [ 'field' => 'deleted_at', 'header' => 'Fecha de Eliminación', 'type' => 'text' ],
            ],
            'createColumns' => [
                [ 'field' => 'name', 'header' => 'Nombre', 'type' => 'text' ],
            ],
            'editColumns' => [
                [ 'field' => 'name', 'header' => 'Nombre', 'type' => 'text' ],
            ],
        ]);
    }

    public function store(StoreRoleRequest $request)
    {
        $role = $request->save();
        return response()->json(['message' => 'Rol creado correctamente'], 201);
    }


    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role = $request->update($role);
        return response()->json(['message' => 'Rol actualizado correctamente'], 200);
    }


    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json(['message' => 'Rol eliminado correctamente'], 200);
    }
}
