<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
  public function index()
{
    $kategoris = Kategori::all();
    return view('kategori', compact('kategoris')); // ✅ arahkan ke kategori.blade.php
}


    public function store(Request $request)
    {
        $request->validate(['nama' => 'required']);
        Kategori::create($request->only('nama'));
        return redirect()->back()->with('success', 'Kategori ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['nama' => 'required']);
        $kategori = Kategori::findOrFail($id);
        $kategori->update(['nama' => $request->nama]);
        return redirect()->back()->with('success', 'Kategori diperbarui');
    }

    public function destroy($id)
    {
        Kategori::destroy($id);
        return redirect()->back()->with('success', 'Kategori dihapus');
    }
}
