@php
    $nama = old('nama_kriteria', $kriteria->nama_kriteria ?? '');
    $sifat = old('sifat_kriteria', $kriteria->sifat_kriteria ?? '');
@endphp

<div class="form-group">
    <label>Nama Kriteria</label>
    <input type="text" name="nama_kriteria" class="form-control" value="{{ $nama }}" required>
</div>

<div class="form-group">
    <label>Sifat Kriteria</label>
    <select name="sifat_kriteria" class="form-control" required>
        <option value="" disabled {{ $sifat === '' ? 'selected' : '' }}>-- Pilih Sifat --</option>
        <option value="benefit" {{ $sifat === 'benefit' ? 'selected' : '' }}>Benefit</option>
        <option value="cost" {{ $sifat === 'cost' ? 'selected' : '' }}>Cost</option>
    </select>
</div>
