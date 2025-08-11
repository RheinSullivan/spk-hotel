@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Dashboard Pengguna</h1>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h4 class="text-primary mb-3">
                    <i class="bi bi-info-circle-fill text-info"></i> Tentang Sistem
                </h4>
                <p class="text-muted" style="text-align: justify;">
                    Sistem ini dirancang untuk <strong>merekomendasikan hotel kepada wisatawan</strong> yang akan berlibur di Pangandaran.Rekomendasi ini, sudah berdasarkan proses perhitungan yang objektif menggunakan 
                    <strong>metode Simple Additive Weighting (SAW)</strong> dengan proses perhitungan 
                    normalisasi matriks keputusan. 
                    Semua kriteria penilaian telah diolah sebelumnya oleh sistem, sehingga 
                    anda dapat langsung melihat <strong>hasil akhir berupa skor tertinggi</strong> 
                    dan detail informasi setiap hotel yang direkomendasikan.
                </p>
            </div>
        </div>

        <div class="card shadow-sm border-0 mt-4">
            <div class="card-body text-center">
                <i class="bi bi-star-fill text-warning" style="font-size: 2rem;"></i>
                <h5 class="mt-2">Hasil Rekomendasi Hotel</h5>
                <p class="text-muted">
                    Silakan pilih menu <strong>Hasil Akhir</strong> pada navigasi 
                    untuk melihat daftar hotel dengan skor terbaik dan detailnya.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
