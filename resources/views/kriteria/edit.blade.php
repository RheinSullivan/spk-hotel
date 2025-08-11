<!-- Modal Edit Kriteria -->
<div class="modal fade" id="editKriteriaModal{{ $kriteria->id }}" tabindex="-1" role="dialog" aria-labelledby="editKriteriaLabel{{ $kriteria->id }}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form action="{{ route('kriteria.update', $kriteria->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title">Edit Kriteria</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                @include('kriteria.form', ['kriteria' => $kriteria])
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
  </div>
</div>
