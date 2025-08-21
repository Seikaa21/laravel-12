<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Konten</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-100 via-purple-100 to-pink-100 text-gray-800">

<div class="flex">
    <!-- SIDEBAR -->
    <aside class="w-64 bg-gradient-to-b from-white to-blue-50 shadow-xl min-h-screen px-6 py-8 hidden md:block border-r border-blue-100">
        {{-- Logo --}}
        <div class="flex items-center gap-2 mb-10">
            <div class="bg-blue-500 text-white w-10 h-10 rounded-full flex items-center justify-center shadow">
                📄
            </div>
            <h2 class="text-xl font-semibold text-gray-800 tracking-wide">TUGAS</h2>
        </div>

        {{-- Menu --}}
        <nav class="space-y-2 text-gray-700 font-medium">
            <a href="{{ url('/') }}" class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-blue-100 transition group border-l-4 border-transparent hover:border-blue-500">
                <span class="text-blue-500">🏠</span>
                <span class="group-hover:text-blue-700">Beranda</span>
            </a>

            @auth
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-purple-100 transition group border-l-4 border-transparent hover:border-purple-500">
                    <span class="text-purple-500">👤</span>
                    <span class="group-hover:text-purple-700">Profil</span>
                </a>

                <a href="{{ route('kategori.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-yellow-100 transition group border-l-4 border-transparent hover:border-yellow-500">
                    <span class="text-yellow-500">📁</span>
                    <span class="group-hover:text-yellow-700">Kategori</span>
                </a>

                <a href="{{ route('konten.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-pink-100 transition group border-l-4 border-transparent hover:border-pink-500">
                    <span class="text-pink-500">📝</span>
                    <span class="group-hover:text-pink-700">Konten</span>
                </a>

                @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-indigo-100 transition group border-l-4 border-transparent hover:border-indigo-500">
                    <span class="text-indigo-500">⚙️</span>
                    <span class="group-hover:text-indigo-700">Setting</span>
                </a>
                @endif

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full text-left px-4 py-2 rounded-md hover:bg-red-50 transition group border-l-4 border-transparent hover:border-red-400">
                        <span class="text-red-500">🚪</span>
                        <span class="group-hover:text-red-600">Logout</span>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-green-100 transition group border-l-4 border-transparent hover:border-green-400">
                    <span class="text-green-600">🔐</span>
                    <span class="group-hover:text-green-700">Login</span>
                </a>
            @endauth
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-6 md:p-10 space-y-10">
        <section class="bg-white/70 backdrop-blur-lg p-6 rounded-2xl shadow-lg">
            <h2 class="text-2xl font-semibold mb-6 text-purple-800 flex items-center gap-2">📝 <span>Konten</span></h2>

            @auth
            <form action="{{ route('konten.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label for="judul" class="block font-medium">Judul</label>
                    <input type="text" name="judul" id="judul" class="w-full border rounded-lg px-3 py-2" required>
                </div>

                <div>
                    <label for="isi" class="block font-medium">Isi</label>
                    <textarea name="isi" id="isi" class="w-full border rounded-lg px-3 py-2" required></textarea>
                </div>

                <div>
                    <label for="kategori_id" class="block font-medium">Kategori</label>
                    <select name="kategori_id" id="kategori_id" class="w-full border rounded-lg px-3 py-2" required>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="gambar" class="block font-medium">Upload Gambar</label>
                    <input type="file" name="gambar" id="gambar" accept="image/*" class="w-full border rounded-lg px-3 py-2">
                </div>

                <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg">Simpan</button>
            </form>
            @endauth

            <table class="w-full text-left text-gray-700 border rounded-lg overflow-hidden mt-6">
                <thead class="bg-gray-200 text-sm uppercase text-gray-600">
                    <tr>
                        <th class="py-2 px-4">Judul</th>
                        <th class="py-2 px-4">Isi</th>
                        <th class="py-2 px-4">Gambar</th>
                        <th class="py-2 px-4">Kategori</th>
                        <th class="py-2 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kontens as $konten)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-2 px-4">{{ $konten->judul }}</td>
                        <td class="py-2 px-4">{{ \Illuminate\Support\Str::limit($konten->isi, 100) }}</td>
                        <td class="py-2 px-4">
                            @if($konten->gambar)
                                <img src="{{ asset('storage/'.$konten->gambar) }}" alt="Gambar" class="h-16 rounded shadow">
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="py-2 px-4">{{ $konten->kategori->nama }}</td>
                        <td class="py-2 px-4 text-right">
                            @auth
                            <button 
                                class="text-blue-600 hover:underline mr-2"
                                data-id="{{ $konten->id }}"
                                data-judul="{{ $konten->judul }}"
                                data-isi="{{ $konten->isi }}"
                                data-kategori="{{ $konten->kategori_id }}"
                                data-gambar="{{ $konten->gambar ? asset('storage/'.$konten->gambar) : '' }}"
                                onclick="openEditKontenModal(this)">
                                Edit
                            </button>
                            <form action="{{ route('konten.destroy', $konten->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus konten ini?')">
                                @csrf @method('DELETE')
                                <button class="text-red-500 hover:underline">Hapus</button>
                            </form>
                            @endauth
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500">Belum ada konten.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </section>

        <!-- MODAL EDIT KONTEN -->
        <div id="editKontenModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
            <form method="POST" id="kontenEditForm" enctype="multipart/form-data"
                  class="bg-white p-6 rounded-xl shadow-lg w-full max-w-lg">
                @csrf @method('PUT')
                <h3 class="text-lg font-bold mb-4">Edit Konten</h3>
                <input type="text" name="judul" id="editKontenJudul" class="w-full border px-3 py-2 mb-3 rounded-lg" required>
                <textarea name="isi" id="editKontenIsi" class="w-full border px-3 py-2 mb-3 rounded-lg" required></textarea>
                <select name="kategori_id" id="editKontenKategori" class="w-full border px-3 py-2 mb-4 rounded-lg" required>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                    @endforeach
                </select>

                <!-- Preview Gambar Lama -->
                <div id="editKontenPreview" class="mb-4 hidden">
                    <p class="text-sm text-gray-600 mb-1">Gambar lama:</p>
                    <img id="editKontenPreviewImg" src="" alt="Preview" class="h-24 rounded shadow">
                </div>

                <input type="file" name="gambar" class="w-full border px-3 py-2 mb-4 rounded-lg">

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeEditKontenModal()" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded">Simpan</button>
                </div>
            </form>
        </div>
    </main>
</div>

<script>
    function openEditKontenModal(button) {
        const id = button.dataset.id;
        const judul = button.dataset.judul;
        const isi = button.dataset.isi;
        const kategoriId = button.dataset.kategori;
        const gambar = button.dataset.gambar;

        document.getElementById('editKontenModal').classList.remove('hidden');
        document.getElementById('editKontenJudul').value = judul;
        document.getElementById('editKontenIsi').value = isi;
        document.getElementById('editKontenKategori').value = kategoriId;
        document.getElementById('kontenEditForm').action = '/konten/' + id;

        if (gambar) {
            document.getElementById('editKontenPreview').classList.remove('hidden');
            document.getElementById('editKontenPreviewImg').src = gambar;
        } else {
            document.getElementById('editKontenPreview').classList.add('hidden');
        }
    }

    function closeEditKontenModal() {
        document.getElementById('editKontenModal').classList.add('hidden');
    }
</script>
</body>
</html>
