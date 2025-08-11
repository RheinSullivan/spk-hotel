@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Data Hak Akses</h1>
    <div class="ml-auto">
        <button class="btn btn-primary" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i> Tambah Hak Akses</button>
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
                                <th>Role</th>
                                <th>Deskripsi</th>
                                <th>Opsi</th>
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

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Tambah Data Hak Akses</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('hak-akses.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Role</label>
                        <input type="text" name="role" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Show and Edit Modals -->
@foreach($roles as $role)
<!-- Show Modal -->
<div class="modal fade" id="showModal{{ $role->id }}" tabindex="-1" aria-labelledby="showModalLabel{{ $role->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showModalLabel{{ $role->id }}">Detail Data Hak Akses</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <p><strong>Role:</strong> {{ $role->role }}</p>
                        <p><strong>Deskripsi:</strong> {{ $role->deskripsi }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal{{ $role->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $role->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{ $role->id }}">Edit Data Hak Akses</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('hak-akses.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Role</label>
                        <input type="text" name="role" class="form-control" value="{{ $role->role }}" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control">{{ $role->deskripsi }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<script>
    $(document).ready(function() {
        $('#table_id').DataTable({
            paging: true, // Pagination
            searching: true, // Search
            ajax: {
                url: "/hak-akses/get-data", // Route for getting data
                type: "GET",
                dataSrc: "data" // Data source
            },
            columns: [
                { data: "no" }, // Nomor
                { data: "role" }, // Role
                { data: "deskripsi" }, // Deskripsi
                { // Kolom opsi
                    data: "id",
                    render: function(data, type, row, meta) {
                        return `
                            <button class="btn btn-info btn-icon" data-toggle="modal" data-target="#showModal${data}">
                                <i class="far fa-eye"></i>
                            </button>
                            <button class="btn btn-warning btn-icon" data-toggle="modal" data-target="#editModal${data}">
                                <i class="far fa-edit"></i>
                            </button>
                            <form action="/hak-akses/${data}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-icon" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        `;
                    }
                }
            ],
            order: [[0, 'asc']] // Urutan default
        });
    });
</script>

@endsection
