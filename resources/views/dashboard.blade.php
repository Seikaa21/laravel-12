<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Biodata</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-100 via-purple-100 to-pink-100 min-h-screen flex">

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

    <main class="flex-1 p-6 md:p-10">
        <div class="bg-white/70 backdrop-blur-lg p-8 rounded-2xl shadow-xl max-w-3xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                👤 <span>Informasi Pengguna</span>
            </h1>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div id="display-profile" class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-gray-700 text-base">
                <div>
                    <p class="font-semibold text-sm text-gray-500">Nama</p>
                    <p class="text-lg">{{ auth()->user()->name }}</p>
                </div>
                <div>
                    <p class="font-semibold text-sm text-gray-500">Email</p>
                    <p class="text-lg">{{ auth()->user()->email }}</p>
                </div>
                <div>
                    <p class="font-semibold text-sm text-gray-500">Tanggal Daftar</p>
                    <p class="text-lg">{{ auth()->user()->created_at->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="font-semibold text-sm text-gray-500">Waktu Login</p>
                    <p class="text-lg" id="waktu-login"></p>
                </div>
                <div class="sm:col-span-2 text-right mt-4">
                    <button onclick="toggleForm()" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition">
                        ✏️ Edit Profil
                    </button>
                </div>
            </div>

            <form id="edit-form" action="{{ route('dashboard.update') }}" method="POST"
                  class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-gray-700 text-base hidden mt-4">
                @csrf
                <div>
                    <label class="font-semibold text-sm text-gray-500">Nama</label>
                    <input name="name" value="{{ auth()->user()->name }}"
                           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label class="font-semibold text-sm text-gray-500">Email</label>
                    <input type="email" name="email" value="{{ auth()->user()->email }}"
                           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500" required>
                </div>
                <div class="sm:col-span-2 flex justify-end gap-4">
                    <button type="button" onclick="toggleForm()" class="px-6 py-2 rounded-lg border text-gray-700 hover:bg-gray-200 transition">Batal</button>
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg transition">
                        💾 Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        function toggleForm() {
            const display = document.getElementById('display-profile');
            const form = document.getElementById('edit-form');
            display.classList.toggle('hidden');
            form.classList.toggle('hidden');
        }

        document.addEventListener('DOMContentLoaded', function () {
            const now = new Date();
            const options = {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            };

            const waktuLogin = now.toLocaleString('id-ID', options).replace('.', ':');
            document.getElementById('waktu-login').textContent = waktuLogin;
        });
    </script>

</body>
</html>
