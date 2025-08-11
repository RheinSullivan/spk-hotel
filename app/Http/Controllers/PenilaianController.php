<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\Hotel;
use App\Models\Kriteria;
use App\Models\Hasil;
use App\Models\BobotKriteria;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function index()
    {
        $hotelSudahDinilaiIds = Penilaian::pluck('id_hotel')->unique();

        // Hotel yang belum dinilai, untuk form tambah
        $hotelsBelumDinilai = Hotel::whereNotIn('id', $hotelSudahDinilaiIds)->get();

        // Hotel yang sudah dinilai, untuk tabel dan modal edit
        $hotelsSudahDinilai = Hotel::whereIn('id', $hotelSudahDinilaiIds)
                                    ->with('penilaian')
                                    ->get();

        $kriteria = Kriteria::all();

        return view('penilaian.index', [
            'hotels' => $hotelsBelumDinilai,
            'hotelsSudahDinilai' => $hotelsSudahDinilai,
            'kriteria' => $kriteria,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_hotel' => 'required|exists:hotels,id',
            'nilai' => 'required|array',
            'nilai.*' => 'required|numeric|min:0',
        ]);

        $idHotel = $request->id_hotel;

        // Cek apakah hotel sudah pernah dinilai
        $existing = Penilaian::where('id_hotel', $idHotel)->exists();
        if ($existing) {
            return redirect()->back()->with('error', 'Hotel ini sudah diberi penilaian.');
        }

        foreach ($request->nilai as $idKriteria => $nilai) {
            Penilaian::create([
                'id_user' => auth()->id(),
                'id_hotel' => $idHotel,
                'id_kriteria' => $idKriteria,
                'nilai' => $nilai,
            ]);
        }

        $this->updateHasil($idHotel);

        return redirect()->route('penilaian.index')->with('success', 'Penilaian berhasil disimpan');
    }

    public function edit($idHotel)
    {
        $hotel = Hotel::with('penilaian.kriteria')->findOrFail($idHotel);
        $kriteria = Kriteria::all();

        // Bentuk data kriteria => nilai
        $nilaiPenilaian = $hotel->penilaian->pluck('nilai', 'id_kriteria')->toArray();

        return view('penilaian.edit', compact('hotel', 'kriteria', 'nilaiPenilaian'));
    }

    public function update(Request $request, $idHotel)
    {
        $request->validate([
            'nilai' => 'required|array',
            'nilai.*' => 'required|numeric|min:0',
        ]);

        foreach ($request->nilai as $idKriteria => $nilai) {
            Penilaian::updateOrCreate(
                [
                    'id_hotel' => $idHotel,
                    'id_kriteria' => $idKriteria,
                ],
                [
                    'id_user' => auth()->id(),
                    'nilai' => $nilai,
                ]
            );
        }

        $this->updateHasil($idHotel);

        return redirect()->route('penilaian.index')->with('success', 'Penilaian berhasil diperbarui.');
    }

    public function destroy($idHotel)
    {
        $hotel = Hotel::findOrFail($idHotel);

        // Hapus semua penilaian yang terkait hotel ini
        Penilaian::where('id_hotel', $hotel->id)->delete();

        Hasil::where('id_hotel', $hotel->id)->delete();

        return redirect()->route('penilaian.index')->with('success', 'Seluruh penilaian untuk hotel ini telah dihapus.');
    }

    // Optional: getData untuk DataTables
    public function getData()
    {
        $kriteriaList = Kriteria::all();
        $hotels = Hotel::with('penilaian.kriteria')->get();

        $data = [];
        foreach ($hotels as $index => $hotel) {
            if ($hotel->penilaian->isEmpty()) continue;

            $row = [
                'no' => $index + 1,
                'hotel' => $hotel->nama_hotel,
            ];

            foreach ($kriteriaList as $krit) {
    $nilai = $hotel->penilaian->firstWhere('id_kriteria', $krit->id)?->nilai;

    if (strtolower($krit->nama_kriteria) === 'harga') {
        // Format harga menjadi 3 angka di belakang koma
        $row['kriteria_'.$krit->id] = is_numeric($nilai) ? number_format($nilai, 3, '.', '') : '-';
    } else {
        // Kriteria lain tampil seperti input aslinya
        $row['kriteria_'.$krit->id] = $nilai ?? '-';
    }
}


            $row['hotel_id'] = $hotel->id;
            $data[] = $row;
        }

        return response()->json(['data' => $data]);
    }

    private function updateHasil($idHotel)
    {
        $allPenilaian = Penilaian::with('kriteria')->get(); // semua data
        $penilaianHotelIni = $allPenilaian->where('id_hotel', $idHotel);

        $kriteria = Kriteria::all();
        $bobotList = BobotKriteria::pluck('bobot', 'id_kriteria');

        if ($penilaianHotelIni->isEmpty()) {
            Hasil::where('id_hotel', $idHotel)->delete();
            return;
        }

        // Hitung max/min untuk tiap kriteria
        $matriks = [];
        foreach ($kriteria as $krit) {
            $nilaiKriteria = $allPenilaian->where('id_kriteria', $krit->id)->pluck('nilai');
            $matriks[$krit->id] = [
                'type' => strtolower($krit->sifat_kriteria),
                'max' => $nilaiKriteria->max(),
                'min' => $nilaiKriteria->min(),
            ];
        }

        // Hitung skor untuk hotel ini
        $skor = 0;
        foreach ($kriteria as $krit) {
            $nilai = $penilaianHotelIni->firstWhere('id_kriteria', $krit->id)?->nilai ?? 0;
            $info = $matriks[$krit->id];
            $bobot = $bobotList[$krit->id] ?? 0;

            if ($info['type'] === 'benefit') {
                $normal = $info['max'] > 0 ? $nilai / $info['max'] : 0;
            } else {
                $normal = $nilai > 0 ? $info['min'] / $nilai : 0;
            }

            $skor += $normal * $bobot;
        }

        Hasil::updateOrCreate(
            [
                'id_user' => auth()->id(),
                'id_hotel' => $idHotel,
            ],
            [
                'nilai' => $skor,
            ]
        );
    }

}
