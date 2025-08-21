<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto p-6">
        {{-- Navbar --}}
        <nav class="mb-6 bg-white shadow rounded-lg p-4 flex justify-between">
            <h1 class="text-xl font-bold">Admin Panel</h1>
            <div>
                <a href="{{ route('welcome') }}" class="px-3 py-1 bg-blue-500 text-white rounded-lg">Home</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-lg">Logout</button>
                </form>
            </div>
        </nav>

        {{-- Konten --}}
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-bold mb-4">Manajemen User</h2>

            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="p-3 border-b">ID</th>
                        <th class="p-3 border-b">Nama</th>
                        <th class="p-3 border-b">Email</th>
                        <th class="p-3 border-b">Role</th>
                        <th class="p-3 border-b">Izin Akses</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">{{ $user->id }}</td>
                            <td class="p-3">{{ $user->name }}</td>
                            <td class="p-3">{{ $user->email }}</td>
                            <td class="p-3">{{ $user->role ?? '-' }}</td>
                            <td class="p-3 space-x-2">
                                {{-- Toggle untuk konten --}}
                               <td class="p-3 space-x-2">
    {{-- Toggle untuk konten --}}
    <button 
        onclick="togglePermission({{ $user->id }}, 'can_access_konten')"
        class="px-2 py-1 rounded {{ $user->can_access_konten ? 'bg-blue-600' : 'bg-blue-400' }} text-white">
        Konten: {{ $user->can_access_konten ? '✅' : '❌' }}
    </button>

    {{-- Toggle untuk kategori --}}
    <button 
        onclick="togglePermission({{ $user->id }}, 'can_access_kategori')"
        class="px-2 py-1 rounded {{ $user->can_access_kategori ? 'bg-green-600' : 'bg-green-400' }} text-white">
        Kategori: {{ $user->can_access_kategori ? '✅' : '❌' }}
    </button>

    {{-- Toggle untuk profil --}}
    <button 
        onclick="togglePermission({{ $user->id }}, 'can_access_profil')"
        class="px-2 py-1 rounded {{ $user->can_access_profil ? 'bg-purple-600' : 'bg-purple-400' }} text-white">
        Profil: {{ $user->can_access_profil ? '✅' : '❌' }}
    </button>
</td>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
    function togglePermission(userId, permission) {
        fetch(`/admin/users/${userId}/toggle-permission`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ permission: permission })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.error || "Gagal update permission");
            }
        })
        .catch(err => alert("Terjadi kesalahan: " + err));
    }
    </script>
</body>
</html>
