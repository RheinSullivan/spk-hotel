<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class HakAksesController extends Controller
{

    public function getData()
    {
        $roles = Role::all();
        $data = $roles->map(function ($role, $index) {
            return [
                'no'        => $index + 1,
                'id'        => $role->id,
                'role'      => $role->role,
                'deskripsi' => $role->deskripsi,
            ];
        });

        return response()->json(['data' => $data]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('hak-akses.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hak-akses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role'      => 'required',
            'deskripsi' => 'required'
        ], [
            'role.required'      => 'Form Role Wajib Di Isi !',
            'deskripsi.required' => 'Form Deskripsi Wajib Di Isi !'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Role::create([
            'role'      => $request->role,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()->route('hak-akses.index')->with('success', 'Data Berhasil Tersimpan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('hak-akses.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'role'      => 'required',
            'deskripsi' => 'required'
        ], [
            'role.required'         => 'Form Role Wajib Di Isi !',
            'deskripsi.required'    => 'Form Deskripsi Wajib Di Isi !'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $role->update([
            'role'      => $request->role,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()->route('hak-akses.index')->with('success', 'Data Berhasil Terupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $role = Role::find($id);

        if ($role) {
            $role->delete();
            return redirect()->route('hak-akses.index')->with('success', 'Data Berhasil Dihapus!');
        } else {
            return redirect()->route('hak-akses.index')->with('error', 'Role not found.');
        }
    }
}
