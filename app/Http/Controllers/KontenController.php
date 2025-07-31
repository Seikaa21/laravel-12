<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Konten;
use Illuminate\Http\Request;

class KontenController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();
        $kontens = Konten::with('kategori')->latest()->get();
        return view('welcome', compact('kategoris', 'kontens'));
    }

    // ========================= KATEGORI =========================

    public function storeKategori(Request $request)
    {
        $request->validate(['nama' => 'required']);
        Kategori::create($request->only('nama'));
        return redirect('/')->with('success', 'Kategori ditambahkan');
    }

    public function updateKategori(Request $request, $id)
    {
        $request->validate(['nama' => 'required']);
        $kategori = Kategori::findOrFail($id);
        $kategori->update(['nama' => $request->nama]);
        return redirect('/')->with('success', 'Kategori diperbarui');
    }

    public function destroyKategori($id)
    {
        Kategori::destroy($id);
        return redirect('/')->with('success', 'Kategori dihapus');
    }

    // ========================= KONTEN =========================

    public function storeKonten(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);
        Konten::create($request->all());
        return redirect('/')->with('success', 'Konten ditambahkan');
    }

    public function updateKonten(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        $konten = Konten::findOrFail($id);
        $konten->update([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'kategori_id' => $request->kategori_id,
        ]);

        return redirect('/')->with('success', 'Konten diperbarui');
    }

    public function destroyKonten($id)
    {
        Konten::destroy($id);
        return redirect('/')->with('success', 'Konten dihapus');
    }
}
