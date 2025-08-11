<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\HotelImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::with('images')->get(); // Eager load images
        return view('hotel.index', compact('hotels'));
    }

    public function create()
    {
        return view('hotel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_hotel' => 'required',
            'alamat' => 'required',
            'rating' => 'required|numeric',
            'fasilitas' => 'required',
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $hotel = Hotel::create($request->only([
            'nama_hotel', 'alamat', 'rating', 'fasilitas', 'harga', 'deskripsi'
        ]));

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('uploads/hotels', $filename, 'public');

                // Simpan path relatif
                $hotel->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('hotel.index')->with('success', 'Data hotel berhasil disimpan');
    }

    public function edit(Hotel $hotel)
    {
        $hotel->load('images');
        return view('hotel.edit', compact('hotel'));
    }
    public function show($id)
{
    $hotel = Hotel::with('images')->findOrFail($id);
    return view('hotel.detail', compact('hotel'));
}
    public function update(Request $request, Hotel $hotel)
    {
        $request->validate([
            'nama_hotel' => 'required',
            'alamat' => 'required',
            'rating' => 'required|numeric',
            'fasilitas' => 'required',
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $hotel->update($request->only([
            'nama_hotel', 'alamat', 'rating', 'fasilitas', 'harga', 'deskripsi'
        ]));

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('hotels', 'public');
                $hotel->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('hotel.index')->with('success', 'Data hotel berhasil diperbarui');
    }

    public function destroy($id)
{
    $hotel = Hotel::findOrFail($id);

    foreach ($hotel->images as $img) {
        Storage::disk('public')->delete($img->path);
    }

    $hotel->images()->delete();
    $hotel->delete();

    return redirect()->route('hotel.index')->with('success', 'Data hotel berhasil dihapus');
}


    public function getData()
    {
        $hotels = Hotel::with('images')->get();

        $data = $hotels->map(function ($hotel, $index) {
            $gambarHtml = '';
            foreach ($hotel->images as $img) {
                $gambarHtml .= '<img src="' . asset('storage/' . $img->path) . '" width="60" class="img-thumbnail mb-1">';
            }

            return [
                'no' => $index + 1,
                'nama_hotel' => $hotel->nama_hotel,
                'alamat' => $hotel->alamat,
              'harga' => 'Rp ' . number_format($hotel->harga, 3, ',', '.'),
                'rating' => $hotel->rating,
                'fasilitas' => $hotel->fasilitas,
                'deskripsi' => $hotel->deskripsi,
                'gambar' => $gambarHtml,
                'id' => $hotel->id
            ];
        });

        return response()->json(['data' => $data]);
    }

    public function deleteImage($id)
    {
        $image = HotelImage::findOrFail($id);
        Storage::disk('public')->delete($image->path);
        $image->delete();

        return back()->with('success', 'Gambar berhasil dihapus');
    }
}
