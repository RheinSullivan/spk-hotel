@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Data Hotel</h1>
    <div class="ml-auto">
        <button class="btn btn-primary" data-toggle="modal" data-target="#createHotelModal"><i class="fa fa-plus"></i> Tambah Hotel</button>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body table-responsive">
        <table class="table table-bordered" id="hotelTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Hotel</th>
                    <th>Alamat</th>
                    <th>Harga</th>
                    <th>Rating</th>
                    <th>Fasilitas</th>
                    <th>Deskripsi</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

@include('hotel.create', ['hotel' => null])

{{-- Render semua modal edit di bawah --}}
@foreach($hotels as $hotel)
    @include('hotel.edit', ['hotel' => $hotel])
@endforeach
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    const table = $('#hotelTable').DataTable({
        ajax: "{{ route('hotel.getData') }}",
        columns: [
            { data: 'no' },
            { data: 'nama_hotel' },
            { data: 'alamat' },
            { data: 'harga' },
            { data: 'rating' },
            { data: 'fasilitas' },
            { data: 'deskripsi' },
            { data: 'gambar' },
            {
                data: 'id',
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-warning btn-sm editBtn" data-id="${data}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="/hotel/${data}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus hotel ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    `;
                }
            }
        ]
    });

    // Tombol edit AJAX (opsional jika kamu ingin AJAX edit juga)
    $('#hotelTable').on('click', '.editBtn', function () {
        const id = $(this).data('id');
        $('#editHotelModal' + id).modal('show');
    });
});
</script>
@endpush

