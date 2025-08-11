<div class="form-group">
    <label>Hotel</label>
    <select name="id_hotel" class="form-control" required>
        <option value="">-- Pilih Hotel --</option>
        @foreach($hotels as $hotel)
            <option value="{{ $hotel->id }}" {{ old('id_hotel') == $hotel->id ? 'selected' : '' }}>
                {{ $hotel->nama_hotel }}
            </option>
        @endforeach
    </select>
</div>

<hr>

@foreach($kriteria as $krit)
    <div class="form-group">
        <label>{{ $krit->nama_kriteria }}</label>
        <input type="number" name="nilai[{{ $krit->id }}]" class="form-control"
               value="{{ old('nilai.' . $krit->id, $penilaian?->nilai ?? '') }}"
               required min="0" step="0.01">
    </div>
@endforeach
