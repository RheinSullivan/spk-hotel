<?php

namespace App\Http\Controllers;

use App\Models\BobotKriteria;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class BobotKriteriaController extends Controller
{
    public function index()
    {
        $kriteria = Kriteria::all();
        return view('bobot.index', compact('kriteria'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kriteria' => 'required|exists:kriteria,id',
            'bobot' => 'required|numeric|min:0',
        ]);

        BobotKriteria::create($request->only(['id_kriteria', 'bobot']));

        return redirect()->route('bobot.index')->with('success', 'Bobot berhasil disimpan');
    }

    public function edit($id)
    {
        $bobot = BobotKriteria::findOrFail($id); // Tanpa relasi
        return response()->json($bobot);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_kriteria' => 'required|exists:kriteria,id',
            'bobot' => 'required|numeric|min:0',
        ]);

        $bobot = BobotKriteria::findOrFail($id);
        $bobot->update([
            'id_kriteria' => $request->id_kriteria,
            'bobot' => $request->bobot,
        ]);

        return redirect()->back()->with('success', 'Bobot berhasil diperbarui');
    }

    public function destroy($id)
    {
        $bobot = BobotKriteria::findOrFail($id);
        $bobot->delete();

        return redirect()->back()->with('success', 'Bobot berhasil dihapus');
    }

    public function getData()
    {
        $data = BobotKriteria::with('kriteria')->get()->map(function ($item, $index) {
            return [
                'no' => $index + 1,
                'nama_kriteria' => $item->kriteria->nama_kriteria ?? '-',
                'bobot' => $item->bobot,
                'id_bobot' => $item->id_bobot // <-- ini penting!
            ];
        });

        return response()->json(['data' => $data]);
    }

}
