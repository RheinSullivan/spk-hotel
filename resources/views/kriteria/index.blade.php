@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Data Kriteria</h1>
    <div class="ml-auto">
        <button class="btn btn-primary" data-toggle="modal" data-target="#createKriteriaModal">
            <i class="fa fa-plus"></i> Tambah Kriteria
        </button>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4">
                <select id="filterSifat" class="form-control">
                    <option value="">Semua Sifat</option>
                    <option value="benefit">Benefit</option>
                    <option value="cost">Cost</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered" id="kriteriaTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kriteria</th>
                        <th>Sifat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

@include('kriteria.create')

@foreach($kriteria as $kriteria)
    @include('kriteria.edit', ['kriteria' => $kriteria])
@endforeach
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    var table = $('#kriteriaTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: "{{ route('kriteria.getData') }}",
            data: function(d) {
                d.sifat = $('#filterSifat').val();
            }
        },
        columns: [
            { data: 'no', name: 'no' },
            { data: 'nama_kriteria', name: 'nama_kriteria' },
            { data: 'sifat_kriteria', name: 'sifat_kriteria' },
            {
                data: 'id',
                name: 'aksi',
                render: function(data) {
                    return `
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editKriteriaModal${data}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="/kriteria/${data}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    `;
                },
                orderable: false,
                searchable: false
            }
        ]
    });

    $('#filterSifat').on('change', function () {
        table.ajax.reload();
    });
});
</script>
@endpush
