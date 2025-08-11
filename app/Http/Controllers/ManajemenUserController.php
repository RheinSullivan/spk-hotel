<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ManajemenUserController extends Controller
{
    /**
     * Tampilkan daftar pengguna.
     */
    public function index()
    {
        $users = User::whereIn('role', ['admin', 'user'])->get();
        return view('data-pengguna.index', compact('users'));
    }

    /**
     * Ambil data pengguna dalam format JSON.
     */
    public function getData()
    {
        $users = User::whereIn('role', ['admin', 'user'])->get();
        $data = $users->map(function ($user, $index) {
            return [
                'no'       => $index + 1,
                'id'       => $user->id,
                'nama'     => $user->nama,
                'email'    => $user->email,
                'username' => $user->username,
                'role'     => $user->role,
            ];
        });

        return response()->json(['data' => $data]);
    }

    /**
     * Form tambah pengguna.
     */
    public function create()
    {
        return view('data-pengguna.create');
    }

    /**
     * Simpan pengguna baru.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'     => 'required|string|max:50',
            'email'    => 'required|email|unique:users,email',
            'username' => 'required|string|max:20|unique:users,username',
            'password' => 'required|string|min:4|confirmed',
            'role'     => 'required|in:admin,user',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        User::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('data-pengguna.index')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    /**
     * Ambil data pengguna untuk edit.
     */
    public function edit($id)
    {
        $pengguna = User::findOrFail($id);
        return response()->json([
            'success' => true,
            'message' => 'Data pengguna berhasil diambil.',
            'data'    => $pengguna,
        ]);
    }

    /**
     * Update data pengguna.
     */
    public function update(Request $request, $id)
    {
        $pengguna = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama'     => 'required|string|max:50',
            'email'    => 'required|email|unique:users,email,' . $id,
            'username' => 'required|string|max:20|unique:users,username,' . $id,
            'role'     => 'required|in:admin,user',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $request->only(['nama', 'email', 'username', 'role']);

        if ($request->filled('password')) {
            $passwordValidator = Validator::make($request->all(), [
                'password' => 'min:4|confirmed',
            ]);

            if ($passwordValidator->fails()) {
                return response()->json($passwordValidator->errors(), 422);
            }

            $data['password'] = Hash::make($request->password);
        }

        $pengguna->update($data);

        return redirect()->route('data-pengguna.index')->with('success', 'Pengguna berhasil diperbarui!');
    }

    /**
     * Hapus pengguna.
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('data-pengguna.index')->with('success', 'Pengguna berhasil dihapus!');
    }
}

