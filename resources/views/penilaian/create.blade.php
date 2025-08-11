<!-- Modal Tambah Penilaian -->
<div class="modal fade" id="createPenilaianModal" tabindex="-1" role="dialog" aria-labelledby="createPenilaianLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{ route('penilaian.store') }}" method="POST" class="modal-content">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title">Tambah Penilaian</h5>
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
            @include('penilaian.form', ['penilaian' => null])
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
  </div>
</div>
