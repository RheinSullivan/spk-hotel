@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Hasil Perhitungan SAW</h1>
</div>

{{-- ===================== Proses Normalisasi Matriks Keputusan ===================== --}}
<div class="card mb-4">
    <div class="card-body table-responsive">
        <h4>Proses Normalisasi Matriks Keputusan</h4>

        @foreach ($kriteria as $krit)
            <h5>{{ $krit->nama_kriteria }} ({{ ucfirst($krit->sifat_kriteria) }})</h5>
            @if (strtolower($krit->sifat_kriteria) === 'benefit')
                <p><strong>Nilai Maksimum:</strong> {{ $nilaiMax[$krit->id] }}</p>
            @else
                <p><strong>Nilai Minimum:</strong> {{ $nilaiMin[$krit->id] }}</p>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="table-light">
                        <tr>
                            <th>Hotel</th>
                            <th>Nilai Asli</th>
                            <th>Rumus</th>
                            <th>Hasil</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hotels as $hotel)
                            <tr>
                                <td>{{ $hotel->nama_hotel }}</td>
                                <td class="text-end">{{ $matrix[$hotel->id][$krit->id] }}</td>
                                <td>{{ $normalisasi[$hotel->id][$krit->id]['rumus'] ?? '' }}</td>
                                <td class="text-end">{{ number_format($normalisasi[$hotel->id][$krit->id]['hasil'] ?? 0, 4) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <br>
        @endforeach
    </div>
</div>

{{-- ===================== Tabel Nilai Akhir ===================== --}}
<div class="card">
    <div class="card-body table-responsive">
        <h4>Proses Perhitungan Hasil Akhir</h4>
        <table class="table table-bordered" id="tabelSAW">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Hotel</th>
                    @foreach($kriteria as $krit)
                        <th>{{ $krit->nama_kriteria }}</th> {{-- hanya nama kriteria --}}
                    @endforeach
                    <th>Total Skor</th>
                    <th>Peringkat</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rankingList as $i => $item)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $item['nama'] }} (ID: {{ $item['id'] }})</td>
                        @foreach($kriteria as $krit)
                            <td class="text-end">
                                {{ number_format($item['normalisasi'][$krit->id] ?? 0, 4) }}
                                × {{ $bobotList[$krit->id] ?? 0 }}
                            </td>
                        @endforeach
                        <td class="text-end">{{ number_format($item['total'], 4) }}</td>
                        <td class="text-center">{{ $item['ranking'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
<style>
    @media (max-width: 768px) {
        table th {
            font-size: 12px;
            white-space: normal !important;
        }
    }
    table td, table th {
        vertical-align: middle;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function () {
    $('#tabelSAW').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        responsive: true
    });
});
</script>
@endpush
