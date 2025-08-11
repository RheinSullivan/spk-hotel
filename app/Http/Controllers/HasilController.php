<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Kriteria;
use App\Models\BobotKriteria;
use App\Models\Penilaian;

class HasilController extends Controller
{
    public function index()
    {
        $kriteria = Kriteria::all();
        $bobotList = BobotKriteria::pluck('bobot', 'id_kriteria');
        $hotels = Hotel::with('penilaian')->get()->unique('nama_hotel')->values();

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
                } else {
                    $hasil = $nilai != 0 ? $nilaiMin[$krit->id] / $nilai : 0;
                }
                $normalisasi[$hotel->id][$krit->id] = round($hasil, 4);
            }
        }

        // 4. Hitung total skor & ranking
        foreach ($hotels as $hotel) {
            $total = 0;
            foreach ($kriteria as $krit) {
                $normVal = $normalisasi[$hotel->id][$krit->id] ?? 0;
                $bobot = $bobotList[$krit->id] ?? 0;
                $total += $normVal * $bobot;
            }

            $rankingList[] = [
                'no' => count($rankingList) + 1,
                'id_hotel' => $hotel->id,
                'nama_hotel' => $hotel->nama_hotel,
                'nilai' => round($total, 4),
                'updated_at' => $hotel->updated_at
            ];
        }

        // Urutkan berdasarkan skor tertinggi
        usort($rankingList, fn($a, $b) => $b['nilai'] <=> $a['nilai']);

        return view('hasil.index', ['hasilList' => $rankingList]);
    }
}
