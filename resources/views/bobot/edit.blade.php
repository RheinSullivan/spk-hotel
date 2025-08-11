<!-- Modal Edit Bobot -->
<div class="modal fade" id="editBobotModal" tabindex="-1" role="dialog" aria-labelledby="editBobotLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="POST" class="modal-content" id="editBobotForm">
        @csrf
        @method('PUT')
        <div class="modal-header">
            <h5 class="modal-title">Edit Bobot</h5>
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
            {{-- Set ID input agar bisa diisi jQuery --}}
            @include('bobot.form', [
                'bobot' => (object) ['id_kriteria' => '', 'bobot' => ''],
                'kriteria' => $kriteria,
                'formId' => 'edit_id_kriteria',
                'inputId' => 'edit_bobot'
            ])
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
  </div>
</div>
