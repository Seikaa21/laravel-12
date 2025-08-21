<?php

namespace App\Http\Controllers;

use App\Models\Konten;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KontenController extends Controller
{
    // ✅ Landing Page (welcome.blade.php)
    public function landing(Request $request)
    {
        $search = $request->input('search');

        $kontens = Konten::with('kategori')
            ->when($search, function ($query, $search) {
                $query->where('judul', 'like', "%{$search}%")
                      ->orWhere('isi', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(6)
            ->withQueryString();

        $kategoris = Kategori::all();

        return view('welcome', compact('kontens', 'kategoris', 'search'));
    }

    // ✅ Halaman khusus konten (konten.blade.php)
    public function index(Request $request)
    {
        $search = $request->input('search');

        $kontens = Konten::with('kategori')
            ->when($search, function ($query, $search) {
                $query->where('judul', 'like', "%{$search}%")
                      ->orWhere('isi', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(9)
            ->withQueryString();

        $kategoris = Kategori::all();

        return view('konten', compact('kontens', 'kategoris', 'search'));
    }

    // ✅ Detail konten
    public function show($id)
{
    $konten = Konten::with('kategori')->findOrFail($id);
    return view('konten.show', compact('konten'));
}


    // ✅ Simpan konten baru
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'kategori_id' => 'required|exists:kategoris,id',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        $data = $request->only(['judul','isi','kategori_id']);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('konten_images', 'public');
        }

        Konten::create($data);

        return redirect()->back()->with('success', 'Konten berhasil ditambahkan');
    }

    // ✅ Update konten
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'kategori_id' => 'required|exists:kategoris,id',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        $konten = Konten::findOrFail($id);
        $data = $request->only(['judul','isi','kategori_id']);

        if ($request->hasFile('gambar')) {
            if ($konten->gambar && Storage::disk('public')->exists($konten->gambar)) {
                Storage::disk('public')->delete($konten->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('konten_images', 'public');
        }

        $konten->update($data);

        return redirect()->back()->with('success', 'Konten berhasil diupdate');
    }

    // ✅ Hapus konten + gambar
    public function destroy($id)
    {
        $konten = Konten::findOrFail($id);

        if ($konten->gambar && Storage::disk('public')->exists($konten->gambar)) {
            Storage::disk('public')->delete($konten->gambar);
        }

        $konten->delete();

        return redirect()->back()->with('success', 'Konten berhasil dihapus');
    }
}
