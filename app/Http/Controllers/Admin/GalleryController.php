<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->paginate(15);
        return view('admin.galleries', compact('galleries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image_file' => ['nullable', 'image', 'max:5120'],
            'image_url' => ['nullable', 'url'],
            'is_active' => ['boolean'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image_file')) {
            $imagePath = $request->file('image_file')->store('galleries', 'public');
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->image_url;
        } else {
            $imagePath = 'https://images.unsplash.com/photo-1577896851231-70ef18881754?w=600&auto=format&fit=crop&q=80';
        }

        Gallery::create([
            'title' => $request->title,
            'image_path' => $imagePath,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.galleries')->with('success', 'Dokumentasi galeri berhasil ditambahkan.');
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        $gallery->update([
            'title' => $request->title,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.galleries')->with('success', 'Galeri berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return redirect()->route('admin.galleries')->with('success', 'Galeri berhasil dihapus.');
    }
}
