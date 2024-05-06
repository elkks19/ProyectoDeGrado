<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $users = User::withTrashed()->get()->except(Auth::id());

        $users = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $user->updated_at->format('Y-m-d H:i:s'),
                'deleted_at' => $user->deleted_at == null ? "aun no eliminado" : $user->deleted_at->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json([
            'data' => $users,
            'columns' => [
                [ 'field' => 'id', 'header' => 'ID'],
                [ 'field' => 'name', 'header' => 'Nombre'],
                [ 'field' => 'email', 'header' => 'Email'],
                [ 'field' => 'role', 'header' => 'Rol'],
                [ 'field' => 'created_at', 'header' => 'Fecha de Creación'],
                [ 'field' => 'updated_at', 'header' => 'Ultima Actualización'],
                [ 'field' => 'deleted_at', 'header' => 'Fecha de Eliminación'],
            ],
            'createColumns' => [
                [ 'field' => 'name', 'header' => 'Nombre', 'type' => 'text' ],
                [ 'field' => 'email', 'header' => 'Email', 'type' => 'email' ],
                [ 'field' => 'role', 'header' => 'Rol', 'type' => 'select', 'options' => Role::All()->pluck('name') ],
                [ 'field' => 'password', 'header' => 'Contraseña', 'type' => 'password' ],
                [ 'field' => 'password_confirmation', 'header' => 'Confirmar Contraseña', 'type' => 'password' ],
            ],
            'editColumns' => [
                [ 'field' => 'name', 'header' => 'Nombre'],
                [ 'field' => 'email', 'header' => 'Email'],
                [ 'field' => 'role', 'header' => 'Rol'],
            ],
        ]);
    }

    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json(['message' => 'User deleted'], 200);
    }
}
