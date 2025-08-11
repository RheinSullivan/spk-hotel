@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $hotel->nama_hotel }}</h1>
    <p>{{ $hotel->alamat }}</p>
    <p>Harga mulai dari Rp {{ number_format($hotel->harga * 1000, 0, ',', '.') }}</p>
    <p>Rating: {{ $hotel->rating }}</p>
    <p>Fasilitas: {{ $hotel->fasilitas }}</p>
    <p>Deskripsi: {{ $hotel->deskripsi }}</p>

    <h4>Gambar Hotel:</h4>
    <div>
        @foreach($hotel->images as $img)
            <img src="{{ asset('storage/' . $img->path) }}" width="200" class="mb-2">
        @endforeach
    </div>
</div>
@endsection
