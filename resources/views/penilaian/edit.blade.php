<!-- Modal Edit Penilaian -->
<div class="modal fade" id="editPenilaianModal{{ $hotel->id }}" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="{{ route('penilaian.update', $hotel->id) }}" method="POST" class="modal-content">
        @csrf
        @method('PUT')
        <div class="modal-header">
            <h5 class="modal-title">Edit Penilaian untuk {{ $hotel->nama_hotel }}</h5>
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
            @foreach($kriteria as $krit)
                <div class="form-group">
                    <label>{{ $krit->nama_kriteria }}</label>
                   <input type="number" 
                    name="nilai[{{ $krit->id }}]" 
                    class="form-control"
                    value="{{ $hotel->penilaian->firstWhere('id_kriteria', $krit->id)?->nilai ?? 0 }}"
                    required 
                    min="0" 
                    step="any">
                </div>
            @endforeach
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
  </div>
</div>
