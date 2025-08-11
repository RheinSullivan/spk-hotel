@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Detail Hotel</h1>
</div>

<div class="card">
    <div class="card-body">
        <h3>{{ $hotel->nama_hotel }}</h3>
        <p><strong>Alamat:</strong> {{ $hotel->alamat }}</p>
        <p><strong>Deskripsi:</strong> {{ $hotel->deskripsi }}</p>
        <p><strong>Fasilitas:</strong> {{ $hotel->fasilitas }}</p>
        <p><strong>Rating:</strong> {{ $hotel->rating }}</p>
        <p><strong>Harga:</strong> Rp{{ number_format($hotel->harga * 1000, 0, ',', '.') }}</p>
        
        <p><strong>Gambar:</strong></p>
        <div class="d-flex flex-column align-items-center justify-content-center gap-3">
            @if($hotel->images && $hotel->images->count())
            @foreach($hotel->images as $img)
            <img src="{{ asset('storage/' . $img->path) }}" alt="Hotel Image" width="512">
            @endforeach
            @endif
            <a href="{{ url()->previous() }}" class="btn btn-secondary mt-5">Kembali</a>
        </div>
    </div>
</div>
@endsection
