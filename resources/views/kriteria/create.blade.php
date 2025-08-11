<!-- Modal Tambah Kriteria -->
<div class="modal fade" id="createKriteriaModal" tabindex="-1" role="dialog" aria-labelledby="createKriteriaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{ route('kriteria.store') }}" method="POST" class="modal-content">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title">Tambah Kriteria</h5>
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
            @include('kriteria.form', ['kriteria' => null])
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
  </div>
</div>
