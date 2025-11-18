<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        // Simpan ke database
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password'])
        ]);

        // Balas dengan data yang baru dibuat
        return response()->json([
            'message' => 'User created successfully!',
            'data' => $user
        ], 201);
    }

    public function index()
{
    $users = \App\Models\User::all();

    return response()->json([
        'message' => 'Data users berhasil diambil!',
        'data' => $users
    ], 200);
}

public function update(Request $request, $id)
{
    $user = \App\Models\User::find($id);

    if (!$user) {
        return response()->json([
            'message' => 'User tidak ditemukan!'
        ], 404);
    }

    $validated = $request->validate([
        'name' => 'sometimes|required',
        'email' => 'sometimes|required|email|unique:users,email,' . $id,
        'password' => 'sometimes|required'
    ]);

    if (isset($validated['password'])) {
        $validated['password'] = bcrypt($validated['password']);
    }

    $user->update($validated);

    return response()->json([
        'message' => 'User berhasil diperbarui!',
        'data' => $user
    ], 200);
}

public function destroy($id)
{
    $user = \App\Models\User::find($id);

    if (!$user) {
        return response()->json([
            'message' => 'User tidak ditemukan!'
        ], 404);
    }

    $user->delete();

    return response()->json([
        'message' => 'User berhasil dihapus!'
    ], 200);
}

}
