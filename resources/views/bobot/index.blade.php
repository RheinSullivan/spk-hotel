@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Data Bobot Kriteria</h1>
    <div class="ml-auto">
        <button class="btn btn-primary" data-toggle="modal" data-target="#createBobotModal">
            <i class="fa fa-plus"></i> Tambah Bobot
        </button>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body table-responsive">
        <table class="table table-bordered" id="bobotTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kriteria</th>
                    <th>Bobot</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

@include('bobot.create', ['kriteria' => $kriteria])
@include('bobot.edit', ['kriteria' => $kriteria])

@endsection

@push('scripts')
<script>
$(document).ready(function () {
    const table = $('#bobotTable').DataTable({
        ajax: "{{ route('bobot.getData') }}",
        columns: [
            { data: 'no' },
            { data: 'nama_kriteria' },
            { data: 'bobot' },
            {
                data: 'id_bobot',
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-warning btn-sm editBtn" data-id="${data}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="/bobot-kriteria/${data}" method="POST" style="display:inline;">
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

    // AJAX Edit Button
    $('#bobotTable').on('click', '.editBtn', function () {
        const id = $(this).data('id');
        $.get(`/bobot-kriteria/${id}/edit`, function (data) {
            $('#editBobotForm').attr('action', `/bobot-kriteria/${data.id_bobot}`);
            $('#edit_id_kriteria').val(data.id_kriteria).trigger('change');
            $('#edit_bobot').val(data.bobot);
            $('#editBobotModal').modal('show');
        });
    });
});
</script>
@endpush
