@php
    $selected = old('id_kriteria', $bobot->id_kriteria ?? '');
    $bobotValue = old('bobot', $bobot->bobot ?? '');
@endphp

<div class="form-group">
    <label>Nama Kriteria</label>
    <select name="id_kriteria" id="{{ $formId ?? 'id_kriteria' }}" class="form-control" required>
        <option value="" disabled>-- Pilih Kriteria --</option>
        @foreach($kriteria as $item)
        <option value="{{ $item->id }}" {{ $selected == $item->id ? 'selected' : '' }}>
            {{ $item->nama_kriteria }}
        </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label>Bobot</label>
    <input type="number" name="bobot" id="{{ $inputId ?? 'bobot' }}" step="0.01" class="form-control" required value="{{ $bobotValue }}">
</div>
