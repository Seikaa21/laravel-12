<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome - CRUD Kategori & Konten</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-100 via-purple-100 to-pink-100 text-gray-800 flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-gradient-to-b from-white to-blue-50 shadow-xl min-h-screen px-6 py-8 hidden md:block border-r border-blue-100">
        <div class="flex items-center gap-2 mb-10">
            <div class="bg-blue-500 text-white w-10 h-10 rounded-full flex items-center justify-center shadow">
                📄
            </div>
            <h2 class="text-xl font-semibold text-gray-800 tracking-wide">TUGAS</h2>
        </div>

        <nav class="space-y-2 text-gray-700 font-medium">
            <a href="{{ url('/') }}"
               class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-blue-100 transition group border-l-4 border-transparent hover:border-blue-500">
                <span class="text-blue-500">🏠</span>
                <span class="group-hover:text-blue-700">Beranda</span>
            </a>

            @auth
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-purple-100 transition group border-l-4 border-transparent hover:border-purple-500">
                <span class="text-purple-500">👤</span>
                <span class="group-hover:text-purple-700">Profil</span>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="flex items-center gap-3 w-full text-left px-4 py-2 rounded-md hover:bg-red-50 transition group border-l-4 border-transparent hover:border-red-400">
                    <span class="text-red-500">🚪</span>
                    <span class="group-hover:text-red-600">Logout</span>
                </button>
            </form>
            @else
            <a href="{{ route('login') }}"
               class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-green-100 transition group border-l-4 border-transparent hover:border-green-400">
                <span class="text-green-600">🔐</span>
                <span class="group-hover:text-green-700">Login</span>
            </a>
            @endauth
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 md:p-10 space-y-10 overflow-y-auto">

        <!-- SECTION KATEGORI -->
        <section class="bg-white/70 backdrop-blur-lg p-6 rounded-2xl shadow-lg">
            <h2 class="text-2xl font-semibold mb-6 text-blue-800 flex items-center gap-2">📁 <span>Kategori</span></h2>

            @auth
            <form action="{{ route('kategori.store') }}" method="POST" class="flex gap-3 mb-6">
                @csrf
                <input type="text" name="nama" class="flex-1 border border-gray-300 rounded-lg px-3 py-2" placeholder="Nama kategori" required>
                <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">+ Tambah</button>
            </form>
            @endauth

            <table class="w-full text-left text-gray-700">
                <thead class="bg-gray-100 text-sm uppercase text-gray-600">
                    <tr>
                        <th class="py-2 px-4">Nama</th>
                        <th class="py-2 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kategoris as $kategori)
                    <tr class="border-b">
                        <td class="py-2 px-4">{{ $kategori->nama }}</td>
                        <td class="py-2 px-4 text-right">
                            @auth
                            <button onclick="openEditKategoriModal({{ $kategori->id }}, '{{ $kategori->nama }}')" class="text-blue-600 hover:underline mr-2">Edit</button>
                            <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus kategori ini?')">
                                @csrf @method('DELETE')
                                <button class="text-red-500 hover:underline">Hapus</button>
                            </form>
                            @endauth
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </section>

        <!-- SECTION KONTEN -->
        <section class="bg-white/70 backdrop-blur-lg p-6 rounded-2xl shadow-lg">
            <h2 class="text-2xl font-semibold mb-6 text-purple-800 flex items-center gap-2">📝 <span>Konten</span></h2>

            @auth
            <form action="{{ route('konten.store') }}" method="POST" class="grid md:grid-cols-4 gap-4 mb-6">
                @csrf
                <input type="text" name="judul" class="border rounded-lg px-3 py-2" placeholder="Judul konten" required>
                <input type="text" name="isi" class="border rounded-lg px-3 py-2" placeholder="Isi konten" required>
                <select name="kategori_id" class="border rounded-lg px-3 py-2" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                    @endforeach
                </select>
                <button class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg">+ Tambah</button>
            </form>
            @endauth

            <table class="w-full text-left text-gray-700">
                <thead class="bg-gray-100 text-sm uppercase text-gray-600">
                    <tr>
                        <th class="py-2 px-4">Judul</th>
                        <th class="py-2 px-4">Isi</th>
                        <th class="py-2 px-4">Kategori</th>
                        <th class="py-2 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kontens as $konten)
                    <tr class="border-b">
                        <td class="py-2 px-4">{{ $konten->judul }}</td>
                        <td class="py-2 px-4">{{ $konten->isi }}</td>
                        <td class="py-2 px-4">{{ $konten->kategori->nama }}</td>
                        <td class="py-2 px-4 text-right">
                            @auth
                            <button onclick="openEditKontenModal({{ $konten->id }}, '{{ $konten->judul }}', '{{ $konten->isi }}', {{ $konten->kategori_id }})" class="text-blue-600 hover:underline mr-2">Edit</button>
                            <form action="{{ route('konten.destroy', $konten->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus konten ini?')">
                                @csrf @method('DELETE')
                                <button class="text-red-500 hover:underline">Hapus</button>
                            </form>
                            @endauth
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </section>

        <!-- MODAL EDIT KATEGORI -->
        <div id="editKategoriModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
            <form method="POST" id="kategoriEditForm" class="bg-white p-6 rounded-xl shadow-lg w-full max-w-md">
                @csrf @method('PUT')
                <h3 class="text-lg font-bold mb-4">Edit Kategori</h3>
                <input type="text" name="nama" id="editKategoriNama" class="w-full border px-3 py-2 mb-4 rounded-lg" required>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeEditKategoriModal()" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
                </div>
            </form>
        </div>

        <!-- MODAL EDIT KONTEN -->
        <div id="editKontenModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
            <form method="POST" id="kontenEditForm" class="bg-white p-6 rounded-xl shadow-lg w-full max-w-lg">
                @csrf @method('PUT')
                <h3 class="text-lg font-bold mb-4">Edit Konten</h3>
                <input type="text" name="judul" id="editKontenJudul" class="w-full border px-3 py-2 mb-3 rounded-lg" required>
                <input type="text" name="isi" id="editKontenIsi" class="w-full border px-3 py-2 mb-3 rounded-lg" required>
                <select name="kategori_id" id="editKontenKategori" class="w-full border px-3 py-2 mb-4 rounded-lg" required>
                    @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                    @endforeach
                </select>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeEditKontenModal()" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded">Simpan</button>
                </div>
            </form>
        </div>

        <!-- SCRIPT -->
        <script>
            function openEditKategoriModal(id, nama) {
                document.getElementById('editKategoriModal').classList.remove('hidden');
                document.getElementById('editKategoriNama').value = nama;
                document.getElementById('kategoriEditForm').action = '/kategori/' + id;
            }
            function closeEditKategoriModal() {
                document.getElementById('editKategoriModal').classList.add('hidden');
            }

            function openEditKontenModal(id, judul, isi, kategoriId) {
                document.getElementById('editKontenModal').classList.remove('hidden');
                document.getElementById('editKontenJudul').value = judul;
                document.getElementById('editKontenIsi').value = isi;
                document.getElementById('editKontenKategori').value = kategoriId;
                document.getElementById('kontenEditForm').action = '/konten/' + id;
            }
            function closeEditKontenModal() {
                document.getElementById('editKontenModal').classList.add('hidden');
            }
        </script>

    </main>
</body>
</html>
