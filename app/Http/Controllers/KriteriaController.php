<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriteria = Kriteria::all();
        return view('kriteria.index', compact('kriteria'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'sifat_kriteria' => 'required|in:benefit,cost',
        ]);

        Kriteria::create([
            'nama_kriteria' => $request->nama_kriteria,
            'sifat_kriteria' => $request->sifat_kriteria,
        ]);

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil disimpan');
    }

    public function edit(Kriteria $kriteria)
    {
        return response()->json($kriteria);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'sifat_kriteria' => 'required|string|in:benefit,cost', // contoh validasi
        ]);

        $kriteria = Kriteria::findOrFail($id);
        $kriteria->nama_kriteria = $request->nama_kriteria;
        $kriteria->sifat_kriteria = $request->sifat_kriteria;
        $kriteria->save();

        return redirect()->back()->with('success', 'Data kriteria berhasil diperbarui');
    }

    public function destroy($id)
    {
        $kriteria = Kriteria::findOrFail($id);
        $kriteria->delete();

        return redirect()->back()->with('success', 'Data kriteria berhasil dihapus');
    }

    // Optional: getData untuk DataTables
    public function getData(Request $request)
    {
        $query = Kriteria::query();

        if ($request->has('sifat') && $request->sifat != '') {
            $query->where('sifat_kriteria', $request->sifat);
        }

        $data = $query->get()->map(function ($item, $index) {
            return [
                'no' => $index + 1,
                'nama_kriteria' => $item->nama_kriteria,
                'sifat_kriteria' => ucfirst($item->sifat_kriteria),
                'id' => $item->id
            ];
        });

        return response()->json(['data' => $data]);
    }
}
