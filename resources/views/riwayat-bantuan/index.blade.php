@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Riwayat Bantuan</h1>
    <div class="ml-auto">
        <button class="btn btn-secondary mr-2" onclick="window.location.href='{{ route('riwayat_bantuan.print') }}'">
            <i class="fa fa-print"></i> Print
        </button>
        <button class="btn btn-primary" data-toggle="modal" data-target="#createModal">
            <i class="fa fa-plus"></i> Tambah Riwayat Bantuan
        </button>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table_id" class="display">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Penerima</th>
                                <th>Jenis Bantuan</th>
                                <th>Tanggal Diterima</th>
                                <th>Keterangan</th>
                                @if(auth()->user()->role_id !== 3) <!-- Kolom opsi hanya untuk role selain 3 -->
                                <th>Opsi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Modal for Riwayat Bantuan -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Tambah Riwayat Bantuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <form id="createForm" action="{{ route('riwayat-bantuan.store') }}" method="POST">
                    @csrf
                    <!-- Validation Errors -->
                    <div class="form-group">
                        <label>Penerima Bantuan</label>
                        <select name="penerima_bantuan_id" class="form-control" required>
                            <option value="" disabled selected>Pilih Penerima Bantuan</option>
                            @foreach($penerima_bantuan as $penerima)
                                <option value="{{ $penerima->id }}" {{ old('penerima_bantuan_id') == $penerima->id ? 'selected' : '' }}>
                                    {{ $penerima->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jenis Bantuan</label>
                        <select name="jenis_bantuan_id" class="form-control" required>
                            <option value="" disabled selected>Pilih Jenis Bantuan</option>
                            @foreach($jenis_bantuan as $jb)
                                <option value="{{ $jb->id }}" {{ old('jenis_bantuan_id') == $jb->id ? 'selected' : '' }}>
                                    {{ $jb->nama_bantuan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Diterima</label>
                        <input type="date" name="tanggal_diterima" class="form-control" value="{{ old('tanggal_diterima') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control">{{ old('keterangan') }}</textarea>
                    </div>
                    <div id="validation-errors" class="alert alert-danger" style="display: none;"></div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit and Show Modals for Riwayat Bantuan -->
@foreach($riwayat_bantuan as $riwayat)
<!-- Show Modal -->
<div class="modal fade" id="showModal{{ $riwayat->id }}" tabindex="-1" aria-labelledby="showModalLabel{{ $riwayat->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showModalLabel{{ $riwayat->id }}">Detail Riwayat Bantuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <p><strong>Penerima Bantuan:</strong> {{ $riwayat->penerimaBantuan->nama_lengkap }}</p>
                        <p><strong>Jenis Bantuan:</strong> {{ $riwayat->jenisBantuan->nama_bantuan }}</p>
                        <p><strong>Tanggal Diterima:</strong> {{ $riwayat->tanggal_diterima }}</p>
                        <p><strong>Keterangan:</strong> {{ $riwayat->keterangan }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal{{ $riwayat->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $riwayat->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{ $riwayat->id }}">Edit Riwayat Bantuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editForm{{ $riwayat->id }}" action="{{ route('riwayat-bantuan.update', $riwayat->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Penerima Bantuan</label>
                        <select name="penerima_bantuan_id" class="form-control" required>
                            <option value="" disabled>Pilih Penerima Bantuan</option>
                            @foreach($penerima_bantuan as $penerima)
                                <option value="{{ $penerima->id }}" {{ $riwayat->penerima_bantuan_id == $penerima->id ? 'selected' : '' }}>
                                    {{ $penerima->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Jenis Bantuan</label>
                        <select name="jenis_bantuan_id" class="form-control" required>
                            <option value="" disabled>Pilih Jenis Bantuan</option>
                            @foreach($jenis_bantuan as $jb)
                                <option value="{{ $jb->id }}" {{ $riwayat->jenis_bantuan_id == $jb->id ? 'selected' : '' }}>
                                    {{ $jb->nama_bantuan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Diterima</label>
                        <input type="date" name="tanggal_diterima" class="form-control" value="{{ $riwayat->tanggal_diterima }}" required>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control">{{ $riwayat->keterangan }}</textarea>
                    </div>

                    <div id="error-container{{ $riwayat->id }}" class="alert alert-danger" style="display: none;"></div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endforeach

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#table_id').DataTable({
            paging: true,
            searching: true,
            ajax: {
                url: "/riwayat-bantuan/get-data",
                type: "GET",
                dataSrc: "data",
                beforeSend: function() {
                    console.log('Loading data...');
                },
                complete: function(data) {
                    console.log(data);
                }
            },
            columns: [
                { data: "no" },
                { data: "penerima" },
                { data: "jenis_bantuan" },
                { data: "tanggal_diterima" },
                { data: "keterangan" },
                {
                    data: "id",
                    render: function(data, type, row, meta) {
                        return `
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#showModal${data}">
                                <i class="far fa-eye"></i>
                            </button>
                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal${data}">
                                <i class="far fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="${data}">
                                <i class="fas fa-trash"></i>
                            </button>
                        `;
                    }
                }
            ],
            order: [[0, 'asc']]
        });

        // Handle form submission for creating a new Riwayat Bantuan
        $('#createForm').on('submit', function(e) {
            e.preventDefault(); // Prevent regular form submission

            var formData = new FormData(this); // Get form data
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $('#createModal').modal('hide'); // Close the modal
                        location.reload(); // Reload the page or you can update dynamically

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                },
                error: function(response) {
                    var errors = response.responseJSON.errors;
                    var errorMessages = '';
                    for (var error in errors) {
                        errorMessages += '<li>' + errors[error] + '</li>';
                    }
                    $('#validation-errors').html('<ul>' + errorMessages + '</ul>').show(); // Show validation errors
                }
            });
        });

        // Handle form submission for editing a Riwayat Bantuan
        @foreach($riwayat_bantuan as $riwayat)
        $('#editForm{{ $riwayat->id }}').on('submit', function(e) {
            e.preventDefault(); // Prevent regular form submission

            var formData = new FormData(this); // Get form data
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            $('#editModal{{ $riwayat->id }}').modal('hide');
                            location.reload(); // Reload the page
                        });
                    }
                },
                error: function(response) {
                    var errors = response.responseJSON.errors;
                    var errorMessages = '';
                    for (var error in errors) {
                        errorMessages += '<li>' + errors[error] + '</li>';
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        html: '<ul>' + errorMessages + '</ul>',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
        @endforeach

        // Handle delete action
        $(document).on('click', '.delete-btn', function(e) {
            var riwayatId = $(this).data('id');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data riwayat bantuan ini akan dihapus.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/riwayat-bantuan/" + riwayatId,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    location.reload(); // Reload the page
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Gagal menghapus riwayat bantuan.',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        });

    });
</script>

@endsection
