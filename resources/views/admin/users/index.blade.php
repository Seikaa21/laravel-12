<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-100 via-purple-100 to-pink-100 text-gray-800 flex">

    {{-- Sidebar --}}
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

                {{-- Menu Admin --}}
                @if(auth()->user()->isAdmin())
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
                @endif

                {{-- Setting --}}
                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center gap-3 px-4 py-2 rounded-md bg-indigo-50 border-l-4 border-indigo-500">
                    <span class="text-indigo-500">⚙️</span>
                    <span class="text-indigo-700 font-semibold">Setting</span>
                </a>

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

    {{-- Konten Utama --}}
    <main class="flex-1 p-6 md:p-10 space-y-10 overflow-y-auto">

        {{-- Navbar --}}
        <nav class="mb-6 bg-white/70 backdrop-blur-lg shadow rounded-xl p-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-purple-800">⚙️ Manajemen User</h1>
        </nav>

        {{-- Manajemen User --}}
        <section class="bg-white/80 backdrop-blur-lg p-6 rounded-2xl shadow-lg">
            <h2 class="text-lg font-bold mb-4 text-indigo-700">👥 Daftar User</h2>

            <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden shadow-md">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-100 to-purple-100 text-left">
                        <th class="p-3 border-b">ID</th>
                        <th class="p-3 border-b">Nama</th>
                        <th class="p-3 border-b">Email</th>
                        <th class="p-3 border-b">Role</th>
                        <th class="p-3 border-b">Izin Akses</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr class="border-b hover:bg-purple-50/50 transition">
                            <td class="p-3">{{ $user->id }}</td>
                            <td class="p-3">{{ $user->name }}</td>
                            <td class="p-3">{{ $user->email }}</td>
                            <td class="p-3">{{ $user->role ?? '-' }}</td>
                            <td class="p-3 space-x-2">
                                {{-- Toggle Konten --}}
                                <button onclick="togglePermission({{ $user->id }}, 'can_access_konten')" 
                                        class="px-3 py-1 rounded-lg shadow text-sm 
                                               {{ $user->can_access_konten ? 'bg-blue-500 text-white' : 'bg-blue-100 text-blue-700' }}">
                                    Konten: {{ $user->can_access_konten ? '✅' : '❌' }}
                                </button>

                                {{-- Toggle Kategori --}}
                                <button onclick="togglePermission({{ $user->id }}, 'can_access_kategori')" 
                                        class="px-3 py-1 rounded-lg shadow text-sm 
                                               {{ $user->can_access_kategori ? 'bg-green-500 text-white' : 'bg-green-100 text-green-700' }}">
                                    Kategori: {{ $user->can_access_kategori ? '✅' : '❌' }}
                                </button>

                                {{-- Toggle Profil --}}
                                <button onclick="togglePermission({{ $user->id }}, 'can_access_profil')" 
                                        class="px-3 py-1 rounded-lg shadow text-sm 
                                               {{ $user->can_access_profil ? 'bg-purple-500 text-white' : 'bg-purple-100 text-purple-700' }}">
                                    Profil: {{ $user->can_access_profil ? '✅' : '❌' }}
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </main>

    {{-- Script --}}
    <script>
        function togglePermission(userId, permission) {
            fetch(`/users/${userId}/toggle-permission`, {
                method: "PATCH",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },
                body: JSON.stringify({ permission: permission })
            })
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    location.reload();
                }
            })
            .catch(err => console.error(err));
        }
    </script>
</body>
</html>
