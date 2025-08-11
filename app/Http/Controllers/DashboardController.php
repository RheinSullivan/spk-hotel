<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $jumlahHotel = Hotel::count();
            $jumlahPengguna = User::count();

            return view('dashboard.admin', [
                'jumlahHotel' => $jumlahHotel,
                'jumlahPengguna' => $jumlahPengguna,
            ]);
        }

        if ($user->role === 'user') {
            // User biasa diarahkan ke dashboard user
            return view('dashboard.user');
        }

        // Jika role tidak dikenali
        return abort(403, 'Unauthorized action.');
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
        //
    }
}
