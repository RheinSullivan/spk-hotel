@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Data Penilaian</h1>
    <div class="ml-auto">
        <button class="btn btn-primary" data-toggle="modal" data-target="#createPenilaianModal">
            <i class="fa fa-plus"></i> Tambah Penilaian
        </button>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body table-responsive">
        <table class="table table-bordered" id="penilaianTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Hotel</th>
                @foreach ($kriteria as $krit)
                    <th>{{ $krit->nama_kriteria }}</th>
                @endforeach
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    </div>
</div>

@include('penilaian.create', ['hotels' => $hotels, 'kriteria' => $kriteria])
{{-- Tampilkan semua modal edit --}}
{{-- Modal Edit Penilaian --}}
@foreach($hotelsSudahDinilai as $hotel)
    @include('penilaian.edit', ['hotel' => $hotel, 'kriteria' => $kriteria])
@endforeach

@endsection

@push('scripts')
<script>
$(document).ready(function () {
    const kriteriaList = @json($kriteria);

    $('#penilaianTable').DataTable({
        ajax: "{{ route('penilaian.getData') }}",
        columns: [
            { data: 'no' },
            { data: 'hotel' },
            ...kriteriaList.map(k => ({
                data: 'kriteria_' + k.id,
                defaultContent: '-'
            })),
            {
                data: 'hotel_id',
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editPenilaianModal${data}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="/penilaian/${data}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus semua penilaian untuk hotel ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    `;
                }
            }
        ]
    });
});
</script>
@endpush
