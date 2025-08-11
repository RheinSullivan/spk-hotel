@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Data Hasil Perhitungan</h1>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <div class="card-body table-responsive">
        <table class="table table-bordered" id="tabelHasil">
            <thead>
                <tr>
                    <th>Peringkat</th>
                    <th>Nama Hotel</th>
                    <th>Skor Akhir</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hasilList as $item)
                    <tr>
                        <td>{{ $item['no'] }}</td>
                        <td>{{ $item['nama_hotel'] }}</td>
                        <td>{{ $item['nilai'] }}</td>
                        <td>
                            <a href="{{ route('hotel.show', $item['id_hotel']) }}" class="btn btn-info btn-sm">
                                Lihat Detail
                            </a>
                            @if($item['updated_at'])
                                <small class="text-muted d-block mt-1">
                                    Data di-update: {{ \Carbon\Carbon::parse($item['updated_at'])->translatedFormat('d F Y H:i') }}
                                </small>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#tabelHasil').DataTable({
            ordering: true,
            searching: true,
            paging: true,
            responsive: true
        });
    });
</script>
@endpush
