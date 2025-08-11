<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Kriteria;
use App\Models\BobotKriteria;
use App\Models\Penilaian;

class PerhitunganController extends Controller
{
    public function index()
    {
        $kriteria = Kriteria::all();
        $bobotList = BobotKriteria::pluck('bobot', 'id_kriteria');
        $hotels = Hotel::with('penilaian.kriteria')->get()->unique('nama_hotel')->values();

        $matrix = [];
        $nilaiMax = [];
        $nilaiMin = [];
        $normalisasi = [];
        $rankingList = [];

        // 1. Ambil nilai asli
        foreach ($hotels as $hotel) {
            foreach ($kriteria as $krit) {
                $nilai = $hotel->penilaian->firstWhere('id_kriteria', $krit->id)?->nilai ?? 0;
                $matrix[$hotel->id][$krit->id] = $nilai;
            }
        }

        // 2. Hitung nilai max & min
        foreach ($kriteria as $krit) {
            $allValues = array_column($matrix, $krit->id);
            $nilaiMax[$krit->id] = max($allValues);
            $nilaiMin[$krit->id] = min($allValues);
        }

        // 3. Normalisasi
        foreach ($kriteria as $krit) {
            foreach ($hotels as $hotel) {
                $nilai = $matrix[$hotel->id][$krit->id];
                if (strtolower($krit->sifat_kriteria) === 'benefit') {
                    $hasil = $nilaiMax[$krit->id] != 0 ? $nilai / $nilaiMax[$krit->id] : 0;
                    $rumus = "{$nilai} / {$nilaiMax[$krit->id]}";
                } else {
                    $hasil = $nilai != 0 ? $nilaiMin[$krit->id] / $nilai : 0;
                    $rumus = "{$nilaiMin[$krit->id]} / {$nilai}";
                }
                $normalisasi[$hotel->id][$krit->id] = [
                    'hasil' => round($hasil, 4),
                    'rumus' => $rumus
                ];
            }
        }

        // 4. Hitung total skor & ranking
        foreach ($hotels as $hotel) {
            $total = 0;
            $normOnly = [];
            foreach ($kriteria as $krit) {
                $normVal = $normalisasi[$hotel->id][$krit->id]['hasil'] ?? 0;
                $bobot = $bobotList[$krit->id] ?? 0;
                $total += $normVal * $bobot;
                $normOnly[$krit->id] = $normVal;
            }

            $rankingList[] = [
                'id' => $hotel->id,
                'nama' => $hotel->nama_hotel,
                'normalisasi' => $normOnly,
                'total' => round($total, 4),
            ];
        }

        // Urutkan berdasarkan total tertinggi
        usort($rankingList, fn($a, $b) => $b['total'] <=> $a['total']);
        foreach ($rankingList as $i => &$ranked) {
            $ranked['ranking'] = $i + 1;
        }

        // Kirim semua data ke view
        return view('perhitungan.index', compact(
            'kriteria',
            'hotels',
            'matrix',
            'nilaiMax',
            'nilaiMin',
            'normalisasi',
            'rankingList',
            'bobotList'
        ));
    }
}
