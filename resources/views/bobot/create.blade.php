<!-- Modal Tambah Bobot -->
<div class="modal fade" id="createBobotModal" tabindex="-1" role="dialog" aria-labelledby="createBobotLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{ route('bobot.store') }}" method="POST" class="modal-content">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title">Tambah Bobot</h5>
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
            @include('bobot.form', ['bobot' => null, 'kriteria' => $kriteria, 'formId' => 'create_id_kriteria', 'inputId' => 'create_bobot'])
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
  </div>
</div>
