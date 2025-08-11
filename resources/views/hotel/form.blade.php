@php
    $nama = old('nama_hotel', isset($hotel) ? $hotel->nama_hotel : '');
    $alamat = old('alamat', isset($hotel) ? $hotel->alamat : '');
    $fasilitas = old('fasilitas', isset($hotel) ? $hotel->fasilitas : '');
    $harga = old('harga', isset($hotel) ? $hotel->harga : '');
    $rating = old('rating', isset($hotel) ? $hotel->rating : '');
    $deskripsi = old('deskripsi', isset($hotel) ? $hotel->deskripsi : '');
@endphp

<div class="form-group">
    <label>Nama Hotel</label>
    <input type="text" name="nama_hotel" class="form-control" value="{{ $nama }}" required>
</div>

<div class="form-group">
    <label>Alamat</label>
    <textarea name="alamat" class="form-control" required>{{ $alamat }}</textarea>
</div>

<div class="form-group">
    <label>Rating</label>
    <input type="number" step="0.1" name="rating" class="form-control" value="{{ $rating }}" required>
</div>

<div class="form-group">
    <label>Fasilitas</label>
    <textarea name="fasilitas" class="form-control" required>{{ $fasilitas }}</textarea>
</div>

<div class="form-group">
    <label>Harga</label>
    <input type="number" name="harga" step="0.001" class="form-control"
       value="{{ old('harga', $hotel->harga ?? '') }}">
</div>

<div class="form-group">
    <label>Deskripsi</label>
    <textarea name="deskripsi" class="form-control">{{ $deskripsi }}</textarea>
</div>

<div class="form-group">
    <label>Gambar (bisa pilih lebih dari 1)</label>
    <input type="file" name="images[]" class="form-control" multiple>
</div>

@if(isset($hotel) && $hotel->images)
    <div class="form-group">
        <label>Gambar saat ini:</label>
        <div class="d-flex flex-wrap">
            @foreach($hotel->images as $img)
                <div class="m-1 position-relative">
                    <img src="{{ asset('storage/' . $img->path) }}" width="80" class="img-thumbnail">
                    <form action="{{ route('hotel.image.delete', $img->id) }}" method="POST" onsubmit="return confirm('Hapus gambar ini?')" style="position: absolute; top: -10px; right: -10px;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger btn-circle">&times;</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
@endif
