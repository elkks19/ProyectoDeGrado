<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::all()->except(Auth::id());
        $deletedUsers = User::onlyTrashed()->get()->except(Auth::id());

        $users = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->getRoleNames(),
                'fechaNacimiento' => $user->fechaNacimiento->format('Y-m-d'),
                'ci' => $user->ci,
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $user->updated_at->format('Y-m-d H:i:s'),
                'deleted_at' => $user->deleted_at?->format('Y-m-d H:i:s'),
            ];
        });

        $deletedUsers = $deletedUsers->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->getRoleNames(),
                'fechaNacimiento' => $user->fechaNacimiento->format('Y-m-d'),
                'ci' => $user->ci,
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $user->updated_at->format('Y-m-d H:i:s'),
                'deleted_at' => $user->deleted_at?->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json([
            'data' => $users,
            'deletedData' => $deletedUsers,
            'columns' => [
                [ 'field' => 'id', 'header' => 'ID', 'type' => 'text'],
                [ 'field' => 'name', 'header' => 'Nombre', 'type' => 'text'],
                [ 'field' => 'ci', 'header' => 'Carnet de Identidad', 'type' => 'text'],
                [ 'field' => 'email', 'header' => 'Email', 'type' => 'text'],
                [ 'field' => 'roles', 'header' => 'Roles', 'type' => 'chips'],
                [ 'field' => 'fechaNacimiento', 'header' => 'Fecha de Nacimiento', 'type' => 'text'],
                [ 'field' => 'created_at', 'header' => 'Fecha de Creación', 'type' => 'text'],
                [ 'field' => 'updated_at', 'header' => 'Ultima Actualización', 'type' => 'text'],
                [ 'field' => 'deleted_at', 'header' => 'Fecha de Eliminación', 'type' => 'status'],
            ],
            'createColumns' => [
                [ 'field' => 'name', 'header' => 'Nombre', 'type' => 'text' ],
                [ 'field' => 'email', 'header' => 'Email', 'type' => 'email' ],
                [ 'field' => 'ci', 'header' => 'Carnet de Identidad', 'type' => 'text' ],
                [ 'field' => 'fechaNacimiento', 'header' => 'Fecha de Nacimiento', 'type' => 'date' ],
                [ 'field' => 'roles', 'header' => 'Roles', 'type' => 'multiselect', 'options' => Role::All()->pluck('name') ],
                [ 'field' => 'password', 'header' => 'Contraseña', 'type' => 'password' ],
                [ 'field' => 'password_confirmation', 'header' => 'Confirmar Contraseña', 'type' => 'password' ],
            ],
            'editColumns' => [
                [ 'field' => 'name', 'header' => 'Nombre', 'type' => 'text' ],
                [ 'field' => 'email', 'header' => 'Email', 'type' => 'email' ],
                [ 'field' => 'ci', 'header' => 'Carnet de Identidad', 'type' => 'text' ],
                [ 'field' => 'fechaNacimiento', 'header' => 'Fecha de Nacimiento', 'type' => 'date' ],
                [ 'field' => 'roles', 'header' => 'Roles', 'type' => 'multiselect', 'options' => Role::All()->pluck('name') ],
                [ 'field' => 'password', 'header' => 'Contraseña', 'type' => 'password' ],
            ],
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        $user = $request->save();

        event(new Registered($user));

        return response()->json(['message' => 'Usuario creado correctamente'], 201);
    }


    public function update(UpdateUserRequest $request, User $user)
    {
        $request->update($user);
        return response()->json(['message' => 'Usuario actualizado correctamente'], 200);
    }


    public function destroy(int $id)
    {
        $user = User::withTrashed()->find($id);

        if ($user->trashed()) {
            $user->restore();
            return response()->json(['message' => 'Usuario restaurado correctamente'], 200);
        }

        $user->delete();
        return response()->json(['message' => 'Usuario eliminado correctamente'], 200);
    }
}
