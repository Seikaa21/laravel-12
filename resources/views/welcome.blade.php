<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome - Konten</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-100 via-purple-100 to-pink-100 text-gray-800 flex">

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
            {{-- Beranda --}}
            <a href="{{ url('/') }}" 
               class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-blue-100 transition group border-l-4 border-transparent hover:border-blue-500">
                <span class="text-blue-500">🏠</span>
                <span class="group-hover:text-blue-700">Beranda</span>
            </a>

            @auth
                {{-- Profil --}}
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-purple-100 transition group border-l-4 border-transparent hover:border-purple-500">
                    <span class="text-purple-500">👤</span>
                    <span class="group-hover:text-purple-700">Profil</span>
                </a>

                 <a href="{{ route('kategori.index') }}" 
                       class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-yellow-100 transition group border-l-4 border-transparent hover:border-yellow-500">
                        <span class="text-yellow-500">📁</span>
                        <span class="group-hover:text-yellow-700">Kategori</span>
                    </a>

                    <a href="{{ route('konten.index') }}" 
                       class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-pink-100 transition group border-l-4 border-transparent hover:border-pink-500">
                        <span class="text-pink-500">📝</span>
                        <span class="group-hover:text-pink-700">Konten</span>
                    </a>


                {{-- Menu Admin --}}
                @if(auth()->user()->isAdmin())
                    {{-- Setting --}}
                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-indigo-100 transition group border-l-4 border-transparent hover:border-indigo-500">
                    <span class="text-indigo-500">⚙️</span>
                    <span class="group-hover:text-indigo-700">Setting</span>
                </a>
                @endif

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="flex items-center gap-3 w-full text-left px-4 py-2 rounded-md hover:bg-red-50 transition group border-l-4 border-transparent hover:border-red-400">
                        <span class="text-red-500">🚪</span>
                        <span class="group-hover:text-red-600">Logout</span>
                    </button>
                </form>
            @else
                {{-- Login --}}
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

        <!-- SECTION KONTEN -->
        <section class="bg-white/70 backdrop-blur-lg p-6 rounded-2xl shadow-lg">
            <h2 class="text-2xl font-semibold mb-6 text-purple-800 flex items-center gap-2">📝 <span>Konten</span></h2>

            <!-- 🔍 FORM SEARCH -->
            <form method="GET" action="{{ url('/') }}" class="mb-6">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari konten..."
                       class="px-4 py-2 border rounded-lg w-full md:w-1/3 focus:ring focus:ring-purple-300">
            </form>

            @if($kontens->count())
            <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($kontens as $konten)
                <div onclick="openModal({{ $konten->id }})"
                     class="cursor-pointer bg-white/80 backdrop-blur-lg p-5 rounded-2xl shadow-md hover:shadow-lg hover:-translate-y-1 transition">

                    <!-- Thumbnail Gambar -->
                    @if($konten->gambar)
                    <img src="{{ asset('storage/' . $konten->gambar) }}" 
                         alt="{{ $konten->judul }}" 
                         class="w-full h-40 object-cover rounded-xl mb-3">
                    @endif

                    <!-- Judul -->
                    <h3 class="text-lg font-bold text-gray-800 mb-2 break-words">{{ $konten->judul }}</h3>

                    <!-- Isi singkat -->
                    <p class="text-gray-600 mb-3 break-words">{{ \Illuminate\Support\Str::limit($konten->isi, 100) }}</p>

                    <!-- Kategori -->
                    <span class="text-sm px-3 py-1 bg-purple-100 text-purple-700 rounded-full">
                        {{ $konten->kategori->nama }}
                    </span>
                </div>

                <!-- Modal Konten Detail -->
                <div id="modal-{{ $konten->id }}" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
                    <div class="bg-white p-6 rounded-xl shadow-xl w-11/12 md:w-2/3 lg:w-1/2 max-h-[90vh] overflow-y-auto relative">
                        <button onclick="closeModal({{ $konten->id }})" 
                                class="absolute top-3 right-3 text-gray-600 hover:text-red-500">✖</button>

                        <!-- Gambar lebih kecil -->
                        @if($konten->gambar)
                        <img src="{{ asset('storage/' . $konten->gambar) }}" 
                             alt="{{ $konten->judul }}" 
                             class="w-2/3 mx-auto h-40 object-cover rounded-lg mb-4">
                        @endif

                        <!-- Judul -->
                        <h2 class="text-xl font-bold text-gray-800 mb-3 text-center">{{ $konten->judul }}</h2>

                        <!-- Isi konten -->
                        <p class="text-gray-700 mb-4 whitespace-pre-line break-words text-justify">{{ $konten->isi }}</p>

                        <!-- Kategori -->
                        <div class="text-center">
                            <span class="px-4 py-1 bg-purple-200 text-purple-700 rounded-full text-sm">
                                {{ $konten->kategori->nama }}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- PAGINATION -->
            <div class="mt-8">
                {{ $kontens->links() }}
            </div>
            @else
            <p class="text-center text-gray-500">Tidak ada konten ditemukan.</p>
            @endif
        </section>

    </main>

    <script>
        function openModal(id) {
            document.getElementById('modal-' + id).classList.remove('hidden');
            document.getElementById('modal-' + id).classList.add('flex');
        }
        function closeModal(id) {
            document.getElementById('modal-' + id).classList.add('hidden');
            document.getElementById('modal-' + id).classList.remove('flex');
        }
    </script>
</body>
</html>
