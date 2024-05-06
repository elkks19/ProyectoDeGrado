<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $users = User::All()->except(Auth::user()->id);

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
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
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
