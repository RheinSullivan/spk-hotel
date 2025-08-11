@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Riwayat Bantuan</h1>
    <div class="ml-auto">
        <button class="btn btn-secondary mr-2" onclick="window.location.href='{{ route('riwayat_bantuan.print-user') }}'">
            <i class="fa fa-print"></i> Print
        </button>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">

            @if(session('errors'))
                <div class="alert alert-danger">
                    {{ session('errors')->first() }}
                </div>
            @endif

                <div class="table-responsive">
                    <table id="table_id" class="display">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Diterima</th>
                                <th>Jenis Bantuan</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayat_bantuan as $riwayat)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($riwayat->tanggal_diterima)->format('d M Y') }}</td>
                                    <td>{{ $riwayat->jenisBantuan->nama_bantuan ?? '-' }}</td>
                                    <td>{{ $riwayat->keterangan ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tambahkan script untuk menginisialisasi DataTables -->
<script>
    $(document).ready(function() {
        $('#table_id').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/Indonesian.json"
            }
        });
    });
</script>
@endsection
