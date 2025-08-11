@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Data Pengguna</h1>
    <div class="ml-auto">
        <button class="btn btn-primary" data-toggle="modal" data-target="#createModal">
            <i class="fa fa-plus"></i> Tambah Pengguna
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
                    <table id="table_id" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('data-pengguna.create-modal')
@include('data-pengguna.edit-modals', ['users' => $users])
@include('data-pengguna.show-modals', ['users' => $users])

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#table_id').DataTable({
            processing: true,
            serverSide: false, // karena pakai map, bukan paginate
            ajax: "{{ route('data-pengguna.get-data') }}",
            columns: [
                { data: 'no', name: 'no' },
                { data: 'nama', name: 'nama' },
                { data: 'email', name: 'email' },
                { data: 'username', name: 'username' },
                { data: 'role', name: 'role' },
                {
                    data: 'id',
                    name: 'aksi',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        return `
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#showModal${data}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal${data}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="/data-pengguna/${data}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
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
